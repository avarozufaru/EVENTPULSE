@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-patch-check-fill" style="color: #0ea5e9;"></i> Verifikasi Event</h2>
            <p class="text-muted mb-0">Setujui atau tolak pengajuan event dari penyelenggara</p>
        </div>
        <a href="/admin/dashboard" class="btn btn-outline-secondary" style="border-radius:10px;"><i class="bi bi-arrow-left"></i> Dashboard</a>
    </div>

    <!-- PENDING EVENTS SECTION -->
    <h4 class="mb-3 d-flex align-items-center gap-2" style="color: #0f172a;">
        <span class="spinner-grow spinner-grow-sm text-warning" role="status"></span>
        Menunggu Verifikasi ({{ count($pendingEvents) }})
    </h4>

    @if(count($pendingEvents) === 0)
    <div class="glass-box text-center py-5 mb-5">
        <i class="bi bi-check-circle-fill display-4 text-success mb-3"></i>
        <h5 style="color: #0f172a;">Semua Bersih!</h5>
        <p class="text-muted mb-0">Tidak ada pengajuan event baru yang perlu diverifikasi saat ini.</p>
    </div>
    @else
    <div class="row mb-5">
        @foreach($pendingEvents as $event)
        <div class="col-md-6 mb-4">
            <div class="card h-100" style="background: #ffffff; border: 1px solid rgba(14,165,233,0.1); border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                <div class="position-relative" style="height: 180px; overflow: hidden; border-top-left-radius: 19px; border-top-right-radius: 19px;">
                    @if($event->banner)
                        <img src="{{ asset('storage/' . $event->banner) }}" class="w-100 h-100 object-fit-cover" alt="{{ $event->judul }}">
                    @else
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #e0f2fe, #bae6fd);">
                            <i class="bi bi-image text-secondary display-6"></i>
                        </div>
                    @endif
                    <span class="badge position-absolute" style="background: rgba(245,158,11,0.15); color: #d97706; border: 1px solid rgba(245,158,11,0.3); padding: 6px 12px; border-radius: 20px; top: 15px; right: 15px;">
                        Pending
                    </span>
                </div>
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <h5 class="card-title fw-bold mb-2" style="color: #0f172a;">{{ $event->judul }}</h5>
                        <p class="text-muted small mb-3">Diajukan oleh: <strong class="text-dark">{{ $event->creator_name }}</strong></p>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-6 text-muted small"><i class="bi bi-calendar-event" style="color: #0ea5e9;"></i> {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</div>
                            <div class="col-6 text-muted small"><i class="bi bi-clock" style="color: #0ea5e9;"></i> {{ substr($event->jam_mulai, 0, 5) }} - {{ substr($event->jam_selesai, 0, 5) }}</div>
                            <div class="col-6 text-muted small"><i class="bi bi-geo-alt" style="color: #0ea5e9;"></i> {{ $event->lokasi }}</div>
                            <div class="col-6 text-muted small"><i class="bi bi-people" style="color: #0ea5e9;"></i> Kuota: {{ $event->kuota }}</div>
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
    <h4 class="mb-3" style="color: #0f172a;"><i class="bi bi-clock-history" style="color: #0ea5e9;"></i> Aktivitas Terakhir</h4>
    <div class="glass-box">
        <div class="table-responsive">
            <table class="table table-hover" id="historyTable" style="margin-bottom: 0;">
                <thead>
                    <tr style="border-bottom: 2px solid rgba(14,165,233,0.3);">
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
                                <div style="width:36px; height:36px; border-radius:8px; overflow:hidden; background:#f1f5f9; display:flex; align-items:center; justify-content:center;">
                                    @if($event->banner)
                                        <img src="{{ asset('storage/' . $event->banner) }}" class="w-100 h-100 object-fit-cover" alt="">
                                    @else
                                        <i class="bi bi-calendar-event text-secondary"></i>
                                    @endif
                                </div>
                                <span class="fw-semibold text-dark">{{ $event->judul }}</span>
                            </div>
                        </td>
                        <td class="text-muted">{{ $event->creator_name }}</td>
                        <td class="text-muted">{{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</td>
                        <td>
                            @if($event->status === 'published')
                                <span class="badge" style="background: rgba(16,185,129,0.1); color: #059669; border: 1px solid rgba(16,185,129,0.2); padding: 6px 12px; border-radius: 20px;">
                                    Disetujui
                                </span>
                            @else
                                <span class="badge" style="background: rgba(239,68,68,0.1); color: #dc2626; border: 1px solid rgba(239,68,68,0.2); padding: 6px 12px; border-radius: 20px;">
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
                cancelButtonColor: '#0ea5e9',
                confirmButtonText: 'Ya, Setujui!',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                color: '#1e293b',
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
                cancelButtonColor: '#0ea5e9',
                confirmButtonText: 'Ya, Tolak!',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                color: '#1e293b',
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        });
    });
</script>
@endsection
