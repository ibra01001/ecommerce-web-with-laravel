<section class="pt-32 pb-24 px-6 bg-gradient-to-b from-black via-neutral-950 to-neutral-900 min-h-screen">

    <div class="max-w-7xl mx-auto text-center mb-16">
        <h1 class="text-5xl md:text-6xl font-light text-white mb-4 tracking-wide">
            Your <span class="text-yellow-400 font-semibold">Cart</span>
        </h1>
    </div>

    <div class="max-w-7xl mx-auto">

        @if(count($cart) > 0)

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Items -->
                <div class="lg:col-span-2 space-y-6">
                    @foreach($cart as $id => $item)
                        <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-6 hover:border-yellow-400 transition">

                            <div class="flex gap-6">
                                <!-- Image -->
                                <div class="w-32 h-32 overflow-hidden rounded-xl">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover">
                                    @endif
                                </div>

                                <!-- Info -->
                                <div class="flex-1">
                                    <h3 class="text-xl text-white font-medium">{{ $item['name'] }}</h3>
                                    <p class="text-yellow-400 text-lg font-semibold">
                                        {{ number_format($item['price'], 2) }} DA
                                    </p>
                                    <!-- Size Badge -->
                                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-yellow-400/10 border border-yellow-400/30 rounded-lg text-yellow-400 text-sm font-medium mt-2">
                                        <x-heroicon-o-tag class="w-4 h-4" />
                                        Size: {{ $item['stock_label'] }}
                                    </span>
                                    
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" class="inline mt-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-gray-400 hover:text-red-400">
                                            Remove
                                        </button>
                                    </form>
                                </div>
                                
                                <!-- Quantity -->
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" id="qty-form-{{ $id }}">
                                        @csrf
                                        <div class="flex items-center gap-2">
                                            <button type="button" onclick="decreaseQty('{{ $id }}')" 
                                                    class="px-4 py-2 bg-neutral-800 text-gray-300 rounded hover:bg-neutral-700">
                                                -
                                            </button>
                                            <input id="qty-{{ $id }}" 
                                                   type="number" 
                                                   name="quantity" 
                                                   min="1" 
                                                   value="{{ $item['quantity'] }}" 
                                                   class="w-16 text-center bg-neutral-900 text-white border border-neutral-700 rounded"
                                                   onchange="document.getElementById('qty-form-{{ $id }}').submit()">
                                            <button type="button" onclick="increaseQty('{{ $id }}')" 
                                                    class="px-4 py-2 bg-neutral-800 text-gray-300 rounded hover:bg-neutral-700">
                                                +
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Summary -->
                <div class="space-y-6">
                    
                    <!-- Discount Code Section -->
                    <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-6">
                        <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <x-heroicon-o-ticket class="w-5 h-5 text-yellow-400" />
                            Discount Code
                        </h3>

                        @if(session('discount'))
                            <!-- Applied Discount -->
                            <div class="bg-green-900/20 border border-green-700/50 rounded-lg p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-green-400 font-semibold">
                                            Code: {{ session('discount')['code'] }}
                                        </p>
                                        <p class="text-gray-400 text-sm mt-1">
                                            -{{ number_format(session('discount')['amount'], 2) }} DA
                                        </p>
                                    </div>
                                    <form action="{{ route('cart.remove-discount') }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="text-red-400 hover:text-red-300 transition">
                                            <x-heroicon-o-x-circle class="w-6 h-6" />
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Discount Input Form -->
                            <form action="{{ route('cart.apply-discount') }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="text" 
                                       name="code" 
                                       placeholder="Enter discount code"
                                       class="flex-1 bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                                              uppercase focus:outline-none focus:border-yellow-400 transition"
                                       required>
                                <button type="submit"
                                        class="bg-yellow-400 text-black px-6 py-3 rounded-lg font-semibold 
                                               hover:bg-yellow-500 transition whitespace-nowrap">
                                    Apply
                                </button>
                            </form>
                        @endif

                        @if(session('error'))
                            <div class="mt-4 bg-red-900/20 border border-red-700/50 rounded-lg p-3">
                                <p class="text-red-400 text-sm">{{ session('error') }}</p>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="mt-4 bg-green-900/20 border border-green-700/50 rounded-lg p-3">
                                <p class="text-green-400 text-sm">{{ session('success') }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Order Summary -->
                    <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-8 sticky top-24">
                        <h3 class="text-2xl text-white mb-6">Order Summary</h3>

                        @php
                            $subtotal = 0;
                            foreach($cart as $item) {
                                $subtotal += $item['price'] * $item['quantity'];
                            }
                            $discountAmount = session('discount')['amount'] ?? 0;
                            $shipping = session('shipping_cost', 0);
                            $totalAmount = $subtotal - $discountAmount + $shipping;
                        @endphp

                        <div class="space-y-4">
                            <div class="flex justify-between text-gray-400">
                                <span>Subtotal</span>
                                <span class="text-white">{{ number_format($subtotal, 2) }} DA</span>
                            </div>

                            @if($discountAmount > 0)
                                <div class="flex justify-between text-green-400">
                                    <span>Discount</span>
                                    <span>-{{ number_format($discountAmount, 2) }} DA</span>
                                </div>
                            @endif

                            <div class="flex justify-between text-gray-400">
                                <span>Shipping Cost</span>
                                <span class="text-green-400">{{ number_format($shipping, 2) }} DA</span>
                            </div>

                            <div class="border-t border-neutral-700 pt-4 flex justify-between text-white text-xl font-semibold">
                                <span>Total</span>
                                <span class="text-yellow-400">
                                    {{ number_format($totalAmount, 2) }} DA
                                </span>
                            </div>
                        </div>

                        <form action="{{ route('checkout.create') }}" method="GET" class="mt-6">
                            <button type="submit" class="w-full bg-yellow-400 py-4 text-black rounded-lg font-semibold hover:bg-yellow-500 transition">
                                Proceed to Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        @else
            <div class="text-center text-gray-400 py-20">
                <x-heroicon-o-shopping-cart class="w-24 h-24 mx-auto mb-4 text-gray-600" />
                <p class="text-2xl mb-4">Your cart is empty.</p>
                <a href="{{ route('home') }}" class="inline-block bg-yellow-400 text-black px-8 py-3 rounded-lg font-semibold hover:bg-yellow-500 transition">
                    Continue Shopping
                </a>
            </div>
        @endif

    </div>
</section>

<script>
    function decreaseQty(id) {
        const input = document.getElementById('qty-' + id);
        if (input.value > 1) {
            input.value = parseInt(input.value) - 1;
            document.getElementById('qty-form-' + id).submit();
        }
    }

    function increaseQty(id) {
        const input = document.getElementById('qty-' + id);
        input.value = parseInt(input.value) + 1;
        document.getElementById('qty-form-' + id).submit();
    }
</script>