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
        background: #f59e0b;
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
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
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

    /* ===================== GRID ===================== */
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

    .current-image-box img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #d1d5db;
    }
</style>

<div class="promo-title mb-3">
    <i class="bi bi-pencil-square"></i>
    Chỉnh sửa sản phẩm
</div>

<form action="{{ route('product.update', $sp->id_sanpham) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid-2">

        <!-- Tên sản phẩm -->
        <div>
            <label class="promo-label">Tên sản phẩm *</label>
            <input type="text" name="tensp" class="form-control promo-input"
                value="{{ old('tensp', $sp->tensp) }}" required>
        </div>

        <!-- SKU -->
        <div>
            <label class="promo-label">Mã SKU</label>
            <input type="text" name="sku" class="form-control promo-input"
                value="{{ old('sku', $sp->sku) }}">
        </div>

        <!-- Giá gốc -->
        <div>
            <label class="promo-label">Giá gốc (VNĐ) *</label>
            <input type="number" name="giasp" class="form-control promo-input"
                value="{{ old('giasp', $sp->giasp) }}" required>
        </div>

        <div class="grid-2">

            <div>
                <label class="promo-label">% Giảm giá</label>
                <input type="number" min="0" max="100"
                    name="giamgia"
                    id="giam_pt"
                    class="form-control promo-input"
                    value="{{ old('giamgia', $sp->giamgia) }}">
            </div>

            <div>
                <label class="promo-label">Giá khuyến mãi (VNĐ)</label>
                <input type="number" id="tien_giam"
                    class="form-control promo-input"
                    value="{{ old('gia_duoc_giam', $sp->gia_duoc_giam ?? 0) }}"
                    readonly>
            </div>

        </div>

        <div>
            <label class="promo-label">Giá bán (VNĐ) *</label>
            <input type="number" name="giakhuyenmai"
                class="form-control promo-input"
                value="{{ old('giakhuyenmai', $sp->giakhuyenmai) }}"
                readonly />
        </div>

        <!-- Danh mục -->
        <div>
            <label class="promo-label">Danh mục *</label>
            <select name="id_danhmuc" class="form-select promo-select" required>
                @foreach($list_danhmucs as $dm)
                <option value="{{ $dm->id_danhmuc }}"
                    {{ $sp->id_danhmuc == $dm->id_danhmuc ? 'selected' : '' }}>
                    {{ $dm->ten_danhmuc }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="promo-label">Ảnh sản phẩm (chọn thêm / thay thế)</label>

            <input type="file"
                name="anhsp[]"
                id="anhspInput"
                class="form-control promo-input"
                multiple
                onchange="previewImagesEdit(event)">

            <div id="preview-wrapper" class="mt-2"></div>


            @if($sp->images && $sp->images->count())
            <div class="mt-3">
                <label class="promo-label">Ảnh hiện tại</label>
                <div class="d-flex flex-wrap gap-2">

                    @foreach($sp->images as $img)
                    <div class="current-image-box position-relative">

                        <img src="{{ asset($img->duong_dan) }}" alt="Ảnh hiện tại">

                        <!-- nút xoá -->
                        <span class="remove-current-img"
                            data-id="{{ $img->id }}"
                            style="
                      position:absolute;
                      top:-6px;
                      right:-6px;
                      background:#dc2626;
                      color:#fff;
                      width:22px;
                      height:22px;
                      display:flex;
                      justify-content:center;
                      align-items:center;
                      border-radius:50%;
                      cursor:pointer;
                  ">
                            ×
                        </span>
                    </div>
                    @endforeach

                </div>
            </div>
            @endif
        </div>

        <div>
            <label class="promo-label">Số lượng *</label>
            <input type="number" name="soluong" class="form-control promo-input"
                value="{{ old('soluong', $sp->soluong) }}" required>
        </div>

        <div>
            <label class="promo-label d-flex align-items-center" style="gap: 8px;">
                <input type="hidden" name="noi_bat" value="0">
                <input type="checkbox" name="noi_bat" value="1"
                    {{ old('noi_bat', $sp->noi_bat) == 1 ? 'checked' : '' }}
                    style="width:18px; height:18px;">
                Sản phẩm nổi bật
            </label>
        </div>

        <div>
            <label class="promo-label">Trạng thái <span style='color: red;'>*</span></label>
            <select name="trang_thai" class="form-select promo-select">
                <option value="1" {{ $sp->trang_thai==1?'selected':'' }}>Đang hoạt động</option>
                <option value="0" {{ $sp->trang_thai==0?'selected':'' }}>Tạm ngưng</option>
            </select>
        </div>

    </div>

    <div class="mt-3">
        <label class="promo-label">Mô tả ngắn</label>
        <textarea name="mota_ngan" class="form-control promo-textarea">{{ old('mota_ngan', $sp->mota_ngan) }}</textarea>
    </div>

    <div class="mt-3">
        <label class="promo-label">Mô tả chi tiết</label>
        <textarea name="mota" class="form-control promo-textarea">{{ old('mota', $sp->mota) }}</textarea>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('product.index') }}" class="btn btn-footer-cancel">Hủy</a>
        <button type="submit" id="btnUpdate" class="btn btn-footer-submit">Cập nhật</button>
    </div>

    <script>
        document.querySelectorAll('.remove-current-img').forEach(btn => {
            btn.addEventListener('click', function() {

                let imgId = this.getAttribute('data-id');
                let input = document.createElement("input");
                input.type = "hidden";
                input.name = "delete_images[]";
                input.value = imgId;

                document.querySelector("form").appendChild(input);
                this.parentElement.style.opacity = "0.4";
                this.parentElement.style.pointerEvents = "none";
            });
        });
    </script>
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
    let selectedFilesEdit = [];

    function previewImagesEdit(event) {
        const files = Array.from(event.target.files);
        selectedFilesEdit = selectedFilesEdit.concat(files);

        renderPreviewEdit();
    }

    function removeImageEdit(index) {
        selectedFilesEdit.splice(index, 1);
        renderPreviewEdit();
    }

    function renderPreviewEdit() {
        const wrapper = document.getElementById('preview-wrapper');
        wrapper.innerHTML = "";

        selectedFilesEdit.forEach((file, index) => {
            const box = document.createElement("div");
            box.classList.add("preview-box");

            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);

            const removeBtn = document.createElement("div");
            removeBtn.classList.add("remove-btn");
            removeBtn.innerHTML = "&times;";
            removeBtn.onclick = () => removeImageEdit(index);

            box.appendChild(img);
            box.appendChild(removeBtn);
            wrapper.appendChild(box);
        });

        updateFileInputEdit();
    }

    function updateFileInputEdit() {
        const input = document.getElementById("anhspInput");
        const dt = new DataTransfer();
        selectedFilesEdit.forEach(f => dt.items.add(f));

        input.files = dt.files;
    }


    document.addEventListener("DOMContentLoaded", function() {

        const giaGoc = document.querySelector("input[name='giasp']");
        const giamPT = document.getElementById("giam_pt");
        const tienGiam = document.getElementById("tien_giam");
        const giaBan = document.querySelector("input[name='giakhuyenmai']");

        function tinhGia() {
            let goc = parseFloat(giaGoc.value) || 0;
            let pt = parseFloat(giamPT.value) || 0;

            let tien_giam = Math.round(goc * pt / 100);
            let ban = goc - tien_giam;

            tienGiam.value = tien_giam;
            giaBan.value = ban;
        }

        giaGoc.addEventListener("input", tinhGia);
        giamPT.addEventListener("input", tinhGia);

        tinhGia();
    });
</script>

@endsection