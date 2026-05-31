<?php

namespace App\Http\Controllers;

use App\Models\PendingRegistration;
use App\Services\EmailVerificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationController extends Controller
{
    protected EmailVerificationService $service;

    public function __construct(EmailVerificationService $service)
    {
        $this->service = $service;
    }

    /**
     * Trang thông báo "Kiểm tra email" sau khi đăng ký.
     * Truyền email từ session để hiển thị + cho phép gửi lại.
     */
    public function notice(Request $request)
    {
        $email = $request->session()->get('pending_email');
        return view('pages.email-notice', compact('email'));
    }

    /**
     * Xử lý link xác minh từ email.
     */
    public function verify(string $token)
    {
        $user = $this->service->verify($token);

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Link xác nhận không hợp lệ hoặc đã hết hạn (24h). Vui lòng đăng ký lại!');
        }

        return redirect()->route('login')
            ->with('success', '🎉 Tài khoản đã được kích hoạt thành công! Vui lòng đăng nhập.');
    }

    /**
     * Gửi lại email xác nhận (throttle 1 lần/phút xử lý ở route).
     */
    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $sent = $this->service->resend($request->email);

        if (!$sent) {
            return back()->with('error', 'Không tìm thấy yêu cầu đăng ký cho email này. Vui lòng đăng ký lại.');
        }

        return back()->with('success', 'Email xác nhận đã được gửi lại! Vui lòng kiểm tra hộp thư (bao gồm Spam).');
    }
}
