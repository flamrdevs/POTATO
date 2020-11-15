<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // redirect to current role
        if (Auth::user()->role != $role) {
            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin');
            }
            if (Auth::user()->role == 'farmer') {
                return redirect()->route('farmer');
            }
            Auth::logout();
            return redirect()->route('welcome');
        }
        
        return $next($request);
    }
}
