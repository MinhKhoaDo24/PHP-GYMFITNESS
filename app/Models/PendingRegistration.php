<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingRegistration extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'hoten',
        'email',
        'password',
        'diachi',
        'sdt',
        'token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
