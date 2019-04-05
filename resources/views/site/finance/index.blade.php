@extends('site.layout')
@section('title')Amyal l Finance @endsection
@section('div_class')orders @endsection
@section('content')
    <h3><a href="{{route('home')}}" target="_self"><i class="fa fa-th"></i> Back to Dashboard</a></h3>
    <div class="col-md-10 col-sm-10 col-xs-12 p-l-0">
        <div class="dash-pages fnancee clearfix">
            <h1>Finance</h1>

            <div class="orders-table">
                <form id="orders" method="get" action="{{route('homeFinances.index')}}">
                    <div class="col-md-2 col-sm-2 col-xs-12 p-l-0">
                        <div class="form-group nw-pd">
                            <input type="hidden" name="filter" value="1">
                            <input name="date_from" value="@if(isset($data['date_from'])){{$data['date_from']}}@endif" autocomplete="off" class="form-control clndr tim" id="datetimepicker12" placeholder="Date from">

                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12 p-l-0">
                        <div class="form-group nw-pd">
                            <input name="date_to" value="@if(isset($data['date_to'])){{$data['date_to']}}@endif" autocomplete="off" class="form-control clndr tim" id="datetimepicker13" placeholder="Date to">

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
                    <div class="col-md-2 col-sm-2 col-xs-12 p-l-0">
                        <div class="form-group nw-pd">
                            <select name="status" class="form-control slct">
                                <option value="">Status</option>
                                <option @if(isset($data['status']) && $data['status'] == "Paid") selected @endif value="Paid">Paid</option>
                                <option @if(isset($data['status']) && $data['status'] == "Unpaid") selected @endif value="Unpaid">Unpaid</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-xs-12 p-0">
                        <div class="col-md-4 col-xs-6 p-l-0">
                            <button onclick="filter()" class="btn btn-gry p_17">Filter</button>
                        </div>
                        <div class="col-md-4 col-xs-6 p-l-0">
                            <a href="{{route('homeFinances.index')}}"  class="btn btn-org p_17">Reset</a>
                        </div>

                        <div class="col-md-4 col-xs-6 p-0 pull-right">
                            <a href="#squarespaceModal-8" data-toggle="modal" class="btn btn-org-rvrs">Wallet</a>
                        </div>


                    </div>


                </form>
                <div class="clearfix"></div>
                <div class="table-responsive text-center">
                    <table class="table main-table">
                        <thead class="text-center">
                        <tr>
                            <th>Tracking No</th>
                            <th>COD value</th>
                            <th>Shipping fees</th>
                            <th>Remain</th>
                            <th>Order Status</th>
                            <th>Finance Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($finances as $finance)
                            <tr>
                            <td>{{$finance->order != null ? $finance->order->tracking_number : "DELETED ORDER"}}</td>

                                <td>{{$finance->cod}}</td>
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
                            <td>{{$finance->status}}</td>
                        </tr>
                        @endforeach
                        </tbody>

                        <tfoot style="border:none">
                        <tr style="border:none">
                            <td> <button onclick="exportTable()" class="btn btn-gry neg-mrgn"><i class="exl"></i> Export</button></td>
                            <td class="orang-bg" style="border:solid 1px #7b7b7b">Total {{$total_cod}}</td>
                            <td class="orang-bg" style="border:solid 1px #7b7b7b">Total {{$total_shipping_fees}}</td>
                            <td class="orang-bg" style="border:solid 1px #7b7b7b">Total {{$total_remains}}</td>
                            <td style="border:none"></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    {{$finances->render()}}
                </div>

            </div>


        </div>
    </div>

@endsection

@section('modals')
    <div class="modal fade" id="squarespaceModal-8" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="col-md-12 col-xs-12 text-center">

                        <h3 class="log-title2 text-left m-b-5 m-t-25 p_24" >Wallet</h3>

                        <div class="table-responsive text-center">
                            <table class="table main-table">
                                <thead class="text-center">
                                <tr>
                                    <th>Date</th>
                                    <th>Received</th>
                                    <th>Payment method</th>
                                    <th>Amount</th>
                                    <th>Rec No</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($wallets as $wallet)
                                    <tr>
                                        <td>{{$wallet->created_at->format('d/m/Y H:i A')}}</td>
                                        <td>{{$wallet->receiver_name}}</td>
                                        <td>{{$wallet->payment_method}}</td>
                                        <td>{{$wallet->amount}}</td>
                                        <td>{{$wallet->record_number}}</td>
                                    </tr>
                                @endforeach


                                </tbody>

                                <tfoot style="border:none">
                                <tr>
                                    <td> <a href="{{route('wallet.exportClient')}}" class="btn btn-gry neg-mrgn"><i class="exl"></i> Export</a></td>
                                    <td colspan="2" style="border:none"></td>
                                    <td class="orang-bg" style="border:solid 1px #7b7b7b">Total {{$wallets->sum('amount')}}</td>

                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function filter(){
            $("#orders").attr('action', "{!! route('homeFinances.index') !!}");
            $("#orders").attr('method', "GET");
            $( "#orders" ).submit();
        }


        function exportTable() {
            $("#orders").attr('action', "{!! route('homeFinances.export') !!}");
            $("#orders").attr('method', "GET");
            $( "#orders" ).submit();
        }
    </script>
@endsection
