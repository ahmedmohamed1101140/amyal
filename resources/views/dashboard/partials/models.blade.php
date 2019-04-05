<div class="modal fade" id="squarespaceModal-3" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div class="my-menu clearfix">

                    <div class="col-md-12 col-xs-12">
                        <div class="clearfix"></div>
                        <div class="col-md-5 col-xs-12 text-center  p-l-0">
                            <img src="{{asset('assets/')}}/img/logo-2.png" class="logo-mdl"> </div>
                        <div class="col-md-7 col-xs-12 p-0">
                            <h3 class="log-title m-t-30">Create Your New Password</h3>
                            @if(Session::has('error'))
                                <h5 style="color: red;font-size: 15px;font-family: pro-bold;">Error! {{Session::get('error')}}</h5>
                            @endif
                            <form action="{{route('Dashboard')}}" method="post">
                                @csrf
                                <div class="form-group nw-pd">
                                    <input type="password" required value="{{old('old_password')}}" name="old_password" class="form-control" placeholder="The Temporary Password ">
                                </div>
                                <div class="form-group nw-pd">
                                    <input type="password" required class="form-control" value="{{old('new_password')}}" name="new_password" placeholder="New Password">
                                </div>

                                <div class="form-group nw-pd">
                                    <input type="password" required class="form-control" name="confirm_password" placeholder="Confirm New Password">
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

<div class="modal fade" id="squarespaceModal-2" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">

                <div class="col-md-12 col-xs-12 text-center">

                    <div class="col-md-2">
                        <img src="{{asset('assets/')}}/img/pick-chk.png"  class="pull-right thnk-img">
                    </div>

                    <div class="col-md-8 p-l-0">
                        <h3 class="pick-title2 text-left m-b-5 m-t-25" >The request was saved</h3>
                        <h4 class="text-left pick-title">We will call you soon</h4>
                        <h4 class="text-left pick-title">Company mobile number: 0122234234</h4>
                        <h4 class="text-left pick-title">Your Request <span>No: {{Session::get('pickup')}}</span></h4>
                    </div>
                </div>
                <div class="clearfix"></div>
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
                        <div class="clearfix"></div>
                        <div class="col-md-5 col-xs-12 text-center  p-l-0">
                            <img src="{{asset("assets/")}}/img/logo-2.png" class="logo-mdl"> </div>
                        <div class="col-md-7 col-xs-12 p-l-0">
                            <h3 class="log-title m-t-30">Login</h3>
                            <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                                @csrf

                                <div class="form-group nw-pd">
                                    <input type="number" name="account_number" class="form-control" placeholder="Account Number" value="{{ old('account_number') }}" required autofocus>
                                    @if ($errors->has('account_number'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('account_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group nw-pd">
                                    <input type="password" class="form-control" placeholder="Password" name="password" required>
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
                                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
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
                        <div class="clearfix"></div>
                        <div class="col-md-5 col-xs-12 text-center  p-l-0">
                            <img src="{{asset("assets/")}}/img/logo-2.png" class="logo-mdl"> </div>
                        <div class="col-md-7 col-xs-12 p-l-0">
                            <h3 class="log-title m-t-30">Please fill this application</h3>
                            <form id="myFormy" action="{{route('submit.application')}}" method="post">
                                @csrf
                                <div class="form-group nw-pd">
                                    <input type="text" class="form-control" required name="name" placeholder="Name">
                                </div>
                                <div class="form-group nw-pd">
                                    <input type="number" class="form-control" required name="mobile" placeholder="Mobile Number">
                                </div>
                                <div class="form-group nw-pd">
                                    <select name="nation" class="form-control slct" required>
                                        <option value="0">Nation</option>
                                        <option value="Egypt">Egypt</option>
                                    </select>
                                </div>
                                <div class="form-group nw-pd">
                                    <select name="city" class="form-control slct" required>
                                        <option value="0">City</option>
                                        <option value="Cairo">Cairo</option>
                                        <option value="Alex">Alex</option>
                                        <option value="Suez">Suez</option>
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
                    <h3 class="log-title" style="margin-top:5px">Forgot Password</h3>

                    <form>
                        <div class="form-group nw-pd">
                            <input type="email" class="form-control" placeholder="Your E-mail Address">
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
                        <h4  class="text-left thnk-title">{{Session::get('success')}}</h4>
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

                    <div class="col-md-4">
                        <img src="{{asset("assets/")}}/img/done.png"  class="pull-right thnk-img">
                    </div>

                    <div class="col-md-8 p-l-0">
                        <h3 class="log-title2 text-left m-b-5 m-t-25" >Sorry</h3>
                        <h4  class="text-left thnk-title">{{Session::get('error')}}</h4>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

