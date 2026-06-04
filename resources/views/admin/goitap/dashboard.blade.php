@extends('admin_layout')

@section('admin_content')

<style>
/* ============ KPI CARDS ============ */
.kpi-card {
    background: #fff;
    border-radius: 16px;
    padding: 22px 24px;
    box-shadow: 0 4px 20px rgba(255, 255, 255, 0.517);
    border-left: 4px solid transparent;
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
    overflow: hidden;
}
.kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.10);
}
.kpi-card::after {
    content: '';
    position: absolute;
    top: -20px; right: -20px;
    width: 90px; height: 90px;
    border-radius: 50%;
    opacity: 0.06;
    background: currentColor;
}
.kpi-card.blue  { border-left-color: #34A4E0; }
.kpi-card.green { border-left-color: #10b981; }
.kpi-card.orange{ border-left-color: #f59e0b; }
.kpi-card.purple{ border-left-color: #8b5cf6; }
.kpi-card.red   { border-left-color: #ef4444; }

.kpi-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    margin-bottom: 14px;
}
.kpi-icon.blue   { background: rgba(52,164,224,0.12); color: #34A4E0; }
.kpi-icon.green  { background: rgba(16,185,129,0.12); color: #10b981; }
.kpi-icon.orange { background: rgba(245,158,11,0.12);  color: #f59e0b; }
.kpi-icon.purple { background: rgba(139,92,246,0.12); color: #8b5cf6; }
.kpi-icon.red    { background: rgba(239,68,68,0.12);  color: #ef4444; }

.kpi-label { font-size: 13px; color: #64748b; font-weight: 600; margin-bottom: 4px; }
.kpi-value { font-size: 28px; font-weight: 800; color: #0f172a; line-height: 1.1; }
.kpi-sub   { font-size: 12px; color: #94a3b8; margin-top: 4px; }

/* ============ CHART CARDS ============ */
.chart-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    padding: 24px;
    margin-bottom: 24px;
}
.chart-card .chart-title {
    font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 4px;
}
.chart-card .chart-sub {
    font-size: 12px; color: #94a3b8; margin-bottom: 18px;
}

/* ============ STATUS TABLE ============ */
.status-table th {
    font-size: 12px; text-transform: uppercase; letter-spacing: .05em;
    color: #64748b; font-weight: 700; padding: 12px 16px;
    background: #f8fafc; border-bottom: 1px solid #e2e8f0;
}
.status-table td { padding: 14px 16px; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #334155; }
.status-table tbody tr:hover { background: #f8fafc; }

/* ============ BADGE ============ */
.status-pill {
    padding: 4px 12px; border-radius: 99px; font-size: 11px; font-weight: 700; text-transform: uppercase;
}
.pill-dang_tap   { background: #dcfce7; color: #16a34a; }
.pill-cho_thanh_toan { background: #fef9c3; color: #ca8a04; }
.pill-da_thanh_toan  { background: #dbeafe; color: #2563eb; }
.pill-het_han    { background: #fee2e2; color: #dc2626; }
.pill-da_huy     { background: #f1f5f9; color: #64748b; }

/* ============ PAGE HEADER ============ */
.page-hero {
    background: #ffffff;
    border-radius: 20px;
    padding: 32px 36px 28px;
    margin-bottom: 28px;
    color: #0f172a;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid #e2e8f0;
}

/* Decorative blobs */
.page-hero .blob-1 {
    position: absolute; top: -60px; right: -60px;
    width: 240px; height: 240px; border-radius: 50%;
    background: radial-gradient(circle, rgba(52,164,224,0.08) 0%, transparent 70%);
    pointer-events: none;
}
.page-hero .blob-2 {
    position: absolute; bottom: -40px; right: 160px;
    width: 160px; height: 160px; border-radius: 50%;
    background: radial-gradient(circle, rgba(52,164,224,0.05) 0%, transparent 70%);
    pointer-events: none;
}
.page-hero .blob-3 {
    position: absolute; top: 20px; left: 50%;
    width: 100px; height: 100px; border-radius: 50%;
    background: radial-gradient(circle, rgba(52,164,224,0.03) 0%, transparent 70%);
    pointer-events: none;
}

/* Breadcrumb */
.hero-breadcrumb {
    display: flex; align-items: center; gap: 6px;
    font-size: 12px; color: #64748b;
    margin-bottom: 16px; font-weight: 500;
    text-transform: uppercase; letter-spacing: .08em;
}
.hero-breadcrumb i { font-size: 11px; }
.hero-breadcrumb .sep { color: #cbd5e1; }

/* Icon badge */
.hero-icon-badge {
    width: 52px; height: 52px;
    border-radius: 14px;
    background: rgba(52,164,224,0.1);
    border: 1px solid rgba(52,164,224,0.2);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(52,164,224,0.05);
}

/* Filter tabs inside hero */
.hero-filter-tabs {
    display: flex; gap: 6px; flex-wrap: wrap;
    margin-top: 22px;
    padding-top: 20px;
    border-top: 1px solid #f1f5f9;
}
.hero-filter-tab {
    padding: 7px 18px;
    border-radius: 99px;
    font-size: 13px; font-weight: 600;
    color: #64748b;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    text-decoration: none;
    transition: all 0.22s ease;
    display: flex; align-items: center; gap: 6px;
}
.hero-filter-tab:hover {
    color: #34A4E0;
    background: rgba(52,164,224,0.08);
    border-color: rgba(52,164,224,0.2);
    text-decoration: none;
}
.hero-filter-tab.active {
    color: #fff;
    background: linear-gradient(135deg, #34A4E0, #1d7ec5);
    border-color: transparent;
    box-shadow: 0 4px 14px rgba(52,164,224,0.3);
}
.hero-filter-tab .tab-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: currentColor; opacity: 0.7;
    display: none;
}
.hero-filter-tab.active .tab-dot { display: inline-block; opacity: 1; }

/* Live indicator */
.live-indicator {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 11px; color: #10b981; font-weight: 600;
    background: rgba(16,185,129,0.10);
    border: 1px solid rgba(16,185,129,0.25);
    padding: 3px 10px; border-radius: 99px;
}
.live-dot {
    width: 6px; height: 6px; border-radius: 50%; background: #10b981;
    animation: pulse-live 1.6s infinite;
}
@keyframes pulse-live {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(0.7); }
}
</style>

<!-- Page Hero (redesigned) -->
<div class="page-hero">
    <!-- Decorative blobs -->
    <div class="blob-1"></div>
    <div class="blob-2"></div>
    <div class="blob-3"></div>

    <!-- Breadcrumb -->
    <div class="hero-breadcrumb">
        <i class="bi bi-grid-1x2"></i>
        <span>Admin</span>
        <span class="sep">/</span>
        <i class="bi bi-award"></i>
        <span>Gói Tập Gym</span>
        <span class="sep">/</span>
        <span style="color:#0f172a;">Dashboard</span>
    </div>

    <!-- Title row -->
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="hero-icon-badge">
                <i class="bi bi-bar-chart-line-fill" style="font-size:24px;color:#34A4E0;"></i>
            </div>
            <div>
                <h4 class="fw-bold mb-1" style="font-size:24px;letter-spacing:-0.3px;color:#0f172a;">
                    Dashboard Gói Tập Gym
                </h4>
                <p class="mb-0" style="font-size:13px;color:#64748b;line-height:1.5;">
                    Thống kê tổng quan về đăng ký, doanh thu và hiệu suất gói tập
                </p>
            </div>
        </div>
        <div class="live-indicator">
            <span class="live-dot"></span>
            Dữ liệu thực
        </div>
    </div>

    <!-- Filter tabs -->
    <div class="hero-filter-tabs">
        <a href="?range=week"    class="hero-filter-tab {{ $range=='week'    ? 'active' : '' }}">
            <span class="tab-dot"></span>
            <i class="bi bi-calendar-week" style="font-size:12px;"></i> Tuần này
        </a>
        <a href="?range=month"   class="hero-filter-tab {{ $range=='month'   ? 'active' : '' }}">
            <span class="tab-dot"></span>
            <i class="bi bi-calendar-month" style="font-size:12px;"></i> Tháng này
        </a>
        <a href="?range=quarter" class="hero-filter-tab {{ $range=='quarter' ? 'active' : '' }}">
            <span class="tab-dot"></span>
            <i class="bi bi-calendar3" style="font-size:12px;"></i> Quý này
        </a>
        <a href="?range=year"    class="hero-filter-tab {{ $range=='year'    ? 'active' : '' }}">
            <span class="tab-dot"></span>
            <i class="bi bi-calendar-range" style="font-size:12px;"></i> Năm nay
        </a>
        <span style="margin-left:auto;font-size:12px;color:#94a3b8;align-self:center;font-style:italic;">
            Đang xem: <strong style="color:#475569;">{{ $rangeLabel }}</strong>
        </span>
    </div>
</div>

<!-- KPI Row -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-card blue">
            <div class="kpi-icon blue"><i class="bi bi-clipboard2-check"></i></div>
            <div class="kpi-label">Tổng Đăng Ký</div>
            <div class="kpi-value">{{ number_format($kpi['total_registrations']) }}</div>
            <div class="kpi-sub">Tất cả trạng thái</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-card green">
            <div class="kpi-icon green"><i class="bi bi-currency-exchange"></i></div>
            <div class="kpi-label">Doanh Thu</div>
            <div class="kpi-value" style="font-size:22px;">{{ number_format($kpi['revenue'],0,',','.') }} đ</div>
            <div class="kpi-sub">Đã & đang tập luyện</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-card orange">
            <div class="kpi-icon orange"><i class="bi bi-person-check"></i></div>
            <div class="kpi-label">Đang Tập Luyện</div>
            <div class="kpi-value">{{ number_format($kpi['active']) }}</div>
            <div class="kpi-sub">Trạng thái đang_tap</div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="kpi-card purple">
            <div class="kpi-icon purple"><i class="bi bi-people-fill"></i></div>
            <div class="kpi-label">Có PT Kèm</div>
            <div class="kpi-value">{{ number_format($kpi['with_pt']) }}</div>
            <div class="kpi-sub">Trong {{ $kpi['total_registrations'] }} đăng ký</div>
        </div>
    </div>
</div>

<!-- Row 1: Đăng ký + Doanh thu (Side-by-side) -->
<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="chart-card h-100">
            <div class="chart-title">📈 Số lượt đăng ký theo thời gian</div>
            <div class="chart-sub">Biểu đồ theo {{ $rangeLabel }}</div>
            <canvas id="registrationChart" height="150"></canvas>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="chart-card h-100">
            <div class="chart-title">💰 Doanh thu gói tập theo thời gian</div>
            <div class="chart-sub">Tổng tiền đăng ký theo {{ $rangeLabel }}</div>
            <canvas id="revenueChart" height="150"></canvas>
        </div>
    </div>
</div>

<!-- Row 2: Biểu đồ tròn/doughnut (Bé lại & thẳng hàng ngang) -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="chart-card h-100 text-center">
            <div class="chart-title text-start">🏅 Phân bổ loại gói tập</div>
            <div class="chart-sub text-start">Silver / Gold / Diamond</div>
            <div style="max-width: 250px; margin: 0 auto; padding: 10px 0;">
                <canvas id="packageTypeChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="chart-card h-100 text-center">
            <div class="chart-title text-start">🧑‍💼 Tỷ lệ đăng ký có PT / không PT</div>
            <div class="chart-sub text-start">Trong kỳ lọc hiện tại</div>
            <div style="max-width: 250px; margin: 0 auto; padding: 10px 0;">
                <canvas id="ptRatioChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Row 3: Top gói tập + Trạng thái -->
<div class="row g-4 mb-2">
    <div class="col-lg-6">
        <div class="chart-card">
            <div class="chart-title">🏆 Đăng ký theo từng gói tập</div>
            <div class="chart-sub">So sánh lượt đăng ký giữa các gói</div>
            <canvas id="perPackageChart" height="160"></canvas>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="chart-card">
            <div class="chart-title">📊 Phân bổ thời hạn đăng ký</div>
            <div class="chart-sub">1 / 3 / 6 / 12 tháng</div>
            <canvas id="durationChart" height="160"></canvas>
        </div>
    </div>
</div>

<!-- Bảng Top gói tập & Trạng thái chi tiết -->
<div class="row g-4 mb-4">
    <div class="col-lg-12">
        <div class="chart-card">
            <div class="chart-title mb-3">📋 Danh sách đăng ký gói tập gần đây</div>
            <div class="table-responsive">
                <table class="table status-table mb-0" style="border-radius:12px;overflow:hidden;">
                    <thead>
                        <tr>
                            <th>Mã ĐK</th>
                            <th>Khách hàng</th>
                            <th>Gói tập</th>
                            <th>Thời hạn</th>
                            <th>Tổng tiền</th>
                            <th>Có PT</th>
                            <th>Trạng thái</th>
                            <th>Ngày đăng ký</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRegistrations as $reg)
                        <tr>
                            <td class="fw-bold" style="color:#34A4E0;">{{ $reg->ma_dang_ky }}</td>
                            <td>{{ $reg->user->hoten ?? '—' }}</td>
                            <td>{{ $reg->packagePrice->goitap->ten_goi ?? '—' }}</td>
                            <td>{{ $reg->packagePrice->so_thang ?? '—' }} tháng</td>
                            <td class="fw-bold">{{ number_format($reg->tong_tien,0,',','.') }} đ</td>
                            <td>
                                @if($reg->co_pt)
                                    <span class="badge bg-success">Có PT</span>
                                @else
                                    <span class="badge bg-secondary">Không</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $pills = [
                                        'dang_tap'       => ['Đang tập','dang_tap'],
                                        'cho_thanh_toan' => ['Chờ TT','cho_thanh_toan'],
                                        'da_thanh_toan'  => ['Đã TT','da_thanh_toan'],
                                        'het_han'        => ['Hết hạn','het_han'],
                                        'da_huy'         => ['Đã hủy','da_huy'],
                                    ];
                                    [$label, $cls] = $pills[$reg->trang_thai] ?? [$reg->trang_thai, 'da_huy'];
                                @endphp
                                <span class="status-pill pill-{{ $cls }}">{{ $label }}</span>
                            </td>
                            <td>{{ $reg->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center text-muted py-4">Không có dữ liệu</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const RANGE = "{{ $range }}";
const API   = "/admin/goitap/chart";

// Default chart options
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color = '#64748b';

// 1. Biểu đồ đăng ký theo thời gian
fetch(`${API}/registrations?range=${RANGE}`)
    .then(r => r.json())
    .then(data => {
        new Chart(document.getElementById('registrationChart'), {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Lượt đăng ký',
                    data: data.values,
                    borderColor: '#34A4E0',
                    backgroundColor: 'rgba(52,164,224,0.10)',
                    fill: true, tension: 0.4, borderWidth: 3,
                    pointBackgroundColor: '#34A4E0',
                    pointRadius: 4,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });

// 2. Biểu đồ loại gói tập (silver/gold/diamond)
fetch(`${API}/package-type?range=${RANGE}`)
    .then(r => r.json())
    .then(data => {
        new Chart(document.getElementById('packageTypeChart'), {
            type: 'doughnut',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.values,
                    backgroundColor: ['#94a3b8','#f59e0b','#06b6d4'],
                    borderWidth: 3, borderColor: '#fff',
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                cutout: '65%',
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 16, font: { size: 13 } } }
                }
            }
        });
    });

// 3. Biểu đồ doanh thu
fetch(`${API}/revenue?range=${RANGE}`)
    .then(r => r.json())
    .then(data => {
        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Doanh thu (đ)',
                    data: data.values,
                    backgroundColor: 'rgba(16,185,129,0.80)',
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ' ' + ctx.parsed.y.toLocaleString('vi-VN') + ' đ'
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' },
                         ticks: { callback: v => (v/1000000).toFixed(1)+'M' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });

// 4. Biểu đồ tỷ lệ PT
fetch(`${API}/pt-ratio?range=${RANGE}`)
    .then(r => r.json())
    .then(data => {
        new Chart(document.getElementById('ptRatioChart'), {
            type: 'pie',
            data: {
                labels: ['Có PT', 'Không có PT'],
                datasets: [{
                    data: [data.with_pt, data.without_pt],
                    backgroundColor: ['#8b5cf6','#e2e8f0'],
                    borderWidth: 3, borderColor: '#fff',
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom', labels: { padding: 16, font: { size: 13 } } },
                    tooltip: {
                        callbacks: {
                            label: ctx => {
                                const total = ctx.dataset.data.reduce((a,b) => a+b, 0);
                                const pct = total > 0 ? ((ctx.parsed/total)*100).toFixed(1) : 0;
                                return ` ${ctx.label}: ${ctx.parsed} (${pct}%)`;
                            }
                        }
                    }
                }
            }
        });
    });

// 5. Đăng ký theo từng gói tập
fetch(`${API}/per-package?range=${RANGE}`)
    .then(r => r.json())
    .then(data => {
        new Chart(document.getElementById('perPackageChart'), {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Lượt đăng ký',
                    data: data.values,
                    backgroundColor: ['#34A4E0','#10b981','#f59e0b','#8b5cf6','#ef4444','#06b6d4'],
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    x: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
                    y: { grid: { display: false } }
                }
            }
        });
    });

// 6. Phân bổ thời hạn đăng ký
fetch(`${API}/duration?range=${RANGE}`)
    .then(r => r.json())
    .then(data => {
        new Chart(document.getElementById('durationChart'), {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Lượt đăng ký',
                    data: data.values,
                    backgroundColor: ['#34A4E0','#10b981','#f59e0b','#ef4444'],
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>

@endsection
