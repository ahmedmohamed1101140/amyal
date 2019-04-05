<?php

namespace App\Http\Controllers\Api;

use App\Agent;
use App\Models\Site\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //
    public function getClientOrders(Request $request){
        $agent = Agent::findOrFail($request->header('authorization'));
        $client = User::where('account_number','=',$request->accountNumber)
            ->where('office_id','=',$agent->office_id)
            ->first();
        if($client && $agent->type = 'Pickup Agent'){
            $orders = Order::select('tracking_number')->where('user_id', '=', $client->id);
            if($request->status == 'Picked Up') {
                $orders = $orders
                    ->where('status', '=', 'Recorded')
                    ->get();
            }
            elseif($request->status == 'Returned to shipper'){
                $orders = $orders
                    ->where('pickup_agent_id', '=', $agent->id)
                    ->where('status', '=', 'Back to shipper')
                    ->get();
            }
            return response()->json([
                'companyName' => $client->company_name,
                'orders' => $orders
            ]);
        }
        else{
            return response()->json([
                'valid' => 'false',
                'message' => 'Incorrect Account Number'
            ]);
        }
    }

    public function getMyOrders(Request $request){
        $agent = Agent::findOrFail($request->header('authorization'));
        if($agent->type = 'Delivery Agent'){
            $orders = Order::select('tracking_number')
                ->where('delivery_agent_id','=',$agent->id)
                ->where('status','=','Out for delivery')
                ->get();
            return $orders;
        }
        else{
            return response()->json([
                'valid' => 'false',
                'message' => 'Permission Denied'
            ]);
        }

    }
}
