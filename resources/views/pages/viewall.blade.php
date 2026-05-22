@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/sanpham.css') }}">
@endpush

@extends('layout')
@section('content')

@php
$ten = request('category')
? 'SẢN PHẨM: ' . optional($danhmucs->firstWhere('id_danhmuc', request('category')))->ten_danhmuc
: 'TẤT CẢ SẢN PHẨM';
@endphp

<!-- HEADER -->
<section class="page-header">
    <div class="header-overlay"></div>
    <div class="header-content">
        <h1 class="page-title">{{ $ten }}</h1>
    </div>
</section>

<section class="product-page">

    <!-- TOP BAR -->
    <div class="topbar-wrapper">
        <div class="container">
            <div class="top-bar">
                <div class="result-count">
                    Tìm thấy <strong>{{ $sanphams->total() }}</strong> sản phẩm
                </div>

                <div class="sort-box">
                    <select class="sort-select">
                        <option value="">Mặc định</option>
                        <option value="price_asc">Giá tăng dần</option>
                        <option value="price_desc">Giá giảm dần</option>
                        <option value="newest">Mới nhất</option>
                    </select>
                </div>
            </div>
        </div>
    </div>


    <!-- MAIN CONTAINER -->
    <div class="container">
        <div class="row">

            <!-- SIDEBAR FILTER -->
            <aside class="col-lg-3 sidebar">
                <div class="filter-box">

                    <!-- SELECTED FILTER -->
                    <div id="selectedBox" class="selected-filter-box" style="display:none;">
                        <div class="selected-header">
                            <span>Bạn chọn</span>
                            <a href="#" class="clear-all">Bỏ hết</a>
                        </div>
                        <div class="selected-tags" id="selectedTags"></div>
                    </div>

                    <hr class="divider" id="selectedDivider" style="display:none;">


                    <!-- PRICE FILTER -->
                    <div class="filter-group">
                        <h3 class="filter-title">Chọn mức giá</h3>
                        <ul class="filter-list">
                            @foreach([
                            'under500' => 'Dưới 500.000đ',
                            '500-1000' => '500.000đ – 1.000.000đ',
                            '1-3' => '1.000.000đ – 3.000.000đ',
                            '3-5' => '3.000.000đ – 5.000.000đ',
                            '5-7' => '5.000.000đ – 7.000.000đ',
                            'above7' => 'Trên 7.000.000đ'
                            ] as $key => $label)
                            <li>
                                <label>
                                    <input type="checkbox" name="price[]" value="{{ $key }}">
                                    <span>{{ $label }}</span>
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    <hr class="divider">

                    <!-- CATEGORY FILTER -->
                    <div class="filter-group">
                        <h3 class="filter-title">Loại sản phẩm</h3>
                        <ul class="filter-list">
                            @foreach($danhmucs as $dm)
                            <li>
                                <label>
                                    <input type="checkbox" name="category[]" value="{{ $dm->id_danhmuc }}">
                                    <span>{{ $dm->ten_danhmuc }}</span>
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </aside>


            <!-- PRODUCT GRID -->
            <div class="col-lg-9">

                <div class="product-grid" id="productList">
                    @foreach($sanphams as $p)
                    <div class="sale-item" data-href="{{ route('detail', ['id'=>$p->id_sanpham]) }}">

                        <div class="sale-img">
                            @php
                            $img = $p->images->first();
                            $imagePath = $img ? str_replace('\\','/',$img->duong_dan) : 'frontend/upload/placeholder.jpg';
                            @endphp
                            <a href="{{ route('detail', ['id'=>$p->id_sanpham]) }}" class="full-link"></a>
                            <img src="{{ asset($imagePath) }}" alt="{{ $p->tensp }}">
                        </div>

                        <div class="hover-icons">
                            <a href="{{ route('add_to_cart', $p->id_sanpham) }}" class="icon-btn js-add-to-cart" data-url="{{ route('add_to_cart',$p->id_sanpham) }}">
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                            <a href="{{ route('detail', $p->id_sanpham) }}" class="icon-btn">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>
                        <h3 class="sale-name">{{ $p->tensp }}</h3>

                        <div class="sale-price">
                            <span class="new-price">{{ number_format($p->giakhuyenmai) }}đ</span>
                            <span class="old-price">{{ number_format($p->giasp) }}đ</span>
                            <span class="discount">-{{ $p->giamgia }}%</span>
                        </div>

                        <div class="benefit">🔥 Giá tốt nhất thị trường</div>
                        <div class="gift">🎁 Quà tặng trị giá {{ rand(100000,200000) }}đ</div>

                        <div class="progress-bar">
                            <div class="progress" style="width: {{ rand(40,80) }}%"></div>
                        </div>

                        <span class="sold">{{ $p->sold }} sản phẩm đã bán</span>

                    </div>
                    @endforeach

                </div>

                <div class="pagination-wrapper" id="paginationBox">
                    {{ $sanphams->links('pagination::bootstrap-4') }}
                </div>

            </div>

        </div>
    </div>

