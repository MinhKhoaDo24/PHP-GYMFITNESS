@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/chitietsanpham.css') }}">
@endpush
@extends('layout')
@section('content')
@php
    $totalComments = $comments->count();
    $averageRating = $totalComments > 0 ? round($comments->avg('rating'), 1) : 0;
    
    // Phân bổ sao
    $starCounts = [
        5 => $comments->where('rating', 5)->count(),
        4 => $comments->where('rating', 4)->count(),
        3 => $comments->where('rating', 3)->count(),
        2 => $comments->where('rating', 2)->count(),
        1 => $comments->where('rating', 1)->count(),
    ];
    $starPercentages = [];
    foreach ($starCounts as $star => $count) {
        $starPercentages[$star] = $totalComments > 0 ? round(($count / $totalComments) * 100) : 0;
    }
@endphp

<section class="product-detail-section">

    <div class="product-detail-container">

        {{-- ================== CỘT TRÁI — ẢNH SẢN PHẨM ================== --}}
        <div class="product-images">
            <div class="main-image">
                @php
                    $imagePath = optional($sanpham->images->first())->duong_dan 
                                ? asset($sanpham->images->first()->duong_dan)
                                : asset('frontend/upload/placeholder.jpg');
                @endphp
                <img id="mainImage"
                    src="{{ asset(optional($sanpham->images->first())->duong_dan ?? 'frontend/upload/placeholder.jpg') }}"
                    class="main-image">
                <!-- OVERLAY XEM ẢNH/VIDEO -->
                <div id="imgOverlay" class="img-overlay">
                    <span class="close-preview">&times;</span>
                    <img id="imgOverlayDisplay" class="overlay-img" style="display: none;">
                    <video id="videoOverlayDisplay" class="overlay-img" controls style="display: none; max-width: 85%; max-height: 85%; border-radius: 8px;"></video>
                </div>

            </div>

            <div class="thumbnail-section">

                <button class="thumb-nav left" onclick="moveThumbs(-1)">&#10094;</button>

                <div class="thumbnail-wrapper" id="thumbWrapper">
                    @foreach($sanpham->images as $key => $img)
                        <img src="{{ asset($img->duong_dan) }}"
                            data-index="{{ $key }}"
                            class="thumb-item {{ $key === 0 ? 'active' : '' }}"
                            onclick="selectThumb({{ $key }})">
                    @endforeach
                </div>

                <button class="thumb-nav right" onclick="moveThumbs(1)">&#10095;</button>

            </div>

        </div>



        {{-- ================== CỘT GIỮA — THÔNG TIN SẢN PHẨM ================== --}}
        <div class="product-info">

            <h1 class="product-title">{{ $sanpham->tensp }}</h1>
            
            <div class="product-rating-summary-top" style="margin-top: 5px; margin-bottom: 10px;">
                @if($totalComments > 0)
                    <div class="stars-gold" style="color: #ffb800; font-size: 15px; display: flex; align-items: center; gap: 5px;">
                        <span>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= round($averageRating))
                                    <i class="bi bi-star-fill"></i>
                                @else
                                    <i class="bi bi-star"></i>
                                @endif
                            @endfor
                        </span>
                        <strong style="color: #333;">{{ $averageRating }} / 5</strong>
                        <a href="#comments-section" class="scroll-to-comments" onclick="scrollToCommentsTab(event)" style="color: #34A4E0; margin-left: 5px; font-weight: 600;">({{ $totalComments }} đánh giá)</a>
                    </div>
                @else
                    <div class="stars-gray" style="color: #ccc; font-size: 15px; display: flex; align-items: center; gap: 5px;">
                        <span>
                            <i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i><i class="bi bi-star"></i>
                        </span>
                        <span style="color: #777; font-size: 13px;">Chưa có đánh giá</span>
                    </div>
                @endif
            </div>

            <div class="meta">
                <span><strong>Danh mục: </strong>
                    <strong style="color: #34A4E0;">{{ optional($sanpham->danhmuc)->ten_danhmuc ?? 'Gym' }}</strong>
                </span>

                <span>|</span>
                @php
                    $availableQty = $sanpham->co_size == 1 ? $sanpham->sizes->sum('pivot.soluong') : $sanpham->soluong;
                @endphp
                <span>Tình trạng: 
                    <strong class="{{ $availableQty > 0 ? 'stock-yes' : 'stock-no' }}">
                        {{ $availableQty > 0 ? 'Còn hàng' : 'Hết hàng' }}
                    </strong>
                </span>
            </div>

            <div class="price-box">
                <span class="current-price">
                    {{ number_format($sanpham->giakhuyenmai ?: $sanpham->giasp, 0, ',', '.') }}đ
                </span>

                @if($sanpham->giakhuyenmai > 0 && $sanpham->giakhuyenmai < $sanpham->giasp)
                    <span class="old-price">{{ number_format($sanpham->giasp, 0, ',', '.') }}đ</span>
                    <span class="save-price">Tiết kiệm: {{ number_format($sanpham->giasp - $sanpham->giakhuyenmai, 0, ',', '.') }}đ</span>
                @endif
            </div>

            @php
                $sentences = preg_split('/(?<=[.!?])\s+/', $sanpham->mota_ngan);
            @endphp

            <ul class="benefits">
                @foreach(array_slice($sentences, 0, 6) as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>

            <style>
            .size-selection-box {
                margin-top: 20px;
                margin-bottom: 20px;
            }
            .size-options {
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
                margin-top: 8px;
            }
            .size-option-wrapper {
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .btn-size-option {
                border: 2px dashed #ccc;
                background: #fff;
                color: #333;
                padding: 10px 20px;
                font-size: 15px;
                font-weight: bold;
                border-radius: 8px;
                cursor: pointer;
                transition: all 0.3s ease;
                min-width: 60px;
                text-align: center;
            }
            .btn-size-option:hover:not(:disabled) {
                border-color: #ff8c00;
                color: #ff8c00;
            }
            .btn-size-option.active {
                border-style: solid;
                border-color: #ff8c00;
                background-color: #ff8c00;
                color: #fff;
                box-shadow: 0 4px 10px rgba(255, 140, 0, 0.3);
            }
            .btn-size-option:disabled {
                border-color: #e0e0e0;
                background-color: #f9f9f9;
                color: #ccc;
                cursor: not-allowed;
                text-decoration: line-through;
            }
            .out-of-stock-text-inline {
                font-size: 11px;
                color: #dc3545;
                margin-top: 4px;
                font-weight: bold;
            }
            .size-surcharge-text {
                font-size: 11px;
                color: #28a745;
                margin-top: 4px;
                font-weight: 600;
            }
            .size-warning-red {
                color: #dc3545;
                font-size: 13px;
                font-weight: bold;
                margin-top: 8px;
                animation: shake 0.5s ease-in-out;
            }
            @keyframes shake {
                0%, 100% { transform: translateX(0); }
                25% { transform: translateX(-5px); }
                75% { transform: translateX(5px); }
            }
            </style>

            @if($sanpham->co_size == 1)
                <div class="size-selection-box">
                    <span class="d-block mb-2 font-weight-bold">
                        @if(in_array($sanpham->id_danhmuc, [5, 6, 7]))
                            Chọn Hương Vị / Quy Cách:
                        @else
                            Chọn Kích Thước (Size):
                        @endif
                    </span>
                    <div class="size-options">
                        @foreach($sanpham->sizes as $sz)
                            @php
                                $isOutOfStock = $sz->pivot->soluong <= 0;
                            @endphp
                            <div class="size-option-wrapper">
                                <button type="button" 
                                        class="btn-size-option {{ $isOutOfStock ? 'disabled-size' : '' }}" 
                                        data-id="{{ $sz->id_size }}" 
                                        data-price-add="{{ (int)$sz->pivot->gia_cong_them }}"
                                        data-qty="{{ $sz->pivot->soluong }}"
                                        {{ $isOutOfStock ? 'disabled' : '' }}>
                                    {{ $sz->ten_size }}
                                </button>
                                @if($isOutOfStock)
                                    <div class="out-of-stock-text-inline">Đang hết hàng</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div id="size-selection-error" class="size-warning-red" style="display: none;">
                        @if(in_array($sanpham->id_danhmuc, [5, 6, 7]))
                            Vui lòng chọn hương vị / quy cách trước khi mua!
                        @else
                            Vui lòng chọn kích thước (size) trước khi mua!
                        @endif
                    </div>
                </div>
            @endif

            <div class="action-wrapper">
                <div class="quantity-area">
                    <span>Số lượng:</span>
                    <div class="quantity-box">
                        <button class="qty-btn" onclick="changeQty(-1)">−</button>
                        <input id="qtyInput" value="1" readonly>
                        <button class="qty-btn" onclick="changeQty(1)">+</button>
                    </div>
                </div>

                <div class="action-buttons">
                    @if($availableQty > 0)
                        <a id="add-to-cart-btn" href="{{ route('add_to_cart', $sanpham->id_sanpham) }}?quantity=1" class="btn add-cart">
                            Thêm vào giỏ hàng
                        </a>

                        <a id="buy-now-btn" href="{{ route('add_go_to_cart', $sanpham->id_sanpham) }}?quantity=1" class="btn buy-now">
                            Mua ngay
                        </a>
                    @else
                        <button type="button" class="btn add-cart disabled" disabled style="background-color: #ccc; cursor: not-allowed; width: 100%;">
                            Hết hàng
                        </button>
                    @endif
                </div>
            </div>

        </div>

        {{-- ================== CỘT PHẢI — CHÍNH SÁCH, THANH TOÁN ================== --}}
        <div class="policy-box">

            <ul class="policy-list">
                <li>
                    ❤️ Tư vấn tận tâm
                </li>
                <li>
                    🚚 Giao hàng siêu tốc (HN & TP.HCM)
                </li>
                <li>
                    💳 Miễn phí thanh toán Visa / Master / JCB
                </li>
                <li>
                    🔄 Đổi trả miễn phí trong 30 ngày
                </li>
            </ul>

            <h5 class="pay-title">Phương thức thanh toán</h5>

            <div class="pay-methods">
                <img src="/frontend/img/thanhtoantienmat.webp">
                <img src="/frontend/img/thanhtoanchuyenkhoan.webp">
                <img src="/frontend/img/thanhtoanvisa.webp">
            </div>
        </div>

    </div>
</section>

<section class="product-tabs-section container">

    <!-- TAB HEADER -->
    <div class="tabs-header">
        <button class="tab-btn active" data-tab="tab1">Thông tin chi tiết</button>
        <button class="tab-btn" data-tab="tab2">Hướng dẫn mua hàng</button>
        <button class="tab-btn" data-tab="tab3">Đánh giá sản phẩm</button>

        <div class="tab-underline"></div>
    </div>


    <div class="tab-underline"></div>

    <!-- TAB CONTENT -->
    <div class="tabs-content">

        <!-- TAB 1 – THÔNG TIN CHI TIẾT -->
        <div id="tab1" class="tab-pane active">
            @php
            $formatted = preg_replace('/\s*✓\s*/', '</li><li>', $sanpham->mota);
            $formatted = "<ul><li>" . trim($formatted, "</li>") . "</li></ul>";
            @endphp

            {!! $formatted !!}

        </div>

        <!-- TAB 2 – HƯỚNG DẪN MUA HÀNG -->
        <div id="tab2" class="tab-pane">
            <h3>Hướng dẫn mua hàng</h3>
            <p>• Chọn sản phẩm và kiểm tra thông tin chi tiết.</p>
            <p>• Bấm "Thêm vào giỏ hàng" để lưu sản phẩm.</p>
            <p>• Bấm "Mua ngay" nếu bạn muốn thanh toán nhanh.</p>
            <p>• Nhập thông tin nhận hàng và chọn phương thức thanh toán.</p>
            <p>• Xác nhận đơn hàng và chờ nhân viên liên hệ.</p>
        </div>

        <!-- TAB 3 – ĐÁNH GIÁ SẢN PHẨM -->
        <div id="tab3" class="tab-pane">
            <h3>Đánh giá sản phẩm</h3>

            <!-- Bảng Thống kê Đánh giá (Rating Dashboard) -->
            <div class="rating-dashboard-card">
                <div class="rating-dashboard-average">
                    <div class="big-score">{{ $averageRating }}</div>
                    <div class="average-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= round($averageRating))
                                <i class="bi bi-star-fill"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </div>
                    <div class="total-reviews-count">{{ $totalComments }} đánh giá thực tế</div>
                </div>
                
                <div class="rating-dashboard-bars">
                    @foreach([5, 4, 3, 2, 1] as $star)
                        <div class="star-bar-row" data-rating="{{ $star }}" style="cursor: pointer;" title="Lọc đánh giá {{ $star }} sao">
                            <span class="star-label">{{ $star }} ★</span>
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" style="width: {{ $starPercentages[$star] }}%;"></div>
                            </div>
                            <span class="percentage-label">{{ $starPercentages[$star] }}%</span>
                            <span class="count-label">({{ $starCounts[$star] }})</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div id="comments-list" class="comments-list" style="margin-top: 25px;">
                @if($comments->count() === 0)
                    <p class="no-comments-text">Hiện chưa có đánh giá nào.</p>
                @else
                    @foreach($comments as $c)
                        <div class="review-item" data-rating="{{ $c->rating ?? 5 }}">
                            <div class="review-user-info">
                                <span class="review-author">{{ $c->user->hoten ?? $c->user->name ?? 'Khách hàng' }}</span>
                                <span class="review-date">{{ $c->created_at ? $c->created_at->format('d-m-Y H:i') : '' }}</span>
                            </div>
                            <div class="review-stars" style="color: #ffb800; font-size: 13px; margin-bottom: 8px;">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($c->rating ?? 5))
                                        <i class="bi bi-star-fill"></i>
                                    @else
                                        <i class="bi bi-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="review-content">{{ $c->content }}</p>

                            @if(!empty($c->images))
                                <div class="review-attachments-grid" style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 10px;">
                                    @foreach($c->images as $path)
                                        @php
                                            $extension = pathinfo($path, PATHINFO_EXTENSION);
                                            $isVideo = in_array(strtolower($extension), ['mp4', 'webm', 'ogg', 'mov', 'qt']);
                                        @endphp
                                        <div class="attachment-thumbnail-wrapper" style="width: 80px; height: 80px; border-radius: 6px; overflow: hidden; border: 1px solid #ddd; cursor: pointer; position: relative;">
                                            @if($isVideo)
                                                <div class="video-thumbnail-container" onclick="openMediaOverlay('{{ asset($path) }}', true)" style="width: 100%; height: 100%;">
                                                    <video src="{{ asset($path) }}" class="attachment-thumbnail-video" muted style="width: 100%; height: 100%; object-fit: cover;"></video>
                                                    <div class="video-play-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 20px;">
                                                        <i class="bi bi-play-circle-fill"></i>
                                                    </div>
                                                </div>
                                            @else
                                                <img src="{{ asset($path) }}" class="attachment-thumbnail-image" onclick="openMediaOverlay('{{ asset($path) }}', false)" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" />
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>


        </div>

    </div>
</section>




<script>
function changeQty(num) {
    let input = document.getElementById('qtyInput');
    let val = parseInt(input.value) + num;
    if (val < 1) val = 1;
    
    // Check limit
    let limit = 999;
    const coSize = {{ $sanpham->co_size }};
    if (coSize === 1) {
        const activeSizeOpt = document.querySelector('.btn-size-option.active');
        if (activeSizeOpt) {
            limit = parseInt(activeSizeOpt.getAttribute('data-qty')) || 0;
        }
    } else {
        limit = {{ $sanpham->soluong }};
    }
    
    if (val > limit) {
        val = limit;
        Swal.fire({
            icon: 'warning',
            title: 'Giới hạn số lượng',
            text: `Chỉ còn ${limit} sản phẩm trong kho.`,
            timer: 1500,
            showConfirmButton: false
        });
    }
    input.value = val;

    // Cập nhật số lượng vào đường dẫn (href) của nút "Thêm vào giỏ hàng" và "Mua ngay"
    let addToCartBtn = document.getElementById('add-to-cart-btn');
    let buyNowBtn = document.getElementById('buy-now-btn');

    if (addToCartBtn) {
        let href = addToCartBtn.getAttribute('href');
        let url = href.split('?')[0];
        addToCartBtn.setAttribute('href', url + '?quantity=' + val);
    }
    if (buyNowBtn) {
        let href = buyNowBtn.getAttribute('href');
        let url = href.split('?')[0];
        buyNowBtn.setAttribute('href', url + '?quantity=' + val);
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const coSize = {{ $sanpham->co_size }};
    const sizeOpts = document.querySelectorAll('.btn-size-option');
    const basePrice = {{ $sanpham->giakhuyenmai ?: $sanpham->giasp }};
    const baseOldPrice = {{ $sanpham->giasp }};
    
    sizeOpts.forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active from all
            sizeOpts.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Hide error message
            const errorEl = document.getElementById('size-selection-error');
            if (errorEl) errorEl.style.display = 'none';
            
            // Update quantity input clamp if it exceeds size inventory
            const qtyInput = document.getElementById('qtyInput');
            const maxQty = parseInt(this.getAttribute('data-qty')) || 0;
            if (qtyInput && parseInt(qtyInput.value) > maxQty) {
                qtyInput.value = maxQty;
            }
            
            // Update price displays dynamically
            const priceAdd = parseInt(this.getAttribute('data-price-add')) || 0;
            const currentPriceEl = document.querySelector('.current-price');
            const oldPriceEl = document.querySelector('.old-price');
            const savePriceEl = document.querySelector('.save-price');
            
            if (currentPriceEl) {
                const finalPrice = basePrice + priceAdd;
                currentPriceEl.innerText = finalPrice.toLocaleString('vi-VN') + 'đ';
            }
            
            if (oldPriceEl) {
                const finalOldPrice = baseOldPrice + priceAdd;
                oldPriceEl.innerText = finalOldPrice.toLocaleString('vi-VN') + 'đ';
                if (savePriceEl) {
                    const finalSave = finalOldPrice - (basePrice + priceAdd);
                    savePriceEl.innerText = 'Tiết kiệm: ' + finalSave.toLocaleString('vi-VN') + 'đ';
                }
            }
        });
    });

    // Auto select first available size on page load
    if (coSize === 1) {
        const firstAvailableBtn = document.querySelector('.btn-size-option:not([disabled])');
        if (firstAvailableBtn) {
            firstAvailableBtn.click();
        }
    }
    
    // Add to cart click handler
    const addCartBtn = document.querySelector('.btn.add-cart');
    const buyNowBtn = document.querySelector('.btn.buy-now');
    
    if (addCartBtn) {
        addCartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            let selectedSizeId = null;
            if (coSize === 1) {
                const activeSizeOpt = document.querySelector('.btn-size-option.active');
                if (!activeSizeOpt) {
                    const errorEl = document.getElementById('size-selection-error');
                    if (errorEl) {
                        errorEl.style.display = 'block';
                        errorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return;
                }
                selectedSizeId = activeSizeOpt.getAttribute('data-id');
            }
            
            const qty = document.getElementById('qtyInput').value || 1;
            const baseUrl = "{{ route('add_to_cart', $sanpham->id_sanpham) }}";
            const url = `${baseUrl}?id_size=${selectedSizeId || ''}&quantity=${qty}`;
            
            // Send ajax request
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(async res => {
                let data = {};
                try {
                    data = await res.json();
                } catch (err) {
                    data = { status: 'success', message: "Đã thêm sản phẩm vào giỏ hàng!" };
                }
                
                if (res.status === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: data.message || 'Đã thêm sản phẩm vào giỏ hàng!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    // Dynamic cart counter update if header has one
                    const cartCountEl = document.querySelector('.navbar__shoppingCart span');
                    if (cartCountEl && typeof data.cart_count !== 'undefined') {
                        cartCountEl.innerText = data.cart_count;
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Thất bại',
                        text: data.message || 'Có lỗi xảy ra, vui lòng thử lại!',
                    });
                }
            })
            .catch(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi',
                    text: 'Có lỗi xảy ra, vui lòng thử lại!',
                });
            });
        });
    }
    
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function(e) {
            e.preventDefault();
            let selectedSizeId = null;
            if (coSize === 1) {
                const activeSizeOpt = document.querySelector('.btn-size-option.active');
                if (!activeSizeOpt) {
                    const errorEl = document.getElementById('size-selection-error');
                    if (errorEl) {
                        errorEl.style.display = 'block';
                        errorEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return;
                }
                selectedSizeId = activeSizeOpt.getAttribute('data-id');
            }
            
            const qty = document.getElementById('qtyInput').value || 1;
            const baseUrl = "{{ route('add_go_to_cart', $sanpham->id_sanpham) }}";
            const url = `${baseUrl}?id_size=${selectedSizeId || ''}&quantity=${qty}`;
            window.location.href = url;
        });
    }
});
</script>

