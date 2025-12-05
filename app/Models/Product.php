<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'stock_type_id',
        'price',
        'image',
        // Keep old fields for backward compatibility during migration
        'stock_type',
        'total_quantity',
        'taille_S',
        'taille_M',
        'taille_L',
        'taille_XL',
        'taille_XXL',
    ];

    // Relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship with Stock Type
    public function stockType()
    {
        return $this->belongsTo(StockType::class);
    }

    // Relationship with Product Stock
    public function stock()
    {
        return $this->hasMany(ProductStock::class);
    }

    // Get stock for a specific option
// Get stock for a specific option
public function getStockForOption($optionId)
{
    return $this->stock()
        ->where('stock_type_option_id', $optionId)
        ->value('quantity') ?? 0;
}

    // Get total available stock (dynamic system)
    public function getTotalStockAttribute()
    {
        // If using new dynamic system
        if ($this->stock_type_id) {
            return $this->stock()->sum('quantity');
        }

        // Fallback to old system
        if ($this->stock_type === 'total') {
            return $this->total_quantity ?? 0;
        }

        // For old size-based products
        return ($this->taille_S ?? 0) + ($this->taille_M ?? 0) + 
               ($this->taille_L ?? 0) + ($this->taille_XL ?? 0) + 
               ($this->taille_XXL ?? 0);
    }

    // Check if product is in stock
    public function isInStock()
    {
        return $this->total_stock > 0;
    }

    // Check if product uses dynamic stock system
    public function usesDynamicStock()
    {
        return $this->stock_type_id !== null;
    }
    public function hasSizes()
{
    // New dynamic system
    if ($this->usesDynamicStock() && $this->stock()->count() > 0) {
        return true;
    }

    // Old static size system
    return
        ($this->taille_S ?? 0) > 0 ||
        ($this->taille_M ?? 0) > 0 ||
        ($this->taille_L ?? 0) > 0 ||
        ($this->taille_XL ?? 0) > 0 ||
        ($this->taille_XXL ?? 0) > 0;
}


    // Get available stock options with quantities
    public function getAvailableStockOptions()
    {
        if (!$this->stock_type_id) {
            return collect();
        }

        return $this->stock()
            ->with('stockTypeOption')
            ->get()
            ->map(function ($stock) {
                return [
                    'id' => $stock->stock_type_option_id,
                    'label' => $stock->stockTypeOption->label,
                    'value' => $stock->stockTypeOption->value,
                    'quantity' => $stock->quantity,
                    'in_stock' => $stock->quantity > 0,
                ];
            });
    }
}