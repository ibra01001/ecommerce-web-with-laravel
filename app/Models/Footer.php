<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'about_text',
        'email',
        'phone',
        'address',
        'facebook_url',
        'instagram_url',
        'twitter_url',
        'youtube_url',
        'linkedin_url',
        'tiktok_url',
        'whatsapp_number',
        'working_hours',
        'working_days',
        'copyright_text',
        'terms_url',
        'privacy_url',
        'refund_policy_url',
        'show_newsletter',
        'newsletter_title',
        'newsletter_description',
        'show_social_media',
        'show_contact_info',
        'show_quick_links',
        'custom_links',
        'is_active',
    ];

    protected $casts = [
        'custom_links' => 'array',
        'show_newsletter' => 'boolean',
        'show_social_media' => 'boolean',
        'show_contact_info' => 'boolean',
        'show_quick_links' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get active social media links
     */
    public function getActiveSocialMediaLinks()
    {
        $links = [];

        if ($this->facebook_url) {
            $links['facebook'] = [
                'url' => $this->facebook_url,
                'name' => 'Facebook',
                'icon' => 'facebook'
            ];
        }

        if ($this->instagram_url) {
            $links['instagram'] = [
                'url' => $this->instagram_url,
                'name' => 'Instagram',
                'icon' => 'instagram'
            ];
        }

        if ($this->twitter_url) {
            $links['twitter'] = [
                'url' => $this->twitter_url,
                'name' => 'Twitter',
                'icon' => 'twitter'
            ];
        }

        if ($this->youtube_url) {
            $links['youtube'] = [
                'url' => $this->youtube_url,
                'name' => 'YouTube',
                'icon' => 'youtube'
            ];
        }

        if ($this->linkedin_url) {
            $links['linkedin'] = [
                'url' => $this->linkedin_url,
                'name' => 'LinkedIn',
                'icon' => 'linkedin'
            ];
        }

        if ($this->tiktok_url) {
            $links['tiktok'] = [
                'url' => $this->tiktok_url,
                'name' => 'TikTok',
                'icon' => 'tiktok'
            ];
        }

        if ($this->whatsapp_number) {
            $links['whatsapp'] = [
                'url' => 'https://wa.me/' . preg_replace('/[^0-9]/', '', $this->whatsapp_number),
                'name' => 'WhatsApp',
                'icon' => 'whatsapp'
            ];
        }

        return $links;
    }

    /**
     * Check if any social media link exists
     */
    public function hasSocialMediaLinks()
    {
        return $this->facebook_url || $this->instagram_url || $this->twitter_url || 
               $this->youtube_url || $this->linkedin_url || $this->tiktok_url || 
               $this->whatsapp_number;
    }

    /**
     * Check if contact information exists
     */
    public function hasContactInfo()
    {
        return $this->email || $this->phone || $this->address;
    }
}