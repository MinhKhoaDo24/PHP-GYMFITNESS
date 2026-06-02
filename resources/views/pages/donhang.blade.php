@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/chitietsanpham.css') }}">
@endpush
@extends('layout')
@section('content')

<style>
.orders-hero {
    width: 100%;
    height: 300px;
    background-image: url('/frontend/img/donhang.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;
    display: flex;
    align-items: flex-end;
}

.orders-hero-content {
    padding: 30px 40px;
    color: #ffffff;
}

.orders-page {
    padding: 40px 0 80px;
    background: #ffffff;
    width: 100%;
}

.orders-wrapper {
    width: 100%;
    /* max-width: 1500px; */
    margin: 0 auto;
    padding: 0 40px 0; 
}

.orders-heading {
    margin-bottom: 14px;
}

.orders-breadcrumb {
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: .08em;
    color: #6b7280;
}

.orders-breadcrumb a {
    color: #34A4E0;
    text-decoration: none;
}

.orders-breadcrumb span {
    color: #9ca3af;
}

.orders-title {
    font-size: 32px;
    font-weight: 700;
    color: #0b1120;
    margin: 6px 0 4px;
}

.orders-subtitle {
    font-size: 14px;
    color: #6b7280;
}

.orders-card {
    background: transparent;
    border: none;
    box-shadow: none;
    width: 100%;
}

.orders-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    background: #0b1120;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 14px 32px rgba(0, 0, 0, 0.18);
    font-size: 16px;
}


.orders-table thead tr {
    background: #020617;
}

.orders-table thead th {
    padding: 16px 18px;
    text-align: left;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    color: #f9fafb;
    white-space: nowrap;
}

.orders-table tbody tr {
    background: #dee2e6;
}

.orders-table tbody tr + tr td {
    border-top: 1px solid #1f2937;
}

.orders-table td {
    padding: 16px 18px;
    color: #000000ff;
    font-size: 16px;
}

.orders-table td:first-child {
    font-weight: 700;
    color: #0319e1ff;
}

.badge-payment {
    padding: 4px 6px;
    font-size: 14px;
    border-radius: 9px;
    background: #0319e1ff;
    color: #f4f4f4ff;
}

.badge-status {

    padding: 4px 6px;
    border-radius: 9px;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    min-width: 150px;
    transition: 0.25s ease;
}

/* Đang xử lý / Chờ xác nhận */
.badge-status--processing {
    background: #F2C34B;
    color: #fff;
}

/* Thành công */
.badge-status--success {
    background: #34D399;
    color: #fff;
}

/* Cảnh báo / Bị hủy */
.badge-status--warning {
    background: #F87171;
        color: #fff;
}
.badge-status--shipping{
    background: #1ba8efff;
    color: #fff;
}

/* Trạng thái mặc định */
.badge-status-default {
    background: #e5e7eb;
    border: 2px solid #9ca3af;
    color: #374151;
}


.checkout-section {
    padding: 35px 0;
    background: #F5F8FB;
}

.checkout-card {
    background: #fff;
    padding: 25px 28px;
    border-radius: 18px;
    box-shadow: 0 4px 18px rgba(0,0,0,0.08);
    margin-bottom: 25px;
    border: 1px solid #e5e7eb;
}

.section-title {
    font-size: 22px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 15px;
}

.info-label {
    color: #6B7280;
    font-weight: 600;
}

.info-value {
    color: #111827;
    font-weight: 600;
}

.table-cart thead th {
    background: #34A4E0 !important;
    color: #fff;
    padding: 12px;
    text-transform: uppercase;
    font-size: 13px;
}

.table-cart tbody td {
    vertical-align: middle;
    font-size: 16px;
    color: #111;
}

.btn-main {
    background: #34A4E0;
    color: #fff;
    font-weight: 600;
    padding: 10px 22px;
    border-radius: 10px;
    transition: .25s;
}

.btn-main:hover {
    background: #1B8AC3;
    color: #fff;
}

.btn-outline-main {
    border: 2px solid #34A4E0;
    color: #34A4E0;
    font-weight: 600;
    padding: 10px 22px;
    border-radius: 10px;
    background: transparent;
    transition: .25s;
}

