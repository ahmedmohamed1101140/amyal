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
                <form method="post" action="{{route('orders.update',$order->id)}}" id="new-order">
                    @csrf
                    {{method_field("PUT")}}
                    <div class="col-md-4 col-sm-4 col-xs-12 p-l-0">
                        <div class="form-group">
                            <div class="palceholder">
                                <label for="name">Item </label>
                                <span class="star">*</span>
                            </div>
                            <textarea data-placement="Item " maxlength="255" name="description" required class="form-control " placeholder="Item ">{{$order->description}}</textarea>

                        </div>
                        <div class="form-group">
                            <div class="palceholder">
                                <label for="name">Notes</label>
                            </div>
                            <textarea placeholder="Notes" class="form-control" maxlength="255" name="notes">{{$order->notes}}</textarea>
                        </div>
                        <div class="col-md-6 p-l-0">
                            <div class="form-group">
                                <div class="palceholder">
                                    <label for="name">COD</label>
                                    <span class="star">*</span>
                                </div>
                                <input placeholder="COD" type="number" name="cod" required class="form-control" value="{{$order->cod}}">
                            </div>
                        </div>

                        <div class="col-md-6 p-0">
                            <div class="form-group">
                                <div class="palceholder">
                                    <label for="name">Security number</label>
                                    <span class="star">*</span>
                                </div>
                                <input type="number" placeholder="Security Number" name="security_number" required class="form-control" value="{{$order->security_number}}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12 p-l-0">
                        <div class="form-group">
                            <div class="palceholder">
                                <label for="name">Receiver name </label>
                                <span class="star">*</span>
                            </div>
                            <input placeholder="Receiver Name" maxlength="190" type="text" name="receiver_name" value="{{$order->receiver_name}}" required class="form-control" >
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
                                        <option @if($order->city_id == $fee->city->id )selected @endif value="{{$fee->city->id}}">{{$fee->city->name}}</option>
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
                            <input type="text" maxlength="400" placeholder="Address" required name="address" value="{{$order->address}}" class="form-control" >
                        </div>
                        <div class="form-group">
                            <div class="palceholder">
                                <label for="name">Markup place </label>
                                <span class="star">*</span>
                            </div>
                            <input type="text" maxlength="400" placeholder="Markup Place" value="{{$order->mark_place}}" name="mark_place" required class="form-control" >

                        </div>
                        <div class="form-group">
                            <div class="palceholder">
                                <label for="name">Mobile Num </label>
                                <span class="star">*</span>
                            </div>
                            <input type="number" name="mobile" minlength="3" maxlength="15" value="{{$order->mobile}}" required placeholder="Mobile Number" class="form-control" >

                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4 col-sm-5 col-xs-12 p-l-0">
                        <div class="table-btns m-t-15">
                            <button type="submit" class="btn btn-org">Save</button>
                            <a href="{{route('orders.edit',$order->id)}}" class="btn btn-gry">Clear</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<!--modals-->


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
                    var temp = {!! json_encode($order->area_id) !!};
                    if( temp == op.value ){
                        op.selected = true;
                        bool = 1;
                    }
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