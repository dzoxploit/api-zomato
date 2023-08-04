<?php

namespace App\Http\Middleware;

use Closure;

class ApiVersionMiddleware
{
    public function handle($request, Closure $next, $version = null)
    {
        if ($version) {
            $request->headers->set('Accept', 'application/vnd.myapp.v' . $version . '+json');
        }

        return $next($request);
    }
}
