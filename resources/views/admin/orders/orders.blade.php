@extends('admin.layout')
@section('title', 'Orders')

@section('content')
<div class="flex justify-between items-center mb-8 fade-in">
    <h2 class="text-3xl font-light text-slate-900 flex items-center gap-3">
        <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Orders Dashboard
    </h2>
    <div class="text-right">
        <p class="text-sm text-slate-600 font-light">Total Orders</p>
        <p class="text-2xl font-medium text-slate-900">{{ $orders->total() }}</p>
    </div>
</div>

@if(session('success'))
<div class="mb-6 bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-2xl">
    <div class="flex items-start gap-3">
        <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="font-medium">{{ session('success') }}</p>
    </div>
</div>
@endif

<!-- Search Bar -->
<div class="mb-6 bg-white p-6 rounded-2xl border-2 border-slate-200 shadow-sm fade-in">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
        <div class="relative flex-1">
            <svg class="w-5 h-5 text-slate-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input 
                type="text" 
                name="search" 
                value="{{ $search ?? '' }}"
                placeholder="Search by order #, customer name, phone, email, or wilaya..." 
                class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 pl-12 text-slate-900 font-light
                       focus:outline-none focus:border-slate-900 transition-all duration-300"
            >
        </div>
        
        <button 
            type="submit" 
            class="flex items-center justify-center gap-2 bg-slate-900 text-white px-8 py-3 rounded-full font-medium
                   hover:bg-slate-800 transition-all duration-300 whitespace-nowrap"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Search
        </button>
        
        @if($search ?? false)
        <a 
            href="{{ route('admin.orders.index') }}" 
            class="flex items-center justify-center gap-2 border-2 border-slate-200 text-slate-900 px-8 py-3 rounded-full font-medium
                   hover:border-slate-900 transition-all duration-300 whitespace-nowrap"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Clear
        </a>
        @endif
    </form>
    
    @if($search ?? false)
    <div class="mt-4 pt-4 border-t-2 border-slate-200">
        <p class="text-sm text-slate-600 font-light">
            Showing results for: <span class="text-slate-900 font-medium">"{{ $search }}"</span>
            @if($orders->total() == 0)
                <span class="text-red-600 font-medium">— No orders found</span>
            @else
                <span class="text-green-600 font-medium">— {{ $orders->total() }} order(s) found</span>
            @endif
        </p>
    </div>
    @endif
</div>

<!-- Orders Table -->
<div class="bg-white rounded-2xl border-2 border-slate-200 shadow-sm overflow-hidden fade-in">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 border-b-2 border-slate-200">
                <tr>
                    <th class="py-4 px-6 text-left text-sm font-medium text-slate-900">Order #</th>
                    <th class="py-4 px-6 text-left text-sm font-medium text-slate-900">Customer</th>
                    <th class="py-4 px-6 text-left text-sm font-medium text-slate-900">Wilaya</th>
                    <th class="py-4 px-6 text-left text-sm font-medium text-slate-900">Phone</th>
                    <th class="py-4 px-6 text-left text-sm font-medium text-slate-900">Status</th>
                    <th class="py-4 px-6 text-left text-sm font-medium text-slate-900">Date</th>
                    <th class="py-4 px-6 text-center text-sm font-medium text-slate-900">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($orders as $order)
                <tr class="hover:bg-slate-50 transition-colors duration-200">
                    <td class="py-4 px-6 font-medium text-slate-900">#{{ $order->id }}</td>
                    <td class="py-4 px-6 text-slate-700 font-light">{{ $order->last_name }} {{ $order->first_name }}</td>
                    <td class="py-4 px-6 text-slate-700 font-light">{{ $order->wilaya }}</td>
                    <td class="py-4 px-6 text-slate-700 font-light">{{ $order->phone }}</td>
                    <td class="py-4 px-6">
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <select name="status" 
                                    onchange="this.form.submit()"
                                    class="px-4 py-2 rounded-full text-sm font-medium border-2 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-slate-900 cursor-pointer
                                    @switch($order->status)
                                        @case('pending')
                                            text-yellow-700 bg-yellow-50 border-yellow-200
                                            @break
                                        @case('confirmed')
                                            text-blue-700 bg-blue-50 border-blue-200
                                            @break
                                        @case('completed')
                                            text-green-700 bg-green-50 border-green-200
                                            @break
                                        @case('canceled')
                                            text-red-700 bg-red-50 border-red-200
                                            @break
                                        @default
                                            text-slate-700 bg-slate-50 border-slate-200
                                    @endswitch">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="canceled" {{ $order->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                            </select>
                        </form>
                    </td>
                    <td class="py-4 px-6 text-slate-700 font-light">{{ $order->created_at->format('M d, Y H:i') }}</td>
                    <td class="py-4 px-6">
                        <div class="flex justify-center items-center gap-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}" 
                               class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300"
                               title="View Details">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>

                            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-300"
                                        title="Delete Order">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-12 px-6 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-lg font-medium text-slate-900">No orders found</p>
                            @if($search ?? false)
                                <p class="text-sm text-slate-600 font-light">Try adjusting your search terms</p>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($orders->hasPages())
<div class="mt-6">
    {{ $orders->links() }}
</div>
@endif
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            opacity: 0;
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
@endsection