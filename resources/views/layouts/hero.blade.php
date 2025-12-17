@php
    $heroSection = \App\Models\HeroHomePage::where('is_active', true)->first();
@endphp

@if($heroSection)
<section class="relative w-full min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Background Media with Overlay -->
    <div class="absolute inset-0 z-0">
        @if($heroSection->background_type === 'video' && $heroSection->background_video_path)
            <!-- Video Background -->
            <video autoplay muted loop playsinline class="w-full h-full object-cover">
                <source src="{{ asset('storage/' . $heroSection->background_video_path) }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="absolute inset-0" style="background: linear-gradient(to right, color-mix(in srgb, var(--background-color) 80%, transparent), color-mix(in srgb, var(--background-color) 40%, transparent));"></div>
        @elseif($heroSection->background_type === 'image' && $heroSection->background_image_path)
            <!-- Image Background -->
            <img src="{{ asset('storage/' . $heroSection->background_image_path) }}" 
                 alt="Hero Background" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0" style="background: linear-gradient(to right, color-mix(in srgb, var(--background-color) 80%, transparent), color-mix(in srgb, var(--background-color) 40%, transparent));"></div>
        @else
            <!-- Default Gradient Background -->
            <div class="w-full h-full" style="background: linear-gradient(135deg, var(--background-color) 0%, color-mix(in srgb, var(--primary-color) 10%, var(--background-color)) 100%);"></div>
        @endif
    </div>

    <!-- Hero Content -->
    <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="max-w-4xl mx-auto text-center space-y-8 animate-fade-in">
            
            @if($heroSection->heading)
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold leading-tight tracking-tight text-theme-text">
                {{ $heroSection->heading }}
            </h1>
            @endif

            @if($heroSection->subheading)
            <p class="text-xl sm:text-2xl md:text-3xl font-light text-theme-text" style="opacity: 0.9;">
                {{ $heroSection->subheading }}
            </p>
            @endif

            @if($heroSection->content)
            <p class="text-base sm:text-lg max-w-2xl mx-auto leading-relaxed" 
               style="color: color-mix(in srgb, var(--text-color) 80%, transparent);">
                {{ $heroSection->content }}
            </p>
            @endif

            <!-- CTA Buttons -->
            @if($heroSection->primary_button_text || $heroSection->secondary_button_text)
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-8">
                @if($heroSection->primary_button_text && $heroSection->primary_button_link)
<a href="{{ $heroSection->primary_button_link }}" 
   class="group inline-flex items-center gap-2
          px-8 py-4 rounded-full font-semibold text-base
          text-white shadow-lg transition-all duration-300
          transform hover:-translate-y-1 hover:shadow-xl
          hero-primary-btn">
    {{ $heroSection->primary_button_text }}

    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1"
         fill="none"
         stroke="currentColor"
         viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M13 7l5 5m0 0l-5 5m5-5H6"/>
    </svg>
</a>

                @endif

                @if($heroSection->secondary_button_text && $heroSection->secondary_button_link)
                <a href="{{ $heroSection->secondary_button_link }}" 
                   class="group inline-flex items-center gap-2 border-2 px-8 py-4 rounded-full font-semibold text-base transition-all duration-300 transform hover:-translate-y-1"
                   style="border-color: var(--primary-color); color: var(--text-color);"
                   onmouseover="this.style.background='var(--primary-color)'; this.style.color='white'; this.style.borderColor='var(--primary-color)';"
                   onmouseout="this.style.background='transparent'; this.style.color='var(--text-color)'; this.style.borderColor='var(--primary-color)';">
                    {{ $heroSection->secondary_button_text }}
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>

    <!-- Scroll Down Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 z-10 animate-bounce">
        <svg class="w-6 h-6 text-theme-text" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<style>
    .hero-primary-btn {
    background-color: var(--primary-color);
    color: var(--background-color);
}

.hero-primary-btn:hover {
    background-color: var(--secondary-color);
    color: var(--background-color); /* keeps contrast correct */
}

    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 1s ease-out forwards;
    }

    /* Theme transitions */
    .text-theme-text,
    a[style*="var(--primary-color)"],
    a[style*="var(--text-color)"] {
        transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
    }
</style>
@endif