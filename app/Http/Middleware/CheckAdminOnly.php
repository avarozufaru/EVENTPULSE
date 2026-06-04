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
            return redirect('/dashboard');
        }
        return $next($request);
    }
}
