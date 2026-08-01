@extends('layouts.admin')

@section('title', 'Beranda Dashboard')

@section('styles')
<style>
    .pagination {
        margin-bottom: 0;
        gap: 3px;
    }
    .pagination .page-link {
        padding: 3px 8px;
        font-size: 0.72rem;
        border-radius: 6px;
        color: #E74C3C;
        border-color: #E2E8F0;
        background-color: #ffffff;
    }
    .pagination .page-item.active .page-link {
        background-color: #E74C3C;
        border-color: #E74C3C;
        color: white;
    }
    .pagination .page-link:hover {
        background-color: rgba(231, 76, 60, 0.05);
        border-color: #E74C3C;
        color: #E74C3C;
    }
    .pagination .page-item.disabled .page-link {
        color: #94A3B8;
        border-color: #E2E8F0;
        background-color: #F8F9FA;
    }
</style>
@endsection

@section('content')
<div class="row g-4 mb-4">
    <!-- Stat Card 1 -->
    <div class="col-xl-3 col-sm-6">
        <div class="card-stat d-flex align-items-center justify-content-between shadow-sm h-100">
            <div>
                <span class="text-muted small fw-medium d-block mb-1">Total Sertifikat</span>
                <h3 class="fw-bold mb-0 text-dark">{{ $jumlah_sertifikat }}</h3>
            </div>
            <div class="stat-icon bg-danger-subtle text-danger">
                <i class="fa-solid fa-award"></i>
            </div>
        </div>
    </div>
    
    <!-- Stat Card 2 -->
    <div class="col-xl-3 col-sm-6">
        <div class="card-stat d-flex align-items-center justify-content-between shadow-sm h-100">
            <div>
                <span class="text-muted small fw-medium d-block mb-1">Total Download</span>
                <h3 class="fw-bold mb-0 text-dark">{{ $jumlah_download }}</h3>
            </div>
            <div class="stat-icon bg-primary-subtle text-primary">
                <i class="fa-solid fa-circle-down"></i>
            </div>
        </div>
    </div>


    <!-- Stat Card 4 -->
    <div class="col-xl-3 col-sm-6">
        <div class="card-stat d-flex align-items-center justify-content-between shadow-sm h-100">
            <div>
                <span class="text-muted small fw-medium d-block mb-1">Download Hari Ini</span>
                <h3 class="fw-bold mb-0 text-dark">{{ $jumlah_hari_ini }}</h3>
            </div>
            <div class="stat-icon bg-success-subtle text-success">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4 align-items-stretch">
    <!-- Chart Section -->
    <div class="col-lg-8">
        <div class="card-custom-admin shadow-sm h-100 d-flex flex-column justify-content-between">
            <div>
                <h5 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-chart-line me-2 text-danger"></i>Grafik Unduhan (7 Hari Terakhir)</h5>
                <div style="height: 300px; position: relative;">
                    <canvas id="downloadChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="col-lg-4">
        <div class="card-custom-admin shadow-sm h-100 d-flex flex-column justify-content-between">
            <div>
                <h5 class="fw-bold mb-4 text-dark"><i class="fa-solid fa-bolt me-2 text-warning"></i>Aktivitas Terbaru</h5>
                
                @if($recent_activities->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="fa-solid fa-clock-rotate-left fa-2x mb-3 d-block"></i>
                        <span>Belum ada aktivitas unduhan terdeteksi.</span>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($recent_activities as $activity)
                            <div class="list-group-item bg-transparent border-0 px-0 py-2 d-flex align-items-start gap-2.5">
                                <div class="bg-success-subtle text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; flex-shrink: 0;">
                                    <i class="fa-solid fa-download" style="font-size: 0.8rem;"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="d-block fw-semibold text-dark small" style="line-height: 1.25;">{{ $activity->certificate->nama_siswa }}</span>
                                    <span class="text-muted d-block" style="font-size: 0.72rem; margin-top: 1px;">Unduh: <strong>{{ $activity->certificate->code }}</strong></span>
                                    <small class="text-muted" style="font-size: 0.65rem;">
                                        <i class="fa-regular fa-clock me-1"></i>{{ $activity->created_at->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            @if(!$recent_activities->isEmpty())
                <!-- Mini Pagination Links -->
                <div class="mt-3 pt-2 border-top d-flex justify-content-center" style="font-size: 0.75rem;">
                    {!! $recent_activities->appends(request()->except('activities_page'))->links('pagination::bootstrap-5') !!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('downloadChart').getContext('2d');
        
        const labels = {!! json_encode($chart_labels) !!};
        const dataValues = {!! json_encode($chart_data) !!};
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Unduhan',
                    data: dataValues,
                    borderColor: '#E74C3C',
                    backgroundColor: 'rgba(231, 76, 60, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#FF6B35',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            color: '#94A3B8'
                        },
                        grid: {
                            color: 'rgba(148, 163, 184, 0.15)'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#94A3B8'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
