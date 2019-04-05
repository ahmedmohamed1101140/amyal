<?php

namespace App\Http\Controllers\Api;

use App\Agent;
use App\Models\Dashboard\Collection;
use App\Models\Dashboard\Finance;
use App\Models\Dashboard\OrderStatus;
use App\Models\Site\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Session;

class ScanController extends Controller
{
    //


    public function updateStatus(Request $request){
        $agent = Agent::findOrFail($request->header('authorization'));
        $type = $agent->type;
        $orders = Order::whereIn('tracking_number',$request->trackingNumber)->get();
        DB::beginTransaction();
        if($request->status == 'Picked Up' && $type == 'Pickup Agent'){
            foreach ($orders as $order){
                try{
                    $this->pickupAgentUpdateStatus($agent,$order,$request->status,$request->message);
                }catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'data' => 'failed',
                        'message' => 'operation failed pleas try again'
                    ]);
                }
            }
        }
        elseif($request->status == 'Returned to shipper' && $type == 'Pickup Agent'){
            foreach ($orders as $order){
                try{
                    $this->pickupAgentUpdateStatus($agent,$order,$request->status,$request->message);

                }catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'data' => 'failed',
                        'message' => 'operation failed pleas try again'
                    ]);
                }
            }
        }
        elseif($request->status == 'Refused' && $type == 'Delivery Agent'){
            foreach ($orders as $order){
                try{
                    $this->deliveryAgentUpdateStatus($agent,$order,$request->status,$request->message);
                }catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'data' => 'failed',
                        'message' => 'operation failed pleas try again'
                    ]);
                }
            }
        }
        elseif($request->status == 'Delivered' && $type == 'Delivery Agent'){
            foreach ($orders as $order){
                try{
                    $this->deliveryAgentUpdateStatus($agent,$order,$request->status,$request->message);
                }catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'data' => 'failed',
                        'message' => 'operation failed pleas try again'
                    ]);
                }
            }
        }
        elseif($request->status == 'Reschedule' && $type == 'Delivery Agent'){
            foreach ($orders as $order){
                try{
                    $this->deliveryAgentUpdateStatus($agent,$order,$request->status,$request->message);
                }catch (\Exception $e) {
                    DB::rollBack();
                    return response()->json([
                        'data' => 'failed',
                        'message' => 'operation failed pleas try again'
                    ]);
                }
            }
        }
        else{
            return response()->json([
                'data' => 'Failed',
                'message' => "Permission denied"
            ]);
        }
        DB::commit();
        return response()->json([
            'data' => 'success',
            'message' => count($orders).' Order updated successfully'
        ]);
    }

    public function pickupAgentUpdateStatus($agent,$order,$status,$message){
        if($status=='Returned to shipper'){
            $this->registerStatus($agent,$status,$order,$message, $message);
        }
        else{
            $this->registerStatus($agent,$status,$order,'By '.$agent->name, 'By '.$agent->name);
        }
        $order->status = $status;
        $order->agent_id = $agent->id;
        $order->office_id = $agent->office->id;
        $order->pickup_date = Carbon::now();
        $order->save();
        if($status == 'Returned to shipper') {
            $this->addFinance($order, $status);
        }
        return true;
    }

    public function deliveryAgentUpdateStatus($agent,$order,$status,$message){
        $this->registerStatus($agent,$status,$order,$message, $message);
        $order->status = $status;
        $order->agent_id = $agent->id;
        $order->office_id = $agent->office->id;
        $order->save();
        if($status == 'Delivered') {
            $this->addUpperFinance($order, $status);
            $this->addCollection($order,$agent);
        }
        return true;
    }

    public function addUpperFinance($order, $status){
        $data['order_id'] = $order->id;
        $data['user_id'] = $order->user->id;
        $data['cod'] = $order->cod;
        $data['shipping_fees'] = $order->shipping_fees;
        $data['remains'] = $order->cod - $order->shipping_fees;
        $data['status'] = 'Unpaid';
        $data['order_status'] = $status;
        Finance::create($data);
        return true;
    }

    public function addFinance($order, $status){
        $data['order_id'] = $order->id;
        $data['user_id'] = $order->user->id;
        $data['cod'] = 0;
        $data['shipping_fees'] = $order->shipping_fees;
        $data['remains'] = $data['cod'] - $order->shipping_fees;
        $data['status'] = 'Unpaid';
        $data['order_status'] = $status;
        Finance::create($data);
        return true;
    }

    public function addCollection($order,$agent){
        $data['order_id'] = $order->id;
        $data['agent_id'] = $agent->id;
        $data['office_id'] = $agent->office_id;
        $data['cod'] = $order->cod;
        Collection::create($data);
        return true;
    }

    public function registerStatus($agent , $status, $order,$agentsMessage,$clientMessage){
        $data['order_id'] = $order->id;
        $data['order_id'] = $order->id;
        $data['status_from'] = $order->status;
        $data['status_to'] = $status;
        $data['agent_id'] = $agent->id;
        $data['agent_additional_info'] = $agentsMessage;
        $data['client_additional_info'] = $clientMessage;
        OrderStatus::create($data);
        return true;
    }

}
