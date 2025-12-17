@extends('layouts.app')
@section('title', 'Login — HoodLuxe')
@section('content')

<!-- Login Section - Matches Hero Style -->
<section class="relative pt-32 pb-24 px-6 bg-gradient-to-b from-slate-50 to-white min-h-screen flex items-center">
    <div class="relative max-w-md mx-auto w-full">
        
        <!-- Header - Matches Homepage Style -->
        <div class="text-center mb-12 space-y-4 fade-in">
            <h1 class="text-4xl md:text-5xl font-light text-slate-900 tracking-tight">
                Welcome Back
            </h1>
            <p class="text-slate-600 text-lg font-light">
                Continue your journey with premium comfort
            </p>
        </div>

        <!-- Session Status -->
        @if(session('status'))
            <div class="mb-6 p-4 bg-slate-900 text-white text-sm rounded fade-in">
                {{ session('status') }}
            </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6 fade-in">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm text-slate-700 font-medium mb-2">
                    Email
                </label>
                <input 
                    id="email" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}"
                    required 
                    autofocus 
                    autocomplete="username"
                    class="w-full px-4 py-3 bg-white border border-slate-200 text-slate-900 focus:outline-none focus:border-slate-900 transition-colors duration-300">
                @error('email')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm text-slate-700 font-medium mb-2">
                    Password
                </label>
                <input 
                    id="password" 
                    type="password" 
                    name="password"
                    required 
                    autocomplete="current-password"
                    class="w-full px-4 py-3 bg-white border border-slate-200 text-slate-900 focus:outline-none focus:border-slate-900 transition-colors duration-300">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between text-sm">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input 
                        id="remember_me" 
                        type="checkbox" 
                        name="remember"
                        class="w-4 h-4 border-slate-300 text-slate-900 focus:ring-0 cursor-pointer">
                    <span class="ml-2 text-slate-600">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" 
                       class="text-slate-600 hover:text-slate-900 transition-colors">
                        Forgot password?
                    </a>
                @endif
            </div>

            <!-- Login Button - Matches Homepage Style -->
            <button 
                type="submit"
                class="w-full px-10 py-4 bg-slate-900 text-white font-medium hover:bg-slate-800 transition-all duration-300 text-base">
                Log in
            </button>
        </form>



        <!-- Security Notice -->
        <div class="mt-12 text-center text-xs text-slate-500 fade-in">
            <p class="font-light">Secure encrypted connection</p>
        </div>
    </div>
</section>

<style>
    .fade-in {
        animation: fadeIn 0.6s ease-out;
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

    /* Remove default input styling */
    input[type="email"],
    input[type="password"] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    /* Prevent iOS zoom */
    @media screen and (max-width: 768px) {
        input[type="email"],
        input[type="password"] {
            font-size: 16px;
        }
    }
</style>

@endsection