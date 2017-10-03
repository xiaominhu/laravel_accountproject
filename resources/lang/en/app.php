<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */
  
   /******************************************************************  back end *****************************************/
	// log in page
	'self_station_login' => 'SelfStation | Login',
	'sign_in' => 'Sign In',
	'email_mobile_no' => 'Email/Mobile No.',
	'enter_phonenumber_and_password' => 'Enter any phone number and password.',
	'password' => 'Password',
	'remember' => 'Remember',
	'back' => 'Back',
	'submit' => 'Submit',
	'forgot_password' => 'Forgot Password?',
	'create_a_client_account' => 'Create a client account',
	'create_a_seller_account' => 'Create a seller account',
	'enter_youremail_address_to_reset' => 'Enter your e-mail address below to reset your password. ',
	'sign_up' => 'Sign Up',
	'full_name' => 'Full Name',
	'enter_your_personal_details' => 'Enter your personal details below ',
	'close' => 'Close',
	'verification_code' => 'Verification Code',
	'verify_phone_number' => 'Verify Phone Number',
	'privacy_policy' => 'Privacy Policy',
	'terms_of_service' => 'Terms of Service',
	'i_agree_to_the' => 'I agree to the',
	'business_license_number' => 'Business License Number',
	'companyname_or_service' => 'Company Name or Service',
	'enter_your_personal_details_below' => 'Enter your personal details below',
	'show_password' => 'Show password',
	 
	
	///////////////////////////////////////////////////////////admin dashboard /////////////////////////////////////////////////////////
	
    'home' => 'Home',
    'main_page' => 'Main Page',
    'user_management' => 'Users Management',
    'payment_manager_methods' => 'Payment Manager Methods',
    'feeds_management' => 'Fees Management',
    'operation_manager_deposit' => 'Operation Manager Deposit',
    'operation_manager_withdrawl' => 'Operation Manager Withdrawl',
    'manager_notifications' => 'Manager Notifications',
    'reports' => 'Reports',
    'attendances' => 'Attendances',
    'maps' => 'Maps',
    'coupons' => 'Coupons',
    'messages' => 'Messages',
    'edit_profile' => 'Edit Profile',
    'user_settings' => 'User Settings',
    'all_rights_reserved' => 'All rights reserved.',
	'log_out'   => 'Log Out',
    'withdrawl_operatons_today' => 'Withdrawl Operations Today',
    'pos_revenue_operations_today' => 'POS Revenue Operations Today ',
    'today_deposit_operations' => 'today_deposit_operations',
    
	// attendances.blade
    'no' => 'No',
    'name' => 'Name',
    'phone' => 'Phone',
    'login_time' => 'Login Time',
    'logout_time' => 'Logout Time',
    'serach' => 'Serach',
    
	// depppsit.blade
	'type'   => 'Type',
	'amount' => 'Amount',
	'notes' => 'Notes',
	'attachment' => 'Attachment',
	'date' => 'Date',
	'approve' => 'Approve',
	'approved' => 'Approved',
	'not_approved' => 'Not Approved',
	
	//feeds management
	'fees_operation'   => 'Fees Operation',
	'select'   => 'Select',
	'percentage'   => 'Percentage',
	'fixed_sar'   => 'Fixed(SAR)',
	'no_en'   => 'No',
	'all'   => 'All',
	'seller'   => 'Seller',
	'user'   => 'User',
	'subscription_fees'   => 'Subscription Fees',
	'depo_no'   => 'No. Depo',
	'type_depo'   => 'Type Depo',
	'amount_depo'   => 'Amount Depo',
	'deposite_date'   => 'Date Depo',
	'view_all'   => 'View All',
	
	// home blade
	'withdrawls_today'   => 'Withdrawls Today',
	'balance'   => 'Balance',
	'deposit_today'   => 'Deposit Today',
	'email'   => 'Email',
	'statement_account'   => 'Statement Account',
	'status'   => 'Status',
	'email_approve'   => 'Email Approve',
	'phone_approve'   => 'Phone Approve',
	'last_login'   => 'Last Login',
	'reg_date'   => 'Reg Date',
	
	//map.blade
	'fuel_station_name'   => 'Fuel Station Name',
	'fuel_type'   => 'Fuel Type',
	'green_fuel'   => 'Green Fuel91',
	'red_fuel'   => 'Red Fuel95',
	'diesel'   => 'Diesel',
	'wash'   => 'Wash',
	'state'   => 'State',
	'all_states'   => 'All States',
	'all_countries'   => 'All Countries',
	'apply'   => 'Apply',
	
	// message 
	'message'   => 'Message',
	'type_message'   => 'Type Message',
	'date_created'   => 'Date Created',
	'technical'   => 'Technical',
	'deposit'   => 'Deposit',
	'withrwal'   => 'Withrwal',
	'solved'   => 'Solved',
	'not_solved'   => 'Not Solved',
	
	//new employee
	'first_name'   => 'First Name',
	'last_name'   => 'Last Name',
	'choose_state'   => 'Choose State',
	'country'   => 'Country',
	'choose_country'   => 'Choose Country',
	'role'   => 'Role',
	'manager_users'   => 'Manager Users',
	'manager_paymentmethods'   => 'Manager Paymentmethods',
	'manager_fees'   => 'Manager Fees',
	'manager_operation_deposit'   => 'Manager Operaton Deposit',
	'manager_operations'   => 'Manager Operatons',
	'withdrawls'   => 'Withdrawls',
	'manager_notifications'   => 'Mnager Notifications',
	'new_password'   => 'New Password',
	'confirm_password'   => 'Confirm Password',
	 
	 // notificatoin
	'solved'   => 'Solved', 
	'user_name'   => 'User Name', 
	'all_notification'   => 'All Notification', 
	'maximum_foramount'   => 'Maximum Foramount ', 
	'maximum_washes'   => 'Maximum Washes', 
	'maximum_oil_changes'   => 'Maximum Oil Changes', 
	'maximum_times_day'   => 'Maximum Times (DAY)', 
	'yes'   => 'Yes', 
	'sms'   => 'SMS', 
	
	// payment manager
	'activated'   => 'Activated', 
	'deactivated'   => 'Deactivated', 
	'admin'   => 'Admin', 
	'statement'   => 'Statement', 
	'search'   => 'Search', 
	'add_new_employee'   => 'Add New Employee', 
	// user setting
	'picture'   => 'Picture', 
	// userstatement
	'no_operation'   => 'No. Opearation', 
	'type_operation'   => 'Type Opearation', 
	'amount_operation'   => 'Amount Opearation', 
	'date_operation'   => 'Date Opearation', 
	'operatoin_details'   => 'Opearation Details', 
	'fuelstation_info'   => 'Fuelstation Info', 
	'vehicle_info'   => 'Vehicle Info', 
	'operation_date'   => 'Opearation Date', 
	'seller_name'   => 'Seller Name', 
	'request_amount'   => 'Request Amount', 
	'withdrawl_amount'   => 'Withdrawl Amount', 
	'notes'   => 'Notes', 
	'period'   => 'Period', 
	
	'bank'   => 'Bank', 
	'master_card'   => 'Master Card', 
	'visa'   => 'VISA', 
	'sdad'   => 'SDAD', 
	
	///////////////////////////////////////////////////////////seller dashboard /////////////////////////////////////////////////////////
	//admin
	'manager_fuel_station'   => 'Manager Fule Station', 
	'contact_us'   => 'Contact Us', 
	// home
	'top_fuel_station_revenue'   => 'Top fuelstations revenue', 
	'revenue_amount'  			 => 'Revenue Amount', 
	'operation_revenue_today'    => 'Operation Revenue Today', 
     // contact ud
    'choose_complaint'  => 'Choose Complaint',
    'deposit_operation'  => 'Deposit Operation',
    'withdrawal_operation'  => 'Withdrawal Operation',
    'techical_support'  => 'Technical Support',
    'send'  => 'Send',
    
	// coupons
	'add_new_coupon'  =>'Add New Coupon',
	'code'  =>'Code',
	'fixed'  =>'Fixed',
	'there_is_no_results'  =>'There is no results.',
	'start_date'  =>'Start Date',
	'end_date'  =>'End Date',
	'cancel'  =>'Cancel',
	
	
	
	
	//fuelstatoin  new.blade.
	'service_type'  =>'Services Type',
	'fuel'  =>'Fuel',
	'wash'  =>'Wash',
	'oil'  =>'Oil',
	
	// fuel stattion index
	'add_fuelstation' => 'Add FuelStation',
	'position'   => 'Position',
	'pos_status' => 'Pos Status',
	'action'     => 'Action',
	'working'     => 'Working',
	'not_working'     => 'Not working',
	'edit'     => 'Edit',
	'delete'     => 'Delete',
	
    
	///////////////////////////////////////////////////////////user dashboard /////////////////////////////////////////////////////////
	'vehicles_amount'   => 'Vehicles Amount',
	'latest_user'   => 'Latest User',
	
	 // invite
	'get_now_10_sar_as_fee_balance'     => 'Get Now 10 SAR As Free Balance',
	'when_your_selfstation_and_do_his_first_fillup_you_get_sar'     => 'When Your Friend register at Selfstation and do his first fill up, you will get 10 SAR.',
	'invitation_link'     => 'Invitation Link',
	'copylink'     => 'copylink',
	'email_send_to'     => 'Email Send To',
	'send_by_sms'     => 'Send by SMS',
	
	
	//deposit
	'visa_master_card' => 'Visa / Master Card',
	'transfer_bank' => 'Transfer Bank',
	'already_added_card' => 'Already Added Card',
	'bank_name' => 'Bank Name',
	'time' => 'Time',
	'card_no' => 'Card No.',
	'expire_date' => 'Expire Date.',
	'holder_name' => 'Holder Name',
	'issued_country' => 'Issued Country',
	'postal_code' => 'Postal Code',
	'choose_card' => 'Choose Card',
	'apply_filter' => 'Apply Filter',
	'add_logo' => 'Add Logo',
	'add_vehicle' => 'Add Vehicle',
	
	//vehhicle
	'model' => 'Model',
	'city' => 'City',
	'sar' => 'SAR',
	'balance_add' => 'Balance Add',
	'vehicle' => 'Vehicle',
	'monthly_expense' => 'Monthly Expense',
	'latest_added_vehicles' => 'Latest Added Vehicles',
	// home
	'free_feeling_up' => 'Free Filling up',
	'deposit_request' => 'Deposit Request',
	'withdraw_request' => 'Withdraw Request',
	'manager_operation' => 'Manager Operation',
	'manager_vehicle' => 'Manager Vehicle',
	
	
	/******************************************************************  frontend *****************************************/
	'selfstation' => 'Selfstation',
	'selfstation_show_message' => 'Udah dari dulu tahu kalo selfstation kenapa nggak ditambal tong',
	'learn_more' => 'Learn more',
	'about_company' => 'About Company',
	'about_company_mess1' => 'Lorem ipsum dolor sit amet, vis tale malis tacimates et, graece doctus omnesque ne est, deserunt pertinacia ne nam. Pro eu simul affert referrentur, natum mutat erroribus te his',
	'about_company_mess2' => 'Lorem ipsum dolor sit amet, vis tale malis tacimates et, graece doctus omnesque ne est, deserunt pertinacia ne nam. Pro eu simul affert referrentur, natum mutat erroribus te his',
	'what_we_do' => 'What we do',
	
	//our services
	'our_services' => 'Our services',
	'electroinic_payment' => 'Electronic Payment',
	'our_services_mess1' => 'Lorem ipsum dolor sit amet, vis tale malis tacimates et, graece doctus omnesque ne est, deserunt pertinacia ne nam. Pro eu simul affert referrentur, natum mutat erroribus te his',
	'our_services_mess2' => 'Lorem ipsum dolor sit amet, vis tale malis tacimates et, graece doctus omnesque ne est, deserunt pertinacia ne nam. Pro eu simul affert referrentur, natum mutat erroribus te his',
	
	'use_our_services' => 'Use Our Services',
	'you_can_get_our_services_easy_steps' => 'You can get our services in 5 easy steps.',
	'add_valance' => 'Add Valance',
	'pay_to_fuelstation' => 'Pay to Fuelstations',
	'through_barcode' => 'Throuh a barcode',
	'payment_will_transfer_directly_to_seller_account' => 'Payment will transfer directly to seller account',
	'get_in_touch_with_us' => 'Get in touch with us',
	'your_message_has_been_sent' => 'Your message has been sent. Thank you!',
	'your_name' => 'Your Name',
	'please_enter_atleast_4_chars' => 'Please enter at least 4 chars',
	'your_email' => 'Your Email',
	'send_message' => 'Send Message',
	'address' => 'Address',
	'street' => 'Street',
	'saudi_arabia' => 'Saudin Arabia',
	'contacts' => 'Contacts',
	'mobile' => 'Mobile',
	'Telex' => 'telex',
	'copyright' => 'Copyright',
	'signup_login' => 'SignUP/LogIn',
	'services' => 'Services',
	'terms_and_conditions' => 'Terms and Conditions',
	 
	/////////////////////////////////////////// add more  ///////////////////////////////////////////////////
	'phone_number'  => 'Phone Number',
	'request_sent_success' =>  'Request is sent successfully.',
	'add_operation_withdrawl_for_user'  => 'Add Operation Withdrawal for User',
	'withdrawl_time_limit_setting'  => 'Withdrawl Time Limit Setting',
	'print_qr'  => 'Print QR code',
	'deleted'  => 'Deleted',
	'limit_operation_not'  => 'Operation of reaching limits',
	'notification'  => 'Notification',
	'notification_stop'  => 'Notification Stop',
	'advanced_search'  => 'Advanced Search',
	'operation_amount'  => 'Operation  Amount',
	'from'  => 'From',
	'to'  => 'To',
	'fuelstation_name'  => 'FuelStation Name',
	'operation_no'  => 'Operation No',
	'operation_type'  => 'Operation Type',
	'employeers'  => 'Employeers',
	'add_pos_user'  => 'Add POS user',
	'fuelstation'  => 'Fuelstation',
	'choose_service'  => 'Choose Service Type',
	'choose_fuelstation'  => 'Choose FuelStation',
	
	'help'  => 'help',
	'pos_revenue'  => 'POS revenue',
	'pos_payment'  => 'POS payment',
	'withdrawl'  => 'Withdrawal',
    'date_opration'  => 'Date Operation',
    'return'  => 'return',
    'vehicle_name'  => 'Vehicle Name',
     
     // admin 
    'fees_type' => 'Fees Type',
    'operation' => 'Operation',
	'subscription' => 'Subscription',
	'operation_fee' => 'Operation Fee',
	'subscripton_fee' => 'Subscription Fee',
	
	// login_time
	'verify'  =>  'Verify',
	'wrongsms' => 'Wrong Verification Code',

	// qrcode
	'qrcode' => 'QR code',

	//export
	'export_to_excel'=> 'Expert to Excel',

	// fee management
	'free_if_exceed' => 'Free if exceed #cars',
	'add_new' => 'Add New',
];
