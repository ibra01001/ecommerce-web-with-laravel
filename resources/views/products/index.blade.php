@extends('layouts.app')

@section('title', 'All Hoodies — HoodLuxe')

@section('content')
<section class="pt-32 pb-24 px-6 bg-gradient-to-b from-black via-neutral-950 to-neutral-900 min-h-screen">
    <!-- Header -->
    <div class="max-w-7xl mx-auto text-center mb-16">
        <h1 class="text-5xl md:text-6xl font-light text-white mb-4 tracking-wide">
            Discover <span class="text-yellow-400 font-semibold">HoodLuxe</span> Collection
        </h1>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">
            Premium hoodies designed for comfort, confidence, and class.
        </p>
    </div>

    <!-- Filters -->
    <div class="max-w-5xl mx-auto mb-12 flex flex-wrap justify-center gap-4">
        @php
            $filters = ['All', 'Men', 'Women', 'Unisex'];
        @endphp
        @foreach($filters as $filter)
        <button class="px-6 py-2 border border-neutral-700 text-gray-300 rounded-full 
                       hover:bg-yellow-400 hover:text-black hover:border-yellow-400 
                       transition-colors duration-300 text-sm font-medium">
            {{ $filter }}
        </button>
        @endforeach
    </div>

    <!-- Product Grid -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
        @forelse($products as $product)
        <div class="group bg-neutral-900 rounded-2xl overflow-hidden border border-neutral-800 hover:border-yellow-400 hover:shadow-[0_0_20px_rgba(250,204,21,0.15)] transition-all duration-300">
            <!-- Product Image -->
            <div class="relative overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                         class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-105">
                @else
                    <div class="w-full h-72 bg-neutral-800 flex items-center justify-center text-gray-500">
                        <x-heroicon-o-photo class="w-12 h-12" />
                    </div>
                @endif
                <!-- Hover overlay -->
                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                    <a href="{{ route('products.show', $product->id) }}" 
                       class="px-5 py-2 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition">
                        View Details
                    </a>
                </div>
            </div>

            <!-- Product Info -->
            <div class="p-5">
                <h3 class="text-xl text-white font-medium mb-2 truncate">{{ $product->name }}</h3>
                <p class="text-gray-400 text-sm line-clamp-2 mb-4">{{ $product->description }}</p>

                <div class="flex justify-between items-center">
                    <span class="text-yellow-400 text-lg font-semibold">{{ number_format($product->price, 2) }} DA</span>
                    <form method="POST" action="{{ route('cart.add', $product->id) }}">
                        @csrf
                        <button type="submit" class="p-2 rounded-full bg-yellow-400 text-black hover:bg-yellow-500 transition" title="Add to Cart">
                            <x-heroicon-o-shopping-cart class="w-5 h-5" />
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <p class="text-gray-500 text-center col-span-full py-20">No products found.</p>
        @endforelse
    </div>
</section>
@endsection
