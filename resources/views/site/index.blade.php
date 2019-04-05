@extends('site.layout')
@section('title')Amyal l Dashboard @endsection
@section('div_class')dshbrd @endsection
@section('content')
    <div class="col-md-10 col-sm-10 col-xs-12 col-md-offset-2 col-sm-offset-2">
        <h1>Get Started</h1>
        <div class="col-md-7 col-sm-9 col-xs-12 p-0">
            <div class="col-md-4 col-sm-4 col-xs-6 p-l-0">
                <div class="dsh-item">
                    <a href="{{route('orders.create')}}">
                        <img src="{{asset("assets/")}}/img/plus.png">
                        <h4>New Order</h4>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-6 p-l-0">
                <div class="dsh-item">
                    <a href="{{route('orders.index')}}">
                        <img src="{{asset("assets/")}}/img/boxes.png">
                        <h4> My Orders</h4>

                    </a>

                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-6 p-l-0">
                <div class="dsh-item">
                    <a href="{{route('homeFinances.index')}}">
                        <img src="{{asset("assets/")}}/img/financ.png">
                        <h4>Finance</h4>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-6 p-l-0">
                <div class="dsh-item">
                    <a href="{{route('profile.index')}}">
                        <img src="{{asset("assets/")}}/img/profile.png">
                        <h4>Profile</h4>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-6 p-l-0">
                <div class="dsh-item">
                    <a href="{{route('tickets.index')}}">
                        <img src="{{asset("assets/")}}/img/support.png">
                        <h4>Support</h4>
                    </a>
                </div>
            </div>

            <div class="col-md-4 col-sm-4 col-xs-6 p-l-0">
                <div class="dsh-item">
                    <a href="#" onclick="sendRequest()" data-toggle="modal">
                        <img src="{{asset("assets/")}}/img/pick.png">
                        <h4>Pickup request</h4>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-3 col-xs-12 p-l-0">
            <div class="dsh-item m-t-100">
                <a href="{{ route('home.logout') }}">
                    <img src="{{asset("assets/")}}/img/logout.png">
                    <h4>Logout</h4>
                </a>
            </div>
        </div>
    </div>
@endsection


@section('modals')
    <div class="modal fade" id="squarespaceModal-2" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="col-md-12 col-xs-12 text-center">

                        <div class="col-md-2">
                            <img src="{{asset("assets/")}}/img/pick-chk.png"  class="pull-right thnk-img">
                        </div>

                        <div class="col-md-8 p-l-0">
                            <h3 class="pick-title2 text-left m-b-5 m-t-25" >The request was saved</h3>
                            <h4 class="text-left pick-title">We will call you soon</h4>
                            <h4 class="text-left pick-title">Company mobile number: 0122234234</h4>
                            <h4 class="text-left pick-title">Your Request: <span id="req_number">No: 23301</span></h4>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="squarespaceModal-77" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="col-md-12 col-xs-12 text-center">
                        <h3 class="log-title" style="margin-top:5px">Pickup Request</h3>
                        <h4>You only have one pickup request between 9Am to 6Pm</h4>
                        <div class="clearfix"></div>
                        <div class="table-btns">
                            <button class="btn btn-gry nw-pad  m-t-10" data-dismiss="modal" aria-label="Close">Okay</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="squarespaceModal-88" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-body">

                    <div class="col-md-12 col-xs-12 text-center">
                        <h3 class="log-title" style="margin-top:5px">Pickup Request</h3>
                        <h4>You only have one pickup request between 9Am to 6Pm</h4>
                        <div class="clearfix"></div>
                        <h4 >Your Last Request: <span id="old_req_number">No: 23301</span></h4>
                        <div class="clearfix"></div>

                        <div class="table-btns">
                            <button class="btn btn-gry nw-pad  m-t-10" data-dismiss="modal" aria-label="Close">Okay</button>
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
        function sendRequest(){
            $.get("{!! route('pickupRequest') !!}", function(data, status){
                console.log(data);
                if(data['data'] == false){
                    $('#squarespaceModal-77').modal('show');
                    setTimeout( function(){
                        $('#squarespaceModal-77').modal('hide');
                    }  , 10000 );
                }
                else if(data['data'] == 'oldValue'){
                    $('#old_req_number').text(data['message']);
                    $('#squarespaceModal-88').modal('show');
                    setTimeout( function(){
                        $('#squarespaceModal-88').modal('hide');
                    }  , 10000 );
                }
                else{
                    $('#req_number').text(data);
                    $('#squarespaceModal-2').modal('show');
                    setTimeout( function(){
                        $('#squarespaceModal-2').modal('hide');
                    }  , 30000 );
                }

//                alert("Data: " + data + "\nStatus: " + status);
            });
        }
    </script>
@endsection