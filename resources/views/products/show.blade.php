@extends('layouts.app')

@section('title', $product->name . ' — HoodLuxe')

@section('content')
<section class="pt-32 pb-24 px-6 bg-gradient-to-b from-black via-neutral-950 to-neutral-900 min-h-screen">
    <div class="max-w-7xl mx-auto">
        
        <!-- Back Navigation -->
        <div class="mb-8">
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center gap-2 text-gray-400 hover:text-yellow-400 transition-colors duration-300 group">
                <x-heroicon-o-arrow-left class="w-5 h-5 group-hover:-translate-x-1 transition-transform" /> 
                <span>Back to Collection</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">

            <!-- Product Image -->
            <div class="relative overflow-hidden rounded-2xl border border-neutral-800 group hover:border-yellow-400 hover:shadow-[0_0_30px_rgba(250,204,21,0.2)] transition-all duration-500">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         alt="{{ $product->name }}"
                         class="w-full h-[500px] lg:h-[800px] object-cover transition-transform duration-700 group-hover:scale-105">
                @else
                    <div class="w-full h-[500px] lg:h-[800px] bg-neutral-900 flex items-center justify-center">
                        <x-heroicon-o-photo class="w-24 h-24 text-gray-700" />
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            </div>

            <!-- Product Details -->
            <div class="flex flex-col space-y-8">
                
                <!-- Product Header -->
                <div class="space-y-4">
                    <h1 class="text-4xl lg:text-5xl xl:text-6xl font-light text-white leading-tight tracking-wide">
                        {{ $product->name }}
                    </h1>
                    <p class="text-gray-400 text-lg leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>

                <!-- Price -->
                <div class="py-6 border-y border-neutral-800">
                    <div class="flex items-baseline gap-3">
                        <span class="text-yellow-400 text-4xl lg:text-5xl font-semibold">
                            {{ number_format($product->price, 0) }} DA
                        </span>
                        <span class="text-gray-500 text-sm">incl. taxes</span>
                    </div>
                </div>

                <!-- Size Selection -->
                <div>
                    <label class="block text-white text-sm font-medium mb-4 tracking-wide uppercase">
                        Select Size
                    </label>
                    <div class="flex flex-wrap gap-3">
                        @php
                            $sizes = [
                                'S' => $product->taille_S,
                                'M' => $product->taille_M,
                                'L' => $product->taille_L,
                                'XL' => $product->taille_XL,
                                'XXL' => $product->taille_XXL
                            ];
                        @endphp

                        @foreach($sizes as $size => $stock)
                            <button type="button"
                                    data-size="{{ $size }}"
                                    data-stock="{{ $stock }}"
                                    class="size-btn px-6 py-3 rounded-lg border {{ $stock > 0 ? 'border-neutral-700 text-gray-300 hover:bg-yellow-400 hover:text-black hover:border-yellow-400' : 'border-neutral-800 text-gray-600 cursor-not-allowed' }} font-medium transition-all duration-300 min-w-[60px] relative"
                                    {{ $stock == 0 ? 'disabled' : '' }}>
                                {{ $size }}
                                @if($stock == 0)
                                    <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                    <p id="size-error" class="text-red-400 text-sm mt-2 hidden">
                        Please select a size
                    </p>
                </div>

                <!-- Quantity Selection -->
                <div>
                    <label class="block text-white text-sm font-medium mb-4 tracking-wide uppercase">
                        Quantity
                    </label>
                    <div class="flex items-center border border-neutral-700 rounded-lg overflow-hidden w-fit bg-neutral-900">
                        <button type="button" onclick="decreaseQty()" 
                                class="px-5 py-3 text-gray-300 hover:bg-yellow-400 hover:text-black transition-colors duration-300">
                            <x-heroicon-o-minus class="w-5 h-5" />
                        </button>
                        <input id="quantity" 
                               name="quantity" 
                               type="number" 
                               value="1" 
                               min="1"
                               max="1"
                               class="w-20 text-center bg-neutral-900 text-white border-x border-neutral-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 appearance-none py-3 text-lg">
                        <button type="button" onclick="increaseQty()" 
                                class="px-5 py-3 text-gray-300 hover:bg-yellow-400 hover:text-black transition-colors duration-300">
                            <x-heroicon-o-plus class="w-5 h-5" />
                        </button>
                    </div>
                    <p id="stock-info" class="text-gray-500 text-sm mt-2">
                        Please select a size first
                    </p>
                </div>

                <!-- Add to Cart Button -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" id="add-to-cart-form" class="pt-4">
                    @csrf
                    <input type="hidden" name="quantity" id="cart-quantity" value="1">
                    <input type="hidden" name="taille_type" id="selected-size" value="">
                    
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-3 bg-yellow-400 text-black font-semibold py-4 px-8 rounded-lg hover:bg-yellow-500 transition-colors duration-300 text-lg group">
                        <x-heroicon-o-shopping-cart class="w-6 h-6 group-hover:scale-110 transition-transform" />
                        Add to Cart
                    </button>
                </form>

                <!-- Product Features -->
                <div class="grid grid-cols-2 gap-4 pt-6 border-t border-neutral-800">
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-neutral-900 rounded-lg border border-neutral-800">
                            <x-heroicon-o-truck class="w-5 h-5 text-yellow-400" />
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium">Free Shipping</p>
                            <p class="text-gray-500 text-xs">On all orders</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-neutral-900 rounded-lg border border-neutral-800">
                            <x-heroicon-o-arrow-path class="w-5 h-5 text-yellow-400" />
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium">Easy Returns</p>
                            <p class="text-gray-500 text-xs">30-day policy</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-neutral-900 rounded-lg border border-neutral-800">
                            <x-heroicon-o-shield-check class="w-5 h-5 text-yellow-400" />
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium">Premium Quality</p>
                            <p class="text-gray-500 text-xs">Guaranteed</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="p-2 bg-neutral-900 rounded-lg border border-neutral-800">
                            <x-heroicon-o-credit-card class="w-5 h-5 text-yellow-400" />
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium">Secure Payment</p>
                            <p class="text-gray-500 text-xs">Protected</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
