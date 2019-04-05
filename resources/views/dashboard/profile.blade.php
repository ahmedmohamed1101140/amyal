@extends('dashboard.layout')
@section('title')Amyal l Profile @endsection
@section('content')
    <nav id="breadcrumb" class="breadcrumb">
        <a href="collection.html" class="breadcrumb-link">Collection</a>
        <a href="#breadcrumb" class="breadcrumb--active">Profile</a>
    </nav>
    <h2 class="orang1" style="margin-bottom:10px; margin-top:0px">Personal Information</h2>
    <div class="profily">
        <div class="col-md-1 col-sm-1 lft">
            <div class="bordy"></div>
        </div>
        <div class="col-md-11 col-sm-11 rght">
            <div class="profily-details">
                <div class="user-img">
                    <img src="img/doctor2.jpg">
                </div>

                <div class="col-md-11 col-sm-11 col-md-offset-1 col-sm-offset-1 lft">
                    <div class="col-md-4 col-sm-4 lft">
                        <h5 class="orang2">Name: <span style="color:#5f6062">Ahmed Abdel Rahman</span></h5>
                    </div>
                    <div class="col-md-3 col-sm-3 rght1">
                        <h5 class="orang2">Mobile: <span style="color:#5f6062">01232492349</span></h5>
                    </div>
                    <div class="col-md-4 col-sm-4 rght1">
                        <h5 class="orang2">Email: <span style="color:#5f6062">a.arahman@amyal.com</span></h5>
                    </div>
                    <div class="col-md-1 col-sm-1 rght">
                        <h5 class="orang2">Age: <span style="color:#5f6062">35</span></h5>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-7 col-sm-7 lft">
                        <h5 class="orang2">Address: <span style="color:#5f6062">Tawfeek elhakim st, Maadi - Cairo - Egypt</span></h5>
                    </div>
                    <div class="col-md-5 col-sm-5 rght1">
                        <h5 class="orang2">GOV No: <span style="color:#5f6062">2384234002340</span></h5>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-4 col-sm-4 lft">
                        <h5 class="orang2">Join date: <span style="color:#5f6062">13/4/2013</span></h5>
                    </div>
                    <div class="col-md-3 col-sm-3 rght1">
                        <h5 class="orang2" style="margin-top:3px">Department: <span style="color:#5f6062">
     <div class="dropdowny ">
                    <select name="two" class="dropdown-select">
                      <option value="">Packing</option>
                      <option value="1">Oldest</option>

                    </select>
                 </div>
     </span></h5>
                    </div>
                    <div class="col-md-3 col-sm-3 rght1">
                        <h5 class="orang2">Position: <span style="color:#5f6062">Worker</span></h5>
                    </div>
                    <div class="col-md-2 col-sm-2 rght">
                        <h5 class="orang2">Office: <span style="color:#5f6062">Maadi</span></h5>
                    </div>
                </div>
            </div>


        </div>

    </div>
    <div class="clearfix"></div>
    <div class="orders-table">



        <div class="table-responsive text-center">
            <h2 class="orang1 text-left" style="margin-bottom:10px; ">My Received requests</h2>
            <table class="table main-table">
                <thead class="text-center">
                <tr>

                    <th>Tracking No</th>
                    <th>Receiver Name</th>
                    <th>Mobile</th>
                    <th>COD Value</th>
                    <th>Area</th>
                    <th>Address</th>

                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>123</td>
                    <td>q7p90z31</td>
                    <td>Samir Ahmed</td>
                    <td >Cairo</td>
                    <td>Maadi</td>
                    <td>sadadada</td>
                </tr>
                <tr>
                    <td>123</td>
                    <td>q7p90z31</td>
                    <td>Samir Ahmed</td>
                    <td >Cairo</td>
                    <td>Maadi</td>
                    <td>sadadada</td>
                </tr>
                <tr>
                    <td>123</td>
                    <td>q7p90z31</td>
                    <td>Samir Ahmed</td>
                    <td >Cairo</td>
                    <td>Maadi</td>
                    <td>sadadada</td>
                </tr>
                </tbody>


            </table>

        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 col-sm-5 col-xs-12 lft">
            <a href="#" class="btn btn-gry"><i class="exl"></i> Export</a>
        </div>                                                                                                                                  			<div class="col-md-4 col-sm-5 col-xs-12">
            <ul class="pagination">
                <li ><a href="#"><i class="icon fa fa-chevron-left"></i></a>
                </li>
                <li class="active"><a href="#">1</a></li>
                <li ><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li ><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li ><a href="#">6</a></li>
                <li><a href="#">7</a></li>
                <li><a href="#"><i class="icon fa fa-chevron-right"></i></a>
                </li>
            </ul>
        </div>
        <div class="col-md-2 col-sm-2 pull-right rght">
            <a href="#squarespaceModal-15" data-toggle="modal" class="btn btn-gry p_20 nw-pad pull-right " style="margin-bottom:25px; padding:6px 24px; margin-right:0 "><i class="scan2"></i> Scan</a>
        </div>

    </div>
@endsection
