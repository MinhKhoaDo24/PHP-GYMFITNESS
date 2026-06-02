<!DOCTYPE html>
<html>
<head>
    <title>Đặt lại mật khẩu</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">

    <div style="text-align: center; margin-bottom: 20px;">
        <h2 style="color: #0ea5e9;">ĐẶT LẠI MẬT KHẨU</h2>
    </div>

    <p>Chào bạn,</p>

    <p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn tại <strong>Rise Fitness</strong>.</p>

    <div style="background: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #0ea5e9; text-align: center;">
        <p>Nhấn vào nút bên dưới để đặt lại mật khẩu:</p>

        <a href="{{ url('/reset-password/'.$token) }}"
           style="display: inline-block;
                  background-color: #0ea5e9;
                  color: #ffffff;
                  text-decoration: none;
                  padding: 12px 24px;
                  border-radius: 6px;
                  font-weight: bold;">
            Đặt lại mật khẩu
        </a>
    </div>

    <p>Liên kết này chỉ có hiệu lực trong một khoảng thời gian nhất định vì lý do bảo mật.</p>

    <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này. Mật khẩu hiện tại của bạn sẽ không bị thay đổi.</p>

    <br>

    <p>Trân trọng,</p>
    <p><strong>Đội ngũ Rise Fitness</strong></p>

</body>
</html>