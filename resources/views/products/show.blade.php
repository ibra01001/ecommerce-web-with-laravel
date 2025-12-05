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

                @if($product->usesDynamicStock())
                    @php
                        $stockOptions = $product->getAvailableStockOptions();
                        $displayType = $product->stockType->display_type;
                    @endphp

                    @if($displayType !== 'none')
                    <!-- Dynamic Stock Options Selection -->
                    <div>
                        <label class="block text-white text-sm font-medium mb-4 tracking-wide uppercase">
                            Select {{ $product->stockType->name }}
                        </label>

                        @if($displayType === 'grid')
                            <!-- Grid Display (for sizes) -->
                            <div class="flex flex-wrap gap-3">
                                @foreach($stockOptions as $option)
                                    <button type="button"
                                            data-option-id="{{ $option['id'] }}"
                                            data-stock="{{ $option['quantity'] }}"
                                            data-label="{{ $option['label'] }}"
                                            class="stock-option-btn px-6 py-3 rounded-lg border {{ $option['in_stock'] ? 'border-neutral-700 text-gray-300 hover:bg-yellow-400 hover:text-black hover:border-yellow-400' : 'border-neutral-800 text-gray-600 cursor-not-allowed' }} font-medium transition-all duration-300 min-w-[60px] relative"
                                            {{ !$option['in_stock'] ? 'disabled' : '' }}>
                                        {{ $option['label'] }}
                                        @if(!$option['in_stock'])
                                            <span class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>

                        @elseif($displayType === 'dropdown')
                            <!-- Dropdown Display -->
                            <select id="stock-option-select"
                                    class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                                           focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                <option value="">Select an option</option>
                                @foreach($stockOptions as $option)
                                    <option value="{{ $option['id'] }}" 
                                            data-stock="{{ $option['quantity'] }}"
                                            data-label="{{ $option['label'] }}"
                                            {{ !$option['in_stock'] ? 'disabled' : '' }}>
                                        {{ $option['label'] }} {{ $option['in_stock'] ? "({$option['quantity']} available)" : '(Out of stock)' }}
                                    </option>
                                @endforeach
                            </select>

                        @elseif($displayType === 'color-swatch')
                            <!-- Color Swatch Display -->
                            <div class="flex flex-wrap gap-3">
                                @foreach($stockOptions as $option)
                                    <button type="button"
                                            data-option-id="{{ $option['id'] }}"
                                            data-stock="{{ $option['quantity'] }}"
                                            data-label="{{ $option['label'] }}"
                                            class="stock-option-btn w-12 h-12 rounded-full border-2 {{ $option['in_stock'] ? 'border-neutral-700 hover:border-yellow-400' : 'border-neutral-800 cursor-not-allowed opacity-50' }} transition-all duration-300 relative"
                                            style="background-color: {{ $option['value'] ?? '#ccc' }}"
                                            title="{{ $option['label'] }}"
                                            {{ !$option['in_stock'] ? 'disabled' : '' }}>
                                        @if(!$option['in_stock'])
                                            <span class="absolute inset-0 flex items-center justify-center">
                                                <span class="w-10 h-0.5 bg-red-500 rotate-45"></span>
                                            </span>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        @endif

                        <p id="option-error" class="text-red-400 text-sm mt-2 hidden">
                            Please select an option
                        </p>
                    </div>
                    @endif
                @endif

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
                        @if($product->usesDynamicStock() && $product->stockType->display_type !== 'none')
                            Please select an option first
                        @else
                            {{ $product->total_stock }} items available
                        @endif
                    </p>
                </div>

                <!-- Add to Cart Button -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" id="add-to-cart-form" class="pt-4">
                    @csrf
                    <input type="hidden" name="quantity" id="cart-quantity" value="1">
                    <input type="hidden" name="stock_option_id" id="selected-option-id" value="">
                    
                    <button type="submit"
                            {{ $product->total_stock == 0 ? 'disabled' : '' }}
                            class="w-full flex items-center justify-center gap-3 {{ $product->total_stock > 0 ? 'bg-yellow-400 hover:bg-yellow-500' : 'bg-gray-700 cursor-not-allowed' }} text-black font-semibold py-4 px-8 rounded-lg transition-colors duration-300 text-lg group">
                        <x-heroicon-o-shopping-cart class="w-6 h-6 group-hover:scale-110 transition-transform" />
                        {{ $product->total_stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
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
const usesDynamicStock = {{ $product->usesDynamicStock() ? 'true' : 'false' }};
const displayType = '{{ $product->usesDynamicStock() ? $product->stockType->display_type : 'none' }}';
let selectedOptionId = null;
let selectedStock = 0;
let selectedLabel = '';

// For "One Size" products with dynamic stock
@if($product->usesDynamicStock() && $product->stockType->display_type === 'none')
    selectedOptionId = {{ $stockOptions->first()['id'] ?? 'null' }};
    selectedStock = {{ $stockOptions->first()['quantity'] ?? 0 }};
    selectedLabel = '{{ $stockOptions->first()['label'] ?? '' }}';
    document.getElementById('selected-option-id').value = selectedOptionId;
    document.getElementById('quantity').max = selectedStock;
@endif

function decreaseQty() {
    const input = document.getElementById('quantity');
    const cartInput = document.getElementById('cart-quantity');
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        cartInput.value = input.value;
    }
}

function increaseQty() {
    const input = document.getElementById('quantity');
    const cartInput = document.getElementById('cart-quantity');
    const max = parseInt(input.max);
    
    if (usesDynamicStock && displayType !== 'none' && !selectedOptionId) {
        alert('Please select an option first');
        return;
    }
    
    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
        cartInput.value = input.value;
    }
}

