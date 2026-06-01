<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận lịch tập thử</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="color: #0ea5e9;">XÁC NHẬN LỊCH TẬP THỬ</h2>
    </div>

    <p>Chào <strong>{{ $trial->ho_ten }}</strong>,</p>

    <p>Cảm ơn bạn đã đăng ký trải nghiệm tại <strong>Rise Fitness</strong>. Chúng tôi rất vui mừng thông báo lịch tập thử của bạn đã được xác nhận thành công!</p>

    <div style="background: #f8fafc; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #0ea5e9;">
        <p style="margin: 5px 0;">📅 <strong>Ngày tập:</strong> {{ \Carbon\Carbon::parse($trial->ngay_mong_muon)->format('d/m/Y') }}</p>
        <p style="margin: 5px 0;">⏰ <strong>Giờ tập:</strong> {{ $trial->gio_mong_muon }}</p>
        <p style="margin: 5px 0;">📍 <strong>Cơ sở:</strong> {{ $trial->co_so_tap }}</p>
        <p style="margin: 5px 0;">🏃 <strong>Môn thể thao:</strong> {{ ucfirst($trial->mon_ua_thich) }}</p>
    </div>

    <p>Vui lòng đến đúng giờ để huấn luyện viên có thể hỗ trợ bạn tốt nhất. Đừng quên mang theo trang phục thể thao thoải mái nhé!</p>

    <p>Nếu có bất kỳ thay đổi nào, vui lòng liên hệ với chúng tôi qua Hotline hoặc phản hồi trực tiếp email này.</p>

    <br>
    <p>Trân trọng,</p>
    <p><strong>Đội ngũ Rise Fitness</strong></p>

</body>
</html>
