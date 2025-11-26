<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin | HoodLuxe')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');
        * {
            font-family: 'Inter', sans-serif;
        }
        body {
            background-color: #000;
            color: #f3f3f3;
        }
        .sidebar {
            background: linear-gradient(180deg, #0a0a0a 0%, #1a1a1a 100%);
            border-right: 1px solid #222;
        }
        .sidebar a {
            color: #ccc;
            display: block;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #111;
            color: #facc15;
        }
    </style>
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 sidebar p-6">
            <h2 class="text-2xl font-semibold text-yellow-400 mb-8">Admin Panel</h2>
            <nav class="space-y-3">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->is('admin/products*') ? 'active' : '' }}">Products</a>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->is('admin/categories*') ? 'active' : '' }}">Categories</a>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->is('admin/orders*') ? 'active' : '' }}">Orders</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-10 bg-gradient-to-b from-black to-neutral-950">
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-light">@yield('title')</h1>
                <a href="/" class="text-yellow-400 hover:text-yellow-500 transition">← Back to site</a>
            </div>

            <div>
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
