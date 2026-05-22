@extends('admin_layout')

@section('admin_content')

<style>
.dashboard-filter button {
    border: none;
    padding: 8px 20px;
    border-radius: 8px;
    background: #f1f5f9;
    font-weight: 600;
    transition: 0.2s;
}
.dashboard-filter button.active {
    background: #10b981;
    color: #fff;
}
.kpi-box {
    background: white;
    padding: 22px;
    border-radius: 14px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
}
.kpi-value {
    font-size: 26px;
    font-weight: 800;
}
.kpi-growth {
    font-size: 13px;
    color: #10b981;
    font-weight: bold;
}
</style>

<h3 class="fw-bold mb-3">Tổng Quan</h3>

<div class="dashboard-filter d-flex gap-2 mb-4">
    <a href="?range=today"><button class="{{ $range=='today'?'active':'' }}">Hôm nay</button></a>
    <a href="?range=week"><button class="{{ $range=='week'?'active':'' }}">Tuần này</button></a>
    <a href="?range=month"><button class="{{ $range=='month'?'active':'' }}">Tháng này</button></a>
    <a href="?range=year"><button class="{{ $range=='year'?'active':'' }}">Năm nay</button></a>
</div>

<div class="row g-4">

    <div class="col-md-3">
        <div class="kpi-box">
            <p>Doanh Thu</p>
            <div class="kpi-value">{{ number_format($stats['revenue'], 0, ',', '.') }} đ</div>
            <div class="kpi-growth">↑ {{ $stats['revenueGrowth'] }}%</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-box">
            <p>Đơn Hàng</p>
            <div class="kpi-value">{{ $stats['orders'] }}</div>
            <div class="kpi-growth">↑ {{ $stats['ordersGrowth'] }}%</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-box">
            <p>Khách Hàng</p>
            <div class="kpi-value">{{ $stats['customers'] }}</div>
            <div class="kpi-growth">↑ {{ $stats['customersGrowth'] }}%</div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="kpi-box">
            <p>Sản Phẩm Đã Bán</p>
            <div class="kpi-value">{{ $stats['soldProducts'] }}</div>
            <div class="kpi-growth">↑ {{ $stats['soldGrowth'] }}%</div>
        </div>
    </div>

</div>

<div class="row mt-4">

    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header fw-bold">Biểu đồ Doanh Thu</div>
            <div class="card-body">
                <canvas id="revenueChart" height="130"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header fw-bold">Biểu đồ Đơn Hàng</div>
            <div class="card-body">
                <canvas id="orderChart" height="130"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header fw-bold">Khách Hàng Mới</div>
            <div class="card-body">
                <canvas id="customerChart" height="130"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header fw-bold">Top Sản phẩm bán chạy</div>
            <div class="card-body">
                <canvas id="soldChart" height="130"></canvas>
            </div>
        </div>
    </div>

</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // 1. Revenue
    fetch("/admin/chart/revenue")
        .then(r => r.json())
        .then(data => {
            new Chart(revenueChart, {
                type: "line",
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: "Doanh thu",
                        data: data.values,
                        borderColor: "#4e73df",
                        backgroundColor: "rgba(78,115,223,0.15)",
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3
                    }]
                }
            });
        });


    // 2. Orders
    fetch("/admin/chart/orders")
        .then(r => r.json())
        .then(data => {
            new Chart(orderChart, {
                type: "bar",
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: "Đơn hàng",
                        data: data.values,
                        backgroundColor: "#1cc88a",
                    }]
                }
            });
        });


    // 3. Customers
    fetch("/admin/chart/customers")
        .then(r => r.json())
        .then(data => {
            new Chart(customerChart, {
                type: "line",
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: "Khách hàng mới",
                        data: data.values,
                        borderColor: "#36b9cc",
                        backgroundColor: "rgba(54,185,204,0.15)",
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    }]
                }
            });
        });


    // 4. Sold products
    fetch("/admin/chart/sold")
        .then(r => r.json())
        .then(data => {
            new Chart(soldChart, {
                type: "pie",
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: "Số lượng",
                        data: data.values,
                        backgroundColor: [
                            "#4e73df", "#1cc88a", "#36b9cc", "#f6c23e", "#e74a3b"
                        ]
                    }]
                }
            });
        });

});
</script>



@endsection
