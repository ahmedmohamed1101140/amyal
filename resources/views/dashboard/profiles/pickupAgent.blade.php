@extends('dashboard.layout')
@section('title')Amyal l Pick up Agent @endsection
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
        <a href="#" class="breadcrumb-link">Pick Up Agents</a>
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
    <ul class="nav panel-tabs mytabs">
        <li class="active"><a href="#tab1" data-toggle="tab">Pickup Requests</a></li>
        <li><a href="#tab2" data-toggle="tab">Orders</a></li>
        {{--<li><a href="#tab3" data-toggle="tab">Meetings</a></li>--}}
        {{--<li><a href="#tab4" data-toggle="tab">Target</a></li>--}}
        {{--<li><a href="#tab5" data-toggle="tab">Attendance</a></li>--}}
    </ul>


    <div class="tab-content taby msgs-wrapper scrollbar" id="style-1">
        <div class="tab-pane active" id="tab1">
            <div class="table-responsive text-center">
                <h2 class="orang1 text-left" style="margin-bottom:10px; ">My pick up requests</h2>
                <table class="table main-table">
                    <thead class="text-center">
                    <tr>
                        <th>Request No</th>
                        <th>Acc No.</th>
                        <th>Company Name</th>
                        <th>Pick up Address</th>
                        <th>Request Date</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($requests as $request)
                        <tr>
                            <td>{{$request->req_number}}</td>
                            <td>{{$request->user->account_number}}</td>
                            <td>{{$request->user->company_name}}</td>
                            <td >{{$request->user->pickup_address}}</td>
                            <td>{{$request->created_at->format('d/m/Y')}}</td>
                            <td>
                                <button onclick="editRequest({{$request->id}})" class="btn btn-org nw-pad  m-t-10">Done</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4 col-sm-5 col-xs-12">
                {{$requests->render()}}
            </div>
        </div>
        <div class="tab-pane" id="tab2">
            <div class="table-responsive text-center">
                <h2 class="orang1 text-left" style="margin-bottom:10px; ">Orders to be returned</h2>
                <table class="table main-table">
                    <thead class="text-center">
                    <tr>
                        <th>Order Tracking Number</th>
                        <th>Acc No.</th>
                        <th>Company Name</th>
                        <th>Pick up Address</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($orders as $order)
                        <tr>
                            <td>{{$order->tracking_number}}</td>
                            <td>{{$order->user->account_number}}</td>
                            <td>{{$order->user->company_name}}</td>
                            <td>{{$order->user->pickup_address}}</td>
                            <td>
                                <button onclick="editOrder({{$order->id}})" class="btn btn-org nw-pad  m-t-10">Returned</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="orders-table">

    </div>

@endsection
@section('modals')
    <div class="modal fade" id="squarespaceModal-77" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="col-md-12 col-xs-12 text-center">
                        <h3 class="log-title" style="margin-top:5px">Update Status</h3>

                        <form id="assign-request" method="POST" action="">
                            @csrf
                            {{method_field('PUT')}}
                            <h4>Are you sure that you want to change this request status?</h4>
                            <input type="hidden" name="status" value="Done" id="status">
                            <input type="hidden" name="agent_id" value="{{auth()->user()->id}}" id="status">
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

    <div class="modal fade" id="squarespaceModal-8" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="col-md-12 col-xs-12 text-center">
                        <h3 class="log-title" style="margin-top:5px">Update Status</h3>

                        <form id="updateStatus" method="post" action="">
                            @csrf
                            <h4>Are you sure that you handel the order tho the client successfully!</h4>
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
        function editRequest($id) {
//            $("#status").val($("#change_select option:selected" ).text());
            $("#assign-request").attr('action', "{!! route('pickup_requests.update',['id' => '']) !!}" + "/" + $id);
            $("#assign-request").attr('method', "POST");
            $('#squarespaceModal-77').modal('show');
        }

        function editOrder($id) {
//            $("#status").val($("#change_select option:selected" ).text());
            $("#updateStatus").attr('action', "{!! route('pickupScanner.store',['id' => '']) !!}" + "/" + $id);
            $('#squarespaceModal-8').modal('show');
        }
    </script>
@endsection