@extends('admin_layout')
@section('admin_content')

<style>
/* ===================== FORM STYLE (ĐỒNG BỘ CREATE USER) ===================== */

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
}

.promo-input:focus,
.promo-select:focus {
    border-color: #0284c7;
    box-shadow: 0 0 0 3px rgba(2,132,199,0.25);
    outline: none;
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
}

.btn-footer-submit:hover {
    opacity: .85;
    transform: translateY(-1px);
}
</style>

<div class="promo-modal">

    <div class="promo-title mb-3">
        <i class="bi bi-person-lines-fill"></i>
        Chỉnh sửa người dùng
    </div>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid-2">

            {{-- Họ tên --}}
            <div>
                <label class="promo-label">Họ tên <span style="color:red">*</span></label>
                <input type="text" name="hoten"
                       class="form-control promo-input"
                       value="{{ $user->hoten }}" required>
            </div>

            {{-- Email --}}
            <div>
                <label class="promo-label">Email <span style="color:red">*</span></label>
                <input type="email" name="email"
                       class="form-control promo-input"
                       value="{{ $user->email }}" required>
            </div>

            {{-- Password (optional) --}}
            <div>
                <label class="promo-label">Mật khẩu (bỏ trống nếu không đổi)</label>
                <input type="password" name="password"
                       class="form-control promo-input"
                       placeholder="Nhập mật khẩu mới nếu muốn đổi">
            </div>

            {{-- SĐT --}}
            <div>
                <label class="promo-label">Số điện thoại <span style="color:red">*</span></label>
                <input type="text" name="sdt"
                       class="form-control promo-input"
                       value="{{ $user->sdt }}" required>
            </div>

            {{-- Phân quyền --}}
            <div>
                <label class="promo-label">Phân quyền <span style="color:red">*</span></label>
                <select name="id_phanquyen" class="form-select promo-select">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id_phanquyen }}"
                            {{ $user->id_phanquyen == $role->id_phanquyen ? 'selected' : '' }}>
                            {{ ucfirst($role->tenquyen) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Địa chỉ --}}
            <div>
                <label class="promo-label">Địa chỉ</label>
                <input type="text" name="diachi"
                       class="form-control promo-input"
                       value="{{ $user->diachi }}">
            </div>

        </div>

        {{-- FOOTER BUTTONS --}}
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('users.index') }}" class="btn-footer-cancel">Hủy bỏ</a>
            <button type="submit" class="btn-footer-submit">Cập nhật</button>
        </div>
    </form>

    @if($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</div>

@endsection
