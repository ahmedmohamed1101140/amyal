@extends('dashboard.layout')
@section('title')Amyal l Shipments @endsection
@section('css')
    <style>
        ol {list-style:none}
    </style>
@endsection
@section('content')

    <div class="dash-pages myorders clearfix">
        <h1>Order Data</h1>
    </div>

    <form id="user-form1" class="user-form clearfix" style="margin-top:0; width:100%">
        <div class="col-md-6 lft">
            <div class="form-group nw-pd">
                <label>Receiver Name</label>
                <input disabled type="text" value="{{$order->receiver_name}}" class="form-control" >
            </div>
        </div>
        <div class="col-md-6 lft">
            <div class="form-group nw-pd">
                <label>Mobile Num</label>
                <input type="text" disabled value="{{$order->mobile}}" class="form-control" >
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6 lft">
            <div class="form-group nw-pd">
                <label>City</label>
                <input type="text" disabled value="{{$order->city->name}}" class="form-control" >
            </div>
        </div>
        <div class="col-md-6 lft">
            <div class="form-group nw-pd">
                <label>Area</label>
                <input type="text" disabled value="{{$order->area->name}}" class="form-control" >
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 p-0">
            <div class="form-group nw-pd">
                <label style="width:14.8%">Address</label>
                <input type="text" disabled value="{{$order->address}}" class="form-control" >
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 p-0">
            <div class="form-group nw-pd">
                <label style="width:14.8%">Markup Place</label>
                <input type="text" disabled value="{{$order->mark_place}}" class="form-control" >
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 lft">
            <div class="form-group nw-pd">
                <label>COD Value</label>
                <input  disabled type="text"  class="form-control" value="{{$order->cod}} LE">
            </div>
        </div>
        <div class="col-md-4 lft">
        <div class="form-group nw-pd">
            <label>Shipping fees</label>
            <input type="text" disabled required class="form-control" value="{{$order->shipping_fees}} LE">
        </div>
    </div>
        <div class="col-md-4 lft">
            <div class="form-group nw-pd">
                <label>Security Num</label>
                <input type="number" disabled class="form-control" value="{{$order->security_number}}">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 p-0">
            <div class="form-group nw-pd">
                <label style="width:14.8%">Item </label>
                <textarea disabled class="form-control " placeholder="Item ">{{$order->description}}</textarea>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 p-0">
            <div class="form-group nw-pd">
                <label style="width:14.8%">Notes</label>
                <textarea disabled class="form-control" name="notes" required>{{$order->notes}}</textarea>
            </div>
        </div>
        @if(auth()->user()->hasRole('shipments.printPolicy'))
            <a href="{{route('shipments.printPolicy',$order->id)}}" class="btn nwbtn3 pull-right no-radius ">Print Policy</a>
        @endif
    </form>
    <h2 class="orang">Status History</h2>
    <div class="table-responsive text-center">
        <table class="table main-table">
            <thead class="text-center">
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>System User</th>
                <th>User Office</th>
                <th>Status From</th>
                <th>Status To</th>
                <th>Additional Info</th>
            </tr>
            </thead>
            <tbody>
            @foreach($statuses as $status)
                <tr>
                    <td>{{$status->created_at->format('d/m/Y')}}</td>
                    <td>{{$status->created_at->format('h:i A')}}</td>
                    <td>{{$status->agent->name}}</td>
                    <td>{{$status->agent->office->name}}</td>
                    <td>{{$status->status_from}}</td>
                    <td>{{$status->status_to}}</td>
                    <td>{{$status->agent_additional_info}}</td>
                </tr>
            @endforeach
            </tbody>


        </table>
    </div>
    <div class="clearfix"></div>
    <div>
        {{$statuses->render()}}
    </div>

    <div class="clearfix"></div>
@endsection
