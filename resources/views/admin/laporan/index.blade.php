@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2><i class="bi bi-graph-up-arrow" style="color: #22c55e;"></i> Laporan Statistik</h2>
                <p class="text-muted mb-0">Analisis dan ringkasan data operasional EventPulse</p>
            </div>
            <a href="/admin/dashboard" class="btn btn-outline-secondary" style="border-radius:10px;"><i
                    class="bi bi-arrow-left"></i> Dashboard</a>
        </div>

        <!-- Stat Cards Grid -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="glass-box d-flex align-items-center justify-content-between p-4"
                    style="border-left: 4px solid #22c55e; height: 100%;">
                    <div>
                        <h6 class="text-muted mb-1">Total Pengguna</h6>
                        <h3 class="fw-bold mb-1" style="color: #0f172a;">{{ $totalUsers }}</h3>
                        <span class="text-secondary small">{{ $totalMahasiswa }} Mhs &bull; {{ $totalPenyelenggara }}
                            Penyelenggara</span>
                    </div>
                    <div style="font-size: 2.5rem; color: rgba(34, 197, 94,0.4);"><i class="bi bi-people-fill"></i></div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="glass-box d-flex align-items-center justify-content-between p-4"
                    style="border-left: 4px solid #4ade80; height: 100%;">
                    <div>
                        <h6 class="text-muted mb-1">Total Event</h6>
                        <h3 class="fw-bold mb-1" style="color: #0f172a;">{{ $totalEvents }}</h3>
                        <span class="text-secondary small">{{ $totalPublished }} Aktif &bull; {{ $totalPending }}
                            Pending</span>
                    </div>
                    <div style="font-size: 2.5rem; color: rgba(56,189,248,0.4);"><i class="bi bi-calendar-check-fill"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="glass-box d-flex align-items-center justify-content-between p-4"
                    style="border-left: 4px solid #10b981; height: 100%;">
                    <div>
                        <h6 class="text-muted mb-1">Total Registrasi Tiket</h6>
                        <h3 class="fw-bold mb-1" style="color: #0f172a;">{{ $totalRegistrations }}</h3>
                        <span class="text-success small"><i class="bi bi-check-circle-fill"></i> Registrasi Terdaftar</span>
                    </div>
                    <div style="font-size: 2.5rem; color: rgba(16,185,129,0.4);"><i
                            class="bi bi-ticket-perforated-fill"></i></div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="row mb-4">
            <div class="col-md-8 mb-4">
                <div class="glass-box h-100">
                    <h5 class="mb-4" style="color: #0f172a;"><i class="bi bi-bar-chart-fill" style="color: #22c55e;"></i>
                        Top 10 Event Pendaftar Terbanyak</h5>
                    <div style="height: 300px; position: relative;">
                        <canvas id="regPerEventChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="glass-box h-100">
                    <h5 class="mb-4" style="color: #0f172a;"><i class="bi bi-pie-chart-fill text-warning"></i> Event per
                        Kategori</h5>
                    <div
                        style="height: 300px; position: relative; display: flex; align-items: center; justify-content: center;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="row">
            <div class="col-12">
                <div class="glass-box">
                    <h5 class="mb-4" style="color: #0f172a;"><i class="bi bi-graph-up text-success"></i> Tren Registrasi
                        Tiket (6 Bulan Terakhir)</h5>
                    <div style="height: 250px; position: relative;">
                        <canvas id="monthlyRegChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Config Chart global options
        Chart.defaults.color = '#64748b';
        Chart.defaults.borderColor = '#e2e8f0';

        // 1. Top 10 Event Chart
        const regEventCtx = document.getElementById('regPerEventChart').getContext('2d');
        const eventLabels = {!! json_encode($regPerEvent->pluck('judul')) !!};
        const eventData = {!! json_encode($regPerEvent->pluck('total')) !!};

        new Chart(regEventCtx, {
            type: 'bar',
            data: {
                labels: eventLabels,
                datasets: [{
                    label: 'Jumlah Pendaftar',
                    data: eventData,
                    backgroundColor: 'rgba(34, 197, 94, 0.65)',
                    borderColor: '#22c55e',
                    borderWidth: 1.5,
                    borderRadius: 8,
                    hoverBackgroundColor: 'rgba(2, 132, 199, 0.8)'
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
                            precision: 0
                        }
                    }
                }
            }
        });

        // 2. Event Per Category Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        const catLabels = {!! json_encode($eventsPerCategory->pluck('nama')) !!};
        const catData = {!! json_encode($eventsPerCategory->pluck('total')) !!};

        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: catLabels,
                datasets: [{
                    data: catData,
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.7)',
                        'rgba(56, 189, 248, 0.7)',
                        'rgba(244, 63, 94, 0.7)',
                        'rgba(251, 191, 36, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(99, 102, 241, 0.7)'
                    ],
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            padding: 15
                        }
                    }
                }
            }
        });

        // 3. Monthly Registrations Chart
        const monthlyCtx = document.getElementById('monthlyRegChart').getContext('2d');
        const monthlyLabels = {!! json_encode($regPerMonth->pluck('bulan')) !!};
        const monthlyData = {!! json_encode($regPerMonth->pluck('total')) !!};

        // Format monthly labels (YYYY-MM to Month Name)
        const formattedLabels = monthlyLabels.map(label => {
            const [year, month] = label.split('-');
            const date = new Date(year, month - 1);
            return date.toLocaleDateString('id-ID', {
                month: 'long',
                year: 'numeric'
            });
        });

        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: formattedLabels,
                datasets: [{
                    label: 'Registrasi Tiket',
                    data: monthlyData,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#ffffff',
                    pointHoverRadius: 6
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
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>
@endsection
