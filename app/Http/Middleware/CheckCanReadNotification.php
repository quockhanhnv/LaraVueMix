<?php

namespace App\Http\Middleware;

use Closure;

class CheckCanReadNotification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->canReadNotification()) {
            return $next($request);
        }

        return response()->json([
            "forbidden" => 'forbidden'
        ], 403);
    }
}
