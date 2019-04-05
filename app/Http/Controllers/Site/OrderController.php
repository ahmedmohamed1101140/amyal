<?php

namespace App\Http\Controllers\Site;

use App\DateReFormat;
use App\FileDownload;
use App\Http\Requests\Site\StoreOrder;
use App\Models\Dashboard\Area;
use App\Models\Dashboard\City;
use App\Models\Site\Order;
use App\uniqueRandom;
use Carbon\Carbon;
use Dompdf\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Excel;
use Illuminate\Support\Facades\Validator;
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

        $data = $request->all();
        if ($request->filter) {
            $orders = $this->search($request)
                ->latest();
            $total_orders = count($orders->get());
            $total_cod = $orders->sum('cod');
            $orders = $orders->paginate(10)
                ->setPath(
                    URL::current()
                    . "?filter" . $request->filter
                    . '&date_from=' . $request->date_from
                    . '&date_to=' . $request->date_to
                    . '&status=' . $request->status
                    . '&type=' . $request->type
                    . '&search_value=' . $request->search_value
                );
        }
        else{
            $orders = Order::latest()->where('user_id', '=', auth()->user()->id);
            $total_orders = count($orders->get());
            $total_cod = $orders->sum('cod');
            $orders = $orders->paginate(10);
        }



        $clientId = auth()->user()->id;
        $cities = DB::SELECT(
            "
                      SELECT cities.id as city_id , cities.name as city_name
                      FROM `cities` 
                      LEFT JOIN shipping_fees on cities.id = shipping_fees.city_id AND shipping_fees.user_id = $clientId
                  "
        );
        foreach ($cities as $city){
            $areas = Area::orWhere('city_id',$city->city_id)->get();
        }
        return view('site.orders.index', compact('orders','data','cities','areas', 'total_orders', 'total_cod'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->status == 'Suspend') {
            Session::flash('error', 'Your profile is suspended Please contact Amyal support');
            return redirect()->back();
        }
        return view('site.orders.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrder $request)
    {
        if (auth()->user()->status == 'Suspend') {
            Session::flash('error', 'Your profile is suspended Please contact Amyal support');
            return redirect()->back();
        }
        if ($request->hasFile('file-upload1')) {
            return $this->store_from_file($request);
        }
        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;
        $data['shipping_fees'] = auth()->user()->getCityShippingFees($request->city_id);

        try_again:
        $data['tracking_number'] = uniqueRandom::generateRDNTrackingNumber();
        $orders = Order::where('tracking_number','=',$data['tracking_number'])->count();
        if($orders > 0){
            goto try_again;
        }

        $order = Order::create($data);
        Session::flash('success', 'Order Added Successfully');
        return redirect()->back();
    }

    //this function store multiple orders from excel file
    public function store_from_file($request)
    {
        try {
            \Excel::load($request->file('file-upload1'), function ($reader, $count = 2) {
                DB::beginTransaction();
                foreach ($reader->toArray() as $item) {

                    $city = City::where('name', '=', $item['city'])->first();
                    $area = Area::where('name', '=', $item['area'])->first();
                    $item['city'] = '';
                    $item['area'] = '';
                    if($city && auth()->user()->find_city('city_id', $city->id)){$item['city'] = $city->name;}
                    if($area && $city && $area->city->id == $city->id){$item['area'] = $area->name;}

                    $result = $this->validate_file_inputs($item, $count);
                    if ($result->fails() && count($result->errors()->messages()) > 1) {
                        throw new Exception($result->errors());
                    }
                    $count++;
                    $data['user_id'] = auth()->user()->id;
                    $data['description'] = $item['item'];
                    $data['receiver_name'] = $item['receiver_name'];
                    $data['notes'] = $item['notes'];
                    $data['cod'] = $item['cod'];
                    $data['security_number'] = $item['security_number'];
                    $data['city_id'] = $city->id;
                    $data['shipping_fees'] = auth()->user()->getCityShippingFees($city->id);
                    $data['area_id'] = $area->id;
                    $data['address'] = $item['address'];
                    $data['mark_place'] = $item['markup_place'];
                    $data['mobile'] = $item['mobile_num'];

                    try_again:
                    $data['tracking_number'] = uniqueRandom::generateRDNTrackingNumber();
                    $orders = Order::where('tracking_number','=',$data['tracking_number'])->count();
                    if($orders > 0){
                        goto try_again;
                    }
                    Order::create($data);
                }
            });
        } catch (\Exception $e) {
            $e->getCode() == 0 ? $error = json_decode($e->getMessage()) : $error = 'Sorry, failed to add order please try again!';
            DB::rollBack();
            return redirect()->route('orders.create')->withErrors($error);
        }
        DB::commit();
        Session::flash('success', 'Orders Added Successfully');
        return redirect()->back();
    }

    public function validate_file_inputs($item, $count)
    {

        $rules = [
            'error_line' => 'required',
            'receiver_name' => 'required|string|max:190',
            'item' => 'required|string|max:255',
            'mobile_num' => 'required|numeric|digits_between:3,15',
            'address' => 'required|string|max:400',
            'markup_place' => 'required|string|max:400',
            'cod' => 'required|numeric|min:0|max:1000000',
            'security_number' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:255',
            'city' => 'required|string|max:255|exists:cities,name',
            'area' => 'required|string|max:255|exists:areas,name',
        ];
        $messages = [
            'area.required' => 'Selected area not found',
            'city.required' => 'Selected city not found',
            'error_line.required' => 'Upload Field At Row ' . $count,
        ];


        $validator = Validator::make($item, $rules, $messages);
        return $validator;

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);
        if ($order->check_auth()) {
            Session::flash('error', "You Don't Have The Permission For This Action");
            return redirect()->back();
        }
        $statuses = $order->order_statuses()->paginate(5);
        return view('site.orders.show', compact('order','statuses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        if ($order->check_auth() || !$order->editable) {
            Session::flash('error', "You Don't Have The Permission To This Action");
            return redirect()->back();
        }
        if ($order->status == 'Recorded') {
            return view('site.orders.edit', compact('order'));
        }
        Session::flash('error', "This Order Can't Be Editable Any More");
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreOrder $request, $id)
    {
        $order = Order::findOrFail($id);
        if ($order->check_auth() || !$order->editable) {
            Session::flash('error', "You Don't Have The Permission To This Action");
            return redirect()->back();
        }
        if ($order->status == 'Recorded') {
            $order->update($request->validated());
            Session::flash('success', "Order Updated Successfully");
            return redirect()->back();
        }
        Session::flash('error', "This Order Can't Be Editable Any More");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if ($order->check_auth() || !$order->editable) {
            Session::flash('error', "You Don't Have The Permission To This Action");
            return redirect()->back();
        }
        if ($order->status == 'Recorded') {
            $order->delete();
            Session::flash('success', "Order Deleted Successfully");
            return redirect()->back();
        }
        Session::flash('error', "This Order Can't Be Editable Any More");
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * searching function
     */
    public function search(Request $request)
    {
        return $this->get_search_result($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * this function responsible for exporting all client orders in one excel sheet
     */
    public function export_all(Request $request)
    {
        $orders = $this->format_orders(
            $this->get_search_result($request)
                ->latest()
                ->get()
        );
        FileDownload::downloadCSV('orders', $orders, 'xls');
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     * this function responsible for printing all orders in pdf file
     */
    public function endOfDay()
    {
        $orders = Order::where('user_id', '=', auth()->user()->id)
            ->where('status', '=', 'recorded')
            ->latest()
            ->get();

        if (count($orders) == 0) {
            Session::flash('error', "You don't have any order in your profile");
            return redirect()->back();
        }

        try {
            DB::beginTransaction();
            foreach ($orders as $order) {
                $order->editable = 0;
                $order->save();
            }
        } catch (\Exception $e) {
            $e->getMessage();
            DB::rollBack();
            Session::flash('error', 'Fail to Download Please Try Again Later');
            return redirect()->route('orders.create');
        }
        DB::commit();
        return FileDownload::downloadPDF('site.orders.table_pdf', $orders, 'orders.pdf');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * return pdf file with the policy data
     */
    public function print_policy(Request $request)
    {

        if ($request->orders_id == null) {
            Session::flash('error', 'Nothing Selected, Please Select orders you want to print');
            return redirect()->back();
        }
        if($request->all_orders == 'on' && $request->search != '[]'){
            $orders = $this->get_search_result(json_decode($request->search))
                ->latest()
                    ->get();
        }
        elseif ($request->all_orders == 'on' ){
            $orders = Order::where('user_id','=',auth()->user()->id)
                ->latest()
                ->get();
        }
        else{
            $orders = Order::where('user_id','=',auth()->user()->id)
                ->whereIn('id', $request->orders_id)
                ->latest()
                ->get();
        }
        return FileDownload::downloadPDF('site.orders.policy', $orders, 'report.pdf');
    }

    /**
     * @param $request
     * @return $this|\Illuminate\Database\Eloquent\Builder
     * return the orders
     */
    public function get_search_result($request)
    {
        $orders = Order::where('user_id', '=', auth()->user()->id);
        if ($request->date_from != null && $request->date_to != null) {
            $from = DateReFormat::RefactorDate($request->date_from);
            $to = DateReFormat::RefactorDate($request->date_to);
            $orders->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
        }

        if ($request->status) {
            $orders = $orders->where('status', '=', $request->status);
        }

        if ($request->area_id) {
            $orders = $orders->where('area_id', '=', $request->area_id);
        }

        if ($request->city_id) {
            $orders = $orders->where('city_id', '=', $request->city_id);
        }

        if($request->type == 'Receiver Name' && $request->search_value){
            $orders = $orders->where('receiver_name', 'LIKE', '%' . $request->search_value. '%');
        }

        if($request->type == 'Item' && $request->search_value){
            $orders = $orders->where('description', 'LIKE', '%' . $request->search_value. '%');
        }

        if($request->type == 'Mobile' && $request->search_value){
            $orders = $orders->where('Mobile', '=', $request->search_value);
        }

        if($request->type == 'Security Number' && $request->search_value){
            $orders = $orders->where('security_number', '=', $request->search_value);
        }

        if($request->type == 'Tracking Number' && $request->search_value){
            $orders = $orders->where('tracking_number', '=', $request->search_value);
        }

        return $orders;
    }

    /**
     * @param $orders
     * @return array
     * change the orders format to new custom format
     * to export these data into excel file
     */
    public function format_orders($orders)
    {
        $new_orders = array();
        foreach ($orders as $order) {
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
            $data['Notes'] = $order->notes;
            $data['Status'] = $order->status;
            $data['created At'] = $order->created_at->format('d/m/Y H:i A');
            $data['updated At'] = $order->updated_at->format('d/m/Y H:i A');
            array_push($new_orders, $data);
        }
        return $new_orders;
    }
}
