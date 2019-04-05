@extends('dashboard.layout')
@section('title')Amyal l Collections @endsection
@section('css')
    <style>
        ol {list-style:none}
    </style>
@endsection
@section('content')
    <h2 class="orang1">Collection</h2>

    <div class="orders-table">
        <form id="collections" method="get" action="{{route('collections.index')}}">

            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input type="hidden" value="1" name="filter">
                    <input name="date_from" value="@if(isset($data['date_from'])){{$data['date_from']}}@endif"  autocomplete="off" class="form-control clndr tim" id="datetimepicker12" placeholder="Date from">

                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input name="date_to"  value="@if(isset($data['date_to'])){{$data['date_to']}}@endif" autocomplete="off" class="form-control clndr tim" id="datetimepicker13" placeholder="Date to">

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
                    <select name="status" class="form-control slct">
                        <option value="">Status</option>
                        <option @if(isset($data['status']) && $data['status'] == "Collect") selected @endif value="Collect">Not Collected</option>
                        <option @if(isset($data['status']) && $data['status'] == "Collected") selected @endif value="Collected">Collected</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input type="text" value="@if(isset($data['name'])){{$data['name']}}@endif" name="name" class="form-control" placeholder="Delivery agent name">
                </div>
            </div>

            <div class="col-md-1 col-sm-2 col-xs-6 p-0 pull-left">
                <button onclick="filter()" class="btn btn-gry p_17" style="width:  100%;">Search</button>
            </div>
            <div class="col-md-1 col-xs-3 lft pull-right">
                <a href="{{route('collections.index')}}" class="btn btn-org p_17">Reset</a>
            </div>

            <div class="clearfix"></div>

        </form>
        <div class="clearfix"></div>
        <div class="table-responsive text-center">
            <table class="table main-table" style="font-size:14px">
                <thead class="text-center">
                <tr>
                    <th>Tracking Number</th>
                    <th>Delivery Agent name</th>
                    <th>Date</th>
                    <th>Office</th>
                    <th>COD Value</th>
                    @if(auth()->user()->hasRole('collections.edit'))
                        <th>Collect</th>
                    @endif
                    <th>Agent</th>
                </tr>
                </thead>
                <tbody class="text-center">
                    @foreach($collections as $collection)
                          <tr>
                              <td>{{$collection->order != null ? $collection->order->tracking_number : "DELETED ORDER" }}</td>
                              <td><a href="{{route('employees.show',$collection->agent_id)}}">{{$collection->agent->name}}</a></td>
                              <td>{{\Carbon\Carbon::parse($collection->created_at)->format('d/m/Y')}}</td>
                            <td >{{$collection->agent->office->name}}</td>
                            <td>{{$collection->cod}}</td>
                              @if(auth()->user()->hasRole('collections.edit'))
                              <td>
                                  <button data-url="{{route('collections.edit',$collection->id)}}"  data-id="{{$collection->id}}"  type="submit" class="btn btn-org change-status  test" style="width: 100%; @if($collection->status == 'Collected') display: none; @endif">Collect</button>
                                  <p @if($collection->status == 'Collect') style="display: none;" @endif id="{{$collection->id}}"><strong>Collected</strong></p>
                              </td>
                              @endif
                              <td id="header-{{$collection->id}}">{{$collection->status_agent == null ? '---' : $collection->statusAgent->name}}</td>
                              {{--<td ><input onchange='editStatus("{{route('collections.edit',$collection->id)}}")' @if($collection->status == 'Collected') checked @endif type="checkbox" data-toggle="toggle" data-on="Collect" data-off="Collected"></td>--}}
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td class="orang-bg">{{$total_cod}}</td>
                    <td colspan="2"></td>

                </tr>
                </tfoot>

            </table>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 col-sm-5 col-xs-12 lft">
            @if(auth()->user()->hasRole('collections.export'))
                <button onclick="exportTable()" class="btn btn-gry neg-mrgn"><i class="exl"></i> Export</button>
            @endif
        </div>
        <div class="col-md-4 col-sm-5 col-xs-12">
            {{$collections->render()}}
        </div>


    </div>
@endsection

@section('js')
    <script>


        $(".test").click(function()
        {
            var element = $(this);
           $.ajax({
                type: 'GET',
                url: element.attr('data-url')
            });
            element.hide(100);
            $("#"+element.attr('data-id')).show();
            $("#header-"+element.attr('data-id')).text("{!! auth()->user()->name !!}");
        })

    </script>

    <script>
        function filter(){
            $("#collections").attr('action', "{!! route('collections.index') !!}");
            $("#collections").attr('method', "GET");
            $( "#collections" ).submit();
        }


        function exportTable() {
            $("#collections").attr('action', "{!! route('collections.export') !!}");
            $("#collections").attr('method', "GET");
            $( "#collections" ).submit();
        }
    </script>



@endsection
