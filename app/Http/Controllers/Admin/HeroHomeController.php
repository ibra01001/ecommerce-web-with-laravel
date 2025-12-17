<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroHomePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroHomeController extends Controller
{
    public function edit()
    {
        $heroSection = HeroHomePage::first();
        
        if (!$heroSection) {
            $heroSection = HeroHomePage::create([
                'heading' => 'Welcome to Our Store',
                'subheading' => 'Discover Amazing Products',
                'content' => 'Shop the latest collection of premium products at unbeatable prices.',
                'background_type' => 'image',
                'is_active' => true,
            ]);
        }
        
        return view('admin.hero-home.edit', compact('heroSection'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'heading' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'background_type' => 'required|in:image,video',
            'background_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'background_video' => 'nullable|mimes:mp4,webm,ogg|max:20480',
            'primary_button_text' => 'nullable|string|max:100',
            'primary_button_link' => 'nullable|string|max:255',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_link' => 'nullable|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        $heroSection = HeroHomePage::first();
        
        if (!$heroSection) {
            $heroSection = new HeroHomePage();
        }

        $backgroundType = $request->input('background_type');
        $heroSection->background_type = $backgroundType;

        if ($backgroundType === 'image' && $request->hasFile('background_image')) {
            if ($heroSection->background_image_path) {
                Storage::disk('public')->delete($heroSection->background_image_path);
            }
            if ($heroSection->background_video_path) {
                Storage::disk('public')->delete($heroSection->background_video_path);
                $heroSection->background_video_path = null;
            }
            
            $path = $request->file('background_image')->store('hero_backgrounds', 'public');
            $heroSection->background_image_path = $path;
        }

        if ($backgroundType === 'video' && $request->hasFile('background_video')) {
            if ($heroSection->background_video_path) {
                Storage::disk('public')->delete($heroSection->background_video_path);
            }
            if ($heroSection->background_image_path) {
                Storage::disk('public')->delete($heroSection->background_image_path);
                $heroSection->background_image_path = null;
            }
            
            $path = $request->file('background_video')->store('hero_backgrounds', 'public');
            $heroSection->background_video_path = $path;
        }

        $heroSection->heading = $request->input('heading');
        $heroSection->subheading = $request->input('subheading');
        $heroSection->content = $request->input('content');
        $heroSection->primary_button_text = $request->input('primary_button_text');
        $heroSection->primary_button_link = $request->input('primary_button_link');
        $heroSection->secondary_button_text = $request->input('secondary_button_text');
        $heroSection->secondary_button_link = $request->input('secondary_button_link');
        $heroSection->is_active = $request->has('is_active');

        $heroSection->save();

        return redirect()->route('admin.hero-home.edit')
            ->with('success', 'Hero section updated successfully!');
    }
}