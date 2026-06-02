@extends('layout')
@section('content')

<style>
    .search-order-section {
        background-image: url('/frontend/img/boxing-slide-1.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        min-height: calc(100vh - 180px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 15px;
    }

    .search-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.5);
        width: 100%;
        max-width: 500px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .search-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
    }

    .search-title {
        font-size: 26px;
        font-weight: 800;
        color: #111827;
        margin-bottom: 8px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .search-subtitle {
        font-size: 14px;
        color: #6B7280;
        text-align: center;
        margin-bottom: 30px;
        font-weight: 500;
    }

    .form-group label {
        font-weight: 700;
        color: #374151;
        font-size: 14px;
        margin-bottom: 8px;
        display: block;
    }

    .form-control-premium {
        height: 50px;
        border-radius: 12px;
        border: 1px solid #d1d5db;
        padding: 10px 16px;
        font-size: 15px;
        transition: all 0.25s ease;
        background-color: #fff;
    }

    .form-control-premium:focus {
        border-color: #34A4E0;
        box-shadow: 0 0 0 4px rgba(52, 164, 224, 0.15);
        outline: none;
    }

    .btn-search-premium {
        height: 50px;
        background: linear-gradient(135deg, #34A4E0 0%, #1d4ed8 100%);
        border: none;
        border-radius: 12px;
        color: #fff;
        font-weight: 700;
        font-size: 16px;
        width: 100%;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .btn-search-premium:hover {
        background: linear-gradient(135deg, #1B8AC3 0%, #1e40af 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(37, 99, 235, 0.3);
        color: #fff;
        text-decoration: none;
    }

    .btn-search-premium:active {
        transform: translateY(0);
    }
</style>

<div class="search-order-section">
    <div class="search-card">
        <h1 class="search-title">Tra cứu đơn hàng</h1>
        <p class="search-subtitle">Dành cho khách hàng mua hàng không cần đăng nhập</p>

        <form action="{{ route('guest.search') }}" method="POST">
            @csrf

            <div class="form-group mb-4">
                <label for="ma_don_hang"><i class="bi bi-hash text-primary"></i> Mã đơn hàng <span class="text-danger">*</span></label>
                <input type="number" 
                       name="ma_don_hang" 
                       id="ma_don_hang" 
                       class="form-control form-control-premium" 
                       placeholder="Ví dụ: 15" 
                       value="{{ old('ma_don_hang') }}"
                       required>
            </div>

            <div class="form-group mb-4">
                <label for="sdt"><i class="bi bi-telephone text-primary"></i> Số điện thoại nhận hàng <span class="text-danger">*</span></label>
                <input type="text" 
                       name="sdt" 
                       id="sdt" 
                       class="form-control form-control-premium" 
                       placeholder="Ví dụ: 0987654321" 
                       value="{{ old('sdt') }}"
                       pattern="^0\d{9}$"
                       maxlength="10"
                       title="Số điện thoại phải bắt đầu bằng 0 và gồm 10 chữ số"
                       required>
            </div>

            <button type="submit" class="btn-search-premium">
                <i class="bi bi-search"></i> Tra cứu ngay
            </button>
        </form>
    </div>
</div>

@endsection
