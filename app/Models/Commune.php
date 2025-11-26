<?php
namespace App\Models;
use App\Models\Wilaya;

use Illuminate\Database\Eloquent\Model;
class Commune extends Model
{
    protected $fillable = ['wilaya_id', 'name'];
    public function wilaya(){
        return $this->belongsTo(Wilaya::class);
    }
} 