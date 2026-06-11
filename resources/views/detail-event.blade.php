@extends('layouts.app')

@section('content')
<div class="container mt-4">
    @php
        $backUrl = '/';
        if (session('role') === 'admin') $backUrl = '/admin/home';
        elseif (session('role') === 'penyelenggara') $backUrl = '/penyelenggara/home';
    @endphp
    <a href="{{ $backUrl }}" class="btn btn-secondary mb-3">← Kembali</a>

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

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <div class="mb-4 text-center">
                <img src="{{ $bannerUrl }}" alt="Banner {{ $event->judul }}" style="max-height: 380px; border-radius: 16px; object-fit: cover; width: 100%; box-shadow: 0 10px 30px rgba(99, 102, 241, 0.25); border: 1px solid rgba(255,255,255,0.1);">
            </div>
            
            <h2 class="fw-bold">{{ $event->judul }}</h2>
            <hr>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p>📅 <strong>Tanggal:</strong> {{ $event->tanggal }}</p>
                    @if($event->jam_mulai)
                    <p>🕐 <strong>Jam:</strong> {{ $event->jam_mulai }}
                        @if($event->jam_selesai) - {{ $event->jam_selesai }} @endif
                    </p>
                    @endif
                    <p>📍 <strong>Lokasi:</strong> {{ $event->lokasi }}</p>
                </div>
                <div class="col-md-6">
                    @if($event->pembicara)
                    <p>🎤 <strong>Pembicara:</strong> {{ $event->pembicara }}</p>
                    @endif
                    <p>👥 <strong>Kuota:</strong> {{ $event->kuota }} (Sisa: <strong class="{{ $remainingQuota <= 0 ? 'text-danger' : 'text-success' }}">{{ $remainingQuota }}</strong>)</p>
                    <p>💰 <strong>Harga:</strong>
                        <span class="text-success fw-bold">
                            {{ $event->harga == 0 ? 'Gratis' : 'Rp ' . number_format($event->harga, 0, ',', '.') }}
                        </span>
                    </p>
                </div>
            </div>

            <h5>Deskripsi</h5>
            <p>{{ $event->deskripsi }}</p>

            <hr>
            @if(session('role') === 'admin' || session('role') === 'penyelenggara')
                <div class="alert text-center py-3" style="background: rgba(99,102,241,0.15); border: 1px solid rgba(99,102,241,0.3); border-radius: 12px; color: #a78bfa;">
                    <i class="bi bi-info-circle-fill"></i> 
                    Anda login sebagai <strong>{{ session('role') === 'admin' ? 'Admin' : 'Penyelenggara' }}</strong>. Hanya mahasiswa yang dapat mendaftar event.
                </div>
            @else
                <form action="/event/{{ $event->id }}/daftar" method="POST">
                    @csrf
                    @if($remainingQuota > 0)
                        <button type="submit" class="btn btn-success btn-lg w-100">
                            🎟️ Daftar Event Sekarang
                        </button>
                    @else
                        <button type="button" class="btn btn-secondary btn-lg w-100" disabled>
                            🚫 Kuota Penuh
                        </button>
                    @endif
                </form>
            @endif
        </div>
    </div>
</div>
@endsection