<!DOCTYPE html>
<html>
    <head></head>
<body>

    <h1>Amyal Report</h1>
    <h2>Company Name: {{auth()->user()->company_name}}</h2>
    <h2>Date: {{\Carbon\Carbon::now()->format('d/m/Y h:i A')}}</h2>
    <h2>Total Orders: {{count($orders)}} Order</h2>
    <br><br><br>
    <hr>

    <table border="1" style="width: 100%">
    <thead align="center">
    <tr>
        <th>Tracking Num</th>
        <th>COD</th>
        <th>Receiver name</th>
        <th>barcode</th>
    </tr>
    </thead>
    <tbody align="center">
    @foreach($orders as $order)
        <tr>
            <td>{{$order->tracking_number}}</td>
            <td>{{$order->cod}}</td>
            <td >{{$order->receiver_name}}</td>
            <td style="padding: 10px;">
                <img src="data:image/png;base64,{{DNS1D::getBarcodePNG($order->tracking_number, 'C39')}}" width="100px;" height="70px;" alt="barcode" />
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>




