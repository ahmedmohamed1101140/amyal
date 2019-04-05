<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Site\Message;
use App\Models\Site\Ticket;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //

    public function ticket_messages(Ticket $ticket){
        return response()->json($ticket->messages()->get());
    }

    public function send_messages(Request $request,Ticket $ticket){
        if($ticket->status == 'Closed'){
            abort(404);
        }


        auth()->user()->authGuard == 'agent' ? $sender_type='Agent' : $sender_type='Client';
        $message = $ticket->messages()->create([
            'sender_id' => auth()->user()->id,
            'sender_type' => $sender_type,
            'message' => $request->message
        ]);

        $message = Message::where('id',$message->id)->first();
        broadcast(new NewMessage($message))->toOthers();
        return $message->toJson();
    }
}
