@extends('layouts.app')

@section('title', 'Checkout — HoodLuxe')

@section('content')

<!-- Error Messages -->
@if ($errors->any())
    <div class="fixed top-24 right-6 z-50 border-2 p-6 rounded-2xl shadow-lg max-w-md animate-fade-in"
         style="background: color-mix(in srgb, #ef4444 10%, transparent); border-color: #ef4444; color: var(--text-color);">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 flex-shrink-0 mt-0.5" style="color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1">
                <h3 class="font-semibold mb-2">Please fix the following errors:</h3>
                <ul class="list-disc pl-5 space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="fixed top-24 right-6 z-50 border-2 p-6 rounded-2xl shadow-lg max-w-md animate-fade-in"
         style="background: color-mix(in srgb, #ef4444 10%, transparent); border-color: #ef4444; color: var(--text-color);">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 flex-shrink-0" style="color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="flex-1">{{ session('error') }}</p>
        </div>
    </div>
@endif

@if(session('success'))
    <div class="fixed top-24 right-6 z-50 border-2 p-6 rounded-2xl shadow-lg max-w-md animate-fade-in"
         style="background: color-mix(in srgb, #10b981 10%, transparent); border-color: #10b981; color: var(--text-color);">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 flex-shrink-0" style="color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="flex-1">{{ session('success') }}</p>
        </div>
    </div>
@endif

<!-- Hero Section -->
<section class="relative pt-32 pb-16 px-6" style="background: linear-gradient(to bottom, color-mix(in srgb, var(--background-color) 95%, var(--primary-color)), var(--background-color));">
    <div class="max-w-7xl mx-auto text-center space-y-4 fade-in">
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-extralight leading-tight tracking-tight" style="color: var(--text-color);">
            Checkout
        </h1>
        <p class="text-lg md:text-xl font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
            Complete your order securely
        </p>
    </div>
</section>

