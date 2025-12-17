<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeaturesSection;
use App\Models\FeatureItem;
use App\Models\BrandStorySection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminFeaturesController extends Controller
{
    // ============================================
    // Features Section Management
    // ============================================
    
    public function editFeatures()
    {
        $featuresSection = FeaturesSection::with('items')->first();
        
        // Create default if doesn't exist
        if (!$featuresSection) {
            $featuresSection = FeaturesSection::create([
                'section_title' => 'Why Choose Us',
                'layout_style' => 'grid',
                'columns' => '4',
                'background_color' => '#f8fafc',
            ]);
        }
        
        return view('admin.features.edit', compact('featuresSection'));
    }

    public function updateFeatures(Request $request)
    {
        $validated = $request->validate([
            'section_title' => 'required|string|max:255',
            'section_description' => 'nullable|string',
            'layout_style' => 'required|in:grid,carousel,list',
            'columns' => 'required|in:2,3,4',
            'background_color' => 'required|string|max:20',
            'show_section_title' => 'boolean',
            'show_section_description' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $featuresSection = FeaturesSection::first();
        
        if (!$featuresSection) {
            $featuresSection = new FeaturesSection();
        }

        $featuresSection->fill($validated);
        $featuresSection->show_section_title = $request->has('show_section_title');
        $featuresSection->show_section_description = $request->has('show_section_description');
        $featuresSection->is_active = $request->has('is_active');
        $featuresSection->save();

        return redirect()->route('admin.features.edit')
            ->with('success', 'Features section updated successfully!');
    }

    // ============================================
    // Feature Items Management
    // ============================================

    public function createItem()
    {
        $featuresSection = FeaturesSection::first();
        
        if (!$featuresSection) {
            return redirect()->route('admin.features.edit')
                ->with('error', 'Please configure the features section first.');
        }
        
        // Get default SVG icons library
        $defaultIcons = $this->getDefaultIcons();
        
        return view('admin.features.items.create', compact('featuresSection', 'defaultIcons'));
    }

    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon_type' => 'required|in:svg,svg_upload,image,emoji',
            'icon_svg' => 'required_if:icon_type,svg',
            'icon_svg_file' => 'required_if:icon_type,svg_upload|nullable|file|mimes:svg|max:2048',
            'icon_image' => 'required_if:icon_type,image|nullable|image|max:2048',
            'icon_emoji' => 'required_if:icon_type,emoji|nullable|string|max:10',
            'icon_color' => 'required|string|max:20',
            'title_color' => 'required|string|max:20',
            'description_color' => 'required|string|max:20',
            'alignment' => 'required|in:left,center,right',
            'link_url' => 'nullable|string|max:255',
            'link_text' => 'nullable|string|max:100',
            'open_in_new_tab' => 'boolean',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $featuresSection = FeaturesSection::first();
        
        if (!$featuresSection) {
            return redirect()->route('admin.features.edit')
                ->with('error', 'Features section not found.');
        }

        // Handle SVG file upload - STORE THE FILE PATH
        if ($request->hasFile('icon_svg_file')) {
            $validated['icon_svg_path'] = $request->file('icon_svg_file')
                ->store('features/icons/svg', 'public');
            // Don't change icon_type - keep it as svg_upload
        }

        // Handle custom SVG input (for preset or custom SVG code)
        if ($request->filled('icon_svg_custom')) {
            $validated['icon_svg'] = $request->icon_svg_custom;
        }

        // Handle icon image upload
        if ($request->hasFile('icon_image')) {
            $validated['icon_image_path'] = $request->file('icon_image')
                ->store('features/icons', 'public');
        }

        $validated['features_section_id'] = $featuresSection->id;
        $validated['open_in_new_tab'] = $request->has('open_in_new_tab');
        $validated['is_active'] = $request->has('is_active');
        
        // Set display order to last if not specified
        if (!isset($validated['display_order'])) {
            $validated['display_order'] = $featuresSection->items()->max('display_order') + 1;
        }

        FeatureItem::create($validated);

        return redirect()->route('admin.features.edit')
            ->with('success', 'Feature item added successfully!');
    }

    public function editItem(FeatureItem $item)
    {
        $defaultIcons = $this->getDefaultIcons();
        return view('admin.features.items.edit', compact('item', 'defaultIcons'));
    }

    public function updateItem(Request $request, FeatureItem $item)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon_type' => 'required|in:svg,svg_upload,image,emoji',
            'icon_svg' => 'required_if:icon_type,svg',
            'icon_svg_file' => 'nullable|file|mimes:svg|max:2048',
            'icon_image' => 'nullable|image|max:2048',
            'icon_emoji' => 'required_if:icon_type,emoji|nullable|string|max:10',
            'icon_color' => 'required|string|max:20',
            'title_color' => 'required|string|max:20',
            'description_color' => 'required|string|max:20',
            'alignment' => 'required|in:left,center,right',
            'link_url' => 'nullable|string|max:255',
            'link_text' => 'nullable|string|max:100',
            'open_in_new_tab' => 'boolean',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Handle SVG file upload - STORE THE FILE PATH
        if ($request->hasFile('icon_svg_file')) {
            // Delete old SVG file if exists
            if ($item->icon_svg_path) {
                Storage::disk('public')->delete($item->icon_svg_path);
            }
            $validated['icon_svg_path'] = $request->file('icon_svg_file')
                ->store('features/icons/svg', 'public');
            // Don't change icon_type - keep it as svg_upload
        }

        // Handle custom SVG input
        if ($request->filled('icon_svg_custom')) {
            $validated['icon_svg'] = $request->icon_svg_custom;
        }

        // Handle icon image upload
        if ($request->hasFile('icon_image')) {
            // Delete old icon image if exists
            if ($item->icon_image_path) {
                Storage::disk('public')->delete($item->icon_image_path);
            }
            $validated['icon_image_path'] = $request->file('icon_image')
                ->store('features/icons', 'public');
        }

        $validated['open_in_new_tab'] = $request->has('open_in_new_tab');
        $validated['is_active'] = $request->has('is_active');

        $item->update($validated);

        return redirect()->route('admin.features.edit')
            ->with('success', 'Feature item updated successfully!');
    }

    public function deleteItem(FeatureItem $item)
    {
        // Delete icon image if exists
        if ($item->icon_image_path) {
            Storage::disk('public')->delete($item->icon_image_path);
        }
        
        // Delete SVG file if exists
        if ($item->icon_svg_path) {
            Storage::disk('public')->delete($item->icon_svg_path);
        }

        $item->delete();

        return redirect()->route('admin.features.edit')
            ->with('success', 'Feature item deleted successfully!');
    }

    public function reorderItems(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:feature_items,id',
            'items.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->items as $itemData) {
            FeatureItem::where('id', $itemData['id'])
                ->update(['display_order' => $itemData['order']]);
        }

        return response()->json(['success' => true]);
    }

    // ============================================
    // Brand Story Section Management
    // ============================================

    public function editBrandStory()
    {
        $brandStory = BrandStorySection::first();
        
        // Create default if doesn't exist
        if (!$brandStory) {
            $brandStory = BrandStorySection::create([
                'title' => 'Crafted with Purpose',
                'description' => 'Every piece is thoughtfully designed to bring comfort and style together. We believe in quality over quantity, creating products that last.',
                'button_text' => 'Learn More About Us',
                'button_link' => '/about-us',
                'background_color' => '#ffffff',
            ]);
        }
        
        return view('admin.features.brand-story.edit', compact('brandStory'));
    }

    public function updateBrandStory(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'background_color' => 'required|string|max:20',
            'title_color' => 'required|string|max:20',
            'description_color' => 'required|string|max:20',
            'show_button' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $brandStory = BrandStorySection::first();
        
        if (!$brandStory) {
            $brandStory = new BrandStorySection();
        }

        $brandStory->fill($validated);
        $brandStory->show_button = $request->has('show_button');
        $brandStory->is_active = $request->has('is_active');
        $brandStory->save();

        return redirect()->route('admin.brand-story.edit')
            ->with('success', 'Brand story section updated successfully!');
    }

    // ============================================
    // Helper Methods
    // ============================================

    private function getDefaultIcons()
    {
        return [
            'shipping' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>',
            'quality' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
            'returns' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>',
            'payment' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>',
            'support' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>',
            'fast_delivery' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
            'eco' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'gift' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>',
        ];
    }
}