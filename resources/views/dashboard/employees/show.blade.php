@extends('dashboard.layout')
@section('title')Amyal l Employees @endsection
@section('content')
        <nav id="breadcrumb" class="breadcrumb">
            <a href="#" class="breadcrumb-link">Employees</a>
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
        @if(auth()->user()->hasRole('employees.update'))
            <a href="#squarespaceModal-1" data-toggle="modal" class="btn btn-org">Update Profile</a>
        @endif
        <div class="section">
            <div class="table-responsive text-center">
                    <h2 class="orang1" style="margin-bottom:10px;">Employee Permissions</h2>
                    <form method="post" action="{{route('employees.permissions')}}">
                        @csrf
                        <table class="table main-table">
                            <thead class="text-center">
                            <tr>
                                <th><input type="checkbox" name="all_permissions" id="checkAll"></th>
                                <th>Permission Description</th>
                            </tr>
                            </thead>
                            <tbody >
                            @foreach($permissions as $permission)
                                <tr>
                                    <td><input @if($permission->agent_id == $agent->id)checked @endif name="permission[]" value="{{$permission->id}}" type="checkbox"  id="checkItem"></td>
                                    <td> <strong>{{$permission->description}}</strong></td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                        <input type="hidden" name="agent_id" value="{{$agent->id}}">
                        <br>
                        @if(auth()->user()->hasRole('employees.permissions'))
                            <button type="submit" class="btn btn-org">Set Permissions</button>
                        @endif
                    </form>
                </div>
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
                                    <input type="text" maxlength="190"  value="{{$agent->position}}" name="position" class="form-control" placeholder="Position" id="position">
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
    <script src="{{asset("admin_assets/")}}/js/multi-input.js"></script>

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
