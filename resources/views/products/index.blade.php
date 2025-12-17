@extends('layouts.app')

@section('title', 'All Hoodies — HoodLuxe')

@section('content')

<!-- Hero Section -->
<section class="relative pt-32 pb-16 px-6" 
         style="background: linear-gradient(to bottom, color-mix(in srgb, var(--primary-color) 5%, var(--background-color)), var(--background-color));">
    <div class="max-w-7xl mx-auto text-center space-y-6 fade-in">
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-extralight leading-tight tracking-tight"
            style="color: var(--text-color);">
            Our Collection
        </h1>
        <p class="text-lg md:text-xl max-w-2xl mx-auto font-light leading-relaxed"
           style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
            Discover comfort and style redefined in every piece
        </p>
    </div>
</section>

<!-- Main Section -->
<section class="py-16 px-6" style="background: var(--background-color);">
    <div class="max-w-7xl mx-auto">

        <!-- Filters & Search -->
        <div class="mb-16 space-y-8 fade-in">
            
            <!-- Category Filters -->
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('products.index', ['q' => request('q')]) }}"
                   class="px-6 py-2.5 rounded-full text-sm font-medium transition-all duration-300 {{ !request('category') ? 'text-white shadow-lg' : 'border-2' }}"
                   style="{{ !request('category') ? 'background: var(--primary-color);' : 'border-color: color-mix(in srgb, var(--text-color) 20%, transparent); color: var(--text-color);' }}"
                   onmouseover="if(!'{{ request('category') }}') this.style.background='var(--secondary-color)'; else { this.style.borderColor='var(--primary-color)'; this.style.background='color-mix(in srgb, var(--primary-color) 5%, transparent)'; }"
                   onmouseout="if(!'{{ request('category') }}') this.style.background='var(--primary-color)'; else { this.style.borderColor='color-mix(in srgb, var(--text-color) 20%, transparent)'; this.style.background='transparent'; }">
                    All Products
                </a>

                @foreach($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->id, 'q' => request('q')]) }}"
                       class="px-6 py-2.5 rounded-full text-sm font-medium transition-all duration-300 {{ request('category') == $category->id ? 'text-white shadow-lg' : 'border-2' }}"
                       style="{{ request('category') == $category->id ? 'background: var(--primary-color);' : 'border-color: color-mix(in srgb, var(--text-color) 20%, transparent); color: var(--text-color);' }}"
                       onmouseover="if('{{ request('category') }}' != '{{ $category->id }}') { this.style.borderColor='var(--primary-color)'; this.style.background='color-mix(in srgb, var(--primary-color) 5%, transparent)'; } else this.style.background='var(--secondary-color)'"
                       onmouseout="if('{{ request('category') }}' != '{{ $category->id }}') { this.style.borderColor='color-mix(in srgb, var(--text-color) 20%, transparent)'; this.style.background='transparent'; } else this.style.background='var(--primary-color)'">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <!-- Search Bar -->
            <div class="max-w-md mx-auto">
                <form method="GET" action="{{ route('products.index') }}" class="relative">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    
                    <input name="q" 
                           value="{{ request('q') }}" 
                           type="search"
                           placeholder="Search our collection..."
                           class="w-full px-6 py-3 rounded-full text-sm font-light pr-24 border-2 transition-all duration-300"
                           style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 20%, transparent); color: var(--text-color);"
                           onfocus="this.style.borderColor='var(--primary-color)'"
                           onblur="this.style.borderColor='color-mix(in srgb, var(--text-color) 20%, transparent)'">
                    
                    @if(request('q'))
                        <a href="{{ route('products.index', ['category' => request('category')]) }}" 
                           class="absolute right-20 top-1/2 -translate-y-1/2 transition-colors"
                           style="color: color-mix(in srgb, var(--text-color) 40%, transparent);"
                           onmouseover="this.style.color='var(--primary-color)'"
                           onmouseout="this.style.color='color-mix(in srgb, var(--text-color) 40%, transparent)'"
                           title="Clear search">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                    
                    <button type="submit" 
                            class="absolute right-1.5 top-1.5 px-6 py-2 rounded-full text-white text-sm font-medium transition-all duration-300"
                            style="background: var(--primary-color);"
                            onmouseover="this.style.background='var(--secondary-color)'"
                            onmouseout="this.style.background='var(--primary-color)'">
                        Search
                    </button>
                </form>

                <!-- Active Filters Display -->
                @if(request('q') || request('category'))
                    <div class="mt-4 flex flex-wrap items-center gap-2 justify-center">
                        <span class="text-xs font-medium" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Active filters:</span>
                        
                        @if(request('q'))
                            <span class="px-3 py-1 rounded-full text-xs flex items-center gap-2"
                                  style="background: color-mix(in srgb, var(--primary-color) 10%, transparent); color: var(--text-color);">
                                Search: "{{ request('q') }}"
                                <a href="{{ route('products.index', ['category' => request('category')]) }}" 
                                   style="color: var(--text-color);"
                                   onmouseover="this.style.color='var(--primary-color)'"
                                   onmouseout="this.style.color='var(--text-color)'">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </a>
                            </span>
                        @endif
                        
                        @if(request('category'))
                            @php
                                $activeCategory = $categories->firstWhere('id', request('category'));
                            @endphp
                            @if($activeCategory)
                                <span class="px-3 py-1 rounded-full text-xs flex items-center gap-2"
                                      style="background: color-mix(in srgb, var(--primary-color) 10%, transparent); color: var(--text-color);">
                                    Category: {{ $activeCategory->name }}
                                    <a href="{{ route('products.index', ['q' => request('q')]) }}" 
                                       style="color: var(--text-color);"
                                       onmouseover="this.style.color='var(--primary-color)'"
                                       onmouseout="this.style.color='var(--text-color)'">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </a>
                                </span>
                            @endif
                        @endif
                        
                        <a href="{{ route('products.index') }}" 
                           class="text-xs underline"
                           style="color: color-mix(in srgb, var(--text-color) 50%, transparent);"
                           onmouseover="this.style.color='var(--primary-color)'"
                           onmouseout="this.style.color='color-mix(in srgb, var(--text-color) 50%, transparent)'">
                            Clear all
                        </a>
                    </div>
                @endif
            </div>

        </div>

        <!-- Results Info -->
        @if(request('q') || request('category'))
            <div class="mb-8 text-center fade-in">
                <p class="text-sm" style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                    Showing <span class="font-semibold" style="color: var(--text-color);">{{ $products->total() }}</span> 
                    {{ Str::plural('result', $products->total()) }}
                    @if(request('q'))
                        for "<span class="font-semibold" style="color: var(--text-color);">{{ request('q') }}</span>"
                    @endif
                </p>
            </div>
        @endif

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">

            @forelse($products as $product)
                <div class="group block fade-in relative product-card">
                    <a href="{{ route('products.show', $product->id) }}">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden mb-4  border-2 transition-all duration-300"
                             style="background: color-mix(in srgb, var(--primary-color) 3%, transparent); border-color: transparent;"
                             onmouseover="this.style.borderColor='var(--primary-color)'; this.style.boxShadow='0 20px 40px -12px color-mix(in srgb, var(--primary-color) 20%, transparent)'"
                             onmouseout="this.style.borderColor='transparent'; this.style.boxShadow='none'">
                            @if($product->primary_image_url)
                                <img src="{{ $product->primary_image_url }}"
                                     alt="{{ $product->name }}"
                                     class="w-full aspect-[3/4] object-cover transition-transform duration-700 group-hover:scale-105">
                            @else
                                <div class="w-full aspect-[3/4] flex items-center justify-center"
                                     style="background: color-mix(in srgb, var(--primary-color) 5%, transparent); color: color-mix(in srgb, var(--text-color) 40%, transparent);">
                                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex flex-col gap-2">
                                @if($loop->index < 3)
                                    <span class="px-3 py-1 text-white text-xs font-medium uppercase tracking-wider  backdrop-blur-sm"
                                          style="background: var(--primary-color);">
                                        New
                                    </span>
                                @endif

                                @if(!$product->isInStock())
                                    <span class="px-3 py-1 bg-red-600 text-white text-xs font-medium uppercase tracking-wider rounded">
                                        Sold Out
                                    </span>
                                @elseif($product->total_stock <= 5)
                                    <span class="px-3 py-1 text-white text-xs font-medium uppercase tracking-wider rounded backdrop-blur-sm"
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
                        </div>

                        <!-- Product Info -->
                        <div class="space-y-3">
                            @if($product->category)
                                <p class="text-xs uppercase tracking-wider font-medium" style="color: var(--secondary-color);">
                                    {{ $product->category->name }}
                                </p>
                            @endif

                            <h3 class="text-lg font-medium transition-colors" style="color: var(--text-color);"
                                onmouseover="this.style.color='var(--primary-color)'"
                                onmouseout="this.style.color='var(--text-color)'">
                                {{ $product->name }}
                            </h3>

                            <div class="flex justify-between items-center pt-1">
                                <span class="text-lg font-semibold" style="color: var(--primary-color);">
                                    {{ number_format($product->price, 0) }} DA
                                </span>
                                
                                @if($product->isInStock())
                                    <button type="button" 
                                            onclick="event.preventDefault(); event.stopPropagation(); openQuickBuyModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ ($product->usesDynamicStock() && $product->stockType->display_type !== 'none') ? 'true' : 'false' }})"
                                            class="p-2 rounded-full text-white transition-all duration-300 transform hover:scale-110 shadow-lg"
                                            style="background: var(--primary-color);"
                                            onmouseover="this.style.background='var(--secondary-color)'"
                                            onmouseout="this.style.background='var(--primary-color)'"
                                            title="Quick Add to Cart">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                        </svg>
                                    </button>
                                @else
                                    <span class="text-sm font-medium" style="color: color-mix(in srgb, var(--text-color) 40%, transparent);">Out of stock</span>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full text-center py-24 space-y-6">
                    <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center"
                         style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                        <svg class="w-10 h-10" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-light mb-2" style="color: var(--text-color);">No Products Found</h3>
                        <p class="text-lg font-light mb-6" style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                            @if(request('q'))
                                No results found for "{{ request('q') }}"
                            @else
                                Try adjusting your search or filters
                            @endif
                        </p>
                        @if(request('q') || request('category'))
                            <a href="{{ route('products.index') }}" 
                               class="inline-block px-6 py-3 text-white rounded-full transition-all duration-300"
                               style="background: var(--primary-color);"
                               onmouseover="this.style.background='var(--secondary-color)'"
                               onmouseout="this.style.background='var(--primary-color)'">
                                View All Products
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="mt-20 flex justify-center fade-in">
                {{ $products->appends(['q' => request('q'), 'category' => request('category')])->links() }}
            </div>
        @endif

    </div>
</section>

<x-quick-buy-modal />

<!-- Bottom CTA Section -->
<section class="py-24 px-6" style="background: color-mix(in srgb, var(--primary-color) 3%, var(--background-color));">
    <div class="max-w-4xl mx-auto text-center space-y-8 fade-in">
        <div class="space-y-6">
            <h2 class="text-3xl md:text-4xl font-light tracking-tight" style="color: var(--text-color);">
                Can't Find What You're Looking For?
            </h2>
            <p class="text-lg font-light leading-relaxed max-w-2xl mx-auto"
               style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                Get in touch with us and we'll help you find the perfect hoodie for your style
            </p>
        </div>
        <div class="pt-4">
            <a href="{{ url('/contact') }}" 
               class="inline-block px-10 py-4 text-white font-medium rounded-full transition-all duration-300 text-base"
               style="background: var(--primary-color);"
               onmouseover="this.style.background='var(--secondary-color)'"
               onmouseout="this.style.background='var(--primary-color)'">
                Contact Us
            </a>
        </div>
    </div>
</section>

@endsection