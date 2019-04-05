@extends('dashboard.layout')
@section('title')Amyal l Employees @endsection
@section('content')
        <h2 class="orang1">Employees</h2>
        <div class="orders-table">
        <form id="employee-data" ">
            <input type="hidden" value="1" name="filter">
            @if(auth()->user()->hasRole('employees.store'))
                <div class="col-md-3 col-sm-3 col-xs-12 lft">
                    <a href="#squarespaceModal-1" data-toggle="modal" class="btn btn-gry"><i class="plusy"></i> Add New Employee</a>
                </div>
            <br><br><br>
            @endif
            <div class="col-md-2 col-sm-3 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input type="hidden" name="filter" value="1">
                    <input type="text" maxlength="190" value="@if(isset($data['name'])){{$data['name']}}@endif" name="name" class="form-control" placeholder="Search by Name">
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input type="text" minlength="3" maxlength="15" value="@if(isset($data['phone'])){{$data['phone']}}@endif" name="phone" class="form-control" placeholder="Search by Mobile">
                </div>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <select name="department_id" class="form-control slct">
                        <option value="" > Select Department</option>
                        @foreach($departments as $department)
                                <option @if(isset($data['department_id']) && $data['department_id'] == $department->id) selected @endif  value="{{$department->id}}">{{$department->name}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <select name="office_id" class="form-control slct">
                        <option value="">Select Office</option>
                        @foreach($offices as $office)
                            <option @if(isset($data['office_id']) && $data['office_id'] == $office->id) selected @endif value="{{$office->id}}">{{$office->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <select name="type" class="form-control slct">
                        <option value="">Employee Type</option>
                        <option @if(isset($data['type']) && $data['type'] == "Employee") selected @endif>Employee </option>
                        <option @if(isset($data['type']) && $data['type'] == "Sales Person") selected @endif>Sales Person</option>
                        <option @if(isset($data['type']) && $data['type'] == "Pickup Agent") selected @endif>Pickup Agent</option>
                        <option @if(isset($data['type']) && $data['type'] == "Delivery Agent") selected @endif>Delivery Agent</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1 col-xs-1 lft pull-left">
                <button onclick="filterEmployees()" class="btn btn-gry p_17" style=" width:100%;">Filter</button>
            </div>
        </form>
            <div class="col-md-1 col-xs-1 lft pull-right">
                <a href="{{route('employees.index')}}" class="btn btn-org p_17" style=" width:100%;">Reset</a>
            </div>
        <div class="clearfix"></div>
        <div class="table-responsive text-center">
            <table class="table main-table">
                <thead class="text-center">
                <tr>
                    <th>Employee Name</th>
                    <th>Email</th>
                    <th>Mobile No.</th>
                    <th>Department</th>
                    <th>Amyal Office</th>
                    <th>Type</th>
                    @if(auth()->user()->hasRole('employees.show') || auth()->user()->hasRole('employees.update'))
                        <th>Action</th>
                    @endif
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($agents as $agent)
                    <tr>
                        <td>{{$agent->name}}</td>
                        <td>{{$agent->email}}</td>
                        <td>{{$agent->phone}}</td>
                        <td>{{$agent->department->name}}</td>
                        <td>{{$agent->office->name}}</td>
                        <td>{{$agent->type}}</td>
                        @if(auth()->user()->hasRole('employees.show') || auth()->user()->hasRole('employees.update'))
                            <td>
                                <a href="{{ route('employees.show',$agent->id) }}"><i
                                            class="fa fa-edit edit-e"></i></a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
            <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">
                <div class="table-btns">
                    @if(auth()->user()->hasRole('employees.exportExcel'))
                        <button onclick="exportTable()" class="btn btn-org"><i class="exl"></i> Export</button>
                    @endif
                </div>
            </div>
        <div class="col-md-4 col-sm-5 col-xs-12">
            {{$agents->render()}}
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
                    <h3 class="log-title" style="margin-top:5px">Add New Employee</h3>
                    <form class="validatedForm" method="post" action="{{route('employees.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-4 col-sm-6 lft">
                            <div class="form-group nw-pd">
                                <select name="type" id="employee_type" required class="form-control slct">
                                    <option value="">Type</option>
                                    <option @if(old('type')=="Employee") selected @endif >Employee</option>
                                    <option @if(old('type')=="Sales Person") selected @endif >Sales Person</option>
                                    <option @if(old('type')=="Pickup Agent") selected @endif >Pickup Agent</option>
                                    <option @if(old('type')=="Delivery Agent") selected @endif >Delivery Agent</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 lft">
                            <div class="form-group nw-pd">
                                <input type="text" maxlength="190" disabled value="{{old('position')}}" name="position" class="form-control" placeholder="Position" id="position">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 rght">
                            <div class="form-group nw-pd">
                                <input type="text" maxlength="190" value="{{old('name')}}" name="name" required class="form-control" placeholder="Employee Name">
                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-6 col-sm-6 lft">
                            <div class="form-group nw-pd">
                                <input type="text" name="phone" value="{{old('phone')}}" maxlength="15" min="3" required  class="form-control" placeholder="Mobile Number">

                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 rght">
                            <div class="form-group nw-pd">
                                <input type="email" maxlength="190" name="email" value="{{old('email')}}" required class="form-control" placeholder="Email">

                            </div>
                        </div>
                        <div class="clearfix"></div>

                        {{--<div class="col-md-4 col-sm-4 lft">--}}
                            {{--<div class="form-group nw-pd">--}}
                                {{--<input type="text" maxlength="190" name="username" value="{{old('username')}}" required class="form-control" placeholder="Username">--}}

                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-md-6 col-sm-4 lft">
                            <div class="form-group nw-pd">
                                <input type="password"  required minlength="4" maxlength="50" name="password" class="form-control" placeholder="Password">

                            </div>
                        </div>
                        <div class="col-md-6 col-sm-4 rght">
                            <div class="form-group nw-pd">
                                <input type="password" minlength="4" maxlength="50" name="password_confirmation" required class="form-control" placeholder="Re-Password">

                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-4 col-sm-4 lft">
                            <div class="form-group nw-pd">
                                <input type="text" maxlength="15" minlength="13" value="{{old('GOV_number')}}" required name="GOV_number" class="form-control" placeholder="GOV. No">

                            </div>
                        </div>
                        <div class="col-md-8 col-sm-6 rght">
                            <div class="form-group nw-pd">
                                <input type="text" name="address" maxlength="400" value="{{old('address')}}" required class="form-control" placeholder="Address">

                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-4 col-sm-6 lft">
                            <div class="form-group nw-pd">
                                <select name="city_id" required class="form-control slct">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option @if(old('city_id') == $city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 rght">
                            <div class="form-group nw-pd">
                                <select name="office_id" required class="form-control slct">
                                    <option value="">Select Office</option>
                                    @foreach($offices as $office)
                                        <option @if(old('office_id') == $office->id) selected @endif value="{{$office->id}}">{{$office->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 rght">
                            <div class="form-group nw-pd">
                                <select name="department_id" id="A" required class="form-control slct">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option @if(old('department_id') == $department ->id) selected @endif value="{{$department->id}}" >{{$department->name}}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-4 col-sm-4 lft">
                            <div class="form-group nw-pd">
                                <input name="age"  autocomplete="off" required value="{{old('age')}}" class="form-control clndr tim" id="datetimepicker11" placeholder="Age">

                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 lft">
                            <div class="form-group nw-pd">
                                <input name="join_date" autocomplete="off"  required value="{{old('join_date')}}" class="form-control clndr tim" id="datetimepicker12" placeholder="Join Date">

                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 lft">
                            <div class="form-group nw-pd">
                                <input type="text" name="shift_from" value="{{old('shift_from')}}" readonly required id="timepicker" class="form-control timepicker" placeholder="Shift From"/>

                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 rght1">
                            <div class="form-group nw-pd">
                                <input type="text" name="shift_to" required value="{{old('shift_to')}}" readonly  class="form-control timepicker" placeholder="Shift To"/>

                            </div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-12 col-sm-12 lft">
                            <div class="form-group nw-pd">
                                <div class="custom-file-upload">
                                    <label for="file">Upload Image: </label>
                                    <input accept=".png, .jpg, .jpeg" type="file" required id="file1" placeholder="Company Logo" name="image"/>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-org pull-right nw-pad " style="margin-right:2px">Add</button>
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


        function filterEmployees(){
            $("#employee-data").attr('action', "{!! route('employees.index') !!}");
            $("#employee-data").attr('method', "GET");
            $( "#employee-data" ).submit();
        }


        function exportTable() {
            $("#employee-data").attr('action', "{!! route('employees.exportExcel') !!}");
            $("#employee-data").attr('method', "GET");
            $( "#employee-data" ).submit();
        }

    </script>
@endsection

