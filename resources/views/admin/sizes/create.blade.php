@extends('admin_layout')
@section('admin_content')

<style>
/* ===================== FORM STYLE ===================== */
.form-title {
    font-size: 22px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #111;
}

.form-title i {
    background: #0ea5e9;
    padding: 8px;
    border-radius: 10px;
    color: #fff;
    font-size: 18px;
}

.form-label-custom {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 6px;
    color: #374151;
}

.form-input {
    border-radius: 12px;
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    background: #fff;
    transition: .2s;
}

.form-input:focus,
.form-textarea:focus {
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14,165,233,0.25);
    outline: none;
}

.form-textarea {
    border-radius: 12px;
    padding: 12px;
    height: 120px;
    border: 1px solid #d1d5db;
    resize: none;
}

.btn-cancel {
    background: #e5e7eb;
    color: #374151;
    font-weight: 600;
    border-radius: 12px;
    padding: 12px 28px;
    transition: .2s;
    border: none;
    text-decoration: none;
    display: inline-block;
}
.btn-cancel:hover {
    background: #d1d5db;
    color: #374151;
}

.btn-submit {
    background: linear-gradient(to right, #0284c7, #0ea5e9);
    color: #fff;
    font-weight: 600;
    border-radius: 12px;
    padding: 12px 28px;
    border: none;
    transition: .2s;
}
.btn-submit:hover {
    opacity: .85;
    transform: translateY(-1px);
}
</style>

<div class="form-title mb-3">
    <i class="bi bi-aspect-ratio"></i>
    Thêm Size mới
</div>

{{-- Validation Errors --}}
@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('sizes.store') }}">
@csrf

    <div class="row">
        <div class="col-md-6">
            <label class="form-label-custom">
                Tên Size <span class="text-danger">*</span>
            </label>
            <input type="text" 
                   name="ten_size"
                   class="form-input form-control"
                   placeholder="Ví dụ: M, L, XL, XXL..."
                   required>
        </div>
    </div>

    <div class="mt-3">
        <label class="form-label-custom">Mô tả chi tiết</label>
        <textarea name="mota" class="form-textarea form-control" placeholder="Mô tả về kích thước này..."></textarea>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('sizes.index') }}" class="btn-cancel">Hủy bỏ</a>
        <button type="submit" class="btn-submit">Thêm mới</button>
    </div>

</form>

@endsection
