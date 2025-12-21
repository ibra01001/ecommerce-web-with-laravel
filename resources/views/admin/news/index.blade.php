@extends('admin.layout')

@section('title', 'News Banner Settings')

@section('content')
    <!-- Page Header -->
    <div class="pt-8 pb-12 px-6 fade-in">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <h1 class="text-4xl md:text-5xl font-light tracking-tight" style="color: var(--text-color);">News Banner Settings</h1>
                    <p class="text-lg font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Manage promotional banners and announcements</p>
                </div>
            </div>
        </div>
    </div>

    <div class="px-6 pb-16">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Alerts -->
            @if(session('success'))
                <div id="alert-success" class="transform transition-all duration-400 slide-fade-in rounded-lg px-4 py-3 flex items-start gap-3 border"
                    style="background: color-mix(in srgb, var(--primary-color) 10%, transparent); border-color: var(--primary-color); color: var(--text-color);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" style="color: var(--primary-color);" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm font-medium">{{ session('success') }}</div>
                    <button type="button" onclick="dismissAlert('alert-success')" class="ml-auto transition-colors" style="color: var(--primary-color);">✕</button>
                </div>
            @endif

            @if(session('error'))
                <div id="alert-error" class="transform transition-all duration-400 slide-fade-in bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 text-red-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <div class="text-sm font-medium">{{ session('error') }}</div>
                    <button type="button" onclick="dismissAlert('alert-error')" class="ml-auto text-red-600 hover:text-red-800">✕</button>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3">
                    <ul class="list-disc list-inside space-y-1 text-sm font-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Main Form Card -->
            <div class="card p-6 md:p-8 fade-in" style="background: var(--background-color);">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-2 rounded-lg" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" style="color: var(--background-color);">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold" style="color: var(--text-color);">Banner Configuration</h2>
                        <p class="text-sm mt-0.5" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Configure your promotional banner</p>
                    </div>
                </div>

                <form action="{{ route('admin.news.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-color);">Banner Title *</label>
                        <input type="text" name="title" value="{{ old('title', $news->title ?? '') }}" 
                               class="w-full px-4 py-3 rounded-lg border-2 transition-all" 
                               style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 30%, transparent); color: var(--text-color);"
                               placeholder="e.g., Summer Sale - 50% Off!">
                    </div>

                    <!-- Content -->
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-color);">Banner Content</label>
                        <textarea name="content" rows="3"
                                  class="w-full px-4 py-3 rounded-lg border-2 transition-all resize-none" 
                                  style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 30%, transparent); color: var(--text-color);"
                                  placeholder="Add promotional details...">{{ old('content', $news->content ?? '') }}</textarea>
                    </div>

                    <!-- Active Toggle -->
                    <div class="flex items-center gap-3 p-4 rounded-lg" style="background: color-mix(in srgb, var(--primary-color) 5%, transparent);">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" value="1" 
                               {{ old('is_active', $news->is_active ?? false) ? 'checked' : '' }}
                               class="w-5 h-5 rounded cursor-pointer">
                        <label for="is_active" class="font-medium cursor-pointer" style="color: var(--text-color);">
                            Display Banner (visible on website)
                        </label>
                    </div>

                    <!-- Current Images -->
                    @if(isset($news) && method_exists($news, 'hasImages') && $news->hasImages())
                    <div class="border-t pt-6" style="border-color: color-mix(in srgb, var(--text-color) 15%, transparent);">
                        <label class="block text-sm font-medium mb-4" style="color: var(--text-color);">
                            Current Images ({{ $news->getImageCount() }})
                        </label>

                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($news->images as $index => $image)
                            <div class="group">
                                <div class="relative overflow-hidden rounded-lg border-2 mb-2" style="border-color: color-mix(in srgb, var(--primary-color) 20%, transparent);">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Banner {{ $index + 1 }}" 
                                         class="w-full h-40 object-cover">
                                </div>
                                <button type="button" onclick="deleteImage('{{ $news->id }}', '{{ $index }}')"
                                        class="w-full px-3 py-2 rounded-lg text-white text-sm font-medium transition-all bg-red-500 hover:bg-red-600 flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Remove
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Upload New Images -->
                    <div class="border-t pt-6" style="border-color: color-mix(in srgb, var(--text-color) 15%, transparent);">
                        <label class="block text-sm font-medium mb-4" style="color: var(--text-color);">Upload New Images</label>
                        
                        <label class="block cursor-pointer">
                            <div class="border-2 border-dashed rounded-lg p-8 text-center hover:border-opacity-100 transition-all" 
                                 style="border-color: color-mix(in srgb, var(--primary-color) 30%, transparent);">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                                     class="w-12 h-12 mx-auto mb-2" style="color: color-mix(in srgb, var(--text-color) 40%, transparent);">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                </svg>
                                <p class="text-sm font-medium" style="color: var(--text-color);">Click to upload images</p>
                                <p class="text-xs mt-1" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">PNG, JPG, WEBP, GIF (Max 2MB each, up to 10 images)</p>
                            </div>
                            <input type="file" name="images[]" multiple accept="image/jpeg,image/jpg,image/png,image/webp,image/gif" class="hidden">
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex gap-3 pt-4">
                        <button type="submit" class="px-8 py-3 rounded-lg transition-all font-semibold text-white flex items-center gap-2"
                                style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Banner
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeIn 0.5s ease-out; }
        .slide-fade-in { animation: fadeIn 0.4s ease-out; }
    </style>

    <script>
        function deleteImage(newsId, imageIndex) {
            if (!confirm('Delete this image?')) return;
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.news.delete-image") }}';
            
            form.innerHTML = `
                @csrf
                @method('DELETE')
                <input type="hidden" name="news_id" value="${newsId}">
                <input type="hidden" name="image_index" value="${imageIndex}">
            `;
            
            document.body.appendChild(form);
            form.submit();
        }

        function dismissAlert(id) {
            document.getElementById(id)?.remove();
        }
    </script>
@endsection