@extends('dashboard.layout')
@section('title')Amyal l Cities @endsection
@section('css')
    <style>
        ol {
            list-style: none
        }
    </style>
@endsection
@section('content')
    <h2 class="orang1">Amyal Cities</h2>
    <div class="orders-table">
        <div class="col-md-3 col-sm-3 col-xs-12 lft">
            @if(auth()->user()->hasRole('cities.store'))
                <a href="#" id="add-data-button" class="btn btn-gry"><i class="plusy"></i> Add New
                    City</a>
            @endif
        </div>

        <form action="{{route('cities.index')}}" method="get">
            <div class="col-md-4 col-sm-4 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input maxlength="190" type="text" value="@if(isset($data['filter'])){{$data['filter']}}@endif" name="filter"
                           class="form-control" placeholder="City Name">
                </div>
            </div>
            <div class="col-md-1 col-xs-1 p-0 pull-left">
                <button type="submit" class="btn btn-gry p_17" style=" width:100%;">Search</button>
            </div>
        </form>

        <div class="clearfix"></div>
        <div class="table-responsive text-center">
            <table class="table main-table">
                <thead class="text-center">
                <tr>
                    <th>Creation Date</th>
                    <th>Name</th>
                    @if(auth()->user()->hasRole('cities.edit'))
                        <th>Status</th>
                    @endif
                    @if(auth()->user()->hasRole('cities.update'))
                        <th>Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($cities as $city)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($city->created_at)->format('d/m/Y')}}</td>
                        <td>{{$city->name}}</td>
                        @if(auth()->user()->hasRole('cities.edit'))
                            <td ><input onchange='editStatus("{{route('cities.edit',$city->id)}}")' @if($city->status == 'hide') checked @endif type="checkbox" data-toggle="toggle" data-on="Display" data-off="Hide"></td>
                        @endif
                        @if(auth()->user()->hasRole('cities.update'))
                            <td>
                                <a href="#" onclick='editCity("{{ route('cities.show',$city->id) }}" )'><i
                                        class="fa fa-edit edit-e"></i></a>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">

        </div>
        <div class="col-md-4 col-sm-5 col-xs-12">
            {{$cities->render()}}
        </div>

    </div>
@endsection

@section('modals')
    <div class="modal fade" id="squarespaceModal-1" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-md-12 col-xs-12">

                        <div id="result"></div>
                        <h3 class="log-title" id="modal-title" style="margin-top:5px">Add New City</h3>
                        <form method="post" action="{{route('cities.store')}}" id="add-data">
                            @csrf
                            <div class="col-md-10 col-sm-10 lft">
                                <div class="form-group nw-pd">
                                    <input type="hidden" id="city_id" name="city_id" value="">
                                    <input maxlength="190" required value="{{old('name')}}" id="name" name="name"
                                           type="text"
                                           class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           placeholder="City Name">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-2 lft">
                                <button id="btn-submit" type="submit" class="btn btn-org pull-right nw-pad "
                                        style="margin-right:0; padding:5px 10px 6px; width:100%;">Add
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        function editCity($cityId) {
            $('#result').html('');
            $.ajax({
                type: 'GET',
                url: $cityId,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#modal-title').text('Update City');
                    $('#name').val(data.name);
                    $('#city_id').val(data.id);
                    $('#squarespaceModal-1').modal('show');
                    $("#add-data").attr('action', "{!! route('cities.update',['id' => '']) !!}" + "/" + data.id);
                    $("#add-data").attr('method', "PUT");
                    $("#btn-submit").text('Update');
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            });
        }

        $("#add-data-button").click(function () {
            $('#result').html('');
            $('#modal-title').text('Add New City');
            $('#name').val('');
            $("#add-data").attr('action', "{!! route('cities.store') !!}");
            $("#add-data").attr('method', "POST");
            $("#btn-submit").text('Add');
            $('#squarespaceModal-1').modal('show');
        });


        $("#add-data").submit(function () {
            var formValues = new FormData($(this)[0]);
            var form = $(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });


            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: {
                    'name': $("#name").val(),
                    'city_id': $("#city_id").val()
                },
                dataType: "JSON",
                cache: false,
                success: function (data) {
                    console.log(data);
                    location.reload();
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    var result = '<div class="alert alert-warning" >' +
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true" style="color:#fff">&times;</span></button>' +
                        '<ol>';
                    $("div.alert-warning").css('display', 'block');
                    jQuery.each(data.responseJSON.errors, function (key, value) {
                        //jQuery('ol').append('<li>'+value+'</li>');
                        result += '<li>' + value + '</li>';
                    });
                    result += '</ol></div>';
                    $('#result').html(result);
//                    console.log(errors.errors);
                }
            });
            return false;
        });

        $(".pushme2").click(function () {
            $(this).text(function (i, v) {
                $.ajax({
                    type: 'GET',
                    url: $(this).attr('name')
                });
                return v === 'Hide' ? 'Display' : 'Hide'
            });
        });

        function editStatus(url) {
            $(this).text(function (i, v) {
                $.ajax({
                    type: 'GET',
                    url: url
                });
                return v === 'Hide' ? 'Display' : 'Hide'
            });
        }

        $(function() {
            $('#toggle-two').bootstrapToggle({
                on: 'Display',
                off: 'Hide'
            });
        })
    </script>
@endsection
