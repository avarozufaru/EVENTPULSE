<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventPulse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background: #0f0f1a;
            color: #e2e8f0;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-image:
                radial-gradient(circle at 20% 20%, rgba(99,102,241,0.15) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(167,139,250,0.1) 0%, transparent 50%),
                radial-gradient(circle at 50% 50%, rgba(15,52,96,0.2) 0%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }
        main, nav, footer { position: relative; z-index: 1; }
        .navbar {
            background: rgba(15, 15, 26, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(99,102,241,0.2);
            box-shadow: 0 4px 30px rgba(0,0,0,0.4);
            padding: 14px 0;
        }
        .navbar-brand {
            font-weight: 900;
            font-size: 1.6rem;
            letter-spacing: 1px;
            background: linear-gradient(135deg, #a78bfa, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .nav-link {
            color: #94a3b8 !important;
            font-weight: 500;
            padding: 6px 14px !important;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .nav-link:hover {
            color: #e2e8f0 !important;
            background: rgba(99,102,241,0.15);
        }
        .card {
            background: rgba(255,255,255,0.04) !important;
            border: 1px solid rgba(255,255,255,0.08) !important;
            border-radius: 16px !important;
            backdrop-filter: blur(10px);
            transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
            color: #e2e8f0;
        }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(99,102,241,0.2) !important;
            border-color: rgba(99,102,241,0.4) !important;
        }
        .card-footer {
            background: transparent !important;
            border-top: 1px solid rgba(255,255,255,0.06) !important;
        }
        .btn-primary-gradient {
            background: linear-gradient(135deg, #6366f1, #a78bfa);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary-gradient:hover {
            background: linear-gradient(135deg, #4f46e5, #8b5cf6);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(99,102,241,0.4);
            color: white;
        }
        .table { color: #e2e8f0 !important; }
        .table-dark { background: rgba(99,102,241,0.2) !important; }
        .table td, .table th {
            border-color: rgba(255,255,255,0.06) !important;
            padding: 14px !important;
        }
        .table tbody tr:hover { background: rgba(255,255,255,0.04); }
        .form-control, .form-select {
            background: rgba(255,255,255,0.06) !important;
            border: 1px solid rgba(255,255,255,0.12) !important;
            color: #e2e8f0 !important;
            border-radius: 10px !important;
        }
        .form-control:focus, .form-select:focus {
            background: rgba(255,255,255,0.08) !important;
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.25) !important;
            color: #e2e8f0 !important;
        }
        .form-control::placeholder { color: #64748b !important; }
        label { color: #94a3b8 !important; font-weight: 500; margin-bottom: 6px; }
        h1, h2, h3, h4, h5 { color: #f1f5f9; }
        .text-muted { color: #64748b !important; }
        hr { border-color: rgba(255,255,255,0.08); }
        .glass-box {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            padding: 2rem;
        }
        footer {
            background: rgba(15,15,26,0.95);
            border-top: 1px solid rgba(99,102,241,0.2);
            color: #64748b;
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0f0f1a; }
        ::-webkit-scrollbar-thumb { background: #6366f1; border-radius: 10px; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-lightning-charge-fill"></i> EventPulse
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <div class="navbar-nav ms-auto align-items-center gap-1">
                    <a class="nav-link" href="/"><i class="bi bi-house"></i> Home</a>
                    @if(session('id'))
                        @if(session('role') === 'admin')
                            <a class="nav-link" href="/admin/dashboard"><i class="bi bi-shield-check"></i> Admin</a>
                            <a class="nav-link" href="/events"><i class="bi bi-calendar-event"></i> Kelola Event</a>
                        @elseif(session('role') === 'penyelenggara')
                            <a class="nav-link" href="/penyelenggara/dashboard"><i class="bi bi-grid-fill"></i> Panel Penyelenggara</a>
                            <a class="nav-link" href="/events"><i class="bi bi-calendar-event"></i> Kelola Event</a>
                        @else
                            <a class="nav-link" href="/dashboard"><i class="bi bi-person-circle"></i> Dashboard</a>
                        @endif
                        <a class="nav-link" href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
                        <span class="badge ms-2" style="background: rgba(99,102,241,0.3); border: 1px solid rgba(99,102,241,0.5); color: #a78bfa; padding: 8px 14px; border-radius: 20px;">
                            <i class="bi bi-person-fill"></i> {{ session('nama') }}
                        </span>
                    @else
                        <a class="nav-link" href="/login"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                        <a href="/register" class="btn btn-primary-gradient btn-sm ms-2 px-3">
                            <i class="bi bi-person-plus"></i> Daftar
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">
                <i class="bi bi-lightning-charge-fill" style="color: #6366f1;"></i>
                <strong style="color: #a78bfa;">EventPulse</strong>
                <span style="color: #475569;"> &copy; 2026 — Platform Event Kampus</span>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#6366f1',
            timer: 3000,
            timerProgressBar: true,
            background: '#1e1e2e',
            color: '#e2e8f0',
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#6366f1',
            background: '#1e1e2e',
            color: '#e2e8f0',
        });
    </script>
    @endif

</body>
</html>