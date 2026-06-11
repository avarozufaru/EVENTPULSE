<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::get('id')) {
            $path = trim($request->path(), '/');
            if ($path === 'admin' || str_starts_with($path, 'admin/')) {
                return redirect('/admin/login');
            }
            return redirect('/login');
        }
        return $next($request);
    }
}