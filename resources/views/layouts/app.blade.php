<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HoodLuxe - Premium Hoodies')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #000000 0%, #0f0f0f 50%, #1a1a1a 100%);
        }

        .fade-in {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 1s ease, transform 1s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .product-card {
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(255, 255, 255, 0.05);
        }

        .btn-primary {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-primary:hover::before {
            width: 300px;
            height: 300px;
        }
        /* Hide number input arrows */
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance: textfield; /* Firefox */
}

    </style>
    @livewireStyles
</head>
<body class="bg-black text-gray-200 smooth-scroll">

    <!-- ✅ Navbar -->
    <nav class="fixed top-0 w-full z-50 bg-black/80 backdrop-blur-md border-b border-neutral-800">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-2xl font-light tracking-wider text-white hover:text-yellow-400 transition">HoodLuxe</a>

            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ url('/products') }}" class="hover:text-yellow-400 transition">Products</a>
                <a href="{{ url('/about') }}" class="hover:text-yellow-400 transition">About</a>
                <a href="{{ url('/contact') }}" class="hover:text-yellow-400 transition">Contact</a>
            </div>

            <div class="flex items-center space-x-6">
                <a href="{{ url('/cart') }}" class="relative hover:text-yellow-400 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <livewire:cart-counter />
                </a>
            </div>
        </div>
    </nav>

    <!-- ✅ Page content placeholder -->
    <main class="pt-24 min-h-screen">
        @yield('content')
    </main>

    <!-- ✅ Footer -->
    <footer class="bg-neutral-950 border-t border-neutral-800 py-12 text-center">
        <p class="text-gray-500 text-sm">&copy; {{ date('Y') }} HoodLuxe. All rights reserved.</p>
    </footer>

    <!-- ✅ Optional: Fade-in animation script -->
    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
    </script>
@livewireScripts
</body>
</html>