<!-- Main Checkout Section -->
<section class="py-16 px-6" style="background: var(--background-color);">
    <div class="max-w-7xl mx-auto">

        <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            <!-- Left Column: Forms -->
            <div class="lg:col-span-2 space-y-8 fade-in">
                
                <!-- Personal Information -->
                <div class="border-2 rounded-2xl p-8" style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent);">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                            <svg class="w-5 h-5" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-light tracking-tight" style="color: var(--text-color);">Personal Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-color);">First Name *</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                class="w-full px-4 py-3 border-2 rounded-full font-light focus:outline-none transition-all duration-300"
                                style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent); color: var(--text-color);"
                                onfocus="this.style.borderColor='var(--primary-color)'"
                                onblur="this.style.borderColor='color-mix(in srgb, var(--primary-color) 20%, transparent)'" />
                            @error('first_name') 
                                <p class="text-sm mt-2" style="color: #ef4444;">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-color);">Last Name *</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                class="w-full px-4 py-3 border-2 rounded-full font-light focus:outline-none transition-all duration-300"
                                style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent); color: var(--text-color);"
                                onfocus="this.style.borderColor='var(--primary-color)'"
                                onblur="this.style.borderColor='color-mix(in srgb, var(--primary-color) 20%, transparent)'" />
                            @error('last_name') 
                                <p class="text-sm mt-2" style="color: #ef4444;">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-color);">Phone Number *</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" maxlength="10" required
                                placeholder="0555123456"
                                class="w-full px-4 py-3 border-2 rounded-full font-light focus:outline-none transition-all duration-300"
                                style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent); color: var(--text-color);"
                                onfocus="this.style.borderColor='var(--primary-color)'"
                                onblur="this.style.borderColor='color-mix(in srgb, var(--primary-color) 20%, transparent)'" />
                            @error('phone') 
                                <p class="text-sm mt-2" style="color: #ef4444;">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-color);">Email Address *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                placeholder="your@email.com"
                                class="w-full px-4 py-3 border-2 rounded-full font-light focus:outline-none transition-all duration-300"
                                style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent); color: var(--text-color);"
                                onfocus="this.style.borderColor='var(--primary-color)'"
                                onblur="this.style.borderColor='color-mix(in srgb, var(--primary-color) 20%, transparent)'" />
                            @error('email') 
                                <p class="text-sm mt-2" style="color: #ef4444;">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="border-2 rounded-2xl p-8" style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent);">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                            <svg class="w-5 h-5" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-light tracking-tight" style="color: var(--text-color);">Shipping Address</h2>
                    </div>

                    <div class="space-y-6">
                        <!-- Wilaya Select -->
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-color);">Wilaya *</label>
                            <select id="wilaya-select" name="wilaya" required
                                class="w-full px-4 py-3 border-2 rounded-full font-light focus:outline-none transition-all duration-300 appearance-none cursor-pointer"
                                style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent); color: var(--text-color);"
                                onfocus="this.style.borderColor='var(--primary-color)'"
                                onblur="this.style.borderColor='color-mix(in srgb, var(--primary-color) 20%, transparent)'">
                                <option value="" data-cost="0" data-wilaya-id="">Select Wilaya</option>
                                @foreach($wilayas as $wilaya)
                                    <option value="{{ $wilaya->name }}" 
                                            data-cost="{{ $wilaya->shipping_cost }}"
                                            data-wilaya-id="{{ $wilaya->id }}"
                                            {{ old('wilaya') == $wilaya->name ? 'selected' : '' }}>
                                        {{ $wilaya->name }} — {{ number_format($wilaya->shipping_cost, 0) }} DA
                                    </option>
                                @endforeach
                            </select>
                            @error('wilaya') 
                                <p class="text-sm mt-2" style="color: #ef4444;">{{ $message }}</p> 
                            @enderror
                        </div>

                        <!-- Commune Select -->
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-color);">Commune *</label>
                            <select id="commune-select" name="commune" required
                                class="w-full px-4 py-3 border-2 rounded-full font-light focus:outline-none transition-all duration-300 appearance-none cursor-pointer"
                                style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent); color: var(--text-color);"
                                onfocus="this.style.borderColor='var(--primary-color)'"
                                onblur="this.style.borderColor='color-mix(in srgb, var(--primary-color) 20%, transparent)'">
                                <option value="">Select a wilaya first</option>
                                @foreach($communes as $commune)
                                    <option value="{{ $commune->name }}" 
                                            data-wilaya-id="{{ $commune->wilaya_id }}"
                                            style="display: none;"
                                            {{ old('commune') == $commune->name ? 'selected' : '' }}>
                                        {{ $commune->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('commune') 
                                <p class="text-sm mt-2" style="color: #ef4444;">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-color);">Street Address *</label>
                            <input type="text" name="address" value="{{ old('address') }}" required
                                placeholder="Street, building, apartment number"
                                class="w-full px-4 py-3 border-2 rounded-full font-light focus:outline-none transition-all duration-300"
                                style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent); color: var(--text-color);"
                                onfocus="this.style.borderColor='var(--primary-color)'"
                                onblur="this.style.borderColor='color-mix(in srgb, var(--primary-color) 20%, transparent)'" />
                            @error('address') 
                                <p class="text-sm mt-2" style="color: #ef4444;">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-color);">Additional Notes (Optional)</label>
                            <textarea name="notes" rows="4"
                                placeholder="Any special delivery instructions..."
                                class="w-full px-4 py-3 border-2 rounded-2xl font-light focus:outline-none transition-all duration-300 resize-none"
                                style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent); color: var(--text-color);"
                                onfocus="this.style.borderColor='var(--primary-color)'"
                                onblur="this.style.borderColor='color-mix(in srgb, var(--primary-color) 20%, transparent)'">{{ old('notes') }}</textarea>
                            @error('notes') 
                                <p class="text-sm mt-2" style="color: #ef4444;">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:col-span-1 fade-in">
                <div class="border-2 rounded-2xl p-6 sticky top-24" style="background: color-mix(in srgb, var(--primary-color) 5%, transparent); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent);">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center border-2" style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent);">
                            <svg class="w-5 h-5" style="color: var(--text-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-medium" style="color: var(--text-color);">Order Summary</h2>
                    </div>

                    @php 
                        $cart = session('cart', []);
                        $subtotal = 0;
                    @endphp

                    @if(empty($cart))
                        <div class="text-center py-12">
                            <div class="w-16 h-16 mx-auto rounded-full flex items-center justify-center mb-4" style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                                <svg class="w-8 h-8" style="color: color-mix(in srgb, var(--text-color) 40%, transparent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <p class="mb-4 font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Your cart is empty</p>
                            <a href="{{ route('products.index') }}" 
                               class="inline-block font-medium transition-colors duration-300"
                               style="color: var(--primary-color);"
                               onmouseover="this.style.color='var(--secondary-color)'"
                               onmouseout="this.style.color='var(--primary-color)'">
                                Continue Shopping →
                            </a>
                        </div>
                    @else
                        <!-- Cart Items -->
                        <div class="space-y-4 mb-6 max-h-80 overflow-y-auto">
                            @foreach($cart as $cartKey => $item)
                                @php 
                                    $itemPrice = isset($item['price']) ? floatval($item['price']) : 0;
                                    $itemQuantity = isset($item['quantity']) ? intval($item['quantity']) : 0;
                                    $lineTotal = $itemPrice * $itemQuantity;
                                    $subtotal += $lineTotal;
                                    
                                    $product = \App\Models\Product::find($item['product_id']);
                                    $imageSrc = $product && $product->primary_image_url ? $product->primary_image_url : null;
                                @endphp
                                <div class="flex gap-3 pb-4 border-b last:border-0" style="border-color: color-mix(in srgb, var(--primary-color) 20%, transparent);">
                                    <div class="w-20 h-20 flex-shrink-0 overflow-hidden rounded-xl" style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                                        @if($imageSrc)
                                            <img src="{{ $imageSrc }}" 
                                                 alt="{{ $item['name'] ?? 'Product' }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center" style="color: color-mix(in srgb, var(--text-color) 40%, transparent);">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium mb-1 truncate" style="color: var(--text-color);">
                                            {{ $item['name'] ?? 'Product' }}
                                        </h4>
                                        @if(!empty($item['stock_label']))
                                            <p class="text-xs mb-1" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
                                                Size: <span class="font-medium">{{ $item['stock_label'] }}</span>
                                            </p>
                                        @endif
                                        <p class="text-xs mb-2" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Quantity: {{ $itemQuantity }}</p>
                                        <p class="text-sm font-semibold" style="color: var(--text-color);">
                                            {{ number_format($lineTotal, 0) }} DA
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Price Summary -->
                        @php
                            $discountAmount = session('discount.amount', 0);
                            $shippingCost = isset($shipping_cost) ? floatval($shipping_cost) : 0;
                            $totalBeforeShipping = $subtotal - $discountAmount;
                            $finalTotal = $totalBeforeShipping + $shippingCost;
                        @endphp

                        <div class="space-y-3 mb-6 pb-6 border-b" style="border-color: color-mix(in srgb, var(--primary-color) 20%, transparent);">
                            <div class="flex justify-between font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
                                <span>Subtotal</span>
                                <span id="subtotal-value" data-subtotal="{{ $subtotal }}" class="font-medium" style="color: var(--text-color);">
                                    {{ number_format($subtotal, 0) }} DA
                                </span>
                            </div>

                            @if($discountAmount > 0)
                                <div class="flex justify-between" style="color: #10b981;">
                                    <span class="font-light">Discount</span>
                                    <span class="font-medium">-{{ number_format($discountAmount, 0) }} DA</span>
                                </div>
                            @endif

                            <div class="flex justify-between font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
                                <span>Shipping</span>
                                <span id="shipping-value" class="font-medium" style="color: var(--text-color);">
                                    {{ $shippingCost > 0 ? number_format($shippingCost, 0) . ' DA' : 'Select wilaya' }}
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <span class="text-lg font-light" style="color: var(--text-color);">Total</span>
                            <span id="total-value" class="text-2xl font-semibold" style="color: var(--text-color);" data-discount="{{ $discountAmount }}">
                                {{ number_format($finalTotal, 0) }} DA
                            </span>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" 
                                class="btn-primary w-full py-4 rounded-full font-medium text-base transition-all duration-300 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Place Order
                        </button>

                        <p class="text-xs text-center mt-4 font-light" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">
                            By placing your order, you agree to our terms and conditions
                        </p>
                    @endif
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Security Section -->
<section class="py-16 px-6" style="background: color-mix(in srgb, var(--primary-color) 3%, transparent);">
    <div class="max-w-4xl mx-auto text-center fade-in">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="space-y-3">
                <div class="w-12 h-12 mx-auto border-2 rounded-full flex items-center justify-center" style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent);">
                    <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="font-medium" style="color: var(--text-color);">Secure Checkout</h3>
                <p class="text-sm font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Your information is protected</p>
            </div>

            <div class="space-y-3">
                <div class="w-12 h-12 mx-auto border-2 rounded-full flex items-center justify-center" style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent);">
                    <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <h3 class="font-medium" style="color: var(--text-color);">Fast Delivery</h3>
                <p class="text-sm font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Quick shipping nationwide</p>
            </div>

            <div class="space-y-3">
                <div class="w-12 h-12 mx-auto border-2 rounded-full flex items-center justify-center" style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent);">
                    <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="font-medium" style="color: var(--text-color);">Support</h3>
                <p class="text-sm font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">We're here to help</p>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const wilayaSelect = document.getElementById('wilaya-select');
    const communeSelect = document.getElementById('commune-select');
    const allCommuneOptions = Array.from(communeSelect.querySelectorAll('option[data-wilaya-id]'));
    
    // Function to filter communes based on selected wilaya
    function filterCommunes() {
        const selectedOption = wilayaSelect.options[wilayaSelect.selectedIndex];
        const selectedWilayaId = selectedOption.getAttribute('data-wilaya-id');
        
        // Hide all commune options first
        allCommuneOptions.forEach(option => {
            option.style.display = 'none';
            option.disabled = true;
        });
        
        // Reset commune selection
        const currentValue = communeSelect.value;
        communeSelect.value = '';
        
        if (selectedWilayaId) {
            // Show only communes for selected wilaya
            let hasVisibleOptions = false;
            allCommuneOptions.forEach(option => {
                if (option.getAttribute('data-wilaya-id') === selectedWilayaId) {
                    option.style.display = 'block';
                    option.disabled = false;
                    hasVisibleOptions = true;
                    
                    // Restore previous selection if it matches
                    if (option.value === currentValue) {
                        communeSelect.value = currentValue;
                    }
                }
            });
            
            communeSelect.options[0].textContent = hasVisibleOptions ? 'Select Commune' : 'No communes available';
        } else {
            communeSelect.options[0].textContent = 'Select a wilaya first';
        }
        
        // Update shipping cost
        updateShippingCost();
    }
    
    // Function to update shipping cost and total
    function updateShippingCost() {
        const shippingCost = parseFloat(wilayaSelect.options[wilayaSelect.selectedIndex].dataset.cost) || 0;
        const subtotal = parseFloat(document.getElementById('subtotal-value').dataset.subtotal) || 0;
        const discountAmount = parseFloat(document.getElementById('total-value').dataset.discount) || 0;
        const total = subtotal - discountAmount + shippingCost;
        
        // Update shipping display
        document.getElementById('shipping-value').textContent = shippingCost > 0 
            ? shippingCost.toLocaleString() + ' DA' 
            : 'Free';
        
        // Update total
        document.getElementById('total-value').textContent = total.toLocaleString() + ' DA';
    }
    
    // Event listener for wilaya change
    wilayaSelect.addEventListener('change', filterCommunes);
    
    // Trigger on page load if wilaya is pre-selected (from old input)
    if (wilayaSelect.value) {
        filterCommunes();
    }
});
</script>

<style>
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
    animation: fade-in 0.3s ease-out;
}

/* Custom select arrow with theme color */
select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1.25rem;
    padding-right: 3rem;
}
</style>

@endsection