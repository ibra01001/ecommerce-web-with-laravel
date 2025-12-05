@extends('admin.layout')

@section('title', 'Dashboard')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-neutral-900 border border-neutral-800 p-6 rounded-xl">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-gray-400 text-sm">Total Products</h3>
            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
        </div>
        <p class="text-3xl font-semibold text-yellow-400">{{ $productsCount }}</p>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 p-6 rounded-xl">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-gray-400 text-sm">Categories</h3>
            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>
        <p class="text-3xl font-semibold text-yellow-400">{{ $categoriesCount }}</p>
    </div>

    <div class="bg-neutral-900 border border-neutral-800 p-6 rounded-xl">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-gray-400 text-sm">Users</h3>
            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <p class="text-3xl font-semibold text-yellow-400">{{ $usersCount }}</p>
    </div>

    <!-- Orders Card -->
    <div class="bg-neutral-900 border border-neutral-800 p-6 rounded-xl">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-gray-400 text-sm">Orders</h3>
            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
            </svg>
        </div>
        <p class="text-3xl font-semibold text-yellow-400">{{ $ordersCount ?? 0 }}</p>
    </div>
</div>

<!-- Charts and Tables Section -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
    <!-- Monthly Products Chart -->
    <div class="bg-neutral-900 border border-neutral-800 p-6 rounded-xl">
        <h3 class="text-lg font-semibold mb-4">Products Added (Monthly)</h3>
        <canvas id="monthlyProductsChart" height="200"></canvas>
    </div>

    <!-- Recent Products -->
    <div class="bg-neutral-900 border border-neutral-800 p-6 rounded-xl">
        <h3 class="text-lg font-semibold mb-4">Recent Products</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-gray-400 border-b border-neutral-800">
                        <th class="text-left py-3">Product</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Quantity</th>
                        <th class="text-right">Added</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentProducts as $product)
                    <tr class="border-b border-neutral-800">
                        <td class="py-3">{{ $product->name }}</td>
                        <td class="text-right">{{ number_format($product->price, 2) }} DA</td>
                        <td class="text-right">{{ $product->usesDynamicStock() ? $product->total_stock : ($product->stock_type === 'size-based' ? ($product->taille_S + $product->taille_M + $product->taille_L + $product->taille_XL + $product->taille_XXL) : $product->total_quantity) }}</td>
                        <td class="text-right">{{ $product->created_at->diffForHumans() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('admin.products.create') }}" class="bg-neutral-900 border border-neutral-800 p-6 rounded-xl hover:bg-neutral-800 transition">
        <h3 class="text-lg font-semibold mb-2">Add New Product</h3>
        <p class="text-gray-400 text-sm">Create and publish a new product listing</p>
    </a>
    
    <a href="{{ route('admin.categories.index') }}" class="bg-neutral-900 border border-neutral-800 p-6 rounded-xl hover:bg-neutral-800 transition">
        <h3 class="text-lg font-semibold mb-2">Manage Categories</h3>
        <p class="text-gray-400 text-sm">View and organize product categories</p>
    </a>

    <a href="#" class="bg-neutral-900 border border-neutral-800 p-6 rounded-xl hover:bg-neutral-800 transition">
        <h3 class="text-lg font-semibold mb-2">View Reports</h3>
        <p class="text-gray-400 text-sm">Access detailed sales and inventory reports</p>
    </a>
</div>

@push('scripts')
<script>
    // Monthly Products Chart
    const ctx = document.getElementById('monthlyProductsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Products Added',
                data: @json($monthlyProducts->pluck('count')),
                borderColor: '#facc15',
                tension: 0.4,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#262626'
                    },
                    ticks: {
                        color: '#d1d5db'
                    }
                },
                x: {
                    grid: {
                        color: '#262626'
                    },
                    ticks: {
                        color: '#d1d5db'
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection
