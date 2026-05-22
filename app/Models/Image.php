<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_sanpham',
        'duong_dan',
    ];

    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class, 'id_sanpham', 'id_sanpham');
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'id_sanpham', 'id_sanpham');
    }
}
