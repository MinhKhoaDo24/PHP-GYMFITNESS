@extends('pages.auth') {{-- kế thừa cùng layout với login --}}
@section('right-panel')
<div class="login-card">
    <div class="logo-container">
        <div class="logo">
            <i class="fa-solid fa-envelope"></i>
        </div>
        <div class="login-header">
            <h3>Quên mật khẩu</h3>
        </div>
    </div>

    {{-- Hiển thị thông báo session --}}
    @if(Session::has('error'))
        <div class="alert alert-danger">{{ Session::get('error') }}</div>
    @endif

    @if(Session::has('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <form action="{{ route('forgot.send') }}" method="POST" class="login-form" id="form-forgot">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Email đã đăng ký</label>
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

        <button type="submit" class="form-submit" id="submitBtn">
            <span>Gửi link đặt lại mật khẩu</span>
        </button>

        <div class="auth-links" style="margin-top: 1rem;">
            <div class="auth-link">
                Nhớ mật khẩu? <a href="{{ route('login') }}">Quay lại đăng nhập</a>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submit loading animation
    const form = document.getElementById('form-forgot');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function() {
        submitBtn.classList.add('loading');
        submitBtn.innerHTML = '<span>Đang gửi...</span>';
    });

    // Input focus animation giống login
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });
});
</script>
@endpush
