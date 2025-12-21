@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')

    <!-- Dashboard Hero -->
    <div class="pt-8 pb-12 px-6 fade-in">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-2">
                    <h1 class="text-4xl md:text-5xl font-light tracking-tight" style="color: var(--text-color);">
                        Dashboard
                    </h1>
                    <p class="text-lg font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
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
                <h2 class="text-2xl font-light tracking-tight" style="color: var(--text-color);">Performance Overview</h2>
                <p class="text-sm font-light mt-1" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Key metrics at a glance</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 fade-in">

                <!-- Total Revenue -->
                <div class="rounded-xl p-6 lg:p-8 border-2 transition-all duration-300 hover:shadow-xl group"
                     style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color)); border-color: transparent;">
                    <div class="flex items-start justify-between mb-6">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300"
                             style="background: color-mix(in srgb, var(--background-color) 15%, transparent);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6" style="color: var(--background-color);">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>
                        </div>

                        @if($revenueGrowth != 0)
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $revenueGrowth > 0 ? 'bg-green-500/20' : 'bg-red-500/20' }}"
                                  style="color: var(--background-color);">
                                {{ $revenueGrowth > 0 ? '+' : '' }}{{ number_format($revenueGrowth, 1) }}%
                            </span>
                        @endif
                    </div>

                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-widest" style="color: color-mix(in srgb, var(--background-color) 80%, transparent);">Total Revenue</p>
                        <p class="text-3xl lg:text-4xl font-light" style="color: var(--background-color);">{{ number_format($totalRevenue, 0) }}</p>
                        <p class="text-xs font-light mt-2" style="color: color-mix(in srgb, var(--background-color) 70%, transparent);">DA</p>
                    </div>
                </div>

                <!-- This Month Revenue -->
                <div class="rounded-xl p-6 lg:p-8 border-2 transition-all duration-300 hover:shadow-xl hover:border-opacity-100"
                     style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 15%, transparent);">
                    <div class="flex items-start justify-between mb-6">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center"
                             style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6" style="color: var(--primary-color);">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-widest" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">This Month</p>
                        <p class="text-3xl lg:text-4xl font-light" style="color: var(--text-color);">{{ number_format($thisMonthRevenue, 0) }}</p>
                        <p class="text-xs font-light mt-2" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">DA</p>
                    </div>
                </div>

                <!-- Average Order Value -->
                <div class="rounded-xl p-6 lg:p-8 border-2 transition-all duration-300 hover:shadow-xl hover:border-opacity-100"
                     style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 15%, transparent);">
                    <div class="flex items-start justify-between mb-6">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center"
                             style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                            <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-widest" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Avg Order Value</p>
                        <p class="text-3xl lg:text-4xl font-light" style="color: var(--text-color);">{{ number_format($averageOrderValue, 0) }}</p>
                        <p class="text-xs font-light mt-2" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">DA</p>
                    </div>
                </div>

                <!-- Today's Orders -->
                <div class="rounded-xl p-6 lg:p-8 border-2 transition-all duration-300 hover:shadow-xl hover:border-opacity-100"
                     style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 15%, transparent);">
                    <div class="flex items-start justify-between mb-6">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center"
                             style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                            <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <p class="text-xs font-semibold uppercase tracking-widest" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Today's Orders</p>
                        <p class="text-3xl lg:text-4xl font-light" style="color: var(--text-color);">{{ $todayOrders }}</p>
                        <p class="text-xs font-light mt-2" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">New orders</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="px-6 pb-12">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 fade-in">

                <!-- Total Products -->
                <div class="rounded-xl p-5 lg:p-6 border-2 transition-all duration-300 hover:shadow-lg hover:border-opacity-100"
                     style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 15%, transparent);">
                    <div class="flex flex-col gap-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center"
                             style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-5 h-5" style="color: var(--primary-color);">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs uppercase tracking-wider font-semibold" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Products</p>
                            <p class="text-2xl lg:text-3xl font-light" style="color: var(--text-color);">{{ $productsCount }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pending Orders -->
                <div class="rounded-xl p-5 lg:p-6 border-2 transition-all duration-300 hover:shadow-lg hover:border-opacity-100"
                     style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 15%, transparent);">
                    <div class="flex flex-col gap-4">
                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs uppercase tracking-wider font-semibold" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Pending</p>
                            <p class="text-2xl lg:text-3xl font-light" style="color: var(--text-color);">{{ $pendingOrders }}</p>
                        </div>
                    </div>
                </div>

                <!-- Processing Orders -->
                <div class="rounded-xl p-5 lg:p-6 border-2 transition-all duration-300 hover:shadow-lg hover:border-opacity-100"
                     style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 15%, transparent);">
                    <div class="flex flex-col gap-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs uppercase tracking-wider font-semibold" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Confirmed</p>
                            <p class="text-2xl lg:text-3xl font-light" style="color: var(--text-color);">{{ $processingOrders }}</p>
                        </div>
                    </div>
                </div>

                <!-- Completed Orders -->
                <div class="rounded-xl p-5 lg:p-6 border-2 transition-all duration-300 hover:shadow-lg hover:border-opacity-100"
                     style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 15%, transparent);">
                    <div class="flex flex-col gap-4">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs uppercase tracking-wider font-semibold" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Completed</p>
                            <p class="text-2xl lg:text-3xl font-light" style="color: var(--text-color);">{{ $completedOrders }}</p>
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
                <div class="rounded-xl border-2 overflow-hidden fade-in"
                     style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 15%, transparent);">
                    <div class="p-6 lg:p-8 border-b-2" style="border-color: color-mix(in srgb, var(--text-color) 10%, transparent);">
                        <h2 class="text-2xl font-light tracking-tight" style="color: var(--text-color);">Top Selling Products</h2>
                        <p class="text-sm font-light mt-1" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Best performers in the last 30 days</p>
                    </div>

                    <div class="p-4 lg:p-8 space-y-3">
                        @foreach($topSellingProducts as $index => $item)
                            <div class="flex items-center gap-4 p-4 rounded-xl transition-all duration-300 hover:shadow-md"
                                 style="background: color-mix(in srgb, var(--primary-color) 3%, transparent);">
                                <div class="w-8 h-8 rounded-full text-white flex items-center justify-center flex-shrink-0 font-semibold text-sm"
                                     style="background: var(--primary-color);">
                                    {{ $index + 1 }}
                                </div>

                                <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->name }}"
                                    class="w-12 h-12 object-cover rounded-lg flex-shrink-0">

                                <div class="flex-1 min-w-0">
                                    <p class="font-medium truncate" style="color: var(--text-color);">{{ $item->product->name }}</p>
                                    <p class="text-sm" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">{{ number_format($item->product->price, 0) }} DA</p>
                                </div>

                                <div class="text-right flex-shrink-0">
                                    <p class="font-semibold" style="color: var(--text-color);">{{ $item->total_sold }}</p>
                                    <p class="text-xs" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">sold</p>
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
            <div class="rounded-xl border-2 overflow-hidden fade-in"
                 style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 15%, transparent);">

                <div class="p-6 lg:p-8 border-b-2 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4"
                     style="border-color: color-mix(in srgb, var(--text-color) 10%, transparent);">
                    <div>
                        <h2 class="text-2xl font-light tracking-tight" style="color: var(--text-color);">Recent Orders</h2>
                        <p class="text-sm font-light mt-1" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Latest customer orders</p>
                    </div>

                    <a href="{{ route('admin.orders.index') }}"
                        class="text-sm font-medium inline-flex items-center gap-2 px-4 py-2 rounded-lg transition-all duration-300"
                        style="color: var(--primary-color); background: color-mix(in srgb, var(--primary-color) 10%, transparent);"
                        onmouseover="this.style.background='var(--primary-color)'; this.style.color='var(--background-color)'"
                        onmouseout="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'; this.style.color='var(--primary-color)'">
                        View All
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <!-- Desktop Table -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                                <th class="text-left py-4 px-8 text-xs uppercase font-semibold tracking-wider" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Order ID</th>
                                <th class="text-left py-4 px-8 text-xs uppercase font-semibold tracking-wider" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Customer</th>
                                <th class="text-left py-4 px-8 text-xs uppercase font-semibold tracking-wider" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Status</th>
                                <th class="text-right py-4 px-8 text-xs uppercase font-semibold tracking-wider" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Total</th>
                                <th class="text-right py-4 px-8 text-xs uppercase font-semibold tracking-wider" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr class="border-t transition-all duration-300"
                                    style="border-color: color-mix(in srgb, var(--text-color) 10%, transparent);"
                                    onmouseover="this.style.background='color-mix(in srgb, var(--primary-color) 3%, transparent)'"
                                    onmouseout="this.style.background='transparent'">
                                    <td class="py-5 px-8">
                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                            class="font-semibold hover:underline" style="color: var(--primary-color);">
                                            #{{ $order->id }}
                                        </a>
                                    </td>
                                    <td class="py-5 px-8 font-medium" style="color: var(--text-color);">{{ $order->customer_name }}</td>

                                    <td class="py-5 px-8">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            @if($order->status === 'completed') bg-green-50 text-green-700
                                            @elseif($order->status === 'confirmed') bg-blue-50 text-blue-700
                                            @elseif($order->status === 'pending') bg-yellow-50 text-yellow-700
                                            @elseif($order->status === 'cancelled') bg-red-50 text-red-700
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <td class="py-5 px-8 text-right font-semibold" style="color: var(--text-color);">
                                        {{ number_format($order->total_amount, 0) }} DA
                                    </td>

                                    <td class="py-5 px-8 text-right text-sm" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
                                        {{ $order->created_at->format('M d, Y') }}
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="py-16 text-center">
                                        <div class="space-y-4">
                                            <div class="w-16 h-16 mx-auto rounded-full flex items-center justify-center"
                                                 style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                                                <svg class="w-8 h-8" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                            </div>

                                            <div>
                                                <p class="text-lg font-medium" style="color: var(--text-color);">No orders yet</p>
                                                <p class="text-sm font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Orders will appear here once customers start purchasing</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="block lg:hidden p-4 space-y-3">
                    @forelse($recentOrders as $order)
                        <a href="{{ route('admin.orders.show', $order->id) }}"
                           class="block p-4 rounded-xl border-2 transition-all duration-300 active:scale-98"
                           style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 15%, transparent);"
                           ontouchstart="this.style.borderColor='var(--primary-color)'"
                           ontouchend="this.style.borderColor='color-mix(in srgb, var(--text-color) 15%, transparent)'">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <p class="text-xs uppercase tracking-wider font-semibold mb-1" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">Order ID</p>
                                    <p class="font-semibold" style="color: var(--primary-color);">#{{ $order->id }}</p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    @if($order->status === 'completed') bg-green-50 text-green-700
                                    @elseif($order->status === 'confirmed') bg-blue-50 text-blue-700
                                    @elseif($order->status === 'pending') bg-yellow-50 text-yellow-700
                                    @elseif($order->status === 'cancelled') bg-red-50 text-red-700
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Customer</span>
                                    <span class="text-sm font-medium" style="color: var(--text-color);">{{ $order->customer_name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Total</span>
                                    <span class="text-sm font-semibold" style="color: var(--text-color);">{{ number_format($order->total_amount, 0) }} DA</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Date</span>
                                    <span class="text-sm" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="py-16 text-center">
                            <div class="space-y-4">
                                <div class="w-16 h-16 mx-auto rounded-full flex items-center justify-center"
                                     style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                                    <svg class="w-8 h-8" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-lg font-medium" style="color: var(--text-color);">No orders yet</p>
                                    <p class="text-sm font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Orders will appear here once customers start purchasing</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="px-6 pb-16">
        <div class="max-w-7xl mx-auto">

            <div class="mb-8 fade-in">
                <h2 class="text-2xl font-light tracking-tight" style="color: var(--text-color);">Quick Actions</h2>
                <p class="text-sm font-light mt-1" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Manage your store efficiently</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6 fade-in">

                <a href="{{ route('admin.products.create') }}"
                    class="group rounded-xl border-2 p-6 lg:p-8 transition-all duration-300 hover:shadow-xl active:scale-98"
                    style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 15%, transparent);"
                    onmouseover="this.style.borderColor='var(--primary-color)'"
                    onmouseout="this.style.borderColor='color-mix(in srgb, var(--text-color) 15%, transparent)'">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300"
                             style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);"
                             onmouseover="this.style.background='var(--primary-color)'"
                             onmouseout="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'">
                            <svg class="w-6 h-6 transition-colors" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                 onmouseover="this.style.color='var(--background-color)'"
                                 onmouseout="this.style.color='var(--primary-color)'">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </div>

                        <div class="flex-1 space-y-2">
                            <h3 class="text-lg font-medium" style="color: var(--text-color);">Add New Product</h3>
                            <p class="text-sm font-light leading-relaxed" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Create and publish a new product listing</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="group rounded-xl border-2 p-6 lg:p-8 transition-all duration-300 hover:shadow-xl active:scale-98"
                    style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 15%, transparent);"
                    onmouseover="this.style.borderColor='var(--primary-color)'"
                    onmouseout="this.style.borderColor='color-mix(in srgb, var(--text-color) 15%, transparent)'">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300"
                             style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                            <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none" stroke="currentColor"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                            </svg>
                        </div>
                        <div class="flex-1 space-y-2">
                            <h3 class="text-lg font-medium" style="color: var(--text-color);">Manage Categories</h3>
                            <p class="text-sm font-light leading-relaxed" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">View and organize product categories</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="group rounded-xl border-2 p-6 lg:p-8 transition-all duration-300 hover:shadow-xl active:scale-98"
                    style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 15%, transparent);"
                    onmouseover="this.style.borderColor='var(--primary-color)'"
                    onmouseout="this.style.borderColor='color-mix(in srgb, var(--text-color) 15%, transparent)'">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300"
                             style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                            <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none" stroke="currentColor" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                        </div>
                        <div class="flex-1 space-y-2">
                            <h3 class="text-lg font-medium" style="color: var(--text-color);">Manage Orders</h3>
                            <p class="text-sm font-light leading-relaxed" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Process and track customer orders</p>
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

        .active\:scale-98:active {
            transform: scale(0.98);
        }
    </style>

@endsection