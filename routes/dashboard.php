<?php
/*
Route::get('dashboard/login','AgentAuth\AgentLoginController@showLoginForm')->name('agent.login');
Route::post('dashboard/login','AgentAuth\AgentLoginController@login')->name('agent.login.submit');
// Password reset routes
Route::post('dashboard/password/email', 'AgentAuth\AgentForgotPasswordController@sendResetLinkEmail')->name('agent.password.email');
Route::get('dashboard/password/reset', 'AgentAuth\AgentForgotPasswordController@showLinkRequestForm')->name('agent.password.request');
Route::post('dashboard/password/reset', 'AgentAuth\AgentResetPasswordController@reset');
Route::get('dashboard/password/reset/{token}', 'AgentAuth\AgentResetPasswordController@showResetForm')->name('agent.password.reset');*/

/*
Route::group(['prefix' =>'dashboard','middleware' => ['web','auth:agent','li_active']],function (){
    Route::get('/logout','AgentAuth\AgentLoginController@logout')->name('agent.logout');
    Route::get('/', 'Dashboard\DashboardController@index')->name('Dashboard');


    Route::resource('/cities','Dashboard\CityController');
    Route::resource('/offices','Dashboard\OfficeController');
    Route::resource('/areas','Dashboard\AreaController');
    Route::resource('/departments','Dashboard\DepartmentController');
    Route::resource('/employees','Dashboard\EmployeeController');
    Route::resource('/positions','Dashboard\PositionController');
    Route::resource('/clients','Dashboard\ClientController');
    Route::post('/clients/{client_id}/shippingfees','Dashboard\ClientController@update_shipping_fees')->name('clients.shippingfees');
    Route::resource('/applications','Dashboard\ClientRequestController');



});*/


Route::prefix('dashboard')->group(function () {
    Route::get('/login', 'AgentAuth\AgentLoginController@showLoginForm')->name('agent.login');
    Route::post('/login', 'AgentAuth\AgentLoginController@login')->name('agent.login.submit');
    Route::post('password/email', 'AgentAuth\AgentForgotPasswordController@sendResetLinkEmail')->name('agent.password.email');
    Route::get('password/reset', 'AgentAuth\AgentForgotPasswordController@showLinkRequestForm')->name('agent.password.request');
    Route::post('password/reset', 'AgentAuth\AgentResetPasswordController@reset');
    Route::get('password/reset/{token}', 'AgentAuth\AgentResetPasswordController@showResetForm')->name('agent.password.reset');

    Route::group(['middleware' => ['li_active', 'auth:agent','agent_profile','route_permissions']], function () {
        Route::get('/', 'Dashboard\DashboardController@index')->name('Dashboard');
        Route::get('/logout','AgentAuth\AgentLoginController@logout')->name('agent.logout');

        Route::resource('/cities','Dashboard\CityController');
        Route::resource('/offices','Dashboard\OfficeController');
        Route::resource('/areas','Dashboard\AreaController');
        Route::resource('/departments','Dashboard\DepartmentController');
        Route::post('/employees/exportDeliveryExcel','Dashboard\EmployeeController@exportDeliveryExcel')->name('employees.exportDeliveryExcel');
        Route::get('/employees/exportExcel','Dashboard\EmployeeController@exportExcel')->name('employees.exportExcel');
        Route::resource('/employees','Dashboard\EmployeeController');
        Route::post('/employees/permissions','Dashboard\EmployeePermissionController@assignPermission')->name('employees.permissions');
        Route::get('/clients/exportExcel','Dashboard\ClientController@exportExcel')->name('clients.exportExcel');
        Route::resource('/clients','Dashboard\ClientController');
        Route::post('/clients/{client_id}/shippingfees','Dashboard\ShippingFeesController@update_shipping_fees')->name('clients.shippingfees');
        Route::get('/applications/exportExcel','Dashboard\ClientRequestController@exportExcel')->name('applications.export');
        Route::resource('/applications','Dashboard\ClientRequestController');
        Route::get('/supports/exportExcel','Dashboard\SupportController@exportExcel')->name('supports.export');
        Route::resource('/supports','Dashboard\SupportController');
        Route::get('/supports/{ticket}/messages','MessageController@ticket_messages')->name('supports.getMessages');
        Route::post('/supports/{ticket}/messages','MessageController@send_messages')->name('supports.sendMessages');

        Route::get('/pickup_requests/exportExcel','Dashboard\PickupRequestController@exportExcel')->name('pickup_requests.exportExcel');
        Route::resource('/pickup_requests','Dashboard\PickupRequestController');

        Route::get('/collections/export','Dashboard\CollectionController@export')->name('collections.export');
        Route::resource('/collections','Dashboard\CollectionController');

        Route::get('/wallets/export','Dashboard\WalletController@export')->name('wallets.export');
        Route::resource('/wallets','Dashboard\WalletController');

        Route::get('/finances/exportExcel','Dashboard\FinanceController@exportExcel')->name('finances.exportExcel');
        Route::resource('/finances','Dashboard\FinanceController');

        Route::post('/shipments/printTable','Dashboard\OrderController@print_policy')->name('shipments.printTable');
        Route::get('/shipments/exportExcel','Dashboard\OrderController@exportExcel')->name('shipments.exportExcel');
        Route::get('/shipments/printPolicy/{id}','Dashboard\OrderController@printPolicy')->name('shipments.printPolicy');
        Route::resource('/shipments','Dashboard\OrderController');

        Route::get('/profile','Dashboard\ProfileController@index')->name('profile');
        Route::get('/my_profile','Dashboard\EmployeeController@employeeProfile')->name('My.profile');
        Route::get('/profile/export','Dashboard\DeliveryAgentController@exportMyOrders')->name('profile.exportMyOrders');
        Route::get('/profile/salesOrders/{id}','Dashboard\SalesPersonController@displayOrder')->name('salesOrder.show');
        Route::post('/profile/export/{id}','Dashboard\SalesPersonController@exportOrders')->name('profile.export');

        Route::get('/shipments/salesPrintPolicy/{id}','Dashboard\SalesPersonController@printPolicy')->name('shipments.salesPrintPolicy');


        Route::prefix('scanner')->group(function () {

            Route::get('/', 'Dashboard\ScanController@index')->name('scanner.index');
            Route::post('/', 'Dashboard\ScanController@update')->name('scanner.update');
            Route::post('/pickupScan/{id}', 'Dashboard\ScanController@pickupAgentUpdateStatus')->name('pickupScanner.store');
        });


//        Route::post('/profile/newCall','Dashboard\SalesPersonController@storeCall')->name('profile.newCall');
//        Route::post('/profile/newMeeting','Dashboard\SalesPersonController@storeMeeting')->name('profile.newMeeting');
//        Route::post('/profile/newAttendance','Dashboard\SalesPersonController@storeAttendance')->name('profile.newAttendance');




    });
});
