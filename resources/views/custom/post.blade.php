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
        <div class="border rounded-xl overflow-hidden shadow-sm hover:shadow-md transition">

            <!-- Image -->
            <a href="{{ route('post.details', $post->slug) }}">
                <img src="{{ $post->image ? $post->image->url : 'https://via.placeholder.com/600x350' }}"
                     class="w-full h-48 object-cover" />
            </a>

            <!-- Content -->
            <div class="p-4">

                <a href="{{ route('post.details', $post->slug) }}">
                    <h2 class="text-lg font-bold text-gray-900 hover:text-blue-700 cursor-pointer">
                        {{ $post->title }}
                    </h2>
                </a>

                <p class="text-sm text-gray-600 mt-1">
                    {{ Str::limit($post->short_description, 120) }}
                </p>

                <span class="text-xs text-gray-500 block mt-2">
                    {{ $post->created_at->format('M d, Y') }}
                </span>
            </div>
        </div>
        @endforeach

    </div>


    <!-- =================== BELOW POSTS (List) =================== -->
    <div class="space-y-6">

        @foreach($posts->skip(4) as $post)
        <div class="flex border-b pb-4 gap-4">

            <!-- Thumb -->
            <a href="{{ route('post.details', $post->slug) }}">
                <img src="{{ $post->image ? $post->image->url : 'https://via.placeholder.com/150x100' }}"
                     class="w-32 h-24 rounded object-cover">
            </a>

            <!-- Content -->
            <div>
                <a href="{{ route('post.details', $post->slug) }}">
                    <h3 class="text-lg font-semibold text-gray-900 hover:text-blue-700 cursor-pointer">
                        {{ $post->title }}
                    </h3>
                </a>

                <p class="text-sm text-gray-600">{{ Str::limit($post->short_description, 80) }}</p>

                <span class="text-xs text-gray-500 block mt-1">
                    {{ $post->created_at->format('M d, Y') }}
                </span>
            </div>

        </div>
        @endforeach

    </div>

</main>

@endsection
