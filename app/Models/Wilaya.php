<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Commune;
class Wilaya extends Model
{
    protected $fillable = ['name', 'code', 'shipping_cost'];

    public function communes()
    {
        return $this->hasMany(Commune::class);
    }
}
