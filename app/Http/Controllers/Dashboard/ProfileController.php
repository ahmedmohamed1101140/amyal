<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Dashboard\Attendance;
use App\Models\Dashboard\Call;
use App\Models\Dashboard\Meeting;
use App\Models\Dashboard\OrderStatus;
use App\Models\Dashboard\Target;
use App\Models\Site\Order;
use App\Models\Site\PickupRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    //
    public function index(){
        if(Auth::check() && auth()->user()->type != 'Employee') {
            switch(auth()->user()->type){
                case 'Pickup Agent':
                    return $this->pickupAgentProfile();
                case 'Sales Person':
                    return $this->salesPersonProfile();
                case 'Delivery Agent':
                    return $this->deliveryAgentProfile();
                default:break;
            }
        }
    }

    public function pickupAgentProfile(){
        $requests = PickupRequest::
                where('agent_id','=',auth()->user()->id)
                ->where('status','=','Assign To')
                ->latest()
                ->paginate(10);
        $orders = Order::where('pickup_agent_id',auth()->user()->id)
            ->where('status','=','Back to shipper')
            ->latest()
            ->get();
        return view('dashboard.profiles.pickupAgent',compact('requests','orders'));
    }

    public function salesPersonProfile(){
        return view('dashboard.profiles.salesPerson');
//        $today = Carbon::now()->format('d/m/Y');
//        $calls = Call::where('agent_id','=',auth()->user()->id)->orderBy('created_at', 'desc')->get();
//        $meetings = Meeting::where('agent_id','=',auth()->user()->id)->orderBy('created_at', 'desc')->get();
//        $targets = Target::where('agent_id','=',auth()->user()->id)->orderBy('created_at', 'desc')->get();
//        $attendances = Attendance::where('agent_id','=',auth()->user()->id)->orderBy('created_at', 'desc')->get();
//        return view('dashboard.profiles.salesPerson',compact(
//            'today',
//            'calls',
//            'meetings',
//            'targets',
//            'attendances'
//        ));
    }

    public function deliveryAgentProfile(){
        $orders = Order::where('delivery_agent_id','=', auth()->user()->id)
            ->where('status','=','Out for delivery')
            ->latest()
            ->paginate(10);
        return view('dashboard.profiles.deliveryAgent',compact('orders'));
    }





}
