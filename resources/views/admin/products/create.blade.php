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
        <!-- Có Size -->
        <div>
            <label class="promo-label d-flex align-items-center" style="gap: 8px; cursor:pointer;">
                <input type="checkbox" 
                    name="co_size" 
                    id="co_size"
                    value="1"
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
            <!-- Dòng size sẽ được thêm động vào đây -->
        </div>
        <div class="mt-2">
            <button type="button" class="btn btn-sm btn-primary" id="add-size-btn" style="border-radius: 8px;">
                <i class="bi bi-plus-circle"></i> Thêm Size
            </button>
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
let selectedFiles = []; 
let cropperInstance = null;
let currentCropIndex = null;
let cropQueue = [];

function processCropQueue() {
    if (cropQueue.length === 0) return;
    const nextIndex = cropQueue.shift();
    if (nextIndex < selectedFiles.length) {
        openCropper(nextIndex);
    } else {
        processCropQueue();
    }
}

function previewImages(event) {
    const files = Array.from(event.target.files);
    const startIndex = selectedFiles.length;
    selectedFiles = selectedFiles.concat(files);
    renderPreview();

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
                cropQueue = cropQueue.concat(tempQueue);
                if (cropQueue.length > 0) {
                    processCropQueue();
                }
            }
        };
    });
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    renderPreview();
}

function openCropper(index) {
    currentCropIndex = index;
    const file = selectedFiles[index];
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
        const originalFile = selectedFiles[currentCropIndex];
        const croppedFile = new File([blob], originalFile.name, {
            type: 'image/jpeg',
            lastModified: Date.now()
        });
        
        selectedFiles[currentCropIndex] = croppedFile;
        
        const modalEl = document.getElementById('cropperModal');
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
        
        renderPreview();
    }, 'image/jpeg', 0.9);
});

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

        const cropBtn = document.createElement('button');
        cropBtn.type = 'button';
        cropBtn.classList.add('btn', 'btn-outline-primary', 'mt-1');
        cropBtn.style.fontSize = '11px';
        cropBtn.style.padding = '2px 8px';
        cropBtn.style.borderRadius = '8px';
        cropBtn.style.width = '120px';
        cropBtn.innerHTML = '<i class="bi bi-crop"></i> Cắt ảnh';
        cropBtn.onclick = () => openCropper(index);

        box.appendChild(img);
        box.appendChild(removeBtn);
        box.appendChild(cropBtn);

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
    const modalEl = document.getElementById('cropperModal');
    if (modalEl) {
        modalEl.addEventListener('hidden.bs.modal', function () {
            if (cropperInstance) {
                cropperInstance.destroy();
                cropperInstance = null;
            }
            setTimeout(processCropQueue, 300);
        });
    }

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

    // ==================== SIZE MANAGEMENT JS ====================
    const coSizeCheckbox = document.getElementById('co_size');
    const sizeSection = document.getElementById('size-section');
    const mainSoluongInput = document.querySelector('input[name="soluong"]');
    const sizeRowsContainer = document.getElementById('size-rows-container');
    const addSizeBtn = document.getElementById('add-size-btn');
    
    let sizeIndex = 0;
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

    addSizeBtn.addEventListener('click', function () {
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

    sizeRowsContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-size-btn')) {
            e.target.closest('.size-row').remove();
            calculateTotalQuantity();
        }
    });

    sizeRowsContainer.addEventListener('input', function (e) {
        if (e.target.classList.contains('size-soluong-input')) {
            calculateTotalQuantity();
        }
    });

    // Khởi tạo trạng thái ban đầu
    toggleSizeSection();

});
</script>

@endsection
