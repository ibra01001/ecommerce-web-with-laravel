@extends('admin.layout')

@section('title', 'Edit Stock Type')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.stock-types.index') }}" 
           class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h2 class="text-3xl font-light text-slate-900 flex items-center gap-3">
            <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Stock Type
        </h2>
    </div>

    <a href="{{ route('admin.stock-types.index') }}" 
       class="flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors duration-300 font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
        </svg>
        View All Stock Types
    </a>
</div>

@if(session('success'))
<div class="mb-6 bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-2xl flex items-center gap-3">
    <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div class="mb-6 bg-red-50 border-2 border-red-200 text-red-800 px-6 py-4 rounded-2xl">
    <div class="flex items-start gap-3">
        <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li class="font-medium">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<form action="{{ route('admin.stock-types.update', $stockType->id) }}" method="POST" 
      class="space-y-8 bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm max-w-4xl">
    @csrf
    @method('PUT')

    <!-- Info Banner -->
    <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="text-blue-900 font-medium mb-1">Edit Stock Type</h3>
                <p class="text-blue-800 text-sm font-light">Update the configuration for this stock type. Changes will affect how inventory options are displayed for associated products.</p>
            </div>
        </div>
    </div>

    <!-- Name -->
    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            Stock Type Name *
        </label>
        <input type="text" name="name" 
               value="{{ old('name', $stockType->name) }}"
               placeholder="e.g., Clothing Sizes, Dumbbell Weights, Colors"
               class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                      focus:outline-none focus:border-slate-900 transition-all duration-300" required>
        <p class="mt-2 text-sm text-slate-500 font-light">Give this stock type a clear, descriptive name</p>
        @error('name') 
            <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> 
        @enderror
    </div>

    <!-- Display Type -->
    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            Display Type *
        </label>
        <select name="display_type"
                class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                       focus:outline-none focus:border-slate-900 transition-all duration-300" required>
            <option value="grid" {{ old('display_type', $stockType->display_type) == 'grid' ? 'selected' : '' }}>
                Grid (Best for sizes like S, M, L)
            </option>

            <option value="none" {{ old('display_type', $stockType->display_type) == 'none' ? 'selected' : '' }}>
                None (For "One Size" products)
            </option>
        </select>
        <p class="mt-2 text-sm text-slate-500 font-light">This determines how customers will see and select options on the product page</p>
        @error('display_type') 
            <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> 
        @enderror
    </div>

    <!-- Sort Order -->
    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
            </svg>
            Sort Order
        </label>
        <input type="number" name="sort_order" 
               value="{{ old('sort_order', $stockType->sort_order) }}"
               min="0"
               placeholder="0"
               class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                      focus:outline-none focus:border-slate-900 transition-all duration-300">
        <p class="mt-2 text-sm text-slate-500 font-light">Lower numbers appear first in lists</p>
        @error('sort_order') 
            <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> 
        @enderror
    </div>

    <!-- Display Type Examples -->
    <div class="border-t-2 border-slate-200 pt-8">
        <h3 class="text-lg font-medium text-slate-900 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Display Type Examples
        </h3>
        <div class="grid md:grid-cols-2 gap-4">
            <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-slate-700 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/>
                    </svg>
                    <div>
                        <p class="text-slate-900 font-medium text-sm mb-1">Grid Layout</p>
                        <p class="text-slate-600 text-sm font-light">Perfect for clothing sizes (S, M, L, XL) or shoe sizes</p>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-slate-700 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    <div>
                        <p class="text-slate-900 font-medium text-sm mb-1">Dropdown Menu</p>
                        <p class="text-slate-600 text-sm font-light">Ideal for many options like weights (1kg - 50kg)</p>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-slate-700 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <div>
                        <p class="text-slate-900 font-medium text-sm mb-1">None</p>
                        <p class="text-slate-600 text-sm font-light">For products with "One Size" or no variations</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Next Steps Info -->
    <div class="bg-green-50 border-2 border-green-200 rounded-2xl p-6">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <h3 class="text-green-900 font-medium mb-1">After Updating</h3>
                <p class="text-green-800 text-sm font-light">You can manage specific options for this stock type (like S, M, L or 1kg, 2kg, 3kg) from the stock types list page.</p>
            </div>
        </div>
    </div>

    <!-- Submit -->
    <div class="pt-8 flex gap-4">
        <button type="submit" 
                class="flex items-center gap-2 bg-slate-900 text-white px-8 py-4 rounded-full font-medium text-base
                       hover:bg-slate-800 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Update Stock Type
        </button>
        
        <a href="{{ route('admin.stock-types.index') }}"
           class="flex items-center gap-2 border-2 border-slate-200 text-slate-900 px-8 py-4 rounded-full font-medium text-base
                  hover:border-slate-900 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Cancel
        </a>
    </div>
</form>
@endsection