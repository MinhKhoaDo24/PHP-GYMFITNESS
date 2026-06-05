@extends('layout')
@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/home.css') }}">
<style>
/* ====== HEALTH RESULTS PAGE ====== */
.hr-page {
    background-color: #050505;
    color: #fff;
    padding: 60px 0;
    min-height: 80vh;
}
.hr-header {
    text-align: center;
    margin-bottom: 50px;
}
.hr-header h1 {
    font-size: 42px;
    background: linear-gradient(90deg, #10b981, #3b82f6);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 15px;
}
.hr-header p {
    color: #9ca3af;
    font-size: 18px;
}

/* 3 Metrics Cards */
.metrics-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin-bottom: 60px;
}
.metric-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    backdrop-filter: blur(10px);
    transition: transform 0.3s;
}
.metric-card:hover {
    transform: translateY(-5px);
    border-color: rgba(59, 130, 246, 0.5);
}
.metric-icon {
    font-size: 40px;
    margin-bottom: 20px;
    color: #3b82f6;
}
.metric-title {
    font-size: 16px;
    text-transform: uppercase;
    color: #9ca3af;
    letter-spacing: 1px;
    margin-bottom: 10px;
}
.metric-value {
    font-size: 48px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 10px;
}
.metric-desc {
    font-size: 14px;
    color: #d1d5db;
}

/* Sections */
.section-title {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 30px;
    border-left: 4px solid #3b82f6;
    padding-left: 15px;
}

/* Services Grid */
.hr-services {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 60px;
}
.hr-service-card {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    height: 250px;
    display: block;
}
.hr-service-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.hr-service-card:hover img {
    transform: scale(1.1);
}
.hr-service-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.9), rgba(0,0,0,0.2));
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 20px;
}
.hr-service-overlay h3 {
    color: #fff;
    font-size: 22px;
    margin-bottom: 10px;
}
.hr-service-overlay span {
    color: #3b82f6;
    font-weight: bold;
    font-size: 14px;
}

/* Products are using sale-grid styles from home.css */
.sale-item .sale-name {
    color: #111111 !important;
}
</style>
@endpush

