<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | EventPulse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #f8fafc; color: #0f172a; min-height: 100vh; display: flex; overflow-x: hidden; }

        .glow-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-image:
                radial-gradient(circle at 10% 20%, rgba(14, 165, 233, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(56, 189, 248, 0.1) 0%, transparent 40%);
            pointer-events: none; z-index: 0;
        }

        .split-container { display: flex; width: 100%; min-height: 100vh; z-index: 1; }

        /* Left Branding Panel */
        .brand-panel {
            flex: 1;
            background: linear-gradient(135deg, #0ea5e9 0%, #0369a1 100%);
            display: flex; flex-direction: column; justify-content: space-between;
            padding: 3.5rem; position: relative; overflow: hidden;
        }
        .brand-panel::before {
            content: '';
            position: absolute; top: -20%; right: -20%; width: 60%; height: 60%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            filter: blur(60px);
        }
        .brand-pattern {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0.1;
            background-image: linear-gradient(rgba(255, 255, 255, 0.4) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255, 255, 255, 0.4) 1px, transparent 1px);
            background-size: 40px 40px; pointer-events: none;
        }
        .brand-logo {
            font-size: 1.8rem; font-weight: 800;
            color: #ffffff;
            display: flex; align-items: center; gap: 8px; text-decoration: none;
            z-index: 2;
        }
        .brand-logo i { color: #facc15; }
        .brand-middle { max-width: 480px; margin: auto 0; position: relative; z-index: 2; }
        .brand-middle h1 { font-size: 2.8rem; font-weight: 800; line-height: 1.25; margin-bottom: 1rem; color: #ffffff; }
        .brand-middle h1 span { color: #facc15; text-shadow: 0 2px 10px rgba(250, 204, 21, 0.3); }
        .brand-middle p { color: rgba(255, 255, 255, 0.9); font-size: 1rem; line-height: 1.7; margin-bottom: 2rem; }

        .step-item {
            display: flex; align-items: center; gap: 14px;
            background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px; padding: 14px 18px; margin-bottom: 12px;
            backdrop-filter: blur(10px);
        }
        .step-num {
            width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
            background: #ffffff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 0.9rem; color: #0ea5e9;
        }
        .step-text h6 { color: #ffffff; font-weight: 700; font-size: 0.95rem; margin-bottom: 2px; }
        .step-text p { color: rgba(255, 255, 255, 0.8); font-size: 0.85rem; margin-bottom: 0; }
        .brand-footer { color: rgba(255, 255, 255, 0.7); font-size: 0.9rem; font-weight: 500; z-index: 2;}

        /* Right Form Panel */
        .form-panel {
            flex: 1.3;
            display: flex; align-items: center; justify-content: center;
            padding: 3rem 3rem 3rem 2rem; background-color: #ffffff;
        }
        .register-card {
            width: 100%; max-width: 520px;
            background: #ffffff;
            border: 1px solid rgba(14, 165, 233, 0.1);
            border-radius: 24px; padding: 2.5rem;
            box-shadow: 0 20px 50px rgba(14, 165, 233, 0.08); position: relative;
        }
        .reg-header h2 { font-weight: 800; color: #0f172a; margin-bottom: 0.4rem; }
        .reg-header p { color: #64748b; font-size: 0.9rem; margin-bottom: 1.6rem; }

        .input-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        .input-wrap { position: relative; }
        .input-wrap i {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 1rem; pointer-events: none; transition: color 0.3s;
        }
        .input-label { font-size: 0.82rem; color: #475569; font-weight: 600; margin-bottom: 6px; display: block; }
        .input-wrap input, .input-wrap select {
            width: 100%; padding: 13px 14px 13px 42px;
            background: #f8fafc; border: 1px solid #e2e8f0;
            border-radius: 12px; color: #0f172a; font-size: 0.9rem; transition: all 0.3s;
        }
        .input-wrap input:focus, .input-wrap select:focus {
            outline: none; background: #ffffff;
            border-color: #0ea5e9; box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }
        .input-wrap input:focus + i, .input-wrap select:focus + i { color: #0ea5e9; }
        .input-wrap input::placeholder { color: #94a3b8; }
        .input-wrap select option { background: #ffffff; color: #0f172a; }

        .btn-register {
            width: 100%; padding: 14px; margin-top: 1.2rem;
            background: linear-gradient(135deg, #0ea5e9, #38bdf8);
            border: none; color: white; font-weight: 700; font-size: 1rem;
            border-radius: 12px; transition: all 0.3s;
            box-shadow: 0 8px 24px rgba(14, 165, 233, 0.3);
        }
        .btn-register:hover {
            background: linear-gradient(135deg, #0284c7, #0ea5e9);
            transform: translateY(-2px); box-shadow: 0 12px 30px rgba(14, 165, 233, 0.4);
        }

        .form-footer-links { text-align: center; margin-top: 1.5rem; font-size: 0.9rem; color: #64748b; }
        .form-footer-links a { color: #0ea5e9; text-decoration: none; font-weight: 600; }
        .form-footer-links a:hover { color: #0284c7; text-decoration: underline; }
        .btn-back-home { display: inline-flex; align-items: center; gap: 6px; color: #64748b !important; font-size: 0.85rem; margin-top: 1rem; text-decoration: none; transition: color 0.3s; }
        .btn-back-home:hover { color: #0f172a !important; }

        @media (max-width: 991.98px) {
            .brand-panel { display: none; }
            .form-panel { padding: 1.5rem; }
            .register-card { padding: 2rem 1.5rem; }
            .input-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<div class="glow-overlay"></div>

<div class="split-container">

    <!-- Left Branding Panel -->
    <div class="brand-panel">
        <div class="brand-pattern"></div>
        <a href="/" class="brand-logo"><i class="bi bi-lightning-charge-fill"></i> EventPulse</a>

        <div class="brand-middle">
            <h1>Bergabung & Temukan <span>Event</span> Seru!</h1>
            <p>Daftarkan dirimu sekarang dan mulai jelajahi ratusan event kampus — seminar, workshop, lomba, dan pentas seni.</p>

            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-text">
                    <h6>Isi Data Diri</h6>
                    <p>Lengkapi formulir pendaftaran dengan data mahasiswa Anda.</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-text">
                    <h6>Pilih Event</h6>
                    <p>Jelajahi event dari berbagai kategori sesuai minat Anda.</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-text">
                    <h6>Dapatkan E-Tiket</h6>
                    <p>Daftar event dan unduh e-tiket digital dengan nomor antrean instan.</p>
                </div>
            </div>
        </div>

        <div class="brand-footer">© 2026 EventPulse — Registrasi & Direktori Event Kampus</div>
    </div>

    <!-- Right Form Panel -->
    <div class="form-panel">
        <div class="register-card">
            <div class="reg-header">
                <h2>Buat Akun Mahasiswa</h2>
                <p>Isi formulir di bawah untuk mendaftar. Gratis, cepat, dan mudah!</p>
            </div>

            <form action="/register" method="POST">
                @csrf

                <!-- Nama & NIM -->
                <div class="input-row mb-3">
                    <div>
                        <label class="input-label">Nama Lengkap</label>
                        <div class="input-wrap">
                            <input type="text" name="nama" placeholder="Nama Lengkap" required>
                            <i class="bi bi-person-fill"></i>
                        </div>
                    </div>
                    <div>
                        <label class="input-label">NIM</label>
                        <div class="input-wrap">
                            <input type="text" name="nim" placeholder="Nomor Induk Mahasiswa">
                            <i class="bi bi-card-text"></i>
                        </div>
                    </div>
                </div>

                <!-- Prodi & No HP -->
                <div class="input-row mb-3">
                    <div>
                        <label class="input-label">Program Studi</label>
                        <div class="input-wrap">
                            <input type="text" name="prodi" placeholder="Teknik Informatika">
                            <i class="bi bi-book-fill"></i>
                        </div>
                    </div>
                    <div>
                        <label class="input-label">No. HP / WhatsApp</label>
                        <div class="input-wrap">
                            <input type="text" name="no_hp" placeholder="081234567890">
                            <i class="bi bi-phone-fill"></i>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="input-label">Email</label>
                    <div class="input-wrap">
                        <input type="email" name="email" placeholder="nama@email.com" required>
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="input-label">Password</label>
                    <div class="input-wrap">
                        <input type="password" name="password" placeholder="Min. 8 karakter" required>
                        <i class="bi bi-lock-fill"></i>
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <i class="bi bi-person-plus-fill me-2"></i>Buat Akun Sekarang
                </button>
            </form>

            <div class="form-footer-links">
                Sudah punya akun? <a href="/login">Masuk di sini</a>
                <br>
                <a href="/" class="btn-back-home"><i class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
            </div>
        </div>
    </div>

</div>

@if($errors->any())
<script>
    Swal.fire({
        icon: 'warning',
        title: 'Pendaftaran Gagal!',
        text: "{{ $errors->first() }}",
        confirmButtonColor: '#0ea5e9',
        background: '#ffffff',
        color: '#0f172a'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}", confirmButtonColor: '#0ea5e9', background: '#ffffff', color: '#0f172a' });
</script>
@endif

@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", confirmButtonColor: '#0ea5e9', timer: 3000, timerProgressBar: true, background: '#ffffff', color: '#0f172a' });
</script>
@endif

</body>
</html>