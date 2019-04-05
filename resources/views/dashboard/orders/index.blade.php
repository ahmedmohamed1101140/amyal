@extends('dashboard.layout')
@section('title')Amyal l Shipments @endsection
@section('css')
    <style>
        ol {list-style:none}
    </style>
@endsection
@section('content')
    <h2 class="orang1">Shipments</h2>

    <div class="orders-table">
        <form id="shipment-data" method="get" action="{{route('shipments.index')}}">
            <div class="part1">
                <h4>Pick up</h4>
                <div class="col-md-6 col-sm-6 col-xs-12 lft">
                    <div class="form-group nw-pd">
                        <input type="hidden" name="filter" value="1">
                        <input name="pickupFrom" value="@if(isset($data['pickupFrom'])){{$data['pickupFrom']}}@endif" autocomplete="off" class="form-control clndr tim" id="datetimepicker12" placeholder="Date from">
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 lft">
                    <div class="form-group nw-pd">
                        <input name="pickupTo" value="@if(isset($data['pickupTo'])){{$data['pickupTo']}}@endif" autocomplete="off" class="form-control clndr tim" id="datetimepicker13" placeholder="Date to">
                    </div>
                </div>
            </div>
            <div class="part2">
                <h4>Last Update</h4>
                <div class="col-md-2 col-sm-2 col-xs-12 lft">
                    <div class="form-group nw-pd">
                        <input name="updateFrom" value="@if(isset($data['updateFrom'])){{$data['updateFrom']}}@endif" autocomplete="off" class="form-control clndr tim" id="datetimepicker6" placeholder="Date from">
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12 lft">
                    <div class="form-group nw-pd">
                        <input name="updateTo" value="@if(isset($data['updateTo'])){{$data['updateTo']}}@endif"  autocomplete="off" class="form-control clndr tim" id="datetimepicker7" placeholder="Date to">
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12 lft">
                    <div class="form-group nw-pd">
                        <select id="A" name="office_id" class="form-control slct">
                            <option value="">Office</option>
                            @foreach($offices as $office)
                                <option @if(isset($data['office_id']) && $data['office_id'] == $office->id) selected @endif value="{{$office->id}}">{{$office->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 lft">
                    <div class="form-group nw-pd">
                        <select id="B" name="agent_id" class="form-control slct">
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 lft">
                    <div class="form-group nw-pd">
                        <select name="status" class="form-control slct">
                            <option value="">Status</option>
                            <option @if(isset($data['status']) && $data['status']=="Recorded") selected @endif value="Recorded">Recorded</option>
                            <option @if(isset($data['status']) && $data['status']=="Picked Up") selected @endif value="Picked Up">Picked Up</option>
                            <option @if(isset($data['status']) && $data['status']=="Received") selected @endif value="Received">Received</option>
                            <option @if(isset($data['status']) && $data['status']=="Out for delivery") selected @endif value="Out for delivery">Out for delivery</option>
                            <option @if(isset($data['status']) && $data['status']=="Delivered") selected @endif value="Delivered">Delivered</option>
                            <option @if(isset($data['status']) && $data['status']=="Rescheduled") selected @endif value="Rescheduled">Rescheduled</option>
                            <option @if(isset($data['status']) && $data['status']=="Refused") selected @endif value="Refused">Refused</option>
                            <option @if(isset($data['status']) && $data['status']=="Transfer to") selected @endif value="Transfer to">Transfer to</option>
                            <option @if(isset($data['status']) && $data['status']=="Back to shipper") selected @endif value="Back to shipper">Back to shipper</option>
                            <option @if(isset($data['status']) && $data['status']=="Returned to shipper") selected @endif value="Returned to shipper">Returned to shipper</option>
                            <option @if(isset($data['status']) && $data['status']=="Incorrect Phone") selected @endif value="Incorrect Phone">Incorrect Phone</option>
                            <option @if(isset($data['status']) && $data['status']=="Incorrect Address") selected @endif value="Incorrect Address">Incorrect Address</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-md-8 col-sm-4 col-xs-12 lft">
                <div class="col-md-4 col-sm-6 col-xs-12 lft">
                    <div class="form-group nw-pd">
                        <input type="text" value="@if(isset($data['mobile'])){{$data['mobile']}}@endif"  name="mobile" class="form-control" placeholder="Mobile Number">
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 p-0">
                    <div class="form-group nw-pd">
                        <input type="number" value="@if(isset($data['tracking_number'])){{$data['tracking_number']}}@endif" name="tracking_number" class="form-control" placeholder="Tracking No. ">

                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 p-0 rght">
                    <div class="form-group nw-pd">
                        <input type="text" value="@if(isset($data['account_number'])){{$data['account_number']}}@endif" name="account_number" class="form-control" placeholder="ACC No.">

                    </div>
                </div>
            </div>
            <div class="col-md-1 col-xs-1 lft pull-left">
                <button onclick="filterOrders()" class="btn btn-gry p_17" style=" width:100%;">Filter</button>
            </div>
            <div class="col-md-1 col-xs-1 lft pull-left">
                <a href="{{route('shipments.index')}}" class="btn btn-org p_17" style=" width:100%;">Reset</a>
            </div>

        </form>
        <div class="clearfix"></div>
        <div class="table-responsive text-center">
            <form id="orders-table-form" action="{{route("shipments.printTable")}}" method="POST">
                @csrf
                <input type="hidden" name="search" value="@if(isset($data)){{json_encode($data)}}@endif">
                <table class="table main-table" style="font-size:14px">
                <thead class="text-center">
                <tr>
                    <th><input type="checkbox" name="all_orders" id="checkAll"></th>
                    <th>Acc No.</th>
                    <th>Track No.</th>
                    <th>Pick up Date</th>
                    <th>Status</th>
                    <th>Last Update</th>
                    <th>System User</th>
                    <th>Office</th>
                    <th>Mobile</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($orders as $order)
                    <tr>
                    <td><input name="orders_id[]" value="{{$order->id}}" type="checkbox"  id="checkItem"></td>
                    <td>{{$order->user->account_number}}</td>
                    @if(auth()->user()->hasRole('shipments.show'))
                        <td><a href="{{route('shipments.show',$order->id)}}">{{$order->tracking_number}}</a></td>
                    @else
                        <td>{{$order->tracking_number}}</td>
                    @endif
                    <td>{{$order->pickup_date != null ? \Carbon\Carbon::parse($order->pickup_date)->format('d/m/Y h:i A') : '---'}}</td>
                    <td >{{$order->status}}</td>
                    <td>{{\Carbon\Carbon::parse($order->updated_at)->format('d/m/Y h:i A')}}</td>
                    <td >{{$order->agent != null ? $order->agent->name : '---'}}</td>
                    <td >{{$order->office != null ? $order->office->name : '----'}}</td>
                    <td >{{$order->mobile}}</td>
                    <td>
                        @if(auth()->user()->hasRole('shipments.update'))
                            <a href="{{route('shipments.edit',$order->id)}}"><img src="{{asset("assets/")}}/img/edit.png" ></a>
                        @endif
                        @if(auth()->user()->hasRole('shipments.destroy'))
                            <a href="javascript:;" onclick="deleteOrder('{{route('shipments.destroy',$order->id)}}')"><img src="{{asset("assets/")}}/img/delete.png" ></a>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            </form>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">
            <div class="table-btns">
                @if(auth()->user()->hasRole('shipments.exportExcel'))
                    <button onclick="exportTable()" class="btn btn-org"><i class="exl"></i> Export</button>
                @endif
                @if(auth()->user()->hasRole('shipments.printTable'))
                    <a href="javascript:void(0);" onclick="printTable()" class="btn btn-gry"><i class="prnt"></i></a>
                @endif
            </div>
        </div>                                                                                                                                 			<div class="col-md-4 col-sm-5 col-xs-12">
           {{$orders->render()}}
        </div>

    </div>
@endsection


@section('modals')
    <div class="modal fade" id="squarespaceModal-77" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="col-md-12 col-xs-12 text-center">
                        <h3 class="log-title" style="margin-top:5px">Delete Order</h3>

                        <form method="post" action="" id="delete-order">
                            @csrf
                            {{method_field('delete')}}
                            <h4>Are you sure that you want to delete this order?</h4>
                            <div class="clearfix"></div>
                            <div class="table-btns">
                                <button type="submit" class="btn btn-org nw-pad  m-t-10">Yes</button>
                                <button class="btn btn-gry nw-pad  m-t-10" data-dismiss="modal" aria-label="Close">No</button>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')
    <script>
        function deleteOrder(url) {
            $("#delete-order").attr('action', url);
            $('#squarespaceModal-77').modal('show');
        }

        (function() {
            //setup an object fully of arrays
            //alternativly it could be something like
            //{"yes":[{value:sweet, text:Sweet}.....]}
            //so you could set the label of the option tag something different than the name
            var bOptions = {
            };
            @foreach($offices as $office)
                bOptions[{!! $office->id !!}] = {!! $office->employees!!}
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
                op.text = 'System User';
                B.appendChild(op);

                for (var i in bOptions[_val]) {
                    //create option tag
                    var op = document.createElement('option');
                    //set its value
                    op.value = bOptions[_val][i].id;
                    //set the display label
                    op.text = bOptions[_val][i].name;
                    @if(isset($data['agent_id']))
                        var temp = {!! json_encode($data['agent_id']) !!};
                        if( temp == op.value ){
                            op.selected = true;
                            bool = 1;
                        }
                    @endif
                    //append it to B
                    B.appendChild(op);
                }
                B.appendChild(op);
            };
            //fire this to update B on load
            A.onchange();

        })();

        function filterOrders(){
            $("#shipment-data").attr('action', "{!! route('shipments.index') !!}");
            $("#shipment-data").attr('method', "GET");
            $( "#shipment-data" ).submit();
        }


        function exportTable() {
            $("#shipment-data").attr('action', "{!! route('shipments.exportExcel') !!}");
            $("#shipment-data").attr('method', "GET");
            $( "#shipment-data" ).submit();
        }


        function printTable() {
            $( "#orders-table-form" ).submit();
        }

    </script>
@endsection