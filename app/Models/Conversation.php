<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversations';

    protected $fillable = [
        'customer_id',
        'staff_id',
        'status'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function customer()
    {
        return $this->belongsTo(NguoiDung::class, 'customer_id', 'id_nd');
    }

    public function staff()
    {
        return $this->belongsTo(NguoiDung::class, 'staff_id', 'id_nd');
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }
}
