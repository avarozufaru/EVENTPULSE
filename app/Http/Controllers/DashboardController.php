<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $user_id = Session::get('id');

        // Active tickets (upcoming events)
        $tiket = DB::table('registrations')
            ->join('events', 'registrations.event_id', '=', 'events.id')
            ->where('registrations.user_id', $user_id)
            ->where('events.tanggal', '>=', now()->toDateString())
            ->select(
                'events.judul',
                'events.tanggal',
                'events.lokasi',
                'registrations.kode_tiket',
                'registrations.nomor_antrian'
            )
            ->orderBy('events.tanggal', 'asc')
            ->get();

        // Past events (riwayat)
        $riwayat = DB::table('registrations')
            ->join('events', 'registrations.event_id', '=', 'events.id')
            ->where('registrations.user_id', $user_id)
            ->where('events.tanggal', '<', now()->toDateString())
            ->select(
                'events.judul',
                'events.tanggal',
                'events.lokasi',
                'registrations.kode_tiket',
                'registrations.nomor_antrian',
                'registrations.status'
            )
            ->orderBy('events.tanggal', 'desc')
            ->get();

        return view('mahasiswa.dashboard', compact('tiket', 'riwayat'));
    }

    public function adminIndex()
    {
        $totalEvent = DB::table('events')->count();
        $totalPeserta = DB::table('registrations')->count();
        $totalUser = DB::table('users')->count();
        $pendingEvents = DB::table('events')->where('status', 'pending')->count();

        // Recent registrations (last 5)
        $recentRegistrations = DB::table('registrations')
            ->join('events', 'registrations.event_id', '=', 'events.id')
            ->join('users', 'registrations.user_id', '=', 'users.id')
            ->select('users.nama', 'events.judul', 'registrations.created_at')
            ->orderBy('registrations.created_at', 'desc')
            ->limit(5)
            ->get();

        // Top events by registration count
        $topEvents = DB::table('registrations')
            ->join('events', 'registrations.event_id', '=', 'events.id')
            ->select('events.judul', DB::raw('COUNT(registrations.id) as total_peserta'), 'events.kuota')
            ->groupBy('events.judul', 'events.kuota')
            ->orderByDesc('total_peserta')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalEvent', 'totalPeserta', 'totalUser', 'pendingEvents',
            'recentRegistrations', 'topEvents'
        ));
    }

    public function penyelenggaraIndex()
    {
        $userId = Session::get('id');
        $totalEvent = DB::table('events')->where('user_id', $userId)->count();
        $totalPeserta = DB::table('registrations')
            ->join('events', 'registrations.event_id', '=', 'events.id')
            ->where('events.user_id', $userId)
            ->count();
        $pendingEvents = DB::table('events')
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        // Per-event stats for Chart.js
        $eventStats = DB::table('events')
            ->leftJoin('registrations', 'events.id', '=', 'registrations.event_id')
            ->where('events.user_id', $userId)
            ->select(
                'events.judul',
                'events.kuota',
                'events.status',
                DB::raw('COUNT(registrations.id) as total_peserta')
            )
            ->groupBy('events.id', 'events.judul', 'events.kuota', 'events.status')
            ->orderBy('events.tanggal', 'desc')
            ->get();

        return view('admin.dashboard-penyelenggara', compact(
            'totalEvent', 'totalPeserta', 'pendingEvents', 'eventStats'
        ));
    }

    public function peserta()
    {
        $role = Session::get('role');
        $query = DB::table('registrations')
            ->join('events', 'registrations.event_id', '=', 'events.id')
            ->join('users', 'registrations.user_id', '=', 'users.id');

        if ($role === 'penyelenggara') {
            $query->where('events.user_id', Session::get('id'));
        }

        $peserta = $query->select(
            'users.nama as name',
            'users.email',
            'events.judul',
            'registrations.kode_tiket',
            'registrations.nomor_antrian',
            'registrations.status'
        )->get();

        return view('admin.peserta', compact('peserta'));
    }
}