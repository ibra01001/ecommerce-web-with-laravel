@extends('admin.layout')

@section('title', 'Edit Stock Type')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-semibold text-white flex items-center gap-3">
        <x-heroicon-o-pencil-square class="w-7 h-7 text-yellow-400" />
        Edit Stock Type
    </h2>

    <a href="{{ route('admin.stock-types.index') }}" 
       class="flex items-center gap-2 text-gray-400 hover:text-yellow-400 transition">
        <x-heroicon-o-arrow-left class="w-5 h-5" />
        Back to Stock Types
    </a>
</div>

<form action="{{ route('admin.stock-types.update', $stockType->id) }}" method="POST" 
      class="space-y-6 bg-neutral-900/60 p-6 rounded-xl border border-neutral-800 shadow-lg max-w-2xl">
    @csrf
    @method('PUT')

    <!-- Name -->
    <div>
        <label class="block text-gray-400 mb-2 flex items-center gap-2">
            <x-heroicon-o-tag class="w-5 h-5 text-yellow-400" />
            Stock Type Name
        </label>
        <input type="text" name="name" 
               value="{{ old('name', $stockType->name) }}"
               placeholder="e.g., Clothing Sizes, Dumbbell Weights, Colors"
               class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                      focus:outline-none focus:border-yellow-400 transition" required>
        @error('name') 
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
        @enderror
    </div>

    <!-- Display Type -->
    <div>
        <label class="block text-gray-400 mb-2 flex items-center gap-2">
            <x-heroicon-o-square-3-stack-3d class="w-5 h-5 text-yellow-400" />
            Display Type
        </label>
        <select name="display_type"
                class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                       focus:outline-none focus:border-yellow-400 transition" required>
            <option value="grid" {{ old('display_type', $stockType->display_type) == 'grid' ? 'selected' : '' }}>
                Grid (Best for sizes like S, M, L)
            </option>
            <option value="dropdown" {{ old('display_type', $stockType->display_type) == 'dropdown' ? 'selected' : '' }}>
                Dropdown (Best for many options like weights)
            </option>
            <option value="color-swatch" {{ old('display_type', $stockType->display_type) == 'color-swatch' ? 'selected' : '' }}>
                Color Swatches (For colors)
            </option>
            <option value="none" {{ old('display_type', $stockType->display_type) == 'none' ? 'selected' : '' }}>
                None (For "One Size" products)
            </option>
        </select>
        @error('display_type') 
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
        @enderror
        <p class="text-gray-500 text-xs mt-2">This determines how customers will see and select options on the product page.</p>
    </div>

    <!-- Sort Order -->
    <div>
        <label class="block text-gray-400 mb-2 flex items-center gap-2">
            <x-heroicon-o-arrows-up-down class="w-5 h-5 text-yellow-400" />
            Sort Order
        </label>
        <input type="number" name="sort_order" 
               value="{{ old('sort_order', $stockType->sort_order) }}"
               min="0"
               class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                      focus:outline-none focus:border-yellow-400 transition">
        @error('sort_order') 
            <p class="text-red-400 text-sm mt-1">{{ $message }}</p> 
        @enderror
        <p class="text-gray-500 text-xs mt-2">Lower numbers appear first in lists.</p>
    </div>

    <!-- Info Box -->
    <div class="bg-blue-600/10 border border-blue-600/30 rounded-lg p-4">
        <div class="flex gap-3">
            <x-heroicon-o-information-circle class="w-5 h-5 text-blue-400 flex-shrink-0 mt-0.5" />
            <div class="text-sm text-gray-300">
                <p class="font-semibold text-blue-400 mb-1">Next Step</p>
                <p>After editing this stock type, you can manage its options like S, M, L or 1kg, 2kg, 3kg.</p>
            </div>
        </div>
    </div>

    <!-- Submit -->
    <div class="pt-4 flex gap-3">
        <button type="submit" 
                class="flex items-center gap-2 bg-yellow-400 text-black px-6 py-2.5 rounded-lg font-semibold 
                       hover:bg-yellow-500 transition">
            <x-heroicon-o-check class="w-5 h-5" />
            Update Stock Type
        </button>
        
        <a href="{{ route('admin.stock-types.index') }}"
           class="flex items-center gap-2 bg-neutral-800 text-gray-300 px-6 py-2.5 rounded-lg font-semibold 
                  hover:bg-neutral-700 transition">
            <x-heroicon-o-x-mark class="w-5 h-5" />
            Cancel
        </a>
    </div>
</form>
@endsection
