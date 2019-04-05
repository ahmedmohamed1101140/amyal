<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Api\LoginController@authenticate');
Route::get('open', 'Api\DataController@open');

Route::get('user', 'Api\LoginController@getAuthenticatedUser');
Route::get('closed', 'Api\DataController@closed');


Route::post('/order_updates','Api\ScanController@updateStatus');

Route::post('/get_status','Api\DataController@getStatuses');
Route::post('/get_client_orders','Api\OrderController@getClientOrders');
Route::get('get_my_orders','Api\OrderController@getMyOrders');


Route::post('/pickup_requests','Api\PickupController@pickupAgentRequests');
Route::post('/pickup_update_requests','Api\PickupController@pickupAgentUpdateRequests');