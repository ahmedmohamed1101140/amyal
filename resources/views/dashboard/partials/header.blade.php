<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Scripts -->
    {{--<script src="{{ asset('js/app.js') }}" defer></script>--}}


    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{asset("admin_assets/")}}/css/bootstrap.css" type="text/css"/>
    <link rel="stylesheet" href="{{asset("admin_assets/")}}/css/style.css" type="text/css"/>
    <link href="{{asset("admin_assets/")}}/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset("admin_assets/")}}/css/bootsnav.css"/>
    <link rel="stylesheet" type="text/css" href="{{asset("admin_assets/")}}/css/jquery.datetimepicker.css"/>
    <link rel="stylesheet" type="text/css" href="{{asset("admin_assets/")}}/css/mdtimepicker.css"/>
    <link rel="stylesheet" type="text/css" href="{{asset("admin_assets/")}}/css/bootstrap-toggle.css"/>
    @yield('css')
    <style>
        ul {
            list-style-type: none;
            padding: 0;
        }
    </style>
</head>

<body>
<header>
    <div class="top-header-inside">
        <div class="container hd-wd">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-logo">
                        <a href="{{route('Dashboard')}}"><img src="{{asset("admin_assets/")}}/img/logo-inside.png"></a>
                    </div>

                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu"><i
                                    class="fa fa-bars"></i></button>
                    </div>

                    <div class="collapse navbar-collapse  nav_bor_top" id="navbar-menu">
                        <ul class="nav navbar-nav navbar-left" data-in="fadeInDown" data-out="fadeOutUp">
                            <li class="dropdown cool-link"><a href="#">About us</a></li>
                            <li class="dropdown cool-link"><a href="#">Services</a></li>
                            <li class="dropdown cool-link"><a href="#">Gallery</a></li>
                            <li class="dropdown cool-link"><a href="#">Faq</a></li>
                            <li class="dropdown cool-link"><a href="#">Contact us</a></li>

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
                        <li style="margin-left:15px">
                            <a href="{{url('dashboard/logout')}}">
                                <span class="fa fa-power-off "></span>
                            </a>

                        </li>
                    </ul>

                    <div class="accnt ">
                        {{--<a href="{{url('dashboard/clients')}}">--}}
                        <h3 class="p_18">Welcome</h3>
                        <h4>{{strtok(auth()->user()->name," ")}}</h4>
                        <p>Last Login
                            {{\Carbon\Carbon::parse(auth()->user()->last_login)->format('d/m/Y h:i A')}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>