@extends('admin.layout')
@section('title', 'Add Category')

@section('content')
<div class="bg-neutral-900 p-6 rounded-2xl shadow-lg border border-neutral-800">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.categories.index') }}" 
           class="text-gray-400 hover:text-yellow-400 transition">
            <x-heroicon-o-arrow-left class="w-6 h-6" />
        </a>
        <h2 class="text-2xl font-semibold text-white flex items-center gap-2">
            <x-heroicon-o-plus-circle class="w-6 h-6 text-yellow-400" />
            Add New Category
        </h2>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-500/10 border border-red-500/30 rounded-lg">
            <ul class="list-disc list-inside text-red-400 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Category Name -->
        <div>
            <label for="name" class="block text-gray-300 font-medium mb-2">
                Category Name <span class="text-red-400">*</span>
            </label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name') }}"
                placeholder="Enter category name"
                class="w-full px-4 py-3 bg-neutral-800 border border-neutral-700 rounded-lg text-gray-300 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                required
            >
        </div>

        <!-- Category Description -->
        <div>
            <label for="description" class="block text-gray-300 font-medium mb-2">
                Description
            </label>
            <textarea 
                id="description" 
                name="description" 
                rows="5"
                placeholder="Enter category description (optional)"
                class="w-full px-4 py-3 bg-neutral-800 border border-neutral-700 rounded-lg text-gray-300 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent resize-none"
            >{{ old('description') }}</textarea>
            <p class="mt-2 text-xs text-gray-500">Provide a brief description of this category</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-4">
            <button 
                type="submit" 
                class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-neutral-900 font-semibold rounded-lg transition flex items-center gap-2">
                <x-heroicon-o-check class="w-5 h-5" />
                Create Category
            </button>
            
            <a 
                href="{{ route('admin.categories.index') }}" 
                class="px-6 py-3 bg-neutral-800 hover:bg-neutral-700 text-gray-300 font-semibold rounded-lg transition flex items-center gap-2">
                <x-heroicon-o-x-mark class="w-5 h-5" />
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection