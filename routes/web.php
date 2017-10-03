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
	Auth::routes();
	Route::get('/', 'HomeController@frontend');
	Route::get('/terms-and-conditions', 'HomeController@terms_and_conditions');
	Route::get('/help', 'HomeController@help');
	Route::post('/languages',  'HomeController@languages');
	Route::get('/abc', 'HomeController@abc');
	
	Route::get('api/auth', 'AuthenticateController@authenticate');
	Route::post('api/auth', 'AuthenticateController@authenticate');
	
	Route::get('api/seller/auth', 'AuthenticateController@authenticateseller');
	Route::post('api/seller/auth', 'AuthenticateController@authenticateseller');
	
	
	Route::get('api/signup', 'AuthenticateController@signup');
	Route::post('api/signup', 'AuthenticateController@signup');


	Route::post('api/validate', 'AuthenticateController@validateuser');
    Route::get('api/validate', 'AuthenticateController@validateuser');

	 
	Route::group(['prefix' => 'api', 'middleware' => ['api_auth']], function (){
		Route::get('getuser', 'AuthenticateController@getuser');
		Route::post('getuser', 'AuthenticateController@getuser');

		Route::get('changepassword', 'AuthenticateController@changepassword');
		Route::post('changepassword', 'AuthenticateController@changepassword');
		
		Route::get('contactus', 'AuthenticateController@contactus');
		Route::post('contactus', 'AuthenticateController@contactus');
		
		Route::get('vehicles/create', 'VehicleController@api_create');
		Route::post('vehicles/create', 'VehicleController@api_create');
		
		Route::get('countries', 'VehicleController@api_countries');
		Route::post('countries', 'VehicleController@api_countries');
		
		Route::get('states', 'VehicleController@api_states');
		Route::post('states', 'VehicleController@api_states');
		
		Route::get('vehicles', 'VehicleController@api_index');
		Route::post('vehicles', 'VehicleController@api_index');
		
		Route::get('vehicles/update', 'VehicleController@api_update');
		Route::post('vehicles/update', 'VehicleController@api_update');
		
		Route::post('invite/email', 'AuthenticateController@invite_friend_email');
		Route::get('invite/email', 'AuthenticateController@invite_friend_email');
		
		Route::get('invite/sms', 'AuthenticateController@invite_friend_sms');
		Route::post('invite/sms', 'AuthenticateController@invite_friend_sms');
		 
		Route::post('map', 'UserController@api_map');
		Route::get('map', 'UserController@api_map');
		
		Route::get('main', 'HomeController@api_main');
		Route::post('main', 'HomeController@api_main');
		
		Route::post('deposit', 'OperationController@api_deposit');
		Route::get('deposit',  'OperationController@api_deposit');
		
		//reports
		Route::get('reports',  'OperationController@api_reports');
		Route::post('reports',  'OperationController@api_reports');
	});
	
	
	Route::group(['prefix' => 'api', 'middleware' => ['api_auth_seller']], function (){
		Route::post('operation',  'OperationController@acceptfromUserToSeller');
		Route::get('operation',  'OperationController@acceptfromUserToSeller');
		
		Route::post('operation/pending',  'OperationController@api_pendingoperation');
		Route::get('operation/pending',  'OperationController@api_pendingoperation');
		
		Route::get('operation/confirm',  'OperationController@api_confirmpayment');
		Route::post('operation/confirm',  'OperationController@api_confirmpayment');
	});

	
	Route::group(['middleware' => ['auth']], function (){
		Route::get('/home', 'HomeController@index');
		Route::post('/getcities',  'HomeController@getcities');
	});
	
	Route::group(['prefix' => 'admin', 'middleware' =>['auth', 'admin']], function () {
		Route::get('/home', 'HomeController@adminindex');
		Route::get('/', 'HomeController@adminindex');
		
		Route::get('/users', 'UserController@admin_browser');
		Route::post('/users', 'UserController@admin_browser');

		Route::get('users/export', 'UserController@admin_browser_export');
		
		Route::get('users/statement/export/{id}', 'UserController@statement_export');
		Route::get('/users/statement/{id}', 'UserController@statement');

		Route::get('/users/statement/details/{id}', 'UserController@sellerdetails');
		
		Route::get('/download/attachment/{id}', 'UserController@admindownload_attach');
		
		Route::get('/users/addnewemployee', 'HomeController@addnewemployee');
		Route::post('/users/addnewemployee', 'HomeController@addnewemployee');
		
		/// payment mangement 
		Route::get('/paymentmanager', 'UserController@paymentmanager')->name('paymentmanager');
		Route::post('/paymentmanager', 'UserController@paymentmanager');
		
		//messsages
		Route::get('/messsages', 'HomeController@messages')->name('messages');
		Route::post('/messsages', 'HomeController@messages');
		Route::get('/messsages/export', 'HomeController@messages_export');
		
		// user settings
		Route::get('/usersettings',  'HomeController@usersettings')->name('adminusersettings');
		Route::post('/usersettings', 'HomeController@usersettings');
		
		Route::get('/map', 'HomeController@map')->name('adminmap');
		
		Route::get('/attendances', 'HomeController@attendances')->name('attendances');
		Route::get('attendances/export', 'HomeController@attendances_export');

		// feeds management
		
		Route::get('/feesmanagement', 'HomeController@feedsmanagement')->name('feedsmanagement');
		Route::post('/feesmanagement', 'HomeController@feedsmanagement');
		Route::post('/getallusers', 'HomeController@getusers');
		Route::post('/subscription/add', 'HomeController@addsubscription');
		
		
		// operation Deposit
		Route::get('/depositmanagement', 'OperationController@depositmanagement')->name('depositmanagement');
		Route::post('/depositmanagement', 'OperationController@depositmanagement');
		Route::get('/depositmanagement/export', 'OperationController@depositmanagement_export');

		// Operation widthraw 
		Route::get('/withdrawmanagement', 'OperationController@withdrawmanagement')->name('withdrawmanagement');
		Route::post('/withdrawmanagement', 'OperationController@withdrawmanagement');
		Route::get('/withdrawmanagement/export', 'OperationController@withdrawmanagement_export');

		///notfication
		Route::get ('/notification',  'VehicleController@adminnotification')->name('adminnotification');
		Route::post('/notification', 'VehicleController@adminnotification');
		Route::get('/notification/export', 'VehicleController@adminnotification_export');
		
		// fuel station
		Route::get('/coupons', 'OperationController@couponsmanagement')->name('couponsmanagement');
		Route::get('/coupons/create', 'OperationController@couponscreate');
		Route::post('/coupons/create', 'OperationController@couponscreate');
		Route::get('/coupons/update/{id}',  'OperationController@couponsupdate');
		Route::post('/coupons/update/{id}', 'OperationController@couponsupdate');
		
		Route::get('/coupons/delete/{id}', 'OperationController@couponsdelete');
		Route::post('/setting', 'HomeController@adminsetting');
		
		// admin
		Route::get('/reports', 'HomeController@reports')->name('adminreport');
		Route::post('/reports', 'HomeController@reports')->name('adminreport');

		Route::get("/reports/export", "HomeController@reports_export");
	});

	Route::group(['prefix' => 'seller', 'middleware' =>  ['auth', 'seller']], function () {
		Route::get('/home', 'HomeController@sellerindex');
		Route::get('/', 'HomeController@sellerindex');
		
		Route::get('/fuelstation', 'SellerController@fuelstation')->name('fuelstation');
		Route::post('/fuelstation', 'SellerController@fuelstation');
		Route::get('fuelstation/export', 'SellerController@fuelstation_export');
		
		Route::get('/fuelstation/create', 'SellerController@fuelstationcreate')->name('fuelstationcreate');
		Route::post('/fuelstation/create', 'SellerController@fuelstationcreate');
		
		Route::get('fuelstation/update/{id}',  'SellerController@fuelstationupdate');
		Route::post('fuelstation/update/{id}', 'SellerController@fuelstationupdate');
		
		Route::get('fuelstation/delete/{id}', 'SellerController@fuelstationdelete');
		// coupons
		Route::get('/coupons', 'SellerController@coupons')->name('sellercoupons');
		Route::post('/coupons', 'SellerController@coupons');
		
		Route::get('/coupons/create',   'SellerController@couponscreate');
		Route::post('/coupons/create',  'SellerController@couponscreate');
		Route::get('/coupons/update/{id}',  'SellerController@couponsupdate');
		Route::post('/coupons/update/{id}', 'SellerController@couponsupdate');
		Route::get('/coupons/delete/{id}', 'SellerController@couponsdelete');
		
		Route::get('/contactus', 'SellerController@contactus')->name('sellercontactus');
		Route::post('/contactus', 'SellerController@contactus');
		
		// user settings
		Route::get('/usersettings', 'SellerController@usersettings')->name('sellerusersettings');
		Route::post('/usersettings', 'SellerController@usersettings');
		
		//repots
		Route::get('/reports', 'SellerController@reports')->name('sellerreports');
		Route::post('/reports', 'SellerController@reports');
		Route::get('/reports/details/{id}', 'SellerController@reportsdetails');
		Route::get('/reports/export', 'SellerController@reports_export');
		
		
		//employeer
		Route::get('/employeers', 'SellerController@employeers')->name('selleremployeers');
		Route::get('/employeers/create', 'SellerController@employeerscreate');
		Route::post('/employeers/create', 'SellerController@employeerscreate');
		
		
	});
 
	Route::group(['prefix' => 'user', 'middleware' => ['auth', 'user']], function (){
	
		Route::get('/home', 'HomeController@userindex');
		Route::get('/', 'HomeController@userindex');
		
		Route::post('/vehicles/create',  'VehicleController@create');
		
		Route::get('/vehicles/export', 'VehicleController@export');

		Route::get('/vehicles/update/{id}',  'VehicleController@update');
		Route::post('/vehicles/update/{id}',  'VehicleController@update');
		Route::get('/vehicles/delete/{id}',  'VehicleController@delete');
		Route::resource('vehicles', 'VehicleController');
		
		Route::get('/vehicles/qrcode/{id}', 'VehicleController@qrcode');

		//  notifications
		Route::get('/notification', 'VehicleController@usernotification')->name('usernotification');
		Route::post('/notification', 'VehicleController@usernotification');

		Route::get('/notification/export', 'VehicleController@usernotification_export');
		
		
		/////////////////////////////////////
		Route::get("/operations/widthrawls", 'OperationController@widthrawls')->name('userwidthraw');
		Route::get("/operations/widthraw", 'OperationController@widthraw');
		Route::post("/operations/widthraw", 'OperationController@widthraw');
		
		Route::get("/operations/deposits", 'OperationController@deposits')->name('userdeposit');
		Route::post("/operations/deposits", 'OperationController@deposits');
		Route::get("/operations/deposit", 'OperationController@deposit');
		Route::post("/operations/deposit", 'OperationController@deposit');
		 
		//  filling up parts
		Route::get("/fillingup", 'UserController@fillingup')->name('fillingup');
		Route::post("/fillingup", 'UserController@fillingup');
			// invite friedn
		Route::post('/invite', 'UserController@invitefriend');

		//contact us
		Route::get('/contactus', 'UserController@contactus')->name('contactus');
		Route::post('/contactus', 'UserController@contactus');
		
		// user settings
		Route::get('/usersettings',  'UserController@usersettings')->name('userusersettings');
		Route::post('/usersettings', 'UserController@usersettings');
		
		//google map
		Route::get('/map', 'UserController@map')->name('usermap');
		
		//repots
		Route::get('/reports', 'UserController@reports')->name('userreports');
		Route::post('/reports', 'UserController@reports');		
		Route::get('/reports/export', 'UserController@reports_export');
	});

	Route::group(['prefix' => 'cron', 'middleware' => []], function (){
		Route::get('/pending', 'CronController@pending');
		Route::get('/withdraw', 'CronController@withdraw');
	});
// Unregistered users. later will make unregistered user.
