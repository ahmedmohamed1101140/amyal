<?php

namespace App\Http\Controllers;

use App\Http\Requests\Site\StoreClientRequest;
use App\Models\Dashboard\City;
use App\Models\Site\ClientRequest;
use App\Models\Site\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use Validator;

class HomeController extends Controller
{


    public function index(){
        $cities = City::where('status','=','display')->orderBy('name', 'asc')->select('id','name')->get();
        return view('welcome',compact('cities'));
    }

    public function storeRequest(StoreClientRequest $request){
        ClientRequest::create($request->validated());
        Session::flash('confirm');
        return redirect('/');
    }

    public function update_password(Request $request){
        $result = Validator::make($request->all(),[
            'now_password'          => 'required|min:6',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
        ]);
        if($result->fails()){
            Session::flash('confirmError',"Please Confirm your password");
            return redirect()->back()->withInput($request->all());
        }

        auth()->user()->password = Hash::make($request->password);
        auth()->user()->first_login = 1;
        auth()->user()->save();
        Session::flash('success','Password Updated Successfully');
        return redirect(route('home'));
    }

    public function find_order(Request $request){
        $tracking_number = $request->tracking_number;
        $cities = City::where('status','=','display')->orderBy('name', 'asc')->select('id','name')->get();

        $order = Order::where('tracking_number','=',$tracking_number)->first();
        if ($order){
            return view('welcome',compact('cities','order','tracking_number'));
        }
        Session::flash('orderNotFound');
        return view('welcome',compact('cities','tracking_number'));
    }
}
