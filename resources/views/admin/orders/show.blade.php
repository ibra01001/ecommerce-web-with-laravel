@extends('admin.layout')
@section('title', $order->last_name . ' ' . $order->first_name . ' — Order Details')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.orders.index') }}" 
           class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h2 class="text-3xl font-light text-slate-900 flex items-center gap-3">
            <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Order #{{ $order->id }}
        </h2>
    </div>

    <span class="px-4 py-2 rounded-full text-sm font-medium border-2
        @if($order->status === 'pending') bg-yellow-50 text-yellow-700 border-yellow-200
        @elseif($order->status === 'confirmed') bg-blue-50 text-blue-700 border-blue-200
        @elseif($order->status === 'completed') bg-green-50 text-green-700 border-green-200
        @elseif($order->status === 'cancelled') bg-red-50 text-red-700 border-red-200
        @else bg-slate-50 text-slate-700 border-slate-200
        @endif">
        {{ ucfirst($order->status) }}
    </span>
</div>

<!-- Order Info Badge -->
<div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-6 mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-slate-900 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm text-slate-600 font-light">Order Date</p>
                <p class="text-xl font-medium text-slate-900">{{ $order->created_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
        <div class="text-right">
            <p class="text-sm text-slate-600 font-light">Total Amount</p>
            <p class="text-2xl font-medium text-slate-900">{{ number_format($order->total, 2) }} DA</p>
        </div>
    </div>
</div>

<!-- Customer & Order Info Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Customer Information -->
    <div class="bg-white p-6 rounded-2xl border-2 border-slate-200 shadow-sm">
        <h3 class="text-lg font-medium text-slate-900 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Customer Information
        </h3>
        <div class="space-y-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-slate-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm text-slate-600 font-light">Full Name</p>
                    <p class="text-base text-slate-900 font-medium">{{ $order->first_name }} {{ $order->last_name }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-slate-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm text-slate-600 font-light">Phone Number</p>
                    <p class="text-base text-slate-900 font-medium">{{ $order->phone }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-slate-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm text-slate-600 font-light">Email Address</p>
                    <p class="text-base text-slate-900 font-medium">{{ $order->email ?? '—' }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-slate-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm text-slate-600 font-light">Address</p>
                    <p class="text-base text-slate-900 font-medium">{{ $order->address }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-slate-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm text-slate-600 font-light">Wilaya</p>
                        <p class="text-base text-slate-900 font-medium">{{ $order->wilaya }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-slate-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm text-slate-600 font-light">Commune</p>
                        <p class="text-base text-slate-900 font-medium">{{ $order->commune }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="bg-white p-6 rounded-2xl border-2 border-slate-200 shadow-sm">
        <h3 class="text-lg font-medium text-slate-900 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            Order Summary
        </h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <span class="text-slate-700 font-light">Subtotal</span>
                <span class="text-slate-900 font-medium">{{ number_format($order->subtotal, 2) }} DA</span>
            </div>

            <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
</svg>

                    <span class="text-slate-700 font-light">Shipping Cost</span>
                </div>
                <span class="text-slate-900 font-medium">{{ number_format($order->shipping_cost, 2) }} DA</span>
            </div>
            <!-- discount here -->
             <div class="flex items-center justify-between pb-3 border-b border-slate-200">
                <div class="flex items-center gap-2">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
</svg>

                    <span class="text-slate-700 font-light">Discount</span>
                </div>
                <span class="text-slate-900 font-medium">{{ number_format($order->discount, 2) }} DA</span>
            </div>

            <div class="flex items-center justify-between py-3 bg-slate-50 px-4 rounded-xl -mx-2">
                <span class="text-slate-900 font-medium text-lg">Total Amount</span>
                <span class="text-slate-900 font-semibold text-xl">{{ number_format($order->total, 2) }} DA</span>
            </div>

            <div class="pt-4 border-t border-slate-200">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-slate-900 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm text-slate-600 font-light mb-1">Additional Notes</p>
                        <p class="text-base text-slate-900 font-light">
                            {{ $order->notes ?: 'No additional notes provided' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ordered Products -->
<div class="bg-white p-6 rounded-2xl border-2 border-slate-200 shadow-sm">
    <h3 class="text-lg font-medium text-slate-900 mb-6 flex items-center gap-2">
        <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
        Ordered Products
    </h3>
    
    <div class="overflow-hidden border-2 border-slate-200 rounded-xl">
        <table class="w-full">
            <thead class="bg-slate-50 border-b-2 border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-slate-900">Product</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-slate-900">Quantity</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-slate-900">Size</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-slate-900">Price</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($order->orderItems as $item)
                <tr class="hover:bg-slate-50 transition-colors duration-200">
                    <td class="px-6 py-4">
                                    <div class="space-y-4">
                @foreach($order->orderItems as $item)
                    @php
                        $product = \App\Models\Product::find($item->product_id);
                        $imageSrc = $product && $product->primary_image_url ? $product->primary_image_url : null;
                    @endphp
                    <div class="flex items-center gap-6 pb-6 border-b border-slate-200 last:border-0 last:pb-0">
                        <div class="w-24 h-24 flex-shrink-0 overflow-hidden rounded-xl bg-slate-100">
                            @if($imageSrc)
                                <img src="{{ $imageSrc }}" 
                                     alt="{{ $item->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" 
                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
                            
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center text-slate-900 font-medium">{{ $item->quantity ?? 1 }}</td>
                    <td class="px-6 py-4 text-center text-slate-700 font-light">{{ $item->taille_type ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-center text-slate-900 font-medium">{{ number_format($item->price, 2) }} DA</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection