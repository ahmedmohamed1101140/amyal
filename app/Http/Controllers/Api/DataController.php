<?php

namespace App\Http\Controllers\Api;

use App\Agent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DataController extends Controller
{
    //
    public function open()
    {
        $data = "This data is open and can be accessed without the client being authenticated";
        return response()->json(compact('data'), 200);

    }

    public function closed()
    {
        $data = "Only authorized users can see this";
        return response()->json(compact('data'), 200);
    }


    public function getStatuses(Request $request)
    {
        $data['PickupStatus'][] = ["name" => "Picked Up", "messageRequired" => false];
        $data['PickupStatus'][] = ["name" => "Returned to shipper", "messageRequired"  => true];

        $data['DeliveryStatus'][] = ["name" => "Refused", "messageRequired" => true];
        $data['DeliveryStatus'][] = ["name" => "Reschedule", "messageRequired" => true];
        $data['DeliveryStatus'][] = ["name" => "Delivered", "messageRequired" => true];


        $agent = Agent::findOrFail($request->header('authorization'));

        if ($agent->type == 'Pickup Agent') {
            return $data['PickupStatus'];
        } elseif ($agent->type == 'Delivery Agent') {
            return $data['DeliveryStatus'];
        }
    }
}
