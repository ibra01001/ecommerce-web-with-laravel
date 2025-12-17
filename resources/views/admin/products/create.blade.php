@extends('admin.layout')

@section('title', 'Create Product')

@section('content')
{{-- --- Custom CSS to remove number input spin buttons --- --}}
<style>
/* Hides the spin buttons from number inputs across browsers */
.no-spinners::-webkit-outer-spin-button,
.no-spinners::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

.no-spinners[type=number] {
  -moz-appearance: textfield;
}
</style>
{{-- --------------------------------------------------- --}}

<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-semibold text-slate-900 flex items-center gap-3">
        <x-heroicon-o-plus class="w-7 h-7 text-slate-900" />
        Create Product
    </h2>

    <a href="{{ route('admin.products.index') }}" 
       class="flex items-center gap-2 text-slate-600 hover:text-slate-900 transition duration-300 font-medium">
        <x-heroicon-o-arrow-left class="w-5 h-5" />
        Back to Products
    </a>
</div>

@if($errors->any())
<div class="mb-6 bg-red-50 border-2 border-red-200 text-red-800 px-6 py-4 rounded-xl">
    <div class="flex items-start gap-3">
        <x-heroicon-o-exclamation-triangle class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" />
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li class="font-medium">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<form action="{{ route('admin.products.store') }}" 
      method="POST" enctype="multipart/form-data"
      class="space-y-8 bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm max-w-5xl">
    @csrf

    {{-- Name --}}
    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <x-heroicon-o-tag class="w-5 h-5 text-slate-900" />
            Name *
        </label>
        <input type="text" name="name" 
               value="{{ old('name') }}"
               class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                      focus:outline-none focus:border-slate-900 transition-all duration-300" required>
        @error('name') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    {{-- Description --}}
    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <x-heroicon-o-document-text class="w-5 h-5 text-slate-900" />
            Description
        </label>
        <textarea name="description" rows="4"
                  class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-light
                         focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none">{{ old('description') }}</textarea>
        @error('description') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        {{-- Category --}}
        <div>
            <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                <x-heroicon-o-archive-box class="w-5 h-5 text-slate-900" />
                Category *
            </label>
            <select name="category_id"
                    class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                           focus:outline-none focus:border-slate-900 transition-all duration-300 appearance-none pr-8" required>
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
        </div>

        {{-- Price --}}
        <div>
            <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                <x-heroicon-o-currency-dollar class="w-5 h-5 text-slate-900" />
                Price * (DA)
            </label>
            <input type="number" step="0.01" name="price" 
                   value="{{ old('price') }}"
                   class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                          focus:outline-none focus:border-slate-900 transition-all duration-300 no-spinners" required>
            @error('price') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
        </div>
    </div>

    {{-- Stock Type --}}
    <div class="border-t-2 border-slate-200 pt-8">
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <x-heroicon-o-cube class="w-5 h-5 text-slate-900" />
            Stock Type *
        </label>
        <select name="stock_type_id" id="stock_type_select"
                class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                       focus:outline-none focus:border-slate-900 transition-all duration-300 appearance-none pr-8" required>
            <option value="">Select a stock type</option>
            @foreach($stockTypes as $stockType)
                <option value="{{ $stockType->id }}"
                    data-display-type="{{ $stockType->display_type }}"
                    {{ old('stock_type_id') == $stockType->id ? 'selected' : '' }}>
                    {{ $stockType->name }}
                </option>
            @endforeach
        </select>
        @error('stock_type_id') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <div id="stock-options-container" class="hidden">
        <h3 class="text-xl font-semibold text-slate-900 mb-4">Set Stock Quantities</h3>
        <div id="stock-options-grid" class="grid gap-4"></div>
    </div>

    <div id="total-stock-display" class="hidden mt-4 p-4 bg-slate-50 rounded-xl border border-slate-300">
        <div class="flex justify-between items-center">
            <span class="text-slate-700 font-medium">Total Stock:</span>
            <span id="total-stock" class="text-2xl font-bold text-slate-900">0</span>
        </div>
    </div>

    {{-- Product Images --}}
    <div class="border-t-2 border-slate-200 pt-8">
        <label class="block text-slate-700 font-medium mb-4 flex items-center gap-2">
            <x-heroicon-o-photo class="w-5 h-5 text-slate-900" />
            Product Images *
        </label>
        
        <div id="images-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
        </div>

        <div class="flex items-center gap-4">
            <label for="add-image-input" class="inline-block cursor-pointer">
                <div class="bg-slate-900 text-white px-6 py-2.5 rounded-full font-medium hover:bg-slate-800 transition inline-flex items-center gap-2 shadow-md">
                    <x-heroicon-o-plus class="w-5 h-5" />
                    Add Image
                </div>
            </label>
            <input type="file" 
                   id="add-image-input"
                   accept="image/*"
                   class="hidden"
                   onchange="addImage(event)">
            <p class="text-slate-500 text-sm">Add images one by one (max 2MB each). First image will be primary.</p>
        </div>
        
        <div id="hidden-inputs-container"></div>
        
        @error('images.*') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <div class="pt-8 flex gap-4">
        <button type="submit" 
                class="flex items-center gap-2 bg-slate-900 text-white px-8 py-4 rounded-full font-medium text-base
                       hover:bg-slate-800 transition-all duration-300 shadow-lg">
            <x-heroicon-o-check class="w-5 h-5" />
            Create Product
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
                'value' => $opt->value,
                'stock' => 0
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

