<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Thông tin tài khoản đăng nhập – Rise Fitness</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f7; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #eef2f5; padding-bottom: 20px; margin-bottom: 20px; }
        .header h2 { color: #0d9488; margin: 0; }
        .credentials-box { background: #f0fdfa; border: 2px solid #0d9488; border-radius: 10px; padding: 20px 24px; margin: 20px 0; }
        .credentials-box h4 { color: #0d9488; margin-top: 0; }
        .credential-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #ccfbf1; }
        .credential-row:last-child { border-bottom: none; }
        .credential-label { color: #666; font-weight: 600; }
        .credential-value { font-weight: 700; color: #111; font-size: 15px; letter-spacing: 0.5px; }
        .warning-box { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 14px 18px; border-radius: 6px; margin: 20px 0; font-size: 14px; color: #78350f; }
        .warning-box strong { display: block; margin-bottom: 4px; }
        .footer { text-align: center; font-size: 12px; color: #999; margin-top: 30px; border-top: 1px solid #eef2f5; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>RISE FITNESS &amp; YOGA</h2>
            <p style="color: #0d9488; font-weight: bold;">THÔNG TIN TÀI KHOẢN ĐĂNG NHẬP</p>
        </div>

        <p>Xin chào <strong>{{ $hoTen }}</strong>,</p>
        <p>Quản trị viên Rise Fitness đã tạo tài khoản nhân viên cho bạn. Dưới đây là thông tin đăng nhập của bạn:</p>

        <div class="credentials-box">
            <h4>🔐 Thông tin đăng nhập</h4>
            <div class="credential-row">
                <span class="credential-label">Địa chỉ đăng nhập:</span>
                <span class="credential-value">{{ url('/login') }}</span>
            </div>
            <div class="credential-row">
                <span class="credential-label">Email:</span>
                <span class="credential-value">{{ $email }}</span>
            </div>
            <div class="credential-row">
                <span class="credential-label">Mật khẩu tạm thời:</span>
                <span class="credential-value">{{ $matKhauGoc }}</span>
            </div>
        </div>

        <div class="warning-box">
            <strong>⚠️ Lưu ý quan trọng về bảo mật:</strong>
            Đây là mật khẩu tạm thời do hệ thống tự tạo. Sau khi đăng nhập lần đầu, vui lòng đổi mật khẩu ngay lập tức tại trang <strong>Hồ sơ cá nhân</strong> để bảo vệ tài khoản của bạn.
        </div>

        <p>Nếu bạn gặp bất kỳ vấn đề gì khi đăng nhập, hãy liên hệ ngay với bộ phận quản lý.</p>

        <div class="footer">
            <p>Rise Fitness &amp; Yoga – Số 12 Chùa Bộc, Đống Đa, Hà Nội</p>
            <p>Hotline: 1900 8888 – Email: support@risefitness.vn</p>
        </div>
    </div>
</body>
</html>
