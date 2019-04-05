@extends('dashboard.layout')
@section('title')Amyal l Sales Person @endsection
@section('content')
    <nav id="breadcrumb" class="breadcrumb">
        <a href="#" class="breadcrumb-link">Sales Person</a>
        <a href="#" class="breadcrumb--active">{{$agent->name}}</a>
    </nav>
    <h2 class="orang1" style="margin-bottom:10px; margin-top:0px">Personal Information</h2>
    <div class="profily">
        <div class="col-md-1 col-sm-1 lft">
            <div class="bordy"></div>
        </div>
        <div class="col-md-11 col-sm-11 rght">
            <div class="profily-details">
                <div class="user-img">
                    <img src="{{asset('storage/images/agent/'.$agent->image)}}" alt="user_image">
                </div>

                <div class="col-md-11 col-sm-11 col-md-offset-1 col-sm-offset-1 lft">
                    <div class="col-md-4 col-sm-4 lft">
                        <h5 class="orang2">Name: <span style="color:#5f6062">{{$agent->name}}</span></h5>
                    </div>
                    <div class="col-md-3 col-sm-3 rght1">
                        <h5 class="orang2">Mobile: <span style="color:#5f6062">{{$agent->phone}}</span></h5>
                    </div>
                    <div class="col-md-4 col-sm-4 rght1">
                        <h5 class="orang2">Email: <span style="color:#5f6062">{{$agent->email}}</span></h5>
                    </div>
                    <div class="col-md-1 col-sm-1 rght">
                        <h5 class="orang2">Age: <span style="color:#5f6062">{{\Carbon\Carbon::parse($agent->age)->diff(\Carbon\Carbon::now())->format('%y years')}}</span></h5>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-7 col-sm-7 lft">
                        <h5 class="orang2">Address: <span style="color:#5f6062">{{$agent->address}}</span></h5>
                    </div>
                    <div class="col-md-5 col-sm-5 rght1">
                        <h5 class="orang2">GOV No: <span style="color:#5f6062">{{$agent->ssn}}</span></h5>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4 col-sm-4 lft">
                        <h5 class="orang2">Join date: <span style="color:#5f6062">{{\Carbon\Carbon::parse($agent->join_date)->format('d/m/y')}}</span></h5>
                    </div>
                    <div class="col-md-3 col-sm-3 rght1">
                        <h5 class="orang2">Department: <span style="color:#5f6062">{{$agent->department->name}}</span></h5>
                    </div>
                    <div class="col-md-3 col-sm-3 rght1">
                        <h5 class="orang2">Position: <span style="color:#5f6062">{{$agent->position}}</span></h5>
                    </div>
                    <div class="col-md-2 col-sm-2 rght">
                        <h5 class="orang2">Office: <span style="color:#5f6062">{{$agent->office->name}}</span></h5>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>
    <br>
    <a href="#squarespaceModal-1" data-toggle="modal" class="btn btn-org">Update Profile</a>

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
                    @foreach($agent->clients as $client)
                        <tr>
                            <td>{{$client->id}}</td>
                            <td>{{$client->account_number}}</td>
                            <td >{{$client->company_name}}</td>
                            <td>{{$client->cp_name}}</td>
                            <td >{{$client->phone}}</td>
                            <td>{{$client->status}}</td>
                            <td>{{$client->created_at->diffForHumans()}}</td>
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
    <div class="modal fade" id="squarespaceModal-1" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12 col-xs-12">
                        @if($errors->any())
                            <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="color:#fff">&times;</span></button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h3 class="log-title" style="margin-top:5px">Edit Employee Data</h3>
                        <form method="post" class="validatedForm" action="{{route('employees.update',$agent->id)}}" enctype="multipart/form-data">
                            @csrf
                            {{method_field('PUT')}}
                            <input type="hidden"  name="agent_id" value="{{$agent->id}}">
                            <div class="col-md-4 col-sm-6 lft">
                                <div class="form-group nw-pd">
                                    <select disabled name="type" required id="employee_type"  class="form-control slct">
                                        <option value="">Type</option>
                                        <option @if($agent->type =="Employee") selected @endif >Employee</option>
                                        <option @if($agent->type =="Sales Person") selected @endif >Sales Person</option>
                                        <option @if($agent->type =="Pickup Agent") selected @endif >Pickup Agent</option>
                                        <option @if($agent->type=="Delivery Agent") selected @endif >Delivery Agent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 lft">
                                <div class="form-group nw-pd">
                                    <input type="text" maxlength="190" disabled  value="{{$agent->position}}" name="position" class="form-control" placeholder="Position" id="position">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 rght">
                                <div class="form-group nw-pd">
                                    <input type="text" maxlength="190" value="{{$agent->name}}" name="name" required class="form-control" placeholder="Employee Name">
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-6 col-sm-6 lft">
                                <div class="form-group nw-pd">
                                    <input type="text" minlength="3" name="phone" value="{{$agent->phone}}" maxlength="15" required  class="form-control" placeholder="Mobile Number">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 rght">
                                <div class="form-group nw-pd">
                                    <input type="email" maxlength="190" name="email" value="{{$agent->email}}" required class="form-control" placeholder="Email">
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            {{--<div class="col-md-4 col-sm-4 lft">--}}
                                {{--<div class="form-group nw-pd">--}}
                                    {{--<input type="text" maxlength="255" name="username" value="{{$agent->username}}" required class="form-control" placeholder="Username">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="col-md-6 col-sm-4 lft">
                                <div class="form-group nw-pd">
                                    <input type="password" minlength="4" maxlength="50" name="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-4 rght">
                                <div class="form-group nw-pd">
                                    <input type="password" minlength="4" maxlength="50" name="password_confirmation" class="form-control" placeholder="Re-Password">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-4 col-sm-4 lft">
                                <div class="form-group nw-pd">
                                    <input type="text" maxlength="15" minlength="13" value="{{$agent->ssn}}" required name="GOV_number" class="form-control" placeholder="GOV. No">
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-6 rght">
                                <div class="form-group nw-pd">
                                    <input maxlength="400" type="text" name="address" value="{{$agent->address}}" required class="form-control" placeholder="Address">
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-4 col-sm-6 lft">
                                <div class="form-group nw-pd">
                                    <select name="city_id" required class="form-control slct">
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                            <option @if($agent->city_id == $city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 rght">
                                <div class="form-group nw-pd">
                                    <select name="office_id" required class="form-control slct">
                                        <option value="">Select Office</option>
                                        @foreach($offices as $office)
                                            <option @if($agent->office_id == $office->id) selected @endif value="{{$office->id}}">{{$office->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 rght">
                                <div class="form-group nw-pd">
                                    <select name="department_id" id="A" required class="form-control slct">
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option @if($agent->department_id == $department ->id) selected @endif value="{{$department->id}}" >{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-md-4 col-sm-4 lft">
                                <div class="form-group nw-pd">
                                    <input name="age" autocomplete="off" required value="{{\Carbon\Carbon::parse($agent->age)->format('d/m/Y')}}" class="form-control clndr tim" id="datetimepicker11" placeholder="Age">
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4 lft">
                                <div class="form-group nw-pd">
                                    <input name="join_date" autocomplete="off" required value="{{\Carbon\Carbon::parse($agent->join_date)->format('d/m/Y')}}" class="form-control clndr tim" id="datetimepicker12" placeholder="Join Date">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-3 lft">
                                <div class="form-group nw-pd">
                                    <input type="text" name="shift_from" value="{{$agent->shift_from}}" readonly required id="timepicker" class="form-control timepicker" placeholder="Shift From"/>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-3 rght1">
                                <div class="form-group nw-pd">
                                    <input type="text" name="shift_to" required value="{{$agent->shift_to}}" readonly  class="form-control timepicker" placeholder="Shift To"/>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-12 col-sm-12 lft">
                                <div class="form-group nw-pd">
                                    <div class="custom-file-upload">
                                        <label for="file">Upload Image: </label>
                                        <input accept=".png, .jpg, .jpeg" type="file" id="file1" placeholder="Company Logo" name="image"/>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-org pull-right nw-pad " style="padding: 5px 10px 7px;">Update</button>
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
        $(document).ready(function(){
            $('.timepicker').mdtimepicker(); //Initializes the time picker
        });

        $( "#employee_type" ).change(function() {
            if($(this).find(":selected").text() == 'Employee'){
                console.log($(this).find(":selected").text() );
                $("#position").removeAttr('disabled');
            }
            else {
                $("#position").val("");
                $("#position").attr('disabled','disabled');
            }
        });


    </script>
@endsection
