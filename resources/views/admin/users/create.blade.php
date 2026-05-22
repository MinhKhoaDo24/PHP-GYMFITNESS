@extends('admin_layout')
@section('admin_content')

<style>
/* ===================== KHUNG FORM (GIỐNG EDIT KM) ===================== */

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
.promo-select:focus {
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16,185,129,0.25);
    outline: none;
}

.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media (max-width: 768px) {
    .grid-2 {
        grid-template-columns: 1fr;
    }
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

.btn-footer-cancel:hover {
    background: #d1d5db;
}

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
        <i class="bi bi-person-plus"></i>
        Thêm người dùng mới
    </div>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="grid-2">

            <!-- Họ tên -->
            <div>
                <label class="promo-label">Họ tên <span style="color:red">*</span></label>
                <input type="text" name="hoten" class="form-control promo-input"
                       placeholder="VD: Nguyễn Văn A" required>
            </div>

            <!-- Email -->
            <div>
                <label class="promo-label">Email <span style="color:red">*</span></label>
                <input type="email" name="email" class="form-control promo-input"
                       placeholder="example@gmail.com" required>
            </div>

            <!-- Mật khẩu -->
            <div>
                <label class="promo-label">Mật khẩu <span style="color:red">*</span></label>
                <input type="password" name="password" class="form-control promo-input"
                       placeholder="Nhập mật khẩu" required>
            </div>

            <!-- SĐT -->
            <div>
                <label class="promo-label">Số điện thoại <span style="color:red">*</span></label>
                <input type="text" name="sdt" class="form-control promo-input"
                       placeholder="VD: 0987654321" required>
            </div>

            <!-- Phân quyền -->
            <div>
                <label class="promo-label">Phân quyền <span style="color:red">*</span></label>
                <select name="id_phanquyen" class="form-select promo-select" required>
                    <option value="">-- Chọn quyền --</option>
                    @foreach ($roles as $r)
                        <option value="{{ $r->id_phanquyen }}">{{ ucfirst($r->tenquyen) }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Địa chỉ -->
            <div>
                <label class="promo-label">Địa chỉ </label>
                <input type="text" name="diachi" class="form-control promo-input"
                       placeholder="Nhập địa chỉ" >
            </div>

        </div>

        <!-- Nút footer -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('users.index') }}" class="btn btn-footer-cancel">Hủy bỏ</a>
            <button type="submit" class="btn btn-footer-submit">Thêm mới</button>
        </div>
    </form>

    @if($errors->any())
        <div class="alert alert-danger mt-2">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>

@endsection