.btn-outline-main:hover {
    background: #34A4E0;
    color: #fff;
}

.total-price {
    font-size: 42px;
    font-weight: 800;
    color: #34A4E0;
}

.payment-option input {
    transform: scale(1.4);
}

.modal-content {
    border-radius: 16px;
    border: none;
}


.orders-empty-row {
    text-align: center;
    padding: 24px 14px;
    font-size: 14px;
    color: #cbd5e1;
}

@media (max-width: 768px) {
    .orders-wrapper {
        padding: 0 18px;
    }

    .orders-title {
        font-size: 26px;
    }

    .orders-table thead th {
        font-size: 11px;
        padding: 10px;
    }

    .orders-table td {
        padding: 12px 10px;
    }
}
/* page-header */
.page-header {
    height: 300px;
    background-image: url('/frontend/img/kick-offer-2.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed;   /* 🔥 giữ ảnh đứng yên khi scroll */
    overflow: hidden;
    position: relative;
}

.header-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.45);
}

.header-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;

    text-shadow:
        0 2px 6px rgba(0,0,0,0.45),
        0 0 12px rgba(255,255,255,0.15);

    z-index: 3;

    /* 🔥 Animation trượt từ dưới lên */
    animation: slideUp 0.9s ease-out forwards;
}

/* 🎬 Animation chạy từ dưới → lên */
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translate(-50%, -20%); /* thấp hơn */
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%); /* vị trí chuẩn */
    }
}

/* ===========================
    NÚT ACTION CHUNG
=========================== */
.orders-action-link {
    display: inline-block;
    padding: 8px 14px;
    font-size: 13px;
    border-radius: 10px;
    border: 2px solid rgba(0,200,255,0.6);
    color: #0319e1;
    text-decoration: none;
    margin-right: 6px;
    transition: 0.25s;
    background: rgba(255,255,255,0.08);
}

.orders-action-link:hover {
    background: linear-gradient(135deg, #00c6ff, #0072ff);
    color: #fff;
}

/* ===========================
    NÚT HỦY ĐƠN
=========================== */
.orders-action-link--danger {
    border-color: rgba(255,60,60,0.7);
    color: #e63946;
    background: rgba(255,0,0,0.06);
}

.orders-action-link--danger:hover {
    background: linear-gradient(135deg, #ff4b4b, #ff1c3d);
    color: #fff !important;
    border-color: transparent;
    transform: translateY(-1px);
}

/* ===========================
    NÚT ĐÁNH GIÁ ĐƠN
=========================== */
.orders-action-link--review {
    border-color: rgba(16, 185, 129, 0.7);
    color: #10b981;
    background: rgba(16, 185, 129, 0.08);
    cursor: pointer;
    outline: none;
    transition: all 0.3s ease;
}

.orders-action-link--review:hover {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff !important;
    border-color: transparent;
    transform: translateY(-1px);
}

/* ===========================
    NÚT MUA LẠI
=========================== */
.orders-action-link--repurchase {
    border-color: rgba(255, 140, 0, 0.75);
    color: #ff8c00;
    background: rgba(255, 140, 0, 0.12);
    cursor: pointer;
    outline: none;
    transition: all 0.3s ease;
}

.orders-action-link--repurchase:hover {
    background: linear-gradient(135deg, #ff8c00, #ff6b00);
    color: #fff !important;
    border-color: transparent;
    transform: translateY(-1px);
}

/* ===========================
    DANH SÁCH SẢN PHẨM TRONG ĐƠN
=========================== */
.order-products-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
    max-width: 320px;
}

.order-product-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 6px 10px;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 8px;
    border-left: 3px solid #ff8c00;
    transition: all 0.25s ease;
}

.order-product-item:hover {
    background: rgba(255, 140, 0, 0.08);
    transform: translateX(3px);
}

.product-name {
    font-weight: 600;
    color: #1f2937;
    font-size: 14px;
    text-align: left;
}

.product-qty-badge {
    background: #ff8c00;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 12px;
    white-space: nowrap;
    margin-left: 8px;
}

</style>

<section class="page-header">
    <div class="header-overlay"></div>
    <div class="header-content">
        <h1>ĐƠN HÀNG</h1>
    </div>
</section>

<div class="orders-page">
    <div class="orders-wrapper">
        <div class="orders-heading">
            <h2 class="orders-title">Danh sách đơn hàng</h2>
            <p class="orders-subtitle">Theo dõi lịch sử mua hàng tại RISE FITNESS</p>
        </div>

        <div class="orders-card">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Thanh toán</th>
                        <th>Ngày đặt</th>
                        <th>Ngày giao dự kiến</th>
                        <th>Trạng thái</th>
                        <th>Sản phẩm</th>
                        <th>Hành động</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($orders as $i => $order)
                        <tr>
                            <td>{{ $i + 1 }}</td>

                            <td>
                                <span class="badge-payment">{{ $order->phuongthucthanhtoan }}</span>
                            </td>

                            <td>
                                {{ $order->ngaydathang
                                    ? \Carbon\Carbon::parse($order->ngaydathang)->format('d-m-Y')
                                    : '---' }}
                            </td>

                            <td>
                                {{ $order->ngaygiaohang
                                    ? \Carbon\Carbon::parse($order->ngaygiaohang)->format('d-m-Y')
                                    : '---' }}
                            </td>

                            <td>
                                @php
                                    $status = strtolower($order->trangthai);
                                @endphp

                                @php
                                    $statusClass = [
                                        'Chờ xác nhận' => 'badge-status--processing',
                                        'Chờ giao hàng' => 'badge-status--processing',

                                        'Đang giao hàng' => 'badge-status--shipping',


                                        'Hoàn thành' => 'badge-status--success',

                                        'Bị hủy' => 'badge-status--warning',
                                        'Thất bại' => 'badge-status--warning',
                                        'Chưa thanh toán' => 'badge-status--warning',
                                        'Đã thanh toán' => 'badge-status--success',
                                    ];

                                    $class = $statusClass[$order->trangthai] ?? '';
                                @endphp

                                <span class="badge-status {{ $class }}">
                                    {{ $order->trangthai }}
                                </span>

                            </td>

                            <td>
                                <div class="order-products-list">
                                    @if($order->details && $order->details->isNotEmpty())
                                        @foreach($order->details as $detail)
                                            <div class="order-product-item">
                                                <span class="product-name">{{ $detail->tensp }}</span>
                                                <span class="product-qty-badge">x{{ $detail->soluong }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">---</span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <a href="{{ route('donhang.edit', ['id' => $order->id_dathang]) }}" 
                                class="orders-action-link" style="margin-bottom: 5px;">
                                    Xem chi tiết
                                </a>

                                @if($order->trangthai === 'Chờ xác nhận')
                                    <form action="{{ route('donhang.cancel', ['id' => $order->id_dathang]) }}" 
                                        method="POST" class="d-inline cancel-form">
                                        @csrf
                                        <button type="button" class="orders-action-link orders-action-link--danger btn-cancel-order" style="margin-bottom: 5px;">
                                            Hủy đơn
                                        </button>
                                    </form>
                                @endif

                                @if(in_array($order->trangthai, ['Hoàn thành', 'Bị hủy', 'Thất bại']))
                                    <form action="{{ route('donhang.repurchase', ['id' => $order->id_dathang]) }}" 
                                        method="POST" class="d-inline repurchase-form">
                                        @csrf
                                        <button type="button" class="orders-action-link orders-action-link--repurchase btn-repurchase-order" style="margin-bottom: 5px;">
                                            Mua lại
                                        </button>
                                    </form>

                                    @if(strtolower($order->trangthai) === 'hoàn thành')
                                        @php
                                            $totalProducts = $order->details->count();
                                            $reviewedCount = $order->details->filter(function($d) use ($comments, $order) {
                                                return isset($comments) && $comments->contains(function($c) use ($d, $order) {
                                                    return $c->sanpham_id == $d->id_sanpham && ($c->id_dathang == $order->id_dathang || is_null($c->id_dathang));
                                                });
                                            })->count();
                                            $allReviewed = ($totalProducts > 0 && $reviewedCount === $totalProducts);
                                        @endphp

                                        @if($allReviewed)
                                            <button class="orders-action-link btn-open-order-reviews"
                                                    style="margin-bottom: 5px; border-color: rgba(52, 164, 224, 0.7); color: #34a4e0; background: rgba(52, 164, 224, 0.08);"
                                                    data-order-id="{{ $order->id_dathang }}"
                                                    data-products="{{ json_encode($order->details->map(function($d) use ($comments, $order) {
                                                        $img = $d->sanpham && $d->sanpham->images ? $d->sanpham->images->first() : null;
                                                        $imgPath = $img ? asset($img->duong_dan) : asset('frontend/upload/placeholder.jpg');
                                                        $comment = isset($comments) ? $comments->first(function($c) use ($d, $order) {
                                                            return $c->sanpham_id == $d->id_sanpham && ($c->id_dathang == $order->id_dathang || is_null($c->id_dathang));
                                                        }) : null;
                                                        return [
                                                            'id_sanpham' => $d->id_sanpham,
                                                            'tensp' => $d->tensp,
                                                            'image' => $imgPath,
                                                            'has_reviewed' => $comment ? true : false,
                                                            'reviewed_rating' => $comment ? $comment->rating : null,
                                                            'reviewed_content' => $comment ? $comment->content : null,
                                                            'reviewed_images' => ($comment && $comment->images) ? array_map(function($path) {
                                                                return asset($path);
                                                            }, $comment->images) : []
                                                        ];
                                                    })) }}">
                                                <i class="bi bi-chat-left-text-fill"></i> Xem đánh giá
                                            </button>
                                        @else
                                            <button class="orders-action-link orders-action-link--review btn-open-order-reviews"
                                                    style="margin-bottom: 5px;"
                                                    data-order-id="{{ $order->id_dathang }}"
                                                    data-products="{{ json_encode($order->details->map(function($d) use ($comments, $order) {
                                                        $img = $d->sanpham && $d->sanpham->images ? $d->sanpham->images->first() : null;
                                                        $imgPath = $img ? asset($img->duong_dan) : asset('frontend/upload/placeholder.jpg');
                                                        $comment = isset($comments) ? $comments->first(function($c) use ($d, $order) {
                                                            return $c->sanpham_id == $d->id_sanpham && ($c->id_dathang == $order->id_dathang || is_null($c->id_dathang));
                                                        }) : null;
                                                        return [
                                                            'id_sanpham' => $d->id_sanpham,
                                                            'tensp' => $d->tensp,
                                                            'image' => $imgPath,
                                                            'has_reviewed' => $comment ? true : false,
                                                            'reviewed_rating' => $comment ? $comment->rating : null,
                                                            'reviewed_content' => $comment ? $comment->content : null,
                                                            'reviewed_images' => ($comment && $comment->images) ? array_map(function($path) {
                                                                return asset($path);
                                                            }, $comment->images) : []
                                                        ];
                                                    })) }}">
                                                <i class="bi bi-star-fill"></i> Đánh giá
                                            </button>
                                        @endif
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-white">
                                Bạn chưa có đơn hàng nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Đánh giá sản phẩm -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true" style="z-index: 99999;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2); background: #ffffff;">
            <div class="modal-header" style="border-bottom: 1px solid #f1f5f9; padding: 18px 24px;">
                <h5 class="modal-title" id="reviewModalLabel" style="font-weight: 800; color: #0b1120; font-size: 20px;">Đánh giá sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="border: none; background: transparent; font-size: 28px; color: #64748b; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            <div class="modal-body" style="padding: 24px; max-height: 70vh; overflow-y: auto;">
                <div id="modalProductsContainer"></div>
            </div>
        </div>
    </div>
