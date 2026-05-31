<?php

namespace App\Services;

use App\Models\NguoiDung;
use App\Models\PendingRegistration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailVerificationService
{
    /**
     * Lưu thông tin đăng ký tạm và gửi email xác nhận.
     */
    public function storePendingAndSendEmail(array $data): void
    {
        $token = Str::random(64);

        // Xóa pending cũ nếu email đã tồn tại (user đăng ký lại)
        PendingRegistration::where('email', $data['email'])->delete();

        PendingRegistration::create([
            'hoten'    => $data['hoten'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'diachi'   => $data['diachi'] ?? null,
            'sdt'      => $data['sdt'] ?? null,
            'token'    => $token,
        ]);

        $verifyUrl = url('/email/verify/' . $token);

        Mail::send('emails.verify-email', [
            'hoten'     => $data['hoten'],
            'verifyUrl' => $verifyUrl,
        ], function ($message) use ($data) {
            $message->to($data['email'])
                    ->subject('🏋️ GymZone – Xác nhận tài khoản của bạn');
        });
    }

    /**
     * Xác minh token, tạo tài khoản thật, xóa pending.
     * Trả về NguoiDung nếu thành công, null nếu thất bại.
     */
    public function verify(string $token): ?NguoiDung
    {
        $pending = PendingRegistration::where('token', $token)->first();

        if (!$pending) {
            return null;
        }

        // Kiểm tra hết hạn 24h
        $expiredAt = Carbon::parse($pending->created_at)->addHours(24);
        if (Carbon::now()->greaterThan($expiredAt)) {
            $pending->delete();
            return null;
        }

        // Tạo tài khoản thật
        $user = NguoiDung::create([
            'hoten'        => $pending->hoten,
            'email'        => $pending->email,
            'password'     => $pending->password, // đã hash sẵn
            'diachi'       => $pending->diachi,
            'sdt'          => $pending->sdt,
            'id_phanquyen' => 2,
            'trang_thai'   => 1,
        ]);

        // Xóa pending
        $pending->delete();

        return $user;
    }

    /**
     * Gửi lại email xác nhận từ pending.
     * Trả về true nếu tìm thấy pending và gửi lại thành công.
     */
    public function resend(string $email): bool
    {
        $pending = PendingRegistration::where('email', $email)->first();

        if (!$pending) {
            return false;
        }

        // Tạo token mới
        $token = Str::random(64);
        $pending->update(['token' => $token]);

        $verifyUrl = url('/email/verify/' . $token);

        Mail::send('emails.verify-email', [
            'hoten'     => $pending->hoten,
            'verifyUrl' => $verifyUrl,
        ], function ($message) use ($email) {
            $message->to($email)
                    ->subject('🏋️ GymZone – Xác nhận tài khoản của bạn');
        });

        return true;
    }
}
