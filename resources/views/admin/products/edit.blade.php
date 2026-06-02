@extends('admin_layout')
@section('admin_content')

<!-- Cropper.js CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

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
        display: inline-flex;
        flex-direction: column;
        align-items: center;
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

        <div class="grid-2">

            <div>
                <label class="promo-label">Số lượng *</label>
                <input type="number" name="soluong" class="form-control promo-input"
                    value="{{ old('soluong', $sp->soluong) }}" required>
            </div>

            <div>
                <label class="promo-label">Trạng thái <span style='color: red;'>*</span></label>
                <select name="trang_thai" class="form-select promo-select">
                    <option value="1" {{ $sp->trang_thai==1?'selected':'' }}>Đang hoạt động</option>
                    <option value="0" {{ $sp->trang_thai==0?'selected':'' }}>Tạm ngưng</option>
                </select>
            </div>

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

        <!-- Có Size -->
        <div>
            <label class="promo-label d-flex align-items-center" style="gap: 8px; cursor:pointer;">
                <input type="checkbox"
                    name="co_size"
                    id="co_size"
                    value="1"
                    data-count="{{ $sp->sizes->count() }}"
                    {{ old('co_size', $sp->co_size) == 1 ? 'checked' : '' }}
                    style="width:18px; height:18px; cursor:pointer;">
                Sản phẩm có kích thước (Size)
            </label>
        </div>
    </div>

    <!-- Cấu hình các Size cho sản phẩm -->
    <div id="size-section" style="display: none;" class="mt-4 card p-3 border shadow-sm" data-sizes="{{ json_encode($sizes) }}">
        <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
            <i class="bi bi-aspect-ratio text-primary"></i> Cấu hình Size sản phẩm
        </h5>
        <div id="size-rows-container">
            @if($sp->co_size == 1)
            @foreach($sp->sizes as $index => $currentSize)
            <div class="row mb-3 align-items-end size-row">
                <div class="col-md-6">
                    <label class="promo-label">Chọn Size</label>
                    <select name="product_sizes[{{ $index }}][id_size]" class="form-select promo-select" required>
                        <option value="">-- Chọn Size --</option>
                        @foreach($sizes as $size)
                        <option value="{{ $size->id_size }}" {{ $currentSize->id_size == $size->id_size ? 'selected' : '' }}>
                            {{ $size->ten_size }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <label class="promo-label">Số lượng</label>
                            <input type="number" name="product_sizes[{{ $index }}][soluong]" class="form-control promo-input size-soluong-input" value="{{ $currentSize->pivot->soluong }}" min="0" required>
                        </div>
                        <div class="col-5">
                            <label class="promo-label">Giá cộng thêm</label>
                            <input type="number" name="product_sizes[{{ $index }}][gia_cong_them]" class="form-control promo-input" value="{{ $currentSize->pivot->gia_cong_them }}" min="0" required>
                        </div>
                        <div class="col-2 text-end">
                            <button type="button" class="btn btn-danger btn-sm remove-size-btn mt-3" style="border-radius: 8px;">Xóa</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
        <div class="mt-2">
            <button type="button" class="btn btn-sm btn-primary" id="add-size-btn" style="border-radius: 8px;">
                <i class="bi bi-plus-circle"></i> Thêm Size
            </button>
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

<!-- Modal Cắt Ảnh -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.2);">
            <div class="modal-header bg-dark text-white border-0">
                <h5 class="modal-title" id="cropperModalLabel"><i class="bi bi-crop"></i> Cắt ảnh sản phẩm (Tỉ lệ 1:1)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0" style="max-height: 500px; overflow: hidden; display: flex; justify-content: center; align-items: center; background: #111;">
                <img id="cropperImage" src="" style="max-width: 100%; max-height: 450px; display: block;">
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">Hủy</button>
                <button type="button" class="btn btn-primary" id="cropConfirmBtn" style="border-radius: 8px; background: linear-gradient(to right, #0284c7, #0ea5e9); border: none;">Xác nhận cắt</button>
            </div>
        </div>
    </div>
</div>

