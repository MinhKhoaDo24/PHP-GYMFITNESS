<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SanPham;

class Dathang extends Model
{
    protected $table = 'dathang';
    protected $primaryKey = 'id_dathang';
    public $timestamps = false;

    protected $fillable = [
        'ngaydathang',
        'ngaygiaohang',
        'ngay_hoan_thanh',
        'tongtien',
        'tiengiam',           // thêm
        'tienphaitra',        // thêm
        'id_khuyenmai',       // thêm
        'phuongthucthanhtoan',
        'diachigiaohang',
        'hoten',
        'email',
        'sdt',
        'trangthai',
        'id_nd'
    ];

    protected $casts = [
        'id_dathang' => 'int',
        'ngaydathang' => 'datetime',
        'ngaygiaohang' => 'datetime',
        'ngay_hoan_thanh' => 'datetime',
        'tongtien' => 'int',
        'tiengiam' => 'int',       // thêm
        'tienphaitra' => 'int',    // thêm
        'id_khuyenmai' => 'int',   // thêm
        'phuongthucthanhtoan' => 'string',
        'diachigiaohang' => 'string',
        'hoten' => 'string',
        'email' => 'string',
        'sdt' => 'int',
        'trangthai' => 'string',
        'id_nd' => 'int',
    ];

    protected $dates = [
        'ngaydathang',
        'ngaygiaohang',
        'ngay_hoan_thanh',
    ];

    public function khuyenmai()
    {
        return $this->belongsTo(Khuyenmai::class, 'id_khuyenmai', 'id_khuyenmai');
    }

    public function details()
    {
        return $this->hasMany(ChitietDonhang::class, 'id_dathang', 'id_dathang');
    }

    protected static function booted()
    {
        static::updating(function ($order) {
            if ($order->isDirty('trangthai')) {
                $oldStatus = $order->getOriginal('trangthai');
                $newStatus = $order->trangthai;

                // Nếu chuyển từ trạng thái chưa hủy/thất bại sang Bị hủy hoặc Thất bại
                if ($oldStatus !== 'Bị hủy' && $oldStatus !== 'Thất bại' && ($newStatus === 'Bị hủy' || $newStatus === 'Thất bại')) {
                    $order->replenishStock();
                }
            }
        });
    }

    public function replenishStock()
    {
        $details = $this->details;
        foreach ($details as $detail) {
            $product = SanPham::with('sizes')->find($detail->id_sanpham);
            if ($product) {
                if ($product->co_size == 1) {
                    $sizeName = null;
                    if (preg_match('/ \(Size:\s*([^)]+)\)/ui', $detail->tensp, $matches)) {
                        $sizeName = trim($matches[1]);
                    }
                    if ($sizeName) {
                        $sizeObj = $product->sizes->first(function ($size) use ($sizeName) {
                            return strcasecmp($size->ten_size, $sizeName) === 0;
                        });
                        if ($sizeObj) {
                            $newSizeQty = $sizeObj->pivot->soluong + $detail->soluong;
                            $product->sizes()->updateExistingPivot($sizeObj->id_size, ['soluong' => $newSizeQty]);
                        }
                    }
                    // Tính lại tổng số lượng của sản phẩm
                    $product->soluong = $product->sizes()->sum('sanpham_size.soluong');
                    $product->save();
                } else {
                    $product->soluong += $detail->soluong;
                    $product->save();
                }
            }
        }
    }
}


