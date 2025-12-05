@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-semibold text-white flex items-center gap-3">
        <x-heroicon-o-pencil-square class="w-7 h-7 text-yellow-400" />
        Edit Product
    </h2>

    <a href="{{ route('admin.products.index') }}" 
       class="flex items-center gap-2 text-gray-400 hover:text-yellow-400 transition">
        <x-heroicon-o-arrow-left class="w-5 h-5" />
        Back to Products
    </a>
</div>

<form action="{{ route('admin.products.update', $product->id) }}" 
      method="POST" enctype="multipart/form-data"
      class="space-y-6 bg-neutral-900/60 p-6 rounded-xl border border-neutral-800 shadow-lg max-w-3xl">
    @csrf
    @method('PUT')

    <!-- Name -->
    <div>
        <label class="block text-gray-400 mb-2 flex items-center gap-2">
            <x-heroicon-o-tag class="w-5 h-5 text-yellow-400" />
            Name
        </label>
        <input type="text" name="name" 
               value="{{ old('name', $product->name) }}"
               class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                      focus:outline-none focus:border-yellow-400 transition" required>
        @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Description -->
    <div>
        <label class="block text-gray-400 mb-2 flex items-center gap-2">
            <x-heroicon-o-document-text class="w-5 h-5 text-yellow-400" />
            Description
        </label>
        <textarea name="description" rows="4"
                  class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                         focus:outline-none focus:border-yellow-400 transition">{{ old('description', $product->description) }}</textarea>
        @error('description') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Category -->
    <div>
        <label class="block text-gray-400 mb-2 flex items-center gap-2">
            <x-heroicon-o-tag class="w-5 h-5 text-yellow-400" />
            Category
        </label>
        <select name="category_id"
                class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                       focus:outline-none focus:border-yellow-400 transition" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Price -->
    <div>
        <label class="block text-gray-400 mb-2 flex items-center gap-2">
            <x-heroicon-o-currency-dollar class="w-5 h-5 text-yellow-400" />
            Price
        </label>
        <input type="number" step="0.01" name="price" 
               value="{{ old('price', $product->price) }}"
               class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                      focus:outline-none focus:border-yellow-400 transition" required>
        @error('price') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Stock Type Selection -->
    <div class="border-t border-neutral-700 pt-6">
        <label class="block text-gray-400 mb-2 flex items-center gap-2">
            <x-heroicon-o-cube class="w-5 h-5 text-yellow-400" />
            Stock Type
        </label>
        <select name="stock_type_id" id="stock_type_select"
                class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                       focus:outline-none focus:border-yellow-400 transition" required>
            @foreach($stockTypes as $stockType)
                <option value="{{ $stockType->id }}"
                    data-display-type="{{ $stockType->display_type }}"
                    {{ old('stock_type_id', $product->stock_type_id) == $stockType->id ? 'selected' : '' }}>
                    {{ $stockType->name }}
                </option>
            @endforeach
        </select>
        @error('stock_type_id') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Dynamic Stock Options -->
    <div id="stock-options-container" class="hidden">
        <h3 class="text-lg font-semibold text-white mb-4">Update Stock Quantities</h3>
        <div id="stock-options-grid" class="grid gap-4"></div>
    </div>

    <!-- Total Stock Display -->
    <div id="total-stock-display" class="hidden mt-4 p-4 bg-neutral-950 rounded-lg border border-yellow-400/30">
        <div class="flex justify-between items-center">
            <span class="text-gray-400 font-medium">Total Stock:</span>
            <span id="total-stock" class="text-2xl font-bold text-yellow-400">{{ $product->total_stock }}</span>
        </div>
    </div>

    <!-- Image -->
    <div class="border-t border-neutral-700 pt-6">
        <label class="block text-gray-400 mb-2 flex items-center gap-2">
            <x-heroicon-o-photo class="w-5 h-5 text-yellow-400" />
            Product Image
        </label>
        <input type="file" name="image" accept="image/*" 
               class="text-gray-300 block w-full file:bg-yellow-400 file:text-black 
                      file:px-4 file:py-2 file:rounded-lg file:border-0 hover:file:bg-yellow-500 transition"
               onchange="previewImage(event)">
        
        <div class="mt-4">
            @if($product->image)
                <img id="imagePreview" src="{{ asset($product->image) }}"
                     class="w-32 h-32 object-cover rounded-lg border border-neutral-700">
            @else
                <img id="imagePreview" src="#" 
                     class="hidden w-32 h-32 object-cover rounded-lg border border-neutral-700">
            @endif
        </div>
    </div>

    <div class="pt-4">
        <button type="submit" 
                class="flex items-center gap-2 bg-yellow-400 text-black px-6 py-2.5 rounded-lg font-semibold 
                       hover:bg-yellow-500 transition">
            <x-heroicon-o-check class="w-5 h-5" />
            Update Product
        </button>
    </div>
