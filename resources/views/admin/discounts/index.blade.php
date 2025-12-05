@extends('admin.layout')

@section('title', 'Discounts')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-semibold text-white flex items-center gap-3">
        <x-heroicon-o-ticket class="w-7 h-7 text-yellow-400" />
        Discount Codes
    </h2>

    <a href="{{ route('admin.discounts.create') }}" 
       class="flex items-center gap-2 bg-yellow-400 text-black px-6 py-2.5 rounded-lg font-semibold 
              hover:bg-yellow-500 transition">
        <x-heroicon-o-plus class="w-5 h-5" />
        Create Discount
    </a>
</div>

@if(session('success'))
    <div class="bg-green-900/20 border border-green-700/50 rounded-lg p-4 mb-6">
        <p class="text-green-400">{{ session('success') }}</p>
    </div>
@endif

<div class="bg-neutral-900/60 rounded-xl border border-neutral-800 overflow-hidden">
    <table class="w-full">
        <thead class="bg-neutral-950 border-b border-neutral-800">
            <tr>
                <th class="text-left p-4 text-gray-400 font-semibold">Code</th>
                <th class="text-left p-4 text-gray-400 font-semibold">Name</th>
                <th class="text-left p-4 text-gray-400 font-semibold">Type</th>
                <th class="text-left p-4 text-gray-400 font-semibold">Value</th>
                <th class="text-left p-4 text-gray-400 font-semibold">Usage</th>
                <th class="text-left p-4 text-gray-400 font-semibold">Valid Until</th>
                <th class="text-left p-4 text-gray-400 font-semibold">Status</th>
                <th class="text-right p-4 text-gray-400 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-neutral-800">
            @forelse($discounts as $discount)
                <tr class="hover:bg-neutral-900/40 transition">
                    <td class="p-4">
                        <code class="bg-neutral-950 px-3 py-1 rounded text-yellow-400 font-mono">
                            {{ $discount->code }}
                        </code>
                    </td>
                    <td class="p-4 text-gray-300">{{ $discount->name }}</td>
                    <td class="p-4">
                        <span class="text-gray-400 capitalize">{{ $discount->type }}</span>
                    </td>
                    <td class="p-4 text-gray-300">
                        @if($discount->type === 'percentage')
                            {{ $discount->value }}%
                        @else
                            {{ number_format($discount->value, 2) }} DZD
                        @endif
                    </td>
                    <td class="p-4 text-gray-300">
                        {{ $discount->usage_count }}
                        @if($discount->usage_limit)
                            / {{ $discount->usage_limit }}
                        @endif
                    </td>
                    <td class="p-4 text-gray-400">
                        @if($discount->expires_at)
                            {{ $discount->expires_at->format('M d, Y') }}
                        @else
                            <span class="text-gray-500">No expiry</span>
                        @endif
                    </td>
                    <td class="p-4">
                        @php
                            $status = $discount->status;
                            $statusColors = [
                                'Active' => 'bg-green-900/20 text-green-400 border-green-700/50',
                                'Inactive' => 'bg-gray-900/20 text-gray-400 border-gray-700/50',
                                'Expired' => 'bg-red-900/20 text-red-400 border-red-700/50',
                                'Scheduled' => 'bg-blue-900/20 text-blue-400 border-blue-700/50',
                                'Used Up' => 'bg-orange-900/20 text-orange-400 border-orange-700/50',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-semibold border {{ $statusColors[$status] ?? '' }}">
                            {{ $status }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.discounts.show', $discount) }}" 
                               class="text-blue-400 hover:text-blue-300 transition"
                               title="View Details">
                                <x-heroicon-o-eye class="w-5 h-5" />
                            </a>
                            
                            <a href="{{ route('admin.discounts.edit', $discount) }}" 
                               class="text-yellow-400 hover:text-yellow-300 transition"
                               title="Edit">
                                <x-heroicon-o-pencil class="w-5 h-5" />
                            </a>

                            <form action="{{ route('admin.discounts.toggle', $discount) }}" 
                                  method="POST" class="inline">
                                @csrf
                                <button type="submit" 
                                        class="transition"
                                        title="{{ $discount->is_active ? 'Deactivate' : 'Activate' }}">
                                    @if($discount->is_active)
                                        <x-heroicon-o-pause-circle class="w-5 h-5 text-orange-400 hover:text-orange-300" />
                                    @else
                                        <x-heroicon-o-play-circle class="w-5 h-5 text-green-400 hover:text-green-300" />
                                    @endif
                                </button>
                            </form>

                            <form action="{{ route('admin.discounts.destroy', $discount) }}" 
                                  method="POST" class="inline"
                                  onsubmit="return confirm('Delete this discount code?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-400 hover:text-red-300 transition"
                                        title="Delete">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-8 text-center text-gray-500">
                        No discount codes yet. Create your first one!
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $discounts->links() }}
</div>
@endsection