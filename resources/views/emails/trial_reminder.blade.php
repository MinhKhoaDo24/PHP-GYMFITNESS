<!DOCTYPE html>
<html>
<head>
    <title>Rise Fitness – Nhắc nhở lịch tập thử</title>
</head>
<body style="font-family: 'Inter', sans-serif; line-height: 1.6; color: #222; max-width: 600px; margin: 0 auto; padding: 20px; background:#fafafa;">
    <div style="text-align:center; margin-bottom:20px;">
        <h2 style="color:#2563eb;">🚀 BỨT PHÁ GIỚI HẠN CỦA BẠN</h2>
        <h3 style="margin-top:5px; color:#111;">Lịch tập thử đang tới!</h3>
    </div>

    <p>Chào <strong>{{ $trial->ho_ten }}</strong>,</p>

    <p>GymZone xin nhắc bạn rằng buổi <strong>luyện tập thử</strong> sẽ diễn ra vào <strong>NGÀY MAI</strong>. Đừng bỏ lỡ cơ hội trải nghiệm không gian hiện đại và các chương trình tập luyện đặc biệt của chúng tôi.</p>

    <div style="background:#e0f2fe; padding:15px; border-radius:8px; margin:20px 0; border-left:4px solid #2563eb;">
        <p style="margin:5px 0;">📅 <strong>Ngày:</strong> {{ \Carbon\Carbon::parse($trial->ngay_mong_muon)->format('d/m/Y') }}</p>
        <p style="margin:5px 0;">⏰ <strong>Giờ:</strong> {{ $trial->gio_mong_muon }}</p>
        <p style="margin:5px 0;">📍 <strong>Địa điểm:</strong> {{ $trial->co_so_tap }}</p>
    </div>

    <p>Hãy chuẩn bị trang phục thể thao, năng lượng tích cực và sẵn sàng chinh phục những thử thách mới. Chúng tôi sẽ đón chào bạn với sự nhiệt tình và chuyên nghiệp.</p>

    <p>Hẹn gặp lại bạn tại <strong>Rise Fitness</strong>!</p>

    <br>
    <p>Trân trọng,</p>
    <p><strong>Đội ngũ Rise Fitness</strong></p>
</body>
</html>
