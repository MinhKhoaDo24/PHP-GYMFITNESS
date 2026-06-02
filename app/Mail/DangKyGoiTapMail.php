<?php

namespace App\Mail;

use App\Models\DangKyGoiTap;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DangKyGoiTapMail extends Mailable
{
    use Queueable, SerializesModels;

    public $dangKy;

    public function __construct(DangKyGoiTap $dangKy)
    {
        $this->dangKy = $dangKy;
    }

    public function build()
    {
        return $this->subject('Xác nhận đăng ký gói tập tại Rise Fitness - ' . $this->dangKy->ma_dang_ky)
                    ->view('emails.dangky_goitap');
    }
}
