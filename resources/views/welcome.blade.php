<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Amyal l Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet"  href="{{asset("assets/")}}/css/bootstrap.css"  type="text/css"/>
    <link rel="stylesheet"  href="{{asset("assets/")}}/css/style.css"  type="text/css"/>
    <link href="{{asset("assets/")}}/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset("assets/")}}/css/bootsnav.css" />
</head>

<body>
<div id="home-wrapper">
    <header>
        <div class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-logo">
                            <a href="#" ><img src="{{asset("assets/")}}/img/logo.png"></a>
                        </div>

                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu"><i class="fa fa-bars"></i></button>
                        </div>

                        <div class="collapse navbar-collapse  nav_bor_top" id="navbar-menu">
                            <ul class="nav navbar-nav navbar-left" data-in="fadeInDown" data-out="fadeOutUp">
                                <li class="dropdown cool-link"><a href="#" >About us</a></li>
                                <li class="dropdown cool-link"><a href="#" >Services</a></li>
                                <li class="dropdown cool-link"><a href="#" >Gallery</a></li>
                                <li class="dropdown cool-link"><a href="#" >Faq</a></li>
                                <li class="dropdown cool-link"><a href="#" >Contact us</a></li>

                            </ul>

                        </div>

                        <ul class="horizontal pull-right">
                            <li>
                                <a href="#" target="_blank">
                                    <span class="fa fa-facebook "></span>
                                </a>

                            </li>
                            <li>
                                <a href="#" target="_blank">
                                    <span class="fa fa-linkedin "></span>
                                </a>

                            </li>
                            <li>
                                <a href="#" target="_blank">
                                    <span class="fa fa-youtube-play "></span>
                                </a>

                            </li>
                        </ul>

                        <ul class="top-btns pull-right">
                            @if(Auth::user())
                                @if(Auth::user()->first_login == 0)
                                    <li><a href="#squarespaceModal-3" data-toggle="modal" class="btn btn-custom-3" style="font-size: 15px;">Login</a></li>
                                @endif
                                <li><a href="{{route('home')}}" data-toggle="modal" class="btn btn-solid-reverse">Home</a></li>
                            @else
                                <li><a href="#squarespaceModal-4" data-toggle="modal" class="btn btn-solid-reverse">Login</a></li>
                                <li><a href="#squarespaceModal-5" data-toggle="modal" class="btn btn-solid-reverse">Application</a></li>
                            @endif
                        </ul>

                    </div>
                </div>
            </div>
        </div>

    </header>

    <div class="contents">

        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="hm-title">
                        <h1>Enjoy with Awesome Service</h1>
                        <h2>Enjoy with Awesome Service</h2>

                        <form id="track-search" method="POST" action="{{route('orders.find')}}">
                            @csrf
                            <input value="@if(isset($tracking_number)) {{$tracking_number}} @endif" type="text" class="nws" name="tracking_number" required placeholder="Your Tracking Number">
                            <input type="submit" class="btn btn-custom-3" value="GO">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if(isset($order))
            <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="results">
                        <div class="table-responsive text-center">
                            <table class="table table-bordered">
                                <thead class="text-center">
                                <tr>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status from</th>
                                    <th>Status to</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->order_statuses as $status)
                                    <tr>
                                        <td>{{$status->updated_at->format('d/m/Y')}}</td>
                                        <td>{{$status->updated_at->format('h:i A')}}</td>
                                        <td>{{$status->status_from}}</td>
                                        <td>{{$status->status_to}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
<div class="clearfix"></div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="foter-logo">
                    <img src="{{asset("assets/")}}/img/logo-s.png" width="86" height="61">
                </div>
                <div class="copyrights">
                    <p>Copyrights © Amyal 2019</p>
                    <p>Designed & Developed by <a href="http://paladox.com" target="_blank">Paladox corporate</a></p>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <ul class="horizontal pull-right">
                    <li>
                        <a href="#" target="_blank">
                            <span class="fa fa-facebook "></span>
                        </a>

                    </li>
                    <li>
                        <a href="#" target="_blank">
                            <span class="fa fa-linkedin "></span>
                        </a>

                    </li>
                    <li>
                        <a href="#" target="_blank">
                            <span class="fa fa-youtube-play "></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</footer>

<!--modals-->
<div class="modal fade" id="squarespaceModal-3" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="my-menu clearfix">

                    <div class="col-md-12 col-xs-12">
                        @if(Session::has('confirmError'))
                            <script>
                                window.onload = function () {
                                    $('#squarespaceModal-3').modal('show');
                                }
                            </script>
                            <div class="alert alert-danger">
                                <ul>
                                    <li>{{Session::get('confirmError')}}</li>
                                </ul>
                            </div>
                        @endif
                        <div class="clearfix"></div>
                        <div class="col-md-5 col-xs-12 text-center  p-l-0">
                            <img src="{{asset('assets/')}}/img/logo-2.png" class="logo-mdl"> </div>
                        <div class="col-md-7 col-xs-12 p-0">
                            <h3 class="log-title m-t-30">Create new password</h3>
                            <form action="{{route('update_password')}}" method="post">
                                @csrf
                                <div class="form-group nw-pd">
                                    <input type="password" required value="{{old('now_password')}}" name="now_password" class="form-control" placeholder="The Temporary Password ">
                                </div>
                                <div class="form-group nw-pd">
                                    <input type="password" required class="form-control" value="{{old('password')}}" name="password" placeholder="New Password">
                                </div>

                                <div class="form-group nw-pd">
                                    <input type="password" required class="form-control" name="password_confirmation" placeholder="Confirm New Password">
                                </div>

                                <div class="clearfix"></div>


                                <button type="submit"  class="btn nwbtn3 pull-right">Submit</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="squarespaceModal-4" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="my-menu clearfix">

                    <div class="col-md-12 col-xs-12">
                        @if ($errors->any() && Session::has('login'))
                            <script>
                                window.onload = function () {
                                    $('#squarespaceModal-4').modal('show');
                                }
                            </script>
                        @endif

                        <div class="clearfix"></div>
                        <div class="col-md-5 col-xs-12 text-center  p-l-0">
                            <img src="{{asset("assets/")}}/img/logo-2.png" class="logo-mdl"> </div>
                        <div class="col-md-7 col-xs-12 p-l-0">
                            <h3 class="log-title m-t-30">Login</h3>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group nw-pd">
                                    <input type="text" placeholder="Account Num" class="form-control{{ $errors->has('account_number') ? ' is-invalid' : '' }}" name="account_number" value="{{ old('account_number') }}" required autofocus>
                                    @if ($errors->has('account_number'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group nw-pd">
                                    <input type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-6 p-l-0">
                                    <div class="checkbox">
                                        <label class="chk">
                                            <input name="remember" type="checkbox"> Remember Me
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6 p-0">
                                    <div class="checkbox">
                                        <p class="chk pull-right">
                                            <a href="#squarespaceModal-6" data-toggle="modal" data-dismiss="modal" class="chk">Forgot Password</a>
                                        </p>
                                    </div>
                                </div>
                                <button type="submit" class="btn nwbtn3 pull-right">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="squarespaceModal-5" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="my-menu clearfix">

                    <div class="col-md-12 col-xs-12">
                        @if ($errors->any() && !Session::has('login') && !Session::has('forgetSuccess') && !Session::has('forget'))
                            <script>
                                window.onload = function () {
                                    $('#squarespaceModal-5').modal('show');
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

                        <div class="clearfix"></div>
                        <div class="col-md-5 col-xs-12 text-center  p-l-0">
                            <img src="{{asset("assets/")}}/img/logo-2.png" class="logo-mdl"> </div>
                        <div class="col-md-7 col-xs-12 p-l-0">
                            <h3 class="log-title m-t-30">Please fill this application</h3>
                            <form id="myFormy" method="post" action="{{route('clientRequests.store')}}">
                                @csrf
                                <div class="form-group nw-pd">
                                    <input type="text" name="name" value="{{old('name')}}" maxlength="255" required class="form-control" placeholder="Name">
                                </div>
                                <div class="form-group nw-pd">
                                    <input type="text" name="phone" value="{{old('phone')}}" minlength="2" maxlength="15" required class="form-control" placeholder="Mobile Num">
                                </div>
                                <div class="form-group nw-pd">
                                    <select name="city_id" required class="form-control slct">
                                        <option value="">City</option>
                                        @foreach($cities as $city)
                                            <option @if(old('city_id') == $city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="clearfix"></div>
                                <button type="submit"  class="btn nwbtn3 pull-right">Submit</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="squarespaceModal-6" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="col-md-12 col-xs-12">
                    @if ($errors->any() && Session::has('forget'))
                        <script>
                            window.onload = function () {
                                $('#squarespaceModal-6').modal('show');
                            }
                        </script>
                    @endif

                    <h3 class="log-title" style="margin-top:5px">Forgot Password</h3>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group nw-pd">
                            <input id="email" type="email" placeholder="Your E-mail Address" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <button type="submit" class="btn nwbtn3 pull-right m-b-10">Submit</button>
                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="squarespaceModal-7" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="col-md-12 col-xs-12 text-center">

                    <div class="col-md-4">
                        <img src="{{asset("assets/")}}/img/done.png"  class="pull-right thnk-img">
                    </div>

                    <div class="col-md-8 p-l-0">
                        <h3 class="log-title2 text-left m-b-5 m-t-25" >Thank you</h3>
                        <h4  class="text-left thnk-title">We will call you within 48 hours</h4>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="squarespaceModal-8" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="col-md-12 col-xs-12 text-center">

                    <div class="col-md-4">
                        <img src="{{asset("assets/")}}/img/done.png"  class="pull-right thnk-img">
                    </div>

                    <div class="col-md-8 p-l-0">
                        <h3 class="log-title2 text-left m-b-5 m-t-25" >Sorry</h3>
                        <h4  class="text-left thnk-title">We don't have any order match your tracking number</h4>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="squarespaceModal-9" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="col-md-12 col-xs-12 text-center">

                    <div class="col-md-4">
                        <img src="{{asset("assets/")}}/img/done.png"  class="pull-right thnk-img">
                    </div>

                    <div class="col-md-8 p-l-0">
                        <h3 class="log-title2 text-left m-b-5 m-t-25" >Thank you</h3>
                        @if (session('status'))
                            <h4  class="text-left thnk-title">{{ session('status') }}</h4>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>


<script src="{{asset("assets/")}}/js/jquery.2.2.3.min.js"></script>
<script src="{{asset("assets/")}}/js/bootstrap.js" type="text/jscript" ></script>
<script src="{{asset("assets/")}}/js/bootsnav.js"></script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#squarespaceModal-').modal('show');
    });
</script>

@if(Session::has('confirm'))
    <script>
        $('#squarespaceModal-7').modal('show');

        setTimeout( function(){
            $('#squarespaceModal-7').modal('hide');
        }  , 4000 );

    </script>
@endif

@if(Session::has('orderNotFound'))
    <script>
        $('#squarespaceModal-8').modal('show');

        setTimeout( function(){
            $('#squarespaceModal-8').modal('hide');
        }  , 10000 );

    </script>
@endif

@if(Session::has('login'))
    <script>
        $('#squarespaceModal-4').modal('show');
    </script>
@endif

@if(Session::has('reset'))
    <script>
        $('#squarespaceModal-3').modal('show');
    </script>
@endif

@if (session('forgetSuccess'))
    <script>
        $('#squarespaceModal-9').modal('show');
        setTimeout( function(){
            $('#squarespaceModal-9').modal('hide');
        }  , 10000 );

    </script>
@endif

<script>



//    $('#myFormy').on('submit', function(e){
//        $('#squarespaceModal-7').modal('show');
//        $('#squarespaceModal-5').modal('hide');
//        e.preventDefault();
//    });
</script>
</body>
</html>