<script>
let currentIndex = 0;
let images = {!! json_encode($sanpham->images->pluck('duong_dan')) !!};

function selectThumb(index) {
    currentIndex = index;

    // Đổi ảnh lớn
    document.getElementById("mainImage").src = "/" + images[index];

    // Cập nhật class active thumbnail
    document.querySelectorAll(".thumb-item").forEach((t, i) => {
        t.classList.toggle("active", i === index);
    });
}

function moveThumbs(direction) {
    const wrapper = document.getElementById("thumbWrapper");
    wrapper.scrollLeft += direction * 120; // lướt thumbnail
}
</script>
<script>
    const mainImg = document.getElementById("mainImage");
    const overlay = document.getElementById("imgOverlay");
    const overlayImg = document.getElementById("imgOverlayDisplay");
    const overlayVid = document.getElementById("videoOverlayDisplay");
    const closeBtn = document.querySelector(".close-preview");

    // Click ảnh chính → mở overlay
    if (mainImg) {
        mainImg.addEventListener("click", function() {
            overlayVid.style.display = "none";
            overlayVid.src = "";
            overlayImg.src = this.src;
            overlayImg.style.display = "block";
            overlay.style.display = "flex";
        });
    }

    // Hàm mở xem ảnh/video đính kèm
    function openMediaOverlay(src, isVideo) {
        if (isVideo) {
            overlayImg.style.display = "none";
            overlayVid.src = src;
            overlayVid.style.display = "block";
        } else {
            overlayVid.style.display = "none";
            overlayVid.src = "";
            overlayImg.src = src;
            overlayImg.style.display = "block";
        }
        overlay.style.display = "flex";
    }

    // Click nút close
    if (closeBtn) {
        closeBtn.addEventListener("click", function() {
            overlay.style.display = "none";
            overlayVid.src = ""; // Dừng phát nhạc/video
        });
    }

    // Click ra ngoài ảnh để đóng
    if (overlay) {
        overlay.addEventListener("click", function(e) {
            if (e.target === overlay) {
                overlay.style.display = "none";
                overlayVid.src = "";
            }
        });
    }

    // Hàm cuộn mượt xuống tab bình luận
    function scrollToCommentsTab(e) {
        e.preventDefault();
        const tabBtn = document.querySelector('.tab-btn[data-tab="tab3"]');
        if (tabBtn) {
            tabBtn.click();
        }
        const section = document.querySelector('.product-tabs-section');
        if (section) {
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
</script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll(".tab-btn");
    const panes = document.querySelectorAll(".tab-pane");
    const underline = document.querySelector(".tab-underline");

    function moveUnderline(btn) {
        underline.style.width = btn.offsetWidth + "px";
        underline.style.left = btn.offsetLeft + "px";
    }

    // Set underline initial position
    moveUnderline(document.querySelector(".tab-btn.active"));

    tabs.forEach(btn => {
        btn.addEventListener("click", () => {

            tabs.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");

            panes.forEach(p => p.classList.remove("active"));
            document.getElementById(btn.dataset.tab).classList.add("active");

            // Move underline
            moveUnderline(btn);
        });
    });
});

