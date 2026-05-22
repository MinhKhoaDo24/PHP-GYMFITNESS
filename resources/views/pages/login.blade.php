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

        <div class="remember-forgot">
            <label class="remember-me">
                <input type="checkbox" name="remember">
                <span>Ghi nhớ đăng nhập</span>
            </label>
            <a href="{{ route('password.forgot') }}" style="color: #6366f1; text-decoration: none; font-weight: 600;">Quên mật khẩu?</a>
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
</div>
@endsection