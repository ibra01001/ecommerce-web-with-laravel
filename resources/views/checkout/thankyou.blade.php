@extends('layouts.app')

@section('content')
<section class="pt-24 pb-16">
    <div class="max-w-2xl mx-auto text-center bg-neutral-900 p-8 rounded">
        <h2 class="text-2xl text-white mb-2">Order Placed</h2>
        <p class="text-gray-400 mb-4">Thank you! Your order #{{ $order->id }} has been received.</p>

        <div class="text-left bg-neutral-800 p-4 rounded mb-4">
            
            <p class="text-gray-300">Total: {{ number_format($order->total, 2) }} DA</p>
            <p class="text-gray-300">Status: {{ ucfirst($order->status) }}</p>
        </div>

        <a href="{{ route('products.index') }}" class="bg-yellow-400 text-black px-4 py-2 rounded">Continue shopping</a>
    </div>
</section>
@endsection