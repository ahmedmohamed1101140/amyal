<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Amyal l Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet"  href="{{asset("admin_assets/")}}/css/bootstrap.css"  type="text/css"/>
    <link rel="stylesheet"  href="{{asset("admin_assets/")}}/css/style.css"  type="text/css"/>
    <link href="{{asset("admin_assets/")}}/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset("admin_assets/")}}/css/bootsnav.css" />
</head>

<body>
<div id="home-wrapper">
    <header>
        <div class="top-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="nav-logo">
                            <a href="{{route('Dashboard')}}" ><img src="{{asset("admin_assets/")}}/img/logo.png"></a>
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



                    </div>
                </div>
            </div>
        </div>

    </header>

    <div class="contents">

        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div style="margin-top:170px">


                        <div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3">
                            <div class="orders-table m-t-10 m-b-25 new-from clearfix">
                                <div class="col-md-4 col-xs-12 text-center  p-l-0">
                                    <h2 class="mytitl">Admin Panel</h2>
                                </div>
                                <div class="col-md-8 col-xs-12 ">

                                    <form method="POST" action="{{ route('agent.login.submit') }}">
                                        @csrf
                                        <div class="mynwbord">
                                            <h3 class="log-title m-t-0 text-left">Login</h3>
                                            <div class="form-group nw-pd">
                                                <input id="email" placeholder="Email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback" role="alert">
                                                         <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group nw-pd">
                                                <input placeholder="Password" id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="col-md-6 p-l-0">
                                                <div class="checkbox">
                                                    <label class="chk" style="color:#fff">
                                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                                    </label>

                                                </div>
                                            </div>
                                            <div class="col-md-6 p-0">
                                                <div class="checkbox">
                                                    <p class="chk pull-right">
                                                        <a href="#squarespaceModal-6" data-toggle="modal" style="color:#fff" class="chk">Forgot Password?</a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group text-right m-t-0">
                                            <button type="submit" class="btn nwbtn3 ">Login</button>
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>




        </div>


    </div>
</div>
<div class="clearfix"></div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="foter-logo">
                    <img src="{{asset("admin_assets/")}}/img/logo-s.png" width="86" height="61">
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

<div class="modal fade" id="squarespaceModal-6" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="col-md-12 col-xs-12">

                    <h3 class="log-title" style="margin-top:5px">Forgot Password</h3>
                    @if ($errors->any() && Session::has('forget'))
                        <script>
                            window.onload = function () {
                                $('#squarespaceModal-6').modal('show');
                            }
                        </script>
                    @endif
                    @if (Session::has('forgetSuccess'))
                        <script>
                            window.onload = function () {
                                $('#squarespaceModal-6').modal('show');
                            }
                        </script>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    @endif
                    <form method="POST" action="{{ route('agent.password.email') }}">
                        @csrf
                        <div class="form-group nw-pd">
                            <input id="email" placeholder="Your E-mail Address" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

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


<script src="{{asset("admin_assets/")}}/js/jquery.2.2.3.min.js"></script>
<script src="{{asset("admin_assets/")}}/js/bootstrap.js" type="text/jscript" ></script>
<script src="{{asset("admin_assets/")}}/js/bootsnav.js"></script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#squarespaceModal-').modal('show');
    });
</script>

@if(Session::has('forgetSuccess'))
    <script>
        $('#squarespaceModal-6').modal('show');
    </script>
@endif

</body>
</html>
