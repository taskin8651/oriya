@extends('custom.master')
@section('content')


    <!-- PAGE WRAPPER -->
    <main class="container mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-12 gap-6">
         <!-- RIGHT SIDEBAR -->
        <aside class=" lg:col-span-3">

          <div class="bg-white rounded-lg shadow p-4">
    <h2 class="text-xl font-bold border-b pb-3 text-primary flex items-center">
        <i class="fa-solid fa-fire mr-2"></i> Odisha
    </h2>

    <ul class="space-y-4 mt-4">
        @forelse($odishaPosts as $post)
            <li class="pb-3 border-b">
                <a href="{{ route('post.details', $post->slug)  }}" class="flex gap-3 items-start">

                    <!-- LEFT: IMAGE -->
                    <div class="w-24 h-16 flex-shrink-0">
                        <img src="{{ $post->image ? $post->image->getUrl() : 'https://via.placeholder.com/150' }}"
     class="w-full h-full object-cover rounded-md"
     alt="{{ $post->title }}">

                    </div>

                    <!-- RIGHT: TEXT -->
                    <div class="flex-1">
                        <h3 class="font-semibold hover:text-primary line-clamp-2">
                            {{ $post->title }}
                        </h3>
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fa-regular fa-clock mr-1"></i>
                            {{ $post->created_at->diffForHumans() }}
                        </p>
                    </div>

                </a>
            </li>
        @empty
            <li class="pb-3">
                <p class="text-gray-500 text-sm">No posts available</p>
            </li>
        @endforelse
    </ul>
</div>



           <!-- AD -->
           @if(isset($sidebarAd) && $sidebarAd->banner)
<div class="w-full bg-gray-200 rounded-lg flex items-center justify-center text-gray-600 border border-dashed border-gray-400 mt-3 overflow-hidden">

        <a href="{{ $sidebarAd->link ?? '#' }}" class="block w-full h-full">
            <img src="{{ $sidebarAd->banner->getUrl() }}"
                 class="w-full h-full object-cover rounded-lg"
                 alt="Advertisement">
        </a>
   
        
    </div>
    @endif



            <!-- VIDEOS -->
            <!-- <div class="bg-white rounded-lg shadow p-4 mt-3">
                <h2 class="text-xl font-bold border-b pb-3 text-primary flex items-center">
                    <i class="fa-solid fa-play-circle mr-2"></i> ताज़ा वीडियो
                </h2>

                <div class="mt-4 space-y-3">
                    <div class="rounded border overflow-hidden news-card">
                        <div class="relative">
                            <img src="https://dummyimage.com/400x250/4a5568/ffffff&text=मुख्यमंत्री+संबोधन" class="w-full h-40 object-cover">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="bg-primary rounded-full w-12 h-12 flex items-center justify-center opacity-90">
                                    <i class="fa-solid fa-play text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="p-3">
                            <h3 class="font-semibold">मुख्यमंत्री का संबोधन</h3>
                            <p class="text-xs text-gray-500 mt-1"><i class="fa-regular fa-clock mr-1"></i> 2 घंटे पहले</p>
                        </div>
                    </div>

                    <div class="rounded border overflow-hidden news-card">
                        <div class="relative">
                            <img src="https://dummyimage.com/400x250/4a5568/ffffff&text=फ्लाईओवर+उद्घाटन" class="w-full h-40 object-cover">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="bg-primary rounded-full w-12 h-12 flex items-center justify-center opacity-90">
                                    <i class="fa-solid fa-play text-white"></i>
                                </div>
                            </div>
                        </div>
                        <div class="p-3">
                            <h3 class="font-semibold">नए फ्लाईओवर का उद्घाटन</h3>
                            <p class="text-xs text-gray-500 mt-1"><i class="fa-regular fa-clock mr-1"></i> 1 दिन पहले</p>
                        </div>
                    </div>
                </div> -->

            </div>

        </aside>

        <!-- LEFT AREA -->
        <div class=" lg:col-span-6 ">

        @php
$slides = $crousels->map(function($c) {
    return [
        'url' => $c->upload_image ? $c->upload_image->url : 'https://dummyimage.com/900x500/4a5568/ffffff&text=No+Image',
        'title' => $c->title,
        'description' => $c->description,
        'label' => 'मुख्य समाचार',
        'type' => 'image', // future me video bhi add ho sakta hai
    ];
})->values()->toArray();
@endphp

