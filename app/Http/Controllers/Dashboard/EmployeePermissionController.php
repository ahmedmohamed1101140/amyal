<?php

namespace App\Http\Controllers\Dashboard;

use App\Agent;
use App\Http\Requests\Dashboard\StoreRole;
use App\Http\Controllers\Controller;
use Session;

class EmployeePermissionController extends Controller
{
    //
    public function assignPermission(StoreRole $request){
        $agent = Agent::findOrFail($request->agent_id);
        $agent->permissions()->sync($request->permission,true);
        Session::flash('success','Permissions Assigned Successfully');
        return redirect()->back();
    }
}
