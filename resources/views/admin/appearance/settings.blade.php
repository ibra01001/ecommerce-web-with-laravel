@extends('admin.layout')

@section('title', 'Appearance Settings')

@section('content')
    <!-- Page Header -->
    <div class="pt-8 pb-12 px-6 fade-in">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between">
                <div class="space-y-2">
                    <h1 class="text-4xl md:text-5xl font-light tracking-tight" style="color: var(--text-color);">Appearance Settings</h1>
                    <p class="text-lg font-light" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Manage your store's logo, colors, and theme.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="px-6 pb-16">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Animated Alerts -->
            @if(session('success'))
                <div id="alert-success"
                    class="transform transition-all duration-400 slide-fade-in rounded-lg px-4 py-3 flex items-start gap-3 border"
                    style="background: color-mix(in srgb, var(--primary-color) 10%, transparent); border-color: var(--primary-color); color: var(--text-color);">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" style="color: var(--primary-color);" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-sm font-medium">{{ session('success') }}</div>
                    <button type="button" onclick="dismissAlert('alert-success')"
                        class="ml-auto transition-colors" style="color: var(--primary-color);"
                        onmouseover="this.style.color='var(--secondary-color)'"
                        onmouseout="this.style.color='var(--primary-color)'">
                        ✕
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div id="alert-error"
                    class="transform transition-all duration-400 slide-fade-in bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 text-red-600" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <div class="text-sm font-medium">{{ session('error') }}</div>
                    <button type="button" onclick="dismissAlert('alert-error')" class="ml-auto text-red-600 hover:text-red-800">
                        ✕
                    </button>
                </div>
            @endif

            <!-- Logo Upload Section -->
            <div class="card p-6 fade-in" style="background: var(--background-color);">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2 rounded-lg" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" style="color: var(--background-color);">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold" style="color: var(--text-color);">Store Logos</h2>
                        <p class="text-sm mt-0.5" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Upload logos for light and dark modes</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Light Mode Logo -->
                    <div class="rounded-xl p-6 border-2 transition-all hover:border-opacity-100" style="border-color: color-mix(in srgb, var(--primary-color) 20%, transparent); background: color-mix(in srgb, var(--primary-color) 2%, transparent);">
                        <div class="flex items-center gap-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" style="color: var(--primary-color);">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                            </svg>
                            <h3 class="font-semibold" style="color: var(--text-color);">Light Mode Logo</h3>
                        </div>
                        
                        @if($logo && $logo->custom_logo_path)
                            <div class="mb-4 p-4 bg-white rounded-lg border" style="border-color: color-mix(in srgb, var(--primary-color) 15%, transparent);">
                                <img src="{{ asset('storage/' . $logo->custom_logo_path) }}" alt="Light mode logo" class="h-20 object-contain mx-auto">
                            </div>
                            <form action="{{ route('admin.appearance.delete_logo') }}" method="POST" onsubmit="return confirm('Delete light mode logo?');">
                                @csrf 
                                @method('DELETE')
                                <input type="hidden" name="type" value="light">
                                <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm font-medium flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                    Remove Logo
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.appearance.upload_Light_logo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label class="block cursor-pointer">
                                    <div class="border-2 border-dashed rounded-lg p-8 text-center hover:border-opacity-100 transition-all" style="border-color: color-mix(in srgb, var(--primary-color) 30%, transparent);">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-2" style="color: color-mix(in srgb, var(--text-color) 40%, transparent);">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                        </svg>
                                        <p class="text-sm font-medium" style="color: var(--text-color);">Click to upload</p>
                                        <p class="text-xs mt-1" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">PNG, JPG, SVG (max. 4MB)</p>
                                    </div>
                                    <input type="file" name="custom_logo" accept="image/*" class="hidden" onchange="this.form.submit()">
                                </label>
                            </form>
                        @endif
                    </div>

                    <!-- Dark Mode Logo -->
                    <div class="rounded-xl p-6 border-2 transition-all hover:border-opacity-100" style="border-color: color-mix(in srgb, var(--primary-color) 20%, transparent); background: color-mix(in srgb, var(--primary-color) 2%, transparent);">
                        <div class="flex items-center gap-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" style="color: var(--primary-color);">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                            </svg>
                            <h3 class="font-semibold" style="color: var(--text-color);">Dark Mode Logo</h3>
                        </div>
                        
                        @if($logo && $logo->dark_logo_path)
                            <div class="mb-4 p-4 bg-gray-900 rounded-lg border" style="border-color: color-mix(in srgb, var(--primary-color) 15%, transparent);">
                                <img src="{{ asset('storage/' . $logo->dark_logo_path) }}" alt="Dark mode logo" class="h-20 object-contain mx-auto">
                            </div>
                            <form action="{{ route('admin.appearance.delete_logo') }}" method="POST" onsubmit="return confirm('Delete dark mode logo?');">
                                @csrf 
                                @method('DELETE')
                                <input type="hidden" name="type" value="dark">
                                <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors text-sm font-medium flex items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                    Remove Logo
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.appearance.upload_Dark_logo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label class="block cursor-pointer">
                                    <div class="border-2 border-dashed rounded-lg p-8 text-center hover:border-opacity-100 transition-all" style="border-color: color-mix(in srgb, var(--primary-color) 30%, transparent);">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 mx-auto mb-2" style="color: color-mix(in srgb, var(--text-color) 40%, transparent);">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                        </svg>
                                        <p class="text-sm font-medium" style="color: var(--text-color);">Click to upload</p>
                                        <p class="text-xs mt-1" style="color: color-mix(in srgb, var(--text-color) 50%, transparent);">PNG, JPG, SVG (max. 4MB)</p>
                                    </div>
                                    <input type="file" name="dark_mode_logo" accept="image/*" class="hidden" onchange="this.form.submit()">
                                </label>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Theme Customization Section -->
            <div class="card p-6 md:p-8 fade-in" style="background: var(--background-color);">
                <div class="flex items-center gap-3 mb-8">
                    <div class="p-2 rounded-lg" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" style="color: var(--background-color);">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold" style="color: var(--text-color);">Theme Customization</h2>
                        <p class="text-sm mt-0.5" style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">Manage your store's color schemes</p>
                    </div>
                </div>

                <!-- Theme Cards Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    @foreach($themes as $theme)
                        @php
                            $isActive = ($theme->mode === 'light' && $theme->is_active_light) || ($theme->mode === 'dark' && $theme->is_active_dark);
                        @endphp
                        <div class="theme-card rounded-xl border-3 overflow-hidden transition-all hover:shadow-xl relative" 
                             data-theme-id="{{ $theme->id }}"
                             style="border-width: 3px; border-color: {{ $isActive ? $theme->primary_color : 'color-mix(in srgb, var(--primary-color) 15%, transparent)' }}; background: {{ $theme->background_color }}; {{ $isActive ? 'box-shadow: 0 8px 16px -4px ' . $theme->primary_color . '40;' : '' }}">
                            
                            <!-- Active Badge - Top Right Corner -->
                            @if($isActive)
                                <div class="absolute top-4 right-4 z-10">
                                    <div class="flex items-center gap-2 px-3 py-1.5 rounded-full shadow-lg animate-pulse" style="background: {{ $theme->primary_color }}; color: {{ $theme->background_color }};">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="text-xs font-bold uppercase tracking-wide">Active</span>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Theme Preview Header -->
                            <div class="p-6" style="background: linear-gradient(135deg, {{ $theme->primary_color }}15, {{ $theme->secondary_color }}15);">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1 pr-20">
                                        <h3 class="text-xl font-bold mb-1" style="color: {{ $theme->text_color }};">{{ $theme->name }}</h3>
                                        <div class="flex items-center gap-2 text-sm" style="color: {{ $theme->text_color }}80;">
                                            @if($theme->mode === 'light')
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                                                </svg>
                                            @endif
                                            <span class="font-semibold">{{ ucfirst($theme->mode) }} Mode</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- All 4 Color Preview with Labels -->
                                <div class="space-y-3">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <div class="text-xs font-medium mb-1" style="color: {{ $theme->text_color }}80;">Primary</div>
                                            <div class="h-14 rounded-lg border-2 shadow-sm" style="background: {{ $theme->primary_color }}; border-color: {{ $theme->text_color }}20;"></div>
                                        </div>
                                        <div>
                                            <div class="text-xs font-medium mb-1" style="color: {{ $theme->text_color }}80;">Secondary</div>
                                            <div class="h-14 rounded-lg border-2 shadow-sm" style="background: {{ $theme->secondary_color }}; border-color: {{ $theme->text_color }}20;"></div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <div class="text-xs font-medium mb-1" style="color: {{ $theme->text_color }}80;">Background</div>
                                            <div class="h-14 rounded-lg border-2 shadow-sm" style="background: {{ $theme->background_color }}; border-color: {{ $theme->text_color }}20;"></div>
                                        </div>
                                        <div>
                                            <div class="text-xs font-medium mb-1" style="color: {{ $theme->text_color }}80;">Text</div>
                                            <div class="h-14 rounded-lg border-2 shadow-sm" style="background: {{ $theme->text_color }}; border-color: {{ $theme->text_color }}20;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="p-4 flex gap-2" style="background: {{ $theme->background_color }}; border-top: 2px solid {{ $theme->text_color }}10;">
                                <button onclick="toggleThemeEditor({{ $theme->id }})" class="flex-1 px-4 py-2.5 rounded-lg transition-all text-sm font-semibold flex items-center justify-center gap-2" style="background: {{ $theme->primary_color }}15; color: {{ $theme->primary_color }}; border: 2px solid {{ $theme->primary_color }}30;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Edit Theme
                                </button>
                                @if(!$isActive)
                                    <form action="{{ route('admin.themes.activate', $theme->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2.5 rounded-lg transition-all text-sm font-semibold flex items-center justify-center gap-2" style="background: {{ $theme->primary_color }}; color: {{ $theme->background_color }};">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Activate
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <!-- Editor Panel (Hidden by default) -->
                            <div id="editor-{{ $theme->id }}" class="hidden border-t" style="border-color: {{ $theme->text_color }}15;">
                                <form action="{{ route('admin.appearance.update_theme', $theme->id) }}" method="POST" class="p-6" style="background: {{ $theme->background_color }};">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="space-y-4">
                                        <!-- Theme Name -->
                                        <div>
                                            <label class="block text-sm font-medium mb-2" style="color: {{ $theme->text_color }};">Theme Name</label>
                                            <input type="text" name="name" value="{{ $theme->name }}" class="w-full px-4 py-2 rounded-lg border-2 transition-all" style="background: {{ $theme->background_color }}; border-color: {{ $theme->text_color }}30; color: {{ $theme->text_color }};">
                                        </div>

                                        <!-- Color Inputs -->
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-sm font-medium mb-2" style="color: {{ $theme->text_color }};">Primary</label>
                                                <input type="color" name="primary_color" value="{{ $theme->primary_color }}" class="w-full h-10 rounded cursor-pointer">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-2" style="color: {{ $theme->text_color }};">Secondary</label>
                                                <input type="color" name="secondary_color" value="{{ $theme->secondary_color }}" class="w-full h-10 rounded cursor-pointer">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-2" style="color: {{ $theme->text_color }};">Background</label>
                                                <input type="color" name="background_color" value="{{ $theme->background_color }}" class="w-full h-10 rounded cursor-pointer">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium mb-2" style="color: {{ $theme->text_color }};">Text</label>
                                                <input type="color" name="text_color" value="{{ $theme->text_color }}" class="w-full h-10 rounded cursor-pointer">
                                            </div>
                                        </div>

                                        <!-- Font Family -->
                                        <div>
                                            <label class="block text-sm font-medium mb-2" style="color: {{ $theme->text_color }};">Font Family</label>
                                            <select name="font_family" class="w-full px-4 py-2 rounded-lg border-2" style="background: {{ $theme->background_color }}; border-color: {{ $theme->text_color }}30; color: {{ $theme->text_color }};">
                                                @foreach(config('fonts') as $key => $font)
                                                    <option value="{{ $key }}" {{ $theme->font_family === $key ? 'selected' : '' }}>{{ $font['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Mode -->
                                        <input type="hidden" name="mode" value="{{ $theme->mode }}">

                                        <!-- Save Button -->
                                        <button type="submit" class="w-full px-4 py-2 rounded-lg transition-all font-medium" style="background: {{ $theme->primary_color }}; color: {{ $theme->background_color }};">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .slide-fade-in {
            animation: fadeIn 0.4s ease-out;
        }

        .theme-card {
            transition: all 0.3s ease;
        }

        .theme-card:hover {
            transform: translateY(-2px);
        }

        input[type="color"] {
            cursor: pointer;
            border: 2px solid color-mix(in srgb, var(--text-color) 20%, transparent);
        }

        input[type="color"]::-webkit-color-swatch-wrapper {
            padding: 0;
        }

        input[type="color"]::-webkit-color-swatch {
            border: none;
            border-radius: 6px;
        }
    </style>

    <script>
        function toggleThemeEditor(themeId) {
            const editor = document.getElementById('editor-' + themeId);
            editor.classList.toggle('hidden');
        }

        function dismissAlert(id) {
            const alert = document.getElementById(id);
            if (alert) alert.remove();
        }
    </script>
@endsection