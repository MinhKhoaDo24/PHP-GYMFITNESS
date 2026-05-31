<!DOCTYPE html>
<html>
<head>
    <title>Nhắc nhở lịch tập thử</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    
    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="color: #f59e0b;">NHẮC NHỞ LỊCH TẬP THỬ</h2>
    </div>

    <p>Chào <strong>{{ $trial->ho_ten }}</strong>,</p>

    <p>Rise Fitness xin gửi lời nhắc nhở nhỏ: Lịch tập thử của bạn sẽ diễn ra vào <strong>NGÀY MAI</strong>!</p>

    <div style="background: #fffbeb; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b;">
        <p style="margin: 5px 0;">📅 <strong>Ngày tập:</strong> {{ \Carbon\Carbon::parse($trial->ngay_mong_muon)->format('d/m/Y') }}</p>
        <p style="margin: 5px 0;">⏰ <strong>Giờ tập:</strong> {{ $trial->gio_mong_muon }}</p>
        <p style="margin: 5px 0;">📍 <strong>Cơ sở:</strong> {{ $trial->co_so_tap }}</p>
    </div>

    <p>Chúng tôi đã chuẩn bị sẵn sàng để đón tiếp bạn. Đừng quên mang theo trang phục thể thao và một tinh thần tràn đầy năng lượng nhé!</p>

    <p>Hẹn gặp lại bạn tại phòng tập!</p>

    <br>
    <p>Trân trọng,</p>
    <p><strong>Đội ngũ Rise Fitness</strong></p>

</body>
</html>
