@extends('site.layout')
@section('title')Amyal l My Profile @endsection
@section('div_class')profile @endsection
@section('content')
    <div class="row">
        <h3><a href="{{route('home')}}" target="_self"><i class="fa fa-th"></i> Back to Dashboard</a></h3>
        <div class="col-md-6 col-sm-6 col-xs-12 p-l-0">
            <div class="profile-details clearfix">
                <h1>Profile</h1>
                <h2 class="orang">Account Information</h2>
                <h3>Account Num  <strong> {{$client->account_number}}</strong></h3>
                <ul class="status">
                    <li>Status</li>
                    @if($client->status == "Active")
                        <li><strong class="green"> Active</strong></li>
                    @else
                        <li><strong class="red"> Inactive</strong></li>
                        <li>Reason</li>
                        <li><strong class="green"> {{$client->action}}</strong></li>
                    @endif
                </ul>

                <form id="user-form">
                    <div class="form-group nw-pd">
                        <label>Mobile Num</label>
                        <input disabled type="number" class="form-control" value="{{$client->phone}}">
                    </div>
                    <div class="form-group nw-pd">
                        <label>Pickup Address</label>
                        <input type="text" disabled class="form-control" value="{{$client->pickup_address}}">
                    </div>

                    <div class="form-group nw-pd">
                        <label>E-mail</label>
                        <input type="text" disabled class="form-control" value="{{$client->email}}">
                    </div>

                    <div class="clearfix"></div>


                </form>
            </div>
        </div>
        <div class="col-md-4 col-sm-5 col-xs-12">

            <div class="shipping">
                <h2 class="orang m-b-25">Shipping Fees</h2>
                <table class="table main-table">
                    <thead class="text-center">
                    <tr>
                        <th>City Name</th>
                        <th>Shipping Fees</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                        @foreach($client->shipping_fees as $shipping_fee)
                            <tr>
                                <td>{{$shipping_fee->city->name}}</td>
                                <td>{{$shipping_fee->fees}}</td>
                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>

        </div>
    </div>
@endsection