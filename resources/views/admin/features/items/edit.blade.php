{{-- resources/views/admin/features/items/edit.blade.php --}}
@extends('admin.layout')

@section('title', 'Edit Feature Item')

@section('content')
<div class="max-w-4xl">
    <div class="flex items-center gap-4 mb-8 fade-in">
        <a href="{{ route('admin.features.edit') }}"
           class="p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-lg transition-all duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h2 class="text-3xl font-light text-slate-900">Edit Feature Item</h2>
    </div>

    @if($errors->any())
    <div class="mb-6 bg-red-50 border-2 border-red-200 text-red-800 px-6 py-4 rounded-2xl fade-in">
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

    <form action="{{ route('admin.features.items.update', $item->id) }}" 
          method="POST" 
          enctype="multipart/form-data"
          class="space-y-8 bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm fade-in">
        @csrf
        @method('PUT')

        <!-- Basic Information -->
        <div class="space-y-6">
            <h3 class="text-xl font-medium text-slate-900 flex items-center gap-2 border-b-2 border-slate-100 pb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Basic Information
            </h3>

            <div>
                <label class="block text-slate-700 font-medium mb-2">Feature Title </label>
                <input type="text" name="title" 
                       value="{{ old('title', $item->title) }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="e.g., Free Shipping"
                       >
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-2">Description</label>
                <textarea name="description" rows="3"
                          class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900
                                 focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
                          placeholder="Brief description of this feature..."
                          >{{ old('description', $item->description) }}</textarea>
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-2">Text Alignment</label>
                <select name="alignment"
                        class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900
                               focus:outline-none focus:border-slate-900 transition-all duration-300 cursor-pointer">
                    <option value="left" {{ old('alignment', $item->alignment) == 'left' ? 'selected' : '' }}>Left</option>
                    <option value="center" {{ old('alignment', $item->alignment) == 'center' ? 'selected' : '' }}>Center</option>
                    <option value="right" {{ old('alignment', $item->alignment) == 'right' ? 'selected' : '' }}>Right</option>
                </select>
            </div>
        </div>

        <!-- Icon Configuration -->
        <div class="space-y-6 border-t-2 border-slate-100 pt-8">
            <h3 class="text-xl font-medium text-slate-900 flex items-center gap-2 pb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                Icon Configuration
            </h3>

            <!-- Icon Type Selection -->
            <div>
                <label class="block text-slate-700 font-medium mb-4">Icon Type *</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <label class="flex items-center gap-3 cursor-pointer group p-4 border-2 border-slate-200 rounded-xl hover:border-slate-900 transition-all">
                        <input type="radio" name="icon_type" value="svg" 
                               {{ old('icon_type', $item->icon_type) == 'svg' ? 'checked' : '' }}
                               class="w-5 h-5 text-slate-900 focus:ring-slate-900 cursor-pointer"
                               onchange="toggleIconType('svg')">
                        <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors">Preset SVG</span>
                    </label>
                    
                    <label class="flex items-center gap-3 cursor-pointer group p-4 border-2 border-slate-200 rounded-xl hover:border-slate-900 transition-all">
                        <input type="radio" name="icon_type" value="svg_upload" 
                               {{ old('icon_type', $item->icon_type) == 'svg_upload' ? 'checked' : '' }}
                               class="w-5 h-5 text-slate-900 focus:ring-slate-900 cursor-pointer"
                               onchange="toggleIconType('svg_upload')">
                        <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors">Upload SVG</span>
                    </label>
                    
                    <label class="flex items-center gap-3 cursor-pointer group p-4 border-2 border-slate-200 rounded-xl hover:border-slate-900 transition-all">
                        <input type="radio" name="icon_type" value="image" 
                               {{ old('icon_type', $item->icon_type) == 'image' ? 'checked' : '' }}
                               class="w-5 h-5 text-slate-900 focus:ring-slate-900 cursor-pointer"
                               onchange="toggleIconType('image')">
                        <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors">Image</span>
                    </label>
                    
                    <label class="flex items-center gap-3 cursor-pointer group p-4 border-2 border-slate-200 rounded-xl hover:border-slate-900 transition-all">
                        <input type="radio" name="icon_type" value="emoji" 
                               {{ old('icon_type', $item->icon_type) == 'emoji' ? 'checked' : '' }}
                               class="w-5 h-5 text-slate-900 focus:ring-slate-900 cursor-pointer"
                               onchange="toggleIconType('emoji')">
                        <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors">Emoji</span>
                    </label>
                </div>
            </div>

            <!-- Preset SVG Icon Section -->
            <div id="svgSection" class="icon-section">
                <label class="block text-slate-700 font-medium mb-3">Select Preset SVG Icon</label>
                <div class="grid grid-cols-4 gap-4 mb-4">
                    @foreach($defaultIcons as $name => $path)
                    <label class="cursor-pointer group">
                        <input type="radio" name="icon_svg" value="{{ $path }}" 
                               {{ old('icon_svg', $item->icon_svg) == $path ? 'checked' : '' }}
                               class="hidden icon-svg-radio">
                        <div class="p-4 border-2 border-slate-200 rounded-xl hover:border-slate-900 transition-all duration-300 icon-svg-box">
                            <svg class="w-8 h-8 mx-auto text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $path !!}
                            </svg>
                            <p class="text-xs text-center mt-2 text-slate-600">{{ ucfirst(str_replace('_', ' ', $name)) }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
                
                <div>
                    <label class="block text-slate-700 font-medium mb-2">Or Paste Custom SVG Path</label>
                    <textarea name="icon_svg_custom" rows="3"
                              class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-mono text-sm
                                     focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
                              placeholder='<path stroke-linecap="round"...'>{{ old('icon_svg', $item->icon_svg) }}</textarea>
                    <p class="text-slate-500 text-sm mt-2">Paste the SVG path data only (the content inside &lt;svg&gt; tags)</p>
                </div>
            </div>

            <!-- SVG File Upload Section -->
            <div id="svgUploadSection" class="icon-section" style="display: none;">
                <label class="block text-slate-700 font-medium mb-3">Upload SVG File</label>
                
                @if($item->icon_svg_path)
                <div class="mb-4">
                    <p class="text-sm text-slate-600 mb-2">Current SVG icon:</p>
                    <div class="p-4 border-2 border-slate-200 rounded-xl bg-slate-50 inline-flex items-center justify-center" style="width: 100px; height: 100px;">
                        <div style="width: 64px; height: 64px; display: flex; align-items: center; justify-center;">
                            {!! $item->icon_svg_content !!}
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="flex items-center gap-4">
                    <input type="file" name="icon_svg_file" accept=".svg"
                           class="block w-full text-sm text-slate-600
                                  file:mr-4 file:py-3 file:px-6
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-medium
                                  file:bg-slate-900 file:text-white
                                  hover:file:bg-slate-800 file:cursor-pointer file:transition-all file:duration-300
                                  cursor-pointer border-2 border-slate-200 rounded-2xl p-3 bg-white"
                           onchange="previewSVG(this)">
                </div>
                <p class="text-slate-500 text-sm mt-2">Upload a new SVG file to replace the current one (max 2MB)</p>
                
                <!-- SVG Preview -->
                <div id="svgPreview" class="mt-4 hidden">
                    <p class="text-slate-700 font-medium mb-2">New Preview:</p>
                    <div class="p-4 border-2 border-slate-200 rounded-xl bg-slate-50 inline-flex items-center justify-center" style="width: 100px; height: 100px;">
                        <div id="svgPreviewContent" style="width: 64px; height: 64px; display: flex; align-items: center; justify-center;"></div>
                    </div>
                </div>
            </div>

            <!-- Image Upload Section -->
            <div id="imageSection" class="icon-section" style="display: none;">
                <label class="block text-slate-700 font-medium mb-3">Upload Icon Image</label>
                @if($item->icon_image_url)
                <div class="mb-4">
                    <img src="{{ $item->icon_image_url }}" alt="Current icon" class="w-16 h-16 object-contain border-2 border-slate-200 rounded-lg p-2">
                    <p class="text-sm text-slate-600 mt-2">Current icon</p>
                </div>
                @endif
                <input type="file" name="icon_image" accept="image/*"
                       class="block w-full text-sm text-slate-600
                              file:mr-4 file:py-3 file:px-6
                              file:rounded-full file:border-0
                              file:text-sm file:font-medium
                              file:bg-slate-900 file:text-white
                              hover:file:bg-slate-800 file:cursor-pointer file:transition-all file:duration-300
                              cursor-pointer border-2 border-slate-200 rounded-2xl p-3 bg-white">
                <p class="text-slate-500 text-sm mt-2">Recommended: PNG or JPG, max 2MB</p>
            </div>

            <!-- Emoji Section -->
            <div id="emojiSection" class="icon-section" style="display: none;">
                <label class="block text-slate-700 font-medium mb-2">Enter Emoji</label>
                <input type="text" name="icon_emoji" 
                       value="{{ old('icon_emoji', $item->icon_emoji) }}"
                       class="w-32 bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-4xl text-center
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="😊"
                       maxlength="4">
                <p class="text-slate-500 text-sm mt-2">Single emoji character</p>
            </div>
        </div>

        <!-- Color Configuration -->
        <div class="space-y-6 border-t-2 border-slate-100 pt-8">
            <h3 class="text-xl font-medium text-slate-900 flex items-center gap-2 pb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
                Colors
            </h3>

            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-slate-700 font-medium mb-2">Icon Color</label>
                    <div class="flex gap-2">
                        <input type="color" name="icon_color" 
                               value="{{ old('icon_color', $item->icon_color) }}"
                               class="h-12 w-20 border-2 border-slate-200 rounded-lg cursor-pointer">
                        <input type="text" 
                               value="{{ old('icon_color', $item->icon_color) }}"
                               class="flex-1 bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900"
                               readonly>
                    </div>
                </div>

                <div>
                    <label class="block text-slate-700 font-medium mb-2">Title Color</label>
                    <div class="flex gap-2">
                        <input type="color" name="title_color" 
                               value="{{ old('title_color', $item->title_color) }}"
                               class="h-12 w-20 border-2 border-slate-200 rounded-lg cursor-pointer">
                        <input type="text" 
                               value="{{ old('title_color', $item->title_color) }}"
                               class="flex-1 bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900"
                               readonly>
                    </div>
                </div>

                <div>
                    <label class="block text-slate-700 font-medium mb-2">Description Color</label>
                    <div class="flex gap-2">
                        <input type="color" name="description_color" 
                               value="{{ old('description_color', $item->description_color) }}"
                               class="h-12 w-20 border-2 border-slate-200 rounded-lg cursor-pointer">
                        <input type="text" 
                               value="{{ old('description_color', $item->description_color) }}"
                               class="flex-1 bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900"
                               readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Optional Link -->
        <div class="space-y-6 border-t-2 border-slate-100 pt-8">
            <h3 class="text-xl font-medium text-slate-900 flex items-center gap-2 pb-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                </svg>
                Optional Link
            </h3>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-slate-700 font-medium mb-2">Link URL</label>
                    <input type="text" name="link_url" 
                           value="{{ old('link_url', $item->link_url) }}"
                           class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900
                                  focus:outline-none focus:border-slate-900 transition-all duration-300"
                           placeholder="/products">
                </div>

                <div>
                    <label class="block text-slate-700 font-medium mb-2">Link Text</label>
                    <input type="text" name="link_text" 
                           value="{{ old('link_text', $item->link_text) }}"
                           class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900
                                  focus:outline-none focus:border-slate-900 transition-all duration-300"
                           placeholder="Learn More">
                </div>
            </div>

            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" name="open_in_new_tab" value="1"
                       {{ old('open_in_new_tab', $item->open_in_new_tab) ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-slate-300 bg-white text-slate-900
                              focus:ring-slate-900 focus:ring-offset-0 focus:ring-2 cursor-pointer">
                <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors">
                    Open link in new tab
                </span>
            </label>
        </div>

        <!-- Display Settings -->
        <div class="space-y-4 border-t-2 border-slate-100 pt-8">
            <div>
                <label class="block text-slate-700 font-medium mb-2">Display Order</label>
                <input type="number" name="display_order" 
                       value="{{ old('display_order', $item->display_order) }}"
                       class="w-32 bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       min="0">
                <p class="text-slate-500 text-sm mt-2">Lower numbers appear first</p>
            </div>

            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $item->is_active) ? 'checked' : '' }}
                       class="w-5 h-5 rounded border-slate-300 bg-white text-slate-900
                              focus:ring-slate-900 focus:ring-offset-0 focus:ring-2 cursor-pointer">
                <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors">
                    Feature is active (visible on homepage)
                </span>
            </label>
        </div>

        <!-- Submit Buttons -->
        <div class="pt-8 flex gap-4">
            <button type="submit"
                    class="flex items-center gap-2 bg-slate-900 text-white px-8 py-4 rounded-full font-medium
                           hover:bg-slate-800 transition-all duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Update Feature
            </button>
            
            <a href="{{ route('admin.features.edit') }}"
               class="flex items-center gap-2 border-2 border-slate-200 text-slate-900 px-8 py-4 rounded-full font-medium
                      hover:border-slate-900 transition-all duration-300">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
