<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Theme;
use App\Models\Logo;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share active theme with all views
        View::composer('*', function ($view) {
            try {
                // Get user's current theme mode preference
                $currentMode = session('theme_mode', 'light');

                // Get active theme based on mode
                $activeTheme = $currentMode === 'dark'
                    ? Theme::where('is_active_dark', true)->first()
                    : Theme::where('is_active_light', true)->first();


                // Get both active themes for the toggle
                $activeLightTheme = Theme::where('is_active_light', true)->first();
                $activeDarkTheme = Theme::where('is_active_dark', true)->first();


                $logo = Logo::first();

                // Get the appropriate logo based on current theme mode
                $logoUrl = null;
                if ($logo) {
                    if ($currentMode === 'dark' && $logo->dark_logo_path) {
                        $logoUrl = asset('storage/' . $logo->dark_logo_path);
                    } elseif ($logo->custom_logo_path) {
                        $logoUrl = asset('storage/' . $logo->custom_logo_path);
                    }
                }

                $view->with([
                    'activeTheme' => $activeTheme,
                    'activeLightTheme' => $activeLightTheme,
                    'activeDarkTheme' => $activeDarkTheme,
                    'currentMode' => $currentMode,
                    'siteLogo' => $logo,
                    'currentLogoUrl' => $logoUrl
                ]);
            } catch (\Exception $e) {
                // Fallback to default values
                $view->with([
                    'activeTheme' => (object) [
                        'primary_color' => '#3b82f6',
                        'secondary_color' => '#8b5cf6',
                        'background_color' => '#ffffff',
                        'text_color' => '#000000',
                        'font_family' => 'Inter',
                        'mode' => 'light'
                    ],
                    'activeLightTheme' => null,
                    'activeDarkTheme' => null,
                    'currentMode' => 'light',
                    'siteLogo' => null,
                    'currentLogoUrl' => null
                ]);
            }
        });
    }
}