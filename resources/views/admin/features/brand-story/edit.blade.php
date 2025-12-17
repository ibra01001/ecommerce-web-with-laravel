{{-- resources/views/admin/features/brand-story/edit.blade.php --}}
@extends('admin.layout')

@section('title', 'Edit Brand Story Section')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}"
               class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h2 class="text-3xl font-bold text-slate-900 flex items-center gap-3">
                <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Edit Brand Story
            </h2>
        </div>

        <a href="{{ route('home') }}" target="_blank"
           class="flex items-center gap-2 px-4 py-2 text-slate-600 hover:text-slate-900 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            Preview
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg text-green-800 flex items-center gap-3">
        <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg text-red-800">
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

    <form action="{{ route('admin.brand-story.update') }}" method="POST" class="space-y-8 bg-white p-8 rounded-lg border border-slate-200 shadow-sm">
        @csrf
        @method('PUT')

        <!-- Content Section -->
        <div class="space-y-6">
            <h3 class="text-xl font-semibold text-slate-900 flex items-center gap-2 pb-4 border-b border-slate-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Content
            </h3>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Section Title *</label>
                <input type="text" name="title" 
                       value="{{ old('title', $brandStory->title ?? '') }}"
                       class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-900 focus:border-transparent"
                       placeholder="e.g., Crafted with Purpose"
                       required>
                @error('title')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Description *</label>
                <textarea name="description" rows="5"
                          class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-900 focus:border-transparent resize-none"
                          placeholder="Tell your brand's story..."
                          required>{{ old('description', $brandStory->description ?? '') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Call-to-Action Button -->
        <div class="space-y-6 border-t border-slate-200 pt-8">
            <h3 class="text-xl font-semibold text-slate-900 flex items-center gap-2 pb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                Call-to-Action Button
            </h3>

            <label class="flex items-center gap-3 cursor-pointer group mb-4">
                <input type="checkbox" name="show_button" value="1"
                       {{ old('show_button', $brandStory->show_button ?? false) ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-slate-300 text-slate-900 focus:ring-2 focus:ring-slate-900 cursor-pointer"
                       onchange="toggleButton(this.checked)">
                <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors">
                    Show call-to-action button
                </span>
            </label>

            <div id="buttonFields" class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Button Text</label>
                    <input type="text" name="button_text" 
                           value="{{ old('button_text', $brandStory->button_text ?? '') }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-900 focus:border-transparent"
                           placeholder="Learn More About Us">
                    @error('button_text')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Button Link</label>
                    <input type="text" name="button_link" 
                           value="{{ old('button_link', $brandStory->button_link ?? '') }}"
                           class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-slate-900 focus:border-transparent"
                           placeholder="/about-us">
                    @error('button_link')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Color Customization -->
        <div class="space-y-6 border-t border-slate-200 pt-8">
            <h3 class="text-xl font-semibold text-slate-900 flex items-center gap-2 pb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                Color Customization
            </h3>

            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Background Color</label>
                    <div class="flex gap-2">
                        <input type="color" name="background_color" 
                               value="{{ old('background_color', $brandStory->background_color ?? '#ffffff') }}"
                               class="h-10 w-20 border border-slate-300 rounded cursor-pointer">
                        <input type="text" 
                               value="{{ old('background_color', $brandStory->background_color ?? '#ffffff') }}"
                               class="flex-1 px-4 py-2 border border-slate-300 rounded-lg"
                               readonly>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Title Color</label>
                    <div class="flex gap-2">
                        <input type="color" name="title_color" 
                               value="{{ old('title_color', $brandStory->title_color ?? '#000000') }}"
                               class="h-10 w-20 border border-slate-300 rounded cursor-pointer">
                        <input type="text" 
                               value="{{ old('title_color', $brandStory->title_color ?? '#000000') }}"
                               class="flex-1 px-4 py-2 border border-slate-300 rounded-lg"
                               readonly>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Description Color</label>
                    <div class="flex gap-2">
                        <input type="color" name="description_color" 
                               value="{{ old('description_color', $brandStory->description_color ?? '#666666') }}"
                               class="h-10 w-20 border border-slate-300 rounded cursor-pointer">
                        <input type="text" 
                               value="{{ old('description_color', $brandStory->description_color ?? '#666666') }}"
                               class="flex-1 px-4 py-2 border border-slate-300 rounded-lg"
                               readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Visibility -->
        <div class="border-t border-slate-200 pt-8">
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $brandStory->is_active ?? true) ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-slate-300 text-slate-900 focus:ring-2 focus:ring-slate-900 cursor-pointer">
                <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors">
                    Brand story section is active (visible on homepage)
                </span>
            </label>
        </div>

        <!-- Preview Section -->
        <div class="border-t border-slate-200 pt-8">
            <h3 class="text-xl font-semibold text-slate-900 mb-6 flex items-center gap-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Live Preview
            </h3>
            
            <div id="preview" class="p-12 rounded-lg border border-slate-200" style="background-color: {{ old('background_color', $brandStory->background_color ?? '#ffffff') }}">
                <div class="max-w-2xl mx-auto text-center space-y-6">
                    <h2 class="text-3xl font-light tracking-tight" style="color: {{ old('title_color', $brandStory->title_color ?? '#000000') }}" id="preview-title">
                        {{ old('title', $brandStory->title ?? 'Crafted with Purpose') }}
                    </h2>
                    <p class="text-lg font-light leading-relaxed" style="color: {{ old('description_color', $brandStory->description_color ?? '#666666') }}" id="preview-description">
                        {{ old('description', $brandStory->description ?? 'Your brand story...') }}
                    </p>
                    <div id="preview-button" class="{{ old('show_button', $brandStory->show_button ?? false) ? '' : 'hidden' }}">
                        <span class="inline-flex items-center gap-2 font-medium" style="color: {{ old('title_color', $brandStory->title_color ?? '#000000') }}" id="preview-button-text">
                            {{ old('button_text', $brandStory->button_text ?? 'Learn More') }}
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="pt-8 flex gap-4">
            <button type="submit"
                    class="flex items-center gap-2 bg-slate-900 text-white px-8 py-3 rounded-lg font-medium hover:bg-slate-800 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Update Brand Story
            </button>
            
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-2 border border-slate-300 text-slate-900 px-8 py-3 rounded-lg font-medium hover:bg-slate-50 transition-all duration-300">
                Back to Dashboard
            </a>
        </div>
    </form>
</div>

<script>
function toggleButton(show) {
    const buttonFields = document.getElementById('buttonFields');
    const previewButton = document.getElementById('preview-button');
    buttonFields.style.opacity = show ? '1' : '0.5';
    previewButton.classList.toggle('hidden', !show);
}

// Live preview updates
document.addEventListener('DOMContentLoaded', function() {
    // Initialize button visibility
    const showButton = document.querySelector('input[name="show_button"]');
    if (showButton) {
        toggleButton(showButton.checked);
    }
    
    // Title preview
    const titleInput = document.querySelector('input[name="title"]');
    if (titleInput) {
        titleInput.addEventListener('input', function() {
            document.getElementById('preview-title').textContent = this.value || 'Crafted with Purpose';
        });
    }
    
    // Description preview
    const descInput = document.querySelector('textarea[name="description"]');
    if (descInput) {
        descInput.addEventListener('input', function() {
            document.getElementById('preview-description').textContent = this.value || 'Your brand story...';
        });
    }
    
    // Button text preview
    const btnTextInput = document.querySelector('input[name="button_text"]');
    if (btnTextInput) {
        btnTextInput.addEventListener('input', function() {
            const btnText = document.getElementById('preview-button-text');
            if (btnText && btnText.childNodes[0]) {
                btnText.childNodes[0].textContent = this.value || 'Learn More';
            }
        });
    }
    
    // Color previews
    const bgColorInput = document.querySelector('input[name="background_color"]');
    if (bgColorInput) {
        bgColorInput.addEventListener('input', function() {
            document.getElementById('preview').style.backgroundColor = this.value;
            if (this.nextElementSibling) {
                this.nextElementSibling.value = this.value;
            }
        });
    }
    
    const titleColorInput = document.querySelector('input[name="title_color"]');
    if (titleColorInput) {
        titleColorInput.addEventListener('input', function() {
            document.getElementById('preview-title').style.color = this.value;
            const btnText = document.getElementById('preview-button-text');
            if (btnText) {
                btnText.style.color = this.value;
            }
            if (this.nextElementSibling) {
                this.nextElementSibling.value = this.value;
            }
        });
    }
    
    const descColorInput = document.querySelector('input[name="description_color"]');
    if (descColorInput) {
        descColorInput.addEventListener('input', function() {
            document.getElementById('preview-description').style.color = this.value;
            if (this.nextElementSibling) {
                this.nextElementSibling.value = this.value;
            }
        });
    }
});
</script>
@endsection