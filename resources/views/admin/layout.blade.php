<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin | HoodLuxe')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @foreach(config('fonts') as $font)
    <link href="{{ $font['url'] }}" rel="stylesheet">
    @endforeach
    
    <style>
        :root {
            --primary-color: {{ $activeTheme->primary_color ?? '#0f172a' }};
            --secondary-color: {{ $activeTheme->secondary_color ?? '#1e293b' }};
            --background-color: {{ $activeTheme->background_color ?? '#ffffff' }};
            --text-color: {{ $activeTheme->text_color ?? '#0f172a' }};
            --font-family: {{ $activeTheme->font_family ?? 'Inter' }}, sans-serif;
        }

        * {
            font-family: var(--font-family);
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
        }

        .sidebar {
            background: linear-gradient(180deg, 
                color-mix(in srgb, var(--primary-color) 3%, var(--background-color)) 0%, 
                color-mix(in srgb, var(--primary-color) 5%, var(--background-color)) 100%);
            border-right: 2px solid color-mix(in srgb, var(--primary-color) 15%, transparent);
        }

        .sidebar a {
            color: color-mix(in srgb, var(--text-color) 60%, transparent);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.875rem 1rem;
            border-radius: 12px;
            transition: all 0.3s;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .sidebar a:hover {
            background-color: color-mix(in srgb, var(--primary-color) 10%, transparent);
            color: var(--primary-color);
        }

        .sidebar a.active {
            background-color: var(--primary-color);
            color: var(--background-color);
        }

        .sidebar-icon {
            width: 20px;
            height: 20px;
        }

        /* Page header styling */
        .page-header {
            background: linear-gradient(to bottom, 
                color-mix(in srgb, var(--primary-color) 5%, var(--background-color)), 
                var(--background-color));
        }

        /* Button styling */
        .btn-primary {
            background: var(--primary-color);
            color: var(--background-color);
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: var(--secondary-color);
        }

        .btn-secondary {
            border: 2px solid color-mix(in srgb, var(--primary-color) 30%, transparent);
            color: var(--text-color);
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            border-color: var(--primary-color);
            background: color-mix(in srgb, var(--primary-color) 5%, transparent);
        }

        /* Card styling */
        .card {
            background: var(--background-color);
            border: 1px solid color-mix(in srgb, var(--primary-color) 15%, transparent);
            border-radius: 12px;
            transition: all 0.3s;
        }

        .card:hover {
            border-color: var(--primary-color);
            box-shadow: 0 10px 30px -10px color-mix(in srgb, var(--primary-color) 20%, transparent);
        }

        /* Input styling */
        input, select, textarea {
            background: var(--background-color);
            border: 2px solid color-mix(in srgb, var(--text-color) 20%, transparent);
            color: var(--text-color);
            transition: all 0.3s;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        /* Link styling */
        .text-link {
            color: var(--primary-color);
            transition: color 0.3s;
        }

        .text-link:hover {
            color: var(--secondary-color);
        }

        /* Badge styling */
        .badge-primary {
            background: color-mix(in srgb, var(--primary-color) 15%, transparent);
            color: var(--primary-color);
        }

        /* Prevent theme from affecting admin */
        .admin-content * {
            font-family: var(--font-family) !important;
        }

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
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>

<body style="background: var(--background-color);">
    <div class="flex min-h-screen admin-content">
        <!-- Sidebar -->
        <aside class="w-72 sidebar p-6 shadow-sm">
            @include('admin.logo')

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="{{ request()->is('admin/products*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    Products
                </a>

                <a href="{{ route('admin.categories.index') }}"
                    class="{{ request()->is('admin/categories*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                    </svg>
                    Categories
                </a>

                <a href="{{ route('admin.stock-types.index') }}"
                    class="{{ request()->is('admin/stock-types*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                    </svg>
                    Stock Types
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="{{ request()->is('admin/orders*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Orders
                </a>

                <a href="{{ route('admin.discounts.index') }}"
                    class="{{ request()->is('admin/discounts*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                    Discounts
                </a>

                <a href="{{ route('admin.about-us.edit') }}"
                    class="{{ request()->is('admin/about-us*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    About Us
                </a>

                <a href="{{ route('admin.users.index') }}" class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Admin Users</span>
                </a>

                <a href="{{ route('admin.appearance.settings') }}"
                    class="{{ request()->is('admin/appearance*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.043-.025a15.994 15.994 0 0 1 1.622-3.395m3.42 3.42a15.995 15.995 0 0 0 4.764-4.648l3.876-5.814a1.151 1.151 0 0 0-1.597-1.597L14.146 6.32a15.996 15.996 0 0 0-4.649 4.763m3.42 3.42a6.776 6.776 0 0 0-3.42-3.42" />
                    </svg>
                    <span>Appearance</span>
                </a>

                <a href="{{ route('admin.hero-home.edit') }}"
                    class="{{ request()->is('admin/hero-home*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Home Section
                </a>

                <a href="{{ route('admin.features.edit') }}"
                    class="{{ request()->is('admin/features*') || request()->is('admin/brand-story*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
                    </svg>
                    Features Section
                </a>

                <a href="{{ route('admin.footer.edit') }}"
                    class="{{ request()->is('admin/footer*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M3 16.5V6a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 6v10.5M3 16.5h18M12 12l-3-3m0 0l3-3m-3 3h12.75" />
                    </svg>
                    Edit Footer
                </a>

                <a href="{{ route('admin.newsletter.index') }}"
                    class="{{ request()->is('admin/newsletter*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Newsletter Subscribers
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 lg:p-12" style="background: var(--background-color);">
            <div class="flex justify-between items-center mb-10">
                <h1 class="text-3xl font-light" style="color: var(--text-color);">@yield('title')</h1>
                <a href="/"
                    class="transition-colors duration-300 font-medium text-sm flex items-center gap-2"
                    style="color: color-mix(in srgb, var(--text-color) 60%, transparent);"
                    onmouseover="this.style.color='var(--primary-color)'"
                    onmouseout="this.style.color='color-mix(in srgb, var(--text-color) 60%, transparent)'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Site
                </a>
            </div>

            <div>
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>