<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model{
    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'image',
        'price',
        'quantity',
        'taille_type'
    ];
    public function Order(){
        return $this->belongsTo(Order::class, 'order_id');
    }
}