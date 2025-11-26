@extends('custom.master')

@section('content')
<div class="container mx-auto px-4 py-8">

@php
    $types = \App\Models\Gallery::TITLE_SELECT;
    $activeType = request('type') ?? 'all';
    
    // Pre-process gallery data for Alpine.js
    $galleryData = [];
    foreach($galleries as $index => $gallery) {
        if($activeType != 'all' && $gallery->title != $activeType) {
            continue;
        }
        
        $file = $gallery->upload_file;
        if($file) {
            $galleryData[] = [
                'src' => $file->getUrl(),
                'thumb' => $file->getUrl('thumb'),
                'type' => $gallery->title,
                'mime_type' => $file->mime_type
            ];
        }
    }
@endphp

<!-- Heading + Tabs -->
<div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-6 gap-4">
    <h1 class="text-3xl font-bold text-yellow-400">Gallery</h1>

    <!-- Tabs -->
    <div class="flex gap-2 flex-wrap">
        <a href="{{ route('custom.gallery', ['type' => 'all']) }}" style="color: black;"
           class="px-3 py-1.5 text-sm rounded-md font-medium border transition 
                  {{ $activeType == 'all' ? 'bg-yellow-500 text-black border-yellow-500' : 'text-white border-gray-500 hover:border-yellow-400 hover:text-yellow-400' }}">
            All
        </a>
        @foreach($types as $key => $label)
            <a href="{{ route('custom.gallery', ['type' => $key]) }}" style="color: black;"
               class="px-3 py-1.5 text-sm rounded-md font-medium border transition 
                  {{ $activeType == $key ? 'bg-yellow-500 text-black border-yellow-500' : 'text-white border-gray-500 hover:border-yellow-400 hover:text-yellow-400' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</div>

<!-- Gallery Grid -->
<div x-data="lightboxModal()" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach($galleryData as $index => $item)
        <div class="cursor-pointer group relative">
            @if($item['type'] === 'video')
                <video class="w-full h-48 object-cover rounded-lg" poster="{{ $item['thumb'] }}" muted
                       @click="openModal({{ $index }})">
                    <source src="{{ $item['src'] }}" type="{{ $item['mime_type'] }}">
                    Your browser does not support the video tag.
                </video>
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                    <span class="bg-black/50 text-white px-2 py-1 rounded">▶</span>
                </div>
            @else
                <img src="{{ $item['src'] }}" alt="Gallery image"
                     class="w-full h-48 object-cover rounded-lg"
                     @click="openModal({{ $index }})">
            @endif
        </div>
    @endforeach

    <!-- Modal -->
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/90 flex items-center justify-center z-50 p-4"
         @keydown.escape="closeModal"
         @click.self="closeModal"
         x-cloak>
        <div class="relative max-w-4xl w-full flex items-center justify-center">

            <!-- Close Button -->
            <button @click="closeModal" class="absolute -top-12 right-0 text-white text-3xl z-50 hover:text-yellow-400 transition">
                &times;
            </button>

            <!-- Left Arrow -->
            <button @click="prevMedia" 
                    class="absolute left-4 text-white text-3xl z-50 hover:text-yellow-400 transition"
                    :class="{'opacity-50 cursor-not-allowed': currentIndex === 0}">
                &#10094;
            </button>

            <!-- Right Arrow -->
            <button @click="nextMedia" 
                    class="absolute right-4 text-white text-3xl z-50 hover:text-yellow-400 transition"
                    :class="{'opacity-50 cursor-not-allowed': currentIndex === media.length - 1}">
                &#10095;
            </button>

            <!-- Media Container -->
            <div class="relative w-full">
                <template x-if="currentMedia.type === 'image'">
                    <img :src="currentMedia.src" 
                         class="rounded-lg max-h-[80vh] w-full object-contain transform transition duration-300"
                         alt="Gallery image">
                </template>

                <template x-if="currentMedia.type === 'video'">
                    <video :src="currentMedia.src" 
                           controls 
                           autoplay 
                           class="rounded-lg max-h-[80vh] w-full object-contain transform transition duration-300">
                    </video>
                </template>
            </div>

            <!-- Counter -->
            <div class="absolute -bottom-10 left-1/2 transform -translate-x-1/2 text-white text-sm">
                <span x-text="currentIndex + 1"></span> / <span x-text="media.length"></span>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.13.2/dist/cdn.min.js"></script>
<script>
    function lightboxModal() {
        return {
            isOpen: false,
            currentIndex: 0,
            media: @json($galleryData),
            get currentMedia() {
                return this.media[this.currentIndex] || {};
            },
            init() {
                // Add keyboard event listeners
                document.addEventListener('keydown', (e) => {
                    if (!this.isOpen) return;
                    
                    switch(e.key) {
                        case 'Escape':
                            this.closeModal();
                            break;
                        case 'ArrowRight':
                            this.nextMedia();
                            break;
                        case 'ArrowLeft':
                            this.prevMedia();
                            break;
                    }
                });
            },
            openModal(index) {
                this.currentIndex = index;
                this.isOpen = true;
                // Prevent body scroll when modal is open
                document.body.style.overflow = 'hidden';
            },
            closeModal() {
                this.isOpen = false;
                // Restore body scroll
                document.body.style.overflow = 'auto';
                
                // Pause any playing videos
                const video = document.querySelector('video');
                if (video) {
                    video.pause();
                }
            },
            nextMedia() {
                if (this.currentIndex < this.media.length - 1) {
                    this.currentIndex++;
                }
            },
            prevMedia() {
                if (this.currentIndex > 0) {
                    this.currentIndex--;
                }
            }
        }
    }
</script>

<style>
    [x-cloak] { display: none !important; }
</style>

@endsection