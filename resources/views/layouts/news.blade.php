{{-- resources/views/layouts/news.blade.php --}}
@php
    $news = \App\Models\News::where('is_active', true)->first();
@endphp

@if($news && $news->images && count($news->images) > 0)
<section class="relative w-full overflow-hidden" style="background: var(--background-color);">
    
    {{-- Main Slider Container --}}
    <div class="relative w-full h-[500px] sm:h-[450px] md:h-[550px] lg:h-[650px]">
        
        {{-- Images --}}
        @foreach($news->images as $index => $image)
        <div class="news-slide absolute inset-0 transition-opacity duration-700 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" 
             data-slide="{{ $index }}">
            <img src="{{ asset('storage/' . $image) }}" 
                 alt="{{ $news->title }}" 
                 class="w-full h-full object-contain sm:object-cover cursor-pointer"
                 onclick="openFullscreen('{{ asset('storage/' . $image) }}')">
            
            {{-- Subtle gradient overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent"></div>
        </div>
        @endforeach

        {{-- Navigation Arrows --}}
        @if(count($news->images) > 1)
        <button onclick="prevSlide()" 
                class="absolute left-4 sm:left-4 bottom-20 sm:top-1/2 sm:-translate-y-1/2 z-20 p-3 rounded-full backdrop-blur-md transition-all duration-300 hover:scale-110"
                style="background: color-mix(in srgb, var(--background-color) 80%, transparent); color: var(--text-color);">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <button onclick="nextSlide()" 
                class="absolute right-4 sm:right-4 bottom-20 sm:top-1/2 sm:-translate-y-1/2 z-20 p-3 rounded-full backdrop-blur-md transition-all duration-300 hover:scale-110"
                style="background: color-mix(in srgb, var(--background-color) 80%, transparent); color: var(--text-color);">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>
        @endif

        {{-- Bottom Info Bar --}}
        @if($news->title)
        <div class="absolute bottom-0 left-0 right-0 z-10 p-4 sm:p-6 backdrop-blur-xl" 
             style="background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.6) 50%, transparent 100%);">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
                
                {{-- Title & Badge --}}
                <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4 w-full sm:w-auto">
                    <div class="px-3 sm:px-4 py-1.5 sm:py-2  backdrop-blur-sm shrink-0" 
                         style="background: var(--primary-color); box-shadow: 0 4px 16px color-mix(in srgb, var(--primary-color) 50%, transparent);">
                        <span class="font-bold text-xs sm:text-sm uppercase tracking-wider text-white">Latest News</span>
                    </div>
                    
                    <h3 class="text-base sm:text-xl md:text-2xl font-bold text-white text-center sm:text-left drop-shadow-lg">
                        {{ $news->title }}
                    </h3>
                </div>

                {{-- Slide Indicators --}}
                @if(count($news->images) > 1)
                <div class="flex gap-2">
                    @foreach($news->images as $index => $image)
                    <button onclick="goToSlide({{ $index }})" 
                            class="slide-dot w-2 h-2 rounded-full transition-all duration-300 {{ $index === 0 ? 'w-8' : '' }}"
                            data-dot="{{ $index }}"
                            style="background: {{ $index === 0 ? 'var(--primary-color)' : 'rgba(255, 255, 255, 0.4)' }}; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);"></button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</section>

{{-- Fullscreen Modal --}}
<div id="fullscreenModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" 
     style="background: rgba(0, 0, 0, 0.96); backdrop-filter: blur(10px);"
     onclick="closeFullscreen()">
    <button onclick="closeFullscreen()" 
            class="absolute top-4 sm:top-6 right-4 sm:right-6 z-10 w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center rounded-lg font-bold text-2xl sm:text-3xl text-white transition-all duration-300 hover:scale-110"
            style="background: var(--primary-color);">
        ×
    </button>
    <img id="fullscreenImg" src="" alt="News" class="max-w-full max-h-full object-contain" onclick="event.stopPropagation()">
</div>

<script>
    let currentSlide = 0;
    const totalSlides = {{ count($news->images) }};

    function showSlide(index) {
        if (index >= totalSlides) currentSlide = 0;
        else if (index < 0) currentSlide = totalSlides - 1;
        else currentSlide = index;

        document.querySelectorAll('.news-slide').forEach((slide, i) => {
            slide.style.opacity = i === currentSlide ? '1' : '0';
        });

        document.querySelectorAll('.slide-dot').forEach((dot, i) => {
            if (i === currentSlide) {
                dot.style.width = '2rem';
                dot.style.background = 'var(--primary-color)';
            } else {
                dot.style.width = '0.5rem';
                dot.style.background = 'rgba(255, 255, 255, 0.4)';
            }
        });
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    function goToSlide(index) {
        showSlide(index);
    }

    // Auto-advance slides every 5 seconds
    @if(count($news->images) > 1)
    let autoSlideInterval = setInterval(nextSlide, 5000);
    
    // Pause auto-slide on hover
    document.querySelector('.relative.w-full').addEventListener('mouseenter', () => {
        clearInterval(autoSlideInterval);
    });
    
    document.querySelector('.relative.w-full').addEventListener('mouseleave', () => {
        autoSlideInterval = setInterval(nextSlide, 5000);
    });
    @endif

    function openFullscreen(src) {
        document.getElementById('fullscreenImg').src = src;
        document.getElementById('fullscreenModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeFullscreen() {
        document.getElementById('fullscreenModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeFullscreen();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
        } else if (e.key === 'ArrowLeft') {
            prevSlide();
        }
    });

    // Touch swipe support
    let touchStartX = 0;
    let touchEndX = 0;
    const sliderContainer = document.querySelector('.relative.w-full');

    sliderContainer.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    sliderContainer.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipeGesture();
    });

    function handleSwipeGesture() {
        if (touchEndX < touchStartX - 50) nextSlide();
        if (touchEndX > touchStartX + 50) prevSlide();
    }
</script>
@endif