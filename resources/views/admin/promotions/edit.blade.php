@extends('admin_layout')
@section('admin_content')

<style>
/* ===================== KHUNG FORM (GIỐNG CREATE) ===================== */


/* TITLE */
.promo-title {
    font-size: 22px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #111;
}

.promo-title i {
    background: #0d9488;
    padding: 8px;
    border-radius: 10px;
    color: #fff;
    font-size: 18px;
}

/* LABEL */
.promo-label {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 6px;
    color: #374151;
}

/* INPUT */
.promo-input,
.promo-select {
    border-radius: 12px;
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    background: #fff;
    transition: 0.2s;
}

.promo-input:focus,
.promo-select:focus,
.promo-textarea:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16,185,129,0.25);
    outline: none;
}

/* TEXTAREA */
.promo-textarea {
    border-radius: 12px;
    padding: 12px;
    height: 120px;
    border: 1px solid #d1d5db;
    resize: none;
}

/* GRID */
.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .grid-2 { grid-template-columns: 1fr; }
}

/* BUTTONS */
.btn-footer-cancel {
    background: #e5e7eb;
    color: #374151;
    font-weight: 600;
    border-radius: 12px;
    padding: 12px 28px;
    transition: 0.2s;
    border: none;
}

.btn-footer-cancel:hover { background: #d1d5db; }

.btn-footer-submit {
    background: linear-gradient(to right, #0284c7, #0ea5e9);
    color: #fff;
    font-weight: 600;
    border-radius: 12px;
    padding: 12px 28px;
    border: none;
    transition: 0.2s;
}

.btn-footer-submit:hover {
    opacity: 0.85;
    transform: translateY(-1px);
}
</style>

<!-- ========================= FORM EDIT ========================= -->

<div class="promo-modal">

    <div class="promo-title mb-3">
        <i class="bi bi-pencil-square"></i>
        Chỉnh sửa khuyến mãi
    </div>

    <form method="POST" action="{{ route('khuyenmai.update', $km->id_khuyenmai) }}">
    @csrf
    @method('PUT')

        <div class="grid-2">


            <div>
                <label class="promo-label">Tên chương trình <span style='color: red;'>*</span></label>
                <input type="text" name="ten_khuyenmai"
                       class="form-control promo-input"
                       value="{{ $km->ten_khuyenmai }}" required>
            </div>

            <div>
                <label class="promo-label">Mã code <span style='color: red;'>*</span></label>
                <input type="text" name="ma_code"
                       class="form-control promo-input"
                       value="{{ $km->ma_code }}" required>
            </div>

            <div>
                <label class="promo-label">Loại giảm giá <span style='color: red;'>*</span></label>
                <select name="kieu_giam" class="form-select promo-select">
                    <option value="percent" {{ $km->kieu_giam=='percent'?'selected':'' }}>% Phần trăm</option>
                    <option value="money" {{ $km->kieu_giam=='money'?'selected':'' }}>Giảm tiền</option>
                </select>
            </div>

            <div>
                <label class="promo-label">Giá trị giảm <span style='color: red;'>*</span></label>
                <input type="number" name="gia_tri_giam"
                       class="form-control promo-input"
                       value="{{ $km->gia_tri_giam }}" required>
            </div>

            <div>
                <label class="promo-label">Giảm tối đa (VNĐ)</label>
                <input type="number" name="giam_toi_da"
                       class="form-control promo-input"
                       value="{{ $km->giam_toi_da }}">
            </div>

            <div>
                <label class="promo-label">Đơn hàng tối thiểu </label>
                <input type="number" name="don_toi_thieu"
                       class="form-control promo-input"
                       value="{{ $km->don_toi_thieu }}" >
            </div>

            <div>
                <label class="promo-label">Giới hạn sử dụng </label>
                <input type="number" name="gioi_han_luot"
                       class="form-control promo-input"
                       value="{{ $km->gioi_han_luot }}" >
            </div>

            <div>
                <label class="promo-label">Ngày bắt đầu <span style='color: red;'>*</span></label>
                <input type="date" name="ngay_bat_dau"
                       class="form-control promo-input"
                       value="{{ date('Y-m-d', strtotime($km->ngay_bat_dau)) }}" required>
            </div>

            <div>
                <label class="promo-label">Ngày kết thúc <span style='color: red;'>*</span></label>
                <input type="date" name="ngay_ket_thuc"
                       class="form-control promo-input"
                       value="{{ date('Y-m-d', strtotime($km->ngay_ket_thuc)) }}" required>
            </div>

            <div>
                <label class="promo-label">Trạng thái <span style='color: red;'>*</span></label>
                <select name="trang_thai" class="form-select promo-select">
                    <option value="1" {{ $km->trang_thai==1?'selected':'' }}>Đang hoạt động</option>
                    <option value="0" {{ $km->trang_thai==0?'selected':'' }}>Tạm ngưng</option>
                </select>
            </div>

        </div>

        <div class="mt-3">
            <label class="promo-label">Mô tả</label>
            <textarea name="mo_ta" class="form-control promo-textarea">{{ $km->mo_ta }}</textarea>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('khuyenmai.index') }}" class="btn-footer-cancel">Hủy bỏ</a>
            <button class="btn-footer-submit">Cập nhật</button>
        </div>

    </form>
</div>

@endsection