</section>



<!-- JS AJAX FILTER -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

        // trạng thái filter hiện tại
        const filters = {
            price: "",
            category: [],
            sort: ""
        };

        const priceCbs = document.querySelectorAll("input[name='price[]']");
        const catCbs = document.querySelectorAll("input[name='category[]']");
        const tagBox = document.getElementById("selectedTags");
        const selectedBox = document.getElementById("selectedBox");
        const divider = document.getElementById("selectedDivider");

        function toggleSelectedUI() {
            const show = tagBox.children.length > 0;
            selectedBox.style.display = show ? "block" : "none";
            divider.style.display = show ? "block" : "none";
        }

        /* ===== AJAX LOAD ===== */
        function loadProducts(page = 1) {
            $.ajax({
                url: "{{ route('ajax.filter.products') }}",
                method: "GET",
                data: {
                    price: filters.price,
                    category: filters.category.join(","),
                    sort: filters.sort,
                    page: page,
                },
                success: res => {
                    document.getElementById("productList").innerHTML = res.html;
                    document.getElementById("paginationBox").innerHTML = res.pagination;
                    document.querySelector(".result-count strong").innerText = res.count;
                }
            });
        }


        /* ===== PRICE FILTER (ONLY ONE) ===== */
        priceCbs.forEach(cb => {
            cb.addEventListener("change", function() {

                // uncheck others
                priceCbs.forEach(x => {
                    if (x !== this) x.checked = false
                });

                // update filter
                filters.price = this.checked ? this.value : "";

                // create tag
                tagBox.querySelectorAll("[data-group='price']").forEach(t => t.remove());

                if (this.checked) {
                    const tag = document.createElement("span");
                    tag.className = "tag";
                    tag.dataset.group = "price";
                    tag.innerHTML = this.nextElementSibling.innerText + " ×";

                    tag.onclick = () => {
                        this.checked = false;
                        filters.price = "";
                        tag.remove();
                        toggleSelectedUI();
                        loadProducts();
                    };

                    tagBox.appendChild(tag);
                }

                toggleSelectedUI();
                loadProducts();
            });
        });


        /* ===== CATEGORY FILTER (MULTI SELECT) ===== */
        catCbs.forEach(cb => {
            cb.addEventListener("change", function() {

                const label = this.nextElementSibling.innerText;

                // update filter array
                filters.category = [...document.querySelectorAll("input[name='category[]']:checked")].map(x => x.value);

                const existing = tagBox.querySelector(`[data-tag='cat-${this.value}']`);

                if (this.checked) {
                    if (!existing) {
                        const tag = document.createElement("span");
                        tag.className = "tag";
                        tag.dataset.tag = "cat-" + this.value;
                        tag.innerHTML = label + " ×";

                        tag.onclick = () => {
                            this.checked = false;
                            tag.remove();
                            filters.category = filters.category.filter(i => i != this.value);
                            toggleSelectedUI();
                            loadProducts();
                        };

                        tagBox.appendChild(tag);
                    }
                } else if (existing) {
                    existing.remove();
                }

                toggleSelectedUI();
                loadProducts();
            });
        });


        /* ===== SORT ===== */
        document.querySelector(".sort-select").addEventListener("change", function() {
            filters.sort = this.value;
            loadProducts();
        });


        /* ===== CLEAR ALL ===== */
        document.querySelector(".clear-all").addEventListener("click", e => {
            e.preventDefault();

            priceCbs.forEach(cb => cb.checked = false);
            catCbs.forEach(cb => cb.checked = false);

            filters.price = "";
            filters.category = [];

            tagBox.innerHTML = "";
            toggleSelectedUI();

            loadProducts();
        });


        /* ===== PAGINATION AJAX ===== */
        document.addEventListener("click", e => {
            if (e.target.closest(".pagination a")) {
                e.preventDefault();
                const page = new URL(e.target.href).searchParams.get("page");
                loadProducts(page);
            }
        });

    });
</script>
<script>
    document.addEventListener("click", function(e) {

        // Nếu click vào icon → KHÔNG mở trang
        if (e.target.closest('.icon-btn')) return;

        // Tìm thẻ có class .sale-item gần nhất
        const card = e.target.closest('.sale-item');

        if (card) {
            window.location.href = card.dataset.href;
        }

    });
</script>

@endsection