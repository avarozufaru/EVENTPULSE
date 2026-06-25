<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventPulse</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: #f0f7ff;
            color: #1e293b;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        main,
        nav,
        footer {
            position: relative;
            z-index: 1;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(34, 197, 94, 0.2);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
            padding: 14px 0;
        }

        .navbar-brand {
            font-weight: 900;
            font-size: 1.6rem;
            letter-spacing: 1px;
            background: linear-gradient(135deg, #16a34a, #4ade80);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            color: #64748b !important;
            font-weight: 600;
            padding: 6px 14px !important;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #22c55e !important;
            background: rgba(34, 197, 94, 0.1);
        }

        .card {
            background: #ffffff !important;
            border: 1px solid rgba(34, 197, 94, 0.1) !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.02);
            transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
            color: #1e293b;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(34, 197, 94, 0.15) !important;
            border-color: rgba(34, 197, 94, 0.3) !important;
        }

        .card-footer {
            background: transparent !important;
            border-top: 1px solid rgba(226, 232, 240, 1) !important;
        }

        .btn-primary-gradient {
            background: linear-gradient(135deg, #16a34a, #4ade80);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary-gradient:hover {
            background: linear-gradient(135deg, #15803d, #22c55e);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.4);
            color: white;
        }

        .table {
            color: #1e293b !important;
        }

        .table-dark {
            background: rgba(34, 197, 94, 0.1) !important;
            color: #16a34a !important;
        }

        .table td,
        .table th {
            border-color: rgba(226, 232, 240, 1) !important;
            padding: 14px !important;
        }

        .table tbody tr:hover {
            background: rgba(34, 197, 94, 0.05);
        }

        .form-control,
        .form-select {
            background: #ffffff !important;
            border: 1px solid rgba(203, 213, 225, 1) !important;
            color: #1e293b !important;
            border-radius: 10px !important;
        }

        .form-control:focus,
        .form-select:focus {
            background: #ffffff !important;
            border-color: #22c55e !important;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2) !important;
            color: #1e293b !important;
        }

        .form-control::placeholder {
            color: #94a3b8 !important;
        }

        label {
            color: #475569 !important;
            font-weight: 600;
            margin-bottom: 6px;
        }

        h1,
        h2,
        h3,
        h4,
        h5 {
            color: #0f172a;
            font-weight: 700;
        }

        .text-muted {
            color: #64748b !important;
        }

        hr {
            border-color: rgba(203, 213, 225, 1);
        }

        .glass-box {
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(34, 197, 94, 0.15);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        }

        footer {
            background: #f8fafc;
            border-top: 1px solid rgba(34, 197, 94, 0.2);
            color: #64748b;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f0f7ff;
        }

        ::-webkit-scrollbar-thumb {
            background: #22c55e;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #16a34a;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="bi bi-lightning-charge-fill" style="color: #22c55e;"></i> EventPulse
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMenu">
                <div class="navbar-nav ms-auto align-items-center gap-1">
                    @if (session('role') === 'admin')
                        <a class="nav-link" href="/admin/home"><i class="bi bi-house"></i> Home</a>
                    @elseif(session('role') === 'penyelenggara')
                        <a class="nav-link" href="/penyelenggara/home"><i class="bi bi-house"></i> Home</a>
                    @else
                        <a class="nav-link" href="/"><i class="bi bi-house"></i> Home</a>
                    @endif
                    @if (session('id'))
                        @if (session('role') === 'admin')
                            <a class="nav-link" href="/admin/dashboard"><i class="bi bi-shield-check"></i> Admin</a>
                            <a class="nav-link" href="/events"><i class="bi bi-calendar-event"></i> Kelola Event</a>
                        @elseif(session('role') === 'penyelenggara')
                            <a class="nav-link" href="/penyelenggara/dashboard"><i class="bi bi-grid-fill"></i> Panel
                                Penyelenggara</a>
                            <a class="nav-link" href="/events"><i class="bi bi-calendar-event"></i> Kelola Event</a>
                        @else
                            <a class="nav-link" href="/dashboard"><i class="bi bi-person-circle"></i> Dashboard</a>
                        @endif
                        <a class="nav-link text-danger" href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
                        <span class="badge ms-2"
                            style="background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); color: #16a34a; padding: 8px 14px; border-radius: 20px;">
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

    <main class="py-4 container-fluid" style="max-width: 1400px;">
        @yield('content')
    </main>

    @yield('modals')

    <footer class="py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">
                <i class="bi bi-lightning-charge-fill" style="color: #22c55e;"></i>
                <strong style="color: #16a34a;">EventPulse</strong>
                <span style="color: #64748b;"> &copy; 2026 — Platform Event Kampus</span>
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#22c55e',
                timer: 3000,
                timerProgressBar: true,
                background: '#ffffff',
                color: '#1e293b',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#ef4444',
                background: '#ffffff',
                color: '#1e293b',
            });
        </script>
    @endif

</body>

</html>
