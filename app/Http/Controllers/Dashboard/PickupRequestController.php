<?php

namespace App\Http\Controllers\Dashboard;

use App\Agent;
use App\DateReFormat;
use App\FileDownload;
use App\Http\Requests\Dashboard\StorePickupRequest;
use App\Http\Requests\Dashboard\StorePickupRequestStatus;
use App\Models\Site\PickupRequest;
use App\uniqueRandom;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Session;

class PickupRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $data = $request->all();
        if($request->filter){
            $requests =  $this->search($request)
                ->latest()
                ->paginate(10)
                ->setPath(
                    URL::current()
                    ."?date".$request->date
                    .'&company_name='.$request->company_name
                    .'&account_number='.$request->account_number
                    .'&status='.$request->status
                );
        }
        else{
            $requests = PickupRequest::whereHas('user',function($query){
                $query->where('office_id','=',auth()->user()->office_id);
            })->latest()->paginate(10);

        }


        $agents = Agent::where('office_id','=',auth()->user()->office_id)
            ->where('type','=','Pickup Agent')
            ->select('id','name')
            ->get();


        return view('dashboard.pickupRequests.index',compact('requests','agents','data'));
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
    public function store(StorePickupRequest $request)
    {
        //
        $data['user_id'] = User::where('account_number' ,'=',$request->account_number)->first()['id'];
        $data['agent_id'] = auth()->user()->id;
        $pickupRequest = PickupRequest::create($data);
        try_again:
        $req_number = uniqueRandom::generateRND($pickupRequest->id);
        $requests = PickupRequest::where('req_number','=',$req_number)->count();
        if($requests > 0){
            goto try_again;
        }
        $pickupRequest->req_number = $req_number;
        $pickupRequest->save();

        Session::flash('success', "Pickup Request Stored");
        return response()->json($pickupRequest);

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
        $request = PickupRequest::findOrFail($id);
        return response()->json($request);
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
    public function update(StorePickupRequestStatus $request, $id)
    {
        //
        $pickup = PickupRequest::findOrFail($id);
        if(!$this->client_permission($request,$pickup)){
            Session::flash('error', "Permission Denied");
            if(auth()->user()->type == 'Pickup Agent'){
                return redirect(route('profile'));
            }
            return redirect()->back();
        }

        $data = $request->validated();
        if($request->status == 'Cancel'){
            $data['agent_id'] = auth()->user()->id;
        }

        $pickup->update($data);
        Session::flash('success', "Pickup Request Updated Successfully");
        return redirect()->back();

    }

    public function client_permission($request,$pickup){
        if(auth()->user()->type == 'Pickup Agent' || auth()->user()->type == 'Employee'){
            if(auth()->user()->type == 'Pickup Agent' && $request->status != 'Done' && $pickup->agent_id !=  auth()->user()->id){
                return false;
            }
            return true;
        }
        else{
            return false;
        }
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


    public function exportExcel(Request $request){
        $requests  = $this->formatRequests(
            $this->getSearchResults($request)
                ->latest()
                ->get()
        );
        FileDownload::downloadCSV('clients',$requests ,'xls');
        return redirect()->back();
    }

    public function getSearchResults($request){
        $requests = PickupRequest::query();
        $requests = $requests->whereHas('user',function($query){
            $query->where('office_id','=',auth()->user()->office_id);
        });
        if($request->company_name){
            $clients = User::where('company_name','LIKE','%'.$request->company_name.'%')->select('id')->get();
            if(count($clients) > 0){
                $requests->where(function($query) use ($clients){
                    foreach ($clients as $client){
                        $query->orWhere('user_id', '=', $client->id);
                    }
                });
            }
            else{
                $requests->where('user_id','=','0');
                goto end;
            }
        }
        if($request->account_number){
            $clients = User::where('account_number','=',$request->account_number)->select('id')->get();
            if(count($clients) > 0){
                $requests->where(function($query) use ($clients){
                    foreach ($clients as $client){
                        $query->orWhere('user_id', '=', $client->id);
                    }
                });
            }
            else{
                $requests->where('user_id','=','0');
                goto end;
            }
        }
        if($request->status){
            $requests = $requests->where('status','=',$request->status);
        }
        if($request->date){
            $from = DateReFormat::RefactorDate($request->date);
            $requests->whereDate('created_at','=',$from);
        }

        end:
        return $requests;
    }

    /**
     * @param $orders
     * @return array
     * change the orders format to new custom format
     * to export these data into excel file
     */
    public function formatRequests($requests){
        $new_requests = array();
        foreach ($requests as $request){
            $data['Request Number'] = $request->req_number;
            $data['Account Number'] = $request->user->account_number;
            $data['Company name'] = $request->user->company_name;
            $data['Pickup Address'] = $request->user->pickup_address;
            $data['Company phone'] = $request->user->phone;
            $data['Status'] = $request->status;
            $data['Pickup Agent'] = $request->agent == null ? '---' : $request->agent->name;
            $data['Created At'] = $request->created_at->format('d/m/Y H:i A');
            $data['Updated At'] = $request->updated_at->format('d/m/Y H:i A');
            array_push($new_requests,$data);
        }
        return $new_requests;
    }



}
