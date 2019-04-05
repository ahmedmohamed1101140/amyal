@extends('site.layout')
@section('title')Amyal l New Order @endsection
@section('div_class')orders @endsection
@section('content')
    <h3><a href="{{route('home')}}" target="_self"><i class="fa fa-th"></i> Back to Dashboard</a></h3>
    <div class="col-md-12 col-sm-12 col-xs-12 p-l-0">
        <div class="dash-pages new-order clearfix">
            <h1>New Order</h1>

            <div class="orders-table">

                <div class="clearfix"></div>
                <form method="post" action="{{route('orders.store')}}" id="new-order">
                    @csrf
                    <div class="col-md-4 col-sm-4 col-xs-12 p-l-0">
                        <div class="form-group">
                            <div class="palceholder">
                                <label for="name">Item </label>
                                <span class="star">*</span>
                            </div>
                            <textarea data-placement="Item " maxlength="255" name="description" required class="form-control " placeholder="Item ">{{old('description')}}</textarea>
                        </div>
                        <div class="form-group">
                            <div class="palceholder">
                                <label for="name">Notes</label>
                            </div>
                            <textarea placeholder="Notes" maxlength="255" class="form-control" name="notes" >{{old('notes')}}</textarea>

                        </div>
                        <div class="col-md-6 p-l-0">
                            <div class="form-group">
                                <div class="palceholder">
                                    <label for="name">COD</label>
                                    <span class="star">*</span>
                                </div>
                                <input placeholder="COD" max="1000000" type="number"  name="cod" required class="form-control" value="{{old("cod")}}">
                            </div>
                        </div>

                        <div class="col-md-6 p-0">
                            <div class="form-group">
                                <div class="palceholder">
                                    <label for="name">Security number</label>
                                    <span class="star">*</span>
                                </div>
                                <input type="number" placeholder="Security Number" name="security_number" required class="form-control" value="{{old('security_number')}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12 p-l-0">
                        <div class="form-group">
                            <div class="palceholder">
                                <label for="name">Receiver name </label>
                                <span class="star">*</span>
                            </div>
                            <input placeholder="Receiver Name" maxlength="190" type="text" name="receiver_name" value="{{old('receiver_name')}}" required class="form-control" >
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 p-l-0">
                            <div class="form-group">
                                <div class="palceholder">
                                    <label for="name">City</label>
                                    <span class="star">*</span>
                                </div>
                                <select required id="A" name="city_id" class="form-control slct">
                                    <option value=""> City</option>
                                    @foreach(auth()->user()->shipping_fees as $fee)
                                        <option @if(old('city_id')== $fee->city->id )selected @endif value="{{$fee->city->id}}">{{$fee->city->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 p-0">
                            <div class="form-group">
                                <div class="palceholder">
                                    <label for="name">Area</label>
                                    <span class="star">*</span>
                                </div>
                                <select required id="B" name="area_id" class="form-control slct">
                                    <option value="">Area</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                            <div class="palceholder">
                                <label for="name">Address </label>
                                <span class="star">*</span>
                            </div>
                            <input type="text" placeholder="Address" maxlength="400" required name="address" value="{{old('address')}}" class="form-control" >
                        </div>
                        <div class="form-group">
                            <div class="palceholder">
                                <label for="name">Markup place </label>
                                <span class="star">*</span>
                            </div>
                            <input type="text" placeholder="Markup Place" maxlength="400" value="{{old('mark_place')}}" name="mark_place" required class="form-control" >

                        </div>
                        <div class="form-group">
                            <div class="palceholder">
                                <label for="name">Mobile Num </label>
                                <span class="star">*</span>
                            </div>
                            <input type="number" minlength="3" maxlength="15" name="mobile" value="{{old('mobile')}}" required placeholder="Mobile Number" class="form-control" >

                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">
                        <div class="table-btns m-t-15">
                            <button type="submit" class="btn btn-org">Save</button>
                            <a href="{{route('orders.create')}}" class="btn btn-gry">Clear</a>
                            <a href="#squarespaceModal-1" data-toggle="modal" class="btn btn-gry"><i class="exl"></i> Upload from excel</a>
                        </div>
                    </div>
                </form>


            </div>


        </div>
    </div>
@endsection

<!--modals-->

@section('modals')
    <div class="modal fade" id="squarespaceModal-1" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog width-980">
        <div class="modal-content">

            <div class="modal-body">

                <div class="col-md-12 col-xs-12 ">

                    <h3 class="pick-title2 text-left m-b-5 m-t-25 p_24" >Required excel format</h3>
                    <div class="table-responsive ">
                        <table class="table main-table m-b-5">
                            <thead class="text-center">
                            <tr>
                                <th>Item </th>
                                <th>Receiver name</th>
                                <th>Mobile Num</th>
                                <th>City</th>
                                <th>Area</th>
                                <th>Address</th>
                                <th>Mark place</th>
                                <th>COD</th>
                                <th>Security Number</th>
                                <th>Notes</th>

                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            </tbody>

                        </table>
                        <p class="red text-left">NOTE:  This is just an Excel file template and the data will not be uploaded inside it</p>
                    </div>
                    <div class="table-btns m-b-15">
                        <form method="post" action="{{route('orders.store')}}" enctype="multipart/form-data">
                            @csrf

                            <a href="{{asset('assets/')}}/template.xlsx" class="btn btn-org"><i class="dwnld"></i> Download the required format</a>
                            <div class="file-upload1 new-upload">
                                <label for="upload" class="file-upload__label btn btn-gry ">Upload the data</label>
                                <input id="upload" class="file-upload__input" type="file" name="file-upload1">
                            </div>
                            <button type="submit" class="btn btn-gry">Save</button>
                            <p class="red inlin">Amyal not responsible for any other format just add 100 order per time</p>
                        </form>
                    </div>


                </div>
                <div class="clearfix"></div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        (function() {

            //setup an object fully of arrays
            //alternativly it could be something like
            //{"yes":[{value:sweet, text:Sweet}.....]}
            //so you could set the label of the option tag something different than the name
            var bOptions = {
            };
            @foreach(auth()->user()->shipping_fees as $fee)
                bOptions[{!! $fee->city->id !!}] = {!! $fee->city->areas!!}
                    @endforeach



            var A = document.getElementById('A');
            var B = document.getElementById('B');

            //on change is a good event for this because you are guarenteed the value is different
            A.onchange = function() {
                //clear out B
                B.length = 0;
                //get the selected value from A
                var _val = this.options[this.selectedIndex].value;

                var bool = 0;

                var op = document.createElement('option');
                op.value = '';
                op.text = 'Area';
                for (var i in bOptions[_val]) {
                    //create option tag
                    var op = document.createElement('option');
                    //set its value
                    op.value = bOptions[_val][i].id;
                    //set the display label
                    op.text = bOptions[_val][i].name;
                    {{--var temp = {!! json_encode(old('position_id')) !!};--}}
                    {{--if( temp == op.value ){--}}
                    {{--op.selected = true;--}}
                    {{--bool = 1;--}}
                    {{--}--}}

                    //append it to B
                    B.appendChild(op);
                }

                B.appendChild(op);

            };


            //fire this to update B on load
            A.onchange();

        })();
    </script>
@endsection