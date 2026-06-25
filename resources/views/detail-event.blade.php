@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @php
        $backUrl = '/';
        if (session('role') === 'admin') $backUrl = '/admin/home';
        elseif (session('role') === 'penyelenggara') $backUrl = '/penyelenggara/home';
    @endphp
    <a href="{{ $backUrl }}" class="btn btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Kembali</a>

    @php
        $judulLower = strtolower($event->judul);
        if ($event->banner && $event->banner !== 'default-banner.jpg') {
            $bannerUrl = asset('storage/' . $event->banner);
        } elseif (str_contains($judulLower, 'ai') || str_contains($judulLower, 'kecerdasan buatan')) {
            $bannerUrl = asset('images/Seminar AI.png');
        } elseif (str_contains($judulLower, 'ui ux') || str_contains($judulLower, 'ui/ux') || str_contains($judulLower, 'ux') || str_contains($judulLower, 'figma')) {
            $bannerUrl = asset('images/workshop UI/UX.png');
        } elseif (str_contains($judulLower, 'workshop')) {
            $bannerUrl = asset('images/workshop.png');
        } elseif (str_contains($judulLower, 'seminar')) {
            $bannerUrl = asset('images/Seminar.png');
        } elseif (str_contains($judulLower, 'seni') || str_contains($judulLower, 'pentas')) {
            $bannerUrl = asset('images/pentas seni.png');
        } else {
            $bannerUrl = asset('images/Seminar.png');
        }
    @endphp

    <div class="card shadow-sm border-0" style="border-radius: 16px;">
        <div class="card-body p-4 p-md-5">
            <div class="mb-4 text-center">
                <img src="{{ $bannerUrl }}" alt="Banner {{ $event->judul }}" style="max-height: 400px; border-radius: 16px; object-fit: cover; width: 100%; box-shadow: 0 10px 30px rgba(14, 165, 233, 0.15); border: 1px solid rgba(14, 165, 233, 0.1);">
            </div>
            
            <h2 class="fw-bold text-dark">{{ $event->judul }}</h2>
            <hr style="border-color: rgba(203, 213, 225, 0.5);">
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <p class="mb-2"><i class="bi bi-calendar-event text-primary me-2"></i> <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($event->tanggal)->format('d F Y') }}</p>
                    @if($event->jam_mulai)
                    <p class="mb-2"><i class="bi bi-clock text-primary me-2"></i> <strong>Jam:</strong> {{ substr($event->jam_mulai, 0, 5) }}
                        @if($event->jam_selesai) - {{ substr($event->jam_selesai, 0, 5) }} @endif
                    </p>
                    @endif
                    <p class="mb-2"><i class="bi bi-geo-alt-fill text-danger me-2"></i> <strong>Lokasi:</strong> {{ $event->lokasi }}</p>
                </div>
                <div class="col-md-6">
                    @if($event->pembicara)
                    <p class="mb-2"><i class="bi bi-mic-fill text-success me-2"></i> <strong>Pembicara:</strong> {{ $event->pembicara }}</p>
                    @endif
                    <p class="mb-2"><i class="bi bi-people-fill text-warning me-2"></i> <strong>Kuota:</strong> {{ $event->kuota }} (Sisa: <strong class="{{ $remainingQuota <= 0 ? 'text-danger' : 'text-success' }}">{{ $remainingQuota }}</strong>)</p>
                    <p class="mb-2"><i class="bi bi-tags-fill text-info me-2"></i> <strong>Harga:</strong>
                        <span class="text-success fw-bold">
                            {{ $event->harga == 0 ? 'Gratis' : 'Rp ' . number_format($event->harga, 0, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>

            <h5 class="fw-bold mb-3 text-dark">Deskripsi</h5>
            <p class="text-secondary" style="line-height: 1.7;">{!! nl2br(e($event->deskripsi)) !!}</p>

            <hr class="my-4" style="border-color: rgba(203, 213, 225, 0.5);">
            @if(session('role') === 'admin' || session('role') === 'penyelenggara')
                <div class="alert text-center py-3" style="background: rgba(14, 165, 233, 0.1); border: 1px solid rgba(14, 165, 233, 0.2); border-radius: 12px; color: #0284c7;">
                    <i class="bi bi-info-circle-fill"></i> 
                    Anda login sebagai <strong>{{ session('role') === 'admin' ? 'Admin' : 'Penyelenggara' }}</strong>. Hanya mahasiswa yang dapat mendaftar event.
                </div>
            @else
                <div class="card mt-4 shadow-sm" style="border: 1px solid rgba(14, 165, 233, 0.2); border-radius: 12px; background: #f8fafc;">
                    <div class="card-header border-bottom-0 pt-4 pb-0 bg-transparent">
                        <h5 class="mb-0 fw-bold" style="color: #0f172a;"><i class="bi bi-card-checklist text-primary me-2"></i> Form Pendaftaran Event</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="/event/{{ $event->id }}/daftar" method="POST">
                            @csrf
                            @if(isset($user))
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-secondary">Nama Lengkap</label>
                                    <input type="text" name="nama" class="form-control" value="{{ $user->nama }}" required>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-secondary">NIM</label>
                                        <input type="text" name="nim" class="form-control" value="{{ $user->nim }}" required>
                                    </div>
                                    <div class="col-md-6 mt-3 mt-md-0">
                                        <label class="form-label fw-bold text-secondary">Program Studi</label>
                                        <input type="text" name="prodi" class="form-control" value="{{ $user->prodi }}" required>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-secondary">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    Silakan login terlebih dahulu untuk melihat data pendaftaran Anda.
                                </div>
                            @endif

                            @if($remainingQuota > 0)
                                <button type="submit" class="btn btn-primary-gradient btn-lg w-100" style="border-radius: 8px;">
                                    🎟️ Daftar Event Sekarang
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary btn-lg w-100" style="border-radius: 8px;" disabled>
                                    🚫 Kuota Penuh
                                </button>
                            @endif
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection