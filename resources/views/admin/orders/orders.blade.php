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

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-500/10 border border-green-500/30 rounded-lg text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <!-- Search Bar -->
    <div class="mb-6">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-3">
            <div class="relative flex-1">
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $search ?? '' }}"
                    placeholder="Search by order #, customer name, phone, email, or wilaya..." 
                    class="w-full px-4 py-3 pl-11 bg-neutral-800 border border-neutral-700 rounded-lg text-gray-300 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                >
                <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" />
            </div>
            
            <button 
                type="submit" 
                class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-neutral-900 font-semibold rounded-lg transition flex items-center gap-2"
            >
                <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                Search
            </button>
            
            @if($search ?? false)
                <a 
                    href="{{ route('admin.orders.index') }}" 
                    class="px-6 py-3 bg-neutral-800 hover:bg-neutral-700 text-gray-300 font-semibold rounded-lg transition flex items-center gap-2"
                >
                    <x-heroicon-o-x-mark class="w-5 h-5" />
                    Clear
                </a>
            @endif
        </form>
        
        @if($search ?? false)
            <div class="mt-3 text-sm text-gray-400">
                Showing results for: <span class="text-yellow-400 font-semibold">"{{ $search }}"</span>
                @if($orders->total() == 0)
                    <span class="text-red-400">- No orders found</span>
                @else
                    <span class="text-green-400">- {{ $orders->total() }} order(s) found</span>
                @endif
            </div>
        @endif
    </div>

    <!-- Orders Table -->
    <div class="overflow-x-auto rounded-xl border border-neutral-800">
        <table class="min-w-full text-gray-300 text-sm">
            <thead class="bg-neutral-800 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="py-3 px-6 text-left">#</th>
                    <th class="py-3 px-6 text-left">Customer</th>
                    <th class="py-3 px-6 text-left">Wilaya</th>
                    <th class="py-3 px-6 text-left">Phone</th>
                    <th class="py-3 px-6 text-left">Status</th>
                    <th class="py-3 px-6 text-left">Date</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-800">
                @forelse($orders as $order)
                <tr class="hover:bg-neutral-800/50 transition">
                    <td class="py-4 px-6 font-semibold text-yellow-400">#{{ $order->id }}</td>
                    <td class="py-4 px-6">{{ $order->last_name }} {{ $order->first_name }}</td>
                    <td class="py-4 px-6">{{ $order->wilaya }}</td>
                    <td class="py-4 px-6">{{ $order->phone }}</td>
                    <td class="py-4 px-6">
                        <!-- Status Dropdown Form -->
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <select name="status" 
                                    onchange="this.form.submit()"
                                    class="px-3 py-1 rounded-full text-xs font-medium border-0 focus:ring-2 focus:ring-yellow-500
                                    @switch($order->status)
                                        @case('pending')
                                            text-yellow-400 bg-yellow-500/10
                                            @break
                                        @case('confirmed')
                                            text-blue-400 bg-blue-500/10
                                            @break
                                        @case('completed')
                                            text-green-400 bg-green-500/10
                                            @break
                                        @case('canceled')
                                            text-red-400 bg-red-500/10
                                            @break
                                        @default
                                            text-gray-400 bg-gray-500/10
                                    @endswitch">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </form>
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
                @empty
                <tr>
                    <td colspan="7" class="py-8 px-6 text-center text-gray-500">
                        <div class="flex flex-col items-center gap-2">
                            <x-heroicon-o-inbox class="w-12 h-12 text-gray-600" />
                            <p class="text-lg">No orders found</p>
                            @if($search ?? false)
                                <p class="text-sm">Try adjusting your search terms</p>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection