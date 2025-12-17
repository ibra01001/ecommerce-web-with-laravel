@extends('admin.layout')

@section('title', 'Manage Stock Type Options')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.stock-types.index') }}" 
           class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h2 class="text-3xl font-light text-slate-900 flex items-center gap-3">
                <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ $stockType->name }}
            </h2>
            <p class="text-slate-600 mt-1 font-light">Manage options for this stock type</p>
        </div>
    </div>

    <a href="{{ route('admin.stock-types.index') }}" 
       class="flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors duration-300 font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
        </svg>
        All Stock Types
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

@if(session('error'))
<div class="mb-6 bg-red-50 border-2 border-red-200 text-red-800 px-6 py-4 rounded-2xl flex items-center gap-3">
    <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span class="font-medium">{{ session('error') }}</span>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Add New Option Form -->
    <div class="lg:col-span-1">
        <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm">
            <h3 class="text-xl font-light text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Add New Option
            </h3>

            <form action="{{ route('admin.stock-types.add-option', $stockType) }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Label *
                    </label>
                    <input type="text" name="label" 
                           placeholder="e.g., S, M, L or 1kg, 2kg"
                           class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                                  focus:outline-none focus:border-slate-900 transition-all duration-300" required>
                </div>


                <div>
                    <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                        </svg>
                        Sort Order
                    </label>
                    <input type="number" name="sort_order" 
                           value="{{ $stockType->options->count() }}"
                           min="0"
                           class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                                  focus:outline-none focus:border-slate-900 transition-all duration-300">
                </div>

                <button type="submit" 
                        class="w-full flex items-center justify-center gap-2 bg-slate-900 text-white px-4 py-3.5 rounded-full font-medium 
                               hover:bg-slate-800 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Option
                </button>
            </form>
        </div>
    </div>

    <!-- Existing Options List -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-sm">
            <div class="p-6 border-b-2 border-slate-200">
                <h3 class="text-xl font-light text-slate-900 flex items-center gap-2">
                    <svg class="w-6 h-6 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                    Current Options ({{ $stockType->options->count() }})
                </h3>
            </div>

            <div class="p-6">
                @if($stockType->options->count() > 0)
                    <div class="space-y-3">
                        @foreach($stockType->options as $option)
                        <div class="flex items-center justify-between bg-slate-50 p-5 rounded-2xl border-2 border-slate-200 hover:border-slate-300 transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <span class="text-slate-500 text-sm font-mono bg-white px-3 py-1.5 rounded-full border-2 border-slate-200">
                                    #{{ $option->sort_order }}
                                </span>
                                <div>
                                    <p class="text-slate-900 font-medium">{{ $option->label }}</p>
                                    @if($option->value)
                                        <p class="text-slate-600 text-sm font-light mt-0.5">Value: {{ $option->value }}</p>
                                    @endif
                                </div>
                                @if($option->is_active)
                                    <span class="px-3 py-1.5 bg-green-50 text-green-700 border-2 border-green-200 rounded-full text-xs font-medium">
                                        Active
                                    </span>
                                @else
                                    <span class="px-3 py-1.5 bg-slate-100 text-slate-600 border-2 border-slate-200 rounded-full text-xs font-medium">
                                        Inactive
                                    </span>
                                @endif
                            </div>

                            <div class="flex items-center gap-3">
                                <button onclick="editOption({{ $option->id }}, '{{ $option->label }}', '{{ $option->value }}', {{ $option->sort_order }}, {{ $option->is_active ? 'true' : 'false' }})"
                                        class="text-slate-600 hover:text-slate-900 hover:bg-slate-100 p-2 rounded-lg transition-all duration-300" 
                                        title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                
                                <form action="{{ route('admin.stock-types.delete-option', $option) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure? Products using this option will be affected.')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all duration-300" 
                                            title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16 text-slate-500">
                        <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <p class="font-light text-lg">No options added yet</p>
                        <p class="text-sm mt-1 font-light">Add your first option using the form on the left</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Edit Option Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl border-2 border-slate-200 shadow-2xl max-w-lg w-full p-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-light text-slate-900 flex items-center gap-2">
                <svg class="w-6 h-6 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Option
            </h3>
            <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-900 transition-colors duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form id="editForm" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-slate-700 font-medium mb-3">Label *</label>
                <input type="text" id="edit_label" name="label" 
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300" required>
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-3">Value (Optional)</label>
                <input type="text" id="edit_value" name="value" 
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300">
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-3">Sort Order</label>
                <input type="number" id="edit_sort_order" name="sort_order" 
                       min="0"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300">
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="edit_is_active" name="is_active" value="1"
                       class="w-5 h-5 rounded border-slate-300 bg-white text-slate-900
                              focus:ring-slate-900 focus:ring-offset-0 focus:ring-2 cursor-pointer">
                <label for="edit_is_active" class="text-slate-700 font-medium cursor-pointer">Active</label>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" 
                        class="flex-1 flex items-center justify-center gap-2 bg-slate-900 text-white px-4 py-3.5 rounded-full font-medium 
                               hover:bg-slate-800 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Option
                </button>
                <button type="button" onclick="closeEditModal()"
                        class="flex-1 flex items-center justify-center gap-2 border-2 border-slate-200 text-slate-900 px-4 py-3.5 rounded-full font-medium 
                               hover:border-slate-900 transition-all duration-300">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function editOption(id, label, value, sortOrder, isActive) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    
    form.action = `/admin/stock-types/options/${id}`;
    document.getElementById('edit_label').value = label;
    document.getElementById('edit_value').value = value || '';
    document.getElementById('edit_sort_order').value = sortOrder;
    document.getElementById('edit_is_active').checked = isActive;
    
    modal.classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Close modal on outside click
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
    }
});
</script>
@endsection