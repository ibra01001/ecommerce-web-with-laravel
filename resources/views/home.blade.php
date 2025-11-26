@extends('layouts.app')
@section('title', 'HoodLuxe — Premium Hoodies for the Modern You')
@section('content')

<!-- Hero Section -->
<section class="relative pt-32 pb-20 px-6 bg-gradient-to-b from-black via-neutral-950 to-neutral-900 overflow-hidden">
    <!-- Background Effect -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-yellow-400/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-yellow-400/20 rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto text-center space-y-8">
        <!-- Hero Text -->
        <div class="space-y-6">
            <h1 class="text-6xl md:text-7xl lg:text-8xl font-light text-white leading-tight tracking-wide">
                Discover <span class="text-yellow-400 font-semibold">HoodLuxe</span>
            </h1>
            <p class="text-gray-400 text-xl md:text-2xl max-w-3xl mx-auto leading-relaxed">
                Premium hoodies designed for comfort, confidence, and class.
            </p>
        </div>

        <!-- CTA Buttons -->
        <div class="flex flex-wrap justify-center gap-4 pt-8">
            <a href="{{ route('products.index') }}" 
               class="px-8 py-4 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition-colors duration-300 text-lg">
                Shop Collection
            </a>
            <a href="#featured" 
               class="px-8 py-4 border border-neutral-700 text-gray-300 rounded-lg hover:bg-yellow-400 hover:text-black hover:border-yellow-400 transition-all duration-300 text-lg">
                Explore Featured
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-3 gap-8 max-w-3xl mx-auto pt-16">
            <div class="space-y-2">
                <p class="text-4xl md:text-5xl font-semibold text-yellow-400">100+</p>
                <p class="text-gray-400 text-sm md:text-base">Premium Designs</p>
            </div>
            <div class="space-y-2">
                <p class="text-4xl md:text-5xl font-semibold text-yellow-400">5K+</p>
                <p class="text-gray-400 text-sm md:text-base">Happy Customers</p>
            </div>
            <div class="space-y-2">
                <p class="text-4xl md:text-5xl font-semibold text-yellow-400">★ 4.9</p>
                <p class="text-gray-400 text-sm md:text-base">Average Rating</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section id="featured" class="py-24 px-6 bg-gradient-to-b from-neutral-900 to-black">
    <div class="max-w-7xl mx-auto">
        
        <!-- Section Header -->
        <div class="text-center mb-16 space-y-4">
            <h2 class="text-4xl md:text-5xl font-light text-white tracking-wide">
                Featured <span class="text-yellow-400 font-semibold">Collection</span>
            </h2>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Handpicked premium hoodies that blend style with unmatched comfort
            </p>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
            @forelse($featuredProducts as $product)
                <div class="group bg-neutral-900 rounded-2xl overflow-hidden border border-neutral-800 hover:border-yellow-400 hover:shadow-[0_0_20px_rgba(250,204,21,0.15)] transition-all duration-300">
                    
                    <!-- Product Image -->
                    <div class="relative overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-80 bg-neutral-800 flex items-center justify-center text-gray-500">
                                <x-heroicon-o-photo class="w-16 h-16" />
                            </div>
                        @endif
                        
                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <a href="{{ route('products.show', $product->id) }}" 
                               class="px-6 py-3 bg-yellow-400 text-black font-semibold rounded-lg hover:bg-yellow-500 transition-colors duration-300 transform translate-y-4 group-hover:translate-y-0">
                                View Details
                            </a>
                        </div>

                        <!-- New Badge (Optional) -->
                        @if($loop->index < 3)
                            <div class="absolute top-4 left-4 px-3 py-1 bg-yellow-400 text-black text-xs font-semibold rounded-full">
                                NEW
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="p-6 space-y-4">
                        <div>
                            <h3 class="text-xl text-white font-medium mb-2 truncate group-hover:text-yellow-400 transition-colors">
                                {{ $product->name }}
                            </h3>
                            <p class="text-gray-400 text-sm line-clamp-2 leading-relaxed">
                                {{ $product->description }}
                            </p>
                        </div>

                        <div class="flex justify-between items-center pt-2">
                            <span class="text-yellow-400 text-xl font-semibold">
                                {{ number_format($product->price, 2) }} DA
                            </span>
                            <form method="POST" action="{{ route('cart.add', $product->id) }}">
                                @csrf
                                <button type="submit" 
                                        class="p-2.5 rounded-full bg-yellow-400 text-black hover:bg-yellow-500 transition-colors duration-300 hover:scale-110 transform"
                                        title="Add to Cart">
                                    <x-heroicon-o-shopping-cart class="w-5 h-5" />
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20 space-y-6">
                    <div class="w-24 h-24 mx-auto bg-neutral-900 rounded-full flex items-center justify-center border border-neutral-800">
                        <x-heroicon-o-cube class="w-12 h-12 text-gray-600" />
                    </div>
                    <div>
                        <h3 class="text-2xl text-white font-medium mb-2">No Featured Products Yet</h3>
                        <p class="text-gray-400 text-lg">Check back soon for our latest collection</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- View All Button -->
        @if(count($featuredProducts) > 0)
            <div class="text-center mt-16">
                <a href="{{ route('products.index') }}" 
                   class="inline-block px-8 py-4 border border-neutral-700 text-gray-300 rounded-lg hover:bg-yellow-400 hover:text-black hover:border-yellow-400 transition-all duration-300 text-lg font-medium">
                    View Full Collection
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Features Section -->
<section class="py-24 px-6 bg-gradient-to-b from-black to-neutral-950">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            
            <div class="text-center space-y-4 group">
                <div class="w-16 h-16 mx-auto bg-neutral-900 rounded-full flex items-center justify-center border border-neutral-800 group-hover:border-yellow-400 transition-colors duration-300">
                    <x-heroicon-o-truck class="w-8 h-8 text-yellow-400" />
                </div>
                <h3 class="text-white text-lg font-medium">Free Shipping</h3>
                <p class="text-gray-400 text-sm">On all orders nationwide</p>
            </div>

            <div class="text-center space-y-4 group">
                <div class="w-16 h-16 mx-auto bg-neutral-900 rounded-full flex items-center justify-center border border-neutral-800 group-hover:border-yellow-400 transition-colors duration-300">
                    <x-heroicon-o-shield-check class="w-8 h-8 text-yellow-400" />
                </div>
                <h3 class="text-white text-lg font-medium">Premium Quality</h3>
                <p class="text-gray-400 text-sm">Carefully crafted materials</p>
            </div>

            <div class="text-center space-y-4 group">
                <div class="w-16 h-16 mx-auto bg-neutral-900 rounded-full flex items-center justify-center border border-neutral-800 group-hover:border-yellow-400 transition-colors duration-300">
                    <x-heroicon-o-arrow-path class="w-8 h-8 text-yellow-400" />
                </div>
                <h3 class="text-white text-lg font-medium">Easy Returns</h3>
                <p class="text-gray-400 text-sm">30-day return policy</p>
            </div>

            <div class="text-center space-y-4 group">
                <div class="w-16 h-16 mx-auto bg-neutral-900 rounded-full flex items-center justify-center border border-neutral-800 group-hover:border-yellow-400 transition-colors duration-300">
                    <x-heroicon-o-credit-card class="w-8 h-8 text-yellow-400" />
                </div>
                <h3 class="text-white text-lg font-medium">Secure Payment</h3>
                <p class="text-gray-400 text-sm">Safe & encrypted checkout</p>
            </div>

        </div>
    </div>
</section>

@endsection