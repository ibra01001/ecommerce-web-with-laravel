@extends('layouts.app')

@section('title', 'Checkout — HoodLuxe')

@section('content')


@if ($errors->any())
    <div class="fixed top-4 right-4 z-50 bg-red-500 text-white p-6 rounded-lg shadow-lg max-w-md">
        <h3 class="font-bold mb-2">⚠️ ERRORS FOUND:</h3>
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 z-50 bg-red-500 text-white p-6 rounded-lg shadow-lg max-w-md">
        {{ session('error') }}
    </div>
@endif

@if(session('success'))
    <div class="fixed top-4 right-4 z-50 bg-green-500 text-white p-6 rounded-lg shadow-lg max-w-md">
        {{ session('success') }}
    </div>
@endif
<section class="pt-32 pb-24 px-6 bg-gradient-to-b from-black via-neutral-950 to-neutral-900 min-h-screen">
    <div class="max-w-5xl mx-auto">
        
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-light text-white mb-2">Checkout</h1>
            <p class="text-gray-400">Complete your order</p>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf

            <!-- Billing & Shipping Form -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Personal Information -->
                <div class="bg-neutral-900/60 border border-neutral-800 rounded-xl p-6">
                    <h2 class="text-xl text-white font-semibold mb-6 flex items-center gap-2">
                        <x-heroicon-o-user class="w-6 h-6 text-yellow-400" />
                        Personal Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">First Name *</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                class="w-full p-3 bg-neutral-950 border border-neutral-700 rounded-lg text-gray-200 focus:outline-none focus:border-yellow-400 transition" />
                            @error('first_name') 
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Last Name *</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                class="w-full p-3 bg-neutral-950 border border-neutral-700 rounded-lg text-gray-200 focus:outline-none focus:border-yellow-400 transition" />
                            @error('last_name') 
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Phone (10 digits) *</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" maxlength="10" required
                                placeholder="0555123456"
                                class="w-full p-3 bg-neutral-950 border border-neutral-700 rounded-lg text-gray-200 focus:outline-none focus:border-yellow-400 transition" />
                            @error('phone') 
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                placeholder="your@email.com"
                                class="w-full p-3 bg-neutral-950 border border-neutral-700 rounded-lg text-gray-200 focus:outline-none focus:border-yellow-400 transition" />
                            @error('email') 
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-neutral-900/60 border border-neutral-800 rounded-xl p-6">
                    <h2 class="text-xl text-white font-semibold mb-6 flex items-center gap-2">
                        <x-heroicon-o-map-pin class="w-6 h-6 text-yellow-400" />
                        Shipping Address
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Wilaya *</label>
                            <select id="wilaya-select" name="wilaya" required
                                class="w-full p-3 bg-neutral-950 border border-neutral-700 rounded-lg text-gray-200 focus:outline-none focus:border-yellow-400 transition">
                                <option value="" data-cost="0">Select Wilaya</option>
                                @foreach($wilayas as $wilaya)
                                    <option value="{{ $wilaya->name }}" 
                                            data-cost="{{ $wilaya->shipping_cost }}"
                                            {{ old('wilaya') == $wilaya->name ? 'selected' : '' }}>
                                        {{ $wilaya->name }} — {{ number_format($wilaya->shipping_cost, 0) }} DA
                                    </option>
                                @endforeach
                            </select>
                            @error('wilaya') 
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Commune *</label>
                            <input type="text" name="commune" value="{{ old('commune') }}" required
                                placeholder="Enter your commune"
                                class="w-full p-3 bg-neutral-950 border border-neutral-700 rounded-lg text-gray-200 focus:outline-none focus:border-yellow-400 transition" />
                            @error('commune') 
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Address *</label>
                            <input type="text" name="address" value="{{ old('address') }}" required
                                placeholder="Street, building, apartment"
                                class="w-full p-3 bg-neutral-950 border border-neutral-700 rounded-lg text-gray-200 focus:outline-none focus:border-yellow-400 transition" />
                            @error('address') 
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                            @enderror
                        </div>

                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Additional Notes (Optional)</label>
                            <textarea name="notes" rows="3"
                                placeholder="Any special delivery instructions..."
                                class="w-full p-3 bg-neutral-950 border border-neutral-700 rounded-lg text-gray-200 focus:outline-none focus:border-yellow-400 transition">{{ old('notes') }}</textarea>
                            @error('notes') 
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-neutral-900/60 border border-neutral-800 rounded-xl p-6 sticky top-24">
                    <h2 class="text-xl text-white font-semibold mb-6 flex items-center gap-2">
                        <x-heroicon-o-shopping-bag class="w-6 h-6 text-yellow-400" />
                        Order Summary
                    </h2>

                    @php 
                        $cart = session('cart', []);
                        $subtotal = 0;
                    @endphp

                    @if(empty($cart))
                        <div class="text-center py-8">
                            <p class="text-gray-400 mb-4">Your cart is empty</p>
                            <a href="{{ route('products.index') }}" 
                               class="text-yellow-400 hover:text-yellow-300 transition">
                                Continue Shopping
                            </a>
                        </div>
                    @else
                        <!-- Cart Items -->
                        <div class="space-y-4 mb-6 max-h-64 overflow-y-auto">
                            @foreach($cart as $cartKey => $item)
                                @php 
                                    $lineTotal = $item['price'] * $item['quantity'];
                                    $subtotal += $lineTotal;
                                @endphp
                                <div class="flex gap-3 pb-4 border-b border-neutral-700">
                                    <div class="w-16 h-16 flex-shrink-0">
                                        @if($item['image'])
                                            <img src="{{ asset('storage/' . $item['image']) }}" 
                                                 alt="{{ $item['name'] }}"
                                                 class="w-full h-full object-cover rounded border border-neutral-700">
                                        @else
                                            <div class="w-full h-full bg-neutral-800 rounded flex items-center justify-center">
                                                <x-heroicon-o-photo class="w-6 h-6 text-gray-600" />
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-white text-sm font-medium truncate">{{ $item['name'] }}</h4>
                                        <p class="text-gray-400 text-xs mt-1">
                                            Size: <span class="text-yellow-400">{{ $item['taille_type'] }}</span>
                                        </p>
                                        <p class="text-gray-400 text-xs">Qty: {{ $item['quantity'] }}</p>
                                        <p class="text-yellow-400 text-sm font-semibold mt-1">
                                            {{ number_format($lineTotal, 0) }} DA
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Price Summary -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-400">
                                <span>Subtotal</span>
                                <span id="subtotal-value" data-subtotal="{{ $subtotal }}">
                                    {{ number_format($subtotal, 0) }} DA
                                </span>
                            </div>
                            <div class="flex justify-between text-gray-400">
                                <span>Shipping</span>
                                <span id="shipping-value">
                                    {{ $shipping_cost > 0 ? number_format($shipping_cost, 0) . ' DA' : 'Select wilaya' }}
                                </span>
                            </div>
                            <div class="border-t border-neutral-700 pt-3 flex justify-between text-white text-lg font-semibold">
                                <span>Total</span>
                                <span id="total-value" class="text-yellow-400">
                                    {{ number_format($subtotal + $shipping_cost, 0) }} DA
                                </span>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <button type="submit" 
                                class="w-full flex items-center justify-center gap-2 bg-yellow-400 text-black font-semibold py-3 px-6 rounded-lg hover:bg-yellow-500 transition">
                            <x-heroicon-o-check-circle class="w-5 h-5" />
                            Place Order
                        </button>

                        <p class="text-gray-500 text-xs text-center mt-4">
                            By placing your order, you agree to our terms and conditions
                        </p>
                    @endif
                </div>
            </div>
        </form>
    </div>
</section>

<script>
document.getElementById('wilaya-select').addEventListener('change', function() {
    const shippingCost = parseFloat(this.options[this.selectedIndex].dataset.cost) || 0;
    const subtotal = parseFloat(document.getElementById('subtotal-value').dataset.subtotal) || 0;
    const total = subtotal + shippingCost;
    
    // Update shipping display
    document.getElementById('shipping-value').textContent = shippingCost > 0 
        ? shippingCost.toLocaleString() + ' DA' 
        : 'Free';
    
    // Update total
    document.getElementById('total-value').textContent = total.toLocaleString() + ' DA';
});

// Trigger on page load if wilaya is pre-selected (from old input)
window.addEventListener('DOMContentLoaded', function() {
    const wilayaSelect = document.getElementById('wilaya-select');
    if (wilayaSelect.value) {
        wilayaSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection