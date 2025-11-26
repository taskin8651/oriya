@extends('custom.master')

@section('content')

<div class="container mx-auto px-4 py-10">
<div class="mb-6 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">

    <!-- Heading -->
    <h1 class="text-3xl font-bold text-yellow-400">
        आज का ई-पेपर
    </h1>

   <!-- Filter Form -->
<form method="GET" action="{{ route('epaper.index') }}" class="flex items-center gap-2">

    <!-- Date Input -->
    <input 
        type="date" 
        name="publication_date" 
        value="{{ request('publication_date') }}"
        class="px-3 py-1.5 rounded-md bg-gray-800 text-white border border-gray-600 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 transition"
    >

    <!-- Filter Button -->
    <button type="submit" class="px-4 py-1.5 bg-yellow-400 text-black font-medium rounded-md text-sm hover:bg-yellow-500 transition">
        Filter
    </button>

    <!-- Clear Button -->
    @if(request('publication_date'))
        <a href="{{ route('epaper.index') }}" class="px-4 py-1.5 bg-gray-700 text-white rounded-md text-sm hover:bg-gray-600 transition">
            Clear
        </a>
    @endif

</form>

</div>


    @if ($epapers->isEmpty())
        <p class="text-gray-400">कोई ई-पेपर उपलब्ध नहीं है।</p>
    @else

    <!-- GRID -->
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">

        @foreach ($epapers as $item)

        <a href="{{ route('custom.epaper-detail', $item->id) }}" class="block text-center">

            <div class="bg-[#1e1e1e] p-4 rounded-xl shadow-md hover:shadow-lg transition">

                <h2 class="text-white text-lg font-semibold mb-3">
                    {{ $item->edition ?? $item->title }}
                </h2>

                <div class="relative overflow-hidden rounded-lg">
                    @if ($item->cover_image)
                        <img src="{{ $item->cover_image->url }}" class="w-full h-auto rounded-lg">
                    @else
                        <div class="flex items-center justify-center h-48 text-gray-500">No Cover</div>
                    @endif
                </div>

            </div>

        </a>

        @endforeach

    </div>

    @endif

</div>

@endsection
