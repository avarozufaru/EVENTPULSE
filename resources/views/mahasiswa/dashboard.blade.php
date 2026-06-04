@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2>Dashboard Mahasiswa</h2>
            <p class="text-muted mb-0">Selamat Datang, <strong>{{ session('nama') }}</strong></p>
        </div>
        <div>
            <a href="/" class="btn btn-primary me-2">🎯 Lihat Event</a>
            <a href="/logout" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <hr>

    <h4>🎟️ Tiket Saya</h4>
    @if(count($tiket) > 0)
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Event</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Kode Tiket</th>
                    <th>No Antrian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tiket as $t)
                <tr>
                    <td>{{ $t->judul }}</td>
                    <td>{{ $t->tanggal }}</td>
                    <td>{{ $t->lokasi }}</td>
                    <td><span class="badge bg-primary">{{ $t->kode_tiket }}</span></td>
                    <td><span class="badge bg-success">#{{ $t->nomor_antrian }}</span></td>
                    <td>
                        <a href="/ticket/{{ $t->kode_tiket }}/download" class="btn btn-sm btn-primary-gradient">
                            <i class="bi bi-download"></i> Unduh E-Tiket
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="alert alert-info">
        Kamu belum mendaftar event apapun. <a href="/">Lihat Event</a>
    </div>
    @endif
</div>
@endsection