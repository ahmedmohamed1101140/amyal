    @extends('dashboard.layout')
    @section('title')Amyal l Sales Person @endsection
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
            <a href="{{route('profile')}}" class="breadcrumb-link">Sales Manager Report</a>
            <a href="#breadcrumb" class="breadcrumb--active">Sales Employee Profile</a>
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
                        <div class="col-md-2 col-sm-2 rght">
                            <h5 class="orang2">Office: <span style="color:#5f6062">{{auth()->user()->office->name}}</span></h5>
                        </div>
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
            <li class="active"><a href="#tab1" data-toggle="tab">Clients</a></li>
            {{--<li><a href="#tab2" data-toggle="tab">Calls</a></li>--}}
            {{--<li><a href="#tab3" data-toggle="tab">Meetings</a></li>--}}
            {{--<li><a href="#tab4" data-toggle="tab">Target</a></li>--}}
            {{--<li><a href="#tab5" data-toggle="tab">Attendance</a></li>--}}
        </ul>

        <div class="tab-content taby msgs-wrapper scrollbar" id="style-1">
            <div class="tab-pane active" id="tab1">
                <div class="table-responsive text-center">
                    <table class="table main-table">
                        <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Acc No.</th>
                            <th>Company Name</th>
                            <th>Contact Person</th>
                            <th>Mobile Number</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Sales Person</th>
                            <th>Amyal Office</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                        @foreach(auth()->user()->clients as $client)
                            <tr>
                                <td>{{$client->id}}</td>
                                <td>{{$client->account_number}}</td>
                                <td ><a href="{{route('clients.show',$client->id)}}">{{$client->company_name}}</a></td>
                                <td>{{$client->cp_name}}</td>
                                <td >{{$client->phone}}</td>
                                <td>{{$client->status}}</td>
                                <td>{{\Carbon\Carbon::parse($client->created_at)->format('d/m/Y h:i A')}}</td>
                                <td >{{$client->agent->name}}</td>
                                <td >{{$client->office->name}}</td>
                            </tr>
                        @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
            {{--<div class="tab-pane" id="tab2">--}}
                {{--<a href="#squarespaceModal-10" data-toggle="modal" class="btn btn-org">Add New Call</a>--}}
                {{--<div class="table-responsive text-center">--}}
                    {{--<table class="table main-table" style="font-size:14px">--}}
                        {{--<thead class="text-center">--}}
                        {{--<tr>--}}
                            {{--<th>Date</th>--}}
                            {{--<th>Time</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody class="text-center">--}}
                            {{--@foreach($calls as $call)--}}
                                {{--<tr>--}}
                                    {{--<td>{{$call->date}}</td>--}}
                                    {{--<td>{{$call->time}}</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="tab-pane" id="tab3">--}}
                {{--<a href="#squarespaceModal-11" data-toggle="modal" class="btn btn-org">Add New Meeting</a>--}}
                {{--<div class="table-responsive text-center">--}}
                    {{--<table class="table main-table" style="font-size:14px">--}}
                        {{--<thead class="text-center">--}}
                        {{--<tr>--}}
                            {{--<th> Date</th>--}}
                            {{--<th> Time</th>--}}
                            {{--<th>Client Name</th>--}}
                            {{--<th>Person Name</th>--}}
                            {{--<th>Person Number</th>--}}
                            {{--<th>Address</th>--}}
                            {{--<th>Meeting Result</th>--}}
                            {{--<th>View</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody class="text-center">--}}
                            {{--@foreach($meetings as $meeting)--}}
                                {{--<tr>--}}
                                    {{--<td >{{$meeting->date}}</td>--}}
                                    {{--<td >{{$meeting->time}}</td>--}}
                                    {{--<td>{{$meeting->client_name}}</td>--}}
                                    {{--<td >{{$meeting->person_name}}</td>--}}
                                    {{--<td>{{$meeting->person_number}}</td>--}}
                                    {{--<td >{{$meeting->address}}</td>--}}
                                    {{--<td>{{$meeting->result}}</td>--}}
                                    {{--<td>--}}
                                        {{--<a href="javascript:;" onclick='viewMeeting("{{$meeting->id}}")'><i--}}
                                                    {{--class="fa fa-edit edit-e"></i></a>--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="tab-pane" id="tab4">--}}
                {{--<div class="table-responsive text-center">--}}
                    {{--<table class="table main-table" style="font-size:14px">--}}
                        {{--<thead class="text-center">--}}
                        {{--<tr>--}}
                            {{--<th>Target No</th>--}}
                            {{--<th>Target</th>--}}
                            {{--<th>Max</th>--}}
                            {{--<th>Percentge</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody class="text-center">--}}
                            {{--@foreach($targets as $target)--}}
                                {{--<tr>--}}
                                    {{--<td >{{$target->id}}</td>--}}
                                    {{--<td>{{$target->name}}</td>--}}
                                    {{--<td >{{$target->max}}</td>--}}
                                    {{--<td>{{$target->percent}}</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}

            {{--<div class="tab-pane" id="tab5">--}}
                {{--<a href="#squarespaceModal-13" data-toggle="modal" class="btn btn-org">Add New Day</a>--}}
                {{--<div class="table-responsive text-center">--}}
                    {{--<table class="table main-table" style="font-size:14px">--}}
                        {{--<thead class="text-center">--}}
                        {{--<tr>--}}
                            {{--<th>Date</th>--}}
                            {{--<th>Check In</th>--}}
                            {{--<th>Check Out</th>--}}
                        {{--</tr>--}}
                        {{--</thead>--}}
                        {{--<tbody class="text-center">--}}
                            {{--@foreach($attendances as $attendance)--}}
                                {{--<tr>--}}
                                    {{--<td >{{$attendance->day}}</td>--}}
                                    {{--<td>{{$attendance->checkIn}}</td>--}}
                                    {{--<td >{{$attendance->checkOut}}</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</div>--}}
            {{--</div>--}}

        </div>


    @endsection
    @section('modals')

        {{--<div class="modal fade" id="squarespaceModal-10" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">--}}
            {{--<div class="modal-dialog">--}}
                {{--<div class="modal-content">--}}

                    {{--<div class="modal-body">--}}

                        {{--<div class="col-md-12 col-xs-12">--}}
                            {{--<h3 class="log-title" style="margin-top:5px">Add New Call</h3>--}}

                            {{--<form method="post" action="{{route('profile.newCall')}}">--}}
                                {{--@csrf--}}
                                {{--<div class="col-md-12 col-sm-12 lft">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<input name="date" required autocomplete="off" class="form-control clndr tim" id="datetimepicker6" placeholder="Date">--}}
                                        {{--@if ($errors->has('date'))--}}
                                            {{--<span class="invalid-feedback" role="alert">--}}
                                                {{--<strong>{{ $errors->first('date') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix"></div>--}}
                                {{--<div class="col-md-12 col-sm-12 lft">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<input type="text" name="time" readonly required id="timepicker" class="form-control timepicker" placeholder="Time"/>--}}
                                        {{--@if ($errors->has('time'))--}}
                                            {{--<span class="invalid-feedback" role="alert">--}}
                                                {{--<strong>{{ $errors->first('time') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix"></div>--}}
                                {{--<div class="col-md-12 col-sm-12 text-center lft">--}}
                                    {{--<button type="submit" class="btn btn-org pull-right nw-pad " style="margin-right:0">Add</button>--}}
                                {{--</div>--}}
                            {{--</form>--}}
                        {{--</div>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="modal fade" id="squarespaceModal-11" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">--}}
            {{--<div class="modal-dialog">--}}
                {{--<div class="modal-content">--}}
                    {{--<div class="modal-body">--}}
                        {{--<div class="col-md-12 col-xs-12">--}}
                            {{--<h3 class="log-title" style="margin-top:5px">Add New Meeting</h3>--}}
                            {{--<form method="post" action="{{route('profile.newMeeting')}}">--}}
                                {{--@csrf--}}
                                {{--<div class="col-md-3 col-sm-3 lft">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<input name="date" required autocomplete="off" class="form-control clndr tim" id="datetimepicker7" placeholder="Date">--}}
                                        {{--@if ($errors->has('date'))--}}
                                            {{--<span class="invalid-feedback" role="alert">--}}
                                                {{--<strong>{{ $errors->first('date') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-3 col-sm-3 lft">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<input type="text" name="time" readonly required id="timepicker" class="form-control timepicker" placeholder="Time"/>--}}
                                        {{--@if ($errors->has('time'))--}}
                                            {{--<span class="invalid-feedback" role="alert">--}}
                                                {{--<strong>{{ $errors->first('time') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6 col-sm-6 rght">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<input type="text" name="client_name" required maxlength="190" minlength="3" class="form-control" placeholder="Client Name">--}}
                                        {{--@if ($errors->has('client_name'))--}}
                                            {{--<span class="invalid-feedback" role="alert">--}}
                                                {{--<strong>{{ $errors->first('client_name') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix"></div>--}}
                                {{--<div class="col-md-6 col-sm-6 lft">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<input type="text" name="person_name" required maxlength="190" minlength="3"  class="form-control" placeholder="Person Name">--}}
                                        {{--@if ($errors->has('person_name'))--}}
                                            {{--<span class="invalid-feedback" role="alert">--}}
                                                {{--<strong>{{ $errors->first('person_name') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6 col-sm-6 rght">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<input type="text" name="person_number" required maxlength="190" minlength="3" class="form-control" placeholder="Person Number">--}}
                                        {{--@if ($errors->has('person_number'))--}}
                                            {{--<span class="invalid-feedback" role="alert">--}}
                                                {{--<strong>{{ $errors->first('person_number') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix"></div>--}}
                                {{--<div class="col-md-12 col-sm-12 p-0">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<input type="text" name="address" required maxlength="500" minlength="3" class="form-control" placeholder="Address">--}}
                                        {{--@if ($errors->has('address'))--}}
                                            {{--<span class="invalid-feedback" role="alert">--}}
                                                {{--<strong>{{ $errors->first('address') }}</strong>--}}
                                            {{--</span>--}}
                                        {{--@endif--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix"></div>--}}
                                {{----}}
                                {{--<div class="clearfix"></div>--}}
                                {{--<div class="col-md-12 col-sm-12 p-0">--}}
                                    {{----}}
                                    {{--<div class="form-group nw-pd rdio">--}}
                                        {{--<p><strong>Meeting Result</strong>--}}
                                            {{--<label>--}}
                                                {{--<input type="radio" value="Quote" onclick="javascript:resultCheck();" name="result" id="noCheck" id="noCheck">--}}
                                                {{--Quote</label>--}}
                                            {{--<label>--}}
                                                {{--<input value="Order" type="radio"onclick="javascript:resultCheck();" name="result" id="noCheck" id="noCheck">--}}
                                                {{--Order</label>--}}
                                            {{--<label>--}}
                                                {{--<input type="radio" value="Request" onclick="javascript:resultCheck();" name="result" id="noCheck" id="noCheck">--}}
                                                {{--Request</label>--}}
                                            {{--<label>--}}
                                                {{--<input type="radio" value="Canceled" onclick="javascript:resultCheck();" name="result" id="yesCheck">--}}
                                                {{--Cancelled</label>--}}
                                        {{--</p>--}}
                                        {{--<div id="ifYes" style="visibility:hidden">--}}
                                            {{--<input type='text' id='why' value="" name='reason' maxlength="4000" minlength="3" required placeholder="Why?" class="form-control">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}




                                {{--<div class="clearfix"></div>--}}
                                {{--<button type="submit" class="btn btn-org pull-right nw-pad " style="margin-right:0">Add</button>--}}
                            {{--</form>--}}
                        {{--</div>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="modal fade" id="squarespaceModal-12" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">--}}
            {{--<div class="modal-dialog">--}}
                {{--<div class="modal-content">--}}
                    {{--<div class="modal-body">--}}
                        {{--<div class="col-md-12 col-xs-12">--}}
                            {{--<h3 class="log-title" style="margin-top:5px">Meeting Details</h3>--}}
                                {{--<div class="col-md-3 col-sm-3 lft">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<p><strong>Date:</strong>--}}
                                        {{--<h4 id="m_date"></h4>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-3 col-sm-3 lft">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<p><strong>Time</strong>--}}
                                        {{--<h4 id="m_time"></h4>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6 col-sm-6 rght">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<p><strong>Client Name</strong>--}}
                                        {{--<h4 id="m_client_name"></h4>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix"></div>--}}
                                {{--<div class="col-md-6 col-sm-6 lft">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<p><strong>Person Name</strong>--}}
                                        {{--<h4 id="m_person_name"></h4>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="col-md-6 col-sm-6 rght">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<p><strong>Person Number</strong>--}}
                                        {{--<h4 id="m_person_number"></h4>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix"></div>--}}
                                {{--<div class="col-md-12 col-sm-12 p-0">--}}
                                    {{--<div class="form-group nw-pd">--}}
                                        {{--<p><strong>address</strong>--}}
                                        {{--<h4 id="m_address"></h4>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<div class="clearfix"></div>--}}

                                {{--<div class="clearfix"></div>--}}
                                {{--<div class="col-md-12 col-sm-12 p-0">--}}

                                    {{--<div class="form-group nw-pd rdio">--}}
                                        {{--<p><strong>Meeting Result</strong>--}}
                                            {{--<label id="m_result"></label>--}}
                                        {{--</p>--}}
                                        {{--<div id="ifYes1" style="visibility:hidden">--}}
                                            {{--<p><strong>reason</strong>--}}
                                            {{--<h4 id="m_why"></h4>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}


                                {{--<div class="clearfix"></div>--}}

                        {{--</div>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

        {{--<div class="modal fade" id="squarespaceModal-13" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">--}}
            {{--<div class="modal-dialog">--}}
                {{--<div class="modal-content">--}}

                    {{--<div class="modal-body">--}}

                        {{--<div class="col-md-12 col-xs-12">--}}
                            {{--<h3 class="log-title" style="margin-top:5px">Add New Day</h3>--}}

                            {{--<form method="post" action="{{route('profile.newAttendance')}}">--}}
                                {{--@csrf--}}
                                {{--<div class="col-md-12 col-sm-12 p-0">--}}
                                    {{--<div class="form-group clearfix">--}}
                                        {{--<div class="rltv" >--}}
                                            {{--<div class="col-md-2 col-sm-2 lft">--}}
                                                {{--<h5 style="margin-top:5px">Date: <span>{{$today}}</span> </h5>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-5 col-sm-3 rght">--}}
                                                {{--<input type="text" name="checkIn" readonly required id="timepicker" class="form-control timepicker" placeholder="Check In"/>--}}
                                                {{--@if ($errors->has('checkIn'))--}}
                                                    {{--<span class="invalid-feedback" role="alert">--}}
                                                        {{--<strong>{{ $errors->first('checkIn') }}</strong>--}}
                                                    {{--</span>--}}
                                                {{--@endif--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-5 col-sm-2 rght">--}}
                                                {{--<input type="text" name="checkOut" readonly required id="timepicker" class="form-control timepicker" placeholder="Check Out"/>--}}
                                                {{--@if ($errors->has('checkOut'))--}}
                                                    {{--<span class="invalid-feedback" role="alert">--}}
                                                        {{--<strong>{{ $errors->first('checkOut') }}</strong>--}}
                                                    {{--</span>--}}
                                                {{--@endif--}}
                                            {{--</div>--}}
                                        {{--</div>--}}

                                    {{--</div>--}}
                                {{--</div>--}}

                                {{--<div class="clearfix"></div>--}}
                                {{--<div class="col-md-12 col-sm-12 text-center lft">--}}
                                    {{--<button type="submit" class="btn btn-org pull-right nw-pad " style="margin-right:0">Add</button>--}}
                                {{--</div>--}}

                            {{--</form>--}}
                        {{--</div>--}}
                        {{--<div class="clearfix"></div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}

    {{--@endsection--}}
    {{----}}

    {{--@section('js')--}}
        {{--<script>--}}
            {{--$(document).ready(function(){--}}
                {{--$('.timepicker').mdtimepicker(); //Initializes the time picker--}}
            {{--});--}}

            {{--function resultCheck() {--}}
                {{--if (document.getElementById('yesCheck').checked) {--}}
                    {{--document.getElementById('ifYes').style.visibility = 'visible';--}}
                {{--}--}}
                {{--else {--}}
                    {{--document.getElementById('ifYes').style.visibility = 'hidden';--}}
                    {{--$("#why").val("");--}}
                {{--}--}}
            {{--}--}}

            {{--function viewMeeting(id) {--}}
                {{--@foreach($meetings as $meeting)--}}
                {{--var temp = {!! json_encode($meeting->id) !!};--}}
                    {{--if( temp == id ){--}}
                        {{--$('#m_date').text({!! json_encode($meeting->date) !!});--}}
                        {{--$('#m_time').text({!! json_encode($meeting->time) !!});--}}
                        {{--$('#m_client_name').text({!! json_encode($meeting->client_name) !!});--}}
                        {{--$('#m_person_name').text({!! json_encode($meeting->person_name) !!});--}}
                        {{--$('#m_person_number').text({!! json_encode($meeting->person_number) !!});--}}
                        {{--$('#m_result').text({!! json_encode($meeting->result) !!});--}}
                        {{--$('#m_address').text({!! json_encode($meeting->address) !!});--}}
                        {{--$('#m_why').text({!! json_encode($meeting->reason) !!});--}}
                        {{--if($('#m_result').text() == 'Canceled'){--}}
                            {{--document.getElementById('ifYes1').style.visibility = 'visible';--}}
                        {{--}--}}
                        {{--$('#squarespaceModal-12').modal('show');--}}
                    {{--}--}}
                {{--@endforeach--}}
            {{--}--}}
        {{--</script>--}}
    {{--@endsection--}}