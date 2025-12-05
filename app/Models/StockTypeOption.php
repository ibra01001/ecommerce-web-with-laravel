<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTypeOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_type_id',
        'label',
        'value',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship with stock type
    public function stockType()
    {
        return $this->belongsTo(StockType::class);
    }

    // Relationship with product stock
    public function productStock()
    {
        return $this->hasMany(ProductStock::class);
    }

    // Scope for active options
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}