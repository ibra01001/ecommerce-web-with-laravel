<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroHomePage extends Model
{
    use HasFactory;

    protected $fillable = [
        'heading',
        'subheading',
        'content',
        'background_type',
        'background_image_path',
        'background_video_path',
        'primary_button_text',
        'primary_button_link',
        'secondary_button_text',
        'secondary_button_link',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}