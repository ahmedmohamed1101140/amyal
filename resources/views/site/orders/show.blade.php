@extends('site.layout')
@section('title')Amyal l My Orders @endsection
@section('div_class')profile @endsection
@section('content')
    <div class="col-md-12 col-sm-12 col-xs-12 pd-all-25" style="padding-bottom:0">
        <div class="dash-pages myorders clearfix">
            <h1>Orders Details</h1>
        </div>
        <!---->
    </div>
    <form id="user-form" class="clearfix" style="margin-top:0; width:100%">
        <div class="col-md-10 col-sm-10 col-xs-10 pd-all-25" style="padding-bottom:5px">
            <div class="col-md-12 lft">
                <div class="form-group nw-pd">
                    <label>Tracking Number</label>
                    <p class="p-form">{{$order->tracking_number}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-10 col-sm-10 col-xs-10 pd-all-25" style="padding-bottom:5px">
            <div class="col-md-6 lft">
                <div class="form-group nw-pd">
                    <label>Receiver Name</label>
                    <p class="p-form">{{$order->receiver_name}}</p>
                </div>
            </div>

            <div class="col-md-6 lft">
                <div class="form-group nw-pd">
                    <label>Mobile Num</label>
                    <p class="p-form">{{$order->mobile}}</p>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-6 lft">
                <div class="form-group nw-pd">
                    <label>City</label>
                    <p class="p-form">{{$order->city->name}}</p>
                </div>
            </div>

            <div class="col-md-6 lft">
                <div class="form-group nw-pd">
                    <label>Area</label>
                    <p class="p-form">{{$order->area->name}}</p>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-md-12 p-0">
                <div class="form-group nw-pd">
                    <label style="width:14.8%">Address</label>
                    <p class="p-form" style="width:84.2%; vertical-align:text-top">{{$order->address}}</p>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-12 p-0">
                <div class="form-group nw-pd">
                    <label style="width:14.8%">Markup Place</label>
                    <p class="p-form" style="width:84.2%; vertical-align:text-top">{{$order->mark_place}}</p>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-4 lft">
                <div class="form-group nw-pd">
                    <label>COD Value</label>
                    <p class="p-form">{{$order->cod}}</p>
                </div>
            </div>

            <div class="col-md-4 lft">
                <div class="form-group nw-pd">
                    <label>Shipping fees</label>
                    <p class="p-form">{{$order->shipping_fees}}</p>
                </div>
            </div>

            <div class="col-md-4 lft">
                <div class="form-group nw-pd">
                    <label>Security Num</label>
                    <p class="p-form">{{$order->security_number}}</p>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-md-12 p-0">
                <div class="form-group nw-pd">
                    <label style="width:14.8%">Item </label>
                    <p class="p-form" style="width:84.2%; vertical-align:text-top">{{$order->description}}</p>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-md-12 p-0">
                <div class="form-group nw-pd">
                    <label style="width:14.8%">Notes</label>
                    <p class="p-form" style="width:84.2%; vertical-align:text-top">{{$order->notes}}</p>
                </div>
            </div>


        </div>

        <div class="col-md-10 col-sm-10 col-xs-10 pd-all-25" style="padding-bottom:5px">
            <h2 class="orang">Status History</h2>
            <div class="table-responsive text-center">
                <table class="table main-table">
                    <thead class="text-center">
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status From</th>
                        <th>Status To</th>
                        <th>Office</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($statuses as $status)
                        <tr>
                            <td>{{$status->created_at->format('d/m/Y')}}</td>
                            <td>{{$status->created_at->format('h:i A')}}</td>
                            <td>{{$status->status_from}}</td>
                            <td>{{$status->status_to}}</td>
                            <td>{{$status->agent->office->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>


                </table>
            </div>
            <div class="text-center">
                {{$statuses->render()}}
            </div>

        </div>
    </form>
    <div class="clearfix"></div>
@endsection