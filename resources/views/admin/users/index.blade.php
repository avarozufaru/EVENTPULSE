@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-people-fill" style="color: #a78bfa;"></i> Kelola User</h2>
            <p class="text-muted mb-0">Kelola semua akun pengguna sistem</p>
        </div>
        <a href="/admin/dashboard" class="btn btn-primary-gradient"><i class="bi bi-arrow-left"></i> Dashboard</a>
    </div>

    <div class="glass-box">
        <div class="table-responsive">
            <table class="table table-hover" id="userTable">
                <thead>
                    <tr style="border-bottom: 2px solid rgba(99,102,241,0.3);">
                        <th>#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $i => $user)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width:36px; height:36px; border-radius:50%; background: linear-gradient(135deg, #6366f1, #a78bfa); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.85rem; color:#fff;">
                                    {{ strtoupper(substr($user->nama ?? 'U', 0, 1)) }}
                                </div>
                                <span>{{ $user->nama }}</span>
                            </div>
                        </td>
                        <td><span style="color: #94a3b8;">{{ $user->email }}</span></td>
                        <td>{{ $user->nim ?? '-' }}</td>
                        <td>{{ $user->prodi ?? '-' }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge" style="background: rgba(239,68,68,0.2); color: #f87171; border: 1px solid rgba(239,68,68,0.3); padding: 6px 12px; border-radius: 20px;">
                                    <i class="bi bi-shield-fill"></i> Admin
                                </span>
                            @elseif($user->role === 'penyelenggara')
                                <span class="badge" style="background: rgba(251,191,36,0.2); color: #fbbf24; border: 1px solid rgba(251,191,36,0.3); padding: 6px 12px; border-radius: 20px;">
                                    <i class="bi bi-star-fill"></i> Penyelenggara
                                </span>
                            @else
                                <span class="badge" style="background: rgba(99,102,241,0.2); color: #818cf8; border: 1px solid rgba(99,102,241,0.3); padding: 6px 12px; border-radius: 20px;">
                                    <i class="bi bi-mortarboard-fill"></i> Mahasiswa
                                </span>
                            @endif
                        </td>
                        <td><span style="color: #64748b;">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-sm" style="background: rgba(99,102,241,0.2); color: #818cf8; border: 1px solid rgba(99,102,241,0.3);">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @if($user->id != session('id'))
                                <form action="/admin/users/{{ $user->id }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-delete-user" style="background: rgba(239,68,68,0.2); color: #f87171; border: 1px solid rgba(239,68,68,0.3);">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<style>
    .dataTables_wrapper .dataTables_filter input { background: rgba(255,255,255,0.06) !important; border: 1px solid rgba(255,255,255,0.12) !important; color: #e2e8f0 !important; border-radius: 10px !important; padding: 6px 14px !important; }
    .dataTables_wrapper .dataTables_length select { background: rgba(255,255,255,0.06) !important; border: 1px solid rgba(255,255,255,0.12) !important; color: #e2e8f0 !important; border-radius: 8px !important; }
    .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_length label, .dataTables_wrapper .dataTables_filter label { color: #94a3b8 !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { color: #94a3b8 !important; background: transparent !important; border: 1px solid rgba(255,255,255,0.08) !important; border-radius: 8px !important; margin: 0 2px; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: rgba(99,102,241,0.3) !important; color: #a78bfa !important; border-color: rgba(99,102,241,0.5) !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: rgba(99,102,241,0.2) !important; color: #e2e8f0 !important; }
</style>
<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            language: { search: "Cari:", lengthMenu: "Tampilkan _MENU_ data", info: "Menampilkan _START_-_END_ dari _TOTAL_ user", paginate: { previous: "‹", next: "›" } },
            pageLength: 10,
            order: [[0, 'asc']]
        });

        // SweetAlert delete confirmation
        $('.btn-delete-user').on('click', function() {
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus User?',
                text: 'Data user dan semua registrasi terkait akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6366f1',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#1e1e2e',
                color: '#e2e8f0',
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        });
    });
</script>
@endsection
