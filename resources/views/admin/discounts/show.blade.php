@extends('admin.layout')
@section('title', 'Discount Details')

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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            Discount Details
        </h2>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('admin.discounts.edit', $discount) }}" 
           class="flex items-center gap-2 bg-slate-900 text-white px-6 py-3 rounded-full font-medium
                  hover:bg-slate-800 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </a>
    </div>
</div>

<!-- Status Badges -->
<div class="mb-6 flex flex-wrap gap-3">
    @if($discount->is_active)
        <span class="inline-flex items-center gap-2 bg-green-50 text-green-700 px-4 py-2 rounded-full text-sm font-medium border-2 border-green-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Active
        </span>
    @else
        <span class="inline-flex items-center gap-2 bg-red-50 text-red-700 px-4 py-2 rounded-full text-sm font-medium border-2 border-red-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Inactive
        </span>
    @endif

    @if($discount->expires_at && $discount->expires_at->isPast())
        <span class="inline-flex items-center gap-2 bg-orange-50 text-orange-700 px-4 py-2 rounded-full text-sm font-medium border-2 border-orange-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Expired
        </span>
    @endif
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <!-- Main Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Basic Information -->
        <div class="bg-white p-6 rounded-2xl border-2 border-slate-200 shadow-sm">
            <h3 class="text-lg font-medium text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Basic Information
            </h3>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-slate-600 font-light mb-2">Discount Code</p>
                    <p class="bg-slate-100 px-4 py-2.5 rounded-lg text-slate-900 font-mono font-medium border border-slate-200">
                        {{ $discount->code }}
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-600 font-light mb-2">Display Name</p>
                    <p class="text-slate-900 font-medium text-lg">{{ $discount->name }}</p>
                </div>
            </div>

            @if($discount->description)
                <div class="mt-6 pt-6 border-t-2 border-slate-200">
                    <p class="text-sm text-slate-600 font-light mb-2">Description</p>
                    <p class="text-slate-700 font-light">{{ $discount->description }}</p>
                </div>
            @endif
        </div>

        <!-- Discount Details -->
        <div class="bg-white p-6 rounded-2xl border-2 border-slate-200 shadow-sm">
            <h3 class="text-lg font-medium text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Discount Details
            </h3>
            
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <p class="text-sm text-slate-600 font-light mb-2">Type</p>
                    <p class="text-slate-900 font-medium flex items-center gap-2 capitalize">
                        @if($discount->type === 'percentage')
                            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Percentage
                        @else
                            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Fixed Amount
                        @endif
                    </p>
                </div>

                <div>
                    <p class="text-sm text-slate-600 font-light mb-2">Value</p>
                    <p class="text-slate-900 font-bold text-2xl">
                        @if($discount->type === 'percentage')
                            {{ $discount->value }}%
                        @else
                            {{ number_format($discount->value, 2) }} DZD
                        @endif
                    </p>
                </div>

                @if($discount->type === 'percentage' && $discount->max_discount)
                    <div>
                        <p class="text-sm text-slate-600 font-light mb-2">Max Discount</p>
                        <p class="text-slate-900 font-medium text-lg">{{ number_format($discount->max_discount, 2) }} DZD</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Conditions -->
        <div class="bg-white p-6 rounded-2xl border-2 border-slate-200 shadow-sm">
            <h3 class="text-lg font-medium text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                </svg>
                Conditions
            </h3>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
                    <p class="text-sm text-slate-600 font-light mb-1">Minimum Purchase</p>
                    <p class="text-slate-900 font-medium text-lg">
                        {{ $discount->min_purchase ? number_format($discount->min_purchase, 2) . ' DZD' : 'No minimum' }}
                    </p>
                </div>

                <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
                    <p class="text-sm text-slate-600 font-light mb-1">Total Usage Limit</p>
                    <p class="text-slate-900 font-medium text-lg">
                        {{ $discount->usage_limit ?? 'Unlimited' }}
                    </p>
                </div>

                <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
                    <p class="text-sm text-slate-600 font-light mb-1">Per User Limit</p>
                    <p class="text-slate-900 font-medium text-lg">
                        {{ $discount->per_user_limit ?? 'Unlimited' }}
                    </p>
                </div>

                <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
                    <p class="text-sm text-slate-600 font-light mb-1">Times Used</p>
                    <p class="text-slate-900 font-bold text-lg">
                        {{ $discount->usage_count ?? 0 }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Validity Period -->
        <div class="bg-white p-6 rounded-2xl border-2 border-slate-200 shadow-sm">
            <h3 class="text-lg font-medium text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Validity Period
            </h3>
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
                    <p class="text-sm text-slate-600 font-light mb-1">Start Date</p>
                    <p class="text-slate-900 font-medium">
                        {{ $discount->starts_at ? $discount->starts_at->format('M d, Y H:i') : 'Immediately' }}
                    </p>
                </div>

                <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
                    <p class="text-sm text-slate-600 font-light mb-1">Expiry Date</p>
                    <p class="text-slate-900 font-medium">
                        {{ $discount->expires_at ? $discount->expires_at->format('M d, Y H:i') : 'No expiry' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Applies To -->
        <div class="bg-white p-6 rounded-2xl border-2 border-slate-200 shadow-sm">
            <h3 class="text-lg font-medium text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Applies To
            </h3>
            
            @if($discount->applies_to_all)
                <div class="flex items-center gap-2 text-slate-700">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-medium">All Products</span>
                </div>
            @else
                @if($discount->categories && $discount->categories->count() > 0)
                    <div class="mb-6">
                        <p class="text-sm text-slate-600 font-light mb-3">Categories</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($discount->categories as $category)
                                <span class="bg-slate-100 text-slate-900 px-4 py-2 rounded-full text-sm font-medium border border-slate-200">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($discount->products && $discount->products->count() > 0)
                    <div class="{{ ($discount->categories && $discount->categories->count() > 0) ? 'pt-6 border-t-2 border-slate-200' : '' }}">
                        <p class="text-sm text-slate-600 font-light mb-3">Products</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($discount->products as $product)
                                <span class="bg-slate-100 text-slate-900 px-4 py-2 rounded-full text-sm font-medium border border-slate-200">
                                    {{ $product->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white p-6 rounded-2xl border-2 border-slate-200 shadow-sm">
            <h3 class="text-lg font-medium text-slate-900 mb-4">Quick Actions</h3>
            
            <div class="space-y-3">
                <a href="{{ route('admin.discounts.edit', $discount) }}" 
                   class="flex items-center gap-2 bg-slate-50 text-slate-900 px-4 py-3 rounded-xl hover:bg-slate-100 transition-all duration-300 w-full border border-slate-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Discount
                </a>

                <form action="{{ route('admin.discounts.destroy', $discount) }}" method="POST" 
                      onsubmit="return confirm('Are you sure you want to delete this discount?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="flex items-center gap-2 bg-red-50 text-red-700 px-4 py-3 rounded-xl hover:bg-red-100 transition-all duration-300 w-full border-2 border-red-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Delete Discount
                    </button>
                </form>
            </div>
        </div>

        <!-- Statistics -->
        <div class="bg-white p-6 rounded-2xl border-2 border-slate-200 shadow-sm">
            <h3 class="text-lg font-medium text-slate-900 mb-4">Statistics</h3>
            
            <div class="space-y-4">
                <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
                    <p class="text-sm text-slate-600 font-light mb-1">Total Uses</p>
                    <p class="text-slate-900 font-bold text-3xl">{{ $discount->usage_count ?? 0 }}</p>
                </div>

                @if($discount->usage_limit)
                    <div>
                        <p class="text-sm text-slate-600 font-light mb-2">Usage Progress</p>
                        <div class="bg-slate-100 rounded-full h-3 overflow-hidden border border-slate-200">
                            <div class="bg-slate-900 h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ min(100, (($discount->usage_count ?? 0) / $discount->usage_limit) * 100) }}%">
                            </div>
                        </div>
                        <p class="text-slate-500 text-xs font-light mt-2">
                            {{ $discount->usage_count ?? 0 }} / {{ $discount->usage_limit }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Metadata -->
        <div class="bg-white p-6 rounded-2xl border-2 border-slate-200 shadow-sm">
            <h3 class="text-lg font-medium text-slate-900 mb-4">Information</h3>
            
            <div class="space-y-4">
                <div class="pb-4 border-b border-slate-200">
                    <p class="text-sm text-slate-600 font-light mb-1">Created</p>
                    <p class="text-slate-900 font-medium">{{ $discount->created_at->format('M d, Y H:i') }}</p>
                </div>

                <div>
                    <p class="text-sm text-slate-600 font-light mb-1">Last Updated</p>
                    <p class="text-slate-900 font-medium">{{ $discount->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection