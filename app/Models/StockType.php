<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_type',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship with options
    public function options()
    {
        return $this->hasMany(StockTypeOption::class)->orderBy('sort_order');
    }

    // Relationship with products
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Get active options
    public function activeOptions()
    {
        return $this->hasMany(StockTypeOption::class)->where('is_active', true)->orderBy('sort_order');
    }

    // Scope for active stock types
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}