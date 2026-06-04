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
            return redirect('/dashboard');
        }
        return $next($request);
    }
}
