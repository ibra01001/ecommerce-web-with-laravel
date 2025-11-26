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
        'price',
        'quantity',
        'taille_S',
        'taille_M',
        'taille_L',
        'taille_XL',
        'taille_XXL',
        'image',
        'category_id'
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($product) {
            $product->quantity = $product->taille_S + $product->taille_M + $product->taille_L + $product->taille_XL + $product->taille_XXL;
        });
    } 
// check if specfic size is available
    public function hasSizeAvailable($size, $quantity = 1)
    {
        $sizeField = 'taille_' . strtoupper($size);
        if ($this->hasSizeAvailable($sizeField, $quantity)) {
            $this->$sizeField -= $quantity;
            $this->quantity -= $quantity;
            $this->save();
            return true;
        }
        return false;
    }

    public function Category()
    {
        return $this->belongsTo(category::class);
    }
}