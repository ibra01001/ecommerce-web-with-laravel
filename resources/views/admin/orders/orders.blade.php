@extends('admin.layout')
@section('title', 'Orders')

@section('content')
<div class="bg-neutral-900 p-6 rounded-2xl shadow-lg border border-neutral-800">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-white flex items-center gap-2">
            <x-heroicon-o-clipboard-document-list class="w-6 h-6 text-yellow-400" />
            Orders Dashboard
        </h2>
        <span class="text-gray-400 text-sm">Total Orders: {{ $orders->total() }}</span>
    </div>

    <!-- Orders Table -->
    <div class="overflow-x-auto rounded-xl border border-neutral-800">
        <table class="min-w-full text-gray-300 text-sm">
            <thead class="bg-neutral-800 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="py-3 px-6 text-left">#</th>
                    <th class="py-3 px-6 text-left">Customer</th>
                    <th class="py-3 px-6 text-left">Wilaya</th>
                    <th class="py-3 px-6 text-left">Total</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-800">
                @foreach($orders as $order)
                <tr class="hover:bg-neutral-800/50 transition">
                    <td class="py-4 px-6 font-semibold text-yellow-400">#{{ $order->id }}</td>
                    <td class="py-4 px-6">{{ $order->last_name }} {{ $order->first_name }}</td>
                    <td class="py-4 px-6">{{ $order->wilaya }}</td>
                    <td class="py-4 px-6">{{ number_format($order->total, 2) }} DA</td>
                    <td class="py-4 px-6">
                        @switch($order->status)
                            @case('pending')
                                <span class="px-3 py-1 text-yellow-400 bg-yellow-500/10 rounded-full text-xs font-medium">Pending</span>
                                @break
                            @case('completed')
                                <span class="px-3 py-1 text-green-400 bg-green-500/10 rounded-full text-xs font-medium">Completed</span>
                                @break
                            @case('canceled')
                                <span class="px-3 py-1 text-red-400 bg-red-500/10 rounded-full text-xs font-medium">Canceled</span>
                                @break
                            @default
                                <span class="px-3 py-1 text-gray-400 bg-gray-500/10 rounded-full text-xs font-medium">{{ ucfirst($order->status) }}</span>
                        @endswitch
                    </td>
                    <td class="py-4 px-6">{{ $order->created_at->format('M d, Y H:i') }}</td>

                    <!-- Actions -->
                    <td class="py-4 px-6 text-center">
                        <div class="flex justify-center items-center gap-3">
                            <!-- View Button -->
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="text-blue-400 hover:text-blue-500 transition" 
                               title="View Details">
                                <x-heroicon-o-eye class="w-5 h-5" />
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-500 transition" title="Delete Order">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection
