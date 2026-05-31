@extends('layout')
@section('content')

<style>
    .cart-page {
        padding: 40px 0 80px;
        background: #f1f5f9;
        width: 100%;
    }

    .cart-wrapper {
        width: 100%;
        max-width: 100%;
        margin: 0;
        padding: 0 40px 0;  
    }

    .cart-card {
        background: transparent;   
        border-radius: 0;     
        box-shadow: none;         
        padding: 0;              
        width: 100%;
    }

    .cart-heading {
        margin-bottom: 12px;
    }

    .cart-title {
        font-size: 32px;
        font-weight: 700;
        color: #0b1120;
        margin-bottom: 4px;
    }

    .cart-breadcrumb {
        font-size: 13px;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: .12em;
    }

    .cart-breadcrumb a {
        color: #34A4E0;
        text-decoration: none;
    }

    .cart-breadcrumb span {
        color: #9ca3af;
    }

    .cart-layout {
        display: flex;
        align-items: flex-start;
        gap: 32px;
        margin-top: 20px;
        width: 100%;
    }

    .cart-table-wrapper {
        flex: 2;
        overflow-x: auto;
        width: 100%;
    }

    .cart-table {
        width: 100%;
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 18px;
        overflow: hidden;
    }

    .cart-table thead tr {
        background: #020617;
    }

    .cart-table thead th {
        padding: 14px 16px;
        font-size: 13px;
        letter-spacing: .08em;
        font-weight: 600;
        text-transform: uppercase;
        color: #f9fafb;
        border-bottom: none;
        white-space: nowrap;
    }

    .cart-table tbody tr {
        background: #ffffff;
    }

    .cart-table tbody tr + tr td {
        border-top: 1px solid #e5e7eb;
    }

    .cart-table tbody td {
        padding: 16px;
        vertical-align: middle;
        font-size: 14px;
        color: #111827;
    }

    .cart-product-info {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .cart-product-thumb {
        flex-shrink: 0;
    }

    .cart-product-thumb img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 16px;
        box-shadow: 0 6px 14px rgba(15, 23, 42, 0.25);
    }

    .cart-product-meta {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .cart-product-name {
        font-size: 15px;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .cart-remove {
        padding: 0;
        border: none;
        background: transparent;
        color: #ef4444;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
    }

    .cart-remove i {
        font-size: 12px;
    }

    .cart-price-original,
    .cart-price-discount,
    .cart-price-promo,
    .cart-line-total {
        white-space: nowrap;
    }

    td.cart-price-discount {
        color: #41c0a0 !important;
        font-weight: 600;
    }

    .cart-line-total {
        font-weight: 600;
        color: #111827;
    }

    .quantity-input {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .cart-quantity {
    text-align: center;        
    }

    .quantity-input {
    display: flex;
    align-items: center;
    gap: 6px;
}

.quantity-btn {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    border: none;
    background-color: #34A4E0;
    color: #fff;
    font-size: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    padding: 0;
    transition: 0.2s ease;
}

.quantity-btn:hover {
    background-color: #1e8ac4;
}

.quantity-field {
    width: 45px;             /* vừa cột, không quá to */
    height: 28px;
    border-radius: 6px;
    border: 1px solid #ccc;
    text-align: center;
    font-size: 14px;
    font-weight: 600;
}

.cart-stock-note {
    font-size: 12px;
    color: #777;
    margin-top: 2px;
}


    .cart-summary {
        flex: 0 0 380px;
        background: radial-gradient(circle at top left, #34A4E0 0, #020617 42%, #020617 100%);
        color: #e5e7eb;
        border-radius: 24px;
        padding: 22px 20px 20px;
        position: sticky;
        top: 110px;   
    }

    .cart-summary-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .cart-summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 14px;
        margin-bottom: 6px;
    }

    .cart-summary-row span:first-child {
        color: #9ca3af;
    }

    .cart-summary-total {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px dashed rgba(148, 163, 184, 0.6);
        font-size: 16px;
    }

    .cart-summary-total span:first-child {
        color: #e5e7eb;
    }

    .cart-summary-total span:last-child {
        font-size: 22px;
        font-weight: 700;
        color: #34A4E0;
    }

    .cart-actions {
        margin-top: 18px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .cart-btn {
        display: block;
        width: 100%;
        text-align: center;
        border-radius: 999px;
        padding: 11px 16px;
        font-weight: 600;
        font-size: 13px;
        letter-spacing: .08em;
        text-transform: uppercase;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .cart-btn-continue {
        background: transparent;
        border: 1px solid #374151;
        color: #e5e7eb;
    }

    .cart-btn-continue:hover {
        background: rgba(15, 23, 42, 0.7);
        text-decoration: none;
        color: #e5e7eb;
    }

    .cart-btn-checkout {
        background: #34A4E0;
        color: #020617;
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.6);
    }

    .cart-btn-checkout:hover {
        filter: brightness(1.05);
        text-decoration: none;
        color: #020617;
    }

    .cart-btn i {
        margin-right: 6px;
    }

    .cart-btn a {
        color: inherit;
        text-decoration: none;
    }

    .cart-empty {
        text-align: center;
        padding: 60px 20px 40px;
        color: #6b7280;
    }

    .cart-empty h2 {
        font-size: 22px;
        margin-bottom: 10px;
        color: #111827;
    }

    @media (max-width: 992px) {
        .cart-layout {
            flex-direction: column;
        }

        .cart-summary {
            position: static;
            width: 100%;
        }
    }

    @media (max-width: 768px) {
        .cart-card {
            padding: 20px 16px 18px;
        }

        .cart-title {
            font-size: 26px;
        }

        .cart-table thead th {
            font-size: 11px;
            padding: 10px 8px;
        }

        .cart-table tbody td {
            padding: 12px 8px;
        }
    }

    .cart-toast {
    position: fixed;
    top: 20px;
    right: -300px;
    background: #00c896;
    color: #020617;
    padding: 12px 22px;
    border-radius: 12px;
    font-weight: 600;
    box-shadow: 0 8px 25px rgba(0,0,0,0.25);
    transition: all .35s ease;
    z-index: 9999;
    }

    .cart-toast.show {
        right: 20px;
    }

    .confirm-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 99999;
    }

    .confirm-box {
        background: #ffffff;
        padding: 24px 28px;
        border-radius: 14px;
        width: 340px;
        text-align: center;
        box-shadow: 0 10px 35px rgba(0,0,0,0.25);
    }

    .confirm-box h3 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 18px;
    }

    .confirm-actions {
        display: flex;
        justify-content: space-between;
        gap: 15px;
    }

    .btn-yes, .btn-no {
        flex: 1;
        padding: 10px 14px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        border: none;
    }

    .btn-no {
        background: #e5e7eb;
        color: #111827;
    }

    .btn-yes {
        background: #34A4E0;
        color: #020617;
    }

    .cart-page {
        padding: 40px 0 80px;   
        background: #ffffff;    
    }

    .cart-wrapper,
    .cart-card,
    .cart-layout {
        position: relative;
        z-index: 1;
    }

    .cart-hero {
        width: 100%;
        height: 300px;
        background-image: url('/frontend/img/giohang.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: flex-end;
    }

    .cart-hero-content {
        padding: 30px 40px;
        color: #ffffff;
    }

    .cart-hero-content h1 {
        font-size: 40px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .cart-hero-breadcrumb {
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .cart-hero-breadcrumb a {
        color: #199ef0ff;
        text-decoration: none;
    }

    .btn-delete {
        background: #e53935;
        color: #fff;
        padding: 6px 14px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        transition: 0.2s;
        display: inline-flex;
        width: auto;
    }

    .btn-delete:hover {
        background: #c62828;
    }

    .btn-delete i {
        font-size: 14px;
    }

    .btn-delete { 
        align-self: flex-start; 
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
</style>

<section class="page-header">
    <div class="header-overlay"></div>
    <div class="header-content">
        <h1>ĐƠN HÀNG</h1>
    </div>
</section>

<div class="cart-page">
    <div class="cart-wrapper">

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="cart-card">
            <div class="cart-heading">
                <h1 class="cart-title">Giỏ hàng</h1>
            </div>

            @if(session('cart') && count(session('cart')) > 0)
                @php $total = 0 @endphp

                <div class="cart-layout">
                    <div class="cart-table-wrapper">
                        <table id="cart" class="table table-hover table-condensed cart-table">
                            <thead>
                                <tr>
                                    <th>Ảnh sp</th>
                                    <th>Tên sp</th>
                                    <th>Giá gốc</th>
                                    <th>Giảm giá</th>
                                    <th class="text-center">Giá khuyến mãi</th>
                                    <th class="text-center">Số lượng</th>
                                    <th class="text-right">Tổng tiền</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach(session('cart') as $id => $details)
                                    @php $total += $details['giakhuyenmai'] * $details['quantity'] @endphp
                                    <tr class="cart-item" data-id="{{ $id }}">
                                        <td>
                                            <div class="cart-product-thumb">
                                               <img src="{{ asset($details['anhsp'] ?? 'frontend/upload/placeholder.jpg') }}"
                                                        alt="{{ $details['tensp'] }}" class="img-responsive">
                                            </div>
                                        </td>

                                        <td>
                                            <div class="cart-product-meta">
                                                <div class="cart-product-name">{{ $details['tensp'] }}</div>
                                                <button type="button" class="btn-delete cart_remove">
                                                    <i class="fa fa-trash-o"></i> Xóa
                                                </button>
                                            </div>
                                        </td>

                                        <td class="cart-price-original" data-th="Price">
                                            {{ number_format($details['giasp'], 0, ',', '.') }} VND
                                        </td>

                                        <td class="cart-price-discount" data-th="Price">
                                            {{ $details['giamgia'] }}%
                                        </td>

                                        <td class="cart-price-promo text-center" data-th="Subtotal">
                                            {{ number_format($details['giakhuyenmai'], 0, ',', '.') }} VND
                                        </td>

                                        <td class="cart-quantity" data-th="Quantity">
                                            <div class="quantity-input">
                                                <input
                                                    class="quantity-field quantity cart_update"
                                                    type="number"
                                                    min="1"
                                                    max="{{ $stock[$id] ?? 999 }}"
                                                    value="{{ $details['quantity'] }}"
                                                >

                                                @if(isset($stock[$id]))
                                                    <div class="cart-stock-note">
                                                        Tồn kho: {{ $stock[$id] }}
                                                    </div>
                                                @endif
                                            </div>
                                        </td>

                                        <td class="cart-line-total text-right product-total" data-th="Total">
                                            {{ number_format($details['giakhuyenmai'] * $details['quantity'], 0, ',', '.') }} VND
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <aside class="cart-summary">
                        <div class="cart-summary-title">Tóm tắt đơn hàng</div>

                        <div class="cart-summary-row">
                            <span>Tổng tiền giá gốc</span>
                            <span id="cart-original">
                                {{ number_format($totalOriginal, 0, ',', '.') }} vnđ
                            </span>
                        </div>

                        <div class="cart-summary-row">
                            <span>Tổng tiền giảm giá</span>
                            <span id="cart-discount">
                                {{ number_format($totalDiscount, 0, ',', '.') }} vnđ
                            </span>
                        </div>

                        <div class="cart-summary-row cart-summary-total">
                            <span>Tổng thanh toán</span>
                            <span id="cart-total-final">
                                {{ number_format($totalFinal, 0, ',', '.') }} vnđ
                            </span>
                        </div>

                        <div class="cart-actions">
                            <a href="{{ url('/') }}" class="cart-btn cart-btn-continue">
                                <i class="fa fa-arrow-left"></i> Tiếp tục mua sắm
                            </a>

                            <a href="{{ route('checkout') }}" class="cart-btn cart-btn-checkout">
                                Tiến hành thanh toán
                            </a>
                        </div>
                    </aside>
                </div>
            @else
                <div class="cart-empty">
                    <h2>Giỏ hàng của bạn đang trống</h2>
                    <p>Tiếp tục mua sắm để thêm sản phẩm vào giỏ.</p>
                    <a href="{{ url('/viewAll') }}" class="btn btn-primary mt-3">
                        <i class="fa fa-arrow-left mr-1"></i> Về trang sản phẩm
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>


<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    // Hàm định dạng số tiền
    function formatPrice(price) {
        return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ' vnđ';
    }

    // Xử lý tăng số lượng
    document.querySelectorAll('.increaseValue').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var row = this.closest('tr');
            var quantityInput = row.querySelector('.quantity');
            var value = parseInt(quantityInput.value, 10);
            var max = parseInt(quantityInput.getAttribute('max'), 10);

            if (isNaN(value)) value = 1;
            if (value < max) {
                quantityInput.value = value + 1;
                updateCart(row, quantityInput.value, this);
            }
        });
    });

    // Xử lý giảm số lượng
    document.querySelectorAll('.decreaseValue').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            var row = this.closest('tr');
            var quantityInput = row.querySelector('.quantity');
            var value = parseInt(quantityInput.value, 10);
            var min = parseInt(quantityInput.getAttribute('min'), 10);

            if (value > min) {
                quantityInput.value = value - 1;
                updateCart(row, quantityInput.value, this);
            }
        });
    });

    // Xử lý thay đổi số lượng trực tiếp
    document.querySelectorAll('.cart_update').forEach(function(input) {
        input.addEventListener('change', function(e) {
            e.preventDefault();
            var row = this.closest('tr');
            var value = parseInt(this.value, 10);
            var min = parseInt(this.getAttribute('min'), 10);
            var max = parseInt(this.getAttribute('max'), 10);

            if (isNaN(value) || value < min) {
                this.value = min;
                value = min;
            } else if (value > max) {
                this.value = max;
                value = max;
            }
            updateCart(row, value, this);
        });
    });


    // Xử lý xóa sản phẩm
    document.querySelectorAll('.cart_remove').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            const row = this.closest('tr');
            const id  = row.getAttribute('data-id');

            const modal  = document.getElementById('confirmDeleteModal');
            const btnYes = document.getElementById('confirmYes');
            const btnNo  = document.getElementById('confirmNo');

            modal.style.display = 'flex';

            btnNo.onclick = () => {
                modal.style.display = 'none';
            };

            btnYes.onclick = () => {
                modal.style.display = 'none';

                fetch('/remove-from-cart/' + id, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        showToast('Có lỗi khi xóa sản phẩm!');
                        return;
                    }

                    // Cập nhật badge số lượng ở header
                    if (data.cart_count !== undefined) {
                        const badge = document.querySelector('.navbar__shoppingCart span');
                        if (badge) {
                            badge.textContent = data.cart_count;
                        }
                    }

                    if (data.cart_count === 0) {
                        // Nếu giỏ hàng trống hoàn toàn, load lại trang để hiển thị giao diện giỏ hàng trống
                        location.reload();
                    } else {
                        row.remove();
                        updateCartTotal();
                        showToast('Xóa sản phẩm thành công!');
                    }
                })
                .catch(() => {
                    showToast('Có lỗi khi xóa sản phẩm!');
                });
            };
        });
    });
    function showToast(message) {
    const toast = document.createElement("div");
    toast.className = "cart-toast";
    toast.textContent = message;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add("show");
    }, 10);

    setTimeout(() => {
        toast.classList.remove("show");
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}
    // Hàm cập nhật giỏ hàng
    function updateCart(row, quantity, element) {
        var button = element && element.classList.contains('quantity-btn') ? element : null;
        if (button) {
            button.disabled = true; 
        }

        $.ajax({
            url: '{{ route("update_cart") }}',
            method: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}',
                id: row.getAttribute('data-id'),
                quantity: quantity
            },
            success: function(response) {
                if (response.status === 'success') {
                    var productTotal = row.querySelector('.product-total');
                    if (productTotal && typeof response.product_total !== 'undefined') {
                        productTotal.textContent = formatPrice(response.product_total);
                    }

                    updateCartSummary(response);
                } else {
                    var quantityInput = row.querySelector('.quantity');
                    quantityInput.value = response.quantity || quantityInput.value;
                }
            },
            complete: function() {
                if (button) {
                    button.disabled = false;
                }
            }
        });
    }

    function updateCartSummary(data) {
        var originalEl = document.getElementById('cart-original');
        var discountEl = document.getElementById('cart-discount');
        var finalEl    = document.getElementById('cart-total-final');

        if (originalEl && typeof data.total_original !== 'undefined') {
            originalEl.textContent = formatPrice(data.total_original);
        }
        if (discountEl && typeof data.total_discount !== 'undefined') {
            discountEl.textContent = formatPrice(data.total_discount);
        }
        if (finalEl && typeof data.total_final !== 'undefined') {
            finalEl.textContent = formatPrice(data.total_final);
        }
    }

    function updateCartTotal(total) {
        const rows = document.querySelectorAll('.cart-item');

        let totalOriginal = 0; 
        let totalFinal    = 0; 

        rows.forEach(row => {
            const qtyInput = row.querySelector('.quantity');
            if (!qtyInput) return;

            const qty = parseInt(qtyInput.value, 10) || 0;

            const originalCell = row.querySelector('.cart-price-original');
            const promoCell    = row.querySelector('.cart-price-promo');

            if (!originalCell || !promoCell) return;

            const originalPrice = parseInt(originalCell.textContent.replace(/[^\d]/g, ''), 10) || 0;
            const promoPrice    = parseInt(promoCell.textContent.replace(/[^\d]/g, ''), 10) || 0;

            totalOriginal += originalPrice * qty;
            totalFinal    += promoPrice    * qty;
        });

        const totalDiscount = totalOriginal - totalFinal;

        const originalEl = document.getElementById('cart-original');
        const discountEl = document.getElementById('cart-discount');
        const finalEl    = document.getElementById('cart-total-final');

        if (originalEl) originalEl.textContent = formatPrice(totalOriginal);
        if (discountEl) discountEl.textContent = formatPrice(totalDiscount);
        if (finalEl)    finalEl.textContent    = formatPrice(totalFinal);
    }
});
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const subtotalEl   = document.getElementById('cart-total');       
        const totalFinalEl = document.getElementById('cart-total-final');  

        if (!subtotalEl || !totalFinalEl) return;

        const syncTotal = () => {
            totalFinalEl.textContent = subtotalEl.textContent;
        };

        syncTotal();

        const observer = new MutationObserver(syncTotal);
        observer.observe(subtotalEl, {
            childList: true,
            characterData: true,
            subtree: true
        });
    });
</script>

<!-- Modal xác nhận -->
<div id="confirmDeleteModal" class="confirm-overlay">
    <div class="confirm-box">
        <h3>Bạn có muốn xóa sản phẩm này?</h3>

        <div class="confirm-actions">
            <button id="confirmYes" class="btn-yes">Có</button>
            <button id="confirmNo" class="btn-no">Không</button>
        </div>
    </div>
</div>

@endsection
