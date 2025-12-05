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

    <!-- Category Filters -->
    <div class="max-w-5xl mx-auto mb-12">
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('products.index') }}" 
               class="px-6 py-2 border {{ !request('category') ? 'bg-yellow-400 text-black border-yellow-400' : 'border-neutral-700 text-gray-300 hover:bg-yellow-400 hover:text-black hover:border-yellow-400' }} rounded-full transition-colors duration-300 text-sm font-medium">
                All Products
            </a>
            
            @foreach($categories as $category)
            <a href="{{ route('products.index', ['category' => $category->id]) }}" 
               class="px-6 py-2 border {{ request('category') == $category->id ? 'bg-yellow-400 text-black border-yellow-400' : 'border-neutral-700 text-gray-300 hover:bg-yellow-400 hover:text-black hover:border-yellow-400' }} rounded-full transition-colors duration-300 text-sm font-medium">
                {{ $category->name }}
            </a>
            @endforeach
        </div>
    </div>

    <!-- Product Grid -->
    <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-10">
        @forelse($products as $product)
        <a href="{{ route('products.show', $product->id) }}" class="group block">
            <div class="bg-neutral-900 rounded-2xl overflow-hidden border border-neutral-800 hover:border-yellow-400 hover:shadow-[0_0_20px_rgba(250,204,21,0.15)] transition-all duration-300 h-full">
                
                <!-- Product Image -->
                <div class="relative overflow-hidden">
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-72 object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                    <div class="w-full h-72 bg-neutral-800 flex items-center justify-center text-gray-500">
                        <x-heroicon-o-photo class="w-12 h-12" />
                    </div>
                    @endif
                    
                    <!-- Badges -->
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        @if($product->category)
                        <span class="px-3 py-1 bg-black/70 backdrop-blur-sm text-yellow-400 text-xs font-medium rounded-full border border-yellow-400/30">
                            {{ $product->category->name }}
                        </span>
                        @endif
                        
                        @if(!$product->isInStock())
                        <span class="px-3 py-1 bg-red-500/90 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                            Out of Stock
                        </span>
                        @elseif($product->total_stock <= 5)
                        <span class="px-3 py-1 bg-orange-500/90 backdrop-blur-sm text-white text-xs font-medium rounded-full">
                            Only {{ $product->total_stock }} left
                        </span>
                        @endif
                    </div>

                    <!-- Hover overlay -->
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <span class="px-5 py-2 bg-yellow-400 text-black font-semibold rounded-lg group-hover:bg-yellow-500 transition">
                            View Details
                        </span>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="p-5">
                    <h3 class="text-xl text-white font-medium mb-2 truncate group-hover:text-yellow-400 transition-colors">
                        {{ $product->name }}
                    </h3>
                    <p class="text-gray-400 text-sm line-clamp-2 mb-4">
                        {{ $product->description }}
                    </p>
                    
                    <!-- Stock Info -->
                    @if($product->usesDynamicStock())
                    
                    @endif
                    
                    <div class="flex justify-between items-center">
                        <span class="text-yellow-400 text-2xl font-semibold">
                            {{ number_format($product->price, 2) }} DA
                        </span>
                        <span class="text-gray-500 text-sm flex items-center gap-1">
                            @if($product->isInStock())
                            <x-heroicon-o-arrow-right class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                            @else
                            <span class="text-red-500 text-xs">Unavailable</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </a>
        @empty
        <div class="col-span-full py-20 text-center">
            <x-heroicon-o-inbox class="w-16 h-16 text-gray-600 mx-auto mb-4" />
            <p class="text-gray-500 text-lg">No products found.</p>
            @if(request('category'))
            <a href="{{ route('products.index') }}" 
               class="inline-block mt-4 px-6 py-2 bg-yellow-400 text-black rounded-lg hover:bg-yellow-500 transition">
                View All Products
            </a>
            @endif
        </div>
        @endforelse 
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="max-w-7xl mx-auto mt-12">
        <div class="flex justify-center">
            {{ $products->links() }}
        </div>
    </div>
    @endif

</section>
@endsection