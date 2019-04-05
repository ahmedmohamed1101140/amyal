<header >
    <div class="top-header-inside">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-logo">
                        <a href="{{route('home')}}" ><img src="{{asset("assets/")}}/img/logo-inside.png"></a>
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

                    <div class="accnt">
                        <a href="{{route('home')}}">
                            <h3 class="p_18">Welcome</h3>
                            <h4>{{auth()->user()->company_name}}</h4>
                            <p>Last Login
                                {{\Carbon\Carbon::parse(auth()->user()->last_login)->format('d/m/Y h:i A')}}
                            </p>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>