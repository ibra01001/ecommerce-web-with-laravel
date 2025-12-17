@extends('admin.layout')

@section('title', 'Footer Settings')

@section('content')
<div class="flex justify-between items-center mb-8 fade-in">
    <h2 class="text-3xl font-light text-slate-900 flex items-center gap-3">
        <svg class="w-8 h-8 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7.5L7.5 3m0 0L12 7.5M7.5 3v13.5m13.5 0L16.5 21m0 0L12 16.5m4.5 4.5V7.5"/>
        </svg>
        Footer Settings
    </h2>

    <a href="{{ route('home') }}" target="_blank"
       class="flex items-center gap-2 text-slate-600 hover:text-slate-900 transition-colors duration-300 font-medium">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        </svg>
        Preview Homepage
    </a>
</div>

@if(session('success'))
<div class="mb-6 bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-2xl flex items-center gap-3 fade-in">
    <svg class="w-6 h-6 text-green-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    </svg>
    <span class="font-medium">{{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div class="mb-6 bg-red-50 border-2 border-red-200 text-red-800 px-6 py-4 rounded-2xl fade-in">
    <div class="flex items-start gap-3">
        <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
            <li class="font-medium">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<form action="{{ route('admin.footer.update') }}" method="POST" 
      class="space-y-8 max-w-7xl">
    @csrf
    @method('PUT')

    <!-- Business Information -->
    <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm fade-in">
        <h3 class="text-2xl font-light text-slate-900 mb-6 flex items-center gap-3">
            <svg class="w-7 h-7 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            Business Information
        </h3>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-slate-700 font-medium mb-3">Business Name</label>
                <input type="text" name="business_name" 
                       value="{{ old('business_name', $footer->business_name ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="Your Business Name">
            </div>

            <div class="md:col-span-2">
                <label class="block text-slate-700 font-medium mb-3">About Text</label>
                <textarea name="about_text" rows="3"
                          class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-light
                                 focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
                          placeholder="Brief description about your business...">{{ old('about_text', $footer->about_text ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <!-- Contact Information -->
    <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm fade-in">
        <h3 class="text-2xl font-light text-slate-900 mb-6 flex items-center gap-3">
            <svg class="w-7 h-7 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Contact Information
        </h3>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-slate-700 font-medium mb-3">Email Address</label>
                <input type="email" name="email" 
                       value="{{ old('email', $footer->email ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="contact@example.com">
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-3">Phone Number</label>
                <input type="text" name="phone" 
                       value="{{ old('phone', $footer->phone ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="+213 555 123 456">
            </div>

            <div class="md:col-span-2">
                <label class="block text-slate-700 font-medium mb-3">Business Address</label>
                <textarea name="address" rows="2"
                          class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-light
                                 focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
                          placeholder="123 Street Name, City, Country">{{ old('address', $footer->address ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-3">Working Hours</label>
                <input type="text" name="working_hours" 
                       value="{{ old('working_hours', $footer->working_hours ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="9:00 AM - 6:00 PM">
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-3">Working Days</label>
                <input type="text" name="working_days" 
                       value="{{ old('working_days', $footer->working_days ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="Monday - Saturday">
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <input type="checkbox" name="show_contact_info" value="1"
                   {{ old('show_contact_info', $footer->show_contact_info ?? true) ? 'checked' : '' }}
                   class="w-5 h-5 rounded border-slate-300 bg-white text-slate-900
                          focus:ring-slate-900 focus:ring-offset-0 focus:ring-2 cursor-pointer">
            <label class="text-slate-700 font-medium cursor-pointer">Display contact information in footer</label>
        </div>
    </div>

    <!-- Social Media Links -->
    <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm fade-in">
        <h3 class="text-2xl font-light text-slate-900 mb-6 flex items-center gap-3">
            <svg class="w-7 h-7 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
            Social Media Links
        </h3>

        <div class="grid md:grid-cols-2 gap-6">
            <div>
                <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </label>
                <input type="url" name="facebook_url" 
                       value="{{ old('facebook_url', $footer->facebook_url ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="https://facebook.com/yourpage">
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    Instagram
                </label>
                <input type="url" name="instagram_url" 
                       value="{{ old('instagram_url', $footer->instagram_url ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="https://instagram.com/yourpage">
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                    Twitter
                </label>
                <input type="url" name="twitter_url" 
                       value="{{ old('twitter_url', $footer->twitter_url ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="https://twitter.com/yourpage">
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                    </svg>
                    YouTube
                </label>
                <input type="url" name="youtube_url" 
                       value="{{ old('youtube_url', $footer->youtube_url ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="https://youtube.com/yourchannel">
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    LinkedIn
                </label>
                <input type="url" name="linkedin_url" 
                       value="{{ old('linkedin_url', $footer->linkedin_url ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="https://linkedin.com/company/yourcompany">
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                    </svg>
                    TikTok
                </label>
                <input type="url" name="tiktok_url" 
                       value="{{ old('tiktok_url', $footer->tiktok_url ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="https://tiktok.com/@yourpage">
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    WhatsApp
                </label>
                <input type="text" name="whatsapp_number" 
                       value="{{ old('whatsapp_number', $footer->whatsapp_number ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="+213555123456">
                <p class="text-slate-500 text-sm mt-2 font-light">Enter number with country code (no spaces or dashes)</p>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <input type="checkbox" name="show_social_media" value="1"
                   {{ old('show_social_media', $footer->show_social_media ?? true) ? 'checked' : '' }}
                   class="w-5 h-5 rounded border-slate-300 bg-white text-slate-900
                          focus:ring-slate-900 focus:ring-offset-0 focus:ring-2 cursor-pointer">
            <label class="text-slate-700 font-medium cursor-pointer">Display social media links in footer</label>
        </div>
    </div>

    <!-- Newsletter Section -->
    <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm fade-in">
        <h3 class="text-2xl font-light text-slate-900 mb-6 flex items-center gap-3">
            <svg class="w-7 h-7 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Newsletter Settings
        </h3>

        <div class="space-y-6">
            <div>
                <label class="block text-slate-700 font-medium mb-3">Newsletter Title</label>
                <input type="text" name="newsletter_title" 
                       value="{{ old('newsletter_title', $footer->newsletter_title ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="Subscribe to our Newsletter">
            </div>

            <div>
                <label class="block text-slate-700 font-medium mb-3">Newsletter Description</label>
                <textarea name="newsletter_description" rows="2"
                          class="w-full bg-white border-2 border-slate-200 rounded-2xl px-4 py-3 text-slate-900 font-light
                                 focus:outline-none focus:border-slate-900 transition-all duration-300 resize-none"
                          placeholder="Get the latest updates...">{{ old('newsletter_description', $footer->newsletter_description ?? '') }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-3">
            <input type="checkbox" name="show_newsletter" value="1"
                   {{ old('show_newsletter', $footer->show_newsletter ?? true) ? 'checked' : '' }}
                   class="w-5 h-5 rounded border-slate-300 bg-white text-slate-900
                          focus:ring-slate-900 focus:ring-offset-0 focus:ring-2 cursor-pointer">
            <label class="text-slate-700 font-medium cursor-pointer">Display newsletter signup in footer</label>
        </div>
    </div>

    <!-- Copyright & Legal -->
    <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm fade-in">
        <h3 class="text-2xl font-light text-slate-900 mb-6 flex items-center gap-3">
            <svg class="w-7 h-7 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Copyright & Legal
        </h3>

        <div class="space-y-6">
            <div>
                <label class="block text-slate-700 font-medium mb-3">Copyright Text</label>
                <input type="text" name="copyright_text" 
                       value="{{ old('copyright_text', $footer->copyright_text ?? '') }}"
                       class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                              focus:outline-none focus:border-slate-900 transition-all duration-300"
                       placeholder="© 2025 Your Business. All rights reserved.">
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-slate-700 font-medium mb-3">Terms & Conditions URL</label>
                    <input type="text" name="terms_url" 
                           value="{{ old('terms_url', $footer->terms_url ?? '') }}"
                           class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                                  focus:outline-none focus:border-slate-900 transition-all duration-300"
                           placeholder="/terms">
                </div>

                <div>
                    <label class="block text-slate-700 font-medium mb-3">Privacy Policy URL</label>
                    <input type="text" name="privacy_url" 
                           value="{{ old('privacy_url', $footer->privacy_url ?? '') }}"
                           class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                                  focus:outline-none focus:border-slate-900 transition-all duration-300"
                           placeholder="/privacy">
                </div>

                <div>
                    <label class="block text-slate-700 font-medium mb-3">Refund Policy URL</label>
                    <input type="text" name="refund_policy_url" 
                           value="{{ old('refund_policy_url', $footer->refund_policy_url ?? '') }}"
                           class="w-full bg-white border-2 border-slate-200 rounded-full px-4 py-3 text-slate-900 font-light
                                  focus:outline-none focus:border-slate-900 transition-all duration-300"
                           placeholder="/refund-policy">
                </div>
            </div>
        </div>
    </div>

    <!-- Active Status -->
    <div class="bg-white p-8 rounded-2xl border-2 border-slate-200 shadow-sm fade-in">
        <div class="flex items-center gap-3">
            <input type="checkbox" name="is_active" value="1"
                   {{ old('is_active', $footer->is_active ?? true) ? 'checked' : '' }}
                   class="w-5 h-5 rounded border-slate-300 bg-white text-slate-900
                          focus:ring-slate-900 focus:ring-offset-0 focus:ring-2 cursor-pointer">
            <label class="text-slate-700 font-medium cursor-pointer">Footer is Active (visible on website)</label>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="pt-8 flex gap-4 fade-in">
        <button type="submit" 
                class="flex items-center gap-2 bg-slate-900 text-white px-8 py-4 rounded-full font-medium text-base
                       hover:bg-slate-800 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Update Footer Settings
        </button>
        
        <a href="{{ route('home') }}" target="_blank"
           class="flex items-center gap-2 border-2 border-slate-200 text-slate-900 px-8 py-4 rounded-full font-medium text-base
                  hover:border-slate-900 transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            View Live Site
        </a>
    </div>
</form>

<style>
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

    .fade-in {
        opacity: 0;
        animation: fadeIn 0.6s ease-out forwards;
    }

    .fade-in:nth-child(2) { animation-delay: 0.1s; }
    .fade-in:nth-child(3) { animation-delay: 0.2s; }
    .fade-in:nth-child(4) { animation-delay: 0.3s; }
    .fade-in:nth-child(5) { animation-delay: 0.4s; }
    .fade-in:nth-child(6) { animation-delay: 0.5s; }
</style>
@endsection