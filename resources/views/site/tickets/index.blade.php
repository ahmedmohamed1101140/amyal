@extends('site.layout')
@section('title')Amyal l Support @endsection
@section('div_class')orders @endsection
@section('content')
    <h3><a href="{{route('home')}}" target="_self"><i class="fa fa-th"></i> Back to Dashboard</a></h3>
    <div class="col-md-10 col-sm-10 col-xs-12 p-l-0">
        <div class="dash-pages support clearfix">
            <h1>Support</h1>

            <div class="orders-table">
                <form id="orders" method="get" action="{{route('tickets.index')}}">
                    <input type="hidden" value="filter" name="filter">
                    <div class="col-md-3 col-sm-3 col-xs-12 p-l-0">
                        <div class="form-group nw-pd">
                            <a href="#squarespaceModal-1" data-toggle="modal" class="btn btn-org nw-btn"><i class="plusy"></i> Add New Ticket</a>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-5 col-xs-12 p-l-0">
                        <div class="form-group nw-pd">
                            <input type="text" name="reference_number" value="@if(isset($data['reference_number'])){{$data['reference_number']}}@endif" class="form-control" placeholder="Ticket Number">
                        </div>

                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12 p-l-0">
                        <div class="form-group nw-pd">
                            <select name="status" class="form-control slct">
                                <option value="">Status</option>
                                <option @if(isset($data['status']) && $data['status'] == 'New') selected @endif>New</option>
                                <option @if(isset($data['status']) && $data['status'] == 'Opened')selected @endif>Opened</option>
                                <option @if(isset($data['status']) && $data['status'] == 'Closed')selected @endif>Closed</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-2 col-sm-2 col-xs-6 p-l-0 pull-left">
                        <button type="submit" class="btn btn-gry p_17">Filter</button>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-6 p-l-0 pull-left">
                        <a href="{{route('tickets.index')}}" class="btn btn-org p_17" >Reset</a>
                    </div>
                </form>
                <div class="clearfix"></div>
                <div class="table-responsive text-center">
                    <table class="table main-table">
                        <thead class="text-center">
                        <tr>
                            <th>Ticket Number</th>
                            <th>Creation date</th>
                            <th>Agent</th>
                            <th>Subject</th>
                            <th>Status</th>

                        </tr>
                        </thead>
                        <tbody class="text-center">
                        @foreach($tickets as $ticket)
                            <tr>
                                <td><a href="{{route('tickets.show',$ticket->id)}}" class="orangy" target="_self">{{$ticket->reference_number}}</a></td>
                                <td>{{$ticket->created_at->format('d/m/Y')}}</td>
                                <td>{{$ticket->agent_id == null ? '---' : $ticket->agent->name}}</td>
                                <td>{{$ticket->subject}}</td>
                                <td>{{$ticket->status}}</td>
                            </tr>
                        @endforeach
                        </tbody>


                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    {{$tickets->render()}}
                </div>

            </div>


        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="squarespaceModal-1" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="col-md-12 col-xs-12">
                    <h3 class="log-title" style="margin-top:5px">New Ticket</h3>

                    @if($errors->any())
                        <script>
                            window.onload = function () {
                                $('#squarespaceModal-1').modal('show');
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
                    <form method="post" action="{{route('tickets.store')}}" id="add-data" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group nw-pd">
                            <input type="text" name="subject" required maxlength="255" value="{{old('subject')}}" class="form-control" placeholder="Subject">
                        </div>
                        <div class="form-group nw-pd">
                            <textarea name="message" class="form-control" maxlength="4000" placeholder="Message">{{old('message')}}</textarea>
                        </div>
                        <div class="table-btns">
                            {{--<div class="file-upload1">--}}
                                {{--<label for="upload" class="file-upload__label btn btn-gry nw-pad "><i class="fa fa-paperclip"></i> Attach</label>--}}
                                {{--<input accept=".png, .jpg, .jpeg, .pdf, .txt, .rar, .zip, .csv, .docx, .doc, .xls" id="upload" class="file-upload__input" type="file" name="file-upload">--}}
                            {{--</div>--}}
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

