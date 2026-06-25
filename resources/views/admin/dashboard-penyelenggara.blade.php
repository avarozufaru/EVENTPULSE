@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2><i class="bi bi-grid-fill" style="color: #f59e0b;"></i> Panel Penyelenggara</h2>
                <p class="text-muted mb-0">Kelola dan pantau event kampus yang Anda selenggarakan</p>
            </div>
            <div class="d-flex gap-2">
                <a href="/events/create" class="btn btn-primary-gradient">
                    <i class="bi bi-calendar-plus"></i> Buat Event Baru
                </a>
                <a href="/events" class="btn" style="border: 1px solid #e2e8f0; border-radius:10px; color: #475569;">
                    <i class="bi bi-calendar-event"></i> Kelola Event
                </a>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="glass-box d-flex align-items-center justify-content-between p-4"
                    style="border-left: 4px solid #22c55e; height: 100%;">
                    <div>
                        <h6 class="text-muted mb-1">Event Saya</h6>
                        <h3 class="fw-bold mb-0" style="color: #0f172a;">{{ $totalEvent }}</h3>
                    </div>
                    <div style="font-size: 2.5rem; color: rgba(34, 197, 94,0.4);"><i class="bi bi-calendar-week-fill"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="glass-box d-flex align-items-center justify-content-between p-4"
                    style="border-left: 4px solid #fbbf24; height: 100%;">
                    <div>
                        <h6 class="text-muted mb-1">Total Pendaftar</h6>
                        <h3 class="fw-bold mb-0" style="color: #0f172a;">{{ $totalPeserta }}</h3>
                    </div>
                    <div style="font-size: 2.5rem; color: rgba(251,191,36,0.4);"><i class="bi bi-people-fill"></i></div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="glass-box d-flex align-items-center justify-content-between p-4"
                    style="border-left: 4px solid #f59e0b; height: 100%;">
                    <div>
                        <h6 class="text-muted mb-1">Menunggu Persetujuan</h6>
                        <h3 class="fw-bold mb-0" style="color: #0f172a;">{{ $pendingEvents }}</h3>
                    </div>
                    <div style="font-size: 2.5rem; color: rgba(245,158,11,0.4);"><i class="bi bi-hourglass-split"></i></div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Event Statistics Chart -->
            <div class="col-lg-8 mb-4">
                <div class="glass-box h-100">
                    <h5 class="mb-4" style="color: #0f172a;"><i class="bi bi-bar-chart-fill" style="color: #22c55e;"></i>
                        Performa Pendaftaran Event</h5>
                    @if (count($eventStats) === 0)
                        <div class="d-flex align-items-center justify-content-center h-75 py-5 text-center">
                            <div>
                                <i class="bi bi-bar-chart text-muted display-6 mb-2"></i>
                                <p class="text-muted mb-0">Belum ada data event untuk dianalisis.</p>
                            </div>
                        </div>
                    @else
                        <div style="height: 320px; position: relative;">
                            <canvas id="eventPerformanceChart"></canvas>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Event List Summary -->
            <div class="col-lg-4 mb-4">
                <div class="glass-box h-100 d-flex flex-column justify-content-between p-4">
                    <div>
                        <h5 class="mb-4" style="color: #0f172a;"><i class="bi bi-list-task me-2"
                                style="color: #22c55e;"></i> Ringkasan Status Event</h5>
                        <div class="d-flex flex-column gap-3">
                            @forelse($eventStats->take(5) as $event)
                                <div class="p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0 fw-semibold text-truncate" style="max-width: 60%; color: #0f172a;"
                                            title="{{ $event->judul }}">{{ $event->judul }}</h6>
                                        <div>
                                            @if ($event->status === 'published')
                                                <span class="badge"
                                                    style="background: rgba(16,185,129,0.1); color: #059669; border: 1px solid rgba(16,185,129,0.3); padding: 4px 8px; border-radius: 6px;">Aktif</span>
                                            @elseif($event->status === 'pending')
                                                <span class="badge"
                                                    style="background: rgba(245,158,11,0.1); color: #d97706; border: 1px solid rgba(245,158,11,0.3); padding: 4px 8px; border-radius: 6px;">Pending</span>
                                            @else
                                                <span class="badge"
                                                    style="background: rgba(239,68,68,0.1); color: #dc2626; border: 1px solid rgba(239,68,68,0.3); padding: 4px 8px; border-radius: 6px;">Ditolak</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <span class="text-muted small"><i class="bi bi-people-fill me-1"></i>
                                            Pendaftar</span>
                                        <span class="fw-medium small" style="color: #0f172a;">{{ $event->total_peserta }} /
                                            {{ $event->kuota }}</span>
                                    </div>
                                    <div class="progress mt-2"
                                        style="height: 4px; background: #e2e8f0; border-radius: 2px;">
                                        @php
                                            $percent =
                                                $event->kuota > 0
                                                    ? min(100, ($event->total_peserta / $event->kuota) * 100)
                                                    : 0;
                                            $colorStyle =
                                                $percent >= 100
                                                    ? 'background:#ef4444;'
                                                    : ($percent >= 80
                                                        ? 'background:#f59e0b;'
                                                        : 'background:#22c55e;');
                                        @endphp
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $percent }}%; border-radius: 2px; {{ $colorStyle }}">
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <i class="bi bi-calendar-x text-muted fs-1 mb-3 d-block opacity-50"></i>
                                    <p class="text-muted">Belum ada event yang dibuat.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    @if (count($eventStats) > 0)
                        <div class="text-end pt-4 mt-auto">
                            <a href="/events" class="btn btn-sm w-100"
                                style="border-radius: 8px; border: 1px solid #e2e8f0; padding: 8px; color: #475569;">
                                <i class="bi bi-arrow-right-circle me-1"></i> Lihat Semua Event
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (count($eventStats) > 0)
        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            Chart.defaults.color = '#64748b';
            Chart.defaults.borderColor = '#e2e8f0';

            const performanceCtx = document.getElementById('eventPerformanceChart').getContext('2d');
            const eventTitles = {!! json_encode($eventStats->pluck('judul')) !!};
            const eventRegistrations = {!! json_encode($eventStats->pluck('total_peserta')) !!};
            const eventQuotas = {!! json_encode($eventStats->pluck('kuota')) !!};

            new Chart(performanceCtx, {
                type: 'bar',
                data: {
                    labels: eventTitles.map(t => t.length > 20 ? t.substring(0, 17) + '...' : t),
                    datasets: [{
                            label: 'Pendaftar',
                            data: eventRegistrations,
                            backgroundColor: 'rgba(34, 197, 94, 0.7)',
                            borderColor: '#22c55e',
                            borderWidth: 1.5,
                            borderRadius: 6,
                        },
                        {
                            label: 'Kuota Event',
                            data: eventQuotas,
                            backgroundColor: 'rgba(56, 189, 248, 0.25)',
                            borderColor: '#4ade80',
                            borderWidth: 1.5,
                            borderRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                boxWidth: 12
                            }
                        }
                    }
                }
            });
        </script>
    @endif
@endsection
