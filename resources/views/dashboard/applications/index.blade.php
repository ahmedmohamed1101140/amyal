@extends('dashboard.layout')
@section('title')Amyal l Client Requests @endsection
@section('content')
    <h2 class="orang1">Client Requests</h2>
    <div class="orders-table">
        <form id="applications" >
            <input type="hidden" value="1" name="filter">
            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input name="date_from" autocomplete="off" value="@if(isset($data['date_from'])){{$data['date_from']}}@endif" class="form-control clndr tim" id="datetimepicker12" placeholder="Date from">
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input name="date_to" autocomplete="off" value="@if(isset($data['date_to'])){{$data['date_to']}}@endif" class="form-control clndr tim" id="datetimepicker13" placeholder="Date to">
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 lft">
                <div class="col-md-6 col-sm-6 col-xs-12 lft">
                    <div class="form-group nw-pd">
                        {{--<input type="text" value="@if(isset($data['name'])){{$data['name']}}@endif" name="name" class="form-control" placeholder="Name">--}}
                        <input type="text" maxlength="190" value="@if(isset($data['name'])){{$data['name']}}@endif" name="name" class="form-control" placeholder="Agent">
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 p-0">
                    <div class="form-group nw-pd">
                        <input type="text" maxlength="15" minlength="3" value="@if(isset($data['phone'])){{$data['phone']}}@endif" name="phone" class="form-control" placeholder="Mobile">
                    </div>

                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12 lft">
                <div class="col-md-6 lft">
                    <div class="form-group nw-pd">
                        <select name="status" class="form-control slct">
                            <option value="">Status</option>
                            <option @if(isset($data['status']) && $data['status'] == "New") selected @endif>New</option>
                            <option @if(isset($data['status']) && $data['status'] == "Open") selected @endif>Open</option>
                            <option @if(isset($data['status']) && $data['status'] == "Accepted") selected @endif>Accepted</option>
                            <option @if(isset($data['status']) && $data['status'] == "Rejected") selected @endif>Rejected</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-xs-3 lft pull-left">
                    <button onclick="filterApplcations()" class="btn btn-gry p_17" style="width:  100%;">Filter</button>
                </div>
                <div class="col-md-3 col-xs-3 lft pull-right">
                    <a href="{{route('applications.index')}}" class="btn btn-org p_1   7">Reset</a>
                </div>
            </div>
        </form>
        <div class="clearfix"></div>
        <div class="table-responsive text-center">
            <table class="table main-table">
                <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>City</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Agent</th>
                    @if(auth()->user()->hasRole('applications.show'))
                        <th>Action</th>
                    @endif
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($applications as $application)
                    <tr>
                    <td>{{$application->id}}</td>
                    <td>
                        {{$application->name}}
                    </td>
                    <td >{{$application->phone}}</td>
                    <td >{{$application->city->name}}</td>
                    <td>{{\Carbon\Carbon::parse($application->created_at)->format('d/m/Y h:i A')}}</td>
                    <td>{{$application->status}}</td>
                    <td>{{$application->agent == null ? '----' : $application->agent->name}}</td>
                    @if(auth()->user()->hasRole('applications.show'))
                        <td>
                            <a href="{{route('applications.show',$application->id)}}">View</a>
                        </td>
                    @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">
            @if(auth()->user()->hasRole('applications.export'))
                <td> <button onclick="exportTable()" class="btn btn-gry neg-mrgn"><i class="exl"></i> Export</button></td>
            @endif
        </div>
        <div class="col-md-4 col-sm-5 col-xs-12">
            {{$applications->render()}}
        </div>
    </div>
@endsection


@section('js')


    <script>
        function filterApplcations(){
            $("#applications").attr('action', "{!! route('applications.index') !!}");
            $("#applications").attr('method', "GET");
            $( "#applications" ).submit();
        }


        function exportTable() {
            $("#applications").attr('action', "{!! route('applications.export') !!}");
            $("#applications").attr('method', "GET");
            $( "#applications" ).submit();
        }
    </script>
@endsection

