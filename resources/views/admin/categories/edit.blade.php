@extends('admin.layout')
@section('title', 'Edit Category')

@section('content')
<div class="bg-neutral-900 p-6 rounded-2xl shadow-lg border border-neutral-800">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.categories.index') }}" 
           class="text-gray-400 hover:text-yellow-400 transition">
            <x-heroicon-o-arrow-left class="w-6 h-6" />
        </a>
        <h2 class="text-2xl font-semibold text-white flex items-center gap-2">
            <x-heroicon-o-pencil-square class="w-6 h-6 text-yellow-400" />
            Edit Category
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

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Category Info Badge -->
        <div class="p-4 bg-neutral-800 border border-neutral-700 rounded-lg flex items-center justify-between">
            <div class="flex items-center gap-3">
                <x-heroicon-o-information-circle class="w-5 h-5 text-blue-400" />
                <div>
                    <p class="text-sm text-gray-400">Editing Category ID</p>
                    <p class="text-lg font-semibold text-yellow-400">#{{ $category->id }}</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-400">Products in this category</p>
                <p class="text-lg font-semibold text-blue-400">{{ $category->products->count() }}</p>
            </div>
        </div>

        <!-- Category Name -->
        <div>
            <label for="name" class="block text-gray-300 font-medium mb-2">
                Category Name <span class="text-red-400">*</span>
            </label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                value="{{ old('name', $category->name) }}"
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
            >{{ old('description', $category->description) }}</textarea>
            <p class="mt-2 text-xs text-gray-500">Provide a brief description of this category</p>
        </div>

        <!-- Metadata -->
        <div class="p-4 bg-neutral-800/50 border border-neutral-700 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400">Created At</p>
                    <p class="text-gray-300 font-medium">{{ $category->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Last Updated</p>
                    <p class="text-gray-300 font-medium">{{ $category->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-3 pt-4">
            <button 
                type="submit" 
                class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-neutral-900 font-semibold rounded-lg transition flex items-center gap-2">
                <x-heroicon-o-check class="w-5 h-5" />
                Update Category
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