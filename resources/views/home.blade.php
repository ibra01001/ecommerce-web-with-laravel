@extends('layouts.app')
@section('title', 'HoodLuxe — Premium Hoodies for the Modern You')
@section('content')

    <!-- Hero Section - Theme Enhanced -->
    <section class="relative pt-32 pb-24 px-6 overflow-hidden"
        style="background: linear-gradient(135deg, var(--background-color) 0%, color-mix(in srgb, var(--primary-color) 5%, var(--background-color)) 100%);">
        <div class="relative max-w-6xl mx-auto text-center space-y-12">
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-1/4 w-64 h-64 rounded-full opacity-10 blur-3xl"
                style="background: var(--primary-color);"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 rounded-full opacity-10 blur-3xl"
                style="background: var(--secondary-color);"></div>

            <!-- Hero Text -->
            @include('layouts.hero')
        </div>
    </section>
    @include('layouts.news')
    <!-- Featured Products Section -->
    <section id="featured" class="py-24 px-6">
        <div class="max-w-7xl mx-auto">

            <!-- Section Header -->
            <div class="text-center mb-20 space-y-4 fade-in">
                <h2 class="text-4xl md:text-5xl font-light tracking-tight text-theme-text">
                    Latest Arrivals
                </h2>
                <p class="text-lg max-w-2xl mx-auto font-light"
                    style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                    Discover Our Products
                </p>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                @forelse($featuredProducts as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="group block fade-in product-card">
                        <div class="h-full">

                            <!-- Product Image -->
                            <div class="relative overflow-hidden  mb-4 border-2 border-transparent transition-all duration-300"
                                style="background: color-mix(in srgb, var(--primary-color) 3%, transparent);">
                                @if($product->primary_image_url)
                                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"
                                        class="w-full aspect-[3/4] object-cover transition-transform duration-700 group-hover:scale-105">
                                @else
                                    <div class="w-full aspect-[3/4] flex items-center justify-center"
                                        style="background: color-mix(in srgb, var(--primary-color) 5%, transparent); color: color-mix(in srgb, var(--text-color) 40%, transparent);">
                                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif

                                <!-- Enhanced Badges -->
                                <div class="absolute top-3 left-3 flex flex-col gap-2">
                                    @if($loop->index < 3)
                                        <span
                                            class="px-3 py-1 text-white text-xs font-medium uppercase tracking-wider  backdrop-blur-sm"
                                            style="background: var(--primary-color);">
                                            New
                                        </span>
                                    @endif

                                    @if(!$product->isInStock())
                                        <span
                                            class="px-3 py-1 bg-red-600 text-white text-xs font-medium uppercase tracking-wider  backdrop-blur-sm">
                                            Sold Out
                                        </span>
                                    @elseif($product->total_stock <= 5)
                                        <span
                                            class="px-3 py-1 text-white text-xs font-medium uppercase tracking-wider  backdrop-blur-sm"
                                            style="background: var(--secondary-color);">
                                            Low Stock
                                        </span>
                                    @endif
                                </div>

                                <!-- Image Count -->
                                @if($product->images->count() > 1)
                                    <div class="absolute top-3 right-3 backdrop-blur-sm text-xs font-medium px-2 py-1 "
                                        style="background: color-mix(in srgb, var(--background-color) 90%, transparent); color: var(--text-color);">
                                        +{{ $product->images->count() - 1 }}
                                    </div>
                                @endif

                                <!-- Hover Overlay -->
                                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                                    style="background: linear-gradient(to top, color-mix(in srgb, var(--primary-color) 20%, transparent), transparent);">
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="space-y-3">
                                <!-- Category -->
                                @if($product->category)
                                    <p class="text-xs uppercase tracking-wider font-medium text-theme-secondary">
                                        {{ $product->category->name }}
                                    </p>
                                @endif

                                <!-- Name -->
                                <h3
                                    class="text-lg font-medium text-theme-text group-hover:text-theme-primary transition-colors">
                                    {{ $product->name }}
                                </h3>

                                <!-- Price and Cart -->
                                <div class="flex justify-between items-center pt-1">
                                    <span class="text-lg font-semibold text-theme-primary">
                                        {{ number_format($product->price, 0) }} DA
                                    </span>

                                    @if($product->isInStock())
                                        <button type="button"
                                            onclick="event.preventDefault(); event.stopPropagation(); openQuickBuyModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ ($product->usesDynamicStock() && $product->stockType->display_type !== 'none') ? 'true' : 'false' }})"
                                            class="p-2 rounded-full text-white transition-all duration-300 transform hover:scale-110 hover:shadow-lg"
                                            style="background: var(--primary-color);"
                                            onmouseover="this.style.background='var(--secondary-color)'"
                                            onmouseout="this.style.background='var(--primary-color)'" title="Quick Add to Cart">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                            </svg>
                                        </button>
                                    @else
                                        <span class="text-sm font-medium"
                                            style="color: color-mix(in srgb, var(--text-color) 40%, transparent);">
                                            Out of stock
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-24 space-y-6">
                        <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center"
                            style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                            <svg class="w-10 h-10 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-light mb-2 text-theme-text">No Products Yet</h3>
                            <p class="text-lg font-light"
                                style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
                                Our collection is coming soon
                            </p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- View All Button - Theme Enhanced -->
            @if(count($featuredProducts) > 0)
                <div class="text-center mt-20 fade-in">
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center gap-3 px-10 py-4 border-2 font-medium rounded-full transition-all duration-300 text-base group"
                        style="border-color: var(--primary-color); color: var(--primary-color);"
                        onmouseover="this.style.background='var(--primary-color)'; this.style.color='white';"
                        onmouseout="this.style.background='transparent'; this.style.color='var(--primary-color)';">
                        View All Products
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    @include('layouts.features')
    <x-quick-buy-modal />

    <!-- Additional Styling for Enhanced Animations -->
    <style>
        .product-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card:hover {
            transform: translateY(-8px);
        }

        .product-card:hover .product-card>div>div:first-child {
            border-color: var(--primary-color) !important;
            box-shadow: 0 20px 40px -12px color-mix(in srgb, var(--primary-color) 20%, transparent);
        }

        /* Smooth color transitions */
        .theme-transition {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Enhanced fade-in with stagger */
        .fade-in {
            animation-delay: calc(var(--stagger, 0) * 0.1s);
        }

        .product-card:nth-child(1) {
            --stagger: 1;
        }

        .product-card:nth-child(2) {
            --stagger: 2;
        }

        .product-card:nth-child(3) {
            --stagger: 3;
        }

        .product-card:nth-child(4) {
            --stagger: 4;
        }

        .product-card:nth-child(5) {
            --stagger: 5;
        }

        .product-card:nth-child(6) {
            --stagger: 6;
        }

        .product-card:nth-child(7) {
            --stagger: 7;
        }

        .product-card:nth-child(8) {
            --stagger: 8;
        }

        /* Pulse animation for new badges */
        @keyframes pulse-theme {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        .product-card:hover [style*="background: var(--primary-color)"] {
            animation: pulse-theme 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
@endsection