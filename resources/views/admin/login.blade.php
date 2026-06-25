<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | EventPulse</title>
    
    <!-- Bootstrap 5.3 & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: #f0f7ff;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        .glow-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(14, 165, 233, 0.12) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(56, 189, 248, 0.08) 0%, transparent 40%);
            pointer-events: none;
            z-index: 0;
        }

        .login-container {
            width: 100%;
            max-width: 460px;
            padding: 1.5rem;
            z-index: 1;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid rgba(14, 165, 233, 0.12);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            box-shadow: 0 20px 50px rgba(14, 165, 233, 0.1);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(14, 165, 233, 0.04), transparent);
            pointer-events: none;
        }

        .brand-logo {
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            background: linear-gradient(135deg, #0284c7, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            margin-bottom: 2rem;
        }

        .brand-logo i {
            color: #0ea5e9;
            -webkit-text-fill-color: initial;
        }

        .login-header h2 {
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .login-header p {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .input-group-custom {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group-custom i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            transition: color 0.3s;
            font-size: 1.1rem;
        }

        .input-group-custom input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            color: #1e293b;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .input-group-custom input:focus {
            outline: none;
            background: #ffffff;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.15);
        }

        .input-group-custom input:focus + i {
            color: #0ea5e9;
        }

        .input-label {
            font-size: 0.85rem;
            color: #475569;
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #0284c7, #0ea5e9);
            border: none;
            color: #fff;
            font-weight: 700;
            border-radius: 12px;
            transition: all 0.3s;
            margin-top: 1rem;
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #0369a1, #0284c7);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(14, 165, 233, 0.4);
        }

        .form-footer-links {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9rem;
            color: #64748b;
        }

        .form-footer-links a {
            color: #0ea5e9;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .form-footer-links a:hover {
            color: #0284c7;
            text-decoration: underline;
        }

        .btn-back-home {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #64748b !important;
            font-size: 0.85rem;
            margin-top: 1.25rem;
            text-decoration: none;
            transition: color 0.3s;
        }

        .btn-back-home:hover {
            color: #0ea5e9 !important;
        }
    </style>
</head>
<body>

    <div class="glow-overlay"></div>

    <div class="login-container">
        <div class="login-card">
            
            <a href="/" class="brand-logo">
                <i class="bi bi-lightning-charge-fill"></i> EventPulse
            </a>

            <div class="login-header">
                <h2>Portal Admin</h2>
                <p>Masuk sebagai Administrator EventPulse</p>
            </div>

            <form action="/admin/login" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="input-label">Email Admin</label>
                    <div class="input-group-custom">
                        <input type="email" name="email" placeholder="admin@eventpulse.com" required>
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="input-label">Password</label>
                    <div class="input-group-custom">
                        <input type="password" name="password" placeholder="••••••••" required>
                        <i class="bi bi-lock-fill"></i>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    Masuk Sebagai Admin
                </button>
            </form>

            <div class="form-footer-links">
                <div>
                    Bukan Admin? <a href="/login">Kembali ke Login Biasa</a>
                </div>
                <a href="/" class="btn-back-home">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>

    <!-- SweetAlert2 Login Session Notifications -->
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Masuk!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#0ea5e9',
            background: '#ffffff',
            color: '#1e293b',
        });
    </script>
    @endif

    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#0ea5e9',
            timer: 3000,
            timerProgressBar: true,
            background: '#ffffff',
            color: '#1e293b',
        });
    </script>
    @endif

</body>
</html>
