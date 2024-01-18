<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureJsonRequest
{
    public function handle($request, Closure $next)
    {
        if ($request->header('Content-Type') !== 'application/json') {
            return response(['error' => 'Invalid Content-Type. Only application/json is allowed.'], 400);
        }

        return $next($request);
    }
}
