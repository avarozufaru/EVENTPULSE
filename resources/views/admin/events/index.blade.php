@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-5">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="mb-1"><i class="bi bi-calendar-event me-2" style="color: #a78bfa;"></i>Kelola Event</h2>
            <p class="text-muted mb-0">Manajemen daftar event Anda dengan mudah dan cepat.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ session('role') === 'admin' ? '/admin/dashboard' : '/penyelenggara/dashboard' }}" class="btn btn-outline-secondary" style="border-radius: 10px;">
                <i class="bi bi-arrow-left"></i> Dashboard
            </a>
            <a href="/events/create" class="btn btn-primary-gradient shadow-sm">
                <i class="bi bi-plus-circle me-1"></i> Tambah Event
            </a>
        </div>
    </div>

    <div class="card shadow-lg border-0 glass-box overflow-hidden p-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="min-width: 800px;">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="ps-4 py-3" width="80">Banner</th>
                            <th scope="col" class="py-3">Info Event</th>
                            <th scope="col" class="py-3">Jadwal</th>
                            <th scope="col" class="py-3">Status</th>
                            <th scope="col" class="py-3">Kuota</th>
                            <th scope="col" class="text-end pe-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($events as $event)
                        <tr>
                            <td class="ps-4 py-3">
                                @if($event->banner)
                                    <img src="{{ asset('storage/' . $event->banner) }}" alt="Banner" class="rounded" style="width: 70px; height: 50px; object-fit: cover; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
                                @else
                                    <div class="rounded d-flex align-items-center justify-content-center" style="width: 70px; height: 50px; background: rgba(255,255,255,0.1);">
                                        <i class="bi bi-image text-white-50"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3">
                                <span class="fw-bold d-block text-dark" style="font-size: 1.05rem;">{{ $event->judul }}</span>
                                <small class="text-muted"><i class="bi bi-geo-alt-fill me-1"></i>{{ $event->lokasi }}</small>
                            </td>
                            <td class="py-3">
                                <div class="d-flex align-items-center text-dark">
                                    <i class="bi bi-calendar-check me-2 text-primary"></i>
                                    <span class="fw-medium">{{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</span>
                                </div>
                            </td>
                            <td class="py-3">
                                @if(isset($event->status))
                                    @if($event->status == 'published')
                                        <span class="badge bg-success bg-opacity-25 text-success border border-success rounded-pill px-3 py-2"><i class="bi bi-check-circle-fill me-1"></i> Published</span>
                                    @elseif($event->status == 'pending')
                                        <span class="badge bg-warning bg-opacity-25 text-warning border border-warning rounded-pill px-3 py-2"><i class="bi bi-clock-fill me-1"></i> Pending</span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-25 text-danger border border-danger rounded-pill px-3 py-2">{{ ucfirst($event->status) }}</span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary bg-opacity-25 text-secondary border border-secondary rounded-pill px-3 py-2">Unknown</span>
                                @endif
                            </td>
                            <td class="py-3">
                                <span class="badge bg-info bg-opacity-25 text-info border border-info px-2 py-1 rounded">{{ $event->kuota }}</span>
                            </td>
                            <td class="text-end pe-4 py-3">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="/events/{{ $event->id }}/edit" class="btn btn-sm btn-outline-warning" style="border-radius: 8px;" title="Edit Event">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="/events/{{ $event->id }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" style="border-radius: 8px;" onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?')" title="Hapus Event">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-1 d-block mb-3 opacity-50"></i>
                                <h5>Belum ada event yang ditambahkan.</h5>
                                <p>Silakan klik tombol "Tambah Event" untuk membuat event baru.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection