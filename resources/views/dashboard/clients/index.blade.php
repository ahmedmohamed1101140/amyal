@extends('dashboard.layout')
@section('title')Amyal l Clients @endsection
@section('content')
    <h2 class="orang1">Clients</h2>
    <div class="orders-table">
    <form id="client-data" method="get" action="{{route('clients.index')}}">
        <input type="hidden" value="1" name="filter">
        @if(auth()->user()->hasRole('clients.store'))
            <div class="col-md-2 col-sm-3 col-xs-12 lft">
                    <a href="#squarespaceModal-9" data-toggle="modal" class="btn btn-gry"><i class="plusy"></i>Add New Client</a>
            </div>
            <br><br><br>
        @endif
        <div class="col-md-2 col-sm-3 col-xs-12 lft">
            <div class="form-group nw-pd">
                    <input name="date" autocomplete="off" value="@if(isset($data['date'])){{$data['date']}}@endif" class="form-control clndr tim" id="datetimepicker12" placeholder="Date">
                </div>
            </div>
            <div class="col-md-4 col-sm-3 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input type="text" maxlength="190" value="@if(isset($data['name'])){{$data['name']}}@endif" name="name" class="form-control" placeholder="Search by Acc No,Company,Sales person">
                </div>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <select name="type"  class="form-control slct">
                        <option value="">Type</option>
                        <option @if(isset($data['type']) && $data['type']== 'company') selected @endif value="company">Company</option>
                        <option @if(isset($data['type']) && $data['type']== 'account_number') selected @endif value="account_number">Account Number</option>
                        <option @if(isset($data['type']) && $data['type']== 'sales_person') selected @endif value="sales_person">Sales Person</option>
                    </select>
                </div>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <select name="office_id"  class="form-control slct">
                        <option value="">Select Office</option>
                        @foreach($offices as $office)
                            <option @if(isset($data['office_id']) && $data['office_id']== $office->id) selected @endif value="{{$office->id}}">{{$office->name}}</option>
                            @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-1 col-xs-1 lft pull-left">
                <button onclick="filterClients()" class="btn btn-gry p_17" style=" width:100%;">Filter</button>
            </div>
            <div class="col-md-1 col-xs-3 lft pull-left">
                <a href="{{route('clients.index')}}" class="btn btn-org p_17">Reset</a>
            </div>
        </form>
    <div class="clearfix"></div>
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
            @foreach($clients as $client)
                <tr>
                    <td>{{$client->id}}</td>
                    <td>{{$client->account_number}}</td>
                        <td >
                            @if(auth()->user()->hasRole('clients.show'))
                            <a href="{{route('clients.show',$client->id)}}">
                                {{$client->company_name}}
                            </a>
                            @else
                                {{$client->company_name}}
                            @endif
                        </td>
                    <td>{{$client->cp_name}}</td>
                    <td >{{$client->phone}}</td>
                    <td>{{$client->status}}</td>
                    <td>{{\Carbon\Carbon::parse($client->created_at)->format('d/m/Y')}}</td>
                    <td >{{$client->agent->name}}</td>
                    <td >{{$client->office->name}}</td>
                </tr>
            @endforeach

            </tbody>


        </table>
    </div>
    <div class="clearfix"></div>
        <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">
            <div class="table-btns">
                @if(auth()->user()->hasRole('clients.exportExcel'))
                    <button onclick="exportTable()" class="btn btn-org"><i class="exl"></i> Export</button>
                @endif
            </div>
        </div>
        <div class="col-md-4 col-sm-5 col-xs-12">
            {{$clients->render()}}
        </div>
</div>
@endsection

