@extends('dashboard.layout')
@section('title')Amyal l Support @endsection
@section('css')
    <style>
        ol {list-style:none}
    </style>
@endsection
@section('content')
    <h2 class="orang1">Support</h2>
    <div class="orders-table">
        <form id="support-data">
            <input type="hidden" value="filter" name="filter">
            @if(auth()->user()->hasRole('supports.store'))
                <div class="col-md-3 col-sm-3 col-xs-12 lft">
                    <a href="#squarespaceModal-1" data-toggle="modal" class="btn btn-gry"><i class="plusy"></i> Add New Ticket</a>
                </div>
            @endif
            <br><br><br>

            <div class="col-md-4 col-sm-4 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input type="text" name="name" value="@if(isset($data['name'])){{$data['name']}}@endif" class="form-control" placeholder="Agent Name">
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input type="text" name="reference_number" value="@if(isset($data['reference_number'])){{$data['reference_number']}}@endif" class="form-control" placeholder="Search by Ticket Number">
                </div>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <select name="status" class="form-control slct" >
                        <option value="">Status</option>
                        <option @if(isset($data['status']) && $data['status'] == 'New') selected @endif>New</option>
                        <option @if(isset($data['status']) && $data['status'] == 'Opened')selected @endif>Opened</option>
                        <option @if(isset($data['status']) && $data['status'] == 'Closed')selected @endif>Closed</option>
                    </select>

                </div>
            </div>



            <div class="col-md-1 col-xs-1 lft pull-left">
                <button onclick="filterSupport()" class="btn btn-gry p_17" style=" width:100%;">Filter</button>
            </div>
            <div class="col-md-1 col-xs-1 lft pull-left">
                <a href="{{route('supports.index')}}" type="submit" class="btn btn-org p_17" style=" width:100%;">Reset</a>
            </div>



        </form>
        <div class="clearfix"></div>
        <div class="table-responsive text-center">
            <table class="table main-table">
                <thead class="text-center">
                <tr>
                    <th>Ticket Number</th>
                    <th>Company Name</th>
                    <th>Subject</th>
                    <th>Agent</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($tickets as $ticket)
                    <tr>
                        <td>
                            @if(auth()->user()->hasRole('supports.show'))
                                <a href="{{route('supports.show',$ticket->id)}}" class="orangy" target="_self">
                                    {{$ticket->reference_number}}
                                </a>
                            @else
                                {{$ticket->reference_number}}
                            @endif
                        </td>
                        <td>{{$ticket->user_id == null ? '---' : $ticket->user->company_name}}</td>
                        <td>{{$ticket->subject}}</td>
                        <td>{{$ticket->agent == null ? '----' : $ticket->agent->name}}</td>
                        <td>{{$ticket->status}}</td>
                    </tr>
                @endforeach
                </tbody>


            </table>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">
            @if(auth()->user()->hasRole('supports.export'))
                <button onclick="exportTable()" class="btn btn-org"><i class="exl"></i> Export</button>
            @endif
        </div>                                                                                                                                  			<div class="col-md-4 col-sm-5 col-xs-12">
            {{$tickets->render()}}
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
                   <div class="col-md-3 col-sm-3 col-xs-12 lft">
                <a href="#squarespaceModal-1" data-toggle="modal" class="btn btn-gry"><i class="plusy"></i> Add New Ticket</a>
            </div>                     <div class="alert alert-warning">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="color:#fff">&times;</span></button>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <h3 class="log-title" style="margin-top:5px">Add New Ticket</h3>
                        <form method="post" action="{{route('supports.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6 col-sm-6 lft">
                                <div class="form-group nw-pd">
                                    <input type="text" required name="subject" maxlength="255" value="{{old('subject')}}" class="form-control" placeholder="Subject">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 rght">
                                <div class="form-group nw-pd">
                                    <input type="text" required name="account_number" value="{{old('account_number')}}" class="form-control" placeholder="ACC No">
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="col-md-12 col-sm-12 p-0">
                                <div class="form-group nw-pd">
                                    <textarea type="text" name="message" class="form-control" placeholder="Details">{{old('message')}}</textarea>
                                </div>
                            </div>



                            <div class="clearfix"></div>
                            <div class="table-btns">
                                <div class="file-upload1">
                                    {{--<label for="upload" class="file-upload__label btn btn-gry nw-pad "><i class="fa fa-paperclip"></i> Attach</label>--}}
                                    {{--<input id="upload" class="file-upload__input" type="file" name="file-upload1">--}}
                                </div>
                                <button type="submit" class="btn btn-org pull-right nw-pad ">Send</button>
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
        function filterSupport(){
        $("#support-data").attr('action', "{!! route('supports.index') !!}");
        $("#support-data").attr('method', "GET");
        $( "#support-data" ).submit();
        }
    
    
        function exportTable() {
        $("#support-data").attr('action', "{!! route('supports.export') !!}");
        $("#support-data").attr('method', "GET");
        $( "#support-data" ).submit();
        }

    </script>

@endsection