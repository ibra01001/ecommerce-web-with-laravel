@extends('admin.layout')

@section('title', 'Edit About Us Page')

@section('content')
<div class="flex justify-between items-center mb-8 fade-in">
    <h2 class="text-3xl font-light text-slate-900 flex items-center gap-3">
        <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Edit About Us Page
    </h2>

    <a href="{{ route('about-us') }}" target="_blank"
       class="flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors duration-300 font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
        Preview Page
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

<form action="{{ route('admin.about-us.update') }}" method="POST" enctype="multipart/form-data"
      class="space-y-8 bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm max-w-5xl fade-in">
    @csrf
    @method('PUT')

    <!-- Title -->
    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            Page Title *
        </label>
        <input type="text" name="title" 
               value="{{ old('title', $aboutUs->title ?? '') }}"
               class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                      focus:outline-none focus:border-slate-900 transition-all duration-300" 
               placeholder="e.g., About Our Company"
               required>
        @error('title') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <!-- Subtitle -->
    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Subtitle
        </label>
        <input type="text" name="subtitle" 
               value="{{ old('subtitle', $aboutUs->subtitle ?? '') }}"
               class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                      focus:outline-none focus:border-slate-900 transition-all duration-300"
               placeholder="A brief tagline or subtitle">
        @error('subtitle') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <!-- Main Content -->
    <div>
        <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Main Content *
        </label>
        <textarea name="content" rows="8"
                  class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-light
                         focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
                  placeholder="Write your company's story, history, and values..."
                  required>{{ old('content', $aboutUs->content ?? '') }}</textarea>
        @error('content') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <!-- Main Image -->
    <div class="border-t-2 border-slate-200 pt-8">
        <label class="block text-slate-700 font-medium mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            Main Hero Image
        </label>
        
        @if($aboutUs && $aboutUs->image)
        <div class="mb-4 relative group w-full max-w-2xl">
            <img src="{{ asset('storage/' . $aboutUs->image) }}" 
                 alt="Current image" 
                 class="w-full h-64 object-cover rounded-2xl border-2 border-slate-200">
            <div class="absolute top-4 left-4 bg-slate-900 text-white text-xs px-3 py-1.5 rounded-full font-medium">
                Current Image
            </div>
        </div>
        @endif
        
        <input type="file" name="image" accept="image/*" 
               class="block w-full text-sm text-slate-600 font-light
                      file:mr-4 file:py-3 file:px-6
                      file:rounded-full file:border-0
                      file:text-sm file:font-medium
                      file:bg-slate-900 file:text-white
                      hover:file:bg-slate-800 file:cursor-pointer file:transition-all file:duration-300
                      cursor-pointer border-2 border-slate-200 rounded-2xl p-3 bg-white">
        <p class="text-slate-500 text-sm mt-2 font-light">Recommended: 1920x1080px or similar ratio (max 4MB)</p>
        @error('image') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
    </div>

    <!-- Mission & Vision Section -->
    <div class="border-t-2 border-slate-200 pt-8">
        <h3 class="text-2xl font-light text-slate-900 mb-6 flex items-center gap-3">
            <svg class="w-7 h-7 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
            Mission & Vision
        </h3>
        
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Mission -->
            <div class="space-y-4">
                <div>
                    <label class="block text-slate-700 font-medium mb-2">Mission Title</label>
                    <input type="text" name="mission_title" 
                           value="{{ old('mission_title', $aboutUs->mission_title ?? '') }}"
                           class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                                  focus:outline-none focus:border-slate-900 transition-all duration-300"
                           placeholder="Our Mission">
                    @error('mission_title') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-slate-700 font-medium mb-2">Mission Content</label>
                    <textarea name="mission_content" rows="4"
                              class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-light
                                     focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
                              placeholder="Describe your company's mission...">{{ old('mission_content', $aboutUs->mission_content ?? '') }}</textarea>
                    @error('mission_content') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Vision -->
            <div class="space-y-4">
                <div>
                    <label class="block text-slate-700 font-medium mb-2">Vision Title</label>
                    <input type="text" name="vision_title" 
                           value="{{ old('vision_title', $aboutUs->vision_title ?? '') }}"
                           class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                                  focus:outline-none focus:border-slate-900 transition-all duration-300"
                           placeholder="Our Vision">
                    @error('vision_title') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-slate-700 font-medium mb-2">Vision Content</label>
                    <textarea name="vision_content" rows="4"
                              class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-light
                                     focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
                              placeholder="Describe your company's vision...">{{ old('vision_content', $aboutUs->vision_content ?? '') }}</textarea>
                    @error('vision_content') <p class="text-red-600 text-sm mt-2 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Team Members Section -->
    <div class="border-t-2 border-slate-200 pt-8">
        <h3 class="text-2xl font-light text-slate-900 mb-6 flex items-center gap-3">
            <svg class="w-7 h-7 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Team Members
        </h3>
        
        <div id="team-members" class="space-y-6 mb-6">
            @if($aboutUs && $aboutUs->team_members)
                @foreach($aboutUs->team_members as $index => $member)
                <div class="team-member-row bg-slate-50 border-2 border-slate-200 rounded-2xl p-6" data-index="{{ $index }}">
                    <!-- Photo Upload Section -->
                    <div class="mb-6 pb-6 border-b-2 border-slate-200">
                        <label class="block text-slate-700 font-medium text-sm mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Member Photo
                        </label>
                        @if(isset($member['photo']) && $member['photo'])
                        <div class="mb-4 relative inline-block">
                            <img src="{{ asset('storage/' . $member['photo']) }}" 
                                 alt="{{ $member['name'] ?? 'Team member' }}" 
                                 class="w-40 h-40 object-cover rounded-2xl border-2 border-slate-200">
                            <div class="absolute top-2 left-2 bg-slate-900 text-white text-xs px-2 py-1 rounded-full font-medium">
                                Current
                            </div>
                        </div>
                        @endif
                        <input type="file" name="team_members[{{ $index }}][photo]" accept="image/*" 
                               class="block w-full text-sm text-slate-600 font-light
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-xs file:font-medium
                                      file:bg-slate-200 file:text-slate-900
                                      hover:file:bg-slate-300 file:cursor-pointer file:transition-all file:duration-300
                                      cursor-pointer border-2 border-slate-200 rounded-full p-2 bg-white">
                        <p class="text-slate-500 text-xs mt-2 font-light">Square image recommended (400x400px, max 1MB)</p>
                    </div>

                    <!-- Member Info -->
                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-slate-700 font-medium text-sm mb-2">Name *</label>
                            <input type="text" name="team_members[{{ $index }}][name]" 
                                   value="{{ $member['name'] ?? '' }}"
                                   class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-2.5 text-slate-900 font-light
                                          focus:outline-none focus:border-slate-900 transition-all duration-300"
                                   placeholder="John Doe">
                        </div>
                        <div>
                            <label class="block text-slate-700 font-medium text-sm mb-2">Position *</label>
                            <input type="text" name="team_members[{{ $index }}][position]" 
                                   value="{{ $member['position'] ?? '' }}"
                                   class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-2.5 text-slate-900 font-light
                                          focus:outline-none focus:border-slate-900 transition-all duration-300"
                                   placeholder="CEO">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-slate-700 font-medium text-sm mb-2">Bio (Optional)</label>
                            <textarea name="team_members[{{ $index }}][bio]" rows="3"
                                   class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-2.5 text-slate-900 font-light
                                          focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
                                   placeholder="Brief bio about the team member...">{{ $member['bio'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" 
                            class="text-red-600 hover:text-red-700 text-sm flex items-center gap-2 transition-colors duration-300 font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Remove Member
                    </button>
                </div>
                @endforeach
            @endif
        </div>
        
        <button type="button" onclick="addTeamMember()" 
                class="flex items-center gap-2 bg-slate-900 text-white px-6 py-3 rounded-full font-medium
                       hover:bg-slate-800 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            Add Team Member
        </button>
    </div>

    <!-- Active Status -->
    <div class="border-t-2 border-slate-200 pt-8">
        <label class="flex items-center gap-3 cursor-pointer group">
            <input type="checkbox" name="is_active" value="1" 
                   {{ old('is_active', $aboutUs->is_active ?? true) ? 'checked' : '' }}
                   class="w-5 h-5 rounded border-slate-300 bg-white text-slate-900
                          focus:ring-slate-900 focus:ring-offset-0 focus:ring-2 cursor-pointer">
            <span class="text-slate-700 font-medium group-hover:text-slate-900 transition-colors duration-300">
                Page is Active (visible to public)
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
            Update About Us Page
        </button>
        
        <a href="{{ route('about-us') }}" target="_blank"
           class="flex items-center gap-2 border-2 border-slate-200 text-slate-900 px-8 py-4 rounded-full font-medium text-base
                  hover:border-slate-900 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            View Live Page
        </a>
    </div>
</form>

<script>
let memberCount = {{ $aboutUs && $aboutUs->team_members ? count($aboutUs->team_members) : 0 }};

function addTeamMember() {
    const container = document.getElementById('team-members');
    const div = document.createElement('div');
    div.className = 'team-member-row bg-slate-50 border-2 border-slate-200 rounded-2xl p-6';
    div.setAttribute('data-index', memberCount);
    div.innerHTML = `
        <!-- Photo Upload Section -->
        <div class="mb-6 pb-6 border-b-2 border-slate-200">
            <label class="block text-slate-700 font-medium text-sm mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Member Photo
            </label>
            <input type="file" name="team_members[${memberCount}][photo]" accept="image/*" 
                   class="block w-full text-sm text-slate-600 font-light
                          file:mr-4 file:py-2 file:px-4
                          file:rounded-full file:border-0
                          file:text-xs file:font-medium
                          file:bg-slate-200 file:text-slate-900
                          hover:file:bg-slate-300 file:cursor-pointer file:transition-all file:duration-300
                          cursor-pointer border-2 border-slate-200 rounded-full p-2 bg-white">
            <p class="text-slate-500 text-xs mt-2 font-light">Square image recommended (400x400px, max 1MB)</p>
        </div>

        <!-- Member Info -->
        <div class="grid md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-slate-700 font-medium text-sm mb-2">Name *</label>
                <input type="text" name="team_members[${memberCount}][name]" 
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-2.5 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="John Doe">
            </div>
            <div>
                <label class="block text-slate-700 font-medium text-sm mb-2">Position *</label>
                <input type="text" name="team_members[${memberCount}][position]" 
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-2.5 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="CEO">
            </div>
            <div class="md:col-span-2">
                <label class="block text-slate-700 font-medium text-sm mb-2">Bio (Optional)</label>
                <textarea name="team_members[${memberCount}][bio]" rows="3"
                       class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-2.5 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
                       placeholder="Brief bio about the team member..."></textarea>
            </div>
        </div>
        <button type="button" onclick="this.parentElement.remove()" 
                class="text-red-600 hover:text-red-700 text-sm flex items-center gap-2 transition-colors duration-300 font-medium">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
            Remove Member
        </button>
    `;
    container.appendChild(div);
    memberCount++;
}
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