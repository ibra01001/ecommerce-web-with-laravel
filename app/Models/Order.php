<?php 
namespace App\Models;
use Illuminate\Database\Eloquent\Model; 

class Order extends Model 
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'email',
        'wilaya',
        'commune',
        'address',
        'notes',
        'subtotal',
        'shipping_cost',
        'total',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}