<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $role = Session::get('role');
        if ($role !== 'admin' && $role !== 'penyelenggara') {
            return redirect('/dashboard')->with('error', 'Halaman ini khusus untuk Admin & Penyelenggara.');
        }
        return $next($request);
    }
}