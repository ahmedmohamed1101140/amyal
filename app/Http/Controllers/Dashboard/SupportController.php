<?php

namespace App\Http\Controllers\Dashboard;

use App\Agent;
use App\FileDownload;
use App\FileUpload;
use App\Http\Requests\Dashboard\StoreTicket;
use App\Http\Requests\Site\StoreMessage;
use App\Models\Site\Message;
use App\Models\Site\Ticket;
use App\uniqueRandom;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Session;


class SupportController extends Controller
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
        if($request->filter ){
            $tickets = $this->search($request)
                ->latest()
                ->paginate(10)
                ->setPath(
                    URL::current()
                    ."?filter=".$request->filter
                    ."&name=".$request->name
                    .'&status='.$request->status
                    .'&reference_number='.$request->reference_number
                );
        }
        else{
            $tickets = Ticket::latest()->paginate(10);
        }
        return view('dashboard.support.index',compact('tickets','data'));
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
    public function store(StoreTicket $request)
    {
        //
        $data = $request->validated('subject');
        $data['user_id'] = User::where('account_number' , '=' ,$request->account_number)->first()->id;
        $data['agent_id'] = auth()->user()->id;
        $data['status'] = 'New';
        $ticket = Ticket::create($data);

        try_again:
        $reference_number = uniqueRandom::generateRND($ticket->id);
        $tickets = Ticket::where('reference_number','=',$reference_number)->count();
        if($tickets > 0){
            goto try_again;
        }
        $ticket->reference_number = $reference_number;
        $ticket->save();

        $message = $request->only('message');
        $message['sender_id'] = auth()->user()->id;
        $message['sender_type'] = 'Agent';
        $message['ticket_id'] = $ticket->id;
        Message::create($message);

        Session::flash('success','Your Ticket Created Successfully');
        return redirect()->back();
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
        $ticket = Ticket::findOrFail($id);

        if($ticket->agent_id != null && $ticket->checkAgentAuth()){
            Session::flash('error',"You don't have the permission for this action");
            return redirect()->back();
        }

        if($ticket->status == 'New'){
            $ticket->status = 'Opened';
            $ticket->agent_id = auth()->user()->id;
            $ticket->save();
        }
        return view('dashboard.support.show',compact('ticket'));
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
        $ticket = Ticket::findOrFail($id);
        if($ticket->agent_id != null && $ticket->checkAgentAuth()){
            Session::flash('error',"You don't have the permission for this action");
            return redirect()->back();
        }

        if($ticket->status != 'Closed'){
            $ticket->status = 'Closed';
            $ticket->agent_id = auth()->user()->id;
            $ticket->save();
        }
        Session::flash('success','Ticket now Closed');
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreMessage $request, $id)
    {
        //
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


    public function search($request){
        return $this->getSearchResults($request);
    }


    public function getSearchResults($request){
        $tickets = Ticket::query();
        if($request->name){
            $agents = Agent::where('name','LIKE','%'.$request->name.'%')->select('id')->get();
            if(count($agents) > 0){
                $tickets->where(function($query) use ($agents){
                    foreach ($agents as $agent){
                        $query->orWhere('agent_id', '=', $agent->id);
                    }
                });
            }
            else{
                goto end;
            }
        }
        if($request->status){
            $tickets = $tickets->where('status','=', $request->status);
        }
        if($request->reference_number){
            $tickets = $tickets->where('reference_number','=',$request->reference_number);
        }

        end:
        return $tickets;
    }

    public function exportExcel(Request $request){
        $tickets = $this->formatFinances(
            $this->getSearchResults($request)
                ->latest()
                ->get()
        );
        FileDownload::downloadCSV('tickets',$tickets,'xls');
        return redirect()->back();
    }

    public function formatFinances($tickets){
        $new_tickets = array();
        foreach ($tickets as $ticket){
            $data['Subject'] = $ticket->subject;
            $data['Status'] = $ticket->status;
            $data['Ticket Number'] = $ticket->reference_number;
            $data['Client'] = $ticket->user_id == null ? '---' : $ticket->user->company_name;
            $data['Agent'] = $ticket->agent == null ? '----' : $ticket->agent->name;
            $data['Created At'] = $ticket->created_at->format('d/m/Y H:i A');
            array_push($new_tickets,$data);
        }
        return $new_tickets;
    }
}
