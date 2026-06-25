@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2><i class="bi bi-people-fill me-2" style="color: #0ea5e9;"></i>Daftar Peserta</h2>
    <a href="{{ session('role') === 'admin' ? '/admin/dashboard' : '/penyelenggara/dashboard' }}" class="btn btn-outline-secondary mb-3" style="border-radius: 10px;">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        /* Custom Light Theme Styles for DataTables */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #1e293b !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
        }
        .dataTables_wrapper .dataTables_info {
            color: #64748b !important;
            margin-top: 15px !important;
        }
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 15px !important;
        }
        .dataTables_wrapper .paginate_button.page-item .page-link {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
            color: #64748b !important;
            border-radius: 6px !important;
            margin: 0 2px !important;
            transition: all 0.2s !important;
        }
        .dataTables_wrapper .paginate_button.page-item.active .page-link {
            background: linear-gradient(135deg, #0284c7, #0ea5e9) !important;
            border-color: transparent !important;
            color: white !important;
            box-shadow: 0 4px 10px rgba(14, 165, 233, 0.2) !important;
        }
        .dataTables_wrapper .paginate_button.page-item .page-link:hover {
            background-color: #f0f7ff !important;
            color: #0ea5e9 !important;
        }
        .table-responsive {
            border: 1px solid #e2e8f0 !important;
            border-radius: 12px !important;
            padding: 15px !important;
            background: #ffffff !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
        }
        table.dataTable thead th {
            border-bottom: 2px solid #0ea5e9 !important;
            background-color: #f8fafc !important;
            color: #0f172a !important;
        }
        table.dataTable tbody td {
            border-bottom: 1px solid #e2e8f0 !important;
            color: #1e293b !important;
        }
        table.dataTable tbody tr:hover td {
            background-color: #f0f7ff !important;
        }
    </style>

    <div class="table-responsive mt-3">
        <table id="pesertaTable" class="table table-hover">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Event</th>
                    <th>Kode Tiket</th>
                    <th>No Antrian</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peserta as $p)
                <tr>
                    <td class="fw-medium">{{ $p->name }}</td>
                    <td class="text-muted">{{ $p->email }}</td>
                    <td>{{ $p->judul }}</td>
                    <td><span class="badge" style="background: rgba(14,165,233,0.1); color: #0284c7; border: 1px solid rgba(14,165,233,0.2);">{{ $p->kode_tiket }}</span></td>
                    <td><span class="badge" style="background: rgba(16,185,129,0.1); color: #059669; border: 1px solid rgba(16,185,129,0.2);">#{{ $p->nomor_antrian }}</span></td>
                    <td>
                        @if($p->status == 'registered')
                            <span class="badge bg-success bg-opacity-10 text-success border border-success px-2 py-1">Registered</span>
                        @else
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary px-2 py-1">{{ $p->status }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- jQuery & DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#pesertaTable').DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "Tidak ada data peserta",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ peserta",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 peserta",
                "infoFiltered": "(disaring dari _MAX_ total peserta)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Tampilkan _MENU_ peserta",
                "loadingRecords": "Memuat...",
                "processing": "",
                "search": "Cari:",
                "zeroRecords": "Tidak ditemukan peserta yang cocok",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Berikutnya",
                    "previous": "Sebelumnya"
                }
            }
        });
    });
</script>
@endsection