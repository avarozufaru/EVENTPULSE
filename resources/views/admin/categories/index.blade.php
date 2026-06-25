@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-tags-fill" style="color: #0ea5e9;"></i> Kelola Kategori</h2>
            <p class="text-muted mb-0">Kelola kategori event untuk pengelompokan kegiatan</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary-gradient" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="bi bi-plus-lg"></i> Tambah Kategori
            </button>
            <a href="/admin/dashboard" class="btn" style="border: 1px solid #e2e8f0; border-radius:10px; color: #475569;"><i class="bi bi-arrow-left"></i> Dashboard</a>
        </div>
    </div>

    <div class="glass-box">
        <div class="table-responsive">
            <table class="table table-hover" id="categoryTable">
                <thead>
                    <tr style="border-bottom: 2px solid rgba(14,165,233,0.3);">
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
                            <span class="fw-semibold text-dark">{{ $category->nama }}</span>
                        </td>
                        <td>
                            @php
                                $eventCount = DB::table('events')->where('category_id', $category->id)->count();
                            @endphp
                            <span class="badge" style="background: rgba(14,165,233,0.1); color: #0284c7; border: 1px solid rgba(14,165,233,0.2); padding: 5px 10px; border-radius: 12px;">
                                {{ $eventCount }} Event
                            </span>
                        </td>
                        <td><span style="color: #64748b;">{{ \Carbon\Carbon::parse($category->created_at)->format('d M Y') }}</span></td>
                        <td>
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-sm btn-edit" style="background: rgba(14,165,233,0.1); color: #0284c7; border: 1px solid rgba(14,165,233,0.2);" onclick="editCategory({{ $category->id }}, '{{ addslashes($category->nama) }}')">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="/admin/categories/{{ $category->id }}" method="POST" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-delete-cat" style="background: rgba(239,68,68,0.1); color: #dc2626; border: 1px solid rgba(239,68,68,0.2);">
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

@section('modals')
<!-- Modal Tambah Kategori -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #ffffff; border: 1px solid rgba(14,165,233,0.2); border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title" style="color: #0f172a;"><i class="bi bi-tag-fill me-2" style="color: #0ea5e9;"></i> Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/categories" method="POST">
                @csrf
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label for="nama" class="form-label text-dark">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Seminar, Workshop, Lomba" required style="border-radius: 10px; border-color: #cbd5e1;">
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius:10px;">Batal</button>
                    <button type="submit" class="btn btn-primary-gradient px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #ffffff; border: 1px solid rgba(14,165,233,0.2); border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title" style="color: #0f172a;"><i class="bi bi-pencil-square me-2" style="color: #0ea5e9;"></i> Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label text-dark">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required style="border-radius: 10px; border-color: #cbd5e1;">
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius:10px;">Batal</button>
                    <button type="submit" class="btn btn-primary-gradient px-4">Perbarui</button>
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

    function editCategory(id, nama) {
        $('#editCategoryForm').attr('action', '/admin/categories/' + id);
        $('#edit_nama').val(nama);
        $('#editCategoryModal').modal('show');
    }
</script>
@endsection
