<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'admin_notes',
        'read_at'
    ];

    protected $casts = [
        'read_at'=> 'datetime',
        'created_at'=> 'datetime',

    ];
    public function markAsRead()
    {
        if(!$this->read_at){
            $this->update([
                'status'=>'read',
                'read_at'=> now()
            ]);
        }
    }
    public function scopeNew($query)
    {
        return $query->where('status','new');
    }

    public function scopeUnread($query)
    {
        return $query->where('status','new');
        
    }
}