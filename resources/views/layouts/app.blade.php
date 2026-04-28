<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'e-Commerce')</title>
    <!-- fivicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/white-07.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Dynamic Theme Styles -->
    <x-theme-styles :theme="$activeTheme" />

    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background: var(--background-color);
            color: var(--text-color);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1),
                transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .product-card {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card:hover {
            transform: translateY(-8px);
        }

        .product-card img {
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        .navbar-glass {
            background: var(--background-color);
            border-bottom: 1px solid color-mix(in srgb, var(--text-color) 10%, transparent);
            transition: all 0.3s ease;
        }

        .nav-link {
            position: relative;
            padding: 0.5rem 0;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-color);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease;
        }

        .mobile-menu.active {
            transform: translateX(0);
        }

        .cart-badge {
            animation: badge-pop 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes badge-pop {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Theme toggle button animation */
        .theme-toggle-btn {
            position: relative;
            cursor: pointer;
        }

        .theme-toggle-btn svg {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .theme-toggle-btn:hover svg:not(.animate-spin) {
            transform: rotate(180deg) scale(1.1);
        }

        @keyframes iconFadeIn {
            0% {
                opacity: 0;
                transform: rotate(-180deg) scale(0.5);
            }

            100% {
                opacity: 1;
                transform: rotate(0deg) scale(1);
            }
        }

        @keyframes iconFadeOut {
            0% {
                opacity: 1;
                transform: rotate(0deg) scale(1);
            }

            100% {
                opacity: 0;
                transform: rotate(180deg) scale(0.5);
            }
        }

        .icon-enter {
            animation: iconFadeIn 0.5s ease-out forwards;
        }

        .icon-exit {
            animation: iconFadeOut 0.5s ease-out forwards;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        /* Smooth theme transition */
        * {
            transition: background-color 0.3s ease,
                color 0.3s ease,
                border-color 0.3s ease,
                fill 0.3s ease,
                stroke 0.3s ease;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    @livewireStyles
</head>

<body class="antialiased">

    <!-- Enhanced Professional Navbar -->
    <nav class="fixed top-0 w-full z-50 navbar-glass">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="flex items-center justify-between h-20">

                <!-- Logo -->
                <div class="flex-shrink-0">
                    @include('layouts.logo')
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-12">
                    <a href="{{ url('/') }}"
                        class="nav-link text-sm font-medium {{ request()->is('/') ? 'active' : '' }}"
                        style="color: var(--text-color);">
                        Home
                    </a>
                    <a href="{{ url('/products') }}"
                        class="nav-link text-sm font-medium {{ request()->is('products*') ? 'active' : '' }}"
                        style="color: var(--text-color);">
                        Products
                    </a>
                    <a href="{{ url('/about-us') }}"
                        class="nav-link text-sm font-medium {{ request()->is('about-us') ? 'active' : '' }}"
                        style="color: var(--text-color);">
                        About
                    </a>
                    <a href="{{ url('/contact') }}"
                        class="nav-link text-sm font-medium {{ request()->is('contact') ? 'active' : '' }}"
                        style="color: var(--text-color);">
                        Contact
                    </a>

                    <!-- Professional Theme Toggle Button -->
                    <button id="theme-toggle-btn"
                        class="theme-toggle-btn relative p-2.5 rounded-full transition-all duration-300 group overflow-hidden"
                        style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);"
                        onmouseover="this.style.background='color-mix(in srgb, var(--primary-color) 20%, transparent)'; this.style.transform='scale(1.05)'"
                        onmouseout="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'; this.style.transform='scale(1)'">
                        <!-- Sun Icon (for light mode) -->
                        <svg id="sun-icon"
                            class="w-5 h-5 transition-all duration-500 {{ $currentMode === 'light' ? '' : 'hidden' }}"
                            style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                        <!-- Moon Icon (for dark mode) -->
                        <svg id="moon-icon"
                            class="w-5 h-5 transition-all duration-500 {{ $currentMode === 'dark' ? '' : 'hidden' }}"
                            style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                        </svg>
                        <!-- Loading Spinner -->
                        <svg id="loading-icon" class="w-5 h-5 hidden animate-spin" style="color: var(--primary-color);"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </button>
                </div>

                <!-- Right Side: User Menu, Cart & Mobile Menu Toggle -->
                <div class="flex items-center gap-4">
                    <!-- User Menu -->
                    <div class="relative hidden md:block">
                        @auth
                        <button id="user-menu-btn" class="flex items-center gap-2 p-2 rounded-full transition-all duration-300"
                            style="color: var(--text-color);"
                            onmouseover="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'"
                            onmouseout="this.style.background='transparent'">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                        </button>
                        <!-- Dropdown -->
                        <div id="user-dropdown" class="absolute right-0 mt-3 w-56 rounded-2xl shadow-xl overflow-hidden z-50 border hidden opacity-0 transition-all duration-300 transform scale-95"
                            style="background: var(--background-color); border-color: color-mix(in srgb, var(--text-color) 10%, transparent);">
                            <div class="p-4 border-b" style="border-color: color-mix(in srgb, var(--text-color) 10%, transparent);">
                                <p class="text-[10px] font-bold uppercase tracking-widest opacity-50 mb-1">Account</p>
                                <p class="text-sm font-medium truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="py-2">
                                @if(Auth::user()->is_admin)
                                <a href="{{ url('/admin/dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm transition-colors"
                                    onmouseover="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'; this.style.color='var(--primary-color)'"
                                    onmouseout="this.style.background='transparent'; this.style.color='inherit'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37a1.724 1.724 0 002.572-1.065z" />
                                    </svg>
                                    Admin Dashboard
                                </a>
                                @endif
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-sm transition-colors text-red-500"
                                        onmouseover="this.style.background='color-mix(in srgb, #ef4444 10%, transparent)'"
                                        onmouseout="this.style.background='transparent'">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                        @else
                        <a href="{{ route('login') }}" class="px-6 py-2 rounded-full text-sm font-medium transition-all duration-300"
                            style="background: var(--primary-color); color: white;"
                            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 10px 20px -10px var(--primary-color)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            Login
                        </a>
                        @endauth
                    </div>

                    <!-- Cart Icon -->
                    <a href="{{ url('/cart') }}" class="relative group p-2 rounded-full transition-all duration-300"
                        style="color: var(--text-color);"
                        onmouseover="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'"
                        onmouseout="this.style.background='transparent'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        <livewire:cart-counter />
                    </a>

                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-btn" class="md:hidden p-2 rounded-full transition-all duration-300"
                        style="color: var(--text-color);"
                        onmouseover="this.style.background='color-mix(in srgb, var(--primary-color) 10%, transparent)'"
                        onmouseout="this.style.background='transparent'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu"
            class="mobile-menu md:hidden fixed top-20 right-0 h-[calc(100vh-5rem)] w-64 shadow-2xl z-40"
            style="background: var(--background-color); border-left: 1px solid color-mix(in srgb, var(--text-color) 10%, transparent);">
            <div class="flex flex-col p-6 space-y-6">
                <a href="{{ url('/') }}" class="text-base font-medium"
                    style="color: {{ request()->is('/') ? 'var(--primary-color)' : 'var(--text-color)' }};">
                    Home
                </a>
                <a href="{{ url('/products') }}" class="text-base font-medium"
                    style="color: {{ request()->is('products*') ? 'var(--primary-color)' : 'var(--text-color)' }};">
                    Products
                </a>
                <a href="{{ url('/about-us') }}" class="text-base font-medium"
                    style="color: {{ request()->is('about-us') ? 'var(--primary-color)' : 'var(--text-color)' }};">
                    About
                </a>
                <a href="{{ url('/contact') }}" class="text-base font-medium"
                    style="color: {{ request()->is('contact') ? 'var(--primary-color)' : 'var(--text-color)' }};">
                    Contact
                </a>

                @auth
                <div class="pt-6 border-t" style="border-color: color-mix(in srgb, var(--text-color) 10%, transparent);">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: color-mix(in srgb, var(--primary-color) 15%, transparent);">
                            <svg class="w-6 h-6" style="color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold" style="color: var(--text-color);">{{ Auth::user()->name }}</p>
                            <p class="text-xs opacity-60" style="color: var(--text-color);">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    @if(Auth::user()->is_admin)
                    <a href="{{ url('/admin/dashboard') }}" class="block p-4 rounded-xl mb-3 font-medium transition-all"
                        style="background: color-mix(in srgb, var(--primary-color) 8%, transparent); color: var(--primary-color);">
                        Admin Panel
                    </a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full p-4 rounded-xl font-medium text-center transition-all"
                            style="background: color-mix(in srgb, #ef4444 8%, transparent); color: #ef4444;">
                            Logout
                        </button>
                    </form>
                </div>
                @else
                <a href="{{ route('login') }}" class="w-full py-4 rounded-xl text-center font-bold transition-all duration-300"
                    style="background: var(--primary-color); color: white;">
                    Login
                </a>
                @endauth

                <!-- Professional Mobile Theme Toggle -->
                <div class="pt-4 border-t"
                    style="border-color: color-mix(in srgb, var(--text-color) 10%, transparent);">
                    <button id="mobile-theme-toggle"
                        class="flex items-center justify-between w-full p-4 rounded-xl transition-all duration-300"
                        style="background: color-mix(in srgb, var(--primary-color) 8%, transparent);"
                        onmouseover="this.style.background='color-mix(in srgb, var(--primary-color) 15%, transparent)'"
                        onmouseout="this.style.background='color-mix(in srgb, var(--primary-color) 8%, transparent)'">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg"
                                style="background: color-mix(in srgb, var(--primary-color) 20%, transparent);">
                                <svg id="mobile-sun-icon"
                                    class="w-5 h-5 transition-all duration-500 {{ $currentMode === 'light' ? '' : 'hidden' }}"
                                    style="color: var(--primary-color);" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                </svg>
                                <svg id="mobile-moon-icon"
                                    class="w-5 h-5 transition-all duration-500 {{ $currentMode === 'dark' ? '' : 'hidden' }}"
                                    style="color: var(--primary-color);" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                                </svg>
                                <svg id="mobile-loading-icon" class="w-5 h-5 hidden animate-spin"
                                    style="color: var(--primary-color);" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </div>
                            <div class="text-left">
                                <div class="text-sm font-semibold" style="color: var(--text-color);">Theme Mode</div>
                                <div class="text-xs"
                                    style="color: color-mix(in srgb, var(--text-color) 60%, transparent);">
                                    Currently: {{ ucfirst($currentMode) }}
                                </div>
                            </div>
                        </div>
                        <svg class="w-5 h-5 transition-transform duration-300" style="color: var(--primary-color);"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        @include('layouts.footer')
    </footer>

    <!-- Scripts -->
    <script>
        // User menu dropdown toggle
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuBtn = document.getElementById('user-menu-btn');
            const userDropdown = document.getElementById('user-dropdown');

            if (userMenuBtn && userDropdown) {
                userMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isHidden = userDropdown.classList.contains('hidden');

                    if (isHidden) {
                        userDropdown.classList.remove('hidden');
                        // Small delay to allow 'hidden' removal to trigger transitions
                        requestAnimationFrame(() => {
                            userDropdown.classList.remove('opacity-0', 'scale-95');
                        });
                    } else {
                        userDropdown.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            userDropdown.classList.add('hidden');
                        }, 300);
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!userDropdown.contains(e.target) && !userMenuBtn.contains(e.target)) {
                        userDropdown.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            userDropdown.classList.add('hidden');
                        }, 300);
                    }
                });
            }
        });

        // Mobile menu toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('active');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const btn = document.getElementById('mobile-menu-btn');
            if (!menu.contains(event.target) && !btn.contains(event.target)) {
                menu.classList.remove('active');
            }
        });

        // Intersection Observer for Fade-in Animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.fade-in').forEach(el => {
                observer.observe(el);
            });
        });

        // Professional Theme Toggle Functionality with Animation
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggleBtn = document.getElementById('theme-toggle-btn');
            const mobileThemeToggle = document.getElementById('mobile-theme-toggle');
            const sunIcon = document.getElementById('sun-icon');
            const moonIcon = document.getElementById('moon-icon');
            const loadingIcon = document.getElementById('loading-icon');
            const mobileSunIcon = document.getElementById('mobile-sun-icon');
            const mobileMoonIcon = document.getElementById('mobile-moon-icon');
            const mobileLoadingIcon = document.getElementById('mobile-loading-icon');

            async function toggleTheme() {
                try {
                    // Show loading state for both desktop and mobile
                    if (themeToggleBtn) {
                        themeToggleBtn.disabled = true;
                        sunIcon.classList.add('hidden');
                        moonIcon.classList.add('hidden');
                        loadingIcon.classList.remove('hidden');
                    }

                    if (mobileThemeToggle) {
                        mobileThemeToggle.disabled = true;
                        mobileSunIcon.classList.add('hidden');
                        mobileMoonIcon.classList.add('hidden');
                        mobileLoadingIcon.classList.remove('hidden');
                    }

                    const response = await fetch('/theme/toggle', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Theme toggle request failed');
                    }

                    const data = await response.json();
                    console.log('Theme toggle response:', data);

                    // Check if response indicates success (handles different response formats)
                    if (data.success || data.message || response.ok) {
                        // Add exit animation to current icons
                        if (sunIcon && !sunIcon.classList.contains('hidden')) {
                            sunIcon.classList.add('icon-exit');
                        }
                        if (moonIcon && !moonIcon.classList.contains('hidden')) {
                            moonIcon.classList.add('icon-exit');
                        }
                        if (mobileSunIcon && !mobileSunIcon.classList.contains('hidden')) {
                            mobileSunIcon.classList.add('icon-exit');
                        }
                        if (mobileMoonIcon && !mobileMoonIcon.classList.contains('hidden')) {
                            mobileMoonIcon.classList.add('icon-exit');
                        }

                        // Wait for animation then reload to apply the new theme
                        setTimeout(() => {
                            window.location.reload();
                        }, 400);
                    } else {
                        console.error('Theme toggle failed:', data);
                        resetToggleButtons();
                    }
                } catch (error) {
                    console.error('Error toggling theme:', error);
                    resetToggleButtons();
                }
            }

            function resetToggleButtons() {
                if (themeToggleBtn) {
                    themeToggleBtn.disabled = false;
                    loadingIcon.classList.add('hidden');
                    const currentMode = '{{ $currentMode }}';
                    if (currentMode === 'light') {
                        sunIcon.classList.remove('hidden');
                    } else {
                        moonIcon.classList.remove('hidden');
                    }
                }

                if (mobileThemeToggle) {
                    mobileThemeToggle.disabled = false;
                    mobileLoadingIcon.classList.add('hidden');
                    const currentMode = '{{ $currentMode }}';
                    if (currentMode === 'light') {
                        mobileSunIcon.classList.remove('hidden');
                    } else {
                        mobileMoonIcon.classList.remove('hidden');
                    }
                }
            }

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', toggleTheme);
            }

            if (mobileThemeToggle) {
                mobileThemeToggle.addEventListener('click', toggleTheme);
            }
        });
    </script>

    @livewireScripts
</body>

</html>