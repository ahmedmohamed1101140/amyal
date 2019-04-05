@extends('dashboard.layout')
@section('title')Amyal l Scanner @endsection
@section('css')
    {{--<link rel="stylesheet" type="text/css" href="{{asset("admin_assets/")}}/css/bootstrap-tagsinput.css"/>--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" crossorigin="anonymous">

    <style>
        ol {list-style:none}
    </style>
@endsection
@section('content')
    <h2 class="orang1">Scan Orders</h2>
    <div class="orders-table">
        @if($errors->any())
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="color:#fff">&times;</span></button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="add-data" action="{{route('scanner.update')}}" method="post">
            @csrf

            <div class="col-md-12 col-sm-12 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input type="text"  name="trackingNumber" required value="{{old('trackingNumber')}}" data-role="tagsinput" id="tags-input" class="form-control">
                </div>
            </div>
            <br><br>

            <div class="col-md-3 col-sm-3 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <select id="primarySelect" name="status" required class="form-control slct">
                        <option value="" > Select Status</option>
                        <option @if(old('status') == 'Received') selected @endif>Received</option>
                        <option @if(old('status') == 'Out for delivery') selected @endif>Out for delivery</option>
                        <option @if(old('status') == 'Transfer To') selected @endif>Transfer To</option>
                        <option @if(old('status') == 'Back to shipper') selected @endif>Back to shipper</option>
                        <option @if(old('status') == 'Incorrect Phone') selected @endif>Incorrect Phone</option>
                        <option @if(old('status') == 'Incorrect Address') selected @endif>Incorrect Address</option>
                    </select>
                </div>
            </div>

            <div class="col-md-3 col-sm-3 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <select required disabled id="secondarySelect" class="form-control slct">
                    </select>
                </div>
            </div>

            <br><br><br>
            <div class="col-md-1 col-xs-1 p-0 pull-left">
                <button class="btn btn-gry p_17" style=" width:100%;">Update</button>
            </div>
        </form>


        <div class="clearfix"></div>


    </div>
@endsection


@section('js')
    {{--<script src="{{asset("admin_assets/")}}/js/bootstrap-tagsinput.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" crossorigin="anonymous"></script>
    <script>
        (function() {

            var primarySelect = document.getElementById('primarySelect');
            var secondarySelect = document.getElementById('secondarySelect');

            primarySelect.onchange = function() {
                var _val = this.options[this.selectedIndex].value;
                if(_val == 'Transfer To'){
                    secondarySelect.length = 0;
                    secondarySelect.name = 'office_id';
                    var op = document.createElement('option');
                    op.value = '';
                    op.text = 'Select Office';
                    secondarySelect.appendChild(op);
                    @foreach($offices as $office)
                        var op = document.createElement('option');
                        op.value = {!! $office->id !!};
                        op.text = "{!! $office->name !!}";
                        secondarySelect.appendChild(op);
                    @endforeach
                    $("#secondarySelect").removeAttr('disabled');

                }
                else if(_val == 'Out for delivery'){
                    secondarySelect.length = 0;
                    secondarySelect.name = 'delivery_id';
                    var op = document.createElement('option');
                    op.value = '';
                    op.text = 'Select Delivery Agent';
                    secondarySelect.appendChild(op);
                    @foreach($deliveryAgents as $agent)
                        var op = document.createElement('option');
                        op.value = {!! $agent->id !!};
                        op.text = "{!! $agent->name !!}";
                        secondarySelect.appendChild(op);
                    @endforeach
                    $("#secondarySelect").removeAttr('disabled');

                }
                else if(_val == 'Back to shipper'){
                    secondarySelect.length = 0;
                    secondarySelect.name = 'pickup_id';
                    var op = document.createElement('option');
                    op.value = '';
                    op.text = 'Select Pickup Agent';
                    secondarySelect.appendChild(op);
                    @foreach($pickupAgents as $agent)
                        var op = document.createElement('option');
                        op.value = {!! $agent->id !!};
                        op.text = "{!! $agent->name !!}";
                        secondarySelect.appendChild(op);
                    @endforeach
                    $("#secondarySelect").removeAttr('disabled');

                }
                else{
                    secondarySelect.length = 0;
                    $("#secondarySelect").val("");
                    $("#secondarySelect").attr('disabled','disabled');
                }
            };
        })();
    </script>
@endsection