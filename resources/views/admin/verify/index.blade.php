@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-patch-check-fill" style="color: #a78bfa;"></i> Verifikasi Event</h2>
            <p class="text-muted mb-0">Setujui atau tolak pengajuan event dari penyelenggara</p>
        </div>
        <a href="/admin/dashboard" class="btn btn-outline-light" style="border: 1px solid rgba(255,255,255,0.08); border-radius:10px;"><i class="bi bi-arrow-left"></i> Dashboard</a>
    </div>

    <!-- PENDING EVENTS SECTION -->
    <h4 class="mb-3 text-white d-flex align-items-center gap-2">
        <span class="spinner-grow spinner-grow-sm text-warning" role="status"></span>
        Menunggu Verifikasi ({{ count($pendingEvents) }})
    </h4>

    @if(count($pendingEvents) === 0)
    <div class="glass-box text-center py-5 mb-5">
        <i class="bi bi-check-circle-fill display-4 text-success mb-3"></i>
        <h5 class="text-white">Semua Bersih!</h5>
        <p class="text-muted mb-0">Tidak ada pengajuan event baru yang perlu diverifikasi saat ini.</p>
    </div>
    @else
    <div class="row mb-5">
        @foreach($pendingEvents as $event)
        <div class="col-md-6 mb-4">
            <div class="card h-100" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); border-radius: 20px;">
                <div class="position-relative" style="height: 180px; overflow: hidden; border-top-left-radius: 19px; border-top-right-radius: 19px;">
                    @if($event->banner)
                        <img src="{{ asset('storage/' . $event->banner) }}" class="w-100 h-100 object-fit-cover" alt="{{ $event->judul }}">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #1e1b4b, #311042);">
                            <i class="bi bi-image text-muted display-6"></i>
                        </div>
                    @endif
                    <span class="badge position-absolute" style="background: rgba(245,158,11,0.2); color: #f59e0b; border: 1px solid rgba(245,158,11,0.3); padding: 6px 12px; border-radius: 20px; top: 15px; right: 15px;">
                        Pending
                    </span>
                </div>
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <h5 class="card-title text-white fw-bold mb-2">{{ $event->judul }}</h5>
                        <p class="text-muted small mb-3">Diajukan oleh: <strong class="text-light">{{ $event->creator_name }}</strong></p>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6 text-muted small"><i class="bi bi-calendar-event text-primary"></i> {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</div>
                            <div class="col-6 text-muted small"><i class="bi bi-clock text-primary"></i> {{ substr($event->jam_mulai, 0, 5) }} - {{ substr($event->jam_selesai, 0, 5) }}</div>
                            <div class="col-6 text-muted small"><i class="bi bi-geo-alt text-primary"></i> {{ $event->lokasi }}</div>
                            <div class="col-6 text-muted small"><i class="bi bi-people text-primary"></i> Kuota: {{ $event->kuota }}</div>
                        </div>

                        <p class="card-text text-secondary small mb-4">{{ $event->deskripsi }}</p>
                    </div>

                    <div class="d-flex gap-2">
                        <form action="/admin/verify/{{ $event->id }}/approve" method="POST" class="w-50 approve-form">
                            @csrf
                            <button type="button" class="btn btn-success w-100 btn-approve" style="border-radius: 12px; font-weight: 600; padding: 10px;">
                                <i class="bi bi-check-lg"></i> Setujui
                            </button>
                        </form>
                        <form action="/admin/verify/{{ $event->id }}/reject" method="POST" class="w-50 reject-form">
                            @csrf
                            <button type="button" class="btn btn-danger w-100 btn-reject" style="border-radius: 12px; font-weight: 600; padding: 10px;">
                                <i class="bi bi-x-lg"></i> Tolak
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- HISTORI VERIFIKASI SECTION -->
    <h4 class="mb-3 text-white"><i class="bi bi-clock-history" style="color: #a78bfa;"></i> Aktivitas Terakhir</h4>
    <div class="glass-box">
        <div class="table-responsive">
            <table class="table table-hover text-white" id="historyTable" style="margin-bottom: 0;">
                <thead>
                    <tr style="border-bottom: 2px solid rgba(99,102,241,0.3);">
                        <th>Event</th>
                        <th>Diajukan Oleh</th>
                        <th>Tanggal Event</th>
                        <th>Status</th>
                        <th>Diverifikasi Pada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentVerified as $event)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:36px; height:36px; border-radius:8px; overflow:hidden; background:#1e1e2f; display:flex; align-items:center; justify-content:center;">
                                    @if($event->banner)
                                        <img src="{{ asset('storage/' . $event->banner) }}" class="w-100 h-100 object-fit-cover" alt="">
                                    @else
                                        <i class="bi bi-calendar-event text-secondary"></i>
                                    @endif
                                </div>
                                <span class="fw-semibold text-white">{{ $event->judul }}</span>
                            </div>
                        </td>
                        <td>{{ $event->creator_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</td>
                        <td>
                            @if($event->status === 'published')
                                <span class="badge" style="background: rgba(16,185,129,0.2); color: #34d399; border: 1px solid rgba(16,185,129,0.3); padding: 6px 12px; border-radius: 20px;">
                                    Disetujui
                                </span>
                            @else
                                <span class="badge" style="background: rgba(239,68,68,0.2); color: #f87171; border: 1px solid rgba(239,68,68,0.3); padding: 6px 12px; border-radius: 20px;">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td><span style="color: #64748b;">{{ \Carbon\Carbon::parse($event->updated_at)->format('d M Y H:i') }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SweetAlert2 dialogs -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-approve').on('click', function() {
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Setujui Event?',
                text: 'Event akan langsung dipublikasikan dan dapat didaftar oleh mahasiswa!',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6366f1',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal',
                background: '#1e1e2e',
                color: '#e2e8f0',
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        });

        $('.btn-reject').on('click', function() {
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Tolak Event?',
                text: 'Event akan ditolak dan tidak akan dipublikasikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6366f1',
                confirmButtonText: 'Ya, Tolak!',
                cancelButtonText: 'Batal',
                background: '#1e1e2e',
                color: '#e2e8f0',
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        });
    });
</script>
@endsection
