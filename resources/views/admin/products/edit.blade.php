@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-semibold text-slate-900 flex items-center gap-3">
        {{-- Title Icon: Changed from Yellow to neutral Slate-900 --}}
        <x-heroicon-o-pencil-square class="w-7 h-7 text-slate-900" />
        Edit Product
    </h2>

    <a href="{{ route('admin.products.index') }}" 
       class="flex items-center gap-2 text-slate-600 hover:text-slate-900 transition duration-300 font-medium">
        <x-heroicon-o-arrow-left class="w-5 h-5" />
        Back to Products
    </a>
</div>

{{-- Success/Error Alerts using the clean dashboard style --}}
@if(session('success'))
<div class="mb-6 bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-xl flex items-center gap-3">
    <x-heroicon-o-check-circle class="w-6 h-6 text-green-600 flex-shrink-0" />
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif

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

<form action="{{ route('admin.products.update', $product->id) }}" 
      method="POST" enctype="multipart/form-data"
      {{-- Form Container: Clean White card style with border and shadow --}}
      class="space-y-8 bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm max-w-5xl">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            {{-- Icon: Changed to neutral Slate-900 --}}
            <x-heroicon-o-tag class="w-5 h-5 text-slate-900" />
            Name *
        </label>
        <input type="text" name="name" 
               value="{{ old('name', $product->name) }}"
               {{-- Input Style: Clean white background, slate border, focus on Slate-900 --}}
               class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                      focus:outline-none focus:border-slate-900 transition-all duration-300" required>
        @error('name') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            {{-- Icon: Changed to neutral Slate-900 --}}
            <x-heroicon-o-document-text class="w-5 h-5 text-slate-900" />
            Description
        </label>
        <textarea name="description" rows="4"
                  {{-- Textarea Style: Rounded-2xl and clean slate focus --}}
                  class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-light
                         focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none">{{ old('description', $product->description) }}</textarea>
        @error('description') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                {{-- Icon: Changed to neutral Slate-900 --}}
                <x-heroicon-o-archive-box class="w-5 h-5 text-slate-900" />
                Category *
            </label>
            <select name="category_id"
                    {{-- Select Style: Rounded-full and clean slate focus --}}
                    class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                           focus:outline-none focus:border-slate-900 transition-all duration-300 appearance-none pr-8" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                {{-- Icon: Changed to neutral Slate-900 --}}
                <x-heroicon-o-currency-dollar class="w-5 h-5 text-slate-900" />
                Price * (DA)
            </label>
            <input type="number" step="0.01" name="price" 
                   value="{{ old('price', $product->price) }}"
                   {{-- Input Style: Rounded-full and clean slate focus --}}
                   class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                          focus:outline-none focus:border-slate-900 transition-all duration-300" required>
            @error('price') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="border-t-2 border-slate-200 pt-8">
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            {{-- Icon: Changed to neutral Slate-900 --}}
            <x-heroicon-o-cube class="w-5 h-5 text-slate-900" />
            Stock Type *
        </label>
        <select name="stock_type_id" id="stock_type_select"
                {{-- Select Style: Rounded-full and clean slate focus --}}
                class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                       focus:outline-none focus:border-slate-900 transition-all duration-300 appearance-none pr-8" required>
            @foreach($stockTypes as $stockType)
                <option value="{{ $stockType->id }}"
                    data-display-type="{{ $stockType->display_type }}"
                    {{ old('stock_type_id', $product->stock_type_id) == $stockType->id ? 'selected' : '' }}>
                    {{ $stockType->name }}
                </option>
            @endforeach
        </select>
        @error('stock_type_id') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <div id="stock-options-container" class="hidden">
        <h3 class="text-xl font-semibold text-slate-900 mb-4">Stock Quantities</h3>
        <div id="stock-options-grid" class="grid gap-4"></div>
    </div>

    <div id="total-stock-display" class="hidden mt-4 p-4 bg-slate-50 rounded-xl border border-slate-300">
        <div class="flex justify-between items-center">
            <span class="text-slate-700 font-medium">Total Stock:</span>
            {{-- Accent Color: Using strong Slate-900 for important number --}}
            <span id="total-stock" class="text-2xl font-bold text-slate-900">{{ $product->total_stock }}</span>
        </div>
    </div>

    <div class="border-t-2 border-slate-200 pt-8">
        <label class="block text-slate-700 font-medium mb-4 flex items-center gap-2">
            {{-- Icon: Changed to neutral Slate-900 --}}
            <x-heroicon-o-photo class="w-5 h-5 text-slate-900" />
            Product Images
        </label>
        
        <div id="images-container" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mb-6">
            @foreach($product->images as $image)
            <div class="relative group shadow-sm" data-existing-image="{{ $image->id }}">
                <img src="{{ $image->image_url }}" 
                     class="w-full h-32 object-cover rounded-xl border-2 {{ $image->is_primary ? 'border-slate-900' : 'border-slate-300' }}">
                
                @if($image->is_primary)
                    {{-- Badge: Changed from yellow to Slate-900 --}}
                    <div class="absolute top-2 left-2 bg-slate-900 text-white text-xs px-2 py-1 rounded-full font-semibold">
                        Primary
                    </div>
                @else
                    {{-- Action Link: Muted colors for setting primary --}}
                    <button type="button" 
                            onclick="markExistingAsPrimary({{ $image->id }})"
                            class="absolute top-2 left-2 bg-white/80 backdrop-blur-sm text-slate-600 text-xs px-2 py-1 rounded-full hover:bg-slate-900 hover:text-white transition shadow-md">
                        Set as Primary
                    </button>
                @endif
                
                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 
                           transition-opacity rounded-xl flex items-center justify-center">
                    {{-- Danger Action: Red for Delete --}}
                    <button type="button" 
                            onclick="deleteExistingImage({{ $image->id }})"
                            class="bg-red-600 text-white px-3 py-1.5 rounded-full text-sm hover:bg-red-700 transition flex items-center gap-1 font-medium">
                        <x-heroicon-o-trash class="w-4 h-4" />
                        Delete
                    </button>
                </div>
            </div>
            @endforeach
            
            {{-- Fallback for legacy image (if any) --}}
            @if($product->image && $product->images->count() === 0)
            <div class="relative group shadow-sm">
                <img src="{{ asset('storage/' . $product->image) }}" 
                     class="w-full h-32 object-cover rounded-xl border-2 border-slate-900">
                {{-- Badge: Changed from yellow to Slate-900 --}}
                <div class="absolute top-2 left-2 bg-slate-900 text-white text-xs px-2 py-1 rounded-full font-semibold">
                    Legacy Image
                </div>
            </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <label for="add-image-input" class="inline-block cursor-pointer">
                {{-- Button: Changed from yellow to Slate-900 primary CTA --}}
                <div class="bg-slate-900 text-white px-6 py-2.5 rounded-full font-medium hover:bg-slate-800 transition inline-flex items-center gap-2 shadow-md">
                    <x-heroicon-o-plus class="w-5 h-5" />
                    Add More Images
                </div>
            </label>
            <input type="file" 
                   id="add-image-input"
                   accept="image/*"
                   class="hidden"
                   onchange="addNewImage(event)">
            <p class="text-slate-500 text-sm">Add images one by one (max 2MB each)</p>
        </div>
        
        <div id="hidden-delete-inputs"></div>
        <div id="hidden-new-images"></div>
        
        @error('images.*') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <div class="pt-8 flex gap-4">
        <button type="submit" 
                {{-- Submit Button: Changed from yellow to Slate-900 primary CTA --}}
                class="flex items-center gap-2 bg-slate-900 text-white px-8 py-4 rounded-full font-medium text-base
                       hover:bg-slate-800 transition-all duration-300 shadow-lg">
            <x-heroicon-o-check class="w-5 h-5" />
            Update Product
        </button>
    </div>
