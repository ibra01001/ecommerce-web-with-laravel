@extends('admin.layout')

@section('title', 'Create Discount')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h2 class="text-3xl font-semibold text-white flex items-center gap-3">
        <x-heroicon-o-plus-circle class="w-7 h-7 text-yellow-400" />
        Create Discount Code
    </h2>

    <a href="{{ route('admin.discounts.index') }}" 
       class="flex items-center gap-2 text-gray-400 hover:text-yellow-400 transition">
        <x-heroicon-o-arrow-left class="w-5 h-5" />
        Back to Discounts
    </a>
</div>

<form action="{{ route('admin.discounts.store') }}" method="POST" 
      class="space-y-6 bg-neutral-900/60 p-6 rounded-xl border border-neutral-800 max-w-4xl">
    @csrf

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Code -->
        <div>
            <label class="block text-gray-400 mb-2 flex items-center gap-2">
                <x-heroicon-o-tag class="w-5 h-5 text-yellow-400" />
                Discount Code *
            </label>
            <input type="text" name="code" value="{{ old('code') }}"
                   class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                          uppercase focus:outline-none focus:border-yellow-400 transition" 
                   placeholder="SUMMER2024" required>
            @error('code') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Name -->
        <div>
            <label class="block text-gray-400 mb-2">Display Name *</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                          focus:outline-none focus:border-yellow-400 transition" 
                   placeholder="Summer Sale 2024" required>
            @error('name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Description -->
    <div>
        <label class="block text-gray-400 mb-2">Description</label>
        <textarea name="description" rows="3"
                  class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                         focus:outline-none focus:border-yellow-400 transition"
                  placeholder="Optional description...">{{ old('description') }}</textarea>
        @error('description') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="border-t border-neutral-700 pt-6">
        <h3 class="text-lg font-semibold text-white mb-4">Discount Details</h3>
        
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Type -->
            <div>
                <label class="block text-gray-400 mb-2">Type *</label>
                <select name="type" id="discount-type"
                        class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                               focus:outline-none focus:border-yellow-400 transition" required>
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
                <label class="block text-gray-400 mb-2">
                    Value * <span id="value-hint" class="text-xs text-gray-500">(e.g., 20 for 20%)</span>
                </label>
                <input type="number" step="0.01" name="value" value="{{ old('value') }}"
                       class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                              focus:outline-none focus:border-yellow-400 transition" required>
                @error('value') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Max Discount (for percentage) -->
            <div id="max-discount-container">
                <label class="block text-gray-400 mb-2">Max Discount (DZD)</label>
                <input type="number" step="0.01" name="max_discount" value="{{ old('max_discount') }}"
                       class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                              focus:outline-none focus:border-yellow-400 transition"
                       placeholder="Optional">
            </div>
        </div>
    </div>

    <div class="border-t border-neutral-700 pt-6">
        <h3 class="text-lg font-semibold text-white mb-4">Conditions</h3>
        
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Min Purchase -->
            <div>
                <label class="block text-gray-400 mb-2">Minimum Purchase (DZD)</label>
                <input type="number" step="0.01" name="min_purchase" value="{{ old('min_purchase') }}"
                       class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                              focus:outline-none focus:border-yellow-400 transition"
                       placeholder="0.00">
            </div>

            <!-- Usage Limit -->
            <div>
                <label class="block text-gray-400 mb-2">Total Usage Limit</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit') }}"
                       class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                              focus:outline-none focus:border-yellow-400 transition"
                       placeholder="Unlimited">
            </div>

            <!-- Per User Limit -->
            <div>
                <label class="block text-gray-400 mb-2">Per User Limit</label>
                <input type="number" name="per_user_limit" value="{{ old('per_user_limit') }}"
                       class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                              focus:outline-none focus:border-yellow-400 transition"
                       placeholder="Unlimited">
            </div>
        </div>
    </div>

    <div class="border-t border-neutral-700 pt-6">
        <h3 class="text-lg font-semibold text-white mb-4">Validity Period</h3>
        
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Start Date -->
            <div>
                <label class="block text-gray-400 mb-2">Start Date</label>
                <input type="datetime-local" name="starts_at" value="{{ old('starts_at') }}"
                       class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                              focus:outline-none focus:border-yellow-400 transition">
            </div>

            <!-- Expiry Date -->
            <div>
                <label class="block text-gray-400 mb-2">Expiry Date</label>
                <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}"
                       class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                              focus:outline-none focus:border-yellow-400 transition">
            </div>
        </div>
    </div>

    <div class="border-t border-neutral-700 pt-6">
        <h3 class="text-lg font-semibold text-white mb-4">Applies To</h3>
        
        <!-- Apply to All -->
        <div class="mb-4">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="applies_to_all" value="1" id="applies-to-all"
                       {{ old('applies_to_all', true) ? 'checked' : '' }}
                       class="w-5 h-5 bg-neutral-950 border-neutral-700 rounded text-yellow-400 
                              focus:ring-yellow-400">
                <span class="text-gray-300">Apply to all products</span>
            </label>
        </div>

        <div id="specific-items" class="{{ old('applies_to_all', true) ? 'hidden' : '' }}">
            <!-- Specific Categories -->
            <div class="mb-4">
                <label class="block text-gray-400 mb-2">Specific Categories</label>
                <select name="category_ids[]" multiple
                        class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                               focus:outline-none focus:border-yellow-400 transition" size="4">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Specific Products -->
            <div>
                <label class="block text-gray-400 mb-2">Specific Products</label>
                <select name="product_ids[]" multiple
                        class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                               focus:outline-none focus:border-yellow-400 transition" size="4">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->category->name }})</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="border-t border-neutral-700 pt-6">
        <!-- Active Status -->
        <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                   class="w-5 h-5 bg-neutral-950 border-neutral-700 rounded text-yellow-400 
                          focus:ring-yellow-400">
            <span class="text-gray-300">Active (discount can be used immediately)</span>
        </label>
    </div>

    <!-- Submit -->
    <div class="pt-4">
        <button type="submit" 
                class="flex items-center gap-2 bg-yellow-400 text-black px-6 py-2.5 rounded-lg font-semibold 
                       hover:bg-yellow-500 transition">
            <x-heroicon-o-check class="w-5 h-5" />
            Create Discount
        </button>
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