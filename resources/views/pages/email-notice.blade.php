@extends('layout')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .verify-page {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #0f0f1a 0%, #1a1a2e 50%, #16213e 100%);
        padding: 40px 20px;
        position: relative;
        overflow: hidden;
    }

    /* Animated background shapes */
    .verify-page::before,
    .verify-page::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        opacity: 0.15;
        animation: floatShape 8s ease-in-out infinite;
    }
    .verify-page::before {
        width: 500px; height: 500px;
        background: #6366f1;
        top: -100px; left: -100px;
    }
    .verify-page::after {
        width: 400px; height: 400px;
        background: #8b5cf6;
        bottom: -100px; right: -100px;
        animation-delay: -4s;
    }
    @keyframes floatShape {
        0%, 100% { transform: translate(0,0) scale(1); }
        50% { transform: translate(30px, 20px) scale(1.05); }
    }

    .verify-card {
        background: rgba(255,255,255,0.04);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 24px;
        padding: 56px 48px;
        max-width: 520px;
        width: 100%;
        text-align: center;
        position: relative;
        z-index: 1;
        box-shadow: 0 32px 64px rgba(0,0,0,0.4);
    }

    .mail-icon-wrapper {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, rgba(99,102,241,0.2), rgba(139,92,246,0.2));
        border: 2px solid rgba(99,102,241,0.4);
        border-radius: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 28px;
        font-size: 44px;
        animation: pulse 2.5s ease-in-out infinite;
    }
    @keyframes pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(99,102,241,0.3); }
        50% { box-shadow: 0 0 0 20px rgba(99,102,241,0); }
    }

    .verify-title {
        font-size: 28px;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 16px;
        line-height: 1.3;
    }
    .verify-title span {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .verify-desc {
        font-size: 15px;
        color: rgba(255,255,255,0.65);
        line-height: 1.8;
        margin-bottom: 8px;
    }

    .email-highlight {
        display: inline-block;
        background: rgba(99,102,241,0.15);
        border: 1px solid rgba(99,102,241,0.3);
        border-radius: 8px;
        padding: 6px 16px;
        color: #a5b4fc;
        font-weight: 600;
        font-size: 14px;
        margin: 12px 0 24px;
        word-break: break-all;
    }

    .steps {
        background: rgba(255,255,255,0.04);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 16px;
        padding: 24px;
        margin: 28px 0;
        text-align: left;
    }
    .steps-title {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: rgba(255,255,255,0.4);
        margin-bottom: 16px;
    }
    .step-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
    }
    .step-item:last-child { margin-bottom: 0; }
    .step-num {
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: white;
        flex-shrink: 0;
    }
    .step-text {
        font-size: 14px;
        color: rgba(255,255,255,0.7);
        line-height: 1.6;
        padding-top: 3px;
    }

    .divider {
        height: 1px;
        background: rgba(255,255,255,0.08);
        margin: 28px 0;
    }

    .resend-label {
        font-size: 14px;
        color: rgba(255,255,255,0.5);
        margin-bottom: 16px;
    }

    .resend-form {
        display: flex;
        gap: 10px;
    }
    .resend-input {
        flex: 1;
        padding: 12px 16px;
        background: rgba(255,255,255,0.07);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 10px;
        color: #fff;
        font-size: 14px;
        outline: none;
        transition: border 0.3s;
    }
    .resend-input::placeholder { color: rgba(255,255,255,0.3); }
    .resend-input:focus { border-color: rgba(99,102,241,0.6); }

    .resend-btn {
        padding: 12px 20px;
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        white-space: nowrap;
        transition: opacity 0.3s, transform 0.2s;
    }
    .resend-btn:hover { opacity: 0.9; transform: translateY(-1px); }
    .resend-btn:active { transform: translateY(0); }

    .back-link {
        margin-top: 24px;
        font-size: 13px;
    }
    .back-link a {
        color: rgba(255,255,255,0.4);
        text-decoration: none;
        transition: color 0.3s;
    }
    .back-link a:hover { color: rgba(255,255,255,0.7); }

    @media (max-width: 540px) {
        .verify-card { padding: 36px 24px; }
        .resend-form { flex-direction: column; }
    }
</style>

<div class="verify-page">
    <div class="verify-card">
        <div class="mail-icon-wrapper">📧</div>

        <h1 class="verify-title">Kiểm tra<br><span>hộp thư của bạn!</span></h1>

        <p class="verify-desc">
            Chúng tôi đã gửi email xác nhận đến địa chỉ:
        </p>

        @if($email)
            <div class="email-highlight">{{ $email }}</div>
        @else
            <div class="email-highlight">email của bạn</div>
        @endif

        <div class="steps">
            <div class="steps-title">Các bước tiếp theo</div>
            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-text">Mở email từ <strong style="color:#a5b4fc">GymZone</strong> trong hộp thư đến (hoặc thư mục Spam)</div>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-text">Nhấn vào nút <strong style="color:#a5b4fc">"Xác nhận tài khoản ngay"</strong> trong email</div>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-text">Tài khoản được kích hoạt → Đăng nhập và bắt đầu mua sắm!</div>
            </div>
        </div>

        <div class="divider"></div>

        <p class="resend-label">Không nhận được email? Nhập lại email và gửi lại:</p>

        <form action="{{ route('email.resend') }}" method="POST" class="resend-form">
            @csrf
            <input
                type="email"
                name="email"
                class="resend-input"
                placeholder="email@example.com"
                value="{{ $email ?? '' }}"
                required
            >
            <button type="submit" class="resend-btn">Gửi lại</button>
        </form>

        <div class="back-link">
            <a href="{{ url('/login') }}">← Quay về trang đăng nhập</a>
        </div>
    </div>
</div>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Đã gửi lại!',
        text: "{{ session('success') }}",
        timer: 4000,
        showConfirmButton: false,
        background: '#1a1a2e',
        color: '#fff',
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Thông báo',
        text: "{{ session('error') }}",
        background: '#1a1a2e',
        color: '#fff',
        confirmButtonColor: '#6366f1',
    });
</script>
@endif

@endsection
