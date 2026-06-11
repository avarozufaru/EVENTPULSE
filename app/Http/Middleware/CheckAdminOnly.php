<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckAdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $role = Session::get('role');
        if ($role !== 'admin') {
            // Jika yang mengakses adalah penyelenggara, arahkan ke dashboard penyelenggara
            if ($role === 'penyelenggara') {
                return redirect('/penyelenggara/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman Admin.');
            }
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman Admin.');
        }
        return $next($request);
    }
}
