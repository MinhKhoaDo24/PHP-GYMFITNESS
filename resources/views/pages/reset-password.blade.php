@extends('pages.auth')
@section('right-panel')
<div class="login-card">
    <div class="logo-container">
        <div class="logo">
            <i class="fa-solid fa-key"></i>
        </div>
        <div class="login-header">
            <h3>Đặt lại mật khẩu</h3>
        </div>
    </div>

    @if(Session::has('error'))
        <div style="background-color: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; padding: 12px; margin-bottom: 15px; color: #991b1b; font-size: 14px;">
            <i class="fa-solid fa-circle-exclamation" style="margin-right: 8px;"></i>
            {{ Session::get('error') }}
        </div>
    @endif

    <form action="{{ route('password.update') }}" method="POST" class="login-form" id="reset-form">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Mật khẩu mới</label>
            <div class="input-wrapper">
                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Tối thiểu 6 ký tự"
                    required
                >
                <i class="fa-solid fa-lock input-icon"></i>
                <span class="toggle-password" data-target="password">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>
            @error('password')
                <div style="color: #dc2626; font-size: 13px; margin-top: 5px;">
                    <i class="fa-solid fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
            <small style="color: #6b7280; margin-top: 8px; display: block;">
                ✓ Tối thiểu 6 ký tự<br>
                ✓ Chứa chữ hoa (A-Z)<br>
                ✓ Chứa chữ thường (a-z)<br>
                ✓ Chứa chữ số (0-9)<br>
                ✓ Chứa ký tự đặc biệt (!@#$%^&*)
            </small>
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
            <div class="input-wrapper">
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation"
                    class="form-control @error('password_confirmation') is-invalid @enderror"
                    placeholder="Nhập lại mật khẩu"
                    required
                >
                <i class="fa-solid fa-lock input-icon"></i>
                <span class="toggle-password" data-target="password_confirmation">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>
            @error('password_confirmation')
                <div style="color: #dc2626; font-size: 13px; margin-top: 5px;">
                    <i class="fa-solid fa-exclamation-circle"></i> {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="form-submit">
            <span>Đặt lại mật khẩu</span>
        </button>

        <div class="auth-links">
            <div class="auth-link">
                <a href="{{ route('login') }}" style="color: #6366f1; text-decoration: none;">Quay lại đăng nhập</a>
            </div>
        </div>
    </form>
</div>

<script>
// Toggle password visibility
document.querySelectorAll('.toggle-password').forEach(toggle => {
    toggle.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        const icon = this.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});
</script>
@endsection
