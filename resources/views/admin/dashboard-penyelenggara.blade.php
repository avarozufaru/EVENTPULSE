@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-grid-fill" style="color: #fbbf24;"></i> Panel Penyelenggara</h2>
            <p class="text-muted mb-0">Kelola dan pantau event kampus yang Anda selenggarakan</p>
        </div>
        <div class="d-flex gap-2">
            <a href="/events/create" class="btn btn-primary-gradient">
                <i class="bi bi-calendar-plus"></i> Buat Event Baru
            </a>
            <a href="/events" class="btn btn-outline-light" style="border: 1px solid rgba(255,255,255,0.08); border-radius:10px;">
                <i class="bi bi-calendar-event"></i> Kelola Event
            </a>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="glass-box d-flex align-items-center justify-content-between p-4" style="border-left: 4px solid #6366f1; height: 100%;">
                <div>
                    <h6 class="text-muted mb-1">Event Saya</h6>
                    <h3 class="text-white fw-bold mb-0">{{ $totalEvent }}</h3>
                </div>
                <div style="font-size: 2.5rem; color: rgba(99,102,241,0.5);"><i class="bi bi-calendar-week-fill"></i></div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="glass-box d-flex align-items-center justify-content-between p-4" style="border-left: 4px solid #fbbf24; height: 100%;">
                <div>
                    <h6 class="text-muted mb-1">Total Pendaftar</h6>
                    <h3 class="text-white fw-bold mb-0">{{ $totalPeserta }}</h3>
                </div>
                <div style="font-size: 2.5rem; color: rgba(251,191,36,0.5);"><i class="bi bi-people-fill"></i></div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="glass-box d-flex align-items-center justify-content-between p-4" style="border-left: 4px solid #f59e0b; height: 100%;">
                <div>
                    <h6 class="text-muted mb-1">Menunggu Persetujuan</h6>
                    <h3 class="text-white fw-bold mb-0">{{ $pendingEvents }}</h3>
                </div>
                <div style="font-size: 2.5rem; color: rgba(245,158,11,0.5);"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Event Statistics Chart -->
        <div class="col-lg-8 mb-4">
            <div class="glass-box h-100">
                <h5 class="text-white mb-4"><i class="bi bi-bar-chart-fill text-warning"></i> Performa Pendaftaran Event</h5>
                @if(count($eventStats) === 0)
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
            <div class="glass-box h-100 d-flex flex-column justify-content-between">
                <div>
                    <h5 class="text-white mb-4"><i class="bi bi-list-task text-primary"></i> Ringkasan Status Event</h5>
                    <div class="table-responsive">
                        <table class="table table-hover text-white align-middle" style="font-size: 0.9rem;">
                            <thead>
                                <tr class="text-secondary" style="border-bottom: 1px solid rgba(255,255,255,0.06);">
                                    <th>Event</th>
                                    <th>Pendaftar</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($eventStats->take(5) as $event)
                                <tr>
                                    <td class="text-truncate fw-semibold" style="max-width: 140px;" title="{{ $event->judul }}">{{ $event->judul }}</td>
                                    <td>{{ $event->total_peserta }} / {{ $event->kuota }}</td>
                                    <td>
                                        @if($event->status === 'published')
                                            <span class="badge" style="background: rgba(16,185,129,0.2); color: #34d399; border: 1px solid rgba(16,185,129,0.3); padding: 4px 8px; border-radius: 8px;">Aktif</span>
                                        @elseif($event->status === 'pending')
                                            <span class="badge" style="background: rgba(245,158,11,0.2); color: #fbbf24; border: 1px solid rgba(245,158,11,0.3); padding: 4px 8px; border-radius: 8px;">Pending</span>
                                        @else
                                            <span class="badge" style="background: rgba(239,68,68,0.2); color: #f87171; border: 1px solid rgba(239,68,68,0.3); padding: 4px 8px; border-radius: 8px;">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">Belum ada event yang dibuat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if(count($eventStats) > 0)
                <div class="text-end pt-3">
                    <a href="/events" class="btn btn-sm btn-outline-light w-100" style="border-radius: 8px; border: 1px solid rgba(255,255,255,0.08);">Lihat Semua Event</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(count($eventStats) > 0)
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.borderColor = 'rgba(255, 255, 255, 0.06)';

    const performanceCtx = document.getElementById('eventPerformanceChart').getContext('2d');
    const eventTitles = {!! json_encode($eventStats->pluck('judul')) !!};
    const eventRegistrations = {!! json_encode($eventStats->pluck('total_peserta')) !!};
    const eventQuotas = {!! json_encode($eventStats->pluck('kuota')) !!};

    new Chart(performanceCtx, {
        type: 'bar',
        data: {
            labels: eventTitles.map(t => t.length > 20 ? t.substring(0, 17) + '...' : t),
            datasets: [
                {
                    label: 'Pendaftar',
                    data: eventRegistrations,
                    backgroundColor: 'rgba(251, 191, 36, 0.7)',
                    borderColor: '#fbbf24',
                    borderWidth: 1.5,
                    borderRadius: 6,
                },
                {
                    label: 'Kuota Event',
                    data: eventQuotas,
                    backgroundColor: 'rgba(99, 102, 241, 0.3)',
                    borderColor: '#6366f1',
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
                    ticks: { precision: 0 }
                }
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: { boxWidth: 12 }
                }
            }
        }
    });
</script>
@endif
@endsection
