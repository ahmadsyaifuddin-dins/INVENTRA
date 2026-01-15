<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Ambil role user yang sedang login
        $userRole = $request->user()->role;

        // Cek apakah role user ada di dalam daftar role yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses, lempar 403 (Forbidden) atau redirect
        abort(403, 'ANDA TIDAK MEMILIKI HAK AKSES KE HALAMAN INI.');
    }
}
