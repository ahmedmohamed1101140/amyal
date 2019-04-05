<div class="page-sidebar ">
    <ul>
        @if(auth()->user()->hasRole('applications.index'))
            <li @if(str_contains($li_active,'applications'))class="active"@endif> <a href="{{route('applications.index')}}"><i class="icona rqsts"></i> Client Applications</a></li>
        @endif
        @if(auth()->user()->hasRole('clients.index'))
            <li @if(str_contains($li_active,'clients'))class="active"@endif> <a href="{{url('dashboard/clients')}}"><i class="icona clnts"></i> Clients</a></li>
        @endif
        @if(auth()->user()->hasRole('shipments.index'))
            <li @if(str_contains($li_active,'shipments'))class="active"@endif> <a href="{{url('dashboard/shipments')}}"><i class="icona shp"></i> Shipments</a></li>
        @endif
        @if(auth()->user()->hasRole('cities.index'))
            <li @if(str_contains($li_active,'cities'))class="active"@endif> <a href="{{url('dashboard/cities')}}"><i class="icona shp"></i> Amyal Cities</a></li>
        @endif
        @if(auth()->user()->hasRole('areas.index'))
            <li @if(str_contains($li_active,'areas'))class="active"@endif> <a href="{{url('dashboard/areas')}}"><i class="icona shp"></i> Amyal Areas</a></li>
        @endif
        @if(auth()->user()->hasRole('offices.index'))
            <li @if(str_contains($li_active,'offices'))class="active"@endif> <a href="{{url('dashboard/offices')}}"><i class="icona ofc"></i> Amyal Offices</a></li>
        @endif
        @if(auth()->user()->hasRole('departments.index'))
            <li @if(str_contains($li_active,'departments'))class="active"@endif> <a href="{{url('dashboard/departments')}}"><i class="icona dep"></i> Amyal Department</a></li>
        @endif
        @if(auth()->user()->hasRole('employees.index'))
            <li @if(str_contains($li_active,'employees'))class="active"@endif> <a href="{{url('dashboard/employees')}}"><i class="icona bsn"></i> Employees</a></li>
        @endif
        @if(auth()->user()->hasRole('supports.index'))
            <li @if(str_contains($li_active,'supports'))class="active"@endif> <a href="{{url('dashboard/supports')}}"><i class="icona sprt"></i> Support <span class="notif">{{$support_count}}</span></a></li>
        @endif
        @if(auth()->user()->hasRole('pickup_requests.index'))
            <li @if(str_contains($li_active,'pickup_requests'))class="active"@endif> <a href="{{url('dashboard/pickup_requests')}}"><i class="icona pic-rq"></i> Pick Up Requests</a></li>
        @endif
        @if(auth()->user()->hasRole('finances.index'))
            <li @if(str_contains($li_active,'finances'))class="active"@endif> <a href="{{url('dashboard/finances')}}"><i class="icona finc"></i> Finance</a></li>
        @endif
        @if(auth()->user()->hasRole('collections.index'))
            <li @if(str_contains($li_active,'collections'))class="active"@endif> <a href="{{url('dashboard/collections')}}"><i class="icona finc"></i> Collection</a></li>
        @endif
        @if(auth()->user()->hasRole('scanner.index'))
            <li @if(str_contains($li_active,'scanner'))class="active"@endif> <a href="{{route('scanner.index')}}"><i class="icona finc"></i> Scan orders</a></li>
        @endif

    </ul>
</div>
