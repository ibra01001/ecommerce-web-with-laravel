@extends('admin.layout')
@section('title', 'Categories')

@section('content')
<div class="bg-neutral-900 p-6 rounded-2xl shadow-lg border border-neutral-800">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-white flex items-center gap-2">
            <x-heroicon-o-tag class="w-6 h-6 text-yellow-400" />
            Categories Dashboard
        </h2>
        <a href="{{ route('admin.categories.create') }}" 
           class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-neutral-900 font-semibold rounded-lg transition flex items-center gap-2">
            <x-heroicon-o-plus class="w-5 h-5" />
            Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-500/10 border border-green-500/30 rounded-lg text-green-400">
            {{ session('success') }}
        </div>
    @endif

    <!-- Categories Table -->
    <div class="overflow-x-auto rounded-xl border border-neutral-800">
        <table class="min-w-full text-gray-300 text-sm">
            <thead class="bg-neutral-800 text-gray-400 uppercase text-xs">
                <tr>
                    <th class="py-3 px-6 text-left">#</th>
                    <th class="py-3 px-6 text-left">Name</th>
                    <th class="py-3 px-6 text-left">Description</th>
                    <th class="py-3 px-6 text-left">Products</th>
                    <th class="py-3 px-6 text-left">Created</th>
                    <th class="py-3 px-6 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-neutral-800">
                @forelse($categories as $category)
                <tr class="hover:bg-neutral-800/50 transition">
                    <td class="py-4 px-6 font-semibold text-yellow-400">#{{ $category->id }}</td>
                    <td class="py-4 px-6 font-medium text-white">{{ $category->name }}</td>
                    <td class="py-4 px-6 text-gray-400">
                        {{ Str::limit($category->description, 50) ?? 'No description' }}
                    </td>
                    <td class="py-4 px-6">
                        <span class="px-3 py-1 bg-blue-500/10 text-blue-400 rounded-full text-xs font-medium">
                            {{ $category->products->count() }} products
                        </span>
                    </td>
                    <td class="py-4 px-6">{{ $category->created_at->format('M d, Y') }}</td>

                    <!-- Actions -->
                    <td class="py-4 px-6 text-center">
                        <div class="flex justify-center items-center gap-3">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.categories.edit', $category->id) }}" 
                               class="text-blue-400 hover:text-blue-500 transition" 
                               title="Edit Category">
                                <x-heroicon-o-pencil class="w-5 h-5" />
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this category? This will also affect related products.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-500 transition" title="Delete Category">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                        <div class="flex flex-col items-center gap-2">
                            <x-heroicon-o-inbox class="w-12 h-12 text-gray-600" />
                            <p class="text-lg">No categories found</p>
                            <a href="{{ route('admin.categories.create') }}" 
                               class="mt-2 text-yellow-400 hover:text-yellow-500 text-sm">
                                Create your first category
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection