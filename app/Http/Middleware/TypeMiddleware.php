<?php

namespace App\Http\Middleware;

use Closure;

class TypeMiddleware
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
        if (request()->hasHeader('type') and request()->header('type') == 2)
        {
            $guard = 'speakers';
        }else
        {
            $guard = 'api';
        }
        auth()->shouldUse($guard);
        return $next($request);
    }
}
