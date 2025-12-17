@extends('layouts.app')

@section('title', $product->name . ' — HoodLuxe')

@section('content')
<section class="pt-24 pb-16 min-h-screen" style="background: var(--background-color);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <a href="{{ route('products.index') }}" 
           class="inline-flex items-center gap-2 mb-6 text-theme-text hover:text-theme-primary transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to collection
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
            
            <!-- Desktop Thumbnails - Scrollable Column -->
            <div class="hidden lg:block lg:col-span-1">
                <div class="sticky top-28">
                    <div class="space-y-3 max-h-[600px] overflow-y-auto pr-2 scrollbar-thin">
                        @php
                            $images = $product->images->count() ? $product->images : collect();
                            if($images->isEmpty() && $product->image) {
                                $images = collect([(object)['image_url' => asset('storage/' . $product->image), 'id' => 0]]);
                            }
                        @endphp

                        @foreach($images as $idx => $img)
                            <button type="button" 
                                    data-index="{{ $idx }}" 
                                    class="thumb-btn w-full aspect-square  overflow-hidden border-2 transition-all duration-300 {{ $idx == 0 ? 'border-theme-primary' : 'border-transparent' }} hover:border-theme-primary"
                                    style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                                <img src="{{ $img->image_url }}" 
                                     alt="thumb {{ $idx + 1 }}" 
                                     class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Image Gallery -->
            <div class="lg:col-span-7 space-y-4">
                <!-- Main Image Container -->
                <div class="w-full  overflow-hidden aspect-square relative" 
                     id="imageContainer"
                     style="background: color-mix(in srgb, var(--primary-color) 3%, transparent);">
                    @if($images->isNotEmpty())
                        <img id="mainImage" 
                             src="{{ $images->first()->image_url }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-full object-cover transition-opacity duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center"
                             style="color: color-mix(in srgb, var(--text-color) 30%, transparent);">
                            <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif

                    <!-- Image Navigation Arrows -->
                    @if($images->count() > 1)
                        <button type="button" 
                                onclick="navigateImage(-1)"
                                class="absolute left-4 top-1/2 -translate-y-1/2 p-3 rounded-full backdrop-blur-md transition-all duration-300 hover:scale-110 z-20"
                                style="background: color-mix(in srgb, var(--background-color) 80%, transparent); color: var(--text-color);">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button type="button" 
                                onclick="navigateImage(1)"
                                class="absolute right-4 top-1/2 -translate-y-1/2 p-3 rounded-full backdrop-blur-md transition-all duration-300 hover:scale-110 z-20"
                                style="background: color-mix(in srgb, var(--background-color) 80%, transparent); color: var(--text-color);">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        <!-- Image Counter -->
                        <div class="absolute top-4 right-4 px-3 py-1.5  backdrop-blur-md text-sm font-medium z-20"
                             style="background: color-mix(in srgb, var(--background-color) 80%, transparent); color: var(--text-color);">
                            <span id="currentImageIndex">1</span> / {{ $images->count() }}
                        </div>
                    @endif
                </div>

                <!-- Mobile Thumbnail Strip - OUTSIDE main image -->
                @if($images->count() > 1)
                    <div class="lg:hidden">
                        <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-thin">
                            @foreach($images as $idx => $img)
                                <button data-index="{{ $idx }}" 
                                        class="mobile-thumb flex-shrink-0 w-16 sm:w-20 aspect-square  overflow-hidden border-2 transition-all duration-300 {{ $idx == 0 ? 'border-theme-primary' : 'border-transparent' }} hover:border-theme-primary"
                                        style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                                    <img src="{{ $img->image_url }}" 
                                         alt="mobile thumb {{ $idx + 1 }}" 
                                         class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="lg:col-span-4 space-y-6">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-light text-theme-text tracking-tight">{{ $product->name }}</h1>
                    @if($product->category)
                        <p class="text-sm text-theme-secondary mt-2 uppercase tracking-wider">{{ $product->category->name }}</p>
                    @endif
                </div>

                <div class="flex items-center gap-4 pb-4 border-b" 
                     style="border-color: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                    <div class="text-2xl sm:text-3xl font-semibold text-theme-primary">{{ number_format($product->price, 0) }} DA</div>
                    <div class="text-sm" 
                         style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
                        <span id="stockDisplay">{{ $product->total_stock }}</span> in stock
                    </div>
                </div>

                <p class="text-theme-text leading-relaxed" style="opacity: 0.8;">
                    {{ $product->description }}
                </p>

                <!-- Main Form -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" id="cartForm" class="space-y-5">
                    @csrf
                    
                    @if($product->usesDynamicStock())
                        @php $options = $product->getAvailableStockOptions(); @endphp
                        @if(count($options) && $product->stockType->display_type === 'grid')
                            <div>
                                <label class="text-sm text-theme-text font-medium block mb-3">Size</label>
                                <div class="grid grid-cols-3 sm:grid-cols-4 gap-2">
                                    @foreach($options as $opt)
                                        <button type="button" 
                                                data-id="{{ $opt['id'] }}" 
                                                data-stock="{{ $opt['quantity'] }}" 
                                                onclick="selectOption(this, {{ $opt['quantity'] }})"
                                                class="option-btn px-4 py-3 rounded-lg border-2 text-sm font-medium transition-all duration-300 {{ $opt['in_stock'] ? 'hover:scale-105' : 'opacity-50 cursor-not-allowed' }}"
                                                style="border-color: color-mix(in srgb, var(--primary-color) 20%, transparent); color: var(--text-color);"
                                                {{ !$opt['in_stock'] ? 'disabled' : '' }}>
                                            {{ $opt['label'] }}
                                            <span class="block text-xs mt-1" 
                                                  style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">
                                                {{ $opt['quantity'] }} left
                                            </span>
                                        </button>
                                    @endforeach
                                </div>
                                <input type="hidden" name="stock_option_id" id="optionHidden">
                                <p id="optionMessage" class="text-sm text-red-500 hidden mt-2">Please select a size</p>
                            </div>
                        @endif
                    @endif

                    <div>
                        <label class="text-sm text-theme-text font-medium block mb-3">Quantity</label>
                        <div class="inline-flex items-center border-2 rounded-lg overflow-hidden"
                             style="border-color: color-mix(in srgb, var(--primary-color) 20%, transparent);">
                            <button type="button" 
                                    onclick="changeQty(-1)" 
                                    class="px-4 py-2 text-theme-text hover:bg-opacity-10 transition-colors"
                                    style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <input id="qtyInput" 
                                   name="quantity" 
                                   type="number" 
                                   value="1" 
                                   min="1" 
                                   max="{{ $product->total_stock }}" 
                                   class="w-16 sm:w-20 text-center border-l border-r py-2 text-theme-text"
                                   style="border-color: color-mix(in srgb, var(--primary-color) 20%, transparent); background: transparent;">
                            <button type="button" 
                                    onclick="changeQty(1)" 
                                    class="px-4 py-2 text-theme-text hover:bg-opacity-10 transition-colors"
                                    style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                        <p id="stockError" class="text-sm text-red-500 hidden mt-2">Only <span id="maxStock"></span> available in stock</p>
                    </div>

                    <button type="submit" 
                            class="w-full rounded-full text-white py-4 font-semibold text-base transition-all duration-300 hover:shadow-lg transform hover:-translate-y-0.5"
                            style="background: var(--primary-color);"
                            onmouseover="this.style.background='var(--secondary-color)'"
                            onmouseout="this.style.background='var(--primary-color)'">
                        Add to cart
                    </button>
                </form>

                <!-- Features -->
                            
            </div>
        </div>
    </div>
