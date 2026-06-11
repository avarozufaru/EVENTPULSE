<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckPenyelenggara
{
    public function handle(Request $request, Closure $next)
    {
        $role = Session::get('role');
        if ($role !== 'penyelenggara') {
            if ($role === 'admin') {
                return redirect('/admin/dashboard')->with('error', 'Halaman ini khusus untuk Penyelenggara.');
            }
            return redirect('/dashboard')->with('error', 'Halaman ini khusus untuk Penyelenggara.');
        }
        return $next($request);
    }
}
