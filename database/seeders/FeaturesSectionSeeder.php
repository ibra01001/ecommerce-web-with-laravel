<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FeaturesSection;
use App\Models\FeatureItem;
use App\Models\BrandStorySection;

class FeaturesSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Features Section
        $featuresSection = FeaturesSection::create([
            'section_title' => 'Why Choose Us',
            'section_description' => 'Discover what makes us different',
            'layout_style' => 'grid',
            'columns' => '4',
            'background_color' => '#f8fafc',
            'show_section_title' => false,
            'show_section_description' => false,
            'display_order' => 1,
            'is_active' => true,
        ]);

        // Create Feature Items
        $features = [
            [
                'title' => 'Free Shipping',
                'description' => 'On all orders nationwide',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>',
                'icon_color' => '#0f172a',
                'title_color' => '#0f172a',
                'description_color' => '#475569',
                'display_order' => 0,
            ],
            [
                'title' => 'Premium Quality',
                'description' => 'Carefully crafted materials',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                'icon_color' => '#0f172a',
                'title_color' => '#0f172a',
                'description_color' => '#475569',
                'display_order' => 1,
            ],
            [
                'title' => 'Easy Returns',
                'description' => '30-day return policy',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>',
                'icon_color' => '#0f172a',
                'title_color' => '#0f172a',
                'description_color' => '#475569',
                'display_order' => 2,
            ],
            [
                'title' => 'Secure Payment',
                'description' => 'Safe & encrypted checkout',
                'icon_svg' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>',
                'icon_color' => '#0f172a',
                'title_color' => '#0f172a',
                'description_color' => '#475569',
                'display_order' => 3,
            ],
        ];

        foreach ($features as $feature) {
            FeatureItem::create([
                'features_section_id' => $featuresSection->id,
                'title' => $feature['title'],
                'description' => $feature['description'],
                'icon_type' => 'svg',
                'icon_svg' => $feature['icon_svg'],
                'icon_color' => $feature['icon_color'],
                'title_color' => $feature['title_color'],
                'description_color' => $feature['description_color'],
                'alignment' => 'center',
                'display_order' => $feature['display_order'],
                'is_active' => true,
            ]);
        }

        // Create Brand Story Section
        BrandStorySection::create([
            'title' => 'Crafted with Purpose',
            'description' => 'Every HoodLuxe piece is thoughtfully designed to bring comfort and style together. We believe in quality over quantity, creating hoodies that last.',
            'button_text' => 'Learn More About Us',
            'button_link' => '/about-us',
            'background_color' => '#ffffff',
            'title_color' => '#0f172a',
            'description_color' => '#475569',
            'show_button' => true,
            'is_active' => true,
        ]);
    }
}