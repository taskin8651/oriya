@extends('custom.master')
@section('content')

<main class="container mx-auto px-4 py-8">

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Breadcrumb -->
        <div class="flex items-center text-sm text-gray-500 mb-6 lg:col-span-3">
            <a href="/" class="hover:text-blue-600">Home</a>
            <span class="mx-2">></span>
            <a href="#" class="hover:text-blue-600">{{ $post->category->name ?? 'Category' }}</a>
            <span class="mx-2">></span>
            <span class="text-gray-700">{{ $post->title }}</span>
        </div>

        <!-- Left Side (Main Article) -->
        <div class="lg:col-span-2">

            <!-- Article Header -->
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    {{ $post->title }}
                </h1>

                <div class="flex flex-wrap items-center text-gray-600 text-sm mb-4">
                    <span class="mr-4"><i class="far fa-user mr-1"></i> By {{ $post->author->name ?? 'Staff Reporter' }}</span>
                    <span class="mr-4"><i class="far fa-calendar mr-1"></i> {{ $post->created_at->format('M d, Y') }}</span>
                    <span class="mr-4"><i class="far fa-clock mr-1"></i> {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min read</span>
                    <span><i class="far fa-eye mr-1"></i> {{ $post->view ?? 0 }} views</span>
                </div>

                <!-- Tags -->
                <div class="flex space-x-2">
                    @foreach($post->tags as $tag)
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">#{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>

            <!-- Featured Image -->
            <div class="mb-8 rounded-xl overflow-hidden shadow-lg">
                <div class="h-64 md:h-96">
                    <img src="{{ $post->image->url ?? asset('default.jpg') }}"
                         alt="{{ $post->title }}"
                         class="w-full h-full object-cover">
                </div>

                @if($post->image)
                <div class="bg-gray-100 px-4 py-2 text-sm text-gray-600 text-center">
                    {{ $post->title }}
                </div>
                @endif
            </div>

            <!-- Article Content -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6 prose max-w-none">
                {!! $post->content !!}
            </div>

            <!-- Share Section -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4">Share this article</h3>

                <div class="flex space-x-4">

                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                       target="_blank"
                       class="bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fab fa-facebook-f mr-2"></i> Share
                    </a>

                    <!-- Twitter -->
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}"
                       target="_blank"
                       class="bg-sky-500 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fab fa-twitter mr-2"></i> Tweet
                    </a>

                    <!-- LinkedIn -->
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                       target="_blank"
                       class="bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fab fa-linkedin-in mr-2"></i> Share
                    </a>

                    <!-- WhatsApp -->
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title.' '.request()->url()) }}"
                       target="_blank"
                       class="bg-green-500 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fab fa-whatsapp mr-2"></i> Share
                    </a>

                </div>
            </div>

        </div>

        <!-- Right Sidebar -->
        <div class="lg:col-span-1">
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

            <!-- Related Posts -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6 mt-3">
                <h3 class="font-bold text-gray-900 mb-4 border-b pb-2">Related News</h3>

                <div class="space-y-4">
                    @foreach($related as $item)
                    <a href="{{ route('post.details', $item->slug) }}">
                        <div class="flex p-3 rounded-lg border border-gray-100 hover:border-blue-200 cursor-pointer transition">
                            <div class="flex-shrink-0 w-20 h-16 bg-gray-200 rounded-md overflow-hidden">
                                <img src="{{ $item->image->thumbnail ?? asset('no-img.png') }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="ml-3">
                                <h4 class="font-semibold text-gray-900 text-sm mb-1">{{ $item->title }}</h4>
                                <p class="text-xs text-gray-500">{{ $item->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

           <!-- Newsletter -->
<div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-sm p-6 text-white">
    <h3 class="font-bold mb-2">Stay Updated</h3>
    <p class="text-sm mb-4">Subscribe to our newsletter for latest updates.</p>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-3 py-2 rounded mb-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex">
        @csrf

        <input type="email"
            name="email"
            placeholder="Your email"
            required
            class="bg-white text-gray-800 rounded-l-lg px-4 py-2 w-full focus:outline-none">

        <button class="bg-blue-800 text-white rounded-r-lg px-4 py-2 font-medium">
            Subscribe
        </button>
    </form>

    @error('email')
        <p class="text-yellow-300 text-xs mt-2">{{ $message }}</p>
    @enderror
</div>


        </div>

    </div>

</main>

@endsection
