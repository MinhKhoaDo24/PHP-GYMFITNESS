@extends('layout')
@section('content')

<style>
    .order-co {
        background-image: url('/frontend/img/boxing-slide-1.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    .checkout-card {
        background: #fff;
        padding: 25px 28px;
        border-radius: 18px;
        box-shadow: 0 4px 18px rgba(0,0,0,0.08);
        margin-bottom: 25px;
        border: 1px solid #e5e7eb;
    }

    .section-title {
        font-size: 22px;
        font-weight: 800;
        color: #111827;
        margin-bottom: 15px;
    }

    .info-label {
        color: #6B7280;
        font-weight: 600;
    }

    .info-value {
        color: #111827;
        font-weight: 600;
    }

    .table-cart thead th {
        background: #34A4E0 !important;
        color: #fff;
        padding: 12px;
        text-transform: uppercase;
        font-size: 13px;
    }

    .table-cart tbody td {
        vertical-align: middle;
        font-size: 16px;
        color: #111;
    }

    .btn-main {
        background: #34A4E0;
        color: #fff;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 10px;
        transition: .25s;
    }

    .btn-main:hover {
        background: #1B8AC3;
        color: #fff;
    }

    .btn-outline-main {
        border: 2px solid #34A4E0;
        color: #34A4E0;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 10px;
        background: transparent;
        transition: .25s;
    }

    .btn-outline-main:hover {
        background: #34A4E0;
        color: #fff;
    }

    .promo-group {
        display: flex;
        width: 100%;
    }

    .promo-input {
        flex: 1;
        padding: 12px 16px;
        border: 1px solid #d1d5db;
        border-right: none;
        border-radius: 8px 0 0 8px;
        font-size: 16px;
    }

    .promo-btn {
        background: #34A4E0;
        color: #fff;
        padding: 0 26px;
        border: 1px solid #34A4E0;
        border-radius: 0 8px 8px 0;
        font-weight: 600;
        cursor: pointer;
        transition: .2s;
    }

    .promo-btn:hover {
        background: #1B8AC3;
    }

    .checkout-summary-box {
        background: #fff;
        padding: 20px 24px;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        max-width: 380px;
        margin-left: auto;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        margin-bottom: 10px;
    }

    .summary-label {
        color: #6B7280;
        font-weight: 600;
    }

    .summary-value {
        font-weight: 700;
        color: #111827;
    }

    .summary-total {
        font-size: 28px;
        font-weight: 800;
        color: #34A4E0;
    }
</style>

<div class="order-co">
<div class="container checkout-section">

<form action="{{ route('dathang') }}" method="POST" id="checkout">
@csrf

@php $u = $showusers->first(); @endphp

{{-- ==================== THÔNG TIN KHÁCH HÀNG ==================== --}}
<div class="checkout-card">
    <div class="section-title"><i class="bi bi-person-circle"></i> Thông tin khách hàng</div>

    <div class="row mb-3">
        <div class="col-md-6">
            <div><span class="info-label">Khách hàng:</span> <span class="info-value" id="display_hoten">{{ $u->hoten }}</span></div>
            <div><span class="info-label">Email:</span> <span class="info-value" id="display_email">{{ $u->email }}</span></div>
        </div>
        <div class="col-md-6">
            <div><span class="info-label">Số điện thoại:</span> <span class="info-value" id="display_sdt">0{{ $u->sdt }}</span></div>
            <div><span class="info-label">Địa chỉ:</span> <span class="info-value" id="display_diachigiaohang">{{ $u->diachi }}</span></div>
        </div>
    </div>

    <button type="button" class="btn btn-outline-main btn-sm" data-bs-toggle="modal" data-bs-target="#updateInfoModal">
        <i class="fa fa-edit"></i> Cập nhật thông tin
    </button>

    {{-- Hidden --}}
    <input type="hidden" name="id_nd" value="{{ $u->id_nd }}">
    <input type="hidden" id="input_hoten" name="display_hoten" value="{{ $u->hoten }}">
    <input type="hidden" id="input_email" name="display_email" value="{{ $u->email }}">
    <input type="hidden" id="input_sdt" name="display_sdt" value="{{ $u->sdt }}">
    <input type="hidden" id="input_diachigiaohang" name="display_diachigiaohang" value="{{ $u->diachi }}">
</div>



{{-- ==================== GIỎ HÀNG ==================== --}}
<div class="checkout-card">
    <div class="section-title"><i class="bi bi-cart-check"></i> Giỏ hàng</div>

    @php $total = 0; @endphp

    <table class="table table-cart table-hover">
        <thead>
            <tr>
                <th>Ảnh</th>
                <th>Sản phẩm</th>
                <th>Giá gốc</th>
                <th>Giảm</th>
                <th>Giá KM</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>

        <tbody>
            @foreach($cart as $item)
                @php
                    $line = $item['giakhuyenmai'] * $item['quantity'];
                    $total += $line;
                @endphp

                <tr>
                    <td><img src="{{ asset($item['anhsp']) }}" width="90"></td>
                    <td>{{ $item['tensp'] }}</td>
                    <td>{{ number_format($item['giasp']) }}đ</td>
                    <td>{{ $item['giamgia'] }}%</td>
                    <td>{{ number_format($item['giakhuyenmai']) }}đ</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td><strong>{{ number_format($line) }}đ</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Hidden cho tất cả sản phẩm --}}
    @foreach(session('cart') as $item)
        <input type="hidden" name="id_sanpham[]" value="{{ $item['id_sanpham'] }}">
        <input type="hidden" name="soluong[]" value="{{ $item['quantity'] }}">
        <input type="hidden" name="giakhuyenmai[]" value="{{ $item['giakhuyenmai'] }}">
    @endforeach
