@extends('admin_layout')
@section('admin_content')

<style>
/* ===================== TITLE ===================== */
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

/* ===================== LABEL ===================== */
.promo-label {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 6px;
    color: #374151;
}

/* ===================== INPUT ===================== */
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

/* ===================== TEXTAREA ===================== */
.promo-textarea {
    border-radius: 12px;
    padding: 12px;
    height: 120px;
    border: 1px solid #d1d5db;
    resize: none;
}

/* ===================== GRID 2 CỘT ===================== */
.grid-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .grid-2 { grid-template-columns: 1fr; }
}

/* ===================== FOOTER BUTTONS ===================== */
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

/* ===================== IMAGE PREVIEW ===================== */
.preview-img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #d1d5db;
    margin-top: 8px;
    display: block;
}
#preview-wrapper {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 8px;
}
.preview-box {
    position: relative;
    display: inline-block;
}

.preview-box img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #d1d5db;
}

.preview-box .remove-btn {
    position: absolute;
    top: -6px;
    right: -6px;
    background: #ef4444;
    color: white;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    font-size: 14px;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>

<!-- ========================= TITLE ========================= -->
<div class="promo-title mb-3">
    <i class="bi bi-bag-plus"></i>
    Thêm sản phẩm mới
</div>

<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="grid-2">

        <!-- Tên sản phẩm -->
        <div>
            <label class="promo-label">Tên sản phẩm *</label>
            <input type="text" name="tensp" class="form-control promo-input" required>
        </div>

        <!-- SKU -->
        <div>
            <label class="promo-label">Mã SKU</label>
            <input type="text" name="sku" class="form-control promo-input">
        </div>

        <!-- Giá gốc -->
        <div>
            <label class="promo-label">Giá gốc (VNĐ) *</label>
            <input type="number" name="giasp" class="form-control promo-input" required>
        </div>

        <!-- % giảm -->
        <!-- % giảm + số tiền giảm -->
        <div class="grid-2">

            <!-- % giảm -->
            <div>
                <label class="promo-label">% Giảm giá</label>
                <input type="number" 
                    name="giamgia" 
                    class="form-control promo-input"
                    min="0" max="100"
                    id="giam_pt">
            </div>

            <!-- Tiền giảm -->
                <div>
                    <label class="promo-label">Giá khuyến mãi (VNĐ)</label>
                    <input type="number"
                        name="gia_duoc_giam" 
                        class="form-control promo-input"
                        id="tien_giam"
                        readonly>
                </div>

        </div>

        <div>
            <label class="promo-label">Giá bán (VNĐ) *</label>
            <input type="number" name="giakhuyenmai" class="form-control promo-input" readonly>
        </div>

        <!-- Danh mục -->
        <div>
            <label class="promo-label">Danh mục *</label>
            <select name="id_danhmuc" class="form-select promo-select" required>
                <option value="">-- Chọn danh mục --</option>
                @foreach($list_danhmucs as $dm)
                    <option value="{{ $dm->id_danhmuc }}">{{ $dm->ten_danhmuc }}</option>
                @endforeach
            </select>
        </div>

        <!-- Ảnh sản phẩm -->
        <div>
            <label class="promo-label">Ảnh sản phẩm *</label>
            <input type="file" name="anhsp[]" class="form-control promo-input" 
                required multiple onchange="previewImages(event)">
            <div id="preview-wrapper"></div>
        </div>
        <!-- Số lượng -->
        <div>
            <label class="promo-label">Số lượng *</label>
            <input type="number" name="soluong" class="form-control promo-input" required>
        </div>
        <!-- Sản phẩm nổi bật -->
        <div>
            <label class="promo-label d-flex align-items-center" style="gap: 8px; cursor:pointer;">
                <input type="checkbox" 
                    name="noi_bat" 
                    value="1"
                    style="width:18px; height:18px; cursor:pointer;">
                Sản phẩm nổi bật
            </label>
        </div>
    </div>

    <!-- Mô tả ngắn-->
    <div class="mt-3">
        <label class="promo-label">Mô tả ngắn</label>
        <textarea name="mota_ngan" class="form-control promo-textarea"></textarea>
    </div>
    <!-- Mô tả dài-->
    <div class="mt-3">
        <label class="promo-label">Mô tả chi tiết</label>
        <textarea name="mota" class="form-control promo-textarea"></textarea>
    </div>

    <!-- Footer Buttons -->
    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('product.index') }}" class="btn btn-footer-cancel">Hủy</a>
        <button type="submit" class="btn btn-footer-submit">Thêm mới</button>
    </div>

</form>

@if($errors->any())
<div class="alert alert-danger mt-2">
    <ul>
        @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
        @endforeach
    </ul>
</div>
@endif


<script>
let selectedFiles = []; 

function previewImages(event) {
    const files = Array.from(event.target.files);
    selectedFiles = selectedFiles.concat(files);

    renderPreview();
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    renderPreview();
}

function renderPreview() {
    const wrapper = document.getElementById('preview-wrapper');
    wrapper.innerHTML = '';

    selectedFiles.forEach((file, index) => {
        const box = document.createElement('div');
        box.classList.add('preview-box');

        const img = document.createElement('img');
        img.classList.add('preview-img');
        img.src = URL.createObjectURL(file);

        const removeBtn = document.createElement('div');
        removeBtn.classList.add('remove-btn');
        removeBtn.innerHTML = '&times;';
        removeBtn.onclick = () => removeImage(index);

        box.appendChild(img);
        box.appendChild(removeBtn);

        wrapper.appendChild(box);
    });

    updateFileInput();
}

function updateFileInput() {
    const input = document.querySelector('input[name="anhsp[]"]');

    const dataTransfer = new DataTransfer();
    selectedFiles.forEach(file => dataTransfer.items.add(file));

    input.files = dataTransfer.files;
}

document.addEventListener("DOMContentLoaded", function () {

    const giaGoc = document.querySelector("input[name='giasp']");
    const giamPT = document.getElementById("giam_pt");
    const giaKhuyenMai = document.getElementById("tien_giam"); 
    const giaBan = document.querySelector("input[name='giakhuyenmai']");

    function tinhGia() {
        let goc = parseFloat(giaGoc.value) || 0;
        let pt  = parseFloat(giamPT.value) || 0;

        let tienGiam = Math.round(goc * pt / 100);
        let ban = goc - tienGiam;

        giaKhuyenMai.value = tienGiam;
        giaBan.value = ban;
    }

    giaGoc.addEventListener("input", tinhGia);
    giamPT.addEventListener("input", tinhGia);

});
</script>

@endsection