<script>
    let selectedFilesEdit = [];
    let cropperInstance = null;
    let currentCropIndex = null;
    let cropQueueEdit = [];

    function processCropQueueEdit() {
        if (cropQueueEdit.length === 0) return;
        const nextIndex = cropQueueEdit.shift();
        if (nextIndex < selectedFilesEdit.length) {
            openCropperEdit(nextIndex);
        } else {
            processCropQueueEdit();
        }
    }

    function previewImagesEdit(event) {
        const files = Array.from(event.target.files);
        const startIndex = selectedFilesEdit.length;
        selectedFilesEdit = selectedFilesEdit.concat(files);
        renderPreviewEdit();

        // Tự động kiểm tra và đưa vào hàng đợi cắt ảnh nếu kích thước vượt chuẩn
        let loadedCount = 0;
        let tempQueue = [];

        files.forEach((file, i) => {
            const img = new Image();
            img.src = URL.createObjectURL(file);
            img.onload = function() {
                if (img.width > 600 || img.height > 600 || img.width !== img.height) {
                    tempQueue.push(startIndex + i);
                }
                loadedCount++;
                if (loadedCount === files.length) {
                    tempQueue.sort((a, b) => a - b);
                    cropQueueEdit = cropQueueEdit.concat(tempQueue);
                    if (cropQueueEdit.length > 0) {
                        processCropQueueEdit();
                    }
                }
            };
        });
    }

    function removeImageEdit(index) {
        selectedFilesEdit.splice(index, 1);
        renderPreviewEdit();
    }

    function openCropperEdit(index) {
        currentCropIndex = index;
        const file = selectedFilesEdit[index];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const cropperImage = document.getElementById('cropperImage');
            cropperImage.src = e.target.result;
            
            const modalEl = document.getElementById('cropperModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
            
            modalEl.addEventListener('shown.bs.modal', function onShown() {
                if (cropperInstance) {
                    cropperInstance.destroy();
                }
                cropperInstance = new Cropper(cropperImage, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 0.9,
                    responsive: true,
                    restore: false,
                    checkCrossOrigin: false
                });
                modalEl.removeEventListener('shown.bs.modal', onShown);
            });
        };
        reader.readAsDataURL(file);
    }

    document.getElementById('cropConfirmBtn').addEventListener('click', function() {
        if (!cropperInstance || currentCropIndex === null) return;
        
        const canvas = cropperInstance.getCroppedCanvas({
            width: 600,
            height: 600
        });
        
        canvas.toBlob(function(blob) {
            const originalFile = selectedFilesEdit[currentCropIndex];
            const croppedFile = new File([blob], originalFile.name, {
                type: 'image/jpeg',
                lastModified: Date.now()
            });
            
            selectedFilesEdit[currentCropIndex] = croppedFile;
            
            const modalEl = document.getElementById('cropperModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();
            
            renderPreviewEdit();
        }, 'image/jpeg', 0.9);
    });

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

            const cropBtn = document.createElement('button');
            cropBtn.type = 'button';
            cropBtn.classList.add('btn', 'btn-outline-primary', 'mt-1');
            cropBtn.style.fontSize = '11px';
            cropBtn.style.padding = '2px 8px';
            cropBtn.style.borderRadius = '8px';
            cropBtn.style.width = '120px';
            cropBtn.innerHTML = '<i class="bi bi-crop"></i> Cắt ảnh';
            cropBtn.onclick = () => openCropperEdit(index);

            box.appendChild(img);
            box.appendChild(removeBtn);
            box.appendChild(cropBtn);

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
        const modalEl = document.getElementById('cropperModal');
        if (modalEl) {
            modalEl.addEventListener('hidden.bs.modal', function () {
                if (cropperInstance) {
                    cropperInstance.destroy();
                    cropperInstance = null;
                }
                setTimeout(processCropQueueEdit, 300);
            });
        }

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

        // ==================== SIZE MANAGEMENT JS ====================
        const coSizeCheckbox = document.getElementById('co_size');
        const sizeSection = document.getElementById('size-section');
        const mainSoluongInput = document.querySelector('input[name="soluong"]');
        const sizeRowsContainer = document.getElementById('size-rows-container');
        const addSizeBtn = document.getElementById('add-size-btn');

        let sizeIndex = parseInt(coSizeCheckbox.getAttribute('data-count')) || 0;
        const sizesList = JSON.parse(sizeSection.getAttribute('data-sizes') || '[]');

        function toggleSizeSection() {
            if (coSizeCheckbox.checked) {
                sizeSection.style.display = 'block';
                mainSoluongInput.setAttribute('readonly', 'readonly');
                calculateTotalQuantity();
            } else {
                sizeSection.style.display = 'none';
                mainSoluongInput.removeAttribute('readonly');
            }
        }

        function calculateTotalQuantity() {
            if (!coSizeCheckbox.checked) return;
            let total = 0;
            document.querySelectorAll('.size-soluong-input').forEach(input => {
                total += parseInt(input.value) || 0;
            });
            mainSoluongInput.value = total;
        }

        coSizeCheckbox.addEventListener('change', toggleSizeSection);

        addSizeBtn.addEventListener('click', function() {
            const index = sizeIndex++;
            
            let optionsHtml = '<option value="">-- Chọn Size --</option>';
            sizesList.forEach(size => {
                optionsHtml += `<option value="${size.id_size}">${size.ten_size}</option>`;
            });

            const rowHtml = `
                <div class="row mb-3 align-items-end size-row">
                    <div class="col-md-6">
                        <label class="promo-label">Chọn Size</label>
                        <select name="product_sizes[${index}][id_size]" class="form-select promo-select" required>
                            ${optionsHtml}
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="row align-items-center">
                            <div class="col-5">
                                <label class="promo-label">Số lượng</label>
                                <input type="number" name="product_sizes[${index}][soluong]" class="form-control promo-input size-soluong-input" value="0" min="0" required>
                            </div>
                            <div class="col-5">
                                <label class="promo-label">Giá cộng thêm</label>
                                <input type="number" name="product_sizes[${index}][gia_cong_them]" class="form-control promo-input" value="0" min="0" required>
                            </div>
                            <div class="col-2 text-end">
                                <button type="button" class="btn btn-danger btn-sm remove-size-btn mt-3" style="border-radius: 8px;">Xóa</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            sizeRowsContainer.insertAdjacentHTML('beforeend', rowHtml);
            calculateTotalQuantity();
        });

        sizeRowsContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-size-btn')) {
                e.target.closest('.size-row').remove();
                calculateTotalQuantity();
            }
        });

        sizeRowsContainer.addEventListener('input', function(e) {
            if (e.target.classList.contains('size-soluong-input')) {
                calculateTotalQuantity();
            }
        });

        // Initialize state
        toggleSizeSection();
    });
</script>

@endsection