@extends('layouts.app')

@section('content')
<div class="container mt-4" style="max-width: 700px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-pencil-square" style="color: #a78bfa;"></i> Edit User</h2>
            <p class="text-muted mb-0">Ubah data dan role pengguna</p>
        </div>
        <a href="/admin/users" class="btn btn-primary-gradient"><i class="bi bi-arrow-left"></i> Kembali</a>
    </div>

    <div class="glass-box">
        <form action="/admin/users/{{ $user->id }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" value="{{ $user->nama }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>NIM</label>
                    <input type="text" name="nim" class="form-control" value="{{ $user->nim ?? '' }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Program Studi</label>
                    <input type="text" name="prodi" class="form-control" value="{{ $user->prodi ?? '' }}">
                </div>
            </div>

            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ $user->no_hp ?? '' }}">
            </div>

            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-select" required>
                    <option value="mahasiswa" {{ $user->role === 'mahasiswa' ? 'selected' : '' }}>🎓 Mahasiswa</option>
                    <option value="penyelenggara" {{ $user->role === 'penyelenggara' ? 'selected' : '' }}>⭐ Penyelenggara</option>
                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>🛡️ Admin</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Password Baru <small style="color: #64748b;">(kosongkan jika tidak ingin mengubah)</small></label>
                <input type="password" name="password" class="form-control" placeholder="••••••••">
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary-gradient px-4">
                    <i class="bi bi-check-lg"></i> Simpan Perubahan
                </button>
                <a href="/admin/users" class="btn" style="background: rgba(255,255,255,0.06); color: #94a3b8; border: 1px solid rgba(255,255,255,0.12);">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
