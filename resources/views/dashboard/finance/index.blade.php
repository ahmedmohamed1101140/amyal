@extends('dashboard.layout')
@section('title')Amyal l Finance @endsection
@section('css')
    <style>
        ol {list-style:none}
    </style>
@endsection
@section('content')
    <h2 class="orang1">Finance</h2>

    <div class="orders-table">
        <form id="finance-data">
            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input type="hidden" name="filter" value="1">
                    <input name="date_from" value="@if(isset($data['date_from'])){{$data['date_from']}}@endif" autocomplete="off" class="form-control clndr tim" id="datetimepicker12" placeholder="Date from">
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input name="date_to" value="@if(isset($data['date_to'])){{$data['date_to']}}@endif" autocomplete="off" class="form-control clndr tim" id="datetimepicker13" placeholder="Date to">
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <select name="status" class="form-control slct">
                        <option value="">Status</option>
                        <option @if(isset($data['status']) && $data['status'] == "Paid") selected @endif value="Paid">Paid</option>
                        <option @if(isset($data['status']) && $data['status'] == "Unpaid") selected @endif value="Unpaid">Unpaid</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <select name="order_status" class="form-control slct">
                        <option value="">Order Status</option>
                        <option @if(isset($data['order_status']) && $data['order_status']=="Delivered") selected @endif value="Delivered">Delivered</option>
                        <option @if(isset($data['order_status']) && $data['order_status']=="Returned to shipper") selected @endif value="Returned to shipper">Returned to shipper</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input type="text" value="@if(isset($data['account_number'])){{$data['account_number']}}@endif" name="account_number" class="form-control" placeholder="Acc Number">
                </div>

            </div>



            <div class="col-md-1 col-sm-2 col-xs-6 p-0 pull-left">
                <button onclick="filterFinances()" class="btn btn-gry p_17" style=" width:100%;">Filter</button>
            </div>
            <div class="col-md-1 col-sm-2 col-xs-6 p-0 pull-left">
                <a href="{{route('finances.index')}}" class="btn btn-org p_17" style=" width:100%;">Reset</a>
            </div>

            <div class="clearfix"></div>


        </form>
        <div class="clearfix"></div>
        <div class="table-responsive text-center">
            <table class="table main-table" style="font-size:14px">
                <thead class="text-center">
                <tr>
                    <th>Acount Number</th>
                    <th>Track No.</th>
                    <th>COD Value</th>
                    <th>Shipping Fees</th>
                    <th>Remain</th>
                    <th>Order Status</th>
                    @if(auth()->user()->hasRole('finances.edit'))
                        <th>Action</th>
                    @endif
                    <th>Agent</th>
                </tr>
                </thead>
                <tbody>
                @foreach($finances as $finance)
                    <tr>
                    <td>{{$finance->order != null ? $finance->order->user->account_number : "DELETED ORDER"}}</td>
                    <td>{{$finance->order != null ? $finance->order->tracking_number : "DELETED ORDER"}}</td>
                    <td >{{$finance->cod}}</td>
                    @if($finance->order != null && $finance->order->shipping_fees_updated == 0)
                        <td>{{$finance->shipping_fees}}</td>
                    @else
                        <td class="orang" style="font-size: 16px;">{{$finance->shipping_fees}}</td>
                    @endif
                    @if($finance->order_status == 'Returned to shipper')
                        <td style="color:red;"><strong>{{$finance->remains}}</strong></td>
                    @else
                        <td style="color:red;"><strong>{{$finance->remains}}</strong></td>
                    @endif
                    <td>{{$finance->order_status}}</td>
                    @if(auth()->user()->hasRole('finances.edit'))
                        <td>
                            <button data-url="{{route('finances.edit',$finance->id)}}"  data-id="{{$finance->id}}"  type="submit" class="btn btn-org change-status  test" style="width: 100%; @if($finance->status == 'Paid') display: none; @endif">Pay</button>
                            <p @if($finance->status != 'Paid') style="display: none;" @endif id="{{$finance->id}}"><strong>Paid</strong></p>
                        </td>
                    @endif
                    <td id="header-{{$finance->id}}">{{$finance->agent_id == null ? '---' : $finance->agent->name}}</td>
                    </tr>
                @endforeach
                </tbody>

                <tfoot>
                <tr>
                    <td colspan="2"></td>
                    <td class="orang-bg">{{$total_cod}}</td>
                    <td class="orang-bg">{{$total_shipping_fees}}</td>
                    <td class="orang-bg">{{$total_remains}}</td>
                    @if(auth()->user()->hasRole('finances.edit'))
                        <td colspan="3"></td>
                    @else
                        <td colspan="2"></td>
                    @endif
                </tr>
                </tfoot>

            </table>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">
            <div class="table-btns">
                @if(auth()->user()->hasRole('finances.exportExcel'))
                    <button onclick="exportFinance()" class="btn btn-org"><i class="exl"></i> Export</button>
                @endif
                @if(auth()->user()->hasRole('wallets.index'))
                    <a href="{{route('wallets.index')}}" class="btn btn-org-reverse">Wallet</a>
                @endif
            </div>
        </div>
        <div class="col-md-4 col-sm-5 col-xs-12">
            {{$finances->render()}}
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



        function filterFinances(){
            $("#finance-data").attr('action', "{!! route('finances.index') !!}");
            $("#finance-data").attr('method', "GET");
            $( "#finance-data" ).submit();
        }


        function exportFinance() {
            $("#finance-data").attr('action', "{!! route('finances.exportExcel') !!}");
            $("#finance-data").attr('method', "GET");
            $( "#finance-data" ).submit();
        }

    </script>



@endsection
