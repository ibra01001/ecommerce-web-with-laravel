@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')

    <!-- Dashboard Hero -->
    <div class="pt-8 pb-12 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between fade-in">
                <div class="space-y-2">
                    <h1 class="text-4xl md:text-5xl font-light text-slate-900 tracking-tight">
                        Dashboard
                    </h1>
                    <p class="text-slate-600 text-lg font-light">
                        Welcome back. Here's your store overview.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="px-6 pb-12">
        <div class="max-w-7xl mx-auto">
            <div class="mb-8 fade-in">
                <h2 class="text-2xl font-light text-slate-900 tracking-tight">Performance Overview</h2>
                <p class="text-slate-600 text-sm font-light mt-1">Key metrics at a glance</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 fade-in">

                <!-- Total Revenue -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white p-8 rounded-lg">
                    <div class="flex items-start justify-between mb-6">
                        <div class="w-12 h-12 bg-white/10 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>

                        </div>

                        @if($revenueGrowth != 0)
                            <span
                                class="px-2 py-1 rounded-full text-xs font-medium {{ $revenueGrowth > 0 ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' }}">
                                {{ $revenueGrowth > 0 ? '+' : '' }}{{ number_format($revenueGrowth, 1) }}%
                            </span>
                        @endif
                    </div>

                    <div class="space-y-1">
                        <p class="text-white/70 text-sm font-medium uppercase tracking-wider">Total Revenue</p>
                        <p class="text-4xl font-light">{{ number_format($totalRevenue, 0) }}</p>
                        <p class="text-xs text-white/50 mt-2">DA</p>
                    </div>
                </div>

                <!-- This Month Revenue -->
                <div
                    class="bg-white border border-slate-200 p-8 rounded-lg hover:border-slate-300 transition-all duration-300">
                    <div class="flex items-start justify-between mb-6">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>

                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">This Month</p>
                        <p class="text-4xl font-light text-slate-900">{{ number_format($thisMonthRevenue, 0) }}</p>
                        <p class="text-xs text-slate-400 mt-2">DA</p>
                    </div>
                </div>

                <!-- Average Order Value -->
                <div
                    class="bg-white border border-slate-200 p-8 rounded-lg hover:border-slate-300 transition-all duration-300">
                    <div class="flex items-start justify-between mb-6">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Avg Order Value</p>
                        <p class="text-4xl font-light text-slate-900">{{ number_format($averageOrderValue, 0) }}</p>
                        <p class="text-xs text-slate-400 mt-2">DA</p>
                    </div>
                </div>

                <!-- Today's Orders -->
                <div
                    class="bg-white border border-slate-200 p-8 rounded-lg hover:border-slate-300 transition-all duration-300">
                    <div class="flex items-start justify-between mb-6">
                        <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-slate-500 text-sm font-medium uppercase tracking-wider">Today's Orders</p>
                        <p class="text-4xl font-light text-slate-900">{{ $todayOrders }}</p>
                        <p class="text-xs text-slate-400 mt-2">New orders</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="px-6 pb-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 fade-in">

                <!-- Total Products -->
                <div class="bg-white border border-slate-200 p-6 rounded-lg hover:border-slate-300 transition-all">
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <p class="text-slate-500 text-xs uppercase">Products</p>
                            <p class="text-3xl font-light text-slate-900">{{ $productsCount }}</p>
                        </div>
                        <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                            </svg>

                        </div>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="bg-white border border-slate-200 p-6 rounded-lg hover:border-slate-300 transition-all">
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <p class="text-slate-500 text-xs uppercase">Pending</p>
                            <p class="text-3xl font-light text-slate-900">{{ $pendingOrders }}</p>
                        </div>
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Processing Orders -->
                <div class="bg-white border border-slate-200 p-6 rounded-lg hover:border-slate-300 transition-all">
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <p class="text-slate-500 text-xs uppercase">Confirmed</p>
                            <p class="text-3xl font-light text-slate-900">{{ $processingOrders }}</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Completed Orders -->
                <div class="bg-white border border-slate-200 p-6 rounded-lg hover:border-slate-300 transition-all">
                    <div class="flex items-center justify-between">
                        <div class="space-y-1">
                            <p class="text-slate-500 text-xs uppercase">Completed</p>
                            <p class="text-3xl font-light text-slate-900">{{ $completedOrders }}</p>
                        </div>
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Top Selling Products -->
    @if($topSellingProducts->count() > 0)
        <div class="px-6 pb-12">
            <div class="max-w-7xl mx-auto">
                <div class="bg-white border border-slate-200 rounded-lg overflow-hidden fade-in">
                    <div class="p-8 border-b border-slate-200">
                        <h2 class="text-2xl font-light text-slate-900">Top Selling Products</h2>
                        <p class="text-slate-600 text-sm">Best performers in the last 30 days</p>
                    </div>

                    <div class="p-8 space-y-4">
                        @foreach($topSellingProducts as $index => $item)
                            <div class="flex items-center gap-4 p-4 bg-slate-50 rounded-lg hover:bg-slate-100">
                                <div class="w-8 h-8 rounded-full bg-slate-900 text-white flex items-center justify-center">
                                    {{ $index + 1 }}
                                </div>

                                <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}"
                                    class="w-12 h-12 object-cover rounded-lg">

                                <div class="flex-1">
                                    <p class="text-slate-900 font-medium">{{ $item->product->name }}</p>
                                    <p class="text-slate-600 text-sm">{{ number_format($item->product->price, 0) }} DA</p>
                                </div>

                                <div class="text-right">
                                    <p class="text-slate-900 font-medium">{{ $item->total_sold }}</p>
                                    <p class="text-slate-600 text-sm">sold</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    @endif

    <!-- Recent Orders -->
    <div class="px-6 pb-12">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white border border-slate-200 rounded-lg overflow-hidden fade-in">

                <div class="p-8 border-b border-slate-200 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-light text-slate-900">Recent Orders</h2>
                        <p class="text-slate-600 text-sm">Latest customer orders</p>
                    </div>

                    <a href="{{ route('admin.orders.index') }}"
                        class="text-sm font-medium text-slate-900 hover:text-slate-600 inline-flex items-center gap-2">
                        View All
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="text-left py-4 px-8 text-xs uppercase text-slate-600">Order ID</th>
                                <th class="text-left py-4 px-8 text-xs uppercase text-slate-600">Customer</th>
                                <th class="text-left py-4 px-8 text-xs uppercase text-slate-600">Status</th>
                                <th class="text-right py-4 px-8 text-xs uppercase text-slate-600">Total</th>
                                <th class="text-right py-4 px-8 text-xs uppercase text-slate-600">Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="py-5 px-8">
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="font-medium text-slate-900">
                                            #{{ $order->id }}
                                        </a>
                                    </td>
                                    <td class="py-5 px-8 text-slate-900">{{ $order->customer_name }}</td>

                                    <td class="py-5 px-8">
                                        <span class="px-3 py-1 rounded-full text-xs font-medium
                                                                                @if($order->status === 'completed') bg-green-50 text-green-700
                                                                                @elseif($order->status === 'confirmed') bg-blue-50 text-blue-700
                                                                                @elseif($order->status === 'pending') bg-yellow-50 text-yellow-700
                                                                                @elseif($order->status === 'cancelled') bg-red-50 text-red-700
                                                                                @endif">

                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <td class="py-5 px-8 text-right font-medium text-slate-900">
                                        {{ number_format($order->total_amount, 0) }} DA
                                    </td>

                                    <td class="py-5 px-8 text-right text-sm text-slate-600">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="py-16 text-center">
                                        <div class="space-y-4">
                                            <div
                                                class="w-16 h-16 mx-auto bg-slate-100 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </div>

                                            <div>
                                                <p class="text-slate-900 text-lg font-medium">No orders yet</p>
                                                <p class="text-slate-600 text-sm font-light">Orders will appear here once
                                                    customers start purchasing</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="px-6 pb-16">
        <div class="max-w-7xl mx-auto">

            <div class="mb-8 fade-in">
                <h2 class="text-2xl font-light text-slate-900 tracking-tight">Quick Actions</h2>
                <p class="text-slate-600 text-sm font-light mt-1">Manage your store efficiently</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 fade-in">

                <a href="{{ route('admin.products.create') }}"
                    class="group bg-white border-2 border-slate-200 p-8 rounded-lg hover:border-slate-900 transition-all">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center group-hover:bg-slate-900">
                            <svg class="w-6 h-6 text-slate-900 group-hover:text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </div>

                        <div class="flex-1 space-y-2">
                            <h3 class="text-lg font-medium text-slate-900">Add New Product</h3>
                            <p class="text-slate-600 text-sm font-light leading-relaxed">Create and publish a new product
                                listing</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="group bg-white border-2 border-slate-200 p-8 rounded-lg hover:border-slate-900 transition-all">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center group-hover:bg-slate-900">

                            <svg class="w-6 h-6 text-slate-900 group-hover:text-white" fill="none" stroke="currentColor"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>

                        </div>
                        <div class="flex-1 space-y-2">
                            <h3 class="text-lg font-medium text-slate-900">Manage Categories</h3>
                            <p class="text-slate-600 text-sm font-light">View and organize product categories</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="group bg-white border-2 border-slate-200 p-8 rounded-lg hover:border-slate-900 transition-all">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center group-hover:bg-slate-900">
                            <svg class="w-6 h-6 text-slate-900 group-hover:text-white" fill="none" stroke="currentColor"xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>

                        </div>
                        <div class="flex-1 space-y-2">
                            <h3 class="text-lg font-medium text-slate-900">Manage Orders</h3>
                            <p class="text-slate-600 text-sm font-light">Process and track customer orders</p>
                        </div>
                    </div>
                </a>

            </div>

        </div>
    </div>

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