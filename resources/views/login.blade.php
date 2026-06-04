<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EventPulse</title>
    
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
            background-color: #050508;
            color: #e2e8f0;
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        /* Ambient Glows */
        .glow-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(99,102,241,0.15) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(167,139,250,0.1) 0%, transparent 40%);
            pointer-events: none;
            z-index: 0;
        }

        .split-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
            z-index: 1;
        }

        /* Left Branding Panel */
        .brand-panel {
            flex: 1.2;
            background: linear-gradient(135deg, #0f0f1c 0%, #07070a 100%);
            border-right: 1px solid rgba(99,102,241,0.2);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3.5rem;
            position: relative;
            overflow: hidden;
        }

        .brand-panel::before {
            content: '';
            position: absolute;
            top: -20%; right: -20%;
            width: 60%; height: 60%;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, transparent 70%);
            filter: blur(50px);
        }

        /* Abstract Pattern Grid */
        .brand-pattern {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            opacity: 0.05;
            background-image: linear-gradient(rgba(99, 102, 241, 0.4) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(99, 102, 241, 0.4) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }

        .brand-logo {
            font-size: 1.8rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            background: linear-gradient(135deg, #a78bfa, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .brand-logo i {
            color: #6366f1;
            -webkit-text-fill-color: initial;
        }

        .brand-middle {
            max-width: 520px;
            margin: auto 0;
            position: relative;
            z-index: 2;
        }

        .brand-middle h1 {
            font-size: 3.2rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            color: #f8fafc;
        }

        .brand-middle h1 span {
            background: linear-gradient(135deg, #facc15, #f59e0b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-middle p {
            color: #94a3b8;
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        /* Glass Feature Card inside Brand Panel */
        .glass-feature {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .glass-icon-wrapper {
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #a78bfa;
            font-size: 1.3rem;
        }

        .glass-feature-text h6 {
            color: #f1f5f9;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .glass-feature-text p {
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 0;
        }

        .brand-footer {
            color: #475569;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Right Form Panel */
        .form-panel {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            background-color: #07070b;
        }

        .login-card {
            width: 100%;
            max-width: 440px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            position: relative;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            border-radius: 24px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.05), transparent);
            pointer-events: none;
        }

        .login-header h2 {
            font-weight: 800;
            color: #f1f5f9;
            margin-bottom: 0.5rem;
        }

        .login-header p {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 1.8rem;
        }

        /* Role Switcher Tab */
        .role-switcher {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            padding: 5px;
            border-radius: 14px;
            display: flex;
            gap: 5px;
            margin-bottom: 1.75rem;
        }

        .role-btn {
            flex: 1;
            padding: 11px 10px;
            border: none;
            background: transparent;
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.88rem;
            border-radius: 10px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            cursor: pointer;
        }

        .role-btn i {
            font-size: 1rem;
        }

        .role-btn.active {
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            color: #fff;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        /* Form Controls */
        .input-group-custom {
            position: relative;
            margin-bottom: 1.25rem;
        }

        .input-group-custom i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
            transition: color 0.3s;
            font-size: 1.1rem;
        }

        .input-group-custom input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            color: #f1f5f9;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .input-group-custom input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.06);
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        .input-group-custom input:focus + i {
            color: #a78bfa;
        }

        .input-label {
            font-size: 0.85rem;
            color: #94a3b8;
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
        }

        /* Buttons & Actions */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #6366f1, #a78bfa);
            border: none;
            color: #fff;
            font-weight: 700;
            border-radius: 12px;
            transition: all 0.3s;
            margin-top: 1rem;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.35);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #4f46e5, #8b5cf6);
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(99, 102, 241, 0.45);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #475569;
            font-size: 0.8rem;
            font-weight: 600;
            margin: 1.5rem 0;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .divider:not(:empty)::before { margin-right: .5em; }
        .divider:not(:empty)::after { margin-left: .5em; }

        .btn-google {
            width: 100%;
            padding: 13px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            color: #e2e8f0;
            font-weight: 600;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
        }

        .btn-google:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-1px);
        }

        .btn-google svg {
            width: 18px;
            height: 18px;
        }

        .form-footer-links {
            text-align: center;
            margin-top: 1.8rem;
            font-size: 0.9rem;
            color: #64748b;
        }

        .form-footer-links a {
            color: #a78bfa;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .form-footer-links a:hover {
            color: #818cf8;
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
            color: #e2e8f0 !important;
        }

        /* Responsive Layout */
        @media (max-width: 991.98px) {
            .brand-panel {
                display: none;
            }
            .form-panel {
                padding: 1.5rem;
            }
            .login-card {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="glow-overlay"></div>

    <div class="split-container">
        
        <!-- Left Branding Panel -->
        <div class="brand-panel">
            <div class="brand-pattern"></div>
            
            <a href="/" class="brand-logo">
                <i class="bi bi-lightning-charge-fill"></i> EventPulse
            </a>

            <div class="brand-middle">
                <h1>Temukan <span>Event</span><br>Terbaik di Kampusmu</h1>
                <p>Platform pusat informasi dan pendaftaran tiket digital kegiatan mahasiswa secara mudah, aman, dan instan.</p>
                
                <div class="glass-feature">
                    <div class="glass-icon-wrapper">
                        <i class="bi bi-ticket-perforated-fill"></i>
                    </div>
                    <div class="glass-feature-text">
                        <h6>E-Tiket dengan Nomor Antrean</h6>
                        <p>Dapatkan tiket instan berformat PDF setelah mendaftar event.</p>
                    </div>
                </div>
            </div>

            <div class="brand-footer">
                © 2026 EventPulse — Registrasi & Direktori Event Kampus
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="form-panel">
            <div class="login-card">
                
                <div class="login-header">
                    <h2 id="welcome-title">Selamat Datang!</h2>
                    <p id="welcome-desc">Silakan masuk ke akun Mahasiswa Anda.</p>
                </div>

                <!-- Role Switcher: 2 tab saja -->
                <div class="role-switcher">
                    <button type="button" class="role-btn active" id="btn-mahasiswa" onclick="switchRole('mahasiswa')">
                        <i class="bi bi-person-fill"></i> Mahasiswa
                    </button>
                    <button type="button" class="role-btn" id="btn-penyelenggara" onclick="switchRole('penyelenggara')">
                        <i class="bi bi-calendar-event-fill"></i> Penyelenggara
                    </button>
                </div>

                <!-- Login Form -->
                <form action="/login" method="POST">
                    @csrf
                    
                    <!-- Hidden input to store role selection -->
                    <input type="hidden" name="role" id="input-role" value="mahasiswa">

                    <div class="mb-3">
                        <label class="input-label">Email</label>
                        <div class="input-group-custom">
                            <input type="email" name="email" placeholder="contoh@mhs.ac.id" required>
                            <i class="bi bi-envelope-fill"></i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="input-label">Password</label>
                        <div class="input-group-custom">
                            <input type="password" name="password" placeholder="••••••••" required>
                            <i class="bi bi-lock-fill"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="btn-submit-text">
                        Masuk Sebagai Mahasiswa
                    </button>
                </form>

                <!-- Google Sign In Simulation -->
                <div class="divider">atau masuk dengan</div>

                <button class="btn-google" onclick="simulateGoogleLogin()">
                    <svg viewBox="0 0 24 24" width="24" height="24" xmlns="http://www.w3.org/2000/svg">
                        <g transform="matrix(1, 0, 0, 1, 0, 0)">
                            <path d="M21.35,11.1H12v2.7h5.38c-0.24,1.28 -0.96,2.37 -2.04,3.1v2.58h3.3c1.93,-1.78 3.04,-4.4 3.04,-7.48C21.68,11.83 21.56,11.43 21.35,11.1z" fill="#4285F4" />
                            <path d="M12,20.8c2.38,0 4.38,-0.79 5.84,-2.14l-3.3,-2.58c-0.91,0.61 -2.08,0.98 -3.53,0.98 -2.71,0 -5,-1.83 -5.82,-4.29H1.83v2.66C3.29,18.3 7.37,20.8 12,20.8z" fill="#34A853" />
                            <path d="M6.18,12.77c-0.21,-0.61 -0.32,-1.27 -0.32,-1.95s0.12,-1.34 0.32,-1.95V6.21H1.83c-0.68,1.37 -1.07,2.9 -1.07,4.52s0.39,3.15 1.07,4.52L6.18,12.77z" fill="#FBBC05" />
                            <path d="M12,5.2c1.29,0 2.45,0.44 3.37,1.32l2.52,-2.52C16.37,2.54 14.37,1.8 12,1.8 7.37,1.8 3.29,4.3 1.83,7.21l3.3,2.66C5.95,7.03 8.24,5.2 12,5.2z" fill="#EA4335" />
                        </g>
                    </svg>
                    Google
                </button>

                <!-- Footer Links -->
                <div class="form-footer-links">
                    <div id="register-link-container">
                        Belum punya akun? <a href="/register">Daftar Gratis</a>
                    </div>
                    <a href="/" class="btn-back-home">
                        <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>

            </div>
        </div>

    </div>

    <script>
        function switchRole(role) {
            const btnMhs = document.getElementById('btn-mahasiswa');
            const btnPenyelenggara = document.getElementById('btn-penyelenggara');
            const inputRole = document.getElementById('input-role');
            const welcomeTitle = document.getElementById('welcome-title');
            const welcomeDesc = document.getElementById('welcome-desc');
            const btnSubmitText = document.getElementById('btn-submit-text');
            const registerLinkContainer = document.getElementById('register-link-container');
            const emailInput = document.querySelector('input[type="email"]');

            btnMhs.classList.remove('active');
            btnPenyelenggara.classList.remove('active');

            if (role === 'mahasiswa') {
                btnMhs.classList.add('active');
                inputRole.value = 'mahasiswa';
                welcomeTitle.innerText = 'Selamat Datang!';
                welcomeDesc.innerText = 'Silakan masuk ke akun Mahasiswa Anda.';
                btnSubmitText.innerText = 'Masuk Sebagai Mahasiswa';
                registerLinkContainer.style.display = 'block';
                emailInput.placeholder = 'contoh@mhs.ac.id';
            } else {
                btnPenyelenggara.classList.add('active');
                inputRole.value = 'penyelenggara';
                welcomeTitle.innerText = 'Portal Penyelenggara';
                welcomeDesc.innerText = 'Masuk untuk mengelola event kampus Anda.';
                btnSubmitText.innerText = 'Masuk Sebagai Penyelenggara';
                registerLinkContainer.style.display = 'none';
                emailInput.placeholder = 'penyelenggara@email.com';
            }
        }

        function simulateGoogleLogin() {
            Swal.fire({
                icon: 'info',
                title: 'Simulasi Login Google',
                text: 'Fitur login Google terintegrasi sedang disimulasikan.',
                confirmButtonColor: '#6366f1',
                background: '#1e1e2e',
                color: '#e2e8f0',
            });
        }
    </script>

    <!-- SweetAlert2 Login Session Notifications -->
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal Masuk!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#6366f1',
            background: '#1e1e2e',
            color: '#e2e8f0',
        });
    </script>
    @endif

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

</body>
</html>