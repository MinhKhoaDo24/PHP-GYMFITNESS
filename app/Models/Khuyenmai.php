<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Khuyenmai extends Model
{
    protected $table = 'khuyenmai';
    protected $primaryKey = 'id_khuyenmai';

    protected $fillable = [
        'ten_khuyenmai',
        'ma_code',
        'gia_tri_giam',
        'kieu_giam',              // percent | fixed
        'mo_ta',
        'gia_tri_don_nho_nhat',
        'giam_toi_da',
        'so_lan_da_su_dung',
        'gioi_han_su_dung',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'trang_thai',            // 1 = active, 0 = inactive
    ];

    protected $casts = [
        'gia_tri_giam'        => 'float',
        'gia_tri_don_nho_nhat'=> 'float',
        'giam_toi_da'         => 'float',
        'so_lan_da_su_dung'   => 'integer',
        'gioi_han_su_dung'    => 'integer',
        'ngay_bat_dau'        => 'datetime',
        'ngay_ket_thuc'       => 'datetime',
        'trang_thai'          => 'integer',
    ];



    public $timestamps = true;

    /*---------------------------------------
     | QUAN HỆ
     ----------------------------------------*/

    // 1 khuyến mãi có thể áp dụng cho nhiều sản phẩm
    public function sanphams()
    {
        return $this->hasMany(Sanpham::class, 'id_khuyenmai');
    }

    /*---------------------------------------
     | KTRA CÒN HIỆU LỰC?
     ----------------------------------------*/
    public function getConHieuLucAttribute()
    {
        $today = Carbon::now();

        return $this->trang_thai == 1 &&
               $this->ngay_bat_dau <= $today &&
               $this->ngay_ket_thuc >= $today &&
               ($this->gioi_han_su_dung == null ||
                $this->so_lan_da_su_dung < $this->gioi_han_su_dung);
    }

    /*---------------------------------------
     | TÍNH GIẢM GIÁ
     ----------------------------------------*/
    public function tinhGiaGiam($giaGoc)
    {
        if (!$this->con_hieu_luc) {
            return 0;
        }

        // Giảm theo %
        if ($this->kieu_giam === 'percent') {
            $giam = $giaGoc * ($this->gia_tri_giam / 100);
        }
        // Giảm theo số tiền
        else {
            $giam = $this->gia_tri_giam;
        }

        // Giảm tối đa (optional)
        if ($this->giam_toi_da != null) {
            $giam = min($giam, $this->giam_toi_da);
        }

        return $giam;
    }

    /*---------------------------------------
     | TÍNH GIÁ SAU KHUYẾN MÃI
     ----------------------------------------*/
    public function tinhGiaSauKM($giaGoc)
    {
        return max(0, $giaGoc - $this->tinhGiaGiam($giaGoc));
    }
}
