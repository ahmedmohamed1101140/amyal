<?php

namespace App\Http\Controllers\Site;

use App\Events\NewMessage;
use App\FileUpload;
use App\Http\Requests\Site\StoreMessage;
use App\Http\Requests\Site\StoreTicket;
use App\Models\Site\Message;
use App\Models\Site\Ticket;
use App\uniqueRandom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Session;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->filter ){
            return $this->search($request);
        }

        $tickets = Ticket::where('user_id','=',auth()->user()->id)
            ->latest()
            ->paginate(10);
        return view('site.tickets.index',compact('tickets'));
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
        $data = $request->only('subject');
        $data['user_id'] = auth()->user()->id;
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
        $message['sender_type'] = 'Client';
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
        if($ticket->check_auth()){
            Session::flash('error', "You Don't Have The Permission For This Action");
            return redirect()->back();
        }
        return view('site.tickets.show',compact('ticket'));

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
    public function update(StoreMessage $request, $id)
    {
        //
        $ticket = Ticket::findOrFail($id);
        if($ticket->check_auth()){
            Session::flash('error', "You Don't Have The Permission For This Action");
            return redirect()->back();
        }
        $data = $request->only('message');
        $data['ticket_id'] = $id;
        $data['sender_id'] = auth()->user()->id;
        $data['sender_type'] = 'Client';

        //upload file to server directory to service
        if($request->file_upload1 != null){
            $data['attachment'] = FileUpload::upload($request->file('file_upload1'),'/storage/support/');;
        }

        $message = Message::create($data);
        $message = Message::where('id',$message->id)->with('user')->get();
        return $message->toJson();
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

    public function search($request){
        $tickets = Ticket::where('user_id','=',auth()->user()->id);
        if($request->status){
            $tickets = $tickets->where('status','=', $request->status);
        }
        if($request->reference_number){
            $tickets = $tickets->where('reference_number','=',$request->reference_number);
        }

        $tickets = $tickets
            ->latest()
            ->paginate(10)
            ->setPath(
                URL::current()
                ."?filter=".$request->filter
                .'&status='.$request->status
                .'&reference_number='.$request->reference_number
            );
        $data = $request->all();
        return view('site.tickets.index',compact('tickets','data'));

    }

}
