<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->is_super_admin != 1) {
            abort(403, 'Akses ditolak!');
        }

        return $next($request);
    }
}