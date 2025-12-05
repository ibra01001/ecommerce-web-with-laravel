@extends('admin.layout')

@section('title', 'Add Product')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-semibold text-white flex items-center gap-3">
        <x-heroicon-o-plus-circle class="w-7 h-7 text-yellow-400" />
        Add New Product
    </h2>

    <a href="{{ route('admin.products.index') }}" 
       class="flex items-center gap-2 text-gray-400 hover:text-yellow-400 transition">
        <x-heroicon-o-arrow-left class="w-5 h-5" />
        Back to Products
    </a>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" 
      class="space-y-6 bg-neutral-900/60 p-6 rounded-xl border border-neutral-800 shadow-lg max-w-3xl">
    @csrf

    <!-- Name -->
    <div>
        <label class="block text-gray-400 mb-2 flex items-center gap-2">
            <x-heroicon-o-tag class="w-5 h-5 text-yellow-400" />
            Name
        </label>
        <input type="text" name="name" 
               value="{{ old('name') }}"
               class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                      focus:outline-none focus:border-yellow-400 transition" required>
        @error('name') 
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
        @enderror
    </div>

    <!-- Description -->
    <div>
        <label class="block text-gray-400 mb-2 flex items-center gap-2">
            <x-heroicon-o-document-text class="w-5 h-5 text-yellow-400" />
            Description
        </label>
        <textarea name="description" rows="4"
                  class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                         focus:outline-none focus:border-yellow-400 transition">{{ old('description') }}</textarea>
        @error('description') 
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
        @enderror
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
            <option value="" disabled selected>Select a category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" 
                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') 
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
        @enderror
    </div>  

    <!-- Price -->
    <div>
        <label class="block text-gray-400 mb-2 flex items-center gap-2">
            <x-heroicon-o-currency-dollar class="w-5 h-5 text-yellow-400" />
            Price
        </label>
        <input type="number" step="0.01" name="price" 
               value="{{ old('price') }}"
               class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                      focus:outline-none focus:border-yellow-400 transition" required>
        @error('price') 
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
        @enderror
    </div>

    <!-- Stock Type Selection -->
    <div class="border-t border-neutral-700 pt-6">
        <div class="mb-6">
            <label class="block text-gray-400 mb-2 flex items-center gap-2">
                <x-heroicon-o-cube class="w-5 h-5 text-yellow-400" />
                Stock Type
            </label>
            <select name="stock_type_id" id="stock_type_select"
                    class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                           focus:outline-none focus:border-yellow-400 transition" required>
                <option value="" disabled selected>Select stock type</option>
                @foreach($stockTypes as $stockType)
                    <option value="{{ $stockType->id }}" 
                            data-display-type="{{ $stockType->display_type }}"
                            {{ old('stock_type_id') == $stockType->id ? 'selected' : '' }}>
                        {{ $stockType->name }}
                    </option>
                @endforeach
            </select>
            @error('stock_type_id') 
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
            @enderror
        </div>

        <!-- Dynamic Stock Options Container -->
        <div id="stock-options-container" class="hidden">
            <h3 class="text-lg font-semibold text-white mb-4">Set Stock Quantities</h3>
            <div id="stock-options-grid" class="grid gap-4"></div>
        </div>

        <!-- Total Stock Display -->
        <div id="total-stock-display" class="hidden mt-4 p-4 bg-neutral-950 rounded-lg border border-yellow-400/30">
            <div class="flex justify-between items-center">
                <span class="text-gray-400 font-medium">Total Stock:</span>
                <span id="total-stock" class="text-2xl font-bold text-yellow-400">0</span>
            </div>
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
            <img id="imagePreview" src="#" alt="Image preview" 
                 class="hidden w-32 h-32 object-cover rounded-lg border border-neutral-700">
        </div>
    </div>

    <!-- Submit -->
    <div class="pt-4">
        <button type="submit" 
                class="flex items-center gap-2 bg-yellow-400 text-black px-6 py-2.5 rounded-lg font-semibold 
                       hover:bg-yellow-500 transition">
            <x-heroicon-o-check class="w-5 h-5" />
            Save Product
        </button>
    </div>
