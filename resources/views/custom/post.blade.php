@extends('custom.master')

@section('content')

<main class="container mx-auto px-4 py-6">

    <!-- Dynamic Category Title -->
    <h1 class="text-3xl font-bold text-gray-900 border-b pb-3 mb-6">
        {{ $category->name }}
    </h1>

    <!-- =================== TOP 4 NEWS =================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

      @foreach($posts->take(4) as $post)
<div class="relative border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">

    <!-- Image -->
    <a href="{{ route('post.details', $post->slug) }}">
        <img src="{{ $post->image ? $post->image->url : 'https://via.placeholder.com/600x350' }}"
             class="w-full h-56 object-cover" />
    </a>

    <!-- Bottom Content Overlay -->
    <div class="absolute bottom-0 left-0 w-full  p-4">

        <a href="{{ route('post.details', $post->slug) }}">
            <h2 class="text-lg font-bold text-gray-800 hover:text-blue-300">
                {{ $post->title }}
            </h2>
        </a>

        <p class="text-sm mt-1 text-gray-800">
            {{ Str::limit($post->short_description, 120) }}
        </p>

        <span class="text-xs mt-2 text-gray-800">
            {{ $post->created_at->format('M d, Y') }}
        </span>

    </div>

</div>
@endforeach


    </div>


   <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

    <!-- LEFT COLUMN -->
    <div class="md:col-span-1">
        <h2 class="text-xl font-bold mb-4">Related Categories</h2>

        @foreach($leftCategories as $cat)
            <!-- Category Title -->
            <h3 class="text-lg font-semibold mt-4">{{ $cat->title }}</h3>

            <!-- Posts of this Category -->
            @foreach($leftPosts->where('category_id', $cat->id)->take(5) as $post)
                <div class="flex gap-4 border-b pb-3 mt-2">
                    <img src="{{ $post->image?->url ?? 'https://via.placeholder.com/80x60' }}"
                         class="w-20 h-14 object-cover rounded">

                    <div>
                        <a href="{{ route('post.details', $post->slug) }}" class="font-medium text-gray-900">
                            {{ $post->title }}
                        </a>
                        <p class="text-xs text-gray-500">{{ $post->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            @endforeach

        @endforeach
    </div>


    <!-- CENTER COLUMN -->
<div class="md:col-span-2 space-y-4">
    <h2 class="text-xl font-bold mb-4">{{ $category->title }}</h2>

    @foreach($centerPosts as $post)
        <div class="flex gap-4 border-b pb-4 items-start">
            <!-- Image Left -->
            <a href="{{ route('post.details', $post->slug) }}">
                <img src="{{ $post->image?->url ?? 'https://via.placeholder.com/150x100' }}"
                     class="w-32 h-24 object-cover rounded-lg">
            </a>

            <!-- Content Right -->
            <div class="flex-1">
                <a href="{{ route('post.details', $post->slug) }}">
                    <h3 class="text-lg font-semibold text-gray-900 hover:text-blue-700">
                        {{ $post->title }}
                    </h3>
                </a>

                <p class="text-sm text-gray-600 mt-1">
                    {{ Str::limit($post->short_description, 120) }}
                </p>

                <span class="text-xs text-gray-500 mt-1 block">
                    {{ $post->created_at->format('M d, Y') }}
                </span>
            </div>
        </div>
    @endforeach

    <!-- Pagination Links -->
    <div class="mt-4">
       {{ $centerPosts->links() }}

    </div>
</div>



    <!-- RIGHT COLUMN -->
    <div class="md:col-span-1">
           <!-- AD -->
           @if(isset($sidebarAd) && $sidebarAd->banner)
<div class="w-full bg-gray-200 rounded-lg flex items-center justify-center text-gray-600 border border-dashed border-gray-400 mt-3 overflow-hidden mb-3">

        <a href="{{ $sidebarAd->link ?? '#' }}" class="block w-full h-full">
            <img src="{{ $sidebarAd->banner->getUrl() }}"
                 class="w-full h-full object-cover rounded-lg"
                 alt="Advertisement">
        </a>
    
        
    </div>
    @endif

        @foreach($rightCategories as $cat)
            <h2 class="text-xl font-bold mb-4">{{ $cat->name }}</h2>

            @foreach($rightPosts->where('category_id', $cat->id)->take(5) as $post)
                <div class="flex gap-4 border-b pb-3 mt-2">
                    <img src="{{ $post->image?->url ?? 'https://via.placeholder.com/80x60' }}"
                         class="w-20 h-14 object-cover rounded">

                    <div>
                        <a href="{{ route('post.details', $post->slug) }}" class="font-medium text-gray-900">
                            {{ $post->title }}
                        </a>
                        <p class="text-xs text-gray-500">{{ $post->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            @endforeach

        @endforeach
    </div>

</div>

</main>

@endsection
