<?php

namespace App\Http\Controllers\Dashboard;

use App\Agent;
use App\DateReFormat;
use App\FileDownload;
use App\Http\Requests\Dashboard\StoreClientRequestStatus;
use App\Models\Dashboard\ClientRequestStatus;
use App\Models\Site\ClientRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Session;

class ClientRequestController extends Controller
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
            $applications = $this->search($request)
                ->latest()
                ->paginate(10)
                ->setPath(
                    URL::current()
                    ."?date_from".$request->date_from
                    .'&date_to='.$request->date_to
                    .'&name='.$request->name
                    .'&phone='.$request->phone
                    .'&status='.$request->status
                );
        }
        else{
            $applications = ClientRequest::
                latest()
                ->paginate(10);

        }

        return view('dashboard.applications.index',compact('applications','data'));
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
    public function store(StoreClientRequestStatus $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $application = ClientRequest::findOrFail($id);
        if($application->status == 'New' ){
            $application->status = "Open";
            $application->agent_id = auth()->user()->id;
            $application->save();
            $this->add_new_status(
                'New',
                'Open',
                '----',
                auth()->user()->id,
                $application->id
            );
        }

        return view('dashboard.applications.show',compact('application'));
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreClientRequestStatus $request, $id)
    {
        //
        $data = $request->validated();
        $data['agent_id'] = auth()->user()->id;
        $application = ClientRequest::findOrFail($id);
        try{
            DB::beginTransaction();
            $old_status = $application->status;
            $application->update($data);
            $this->add_new_status(
                $old_status,
                $request->status,
                $request->action,
                auth()->user()->id,
                $application->id
            );

        }catch (\Exception $e) {
            DB::rollBack();
            Session::flash('error', 'Something went wrong pleas try again');
            return redirect()->back();
        }
        DB::commit();
        Session::flash('success', "Status Added Successfully");
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
    }

    public function search(Request $request){
        return $this->getSearchResults($request);

    }

    /**
     * @param $status_from
     * @param $status_to
     * @param $action
     * @param $agent_id
     * @param $client_request_id
     * @return bool
     *
     * store the log of the request status
     */
    public function add_new_status($status_from,$status_to,$action,$agent_id,$client_request_id){
        $data['status_from'] = $status_from;
        $data['status_to'] = $status_to;
        $data['action'] = $action;
        $data['agent_id'] = $agent_id;
        $data['client_request_id'] = $client_request_id;
        ClientRequestStatus::create($data);
        return true;
    }

    public function getSearchResults($request){
        $applications = ClientRequest::query();
        if($request->date_from != null && $request->date_to != null){
            $from = DateReFormat::RefactorDate($request->date_from);
            $to = DateReFormat::RefactorDate($request->date_to);
            $applications->whereDate('created_at','>=',$from)->whereDate('created_at','<=',$to);
        }
        if($request->name){
            $agents = Agent::where('name','LIKE','%'.$request->name.'%')->select('id')->get();
            if(count($agents) > 0){
                $applications->where(function($query) use ($agents){
                    foreach ($agents as $agent){
                        $query->orWhere('agent_id', '=', $agent->id);
                    }
                });
            }
            else{
                $applications->where('agent_id','=','0');
                goto end;
            }
        }

        if($request->phone){
            $applications->where('phone','=',$request->phone);
        }

        if($request->status){
            $applications->where('status','=',$request->status);
        }

        end:
        return $applications;

    }

    public function exportExcel(Request $request){
        $applications = $this->formatRequests(
            $this->getSearchResults($request)
                ->latest()
                ->get()
        );
        FileDownload::downloadCSV('Applications',$applications,'xls');
        return redirect()->back();
    }

    public function formatRequests($requests){
        $new_requests= array();
        foreach ($requests as $request){
            $data['Name'] = $request->name;
            $data['Phone'] = $request->phone;
            $data['City'] = $request->city->name;
            $data['Status'] = $request->status;
            $data['Action'] = $request->action;
            $data['Created At'] = $request->created_at->format('d/m/Y H:i A');
            array_push($new_requests,$data);
        }
        return $new_requests;
    }
}