let selectedSize = null;
let selectedStock = 0;

// Quantity decrease function
function decreaseQty() {
    const input = document.getElementById('quantity');
    const cartInput = document.getElementById('cart-quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        cartInput.value = input.value;
    }
}

// Quantity increase function
function increaseQty() {
    const input = document.getElementById('quantity');
    const cartInput = document.getElementById('cart-quantity');
    const max = parseInt(input.max);
    
    if (!selectedSize) {
        alert('Please select a size first');
        return;
    }
    
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
        cartInput.value = input.value;
    }
}

// Update cart quantity when input changes manually
document.getElementById('quantity').addEventListener('change', function() {
    const max = parseInt(this.max);
    
    if (parseInt(this.value) > max) {
        this.value = max;
    }
    if (parseInt(this.value) < 1) {
        this.value = 1;
    }
    
    document.getElementById('cart-quantity').value = this.value;
});

// Size selection functionality
document.querySelectorAll('.size-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        // Don't allow selection if out of stock
        if (this.disabled) {
            return;
        }

        // Remove selection from all buttons
        document.querySelectorAll('.size-btn').forEach(b => {
            b.classList.remove('bg-yellow-400', 'text-black', 'border-yellow-400');
            b.classList.add('text-gray-300', 'border-neutral-700');
        });
        
        // Add selection to clicked button
        this.classList.remove('text-gray-300', 'border-neutral-700');
        this.classList.add('bg-yellow-400', 'text-black', 'border-yellow-400');

        // Get size and stock info
        selectedSize = this.dataset.size;
        selectedStock = parseInt(this.dataset.stock);

        // Update hidden input
        document.getElementById('selected-size').value = selectedSize;

        // Update quantity limits
        const quantityInput = document.getElementById('quantity');
        quantityInput.max = selectedStock;
        
        // Reset quantity to 1 if current value exceeds available stock
        if (parseInt(quantityInput.value) > selectedStock) {
            quantityInput.value = 1;
            document.getElementById('cart-quantity').value = 1;
        }

        // Update stock info text
        const stockInfo = document.getElementById('stock-info');
        if (selectedStock > 0) {
            stockInfo.textContent = `${selectedStock} items available in size ${selectedSize}`;
            stockInfo.classList.remove('text-red-400');
            stockInfo.classList.add('text-gray-500');
        } else {
            stockInfo.textContent = `Size ${selectedSize} is out of stock`;
            stockInfo.classList.remove('text-gray-500');
            stockInfo.classList.add('text-red-400');
        }

        // Hide size error if shown
        document.getElementById('size-error').classList.add('hidden');
    });
});

// Form submission validation
document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
    const sizeError = document.getElementById('size-error');
    
    if (!selectedSize) {
        e.preventDefault();
        sizeError.classList.remove('hidden');
        
        // Scroll to size selection
        const firstSizeBtn = document.querySelector('.size-btn');
        if (firstSizeBtn) {
            firstSizeBtn.scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });
        }
        
        return false;
    }

    if (selectedStock === 0) {
        e.preventDefault();
        alert('This size is out of stock. Please select another size.');
        return false;
    }
});
</script>
@endsection
