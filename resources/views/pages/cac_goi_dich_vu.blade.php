@extends('layout')
@section('content')
<style>
    /* Hero Banner */
    .packages-hero {
        position: relative;
        background: linear-gradient(135deg, #111827 0%, #000000 100%);
        padding: 100px 0 80px;
        text-align: center;
        color: white;
        overflow: hidden;
    }
    
    .packages-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070&auto=format&fit=crop') no-repeat center center/cover;
        opacity: 0.3;
        z-index: 0;
    }

    .packages-hero .container {
        position: relative;
        z-index: 1;
    }

    .packages-hero h1 {
        font-size: 3.5rem;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 20px;
        background: linear-gradient(to right, #fcfcfcff, #ffffffff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: 2px;
    }

    .packages-hero p {
        font-size: 1.2rem;
        color: #d1d5db;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Grid Layout */
    .packages-section {
        padding: 80px 0;
        background-color: #f9fafb;
    }

    .packages-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 40px;
        margin-top: 40px;
    }

    /* Card Design */
    .pkg-card {
        background: #ffffff;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        display: flex;
        flex-direction: column;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .pkg-card:hover {
        transform: translateY(-15px);
        box-shadow: 0 20px 40px rgba(72, 99, 248, 1);
    }

    .pkg-image-wrapper {
        position: relative;
        width: 100%;
        height: 220px;
        overflow: hidden;
    }

    .pkg-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .pkg-card:hover .pkg-image {
        transform: scale(1.1);
    }

    .pkg-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #f59e0b, #ea580c);
        color: white;
        padding: 6px 14px;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        box-shadow: 0 4px 10px rgba(234, 88, 12, 0.3);
        animation: pulseBadge 2s infinite;
        z-index: 3;
    }

    @keyframes pulseBadge {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(22, 66, 153, 0.7); }
        70% { transform: scale(1.05); box-shadow: 0 0 0 10px rgba(22, 66, 153, 0.7); }
        100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(22, 66, 153, 0.7); }
    }

    .pkg-type {
        position: absolute;
        bottom: 15px;
        left: 20px;
        background: #111827;
        color: #fff;
        padding: 5px 15px;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        z-index: 2;
        border: 2px solid #fff;
    }

    .pkg-body {
        padding: 40px 30px 30px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .pkg-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: #111827;
        margin-bottom: 10px;
        line-height: 1.3;
    }

    .pkg-short-desc {
        font-size: 0.95rem;
        color: #4b5563;
        margin-bottom: 20px;
        line-height: 1.5;
        font-style: italic;
    }

    .pkg-features {
        list-style: none;
        padding: 0;
        margin: 0 0 25px 0;
        flex: 1;
    }

    .pkg-features li {
        position: relative;
        padding-left: 30px;
        margin-bottom: 12px;
        font-size: 0.95rem;
        color: #4b5563;
        line-height: 1.5;
    }

    .pkg-features li::before {
        content: '\f058';
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        left: 0;
        top: 2px;
        color: #10b981;
        font-size: 1.1rem;
    }

    .pkg-btn {
        display: block;
        width: 100%;
        text-align: center;
        background: linear-gradient(135deg, #2e72ccff, #2e8cccff);
        color: white;
        padding: 14px 20px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .pkg-btn:hover {
        background: linear-gradient(135deg, #316bd6ff, rgba(11, 81, 146, 0.774));
        box-shadow: 0 8px 20px rgba(10, 8, 126, 0.4);
        color: white;
        transform: translateY(-2px);
    }
</style>

<div class="packages-hero">
    <div class="container">
        <h1>Các Gói Dịch Vụ</h1>
        <p>Chọn cho mình một hành trình phù hợp để đánh thức sức mạnh tiềm ẩn, nâng tầm vóc dáng và thay đổi phong cách sống cùng Rise Fitness.</p>
    </div>
</div>

<div class="packages-section">
    <div class="container">
        <div class="text-center" style="margin-bottom: 50px;">
            <h2 style="font-size: 2.5rem; font-weight: 800; color: #111827; text-transform: uppercase;">Khám Phá Các Lựa Chọn</h2>
            <div style="width: 80px; height: 4px; background: #2b52ffff; margin: 15px auto; border-radius: 2px;"></div>
        </div>

        <div class="packages-grid">
            @forelse($goitaps as $goitap)
                <div class="pkg-card">
                    <div class="pkg-image-wrapper">
                        @if($goitap->is_best == 1)
                            <span class="pkg-badge">Được yêu thích</span>
                        @endif
                        <img src="{{ asset($goitap->hinh_anh) }}" alt="{{ $goitap->ten_goi }}" class="pkg-image">
                        <div class="pkg-type">{{ ucfirst($goitap->loai_goi) }}</div>
                    </div>
                    
                    <div class="pkg-body">
                        <h3 class="pkg-title">{{ $goitap->ten_goi }}</h3>
                        
                        @if(!empty($goitap->mo_ta_ngan))
                            <p class="pkg-short-desc">{{ $goitap->mo_ta_ngan }}</p>
                        @endif
                        
                        <ul class="pkg-features">
                            @php
                                $moTa = trim($goitap->mo_ta_chi_tiet);
                                $items = [];
                                if (strpos($moTa, '<li>') !== false) {
                                    if (preg_match_all('/<li[^>]*>(.*?)<\/li>/s', $moTa, $matches)) {
                                        $items = array_map('trim', $matches[1]);
                                        $items = array_map(fn($item) => html_entity_decode(strip_tags($item)), $items);
                                    }
                                } else {
                                    $items = array_filter(
                                        array_map('trim', explode("\n", $moTa)),
                                        fn($line) => !empty($line)
                                    );
                                }
                                if (empty($items)) {
                                    $items = [$goitap->mo_ta_ngan];
                                }
                            @endphp

                            @foreach($items as $item)
                                @if(!empty($item))
                                    <li>{{ $item }}</li>
                                @endif
                            @endforeach
                        </ul>

                        <a href="{{ route('goitap.register.show', $goitap->slug) }}" class="pkg-btn">
                            Đăng Ký Ngay
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 0;">
                    <h3 style="color: #6b7280; font-weight: 500;">Hiện tại chưa có gói dịch vụ nào.</h3>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