</section>

<!-- Related Products Section -->
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<section class="py-16 px-4 sm:px-6" 
         style="background: color-mix(in srgb, var(--primary-color) 2%, var(--background-color));">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-2xl sm:text-3xl font-light text-theme-text mb-8">You May Also Like</h2>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($relatedProducts as $relatedProduct)
                <a href="{{ route('products.show', $relatedProduct->id) }}" class="group block">
                    <div class="relative overflow-hidden mb-3 transition-transform duration-300 group-hover:scale-105"
                         style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                        @if($relatedProduct->primary_image_url)
                            <img src="{{ $relatedProduct->primary_image_url }}"
                                 alt="{{ $relatedProduct->name }}"
                                 class="w-full aspect-[3/4] object-cover">
                        @else
                            <div class="w-full aspect-[3/4] flex items-center justify-center"
                                 style="color: color-mix(in srgb, var(--text-color) 30%, transparent);">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        @if(!$relatedProduct->isInStock())
                            <span class="absolute top-2 left-2 px-2 py-1 bg-red-600 text-white text-xs font-medium ">
                                Sold Out
                            </span>
                        @endif
                    </div>

                    <h3 class="text-sm font-medium text-theme-text group-hover:text-theme-primary transition-colors mb-1">
                        {{ $relatedProduct->name }}
                    </h3>
                    <p class="text-theme-primary font-semibold">{{ number_format($relatedProduct->price, 0) }} DA</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<style>
    /* Custom Scrollbar Styling */
    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: color-mix(in srgb, var(--primary-color) 5%, transparent);
        border-radius: 10px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 10px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: var(--secondary-color);
    }

    /* Firefox scrollbar */
    .scrollbar-thin {
        scrollbar-width: thin;
        scrollbar-color: var(--primary-color) transparent;
    }

    /* Smooth transitions for theme changes */
    .text-theme-text,
    .text-theme-primary,
    .text-theme-secondary,
    button,
    input {
        transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
    }

    /* Selected option style */
    .option-btn.selected {
        border-color: var(--primary-color) !important;
        background: color-mix(in srgb, var(--primary-color) 10%, transparent) !important;
    }

    /* Thumbnail active state */
    .thumb-btn.active,
    .mobile-thumb.active {
        border-color: var(--primary-color) !important;
        box-shadow: 0 0 0 1px var(--primary-color);
    }

    /* Remove number input spinners */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>

