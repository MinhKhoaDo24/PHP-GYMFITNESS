@extends('admin_layout')
@section('admin_content')

<style>
/* ===================== FORM STYLE ===================== */

.promo-title {
    font-size: 22px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #111;
}

.promo-title i {
    background: #0ea5e9;
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
    background: #f8fafc;
}

/* TEXTAREA */
.promo-textarea {
    border-radius: 12px;
    padding: 12px;
    height: 100px;
    border: 1px solid #d1d5db;
}

/* GRID */
.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

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
}

.btn-footer-submit {
    background: linear-gradient(to right, #0284c7, #0ea5e9);
    color: #fff;
    font-weight: 600;
    border-radius: 12px;
    padding: 12px 28px;
}

</style>

<div class="promo-modal">

    <div class="promo-title mb-3">
        <i class="bi bi-pencil-square"></i>
        Chỉnh sửa đăng ký tập thử
    </div>

    <form method="POST" action="{{ route('dangki.update', $trial->id_dang_ky) }}">
        @csrf
        @method('PUT')

        <div class="grid-2">

            {{-- Họ tên --}}
            <div>
                <label class="promo-label">Họ tên</label>
                <input type="text" class="form-control promo-input" 
                       value="{{ $trial->ho_ten }}" readonly>
            </div>

            {{-- Email --}}
            <div>
                <label class="promo-label">Email</label>
                <input type="email" class="form-control promo-input" 
                       value="{{ $trial->email }}" readonly>
            </div>

            {{-- SĐT --}}
            <div>
                <label class="promo-label">Số điện thoại</label>
                <input type="text" class="form-control promo-input" 
                       value="{{ $trial->so_dien_thoai }}" readonly>
            </div>

            {{-- Ngày tập --}}
            <div>
                <label class="promo-label">Ngày mong muốn</label>
                <input type="date" class="form-control promo-input"
                       value="{{ $trial->ngay_mong_muon }}" readonly>
            </div>

            {{-- Giờ tập --}}
            <div>
                <label class="promo-label">Giờ mong muốn</label>
                <input type="text" class="form-control promo-input"
                       value="{{ $trial->gio_mong_muon }}" readonly>
            </div>

            {{-- Môn thể thao --}}
            <div>
                <label class="promo-label">Môn thể thao ưa thích</label>
                <input type="text" class="form-control promo-input" 
                       value="{{ $trial->mon_ua_thich }}" readonly>
            </div>

            {{-- Cơ sở tập --}}
            <div>
                <label class="promo-label">Cơ sở tập luyện</label>
                <input type="text" class="form-control promo-input"
                       value="{{ $trial->co_so_tap }}" readonly>
            </div>

            {{-- Trạng thái (chỉ trường được sửa) --}}
            <div>
                <label class="promo-label">Trạng thái <span style="color:red">*</span></label>
                @if($errors->has('trangthai'))
                    <br><small class="text-danger" style="color:red; font-style:italic;">{{ $errors->first('trangthai') }}</small>
                @endif
                <select name="trangthai" class="form-select promo-select" @if(in_array($trial->trangthai, [2, 3])) disabled @endif>
                    @if($trial->trangthai == 0)
                        <option value="0" selected>Mới đăng ký</option>
                        <option value="1">Đã xác nhận</option>
                        <option value="3">Hủy</option>
                    @elseif($trial->trangthai == 1)
                        <option value="1" selected>Đã xác nhận</option>
                        <option value="2">Hoàn thành</option>
                        <option value="3">Hủy</option>
                    @elseif($trial->trangthai == 2)
                        <option value="2" selected>Hoàn thành</option>
                    @elseif($trial->trangthai == 3)
                        <option value="3" selected>Hủy</option>
                    @endif
                </select>
                @if(in_array($trial->trangthai, [2, 3]))
                    <small class="text-muted" style="display:block; margin-top:5px; font-size:12px;">(Trạng thái này đã bị đóng băng)</small>
                @endif
            </div>

        </div>

        {{-- Ghi chú --}}
        <div class="mt-3">
            <label class="promo-label">Ghi chú</label>
            <textarea name="ghi_chu" class="form-control promo-textarea">{{ $trial->ghi_chu }}</textarea>
        </div>

        <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('product.index') }}" class="btn btn-footer-cancel">Hủy</a>
            <button type="submit" id="btnUpdate" class="btn btn-footer-submit">Cập nhật</button>
        </div>


    </form>

</div>

@endsection
