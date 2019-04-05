<?php

namespace App\Http\Controllers\Dashboard;

use App\FileDownload;
use App\Http\Requests\Dashboard\StoreAttendance;
use App\Http\Requests\Dashboard\StoreCall;
use App\Http\Requests\Dashboard\StoreClient;
use App\Http\Requests\Dashboard\StoreMeeting;
use App\Http\Requests\Dashboard\StoreTarget;
use App\Http\Controllers\Controller;
use App\Models\Dashboard\Attendance;
use App\Models\Dashboard\Call;
use App\Models\Dashboard\Meeting;
use App\Models\Dashboard\Target;
use App\Models\Site\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Session;

class SalesPersonController extends Controller
{
    //
    public function exportOrders($id){
        $client = User::findOrFail($id);
        if($client->agent_id != auth()->user()->id){
            Session::flash('error', "Permission Denied");
            return redirect()->back();
        }
        $orders = $this->format_orders(
            Order::where('user_id','=',$id)
                ->latest()
                ->get()
        );
        FileDownload::downloadCSV('orders',$orders,'xls');
        return redirect()->back();
    }

    public function format_orders($orders){
        $new_orders = array();
        foreach ($orders as $order){
            $data['Company Name'] = $order->user->company_name;
            $data['Account Number'] = $order->user->account_number;
            $data['Tracking Number'] = $order->tracking_number;
            $data['Item'] = $order->description;
            $data['Receiver Name'] = $order->receiver_name;
            $data['Mobile'] = $order->mobile;
            $data['City'] = $order->city->name;
            $data['Area'] = $order->area->name;
            $data['Address'] = $order->address;
            $data['Markup Place'] = $order->mark_place;
            $data['COD'] = $order->cod;
            $data['Security Number'] = $order->security_number;
            $data['Status'] = $order->status;
            $data['Created At'] = $order->created_at->format('d/m/Y H:i A');
            $data['Updated At'] = $order->updated_at->format('d/m/Y H:i A');
            array_push($new_orders,$data);
        }
        return $new_orders;
    }


    public function storeCall(StoreCall $request){
        $data = $request->except('_token');
        $data['agent_id'] = auth()->user()->id;
        Call::create($data);
        Session::flash('success', "Call Added Successfully");
        return redirect()->back();
    }

    public function storeMeeting(StoreMeeting $request){
        $data = $request->except('_token');
        $data['agent_id'] = auth()->user()->id;
        Meeting::create($data);
        Session::flash('success', "Meeting Added Successfully");
        return redirect()->back();

    }

    public function storeTarget(StoreTarget $request){
        try{
            DB::beginTransaction();
            $data['agent_id'] = auth()->user()->id;
            for($i = 0; $i < count($request->name); $i++){
                $data['name'] = $request->name[$i];
                $data['max'] = $request->max[$i];
                $data['percent'] = $request->percent[$i];
                Target::created($data);
            }
        }
        catch (\Exception $e){
            $e->getMessage();
            DB::rollBack();
            Session::flash('error', 'Sorry Failed To Add Your Targets Please Try Again');
            return redirect()->back();
        }
        DB::commit();
        Session::flash('success', "Target Added Successfully");
        return redirect()->back();

    }

    public function storeAttendance(StoreAttendance $request){
        $data = $request->except('_token');
        $data['agent_id'] = auth()->user()->id;
        $data['day'] = Carbon::now()->format('d/m/Y');
        Attendance::create($data);
        Session::flash('success', "Attendance Added Successfully");
        return redirect()->back();
    }

    public function displayOrder($id){
        $order = Order::findOrFail($id);
        if($order->user->agent_id == auth()->user()->id){
            $statuses = $order->order_statuses()->paginate(5);
            return view('dashboard.profiles.orderShow',compact('order','statuses'));
        }
        Session::flash('error', "You don't have the permission for this action");
        return redirect()->back();
    }

    //this function responsible for printing all orders in pdf file
    public function printPolicy($id){
        $order = Order::findOrFail($id);
        if($order->user->agent_id == auth()->user()->id) {
            return FileDownload::printPolicy('dashboard.orders.orderPolicy',$order,'report.pdf');
        }
        Session::flash('error', "You don't have the permission for this action");
        return redirect()->back();
    }

}
