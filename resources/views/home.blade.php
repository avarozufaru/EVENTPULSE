@extends('layouts.app')

@section('content')

<style>
    /* ==========================
       HERO SECTION
    ========================== */
    .hero-section {
        background: linear-gradient(
            135deg,
            #0369a1 0%,
            #0ea5e9 50%,
            #38bdf8 100%
        );
        min-height: 400px;
        display: flex;
        align-items: center;
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(14, 165, 233, 0.25);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.5);
    }
    .hero-section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.25), transparent 40%);
        pointer-events: none;
    }
    .hero-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.4);
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
        color: rgba(255, 255, 255, 0.9);
    }
    .hero-stat {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 16px;
        padding: 18px 28px;
        min-width: 150px;
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .hero-stat:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.25);
        box-shadow: 0 8px 20px rgba(255, 255, 255, 0.15);
    }
    .hero-stat-label {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.9);
    }

    /* ==========================
       EVENT SECTION
    ========================== */
    .event-card {
        overflow: hidden;
        border: 1px solid rgba(14, 165, 233, 0.1) !important;
        background: #ffffff !important;
        backdrop-filter: none;
        box-shadow: 0 10px 25px rgba(0,0,0,0.03);
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
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .event-date-badge {
        display: inline-block;
        background: rgba(14, 165, 233, 0.1);
        color: #0284c7;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 1px solid rgba(14, 165, 233, 0.2);
    }
    .event-title {
        margin-top: 15px;
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f172a;
        min-height: 56px;
    }
    .event-info {
        margin-top: 15px;
    }
    .event-info p {
        color: #64748b;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }
    .event-btn {
        width: 100%;
        display: block;
        text-align: center;
        text-decoration: none;
        background: linear-gradient(135deg, #0ea5e9, #38bdf8);
        color: white !important;
        border-radius: 12px;
        padding: 13px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .event-btn:hover {
        background: linear-gradient(135deg, #0284c7, #0ea5e9);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
        color: white !important;
    }
    .empty-event-icon {
        font-size: 4rem;
        color: #94a3b8;
    }

    /* Countdown timer styles */
    .countdown-timer {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: rgba(255, 255, 255, 0.9);
        color: #0f172a;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        z-index: 2;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Search bar styles */
    .search-container {
        position: relative;
        max-width: 400px;
    }
    .search-input {
        padding-left: 40px;
        border-radius: 50px;
    }
    .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
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
    <div id="featuredCarousel" class="carousel slide hero-section" data-bs-ride="carousel" style="min-height: 420px; overflow: hidden; border-radius: 24px; box-shadow: 0 20px 40px rgba(14, 165, 233, 0.25); border: 1px solid rgba(255, 255, 255, 0.5); margin-bottom: 2rem;">
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
                <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}" style="min-height: 420px; background: linear-gradient(rgba(14, 165, 233, 0.6), rgba(2, 132, 199, 0.8)), url('{{ asset($feImage) }}') center/cover no-repeat;">
                    <div class="container text-center text-white py-5 d-flex flex-column justify-content-center align-items-center" style="min-height: 420px; z-index: 5; position: relative;">
                        <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill fw-bold">🔥 EVENT UNGGULAN</span>
                        <h1 class="fw-bold mb-3 hero-title" style="max-width: 800px; text-shadow: 0 4px 12px rgba(0,0,0,0.3);">{{ $fe->judul }}</h1>
                        <p class="mb-4 fs-5 hero-subtitle" style="max-width: 700px; text-shadow: 0 2px 6px rgba(0,0,0,0.3);">{{ Str::limit($fe->deskripsi, 120) }}</p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap mb-4" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                            <span class="badge bg-white text-primary bg-opacity-90 border border-light px-3 py-2"><i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($fe->tanggal)->format('d M Y') }}</span>
                            <span class="badge bg-white text-danger bg-opacity-90 border border-light px-3 py-2"><i class="bi bi-geo-alt-fill text-danger"></i> {{ $fe->lokasi }}</span>
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
                Daftar event seminar, workshop, lomba, dan seni kampus dengan mudah dan cepat.
            </p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                @if(!session('id'))
                    <a href="/register" class="btn btn-warning btn-lg px-4 fw-bold shadow">
                        <i class="bi bi-person-plus"></i> Daftar Gratis
                    </a>
                    <a href="/login" class="btn btn-outline-light btn-lg px-4 shadow-sm bg-white bg-opacity-10">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                @else
                    @if(session('role') === 'admin')
                        <a href="/admin/dashboard" class="btn btn-warning btn-lg px-4 fw-bold shadow">
                            <i class="bi bi-grid"></i> Dashboard Saya
                        </a>
                    @elseif(session('role') === 'penyelenggara')
                        <a href="/penyelenggara/dashboard" class="btn btn-warning btn-lg px-4 fw-bold shadow">
                            <i class="bi bi-grid"></i> Dashboard Saya
                        </a>
                    @else
                        <a href="/dashboard" class="btn btn-warning btn-lg px-4 fw-bold shadow">
                            <i class="bi bi-grid"></i> Dashboard Saya
                        </a>
                    @endif
                @endif
            </div>
            <div class="row mt-5 justify-content-center g-3" id="stats-counter-section">
                <div class="col-auto">
                    <div class="hero-stat">
                        <div class="fw-bold fs-4 counter-anim" data-target="{{ $events->count() }}">0</div>
                        <div class="hero-stat-label">Event Tersedia</div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="hero-stat">
                        <div class="fw-bold fs-4"><span class="counter-anim" data-target="100">0</span>%</div>
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

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1" style="color: #0f172a;">📅 Event Tersedia</h3>
        <p class="text-muted mb-0">
            Pilih event yang kamu minati dan daftar sekarang
        </p>
    </div>
    
    <!-- Search Bar (Client Side) -->
    <div class="search-container">
        <i class="bi bi-search search-icon"></i>
        <input type="text" id="eventSearchInput" class="form-control search-input border-primary" placeholder="Cari event...">
    </div>
</div>
    
<!-- Category Filter Pills -->
@php
    $homeBase = '/';
    if (session('role') === 'admin') $homeBase = '/admin/home';
    elseif (session('role') === 'penyelenggara') $homeBase = '/penyelenggara/home';
@endphp
<div class="mb-4">
    <div class="d-flex flex-wrap gap-2 justify-content-start">
        <a href="{{ $homeBase }}" class="btn btn-sm {{ request('category') == '' ? 'btn-primary-gradient text-white' : 'btn-outline-secondary' }} px-4 py-2 rounded-pill shadow-sm">
            🌐 Semua Event
        </a>
        @foreach($categories as $cat)
            <a href="{{ $homeBase }}?category={{ $cat->id }}" class="btn btn-sm {{ request('category') == $cat->id ? 'btn-primary-gradient text-white font-weight-bold' : 'btn-outline-secondary' }} px-4 py-2 rounded-pill shadow-sm">
                <i class="bi {{ $cat->icon }}"></i> {{ $cat->nama }}
            </a>
        @endforeach
    </div>
</div>

<div class="row g-4" id="eventGrid">

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
        
        $eventDateTime = \Carbon\Carbon::parse($event->tanggal . ' ' . ($event->jam_mulai ?? '00:00:00'));
    @endphp

    <div class="col-lg-4 col-md-6 event-item">

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
                
                <div class="countdown-timer" data-date="{{ $eventDateTime->toIso8601String() }}">
                    <i class="bi bi-hourglass-split text-primary"></i> 
                    <span class="time-text">Menghitung...</span>
                </div>

            </div>

            <div class="card-body">

                <span class="event-date-badge">
                    <i class="bi bi-calendar-event"></i>
                    {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}
                </span>

                <h5 class="event-title mt-3 event-title-text">
                    {{ $event->judul }}
                </h5>

                <div class="event-info">

                    <p>
                        <i class="bi bi-geo-alt-fill text-danger"></i>
                        <span class="event-location-text">{{ $event->lokasi }}</span>
                    </p>

                    @if($event->jam_mulai)
                    <p>
                        <i class="bi bi-clock-fill text-primary"></i>
                        {{ substr($event->jam_mulai, 0, 5) }}

                        @if($event->jam_selesai)
                            - {{ substr($event->jam_selesai, 0, 5) }}
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

                <a href="/event/{{ $event->id }}" class="event-btn shadow-sm">
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

<div id="noResult" class="col-12 text-center py-5 d-none">
    <i class="bi bi-search empty-event-icon"></i>
    <p class="text-muted mt-3 fs-5">Event tidak ditemukan.</p>
</div>

</div>

<!-- Scripts for features -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 1. Search Filter
        const searchInput = document.getElementById('eventSearchInput');
        const eventItems = document.querySelectorAll('.event-item');
        const noResult = document.getElementById('noResult');

        if(searchInput) {
            searchInput.addEventListener('input', function(e) {
                const term = e.target.value.toLowerCase();
                let visibleCount = 0;
                
                eventItems.forEach(item => {
                    const title = item.querySelector('.event-title-text').textContent.toLowerCase();
                    const loc = item.querySelector('.event-location-text').textContent.toLowerCase();
                    
                    if(title.includes(term) || loc.includes(term)) {
                        item.style.display = 'block';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });
                
                if(visibleCount === 0 && eventItems.length > 0) {
                    noResult.classList.remove('d-none');
                } else {
                    noResult.classList.add('d-none');
                }
            });
        }

        // 2. Countdown Timer
        const timers = document.querySelectorAll('.countdown-timer');
        setInterval(() => {
            const now = new Date().getTime();
            
            timers.forEach(timer => {
                const eventDate = new Date(timer.getAttribute('data-date')).getTime();
                const diff = eventDate - now;
                const textEl = timer.querySelector('.time-text');
                
                if (diff < 0) {
                    // Check if it's today
                    const eventDay = new Date(timer.getAttribute('data-date')).toDateString();
                    const today = new Date().toDateString();
                    
                    if(eventDay === today) {
                        textEl.textContent = "Berlangsung Hari Ini";
                        timer.style.color = "#059669"; // emerald
                        timer.querySelector('i').className = "bi bi-play-circle-fill text-success";
                    } else {
                        textEl.textContent = "Event Selesai";
                        timer.style.color = "#64748b";
                        timer.querySelector('i').className = "bi bi-check-circle-fill text-secondary";
                    }
                } else {
                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    
                    if(days > 0) {
                        textEl.textContent = `${days}h ${hours}j ${mins}m`;
                    } else if(hours > 0) {
                        textEl.textContent = `${hours}j ${mins}m`;
                        timer.style.color = "#f59e0b"; // amber
                    } else {
                        textEl.textContent = `${mins}m`;
                        timer.style.color = "#ef4444"; // red
                    }
                }
            });
        }, 1000);

        // 3. Animated Counter
        const counters = document.querySelectorAll('.counter-anim');
        const speed = 200; // The lower the slower

        const animateCounters = () => {
            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    
                    const inc = target / speed;
                    
                    if (count < target) {
                        counter.innerText = Math.ceil(count + inc);
                        setTimeout(updateCount, 10);
                    } else {
                        counter.innerText = target;
                    }
                };
                updateCount();
            });
        }

        // Intersection Observer to trigger animation when visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        const statsSection = document.getElementById('stats-counter-section');
        if(statsSection) {
            observer.observe(statsSection);
        }
    });
</script>

@endsection