@section('modals')
    <div class="modal fade" id="squarespaceModal-9" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                @if ($errors->any())
                    <script>
                        window.onload = function () {
                            $('#squarespaceModal-9').modal('show');
                        }
                    </script>
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="color:#fff">&times;</span></button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="col-md-12 col-xs-12">
                    <h3 class="log-title" style="margin-top:5px">Add New Client</h3>

                    <form method="POST" action="{{route('clients.store')}}">
                        @csrf
                        <div class="col-md-6 col-sm-6 lft">
                            <div class="form-group nw-pd">
                                <input maxlength="190" type="text" value="{{old('company_name')}}" required name="company_name" class="form-control" placeholder="Company Name">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 rght">
                            <div class="form-group nw-pd">
                                <input type="number" required value="{{old('phone')}}" name="phone" class="form-control" placeholder="Mobile Number">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-3 col-sm-3 lft">
                            <div class="form-group nw-pd">
                                <select name="city_id" required class="form-control slct">
                                    <option value="">City</option>
                                    @foreach($cities as $city)
                                        <option @if(old('city_id') == $city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-9 col-sm-9 rght">
                            <div class="form-group nw-pd">
                                <input type="email" maxlength="190" value="{{old('email')}}" required name="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 col-sm-12 p-0">
                            <div class="form-group nw-pd">
                                <input type="text" maxlength="400" value="{{old('address')}}" name="address" required class="form-control" placeholder="Address">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 col-sm-12 p-0">
                            <div class="form-group nw-pd">
                                <input type="text" maxlength="400" value="{{old('pickup_address')}}" name="pickup_address" required class="form-control" placeholder="Pick up address">
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-6 col-sm-6 lft">
                            <div class="form-group nw-pd">
                                <input type="text" maxlength="190" value="{{old('cp_name')}}"  name="cp_name" required class="form-control" placeholder="Contact person name">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 rght">
                            <div class="form-group nw-pd">
                                <input type="number" maxlength="15" minlength="3" value="{{old('cp_phone')}}" name="cp_phone" required class="form-control" placeholder="Contact person mobile num">
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-6 col-sm-6 lft">
                            <div class="form-group nw-pd">
                                <input type="password" maxlength="50" minlength="4" value="{{old('password')}}" name="password" required class="form-control" placeholder="Password">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 rght">
                            <div class="form-group nw-pd">
                                <input type="password" maxlength="50" minlength="4" name="password_confirmation" required class="form-control" placeholder="Confirm Password">
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-6 col-sm-6 lft">
                            <div class="form-group nw-pd">
                                <select name="office_id" required id="A" class="form-control slct">
                                    <option value="">Amyal office</option>
                                    @foreach($offices as $office)
                                        <option @if(old('office_id') == $office->id) selected @endif value="{{$office->id}}">{{$office->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 rght">
                            <div class="form-group nw-pd">
                                <select name="agent_id" required id="B" class="form-control slct">

                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <button type="submit" class="btn btn-org pull-right nw-pad " style="margin-right:0">Add</button>
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
        @if ($errors->any())
            window.onload = function () {
                $('#squarespaceModal-9').modal('show');
            };
        @endif
    </script>
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
                op.text = 'Sales Person';
                for (var i in bOptions[_val]) {

                    if(bOptions[_val][i].type == 'Sales Person'){
                        //create option tag
                        var op = document.createElement('option');
                        //set its value
                        op.value = bOptions[_val][i].id;
                        //set the display label
                        op.text = bOptions[_val][i].name;

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



            var A = document.getElementById('C');
            var B = document.getElementById('D');

            //on change is a good event for this because you are guarenteed the value is different
            A.onchange = function() {
                //clear out B
                B.length = 0;
                //get the selected value from A
                var _val = this.options[this.selectedIndex].value;

                var bool = 0;

                var op = document.createElement('option');
                op.value = '';
                op.text = 'Sales Person';
                for (var i in bOptions[_val]) {
                    //create option tag
                    var op = document.createElement('option');
                    //set its value
                    op.value = bOptions[_val][i].id;
                    //set the display label
                    op.text = bOptions[_val][i].name;
                    {{--var temp = {!! json_encode(old('position_id')) !!};--}}
                    {{--if( temp == op.value ){--}}
                    {{--op.selected = true;--}}
                    {{--bool = 1;--}}
                    {{--}--}}

                    //append it to B
                    B.appendChild(op);
                }

                B.appendChild(op);

            };


            //fire this to update B on load
            A.onchange();

        })();

        function filterClients(){
            $("#client-data").attr('action', "{!! route('clients.index') !!}");
            $("#client-data").attr('method', "GET");
            $( "#client-data" ).submit();
        }


        function exportTable() {
            $("#client-data").attr('action', "{!! route('clients.exportExcel') !!}");
            $("#client-data").attr('method', "GET");
            $( "#client-data" ).submit();
        }
    </script>
@endsection

