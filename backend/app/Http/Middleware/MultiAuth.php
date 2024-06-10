<?php
 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MultiAuth
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
        if (Auth::guard('api')->check()) {
            Auth::shouldUse('api');
        } elseif (Auth::guard('admin')->check()) {
            Auth::shouldUse('admin');
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
