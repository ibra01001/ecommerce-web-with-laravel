<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'content',
        'images',
        'is_active'
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'images' => '[]',
        'is_active' => false,
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors & Mutators
    public function getImageUrlsAttribute(): array
    {
        return collect($this->images)
            ->map(fn($path) => Storage::url($path))
            ->toArray();
    }

    // Helper Methods
    public function hasImages(): bool
    {
        return !empty($this->images);
    }

    public function getImageCount(): int
    {
        return count($this->images ?? []);
    }

    public function addImage(string $path): void
    {
        $images = $this->images ?? [];
        $images[] = $path;
        $this->update(['images' => $images]);
    }

    public function removeImage(int $index): void
    {
        $images = $this->images ?? [];
        
        if (isset($images[$index])) {
            Storage::delete($images[$index]);
            unset($images[$index]);
            $this->update(['images' => array_values($images)]);
        }
    }

    public function clearImages(): void
    {
        foreach ($this->images ?? [] as $path) {
            Storage::delete($path);
        }
        
        $this->update(['images' => []]);
    }

    // Boot method for model events
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($news) {
            $news->clearImages();
        });
    }
}