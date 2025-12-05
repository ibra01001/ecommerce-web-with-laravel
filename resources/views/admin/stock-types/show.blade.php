@extends('admin.layout')

@section('title', 'Manage Stock Type Options')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-semibold text-white flex items-center gap-3">
            <x-heroicon-o-cog class="w-7 h-7 text-yellow-400" />
            {{ $stockType->name }}
        </h2>
        <p class="text-gray-400 mt-1">Manage options for this stock type</p>
    </div>

    <a href="{{ route('admin.stock-types.index') }}" 
       class="flex items-center gap-2 text-gray-400 hover:text-yellow-400 transition">
        <x-heroicon-o-arrow-left class="w-5 h-5" />
        Back to Stock Types
    </a>
</div>

@if(session('success'))
<div class="bg-green-600/20 border border-green-600 text-green-300 px-4 py-3 rounded-lg mb-8 flex items-center gap-2">
    <x-heroicon-o-check-circle class="w-5 h-5 text-green-400" />
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-600/20 border border-red-600 text-red-300 px-4 py-3 rounded-lg mb-8 flex items-center gap-2">
    <x-heroicon-o-x-circle class="w-5 h-5 text-red-400" />
    {{ session('error') }}
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Add New Option Form -->
    <div class="lg:col-span-1">
        <div class="bg-neutral-900/60 p-6 rounded-xl border border-neutral-800 shadow-lg">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                <x-heroicon-o-plus-circle class="w-5 h-5 text-yellow-400" />
                Add New Option
            </h3>

            <form action="{{ route('admin.stock-types.add-option', $stockType) }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-gray-400 mb-2 text-sm">Label *</label>
                    <input type="text" name="label" 
                           placeholder="e.g., S, M, L or 1kg, 2kg"
                           class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                                  focus:outline-none focus:border-yellow-400 transition" required>
                </div>

                <div>
                    <label class="block text-gray-400 mb-2 text-sm">Value (Optional)</label>
                    <input type="text" name="value" 
                           placeholder="For colors: #FF0000"
                           class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                                  focus:outline-none focus:border-yellow-400 transition">
                    <p class="text-gray-500 text-xs mt-1">Use for color codes or special values</p>
                </div>

                <div>
                    <label class="block text-gray-400 mb-2 text-sm">Sort Order</label>
                    <input type="number" name="sort_order" 
                           value="{{ $stockType->options->count() }}"
                           min="0"
                           class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                                  focus:outline-none focus:border-yellow-400 transition">
                </div>

                <button type="submit" 
                        class="w-full flex items-center justify-center gap-2 bg-yellow-400 text-black px-4 py-2.5 rounded-lg font-semibold 
                               hover:bg-yellow-500 transition">
                    <x-heroicon-o-plus class="w-5 h-5" />
                    Add Option
                </button>
            </form>
        </div>
    </div>

    <!-- Existing Options List -->
    <div class="lg:col-span-2">
        <div class="bg-neutral-900/60 rounded-xl border border-neutral-800 shadow-lg">
            <div class="p-6 border-b border-neutral-800">
                <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                    <x-heroicon-o-list-bullet class="w-5 h-5 text-yellow-400" />
                    Current Options ({{ $stockType->options->count() }})
                </h3>
            </div>

            <div class="p-6">
                @if($stockType->options->count() > 0)
                    <div class="space-y-3">
                        @foreach($stockType->options as $option)
                        <div class="flex items-center justify-between bg-neutral-950 p-4 rounded-lg border border-neutral-700">
                            <div class="flex items-center gap-4">
                                <span class="text-gray-500 text-sm font-mono">{{ $option->sort_order }}</span>
                                <div>
                                    <p class="text-white font-medium">{{ $option->label }}</p>
                                    @if($option->value)
                                        <p class="text-gray-400 text-sm">Value: {{ $option->value }}</p>
                                    @endif
                                </div>
                                @if($option->is_active)
                                    <span class="px-2 py-1 bg-green-600/20 text-green-400 rounded text-xs">Active</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-600/20 text-gray-400 rounded text-xs">Inactive</span>
                                @endif
                            </div>

                            <div class="flex items-center gap-3">
                                <button onclick="editOption({{ $option->id }}, '{{ $option->label }}', '{{ $option->value }}', {{ $option->sort_order }}, {{ $option->is_active ? 'true' : 'false' }})"
                                        class="text-yellow-400 hover:text-yellow-300 transition" title="Edit">
                                    <x-heroicon-o-pencil-square class="w-5 h-5" />
                                </button>
                                
                                <form action="{{ route('admin.stock-types.delete-option', $option) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure? Products using this option will be affected.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-400 transition" title="Delete">
                                        <x-heroicon-o-trash class="w-5 h-5" />
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12 text-gray-500">
                        <x-heroicon-o-inbox class="w-12 h-12 mx-auto mb-3 text-gray-600" />
                        <p>No options added yet. Add your first option!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Edit Option Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black/80 z-50 flex items-center justify-center p-4">
    <div class="bg-neutral-900 rounded-xl border border-neutral-800 max-w-md w-full p-6">
        <h3 class="text-xl font-semibold text-white mb-4">Edit Option</h3>
        
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-gray-400 mb-2 text-sm">Label *</label>
                <input type="text" id="edit_label" name="label" 
                       class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                              focus:outline-none focus:border-yellow-400 transition" required>
            </div>

            <div>
                <label class="block text-gray-400 mb-2 text-sm">Value (Optional)</label>
                <input type="text" id="edit_value" name="value" 
                       class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                              focus:outline-none focus:border-yellow-400 transition">
            </div>

            <div>
                <label class="block text-gray-400 mb-2 text-sm">Sort Order</label>
                <input type="number" id="edit_sort_order" name="sort_order" 
                       min="0"
                       class="w-full bg-neutral-950 border border-neutral-700 rounded-lg p-3 text-gray-200 
                              focus:outline-none focus:border-yellow-400 transition">
            </div>

            <div class="flex items-center gap-2">
                <input type="checkbox" id="edit_is_active" name="is_active" value="1"
                       class="w-4 h-4 rounded border-neutral-700 bg-neutral-950 text-yellow-400 
                              focus:ring-yellow-400 focus:ring-offset-0">
                <label for="edit_is_active" class="text-gray-400 text-sm">Active</label>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" 
                        class="flex-1 bg-yellow-400 text-black px-4 py-2.5 rounded-lg font-semibold 
                               hover:bg-yellow-500 transition">
                    Update
                </button>
                <button type="button" onclick="closeEditModal()"
                        class="flex-1 bg-neutral-800 text-gray-300 px-4 py-2.5 rounded-lg font-semibold 
                               hover:bg-neutral-700 transition">
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
</script>
@endsection