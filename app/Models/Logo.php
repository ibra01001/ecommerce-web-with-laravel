<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    use HasFactory;

    protected $table = 'logos';
    
    protected $fillable = [
        'name',
        'custom_logo_path',
        'dark_logo_path',
    ];

    /**
     * Get the full URL for the light mode logo
     */
    public function getLightLogoUrlAttribute()
    {
        if ($this->custom_logo_path) {
            return asset('storage/' . $this->custom_logo_path);
        }
        return null;
    }

    /**
     * Get the full URL for the dark mode logo
     */
    public function getDarkLogoUrlAttribute()
    {
        if ($this->dark_logo_path) {
            return asset('storage/' . $this->dark_logo_path);
        }
        return null;
    }

    /**
     * Get the appropriate logo based on the current theme
     */
    public function getLogoForTheme($theme)
    {
        if ($theme && $theme->mode === 'dark' && $this->dark_logo_path) {
            return $this->getDarkLogoUrlAttribute();
        }
        
        // Default to light logo
        if ($this->custom_logo_path) {
            return $this->getLightLogoUrlAttribute();
        }
        
        return null;
    }

    /**
     * Check if light logo exists
     */
    public function hasLightLogo()
    {
        return !is_null($this->custom_logo_path);
    }

    /**
     * Check if dark logo exists
     */
    public function hasDarkLogo()
    {
        return !is_null($this->dark_logo_path);
    }
}