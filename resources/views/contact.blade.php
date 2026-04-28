@extends('layouts.app')
@section('title', 'Contact Us — HoodLuxe')
@section('content')

    <!-- Hero Section - Theme Enhanced -->
    <section class="relative pt-32 pb-24 px-6 overflow-hidden"
        style="background: linear-gradient(135deg, var(--background-color) 0%, color-mix(in srgb, var(--primary-color) 5%, var(--background-color)) 100%);">
        <div class="relative max-w-6xl mx-auto text-center space-y-8">
            <!-- Decorative Elements -->
            <div class="absolute top-0 left-1/4 w-64 h-64 rounded-full opacity-10 blur-3xl"
                style="background: var(--primary-color);"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 rounded-full opacity-10 blur-3xl"
                style="background: var(--secondary-color);"></div>

            <!-- Hero Text -->
            <div class="relative space-y-6 fade-in">
                <h1 class="text-5xl md:text-7xl font-light tracking-tight text-theme-text">
                    Get In Touch
                </h1>
                <p class="text-xl md:text-2xl font-light max-w-3xl mx-auto"
                    style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                    We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
            </div>
        </div>
    </section>

<!-- Contact Section -->
    <section class="py-24 px-6">
        <div class="max-w-7xl mx-auto">
            
            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="mb-8 p-6 rounded-2xl fade-in flex items-start gap-4" 
                 style="background: color-mix(in srgb, #10b981 10%, transparent); border-left: 4px solid #10b981;">
                <svg class="w-6 h-6 flex-shrink-0 mt-0.5" style="color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-lg font-medium text-theme-text mb-1">Success!</h3>
                    <p class="text-theme-text font-light">{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-8 p-6 rounded-2xl fade-in flex items-start gap-4" 
                 style="background: color-mix(in srgb, #ef4444 10%, transparent); border-left: 4px solid #ef4444;">
                <svg class="w-6 h-6 flex-shrink-0 mt-0.5" style="color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="text-lg font-medium text-theme-text mb-1">Error</h3>
                    <p class="text-theme-text font-light">{{ session('error') }}</p>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-8 p-6 rounded-2xl fade-in" 
                 style="background: color-mix(in srgb, #ef4444 10%, transparent); border-left: 4px solid #ef4444;">
                <div class="flex items-start gap-4">
                    <svg class="w-6 h-6 flex-shrink-0 mt-0.5" style="color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-lg font-medium text-theme-text mb-2">Please correct the following errors:</h3>
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                            <li class="text-theme-text font-light">• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endif

            <div class="grid lg:grid-cols-2 gap-16">

                <!-- Contact Form -->
                <div class="fade-in space-y-8">
                    <div class="space-y-4">
                        <h2 class="text-3xl md:text-4xl font-light tracking-tight text-theme-text">
                            Send us a Message
                        </h2>
                        <p class="text-lg font-light"
                            style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                            Fill out the form below and we'll get back to you within 24 hours.
                        </p>
                    </div>

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div class="space-y-2 contact-input-group">
                            <label for="name" class="block text-sm font-medium text-theme-text uppercase tracking-wider">
                                Full Name <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   required
                                   class="w-full px-6 py-4 border-2 text-theme-text focus:outline-none transition-all duration-300 @error('name') border-red-500 @else border-transparent @enderror"
                                   style="background: color-mix(in srgb, var(--primary-color) 3%, transparent); border-radius: 0.5rem;"
                                   onfocus="this.style.borderColor='var(--primary-color)'"
                                   onblur="this.style.borderColor='{{ $errors->has('name') ? '#ef4444' : 'transparent' }}'"
                                   value="{{ old('name') }}">
                            @error('name')
                            <p class="text-sm font-light" style="color: #ef4444;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2 contact-input-group">
                            <label for="email" class="block text-sm font-medium text-theme-text uppercase tracking-wider">
                                Email Address <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   required
                                   class="w-full px-6 py-4 border-2 text-theme-text focus:outline-none transition-all duration-300 @error('email') border-red-500 @else border-transparent @enderror"
                                   style="background: color-mix(in srgb, var(--primary-color) 3%, transparent); border-radius: 0.5rem;"
                                   onfocus="this.style.borderColor='var(--primary-color)'"
                                   onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : 'transparent' }}'"
                                   value="{{ old('email') }}">
                            @error('email')
                            <p class="text-sm font-light" style="color: #ef4444;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="space-y-2 contact-input-group">
                            <label for="phone" class="block text-sm font-medium text-theme-text uppercase tracking-wider">
                                Phone Number <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone"
                                   required
                                   class="w-full px-6 py-4 border-2 text-theme-text focus:outline-none transition-all duration-300 @error('phone') border-red-500 @else border-transparent @enderror"
                                   style="background: color-mix(in srgb, var(--primary-color) 3%, transparent); border-radius: 0.5rem;"
                                   onfocus="this.style.borderColor='var(--primary-color)'"
                                   onblur="this.style.borderColor='{{ $errors->has('phone') ? '#ef4444' : 'transparent' }}'"
                                   value="{{ old('phone') }}"
                                   maxlength="10"
                                   placeholder="{{ $footer?->phone }}">
                            @error('phone')
                            <p class="text-sm font-light" style="color: #ef4444;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Subject -->
                        <div class="space-y-2 contact-input-group">
                            <label for="subject" class="block text-sm font-medium text-theme-text uppercase tracking-wider">
                                Subject <span style="color: #ef4444;">*</span>
                            </label>
                            <input type="text" 
                                   id="subject" 
                                   name="subject" 
                                   required
                                   class="w-full px-6 py-4 border-2 text-theme-text focus:outline-none transition-all duration-300 @error('subject') border-red-500 @else border-transparent @enderror"
                                   style="background: color-mix(in srgb, var(--primary-color) 3%, transparent); border-radius: 0.5rem;"
                                   onfocus="this.style.borderColor='var(--primary-color)'"
                                   onblur="this.style.borderColor='{{ $errors->has('subject') ? '#ef4444' : 'transparent' }}'"
                                   value="{{ old('subject') }}">
                            @error('subject')
                            <p class="text-sm font-light" style="color: #ef4444;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div class="space-y-2 contact-input-group">
                            <label for="message" class="block text-sm font-medium text-theme-text uppercase tracking-wider">
                                Message <span style="color: #ef4444;">*</span>
                            </label>
                            <textarea id="message" 
                                      name="message" 
                                      rows="6" 
                                      required
                                      class="w-full px-6 py-4 border-2 text-theme-text focus:outline-none transition-all duration-300 resize-none @error('message') border-red-500 @else border-transparent @enderror"
                                      style="background: color-mix(in srgb, var(--primary-color) 3%, transparent); border-radius: 0.5rem;"
                                      onfocus="this.style.borderColor='var(--primary-color)'"
                                      onblur="this.style.borderColor='{{ $errors->has('message') ? '#ef4444' : 'transparent' }}'">{{ old('message') }}</textarea>
                            @error('message')
                            <p class="text-sm font-light" style="color: #ef4444;">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full px-10 py-4 text-white font-medium rounded-full transition-all duration-300 text-base group flex items-center justify-center gap-3"
                            style="background: var(--primary-color);"
                            onmouseover="this.style.background='var(--secondary-color)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 20px 40px -12px color-mix(in srgb, var(--primary-color) 30%, transparent)'"
                            onmouseout="this.style.background='var(--primary-color)'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            Send Message
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </form>
                </div>

               

                <!-- Contact Information -->
                <div class="space-y-8 fade-in lg:pl-8">
                    <div class="space-y-4">
                        <h2 class="text-3xl md:text-4xl font-light tracking-tight text-theme-text">
                            Contact Information
                        </h2>
                        <p class="text-lg font-light"
                            style="color: color-mix(in srgb, var(--text-color) 70%, transparent);">
                            Reach out to us through any of these channels.
                        </p>
                    </div>
                    @if($footer)
                    <!-- Contact Cards -->
                    <div class="space-y-6">
                        <!-- Email Card -->
                        @if($footer?->email)
                        <div class="contact-card p-8 border-2 border-transparent transition-all duration-300"
                            style="background: color-mix(in srgb, var(--primary-color) 3%, transparent); border-radius: 1rem;">
                            <div class="flex items-start gap-6">
                                <div class="flex-shrink-0 w-14 h-14 rounded-full flex items-center justify-center"
                                    style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                                    <svg class="w-7 h-7 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="space-y-2">
                                    <h3 class="text-lg font-medium text-theme-text">Email</h3>
                                    <a href="mailto:{{ $footer?->email }}"
                                        class="text-base font-light text-theme-primary hover:text-theme-secondary transition-colors">
                                        {{ $footer?->email }}
                                    </a>

                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Phone Card -->
                        @if($footer?->phone)
                        <div class="contact-card p-8 border-2 border-transparent transition-all duration-300"
                            style="background: color-mix(in srgb, var(--primary-color) 3%, transparent); border-radius: 1rem;">
                            <div class="flex items-start gap-6">
                                <div class="flex-shrink-0 w-14 h-14 rounded-full flex items-center justify-center"
                                    style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                                    <svg class="w-7 h-7 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div class="space-y-2">
                                    <h3 class="text-lg font-medium text-theme-text">Phone</h3>
                                    <a href="tel:{{ $footer?->phone }}"
                                        class="text-base font-light text-theme-primary hover:text-theme-secondary transition-colors">
                                        {{ $footer?->phone }}
                                    </a>

                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Address Card -->
                        @if($footer?->address)
                        <div class="contact-card p-8 border-2 border-transparent transition-all duration-300"
                            style="background: color-mix(in srgb, var(--primary-color) 3%, transparent); border-radius: 1rem;">
                            <div class="flex items-start gap-6">
                                <div class="flex-shrink-0 w-14 h-14 rounded-full flex items-center justify-center"
                                    style="background: color-mix(in srgb, var(--primary-color) 10%, transparent);">
                                    <svg class="w-7 h-7 text-theme-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="space-y-2">
                                    <h3 class="text-lg font-medium text-theme-text">Visit Us</h3>
                                    <p class="text-base font-light text-theme-text">
                                        {{ $footer?->address }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Social Media Card -->
                       
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>



    <!-- Additional Styling -->
    <style>
        /* Fade-in Animation */
        .fade-in {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Stagger animation delays */
        .contact-input-group:nth-child(1) { animation-delay: 0.1s; }
        .contact-input-group:nth-child(2) { animation-delay: 0.2s; }
        .contact-input-group:nth-child(3) { animation-delay: 0.3s; }
        .contact-input-group:nth-child(4) { animation-delay: 0.4s; }
        .contact-input-group:nth-child(5) { animation-delay: 0.5s; }

        /* Contact Cards Hover Effects */
        .contact-card:hover {
            border-color: var(--primary-color) !important;
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -12px color-mix(in srgb, var(--primary-color) 20%, transparent);
        }

        /* Social Icons Hover */
        .social-icon:hover {
            background: var(--primary-color) !important;
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 10px 25px -8px color-mix(in srgb, var(--primary-color) 40%, transparent);
        }

        .social-icon:hover svg {
            color: white !important;
        }

        /* FAQ Items Hover */
        .faq-item:hover {
            border-color: var(--primary-color) !important;
            transform: translateX(8px);
            box-shadow: -4px 0 0 0 var(--primary-color);
        }

        /* Input Focus Effects */
        input:focus, textarea:focus {
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--primary-color) 10%, transparent);
        }

        /* Smooth transitions */
        * {
            transition-property: background-color, border-color, color, transform, box-shadow;
            transition-duration: 0.3s;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Button Hover Animation */
        button[type="submit"] {
            position: relative;
            overflow: hidden;
        }

        button[type="submit"]::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: color-mix(in srgb, white 20%, transparent);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        button[type="submit"]:hover::before {
            width: 300px;
            height: 300px;
        }
    </style>

@endsection