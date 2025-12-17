<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Footer;
use Illuminate\Http\Request;

class AdminFooterController extends Controller
{
    /**
     * Show the footer settings form
     */
    public function edit()
    {
        $footer = Footer::first();

        // Create default footer if none exists
        if (!$footer) {
            $footer = Footer::create([
                'business_name' => config('app.name'),
                'about_text' => 'We are your trusted online store for quality products.',
                'copyright_text' => '© ' . date('Y') . ' ' . config('app.name') . '. All rights reserved.',
                'newsletter_title' => 'Subscribe to our Newsletter',
                'newsletter_description' => 'Get the latest updates on new products and upcoming sales.',
                'show_newsletter' => true,
                'show_social_media' => true,
                'show_contact_info' => true,
                'show_quick_links' => true,
                'is_active' => true,
            ]);
        }

        return view('admin.footer.edit', compact('footer'));
    }

    /**
     * Update footer settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'business_name' => 'nullable|string|max:255',
            'about_text' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'whatsapp_number' => 'nullable|string|max:50',
            'working_hours' => 'nullable|string|max:255',
            'working_days' => 'nullable|string|max:255',
            'copyright_text' => 'nullable|string|max:255',
            'terms_url' => 'nullable|string|max:255',
            'privacy_url' => 'nullable|string|max:255',
            'refund_policy_url' => 'nullable|string|max:255',
            'newsletter_title' => 'nullable|string|max:255',
            'newsletter_description' => 'nullable|string|max:500',
            'show_newsletter' => 'nullable|boolean',
            'show_social_media' => 'nullable|boolean',
            'show_contact_info' => 'nullable|boolean',
            'show_quick_links' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $footer = Footer::first();

        if (!$footer) {
            $footer = new Footer();
        }

        // Update all fields
        $footer->business_name = $request->input('business_name');
        $footer->about_text = $request->input('about_text');
        $footer->email = $request->input('email');
        $footer->phone = $request->input('phone');
        $footer->address = $request->input('address');
        $footer->facebook_url = $request->input('facebook_url');
        $footer->instagram_url = $request->input('instagram_url');
        $footer->twitter_url = $request->input('twitter_url');
        $footer->youtube_url = $request->input('youtube_url');
        $footer->linkedin_url = $request->input('linkedin_url');
        $footer->tiktok_url = $request->input('tiktok_url');
        $footer->whatsapp_number = $request->input('whatsapp_number');
        $footer->working_hours = $request->input('working_hours');
        $footer->working_days = $request->input('working_days');
        $footer->copyright_text = $request->input('copyright_text');
        $footer->terms_url = $request->input('terms_url');
        $footer->privacy_url = $request->input('privacy_url');
        $footer->refund_policy_url = $request->input('refund_policy_url');
        $footer->newsletter_title = $request->input('newsletter_title');
        $footer->newsletter_description = $request->input('newsletter_description');
        $footer->show_newsletter = $request->has('show_newsletter');
        $footer->show_social_media = $request->has('show_social_media');
        $footer->show_contact_info = $request->has('show_contact_info');
        $footer->show_quick_links = $request->has('show_quick_links');
        $footer->is_active = $request->has('is_active');

        $footer->save();

        return redirect()->route('admin.footer.edit')
            ->with('success', 'Footer settings updated successfully!');
    }
}