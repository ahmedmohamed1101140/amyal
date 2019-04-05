<?php

namespace App\Http\Middleware;

use App\Models\Site\Ticket;
use Closure;

class li_active
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
        view()->share(['li_active'=>$request->url()]);
        view()->share(['support_count'=>Ticket::where('status','!=','Closed')->count()]);
        return $next($request);
    }
}