</form>

@php
$stockTypesJson = $stockTypes->map(function($type) use ($product) {
    // ... (Stock data mapping remains the same as it's backend logic)
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
// --- JS Initialization (Stays the same) ---
const stockTypesData = @json($stockTypesJson);
const stockTypeSelect = document.getElementById('stock_type_select');
const stockOptionsContainer = document.getElementById('stock-options-container');
const stockOptionsGrid = document.getElementById('stock-options-grid');
const totalStockDisplay = document.getElementById('total-stock-display');
const totalStockElement = document.getElementById('total-stock');

// Image management
let imagesToDelete = [];
let newImages = [];
let newImageCounter = 0;

// --- Stock Functions (Styles updated within) ---
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
            {{-- Stock Input Style: Light theme slate-focused --}}
            <div class="bg-slate-50 border border-slate-300 rounded-xl p-4">
                <label class="block text-slate-700 mb-2">Quantity</label>
                <input type="number" name="stock[${option.id}]"
                       value="${option.stock ?? 0}" min="0"
                       class="w-full bg-white border border-slate-300 rounded-full px-4 py-3 text-slate-900
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       oninput="updateTotalStock()" required>
            </div>`;
    } else {
        const gridClass = type.options.length > 3 ? 'grid-cols-2 lg:grid-cols-3' : 'grid-cols-1';
        html = `<div class="grid ${gridClass} gap-4">`;
        type.options.forEach(option => {
            html += `
                {{-- Stock Input Style: Light theme slate-focused --}}
                <div class="bg-slate-50 border border-slate-300 rounded-xl p-4">
                    <label class="block text-slate-700 mb-2 font-medium">${option.label}</label>
                    <input type="number" name="stock[${option.id}]"
                           value="${option.stock ?? 0}" min="0"
                           class="w-full bg-white border border-slate-300 rounded-full px-4 py-3 text-slate-900
                                  focus:outline-none focus:border-slate-900 transition-all duration-300"
                           oninput="updateTotalStock()" required>
                </div>`;
        });
        html += `</div>`;
    }

    stockOptionsGrid.innerHTML = html;
    updateTotalStock();
});

// --- Image Management Functions (Styles updated within) ---
function deleteExistingImage(imageId) {
    if (confirm('Are you sure you want to delete this image?')) {
        imagesToDelete.push(imageId);
        
        const element = document.querySelector(`[data-existing-image="${imageId}"]`);
        if (element) {
            // Visually fade out the deleted image on the UI
            element.style.opacity = '0.3';
            element.style.pointerEvents = 'none';
        }
        
        updateDeleteInputs();
    }
}

function markExistingAsPrimary(imageId) {
    alert('To set a different primary image, please delete the current primary image first, and the system will automatically promote the next image.');
}

function addNewImage(event) {
    const file = event.target.files[0];
    if (!file) return;

    if (file.size > 2 * 1024 * 1024) {
        alert('Image size must be less than 2MB');
        event.target.value = '';
        return;
    }

    if (!file.type.startsWith('image/')) {
        alert('Please select a valid image file');
        event.target.value = '';
        return;
    }

    const imageId = `new-image-${newImageCounter++}`;
    
    newImages.push({
        id: imageId,
        file: file
    });

    const reader = new FileReader();
    reader.onload = function(e) {
        const container = document.getElementById('images-container');
        const imageDiv = document.createElement('div');
        imageDiv.className = 'relative group shadow-sm';
        imageDiv.id = imageId;
        imageDiv.innerHTML = `
            <img src="${e.target.result}" 
                 class="w-full h-32 object-cover rounded-xl border-2 border-green-600">
            
            {{-- Badge: Using Green for a new/added status --}}
            <div class="absolute top-2 left-2 bg-green-600 text-white text-xs px-2 py-1 rounded-full font-semibold">
                New
            </div>
            
            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 
                       transition-opacity rounded-xl flex items-center justify-center">
                {{-- Action: Red for removal --}}
                <button type="button" 
                        onclick="removeNewImage('${imageId}')"
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
    updateNewImageInputs();
}

function removeNewImage(imageId) {
    const index = newImages.findIndex(img => img.id === imageId);
    if (index > -1) {
        newImages.splice(index, 1);
    }

    const element = document.getElementById(imageId);
    if (element) element.remove();

    updateNewImageInputs();
}

function updateDeleteInputs() {
    const container = document.getElementById('hidden-delete-inputs');
    container.innerHTML = '';
    
    imagesToDelete.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'delete_images[]';
        input.value = id;
        container.appendChild(input);
    });
}

function updateNewImageInputs() {
    const container = document.getElementById('hidden-new-images');
    container.innerHTML = '';
    
    newImages.forEach(imageData => {
        // We recreate the file input element that contains the file data
        const dt = new DataTransfer();
        dt.items.add(imageData.file);
        
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'images[]';
        input.files = dt.files;
        input.style.display = 'none'; // Keep hidden for submission
        container.appendChild(input);
    });
}

// Initial call to set up the stock inputs based on the current product
stockTypeSelect.dispatchEvent(new Event('change'));
</script>
@endsection