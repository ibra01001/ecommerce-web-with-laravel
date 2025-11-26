@extends('admin.layout')

@section('title', 'Products')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-semibold text-white flex items-center gap-3">
        <x-heroicon-o-rectangle-stack class="w-7 h-7 text-yellow-400" />
        Products
    </h2>

    <a href="{{ route('admin.products.create') }}" 
       class="flex items-center gap-2 bg-yellow-400 text-black px-5 py-2.5 rounded-lg font-medium hover:bg-yellow-500 transition">
        <x-heroicon-o-plus class="w-5 h-5" />
        Add Product
    </a>
</div>

@if(session('success'))
    <div class="bg-green-600/20 border border-green-600 text-green-300 px-4 py-3 rounded-lg mb-8 flex items-center gap-2">
        <x-heroicon-o-check-circle class="w-5 h-5 text-green-400" />
        {{ session('success') }}
    </div>
@endif

<div class="overflow-hidden border border-neutral-800 rounded-xl bg-neutral-900/60 shadow-lg">
    <table class="w-full text-left text-gray-300">
        <thead class="bg-neutral-800 text-gray-400 uppercase text-sm">
            <tr>
                <th class="px-6 py-3">Image</th>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Price</th>
                <th class="px-6 py-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-800">
            @forelse($products as $product)
            <tr class="hover:bg-neutral-800/40 transition">
                <td class="px-6 py-4">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                             class="w-14 h-14 object-cover rounded-lg border border-neutral-700">
                    @else
                        <div class="w-14 h-14 bg-neutral-800 flex items-center justify-center rounded-lg text-gray-500">
                            <x-heroicon-o-photo class="w-6 h-6" />
                        </div>
                    @endif
                </td>

                <td class="px-6 py-4 font-medium text-white">{{ $product->name }}</td>
                <td class="px-6 py-4 text-yellow-400 font-semibold">{{ number_format($product->price, 2) }} DA</td>

                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-3">
                        <!-- Edit -->
                        <a href="{{ route('admin.products.edit', $product) }}" 
                           class="text-yellow-400 hover:text-yellow-300 transition" title="Edit">
                            <x-heroicon-o-pencil-square class="w-5 h-5" />
                        </a>

                        <!-- Delete -->
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-400 transition" title="Delete">
                                <x-heroicon-o-trash class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                    <x-heroicon-o-cube class="w-6 h-6 mx-auto mb-2 text-gray-600" />
                    No products available.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $products->links() }}
</div>
@endsection
