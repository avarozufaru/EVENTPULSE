@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2><i class="bi bi-person-badge-fill me-2" style="color: #22c55e;"></i>Dashboard Mahasiswa</h2>
                <p class="text-muted mb-0">Selamat Datang, <strong style="color: #0f172a;">{{ session('nama') }}</strong></p>
            </div>
            <div>
                <a href="/" class="btn btn-primary-gradient me-2 shadow-sm"><i class="bi bi-search me-1"></i> Cari
                    Event</a>
            </div>
        </div>

        <div class="glass-box mb-5">
            <h4 class="mb-4" style="color: #0f172a;"><i class="bi bi-ticket-perforated-fill me-2"
                    style="color: #22c55e;"></i>Tiket Saya</h4>

            @if (count($tiket) > 0)
                <div class="table-responsive" style="border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff;">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: #f8fafc; border-bottom: 2px solid rgba(34, 197, 94,0.3);">
                            <tr>
                                <th class="py-3 px-4 text-dark">Event</th>
                                <th class="py-3 text-dark">Tanggal</th>
                                <th class="py-3 text-dark">Lokasi</th>
                                <th class="py-3 text-dark">Kode Tiket</th>
                                <th class="py-3 text-dark">No Antrian</th>
                                <th class="py-3 px-4 text-end text-dark">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tiket as $t)
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td class="py-3 px-4 fw-bold" style="color: #0f172a;">{{ $t->judul }}</td>
                                    <td class="py-3" style="color: #475569;"><i class="bi bi-calendar-event me-1"
                                            style="color: #22c55e;"></i>
                                        {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}</td>
                                    <td class="py-3" style="color: #475569;"><i class="bi bi-geo-alt me-1"
                                            style="color: #22c55e;"></i> {{ $t->lokasi }}</td>
                                    <td class="py-3"><span class="badge"
                                            style="background: rgba(34, 197, 94,0.1); color: #16a34a; border: 1px solid rgba(34, 197, 94,0.2); font-size: 0.9rem; padding: 6px 12px;">{{ $t->kode_tiket }}</span>
                                    </td>
                                    <td class="py-3"><span class="badge"
                                            style="background: rgba(16,185,129,0.1); color: #059669; border: 1px solid rgba(16,185,129,0.2); font-size: 0.9rem; padding: 6px 12px;">#{{ $t->nomor_antrian }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-end">
                                        <a href="/ticket/{{ $t->kode_tiket }}/download" class="btn btn-sm"
                                            style="background: linear-gradient(135deg, #16a34a, #22c55e); color: white; border: none; border-radius: 8px; padding: 8px 12px;">
                                            <i class="bi bi-download me-1"></i> Unduh PDF
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 rounded" style="background: #f8fafc; border: 1px dashed #cbd5e1;">
                    <i class="bi bi-ticket-detailed text-muted display-4 mb-3 d-block opacity-50"></i>
                    <h5 style="color: #0f172a;">Belum ada tiket</h5>
                    <p class="text-muted mb-4">Kamu belum mendaftar event apapun. Yuk temukan event menarik!</p>
                    <a href="/" class="btn btn-primary-gradient px-4 py-2"><i class="bi bi-search me-2"></i>Jelajahi
                        Event</a>
                </div>
            @endif
        </div>
    </div>
@endsection
