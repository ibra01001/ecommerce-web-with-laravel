@extends('admin.layout')
@section('title', 'Terms & Conditions Management')
@section('content')

    <!-- Hero Section -->
    <section class="relative pt-32 pb-16 px-6 overflow-hidden"
        style="background: linear-gradient(135deg, var(--background-color) 0%, color-mix(in srgb, var(--primary-color) 5%, var(--background-color)) 100%);">
        <div class="relative max-w-6xl mx-auto">
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-1/4 w-64 h-64 rounded-full opacity-10 blur-3xl"
                style="background: var(--primary-color);"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 rounded-full opacity-10 blur-3xl"
                style="background: var(--secondary-color);"></div>

            <!-- Header Content -->
            <div class="relative space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-light tracking-tight text-theme-text mb-3">
                            Terms & Conditions
                        </h1>
                        <p class="text-lg font-light"
                            style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                            Manage your terms and policies
                        </p>
                    </div>
                    <a href="{{ route('admin.terms.create') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-medium transition-all duration-300 text-white hover:shadow-lg transform hover:scale-105"
                        style="background: var(--primary-color);"
                        onmouseover="this.style.background='var(--secondary-color)'"
                        onmouseout="this.style.background='var(--primary-color)'">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add New Term
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Terms List Section -->
    <section class="py-16 px-6">
        <div class="max-w-6xl mx-auto">

            @if(session('success'))
                <div class="mb-8 p-4 rounded-lg border-2 fade-in"
                    style="background: color-mix(in srgb, var(--primary-color) 10%, transparent); border-color: var(--primary-color); color: var(--text-color);">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @forelse($terms as $term)
                <div class="mb-6 border-2 rounded-lg overflow-hidden transition-all duration-300 hover:shadow-xl fade-in term-card"
                    style="background: var(--background-color); border-color: color-mix(in srgb, var(--primary-color) 20%, transparent);">
                    <div class="p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 space-y-3">
                                <h3 class="text-2xl font-medium text-theme-text">
                                    {{ $term->title }}
                                </h3>
                                <div class="prose max-w-none text-theme-text"
                                    style="color: color-mix(in srgb, var(--text-color) 80%, transparent);">
                                    <p class="line-clamp-3">{{ Str::limit(strip_tags($term->content), 200) }}</p>
                                </div>
                                <div class="flex items-center gap-4 text-sm"
                                    style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $term->created_at->format('M d, Y') }}
                                    </span>
                                    @if($term->updated_at != $term->created_at)
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Updated {{ $term->updated_at->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('admin.terms.edit', $term) }}"
                                    class="p-3 rounded-full transition-all duration-300 hover:shadow-lg transform hover:scale-110"
                                    style="background: color-mix(in srgb, var(--primary-color) 10%, transparent); color: var(--primary-color);"
                                    onmouseover="this.style.background='var(--primary-color)'; this.style.color='white';"
                                    onmouseout="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'; this.style.color='var(--primary-color)';"
                                    title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.terms.destroy', $term) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this term?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-3 rounded-full transition-all duration-300 hover:shadow-lg transform hover:scale-110"
                                        style="background: color-mix(in srgb, #ef4444 10%, transparent); color: #ef4444;"
                                        onmouseover="this.style.background='#ef4444'; this.style.color='white';"
                                        onmouseout="this.style.background='color-mix(in srgb, #ef4444 10%, transparent)'; this.style.color='#ef4444';"
                                        title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-24 space-y-6">
                    <div class="w-20 h-20 mx-auto rounded-full flex items-center justify-center"
                        style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                        <svg class="w-10 h-10 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-light mb-2 text-theme-text">No Terms Added Yet</h3>
                        <p class="text-lg font-light mb-6"
                            style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
                            Start by creating your first term or policy
                        </p>
                        <a href="{{ route('admin.terms.create') }}"
                            class="inline-flex items-center gap-2 px-8 py-3 rounded-full font-medium transition-all duration-300 text-white hover:shadow-lg transform hover:scale-105"
                            style="background: var(--primary-color);"
                            onmouseover="this.style.background='var(--secondary-color)'"
                            onmouseout="this.style.background='var(--primary-color)'">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create First Term
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

    <style>
        .term-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .term-card:hover {
            transform: translateY(-4px);
            border-color: var(--primary-color) !important;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }

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

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>

@endsection