<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Tiket {{ $registration->kode_tiket }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333333;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
        }

        .ticket-wrapper {
            border: 2px solid #6366f1;
            border-radius: 12px;
            overflow: hidden;
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .ticket-header {
            background-color: #6366f1;
            color: #ffffff;
            padding: 15px 20px;
            text-align: center;
        }

        .ticket-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .ticket-header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            opacity: 0.85;
        }

        .ticket-body {
            padding: 20px;
            background-color: #fafafa;
        }

        .ticket-section {
            margin-bottom: 20px;
        }

        .ticket-section-title {
            font-size: 12px;
            text-transform: uppercase;
            color: #888888;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .ticket-info-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .ticket-info-grid td {
            padding: 8px 0;
            vertical-align: top;
            font-size: 14px;
        }

        .ticket-info-grid td.label {
            width: 30%;
            color: #666666;
            font-weight: 500;
        }

        .ticket-info-grid td.value {
            width: 70%;
            color: #111111;
            font-weight: 700;
        }

        .ticket-footer {
            border-top: 2px dashed #e2e8f0;
            padding: 20px;
            background-color: #f8fafc;
            text-align: center;
            position: relative;
        }

        .ticket-pass {
            display: inline-block;
            background-color: #10b981;
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .ticket-code {
            font-size: 22px;
            font-weight: 900;
            letter-spacing: 2px;
            color: #6366f1;
            margin-top: 5px;
        }

        .ticket-barcode-sim {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #888888;
            letter-spacing: 6px;
            margin-top: 15px;
            text-transform: uppercase;
        }

        .instructions {
            margin-top: 25px;
            font-size: 11px;
            color: #888888;
            text-align: center;
            line-height: 1.5;
        }
    </style>
</head>
<body>

    <div class="ticket-wrapper">
        <div class="ticket-header">
            <h1>EventPulse E-Ticket</h1>
            <p>Tunjukkan tiket digital atau cetak ini saat memasuki lokasi acara</p>
        </div>

        <div class="ticket-body">
            <div class="ticket-section">
                <div class="ticket-section-title">Informasi Peserta</div>
                <table class="ticket-info-grid">
                    <tr>
                        <td class="label">Nama Lengkap</td>
                        <td class="value">{{ $registration->nama_mhs }}</td>
                    </tr>
                    <tr>
                        <td class="label">NIM / Student ID</td>
                        <td class="value">{{ $registration->nim ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Program Studi</td>
                        <td class="value">{{ $registration->prodi ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="ticket-section">
                <div class="ticket-section-title">Detail Event</div>
                <table class="ticket-info-grid">
                    <tr>
                        <td class="label">Judul Event</td>
                        <td class="value">{{ $registration->judul }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tanggal</td>
                        <td class="value">{{ \Carbon\Carbon::parse($registration->tanggal)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Waktu</td>
                        <td class="value">
                            {{ $registration->jam_mulai }} 
                            @if($registration->jam_selesai) - {{ $registration->jam_selesai }} @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Lokasi</td>
                        <td class="value">{{ $registration->lokasi }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="ticket-footer">
            <div class="ticket-pass">NO. ANTRIAN: #{{ $registration->nomor_antrian }}</div>
            <div>Kode Tiket Anda:</div>
            <div class="ticket-code">{{ $registration->kode_tiket }}</div>
            <div class="ticket-barcode-sim">||||||| | ||||| | ||| |||||||</div>
        </div>
    </div>

    <div class="instructions">
        <strong>Syarat & Ketentuan Masuk:</strong><br>
        1. Tiket ini berlaku untuk 1 orang sesuai dengan nama yang terdaftar.<br>
        2. Dilarang menyebarluaskan kode tiket untuk mencegah duplikasi pendaftaran.<br>
        3. Harap datang 15 menit sebelum acara dimulai untuk melakukan registrasi ulang.
    </div>

</body>
</html>
