@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/chitietsanpham.css') }}">
@endpush
@extends('layout')
@section('content')

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
                <!-- OVERLAY XEM ẢNH -->
                <div id="imgOverlay" class="img-overlay">
                    <span class="close-preview">&times;</span>
                    <img id="imgOverlayDisplay" class="overlay-img">
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

            <div class="meta">
                <span><strong>Danh mục: </strong>
                    <strong style="color: #34A4E0;">{{ optional($sanpham->danhmuc)->ten_danhmuc ?? 'Gym' }}</strong>
                </span>

                <span>|</span>
                <span>Tình trạng: 
                    <strong class="{{ $sanpham->soluong > 0 ? 'stock-yes' : 'stock-no' }}">
                        {{ $sanpham->soluong > 0 ? 'Còn hàng' : 'Hết hàng' }}
                    </strong>
                </span>
            </div>

            <div class="price-box">
                <span class="current-price">
                    {{ number_format($sanpham->giakhuyenmai ?: $sanpham->giasp) }}đ
                </span>

                @if($sanpham->giakhuyenmai > 0 && $sanpham->giakhuyenmai < $sanpham->giasp)
                    <span class="old-price">{{ number_format($sanpham->giasp) }}đ</span>
                    <span class="save-price">Tiết kiệm: {{ number_format($sanpham->giasp - $sanpham->giakhuyenmai) }}đ</span>
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
                    <a id="add-to-cart-btn" href="{{ route('add_to_cart', $sanpham->id_sanpham) }}?quantity=1" class="btn add-cart">
                        Thêm vào giỏ hàng
                    </a>

                    <a id="buy-now-btn" href="{{ route('add_go_to_cart', $sanpham->id_sanpham) }}?quantity=1" class="btn buy-now">
                        Mua ngay
                    </a>
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

            @if($comments->count() === 0)
                <p>Hiện chưa có đánh giá nào.</p>
            @else
                @foreach($comments as $c)
                    <div class="review-item">
                        <strong>{{ $c->user->name ?? 'Khách hàng' }}</strong>
                        <p>{{ $c->content }}</p>
                    </div>
                @endforeach
            @endif
        </div>

    </div>
</section>




<script>
function changeQty(num) {
    let input = document.getElementById('qtyInput');
    let val = parseInt(input.value) + num;
    if (val < 1) val = 1;
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
    const closeBtn = document.querySelector(".close-preview");

    // Click ảnh chính → mở overlay
    mainImg.addEventListener("click", function() {
        overlayImg.src = this.src;
        overlay.style.display = "flex";
    });

    // Click nút close
    closeBtn.addEventListener("click", function() {
        overlay.style.display = "none";
    });

    // Click ra ngoài ảnh để đóng
    overlay.addEventListener("click", function(e) {
        if (e.target === overlay) {
            overlay.style.display = "none";
        }
    });
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





@endsection