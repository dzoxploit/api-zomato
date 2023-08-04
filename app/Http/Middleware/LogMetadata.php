<?php
// app/Http/Middleware/LogMetadata.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogMetadata
{
    public function handle($request, Closure $next)
    {
        $metadata = [
            'body' => $request->all(),
            'ip' => $request->ip(),
            'headers' => $request->header(),
        ];

        Log::info('API Request Metadata', $metadata);

        return $next($request);
    }
}
