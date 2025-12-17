<div>
    <!-- Hero Section -->
    <section class="relative pt-20 sm:pt-32 pb-12 sm:pb-16 px-4 sm:px-6" 
             style="background: linear-gradient(to bottom, color-mix(in srgb, var(--primary-color) 5%, var(--background-color)), var(--background-color));">
        <div class="max-w-7xl mx-auto text-center space-y-3 sm:space-y-4 fade-in">
            <h1 class="text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-extralight leading-tight tracking-tight"
                style="color: var(--text-color);">
                Your Cart
            </h1>
            <p class="text-base sm:text-lg md:text-xl font-light"
               style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                Review your selected items
            </p>
        </div>
    </section>

    <!-- Cart Section -->
    <section class="py-8 sm:py-16 px-4 sm:px-6" style="background: var(--background-color);">
        <div class="max-w-7xl mx-auto">

            @if(count($cart) > 0)

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">

                    <!-- Cart Items -->
                    <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                        @foreach($cart as $id => $item)
                            <div class="rounded-xl sm:rounded-2xl p-4 sm:p-6 border-2 transition-all duration-300"
                                 style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 10%, transparent);"
                                 onmouseover="this.style.borderColor='var(--primary-color)'"
                                 onmouseout="this.style.borderColor='color-mix(in srgb, var(--text-color) 10%, transparent)'"
                                 wire:key="cart-item-{{ $id }}">

                                <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">
                                    <!-- Product Image -->
                                    <div class="w-full sm:w-28 md:w-64 h-64 flex-shrink-0 overflow-hidden rounded-xl"
                                         style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                                        @php
                                            $imageSrc = null;
                                            $product = \App\Models\Product::find($item['product_id']);
                                            
                                            if ($product && $product->primary_image_url) {
                                                $imageSrc = $product->primary_image_url;
                                            } elseif (isset($item['image']) && !empty($item['image'])) {
                                                if (str_starts_with($item['image'], 'http')) {
                                                    $imageSrc = $item['image'];
                                                } else {
                                                    $imageSrc = asset('storage/' . $item['image']);
                                                }
                                            }
                                        @endphp
                                        
                                        @if($imageSrc)
                                            <img src="{{ $imageSrc }}" 
                                                 alt="{{ $item['name'] }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center"
                                                 style="color: color-mix(in srgb, var(--text-color) 40%, transparent);">
                                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info & Controls -->
                                    <div class="flex-1 flex flex-col justify-between space-y-3">
                                        <div>
                                            <h3 class="text-lg sm:text-xl font-medium" style="color: var(--text-color);">{{ $item['name'] }}</h3>
                                            <p class="text-base sm:text-lg font-medium mt-1" style="color: var(--primary-color);">
                                                {{ number_format($item['price'], 0) }} DA
                                            </p>
                                        </div>

                                        <!-- Size Badge & Remove Button -->
                                        <div class="flex flex-wrap items-center gap-3">
                                            @if(isset($item['stock_label']))
                                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium border"
                                                      style="background: color-mix(in srgb, var(--primary-color) 10%, transparent); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent); color: var(--text-color);">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                    </svg>
                                                    Size: {{ $item['stock_label'] }}
                                                </span>
                                            @endif
                                            
                                            <button wire:click="removeItem('{{ $id }}')" 
                                                    class="text-sm font-medium transition-colors duration-300"
                                                    style="color: color-mix(in srgb, var(--text-color) 60%, transparent);"
                                                    onmouseover="this.style.color='#dc2626'"
                                                    onmouseout="this.style.color='color-mix(in srgb, var(--text-color) 60%, transparent)'">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Quantity Controls -->
                                    <div class="flex sm:items-center justify-center sm:justify-end">
                                        <div class="flex items-center gap-2">
                                            <button wire:click="decreaseQuantity('{{ $id }}')" 
                                                    class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full transition-all duration-300"
                                                    style="background: color-mix(in srgb, var(--primary-color) 10%, transparent); color: var(--text-color);"
                                                    onmouseover="this.style.background='var(--primary-color)'; this.style.color='white'"
                                                    onmouseout="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'; this.style.color='var(--text-color)'">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                                </svg>
                                            </button>
                                            
                                            <input type="number" 
                                                   wire:change="updateQuantity('{{ $id }}', $event.target.value)"
                                                   value="{{ $item['quantity'] }}"
                                                   min="1" 
                                                   class="w-14 sm:w-16 text-center rounded-full font-medium border-2 transition-all duration-300 text-sm sm:text-base"
                                                   style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 20%, transparent); color: var(--text-color);"
                                                   onfocus="this.style.borderColor='var(--primary-color)'"
                                                   onblur="this.style.borderColor='color-mix(in srgb, var(--text-color) 20%, transparent)'">
                                            
                                            <button wire:click="increaseQuantity('{{ $id }}')" 
                                                    class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center rounded-full transition-all duration-300"
                                                    style="background: color-mix(in srgb, var(--primary-color) 10%, transparent); color: var(--text-color);"
                                                    onmouseover="this.style.background='var(--primary-color)'; this.style.color='white'"
                                                    onmouseout="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'; this.style.color='var(--text-color)'">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-4 sm:space-y-6">
                        
                        <!-- Shipping Wilaya Selector -->
                        <div class="rounded-xl sm:rounded-2xl p-4 sm:p-6 border-2"
                             style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 10%, transparent);">
                            <h3 class="text-base sm:text-lg font-medium mb-4 flex items-center gap-2" style="color: var(--text-color);">
                                <svg class="w-5 h-5" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Shipping Location
                            </h3>
                            
                            <select wire:model.live="wilaya_id" 
                                    class="w-full px-4 py-3 rounded-lg border-2 transition-all duration-300"
                                    style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 20%, transparent); color: var(--text-color);"
                                    onfocus="this.style.borderColor='var(--primary-color)'"
                                    onblur="this.style.borderColor='color-mix(in srgb, var(--text-color) 20%, transparent)'">
                                <option value="">Select your wilaya</option>
                                @foreach($wilayas as $wilaya)
                                    <option value="{{ $wilaya->id }}">
                                        {{ $wilaya->code }} - {{ $wilaya->name }} ({{ number_format($wilaya->shipping_cost, 0) }} DA)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Discount Code Section -->
                        <div class="rounded-xl sm:rounded-2xl p-4 sm:p-6 border-2"
                             style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 10%, transparent);">
                            <h3 class="text-base sm:text-lg font-medium mb-4 flex items-center gap-2" style="color: var(--text-color);">
                                <svg class="w-5 h-5" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                </svg>
                                Discount Code
                            </h3>

                            @if($discountCode)
                                <!-- Applied Discount -->
                                <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-green-800 font-semibold text-sm sm:text-base">
                                                Code: {{ $discountCode }}
                                            </p>
                                            <p class="text-green-600 text-sm mt-1">
                                                -{{ number_format($discountAmount, 0) }} DA
                                            </p>
                                        </div>
                                        <button wire:click="removeDiscount" 
                                                class="text-red-600 hover:text-red-700 transition-colors duration-300">
                                            <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            @else
                                <!-- Discount Input Form -->
                                <form wire:submit.prevent="applyDiscount" class="flex flex-col sm:flex-row gap-2">
                                    <input type="text" 
                                           wire:model="discountInput"
                                           placeholder="Enter code"
                                           class="flex-1 rounded-full px-4 py-2.5 sm:py-3 font-light text-sm sm:text-base uppercase border-2 transition-all duration-300"
                                           style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 20%, transparent); color: var(--text-color);"
                                           onfocus="this.style.borderColor='var(--primary-color)'"
                                           onblur="this.style.borderColor='color-mix(in srgb, var(--text-color) 20%, transparent)'">
                                    <button type="submit"
                                            class="text-white px-6 py-2.5 sm:py-3 rounded-full font-medium text-sm sm:text-base whitespace-nowrap transition-all duration-300"
                                            style="background: var(--primary-color);"
                                            onmouseover="this.style.background='var(--secondary-color)'"
                                            onmouseout="this.style.background='var(--primary-color)'">
                                        Apply
                                    </button>
                                </form>
                            @endif

                            @if($errorMessage)
                                <div class="mt-4 bg-red-50 border-2 border-red-200 rounded-xl p-3">
                                    <p class="text-red-700 text-sm">{{ $errorMessage }}</p>
                                </div>
                            @endif

                            @if($successMessage)
                                <div class="mt-4 bg-green-50 border-2 border-green-200 rounded-xl p-3">
                                    <p class="text-green-700 text-sm">{{ $successMessage }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Order Summary -->
                        <div class="rounded-xl sm:rounded-2xl p-4 sm:p-6 lg:sticky lg:top-24 border-2"
                             style="background: color-mix(in srgb, var(--primary-color) 3%, var(--background-color)); border-color: color-mix(in srgb, var(--text-color) 10%, transparent);">
                            <h3 class="text-xl sm:text-2xl font-light mb-4 sm:mb-6 tracking-tight" style="color: var(--text-color);">Order Summary</h3>

                            <div class="space-y-3 sm:space-y-4">
                                <div class="flex justify-between font-light text-sm sm:text-base"
                                     style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                                    <span>Subtotal</span>
                                    <span class="font-medium" style="color: var(--text-color);">{{ number_format($this->subtotal, 0) }} DA</span>
                                </div>

                                @if($discountAmount > 0)
                                    <div class="flex justify-between text-green-600 text-sm sm:text-base">
                                        <span class="font-light">Discount</span>
                                        <span class="font-medium">-{{ number_format($discountAmount, 0) }} DA</span>
                                    </div>
                                @endif

                                <div class="flex justify-between font-light text-sm sm:text-base"
                                     style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                                    <span>Shipping</span>
                                    <span class="font-medium" style="color: var(--text-color);">{{ number_format($shipping_cost, 0) }} DA</span>
                                </div>

                                <div class="border-t-2 pt-3 sm:pt-4 flex justify-between text-lg sm:text-xl"
                                     style="border-color: color-mix(in srgb, var(--text-color) 10%, transparent); color: var(--text-color);">
                                    <span class="font-light">Total</span>
                                    <span class="font-semibold">
                                        {{ number_format($total, 0) }} DA
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('checkout.create') }}" 
                               class="block w-full text-white py-3 sm:py-4 rounded-full font-medium text-sm sm:text-base text-center transition-all duration-300 mt-4 sm:mt-6 transform hover:scale-105 shadow-lg hover:shadow-xl"
                               style="background: var(--primary-color);"
                               onmouseover="this.style.background='var(--secondary-color)'"
                               onmouseout="this.style.background='var(--primary-color)'">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>

            @else
                <!-- Empty Cart -->
                <div class="text-center py-16 sm:py-24 space-y-4 sm:space-y-6 fade-in">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto rounded-full flex items-center justify-center"
                         style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl sm:text-3xl font-light mb-2 sm:mb-3 tracking-tight" style="color: var(--text-color);">Your Cart is Empty</h3>
                        <p class="text-base sm:text-lg font-light mb-6 sm:mb-8" style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">Start adding some products to your cart</p>
                        <a href="{{ route('products.index') }}" 
                           class="inline-block text-white px-8 sm:px-10 py-3 sm:py-4 rounded-full font-medium text-sm sm:text-base transition-all duration-300"
                           style="background: var(--primary-color);"
                           onmouseover="this.style.background='var(--secondary-color)'"
                           onmouseout="this.style.background='var(--primary-color)'">
                            Shop Collection
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </section>

    <!-- Bottom CTA Section -->
    <section class="py-16 sm:py-24 px-4 sm:px-6" 
             style="background: color-mix(in srgb, var(--primary-color) 3%, var(--background-color));">
        <div class="max-w-4xl mx-auto text-center space-y-6 sm:space-y-8 fade-in">
            <div class="space-y-4 sm:space-y-6">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-light tracking-tight" style="color: var(--text-color);">
                    Need Help?
                </h2>
                <p class="text-base sm:text-lg font-light leading-relaxed max-w-2xl mx-auto px-4"
                   style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                    Our customer support team is here to assist you with any questions
                </p>
            </div>
            <div class="pt-2 sm:pt-4">
                <a href="{{ url('/contact') }}" 
                   class="inline-block px-8 sm:px-10 py-3 sm:py-4 rounded-full font-medium text-sm sm:text-base border-2 transition-all duration-300"
                   style="border-color: color-mix(in srgb, var(--text-color) 20%, transparent); color: var(--text-color);"
                   onmouseover="this.style.borderColor='var(--primary-color)'; this.style.background='color-mix(in srgb, var(--primary-color) 5%, transparent)'"
                   onmouseout="this.style.borderColor='color-mix(in srgb, var(--text-color) 20%, transparent)'; this.style.background='transparent'">
                    Contact Support
                </a>
            </div>
        </div>
    </section>

    <style>
    /* Prevent zoom on iOS */
    @media screen and (max-width: 768px) {
        input[type="text"],
        input[type="number"],
        select {
            font-size: 16px;
        }
    }

    /* Hide number input arrows on mobile */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }
    </style>
</div>