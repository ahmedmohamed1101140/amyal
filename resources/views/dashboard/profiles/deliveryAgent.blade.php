@extends('dashboard.layout')
@section('title')Amyal l Delivery up Agent @endsection
@section('css')
    <style>
        ol {list-style:none}
    </style>
@endsection
@section('div_style')
    style="margin-left:0px;"
@endsection
@section('content')
    <nav id="breadcrumb" class="breadcrumb">
        <a href="#" class="breadcrumb-link">Delivery Agent Agents</a>
        <a href="#breadcrumb" class="breadcrumb--active">Profile</a>
    </nav>
    <h2 class="orang1" style="margin-bottom:10px; margin-top:0px">Personal Information</h2>
    <div class="profily">
        <div class="col-md-1 col-sm-1 lft">
            <div class="bordy"></div>
        </div>
        <div class="col-md-11 col-sm-11 rght">
            <div class="profily-details">
                <div class="user-img">
                    <img src="{{asset('storage/images/agent/'.auth()->user()->image)}}">
                </div>

                <div class="col-md-11 col-sm-11 col-md-offset-1 col-sm-offset-1 lft">
                    <div class="col-md-4 col-sm-4 lft">
                        <h5 class="orang2">Name: <span style="color:#5f6062">{{auth()->user()->name}}</span></h5>
                    </div>
                    <div class="col-md-3 col-sm-3 rght1">
                        <h5 class="orang2">Mobile: <span style="color:#5f6062">{{auth()->user()->phone}}</span></h5>
                    </div>
                    <div class="col-md-4 col-sm-4 rght1">
                        <h5 class="orang2">Email: <span style="color:#5f6062">{{auth()->user()->email}}</span></h5>
                    </div>
                    <div class="col-md-1 col-sm-1 rght">
                        <h5 class="orang2">Age: <span style="color:#5f6062">{{\Carbon\Carbon::parse(auth()->user()->age)->diff(\Carbon\Carbon::now())->format('%y years')}}</span></h5>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-7 col-sm-7 lft">
                        <h5 class="orang2">Address: <span style="color:#5f6062">{{auth()->user()->address}}</span></h5>
                    </div>
                    <div class="col-md-5 col-sm-5 rght1">
                        <h5 class="orang2">GOV No: <span style="color:#5f6062">{{auth()->user()->ssn}}</span></h5>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4 col-sm-4 lft">
                        <h5 class="orang2">Join date: <span style="color:#5f6062">{{\Carbon\Carbon::parse(auth()->user()->join_date)->format('d/m/Y')}}</span></h5>
                    </div>
                    <div class="col-md-3 col-sm-3 rght1">
                        <h5 class="orang2">Department: <span style="color:#5f6062">{{auth()->user()->department->name}}</span></h5>
                    </div>
                    <div class="col-md-3 col-sm-3 rght1">
                        <h5 class="orang2">City: <span style="color:#5f6062">{{auth()->user()->city->name}}</span></h5>
                    </div>
                    <div class="col-md-2 col-sm-2 rght">
                        <h5 class="orang2">Office: <span style="color:#5f6062">{{auth()->user()->office->name}}</span></h5>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4 col-sm-4 lft">
                        <h5 class="orang2">Shift From: <span style="color:#5f6062">{{auth()->user()->shift_from}}</span></h5>
                    </div>
                    <div class="col-md-3 col-sm-3 rght1">
                        <h5 class="orang2" style="margin-top:3px">Shift To: <span style="color:#5f6062">{{auth()->user()->shift_to}}</span></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="orders-table">
        <div class="table-responsive text-center">
            <h2 class="orang1 text-left" style="margin-bottom:10px; ">My Orders</h2>
            <table class="table main-table">
                <thead class="text-center">
                <tr>
                    <th>Tracking No</th>
                    <th>Receiver Name</th>
                    <th>Mobile</th>
                    <th>COD Value</th>
                    <th>City</th>
                    <th>Area</th>
                    <th>Address</th>
                    <th>Mark Place</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($orders as $order)
                    <tr>
                        <td>{{$order->tracking_number}}</td>
                        <td>{{$order->receiver_name}}</td>
                        <td>{{$order->mobile}}</td>
                        <td>{{$order->cod}}</td>
                        <td>{{$order->city->name}}</td>
                        <td>{{$order->area->name}}</td>
                        <td>{{$order->address}}</td>
                        <td>{{$order->mark_place}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 col-sm-5 col-xs-12 lft">
            <a href="{{route('profile.exportMyOrders')}}" class="btn btn-gry"><i class="exl"></i> Export</a>
        </div>
        <div class="col-md-4 col-sm-5 col-xs-12">
            {{$orders->render()}}
        </div>
    </div>

@endsection

