@if ($errors->any())
    {{--<script>--}}
        {{--window.onload = function () {--}}
            {{--$('#squarespaceModal-1').modal('show');--}}
        {{--}--}}
    {{--</script>--}}
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="color:#fff">&times;</span></button>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (Session::has('success'))
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="color:#fff">&times;</span></button>
        <strong>Success!</strong> {{Session::get('success')}}
    </div>
@endif
@if (Session::has('error'))
    <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="color:#fff">&times;</span></button>
        <strong>Error!</strong> {{Session::get('error')}}
    </div>
@endif


