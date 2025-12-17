<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    /**
     * Toggle between light and dark mode for the user
     */
    public function toggle(Request $request)
    {
        $currentMode = session('theme_mode', 'light');
        $newMode = $currentMode === 'light' ? 'dark' : 'light';

        // Check if the new mode has an active theme
        $activeTheme = \App\Models\Theme::getActive($newMode);
        if (!$activeTheme) {
            return response()->json([
                'error' => 'No active ' . $newMode . ' theme set by admin.'
            ], 422);
        }

        session(['theme_mode' => $newMode]);

        return response()->json([
            'message' => ucfirst($newMode) . ' mode activated',
            'theme' => $activeTheme
        ]);
    }

    /**
     * Set specific mode
     */
    public function setMode(Request $request)
    {
        $request->validate([
            'mode' => 'required|in:light,dark'
        ]);

        session(['theme_mode' => $request->mode]);
        
        $activeTheme = Theme::getActive($request->mode);

        return response()->json([
            'success' => true,
            'mode' => $request->mode,
            'theme' => [
                'primary_color' => $activeTheme->primary_color,
                'secondary_color' => $activeTheme->secondary_color,
                'background_color' => $activeTheme->background_color,
                'text_color' => $activeTheme->text_color,
                'font_family' => $activeTheme->font_family,
            ]
        ]);
    }
}