@extends('admin_layout')
@section('admin_content')

<style>
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

.promo-label {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 6px;
    color: #374151;
}

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

.promo-textarea {
    border-radius: 12px;
    padding: 12px;
    height: 120px;
    border: 1px solid #d1d5db;
    resize: none;
}

.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media (max-width: 768px) {
    .grid-2 { grid-template-columns: 1fr; }
}

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

<div class="promo-modal">

    <div class="promo-title mb-3">
        <i class="bi bi-bookmark-plus"></i>
        Tạo khuyến mãi mới
    </div>

    <form action="{{ route('khuyenmai.store') }}" method="POST" id="form-create-promo">
        @csrf

        @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid-2">

            <div>
                <label class="promo-label">Tên chương trình <span style='color: red;'>*</span></label>
                <input type="text" name="ten_khuyenmai" class="form-control promo-input" placeholder="VD: Giảm giá mùa hè" required>
            </div>

            <div>
                <label class="promo-label">Mã code <span style='color: red;'>*</span></label>
                <input type="text" name="ma_code" class="form-control promo-input" placeholder="VD: SUMMER2024" required>
            </div>

            <div>
                <label class="promo-label">Loại giảm giá <span style='color: red;'>*</span></label>
                <select name="kieu_giam" class="form-select promo-select" id="kieu_giam_create">
                    <option value="percent">% Phần trăm</option>
                    <option value="money">Giảm tiền</option>
                    <option value="freeship">Miễn phí vận chuyển</option>
                </select>
            </div>

            <div>
                <label class="promo-label">Giá trị giảm <span style='color: red;'>*</span></label>
                <input type="number" name="gia_tri_giam" class="form-control promo-input" id="gia_tri_giam_create" value="0" min="-1" required>
            </div>

            <div>
                <label class="promo-label">Giảm tối đa (VNĐ)</label>
                <input type="number" name="giam_toi_da" class="form-control promo-input">
            </div>

            <div>
                <label class="promo-label">Đơn hàng tối thiểu (VNĐ) *</label>
                <input type="number" name="don_toi_thieu" class="form-control promo-input" value="0" required>
            </div>

            <div>
                <label class="promo-label">Giới hạn sử dụng</label>
                <input type="number" name="gioi_han_luot" class="form-control promo-input">
            </div>

            <div>
                <label class="promo-label">Ngày bắt đầu <span style='color: red;'>*</span></label>
                <input type="date" name="ngay_bat_dau" class="form-control promo-input" required>
            </div>

            <div>
                <label class="promo-label">Ngày kết thúc <span style='color: red;'>*</span></label>
                <input type="date" name="ngay_ket_thuc" class="form-control promo-input" required>
                <div id="date-error-create" style="display:none; color:#dc3545; font-size:13px; margin-top:4px;">
                    <i class="bi bi-exclamation-circle"></i> Ngày kết thúc phải sau ngày bắt đầu.
                </div>
            </div>

        </div>

        <div class="mt-3">
            <label class="promo-label">Mô tả</label>
            <textarea name="mo_ta" class="form-control promo-textarea" placeholder="Mô tả chi tiết về chương trình khuyến mãi..."></textarea>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('khuyenmai.index') }}" class="btn btn-footer-cancel">Hủy bỏ</a>
            <button type="submit" class="btn btn-footer-submit">Tạo mới</button>
        </div>

    </form>

    @endif

</div>

<script>
function toggleGiaTriCreate(val) {
    const input = document.getElementById('gia_tri_giam_create');
    if (val === 'freeship') {
        input.value = 0;
        input.disabled = true;
    } else {
        input.disabled = false;
    }
}

document.getElementById('kieu_giam_create').addEventListener('change', function() {
    toggleGiaTriCreate(this.value);
});

// --- Validation ngày ---
const batDauInput  = document.querySelector('input[name="ngay_bat_dau"]');
const ketThucInput = document.querySelector('input[name="ngay_ket_thuc"]');
const dateError    = document.getElementById('date-error-create');

function validateDates() {
    if (batDauInput.value && ketThucInput.value) {
        if (ketThucInput.value <= batDauInput.value) {
            dateError.style.display = 'block';
            ketThucInput.setCustomValidity('Ngày kết thúc phải sau ngày bắt đầu.');
            return false;
        } else {
            dateError.style.display = 'none';
            ketThucInput.setCustomValidity('');
        }
    }
    return true;
}

batDauInput.addEventListener('change', function() {
    // Cập nhật min cho ngày kết thúc
    if (this.value) {
        ketThucInput.min = this.value;
    }
    validateDates();
});

ketThucInput.addEventListener('change', validateDates);

document.getElementById('form-create-promo').addEventListener('submit', function(e) {
    if (!validateDates()) {
        e.preventDefault();
    }
});
</script>

@endsection