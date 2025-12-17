@extends('admin.layout')
@section('title', 'Create Discount')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.discounts.index') }}" 
           class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h2 class="text-3xl font-light text-slate-900 flex items-center gap-3">
            <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
            </svg>
            Create Discount Code
        </h2>
    </div>

    <a href="{{ route('admin.discounts.index') }}" 
       class="flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors duration-300 font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
        </svg>
        View All Discounts
    </a>
</div>

<form action="{{ route('admin.discounts.store') }}" method="POST" 
      class="space-y-8 bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm max-w-4xl">
    @csrf

    <!-- Basic Information -->
    <div class="space-y-6">
        <h3 class="text-lg font-medium text-slate-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Basic Information
        </h3>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- Code -->
            <div>
                <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Discount Code *
                </label>
                <input type="text" name="code" value="{{ old('code') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light uppercase
                              focus:outline-none focus:border-slate-900 transition-all duration-300" 
                       placeholder="SUMMER2024" required>
                @error('code') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Name -->
            <div>
                <label class="block text-slate-700 font-medium mb-3">Display Name *</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300" 
                       placeholder="Summer Sale 2024" required>
                @error('name') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Description -->
        <div>
            <label class="block text-slate-700 font-medium mb-3">Description</label>
            <textarea name="description" rows="4"
                      class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-light
                             focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
                      placeholder="Optional description...">{{ old('description') }}</textarea>
            @error('description') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Discount Details -->
    <div class="border-t-2 border-slate-200 pt-8 space-y-6">
        <h3 class="text-lg font-medium text-slate-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            Discount Details
        </h3>
        
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Type -->
            <div>
                <label class="block text-slate-700 font-medium mb-3">Type *</label>
                <select name="type" id="discount-type"
                        class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                               focus:outline-none focus:border-slate-900 transition-all duration-300" required>
                    <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>
                        Percentage (%)
                    </option>
                    <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>
                        Fixed Amount (DZD)
                    </option>
                </select>
            </div>

            <!-- Value -->
            <div>
                <label class="block text-slate-700 font-medium mb-3">
                    Value * <span id="value-hint" class="text-xs text-slate-500 font-light">(e.g., 20 for 20%)</span>
                </label>
                <input type="number" step="0.01" name="value" value="{{ old('value') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300" required>
                @error('value') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Max Discount -->
            <div id="max-discount-container">
                <label class="block text-slate-700 font-medium mb-3">Max Discount (DZD)</label>
                <input type="number" step="0.01" name="max_discount" value="{{ old('max_discount') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="Optional">
            </div>
        </div>
    </div>

    <!-- Conditions -->
    <div class="border-t-2 border-slate-200 pt-8 space-y-6">
        <h3 class="text-lg font-medium text-slate-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
            </svg>
            Conditions
        </h3>
        
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Min Purchase -->
            <div>
                <label class="block text-slate-700 font-medium mb-3">Minimum Purchase (DZD)</label>
                <input type="number" step="0.01" name="min_purchase" value="{{ old('min_purchase') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="0.00">
            </div>

            <!-- Usage Limit -->
            <div>
                <label class="block text-slate-700 font-medium mb-3">Total Usage Limit</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="Unlimited">
            </div>

            <!-- Per User Limit -->
            <div>
                <label class="block text-slate-700 font-medium mb-3">Per User Limit</label>
                <input type="number" name="per_user_limit" value="{{ old('per_user_limit') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="Unlimited">
            </div>
        </div>
    </div>

    <!-- Validity Period -->
    <div class="border-t-2 border-slate-200 pt-8 space-y-6">
        <h3 class="text-lg font-medium text-slate-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Validity Period
        </h3>
        
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Start Date -->
            <div>
                <label class="block text-slate-700 font-medium mb-3">Start Date</label>
                <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300">
            </div>

            <!-- Expiry Date -->
            <div>
                <label class="block text-slate-700 font-medium mb-3">Expiry Date</label>
                <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300">
            </div>
        </div>
    </div>

    <!-- Applies To -->
    <div class="border-t-2 border-slate-200 pt-8 space-y-6">
        <h3 class="text-lg font-medium text-slate-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            Applies To
        </h3>
        
        <!-- Apply to All -->
        <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="applies_to_all" value="1" id="applies-to-all"
                       {{ old('applies_to_all', true) ? 'checked' : '' }}
                       class="w-5 h-5 text-slate-900 border-2 border-slate-300 rounded focus:ring-2 focus:ring-slate-900">
                <span class="text-slate-900 font-medium">Apply to all products</span>
            </label>
        </div>

        <div id="specific-items" class="{{ old('applies_to_all', true) ? 'hidden' : '' }} space-y-6">
            <!-- Specific Categories -->
            <div>
                <label class="block text-slate-700 font-medium mb-3">Specific Categories</label>
                <select name="category_ids[]" multiple
                        class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-light
                               focus:outline-none focus:border-slate-900 transition-all duration-300" size="5">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" class="py-2">{{ $category->name }}</option>
                    @endforeach
                </select>
                <p class="mt-2 text-sm text-slate-500 font-light">Hold Ctrl/Cmd to select multiple</p>
            </div>

            <!-- Specific Products -->
            <div>
                <label class="block text-slate-700 font-medium mb-3">Specific Products</label>
                <select name="product_ids[]" multiple
                        class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-light
                               focus:outline-none focus:border-slate-900 transition-all duration-300" size="5">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" class="py-2">{{ $product->name }} ({{ $product->category->name }})</option>
                    @endforeach
                </select>
                <p class="mt-2 text-sm text-slate-500 font-light">Hold Ctrl/Cmd to select multiple</p>
            </div>
        </div>
    </div>

    <!-- Active Status -->
    <div class="border-t-2 border-slate-200 pt-8">
        <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                       class="w-5 h-5 text-slate-900 border-2 border-slate-300 rounded focus:ring-2 focus:ring-slate-900">
                <span class="text-slate-900 font-medium">Active (discount can be used immediately)</span>
            </label>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="pt-8 flex gap-4">
        <button type="submit" 
                class="flex items-center gap-2 bg-slate-900 text-white px-8 py-4 rounded-full font-medium text-base
                       hover:bg-slate-800 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Create Discount
        </button>
        
        <a href="{{ route('admin.discounts.index') }}" 
           class="flex items-center gap-2 border-2 border-slate-200 text-slate-900 px-8 py-4 rounded-full font-medium text-base
                  hover:border-slate-900 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Cancel
        </a>
    </div>
</form>

<script>
document.getElementById('discount-type').addEventListener('change', function() {
    const maxDiscountContainer = document.getElementById('max-discount-container');
    const valueHint = document.getElementById('value-hint');
    
    if (this.value === 'percentage') {
        maxDiscountContainer.style.display = 'block';
        valueHint.textContent = '(e.g., 20 for 20%)';
    } else {
        maxDiscountContainer.style.display = 'none';
        valueHint.textContent = '(fixed amount in DZD)';
    }
});

document.getElementById('applies-to-all').addEventListener('change', function() {
    const specificItems = document.getElementById('specific-items');
    specificItems.classList.toggle('hidden', this.checked);
});
</script>
@endsection