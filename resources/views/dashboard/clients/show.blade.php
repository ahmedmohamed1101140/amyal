@extends('dashboard.layout')
@section('title')Amyal l Clients @endsection
@section('content')
    <div class="col-md-6 col-sm-5 col-xs-12 p-l-0">
        <div class="profile-details clearfix">
            <h1>Profile</h1>
            <h2 class="orang">Account Information</h2>
            <h3>Account Num  <strong> {{$client->account_number}}</strong></h3>
            <ul class="status">
                <li>Status</li>
                @if($client->status == 'Active')
                    <li><strong class="green"> Active</strong></li>
                @else
                    <li><strong class="red"> Suspend</strong></li>
                    <li>Reason</li>
                    <li><strong class="green"> {{$client->action}}</strong></li>
                @endif
            </ul>
        </div>
    </div>
    <form id="user-form" class="clearfix" style="margin-top:0;" method="POST" action="{{route('clients.update',$client->id)}}">
        {{method_field('PUT')}}
        @csrf
        <input type="hidden" name="client_id" value="{{$client->id}}">
        <div class="col-md-12 col-sm-12 col-xs-12 pd-all-25" style="padding-bottom:5px;margin-left: -39px;">
            <div class="col-md-5 col-sm-5 col-xs-12 p-l-0" >
                <div class="form-group nw-pd">
                    <label>Company Name</label>
                    <input type="text" maxlength="190" required name="company_name" value="{{$client->company_name}}" class="form-control" placeholder="Company Name">
                </div>
                <div class="form-group nw-pd">
                    <label>Mobile Num</label>
                    <input type="text" minlength="3" maxlength="15" required name="phone" value="{{$client->phone}}" class="form-control" placeholder="Mobile Number">
                </div>
                <div class="form-group nw-pd">
                    <label>E-mail</label>
                    <input  type="email" maxlength="190" required name="email" value="{{$client->email}}" class="form-control" placeholder="E-mail">
                </div>
                <div class="form-group nw-pd">
                    <label>City</label>
                    <select name="city_id" required class="form-control slct">
                        <option value="">City</option>
                        @foreach($cities as $city)
                            <option @if($client->city_id == $city->id)selected @endif value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group nw-pd">
                    <label>Amyal Office</label>
                    <select name="office_id" id="A" required class="form-control slct">
                        <option value="">Amyal office</option>
                        @foreach($offices as $office)
                            <option {{$client->office_id == $office->id ? "selected":''}} value="{{$office->id}}">{{$office->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group nw-pd">
                    <label>Sales Person</label>
                    <select name="agent_id" id="B" required class="form-control slct">
                    </select>
                </div>

                <div class="form-group nw-pd">
                    <label>Status</label>
                    <select name="status" class="form-control slct">
                        <option value="">Status</option>
                        <option @if($client->status == 'Active') selected @endif value="Active">Active</option>
                        <option @if($client->status == 'Suspend') selected @endif value="Suspend">Suspend</option>
                    </select>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-7 col-sm-5 col-xs-12" >
                <div class="form-group nw-pd">
                    <label>Contact Person Name</label>
                    <input type="text" maxlength="190" name="cp_name" value="{{$client->cp_name}}" required class="form-control" placeholder="Contact Person Name">
                </div>
                <div class="form-group nw-pd">
                    <label>Contact Person Mobile</label>
                    <input type="text" maxlength="15" minlength="3" name="cp_phone" value="{{$client->cp_phone}}" required class="form-control" placeholder="Contact Person Name">
                </div>
                <div class="form-group nw-pd">
                    <label>Address</label>
                    <input type="text" maxlength="400" name="address" required value="{{$client->address}}" class="form-control" placeholder="Address">
                </div>
                <div class="form-group nw-pd">
                    <label>Pickup Address</label>
                    <input type="text" maxlength="400" name="pickup_address" value="{{$client->pickup_address}}" required  class="form-control" placeholder="Pickup Address">
                </div>
                <div class="form-group nw-pd">
                    <label>Password</label>
                    <input type="password" minlength="4" maxlength="50" name="password" class="form-control" placeholder="*******">
                </div>
                <div class="form-group nw-pd">
                    <label>Confirm Password</label>
                    <input type="password" minlength="4" maxlength="50" name="password_confirmation" class="form-control" placeholder="*******">
                </div>
                <div class="form-group nw-pd">
                    <label>Reason</label>
                    <input type="text" maxlength="190" name="action" class="form-control" value="{{$client->action}}" placeholder="Reason">                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        @if(auth()->user()->hasRole('clients.update'))
            <button type="submit" class="btn nwbtn3 pull-right no-radius" style="margin-right:80px;">Update</button>
        @endif
    </form>
    <div class="clearfix"></div>

        <div class="col-md-12 col-sm-12 col-xs-12 pd-all-25" style="padding-bottom:5px;margin-left: -39px;">
            <ul class="nav panel-tabs mytabs">
                <li ><a href="#tab1" data-toggle="tab">Shipping Fees</a></li>
                <li class="active"><a href="#tab2" data-toggle="tab">Client Orders</a></li>
            </ul>

            <div class="tab-content taby msgs-wrapper scrollbar" id="style-1">

                <div class="tab-pane" id="tab1">
                    <form method="POST" action="{{route('clients.shippingfees',$client->id  )}}">
                    @csrf
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="shipping" style="padding-top:5px">
                            <h2 class="orang">Shipping Fees</h2>
                            @foreach($shipping_fees as $city)
                                 <p class="clearfix p-city">{{$city->city_name}}:
                                     <br>
                                     <input type="number" min="0" max="10000" value="{{$city->shipping_fee}}" class="form-control inpt1" placeholder="Price" name="{{$city->city_id}}">
                                 </p>
                            @endforeach
                        </div>
                    </div>
                        @if(auth()->user()->hasRole('clients.shippingfees'))
                            <button type="submit" class="btn nwbtn3 pull-right no-radius">Save</button>
                        @endif
                    </form>
                </div>
                <div class="tab-pane active" id="tab2">
                    <div class="table-responsive text-center">
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
                        {{--<a href="#" class="btn btn-gry"><i class="exl"></i> Export</a>--}}
                    </div>
                    <div class="col-md-4 col-sm-5 col-xs-12">
                        {{$orders->render()}}
                    </div>

                </div>
            </div>

        </div>
        <div class="clearfix"></div>

@endsection


@section('js')
    <script>
        (function() {

            //setup an object fully of arrays
            //alternativly it could be something like
            //{"yes":[{value:sweet, text:Sweet}.....]}
            //so you could set the label of the option tag something different than the name
            var bOptions = {
            };
            @foreach($offices as $office)
                bOptions[{!! $office->id !!}] = {!! $office->employees !!}
            @endforeach



            var A = document.getElementById('A');
            var B = document.getElementById('B');

            //on change is a good event for this because you are guarenteed the value is different
            A.onchange = function() {
                //clear out B
                B.length = 0;
                //get the selected value from A
                var _val = this.options[this.selectedIndex].value;

                var bool = 0;

                var op = document.createElement('option');
                op.value = '';
                op.text = 'Select Employee';
                for (var i in bOptions[_val]) {
                    //create option tag
                    if(bOptions[_val][i].type == 'Sales Person'){
                        var op = document.createElement('option');
                        //set its value
                        op.value = bOptions[_val][i].id;
                        //set the display label
                        op.text = bOptions[_val][i].name;
                        var temp = {!! json_encode($client->agent_id) !!};
                        if( temp == op.value ){
                            op.selected = true;
                            bool = 1;
                        }
                        //append it to B
                        B.appendChild(op);
                    }

                }

                B.appendChild(op);

            };


            //fire this to update B on load
            A.onchange();

        })();
    </script>
@endsection


