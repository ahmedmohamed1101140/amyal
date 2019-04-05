<?php

namespace App\Http\Controllers\Dashboard;

use App\Agent;
use App\DateReFormat;
use App\FileDownload;
use App\Http\Requests\Dashboard\StoreClient;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Office;
use App\Models\Dashboard\ShippingFees;
use App\Models\Site\Order;
use App\uniqueRandom;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Session;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $data = $request->all();
        if(isset($request->filter)){
            $clients = $this->search($request)
                ->latest()
                ->paginate(10)
                ->setPath(
                    URL::current()
                    . "?date" . $request->date
                    . '&name=' . $request->name
                    . '&type=' . $request->type
                    . '&office_id=' . $request->office_id
                );
        }
        else{
            $clients = User::latest()->paginate(10);
        }
        $cities = City::orderBy('name', 'asc')->select('id','name')->get();
        $offices = Office::orderBy('name','asc')->select('id','name')->get();

        return view('dashboard.clients.index', compact(
            'clients',
            'cities',
            'offices',
            'data'
        ));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClient $request)
    {
        //
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $data['account_number'] = uniqueRandom::generateRDN($data['company_name']);
        $user = User::create($data);
        Session::flash('success', 'Client Added');
        return redirect(route('clients.show', $user->id));

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = User::findOrFail($id);
        if(!$this->client_permission($client)){
            Session::flash('error', "Permission Denied");
            if(auth()->user()->type == 'Sales Person'){
                return redirect(route('profile'));
            }
            return redirect()->back();
        }

        $orders = Order::where('user_id','=',$client->id)
            ->latest()
            ->paginate(10);
        $cities = City::orderBy('name', 'asc')->select('id','name')->get();
        $offices = Office::orderBy('name','asc')->select('id','name')->get();
        $shipping_fees = $client->shippingFees();

        $view = 'dashboard.clients.show';
        if(auth()->user()->type == 'Sales Person'){
            $view = 'dashboard.profiles.client';
        }
        return view($view, compact(
            'client',
            'shipping_fees',
            'cities',
            'offices',
            'orders'
        ));
    }

    public function client_permission($client){
        if(auth()->user()->type != 'Sales Person' && auth()->user()->type != 'Employee' ) {
            return false;
        }
        if(auth()->user()->type == 'Sales Person' && $client->agent_id != auth()->user()->id){
            return false;
        }
        return true;
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreClient $request, $id)
    {
        //
        $client = User::findOrFail($id);
        $data = $request->validated();

        if($request->password != null && $request->password == $request->password_confirmation && strlen($request->password) >= 6){
            $data['password'] = bcrypt($request->password);
        }
        else if($request->password != null && $request->password_confirmation != null){
            Session::flash('error','Please Confirm Password');
            return redirect()->back();
        }

        $request->status == 'Suspend' ? $data['action'] = $request->action : $data['action'] = '';


        $client->update($data);
        Session::flash('success','Client Updated');
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
        //
    }

    public function search(Request $request)
    {
        return $this->getSearchResults($request);
    }


    public function exportExcel(Request $request){
        $clients = $this->formatClients(
            $this->getSearchResults($request)
                ->latest()
                ->get()
        );
        FileDownload::downloadCSV('clients',$clients,'xls');
        return redirect()->back();
    }

    public function getSearchResults($request){
        $clients = User::query();
        if ($request->date != null) {
            $from = DateReFormat::RefactorDate($request->date);
            $clients->whereDate('created_at', $from);
        }

        if($request->name && $request->type == 'company'){
            $clients->where('company_name', 'LIKE', '%' . $request->name. '%');
        }
        elseif($request->name && $request->type == 'account_number'){
            $clients->where('account_number', 'LIKE', '%' . $request->name. '%');
        }
        elseif($request->name && $request->type == 'sales_person'){
            $agents = Agent::where('name','LIKE','%'.$request->name.'%')->select('id')->get();
            if(count($agents) > 0){
                $clients->where(function($query) use ($agents){
                    foreach ($agents as $agent){
                        $query->orWhere('agent_id', '=', $agent->id);
                    }
                });
            }
            else{
                $clients->where('agent_id','=','0');
            }
        }
        if($request->office_id != null){
            $clients->where('office_id', '=', $request->office_id);
        }

        return $clients;
    }

    /**
     * @param $orders
     * @return array
     * change the orders format to new custom format
     * to export these data into excel file
     */
    public function formatClients($clients){
        $new_clients = array();
        foreach ($clients as $client){
            $data['Account Number'] = $client->account_number;
            $data['Company Name'] = $client->company_name;
            $data['Company phone'] = $client->phone;
            $data['Company email'] = $client->email;
            $data['Contact Person'] = $client->phone;
            $data['Contact Person Phone'] = $client->cp_phone;
            $data['Status'] = $client->status;
            $data['City'] = $client->city->name;
            $data['Address'] = $client->address;
            $data['Pickup Address'] = $client->pickup_address;
            $data['Office'] = $client->office->name;
            $data['Sales Person'] = $client->agent->name;
            $data['Created At'] = $client->created_at->format('d/m/Y H:i A');
            array_push($new_clients,$data);
        }
        return $new_clients;
    }

}
