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
                            <a href="" ><img src="{{asset("admin_assets/")}}/img/logo.png"></a>
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
                            <li><a href="#squarespaceModal-3" data-toggle="modal" class="btn btn-solid-reverse">Reset</a></li>
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

                        <form id="track-search">
                            <input type="text" class="nws" name="newsletter" required placeholder="Your Traking Number">
                            <input type="submit" class="btn btn-custom-3" value="GO">
                        </form>

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
<div class="modal fade" id="squarespaceModal-3" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="my-menu clearfix">

                    <div class="col-md-12 col-xs-12">
                        <div class="clearfix"></div>
                        <div class="col-md-5 col-xs-12 text-center  p-l-0">
                            <img src="{{asset("admin_assets/")}}/img/logo-2.png" class="logo-mdl"> </div>
                        <div class="col-md-7 col-xs-12 p-0">
                            <h3 class="log-title m-t-30">Reset your password</h3>
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group nw-pd">
                                    <input id="email" placeholder="Email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group nw-pd">
                                    <input id="password" type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group nw-pd">
                                    <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control" name="password_confirmation" required>
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


<script src="{{asset("admin_assets/")}}/js/jquery.2.2.3.min.js"></script>
<script src="{{asset("admin_assets/")}}/js/bootstrap.js" type="text/jscript" ></script>
<script src="{{asset("admin_assets/")}}/js/bootsnav.js"></script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#squarespaceModal-3').modal('show');
    });
</script>

</body>
</html>
