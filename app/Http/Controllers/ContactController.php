<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;


use App\Models\Footer;

class ContactController extends Controller
{
    public function contact()
    {
        $footer = Footer::where('is_active', true)->first();
        return view('contact', compact('footer'));
    }
    public function store(Request $request)
    {
        $key = 'contact-message:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', 'Too many contact attempts. Please try again in ' . ceil($seconds / 60) . 'minutes.');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:10',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000',
        ]);

        $contact = ContactMessage::create($validated);
        RateLimiter::hit($key, 3600 * 3);

        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}