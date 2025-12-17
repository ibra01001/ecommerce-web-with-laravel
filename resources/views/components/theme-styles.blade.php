@props(['theme'])

<style>
    :root {
        /* Theme Colors */
        --primary-color: {{ $theme->primary_color }};
        --secondary-color: {{ $theme->secondary_color }};
        --background-color: {{ $theme->background_color }};
        --text-color: {{ $theme->text_color }};
        
        /* RGB values for opacity utilities */
        --primary-rgb: {{ hexToRgb($theme->primary_color) }};
        --secondary-rgb: {{ hexToRgb($theme->secondary_color) }};
        --background-rgb: {{ hexToRgb($theme->background_color) }};
        --text-rgb: {{ hexToRgb($theme->text_color) }};
    }

    body {
        font-family: '{{ $theme->font_family }}', 'Inter', sans-serif !important;
        background-color: var(--background-color);
        color: var(--text-color);
    }

    /* Apply theme colors to buttons and elements */
    .btn-primary, .bg-theme-primary {
        background-color: var(--primary-color) !important;
        color: white !important;
    }

    .btn-secondary, .bg-theme-secondary {
        background-color: var(--secondary-color) !important;
        color: white !important;
    }

    .text-theme-primary {
        color: var(--primary-color) !important;
    }

    .text-theme-secondary {
        color: var(--secondary-color) !important;
    }

    .border-theme-primary {
        border-color: var(--primary-color) !important;
    }

    .border-theme-secondary {
        border-color: var(--secondary-color) !important;
    }

    .bg-theme-background {
        background-color: var(--background-color) !important;
    }

    .text-theme-text {
        color: var(--text-color) !important;
    }

    /* Hover states */
    .btn-primary:hover, .hover\:bg-theme-primary:hover {
        background-color: color-mix(in srgb, var(--primary-color) 85%, black) !important;
    }

    .btn-secondary:hover, .hover\:bg-theme-secondary:hover {
        background-color: color-mix(in srgb, var(--secondary-color) 85%, black) !important;
    }

    .hover\:text-theme-primary:hover {
        color: var(--primary-color) !important;
    }

    .hover\:text-theme-secondary:hover {
        color: var(--secondary-color) !important;
    }

    /* Links - only style non-admin links */
    .theme-link {
        color: var(--primary-color);
        transition: color 0.2s ease;
    }

    .theme-link:hover {
        color: var(--secondary-color);
    }

    /* Product cards and interactive elements */
    .product-card:hover {
        border-color: var(--primary-color);
    }

    /* Buttons that should use theme */
    button.theme-btn,
    a.theme-btn {
        background-color: var(--primary-color);
        color: white;
        transition: all 0.3s ease;
    }

    button.theme-btn:hover,
    a.theme-btn:hover {
        background-color: color-mix(in srgb, var(--primary-color) 85%, black);
    }

    @if($theme->mode === 'dark')
        /* Dark mode adjustments */
        body {
            background-color: #1a1a1a !important;
            color: #f0f0f0 !important;
        }

        .navbar-glass {
            background: rgba(26, 26, 26, 0.98) !important;
            border-color: #333 !important;
        }

        .card, .bg-white:not(.no-dark) {
            background-color: #2a2a2a !important;
            color: #f0f0f0 !important;
        }

        .border:not(.no-dark) {
            border-color: #3a3a3a !important;
        }

        .text-slate-900:not(.no-dark) {
            color: #f0f0f0 !important;
        }

        .text-slate-700:not(.no-dark) {
            color: #d0d0d0 !important;
        }

        .text-slate-600:not(.no-dark) {
            color: #b0b0b0 !important;
        }

        .text-slate-500:not(.no-dark) {
            color: #909090 !important;
        }

        .bg-slate-50:not(.no-dark) {
            background-color: #2a2a2a !important;
        }

        .bg-slate-100:not(.no-dark) {
            background-color: #333 !important;
        }

        input:not(.no-dark), 
        textarea:not(.no-dark), 
        select:not(.no-dark) {
            background-color: #333 !important;
            border-color: #444 !important;
            color: #f0f0f0 !important;
        }

        footer {
            background-color: #1a1a1a !important;
            border-color: #333 !important;
        }
    @endif
</style>

<!-- Load theme-specific font -->
<link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $theme->font_family) }}:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">

@php
function hexToRgb($hex) {
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return "$r, $g, $b";
}
@endphp