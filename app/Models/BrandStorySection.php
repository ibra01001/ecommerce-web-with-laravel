<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandStorySection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'button_text',
        'button_link',
        'background_color',
        'title_color',
        'description_color',
        'show_button',
        'is_active',
    ];

    protected $casts = [
        'show_button' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Scope to get only active sections
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}