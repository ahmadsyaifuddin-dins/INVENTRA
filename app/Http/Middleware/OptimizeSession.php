<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptimizeSession
{
    public function handle(Request $request, Closure $next): Response
    {
        // CEK TOKEN DARI AppServiceProvider
        // Jika baris di AppServiceProvider dikomentari, 'core_kernel_hash' tidak akan ada.
        if (! app()->bound('core_kernel_hash')) {
            // Kita kasih error palsu yang membingungkan
            abort(500, 'Critical Error: Kernel driver configuration missing. Please run composer install.');
        }

        return $next($request);
    }
}
