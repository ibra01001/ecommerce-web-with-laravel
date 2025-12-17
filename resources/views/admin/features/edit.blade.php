@extends('admin.layout')

@section('title', 'Manage Features Section')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center fade-in">
        <h2 class="text-3xl font-light text-slate-900 flex items-center gap-3">
            <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            Features Section Management
        </h2>
        <div class="flex gap-3">
            <a href="{{ route('admin.brand-story.edit') }}"
               class="flex items-center gap-2 border-2 border-slate-200 text-slate-900 px-6 py-3 rounded-full font-medium
                      hover:border-slate-900 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Edit Brand Story
            </a>
            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors duration-300 font-medium px-6 py-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Preview
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-2xl flex items-center gap-3 fade-in">
        <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="bg-red-50 border-2 border-red-200 text-red-800 px-6 py-4 rounded-2xl fade-in">
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

    <!-- Section Settings Form -->
    <form action="{{ route('admin.features.update') }}" method="POST"
          class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm space-y-6 fade-in">
        @csrf
        @method('PUT')

        <h3 class="text-xl font-medium text-slate-900 flex items-center gap-2 border-b-2 border-slate-100 pb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Section Configuration
        </h3>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-slate-700 font-medium mb-2">Section Title</label>
                <input type="text" name="section_title" 
                       value="{{ old('section_title', $featuresSection->section_title) }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="Why Choose Us">
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-2">Background Color</label>
                <div class="flex gap-2">
                    <input type="color" name="background_color" 
                           value="{{ old('background_color', $featuresSection->background_color) }}"
                           class="h-12 w-20 border-2 border-slate-200 rounded-lg cursor-pointer">
                    <input type="text" 
                           value="{{ old('background_color', $featuresSection->background_color) }}"
                           class="flex-1 bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900
                                  focus:outline-none focus:border-slate-900 transition-all duration-300"
                           readonly>
                </div>
            </div>
        </div>

        <div>
            <label class="block text-slate-700 font-medium mb-2">Section Description (Optional)</label>
            <textarea name="section_description" rows="3"
                      class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900
                             focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
                      placeholder="A brief description about your features...">{{ old('section_description', $featuresSection->section_description) }}</textarea>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-slate-700 font-medium mb-2">Layout Style</label>
                <select name="layout_style"
                        class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900
                               focus:outline-none focus:border-slate-900 transition-all duration-300 cursor-pointer">
                    <option value="grid" {{ old('layout_style', $featuresSection->layout_style) == 'grid' ? 'selected' : '' }}>Grid Layout</option>
                    <option value="carousel" {{ old('layout_style', $featuresSection->layout_style) == 'carousel' ? 'selected' : '' }}>Carousel</option>
                    <option value="list" {{ old('layout_style', $featuresSection->layout_style) == 'list' ? 'selected' : '' }}>List View</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-2">Number of Columns</label>
                <select name="columns"
                        class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900
                               focus:outline-none focus:border-slate-900 transition-all duration-300 cursor-pointer">
                    <option value="2" {{ old('columns', $featuresSection->columns) == '2' ? 'selected' : '' }}>2 Columns</option>
                    <option value="3" {{ old('columns', $featuresSection->columns) == '3' ? 'selected' : '' }}>3 Columns</option>
                    <option value="4" {{ old('columns', $featuresSection->columns) == '4' ? 'selected' : '' }}>4 Columns</option>
                </select>
            </div>
        </div>

        <div class="space-y-3 border-t-2 border-slate-100 pt-6">
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" name="show_section_title" value="1"
                       {{ old('show_section_title', $featuresSection->show_section_title) ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-slate-300 bg-white text-slate-900
                              focus:ring-slate-900 focus:ring-offset-0 focus:ring-2 cursor-pointer">
                <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors duration-300">
                    Show Section Title
                </span>
            </label>

            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" name="show_section_description" value="1"
                       {{ old('show_section_description', $featuresSection->show_section_description) ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-slate-300 bg-white text-slate-900
                              focus:ring-slate-900 focus:ring-offset-0 focus:ring-2 cursor-pointer">
                <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors duration-300">
                    Show Section Description
                </span>
            </label>

            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $featuresSection->is_active) ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-slate-300 bg-white text-slate-900
                              focus:ring-slate-900 focus:ring-offset-0 focus:ring-2 cursor-pointer">
                <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors duration-300">
                    Section is Active (visible on homepage)
                </span>
            </label>
        </div>

        <div class="pt-4">
            <button type="submit"
                    class="flex items-center gap-2 bg-slate-900 text-white px-8 py-4 rounded-full font-medium
                           hover:bg-slate-800 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Update Section Settings
            </button>
        </div>
    </form>

    <!-- Feature Items Management -->
    <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm fade-in">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-medium text-slate-900 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Feature Items ({{ $featuresSection->items->count() }})
            </h3>
            <a href="{{ route('admin.features.items.create') }}"
               class="flex items-center gap-2 bg-slate-900 text-white px-6 py-3 rounded-full font-medium
                      hover:bg-slate-800 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add New Feature
            </a>
        </div>

        @if($featuresSection->items->count() > 0)
        <div class="space-y-4" id="features-list">
            @foreach($featuresSection->items as $item)
            <div class="border-2 border-slate-200 rounded-2xl p-6 hover:border-slate-300 transition-all duration-300 feature-item"
                 data-id="{{ $item->id }}">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex items-start gap-4 flex-1">
                        <!-- Drag Handle -->
                        <div class="drag-handle cursor-move text-slate-400 hover:text-slate-600 transition-colors pt-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                            </svg>
                        </div>

                        <!-- Icon Preview -->
                        <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center">
                            @if($item->icon_type === 'svg')
                                <svg class="w-12 h-12" style="color: {{ $item->icon_color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $item->icon_svg !!}
                                </svg>
                            @elseif($item->icon_type === 'svg_upload')
                                <div style="width: auto; height: auto; color: {{ $item->icon_color }}">
                                    {!! $item->icon_svg_content !!}
                                </div>
                            @elseif($item->icon_type === 'image' && $item->icon_image_url)
                                <img src="{{ $item->icon_image_url }}" alt="{{ $item->title }}" class="w-12 h-12 object-contain">
                            @elseif($item->icon_type === 'emoji')
                                <span class="text-4xl">{{ $item->icon_emoji }}</span>
                            @endif
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <h4 class="text-lg font-medium text-slate-900 mb-1">{{ $item->title }}</h4>
                            <p class="text-slate-600 text-sm mb-2">{{ Str::limit($item->description, 100) }}</p>
                            <div class="flex items-center gap-3 text-xs text-slate-500">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    {{ ucfirst(str_replace('_', ' ', $item->icon_type)) }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                    </svg>
                                    Order: {{ $item->display_order }}
                                </span>
                                @if(!$item->is_active)
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full font-medium">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.features.items.edit', $item->id) }}"
                           class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300"
                           title="Edit">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <form action="{{ route('admin.features.items.delete', $item->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this feature item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-2 text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-300"
                                    title="Delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 space-y-4">
            <div class="w-16 h-16 mx-auto bg-slate-100 rounded-full flex items-center justify-center">
                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <h4 class="text-lg text-slate-900 font-medium mb-2">No Features Yet</h4>
                <p class="text-slate-600 mb-4">Add your first feature to showcase your brand's strengths</p>
                <a href="{{ route('admin.features.items.create') }}"
                   class="inline-flex items-center gap-2 bg-slate-900 text-white px-6 py-3 rounded-full font-medium
                          hover:bg-slate-800 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add First Feature
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Sortable.js for drag and drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const featuresList = document.getElementById('features-list');
    if (featuresList) {
        new Sortable(featuresList, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'opacity-50',
            onEnd: function(evt) {
                const items = [];
                document.querySelectorAll('.feature-item').forEach((item, index) => {
                    items.push({
                        id: item.dataset.id,
                        order: index
                    });
                });

                // Send update to server
                fetch('{{ route("admin.features.items.reorder") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ items: items })
                });
            }
        });
    }
});
</script>

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
.fade-in:nth-child(2) { animation-delay: 0.1s; }
.fade-in:nth-child(3) { animation-delay: 0.2s; }
.fade-in:nth-child(4) { animation-delay: 0.3s; }

/* Constrain SVG sizes in admin preview */
.feature-item svg {
    max-width: 48px;
    max-height: 48px;
}
</style>
@endsection