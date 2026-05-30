<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hóa đơn mua hàng - Rise Fitness & Yoga</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; padding: 20px; color: #1f2937; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); border: 1px solid #e5e7eb;">
        
        <!-- Header -->
        <div style="background-color: #020617; padding: 30px; text-align: center;">
            <h1 style="color: #34A4E0; margin: 0; font-size: 24px; letter-spacing: 2px;">RISE FITNESS & YOGA</h1>
            <p style="color: #9ca3af; margin: 5px 0 0 0; font-size: 14px;">Cảm ơn bạn đã mua hàng của chúng tôi!</p>
        </div>

        <div style="padding: 30px;">
            <h2 style="color: #111827; margin-top: 0; font-size: 18px; border-bottom: 2px solid #f3f4f6; padding-bottom: 10px;">THÔNG TIN ĐƠN HÀNG</h2>
            
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px;">
                <tr>
                    <td style="padding: 6px 0; color: #6b7280; width: 140px;">Khách hàng:</td>
                    <td style="padding: 6px 0; font-weight: 600; color: #111827;">{{ $order->hoten }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #6b7280;">Số điện thoại:</td>
                    <td style="padding: 6px 0; font-weight: 600; color: #111827;">{{ $order->sdt }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #6b7280;">Địa chỉ nhận hàng:</td>
                    <td style="padding: 6px 0; font-weight: 600; color: #111827;">{{ $order->diachigiaohang }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #6b7280;">Phương thức:</td>
                    <td style="padding: 6px 0; font-weight: 600; color: #111827;">{{ $order->phuongthucthanhtoan }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; color: #6b7280;">Ngày đặt hàng:</td>
                    <td style="padding: 6px 0; font-weight: 600; color: #111827;">{{ $order->ngaydathang ? $order->ngaydathang->format('d/m/Y H:i') : '' }}</td>
                </tr>
            </table>

            <h2 style="color: #111827; margin-top: 30px; font-size: 18px; border-bottom: 2px solid #f3f4f6; padding-bottom: 10px;">DANH SÁCH SẢN PHẨM</h2>
            
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 14px;">
                <thead>
                    <tr style="background-color: #f9fafb; border-bottom: 1px solid #e5e7eb;">
                        <th style="text-align: left; padding: 10px; color: #4b5563; font-weight: 600;">Sản phẩm</th>
                        <th style="text-align: center; padding: 10px; color: #4b5563; font-weight: 600;">Số lượng</th>
                        <th style="text-align: right; padding: 10px; color: #4b5563; font-weight: 600;">Đơn giá</th>
                        <th style="text-align: right; padding: 10px; color: #4b5563; font-weight: 600;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 12px 10px; color: #111827; font-weight: 500;">{{ $item['tensp'] }}</td>
                        <td style="padding: 12px 10px; text-align: center; color: #111827;">{{ $item['quantity'] }}</td>
                        <td style="padding: 12px 10px; text-align: right; color: #111827;">{{ number_format($item['giakhuyenmai'], 0, ',', '.') }}đ</td>
                        <td style="padding: 12px 10px; text-align: right; color: #111827; font-weight: 600;">{{ number_format($item['giakhuyenmai'] * $item['quantity'], 0, ',', '.') }}đ</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Tổng thanh toán -->
            <div style="background-color: #f9fafb; border-radius: 8px; padding: 20px; margin-top: 20px; border: 1px solid #e5e7eb;">
                <table style="width: 100%; font-size: 14px; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 6px 0; color: #4b5563;">Tổng tiền sản phẩm:</td>
                        <td style="padding: 6px 0; text-align: right; color: #111827;">{{ number_format($order->tongtien, 0, ',', '.') }}đ</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #4b5563;">Tiền giảm giá:</td>
                        <td style="padding: 6px 0; text-align: right; color: #10b981; font-weight: 500;">-{{ number_format($order->tiengiam, 0, ',', '.') }}đ</td>
                    </tr>
                    <tr>
                        <td style="padding: 6px 0; color: #4b5563;">Phí giao hàng:</td>
                        <td style="padding: 6px 0; text-align: right; color: #111827;">{{ number_format($order->tienphaitra - $order->tongtien + $order->tiengiam, 0, ',', '.') }}đ</td>
                    </tr>
                    <tr style="border-top: 1px dashed #d1d5db;">
                        <td style="padding: 12px 0 0 0; font-size: 16px; font-weight: 700; color: #111827;">TỔNG THANH TOÁN:</td>
                        <td style="padding: 12px 0 0 0; text-align: right; font-size: 18px; font-weight: 700; color: #34A4E0;">{{ number_format($order->tienphaitra, 0, ',', '.') }}đ</td>
                    </tr>
                </table>
            </div>

        </div>

        <!-- Footer -->
        <div style="background-color: #f9fafb; border-top: 1px solid #e5e7eb; padding: 20px; text-align: center; font-size: 12px; color: #6b7280;">
            <p style="margin: 0 0 5px 0;">Rise Fitness & Yoga - 12 Chùa Bộc, Đống Đa, Hà Nội</p>
            <p style="margin: 0;">Hotline: 18006750 | Email: {{ config('mail.from.address', 'nhwquynhto1606@gmail.com') }}</p>
        </div>

    </div>
</body>
</html>
