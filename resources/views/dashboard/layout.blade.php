@include('dashboard.partials.header')


<div class="contents">
    <div class="page-container side-bg">
        @if(auth()->user()->type == 'Employee')
            @include('dashboard.partials.navigation')
        @endif
        <div class="page-content" @yield('div_style')>
            <div class="col-md-12 col-sm-12 col-xs-12 pd-all-25" >
                @include('dashboard.partials.alerts')
                @yield('content')
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

@include('dashboard.partials.footer')


{{--@include('dashboard.partials.models')--}}

{{--@include('dashboard.partials.messages')--}}

