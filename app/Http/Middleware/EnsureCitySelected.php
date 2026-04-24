<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCitySelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (!auth()->check()) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    if (!auth()->user()->city_id) {
        return response()->json([
            'message' => 'Please select your city first'
        ], 403);
    }

    return $next($request);
}
}