</form>

@php
$stockTypesJson = $stockTypes->map(function($type) {
    return [
        'id' => $type->id,
        'name' => $type->name,
        'display_type' => $type->display_type,
        'options' => $type->activeOptions->map(function($opt) {
            return [
                'id' => $opt->id,
                'label' => $opt->label,
                'value' => $opt->value
            ];
        })->values()
    ];
})->values();
@endphp

<script>
// Stock type data from backend
const stockTypesData = @json($stockTypesJson);

const stockTypeSelect = document.getElementById('stock_type_select'); // Changed from 'stock_type_id'
const stockOptionsContainer = document.getElementById('stock-options-container');
const stockOptionsGrid = document.getElementById('stock-options-grid');
const totalStockDisplay = document.getElementById('total-stock-display');
const totalStockElement = document.getElementById('total-stock');

// Calculate and update total stock
function updateTotalStock() {
    const stockInputs = document.querySelectorAll('input[name^="stock["]');
    let total = 0;
    
    stockInputs.forEach(input => {
        total += parseInt(input.value) || 0;
    });
    
    if (totalStockElement) {
        totalStockElement.textContent = total;
    }
}

// Handle stock type change
stockTypeSelect?.addEventListener('change', function() {
    const selectedTypeId = parseInt(this.value);
    const selectedType = stockTypesData.find(t => t.id === selectedTypeId);
    
    if (!selectedType || !selectedType.options || selectedType.options.length === 0) {
        stockOptionsContainer.classList.add('hidden');
        totalStockDisplay.classList.add('hidden');
        stockOptionsGrid.innerHTML = '';
        return;
    }
    
    // Show containers
    stockOptionsContainer.classList.remove('hidden');
    totalStockDisplay.classList.remove('hidden');
    
    // Generate stock input fields based on display type
    let html = '';
    
    if (selectedType.display_type === 'none') {
        // One size fits all
        const option = selectedType.options[0];
        html = `
            <div class="bg-neutral-950 border border-neutral-700 rounded-lg p-4">
                <label class="block text-gray-400 mb-2">Quantity</label>
                <input type="number" 
                       name="stock[${option.id}]" 
                       min="0" 
                       value="0"
                       class="w-full bg-neutral-900 border border-neutral-600 rounded-lg p-3 text-gray-200 
                              focus:outline-none focus:border-yellow-400 transition"
                       oninput="updateTotalStock()"
                       required>
            </div>
        `;
    } else {
        // Multiple options (grid, dropdown, color-swatch)
        const gridClass = selectedType.options.length > 3 ? 'grid-cols-2 md:grid-cols-3' : 'grid-cols-1';
        html = `<div class="grid ${gridClass} gap-4">`;
        
        selectedType.options.forEach(option => {
            html += `
                <div class="bg-neutral-950 border border-neutral-700 rounded-lg p-4">
                    <label class="block text-gray-400 mb-2 font-medium">${option.label}</label>
                    <input type="number" 
                           name="stock[${option.id}]" 
                           min="0" 
                           value="0"
                           class="w-full bg-neutral-900 border border-neutral-600 rounded-lg p-3 text-gray-200 
                                  focus:outline-none focus:border-yellow-400 transition"
                           oninput="updateTotalStock()"
                           required>
                </div>
            `;
        });
        
        html += '</div>';
    }
    
    stockOptionsGrid.innerHTML = html;
    updateTotalStock();
});

// Image preview function
function previewImage(event) {
    const preview = document.getElementById('imagePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
}

// Trigger change event on page load if a stock type is pre-selected
if (stockTypeSelect?.value) {
    stockTypeSelect.dispatchEvent(new Event('change'));
}
</script>
@endsection