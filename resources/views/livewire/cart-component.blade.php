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
                        <div
                            class="bg-neutral-900 rounded-2xl border border-neutral-800 p-6 hover:border-yellow-400 transition">

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
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 bg-yellow-400/10 border border-yellow-400/30 rounded-lg text-yellow-400 text-sm font-medium">
                                        <x-heroicon-o-tag class="w-4 h-4" />
                                        Size: {{ $item['taille_type'] }}
                                    </span>
                                    <button wire:click="removeItem('{{ $id }}')"
                                        class="text-sm text-gray-400 hover:text-red-400 mt-3"> Remove </button>
                                </div> <!-- Quantity -->
                                <div class="flex items-center gap-2"> <button onclick="decreaseQty('{{ $id }}')"
                                        class="px-4 py-2 bg-neutral-800 text-gray-300"> - </button> <input id="qty-{{ $id }}"
                                        type="number" min="1" wire:change="updateQuantity('{{ $id }}', $event.target.value)"
                                        value="{{ $item['quantity'] }}" class="w-16 text-center bg-neutral-900 text-white">
                                    <button onclick="increaseQty('{{ $id }}')" class="px-4 py-2 bg-neutral-800 text-gray-300"> +
                                    </button>
                                </div>
                            </div>
                    </div> @endforeach
                </div>

                <!-- Summary -->
                <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-8 h-fit">
                    <h3 class="text-2xl text-white mb-6">Order Summary</h3>

                    <div class="space-y-4">
                        <div class="flex justify-between text-gray-400">
                            <span>Subtotal</span>
                            <span class="text-white">{{ number_format($total - $shipping_cost, 2) }} DA</span>
                        </div>

                        <!-- Wilaya select -->
                        <div class="flex flex-col">
                            <label class="text-gray-400 mb-1">Shipping (Wilaya)</label>

                            <select wire:model.live="wilaya_id"
                                class="bg-neutral-900 border border-neutral-700 p-3 rounded-lg text-gray-200">
                                <option value="">Select Wilaya</option>

                                @foreach($wilayas as $wilaya)
                                    <option value="{{ $wilaya->id }}">
                                        {{ $wilaya->name }} — {{ $wilaya->shipping_cost }} DA
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex justify-between text-gray-400">
                            <span>Shipping Cost</span>
                            <span class="text-green-400">{{ number_format($shipping_cost, 2) }} DA</span>
                        </div>

                        <div class="flex justify-between text-white text-xl font-semibold pt-4">
                            <span>Total</span>
                            <span class="text-yellow-400">
                                {{ number_format($total, 2) }} DA
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('checkout.create') }}" method="GET" class="mt-6">
                        <button class="w-full bg-yellow-400 py-4 text-black rounded-lg font-semibold">
                            Proceed to Checkout
                        </button>
                    </form>

                </div>
            </div>

        @else
            <div class="text-center text-gray-400 py-20">
                Your cart is empty.
            </div>
        @endif

    </div>
</section>

<script>
    function decreaseQty(id) {
        const i = document.getElementById('qty-' + id);
        if (i.value > 1) {
            i.value = parseInt(i.value) - 1;
            i.dispatchEvent(new Event('change'));
        }
    }

    function increaseQty(id) {
        const i = document.getElementById('qty-' + id);
        i.value = parseInt(i.value) + 1;
        i.dispatchEvent(new Event('change'));
    }
</script>