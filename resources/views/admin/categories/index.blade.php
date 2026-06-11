@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-tags-fill" style="color: #a78bfa;"></i> Kelola Kategori</h2>
            <p class="text-muted mb-0">Kelola kategori event untuk pengelompokan kegiatan</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary-gradient" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="bi bi-plus-lg"></i> Tambah Kategori
            </button>
            <a href="/admin/dashboard" class="btn btn-outline-light" style="border: 1px solid rgba(255,255,255,0.08); border-radius:10px;"><i class="bi bi-arrow-left"></i> Dashboard</a>
        </div>
    </div>

    <div class="glass-box">
        <div class="table-responsive">
            <table class="table table-hover" id="categoryTable">
                <thead>
                    <tr style="border-bottom: 2px solid rgba(99,102,241,0.3);">
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Event</th>
                        <th>Dibuat Pada</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            <span class="fw-semibold text-white">{{ $category->nama }}</span>
                        </td>
                        <td>
                            @php
                                $eventCount = DB::table('events')->where('category_id', $category->id)->count();
                            @endphp
                            <span class="badge" style="background: rgba(99,102,241,0.2); color: #818cf8; border: 1px solid rgba(99,102,241,0.3); padding: 5px 10px; border-radius: 12px;">
                                {{ $eventCount }} Event
                            </span>
                        </td>
                        <td><span style="color: #64748b;">{{ \Carbon\Carbon::parse($category->created_at)->format('d M Y') }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-edit" style="background: rgba(99,102,241,0.2); color: #818cf8; border: 1px solid rgba(99,102,241,0.3);" onclick="editCategory({{ $category->id }}, '{{ addslashes($category->nama) }}')">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="/admin/categories/{{ $category->id }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-delete-cat" style="background: rgba(239,68,68,0.2); color: #f87171; border: 1px solid rgba(239,68,68,0.3);">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #151522; border: 1px solid rgba(99,102,241,0.2); border-radius: 20px;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title text-white"><i class="bi bi-tag-fill" style="color: #a78bfa;"></i> Tambah Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/categories" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Seminar, Workshop, Lomba" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" style="border-radius:10px;">Batal</button>
                    <button type="submit" class="btn btn-primary-gradient px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #151522; border: 1px solid rgba(99,102,241,0.2); border-radius: 20px;">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title text-white"><i class="bi bi-pencil-square" style="color: #a78bfa;"></i> Edit Kategori</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal" style="border-radius:10px;">Batal</button>
                    <button type="submit" class="btn btn-primary-gradient px-4">Perbarui</button>
                </div>
            </form>
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
        $('#categoryTable').DataTable({
            language: { search: "Cari:", lengthMenu: "Tampilkan _MENU_ data", info: "Menampilkan _START_-_END_ dari _TOTAL_ kategori", paginate: { previous: "‹", next: "›" } },
            pageLength: 10,
            order: [[0, 'asc']]
        });

        // SweetAlert delete confirmation
        $('.btn-delete-cat').on('click', function() {
            const form = $(this).closest('form');
            Swal.fire({
                title: 'Hapus Kategori?',
                text: 'Kategori akan dihapus secara permanen. Pastikan tidak ada event yang menggunakan kategori ini!',
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

    function editCategory(id, nama) {
        $('#editCategoryForm').attr('action', '/admin/categories/' + id);
        $('#edit_nama').val(nama);
        $('#editCategoryModal').modal('show');
    }
</script>
@endsection
