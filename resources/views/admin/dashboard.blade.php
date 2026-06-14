@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-shield-lock-fill" style="color: #a78bfa;"></i> Control Panel Admin</h2>
            <p class="text-muted mb-0">Kelola operasional dan administrasi portal EventPulse</p>
        </div>
        <div class="d-flex gap-2">
            <a href="/admin/verify" class="btn btn-warning position-relative d-flex align-items-center gap-2" style="border-radius: 10px; font-weight: 600; padding: 10px 16px; border: none; color: #000;">
                <i class="bi bi-patch-check"></i> Verifikasi Event
                @if($pendingEvents > 0)
                <span class="badge rounded-pill bg-danger">
                    {{ $pendingEvents }}
                </span>
                @endif
            </a>
            <a href="/admin/laporan" class="btn btn-primary-gradient d-flex align-items-center gap-2" style="border-radius: 10px; font-weight: 600; padding: 10px 16px;">
                <i class="bi bi-graph-up-arrow"></i> Lihat Laporan
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="glass-box d-flex align-items-center justify-content-between p-4" style="border-left: 4px solid #6366f1; height: 100%;">
                <div>
                    <h6 class="text-muted uppercase mb-1" style="font-size: 0.8rem;">Total Event</h6>
                    <h3 class="text-white fw-bold mb-0">{{ $totalEvent }}</h3>
                </div>
                <div style="font-size: 2rem; color: rgba(99,102,241,0.5);"><i class="bi bi-calendar-event"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="glass-box d-flex align-items-center justify-content-between p-4" style="border-left: 4px solid #10b981; height: 100%;">
                <div>
                    <h6 class="text-muted uppercase mb-1" style="font-size: 0.8rem;">Total Peserta</h6>
                    <h3 class="text-white fw-bold mb-0">{{ $totalPeserta }}</h3>
                </div>
                <div style="font-size: 2rem; color: rgba(16,185,129,0.5);"><i class="bi bi-people"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="glass-box d-flex align-items-center justify-content-between p-4" style="border-left: 4px solid #a78bfa; height: 100%;">
                <div>
                    <h6 class="text-muted uppercase mb-1" style="font-size: 0.8rem;">Total User</h6>
                    <h3 class="text-white fw-bold mb-0">{{ $totalUser }}</h3>
                </div>
                <div style="font-size: 2rem; color: rgba(167,139,250,0.5);"><i class="bi bi-person-fill"></i></div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3">
            <div class="glass-box d-flex align-items-center justify-content-between p-4" style="border-left: 4px solid #f59e0b; height: 100%;">
                <div>
                    <h6 class="text-muted uppercase mb-1" style="font-size: 0.8rem;">Event Pending</h6>
                    <h3 class="text-white fw-bold mb-0">{{ $pendingEvents }}</h3>
                </div>
                <div style="font-size: 2rem; color: rgba(245,158,11,0.5);"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>
    </div>

    <!-- Quick Admin Actions -->
    <h5 class="text-white mb-3"><i class="bi bi-sliders" style="color: #a78bfa;"></i> Menu Pintasan</h5>
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <a href="/admin/users" class="card p-4 text-center text-decoration-none h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px;">
                <div class="display-6 mb-2" style="color: #6366f1;"><i class="bi bi-people-fill"></i></div>
                <h6 class="text-white fw-bold mb-1">Kelola Pengguna</h6>
                <p class="text-secondary small mb-0">Manajemen akun user & hak akses</p>
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="/admin/categories" class="card p-4 text-center text-decoration-none h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px;">
                <div class="display-6 mb-2" style="color: #a78bfa;"><i class="bi bi-tags-fill"></i></div>
                <h6 class="text-white fw-bold mb-1">Kelola Kategori</h6>
                <p class="text-secondary small mb-0">Ubah / tambah kategori event</p>
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="/events" class="card p-4 text-center text-decoration-none h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px;">
                <div class="display-6 mb-2" style="color: #10b981;"><i class="bi bi-calendar-event-fill"></i></div>
                <h6 class="text-white fw-bold mb-1">Kelola Event</h6>
                <p class="text-secondary small mb-0">Tinjau & edit postingan kegiatan</p>
            </a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="/admin/peserta" class="card p-4 text-center text-decoration-none h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 16px;">
                <div class="display-6 mb-2" style="color: #f59e0b;"><i class="bi bi-clipboard-data-fill"></i></div>
                <h6 class="text-white fw-bold mb-1">Daftar Peserta</h6>
                <p class="text-secondary small mb-0">Lihat seluruh peserta terdaftar</p>
            </a>
        </div>
    </div>

    <!-- Data Summary Rows -->
    <div class="row">
        <!-- Recent Registrations -->
        <div class="col-lg-7 mb-4">
            <div class="glass-box h-100 p-4">
                <h5 class="text-white mb-4"><i class="bi bi-clock-history text-primary me-2"></i> Pendaftaran Tiket Terbaru</h5>
                <div class="d-flex flex-column gap-3">
                    @forelse($recentRegistrations as $reg)
                    <div class="d-flex justify-content-between align-items-center p-3 rounded" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); transition: background 0.2s ease;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 45px; height: 45px; background: rgba(99,102,241,0.15); color: #a78bfa; font-weight: bold; font-size: 1.1rem; border: 1px solid rgba(99,102,241,0.3);">
                                {{ strtoupper(substr($reg->nama, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="mb-1 text-white fw-semibold">{{ $reg->nama }}</h6>
                                <p class="mb-0 text-muted" style="font-size: 0.85rem;"><i class="bi bi-ticket-detailed me-1"></i> {{ $reg->judul }}</p>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge" style="background: rgba(255,255,255,0.08); color: #cbd5e1; font-weight: normal; padding: 6px 10px; border-radius: 8px;">
                                {{ \Carbon\Carbon::parse($reg->created_at)->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="bi bi-inbox text-muted fs-1 mb-3 d-block opacity-50"></i>
                        <p class="text-muted">Belum ada pendaftaran tiket terbaru.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Top Events -->
        <div class="col-lg-5 mb-4">
            <div class="glass-box h-100 p-4">
                <h5 class="text-white mb-4"><i class="bi bi-trophy-fill text-warning me-2"></i> Event Paling Populer</h5>
                <div class="d-flex flex-column gap-3">
                    @forelse($topEvents as $event)
                    <div class="p-3 rounded" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="mb-0 text-white fw-semibold text-truncate" style="max-width: 65%;" title="{{ $event->judul }}">{{ $event->judul }}</h6>
                            <div class="text-warning fw-bold small" style="background: rgba(245,158,11,0.1); padding: 4px 8px; border-radius: 6px;">
                                <i class="bi bi-people-fill me-1"></i> {{ $event->total_peserta }} / {{ $event->kuota }}
                            </div>
                        </div>
                        <div class="progress mt-3" style="height: 6px; background: rgba(255,255,255,0.08); border-radius: 3px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);">
                            @php
                                $percent = ($event->kuota > 0) ? min(100, ($event->total_peserta / $event->kuota) * 100) : 0;
                            @endphp
                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percent }}%; border-radius: 3px;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x text-muted fs-1 mb-3 d-block opacity-50"></i>
                        <p class="text-muted">Belum ada data event.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection