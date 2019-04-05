@extends('dashboard.layout')
@section('title')Amyal l Client Requests @endsection
@section('content')
        <div class="profile-details clearfix">
            <h1 class="orang">Request Information</h1>

            <div class="col-md-4 col-sm-4 lft">
                <h4 class="orang2"><strong>Name:</strong> <span style="color:#5f6062">{{$application->name}}</span></h4>
            </div>
            <div class="col-md-3 col-sm-3 rght1">
                <h4 class="orang2"><strong>Mobile: </strong><span style="color:#5f6062">{{$application->phone}}</span></h4>
            </div>
            <div class="col-md-4 col-sm-4 rght1">
                <h4 class="orang2"> <strong>City:</strong>  <span style="color:#5f6062">{{$application->city->name}}</span></h4>
            </div>
            <br><br>
        </div>
        <div class="orders-table">
                <div class="col-md-3 col-sm-3 col-xs-12 lft">
                    @if(auth()->user()->hasRole('applications.update'))
                        <a href="#squarespaceModal-14" data-toggle="modal" class="btn btn-gry"><i class="plusy"></i> Add New Action</a>
                    @endif
                </div>

                <div class="clearfix"></div>
                <div class="table-responsive text-center">
                    @if(count($application->statuses) > 0)
                    <table class="table main-table">
                        <thead class="text-center">
                        <tr>
                            <th>Agent Name</th>
                            <th>Status From</th>
                            <th>Status To</th>
                            <th>Date</th>
                            <th>Action</th>

                        </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach($application->statuses as $status)
                                <tr>
                                    <td>{{$status->agent->name}}</td>
                                    <td>{{$status->status_from}}</td>
                                    <td>{{$status->status_to}}</td>
                                    <td>{{\Carbon\Carbon::parse($status->created_at)->format('d/m/Y h:i A')}}</td>
                                    <td>{{$status->action}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <table class="table main-table">
                            <thead class="text-center">
                            <tr>
                                <th>Agent Name</th>
                                <th>Status From</th>
                                <th>Status To</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                    <td>---</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
                <div class="clearfix"></div>
                <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">
            </div>
        </div>
@endsection

@section('modals')
    @if(auth()->user()->hasRole('applications.update'))
        <div class="modal fade" id="squarespaceModal-14" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12 col-xs-12">
                    <h3 class="log-title" style="margin-top:5px">Add New Status</h3>
                    @if ($errors->any())
                        <script>
                            window.onload = function () {
                                $('#squarespaceModal-14').modal('show');
                            }
                        </script>
                        <div class="alert alert-warning">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="{{route('applications.update',$application->id)}}">
                        @csrf
                        {{method_field('PUT')}}
                        <div class="col-md-12 col-sm-12 lft">
                            <div class="form-group nw-pd">
                                <select required name="status" class="form-control slct">
                                    <option>Open</option>
                                    <option>Accepted</option>
                                    <option>Rejected</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12 col-sm-12 lft">
                            <div class="form-group nw-pd">
                                <input required type="text" maxlength="400" name="action" class="form-control" placeholder="Action">
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-12 col-sm-12 text-center lft">
                            <button type="submit" class="btn btn-org pull-right nw-pad " style="margin-right:0">Add</button>
                        </div>

                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
    @endif
@endsection