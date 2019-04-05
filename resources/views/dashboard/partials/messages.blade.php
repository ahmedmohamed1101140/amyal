@if(Session::has('success'))
    <script>
        $('#squarespaceModal-7').modal('show');
    </script>

@elseif(Session::has('error'))
    <script>
        $('#squarespaceModal-77').modal('show');
    </script>
@endif


@if(Session::has('reset'))
    <script>
        $('#squarespaceModal-3').modal('show');
    </script>
@endif

@if(Session::has('pickup'))
    <script>
        $('#squarespaceModal-2').modal('show');
    </script>
@endif

