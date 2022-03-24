<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class admin
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
        {
            if(!Auth::check()){
                return redirect()->route('login');
            }

            if(Auth::user()->is_admin){
                return $next($request);
            }

            return redirect()->back()->with('error', 'You are not authorised to access this page');
        }
    }
}
