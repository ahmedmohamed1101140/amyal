<?php

namespace App\Http\Controllers\Dashboard;

use App\FileDownload;
use App\Models\Site\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class DeliveryAgentController extends Controller
{
    //

    public function exportMyOrders(){
        if(auth()->user()->type != 'Delivery Agent'){
            Session::flash('error', "Permission Denied");
            return redirect()->back();
        }
        $orders = Order::where('delivery_agent_id','=', auth()->user()->id)
            ->latest();
        if(count($orders->get()) == 0){
            Session::flash('error', "You don't have any order in your profile");
            return redirect()->back();
        }

        $orders = $this->format_orders(
            $orders->distinct()->get()
        );

        FileDownload::downloadCSV('orders',$orders,'csv');
        return redirect()->back();
    }

    //change the orders format to new custom format
    //to export these data into excel file
    public function format_orders($orders){
        $new_orders = array();
        foreach ($orders as $order){
            $data['user'] = $order->user->company_name;
            $data['Tracking Number'] = $order->tracking_number;
            $data['Receiver Name'] = $order->receiver_name;
            $data['Mobile'] = $order->mobile;
            $data['City'] = $order->city->name;
            $data['Area'] = $order->area->name;
            $data['Address'] = $order->address;
            $data['Markup Place'] = $order->mark_place;
            array_push($new_orders,$data);
        }
        return $new_orders;
    }



}
