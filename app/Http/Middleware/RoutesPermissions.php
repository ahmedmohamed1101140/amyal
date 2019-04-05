<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class RoutesPermissions
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
        if(Auth::user()->type == 'Employee' && $request->route()->getName() != 'My.profile'){
            foreach (Auth::user()->permissions as $permission){
                if($permission->route_name == $request->route()->getName()){
                    return $next($request);
                }
            }
            if($this->valid_routes($request)){
                return $next($request);
            }

            Session::flash('error','Permission Denied');
            return redirect(route('My.profile'));
        }
        return $next($request);
    }

    public function valid_routes($request){
        $valid_routes = [
            'cities.show',
            'areas.show',
            'offices.show',
            'departments.show',
            'pickup_requests.show',
            'agent.logout',
            'shipments.edit',
            'supports.getMessages',
            'supports.sendMessages',
            'Dashboard',
            'scanner.update',
        ];

        foreach ($valid_routes as $route){
            if($request->route()->getName() == $route){
                return true;
            }
        }

    }
}
