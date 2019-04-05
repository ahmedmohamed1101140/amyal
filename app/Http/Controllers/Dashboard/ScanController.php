<?php

namespace App\Http\Controllers\Dashboard;

use App\Agent;
use App\Http\Requests\Dashboard\ScannerRequest;
use App\Models\Dashboard\Collection;
use App\Models\Dashboard\Finance;
use App\Models\Dashboard\Office;
use App\Models\Dashboard\OrderStatus;
use App\Models\Site\Order;
use Illuminate\Support\Facades\DB;
use Session;
use Dompdf\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScanController extends Controller
{
    //
    public function index(){
        $offices = Office::where('id','!=',auth()->user()->office_id)
            ->select('id','name')
            ->get();
        $pickupAgents = Agent::where('office_id','=',auth()->user()->office_id)
            ->where('type','=','Pickup Agent')
            ->select('id','name')
            ->get();
        $deliveryAgents = Agent::where('office_id','=',auth()->user()->office_id)
            ->where('type','=','Delivery Agent')
            ->select('id','name')
            ->get();


        return view('dashboard.scanners.index',compact('offices','data','pickupAgents','deliveryAgents'));
    }

    /*
     * all tracking numbers will be validated in the validator
     * find all orders and change it's status
     * record the past and the new status into the database
     * return success message with the number of orders had been updated
    */
    public function update(ScannerRequest $request){
        $request['trackingNumber'] = explode(",", $request->trackingNumber);
        $orders = Order::whereIn('tracking_number',$request->trackingNumber)->get();
        if(count($orders) == 0){
            Session::flash('error', "Invalid Tracking number/s no orders found");
            goto end;
        }
        $count = 0;
        try {
            DB::beginTransaction();
            foreach ($orders as $order){
                if($request->status == 'Received'){
                    /*
                     * only change the status to received
                     * log the status
                     * connect the agent with the order
                     * connect the office with the order
                     */
                    $this->registerStatus($request,$order,'---','---');
                    $order->status = $request->status;
                    $order->agent_id = auth()->user()->id;
                    $order->office_id = auth()->user()->office->id;
                    $order->save();
                }
                elseif($request->status == 'Incorrect Phone'){
                    /*
                     * only change the status to received
                     * log the status
                     * connect the agent with the order
                     * connect the office with the order
                     */
                    $this->registerStatus($request,$order,'Waiting for updated phone','Waiting for updated phone');
                    $order->status = $request->status;
                    $order->agent_id = auth()->user()->id;
                    $order->office_id = auth()->user()->office->id;
                    $order->save();
                }
                elseif($request->status == 'Incorrect Address'){
                    /*
                     * only change the status to received
                     * log the status
                     * connect the agent with the order
                     * connect the office with the order
                     */
                    $this->registerStatus($request,$order,'Waiting for updated Address','Waiting for updated Address');
                    $order->status = $request->status;
                    $order->agent_id = auth()->user()->id;
                    $order->office_id = auth()->user()->office->id;
                    $order->save();
                }
                elseif($request->status == 'Out for delivery'){
                    $agent = Agent::select('id','name')->where('type','=','Delivery Agent')->where('id',$request->delivery_id)->first();
                    $this->registerStatus(
                        $request,
                        $order,
                        'With Agent '.$agent->name,
                        'Agent will deliver you the order soon'
                    );
                    $order->status = $request->status;
                    $order->agent_id = auth()->user()->id;
                    $order->office_id = auth()->user()->office->id;
                    $order->delivery_agent_id = $agent->id;
                    $order->save();
                }
                elseif($request->status == 'Transfer To'){
                    /*
                     * find the office
                     * register the new status
                     * change the status
                     */
                    $office = Office::select('name')->where('id',$request->office_id)->first();
                    $this->registerStatus(
                        $request,
                        $order,
                        'From '.auth()->user()->office->name.' to '.$office->name,
                        'From '.auth()->user()->office->name.' to '.$office->name
                    );
                    $order->status = $request->status;
                    $order->agent_id = auth()->user()->id;
                    $order->office_id = auth()->user()->office->id;
                    $order->save();
                }
                elseif($request->status == 'Back to shipper'){
                    $agent = Agent::select('id','name')->where('type','=','Pickup Agent')->where('id',$request->pickup_id)->first();
                    $this->registerStatus(
                        $request,
                        $order,
                        'By Agent '.$agent->name,
                        'Agent will deliver you the order soon'
                    );
                    $order->status = $request->status;
                    $order->agent_id = auth()->user()->id;
                    $order->office_id = auth()->user()->office->id;
                    $order->pickup_agent_id = $agent->id;
                    $order->save();
                }
                $count++;
            }
        }catch (\Exception $e) {
            Session::flash('error', "Sorry, failed to update orders status please try again!");
            DB::rollBack();
            goto end;
        }
        DB::commit();
        Session::flash('success', $count." Orders Status Updated Successfully");
        end:
        return redirect()->back();

    }

    public function registerStatus($request, $order,$agentsMessage,$clientMessage){
        $data['order_id'] = $order->id;
        $data['status_from'] = $order->status;
        $data['status_to'] = $request->status;
        $data['agent_id'] = auth()->user()->id;
        $data['agent_additional_info'] = $agentsMessage;
        $data['client_additional_info'] = $clientMessage;
        OrderStatus::create($data);
        return true;
    }

    public function pickupAgentUpdateStatus(Request $request,$id){
        $order = Order::findOrFail($id);
        $request['status'] = 'Returned to shipper';
        try{
            DB::beginTransaction();
            $this->registerStatus($request,$order,'By '.auth()->user()->name, 'By '.auth()->user()->name);
            $order->status = $request->status;
            $order->agent_id = auth()->user()->id;
            $order->office_id = auth()->user()->office->id;
            $order->save();

            $this->addFinance($order);

        }catch (\Exception $e) {
            Session::flash('error', "Sorry, failed to update orders status please try again!");
            DB::rollBack();
            goto end;
        }
        DB::commit();
        Session::flash('success', "Orders Status Updated Successfully");
        end:
        return redirect()->back();
    }

    public function addFinance($order){
        $data['order_id'] = $order->id;
        $data['user_id'] = $order->user->id;
        $data['cod'] = 0;
        $data['shipping_fees'] = $order->shipping_fees;
        $data['remains'] = $data['cod'] - $order->shipping_fees;
        $data['status'] = 'Unpaid';
        $data['order_status'] = 'Returned to shipper';
        Finance::create($data);
        return true;
    }

    public function addCollection($order){
        $data['order_id'] = $order->id;
        $data['agent_id'] = auth()->user()->id;
        $data['office_id'] = auth()->user()->office_id;
        $data['cod'] = $order->shipping_fees;
        Collection::create($data);
        return true;
    }
}
