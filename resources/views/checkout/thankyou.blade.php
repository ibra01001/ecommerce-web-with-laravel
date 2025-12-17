@extends('layouts.app')

@section('title', 'Order Confirmed — HoodLuxe')

@section('content')

<!-- Hero Section -->
<section class="relative pt-32 pb-16 px-6" 
         style="background: linear-gradient(to bottom, color-mix(in srgb, var(--primary-color) 5%, var(--background-color)), var(--background-color));">
    <div class="max-w-4xl mx-auto text-center space-y-8 fade-in">
        <!-- Success Icon -->
        <div class="inline-flex items-center justify-center w-24 h-24 border-2 rounded-full mb-4"
             style="background: color-mix(in srgb, var(--primary-color) 10%, transparent); border-color: color-mix(in srgb, var(--primary-color) 30%, transparent);">
            <svg class="w-12 h-12" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        
        <div class="space-y-4">
            <h1 class="text-5xl md:text-6xl font-extralight leading-tight tracking-tight"
                style="color: var(--text-color);">
                Order Confirmed
            </h1>
            <p class="text-xl font-light"
               style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                Thank you for your purchase!
            </p>
        </div>

        <!-- Order Number Badge -->
        <div class="inline-block text-white px-8 py-4 rounded-full"
             style="background: var(--primary-color);">
            <p class="text-sm font-light mb-1">Order Number</p>
            <p class="text-2xl font-semibold tracking-wide">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>
    </div>
</section>

