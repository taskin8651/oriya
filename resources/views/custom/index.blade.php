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
<div class="w-full bg-gray-200 rounded-lg flex items-center justify-center text-gray-600 border border-dashed border-gray-400 mt-3 overflow-hidden">

    @if(isset($sidebarAd) && $sidebarAd->banner)
        <a href="{{ $sidebarAd->link ?? '#' }}" class="block w-full h-full">
            <img src="{{ $sidebarAd->banner->getUrl() }}"
                 class="w-full h-full object-cover rounded-lg"
                 alt="Advertisement">
        </a>
    @else
        <div class="h-64 flex flex-col items-center justify-center">
            <i class="fa-solid fa-ad text-3xl mb-2"></i>
            <p>विज्ञापन</p>
            <p class="text-xs mt-1">300x250</p>
        </div>
    @endif

</div>



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

            <!-- FEATURED TOP -->
            <div class="rounded-lg overflow-hidden shadow-lg relative news-card">
                <img src="https://dummyimage.com/900x500/4a5568/ffffff&text=ओडिशा+में+नया+मंत्रिमंडल+गठित" class="w-full h-72 md:h-96 object-cover">

                <div class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black to-transparent">
                    <span class="bg-primary text-white px-2 py-1 text-xs rounded">मुख्य समाचार</span>

                    <h2 class="text-2xl md:text-3xl font-bold text-white mt-3 leading-tight">
                        ओडिशा में नया मंत्रिमंडल गठित – 12 मंत्रियों को शपथ
                    </h2>

                    <p class="text-gray-300 mt-2 text-sm">
                        राज्यपाल भवन में आयोजित समारोह में मुख्यमंत्री ने नए मंत्रियों को शपथ दिलाई। नए मंत्रिमंडल में 8 कैबिनेट मंत्री और 4 राज्य मंत्री शामिल हैं।
                    </p>
                </div>
            </div>

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
                   <a href="{{ route('post.details', $post->slug) }}">
        {{ $post->title }}
    </a>
                </h3>

                <p class="text-gray-600 text-sm mt-2">
                    {{ $post->short_description ?? '' }}
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
<div class="w-full bg-gray-200 rounded-lg flex items-center justify-center text-gray-600 border border-dashed border-gray-400 mt-3 overflow-hidden">

    @if(isset($sidebarAd) && $sidebarAd->banner)
        <a href="{{ $sidebarAd->link ?? '#' }}" class="block w-full h-full">
            <img src="{{ $sidebarAd->banner->getUrl() }}"
                 class="w-full h-full object-cover rounded-lg"
                 alt="Advertisement">
        </a>
    @else
        <div class="h-64 flex flex-col items-center justify-center">
            <i class="fa-solid fa-ad text-3xl mb-2"></i>
            <p>विज्ञापन</p>
            <p class="text-xs mt-1">300x250</p>
        </div>
    @endif

</div>
           <div class="bg-white rounded-lg shadow p-4 mt-3">

    <h2 class="text-xl font-bold border-b pb-3 text-primary flex items-center">
        <i class="fa-solid fa-fire mr-2"></i> Latest News Today: Breaking News and Top Headlines
    </h2>

    <!-- MARQUEE START -->
    <div class="mt-4 overflow-hidden whitespace-nowrap">
        <marquee behavior="scroll" direction="up" scrollamount="3" height="250px">
            @foreach($latestPosts as $post)
                <div class="pb-3 border-b mb-3">
                    <a href="{{ route('post.details', $post->slug) }}" class="font-semibold hover:text-primary">
                        {{ $post->title }}
                    </a>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fa-regular fa-clock mr-1"></i>
                        {{ $post->created_at->diffForHumans() }}
                    </p>
                </div>
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
            @if($category->posts->count() > 0)

                <div class="bg-white border rounded-xl p-4 shadow-sm">
                    <h2 class="text-xl font-semibold border-b-2 border-red-600 pb-2 mb-4">
                        {{ $category->name }}
                    </h2>

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

                    <a href="{{ url('category/'.$category->slug) }}"
                       class="text-red-600 font-semibold mt-3 inline-block hover:underline cursor-pointer">
                        More {{ $category->name }} News →
                    </a>
                </div>

            @endif
        @endforeach

    </div>
</section>

@endsection