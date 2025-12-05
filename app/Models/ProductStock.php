<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $table = 'product_stock';

    protected $fillable = [
        'product_id',
        'stock_type_option_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // Relationship with product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relationship with stock type option
    public function stockTypeOption()
    {
        return $this->belongsTo(StockTypeOption::class);
    }

    // Check if in stock
    public function isInStock()
    {
        return $this->quantity > 0;
    }

    // Decrease stock
    public function decreaseStock($amount)
    {
        if ($this->quantity >= $amount) {
            $this->quantity -= $amount;
            $this->save();
            return true;
        }
        return false;
    }

    // Increase stock
    public function increaseStock($amount)
    {
        $this->quantity += $amount;
        $this->save();
    }
}