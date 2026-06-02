@extends('pages.auth')
@section('right-panel')
<div class="login-card">
    <div class="logo-container">
        <div class="logo">
            <i class="fa-solid fa-lock"></i>
        </div>
        <div class="login-header">
            <h3>Đăng nhập</h3>
        </div>
    </div>

    {{-- Kiểm tra nếu đã sai 5 lần --}}
    @php
        $email = old('email', '');
        $loginAttempts = $email ? session("login_attempts.{$email}", 0) : 0;
        $isLocked = $loginAttempts >= 5;
    @endphp

    @if($isLocked && $errors->has('error') && strpos($errors->first('error'), 'quá nhiều lần') !== false)
        {{-- Form bị khóa - Chỉ hiển thị nút quên mật khẩu --}}
        <div style="text-align: center; padding: 30px;">
            <div style="color: #dc2626; font-size: 48px; margin-bottom: 20px;">
                <i class="fa-solid fa-lock"></i>
            </div>
            <p style="color: #6b7280; margin-bottom: 30px; font-size: 16px;">
                Bạn đã nhập sai mật khẩu quá nhiều lần.<br>
                Vui lòng đặt lại mật khẩu để tiếp tục.
            </p>
            <a href="{{ route('password.forgot') }}" class="form-submit" style="display: inline-block; text-decoration: none; color: white;">
                <span>Đặt lại mật khẩu</span>
            </a>
            <p style="margin-top: 20px; color: #9ca3af;">
                <a href="{{ URL::to('register') }}" style="color: #6366f1; text-decoration: none;">Hoặc đăng ký tài khoản mới</a>
            </p>
        </div>
    @else
        {{-- Form đăng nhập bình thường --}}
        <form action="{{route('login')}}" method="POST" class="login-form" id="form-login">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Địa chỉ Email</label>
                <div class="input-wrapper">
                    <input 
                        type="email" 
                        name="email" 
                        id="email"
                        class="form-control"
                        placeholder="example@email.com"
                        value="{{ old('email') }}"
                        required
                    >
                    <i class="fa-solid fa-envelope input-icon"></i>
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Mật khẩu</label>
                <div class="password-wrapper">
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="form-control"
                            placeholder="Nhập mật khẩu của bạn"
                            required
                        >
                        <i class="fa-solid fa-lock input-icon"></i>
                        <span class="toggle-password" id="togglePassword">
                            <i class="fa-solid fa-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Hiển thị cảnh báo nếu sai 3-4 lần --}}
            @if($loginAttempts >= 3 && $loginAttempts < 5)
                <div style="background-color: #fef3c7; border: 1px solid #fcd34d; border-radius: 8px; padding: 12px; margin-bottom: 15px; color: #92400e; font-size: 14px;">
                    <i class="fa-solid fa-exclamation-triangle" style="margin-right: 8px;"></i>
                    Bạn đã nhập sai {{ $loginAttempts }} lần. Lần thứ 5 tài khoản sẽ bị khóa!
                </div>
            @endif

            <div class="remember-forgot">
                <label class="remember-me">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    <span>Ghi nhớ đăng nhập</span>
                </label>
                <a href="{{ route('password.forgot') }}" style="color: #6366f1; text-decoration: none; font-weight: 600;">Quên mật khẩu?</a>
            </div>

            {{-- reCAPTCHA v2 --}}
            <div class="recaptcha-wrapper">
                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
            </div>

            <button type="submit" class="form-submit" id="submitBtn">
                <span>Đăng nhập ngay</span>
            </button>

            <div class="divider">
                <span>Hoặc đăng nhập với</span>
            </div>

            <div class="social-login">
                <button type="button" class="social-btn">
                    <i class="fa-brands fa-google" style="color: #DB4437;"></i>
                    Google
                </button>
                <button type="button" class="social-btn">
                    <i class="fa-brands fa-facebook" style="color: #1877F2;"></i>
                    Facebook
                </button>
            </div>

            <div class="auth-links">
                <div class="auth-link">
                    Chưa có tài khoản? <a href="{{ URL::to('register')}}">Đăng ký miễn phí</a>
                </div>
            </div>
        </form>
    @endif
</div>
@endsection