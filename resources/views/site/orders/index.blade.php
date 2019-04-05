@extends('site.layout')
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" crossorigin="anonymous">

@endsection
@section('title')Amyal l My Orders @endsection
@section('div_class')orders @endsection
@section('content')
    <h3><a href="{{route('home')}}" target="_self"><i class="fa fa-th"></i> Back to Dashboard</a></h3>
    <div class="col-md-12 col-sm-12 col-xs-12 p-l-0">
        <div class="dash-pages myorders clearfix">
            <h1>My Orders</h1>
            <br><br>
            <div class="orders-table">
                <form id="orders" method="get" action="{{route('orders.index')}}">
                    <input type="hidden" name="filter" value="1">
                    <div class="col-md-2 col-sm-2 col-xs-12 p-l-0">
                        <div class="form-group nw-pd">
                            <input name="date_from" value="@if(isset($data['date_from'])){{$data['date_from']}}@endif" autocomplete="off" class="form-control slct tim" id="datetimepicker12" placeholder="Date from" />
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12 p-l-0">
                        <div class="form-group nw-pd">
                            <input name="date_to" value="@if(isset($data['date_to'])){{$data['date_to']}}@endif" autocomplete="off" class="form-control slct tim" id="datetimepicker13" placeholder="Date to" />
                        </div>
                    </div>


                    <div class="col-md-2 col-sm-2 col-xs-12 p-l-0">
                        <div class="form-group nw-pd">
                            <select required id="A" name="city_id" class="form-control slct">
                                <option value=""> City</option>
                                @foreach($cities as $city)
                                    <option @if(isset($data['city_id']) && $data['city_id']== $city->city_id )selected @endif value="{{$city->city_id}}">{{$city->city_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="col-md-2 col-sm-2 col-xs-12 p-l-0">
                        <div class="form-group nw-pd">
                            <select required id="B" name="area_id" class="form-control slct">
                                <option value="">Area</option>
                            </select>
                        </div>
                    </div>






                    <div class="col-md-2 col-sm-2 col-xs-12 p-l-0">
                        <div class="form-group nw-pd">
                            <select name="status" class="form-control slct">
                                <option value="">Status</option>
                                <option @if(isset($data['status']) && $data['status']=="Recorded") selected @endif value="Recorded">Recorded</option>
                                <option @if(isset($data['status']) && $data['status']=="Picked Up") selected @endif value="Picked up">Picked Up</option>
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
                    <div class="col-md-2 col-sm-2 col-xs-12 p-l-0">
                        <div class="form-group nw-pd">
                            <select id="type" name="type" class="form-control slct">
                                <option value="">Searching Type</option>
                                <option @if(isset($data['type']) && $data['type']=="Item") selected @endif >Item</option>
                                <option @if(isset($data['type']) && $data['type']=="Receiver Name") selected @endif >Receiver Name</option>
                                <option @if(isset($data['type']) && $data['type']=="Mobile") selected @endif >Mobile</option>
                                <option @if(isset($data['type']) && $data['type']=="Security Number") selected @endif >Security Number</option>
                                <option @if(isset($data['type']) && $data['type']=="Tracking Number") selected @endif >Tracking Number</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">
                        <div class="form-group nw-pd">
                            <div class="col-md-6 col-xs-12 p-0" id="content-container">
                                <input type="text" name="search_value" value="@if(isset($data['search_value'])){{$data['search_value']}}@endif" class="form-control"  placeholder="Search Value">
                            </div>
                            <div class="col-md-3 col-xs-6 ">
                                <button onclick="filterOrders()" class="btn btn-gry p_17">Filter</button>
                            </div>
                            <div class="col-md-3 col-xs-1 ">
                                <a style="width: 167%"  href="{{route('orders.index')}}" class="btn btn-org p_17" style=" width:100%;">Reset</a>
                            </div>
                        </div>

                    </div>
                </form>
                <br><br><br>
                <div class="clearfix"></div>
                    <div class="table-responsive text-center">
                        <form id="orders-table-form" action="{{route("orders.printTable")}}" method="POST">
                            @csrf
                            <input type="hidden" name="search" value="@if(isset($data)){{json_encode($data)}}@endif">
                            <table class="table main-table">
                            <thead class="text-center">
                            <tr>
                                <th><input type="checkbox" name="all_orders" id="checkAll"></th>
                                <th>Tracking Num</th>
                                <th >Item</th>
                                <th>Receiver name</th>
                                <th>Mobile</th>
                                <th>City</th>
                                <th>Area</th>
                                <th>Address</th>
                                <th>Markup Place</th>
                                <th>COD</th>
                                <th>Security Number</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            @foreach($orders as $order)
                            <tr>
                                <td><input name="orders_id[]" value="{{$order->id}}" type="checkbox"  id="checkItem"></td>
                                <td>
                                    <a href="{{route('orders.show',$order->id)}}">{{$order->tracking_number}}</a>
                                </td>
                                <td>{{$order->description}}</td>
                                <td>{{$order->receiver_name}}</td>
                                <td>{{$order->mobile}}</td>
                                <td>{{$order->city->name}}</td>
                                <td>{{$order->area->name}}</td>
                                <td>{{$order->address}}</td>
                                <td>{{$order->mark_place}}</td>
                                <td>{{$order->cod}}</td>
                                <td>{{$order->security_number}}</td>
                                <td>{{$order->status}}</td>
                                <td>
                                    @if($order->editable && $order->status == 'Recorded')
                                        <a href="{{route('orders.edit',$order->id)}}"><img src="{{asset("assets/")}}/img/edit.png" ></a>
                                        <a href="javascript:;" onclick="deleteOrder('{{route('orders.destroy',$order->id)}}','{{$order->editable}}')"><img src="{{asset("assets/")}}/img/delete.png" ></a>
                                    @endif
                                        <a href="{{route('orders.show',$order->id)}}"><i class="fa fa-eye" style="font-size:20px; vertical-align:middle"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td class="orang-bg">Total {{$total_orders}} Order</td>
                                <td colspan="7"></td>
                                <td class="orang-bg">Total {{$total_cod}} </td>
                                <td colspan="4"></td>
                            </tr>
                            </tfoot>
                        </table>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">
                        <div class="table-btns">
                            <a href="{{route('orders.endOfDay')}}" class="btn btn-org">End of the day</a>
                            <button onclick="exportTable()" class="btn btn-gry"><i class="exl"></i> Export</button>
                            <a href="javascript:void(0);" onclick="printTable()" class="btn btn-gry"><i class="prnt"></i></a>
                        </div>
                    </div>
            </div>
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
        (function() {

            //setup an object fully of arrays
            //alternativly it could be something like
            //{"yes":[{value:sweet, text:Sweet}.....]}
            //so you could set the label of the option tag something different than the name
            var bOptions = {
            };
            @foreach(auth()->user()->shipping_fees as $fee)
                bOptions[{!! $fee->city->id !!}] = {!! $fee->city->areas!!}
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
                op.text = 'Area';
                for (var i in bOptions[_val]) {
                    //create option tag
                    var op = document.createElement('option');
                    //set its value
                    op.value = bOptions[_val][i].id;
                    //set the display label
                    op.text = bOptions[_val][i].name;
                    @if(isset($data['area_id']))
                        var temp = {!! json_encode($data['area_id']) !!};
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
    </script>

    <script>

        function deleteOrder(url,status) {
            $("#delete-order").attr('action', url);
            $('#squarespaceModal-77').modal('show');
        }

        function printTable() {
            $( "#orders-table-form" ).submit();
        }

        function filterOrders(){
            $("#orders").attr('action', "{!! route('orders.index') !!}");
            $("#orders").attr('method', "GET");
            $( "#orders" ).submit();
        }

        function exportTable() {
            $("#orders").attr('action', "{!! route('orders.export') !!}");
            $("#orders").attr('method', "GET");
            $( "#orders" ).submit();
        }

    </script>

    <script>
        (function() {

            var primarySelect = document.getElementById('type');
            primarySelect.onchange = function() {
                var _val = this.options[this.selectedIndex].value;
                {{--else if(_val == 'Tracking Number'){--}}
                    {{--$( "#content-container" ).html(`--}}
                    {{--<input type="text" name="tracking_number" value="@if(isset($data['tracking_number'])){{$data['tracking_number']}}@endif" data-role="tagsinput" id="tags-input" class="form-control">--}}
                    {{--`);--}}
                {{--}--}}
//                else{
                    $( "#content-container" ).html(
                        `
                            <input type="text" name="search_value" value="@if(isset($data['search_value'])){{$data['search_value']}}@endif" class="form-control"  placeholder="Search Value">
                        `
                    );
//                }
            };
        })();
    </script>



@endsection
