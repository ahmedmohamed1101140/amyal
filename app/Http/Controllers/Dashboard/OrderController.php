<?php

namespace App\Http\Controllers\Dashboard;

use App\Agent;
use App\DateReFormat;
use App\FileDownload;
use App\Http\Requests\Dashboard\StoreOrder;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Office;
use App\Models\Site\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->filter != null)
            return $this->search($request);
        $offices = Office::select('id','name')->get();
        $orders = Order::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.orders.index',compact('offices','orders'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        $statuses = $order->order_statuses()->paginate(5);
        return view('dashboard.orders.show',compact('order','statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $order = Order::findOrFail($id);
        if($order->status == 'Delivered' || $order->status == 'Returned to shipper'){
            Session::flash('error',"Order Reach the status ".$order->status. " it's not editable anymore");
            return redirect()->back();
        }
        $cities = City::all();
        return view('dashboard.orders.edit',compact('order','cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrder $request, $id)
    {
        //
        $date = $request->validated();
        $order = Order::findOrFail($id);
        if($order->status == 'Delivered' || $order->status == 'Returned to shipper'){
            Session::flash('error',"Order Reach the status ".$order->status. " it's not editable anymore");
            return redirect()->back();
        }
        if($order->shipping_fees != $request->shipping_fees){
            $order->shipping_fees_updated = 1;
        }
        $order->update($date);
        Session::flash('success','Order Updated');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Order::findOrFail($id)->delete();
        Session::flash('success',"Order Deleted Successfully");
        return redirect(route('shipments.index'));
    }

    public function search(Request $request){
        $orders = $this->get_search_result($request)
            ->latest()
            ->paginate(10)
            ->setPath(
                URL::current()
                ."?pickupFrom".$request->pickupFrom
                .'&pickupTo='.$request->pickupTo
                .'&updateFrom='.$request->updateFrom
                .'&updateTo='.$request->updateTo
                .'&office_id='.$request->office_id
                .'&agent_id='.$request->agent_id
                .'&status='.$request->status
                .'&mobile='.$request->mobile
                .'&tracking_number='.$request->tracking_number
                .'&account_number='.$request->account_number
            );


        $data = $request->all();
        $offices = Office::select('id','name')->get();
        return view('dashboard.orders.index',compact('offices','orders','data'));

    }

    //this function responsible for printing all orders in pdf file
    public function printPolicy($id){
        $order = Order::findOrFail($id);
        return FileDownload::printPolicy('dashboard.orders.orderPolicy',$order,'report.pdf');
    }

    public function exportExcel(Request $request){
        $orders = $this->format_orders(
            $this->get_search_result($request)
                ->latest()
                ->get()
        );
        FileDownload::downloadCSV('orders',$orders,'xls');
        return redirect()->back();
    }

    public function printAll(Request $request){
        $orders = $this->get_search_result($request)->latest()->get();
        return FileDownload::downloadPDF('site.orders.table_pdf',$orders,'orders.pdf');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * return pdf file with the policy data
     */
    public function print_policy(Request $request)
    {
        if ($request->orders_id == null) {
            Session::flash('error', 'Noting Selected, Please Select orders you want to print');
            return redirect()->back();
        }
        if($request->all_orders == 'on' && $request->search != '[]'){
            $orders = $this->get_search_result(json_decode($request->search))
                ->latest()
                ->get();
        }
        elseif ($request->all_orders == 'on' ){
            $orders = Order::latest()
                ->get();
        }
        else{
            $orders = Order::query();
            $orders = $orders->whereIn('id', $request->orders_id)
                ->latest()
                ->get();
        }
        return FileDownload::downloadPDF('dashboard.orders.policy', $orders, 'report.pdf');
    }


    /**
     * @param $request
     * @return $this|\Illuminate\Database\Eloquent\Builder
     * return the orders
     */
    public function get_search_result($request){
        $orders = Order::query();
        if ($request->pickupFrom != null && $request->pickupTo != null) {
            $from = DateReFormat::RefactorDate($request->pickupFrom);
            $to = DateReFormat::RefactorDate($request->pickupTo);

            $orders->whereDate('pickup_date','>=',$from)->whereDate('created_at','<=',$to);
        }

        if ($request->updateFrom != null && $request->updateTo != null) {
            $from = DateReFormat::RefactorDate($request->updateFrom);
            $to = DateReFormat::RefactorDate($request->updateTo);
            $orders->whereDate('updated_at','>=',$from)->whereDate('updated_at','<=',$to);
        }

        if($request->office_id){
            $orders = $orders->where('office_id','=',$request->office_id);
        }

        if($request->agent_id){
            $orders = $orders->where('agent_id','=',$request->agent_id);
        }

        if($request->status){
            $orders = $orders->where('status','=',$request->status);
        }

        if($request->mobile){
            $orders = $orders->where('mobile','=',$request->mobile);
        }

        if($request->tracking_number){
            $orders = $orders->where('tracking_number','=',$request->tracking_number);
        }

        if($request->account_number){
            $clients = User::where('account_number','=',$request->account_number)->select('id')->get();
            if(count($clients) > 0){
                $orders->where(function($query) use ($clients){
                    foreach ($clients as $client){
                        $query->orWhere('user_id', '=', $client->id);
                    }
                });
            }
            else{
                $orders->where('user_id','=','0');
            }
        }

        return $orders;
    }

    /**
     * @param $orders
     * @return array
     * change the orders format to new custom format
     * to export these data into excel file
     */
    public function format_orders($orders){
        $new_orders = array();
        foreach ($orders as $order){
            $data['Company Name'] = $order->user->company_name;
            $data['Account Number'] = $order->user->account_number;
            $data['Tracking Number'] = $order->tracking_number;
            $data['Item'] = $order->description;
            $data['Receiver Name'] = $order->receiver_name;
            $data['System User'] = $order->agent != null ? $order->agent->name : '---';
            $data['Office'] = $order->office != null ? $order->office->name : '----';
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
}
