<?php

namespace App\Http\Controllers\Site;

use App\Models\Site\PickupRequest;
use App\Http\Controllers\Controller;
use App\uniqueRandom;
use Carbon\Carbon;

class PickupRequestController extends Controller
{
    //
    public function createPickupRequest(){

        $time  = Carbon::now()->format('H:i A');
        if($time <=  Carbon::parse('today 9am')->format('H:i A') || $time >= Carbon::parse('today 6pm')->format('H:i A')){
            return response()->json([
                'data' => false,
            ]);
        }

        $pickupRequests = PickupRequest::where('user_id','=',auth()->user()->id)->latest()->first();
        if($pickupRequests != null){
            if($pickupRequests->created_at->format('d/m/Y') == Carbon::now()->format('d/m/Y')){
                return response()->json([
                    'data' => 'oldValue',
                    'message' => $pickupRequests->req_number
                ]);
            }
        }

        $data['user_id'] = auth()->user()->id;
        $pickup = PickupRequest::create($data);

        try_again:
        $req_number = uniqueRandom::generateRND($pickup->id);
        $requests = PickupRequest::where('req_number','=',$req_number)->count();
        if($requests > 0){
            goto try_again;
        }
        $pickup->req_number = $req_number;
        $pickup->save();
        $data['req_number'] = $pickup->req_number;
        return response()->json($data['req_number']);
    }
}
