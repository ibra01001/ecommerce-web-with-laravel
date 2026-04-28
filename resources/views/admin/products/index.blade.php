@extends('admin.layout')
@section('title', 'Products')
@section('content')

    <div class="min-h-screen py-8 px-6" style="background: var(--background-color);">
            <div class="max-w-7xl mx-auto">

                <!-- Header Section -->
                <div class="mb-8 fade-in">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h1 class="text-4xl font-light tracking-tight text-theme-text mb-2">
                                Products
                            </h1>
                            <p class="text-lg font-light"
                                style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                                Manage your product inventory and catalog
                            </p>
                        </div>

                        <!-- Add Product Button -->
                        <a href="{{ route('admin.products.create') }}"
                            class="px-8 py-4 text-white font-medium rounded-xl transition-all duration-300 text-center"
                            style="background: var(--primary-color);"
                            onmouseover="this.style.background='var(--secondary-color)'; this.style.transform='translateY(-2px)'"
                            onmouseout="this.style.background='var(--primary-color)'; this.style.transform='translateY(0)'">
                            Add Product
                        </a>
                    </div>
                </div>

                <!-- Success Alert -->
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-xl flex items-center gap-3 fade-in"
                        style="background: color-mix(in srgb, #10b981 10%, transparent); border-left: 4px solid #10b981;">
                        <svg class="w-6 h-6" style="color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-theme-text font-light">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Search Bar -->
                <div class="mb-6 fade-in">
                    <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col md:flex-row gap-4">
                        <!-- Search Input -->
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search products by name..."
                                class="w-full px-6 py-4 border-2 border-transparent bg-transparent text-theme-text focus:outline-none transition-all duration-300 rounded-xl"
                                style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);"
                                onfocus="this.style.borderColor='var(--primary-color)'"
                                onblur="this.style.borderColor='transparent'">
                        </div>

                        <!-- Search Button -->
                        <button type="submit" class="px-8 py-4 text-white font-medium rounded-xl transition-all duration-300"
                            style="background: var(--primary-color);"
                            onmouseover="this.style.background='var(--secondary-color)'; this.style.transform='translateY(-2px)'"
                            onmouseout="this.style.background='var(--primary-color)'; this.style.transform='translateY(0)'">
                            Search
                        </button>

                        <!-- Clear Button -->
                        @if(request('search'))
                            <a href="{{ route('admin.products.index') }}"
                                class="px-8 py-4 text-theme-text font-medium rounded-xl transition-all duration-300 text-center"
                                style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);"
                                onmouseover="this.style.background='var(--primary-color)'; this.style.color='white'"
                                onmouseout="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'; this.style.color='var(--text-color)'">
                                Clear
                            </a>
                        @endif
                    </form>

                    <!-- Search Results Info -->
                    @if(request('search'))
                        <div class="mt-3 text-sm font-light"
                            style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                            Showing results for "<span class="font-semibold text-theme-text">{{ request('search') }}</span>"
                            <span style="color: color-mix(in srgb, var(--text-color) 40%, transparent);">•</span>
                            <span class="font-semibold text-theme-text">{{ $products->total() }}</span> product(s) found
                        </div>
                    @endif
                </div>

                <!-- Bulk Actions Bar -->
                <div id="bulkActionsBar" class="mb-6 p-4 rounded-xl hidden fade-in"
                    style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                    <div class="flex items-center justify-between">
                        <span class="text-theme-text font-light">
                            <span id="selectedCount">0</span> product(s) selected
                        </span>
                        <div class="flex gap-3">
                            <button onclick="bulkDelete()"
                                class="px-6 py-2 text-white font-medium rounded-lg transition-all duration-300"
                                style="background: #ef4444;" onmouseover="this.style.background='#dc2626'"
                                onmouseout="this.style.background='#ef4444'">
                                Delete Selected
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="rounded-2xl overflow-hidden fade-in"
                    style="background: color-mix(in srgb, var(--primary-color) 3%, transparent);">
                    @if($products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr style="background: color-mix(in srgb, var(--primary-color) 8%, transparent);">
                                        <th class="px-6 py-4 text-left">
                                            <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"
                                                class="w-5 h-5 rounded cursor-pointer">
                                        </th>
                                        <th
                                            class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider text-theme-text">
                                            Image</th>
                                        <th
                                            class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider text-theme-text">
                                            Name</th>
                                        <th
                                            class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider text-theme-text">
                                            Price</th>
                                        <th
                                            class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider text-theme-text">
                                            Stock</th>
                                        <th
                                            class="px-6 py-4 text-left text-sm font-medium uppercase tracking-wider text-theme-text">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y"
                                    style="border-color: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                                    @foreach($products as $product)
                                        <tr class="product-row hover:bg-opacity-50 transition-all duration-300"
                                            style="background: transparent;"
                                            onmouseover="this.style.background='color-mix(in srgb, var(--primary-color) 5%, transparent)'"
                                            onmouseout="this.style.background='transparent'">
                                            <td class="px-6 py-4">
                                                <input type="checkbox" value="{{ $product->id }}"
                                                    class="product-checkbox w-5 h-5 rounded cursor-pointer"
                                                    onchange="updateBulkActions()">
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($product->primary_image_url || $product->image)
                                                    <div class="relative w-20 h-20 rounded-xl overflow-hidden"
                                                        style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                                                        <img src="{{ $product->primary_image_url ?? $product->image }}"
                                                            alt="{{ $product->name }}"
                                                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-110">
                                                        @if($product->images->count() > 1)
                                                            <span
                                                                class="absolute -top-2 -right-2 text-white text-xs font-medium px-2 py-1 rounded-full"
                                                                style="background: var(--primary-color);">
                                                                {{ $product->images->count() }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="w-20 h-20 rounded-xl flex items-center justify-center"
                                                        style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                                                        <svg class="w-10 h-10"
                                                            style="color: color-mix(in srgb, var(--text-color) 30%, transparent);"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-theme-text font-medium">{{ $product->name }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-theme-text font-light">{{ number_format($product->price, 2) }} DA
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($product->total_stock > 10)
                                                    <span class="px-3 py-1 text-xs font-medium rounded-full"
                                                        style="background: color-mix(in srgb, #10b981 20%, transparent); color: #10b981;">
                                                        {{ $product->total_stock }} units
                                                    </span>
                                                @elseif($product->total_stock > 0)
                                                    <span class="px-3 py-1 text-xs font-medium rounded-full"
                                                        style="background: color-mix(in srgb, #f59e0b 20%, transparent); color: #f59e0b;">
                                                        {{ $product->total_stock }} units
                                                    </span>
                                                @else
                                                    <span class="px-3 py-1 text-xs font-medium rounded-full"
                                                        style="background: color-mix(in srgb, #ef4444 20%, transparent); color: #ef4444;">
                                                        Out of stock
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex gap-2">
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('admin.products.edit', $product) }}"
                                                        class="p-2 rounded-lg transition-all duration-300"
                                                        style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);"
                                                        onmouseover="this.style.background='var(--primary-color)'; this.querySelector('svg').style.color='white'"
                                                        onmouseout="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'; this.querySelector('svg').style.color='var(--primary-color)'"
                                                        title="Edit Product">
                                                        <svg class="w-5 h-5 transition-colors" style="color: var(--primary-color);"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                                        class="inline"
                                                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 rounded-lg transition-all duration-300"
                                                            style="background: color-mix(in srgb, #ef4444 10%, transparent);"
                                                            onmouseover="this.style.background='#ef4444'; this.querySelector('svg').style.color='white'"
                                                            onmouseout="this.style.background='color-mix(in srgb, #ef4444 10%, transparent)'; this.querySelector('svg').style.color='#ef4444'"
                                                            title="Delete Product">
                                                            <svg class="w-5 h-5 transition-colors" style="color: #ef4444;" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
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
                        @if($products->hasPages())
                            <div class="px-6 py-4"
                                style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                                {{ $products->appends(['search' => request('search')])->links() }}
                            </div>
                        @endif
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-16">
                            <svg class="w-24 h-24 mx-auto mb-4"
                                style="color: color-mix(in srgb, var(--text-color) 30%, transparent);" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <h3 class="text-2xl font-light text-theme-text mb-2">No products found</h3>
                            <p class="font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
                                @if(request('search'))
                                    No products match "{{ request('search') }}" - try a different search term
                                @else
                                    Add your first product to get started
                                @endif
                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        <!-- Bulk Delete Form (Hidden) -->
        <form id="bulkDeleteForm" action="{{ route('admin.products.destroy-multiple') }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
            <input type="hidden" name="product_ids" id="bulkDeleteIds">
        </form>

        <style>
            /* Animations */
            .fade-in {
                animation: fadeInUp 0.6s ease-out forwards;
                opacity: 0;
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Custom Checkbox Styling */
            input[type="checkbox"] {
                accent-color: var(--primary-color);
            }

            /* Smooth transitions for images */
            img {
                transition: transform 0.3s ease;
            }
        </style>

        <script>
            // Select All Checkboxes
            function toggleSelectAll(checkbox) {
                const checkboxes = document.querySelectorAll('.product-checkbox');
                checkboxes.forEach(cb => cb.checked = checkbox.checked);
                updateBulkActions();
            }

            // Update Bulk Actions Bar
            function updateBulkActions() {
                const checkboxes = document.querySelectorAll('.product-checkbox:checked');
                const bulkBar = document.getElementById('bulkActionsBar');
                const selectedCount = document.getElementById('selectedCount');

                selectedCount.textContent = checkboxes.length;

                if (checkboxes.length > 0) {
                    bulkBar.classList.remove('hidden');
                } else {
                    bulkBar.classList.add('hidden');
                }
            }

            // Bulk Delete
            function bulkDelete() {
                const checkboxes = document.querySelectorAll('.product-checkbox:checked');
                const ids = Array.from(checkboxes).map(cb => cb.value);

                if (ids.length === 0) return;

                if (confirm(`Are you sure you want to delete ${ids.length} product(s)?`)) {
                    document.getElementById('bulkDeleteIds').value = JSON.stringify(ids);
                    document.getElementById('bulkDeleteForm').submit();
                }
            }
        </script>

@endsection