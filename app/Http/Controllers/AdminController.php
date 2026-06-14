<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    // ========== KELOLA USER ==========

    public function userIndex()
    {
        $users = DB::table('users')->orderBy('created_at', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,penyelenggara,mahasiswa',
        ], [
            'email.unique' => 'Email ini sudah digunakan.',
            'password.min' => 'Password minimal 6 karakter.'
        ]);

        DB::table('users')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'no_hp' => $request->no_hp,
            'foto' => 'default.png',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect('/admin/users')->with('success', 'User berhasil ditambahkan!');
    }

    public function userEdit($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) {
            abort(404);
        }
        return view('admin.users.edit', compact('user'));
    }

    public function userUpdate(Request $request, $id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) {
            abort(404);
        }

        $data = [
            'nama'       => $request->nama,
            'email'      => $request->email,
            'role'       => $request->role,
            'nim'        => $request->nim,
            'prodi'      => $request->prodi,
            'no_hp'      => $request->no_hp,
            'updated_at' => now(),
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('users')->where('id', $id)->update($data);
        return redirect('/admin/users')->with('success', 'User berhasil diperbarui!');
    }

    public function userDestroy($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        if (!$user) {
            abort(404);
        }

        // Prevent deleting self
        if ($user->id == Session::get('id')) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Delete related registrations
        DB::table('registrations')->where('user_id', $id)->delete();
        DB::table('users')->where('id', $id)->delete();

        return redirect('/admin/users')->with('success', 'User berhasil dihapus!');
    }

    // ========== KELOLA KATEGORI ==========

    public function categoryIndex()
    {
        $categories = DB::table('categories')->orderBy('id', 'asc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        DB::table('categories')->insert([
            'nama'       => $request->nama,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin/categories')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function categoryUpdate(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        DB::table('categories')->where('id', $id)->update([
            'nama'       => $request->nama,
            'updated_at' => now(),
        ]);

        return redirect('/admin/categories')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function categoryDestroy($id)
    {
        // Check if category is used by events
        $eventCount = DB::table('events')->where('category_id', $id)->count();
        if ($eventCount > 0) {
            return back()->with('error', "Kategori tidak bisa dihapus karena masih digunakan oleh {$eventCount} event.");
        }

        DB::table('categories')->where('id', $id)->delete();
        return redirect('/admin/categories')->with('success', 'Kategori berhasil dihapus!');
    }

    // ========== VERIFIKASI EVENT ==========

    public function verifyIndex()
    {
        $pendingEvents = DB::table('events')
            ->join('users', 'events.user_id', '=', 'users.id')
            ->where('events.status', 'pending')
            ->select('events.*', 'users.nama as creator_name')
            ->orderBy('events.created_at', 'desc')
            ->get();

        $recentVerified = DB::table('events')
            ->join('users', 'events.user_id', '=', 'users.id')
            ->whereIn('events.status', ['published', 'rejected'])
            ->select('events.*', 'users.nama as creator_name')
            ->orderBy('events.updated_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.verify.index', compact('pendingEvents', 'recentVerified'));
    }

    public function verifyApprove($id)
    {
        DB::table('events')->where('id', $id)->update([
            'status'     => 'published',
            'updated_at' => now(),
        ]);

        return redirect('/admin/verify')->with('success', 'Event berhasil disetujui dan dipublikasikan!');
    }

    public function verifyReject($id)
    {
        DB::table('events')->where('id', $id)->update([
            'status'     => 'rejected',
            'updated_at' => now(),
        ]);

        return redirect('/admin/verify')->with('success', 'Event ditolak.');
    }

    // ========== LAPORAN ==========

    public function laporan()
    {
        // Summary stats
        $totalUsers       = DB::table('users')->count();
        $totalMahasiswa   = DB::table('users')->where('role', 'mahasiswa')->count();
        $totalPenyelenggara = DB::table('users')->where('role', 'penyelenggara')->count();
        $totalEvents      = DB::table('events')->count();
        $totalPublished   = DB::table('events')->where('status', 'published')->count();
        $totalPending     = DB::table('events')->where('status', 'pending')->count();
        $totalRegistrations = DB::table('registrations')->count();

        // Registrations per event (top 10)
        $regPerEvent = DB::table('registrations')
            ->join('events', 'registrations.event_id', '=', 'events.id')
            ->select('events.judul', DB::raw('COUNT(registrations.id) as total'))
            ->groupBy('events.judul')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Events per category
        $eventsPerCategory = DB::table('events')
            ->join('categories', 'events.category_id', '=', 'categories.id')
            ->select('categories.nama', DB::raw('COUNT(events.id) as total'))
            ->groupBy('categories.nama')
            ->get();

        // Registrations per month (last 6 months)
        $regPerMonth = DB::table('registrations')
            ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan"), DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        return view('admin.laporan.index', compact(
            'totalUsers', 'totalMahasiswa', 'totalPenyelenggara',
            'totalEvents', 'totalPublished', 'totalPending',
            'totalRegistrations', 'regPerEvent', 'eventsPerCategory', 'regPerMonth'
        ));
    }
}