@extends('admin.layout')
@section('title', 'Edit Category')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.categories.index') }}" 
           class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h2 class="text-3xl font-light text-slate-900 flex items-center gap-3">
            <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Category
        </h2>
    </div>

    <a href="{{ route('admin.categories.index') }}" 
       class="flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors duration-300 font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
        </svg>
        View All Categories
    </a>
</div>

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

<form action="{{ route('admin.categories.update', $category->id) }}" method="POST" 
      class="space-y-8 bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm max-w-4xl">
    @csrf
    @method('PUT')

    <!-- Category Info Badge -->
    <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-slate-900 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-slate-600 font-light">Editing Category ID</p>
                    <p class="text-xl font-medium text-slate-900">#{{ $category->id }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-slate-600 font-light">Products in this category</p>
                <p class="text-xl font-medium text-slate-900">{{ $category->products->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Category Name -->
    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            Category Name *
        </label>
        <input 
            type="text" 
            id="name" 
            name="name" 
            value="{{ old('name', $category->name) }}"
            placeholder="e.g., Electronics, Clothing, Home & Garden"
            class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                   focus:outline-none focus:border-slate-900 transition-all duration-300"
            required
        >
        @error('name') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <!-- Category Description -->
    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Description
        </label>
        <textarea 
            id="description" 
            name="description" 
            rows="6"
            placeholder="Provide a brief description of this category (optional)"
            class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-light
                   focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
        >{{ old('description', $category->description) }}</textarea>
        <p class="mt-2 text-sm text-slate-500 font-light">Help customers understand what products belong in this category</p>
        @error('description') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <!-- Metadata -->
    <div class="border-t-2 border-slate-200 pt-8">
        <h3 class="text-lg font-medium text-slate-900 mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Category Information
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
                <p class="text-sm text-slate-600 font-light mb-1">Created At</p>
                <p class="text-base text-slate-900 font-medium">{{ $category->created_at->format('M d, Y H:i') }}</p>
            </div>
            <div class="bg-slate-50 border-2 border-slate-200 rounded-2xl p-4">
                <p class="text-sm text-slate-600 font-light mb-1">Last Updated</p>
                <p class="text-base text-slate-900 font-medium">{{ $category->updated_at->format('M d, Y H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="pt-8 flex gap-4">
        <button 
            type="submit" 
            class="flex items-center gap-2 bg-slate-900 text-white px-8 py-4 rounded-full font-medium text-base
                   hover:bg-slate-800 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Update Category
        </button>
        
        <a 
            href="{{ route('admin.categories.index') }}" 
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