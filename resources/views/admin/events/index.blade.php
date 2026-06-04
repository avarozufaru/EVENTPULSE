@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Kelola Event</h2>
    <a href="/events/create" class="btn btn-primary mb-3">+ Tambah Event</a>
    <a href="{{ session('role') === 'admin' ? '/admin/dashboard' : '/penyelenggara/dashboard' }}" class="btn btn-secondary mb-3 ms-2">← Dashboard</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Kuota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{ $event->judul }}</td>
                <td>{{ $event->tanggal }}</td>
                <td>{{ $event->lokasi }}</td>
                <td>{{ $event->kuota }}</td>
                <td>
                    <a href="/events/{{ $event->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                    <form action="/events/{{ $event->id }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus event ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection