@foreach($products as $p)
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
        <a href="#" class="icon-btn js-add-to-cart" data-url="{{ route('add_to_cart',$p->id_sanpham) }}"
           data-id="{{ $p->id_sanpham }}"
           data-name="{{ $p->tensp }}"
           data-co-size="{{ $p->co_size }}"
           data-sizes="{{ $p->co_size == 1 ? json_encode($p->sizes->map(function($s){ return ['id'=>$s->id_size,'name'=>$s->ten_size,'qty'=>$s->pivot->soluong,'surcharge'=>(int)$s->pivot->gia_cong_them]; })) : '' }}">
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
