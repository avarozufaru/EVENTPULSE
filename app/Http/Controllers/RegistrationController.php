<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;

class RegistrationController extends Controller
{
    public function store($id)
    {
        $user_id = Session::get('id');

        if (!$user_id) {
            return redirect('/login');
        }

        // Ambil data event
        $event = DB::table('events')->where('id', $id)->first();
        if (!$event) {
            abort(404);
        }

        // Cek kuota penuh
        $registeredCount = DB::table('registrations')->where('event_id', $id)->count();
        if ($registeredCount >= $event->kuota) {
            return back()->with('error', 'Pendaftaran gagal, kuota event ini sudah penuh.');
        }

        // Cek apakah sudah pernah daftar
        $cek = DB::table('registrations')
            ->where('event_id', $id)
            ->where('user_id', $user_id)
            ->first();

        if ($cek) {
            return back()->with('error', 'Anda sudah terdaftar pada event ini');
        }

        // Nomor antrian
        $antrian = $registeredCount + 1;

        // Kode tiket
        $kode_tiket = 'EP-' . rand(1000,9999) . '-' . rand(1000,9999);

        DB::table('registrations')->insert([
            'event_id' => $id,
            'user_id' => $user_id,
            'kode_tiket' => $kode_tiket,
            'nomor_antrian' => $antrian,
            'status' => 'terdaftar',
            'created_at' => now()
        ]);

        return redirect('/dashboard')->with('success', 'Pendaftaran event berhasil!');
    }

    public function downloadTicket($kode_tiket)
    {
        $user_id = Session::get('id');
        if (!$user_id) {
            return redirect('/login');
        }

        $registration = DB::table('registrations')
            ->join('events', 'registrations.event_id', '=', 'events.id')
            ->join('users', 'registrations.user_id', '=', 'users.id')
            ->where('registrations.kode_tiket', $kode_tiket)
            ->where(function($query) use ($user_id) {
                if (Session::get('role') === 'mahasiswa') {
                    $query->where('registrations.user_id', $user_id);
                }
            })
            ->select(
                'events.judul',
                'events.tanggal',
                'events.jam_mulai',
                'events.jam_selesai',
                'events.lokasi',
                'users.nama as nama_mhs',
                'users.nim',
                'users.prodi',
                'registrations.kode_tiket',
                'registrations.nomor_antrian',
                'registrations.status',
                'registrations.created_at'
            )
            ->first();

        if (!$registration) {
            abort(404, 'Tiket tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $pdf = Pdf::loadView('ticket.pdf', compact('registration'));
        return $pdf->download('tiket-' . $registration->kode_tiket . '.pdf');
    }
}