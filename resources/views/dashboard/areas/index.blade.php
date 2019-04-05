@extends('dashboard.layout')
@section('title')Amyal l Areas @endsection
@section('css')
    <style>
        ol {list-style:none}
    </style>
@endsection
@section('content')
        <h2 class="orang1">Amyal Areas</h2>
        <div class="orders-table">
            <div class="col-md-3 col-sm-3 col-xs-12 lft">
                @if(auth()->user()->hasRole('areas.store'))
                    <a href="#" onclick='addArea()' class="btn btn-gry"><i class="plusy"></i> Add New
                        Area</a>
                @endif
            </div>

            <form action="{{route('areas.index')}}" method="get">
                <div class="col-md-3 col-sm-3 col-xs-12 lft">
                    <div class="form-group nw-pd">
                        <input maxlength="190" type="text" value="@if(isset($data['filter'])){{$data['filter']}}@endif" name="filter" class="form-control" placeholder="Search by Area Name.">
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-12 lft">
                    <div class="form-group nw-pd">
                        <select name="city_id" class="form-control slct">
                            <option value="">City</option>
                            @foreach($cities as $city)
                                <option @if(isset($data['city_id']) && $data['city_id'] == $city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-1 col-xs-1 p-0 pull-left">
                    <button type="submit" class="btn btn-gry p_17" style=" width:100%;">Filter</button>
                </div>
            </form>

            <div class="clearfix"></div>
            <div class="table-responsive text-center">
                <table class="table main-table">
                    <thead class="text-center">
                    <tr>
                        <th>Creation Date</th>
                        <th>Area Name</th>
                        <th>City</th>
                        @if(auth()->user()->hasRole('areas.update'))
                            <th>Actions</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($areas as $area)
                        <tr>
                            <td>{{\Carbon\Carbon::parse($area->created_at)->format('d/m/Y')}}</td>
                            <td >{{$area->name}}</td>
                            <td>{{$area->city->name}}</td>
                            @if(auth()->user()->hasRole('areas.update'))
                                <td >
                                        <a href="#" onclick='editArea("{{ route('areas.show',$area->id) }}" )'><i
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
                {{$areas->render()}}
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
                    <h3 class="log-title" id="modal-title" style="margin-top:5px">Add New Area</h3>
                    @if(count($cities) == 0)
                        <div class="alert alert-warning">
                            <ul>
                                <li><strong>Warning:</strong> You Need To Add Some Cities First</li>
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{route('areas.store')}}" id="add-data">
                        @csrf
                        <div class="col-md-5 col-sm-10 lft">
                            <div class="form-group nw-pd">
                                <input type="hidden" id="area_id" name="area_id" value="">
                                <input maxlength="190" required value="{{old('name')}}" id="name" name="name" type="text" class="form-control" placeholder="Area Name">
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-10 lft">
                            <div class="form-group nw-pd">
                                <select required name="city_id" id="city_id" class="form-control slct">
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option @if(old('city_id') && old('city_id') == $city->id) selected @endif value="{{$city->id}}">{{$city->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('city_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('city_id') }}</strong>
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
        function addArea(){
            $('#result').html('');
            $('#modal-title').text('Add New Area');
            $('#name').val('');
            $('#area_id').val('');
            $('#city_id').val('');
            $("#add-data").attr('action', "{!! route('areas.store') !!}");
            $("#btn-submit").text('Add');
            $('#squarespaceModal-1').modal('show');
        }

        function editArea($cityId) {
            $('#result').html('');
            $.ajax({
                type: 'GET',
                url: $cityId,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#modal-title').text('Update Area');
                    $('#name').val(data.name);
                    $('#city_id').val(data.city_id);
                    $('#area_id').val(data.id);
                    $('#squarespaceModal-1').modal('show');
                    $("#add-data").attr('action', "{!! route('areas.update',['id' => '']) !!}" + "/" + data.id);
                    $("#add-data").attr('method', "PUT");
                    $("#btn-submit").text('Update');
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                }
            });
        }


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
                    'name':$("#name").val(),
                    'city_id':$("#city_id").val(),
                    'area_id':$("#area_id").val()
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

    </script>
@endsection
