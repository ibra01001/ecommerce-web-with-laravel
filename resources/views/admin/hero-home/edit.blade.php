@extends('admin.layout')

@section('title', 'Edit Hero Home Section')

@section('content')
<div class="flex justify-between items-center mb-8 fade-in">
    <h2 class="text-3xl font-light text-slate-900 flex items-center gap-3">
        <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
        </svg>
        Edit Hero Home Section
    </h2>

    <a href="{{ route('home') }}" target="_blank"
       class="flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors duration-300 font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
        Preview Homepage
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

<form action="{{ route('admin.hero-home.update') }}" method="POST" enctype="multipart/form-data"
      class="space-y-8 bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm max-w-5xl fade-in">
    @csrf
    @method('PUT')

    <!-- Main Heading -->
    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            Main Heading *
        </label>
        <input type="text" name="heading" 
               value="{{ old('heading', $heroSection->heading ?? '') }}"
               class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                      focus:outline-none focus:border-slate-900 transition-all duration-300" 
               placeholder="e.g., Welcome to Our Store"
               required>
        @error('heading') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <!-- Subheading -->
    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Subheading
        </label>
        <input type="text" name="subheading" 
               value="{{ old('subheading', $heroSection->subheading ?? '') }}"
               class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                      focus:outline-none focus:border-slate-900 transition-all duration-300"
               placeholder="A compelling subtitle">
        @error('subheading') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <!-- Hero Content -->
    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Hero Content
        </label>
        <textarea name="content" rows="5"
                  class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-light
                         focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
                  placeholder="Write a brief description or call-to-action...">{{ old('content', $heroSection->content ?? '') }}</textarea>
        @error('content') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <!-- Background Type Selection -->
    <div class="border-t-2 border-slate-200 pt-8">
        <label class="block text-slate-700 font-medium mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
            </svg>
            Background Type *
        </label>
        
        <div class="flex gap-4 mb-6">
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="radio" name="background_type" value="image" 
                       {{ old('background_type', $heroSection->background_type ?? 'image') == 'image' ? 'checked' : '' }}
                       class="w-5 h-5 text-slate-900 focus:ring-slate-900 cursor-pointer"
                       onchange="toggleBackgroundType('image')">
                <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors duration-300">
                    Image Background
                </span>
            </label>
            
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="radio" name="background_type" value="video" 
                       {{ old('background_type', $heroSection->background_type ?? 'image') == 'video' ? 'checked' : '' }}
                       class="w-5 h-5 text-slate-900 focus:ring-slate-900 cursor-pointer"
                       onchange="toggleBackgroundType('video')">
                <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors duration-300">
                    Video Background
                </span>
            </label>
        </div>

        <!-- Image Upload Section -->
        <div id="imageSection" class="background-section">
            <label class="block text-slate-700 font-medium mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Hero Background Image
            </label>
            
            @if($heroSection && $heroSection->background_image_path)
            <div class="mb-4 relative group w-full max-w-2xl">
                <img src="{{ asset('storage/' . $heroSection->background_image_path) }}" 
                     alt="Current background" 
                     class="w-full h-64 object-cover rounded-2xl border-2 border-slate-200">
                <div class="absolute top-4 left-4 bg-slate-900 text-white text-xs px-3 py-1.5 rounded-full font-medium">
                    Current Image
                </div>
            </div>
            @endif
            
            <input type="file" name="background_image" accept="image/*" 
                   class="block w-full text-sm text-slate-600 font-light
                          file:mr-4 file:py-3 file:px-6
                          file:rounded-full file:border-0
                          file:text-sm file:font-medium
                          file:bg-slate-900 file:text-white
                          hover:file:bg-slate-800 file:cursor-pointer file:transition-all file:duration-300
                          cursor-pointer border-2 border-slate-200 rounded-2xl p-3 bg-white">
            <p class="text-slate-500 text-sm mt-2 font-light">Recommended: 1920x1080px or similar ratio (max 2MB)</p>
            @error('background_image') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
        </div>

        <!-- Video Upload Section -->
        <div id="videoSection" class="background-section" style="display: none;">
            <label class="block text-slate-700 font-medium mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                Hero Background Video
            </label>
            
            @if($heroSection && $heroSection->background_video_path)
            <div class="mb-4 relative group w-full max-w-2xl">
                <video class="w-full h-64 object-cover rounded-2xl border-2 border-slate-200" controls>
                    <source src="{{ asset('storage/' . $heroSection->background_video_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <div class="absolute top-4 left-4 bg-slate-900 text-white text-xs px-3 py-1.5 rounded-full font-medium">
                    Current Video
                </div>
            </div>
            @endif
            
            <input type="file" name="background_video" accept="video/mp4,video/webm,video/ogg" 
                   class="block w-full text-sm text-slate-600 font-light
                          file:mr-4 file:py-3 file:px-6
                          file:rounded-full file:border-0
                          file:text-sm file:font-medium
                          file:bg-slate-900 file:text-white
                          hover:file:bg-slate-800 file:cursor-pointer file:transition-all file:duration-300
                          cursor-pointer border-2 border-slate-200 rounded-2xl p-3 bg-white">
            <p class="text-slate-500 text-sm mt-2 font-light">Formats: MP4, WebM, OGG (max 20MB)</p>
            @error('background_video') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
        </div>
    </div>

    <!-- Call-to-Action Buttons -->
    <div class="border-t-2 border-slate-200 pt-8">
        <h3 class="text-2xl font-light text-slate-900 mb-6 flex items-center gap-3">
            <svg class="w-7 h-7 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
            </svg>
            Call-to-Action Buttons
        </h3>
        
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Primary Button -->
            <div class="space-y-4">
                <div>
                    <label class="block text-slate-700 font-medium mb-2">Primary Button Text</label>
                    <input type="text" name="primary_button_text" 
                           value="{{ old('primary_button_text', $heroSection->primary_button_text ?? '') }}"
                           class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                                  focus:outline-none focus:border-slate-900 transition-all duration-300"
                           placeholder="Shop Now">
                    @error('primary_button_text') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-slate-700 font-medium mb-2">Primary Button Link</label>
                    <input type="text" name="primary_button_link" 
                           value="{{ old('primary_button_link', $heroSection->primary_button_link ?? '') }}"
                           class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                                  focus:outline-none focus:border-slate-900 transition-all duration-300"
                           placeholder="/products">
                    @error('primary_button_link') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Secondary Button -->
            <div class="space-y-4">
                <div>
                    <label class="block text-slate-700 font-medium mb-2">Secondary Button Text</label>
                    <input type="text" name="secondary_button_text" 
                           value="{{ old('secondary_button_text', $heroSection->secondary_button_text ?? '') }}"
                           class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                                  focus:outline-none focus:border-slate-900 transition-all duration-300"
                           placeholder="Learn More">
                    @error('secondary_button_text') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-slate-700 font-medium mb-2">Secondary Button Link</label>
                    <input type="text" name="secondary_button_link" 
                           value="{{ old('secondary_button_link', $heroSection->secondary_button_link ?? '') }}"
                           class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                                  focus:outline-none focus:border-slate-900 transition-all duration-300"
                           placeholder="/about-us">
                    @error('secondary_button_link') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Active Status -->
    <div class="border-t-2 border-slate-200 pt-8">
        <label class="flex items-center gap-3 cursor-pointer group">
            <input type="checkbox" name="is_active" value="1" 
                   {{ old('is_active', $heroSection->is_active ?? true) ? 'checked' : '' }}
                   class="w-5 h-5 rounded border-slate-300 bg-white text-slate-900
                          focus:ring-slate-900 focus:ring-offset-0 focus:ring-2 cursor-pointer">
            <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors duration-300">
                Hero Section is Active (visible on homepage)
            </span>
        </label>
    </div>

    <!-- Submit Button -->
    <div class="pt-8 flex gap-4">
        <button type="submit" 
                class="flex items-center gap-2 bg-slate-900 text-white px-8 py-4 rounded-full font-medium text-base
                       hover:bg-slate-800 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Update Hero Section
        </button>
        
        <a href="{{ route('home') }}" target="_blank"
           class="flex items-center gap-2 border-2 border-slate-200 text-slate-900 px-8 py-4 rounded-full font-medium text-base
                  hover:border-slate-900 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            View Live Homepage
        </a>
    </div>
</form>

<script>
function toggleBackgroundType(type) {
    const imageSection = document.getElementById('imageSection');
    const videoSection = document.getElementById('videoSection');
    
    if (type === 'image') {
        imageSection.style.display = 'block';
        videoSection.style.display = 'none';
    } else {
        imageSection.style.display = 'none';
        videoSection.style.display = 'block';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const selectedType = document.querySelector('input[name="background_type"]:checked').value;
    toggleBackgroundType(selectedType);
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
</style>
@endsection