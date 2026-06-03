<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NguoiDung;
use App\Services\EmailVerificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules\Password;
use App\Helpers\CartHelper;

class AuthController extends Controller
{
    protected EmailVerificationService $verificationService;

    public function __construct(EmailVerificationService $verificationService)
    {
        $this->verificationService = $verificationService;
    }

    public function index()
    {
        return view('pages.login');
    }

    public function register()
    {
        return view('pages.register');
    }

    /**
     * Đăng ký: Lưu tạm vào pending_registrations → Gửi email xác nhận
     * KHÔNG tạo tài khoản thật cho đến khi user xác minh email.
     */
    public function registerPost(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:nguoidung,email|unique:pending_registrations,email',
            'password' => [
                'required',
                'confirmed',
                Password::min(6)
                    ->mixedCase()   // cần cả chữ hoa và chữ thường
                    ->numbers()     // cần ít nhất 1 chữ số
                    ->symbols(),    // cần ít nhất 1 ký tự đặc biệt
            ],
            'address'  => 'required|string|max:255',
            'phone'    => 'required|regex:/^[0-9]{10,11}$/'
        ], [
            'name.required'      => 'Vui lòng nhập họ và tên',
            'email.required'     => 'Vui lòng nhập email',
            'email.email'        => 'Email không hợp lệ',
            'email.unique'       => 'Email này đã được sử dụng',
            'password.required'  => 'Vui lòng nhập mật khẩu',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
            'address.required'   => 'Vui lòng nhập địa chỉ',
            'phone.required'     => 'Vui lòng nhập số điện thoại',
            'phone.regex'        => 'Số điện thoại phải có 10-11 chữ số'
        ]);

        // Gửi email xác nhận, lưu pending (không tạo tài khoản thật)
        $this->verificationService->storePendingAndSendEmail([
            'hoten'    => $request->name,
            'email'    => $request->email,
            'password' => $request->password,
            'diachi'   => $request->address,
            'sdt'      => $request->phone,
        ]);

        // Lưu email vào session để hiển thị trên trang notice
        session(['pending_email' => $request->email]);

        return redirect()->route('email.notice');
    }

    /**
     * Đăng nhập: Validate reCAPTCHA trước, rồi mới Auth::attempt()
     */
    public function loginPost(Request $request)
    {
        // ── Track số lần đăng nhập sai ─────────────────────────────────────
        $email = $request->email;
        $loginAttempts = session("login_attempts.{$email}", 0);

        // Nếu đã sai 5 lần, chặn đăng nhập
        if ($loginAttempts >= 5) {
            return redirect()->route('password.forgot')
                ->with('error', 'Bạn đã nhập sai mật khẩu 5 lần. Vui lòng đặt lại mật khẩu để tiếp tục!');
        }

        // ── 1. Validate reCAPTCHA ──────────────────────────────────────────
        $recaptchaToken = $request->input('g-recaptcha-response');

        if (empty($recaptchaToken)) {
            return back()->with('error', 'Vui lòng xác nhận reCAPTCHA để tiếp tục!');
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => $recaptchaToken,
            'remoteip' => $request->ip(),
        ]);

        $result = $response->json();

        if (empty($result['success']) || !$result['success']) {
            return back()->with('error', 'Xác minh reCAPTCHA thất bại. Vui lòng thử lại!');
        }

        // ── 2. Kiểm tra tài khoản ─────────────────────────────────────────
        $user = NguoiDung::where('email', $request->email)->first();

        // Nếu không tìm thấy user
        if (!$user) {
            // Tăng counter
            session(["login_attempts.{$email}" => $loginAttempts + 1]);

            $newAttempts = $loginAttempts + 1;
            if ($newAttempts >= 5) {
                session(["login_attempts.{$email}" => $newAttempts]);
                return redirect()->route('password.forgot')
                    ->with('error', 'Bạn đã nhập sai mật khẩu 5 lần. Vui lòng đặt lại mật khẩu để tiếp tục!');
            } elseif ($newAttempts >= 3) {
                return back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu! (Lần nhập sai: ' . $newAttempts . '/5 - Lần thứ 5 sẽ bị khóa)');
            } else {
                return back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu!');
            }
        }

        // Nếu trạng thái = 0 -> báo lỗi
        if ($user->trang_thai == 0) {
            return back()->with('error', 'Tài khoản đang bị khóa. Vui lòng liên hệ quản trị viên!');
        }

        // ── 3. Auth::attempt ───────────────────────────────────────────────
        $credentials = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, false)) {
            // Reset counter khi đăng nhập thành công
            session()->forget("login_attempts.{$email}");
            
            $request->session()->regenerate();

            // ── Khôi phục giỏ hàng từ CSDL (Không gộp giỏ hàng khách) ───────
            $loggedInUser = Auth::user();
            $dbCart = $loggedInUser->cart_data ?? [];
            session()->put('cart', $dbCart);

            // ── Remember Me bằng Sanctum token ghi vào cookie ──────────────
            if ($request->boolean('remember')) {
                $user = Auth::user();

                // Xóa token cũ cùng tên để tránh trùng
                $user->tokens()->where('name', 'remember_me')->delete();

                // Tạo Sanctum token mới, hết hạn 30 ngày
                $token = $user->createToken('remember_me')->plainTextToken;

                // Ghi vào httpOnly cookie, tồn tại 30 ngày
                Cookie::queue(
                    'remember_token',
                    $token,
                    60 * 24 * 30,   // phút — 30 ngày
                    '/',
                    null,
                    false,          // secure — đặt true khi production HTTPS
                    true            // httpOnly
                );
            }

            return redirect()->intended('/')
                ->with('thongbao', 'Đăng nhập thành công!')
                ->withCookie(Cookie::queued('remember_token') ?? cookie()->forget('remember_token'));
        }

        // Tăng counter khi đăng nhập thất bại
        $newAttempts = $loginAttempts + 1;
        session(["login_attempts.{$email}" => $newAttempts]);

        if ($newAttempts >= 5) {
            return redirect()->route('password.forgot')
                ->with('error', 'Bạn đã nhập sai mật khẩu 5 lần. Vui lòng đặt lại mật khẩu để tiếp tục!');
        } elseif ($newAttempts >= 3) {
            return back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu! (Lần nhập sai: ' . $newAttempts . '/5 - Lần thứ 5 sẽ bị khóa)');
        } else {
            return back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu!');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function kiemTraEmail(Request $request)
    {
        $existsInUsers   = NguoiDung::where('email', $request->email)->exists();
        $existsInPending = \App\Models\PendingRegistration::where('email', $request->email)->exists();
        return response()->json(['exists' => $existsInUsers || $existsInPending]);
    }
}

