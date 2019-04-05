@extends('dashboard.layout')
@section('title')Amyal l Pick up Request @endsection
@section('css')
    <style>
        ol {list-style:none}
    </style>
@endsection
@section('content')
    <h2 class="orang1">Pick up Requests</h2>

    <div class="orders-table">
        <form id="pickup-request-data" >
            <input type="hidden" name="filter" value="filter">
            @if(auth()->user()->hasRole('pickup_requests.index'))
                <div class="col-md-3 col-sm-3 col-xs-12 lft">
                    <a href="#squarespaceModal-6" data-toggle="modal" class="btn btn-gry"><i class="plusy"></i> Add New Pick up Requests</a>
                </div>
            @endif
            <br><br><br>

            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input type="text" name="company_name" value="@if(isset($data['company_name'])){{$data['company_name']}}@endif" class="form-control" placeholder="company name">
                </div>
            </div>


            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input type="text" name="account_number" value="@if(isset($data['account_number'])){{$data['account_number']}}@endif" class="form-control" placeholder="Acc. No.">
                </div>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <select name="status" class="form-control slct">
                        <option value="">Status</option>
                        <option @if(isset($data['status'] ) && $data['status'] == 'New') selected @endif>New</option>
                        <option @if(isset($data['status'] ) && $data['status'] == 'Assign To') selected @endif value="Assign To">Assigned</option>
                        <option @if(isset($data['status'] ) && $data['status'] == 'Done') selected @endif>Done</option>
                        <option @if(isset($data['status'] ) && $data['status'] == 'Cancel') selected @endif>Cancel</option>
                    </select>

                </div>
            </div>

            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input name="date" autocomplete="off" value="@if(isset($data['date'])){{$data['date']}}@endif" class="form-control clndr tim" id="datetimepicker12" placeholder="Date">
                </div>
            </div>

            <div class="col-md-1 col-xs-1 p-0 pull-rght">
                <button onclick="filterRequests()" class="btn btn-gry p_17" style=" width:100%;">Filter</button>
            </div>
            <div class="col-md-1 col-xs-1 p-0 pull-left">
                <a href="{{route('pickup_requests.index')}}" class="btn btn-org p_17" style=" width:100%;">Reset</a>
            </div>
        </form>
        <div class="clearfix"></div>
        <div class="table-responsive text-center">
            <table class="table main-table">
                <thead class="text-center">
                <tr>
                    <th>Request No</th>
                    <th>Acc No.</th>
                    <th>Company Name</th>
                    <th>Pick up Address</th>
                    <th>Mobile Number</th>
                    <th>Request Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Agent</th>
                    @if(auth()->user()->hasRole('pickup_requests.update'))
                        <th>Transfer To</th>
                    @endif
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($requests as $request)
                    <tr>
                    <td>{{$request->req_number}}</td>
                    <td>{{$request->user->account_number}}</td>
                    <td>{{$request->user->company_name}}</td>
                    <td >{{$request->user->pickup_address}}</td>
                    <td >{{$request->user->phone}}</td>
                    <td>{{$request->created_at->format('d/m/Y')}}</td>
                    <td>{{$request->created_at->format('h:i A')}}</td>
                    <td>{{$request->status}}</td>
                    <td>{{$request->agent_id == null ? '---' : $request->agent->name}}</td>
                    @if(auth()->user()->hasRole('pickup_requests.update'))
                        <td><a href="#" onclick='editRequest("{{ route('pickup_requests.show',$request->id) }}" )'><i class="fa fa-edit edit-e"></i></a></td>
                    @endif
                    </tr>
                @endforeach
                </tbody>


            </table>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">
            <div class="table-btns">
                @if(auth()->user()->hasRole('pickup_requests.exportExcel'))
                    <button onclick="exportTable()" class="btn btn-org"><i class="exl"></i> Export</button>
                @endif
            </div>
        </div>                                         
        <div class="col-md-4 col-sm-5 col-xs-12">
            {{$requests->render()}}
        </div>

    </div>
@endsection

