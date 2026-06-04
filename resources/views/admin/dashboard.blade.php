@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Dashboard {{ session('role') === 'admin' ? 'Admin' : 'Penyelenggara' }}</h2>
    @php
        $cardCol = session('role') === 'admin' ? 'col-md-4' : 'col-md-6';
    @endphp
    <div class="row mt-3">
        <div class="{{ $cardCol }}">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Event</h5>
                    <p class="card-text display-6">{{ $totalEvent }}</p>
                </div>
            </div>
        </div>
        <div class="{{ $cardCol }}">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Peserta</h5>
                    <p class="card-text display-6">{{ $totalPeserta }}</p>
                </div>
            </div>
        </div>
        @if(session('role') === 'admin')
        <div class="{{ $cardCol }}">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total User</h5>
                    <p class="card-text display-6">{{ $totalUser }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
    <div class="mt-3">
        <a href="/events" class="btn btn-primary">Kelola Event</a>
        <a href="{{ session('role') === 'admin' ? '/admin/peserta' : '/penyelenggara/peserta' }}" class="btn btn-success ms-2">Lihat Peserta</a>
    </div>
</div>
@endsection