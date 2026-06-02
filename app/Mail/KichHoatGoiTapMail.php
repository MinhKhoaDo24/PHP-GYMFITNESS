<?php

namespace App\Mail;

use App\Models\DangKyGoiTap;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KichHoatGoiTapMail extends Mailable
{
    use Queueable, SerializesModels;

    public $dangKy;

    public function __construct(DangKyGoiTap $dangKy)
    {
        $this->dangKy = $dangKy;
    }

    public function build()
    {
        return $this->subject('Rise Fitness - Kích hoạt gói tập thành công - ' . $this->dangKy->ma_dang_ky)
                    ->view('emails.kichhoat_goitap');
    }
}