</div>

<!-- OVERLAY XEM ẢNH/VIDEO ĐÁNH GIÁ -->
<div id="imgOverlay" class="img-overlay">
    <span class="close-preview">&times;</span>
    <img id="imgOverlayDisplay" class="overlay-img" style="display: none;">
    <video id="videoOverlayDisplay" class="overlay-img" controls style="display: none; max-width: 85%; max-height: 85%; border-radius: 8px;"></video>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let orderReviewFiles = {};

    const overlay = document.getElementById("imgOverlay");
    const overlayImg = document.getElementById("imgOverlayDisplay");
    const overlayVid = document.getElementById("videoOverlayDisplay");
    const closeBtn = document.querySelector(".close-preview");

    // Hàm mở xem ảnh/video đính kèm
    window.openMediaOverlay = function(src, isVideo) {
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

    // Mở modal khi click "Đánh giá" bên ngoài
    $(document).on('click', '.btn-open-order-reviews', function() {
        const orderId = $(this).data('order-id');
        const products = $(this).data('products');
        
        $('#reviewModalLabel').text('Đánh giá sản phẩm - Đơn hàng #RF-' + String(orderId).padStart(5, '0'));
        
        let container = $('#modalProductsContainer');
        container.html('');
        orderReviewFiles = {}; // Clear files memory
        
        products.forEach(p => {
            let innerContentHtml = '';
            if (p.has_reviewed) {
                let starsHtml = '';
                for (let i = 1; i <= 5; i++) {
                    if (i <= p.reviewed_rating) {
                        starsHtml += '<i class="bi bi-star-fill" style="color: #ffb800; font-size: 16px; margin-right: 2px;"></i>';
                    } else {
                        starsHtml += '<i class="bi bi-star" style="color: #cbd5e1; font-size: 16px; margin-right: 2px;"></i>';
                    }
                }
                
                let attachmentsHtml = '';
                if (p.reviewed_images && p.reviewed_images.length > 0) {
                    attachmentsHtml += '<div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px;">';
                    p.reviewed_images.forEach(path => {
                        let extension = path.split('.').pop().toLowerCase();
                        let isVideo = ['mp4', 'webm', 'ogg', 'mov', 'qt'].includes(extension);
                        
                        attachmentsHtml += '<div class="attachment-thumbnail-wrapper" style="width: 60px; height: 60px; border-radius: 6px; overflow: hidden; border: 1px solid #ddd; cursor: pointer; position: relative;">';
                        if (isVideo) {
                            attachmentsHtml += `
                                <div class="video-thumbnail-container" onclick="openMediaOverlay('${path}', true)" style="width: 100%; height: 100%;">
                                    <video src="${path}" class="attachment-thumbnail-video" muted style="width: 100%; height: 100%; object-fit: cover;"></video>
                                    <div class="video-play-overlay" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 16px;">
                                        <i class="bi bi-play-circle-fill"></i>
                                    </div>
                                </div>
                            `;
                        } else {
                            attachmentsHtml += `
                                <img src="${path}" class="attachment-thumbnail-image" onclick="openMediaOverlay('${path}', false)" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" />
                            `;
                        }
                        attachmentsHtml += '</div>';
                    });
                    attachmentsHtml += '</div>';
                }

                innerContentHtml = `
                    <div style="background: #f8fafc; border-radius: 10px; padding: 15px; border: 1px solid #e2e8f0; margin-top: 5px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <span style="font-size: 13px; color: #64748b; font-weight: 700;">Đánh giá của bạn:</span>
                                <div>${starsHtml}</div>
                            </div>
                            <span style="font-size: 12px; color: #10b981; font-weight: 700; background: rgba(16, 185, 129, 0.1); padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                <i class="bi bi-check-circle-fill"></i> Đã đánh giá
                            </span>
                        </div>
                        <p style="font-size: 14px; color: #334155; margin: 0; line-height: 1.5; font-style: italic;">"${p.reviewed_content}"</p>
                        ${attachmentsHtml}
                    </div>
                `;
            } else {
                innerContentHtml = `
                    <form class="modal-single-review-form" enctype="multipart/form-data" style="margin-top: 5px;">
                        @csrf
                        <input type="hidden" name="sanpham_id" value="${p.id_sanpham}">
                        <input type="hidden" name="id_dathang" value="${orderId}">
                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                            <span style="font-size: 13px; color: #64748b; font-weight: 600;">Đánh giá của bạn:</span>
                            <div class="star-rating-selector" style="display: flex; flex-direction: row-reverse; gap: 5px;">
                                <input type="radio" id="modal_star5_${p.id_sanpham}" name="rating" value="5" checked style="display: none;" />
                                <label for="modal_star5_${p.id_sanpham}" title="5 sao" style="font-size: 24px; color: #cbd5e1; cursor: pointer; transition: color 0.2s;"><i class="bi bi-star-fill"></i></label>
                                
                                <input type="radio" id="modal_star4_${p.id_sanpham}" name="rating" value="4" style="display: none;" />
                                <label for="modal_star4_${p.id_sanpham}" title="4 sao" style="font-size: 24px; color: #cbd5e1; cursor: pointer; transition: color 0.2s;"><i class="bi bi-star-fill"></i></label>
                                
                                <input type="radio" id="modal_star3_${p.id_sanpham}" name="rating" value="3" style="display: none;" />
                                <label for="modal_star3_${p.id_sanpham}" title="3 sao" style="font-size: 24px; color: #cbd5e1; cursor: pointer; transition: color 0.2s;"><i class="bi bi-star-fill"></i></label>
                                
                                <input type="radio" id="modal_star2_${p.id_sanpham}" name="rating" value="2" style="display: none;" />
                                <label for="modal_star2_${p.id_sanpham}" title="2 sao" style="font-size: 24px; color: #cbd5e1; cursor: pointer; transition: color 0.2s;"><i class="bi bi-star-fill"></i></label>
                                
                                <input type="radio" id="modal_star1_${p.id_sanpham}" name="rating" value="1" style="display: none;" />
                                <label for="modal_star1_${p.id_sanpham}" title="1 sao" style="font-size: 24px; color: #cbd5e1; cursor: pointer; transition: color 0.2s;"><i class="bi bi-star-fill"></i></label>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <textarea name="content" class="comment-textarea" rows="3" placeholder="Chia sẻ trải nghiệm thực tế về sản phẩm..." required style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; background: #ffffff; color: #333; resize: vertical;"></textarea>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 12px;">
                            <label class="upload-btn-wrapper" for="attachments_${p.id_sanpham}" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border: 1px dashed #34A4E0; border-radius: 8px; color: #34A4E0; cursor: pointer; font-weight: 600; font-size: 13px; transition: all 0.2s;">
                                <i class="bi bi-camera-fill"></i> Đính kèm ảnh/video thực tế
                            </label>
                            <input type="file" id="attachments_${p.id_sanpham}" name="attachments[]" class="single-product-attachments-input" accept="image/*,video/*" multiple style="display: none;" />
                            
                            <button type="submit" class="btn btn-main btn-submit-single-review" style="padding: 8px 18px; font-size: 13px; border-radius: 8px; border: none; font-weight: 700; background: #34A4E0; color: #fff; cursor: pointer;">
                                Gửi đánh giá
                            </button>
                        </div>
                        
                        <div class="upload-preview-container single-product-upload-preview" style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px;"></div>
                    </form>
                `;
            }

            let productHtml = `
                <div class="modal-product-review-card" data-product-id="${p.id_sanpham}" style="display: flex; gap: 20px; border-bottom: 1px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 20px; align-items: flex-start; text-align: left;">
                    <img src="${p.image}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;" />
                    <div style="flex-grow: 1;">
                        <h6 style="font-weight: 700; color: #1e293b; margin: 0 0 8px 0; font-size: 15px;">${p.tensp}</h6>
                        ${innerContentHtml}
                    </div>
                </div>
            `;
            container.append(productHtml);
        });
        
        // Show modal
        $('#reviewModal').modal('show');
    });

    // Đóng modal khi click Close hoặc dấu &times;
    $(document).on('click', '.btn-close', function() {
        $('#reviewModal').modal('hide');
    });

    // Xử lý tệp đính kèm cho từng sản phẩm trong modal
    $(document).on('change', '.single-product-attachments-input', function(e) {
        const fileInput = this;
        const productId = $(fileInput).attr('id').replace('attachments_', '');
        const previewContainer = $(fileInput).closest('form').find('.single-product-upload-preview');
        const files = Array.from(e.target.files);
        
        if (!orderReviewFiles[productId]) {
            orderReviewFiles[productId] = [];
        }
        
        if (orderReviewFiles[productId].length + files.length > 5) {
            Swal.fire('Lỗi', 'Bạn chỉ được đính kèm tối đa 5 hình ảnh hoặc video cho sản phẩm này.', 'error');
            return;
        }
        
        files.forEach(file => {
            if (file.size > 20 * 1024 * 1024) {
                Swal.fire('Lỗi', `File "${file.name}" vượt quá dung lượng giới hạn 20MB.`, 'error');
                return;
            }
            
            orderReviewFiles[productId].push(file);
            
            const isVid = file.type.startsWith('video/');
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item-box';
            
            const removeBtn = document.createElement('span');
            removeBtn.className = 'preview-remove-btn';
            removeBtn.innerHTML = '&times;';
            removeBtn.addEventListener('click', function() {
                const idx = orderReviewFiles[productId].indexOf(file);
                if (idx > -1) {
                    orderReviewFiles[productId].splice(idx, 1);
                }
                previewItem.remove();
            });
            
            if (isVid) {
                const videoEl = document.createElement('video');
                videoEl.src = URL.createObjectURL(file);
                videoEl.muted = true;
                previewItem.appendChild(videoEl);
                
                const playIcon = document.createElement('div');
                playIcon.className = 'video-preview-overlay';
                playIcon.innerHTML = '<i class="bi bi-play-circle-fill"></i>';
                previewItem.appendChild(playIcon);
            } else {
                const imgEl = document.createElement('img');
                imgEl.src = URL.createObjectURL(file);
                previewItem.appendChild(imgEl);
            }
            
            previewItem.appendChild(removeBtn);
            previewContainer.append(previewItem);
        });
        
        fileInput.value = '';
    });

    // Gửi đánh giá cho từng sản phẩm
    $(document).on('submit', '.modal-single-review-form', function(e) {
        e.preventDefault();
        
        const form = this;
        const productId = $(form).find('input[name="sanpham_id"]').val();
        const orderId = $(form).find('input[name="id_dathang"]').val();
        const content = $(form).find('.comment-textarea').val().trim();
        if (content === '') return;

        let formData = new FormData();
        formData.append('_token', $('input[name="_token"]').val());
        formData.append('sanpham_id', productId);
        formData.append('id_dathang', orderId);
        formData.append('content', content);
        
        let ratingVal = $(form).find('input[name="rating"]:checked').val() || 5;
        formData.append('rating', ratingVal);
        
        if (orderReviewFiles[productId]) {
            orderReviewFiles[productId].forEach(file => {
                formData.append('attachments[]', file);
            });
        }

        const submitBtn = $(form).find('.btn-submit-single-review');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang gửi...');

        $.ajax({
            url: "{{ route('comment.post') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: 'Đã gửi đánh giá cho sản phẩm này!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    $(form).html('<div style="color: #10b981; font-weight: 700; font-size: 14px; margin-top: 10px; display: flex; align-items: center; gap: 5px;"><i class="bi bi-check-circle-fill"></i> Đã đánh giá thành công</div>');
                    
                    // Reload page to update buttons and reviewed state
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    Swal.fire('Lỗi', res.message || 'Đã xảy ra lỗi khi gửi đánh giá.', 'error');
                    submitBtn.prop('disabled', false).text('Gửi đánh giá');
                }
            },
            error: function(xhr) {
                let msg = 'Đã xảy ra lỗi khi gửi đánh giá.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire('Lỗi', msg, 'error');
                submitBtn.prop('disabled', false).text('Gửi đánh giá');
            }
        });
    });

    document.querySelectorAll('.btn-cancel-order').forEach(btn => {
        btn.addEventListener('click', function () {

            let form = this.closest('form');

            Swal.fire({
                title: "Bạn chắc chắn muốn hủy đơn?",
                text: "Đơn hàng sẽ bị hủy và không thể khôi phục!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#e63946",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Hủy đơn",
                cancelButtonText: "Không"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        });
    });

    document.querySelectorAll('.btn-repurchase-order').forEach(btn => {
        btn.addEventListener('click', function () {

            let form = this.closest('form');

            Swal.fire({
                title: "Mua lại đơn hàng?",
                text: "Toàn bộ sản phẩm trong đơn hàng cũ này sẽ được thêm vào giỏ hàng của bạn.",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#34A4E0",
                cancelButtonColor: "#6b7280",
                confirmButtonText: "Đồng ý",
                cancelButtonText: "Hủy"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        });
    });

});
</script>

@endsection
