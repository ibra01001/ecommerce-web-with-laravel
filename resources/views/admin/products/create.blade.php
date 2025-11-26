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
      class="space-y-6 bg-neutral-900/60 p-6 rounded-xl border border-neutral-800 shadow-lg max-w-2xl">
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

    <!-- Size Inventory Section -->
    <div class="border-t border-neutral-700 pt-6">
        <h3 class="text-xl font-semibold text-white mb-4 flex items-center gap-2">
            <x-heroicon-o-cube class="w-6 h-6 text-yellow-400" />
            Size Inventory
        </h3>
        
        <div class="grid grid-cols-5 gap-4">
            <!-- Size S -->
            <div>
                <label class="block text-gray-400 mb-2 text-center font-medium">
                    Size S
                </label>
                <input type="number" name="taille_S" 
                       value="{{ old('taille_S', 0) }}"
                       min="0"
                       class="size-input w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 text-center
                              focus:outline-none focus:border-yellow-400 transition" required>
                @error('taille_S') 
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Size M -->
            <div>
                <label class="block text-gray-400 mb-2 text-center font-medium">
                    Size M
                </label>
                <input type="number" name="taille_M" 
                       value="{{ old('taille_M', 0) }}"
                       min="0"
                       class="size-input w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 text-center
                              focus:outline-none focus:border-yellow-400 transition" required>
                @error('taille_M') 
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Size L -->
            <div>
                <label class="block text-gray-400 mb-2 text-center font-medium">
                    Size L
                </label>
                <input type="number" name="taille_L" 
                       value="{{ old('taille_L', 0) }}"
                       min="0"
                       class="size-input w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 text-center
                              focus:outline-none focus:border-yellow-400 transition" required>
                @error('taille_L') 
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Size XL -->
            <div>
                <label class="block text-gray-400 mb-2 text-center font-medium">
                    Size XL
                </label>
                <input type="number" name="taille_XL" 
                       value="{{ old('taille_XL', 0) }}"
                       min="0"
                       class="size-input w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 text-center
                              focus:outline-none focus:border-yellow-400 transition" required>
                @error('taille_XL') 
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>

            <!-- Size XXL -->
            <div>
                <label class="block text-gray-400 mb-2 text-center font-medium">
                    Size XXL
                </label>
                <input type="number" name="taille_XXL" 
                       value="{{ old('taille_XXL', 0) }}"
                       min="0"
                       class="size-input w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 text-center
                              focus:outline-none focus:border-yellow-400 transition" required>
                @error('taille_XXL') 
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p> 
                @enderror
            </div>
        </div>

        <!-- Total Stock Display -->
        <div class="mt-4 p-4 bg-neutral-950 rounded-lg border border-yellow-400/30">
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

        @error('image') 
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
        @enderror
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

<!-- Scripts -->
<script>
// Image preview
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('imagePreview');
        output.src = reader.result;
        output.classList.remove('hidden');
    };
    reader.readAsDataURL(event.target.files[0]);
}

// Calculate total stock
document.addEventListener('DOMContentLoaded', function() {
    const sizeInputs = document.querySelectorAll('.size-input');
    const totalStock = document.getElementById('total-stock');
    
    function updateTotal() {
        let total = 0;
        sizeInputs.forEach(input => {
            total += parseInt(input.value) || 0;
        });
        totalStock.textContent = total;
        
        // Change color based on stock
        if (total === 0) {
            totalStock.classList.remove('text-yellow-400', 'text-green-400');
            totalStock.classList.add('text-red-400');
        } else if (total < 20) {
            totalStock.classList.remove('text-red-400', 'text-green-400');
            totalStock.classList.add('text-yellow-400');
        } else {
            totalStock.classList.remove('text-red-400', 'text-yellow-400');
            totalStock.classList.add('text-green-400');
        }
    }
    
    sizeInputs.forEach(input => {
        input.addEventListener('input', updateTotal);
    });
    
    // Initial calculation
    updateTotal();
});
</script>
@endsection