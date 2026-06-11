<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('register');
    }

    public function storeRegister(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nim' => 'required|unique:users,nim',
            'prodi' => 'required',
            'no_hp' => 'required',
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau login.',
            'nim.unique' => 'NIM ini sudah terdaftar.',
            'password.min' => 'Password minimal 6 karakter.'
        ]);

        DB::table('users')->insert([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'no_hp' => $request->no_hp,
            'foto' => 'default.png',
            'role' => 'mahasiswa',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    public function processLogin(Request $request)
    {
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah');
        }

        // Jika role tab dipilih (mahasiswa/penyelenggara), validasi strict
        $selectedTab = $request->input('role');
        if ($selectedTab === 'mahasiswa' && $user->role !== 'mahasiswa') {
            return back()->with('error', 'Akun ini bukan akun Mahasiswa.');
        }
        if ($selectedTab === 'penyelenggara' && $user->role !== 'penyelenggara') {
            return back()->with('error', 'Akun ini bukan akun Penyelenggara.');
        }

        Session::put('id', $user->id);
        Session::put('nama', $user->nama);
        Session::put('role', $user->role);

        // Redirect sesuai role
        if ($user->role === 'penyelenggara') {
            return redirect('/penyelenggara/dashboard');
        }

        return redirect('/dashboard');
    }

    public function adminLogin()
    {
        return view('admin.login');
    }

    public function processAdminLogin(Request $request)
    {
        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Password salah');
        }

        if ($user->role !== 'admin') {
            return back()->with('error', 'Akun ini bukan akun Admin.');
        }

        Session::put('id', $user->id);
        Session::put('nama', $user->nama);
        Session::put('role', $user->role);

        return redirect('/admin/dashboard')->with('success', 'Selamat Datang Admin!');
    }

    public function logout()
    {
        Session::flush();
        return redirect('/login');
    }
}