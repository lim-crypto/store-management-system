<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUser
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

        if (Auth::check()) {
            if (auth()->user()->is_admin == 1) {
                return  redirect()->route('admin.home');
            }
            if (auth()->user()->is_active == 0) {
                auth()->logout();
                return redirect()->route('login')->with('error', 'Sorry your account is deactivated.');
            }
        }

        return $next($request);
    }
}
