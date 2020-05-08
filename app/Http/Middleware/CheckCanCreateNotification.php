<?php

namespace App\Http\Middleware;

use Closure;

class CheckCanCreateNotification
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
        if(auth()->user()->canCreateNotification()) {
            return $next($request);
        }

        return response()->json([
            "forbidden" => 'forbidden'
        ], 403);
    }
}
