@extends('layouts.app')

@section('content')

<style>
    /* ==========================
       HERO SECTION
    ========================== */
    .hero-section {
        background: linear-gradient(
            135deg,
            #4f46e5 0%,
            #7c3aed 50%,
            #9333ea 100%
        );
        min-height: 400px;
        display: flex;
        align-items: center;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(99, 102, 241, 0.25);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.15), transparent 40%);
        pointer-events: none;
    }
    .hero-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.25);
    }
    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        line-height: 1.25;
    }
    .hero-highlight {
        color: #facc15;
        text-shadow: 0 2px 10px rgba(250, 204, 21, 0.4);
    }
    .hero-subtitle {
        max-width: 700px;
        margin: auto;
        color: rgba(255, 255, 255, 0.85);
    }
    .hero-stat {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 16px;
        padding: 18px 28px;
        min-width: 150px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .hero-stat:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 8px 20px rgba(255, 255, 255, 0.05);
    }
    .hero-stat-label {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.8);
    }

    /* ==========================
       EVENT SECTION
    ========================== */
    .event-card {
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        background: rgba(255, 255, 255, 0.03) !important;
        backdrop-filter: blur(10px);
    }
    .event-banner {
        position: relative;
        height: 220px;
        overflow: hidden;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }
    .event-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .event-card:hover .event-image {
        transform: scale(1.08);
    }
    .price-badge-container {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 2;
    }
    .price-badge {
        border-radius: 50px;
        padding: 8px 14px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .event-date-badge {
        display: inline-block;
        background: rgba(99, 102, 241, 0.15);
        color: #a78bfa;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid rgba(99, 102, 241, 0.3);
    }
    .event-title {
        margin-top: 15px;
        font-size: 1.25rem;
        font-weight: 700;
        color: #f1f5f9;
        min-height: 56px;
    }
    .event-info {
        margin-top: 15px;
    }
    .event-info p {
        color: #94a3b8;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }
    .event-btn {
        width: 100%;
        display: block;
        text-align: center;
        text-decoration: none;
        background: linear-gradient(135deg, #6366f1, #a78bfa);
        color: white !important;
        border-radius: 12px;
        padding: 13px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .event-btn:hover {
        background: linear-gradient(135deg, #4f46e5, #8b5cf6);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
        color: white !important;
    }
    .empty-event-icon {
        font-size: 4rem;
        color: #475569;
    }

    /* ==========================
       RESPONSIVE
    ========================== */
    @media(max-width:768px) {
        .hero-title {
            font-size: 2.3rem;
        }
        .hero-stat {
            min-width: 120px;
            padding: 15px 20px;
        }
    }
</style>

<!-- Hero / Carousel Section -->
@if(count($featuredEvents) > 0)
    <div id="featuredCarousel" class="carousel slide hero-section" data-bs-ride="carousel" style="min-height: 420px; overflow: hidden; border-radius: 24px; box-shadow: 0 20px 40px rgba(99, 102, 241, 0.25); border: 1px solid rgba(255, 255, 255, 0.1); margin-bottom: 2rem;">
        <div class="carousel-indicators" style="z-index: 10;">
            @foreach($featuredEvents as $idx => $fe)
                <button type="button" data-bs-target="#featuredCarousel" data-bs-slide-to="{{ $idx }}" class="{{ $idx === 0 ? 'active' : '' }}" aria-label="Slide {{ $idx + 1 }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner" style="height: 100%; min-height: 420px;">
            @foreach($featuredEvents as $idx => $fe)
                @php
                    $feImage = 'images/Seminar.png';
                    $feJudulLower = strtolower($fe->judul);
                    if ($fe->banner && $fe->banner !== 'default-banner.jpg') {
                        $feImage = 'storage/' . $fe->banner;
                    } elseif (str_contains($feJudulLower, 'ai') || str_contains($feJudulLower, 'kecerdasan buatan')) {
                        $feImage = 'images/Seminar AI.png';
                    } elseif (str_contains($feJudulLower, 'ui ux') || str_contains($feJudulLower, 'ui/ux') || str_contains($feJudulLower, 'ux') || str_contains($feJudulLower, 'figma')) {
                        $feImage = 'images/workshop UI/UX.png';
                    } elseif (str_contains($feJudulLower, 'workshop')) {
                        $feImage = 'images/workshop.png';
                    } elseif (str_contains($feJudulLower, 'seminar')) {
                        $feImage = 'images/Seminar.png';
                    } elseif (str_contains($feJudulLower, 'seni') || str_contains($feJudulLower, 'pentas')) {
                        $feImage = 'images/pentas seni.png';
                    }
                @endphp
                <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}" style="min-height: 420px; background: linear-gradient(rgba(15, 15, 26, 0.75), rgba(15, 15, 26, 0.75)), url('{{ asset($feImage) }}') center/cover no-repeat;">
                    <div class="container text-center text-white py-5 d-flex flex-column justify-content-center align-items-center" style="min-height: 420px; z-index: 5; position: relative;">
                        <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill fw-bold">🔥 EVENT UNGGULAN</span>
                        <h1 class="fw-bold mb-3 hero-title" style="max-width: 800px; text-shadow: 0 4px 12px rgba(0,0,0,0.6);">{{ $fe->judul }}</h1>
                        <p class="mb-4 fs-5 hero-subtitle" style="max-width: 700px; text-shadow: 0 2px 6px rgba(0,0,0,0.5);">{{ Str::limit($fe->deskripsi, 120) }}</p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap mb-4" style="text-shadow: 0 2px 4px rgba(0,0,0,0.6);">
                            <span class="badge bg-dark bg-opacity-50 border border-secondary px-3 py-2"><i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($fe->tanggal)->format('d M Y') }}</span>
                            <span class="badge bg-dark bg-opacity-50 border border-secondary px-3 py-2"><i class="bi bi-geo-alt-fill text-danger"></i> {{ $fe->lokasi }}</span>
                        </div>
                        <a href="/event/{{ $fe->id }}" class="btn btn-warning btn-lg px-5 fw-bold" style="box-shadow: 0 4px 15px rgba(250, 204, 21, 0.4);">
                            🎯 Daftar Sekarang
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
@else
    <div class="hero-section d-flex align-items-center">
        <div class="container text-center text-white py-5">
            <div class="mb-3">
                <span class="hero-badge">   
                    ⚡ Platform Event Kampus #1
                </span>
            </div>
            <h1 class="fw-bold mb-3 hero-title">
                Temukan <span class="hero-highlight">Event</span> Terbaik<br>di Kampusmu
            </h1>
            <p class="mb-4 fs-5 hero-subtitle">
                Daftar event seminar, workshop, lomba, dan seni kampus dengan mudah and cepat.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                @if(!session('id'))
                    <a href="/register" class="btn btn-warning btn-lg px-4 fw-bold">
                        <i class="bi bi-person-plus"></i> Daftar Gratis
                    </a>
                    <a href="/login" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                @else
                    @if(session('role') === 'admin')
                        <a href="/admin/dashboard" class="btn btn-warning btn-lg px-4 fw-bold">
                            <i class="bi bi-grid"></i> Dashboard Saya
                        </a>
                    @elseif(session('role') === 'penyelenggara')
                        <a href="/penyelenggara/dashboard" class="btn btn-warning btn-lg px-4 fw-bold">
                            <i class="bi bi-grid"></i> Dashboard Saya
                        </a>
                    @else
                        <a href="/dashboard" class="btn btn-warning btn-lg px-4 fw-bold">
                            <i class="bi bi-grid"></i> Dashboard Saya
                        </a>
                    @endif
                @endif
            </div>
            <div class="row mt-5 justify-content-center g-3">
                <div class="col-auto">
                    <div class="hero-stat">
                        <div class="fw-bold fs-4">{{ $events->count() }}</div>
                        <div class="hero-stat-label">Event Tersedia</div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="hero-stat">
                        <div class="fw-bold fs-4">100%</div>
                        <div class="hero-stat-label">Gratis Mendaftar</div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="hero-stat">
                        <div class="fw-bold fs-4">⚡ Fast</div>
                        <div class="hero-stat-label">Proses Instan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Event List -->

<div class="container py-5">

<div class="d-flex flex-column gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1">📅 Event Tersedia</h3>
        <p class="text-muted mb-0">
            Pilih event yang kamu minati dan daftar sekarang
        </p>
    </div>
    
    <!-- Category Filter Pills -->
    @php
        $homeBase = '/';
        if (session('role') === 'admin') $homeBase = '/admin/home';
        elseif (session('role') === 'penyelenggara') $homeBase = '/penyelenggara/home';
    @endphp
    <div class="mt-2">
        <div class="d-flex flex-wrap gap-2 justify-content-start">
            <a href="{{ $homeBase }}" class="btn btn-sm {{ request('category') == '' ? 'btn-primary-gradient' : 'btn-outline-light' }} px-4 py-2 rounded-pill">
                🌐 Semua Event
            </a>
            @foreach($categories as $cat)
                <a href="{{ $homeBase }}?category={{ $cat->id }}" class="btn btn-sm {{ request('category') == $cat->id ? 'btn-primary-gradient font-weight-bold' : 'btn-outline-light' }} px-4 py-2 rounded-pill">
                    <i class="bi {{ $cat->icon }}"></i> {{ $cat->nama }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<div class="row g-4">

    @forelse($events as $event)

    @php
        $judulLower = strtolower($event->judul);
        if ($event->banner && $event->banner !== 'default-banner.jpg') {
            $imagePath = 'storage/' . $event->banner;
        } elseif (str_contains($judulLower, 'ai') || str_contains($judulLower, 'kecerdasan buatan')) {
            $imagePath = 'images/Seminar AI.png';
        } elseif (str_contains($judulLower, 'ui ux') || str_contains($judulLower, 'ui/ux') || str_contains($judulLower, 'ux') || str_contains($judulLower, 'figma')) {
            $imagePath = 'images/workshop UI/UX.png';
        } elseif (str_contains($judulLower, 'workshop')) {
            $imagePath = 'images/workshop.png';
        } elseif (str_contains($judulLower, 'seminar')) {
            $imagePath = 'images/Seminar.png';
        } elseif (str_contains($judulLower, 'seni') || str_contains($judulLower, 'pentas')) {
            $imagePath = 'images/pentas seni.png';
        } else {
            $imagePath = 'images/Seminar.png';
        }
    @endphp

    <div class="col-lg-4 col-md-6">

        <div class="card event-card h-100 shadow-sm">

            <div class="event-banner">

                <img
                    src="{{ asset($imagePath) }}"
                    alt="{{ $event->judul }}"
                    class="event-image"
                >

                <div class="price-badge-container">
                    <span class="badge price-badge {{ $event->harga == 0 ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ $event->harga == 0 ? '🎉 Gratis' : 'Rp '.number_format($event->harga,0,',','.') }}
                    </span>
                </div>

            </div>

            <div class="card-body">

                <span class="event-date-badge">
                    <i class="bi bi-calendar-event"></i>
                    {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}
                </span>

                <h5 class="event-title mt-3">
                    {{ $event->judul }}
                </h5>

                <div class="event-info">

                    <p>
                        <i class="bi bi-geo-alt-fill text-danger"></i>
                        {{ $event->lokasi }}
                    </p>

                    @if($event->jam_mulai)
                    <p>
                        <i class="bi bi-clock-fill text-primary"></i>
                        {{ $event->jam_mulai }}

                        @if($event->jam_selesai)
                            - {{ $event->jam_selesai }}
                        @endif
                    </p>
                    @endif

                    @if($event->pembicara)
                    <p>
                        <i class="bi bi-mic-fill text-success"></i>
                        {{ $event->pembicara }}
                    </p>
                    @endif

                    <p>
                        <i class="bi bi-people-fill text-warning"></i>
                        Kuota {{ $event->kuota }} Peserta
                    </p>

                </div>

            </div>

            <div class="card-footer">

                <a href="/event/{{ $event->id }}" class="event-btn">
                    Lihat Detail
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>

        </div>

    </div>

    @empty

    <div class="col-12 text-center py-5">

        <i class="bi bi-calendar-x empty-event-icon"></i>

        <p class="text-muted mt-3 fs-5">
            Belum ada event tersedia saat ini.
        </p>

    </div>

    @endforelse

</div>

</div>

@endsection