<div class="hr-page">
    <div class="container">
        
        <div class="hr-header">
            <h1>Kết Quả Phân Tích Cơ Thể</h1>
            <p>Dựa trên chỉ số của bạn, dưới đây là lộ trình và gợi ý được thiết kế riêng.</p>
        </div>

        <!-- METRICS -->
        <div class="metrics-grid">
            <div class="metric-card">
                <div class="metric-icon"><i class="fa-solid fa-weight-scale"></i></div>
                <div class="metric-title">Chỉ số BMI</div>
                <div class="metric-value">{{ $bmi }}</div>
                <div class="metric-desc">
                    @if($bmi < 18.5)
                        <span style="color: #ef4444;">Bạn đang thiếu cân</span>
                    @elseif($bmi >= 18.5 && $bmi <= 24.9)
                        <span style="color: #10b981;">Cân nặng của bạn lý tưởng</span>
                    @elseif($bmi >= 25 && $bmi <= 29.9)
                        <span style="color: #f59e0b;">Bạn đang thừa cân</span>
                    @else
                        <span style="color: #ef4444;">Bạn đang béo phì</span>
                    @endif
                </div>
            </div>

            <div class="metric-card">
                <div class="metric-icon"><i class="fa-solid fa-fire"></i></div>
                <div class="metric-title">Tỷ lệ BMR</div>
                <div class="metric-value">{{ $bmr }}</div>
                <div class="metric-desc">Lượng calo tối thiểu cơ thể cần để duy trì sự sống mỗi ngày (không vận động).</div>
            </div>

            <div class="metric-card">
                <div class="metric-icon"><i class="fa-solid fa-bolt"></i></div>
                <div class="metric-title">Chỉ số TDEE</div>
                <div class="metric-value">{{ $tdee }}</div>
                <div class="metric-desc">Tổng lượng calo bạn đốt cháy trong 1 ngày (đã tính vận động).</div>
            </div>
        </div>

        <!-- ADVICE -->
        <div style="background: rgba(59, 130, 246, 0.1); border-left: 4px solid #3b82f6; padding: 25px; border-radius: 8px; margin-bottom: 60px;">
            <h3 style="font-size: 22px; margin-bottom: 10px; color: #fff;">Mục tiêu: <span style="color: #3b82f6;">{{ $goalText }}</span></h3>
            <p style="font-size: 16px; color: #d1d5db; line-height: 1.6;">
                Để đạt được mục tiêu của mình, bạn nên nạp khoảng <strong style="color: #10b981; font-size: 20px;">{{ $caloAdvice }} calo</strong> mỗi ngày. 
                Kết hợp với chế độ tập luyện đều đặn và thực phẩm bổ sung dưới đây, bạn sẽ nhanh chóng thấy sự thay đổi rõ rệt!
            </p>
        </div>

        <!-- RECOMMENDED SERVICES -->
        @if(count($recommendedServices) > 0)
        <h2 class="section-title">Gói Tập Gợi Ý Cho Bạn</h2>
        <div class="hr-services">
            @foreach($recommendedServices as $srv)
            <a href="{{ $srv['url'] }}" class="hr-service-card">
                <img src="{{ asset($srv['img']) }}" alt="{{ $srv['name'] }}">
                <div class="hr-service-overlay">
                    <h3>{{ $srv['name'] }}</h3>
                    <span>Xem chi tiết & Đăng ký <i class="fa-solid fa-arrow-right"></i></span>
                </div>
            </a>
            @endforeach
        </div>
        @endif

        <!-- RECOMMENDED PRODUCTS -->
        @if($recommendedProducts->count() > 0)
        <h2 class="section-title">Sản Phẩm Khuyên Dùng</h2>
        <div class="top-sell-grid">
            @foreach($recommendedProducts as $sp)
            <div class="sale-item" data-href="{{ route('detail', ['id' => $sp->id_sanpham]) }}">
                <!-- IMAGE -->
                <div class="sale-img">
                    @php
                        $img = $sp->images->first();
                        $imagePath = $img ? str_replace('\\', '/', $img->duong_dan) : 'frontend/upload/default.jpg';
                    @endphp
                    <a href="{{ route('detail', ['id' => $sp->id_sanpham]) }}" class="full-link"></a> 
                    <img src="{{ asset($imagePath) }}" alt="{{ $sp->tensp }}">
                </div>

                <!-- ICON HOVER -->
                <div class="hover-icons">
                    <a href="#" class="icon-btn js-add-to-cart" data-url="{{ route('add_to_cart', $sp->id_sanpham) }}"
                        data-id="{{ $sp->id_sanpham }}"
                        data-name="{{ $sp->tensp }}"
                        data-co-size="{{ $sp->co_size }}"
                        data-sizes="{{ $sp->co_size == 1 ? json_encode($sp->sizes->map(function($s){ return ['id'=>$s->id_size,'name'=>$s->ten_size,'qty'=>$s->pivot->soluong,'surcharge'=>(int)$s->pivot->gia_cong_them]; })) : '' }}">
                        <i class="fa fa-shopping-cart"></i>
                    </a>
                    <a href="{{ route('detail', ['id' => $sp->id_sanpham]) }}" class="icon-btn" title="Xem chi tiết">
                        <i class="fa fa-search"></i>
                    </a>
                </div>

                <!-- NAME -->
                <h3 class="sale-name">{{ $sp->tensp }}</h3>

                <!-- PRICE -->
                <div class="sale-price">
                    <span class="new-price">{{ number_format($sp->gia_duoc_giam, 0, ',', '.') }}đ</span>
                    <span class="old-price">{{ number_format($sp->giasp, 0, ',', '.') }}đ</span>
                    <span class="discount">-{{ $sp->giamgia }}%</span>
                </div>

                <!-- PROGRESS BAR -->
                <div class="progress-bar">
                    <div class="progress" style="width: {{ rand(40,90) }}%"></div>
                </div>
                <span class="sold">{{ $sp->sold }} sản phẩm đã bán</span>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('.sale-item').forEach(item => {
        item.addEventListener('click', function(e) {
            if (e.target.closest('.icon-btn')) return;
            window.location.href = this.dataset.href;
        });
    });
</script>
@endpush
@endsection
