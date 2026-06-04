@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Daftar Peserta</h2>
    <a href="{{ session('role') === 'admin' ? '/admin/dashboard' : '/penyelenggara/dashboard' }}" class="btn btn-secondary mb-3">← Kembali</a>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        /* Custom Dark Theme Styles for DataTables */
        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background-color: rgba(255, 255, 255, 0.06) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #e2e8f0 !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
        }
        .dataTables_wrapper .dataTables_info {
            color: #94a3b8 !important;
            margin-top: 15px !important;
        }
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 15px !important;
        }
        .dataTables_wrapper .paginate_button.page-item .page-link {
            background-color: rgba(255, 255, 255, 0.04) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            color: #94a3b8 !important;
            border-radius: 6px !important;
            margin: 0 2px !important;
            transition: all 0.2s !important;
        }
        .dataTables_wrapper .paginate_button.page-item.active .page-link {
            background: linear-gradient(135deg, #6366f1, #a78bfa) !important;
            border-color: transparent !important;
            color: white !important;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.2) !important;
        }
        .dataTables_wrapper .paginate_button.page-item .page-link:hover {
            background-color: rgba(99, 102, 241, 0.15) !important;
            color: #e2e8f0 !important;
        }
        .table-responsive {
            border: 1px solid rgba(255,255,255,0.08) !important;
            border-radius: 12px !important;
            padding: 15px !important;
            background: rgba(255, 255, 255, 0.01) !important;
            backdrop-filter: blur(10px) !important;
        }
    </style>

    <div class="table-responsive mt-3">
        <table id="pesertaTable" class="table table-bordered table-hover">
            <thead class="table-dark">
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
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->email }}</td>
                    <td>{{ $p->judul }}</td>
                    <td>{{ $p->kode_tiket }}</td>
                    <td>{{ $p->nomor_antrian }}</td>
                    <td>{{ $p->status }}</td>
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