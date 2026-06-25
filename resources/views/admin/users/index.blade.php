@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-people-fill" style="color: #0ea5e9;"></i> Kelola User</h2>
            <p class="text-muted mb-0">Kelola semua akun pengguna sistem</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary-gradient" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="bi bi-person-plus-fill"></i> Tambah Pengguna
            </button>
            <a href="/admin/dashboard" class="btn" style="border: 1px solid #e2e8f0; border-radius:10px; color: #475569;"><i class="bi bi-arrow-left"></i> Dashboard</a>
        </div>
    </div>

    <div class="glass-box">
        <div class="table-responsive">
            <table class="table table-hover" id="userTable">
                <thead>
                    <tr style="border-bottom: 2px solid rgba(14,165,233,0.3);">
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
                                <div style="width:36px; height:36px; border-radius:50%; background: linear-gradient(135deg, #0284c7, #38bdf8); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.85rem; color:#fff;">
                                    {{ strtoupper(substr($user->nama ?? 'U', 0, 1)) }}
                                </div>
                                <span class="fw-medium text-dark">{{ $user->nama }}</span>
                            </div>
                        </td>
                        <td><span style="color: #64748b;">{{ $user->email }}</span></td>
                        <td>{{ $user->nim ?? '-' }}</td>
                        <td>{{ $user->prodi ?? '-' }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge" style="background: rgba(239,68,68,0.1); color: #dc2626; border: 1px solid rgba(239,68,68,0.2); padding: 6px 12px; border-radius: 20px;">
                                    <i class="bi bi-shield-fill"></i> Admin
                                </span>
                            @elseif($user->role === 'penyelenggara')
                                <span class="badge" style="background: rgba(245,158,11,0.1); color: #d97706; border: 1px solid rgba(245,158,11,0.2); padding: 6px 12px; border-radius: 20px;">
                                    <i class="bi bi-star-fill"></i> Penyelenggara
                                </span>
                            @else
                                <span class="badge" style="background: rgba(14,165,233,0.1); color: #0284c7; border: 1px solid rgba(14,165,233,0.2); padding: 6px 12px; border-radius: 20px;">
                                    <i class="bi bi-mortarboard-fill"></i> Mahasiswa
                                </span>
                            @endif
                        </td>
                        <td><span style="color: #64748b;">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-sm" style="background: rgba(14,165,233,0.1); color: #0284c7; border: 1px solid rgba(14,165,233,0.2);">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @if($user->id != session('id'))
                                <form action="/admin/users/{{ $user->id }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-delete-user" style="background: rgba(239,68,68,0.1); color: #dc2626; border: 1px solid rgba(239,68,68,0.2);">
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

@section('modals')
<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="background: #ffffff; border: 1px solid rgba(14,165,233,0.2); border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title" style="color: #0f172a;"><i class="bi bi-person-plus-fill me-2" style="color: #0ea5e9;"></i> Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/users" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama" class="form-label text-dark">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" required style="border-radius: 10px; border-color: #cbd5e1;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label text-dark">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required style="border-radius: 10px; border-color: #cbd5e1;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label text-dark">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required style="border-radius: 10px; border-color: #cbd5e1;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="role" class="form-label text-dark">Role</label>
                            <select class="form-select" id="role" name="role" required style="border-radius: 10px; border-color: #cbd5e1;">
                                <option value="mahasiswa">Mahasiswa (Peserta)</option>
                                <option value="penyelenggara">Penyelenggara (Organisasi/Kepanitiaan)</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nim" class="form-label text-dark">NIM <span class="text-muted">(Opsional untuk Penyelenggara/Admin)</span></label>
                            <input type="text" class="form-control" id="nim" name="nim" style="border-radius: 10px; border-color: #cbd5e1;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="prodi" class="form-label text-dark">Prodi <span class="text-muted">(Opsional)</span></label>
                            <input type="text" class="form-control" id="prodi" name="prodi" style="border-radius: 10px; border-color: #cbd5e1;">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="no_hp" class="form-label text-dark">No HP / WhatsApp <span class="text-muted">(Opsional)</span></label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" style="border-radius: 10px; border-color: #cbd5e1;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius:10px;">Batal</button>
                    <button type="submit" class="btn btn-primary-gradient px-4">Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<style>
    /* DataTables Pagination & Input Styles for Light Theme */
    .dataTables_wrapper .dataTables_filter input { background: #ffffff !important; border: 1px solid #cbd5e1 !important; color: #1e293b !important; border-radius: 10px !important; padding: 6px 14px !important; }
    .dataTables_wrapper .dataTables_length select { background: #ffffff !important; border: 1px solid #cbd5e1 !important; color: #1e293b !important; border-radius: 8px !important; }
    .dataTables_wrapper .dataTables_info, .dataTables_wrapper .dataTables_length label, .dataTables_wrapper .dataTables_filter label { color: #64748b !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button { color: #64748b !important; background: transparent !important; border: 1px solid #e2e8f0 !important; border-radius: 8px !important; margin: 0 2px; }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current { background: rgba(14,165,233,0.1) !important; color: #0284c7 !important; border-color: rgba(14,165,233,0.3) !important; }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover { background: #f0f7ff !important; color: #0ea5e9 !important; border-color: #cbd5e1 !important; }

    /* Fix Table Body Background */
    table.dataTable, table.dataTable tbody, table.dataTable tr, table.dataTable td, table.dataTable th {
        background-color: transparent !important; 
        color: #1e293b !important; 
    }
    table.dataTable tbody tr:hover, table.dataTable tbody tr:hover td { 
        background-color: #f8fafc !important; 
    }
    table.dataTable tbody td { border-bottom: 1px solid #e2e8f0 !important; }
    table.dataTable thead th { border-bottom: 2px solid rgba(14,165,233,0.3) !important; color: #0f172a !important; }
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
                cancelButtonColor: '#0ea5e9',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                color: '#1e293b',
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        });
    });
</script>
@endsection