function toggleIconType(type) {
    document.getElementById('svgSection').style.display = type === 'svg' ? 'block' : 'none';
    document.getElementById('svgUploadSection').style.display = type === 'svg_upload' ? 'block' : 'none';
    document.getElementById('imageSection').style.display = type === 'image' ? 'block' : 'none';
    document.getElementById('emojiSection').style.display = type === 'emoji' ? 'block' : 'none';
}

function previewSVG(input) {
    const preview = document.getElementById('svgPreview');
    const previewContent = document.getElementById('svgPreviewContent');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            let svgContent = e.target.result;
            
            // Add styling to constrain SVG size
            if (svgContent.includes('<svg')) {
                svgContent = svgContent.replace('<svg', '<svg style="max-width: 64px; max-height: 64px; width: 100%; height: 100%;"');
            }
            
            previewContent.innerHTML = svgContent;
            preview.classList.remove('hidden');
        };
        
        reader.readAsText(input.files[0]);
    } else {
        preview.classList.add('hidden');
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const selectedType = document.querySelector('input[name="icon_type"]:checked').value;
    toggleIconType(selectedType);
    
    // Handle SVG radio selection
    document.querySelectorAll('.icon-svg-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.icon-svg-box').forEach(box => {
                box.classList.remove('border-slate-900', 'bg-slate-50');
                box.classList.add('border-slate-200');
            });
            if (this.checked) {
                this.nextElementSibling.classList.remove('border-slate-200');
                this.nextElementSibling.classList.add('border-slate-900', 'bg-slate-50');
            }
        });
        if (radio.checked) {
            radio.nextElementSibling.classList.add('border-slate-900', 'bg-slate-50');
        }
    });
    
    // Sync color inputs
    document.querySelectorAll('input[type="color"]').forEach(colorInput => {
        const textInput = colorInput.nextElementSibling;
        colorInput.addEventListener('input', function() {
            textInput.value = this.value;
        });
    });
});
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.fade-in {
    opacity: 0;
    animation: fadeIn 0.6s ease-out forwards;
}
</style>
@endsection