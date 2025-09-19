<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Log;

class ApiLogger
{
    public function handle($request, Closure $next)
    {
        Log::info("API Hit", [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
        ]);
        return $next($request);
    }
}
