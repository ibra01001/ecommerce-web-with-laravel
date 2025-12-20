@extends('layouts.app')

@section('title', 'About Us — HoodLuxe')

@section('content')

<div class="min-h-screen" style="background: var(--background-color);">
    @if($aboutUs)
        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 px-6 overflow-hidden" 
                 style="background: linear-gradient(to bottom, color-mix(in srgb, var(--primary-color) 3%, var(--background-color)), var(--background-color));">
            <div class="max-w-6xl mx-auto text-center space-y-8 fade-in">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extralight leading-tight tracking-tight"
                    style="color: var(--text-color);">
                    {{ $aboutUs->title }}
                </h1>
                @if($aboutUs->subtitle)
                    <p class="text-xl md:text-2xl font-light leading-relaxed max-w-3xl mx-auto"
                       style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                        {{ $aboutUs->subtitle }}
                    </p>
                @endif
            </div>
        </section>

        <!-- Featured Image -->
        @if($aboutUs->image)
            <section class="relative px-6 pb-20 fade-in" style="background: var(--background-color);">
                <div class="max-w-7xl mx-auto">
                    <div class="relative h-[50vh] md:h-[60vh] lg:h-[70vh] overflow-hidden  border-2"
                         style="border-color: color-mix(in srgb, var(--text-color) 10%, transparent);">
                        <img src="{{ asset('storage/' . $aboutUs->image) }}" 
                             alt="{{ $aboutUs->title }}" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
            </section>
        @endif

        <!-- Main Content -->
        <section class="py-20 px-6" style="background: var(--background-color);">
            <div class="max-w-4xl mx-auto fade-in">
                <div class="prose prose-2xl max-w-none">
                    <p class="text-xl md:text-2xl font-light leading-relaxed whitespace-pre-line"
                       style="color: color-mix(in srgb, var(--text-color) 85%, transparent);">
                        {{ $aboutUs->content }}
                    </p>
                </div>
            </div>
        </section>

        <!-- Mission & Vision -->
        @if($aboutUs->mission_title || $aboutUs->vision_title)
            <section class="py-24 px-6" 
                     style="background: color-mix(in srgb, var(--primary-color) 3%, var(--background-color));">
                <div class="max-w-7xl mx-auto">
                    <div class="grid md:grid-cols-2 gap-16 lg:gap-24">
                        @if($aboutUs->mission_title)
                            <div class="space-y-6 fade-in">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0"
                                         style="background: var(--primary-color);">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-3xl md:text-4xl font-light" style="color: var(--text-color);">
                                        {{ $aboutUs->mission_title }}
                                    </h2>
                                </div>
                                <p class="text-lg md:text-xl font-light leading-relaxed pl-16"
                                   style="color: color-mix(in srgb, var(--text-color) 75%, transparent);">
                                    {{ $aboutUs->mission_content }}
                                </p>
                            </div>
                        @endif

                        @if($aboutUs->vision_title)
                            <div class="space-y-6 fade-in">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0"
                                         style="background: var(--secondary-color);">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-3xl md:text-4xl font-light" style="color: var(--text-color);">
                                        {{ $aboutUs->vision_title }}
                                    </h2>
                                </div>
                                <p class="text-lg md:text-xl font-light leading-relaxed pl-16"
                                   style="color: color-mix(in srgb, var(--text-color) 75%, transparent);">
                                    {{ $aboutUs->vision_content }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        <!-- Team Members -->
        @if($aboutUs->team_members && count($aboutUs->team_members) > 0)
            <section class="py-24 px-6" style="background: var(--background-color);">
                <div class="max-w-7xl mx-auto">
                    <!-- Section Header -->
                    <div class="text-center mb-20 space-y-6 fade-in">
                        <h2 class="text-4xl md:text-5xl lg:text-6xl font-extralight tracking-tight"
                            style="color: var(--text-color);">
                            Meet Our Team
                        </h2>

                    </div>

                    <!-- Team Grid -->
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 lg:gap-10">
                        @foreach($aboutUs->team_members as $member)
                            <div class="group fade-in">
                                <!-- Photo Container -->
                                <div class="mb-6 overflow-hidden rounded-xl border-2 transition-all duration-300"
                                     style="border-color: color-mix(in srgb, var(--text-color) 10%, transparent);"
                                     onmouseover="this.style.borderColor='var(--primary-color)'"
                                     onmouseout="this.style.borderColor='color-mix(in srgb, var(--text-color) 10%, transparent)'">
                                    @if(isset($member['photo']) && $member['photo'])
                                        <img src="{{ asset('storage/' . $member['photo']) }}" 
                                             alt="{{ $member['name'] }}"
                                             class="w-full aspect-[3/4] object-cover grayscale group-hover:grayscale-0 transition-all duration-700 group-hover:scale-105">
                                    @else
                                        <div class="w-full aspect-[3/4] flex items-center justify-center"
                                             style="background: linear-gradient(to bottom right, color-mix(in srgb, var(--primary-color) 5%, transparent), color-mix(in srgb, var(--secondary-color) 5%, transparent));">
                                            <svg class="w-20 h-20" style="color: color-mix(in srgb, var(--text-color) 30%, transparent);" 
                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Member Info -->
                                <div class="space-y-2">
                                    <h3 class="text-xl font-medium" style="color: var(--text-color);">
                                        {{ $member['name'] }}
                                    </h3>
                                    <p class="text-sm uppercase tracking-wider font-medium" style="color: var(--secondary-color);">
                                        {{ $member['position'] }}
                                    </p>
                                    @if(isset($member['bio']) && $member['bio'])
                                        <p class="font-light leading-relaxed pt-2 text-sm"
                                           style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                                            {{ $member['bio'] }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Bottom CTA Section -->
        <section class="py-24 px-6" style="background: var(--background-color);">
            <div class="max-w-4xl mx-auto text-center space-y-8 fade-in">
                <div class="space-y-6">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-light tracking-tight"
                        style="color: var(--text-color);">
                        Let's Create Together
                    </h2>
                    <p class="text-xl font-light leading-relaxed max-w-2xl mx-auto"
                       style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                        Have a question or want to collaborate? We'd love to hear from you
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                    <a href="{{ url('/contact') }}" 
                       class="inline-block text-white px-10 py-4 rounded-full font-medium text-base transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl"
                       style="background: var(--primary-color);"
                       onmouseover="this.style.background='var(--secondary-color)'"
                       onmouseout="this.style.background='var(--primary-color)'">
                        Get in Touch
                    </a>
                    <a href="{{ route('products.index') }}" 
                       class="inline-block px-10 py-4 rounded-full font-medium text-base border-2 transition-all duration-300"
                       style="border-color: color-mix(in srgb, var(--text-color) 20%, transparent); color: var(--text-color);"
                       onmouseover="this.style.borderColor='var(--primary-color)'; this.style.background='color-mix(in srgb, var(--primary-color) 5%, transparent)'"
                       onmouseout="this.style.borderColor='color-mix(in srgb, var(--text-color) 20%, transparent)'; this.style.background='transparent'">
                        View Collection
                    </a>
                </div>
            </div>
        </section>

    @else
        <!-- Empty State -->
        <div class="min-h-screen flex items-center justify-center px-6"
             style="background: linear-gradient(to bottom, color-mix(in srgb, var(--primary-color) 3%, var(--background-color)), var(--background-color));">
            <div class="text-center max-w-md mx-auto space-y-6 fade-in">
                <div class="w-24 h-24 mx-auto rounded-full flex items-center justify-center"
                     style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                    <svg class="w-12 h-12" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-light mb-3 tracking-tight" style="color: var(--text-color);">Coming Soon</h2>
                    <p class="font-light text-lg leading-relaxed" style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                        We're crafting our story. Check back soon to learn more about us.
                    </p>
                </div>
                <div class="pt-4">
                    <a href="{{ route('home') }}" 
                       class="inline-block font-medium transition-colors duration-300"
                       style="color: var(--primary-color);"
                       onmouseover="this.style.color='var(--secondary-color)'"
                       onmouseout="this.style.color='var(--primary-color)'">
                        Return to Home →
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection