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
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
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
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
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

    /* Style cho các ô input & select trong Modal trở nên SIÊU PREMIUM */
    #updateInfoModal .form-control,
    #updateInfoModal .form-select {
        height: 48px !important;
        border-radius: 10px !important;
        padding: 10px 16px !important;
        font-size: 15px !important;
        border: 1px solid #d1d5db !important;
        background-color: #fff !important;
        transition: all 0.2s ease !important;
    }
    #updateInfoModal .form-control:focus,
    #updateInfoModal .form-select:focus {
        border-color: #34A4E0 !important;
        box-shadow: 0 0 0 3px rgba(52, 164, 224, 0.25) !important;
        outline: none !important;
    }
    #updateInfoModal label {
        font-size: 14px;
        color: #4b5563;
        margin-bottom: 6px;
    }
</style>

<div class="order-co">
    <div class="container checkout-section">

        <form action="{{ route('dathang') }}" method="POST" id="checkout">
            @csrf

            @php $u = $showusers->first(); @endphp

            {{-- ==================== THÔNG TIN KHÁCH HÀNG ==================== --}}
            <div class="checkout-card">
                <div class="section-title"><i class="bi bi-person-circle"></i> Thông tin khách hàng nhận hàng</div>

                @if(!$u)
                <div class="alert alert-info d-flex align-items-center mb-3" style="border-radius: 10px;">
                    <i class="bi bi-info-circle-fill me-2" style="font-size: 20px;"></i>
                    <span>Bạn chưa đăng nhập. Vui lòng nhấn <strong>"Cập nhật thông tin nhận hàng"</strong> bên dưới để nhập thông tin giao hàng.</span>
                </div>
                @endif

                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="p-3" style="background: #fafafa; border-radius: 12px; border: 1px solid #f1f5f9; height: 100%;">
                            <div class="mb-3">
                                <span class="info-label text-muted" style="font-size: 13px;">Họ tên khách hàng:</span> <br>
                                <strong class="info-value" id="display_hoten" style="font-size: 16px; color: #1f2937;">{{ optional($u)->hoten ?? 'Chưa cập nhật' }}</strong>
                            </div>
                            <div>
                                <span class="info-label text-muted" style="font-size: 13px;">Địa chỉ Email:</span> <br>
                                <strong class="info-value" id="display_email" style="font-size: 16px; color: #1f2937;">{{ optional($u)->email ?? 'Chưa cập nhật' }}</strong>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3" style="background: #fafafa; border-radius: 12px; border: 1px solid #f1f5f9; height: 100%;">
                            <div class="mb-3">
                                <span class="info-label text-muted" style="font-size: 13px;">Số điện thoại liên hệ:</span> <br>
                                <strong class="info-value" id="display_sdt" style="font-size: 16px; color: #1f2937;">{{ $u ? '0'.$u->sdt : 'Chưa cập nhật' }}</strong>
                            </div>
                            <div>
                                <span class="info-label text-muted" style="font-size: 13px;">Địa chỉ nhận hàng chi tiết:</span> <br>
                                <strong class="info-value" id="display_diachigiaohang" style="font-size: 16px; color: #1f2937;">{{ optional($u)->diachi ?? 'Chưa cập nhật' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Khu vực giao hàng & Phí ship thiết kế SIÊU PREMIUM --}}
                <div class="row mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="p-3" style="background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px; border-left: 5px solid #0284c7;">
                            <div class="d-flex align-items-center">
                                <div style="background: #e0f2fe; color: #0284c7; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; border-radius: 10px; font-size: 22px; margin-right: 14px;">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div>
                                    <div style="font-size: 11px; color: #0369a1; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Khu vực giao hàng</div>
                                    <div class="info-value" id="display_thanh_pho" style="font-size: 16px; font-weight: 800; color: #0c4a6e;">{{ env('STORE_CITY', 'Hà Nội') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3" style="background: #fffbeb; border: 1px solid #fef3c7; border-radius: 12px; border-left: 5px solid #d97706;">
                            <div class="d-flex align-items-center">
                                <div style="background: #fef3c7; color: #d97706; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; border-radius: 10px; font-size: 22px; margin-right: 14px;">
                                    <i class="bi bi-truck"></i>
                                </div>
                                <div>
                                    <div style="font-size: 11px; color: #b45309; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Phí vận chuyển</div>
                                    <div class="info-value" id="display_phi_ship" style="font-size: 16px; font-weight: 800; color: #78350f;">{{ number_format((int)env('SHIPPING_FEE_INSIDE',20000), 0, ',', '.') }}đ</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <button type="button" class="btn btn-outline-main btn-sm px-3 py-2" style="border-radius: 8px; font-weight: 600;" data-toggle="modal" data-target="#updateInfoModal">
                        <i class="fa fa-edit"></i> Cập nhật thông tin nhận hàng
                    </button>
                    <small class="text-muted"><i class="bi bi-info-circle"></i> Đổi địa chỉ / khu vực để cập nhật lại phí ship.</small>
                </div>

                {{-- Hidden --}}
                <input type="hidden" name="id_nd" value="{{ optional($u)->id_nd }}">
                <input type="hidden" id="input_hoten" name="display_hoten" value="{{ optional($u)->hoten }}">
                <input type="hidden" id="input_email" name="display_email" value="{{ optional($u)->email }}">
                <input type="hidden" id="input_sdt" name="display_sdt" value="{{ optional($u)->sdt }}">
                <input type="hidden" id="input_diachigiaohang" name="display_diachigiaohang" value="{{ optional($u)->diachi }}">
            </div>

            {{-- ==================== GIỎ HÀNG ==================== --}}
            <div class="checkout-card">
                <div class="section-title"><i class="bi bi-cart-check"></i> Giỏ hàng</div>

                @php 
                    $total = 0;
                    $totalOriginal = 0;
                    $totalSale = 0;
                    $totalSurcharge = 0;
                    $totalDiscount = 0; 
                @endphp

                <table class="table table-cart table-hover">
                    <thead>
                        <tr>
                            <th>Ảnh</th>
                            <th>Sản phẩm</th>
                            <th>Size</th>
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
                            $giaKM = ($item['giakhuyenmai'] ?? $item['giasp']) + ($item['gia_cong_them'] ?? 0);
                            $line = $giaKM * $item['quantity'];
                            $Thanhtien = $line;
                            $Original_Price = ($item['giasp'] + ($item['gia_cong_them'] ?? 0)) * $item['quantity'];
                            $totalOriginal += $Original_Price;
                            $totalSale += $line;
                            $totalSurcharge += 0;
                        @endphp

                        <tr>
                            <td><img src="{{ asset($item['anhsp']) }}" width="90"></td>
                            <td>{{ $item['tensp'] }}</td>
                            <td class="text-center font-weight-bold" style="color: #ff8c00;">{{ $item['ten_size'] ?? '' }}</td>
                            <td>{{ number_format($item['giasp'] + ($item['gia_cong_them'] ?? 0), 0, ',', '.') }}đ</td>
                            <td>{{ $item['giamgia'] }}%</td>
                            <td>{{ number_format(($item['giakhuyenmai'] ?? $item['giasp']) + ($item['gia_cong_them'] ?? 0), 0, ',', '.') }}đ</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td><strong>{{ number_format($Thanhtien, 0, ',', '.') }}đ</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                @php
                    $total = $totalSale + $totalSurcharge;
                    $totalDiscount = $totalOriginal - $totalSale;
                @endphp

                {{-- Hidden cho tất cả sản phẩm --}}
                @foreach($cart as $item)
                <input type="hidden" name="id_sanpham[]" value="{{ $item['id_sanpham'] }}">
                <input type="hidden" name="soluong[]" value="{{ $item['quantity'] }}">
                <input type="hidden" name="giakhuyenmai[]" value="{{ $item['giakhuyenmai'] }}">
                @endforeach
            </div>

            {{-- ==================== MÀ KHUYẾN MÃI ==================== --}}
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
                <input type="hidden" name="tienphaitra" id="tienphaitra" value="{{ $total + (int) env('SHIPPING_FEE_INSIDE', 20000) }}">
                <input type="hidden" name="thanh_pho" id="thanh_pho_hidden" value="{{ env('STORE_CITY', 'Hà Nội') }}">
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
                    <span class="summary-label">Giá gốc (Sản phẩm):</span>
                    <span class="summary-value">{{ number_format($totalOriginal, 0, ',', '.') }}đ</span>
                </div>

                <div class="summary-row">
                    <span class="summary-label">Giảm giá khuyến mãi:</span>
                    <span class="summary-value text-danger">- {{ number_format($totalDiscount, 0, ',', '.') }}đ</span>
                </div>

                <div class="summary-row">
                    <span class="summary-label">Phí vận chuyển:</span>
                    <span class="summary-value" id="shipping_fee_display">{{ number_format((int)env('SHIPPING_FEE_INSIDE', 20000), 0, ',', '.') }}đ</span>
                </div>

                <div class="summary-row">
                    <span class="summary-label">Giảm giá vouchers:</span>
                    <span class="summary-value text-danger" id="discount_amount">- 0đ</span>
                </div>

                <div class="summary-row" id="shipping_discount_row" style="display: none;">
                    <span class="summary-label">Giảm giá vận chuyển:</span>
                    <span class="summary-value text-danger" id="shipping_discount_amount">- 0đ</span>
                </div>

                <hr>

                <div class="summary-row">
                    <span class="summary-label">Tổng thanh toán:</span>
                    <span class="summary-total" id="total_amount">{{ number_format($total + (int)env('SHIPPING_FEE_INSIDE', 20000), 0, ',', '.') }}đ</span>
                </div>
            </div>

            <input type="hidden" name="tongtien" id="tongtien" value="{{ $total }}">

            <div class="d-flex justify-content-between mt-4">
                <a href="/cart" class="btn btn-outline-main">← Quay lại</a>
                <button type="submit" class="btn btn-main">Đặt hàng</button>
            </div>

        </form>
    </div>
</div>

{{-- ==================== MODAL CẬP NHẬT THÔNG TIN ==================== --}}
<div class="modal fade" id="updateInfoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-gear"></i> Cập nhật thông tin nhận hàng</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-semibold">Họ tên</label>
                            <input type="text" class="form-control" id="modal_hoten" value="{{ optional($u)->hoten }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-semibold">Email</label>
                            <input type="email" class="form-control" id="modal_email" value="{{ optional($u)->email }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-semibold">Số điện thoại</label>
                            <input type="text" class="form-control" id="modal_sdt"
                                pattern="^0\d{9}$" minlength="10" maxlength="10"
                                title="Số điện thoại phải bắt đầu bằng 0 và có 10 chữ số"
                                value="{{ $u ? '0'.$u->sdt : '' }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="fw-semibold">Địa chỉ (số nhà, đường)</label>
                            <input type="text" class="form-control" id="modal_diachi" value="{{ optional($u)->diachi }}" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group mb-2">
                            <label class="fw-semibold">Tỉnh / Thành phố giao hàng</label>
                            <select class="form-control form-select" id="thanh_pho_select">
                                <option value="Hà Nội" selected>Hà Nội</option>
                                <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                                <option value="Đà Nẵng">Đà Nẵng</option>
                                <option value="Hải Phòng">Hải Phòng</option>
                                <option value="Cần Thơ">Cần Thơ</option>
                                <option value="An Giang">An Giang</option>
                                <option value="Bà Rịa - Vũng Tàu">Bà Rịa - Vũng Tàu</option>
                                <option value="Bắc Giang">Bắc Giang</option>
                                <option value="Bắc Kạn">Bắc Kạn</option>
                                <option value="Bạc Liêu">Bạc Liêu</option>
                                <option value="Bắc Ninh">Bắc Ninh</option>
                                <option value="Bến Tre">Bến Tre</option>
                                <option value="Bình Định">Bình Định</option>
                                <option value="Bình Dương">Bình Dương</option>
                                <option value="Bình Phước">Bình Phước</option>
                                <option value="Bình Thuận">Bình Thuận</option>
                                <option value="Cà Mau">Cà Mau</option>
                                <option value="Cao Bằng">Cao Bằng</option>
                                <option value="Đắk Lắk">Đắk Lắk</option>
                                <option value="Đắk Nông">Đắk Nông</option>
                                <option value="Điện Biên">Điện Biên</option>
                                <option value="Đồng Nai">Đồng Nai</option>
                                <option value="Đồng Tháp">Đồng Tháp</option>
                                <option value="Gia Lai">Gia Lai</option>
                                <option value="Hà Giang">Hà Giang</option>
                                <option value="Hà Nam">Hà Nam</option>
                                <option value="Hà Tĩnh">Hà Tĩnh</option>
                                <option value="Hải Dương">Hải Dương</option>
                                <option value="Hậu Giang">Hậu Giang</option>
                                <option value="Hòa Bình">Hòa Bình</option>
                                <option value="Hưng Yên">Hưng Yên</option>
                                <option value="Khánh Hòa">Khánh Hòa</option>
                                <option value="Kiên Giang">Kiên Giang</option>
                                <option value="Kon Tum">Kon Tum</option>
                                <option value="Lai Châu">Lai Châu</option>
                                <option value="Lâm Đồng">Lâm Đồng</option>
                                <option value="Lạng Sơn">Lạng Sơn</option>
                                <option value="Lào Cai">Lào Cai</option>
                                <option value="Long An">Long An</option>
                                <option value="Nam Định">Nam Định</option>
                                <option value="Nghệ An">Nghệ An</option>
                                <option value="Ninh Bình">Ninh Bình</option>
                                <option value="Ninh Thuận">Ninh Thuận</option>
                                <option value="Phú Thọ">Phú Thọ</option>
                                <option value="Phú Yên">Phú Yên</option>
                                <option value="Quảng Bình">Quảng Bình</option>
                                <option value="Quảng Nam">Quảng Nam</option>
                                <option value="Quảng Ngãi">Quảng Ngãi</option>
                                <option value="Quảng Ninh">Quảng Ninh</option>
                                <option value="Quảng Trị">Quảng Trị</option>
                                <option value="Sóc Trăng">Sóc Trăng</option>
                                <option value="Sơn La">Sơn La</option>
                                <option value="Tây Ninh">Tây Ninh</option>
                                <option value="Thái Bình">Thái Bình</option>
                                <option value="Thái Nguyên">Thái Nguyên</option>
                                <option value="Thanh Hóa">Thanh Hóa</option>
                                <option value="Thừa Thiên Huế">Thừa Thiên Huế</option>
                                <option value="Tiền Giang">Tiền Giang</option>
                                <option value="Trà Vinh">Trà Vinh</option>
                                <option value="Tuyên Quang">Tuyên Quang</option>
                                <option value="Vĩnh Long">Vĩnh Long</option>
                                <option value="Vĩnh Phúc">Vĩnh Phúc</option>
                                <option value="Yên Bái">Yên Bái</option>
                            </select>
                            <small class="text-muted mt-1 d-block">
                                Nội thành <strong>{{ number_format((int)env('SHIPPING_FEE_INSIDE',20000), 0, ',', '.') }}đ</strong>
                                &nbsp;|&nbsp; Ngoại tỉnh <strong>{{ number_format((int)env('SHIPPING_FEE_OUTSIDE',35000), 0, ',', '.') }}đ</strong>
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="saveInfoBtn">Lưu thay đổi</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
            </div>
        </div>
    </div>
</div>

{{-- ==================== SCRIPT ==================== --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const originalTotal   = {{ $total }};
const storeCity       = @json(env('STORE_CITY', 'Hà Nội'));
const feeInside       = {{ (int) env('SHIPPING_FEE_INSIDE',  20000) }};
const feeOutside      = {{ (int) env('SHIPPING_FEE_OUTSIDE', 35000) }};

// Tính phí ship dựa theo tỉnh/thành khách chọn
function getShippingFee(city) {
    return city.trim().toLowerCase() === storeCity.trim().toLowerCase() ? feeInside : feeOutside;
}

// Cập nhật tổng tiền hiển thị (không có promo)
function refreshTotal() {
    const city = $('#guest_thanh_pho').length ? $('#guest_thanh_pho').val() : $('#thanh_pho_select').val();
    const fee     = getShippingFee(city);
    const newTotal = originalTotal + fee;

    $('#shipping_fee_display').text(fee.toLocaleString('vi-VN') + 'đ');
    $('#total_amount').text(newTotal.toLocaleString('vi-VN') + 'đ');
    $('#tienphaitra').val(newTotal);
    $('#thanh_pho_hidden').val(city);

    // Reset promo khi đổi tỉnh
    $('#promo_code').val('');
    $('#id_khuyenmai').val('');
    $('#tiengiam').val(0);
    $('#shipping_discount_row').hide();
    $('#discount_amount').text('0đ');
}

// Xử lý nút Lưu trong Modal
$('#saveInfoBtn').on('click', function() {
    const hoten = $('#modal_hoten').val().trim();
    const email = $('#modal_email').val().trim();
    const sdt   = $('#modal_sdt').val().trim();
    const diachi = $('#modal_diachi').val().trim();
    const city  = $('#thanh_pho_select').val();

    // Validate cơ bản
    if (!hoten || !email || !sdt || !diachi) {
        Swal.fire('Thiếu thông tin!', 'Vui lòng điền đầy đủ các trường.', 'warning');
        return;
    }
    const sdtRegex = /^0\d{9}$/;
    if (!sdtRegex.test(sdt)) {
        Swal.fire('Số điện thoại không hợp lệ!', 'Phải bắt đầu bằng 0 và đủ 10 số.', 'error');
        return;
    }

    // Cập nhật hiển thị trên trang checkout
    $('#display_hoten').text(hoten);
    $('#display_email').text(email);
    $('#display_sdt').text(sdt);
    $('#display_diachigiaohang').text(diachi);
    $('#display_thanh_pho').text(city);

    // Cập nhật input hidden để gửi đi khi đặt hàng
    $('#input_hoten').val(hoten);
    $('#input_email').val(email);
    $('#input_sdt').val(sdt);
    $('#input_diachigiaohang').val(diachi);

    // Tính lại phí ship theo tỉnh mới
    refreshTotal();

    // Hiển thị phí ship mới ở card thông tin
    const fee = getShippingFee(city);
    $('#display_phi_ship').text(fee.toLocaleString('vi-VN') + 'đ');

    // Đóng modal và thông báo
    $('#updateInfoModal').modal('hide');
    Swal.fire({
        icon: 'success',
        title: 'Cập nhật thành công!',
        text: 'Thông tin nhận hàng đã được cập nhật.',
        timer: 2000,
        showConfirmButton: false
    });
});

// Áp mã KM
$('#apply_promo').click(function() {
    const city = $('#guest_thanh_pho').length ? $('#guest_thanh_pho').val() : $('#thanh_pho_select').val();
    $.post("{{ route('promo.apply') }}", {
        promo_code: $('#promo_code').val().trim(),
        thanh_pho : city,
        _token    : '{{ csrf_token() }}'
    }, function(res) {
        const fee = getShippingFee(city);

        if (res.success) {
            Swal.fire("Thành công!", res.message, "success");

            if (res.is_freeship) {
    const remainFee = fee - res.discount;
    if (remainFee <= 0) {
        $('#shipping_fee_display').html('<del>' + fee.toLocaleString('vi-VN') + 'đ</del> <span class="text-success fw-bold">Miễn phí</span>');
    } else {
        $('#shipping_fee_display').html('<del>' + fee.toLocaleString('vi-VN') + 'đ</del> <span class="text-warning fw-bold">' + remainFee.toLocaleString('vi-VN') + 'đ</span>');
    }
    $('#shipping_discount_row').show();
    $('#shipping_discount_amount').text('-' + res.discount.toLocaleString('vi-VN') + 'đ');
    $('#discount_amount').text('0đ');
} else {
                // Mã giảm giá thường
                $('#shipping_fee_display').text(fee.toLocaleString('vi-VN') + 'đ');
                $('#shipping_discount_row').hide();
                $('#discount_amount').text('-' + res.discount.toLocaleString('vi-VN') + 'đ');
            }
            
            $('#total_amount').text(res.new_total.toLocaleString('vi-VN') + 'đ');
            $('#id_khuyenmai').val(res.id_khuyenmai);
            $('#tiengiam').val(res.discount);
            $('#tienphaitra').val(res.new_total);
        } else {
            Swal.fire("Lỗi!", res.message, "error");

            // Reset về trạng thái ban đầu
            refreshTotal();
        }
    });
});

// Thay đổi tỉnh/thành của khách guest
$(document).on('change', '#guest_thanh_pho', function() {
    const city = $(this).val();
    $('#thanh_pho_hidden').val(city);
    refreshTotal();
    const fee = getShippingFee(city);
    $('#display_phi_ship').text(fee.toLocaleString('vi-VN') + 'đ');
    $('#display_thanh_pho').text(city);
});

// Khởi tạo khi load trang
$(document).ready(function () {
    // Tự động chọn tỉnh/thành phố trong select khớp với giá trị ẩn ban đầu (STORE_CITY)
    const initialCity = $('#thanh_pho_hidden').val() ? $('#thanh_pho_hidden').val().trim().toLowerCase() : '';
    if (initialCity) {
        $('#thanh_pho_select option').each(function() {
            if ($(this).val().trim().toLowerCase() === initialCity) {
                $(this).prop('selected', true);
                return false; // break loop
            }
        });
        $('#guest_thanh_pho option').each(function() {
            if ($(this).val().trim().toLowerCase() === initialCity) {
                $(this).prop('selected', true);
                return false; // break loop
            }
        });
    }
    refreshTotal();
});

// Chọn hình thức thanh toán
$('#cod').click(() => $('#checkout').attr('action', "{{ route('dathang') }}"));
$('#vnpay').click(() => $('#checkout').attr('action', "{{ route('vnpay') }}"));

// Ràng buộc kiểm tra trước khi đặt hàng (Không cho đặt hàng khi sđt/địa chỉ trống hoặc sđt = 0)
$('#checkout').submit(function(e) {
    const sdt = $('#guest_sdt').length ? $('#guest_sdt').val().trim() : $('#input_sdt').val().trim();
    const diachi = $('#guest_diachi').length ? $('#guest_diachi').val().trim() : $('#input_diachigiaohang').val().trim();
    const hoten = $('#guest_hoten').length ? $('#guest_hoten').val().trim() : $('#input_hoten').val().trim();

    if (!diachi || !sdt || sdt === '0' || sdt === '') {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Thiếu thông tin giao hàng!',
            text: 'Vui lòng điền đầy đủ thông tin nhận hàng trước khi đặt hàng.',
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
