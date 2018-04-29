<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
	Auth::routes();
	Route::get('/', 'HomeController@frontend');
	Route::get('/terms-and-conditions', 'HomeController@terms_and_conditions');
	Route::get('/help', 'HomeController@help');
	Route::post('/languages',  'HomeController@languages');

	Route::post('/getintouch', 'HomeController@getintouch');
	Route::get('/abc', 'HomeController@abc');
	Route::get('/seller/login', function(){
		Session::flash('seller', 'seller');
		return view('auth.login');
	});
	Route::get('vehicles/qrcode/{id}', 'VehicleController@printview');
	//email verify 
	Route::get('email/verify/confirm/{confirmationCode}', 'HomeController@verifyemailconfirm');
	 
	Route::post('api/auth', 'AuthenticateController@authenticate');
	Route::post('api/seller/auth', 'AuthenticateController@authenticateseller');
	Route::post('api/signup', 'AuthenticateController@signup');
	Route::post('api/validate', 'AuthenticateController@validateuser');
	//forgot password
	Route::get('api/forgotpassword/request', 'AuthenticateController@forgot_password');
	Route::get('api/forgotpassword/validate', 'AuthenticateController@validate_password');
	Route::get('api/forgotpassword/reset', 'AuthenticateController@forgot_resetpassword');
		
	Route::post('api/forgotpassword/request', 'AuthenticateController@forgot_password');
	Route::post('api/forgotpassword/validate', 'AuthenticateController@validate_password');
	Route::post('api/forgotpassword/reset', 'AuthenticateController@forgot_resetpassword');	

	Route::post('api/map', 'UserController@api_map');
	Route::post('api/states', 'VehicleController@api_states');

	Route::group(['prefix' => 'api', 'middleware' => ['api_auth']], function (){
		Route::post('getuser', 'AuthenticateController@getuser');
		Route::post('changepassword', 'AuthenticateController@changepassword');
		Route::post('contactus', 'AuthenticateController@contactus');
		Route::post('vehicles/create', 'VehicleController@api_create');
		Route::post('countries', 'VehicleController@api_countries');
		
		Route::post('vehicles', 'VehicleController@api_index');
		Route::post('vehicles/update', 'VehicleController@api_update');
		Route::post('invite/email', 'AuthenticateController@invite_friend_email');
		Route::post('invite/sms', 'AuthenticateController@invite_friend_sms');
		
		Route::post('main', 'HomeController@api_main');
		Route::post('deposit', 'OperationController@api_deposit');
		//reports
		Route::post('reports',  'OperationController@api_reports');
		//sendmoney
		Route::post('/sendmoney', 'UserController@api_sendmoney');
		Route::post('/redeem_voucher', 'UserController@api_redeem_voucher');
	});

	Route::group(['prefix' => 'api', 'middleware' => ['api_auth_seller']], function (){
		Route::post('operation',  'OperationController@acceptfromUserToSeller');
		Route::post('operation/pending',  'OperationController@api_pendingoperation');
		Route::post('operation/confirm',  'OperationController@api_confirmpayment');
		Route::post('operation/history', 'OperationController@api_operationhistory');
	});
 
	Route::group(['middleware' => ['auth']], function (){
		Route::get('/home', 'HomeController@index');
		Route::post('/getcities',  'HomeController@getcities');
		Route::get('verify/email', 'HomeController@verifyemail');
		Route::post('verify/sms/request', 'HomeController@smsrequest');
		Route::post('verify/sms/validate', 'HomeController@smsvalidate');
	});
	
	Route::group(['prefix' => 'admin', 'middleware' =>['auth', 'admin']], function () {
		Route::get('/home', 'HomeController@adminindex');
		Route::get('/', 'HomeController@adminindex');
		
		Route::get('/users', 'UserController@admin_browser');
		Route::post('/users', 'UserController@admin_browser');
		Route::get('user/delete/{id}', 'UserController@deleteuser');
		
		Route::get('users/export', 'UserController@admin_browser_export');
		Route::get('users/export/pdf', 'UserController@admin_browser_export_pdf');
		
		Route::get('users/statement/export/{id}', 'UserController@statement_export');
		Route::get('users/statement/export_pdf/{id}', 'UserController@statement_export_pdf')->name('statement_export_pdf');
		Route::get('/users/statement/{id}', 'UserController@statement');

		Route::get('users/getdetails/{id}', 'UserController@userdetailforboth')->name('adminuserdetails');
		Route::post('users/getdetails/{id}', 'UserController@userdetailforboth');

		Route::get('/users/statement/details/{id}', 'UserController@sellerdetails');
		Route::get('/download/attachment/{id}', 'UserController@admindownload_attach');
		
		Route::get('/users/addnewemployee', 'HomeController@addnewemployee');
		Route::post('/users/addnewemployee', 'HomeController@addnewemployee');

		Route::get('/users/updateemployee/{id}', 'HomeController@updateemployee');
		Route::post('/users/updateemployee/{id}', 'HomeController@updateemployee');
		
		/// payment mangement 
		Route::get('/paymentmanager', 'UserController@paymentmanager')->name('paymentmanager');
		Route::post('/paymentmanager', 'UserController@paymentmanager');
		
		//messsages
		Route::get('/messsages', 'HomeController@messages')->name('messages');
		Route::post('/messsages', 'HomeController@messages');
		Route::get('/messsages/export', 'HomeController@messages_export');
		Route::get('/messsages/export/pdf', 'HomeController@messages_export_pdf');
		Route::post('message/item', 'HomeController@message');
		// user settings
		Route::get('/usersettings',  'HomeController@usersettings')->name('adminusersettings');
		Route::post('/usersettings', 'HomeController@usersettings');
		
		Route::get('/map', 'HomeController@map')->name('adminmap');
		Route::get('/attendances', 'HomeController@attendances')->name('attendances');
		Route::get('attendances/export', 'HomeController@attendances_export');
		Route::get('attendances/export/pdf', 'HomeController@attendances_export_pdf');

		// feeds management
		Route::get('/feesmanagement', 'HomeController@feedsmanagement')->name('feedsmanagement');
		Route::post('/feesmanagement', 'HomeController@feedsmanagement');
		Route::post('/feesmanagement/add', 'HomeController@feesadd')->name('adminfeesadd');
 
		Route::get('/feesmanagement/subscription', 'HomeController@subscriptionfees')->name('subscriptionfees');
		Route::post('/feesmanagement/subscription', 'HomeController@subscriptionfees');
		Route::post('/getallusers', 'HomeController@getusers');
		Route::post('/subscription/add', 'HomeController@addsubscription');
		 
		// operation Deposit
		Route::get('/depositmanagement', 'OperationController@depositmanagement')->name('depositmanagement');
		Route::post('/depositmanagement', 'OperationController@depositmanagement');
		Route::get('/depositmanagement/export', 'OperationController@depositmanagement_export');
		Route::get('/depositmanagement/export/pdf', 'OperationController@depositmanagement_export_pdf');
		// admin deposit
		Route::get('/admindeposit', 'OperationController@userdeposit')->name('admindeposit');
		Route::post('/admindeposit', 'OperationController@userdeposit');

		// Operation widthraw 
		Route::get('/withdrawmanagement', 'OperationController@withdrawmanagement')->name('withdrawmanagement');
		Route::post('/withdrawmanagement', 'OperationController@withdrawmanagement');
		Route::get('/withdrawmanagement/export', 'OperationController@withdrawmanagement_export');
		Route::get('/withdrawmanagement/export/pdf', 'OperationController@withdrawmanagement_export_pdf');

		Route::get('/withdrawmanagement/userrequest',  'OperationController@userwithdraw');
		Route::post('/withdrawmanagement/userrequest', 'OperationController@userwithdraw');

		Route::get('/withdrawmanagement/sellerrequest',  'OperationController@sellerwithdraw')->name('sellerwithdraw');
		Route::post('/withdrawmanagement/sellerrequest', 'OperationController@sellerwithdraw');

		Route::get('/withdrawmanagement/adminrequest', 'OperationController@adminwithdraw')->name('adminwithdraw');
		Route::post('/withdrawmanagement/adminrequest', 'OperationController@adminwithdraw');
		 
		///notfication
		Route::get ('/notification',  'VehicleController@adminnotification')->name('adminnotification');
		Route::post('/notification', 'VehicleController@adminnotification');
		Route::get('/notification/export', 'VehicleController@adminnotification_export');
	    Route::get('/notification/export/pdf', 'VehicleController@adminnotification_pdf');

		// fuel station
		Route::get('/coupons', 'OperationController@couponsmanagement')->name('couponsmanagement');
		Route::get('/coupons/create', 'OperationController@couponscreate');
		Route::post('/coupons/create', 'OperationController@couponscreate');
		Route::get('/coupons/update/{id}',  'OperationController@couponsupdate');
		Route::post('/coupons/update/{id}', 'OperationController@couponsupdate');
		
		Route::get('/coupons/delete/{id}', 'OperationController@couponsdelete');
		Route::get('/coupon/usage/{id}', 'OperationController@couponsusages');
		
		Route::post('/setting', 'HomeController@adminsetting');
		  
		Route::get('/vouchers',			     'OperationController@vouchermanagement')->name('vouchermanagement');
		Route::get('/vouchers/create',		 'OperationController@voucherscreate');
		Route::post('/vouchers/create', 	 'OperationController@voucherscreate');
		Route::get('/vouchers/update/{id}',  'OperationController@vouchersupdate')->name('voucherupdate');
		Route::post('/vouchers/update/{id}', 'OperationController@vouchersupdate');
		Route::get('/vouchers/delete/{id}',  'OperationController@vouchersdelete')->name('voucherdelete');
		Route::get('/vouchers/usage/{id}',   'OperationController@vouchersusages')->name('voucherusage');
 
		// admin
		Route::get('/reports', 'HomeController@reports')->name('adminreport');
		Route::post('/reports', 'HomeController@reports');
		Route::get("/reports/export", "HomeController@reports_export");
		Route::get("/reports/export/pdf", "HomeController@reports_export_pdf");
        Route::get('/reports/details/{id}', 'HomeController@report_detail')->name('adminreportdetails');

		//get in touch
		Route::get('/getintouch', 'HomeController@admingetintouch')->name('admingetintouch');
		Route::post('/getintouch', 'HomeController@admingetintouch');
		Route::get('/getintouch/export', 'HomeController@admingetintouch_export');
		Route::get('/getintouch/export/pdf', 'HomeController@admingetintouch_export_pdf');

		Route::get('history', 'HomeController@history')->name('adminhistory');

		Route::get('/setting', 'HomeController@adminsettings')->name('adminsettings');
	 

		//  qr code stop
		Route::get('/qrstatus', 'VehicleController@qrstatusmanagement')->name('adminqrstatus');
		Route::post('/qrstatus', 'VehicleController@qrstatusmanagement');
	});

	Route::group(['prefix' => 'seller', 'middleware' =>  ['auth', 'seller']], function () {
		Route::get('/home', 'HomeController@sellerindex');
		Route::get('/', 'HomeController@sellerindex');
		
		Route::get('/fuelstation', 'SellerController@fuelstation')->name('fuelstation');
		Route::post('/fuelstation', 'SellerController@fuelstation');
		Route::get('fuelstation/export', 'SellerController@fuelstation_export');
		Route::get('fuelstation/export/pdf', 'SellerController@fuelstation_export_pdf');
		
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
		Route::get('/reports/export/pdf', 'SellerController@reports_export_pdf');
		
		
		//pos employeer
		Route::get('/employeers', 'SellerController@employeers')->name('selleremployeers');
		Route::get('/employeers/create', 'SellerController@employeerscreate');
		Route::post('/employeers/create', 'SellerController@employeerscreate');
		
		Route::get('/employeers/delete/{id}', 'SellerController@employeerdelete');
		Route::get('/employeers/update/{id}', 'SellerController@employeerupdate');
		Route::post('/employeers/update/{id}', 'SellerController@employeerupdate');
		
		//web employeer
		Route::get('/workers', 'SellerController@workers')->name('sellerworkerlist');
		Route::get('/workers/delete/{id}', 'SellerController@workerdelete')->name('sellerworkerdelete');
		Route::get('/workers/create', 'SellerController@workercreate')->name('sellerworkers');
		Route::post('/workers/create', 'SellerController@workercreate');
	});
 
	Route::group(['prefix' => 'user', 'middleware' => ['auth', 'user']], function (){
		Route::get('/home', 'HomeController@userindex');
		Route::get('/', 'HomeController@userindex');
		
		Route::post('/vehicles/create',  'VehicleController@create');
		
		Route::get('/vehicles/export', 'VehicleController@export');
		Route::get('/vehicles/export/pdf', 'VehicleController@export_pdf');

		Route::get('/vehicles/update/{id}',  'VehicleController@update');
		Route::post('/vehicles/update/{id}',  'VehicleController@update');
		Route::get('/vehicles/delete/{id}',  'VehicleController@delete');
		Route::resource('vehicles', 'VehicleController');
		
		Route::get('/vehicles/qrcode/{id}', 'VehicleController@qrcode');

		//  notifications
		Route::get('/notification', 'VehicleController@usernotification')->name('usernotification');
		Route::post('/notification', 'VehicleController@usernotification');

		Route::get('/notification/export', 'VehicleController@usernotification_export');
		Route::get('/notification/export/pdf', 'VehicleController@usernotification_export_pdf');
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
		Route::get('/reports/export/pdf', 'UserController@reports_export_pdf');
		Route::get('/report/details/{id}', 'UserController@report_detail')->name('userreportdetails');
		Route::get('/download/attachment/{id}', 'UserController@userdownload_attach');
		//route
		Route::get('/sendmoney', 'UserController@sendmoney')->name('usersendmoney');
		Route::post('/sendmoney', 'UserController@sendmoney');

		//redeem_voucher
		Route::get('/voucher', 'UserController@redeem_voucher')->name('redeem_voucher');
		Route::post('/voucher', 'UserController@redeem_voucher');
	});

	Route::group(['prefix' => 'cron', 'middleware' => []], function (){
		Route::get('/pending', 'CronController@pending');
		Route::get('/withdraw', 'CronController@withdraw');
		Route::get('/collectingsubscription', 'CronController@collectingsubscription');
		Route::get('/changeExpireStatus', 'CronController@changeExpireStatus');
	});