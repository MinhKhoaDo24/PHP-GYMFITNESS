<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaiKhoanNhanVienMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $hoTen;
    public string $email;
    public string $matKhauGoc; // Mật khẩu chưa mã hóa để gửi email

    public function __construct(string $hoTen, string $email, string $matKhauGoc)
    {
        $this->hoTen      = $hoTen;
        $this->email      = $email;
        $this->matKhauGoc = $matKhauGoc;
    }

    public function build()
    {
        return $this->subject('Rise Fitness – Thông tin tài khoản đăng nhập của bạn')
                    ->view('emails.tai_khoan_nhan_vien');
    }
}
