<?php

namespace App\Http\Controllers\Api;

use App\Agent;
use App\Models\Site\PickupRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PickupController extends Controller
{
    public function pickupAgentRequests(Request $request){

        $agent = Agent::findOrFail($request->header('authorization'));

        $requests = PickupRequest::where('agent_id','=',$agent->id)
            ->where('status','=','Assign To')
            ->orderBy('id','desc')
            ->get();

        return response()->json($requests);

    }

    public function pickupAgentUpdateRequests(Request $request){
        //find pickup request
        //get agent
        //check agent pickup
        //status == done
        //update request

        $pickupRequest = PickupRequest::findOrFail($request->request_id);
        $agent = Agent::findOrFail($request->header('authorization'));

        if($agent->type == 'Pickup Agent' && $pickupRequest->agent_id == $agent->id && $request->status == 'Done'){
                $pickupRequest->status = 'Done';
                $pickupRequest->save();
            return response()->json([
                'valid' => 'true',
                'message' => 'Request Updated Successfully'
            ]);

        }else{
            return response()->json([
                'valid' => 'false',
                'message' => 'Permission Denied'
            ]);
        }

    }
}
