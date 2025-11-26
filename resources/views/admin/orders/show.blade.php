@extends('admin.layout')
@section('title', $order->last_name . ' ' . $order->first_name . ' — Order Details')

@section('content')
<div class="bg-neutral-900 p-8 rounded-2xl shadow-lg border border-neutral-800">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-semibold text-white flex items-center gap-3">
            <x-heroicon-o-receipt-percent class="w-7 h-7 text-yellow-400" />
            Order #{{ $order->id }}
        </h2>

        <span class="px-4 py-1 rounded-full text-sm font-medium 
            @if($order->status === 'pending') bg-yellow-500/20 text-yellow-400 
            @elseif($order->status === 'completed') bg-green-500/20 text-green-400 
            @elseif($order->status === 'cancelled') bg-red-500/20 text-red-400 
            @else bg-gray-500/20 text-gray-300 
            @endif">
            {{ ucfirst($order->status) }}
        </span>
    </div>

    <!-- Info Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Customer Info -->
        <div>
            <h3 class="text-lg font-semibold text-yellow-400 mb-4 flex items-center gap-2">
                <x-heroicon-o-user class="w-5 h-5" /> Customer Information
            </h3>
            <div class="space-y-2 text-gray-300">
                <p><x-heroicon-o-identification class="inline w-5 h-5 text-yellow-400 mr-2"/> 
                    <span class="font-medium text-white">Name:</span> {{ $order->first_name }} {{ $order->last_name }}</p>
                <p><x-heroicon-o-phone class="inline w-5 h-5 text-yellow-400 mr-2"/> 
                    <span class="font-medium text-white">Phone:</span> {{ $order->phone }}</p>
                <p><x-heroicon-o-envelope class="inline w-5 h-5 text-yellow-400 mr-2"/> 
                    <span class="font-medium text-white">Email:</span> {{ $order->email ?? '—' }}</p>
                <p><x-heroicon-o-map-pin class="inline w-5 h-5 text-yellow-400 mr-2"/> 
                    <span class="font-medium text-white">Address:</span> {{ $order->address }}</p>
                <p><x-heroicon-o-map class="inline w-5 h-5 text-yellow-400 mr-2"/> 
                    <span class="font-medium text-white">Wilaya:</span> {{ $order->wilaya }}</p>
                <p><x-heroicon-o-building-office class="inline w-5 h-5 text-yellow-400 mr-2"/> 
                    <span class="font-medium text-white">Commune:</span> {{ $order->commune }}</p>
            </div>
        </div>

        <!-- Order Info -->
        <div>
            <h3 class="text-lg font-semibold text-yellow-400 mb-4 flex items-center gap-2">
                <x-heroicon-o-clipboard-document-list class="w-5 h-5" /> Order Summary
            </h3>
            <div class="space-y-2 text-gray-300">
                <p><x-heroicon-o-currency-dollar class="inline w-5 h-5 text-yellow-400 mr-2"/> 
                    <span class="font-medium text-white">Total:</span> {{ number_format($order->total, 2) }} DA</p>
                <p><x-heroicon-o-calendar class="inline w-5 h-5 text-yellow-400 mr-2"/> 
                    <span class="font-medium text-white">Date:</span> {{ $order->created_at->format('M d, Y H:i') }}</p>
                <p><x-heroicon-o-document-text class="inline w-5 h-5 text-yellow-400 mr-2"/> 
                    <span class="font-medium text-white">Notes:</span> {{ $order->notes ?: 'No additional notes' }}</p>
                <p><x-heroicon-o-truck class="inline w-5 h-5 text-yellow-400 mr-2"/> 
                    <span class="font-medium text-white">Shipping Cost:</span> {{ number_format($order->shipping_cost, 2) }} DA</p>
            </div>
        </div>
    </div>

    <!-- Products -->
    <div>
        <h3 class="text-lg font-semibold text-yellow-400 mb-4 flex items-center gap-2">
            <x-heroicon-o-shopping-bag class="w-5 h-5" /> Ordered Products
        </h3>
        <div class="overflow-hidden border border-neutral-800 rounded-xl">
            <table class="w-full text-left text-gray-300">
                <thead class="bg-neutral-800 text-gray-400 uppercase text-sm">
                    <tr>
                        <th class="px-6 py-3">Product</th>
                        <th class="px-6 py-3 text-center">Quantity</th>
                        <th class="px-6 py-3 text-center">Size</th>
                        <th class="px-6 py-3 text-center">Price</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-neutral-800">
                    @foreach($order->items as $item)
                        <tr class="hover:bg-neutral-800/40 transition">
                            <td class="px-6 py-4 font-medium text-white flex items-center gap-3">
                                @if(!empty($item->image))
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <x-heroicon-o-photo class="w-6 h-6 text-gray-500" />
                                @endif
                                {{ $item->name }}
                            </td>
                            <td class="px-6 py-4 text-center">{{ $item->quantity ?? 1 }}</td>
                            <td class="px-6 py-4 text-center">{{ $item->taille_type ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-center">{{ number_format($item->price, 2) }} DA</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