@section('modals')
    <div class="modal fade" id="squarespaceModal-6" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="col-md-12 col-xs-12">
                        <div id="result"></div>

                        <h3 class="log-title" style="margin-top:5px">Add New Pick up Request</h3>
                        <form id="add-data" method="POST" action="{{route('pickup_requests.store')}}">
                            @csrf
                            <div class="col-md-10 col-sm-12 lft">
                                <div class="form-group nw-pd">
                                    <input type="text" id="account_number" name="account_number" class="form-control" placeholder="Account Number ">
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-3 pull-right lft">
                                <button type="submit" class="btn btn-org pull-right nw-pad " style="margin-right:0; padding:5px 10px 6px; width:100%;">Request</button>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="squarespaceModal-1" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12 col-xs-12">
                        @if(count($agents) == 0)
                            <div class="alert alert-warning">
                                <ul>
                                    <li><strong>Warning:</strong> You Need To Add Some Agents First</li>
                                </ul>
                            </div>
                        @endif
                        <div id="result"></div>
                        <h3 class="log-title" id="modal-title" style="margin-top:5px">Add New Area</h3>
                        <form id="assign-request" method="POST" action="{{route('pickup_requests.store')}}">
                            @csrf
                            {{method_field('PUT')}}
                            <div class="col-md-5 col-sm-10 lft">
                                <div class="form-group nw-pd">
                                    <input type="hidden" id="request_id" name="request_id" value="">
                                    <select name="status" id="status" required class="form-control slct">
                                        <option value="">Status</option>
                                        <option >Assign To</option>
                                        <option >Cancel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-10 lft">
                                <div class="form-group nw-pd">
                                    <select disabled required name="agent_id" id="agent_id" class="form-control slct">
                                        <option value="">Select Pickup Agent</option>
                                        @foreach($agents as $agent)
                                            <option @if(old('agent_id') && old('agent_id') == $agent->id) selected @endif value="{{$agent->id}}">{{$agent->name}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-3 col-sm-2 rght">
                                <button type="submit" class="btn btn-org pull-right nw-pad "
                                        style="margin-right:0; padding:5px 10px 6px; width:100%;">Update
                                </button>
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
        $("#add-data").submit(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: {
                    'account_number':$("#account_number").val(),
                },
                dataType: "JSON",
                cache: false,
                success: function (data) {
                    console.log(data);
                    location.reload();
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    var result = '<div class="alert alert-warning" >' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="color:#fff">&times;</span></button>' +
                        '<ol>';
                    $("div.alert-warning").css('display', 'block');
                    jQuery.each(data.responseJSON.errors, function (key, value) {
                        //jQuery('ol').append('<li>'+value+'</li>');
                        result += '<li>' + value + '</li>';
                    });
                    result += '</ol></div>';
                    $('#result').html(result);
                    console.log(errors);
                }
            });
            return false;
        });

        function editRequest($cityId) {
            $.ajax({
                type: 'GET',
                url: $cityId,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    console.log(data);
                    $('#modal-title').text('Update Request Status');
                    $('#request_id').val(data.id);
                    if(data.status != 'New'){
                        $('#status').val(data.status);
                    }
                    if(data.status == 'Assign To'){
                        $("#agent_id").removeAttr('disabled');
                        $('#agent_id').val(data.agent_id);

                    }
                    $("#assign-request").attr('action', "{!! route('pickup_requests.update',['id' => '']) !!}" + "/" + data.id);
                    $("#assign-request").attr('method', "POST");
                    $('#squarespaceModal-1').modal('show');
                },
                error: function (data) {
                    var errors = data.esponseJSON;
                    console.log(errors);
                }
            });
        }


        $( "#status" ).change(function() {
            if($(this).find(":selected").text() == 'Assign To'){
                console.log($(this).find(":selected").text() );
                $("#agent_id").removeAttr('disabled');
            }
            else {
                $("#agent_id").val("");
                $("#agent_id").attr('disabled','disabled');
            }
        });



        function filterRequests(){
            $("#pickup-request-data").attr('action', "{!! route('pickup_requests.index') !!}");
            $("#pickup-request-data").attr('method', "GET");
            $( "#pickup-request-data" ).submit();
        }


        function exportTable() {
            $("#pickup-request-data").attr('action', "{!! route('pickup_requests.exportExcel') !!}");
            $("#pickup-request-data").attr('method', "GET");
            $( "#pickup-request-data" ).submit();
        }
        
        
    </script>
@endsection