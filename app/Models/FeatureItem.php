<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FeatureItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'features_section_id',
        'title',
        'description',
        'icon_type',
        'icon_svg',
        'icon_svg_path',
        'icon_image_path',
        'icon_emoji',
        'icon_color',
        'title_color',
        'description_color',
        'alignment',
        'link_url',
        'link_text',
        'open_in_new_tab',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'open_in_new_tab' => 'boolean',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get the features section this item belongs to
     */
    public function featuresSection()
    {
        return $this->belongsTo(FeaturesSection::class);
    }

    /**
     * Get the icon image URL
     */
    public function getIconImageUrlAttribute()
    {
        if ($this->icon_image_path) {
            return Storage::url($this->icon_image_path);
        }
        return null;
    }

    /**
     * Get the SVG file URL
     */
    public function getIconSvgUrlAttribute()
    {
        if ($this->icon_svg_path) {
            return Storage::url($this->icon_svg_path);
        }
        return null;
    }

    /**
     * Get the SVG content from file
     */
    public function getIconSvgContentAttribute()
    {
        if ($this->icon_svg_path && Storage::disk('public')->exists($this->icon_svg_path)) {
            return Storage::disk('public')->get($this->icon_svg_path);
        }
        return $this->icon_svg; // Fallback to inline SVG
    }

    /**
     * Get the icon based on type
     */
    public function getIconAttribute()
    {
        switch ($this->icon_type) {
            case 'svg':
                return $this->icon_svg;
            case 'svg_upload':
                return $this->icon_svg_content;
            case 'image':
                return $this->icon_image_url;
            case 'emoji':
                return $this->icon_emoji;
            default:
                return null;
        }
    }

    /**
     * Scope to get only active items
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by display order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }
}