<!-- Order Details Section -->
<section class="py-16 px-6" style="background: var(--background-color);">
    <div class="max-w-5xl mx-auto space-y-8">

        <!-- Order Status -->
        <div class="border-2 rounded-2xl p-8 fade-in"
             style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 20%, transparent);">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center"
                         style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                        <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-light" style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">Order Status</p>
                        <p class="text-lg font-medium" style="color: var(--text-color);">{{ ucfirst($order->status) }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-sm font-light" style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">Order Date</p>
                    <p class="text-lg font-medium" style="color: var(--text-color);">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Ordered Items -->
        <div class="border-2 rounded-2xl p-8 fade-in"
             style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 20%, transparent);">
            <h2 class="text-2xl font-light tracking-tight mb-6" style="color: var(--text-color);">Order Items</h2>
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                    @php
                        $product = \App\Models\Product::find($item->product_id);
                        $imageSrc = $product && $product->primary_image_url ? $product->primary_image_url : null;
                    @endphp
                    <div class="flex items-center gap-6 pb-6 last:border-0 last:pb-0"
                         style="border-bottom: 1px solid color-mix(in srgb, var(--text-color) 20%, transparent);">
                        <div class="w-24 h-24 flex-shrink-0 overflow-hidden rounded-xl"
                             style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                            @if($imageSrc)
                                <img src="{{ $imageSrc }}" 
                                     alt="{{ $item->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center"
                                     style="color: color-mix(in srgb, var(--text-color) 40%, transparent);">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-medium mb-1" style="color: var(--text-color);">{{ $item->name }}</h4>
                            @if($item->taille_type)
                                <p class="text-sm font-light mb-1" style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                                    Size: <span class="font-medium" style="color: var(--text-color);">{{ $item->taille_type }}</span>
                                </p>
                            @endif
                            <p class="text-sm font-light" style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                                Quantity: <span class="font-medium" style="color: var(--text-color);">{{ $item->quantity }}</span>
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold" style="color: var(--primary-color);">{{ number_format($item->price, 0) }} DA</p>
                            <p class="text-sm font-light" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">each</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary & Shipping Info Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Order Summary -->
            <div class="border-2 rounded-2xl p-8 fade-in"
                 style="background: color-mix(in srgb, var(--primary-color) 3%, var(--background-color)); border-color: color-mix(in srgb, var(--text-color) 20%, transparent);">
                <h3 class="text-xl font-medium mb-6" style="color: var(--text-color);">Order Summary</h3>
                <div class="space-y-4">
                    <div class="flex justify-between font-light" style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                        <span>Subtotal</span>
                        <span class="font-medium" style="color: var(--text-color);">{{ number_format($order->subtotal, 0) }} DA</span>
                    </div>
                    
                    @if($order->discount_amount > 0)
                        <div class="flex justify-between" style="color: var(--secondary-color);">
                            <span class="font-light flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                </svg>
                                Discount @if($order->coupon_code)({{ $order->coupon_code }})@endif
                            </span>
                            <span class="font-medium">-{{ number_format($order->discount_amount, 0) }} DA</span>
                        </div>
                    @endif
                    
                    <div class="flex justify-between font-light" style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                        <span>Shipping</span>
                        <span class="font-medium" style="color: var(--text-color);">{{ number_format($order->shipping_cost, 0) }} DA</span>
                    </div>
                    
                    <div class="border-t-2 pt-4" style="border-color: color-mix(in srgb, var(--text-color) 20%, transparent);">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-light" style="color: var(--text-color);">Total</span>
                            <span class="text-2xl font-semibold" style="color: var(--text-color);">{{ number_format($order->total, 0) }} DA</span>
                        </div>
                    </div>
                    
                    @if($order->discount_amount > 0)
                        <div class="border-2 rounded-xl p-4 mt-4"
                             style="background: color-mix(in srgb, var(--secondary-color) 10%, transparent); border-color: color-mix(in srgb, var(--secondary-color) 30%, transparent);">
                            <p class="text-sm font-medium text-center flex items-center justify-center gap-2"
                               style="color: var(--secondary-color);">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                You saved {{ number_format($order->discount_amount, 0) }} DA on this order!
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="border-2 rounded-2xl p-8 fade-in"
                 style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 20%, transparent);">
                <h3 class="text-xl font-medium mb-6" style="color: var(--text-color);">Shipping Information</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-xs uppercase tracking-wider font-medium mb-1" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Full Name</p>
                        <p class="font-medium" style="color: var(--text-color);">{{ $order->first_name }} {{ $order->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider font-medium mb-1" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Phone Number</p>
                        <p class="font-medium" style="color: var(--text-color);">{{ $order->phone }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider font-medium mb-1" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Email Address</p>
                        <p class="font-medium" style="color: var(--text-color);">{{ $order->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider font-medium mb-1" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Location</p>
                        <p class="font-medium" style="color: var(--text-color);">{{ $order->commune }}, {{ $order->wilaya }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wider font-medium mb-1" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Street Address</p>
                        <p class="font-medium" style="color: var(--text-color);">{{ $order->address }}</p>
                    </div>
                    @if($order->notes)
                        <div>
                            <p class="text-xs uppercase tracking-wider font-medium mb-1" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Additional Notes</p>
                            <p class="font-medium" style="color: var(--text-color);">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- What's Next Section -->
        <div class="border-2 rounded-2xl p-8 fade-in"
             style="background: color-mix(in srgb, var(--primary-color) 3%, var(--background-color)); border-color: color-mix(in srgb, var(--text-color) 20%, transparent);">
            <h3 class="text-2xl font-light tracking-tight mb-8" style="color: var(--text-color);">What Happens Next?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center space-y-3">
                    <div class="w-16 h-16 mx-auto text-white rounded-full flex items-center justify-center text-2xl font-semibold"
                         style="background: var(--primary-color);">
                        1
                    </div>
                    <h4 class="font-medium" style="color: var(--text-color);">Order Confirmation</h4>
                    <p class="text-sm font-light" style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">You'll receive a confirmation email shortly</p>
                </div>
                <div class="text-center space-y-3">
                    <div class="w-16 h-16 mx-auto text-white rounded-full flex items-center justify-center text-2xl font-semibold"
                         style="background: var(--primary-color);">
                        2
                    </div>
                    <h4 class="font-medium" style="color: var(--text-color);">Order Processing</h4>
                    <p class="text-sm font-light" style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">We'll prepare your items for shipping</p>
                </div>
                <div class="text-center space-y-3">
                    <div class="w-16 h-16 mx-auto text-white rounded-full flex items-center justify-center text-2xl font-semibold"
                         style="background: var(--primary-color);">
                        3
                    </div>
                    <h4 class="font-medium" style="color: var(--text-color);">Delivery</h4>
                    <p class="text-sm font-light" style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">Track your order until it reaches you</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8 fade-in">
            <a href="{{ route('products.index') }}" 
               class="inline-block text-white px-10 py-4 rounded-full font-medium text-base text-center transition-all duration-300"
               style="background: var(--primary-color);"
               onmouseover="this.style.background='var(--secondary-color)'"
               onmouseout="this.style.background='var(--primary-color)'">
                Continue Shopping
            </a>
            @auth
               
            @endauth
        </div>
    </div>
</section>

<!-- Support Section -->
<section class="py-24 px-6" style="background: color-mix(in srgb, var(--primary-color) 3%, var(--background-color));">
    <div class="max-w-4xl mx-auto text-center space-y-8 fade-in">
        <div class="space-y-6">
            <h2 class="text-3xl md:text-4xl font-light tracking-tight" style="color: var(--text-color);">
                Need Assistance?
            </h2>
            <p class="text-lg font-light leading-relaxed max-w-2xl mx-auto"
               style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                Our customer support team is ready to help you with any questions about your order
            </p>
        </div>
        <div class="pt-4">
            <a href="{{ url('/contact') }}" 
               class="inline-block px-10 py-4 border-2 font-medium rounded-full transition-all duration-300 text-base"
               style="border-color: color-mix(in srgb, var(--text-color) 20%, transparent); color: var(--text-color);"
               onmouseover="this.style.borderColor='var(--primary-color)'; this.style.background='color-mix(in srgb, var(--primary-color) 5%, transparent)'"
               onmouseout="this.style.borderColor='color-mix(in srgb, var(--text-color) 20%, transparent)'; this.style.background='transparent'">
                Contact Support
            </a>
        </div>
    </div>
</section>

@endsection