<div x-data="carousel(@js($slides))" x-init="init()" class="relative overflow-hidden rounded-lg shadow-lg max-w-6xl mx-auto h-72 md:h-96">
    <!-- Slides -->
    <template x-for="(slide, index) in slides" :key="index">
        <div 
            x-show="active === index" 
            x-transition:enter="transition ease-out duration-700" 
            x-transition:enter-start="opacity-0 scale-95" 
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-500" 
            x-transition:leave-start="opacity-100 scale-100" 
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute inset-0 w-full h-full"
        >
            <template x-if="slide.type==='image'">
                <img :src="slide.url" :alt="slide.title" class="w-full h-full object-cover">
            </template>
            <template x-if="slide.type==='video'">
                <video :src="slide.url" controls autoplay class="w-full h-full object-cover"></video>
            </template>

            <!-- Caption -->
            <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/70 to-transparent">
                <span class="bg-yellow-500 text-black px-2 py-1 text-xs rounded" x-text="slide.label"></span>
                <h2 class="text-2xl md:text-3xl font-bold text-white mt-3 leading-tight" x-text="slide.title"></h2>
                <p class="text-gray-300 mt-2 text-sm" x-text="slide.description"></p>
            </div>
        </div>
    </template>

    <!-- Prev / Next Buttons -->
    <button @click="prev" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/50 text-white rounded-full px-3 py-2 z-50 hover:bg-black/70 transition">&#10094;</button>
    <button @click="next" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/50 text-white rounded-full px-3 py-2 z-50 hover:bg-black/70 transition">&#10095;</button>

    <!-- Dots -->
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
        <template x-for="(slide, index) in slides" :key="index">
            <div @click="active = index" class="w-3 h-3 rounded-full cursor-pointer transition"
                 :class="{'bg-yellow-500': active === index, 'bg-white/50': active !== index}"></div>
        </template>
    </div>
</div>

<script src="https://unpkg.com/alpinejs@3.13.2/dist/cdn.min.js" defer></script>
<script>
function carousel(slides) {
    return {
        active: 0,
        slides: slides,
        startX: 0,
        endX: 0,
        next() { this.active = (this.active + 1) % this.slides.length; },
        prev() { this.active = (this.active - 1 + this.slides.length) % this.slides.length; },
        init() {
            // Auto slide
            setInterval(() => this.next(), 5000);

            // Swipe support for mobile
            const el = this.$el;
            el.addEventListener('touchstart', (e) => { this.startX = e.touches[0].clientX; });
            el.addEventListener('touchend', (e) => {
                this.endX = e.changedTouches[0].clientX;
                if (this.startX - this.endX > 50) this.next();
                if (this.endX - this.startX > 50) this.prev();
            });
        }
    }
}
</script>


            <!-- GRID NEWS -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

                <!-- CARD -->
                
    @foreach($latest12 as $post)
        <div class="bg-white rounded-lg shadow overflow-hidden news-card">
            
            <img src="{{ $post->image ? $post->image->getUrl() : 'https://dummyimage.com/400x250/4a5568/ffffff&text=No+Image' }}"
                 class="w-full h-48 object-cover">

            <div class="p-4">
                <span class="text-xs bg-primary text-white px-2 py-1 rounded">
                    {{ $post->category->name ?? 'Uncategorized' }}
                </span>

                <h3 class="text-lg font-bold mt-2">
    <a href="{{ route('post.details', $post->slug) }}"
       class="transition-colors duration-300 hover:text-primary">
        {{ $post->title }}
    </a>
</h3>


                <p class="text-gray-600 text-sm mt-2">
                   {{ \Illuminate\Support\Str::words($post->short_description, 20, '...') }}

                </p>

                <p class="text-xs text-gray-500 mt-3">
                    <i class="fa-regular fa-clock mr-1"></i>
                    {{ $post->created_at->diffForHumans() }}
                </p>
            </div>

        </div>
    @endforeach
            </div>
        </div>

        <!-- RIGHT SIDEBAR -->
        <aside class=" lg:col-span-3">
       <!-- AD -->
       @if(isset($sidebarAd) && $sidebarAd->banner)
