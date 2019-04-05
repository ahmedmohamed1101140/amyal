@extends('dashboard.layout')
@section('title')Amyal l Shipments @endsection
@section('css')
    <style>
        ol {list-style:none}
    </style>
@endsection
@section('content')

    <div class="dash-pages myorders clearfix">
        <h1>Update Order</h1>
    </div>

    <form id="user-form1" method="POST" action="{{route('shipments.update',$order->id)}}" class="user-form clearfix" style="margin-top:0; width:100%">
        @csrf
        {{method_field('PUT')}}
        <div class="col-md-6 lft">
            <div class="form-group nw-pd">
                <label>Receiver Name</label>
                <input placeholder="Receiver Name" maxlength="190" type="text" name="receiver_name" value="{{$order->receiver_name}}" required class="form-control" >
            </div>
        </div>
        <div class="col-md-6 lft">
            <div class="form-group nw-pd">
                <label>Mobile Num</label>
                <input type="text" minlength="3" maxlength="15" name="mobile" value="{{$order->mobile}}" required placeholder="Mobile Number" class="form-control" >
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-6 lft">
            <div class="form-group nw-pd">
                <label>City</label>
                <select required id="A" name="city_id" class="form-control slct">
                    <option value=""> City</option>
                    @foreach($order->user->shipping_fees()->get() as $fee)
                        <option @if($order->city_id == $fee->city->id )selected @endif value="{{$fee->city->id}}">{{$fee->city->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6 lft">
            <div class="form-group nw-pd">
                <label>Area</label>
                <select required id="B" name="area_id" class="form-control slct">
                    <option value="">Area</option>
                </select>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 p-0">
            <div class="form-group nw-pd">
                <label style="width:14.8%">Address</label>
                <input type="text" placeholder="Address" maxlength="400" required name="address" value="{{$order->address}}" class="form-control" >
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 p-0">
            <div class="form-group nw-pd">
                <label style="width:14.8%">Markup Place</label>
                <input type="text" placeholder="Markup Place" maxlength="400" value="{{$order->mark_place}}" name="mark_place" required class="form-control" >
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 lft">
            <div class="form-group nw-pd">
                <label>COD Value</label>
                <input placeholder="COD" type="number"  name="cod" required class="form-control" value="{{$order->cod}}">
            </div>
        </div>
        <div class="col-md-4 lft">
            <div class="form-group nw-pd">
                <label>Shipping fees</label>
                <input placeholder="Shipping Fees" type="number"  name="shipping_fees" required class="form-control" value="{{$order->shipping_fees}}">
            </div>
        </div>
        <div class="col-md-4 lft">
            <div class="form-group nw-pd">
                <label>Security Num</label>
                <input type="number" placeholder="Security Number" name="security_number" required class="form-control" value="{{$order->security_number}}">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 p-0">
            <div class="form-group nw-pd">
                <label style="width:14.8%">Item </label>
                <textarea data-placement="Item " maxlength="255" name="description" required class="form-control " placeholder="Item ">{{$order->description}}</textarea>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12 p-0">
            <div class="form-group nw-pd">
                <label style="width:14.8%">Notes</label>
                <textarea placeholder="Notes" maxlength="255" class="form-control" name="notes">{{$order->notes}}</textarea>
            </div>
        </div>
        <button type="submit" class="btn nwbtn3 pull-right no-radius ">Update</button>
    </form>
    <div class="clearfix"></div>
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
            @foreach($order->user->shipping_fees()->get() as $fee)
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