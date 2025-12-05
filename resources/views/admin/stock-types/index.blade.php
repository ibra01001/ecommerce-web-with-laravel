@extends('admin.layout')

@section('title', 'Stock Types')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-semibold text-white flex items-center gap-3">
        <x-heroicon-o-squares-2x2 class="w-7 h-7 text-yellow-400" />
        Stock Types
    </h2>

    <a href="{{ route('admin.stock-types.create') }}" 
       class="flex items-center gap-2 bg-yellow-400 text-black px-5 py-2.5 rounded-lg font-medium hover:bg-yellow-500 transition">
        <x-heroicon-o-plus class="w-5 h-5" />
        Create Stock Type
    </a>
</div>

@if(session('success'))
<div class="bg-green-600/20 border border-green-600 text-green-300 px-4 py-3 rounded-lg mb-8 flex items-center gap-2">
    <x-heroicon-o-check-circle class="w-5 h-5 text-green-400" />
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-600/20 border border-red-600 text-red-300 px-4 py-3 rounded-lg mb-8 flex items-center gap-2">
    <x-heroicon-o-x-circle class="w-5 h-5 text-red-400" />
    {{ session('error') }}
</div>
@endif

<div class="overflow-hidden border border-neutral-800 rounded-xl bg-neutral-900/60 shadow-lg">
    <table class="w-full text-left text-gray-300">
        <thead class="bg-neutral-800 text-gray-400 uppercase text-sm">
            <tr>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Display Type</th>
                <th class="px-6 py-3 text-center">Options</th>
                <th class="px-6 py-3 text-center">Products</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-800">
            @forelse($stockTypes as $stockType)
            <tr class="hover:bg-neutral-800/40 transition">
                <td class="px-6 py-4 font-medium text-white">{{ $stockType->name }}</td>
                <td class="px-6 py-4">
                    <span class="px-3 py-1 bg-neutral-800 text-gray-300 rounded-full text-xs">
                        {{ ucfirst($stockType->display_type) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="text-yellow-400 font-semibold">{{ $stockType->options_count }}</span>
                </td>
                <td class="px-6 py-4 text-center">
                    <span class="text-gray-400">{{ $stockType->products_count }}</span>
                </td>
                <td class="px-6 py-4 text-center">
                    @if($stockType->is_active)
                        <span class="px-3 py-1 bg-green-600/20 text-green-400 rounded-full text-xs">Active</span>
                    @else
                        <span class="px-3 py-1 bg-gray-600/20 text-gray-400 rounded-full text-xs">Inactive</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex justify-center gap-3">
                        <a href="{{ route('admin.stock-types.show', $stockType) }}" 
                           class="text-blue-400 hover:text-blue-300 transition" title="Manage Options">
                            <x-heroicon-o-cog class="w-5 h-5" />
                        </a>
                        <a href="{{ route('admin.stock-types.edit', $stockType) }}" 
                           class="text-yellow-400 hover:text-yellow-300 transition" title="Edit">
                            <x-heroicon-o-pencil-square class="w-5 h-5" />
                        </a>
                        <form action="{{ route('admin.stock-types.destroy', $stockType) }}" method="POST" 
                              onsubmit="return confirm('Are you sure? This will affect all products using this stock type.')">
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
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    <x-heroicon-o-squares-2x2 class="w-6 h-6 mx-auto mb-2 text-gray-600" />
                    No stock types available. Create your first one!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6 bg-neutral-900/60 border border-neutral-800 rounded-xl p-6">
    <h3 class="text-lg font-semibold text-white mb-2">What are Stock Types?</h3>
    <p class="text-gray-400 text-sm">
        Stock Types define how inventory is tracked for products. For example, clothing uses sizes (S, M, L), 
        shoes use EU sizes, and accessories might use "One Size". You can create custom stock types for any product category.
    </p>
</div>
@endsection