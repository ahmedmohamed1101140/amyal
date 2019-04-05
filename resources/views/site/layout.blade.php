@include('site.partials.header')
@include('site.partials.nav')


<div class="contents">
    <div class="@yield('div_class')">
        <div class="container">
            <div class="row">
                @include('site.partials.alerts')
                @yield('content')
            </div>
        </div>
    </div>
</div>

@include('site.partials.footer')



