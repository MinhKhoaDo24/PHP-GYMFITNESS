<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Xác nhận đăng ký gói tập</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f7; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #eef2f5; padding-bottom: 20px; margin-bottom: 20px; }
        .header h2 { color: #34A4E0; margin: 0; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 10px 0; border-bottom: 1px solid #f2f2f2; }
        .info-table td.label { font-weight: bold; color: #666; width: 40%; }
        .info-table td.value { text-align: right; font-weight: 600; color: #111; }
        .payment-info { background-color: #f0f9ff; border-left: 4px solid #34A4E0; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .payment-info h4 { margin-top: 0; color: #34A4E0; }
        .footer { text-align: center; font-size: 12px; color: #999; margin-top: 30px; border-top: 1px solid #eef2f5; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>RISE FITNESS & YOGA</h2>
            <p>Cảm ơn quý khách đã đăng ký dịch vụ của chúng tôi!</p>
        </div>
        
        <p>Xin chào <strong>{{ $dangKy->user->hoten }}</strong>,</p>
        <p>Yêu cầu đăng ký gói tập của bạn đã được tiếp nhận thành công. Dưới đây là thông tin chi tiết:</p>
        
        <table class="info-table">
            <tr>
                <td class="label">Mã đăng ký:</td>
                <td class="value">{{ $dangKy->ma_dang_ky }}</td>
            </tr>
            <tr>
                <td class="label">Gói tập:</td>
                <td class="value">{{ $dangKy->packagePrice->goitap->ten_goi }}</td>
            </tr>
            <tr>
                <td class="label">Dịch vụ:</td>
                <td class="value">{{ $dangKy->packagePrice->goitap->mo_ta_ngan }}</td>
            </tr>
            <tr>
                <td class="label">Thời hạn:</td>
                <td class="value">{{ $dangKy->packagePrice->so_thang }} tháng</td>
            </tr>
            <tr>
                <td class="label">Huấn luyện viên (PT):</td>
                <td class="value">{{ $dangKy->co_pt ? 'Có kèm PT chuyên nghiệp' : 'Không kèm PT' }}</td>
            </tr>
            <tr style="font-size: 18px; border-top: 2px solid #34A4E0;">
                <td class="label" style="color: #34A4E0; padding-top: 15px;">Tổng cộng:</td>
                <td class="value" style="color: #34A4E0; padding-top: 15px;">{{ number_format($dangKy->tong_tien, 0, ',', '.') }} VNĐ</td>
            </tr>
        </table>
        
        <div class="payment-info">
            <h4>Hướng dẫn thanh toán chuyển khoản:</h4>
            <p>Để kích hoạt gói tập, vui lòng chuyển khoản theo thông tin dưới đây:</p>
            <p><strong>Ngân hàng:</strong> MB Bank (Ngân hàng Quân Đội)</p>
            <p><strong>Số tài khoản:</strong> 999988886666</p>
            <p><strong>Chủ tài khoản:</strong> RISE FITNESS VIETNAM</p>
            <p><strong>Số tiền:</strong> {{ number_format($dangKy->tong_tien, 0, ',', '.') }} VNĐ</p>
            <p><strong>Nội dung chuyển khoản:</strong> <span style="background-color: #ffe082; padding: 2px 6px; border-radius: 4px; font-weight: bold; color: #5d4037;">{{ $dangKy->ma_dang_ky }}</span></p>
        </div>
        
        <p>Sau khi nhận được thanh toán, ban quản trị Rise Fitness sẽ phê duyệt và kích hoạt gói tập của quý khách ngay lập tức.</p>
        
        <div class="footer">
            <p>Rise Fitness & Yoga - Số 12 Chùa Bộc, Đống Đa, Hà Nội</p>
            <p>Hotline: 1900 8888 - Email: support@risefitness.vn</p>
        </div>
    </div>
</body>
</html>
