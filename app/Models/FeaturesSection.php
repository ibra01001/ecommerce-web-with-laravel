<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturesSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_title',
        'section_description',
        'layout_style',
        'columns',
        'background_color',
        'show_section_title',
        'show_section_description',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'show_section_title' => 'boolean',
        'show_section_description' => 'boolean',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get all feature items for this section
     */
    public function items()
    {
        return $this->hasMany(FeatureItem::class)->orderBy('display_order');
    }

    /**
     * Get only active feature items
     */
    public function activeItems()
    {
        return $this->hasMany(FeatureItem::class)
            ->where('is_active', true)
            ->orderBy('display_order');
    }

    /**
     * Scope to get only active sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}