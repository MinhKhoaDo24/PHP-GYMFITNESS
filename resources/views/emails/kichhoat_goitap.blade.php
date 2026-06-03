<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gói tập đã được kích hoạt thành công</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f4f4f7; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { text-align: center; border-bottom: 2px solid #eef2f5; padding-bottom: 20px; margin-bottom: 20px; }
        .header h2 { color: #10b981; margin: 0; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .info-table td { padding: 10px 0; border-bottom: 1px solid #f2f2f2; }
        .info-table td.label { font-weight: bold; color: #666; width: 40%; }
        .info-table td.value { text-align: right; font-weight: 600; color: #111; }
        .pt-info { background-color: #f0fdf4; border-left: 4px solid #10b981; padding: 15px; border-radius: 6px; margin: 20px 0; }
        .pt-info h4 { margin-top: 0; color: #10b981; }
        .footer { text-align: center; font-size: 12px; color: #999; margin-top: 30px; border-top: 1px solid #eef2f5; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>RISE FITNESS & YOGA</h2>
            <p style="color: #10b981; font-weight: bold;">GÓI TẬP ĐÃ ĐƯỢC KÍCH HOẠT THÀNH CÔNG!</p>
        </div>
        
        <p>Xin chào <strong>{{ $dangKy->user->hoten }}</strong>,</p>
        <p>Rise Fitness xin thông báo: Gói tập của bạn đã được kích hoạt thành công sau khi xác nhận thanh toán đầy đủ. Chào mừng bạn đến với môi trường tập luyện chuyên nghiệp hàng đầu!</p>
        
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
                <td class="label">Thời gian bắt đầu:</td>
                <td class="value">{{ $dangKy->ngay_bat_dau->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Thời gian kết thúc:</td>
                <td class="value">{{ $dangKy->ngay_ket_thuc->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">Tổng tiền thanh toán:</td>
                <td class="value" style="color: #10b981;">{{ number_format($dangKy->tong_tien, 0, ',', '.') }} VNĐ</td>
            </tr>
        </table>
        
        @if($dangKy->co_pt && $dangKy->pt)
        <div class="pt-info">
            <h4>Huấn luyện viên cá nhân (PT) đồng hành cùng bạn:</h4>
            <p><strong>Họ tên PT:</strong> {{ $dangKy->pt->hoten }}</p>
            <p><strong>Số điện thoại liên hệ:</strong> 0{{ $dangKy->pt->sdt }}</p>
            <p><strong>Email:</strong> {{ $dangKy->pt->email }}</p>
            <p>PT của bạn sẽ chủ động liên hệ trong vòng 24h để sắp xếp lịch hẹn và đo chỉ số cơ thể đầu vào (InBody).</p>
        </div>
        @endif
        
        <p>Bây giờ quý khách có thể đến bất kỳ cơ sở nào của Rise Fitness và đọc <strong>Mã đăng ký: {{ $dangKy->ma_dang_ky }}</strong> hoặc <strong>Số điện thoại</strong> tại quầy lễ tân để nhận thẻ tập và bắt đầu tập luyện.</p>
        
        <div class="footer">
            <p>Rise Fitness & Yoga - Số 12 Chùa Bộc, Đống Đa, Hà Nội</p>
            <p>Hotline: 1900 8888 - Email: support@risefitness.vn</p>
        </div>
    </div>
</body>
</html>
