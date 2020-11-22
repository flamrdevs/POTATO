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
        // role pada controller selain role admin dan farmer maka logout
        if ($role != 'admin' && $role != 'farmer') {
            Auth::logout();
            return redirect()->route('welcome');
        }
        // jika role tidak sama dengan role pada controller
        if (Auth::user()->role != $role) {
            switch (Auth::user()->role) {
                case 'admin':
                    return redirect()->route('admin');
                case 'farmer':
                    return redirect()->route('farmer');
                default:
                    Auth::logout();
                    return redirect()->route('welcome');
            }
        }
        
        return $next($request);
    }
}
