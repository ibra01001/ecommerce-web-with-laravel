{{-- resources/views/components/features-section.blade.php --}}
@php
    $featuresSection = \App\Models\FeaturesSection::with('activeItems')->active()->first();
@endphp

@if($featuresSection)
<section class="py-16" style="background-color: {{ $featuresSection->background_color }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($featuresSection->show_section_title)
        <h2 class="text-3xl font-bold text-center mb-4" style="color: {{ $featuresSection->title_color ?? '#0f172a' }}">
            {{ $featuresSection->section_title }}
        </h2>
        @endif

        @if($featuresSection->show_section_description && $featuresSection->section_description)
        <p class="text-center text-lg mb-12 max-w-3xl mx-auto" style="color: {{ $featuresSection->description_color ?? '#475569' }}">
            {{ $featuresSection->section_description }}
        </p>
        @endif

        @if($featuresSection->layout_style === 'grid')
        <div class="grid gap-8 md:grid-cols-{{ $featuresSection->columns }}">
            @foreach($featuresSection->activeItems as $item)
            <div class="text-{{ $item->alignment }}">
                {{-- Icon --}}
                <div class="mb-4 flex {{ $item->alignment === 'center' ? 'justify-center' : ($item->alignment === 'right' ? 'justify-end' : 'justify-start') }}">
                    @if($item->icon_type === 'svg')
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: {{ $item->icon_color }}">
                            {!! $item->icon_svg !!}
                        </svg>
                    @elseif($item->icon_type === 'svg_upload')
                        <div class="w-12 h-12 flex items-center justify-center" style="color: {{ $item->icon_color }}">
                            {!! $item->icon_svg_content !!}
                        </div>
                    @elseif($item->icon_type === 'image')
                        <img src="{{ $item->icon_image_url }}" alt="{{ $item->title }}" class="w-12 h-12 object-contain">
                    @elseif($item->icon_type === 'emoji')
                        <span class="text-5xl">{{ $item->icon_emoji }}</span>
                    @endif
                </div>

                {{-- Title --}}
                <h3 class="text-xl font-semibold mb-2" style="color: {{ $item->title_color }}">
                    {{ $item->title }}
                </h3>

                {{-- Description --}}
                <p class="text-sm" style="color: {{ $item->description_color }}">
                    {{ $item->description }}
                </p>

                {{-- Optional Link --}}
                @if($item->link_url && $item->link_text)
                <a href="{{ $item->link_url }}" 
                   class="inline-block mt-3 text-sm font-medium hover:underline"
                   style="color: {{ $item->icon_color }}"
                   @if($item->open_in_new_tab) target="_blank" rel="noopener noreferrer" @endif>
                    {{ $item->link_text }} →
                </a>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

{{-- Brand Story Section --}}
@php
    $brandStory = \App\Models\BrandStorySection::active()->first();
@endphp

@if($brandStory)
<section class="py-16" style="background-color: {{ $brandStory->background_color }}">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-6" style="color: {{ $brandStory->title_color }}">
            {{ $brandStory->title }}
        </h2>
        
        <p class="text-lg mb-8 leading-relaxed" style="color: {{ $brandStory->description_color }}">
            {{ $brandStory->description }}
        </p>

        @if($brandStory->show_button && $brandStory->button_text)
        <a href="{{ $brandStory->button_link ?? '#' }}" 
           class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-medium transition-all duration-300 hover:opacity-90"
           style="background-color: {{ $brandStory->title_color }}; color: {{ $brandStory->background_color }}">
            {{ $brandStory->button_text }}
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
        @endif
    </div>
</section>
@endif
@endif

<style>
    /* Add proper sizing constraints for uploaded SVGs */
    [class*="w-12"][class*="h-12"] svg {
        max-width: 48px;
        max-height: 48px;
        width: 100%;
        height: 100%;
    }
</style>