@extends('pages.auth')

@section('right-panel')
<div class="login-card">
    @if(session()->has('thongbao'))

        @endif
    <div class="logo-container">
        <div class="logo">
            <i class="fa-solid fa-user-plus"></i>
        </div>
        <div class="login-header">
            <h3>Đăng ký tài khoản</h3>
        </div>
    </div>

    <form action="{{ route('register') }}" method="POST" class="login-form" id="form-register">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">Họ và tên</label>
            <div class="input-wrapper">
                <input type="text" name="name" id="name"
                    class="form-control" placeholder="Nguyễn Văn A" required>
                <i class="fa-solid fa-user input-icon"></i>
            </div>
            <span class="form-message"></span>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">Địa chỉ Email</label>
            <div class="input-wrapper">
                <input type="email" name="email" id="email"
                    class="form-control" placeholder="example@email.com" required>
                <i class="fa-solid fa-envelope input-icon"></i>
            </div>
            <span class="form-message" id="email-error"></span>
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Mật khẩu</label>
            <div class="input-wrapper">
                <input type="password" name="password" id="password"
                    class="form-control" placeholder="Tối thiểu 6 ký tự" required>
                <i class="fa-solid fa-lock input-icon"></i>
                <span class="toggle-password" data-target="password">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>
            <span class="form-message"></span>
        </div>

        <!-- Confirm password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
            <div class="input-wrapper">
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="form-control" placeholder="Nhập lại mật khẩu" required>
                <i class="fa-solid fa-lock input-icon"></i>
                <span class="toggle-password" data-target="password_confirmation">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>
            <span class="form-message"></span>
        </div>

        <button type="submit" class="form-submit">
            <span>Đăng ký ngay</span>
        </button>

        <div class="divider">
            <span>Hoặc đăng ký bằng</span>
        </div>

        <div class="social-login">
            <button type="button" class="social-btn">
                <i class="fa-brands fa-google" style="color: #DB4437;"></i> Google
            </button>
            <button type="button" class="social-btn">
                <i class="fa-brands fa-facebook" style="color: #1877F2;"></i> Facebook
            </button>
        </div>

        <div class="auth-links">
            <div class="auth-link">
                Đã có tài khoản? <a href="{{ url('login') }}">Đăng nhập ngay</a>
            </div>
        </div>
    </form>
</div>

<script>
    let emailIsValid = true;

    // Show error
    function showError(input, message) {
        const formGroup = input.closest('.form-group');
        const errorElement = formGroup.querySelector('.form-message');
        errorElement.textContent = message;
        input.classList.add('is-invalid');
    }

    // Hide error
    function hideError(input) {
        const formGroup = input.closest('.form-group');
        const errorElement = formGroup.querySelector('.form-message');
        errorElement.textContent = '';
        input.classList.remove('is-invalid');
    }

    // Required validation
    document.querySelectorAll('#form-register input[required]').forEach(input => {
        input.addEventListener('blur', function () {
            if (this.value.trim() === '') showError(this, 'Vui lòng nhập trường này.');
            else hideError(this);
        });
        input.addEventListener('input', () => hideError(input));
    });

    // Email check AJAX
    document.getElementById('email').addEventListener('blur', function () {
        const email = this.value;

        if (!email) {
            hideError(this);
            emailIsValid = true;
            return;
        }

        fetch('{{ route("kiemtra.email") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email })
        })
        .then(res => res.json())
        .then(data => {
            if (data.exists) {
                showError(this, 'Email này đã được sử dụng. Vui lòng chọn email khác.');
                emailIsValid = false;
            } else {
                hideError(this);
                emailIsValid = true;
            }
        })
        .catch(() => {
            showError(this, 'Không thể kiểm tra email.');
            emailIsValid = false;
        });
    });

    // Submit validation
    document.getElementById('form-register').addEventListener('submit', function (e) {
        let formIsValid = true;

        document.querySelectorAll('#form-register input[required]').forEach(input => {
            if (input.value.trim() === '') {
                showError(input, 'Vui lòng nhập trường này.');
                formIsValid = false;
            }
        });

        if (!emailIsValid) {
            formIsValid = false;
            document.getElementById('email').focus();
        }

        if (!formIsValid) e.preventDefault();
    });

    // Toggle password
    document.querySelectorAll('.toggle-password').forEach(toggle => {
        toggle.addEventListener('click', function () {
            const input = document.getElementById(this.dataset.target);
            const icon = this.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });
    });

</script>
@endsection
