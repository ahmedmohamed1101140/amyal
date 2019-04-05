<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class FirstLogin
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
        if(Auth::check()){
            if(auth()->user()->first_login == 0){
                Session::flash('reset');
                return redirect('/');
            }
        }
        return $next($request);
    }
}
