<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;

class CheckRefferal
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
        if($request->ref && !Cookie::get('ref')) {
            Cookie::queue(Cookie::make('ref', (int)$request->ref, 60 * 24 * 365 * 100));
        }
        return $next($request);
    }
}