<script>
    // Image gallery
    const images = @json($images->map(fn($i) => $i->image_url)->values());
    let current = 0;
    const mainImage = document.getElementById('mainImage');
    const currentIndexEl = document.getElementById('currentImageIndex');

    function setMain(idx) {
        if (!images[idx]) return;
        current = idx;
        mainImage.style.opacity = 0;
        setTimeout(() => {
            mainImage.src = images[idx];
            mainImage.style.opacity = 1;
        }, 150);

        // Update counter
        if(currentIndexEl) {
            currentIndexEl.textContent = idx + 1;
        }

        // Update thumbnails
        document.querySelectorAll('.thumb-btn, .mobile-thumb').forEach((el, i) => {
            if (i === idx) {
                el.classList.add('active');
            } else {
                el.classList.remove('active');
            }
        });

        // Scroll desktop thumbnail into view
        const desktopThumb = document.querySelectorAll('.thumb-btn')[idx];
        if (desktopThumb) {
            desktopThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }

        // Scroll mobile thumbnail into view
        const mobileThumb = document.querySelectorAll('.mobile-thumb')[idx];
        if (mobileThumb) {
            mobileThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }

    function navigateImage(direction) {
        const newIndex = (current + direction + images.length) % images.length;
        setMain(newIndex);
    }

    // Thumbnail clicks
    document.querySelectorAll('.thumb-btn, .mobile-thumb').forEach(el => {
        el.addEventListener('click', () => setMain(parseInt(el.dataset.index)));
    });

    // Touch swipe for mobile
    let touchStartX = 0;
    let touchEndX = 0;
    const imageContainer = document.getElementById('imageContainer');

    imageContainer.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    imageContainer.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        if (touchEndX < touchStartX - 50) navigateImage(1); // Swipe left
        if (touchEndX > touchStartX + 50) navigateImage(-1); // Swipe right
    }

    // Stock management
    let maxStock = {{ $product->total_stock }};
    let selectedStock = maxStock;
    let selectedOption = null;

    function updateStockDisplay() {
        document.getElementById('stockDisplay').textContent = selectedStock;
    }

    // Main form option selection
    function selectOption(btn, stock) {
        if (btn.disabled) return;
        
        document.querySelectorAll('.option-btn').forEach(b => {
            b.classList.remove('selected');
        });
        btn.classList.add('selected');
        
        selectedOption = btn.dataset.id;
        selectedStock = stock;
        document.getElementById('optionHidden').value = selectedOption;
        document.getElementById('optionMessage').classList.add('hidden');
        document.getElementById('qtyInput').max = stock;
        
        const qtyInput = document.getElementById('qtyInput');
        if (parseInt(qtyInput.value) > stock) {
            qtyInput.value = stock;
        }
        
        updateStockDisplay();
    }

    function changeQty(delta) {
        const input = document.getElementById('qtyInput');
        const currentMax = selectedOption ? selectedStock : maxStock;
        const newVal = Math.max(1, Math.min(currentMax, parseInt(input.value) + delta));
        input.value = newVal;
        validateStock();
    }

    function validateStock() {
        const input = document.getElementById('qtyInput');
        const qty = parseInt(input.value);
        const currentMax = selectedOption ? selectedStock : maxStock;
        const errorEl = document.getElementById('stockError');
        const maxStockEl = document.getElementById('maxStock');

        if (qty > currentMax) {
            input.value = currentMax;
            errorEl.classList.remove('hidden');
            maxStockEl.textContent = currentMax;
            setTimeout(() => errorEl.classList.add('hidden'), 3000);
        } else {
            errorEl.classList.add('hidden');
        }
    }

    document.getElementById('qtyInput').addEventListener('input', validateStock);

    // Main form validation
    document.getElementById('cartForm').addEventListener('submit', function(e) {
        @if($product->usesDynamicStock())
            if (!selectedOption) {
                e.preventDefault();
                document.getElementById('optionMessage').classList.remove('hidden');
                return false;
            }
        @endif
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') navigateImage(-1);
        if (e.key === 'ArrowRight') navigateImage(1);
    });
</script>
@endsection