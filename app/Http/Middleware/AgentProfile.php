<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class AgentProfile
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
        if($request->route()->getName() != 'profile') {
            if (auth()->user()->type != 'Employee') {
                if($this->check_pickup_agent_gates($request)){
                    return $next($request);
                }
                if($this->check_sales_person_gates($request)){
                    return $next($request);
                }
                if($this->check_delivery_agent_gates($request)){
                    return $next($request);
                }
                return redirect(route('profile'));
            }
        }
        return $next($request);
    }

    public function check_pickup_agent_gates($request){
        $valid_routes = [
            'pickup_requests.update',
            'agent.logout',
            'pickupScanner.store'
        ];
        if(auth()->user()->type == 'Pickup Agent'){
            foreach ($valid_routes as $route) {
                if($request->route()->getName() == $route) {
                    return true;
                }
            }
        }
        return false;
    }

    public function check_sales_person_gates($request){
        $valid_routes = [
            'clients.show',
            'profile.export',
//            'profile.newCall',
//            'profile.newMeeting',
//            'profile.newAttendance',
            'agent.logout',
            'salesOrder.show',
            'shipments.salesPrintPolicy'
        ];

        if(auth()->user()->type == 'Sales Person'){
            foreach ($valid_routes as $route){
                if($request->route()->getName() == $route){
                    return true;
                }
            }
        }
        return false;
    }


    public function check_delivery_agent_gates($request){
        $valid_routes = [
            'agent.logout',
            'profile.exportMyOrders'
        ];

        if(auth()->user()->type == 'Delivery Agent'){
            foreach ($valid_routes as $route) {
                if($request->route()->getName() == $route) {
                    return true;
                }
            }
        }
        return false;
    }
}
