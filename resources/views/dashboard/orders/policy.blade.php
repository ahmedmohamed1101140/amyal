<h1>Amyal Report</h1>
<br><br>
@foreach($orders as $order)
<h2>Account Number: {{$order->user->account_number}}</h2>
<h2>Company Name: {{$order->user->company_name}}</h2>
<h2>Mobile Number:  {{$order->user->phone}}</h2>
<h2>From: {{$order->user->created_at->format('d/m/Y')}}</h2>


<br><br><br>
<hr>

    <div class="row"></div>
    <h3>Item: {{$order->description}}</h3>
    <h3>Receiver Name: {{$order->receiver_name}}</h3>
    <h3>City: {{$order->city->name}}</h3>
    <h3>Area: {{$order->area->name}}</h3>

    <h3>Address: {{$order->address}}</h3>
    <h3>Markup Place: {{$order->mark_place}}</h3>
    <h3>COD: {{$order->cod}}</h3>
    <h3>Security Number:{{$order->security_number}}</h3>
    <h3>Notes: {{$order->notes}}</h3>
    <h3>Tracking Number:{{$order->tracking_number}}</h3>
    <div class="row">
        <div class="col-md-6">
            <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($order->tracking_number)) !!} ">
        </div>
        <div class="col-md-6">
            <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($order->tracking_number, 'C39')}}" width="100px;" height="70px;" alt="barcode" />
        </div>
    </div>
    <br><br><br>
    <hr>
    <hr>
@endforeach