</div>



{{-- ==================== MÃ KHUYẾN MÃI ==================== --}}
<div class="checkout-card">
    <div class="section-title"><i class="bi bi-ticket-perforated"></i> Mã khuyến mãi</div>

    <div class="promo-group">
        <input type="text" id="promo_code" name="ma_khuyen_mai" class="promo-input"
            placeholder="Nhập mã khuyến mãi...">
        <button type="button" id="apply_promo" class="promo-btn">Áp dụng</button>
    </div>

    <p id="promo_message" class="mt-2 fw-bold"></p>

    <!-- Hidden lưu ID thật -->
    <input type="hidden" name="id_khuyenmai" id="id_khuyenmai" value="">

    <input type="hidden" name="tiengiam" id="tiengiam" value="0">
    <input type="hidden" name="tienphaitra" id="tienphaitra" value="{{ $total + 25000 }}">

</div>



{{-- ==================== THÔNG TIN THANH TOÁN ==================== --}}
<div class="checkout-card">
    <div class="section-title"><i class="bi bi-credit-card-2-back"></i> Phương thức thanh toán</div>

    <label class="d-flex align-items-center mb-2">
        <input type="radio" name="redirect" id="cod" value="COD" checked>
        <span class="ml-3">Thanh toán khi nhận hàng (COD)</span>
    </label>

    <label class="d-flex align-items-center">
        <input type="radio" name="redirect" id="vnpay" value="VNPAY">
        <span class="ml-3">Thanh toán online (VNPay)</span>
    </label>
</div>



{{-- ==================== TỔNG TIỀN ==================== --}}
<div class="checkout-summary-box">
    <div class="summary-row">
        <span class="summary-label">Tạm tính (Tiền hàng):</span>
        <span class="summary-value">{{ number_format($total) }}đ</span>
    </div>

    <div class="summary-row">
        <span class="summary-label">Phí vận chuyển:</span>
        <span class="summary-value" id="shipping_fee_display">25.000đ</span>
    </div>

    <div class="summary-row">
        <span class="summary-label">Giảm giá sản phẩm:</span>
        <span class="summary-value text-danger" id="discount_amount">0đ</span>
    </div>

    <div class="summary-row" id="shipping_discount_row" style="display: none;">
        <span class="summary-label">Giảm giá vận chuyển:</span>
        <span class="summary-value text-danger" id="shipping_discount_amount">-25.000đ</span>
    </div>

    <hr>

    <div class="summary-row">
        <span class="summary-label">Tổng thanh toán:</span>
        <span class="summary-total" id="total_amount">{{ number_format($total + 25000) }}đ</span>
    </div>
</div>

<input type="hidden" name="tongtien" id="tongtien" value="{{ $total }}">

<div class="d-flex justify-content-between mt-4">
    <a href="/cart" class="btn btn-outline-main">← Quay lại</a>
    <button type="submit" class="btn btn-main">Đặt hàng</button>
</div>

</form>
</div>