</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const starRows = document.querySelectorAll('.star-bar-row');
    const reviewItems = document.querySelectorAll('.review-item');
    let currentFilter = null; // null means no filter

    starRows.forEach(row => {
        row.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            
            // Nếu click lại vào dòng đang lọc -> Hủy lọc
            if (currentFilter === rating) {
                currentFilter = null;
                // Xóa hiệu ứng mờ
                starRows.forEach(r => {
                    r.style.opacity = '1';
                    r.style.transform = 'scale(1)';
                });
            } else {
                currentFilter = rating;
                // Làm mờ các dòng khác, làm nổi bật dòng được chọn
                starRows.forEach(r => {
                    r.style.opacity = '0.4';
                    r.style.transform = 'scale(1)';
                    r.style.transition = 'all 0.3s ease';
                });
                this.style.opacity = '1';
                this.style.transform = 'scale(1.02)';
            }
            
            // Lọc các review
            let visibleCount = 0;
            reviewItems.forEach(item => {
                const itemRating = item.getAttribute('data-rating');
                if (currentFilter === null || itemRating === currentFilter) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Hiển thị thông báo nếu không có comment nào khớp
            let noCommentsMsg = document.getElementById('no-filtered-comments');
            if (visibleCount === 0 && reviewItems.length > 0) {
                if (!noCommentsMsg) {
                    noCommentsMsg = document.createElement('p');
                    noCommentsMsg.id = 'no-filtered-comments';
                    noCommentsMsg.className = 'no-comments-text';
                    noCommentsMsg.style.textAlign = 'center';
                    noCommentsMsg.style.marginTop = '20px';
                    noCommentsMsg.style.color = '#777';
                    document.getElementById('comments-list').appendChild(noCommentsMsg);
                }
                noCommentsMsg.innerText = `Không có đánh giá ${currentFilter} sao nào.`;
                noCommentsMsg.style.display = 'block';
            } else if (noCommentsMsg) {
                noCommentsMsg.style.display = 'none';
            }
        });
    });
});
</script>

@endsection