<div class="w-full bg-gray-200 rounded-lg flex items-center justify-center text-gray-600 border border-dashed border-gray-400 mt-3 overflow-hidden">

        <a href="{{ $sidebarAd->link ?? '#' }}" class="block w-full h-full">
            <img src="{{ $sidebarAd->banner->getUrl() }}"
                 class="w-full h-full object-cover rounded-lg"
                 alt="Advertisement">
        </a>
    
        
    </div>
    @endif
           <div class="bg-white rounded-lg shadow p-4 mt-3">

    <h2 class="text-xl font-bold border-b pb-3 text-primary flex items-center">
        <i class="fa-solid fa-fire mr-2"></i> Latest News Today: Breaking News and Top Headlines
    </h2>

    <!-- MARQUEE START -->
    <div class="mt-4 overflow-hidden whitespace-nowrap">
        <marquee behavior="scroll" direction="up" scrollamount="3" height="250px">
            @foreach($latestPosts as $post)
            <a href="{{ route('post.details', $post->slug) }}" class="font-semibold hover:text-primary">
                <div class="pb-3 border-b mb-3">
                        {{ $post->title }}
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fa-regular fa-clock mr-1"></i>
                            {{ $post->created_at->diffForHumans() }}
                        </p>
                    </div>
                </a>
            @endforeach
        </marquee>
    </div>
    <!-- MARQUEE END -->

</div>

                    

            <!-- VIDEOS -->
           <div class="bg-white rounded-lg shadow p-4 mt-3">
    <h2 class="text-xl font-bold border-b pb-3 text-primary flex items-center">
        <i class="fa-solid fa-play-circle mr-2"></i> ताज़ा वीडियो
    </h2>

    <div class="mt-4 space-y-4">
        @php
    function getYouTubeId($url) {
        // If already embed URL
        if (preg_match('/embed\/([^\?&]+)/', $url, $match)) {
            return $match[1];
        }

        // Normal YouTube watch URL
        if (preg_match('/v=([^\?&]+)/', $url, $match)) {
            return $match[1];
        }

        // youtu.be short URL
        if (preg_match('/youtu\.be\/([^\?&]+)/', $url, $match)) {
            return $match[1];
        }

        return null;
    }
@endphp
@foreach($youtubeVideos as $video)
    @php 
        $videoId = getYouTubeId($video->url);
    @endphp

    <div class="rounded border overflow-hidden news-card">
        <div class="relative">
            <iframe 
                width="100%" 
                height="200" 
                src="https://www.youtube.com/embed/{{ $videoId }}"
                title="{{ $video->description }}"
                frameborder="0" 
                allowfullscreen>
            </iframe>
        </div>

        <div class="p-3">
            <h3 class="font-semibold">{{ $video->description }}</h3>
            <p class="text-xs text-gray-500 mt-1">
                <i class="fa-regular fa-clock mr-1"></i> 
                {{ $video->created_at->diffForHumans() }}
            </p>
        </div>
    </div>
@endforeach


    </div>
</div>

        </aside>

    </main>

<section class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

       @foreach($categories as $category)

    <div class="bg-white border rounded-xl p-4 shadow-sm">

        <h2 class="text-xl font-semibold border-b-2 border-red-600 pb-2 mb-4">
            {{ $category->name }}
        </h2>

        {{-- Latest 5 Posts --}}
        @if($category->posts->count() > 0)
            <div class="space-y-4">
                @foreach($category->posts as $post)
                    <div class="flex gap-3">
                        <img src="{{ $post->image->url ?? 'https://via.placeholder.com/120x80?text=Img' }}"
                             class="w-28 h-20 object-cover rounded">

                        <div>
                            <h3 class="font-semibold leading-tight hover:text-red-600 cursor-pointer">
                                <a href="{{ route('post.details', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            <p class="text-sm text-gray-500">
                                {{ $post->created_at->format('F d, Y') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400 text-sm">No posts available</p>
        @endif

        {{-- Show More link only if total posts > 5 --}}
@if($category->total_posts_count > 5)
    <a href="{{ route('category.posts', $category->slug) }}"
       class="text-red-600 font-semibold mt-3 inline-block hover:underline">
        More News →
    </a>
@endif


    </div>

@endforeach


    </div>
</section>

@endsection