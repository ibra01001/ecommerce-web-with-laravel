<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'primary_color',
        'secondary_color',
        'background_color',
        'text_color',
        'font_family',
        'mode',
        'is_active_light',
        'is_active_dark',
    ];

    protected $casts = [
        'is_active_light' => 'boolean',
        'is_active_dark' => 'boolean',
    ];

    /**
     * Boot method to enforce max 4 themes.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($theme) {
            if (self::count() >= 4) {
                throw new \Exception('Maximum of 4 themes allowed.');
            }
        });
    }

    /**
     * Activate this theme for its mode (light or dark)
     */
    public function activate()
    {
        \DB::transaction(function () {
            if ($this->mode === 'light') {
                self::where('mode', 'light')->update(['is_active_light' => false]);
                $this->update(['is_active_light' => true]);
            } else {
                self::where('mode', 'dark')->update(['is_active_dark' => false]);
                $this->update(['is_active_dark' => true]);
            }
        });
    }

    /**
     * Get the currently active theme based on mode
     */
    public static function getActive($mode = null)
    {
        $mode = $mode ?? session('theme_mode', 'light');
        if ($mode === 'dark') {
            return self::where('is_active_dark', true)->first();
        }
        return self::where('is_active_light', true)->first();
    }

    /**
     * Get the active light theme
     */
    public static function getActiveLight()
    {
        return self::where('is_active_light', true)->first();
    }

    /**
     * Get the active dark theme
     */
    public static function getActiveDark()
    {
        return self::where('is_active_dark', true)->first();
    }

    /**
     * Check if this theme is currently active
     */
    public function getIsActiveAttribute()
    {
        if ($this->mode === 'light') {
            return $this->is_active_light;
        }
        return $this->is_active_dark;
    }
}