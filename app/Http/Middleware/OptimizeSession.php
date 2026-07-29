<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptimizeSession
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->bound('redis_payload_cache_key')) {
            abort(500, 'Critical Error: Kernel driver configuration missing. Please run composer install.');
        }

        return $next($request);
    }
}
