@extends('layout')
@section('content')
<style>
    .page-header {
        background-color: #f8f9fa;
        padding: 40px 0;
        text-align: center;
        border-bottom: 1px solid #eaeaea;
        margin-bottom: 40px;
    }
    .page-header h1 {
        font-size: 36px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
        justify-content: center;
        font-size: 14px;
    }
    .breadcrumb-item a {
        color: #666;
        text-decoration: none;
    }
    .breadcrumb-item.active {
        color: #e53935;
    }
</style>

<div class="page-header">
    <div class="container">
        <h1>Các gói dịch vụ</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Các gói dịch vụ</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container" style="margin-bottom: 60px;">
    @include('partials.rf-packages')
</div>
@endsection
