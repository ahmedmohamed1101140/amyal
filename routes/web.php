<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home.index');
Route::post('/newrequest', 'HomeController@storeRequest')->name('clientRequests.store');
Route::post('/orders', 'HomeController@find_order')->name('orders.find');
Route::post('/password','HomeController@update_password')->name('update_password');

Route::get('/logout', 'Auth\LoginController@userLogout')->name('home.logout');
Auth::routes();

Route::group(['prefix' => 'home','middleware' => ['web','auth:web','first_login']],function() {
    Route::get('/', 'Site\WelcomeController@index')->name('home');

    Route::post('/orders/printTable','Site\OrderController@print_policy')->name('orders.printTable');
    Route::get('/orders/endOfDay','Site\OrderController@endOfDay')->name('orders.endOfDay');
    Route::get('/orders/export','Site\OrderController@export_all')->name('orders.export');
    Route::get('/profile','Site\ProfileController@index')->name('profile.index');
    Route::resource('/orders','Site\OrderController');
    Route::get('/pickupRequest','Site\PickupRequestController@createPickupRequest')->name('pickupRequest');
    Route::resource('/tickets','Site\TicketController');
    Route::get('/tickets/{ticket}/messages','MessageController@ticket_messages')->name('tickets.getMessages');
    Route::post('/tickets/{ticket}/messages','MessageController@send_messages')->name('tickets.sendMessages');


    Route::prefix('finances')->group(function () {
        Route::get('/', 'Site\FinanceController@index')->name('homeFinances.index');
        Route::get('/export', 'Site\FinanceController@export')->name('homeFinances.export');
    });
    Route::prefix('wallets')->group(function () {
        Route::get('/export', 'Site\FinanceController@exportWallet')->name('wallet.exportClient');
    });

});




