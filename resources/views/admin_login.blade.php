<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin - Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Favicon / Logo --}}
    <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/img/LOGO.png') }}" />

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons (icon user, khóa…) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* ===== NỀN TOÀN TRANG (ẢNH) ===== */
        body {
            min-height: 100vh;
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Microgramma Extended", sans-serif;
            background: url('{{ asset('frontend/img/banneradmin.jpg') }}') center center / cover no-repeat fixed;
        }

        /* overlay làm tối nhẹ cho dễ đọc chữ */
        .bg-overlay {
            min-height: 100vh;
        }

        /* ===== BOX LOGIN GLASS MỜ ===== */
        .login-card {
            max-width: 430px;
            width: 100%;
            padding: 2px 30px 26px;
            border-radius: 26px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.35);
            box-shadow: 0 18px 40px rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            color: #fff;
        }

        .login-logo {
            margin-top: -75px;
            width: 250px;
            height: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 10px rgba(0,0,0,0.6));
        }

        .login-title {
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: -60px;
            color: #fff
        }

        /* ===== INPUT + ICON ===== */
        .login-label {
            font-size: 0.8rem;
            letter-spacing: 0.05em;
            text-transform: none;
            opacity: 0.9;
        }

        .form-control,
        .input-group-text {
            background-color: rgba(0, 0, 0, 0.18);
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.45);
            color: #fff;
        }

        /* viền đỏ khi lỗi */
        .form-control.is-invalid {
            border-color: #ff6b6b !important;
            box-shadow: 0 0 0 1px rgba(255, 107, 107, 0.6);
        }

        /* chữ cảnh báo màu đỏ dưới ô input */
        .invalid-feedback-custom {
            color: #000;
            font-weight: 700;
            font-size: 1rem;
            margin-top: 0.25rem;
            margin-left: 0.4rem;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .form-control:focus {
            border-color: #fff;
            box-shadow: 0 0 0 0.15rem rgba(255, 255, 255, 0.4);
            background-color: rgba(0, 0, 0, 0.18);
        }

        .input-group .form-control {
            border-right: none;
        }

        .input-group-text {
            border-left: none;
        }

        .input-group .bi {
            font-size: 1.1rem;
        }

        /* ===== CHECKBOX + BUTTON ===== */
        .form-check-label {
            font-size: 0.85rem;
        }

        .btn-login {
            width: 100%;
            border-radius: 999px;
            padding: 0.6rem 1rem;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            background: #333;
            color: #ffffff;
            border: none;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.45);
            transition: transform 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }

        .btn-login:hover {
            color: #333;
            transform: translateY(-1px);
            background: #fff;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.55);
        }

        .btn-login:active {
            transform: translateY(1px) scale(0.99);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.55);
        }

        /* ===== ALERT LỖI ===== */
        .login-alert {
            background: rgba(220, 53, 69, 0.15);
            border-color: rgba(220, 53, 69, 0.8);
            color: #ffe9ec;
            font-size: 0.85rem;
        }

        .login-alert ul {
            margin-bottom: 0;
            padding-left: 1.25rem;
        }
    </style>
</head>
<body>
<div class="bg-overlay d-flex align-items-center justify-content-center">
    <div class="login-card">

        {{-- LOGO + TIÊU ĐỀ --}}
        <div class="text-center mb-2">
            <img src="{{ asset('frontend/img/LOGO.png') }}" alt="Logo doanh nghiệp" class="login-logo mb-1">
            <h2 class="login-title mb-0">ADMIN - ĐĂNG NHẬP</h2>
        </div>

        {{-- FORM ĐĂNG NHẬP --}}
        <form action="{{ URL::to('/signinDashboard') }}" method="POST" autocomplete="off">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label class="login-label mb-1" for="email">Email</label>
                <div class="input-group">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Nhập email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                </div>

                {{-- lỗi riêng cho email --}}
                @error('email')
                    <div class="invalid-feedback-custom">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Mật khẩu --}}
            <div class="mb-3">
                <label class="login-label mb-1" for="password">Mật khẩu</label>
                <div class="input-group">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control
                            @error('password') is-invalid @enderror
                            @if (session('thongbao')) is-invalid @endif"
                        placeholder="Nhập mật khẩu"
                        required
                    >
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                </div>

                {{-- lỗi validate mật khẩu (bắt buộc, min,...) --}}
                @error('password')
                    <div class="invalid-feedback-custom">
                        {{ $message }}
                    </div>
                @enderror

                {{-- lỗi sai tài khoản / mật khẩu (thongbao hiện dưới password) --}}
                @if (session('thongbao'))
                    <div class="invalid-feedback-custom">
                        {{ session('thongbao') }}
                    </div>
                    @php Session::put('thongbao', null); @endphp
                @endif
            </div>

            {{-- Ghi nhớ tôi --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="remember"
                        name="remember-me"
                        value="1"
                    >
                    <label class="form-check-label" for="remember">
                        Ghi nhớ tôi
                    </label>
                </div>
                {{-- bỏ forgot password, để 1 span invisible cho cân layout --}}
                <span class="small opacity-0">hidden</span>
            </div>

            {{-- NÚT ĐĂNG NHẬP --}}
            <button type="submit" class="btn btn-login">
                Đăng nhập
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
