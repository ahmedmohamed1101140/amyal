<?php

namespace App\Http\Controllers\Dashboard;

use App\Agent;

use App\FileDownload;
use App\FileUpload;
use App\Http\Requests\Dashboard\StoreEmployee;
use App\Http\Requests\Dashboard\StoreRole;
use App\Models\Dashboard\City;
use App\Models\Dashboard\Department;
use App\Models\Dashboard\Office;
use App\Models\Dashboard\Position;
use App\Models\Site\Order;
use App\Models\Site\PickupRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Session;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        if (isset($request->filter)) {
            $agents = $this->search($request)->latest()
                ->paginate(10)
                ->setPath(
                    URL::current()
                    . "?filter" . $request->filter
                    . '&name=' . $request->name
                    . '&phone=' . $request->phone
                    . '&department_id=' . $request->department_id
                    . '&office_id=' . $request->office_id
                    . '&type=' . $request->type
                );
        }
        else{
            $agents = Agent::latest()->paginate(10);
        }

        $departments = Department::orderBy('name', 'asc')->select('id','name')->get();
        $cities = City::orderBy('name', 'asc')->select('id','name')->get();
        $offices = Office::orderBy('name', 'asc')->select('id','name')->get();

        return view('dashboard.employees.index', compact(
            'agents',
            'departments',
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
    public function store(StoreEmployee $request)
    {
        //
        $data = $request->validated();
        $data['ssn'] = $request->GOV_number;
        $data['password'] = bcrypt($request->password);
        $data['join_date'] = Carbon::createFromFormat('d/m/Y', $request->join_date);
        $data['age'] = Carbon::createFromFormat('d/m/Y', $request->age);
        $data['image'] = FileUpload::upload($request->file('image'), '/storage/images/agent/');;

        Agent::create($data);
        Session::flash('success', 'Employee Added');
        return redirect(route('employees.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agent = Agent::findOrFail($id);
        $departments = Department::orderBy('name', 'asc')->select('id','name')->get();
        $cities = City::orderBy('name', 'asc')->select('id','name')->get();
        $offices = Office::orderBy('name', 'asc')->select('id','name')->get();
        return $this->redirect_to_profile($agent, $departments, $cities, $offices);

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
    public function update(StoreEmployee $request, $id)
    {
        //
        $agent = Agent::findOrFail($id);
        $data = $request->validated();
        $data['join_date'] = Carbon::createFromFormat('d/m/Y', $request->join_date);
        $data['age'] = Carbon::createFromFormat('d/m/Y', $request->age);
        $data['ssn'] = $request->GOV_number;

        if($request->password != null && $request->password == $request->password_confirmation && strlen($request->password) >= 6){
            $data['password'] = bcrypt($request->password);
        } else if ($request->password != null && $request->password_confirmation != null) {
            Session::flash('error', 'Please Confirm Password');
            return redirect()->back();
        }

        if ($request->file('image')) {
            FileUpload::delete_image($agent->image, '/storage/images/agent/');
            $data['image'] = FileUpload::upload($request->file('image'), '/storage/images/agent/');;
        }


        $agent->update($data);
        Session::flash('success', 'Employee Updated');
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
//        $agent = Agent::FindOrFain($id);
//        FileUpload::delete_image($agent->image, '/storage/images/agent/');
//        $agent->delete();
//        Session::flash('success', 'Employee Deleted');
//        return redirect(route('employees.index'));
    }

    public function search($request)
    {
        return $this->getSearchResults($request);
    }


    public function exportExcel(Request $request){
        $agents = $this->formatAgents(
            $this->getSearchResults($request)
                ->latest()
                ->get()
        );
        FileDownload::downloadCSV('employees',$agents,'xls');
        return redirect()->back();
    }

    public function getSearchResults($request){
        $agents = Agent::query();
        if ($request->name) {
            $agents = $agents->where('name', 'LIKE', '%' . $request->name . '%');
        }
        if ($request->phone) {
            $agents = $agents->where('phone', 'LIKE', '%' . $request->phone . '%');
        }
        if ($request->department_id) {
            $agents = $agents->where('department_id', '=', $request->department_id);
        }
        if($request->office_id){
            $agents = $agents->where('office_id','=',$request->office_id);
        }
        if($request->type){
            $agents = $agents->where('type','=',$request->type);
        }

        return $agents;
    }

    /**
     * @param $orders
     * @return array
     * change the orders format to new custom format
     * to export these data into excel file
     */
    public function formatAgents($agents){
        $new_agents = array();
        foreach ($agents as $agent){
            $data['Name'] = $agent->name;
            $data['Email'] = $agent->email;
            $data['Phone'] = $agent->phone;
            $data['GOV.number'] = $agent->ssn;
            $data['Address'] = $agent->address;
            $data['Age'] = $agent->age;
            $data['Join Date'] = $agent->join_date;
            $data['Shift From'] = $agent->shift_from;
            $data['Shift To'] = $agent->shift_to;
            $data['Office'] = $agent->office->name;
            $data['Department'] = $agent->department->name;
            $data['City'] = $agent->city->name;
            $data['Position'] = $agent->position == null ? "---" : $agent->position;
            $data['Type'] = $agent->type;
            array_push($new_agents,$data);
        }
        return $new_agents;
    }





    /**
     * @param $agent
     * @param $departments
     * @param $cities
     * @param $offices
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * this function return the profile of each employee alone
     */
    public function redirect_to_profile($agent,$departments,$cities,$offices){
        if($agent->type == 'Employee'){
            $permissions = $agent->myPermissions();
            return view('dashboard.employees.show',compact(
                'agent','departments','cities','offices','permissions'
            ));
        } else if ($agent->type == 'Pickup Agent') {
            $requests = PickupRequest::
            where('agent_id', '=', $agent->id)
                ->where('status', '=', 'Assign To')
                ->latest()
                ->paginate(10);
            return view('dashboard.employees.pickup', compact(
                'agent', 'departments', 'cities', 'offices', 'requests'
            ));
        } else if ($agent->type == 'Sales Person') {
            return view('dashboard.employees.sales', compact(
                'agent', 'departments', 'cities', 'offices'
            ));
        } else if ($agent->type == 'Delivery Agent') {
            $orders = Order::where('delivery_agent_id', '=', $agent->id)
                ->where('status','=','Out for delivery')
                ->latest()
                ->paginate(10);
            return view('dashboard.employees.delivery', compact(
                'agent', 'departments', 'cities', 'offices', 'orders'
            ));
        }
        
    }


    public function assignPermission(StoreRole $request){
        $agent = Agent::findOrFail($request->agent_id);
        $agent->permissions()->sync($request->permission,true);
        Session::flash('success','Permissions Assigned Successfully');
        return redirect()->back();
    }

    public function employeeProfile(){
        return view('dashboard.profiles.employeeProfile');
    }

    public function exportDeliveryExcel(Request $request){
        $orders = $this->formatDeliveryOrders(
            Order::where('delivery_agent_id','=', $request->agentId)
                ->where('status','=','Out for delivery')
                ->latest()
                ->get()
        );
        FileDownload::downloadCSV('orders',$orders,'csv');
        return redirect()->back();
    }

    //change the orders format to new custom format
    //to export these data into excel file
    public function formatDeliveryOrders($orders){
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
