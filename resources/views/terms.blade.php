@extends('layouts.app')

@section('title', 'Terms & Conditions — HoodLuxe')

@section('content')

    <div class="min-h-screen" style="background: var(--background-color);">
        <!-- Hero Section -->
        <section class="relative pt-32 pb-20 px-6 overflow-hidden"
            style="background: linear-gradient(to bottom, color-mix(in srgb, var(--primary-color) 3%, var(--background-color)), var(--background-color));">
            <div class="max-w-6xl mx-auto text-center space-y-8 fade-in">
                <h1 class="text-5xl md:text-6xl lg:text-7xl font-extralight leading-tight tracking-tight"
                    style="color: var(--text-color);">
                    Terms & Conditions
                </h1>
                <p class="text-xl md:text-2xl font-light leading-relaxed max-w-3xl mx-auto"
                    style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                    Please read our terms and conditions carefully
                </p>
            </div>
        </section>

        <!-- Terms Content -->
        <section class="py-20 px-6" style="background: var(--background-color);">
            <div class="max-w-4xl mx-auto fade-in">
                <div class="space-y-12">
                    @forelse($terms as $term)
                        <div class="prose prose-2xl max-w-none">
                            <h2 class="text-3xl font-light mb-6" style="color: var(--text-color);">
                                {{ $term->title }}
                            </h2>
                            <div class="text-xl font-light leading-relaxed whitespace-pre-line"
                                style="color: color-mix(in srgb, var(--text-color) 85%, transparent);">
                                {!! $term->content !!}
                            </div>
                        </div>
                        @if(!$loop->last)
                            <hr class="border-t-2 my-12"
                                style="border-color: color-mix(in srgb, var(--text-color) 10%, transparent);">
                        @endif
                    @empty
                        <div class="text-center py-12">
                            <p class="text-xl font-light"
                                style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                                No terms and conditions have been published yet.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Bottom CTA Section -->
        <section class="py-24 px-6" style="background: var(--background-color);">
            <div class="max-w-4xl mx-auto text-center space-y-8 fade-in">
                <div class="space-y-6">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-light tracking-tight"
                        style="color: var(--text-color);">
                        Questions?
                    </h2>
                    <p class="text-xl font-light leading-relaxed max-w-2xl mx-auto"
                        style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                        If you have any questions about our terms, please don't hesitate to contact us.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
                    <a href="{{ url('/contact') }}"
                        class="inline-block text-white px-10 py-4 rounded-full font-medium text-base transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl"
                        style="background: var(--primary-color);"
                        onmouseover="this.style.background='var(--secondary-color)'"
                        onmouseout="this.style.background='var(--primary-color)'">
                        Contact Us
                    </a>
                </div>
            </div>
        </section>
    </div>

@endsection