let imageFiles = [];
let imageCounter = 0;

function updateTotalStock() {
    const stockInputs = document.querySelectorAll('input[name^="stock["]');
    let total = 0;
    stockInputs.forEach(input => total += parseInt(input.value) || 0);
    if (totalStockElement) totalStockElement.textContent = total;
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
            <div class="bg-slate-50 border border-slate-300 rounded-xl p-4">
                <label class="block text-slate-700 mb-2">Quantity</label>
                <input type="number" name="stock[${option.id}]"
                       value="0" min="0"
                       class="w-full bg-white border border-slate-300 rounded-full px-4 py-3 text-slate-900
                              focus:outline-none focus:border-slate-900 transition-all duration-300 no-spinners"
                       oninput="updateTotalStock()" required>
            </div>`;
    } else {
        const gridClass = type.options.length > 3 ? 'grid-cols-2 lg:grid-cols-3' : 'grid-cols-1';
        html = `<div class="grid ${gridClass} gap-4">`;
        type.options.forEach(option => {
            html += `
                <div class="bg-slate-50 border border-slate-300 rounded-xl p-4">
                    <label class="block text-slate-700 mb-2 font-medium">${option.label}</label>
                    <input type="number" name="stock[${option.id}]"
                           value="0" min="0"
                           class="w-full bg-white border border-slate-300 rounded-full px-4 py-3 text-slate-900
                                  focus:outline-none focus:border-slate-900 transition-all duration-300 no-spinners"
                           oninput="updateTotalStock()" required>
                </div>`;
        });
        html += `</div>`;
    }

    stockOptionsGrid.innerHTML = html;
    updateTotalStock();
});

function addImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) { alert('Image size must be less than 2MB'); event.target.value = ''; return; }
    if (!file.type.startsWith('image/')) { alert('Please select a valid image file'); event.target.value = ''; return; }

    const imageId = `image-${imageCounter++}`;
    const isPrimary = imageFiles.length === 0;

    imageFiles.push({ id: imageId, file: file, isPrimary: isPrimary });

    const reader = new FileReader();
    reader.onload = function(e) {
        const container = document.getElementById('images-container');
        const imageDiv = document.createElement('div');
        imageDiv.className = 'relative group shadow-sm'; 
        imageDiv.id = imageId;
        imageDiv.innerHTML = `
            <img src="${e.target.result}" 
                 class="w-full h-32 object-cover rounded-xl border-2 ${isPrimary ? 'border-slate-900' : 'border-slate-300'}">
            
            ${isPrimary ? `
                <div class="absolute top-2 left-2 bg-slate-900 text-white text-xs px-2 py-1 rounded-full font-semibold">
                    Primary
                </div>
            ` : `
                <button type="button" 
                        onclick="setPrimaryImage('${imageId}')"
                        class="absolute top-2 left-2 bg-white/80 backdrop-blur-sm text-slate-600 text-xs px-2 py-1 rounded-full hover:bg-slate-900 hover:text-white transition shadow-md">
                    Set as Primary
                </button>
            `}
            
            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 
                       transition-opacity rounded-xl flex items-center justify-center gap-2">
                <button type="button" 
                        onclick="removeImage('${imageId}')"
                        class="bg-red-600 text-white px-3 py-1.5 rounded-full text-sm hover:bg-red-700 transition flex items-center gap-1 font-medium">
                    <x-heroicon-o-trash class="w-4 h-4" />
                    Remove
                </button>
            </div>
            
            <div class="absolute bottom-2 right-2 bg-black/70 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-lg">
                ${Math.round(file.size / 1024)}KB
            </div>
        `;
        container.appendChild(imageDiv);
    };
    reader.readAsDataURL(file);

    event.target.value = '';
    updateHiddenInputs();
}

function removeImage(imageId) {
    const index = imageFiles.findIndex(img => img.id === imageId);
    if (index > -1) {
        const wasPrimary = imageFiles[index].isPrimary;
        imageFiles.splice(index, 1);
        if (wasPrimary && imageFiles.length > 0) imageFiles[0].isPrimary = true;
    }

    const element = document.getElementById(imageId);
    if (element) element.remove();

    rerenderImages();
    updateHiddenInputs();
}

function setPrimaryImage(imageId) {
    imageFiles.forEach(img => img.isPrimary = (img.id === imageId));
    rerenderImages();
}

function rerenderImages() {
    const container = document.getElementById('images-container');
    container.innerHTML = '';
    const sortedImages = [...imageFiles].sort((a,b)=>b.isPrimary-a.isPrimary);
    sortedImages.forEach(imageData => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imageDiv = document.createElement('div');
            imageDiv.className = 'relative group shadow-sm';
            imageDiv.id = imageData.id;
            imageDiv.innerHTML = `
                <img src="${e.target.result}" 
                     class="w-full h-32 object-cover rounded-xl border-2 ${imageData.isPrimary ? 'border-slate-900' : 'border-slate-300'}">
                
                ${imageData.isPrimary ? `
                    <div class="absolute top-2 left-2 bg-slate-900 text-white text-xs px-2 py-1 rounded-full font-semibold">
                        Primary
                    </div>
                ` : `
                    <button type="button" 
                            onclick="setPrimaryImage('${imageData.id}')"
                            class="absolute top-2 left-2 bg-white/80 backdrop-blur-sm text-slate-600 text-xs px-2 py-1 rounded-full hover:bg-slate-900 hover:text-white transition shadow-md">
                        Set as Primary
                    </button>
                `}
                
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 
                           transition-opacity rounded-xl flex items-center justify-center gap-2">
                    <button type="button" 
                            onclick="removeImage('${imageData.id}')"
                            class="bg-red-600 text-white px-3 py-1.5 rounded-full text-sm hover:bg-red-700 transition flex items-center gap-1 font-medium">
                        <x-heroicon-o-trash class="w-4 h-4" />
                        Remove
                    </button>
                </div>
                
                <div class="absolute bottom-2 right-2 bg-black/70 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-lg">
                    ${Math.round(imageData.file.size / 1024)}KB
                </div>
            `;
            container.appendChild(imageDiv);
        };
        reader.readAsDataURL(imageData.file);
    });
    updateHiddenInputs();
}

function updateHiddenInputs() {
    const hiddenContainer = document.getElementById('hidden-inputs-container');
    hiddenContainer.innerHTML = '';

    const sortedImages = [...imageFiles].sort((a,b)=>b.isPrimary-a.isPrimary);
    sortedImages.forEach((imageData,index) => {
        const dt = new DataTransfer();
        dt.items.add(imageData.file);
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'images[]';
        input.files = dt.files;
        input.style.display = 'none';
        hiddenContainer.appendChild(input);
    });
}

if (stockTypeSelect.value) {
    stockTypeSelect.dispatchEvent(new Event('change'));
}
</script>
@endsection
