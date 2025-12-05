@extends('layouts.app')

@section('content')
<section class="pt-24 pb-16 bg-gradient-to-b from-neutral-900 to-black min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Success Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-500 rounded-full mb-4 animate-bounce">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Order Confirmed!</h1>
            <p class="text-xl text-gray-400">Thank you for your purchase</p>
        </div>

        <!-- Order Details Card -->
        <div class="bg-neutral-800 rounded-lg shadow-xl overflow-hidden mb-6">
            <!-- Order Header -->
            <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-black font-medium">Order Number</p>
                        <p class="text-2xl font-bold text-black">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-black font-medium">Order Date</p>
                        <p class="text-lg text-black">{{ $order->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Status -->
            <div class="px-6 py-4 border-b border-neutral-700">
                <div class="flex items-center justify-between">
                    <span class="text-gray-300 font-medium">Status:</span>
                    <span class="px-4 py-2 rounded-full text-sm font-semibold
                        @if($order->status === 'pending') bg-yellow-400 text-black
                        @elseif($order->status === 'processing') bg-blue-500 text-white
                        @elseif($order->status === 'shipped') bg-purple-500 text-white
                        @elseif($order->status === 'delivered') bg-green-500 text-white
                        @else bg-gray-500 text-white
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <!-- Ordered Items -->
            <div class="px-6 py-4 border-b border-neutral-700">
                <h3 class="text-lg font-semibold text-white mb-4">Order Items</h3>
                <div class="space-y-4">
                    @foreach($order->orderItems as $item)
                    <div class="flex items-center space-x-4 bg-neutral-900 p-4 rounded-lg">
                        <img src="{{ asset('storage/' . $item->image) }}" 
                             alt="{{ $item->name }}" 
                             class="w-20 h-20 object-cover rounded-lg">
                        <div class="flex-1">
                            <h4 class="text-white font-medium">{{ $item->name }}</h4>
                            @if($item->taille_type)
                            <p class="text-sm text-gray-400">Size: {{ $item->taille_type }}</p>
                            @endif
                            <p class="text-sm text-gray-400">Quantity: {{ $item->quantity }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-white font-semibold">${{ number_format($item->price, 2) }}</p>
                            <p class="text-sm text-gray-400">each</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="px-6 py-4 bg-neutral-900">
                <h3 class="text-lg font-semibold text-white mb-4">Order Summary</h3>
                <div class="space-y-2">
                    <div class="flex justify-between text-gray-300">
                        <span>Subtotal:</span>
                        <span>${{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    
                    @if($order->discount_amount > 0)
                    <div class="flex justify-between text-green-400 font-medium">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                            Discount @if($order->coupon_code)({{ $order->coupon_code }})@endif:
                        </span>
                        <span>-${{ number_format($order->discount_amount, 2) }}</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between text-gray-300">
                        <span>Shipping:</span>
                        <span>${{ number_format($order->shipping_cost, 2) }}</span>
                    </div>
                    
                    <div class="border-t border-neutral-700 pt-2 mt-2">
                        <div class="flex justify-between text-white text-xl font-bold">
                            <span>Total:</span>
                            <span class="text-yellow-400">${{ number_format($order->total, 2) }}</span>
                            
                        </div>
                    </div>
                    
                    @if($order->discount_amount > 0)
                    <div class="bg-green-500/10 border border-green-500/30 rounded-lg p-3 mt-4">
                        <p class="text-green-400 text-sm font-medium text-center">
                            🎉 You saved ${{ number_format($order->discount_amount, 2) }} on this order!
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="px-6 py-4 border-t border-neutral-700">
                <h3 class="text-lg font-semibold text-white mb-4">Shipping Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-300">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Name</p>
                        <p class="font-medium">{{ $order->first_name }} {{ $order->last_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Phone</p>
                        <p class="font-medium">{{ $order->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Email</p>
                        <p class="font-medium">{{ $order->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Location</p>
                        <p class="font-medium">{{ $order->commune }}, {{ $order->wilaya }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500 mb-1">Address</p>
                        <p class="font-medium">{{ $order->address }}</p>
                    </div>
                    @if($order->notes)
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500 mb-1">Notes</p>
                        <p class="font-medium">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- What's Next Section -->
        <div class="bg-neutral-800 rounded-lg p-6 mb-6">
            <h3 class="text-xl font-semibold text-white mb-4">What happens next?</h3>
            <div class="space-y-3">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center text-black font-bold mr-3">1</div>
                    <div>
                        <p class="text-white font-medium">Order Confirmation</p>
                        <p class="text-gray-400 text-sm">You'll receive a confirmation email shortly</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center text-black font-bold mr-3">2</div>
                    <div>
                        <p class="text-white font-medium">Order Processing</p>
                        <p class="text-gray-400 text-sm">We'll prepare your items for shipping</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center text-black font-bold mr-3">3</div>
                    <div>
                        <p class="text-white font-medium">Shipment & Delivery</p>
                        <p class="text-gray-400 text-sm">Track your order until it reaches your doorstep</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('products.index') }}" 
               class="bg-yellow-400 hover:bg-yellow-500 text-black font-semibold px-8 py-3 rounded-lg transition-colors text-center">
                Continue Shopping
            </a>
            @auth
            <a href="{{ route('orders.index') }}" 
               class="bg-neutral-700 hover:bg-neutral-600 text-white font-semibold px-8 py-3 rounded-lg transition-colors text-center">
                View My Orders
            </a>
            @endauth
        </div>
    </div>
</section>
@endsection