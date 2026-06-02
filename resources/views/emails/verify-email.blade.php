<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận tài khoản GymZone</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #0f0f1a;
            color: #333;
        }
        .wrapper {
            max-width: 620px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        /* Header */
        .header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            padding: 48px 40px 36px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(99,102,241,0.15) 0%, transparent 60%);
        }
        .logo-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 20px;
            box-shadow: 0 8px 32px rgba(99,102,241,0.4);
        }
        .brand-name {
            font-size: 28px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: 1px;
        }
        .brand-tagline {
            font-size: 13px;
            color: rgba(255,255,255,0.6);
            margin-top: 6px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        /* Body */
        .body {
            padding: 48px 40px;
            background: #ffffff;
        }
        .greeting {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 16px;
        }
        .message {
            font-size: 15px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 32px;
        }
        .message strong {
            color: #1a1a2e;
        }
        /* CTA Button */
        .cta-wrapper {
            text-align: center;
            margin: 36px 0;
        }
        .cta-btn {
            display: inline-block;
            padding: 16px 48px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 8px 32px rgba(99,102,241,0.4);
            transition: all 0.3s ease;
        }
        /* Info boxes */
        .info-box {
            background: #f8f9ff;
            border-left: 4px solid #6366f1;
            border-radius: 8px;
            padding: 16px 20px;
            margin: 24px 0;
            font-size: 14px;
            color: #555;
            line-height: 1.6;
        }
        .info-box .label {
            font-weight: 700;
            color: #6366f1;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }
        /* URL fallback */
        .url-fallback {
            background: #f1f5f9;
            border-radius: 8px;
            padding: 14px 20px;
            word-break: break-all;
            font-size: 12px;
            color: #6366f1;
            font-family: monospace;
            margin: 16px 0;
        }
        /* Features */
        .features {
            display: flex;
            gap: 16px;
            margin: 32px 0;
        }
        .feature {
            flex: 1;
            text-align: center;
            padding: 20px 12px;
            background: #f8f9ff;
            border-radius: 12px;
        }
        .feature-icon { font-size: 28px; margin-bottom: 8px; }
        .feature-title { font-size: 12px; font-weight: 700; color: #1a1a2e; }
        /* Footer */
        .footer {
            background: #f8f9ff;
            padding: 28px 40px;
            text-align: center;
            border-top: 1px solid #e8ecf8;
        }
        .footer p {
            font-size: 12px;
            color: #999;
            line-height: 1.7;
        }
        .footer a { color: #6366f1; text-decoration: none; }
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e8ecf8, transparent);
            margin: 24px 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Header -->
        <div class="header">
            <div class="logo-icon">🏋️</div>
            <div class="brand-name">GymZone</div>
            <div class="brand-tagline">Bứt phá giới hạn của bạn</div>
        </div>

        <!-- Body -->
        <div class="body">
            <p class="greeting">Xin chào, {{ $hoten }}! 👋</p>

            <p class="message">
                Cảm ơn bạn đã đăng ký tài khoản tại <strong>Rise Fitness</strong>.<br>
                Bạn chỉ còn <strong>một bước nữa</strong> để bắt đầu hành trình chinh phục mục tiêu hình thể!
            </p>

            <!-- Features -->
            <div class="features">
                <div class="feature">
                    <div class="feature-icon">🛒</div>
                    <div class="feature-title">Mua sắm sản phẩm</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">🎟️</div>
                    <div class="feature-title">Nhận ưu đãi VIP</div>
                </div>
                <div class="feature">
                    <div class="feature-icon">📦</div>
                    <div class="feature-title">Theo dõi đơn hàng</div>
                </div>
            </div>

            <div class="divider"></div>

            <p class="message">
                Nhấn vào nút bên dưới để <strong>xác nhận địa chỉ email</strong> và kích hoạt tài khoản của bạn:
            </p>

            <!-- CTA -->
            <div class="cta-wrapper">
                <a href="{{ $verifyUrl }}" class="cta-btn">
                    ✅ &nbsp; Xác nhận tài khoản ngay
                </a>
            </div>

            <div class="info-box">
                <div class="label">⏰ Lưu ý quan trọng</div>
                Link xác nhận sẽ <strong>hết hạn sau 24 giờ</strong>. Nếu bạn không nhấn xác nhận trong thời gian này, bạn sẽ cần đăng ký lại.
            </div>

            <p style="font-size: 13px; color: #888; margin-bottom: 8px;">
                Nếu nút không hoạt động, hãy copy đường dẫn sau vào trình duyệt:
            </p>
            <div class="url-fallback">{{ $verifyUrl }}</div>

            <div class="divider"></div>

            <p style="font-size: 13px; color: #aaa;">
                Nếu bạn không thực hiện đăng ký này, vui lòng bỏ qua email này. Tài khoản sẽ KHÔNG được tạo.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                © {{ date('Y') }} <strong>Rise Fitness</strong> – Tất cả quyền được bảo lưu.<br>
                Email này được gửi tự động, vui lòng không trả lời.<br>
                <a href="{{ url('/') }}">Trang chủ Rise Fitness</a>
            </p>
        </div>
    </div>
</body>
</html>