{{-- ==================== MODAL UPDATE USER ==================== --}}
<div class="modal fade" id="updateInfoModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="updateInfoForm" action="{{ route('profile.update') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="id_nd" value="{{ $u->id_nd }}">

            <div class="modal-header">
                <h5 class="modal-title">Cập nhật thông tin khách hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="form-group mb-3">
                    <label>Họ tên</label>
                    <input type="text" class="form-control" id="hoten" name="hoten" value="{{ $u->hoten }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $u->email }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Số điện thoại</label>
                    <input type="text" class="form-control" id="sdt" name="sdt"
                        pattern="^0\d{9}$" minlength="10" maxlength="10"
                        title="Số điện thoại phải bắt đầu bằng 0 và có 10 chữ số"
                        value="0{{ $u->sdt }}" required>
                </div>

                <div class="form-group mb-3">
                    <label>Địa chỉ</label>
                    <input type="text" class="form-control" id="diachi" name="diachi" value="{{ $u->diachi }}" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
            </div>
        </form>
    </div>
</div>


{{-- ==================== SCRIPT ==================== --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const originalTotal = {{ $total }};
const originalTotalWithShip = {{ $total + 25000 }};

// Xử lý submit Form cập nhật thông tin trong Modal (Không load lại trang)
$('#updateInfoForm').submit(function(e) {
    e.preventDefault();
    
    const hoten = $('#hoten').val().trim();
    const email = $('#email').val().trim();
    const sdt = $('#sdt').val().trim();
    const diachi = $('#diachi').val().trim();
    
    // Cập nhật text hiển thị trên trang checkout
    $('#display_hoten').text(hoten);
    $('#display_email').text(email);
    $('#display_sdt').text(sdt);
    $('#display_diachigiaohang').text(diachi);
    
    // Cập nhật giá trị vào các input hidden để gửi đi khi đặt hàng
    $('#input_hoten').val(hoten);
    $('#input_email').val(email);
    $('#input_sdt').val(sdt);
    $('#input_diachigiaohang').val(diachi);
    
    // Đóng Modal
    $('#updateInfoModal').modal('hide');
    
    // Thông báo bằng SweetAlert2
    Swal.fire({
        icon: 'success',
        title: 'Cập nhật thành công!',
        text: 'Thông tin nhận hàng đã được cập nhật mới.',
        timer: 2000,
        showConfirmButton: false
    });
});

// Áp mã KM
$('#apply_promo').click(function() {
    $.post("{{ route('promo.apply') }}", {
        promo_code: $('#promo_code').val().trim(),
        _token: '{{ csrf_token() }}'
    }, function(res) {

        if (res.success) {
            Swal.fire("Thành công!", res.message, "success");

            if (res.is_freeship) {
                // Nếu là mã freeship
                $('#shipping_fee_display').html('<del>25.000đ</del> <span class="text-success fw-bold">Miễn phí</span>');
                $('#shipping_discount_row').show();
                $('#discount_amount').text("0đ");
            } else {
                // Nếu là mã giảm giá sản phẩm bình thường
                $('#shipping_fee_display').text("25.000đ");
                $('#shipping_discount_row').hide();
                $('#discount_amount').text('-' + res.discount.toLocaleString() + "đ");
            }
            
            $('#total_amount').text(res.new_total.toLocaleString() + "đ");

            $('#id_khuyenmai').val(res.id_khuyenmai);
            $('#tiengiam').val(res.discount);
            $('#tienphaitra').val(res.new_total);
        } else {
            Swal.fire("Lỗi!", res.message, "error");

            // Reset về trạng thái ban đầu
            $('#shipping_fee_display').text("25.000đ");
            $('#shipping_discount_row').hide();
            $('#discount_amount').text("0đ");
            $('#total_amount').text(originalTotalWithShip.toLocaleString() + "đ");

            $('#id_khuyenmai').val('');
            $('#tiengiam').val(0);
            $('#tienphaitra').val(originalTotalWithShip);
        }
    });

});

// Reset KM khi load trang
$(document).ready(function () {
    $('#promo_code').val('');
    $('#shipping_fee_display').text("25.000đ");
    $('#shipping_discount_row').hide();
    $('#discount_amount').text("0đ");
    $('#total_amount').text(originalTotalWithShip.toLocaleString() + "đ");
});

// Chọn hình thức thanh toán
$('#cod').click(() => $('#checkout').attr('action', "{{ route('dathang') }}"));
$('#vnpay').click(() => $('#checkout').attr('action', "{{ route('vnpay') }}"));

// Ràng buộc kiểm tra trước khi đặt hàng (Không cho đặt hàng khi sđt/địa chỉ trống hoặc sđt = 0)
$('#checkout').submit(function(e) {
    const sdt = $('#input_sdt').val().trim();
    const diachi = $('#input_diachigiaohang').val().trim();
    const hoten = $('#input_hoten').val().trim();

    if (!diachi || !sdt || sdt === '0' || sdt === '') {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Thiếu thông tin giao hàng!',
            text: 'Vui lòng bấm nút "Cập nhật thông tin" để cập nhật Số điện thoại và Địa chỉ giao hàng trước khi đặt hàng.',
            confirmButtonText: 'Đồng ý'
        });
        return false;
    }

    const sdtRegex = /^(0\d{9}|\d{9})$/;
    if (!sdtRegex.test(sdt)) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Số điện thoại không hợp lệ!',
            text: 'Số điện thoại phải gồm 10 chữ số bắt đầu bằng số 0 (hoặc 9 chữ số nếu không có số 0 ở đầu). Vui lòng cập nhật lại!',
            confirmButtonText: 'Đồng ý'
        });
        return false;
    }
});

// Hiển thị thông báo flash từ server (nếu có) bằng SweetAlert2
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Thành công!',
        text: "{{ session('success') }}",
        confirmButtonText: 'Đồng ý'
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Lỗi!',
        text: "{{ session('error') }}",
        confirmButtonText: 'Đồng ý'
    });
@endif

@if($errors->any())
    Swal.fire({
        icon: 'error',
        title: 'Lỗi dữ liệu!',
        text: "{{ $errors->first() }}",
        confirmButtonText: 'Đồng ý'
    });
@endif

</script>

@endsection