document.getElementById('quantity').addEventListener('change', function() {
    const max = parseInt(this.max);
    if (parseInt(this.value) > max) this.value = max;
    if (parseInt(this.value) < 1) this.value = 1;
    document.getElementById('cart-quantity').value = this.value;
});

// Handle option selection (buttons)
if (displayType === 'grid' || displayType === 'color-swatch') {
    document.querySelectorAll('.stock-option-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.disabled) return;

            document.querySelectorAll('.stock-option-btn').forEach(b => {
                b.classList.remove('bg-yellow-400', 'text-black', 'border-yellow-400', 'ring-2', 'ring-yellow-400');
            });
            
            this.classList.add('bg-yellow-400', 'text-black', 'border-yellow-400');

            selectedOptionId = this.dataset.optionId;
            selectedStock = parseInt(this.dataset.stock);
            selectedLabel = this.dataset.label;

            document.getElementById('selected-option-id').value = selectedOptionId;

            const quantityInput = document.getElementById('quantity');
            quantityInput.max = selectedStock;
            
            if (parseInt(quantityInput.value) > selectedStock) {
                quantityInput.value = 1;
                document.getElementById('cart-quantity').value = 1;
            }

            const stockInfo = document.getElementById('stock-info');
            stockInfo.textContent = `${selectedStock} items available (${selectedLabel})`;
            stockInfo.classList.remove('text-red-400');
            stockInfo.classList.add('text-gray-500');

            document.getElementById('option-error').classList.add('hidden');
        });
    });
}

// Handle dropdown selection
if (displayType === 'dropdown') {
    document.getElementById('stock-option-select').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (!selectedOption.value) return;

        selectedOptionId = selectedOption.value;
        selectedStock = parseInt(selectedOption.dataset.stock);
        selectedLabel = selectedOption.dataset.label;

        document.getElementById('selected-option-id').value = selectedOptionId;

        const quantityInput = document.getElementById('quantity');
        quantityInput.max = selectedStock;
        
        if (parseInt(quantityInput.value) > selectedStock) {
            quantityInput.value = 1;
            document.getElementById('cart-quantity').value = 1;
        }

        const stockInfo = document.getElementById('stock-info');
        stockInfo.textContent = `${selectedStock} items available (${selectedLabel})`;

        document.getElementById('option-error').classList.add('hidden');
    });
}

// Form submission validation
document.getElementById('add-to-cart-form').addEventListener('submit', function(e) {
    if (usesDynamicStock && displayType !== 'none') {
        if (!selectedOptionId) {
            e.preventDefault();
            document.getElementById('option-error').classList.remove('hidden');
            return false;
        }

        if (selectedStock === 0) {
            e.preventDefault();
            alert('This option is out of stock. Please select another option.');
            return false;
        }
    }
});
</script>
@endsection