</form>

@php
$stockTypesJson = $stockTypes->map(function($type) use ($product) {
    return [
        'id' => $type->id,
        'name' => $type->name,
        'display_type' => $type->display_type,
        'options' => $type->activeOptions->map(function($opt) use ($product) {
            return [
                'id' => $opt->id,
                'label' => $opt->label,
                'value' => $opt->value,
                'stock' => $product->getStockForOption($opt->id)

            ];
        })->values()
    ];
})->values();
@endphp

<script>
const stockTypesData = @json($stockTypesJson);
const stockTypeSelect = document.getElementById('stock_type_select');
const stockOptionsContainer = document.getElementById('stock-options-container');
const stockOptionsGrid = document.getElementById('stock-options-grid');
const totalStockDisplay = document.getElementById('total-stock-display');
const totalStockElement = document.getElementById('total-stock');

function updateTotalStock() {
    const stockInputs = document.querySelectorAll('input[name^="stock["]');
    let total = 0;
    stockInputs.forEach(input => total += parseInt(input.value) || 0);
    totalStockElement.textContent = total;
}

stockTypeSelect?.addEventListener('change', function () {
    const type = stockTypesData.find(t => t.id == this.value);

    if (!type || !type.options.length) {
        stockOptionsContainer.classList.add('hidden');
        totalStockDisplay.classList.add('hidden');
        stockOptionsGrid.innerHTML = '';
        return;
    }

    stockOptionsContainer.classList.remove('hidden');
    totalStockDisplay.classList.remove('hidden');

    let html = '';

    if (type.display_type === 'none') {
        const option = type.options[0];
        html = `
            <div class="bg-neutral-950 border border-neutral-700 rounded-lg p-4">
                <label class="block text-gray-400 mb-2">Quantity</label>
                <input type="number" name="stock[${option.id}]"
                       value="${option.stock ?? 0}" min="0"
                       class="w-full bg-neutral-900 border border-neutral-600 rounded-lg p-3 text-gray-200
                              focus:outline-none focus:border-yellow-400 transition"
                       oninput="updateTotalStock()" required>
            </div>`;
    } else {
        const gridClass = type.options.length > 3 ? 'grid-cols-2 md:grid-cols-3' : 'grid-cols-1';
        html = `<div class="grid ${gridClass} gap-4">`;
        type.options.forEach(option => {
            html += `
                <div class="bg-neutral-950 border border-neutral-700 rounded-lg p-4">
                    <label class="block text-gray-400 mb-2 font-medium">${option.label}</label>
                    <input type="number" name="stock[${option.id}]"
                           value="${option.stock ?? 0}" min="0"
                           class="w-full bg-neutral-900 border border-neutral-600 rounded-lg p-3 text-gray-200
                                  focus:outline-none focus:border-yellow-400 transition"
                           oninput="updateTotalStock()" required>
                </div>`;
        });
        html += `</div>`;
    }

    stockOptionsGrid.innerHTML = html;
    updateTotalStock();
});

// Preview image
function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

// Auto-build stock grid for current product
stockTypeSelect.dispatchEvent(new Event('change'));
</script>
@endsection
