@extends('dashboard.layout')
@section('title')Amyal l Departments @endsection
@section('css')
    <style>
        ol {list-style:none}
    </style>
@endsection
@section('content')
    <h2 class="orang1">Amyal Departments</h2>
    <div class="orders-table">
        <div class="col-md-3 col-sm-3 col-xs-12 lft">
            @if(auth()->user()->hasRole('departments.store'))
                <a href="#" onclick='addDepartment()'  class="btn btn-gry"><i class="plusy"></i> Add New
                    Department</a>
            @endif
        </div>

        <form action="{{route('departments.index')}}" method="get">
            <div class="col-md-4 col-sm-4 col-xs-12 lft">
                <div class="form-group nw-pd">
                    <input maxlength="190" type="text" value="@if(isset($data['filter'])){{$data['filter']}}@endif" name="filter" class="form-control" placeholder="Department Name">
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
                    <th>Department Name</th>
                    @if(auth()->user()->hasRole('departments.update'))
                        <th>Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($departments as $department)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($department->created_at)->format('d/m/Y')}}</td>
                        <td>
                            {{$department->name}}
                        </td>
                        @if(auth()->user()->hasRole('departments.update'))
                            <td>
                                <a href="#" onclick='editDepartment("{{ route('departments.show',$department->id) }}" )'><i
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
            {{$departments->render()}}
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

                    <h3 class="log-title" id="modal-title" style="margin-top:5px">Add New Department</h3>
                    <form method="post" action="{{route('departments.store')}}" id="add-data">
                        @csrf
                        <div class="col-md-10 col-sm-10 lft">
                            <div class="form-group nw-pd">
                                <input type="hidden" id="department_id" name="department_id" value="">
                                <input maxlength="190" required value="{{old('name')}}" id="name" name="name" type="text" class="form-control" placeholder="Department Name">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-2 lft">
                            <button type="submit" class="btn btn-org pull-right nw-pad "
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
        function addDepartment(){
            $('#result').html('');
            $('#modal-title').text('Add New Department');
            $('#name').val('');
            $('#department_id').val('');
            $("#adddata").attr('action', "{!! route('departments.store') !!}");
            $("#add-data").attr('method', "POST");
            $("#btn-submit").text('Add');
            $('#squarespaceModal-1').modal('show');
        }

        function editDepartment($departmentID) {
            $('#result').html('');
            $.ajax({
                type: 'GET',
                url: $departmentID,
                dataType: "JSON",
                cache: false,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('#modal-title').text('Update Department');
                    $('#name').val(data.name);
                    $('#department_id').val(data.id);
                    $('#squarespaceModal-1').modal('show');
                    $("#add-data").attr('action', "{!! route('departments.update',['id' => '']) !!}" + "/" + data.id);
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
                    'department_id':$("#department_id").val()
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