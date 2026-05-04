<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('auth_user')) {
            return redirect()->route('login');
        }

        if (session('auth_user.role') !== 'customer') {
            abort(403, 'Akses ditolak. Hanya customer yang diizinkan.');
        }

        return $next($request);
    }
}