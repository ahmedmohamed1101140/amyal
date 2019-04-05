@extends('dashboard.layout')
@section('title')Amyal l Wallet @endsection
@section('css')
    <style>
        ol {list-style:none}
    </style>
@endsection
@section('content')
    <h2 class="orang1 m-b-0">Wallet</h2>
    <nav id="breadcrumb" class="breadcrumb">
        <a href="" class="breadcrumb-link">Finance</a>
        <a href="" class="breadcrumb--active">Wallet</a>
    </nav>
    <div class="orders-table">
        @if(auth()->user()->hasRole('wallets.store'))
            <div class="col-md-3 col-sm-3 col-xs-12 lft">
                <a href="#squarespaceModal-1" data-toggle="modal" class="btn btn-gry"><i class="plusy"></i> Add New Wallet</a>
            </div>
        @endif

            <form id="wallet-data">
                <input type="hidden" value="filter" name="filter">
                <div class="col-md-4 col-sm-4 col-xs-12 lft">
                    <div class="form-group nw-pd">
                        <input type="text" name="account_number" value="@if(isset($data['account_number'])){{$data['account_number']}}@endif" class="form-control" placeholder="Account Number">
                    </div>
                </div>


                <div class="col-md-2 col-sm-2 col-xs-12 lft">
                    <div class="form-group nw-pd">
                        <input name="date" autocomplete="off" value="@if(isset($data['date'])){{$data['date']}}@endif" class="form-control clndr tim" id="datetimepicker12" placeholder="Date">
                    </div>
                </div>


                <div class="col-md-1 col-xs-1 lft pull-left">
                    <button onclick="filterWallet()" class="btn btn-gry p_17" style=" width:100%;">Filter</button>
                </div>
                <div class="col-md-1 col-xs-1 lft pull-left">
                    <a href="{{route('wallets.index')}}" type="submit" class="btn btn-org p_17" style=" width:100%;">Reset</a>
                </div>



            </form>

    <div class="clearfix"></div>
    <div class="table-responsive text-center">
        <table class="table main-table">
            <thead class="text-center">
            <tr>
                <th>Date</th>
                <th>Receiver Name</th>
                <th>Payment Method</th>
                <th>Record No.</th>
                <th>Account Number</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody class="text-center">
                @foreach($wallets as $wallet)
                    <tr>
                    <td>{{$wallet->date}}</td>
                    <td>{{$wallet->receiver_name}}</td>
                    <td >{{$wallet->payment_method}}</td>
                    <td>{{$wallet->record_number}}</td>
                    <td>{{$wallet->user->account_number}}</td>
                    <td>{{$wallet->amount}}</td>
                </tr>
                @endforeach
            </tbody>

            <tfoot>
            <tr>
                <td colspan="5"></td>
                <td class="orang-bg">{{$total}}</td>
            </tr>
            </tfoot>

        </table>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">
        @if(auth()->user()->hasRole('wallets.export'))
            <button onclick="exportTable()" class="btn btn-org"><i class="exl"></i> Export</button>
        @endif
    </div>                                                                                                                                  			<div class="col-md-4 col-sm-5 col-xs-12">
        {{$wallets->render()}}
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
                            <script>
                                $('#squarespaceModal-14').modal('show');
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
                        <h3 class="log-title" style="margin-top:5px">Add New Wallet</h3>

                        <form method="POST" action="{{route('wallets.store')}}">
                            @csrf
                            <div class="col-md-6 col-sm-6 col-xs-12 lft">
                                <div class="form-group nw-pd">
                                    <input name="date" value="{{old('date')}}" required autocomplete="off" class="form-control clndr tim" id="datetimepicker11" placeholder="Date">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 rght">
                                <div class="form-group nw-pd">
                                    <div class="form-group nw-pd">
                                        <input type="text" name="receiver_name" value="{{old('receiver_name')}}" required maxlength="191" class="form-control" placeholder="Received">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-6 col-sm-6 col-xs-12 lft">
                                <div class="form-group nw-pd">
                                    <input type="number" name="record_number" value="{{old('record_number')}}" class="form-control" placeholder="Record Number">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 rght">
                                <div class="form-group nw-pd">
                                    <div class="form-group nw-pd">
                                        <input type="text" name="payment_method" value="{{old('payment_method')}}" required maxlength="191" class="form-control" placeholder="Payment Method">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 lft">
                                <div class="form-group nw-pd">
                                    <input type="text" name="account_number" value="{{old('account_number')}}" required maxlength="191" class="form-control" placeholder="Account Number">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 lft">
                                <div class="form-group nw-pd">
                                    <input type="number" name="amount" value="{{old('amount')}}" required class="form-control" placeholder="Amount">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-2 col-sm-2 rght pull-right">
                                <button type="submit" class="btn btn-gry  nw-pad " style="margin-right:0; margin-top:20px ">Add</button>
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
        function filterWallet(){
            $("#wallet-data").attr('action', "{!! route('wallets.index') !!}");
            $("#wallet-data").attr('method', "GET");
            $( "#wallet-data" ).submit();
        }


        function exportTable() {
            $("#wallet-data").attr('action', "{!! route('wallets.export') !!}");
            $("#wallet-data").attr('method', "GET");
            $( "#wallet-data" ).submit();
        }

    </script>

@endsection
