@extends('admin_layout')
@section('admin_content')

<style>
/* ===================== FORM STYLE (CHUẨN KHUYẾN MÃI) ===================== */

/* TITLE */
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

/* LABEL */
.form-label-custom {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 6px;
    color: #374151;
}

/* INPUT + SELECT */
.form-input,
.form-select-custom {
    border-radius: 12px;
    padding: 10px 14px;
    border: 1px solid #d1d5db;
    background: #fff;
    transition: .2s;
}

.form-input:focus,
.form-select-custom:focus,
.form-textarea:focus {
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14,165,233,0.25);
    outline: none;
}

/* TEXTAREA */
.form-textarea {
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

@media (max-width: 768px) {
    .grid-2 { grid-template-columns: 1fr; }
}

/* BUTTONS */
.btn-cancel {
    background: #e5e7eb;
    color: #374151;
    font-weight: 600;
    border-radius: 12px;
    padding: 12px 28px;
    transition: .2s;
    border: none;
}
.btn-cancel:hover { background: #d1d5db; }

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


{{-- ======================== TITLE ======================== --}}
<div class="form-title mb-3">
    <i class="bi bi-folder-plus"></i>
    Thêm danh mục mới
</div>

{{-- VALIDATION ERROR --}}
@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif


{{-- ======================== FORM ======================== --}}
<form method="POST" action="{{ route('danhmuc.store') }}">
@csrf

    <div class="grid-2">

        {{-- TÊN DANH MỤC --}}
        <div>
            <label class="form-label-custom">
                Tên danh mục <span class="text-danger">*</span>
            </label>
            <input type="text" 
                   name="ten_danhmuc"
                   class="form-input form-control"
                   required>
        </div>

        <!-- {{-- DANH MỤC CHA --}}
        <div>
            <label class="form-label-custom">Danh mục cha</label>
            <select name="danh_muc_cha" class="form-select-custom form-select">
                <option value="">— Không chọn —</option>
                @foreach($list_danhmucs as $dm)
                    <option value="{{ $dm->id_danhmuc }}">{{ $dm->ten_danhmuc }}</option>
                @endforeach
            </select>
        </div> -->

    </div>

    {{-- MÔ TẢ --}}
    <div class="mt-3">
        <label class="form-label-custom">Mô tả</label>
        <textarea name="mo_ta_danh_muc" class="form-textarea form-control"></textarea>
    </div>

    {{-- BUTTONS --}}
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('danhmuc.index') }}" class="btn-cancel">Hủy bỏ</a>
        <button type="submit" class="btn-submit">Thêm mới</button>
    </div>

</form>

@endsection
