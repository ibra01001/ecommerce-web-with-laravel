<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLogoAndThemeController extends Controller
{
    public function settings()
    {
        $logo = Logo::first();
        if (!$logo) {
            $logo = Logo::create([
                'name' => 'Site Logo',
                'custom_logo_path' => null,
                'dark_logo_path' => null
            ]);
        }

        // Get all themes grouped by mode
        $themes = Theme::orderBy('mode')->orderBy('id')->get();
        
        // Get active themes for both modes
        $activeLightTheme = Theme::getActiveLight();
        $activeDarkTheme = Theme::getActiveDark();
        
        // Get current active theme based on admin's session
        $activeTheme = Theme::getActive();

        return view('admin.appearance.settings', compact(
            'logo', 
            'themes', 
            'activeTheme',
            'activeLightTheme',
            'activeDarkTheme'
        ));
    }

    public function uploadLightLogo(Request $request)
    {
        $request->validate([
            'custom_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $logo = Logo::first();
        if (!$logo) {
            $logo = new Logo();
            $logo->name = 'Site Logo';
        }

        // Delete old logo if exists
        if ($logo->custom_logo_path && Storage::disk('public')->exists($logo->custom_logo_path)) {
            Storage::disk('public')->delete($logo->custom_logo_path);
        }

        // Store new logo
        $path = $request->file('custom_logo')->store('logos', 'public');
        $logo->custom_logo_path = $path;
        $logo->save();

        return redirect()->back()->with('success', 'Light mode logo uploaded successfully!');
    }

    public function uploadDarkLogo(Request $request)
    {
        $request->validate([
            'dark_mode_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
        ]);

        $logo = Logo::first();
        if (!$logo) {
            $logo = new Logo();
            $logo->name = 'Site Logo';
        }

        // Delete old logo if exists
        if ($logo->dark_logo_path && Storage::disk('public')->exists($logo->dark_logo_path)) {
            Storage::disk('public')->delete($logo->dark_logo_path);
        }

        // Store new logo
        $path = $request->file('dark_mode_logo')->store('logos', 'public');
        $logo->dark_logo_path = $path;
        $logo->save();

        return redirect()->back()->with('success', 'Dark mode logo uploaded successfully!');
    }

    public function deleteLogo(Request $request)
    {
        $logo = Logo::first();
        
        if (!$logo) {
            return redirect()->back()->with('error', 'No logo found.');
        }

        $type = $request->input('type', 'light');

        if ($type === 'dark') {
            if ($logo->dark_logo_path) {
                if (Storage::disk('public')->exists($logo->dark_logo_path)) {
                    Storage::disk('public')->delete($logo->dark_logo_path);
                }
                $logo->dark_logo_path = null;
                $logo->save();
                return redirect()->back()->with('success', 'Dark mode logo deleted successfully!');
            }
            return redirect()->back()->with('error', 'No dark mode logo to delete.');
        } else {
            if ($logo->custom_logo_path) {
                if (Storage::disk('public')->exists($logo->custom_logo_path)) {
                    Storage::disk('public')->delete($logo->custom_logo_path);
                }
                $logo->custom_logo_path = null;
                $logo->save();
                return redirect()->back()->with('success', 'Light mode logo deleted successfully!');
            }
            return redirect()->back()->with('error', 'No light mode logo to delete.');
        }
    }

    public function createTheme(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'mode' => 'required|in:light,dark',
            // Add other validation as needed
        ]);

        // Enforce max 4 themes
        if (Theme::query()->count() >= 4) {
            return redirect()->back()->with('error', 'Maximum of 4 themes allowed.');
        }

        // Only allow up to 2 themes per mode (optional, but not required by your spec)
        // $modeCount = Theme::where('mode', $request->mode)->count();
        // if ($modeCount >= 2) {
        //     return redirect()->back()->with('error', 'Maximum of 2 themes per mode.');
        // }

        $defaults = $this->getThemeDefaults($request->input('mode'));

        Theme::create([
            'name' => $request->input('name'),
            'mode' => $request->input('mode'),
            'is_active_light' => false,
            'is_active_dark' => false,
            ...$defaults,
        ]);

        return redirect()->back()->with('success', 'Theme created successfully! You can now customize it.');
    }

    private function getThemeDefaults($mode)
    {
        if ($mode === 'dark') {
            return [
                'primary_color' => '#60a5fa',
                'secondary_color' => '#a78bfa',
                'background_color' => '#0f172a',
                'text_color' => '#ffffff',
            ];
        }

        return [
            'primary_color' => '#3b82f6',
            'secondary_color' => '#130533ff',
            'background_color' => '#ffffff',
            'text_color' => '#000000',
        ];
    }

    public function updateTheme(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:themes,name,' . $id,
            'primary_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'background_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'text_color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'font_family' => 'required|string',
            'mode' => 'required|in:light,dark',
        ]);

        $theme = Theme::findOrFail($id);
        
        // Update theme properties
        $theme->update($request->only([
            'name',
            'primary_color',
            'secondary_color',
            'background_color',
            'text_color',
            'font_family',
            'mode',
        ]));

        return redirect()->back()->with('success', 'Theme updated successfully!');
    }

    public function activateTheme($id)
    {
        $theme = Theme::findOrFail($id);
        $theme->activate();

        return redirect()->back()->with('success', 'Theme activated for ' . $theme->mode . ' mode.');
    }

    public function deleteTheme($id)
    {
        $theme = Theme::findOrFail($id);

        // Prevent deleting active themes
        if ($theme->is_active_light || $theme->is_active_dark) {
            return redirect()->back()->with('error', 'Cannot delete an active theme. Please activate another theme first.');
        }

        // Ensure at least one theme per mode remains
        $modeCount = Theme::where('mode', $theme->mode)->count();
        if ($modeCount <= 1) {
            return redirect()->back()->with('error', 'Cannot delete the only ' . $theme->mode . ' theme.');
        }

        $theme->delete();

        return redirect()->back()->with('success', 'Theme deleted successfully!');
    }

    /**
     * Toggle theme mode in admin panel (for preview)
     */
    public function toggleAdminTheme(Request $request)
    {
        $currentMode = session('theme_mode', 'light');
        $newMode = $currentMode === 'light' ? 'dark' : 'light';
        
        session(['theme_mode' => $newMode]);
        
        return redirect()->back()->with('success', ucfirst($newMode) . ' mode activated in admin panel!');
    }
}