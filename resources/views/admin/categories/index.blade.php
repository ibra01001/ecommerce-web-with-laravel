@extends('admin.layout')
@section('title', 'Categories')

@section('content')
<div class="flex justify-between items-center mb-8 fade-in">
    <h2 class="text-3xl font-light text-slate-900 flex items-center gap-3">
        <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
        </svg>
        Categories Dashboard
    </h2>

    <a href="{{ route('admin.categories.create') }}" 
       class="flex items-center gap-2 bg-slate-900 text-white px-6 py-3 rounded-full font-medium
              hover:bg-slate-800 transition-all duration-300">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Add Category
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

<!-- Categories Table -->
<div class="bg-white rounded-2xl border-2 border-slate-200 shadow-sm overflow-hidden fade-in">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-slate-50 border-b-2 border-slate-200">
                <tr>
                    <th class="py-4 px-6 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">#</th>
                    <th class="py-4 px-6 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Name</th>
                    <th class="py-4 px-6 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Description</th>
                    <th class="py-4 px-6 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Products</th>
                    <th class="py-4 px-6 text-left text-xs font-medium text-slate-700 uppercase tracking-wider">Created</th>
                    <th class="py-4 px-6 text-center text-xs font-medium text-slate-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($categories as $category)
                <tr class="hover:bg-slate-50 transition-colors duration-200">
                    <td class="py-4 px-6 font-medium text-slate-900">#{{ $category->id }}</td>
                    <td class="py-4 px-6">
                        <span class="font-medium text-slate-900">{{ $category->name }}</span>
                    </td>
                    <td class="py-4 px-6 text-slate-600 font-light">
                        {{ Str::limit($category->description, 50) ?? 'No description' }}
                    </td>
                    <td class="py-4 px-6">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-700 rounded-full text-xs font-medium border border-slate-200">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            {{ $category->products->count() }} products
                        </span>
                    </td>
                    <td class="py-4 px-6 text-slate-600 font-light">
                        {{ $category->created_at->format('M d, Y') }}
                    </td>

                    <!-- Actions -->
                    <td class="py-4 px-6">
                        <div class="flex justify-center items-center gap-2">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.categories.edit', $category->id) }}" 
                               class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300" 
                               title="Edit Category">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this category? This will also affect related products.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-300" 
                                        title="Delete Category">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-16 px-6">
                        <div class="flex flex-col items-center gap-4 text-center">
                            <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-lg font-medium text-slate-900 mb-1">No categories found</p>
                                <p class="text-slate-600 font-light mb-4">Get started by creating your first category</p>
                            </div>
                            <a href="{{ route('admin.categories.create') }}" 
                               class="flex items-center gap-2 bg-slate-900 text-white px-6 py-3 rounded-full font-medium
                                      hover:bg-slate-800 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Create First Category
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            opacity: 0;
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
@endsection