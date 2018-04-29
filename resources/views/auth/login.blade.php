

<html lang="en"><!--<![endif]--><!-- BEGIN HEAD --><head>
        <meta charset="utf-8">
        <title> {{trans('app.self_station_login')}}  </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport">
        <meta content="Login for WaZaPAY" name="description">
        <meta content="" name="author">
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css">
		<link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ URL::asset('assets/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css">
		
		@if(App::getLocale() == "sa")
			<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css-rtl/bootstrap.css') }}">
		@else
			<link href="{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
		@endif
		
		
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
		<link href="{{ URL::asset('assets/select2/select2.min.css') }}" rel="stylesheet" type="text/css">
		<link href="{{ URL::asset('assets/select2/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="assets/css/components.min.css" rel="stylesheet" id="style_components" type="text/css">
		<link href="{{ URL::asset('assets/components.min.css') }}" rel="stylesheet" type="text/css">
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
		<link href="{{ URL::asset('assets/login.min.css') }}" rel="stylesheet" type="text/css">
        <link href="assets/css/custom.css" rel="stylesheet" type="text/css">
		<link href="{{ URL::asset('assets/custom.css') }}" rel="stylesheet" type="text/css">
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->

		<link href="{{ URL::asset('app-assets/build/css/intlTelInput.css') }}" rel="stylesheet" type="text/css">

        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico"> </head>

		<?php
			if(Auth::check()) {
		?>
			<script> 
				window.location.href = '{{Url::to("/seller/home")}}'; //using a named route
			</script>
		<?php
			}
		?>

    <!-- END HEAD -->
	@if(App::getLocale() == "sa")
		<body class="sa login" style="background-image: url('/frontend/assets/img/bg.jpg'); background-size: cover; background-position: 50% 50%;background-attachment: fixed;">
	@else
		 <body class=" login" style="background-image: url('/frontend/assets/img/bg.jpg'); background-size: cover; background-position: 50% 50%;background-attachment: fixed;">
    @endif
	 
		<div class = "overlay">

		</div>


        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="{{Url::to('/')}}"> <img src="{{URL::asset('/images/logo.png')}}"  height = "100" alt=""> </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
			@if(strpos(Request::url(), '/seller/login') !== false) 
            	<form class="login-form" action="{{route('login')}}?seller" method="post" novalidate="novalidate">
		    @else
				<form class="login-form" action="{{route('login')}}" method="post" novalidate="novalidate">
			@endif

				{{ csrf_field() }}
					 
				@if(Session::has('signup')) 
					<div class="alert alert-success fade in">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						<strong>  {{trans('app.signup_success_message')}} </strong> 
					</div>
				@endif

				

				@if (session('status')) 
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

				@if (session('emailverifysuccess')) 
					<div class="alert alert-success">
						<strong>  {{trans('success')}} </strong> 
					</div>
				@endif


				<input type = "hidden" name = "usertype" value = "<?php
					$currentURL = URL::current();
					if (strpos($currentURL, 'seller') !== false) 
						echo 'seller';
					else
						echo 'user';
				?>">
            <!--Please check the login action tap-->
                <h3 class="form-title font-green">{{trans('app.sign_in')}} </h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> {{trans('app.enter_phonenumber_and_password')}}  </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">  {{trans('app.email_mobile_no')}}   </label>
                    <input class="form-control form-control-solid placeholder-no-fix" autocomplete="off" placeholder="{{trans('app.email_mobile_no')}}" name="email" type="text" value="<?php 
                    	if(Session::has('email'))
                    		echo Session::get('email');
                     ?>">
					   @if ($errors->has('email'))
					   		@if(!Session::has('login'))
								<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							 @endif
							 @if(Session::has('wrongsms'))
								<span class="help-block">
									<strong>{{trans('app.wrongsms')}}</strong>
								</span>
							 @endif
						@endif
				</div>
					
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9"> {{trans('app.password')}} </label>
                    <input id = "password_login" class="form-control form-control-solid placeholder-no-fix" autocomplete="off" placeholder=" {{trans('app.password')}}" name="password" type="password" value="<?php 
                    	if(Session::has('password'))
                    		echo Session::get('password');
                     ?>">
					
					<a href="javascript:;" id="show-password" class="forget-password"> {{trans('app.show_password')}} </a>
					@if ($errors->has('password'))
						 @if(!Session::has('login'))
							<span class="help-block">
								<strong>{{ $errors->first('password')}}</strong>
							</span> 
						 @endif
					@endif
				</div>
					
				<div class="form-group">
                    <input id = "verficode" autocomplete="off" name="verficode" type="hidden">
                    <input id = "requestid" autocomplete="off" name="requestid" type="hidden" value="<?php  
                    		if(Session::has('request_id'))
								echo Session::get('request_id'); 
                    ?>">
				</div>
					
                <div class="form-actions">
					<div class = "col-md-12">
						<button type="submit" class="btn btn-green uppercase col-md-12"> {{trans('app.sign_in')}} </button>
					</div>
					
						<label class="rememberme check mt-checkbox mt-checkbox-outline">
							<input name="remember" value="1" type="checkbox">  {{trans('app.remember')}}
							<span></span>
						</label>
						
						<a href="javascript:;" id="forget-password" class="forget-password"> {{trans('app.forgot_password')}} </a>
					
                </div>
              
			    @if(!Session::has('seller'))
					<div class="create-account">
						<p>
							<a href="javascript:;" id="register-btn" class="uppercase">  {{trans('app.create_a_client_account')}}  </a>
						</p>
					</div>
				@else
					<div class="create-account">
						<p>
							<a href="#" id="register-vendor-btn" class="uppercase">{{trans('app.create_a_seller_account')}} </a>
						</p>
					</div>
				@endif
            </form>
            <!-- END LOGIN FORM -->
 
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form" action="{{ URL::to('password/email')}}" method="post" novalidate="novalidate">
				 {{csrf_field()}}
                <h3 class="font-green"> {{trans('app.forgot_password')}} </h3>
                <p>  {{trans('app.enter_youremail_address_to_reset')}}  </p>
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" autocomplete="off" placeholder="Email" name="email" type="text"> 
				</div>
				 	 
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn btn-default btn-outline">   {{trans('app.back')}}  </button>
                    <button type="submit" class="btn btn-green uppercase pull-right"> {{trans('app.submit')}}  </button>
                </div>
            </form>
            <!-- END FORGOT PASSWORD FORM -->
			@if(!Session::has('seller'))
            <!-- BEGIN REGISTRATION FORM - CLIENTS -->
            <form class="register-form" action="{{ route('register') }}" method="post" novalidate="novalidate">
				
				{{ csrf_field() }}
				 <input type="hidden" name="invite" value="<?php 
				 	if(isset($_GET['invite']))
				 		echo $_GET['invite'];
				 	else
				 		echo 'never';
				  ?>">
				 
                <h3 class="font-green">{{trans('app.sign_up')}} </h3>
                <p class="hint"> {{trans('app.enter_your_personal_details')}}:  </p>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9"> {{trans('app.full_name')}}   </label>
                    <input class="form-control placeholder-no-fix" placeholder="{{trans('app.full_name')}}" name="name" type="text"  value = "<?php
							if(Session::has('name_user')){
								echo Session::get('name_user');
							}
					 ?>"> 
					
					
					 @if ($errors->has('name'))
					 	 @if(Session::has('user'))
							<span class="help-block">
								<strong>{{ $errors->first('name')}}</strong>
							</span>
						 @endif
                     @endif
				</div>
				
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9"> {{trans('app.email')}}</label>
                    <input class="form-control placeholder-no-fix" placeholder=" {{trans('app.email')}}" name="email" type="text" value = "<?php
							if(Session::has('name_email')){
								echo Session::get('name_email');
							}
					 ?>">
					
					 @if ($errors->has('email'))
					 	 @if(Session::has('user'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						 @endif
					 @endif
					 
				</div>
				
				<input type = "hidden" name = "usertyper" value = "0">
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">  {{trans('app.phone_number')}}</label>
                    
					<div class="intl-tel-input allow-dropdown">
							<div class="flag-container">
								<div class="selected-flag" tabindex="0">
									<div class="iti-flag sa"> </div> 
									<div class="iti-arrow1">(+966)</div>
								</div>
							</div>


								<input id="userphone"  class="form-control placeholder-no-fix"  name = "phone"   placeholder="{{trans('app.phone_number')}}" type="tel" autocomplete="off" value = "<?php
								
									if(Session::has('name_phone')){
										echo Session::get('name_phone');
									}
					?>">
						</div>

					
					 @if ($errors->has('phone'))
					 	 @if(Session::has('user'))
						<span class="help-block">
							<strong>{{ $errors->first('phone') }}</strong>
						</span>
						 @endif
					 @endif
					 
				</div>
					
					
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">  {{trans('app.password')}} </label>
                    <input class="form-control placeholder-no-fix" placeholder=" {{trans('app.password')}}" name="password" type="password"> 
					
					 @if ($errors->has('password'))
					 	 @if(Session::has('user'))
						 <span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						 </span>
						 @endif
					 @endif
					 
				</div>
				
				<div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">  {{trans('app.confirm_password')}}</label>
                    <input class="form-control placeholder-no-fix" placeholder="{{trans('app.confirm_password')}}" name="password_confirmation" type="password">
				</div>
				
				<div class="form-group margin-top-20 margin-bottom-20">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input name="tnc" type="checkbox">  {{trans('app.i_agree_to_the')}}
						 <a href="javascript:;">  {{trans('app.terms_of_service')}}  </a> &amp;
                         <a href="javascript:;"> {{trans('app.privacy_policy')}}   </a>
						
						
                        <span></span>
                    </label>
                    <div id="register_tnc_error"> 

						 @if ($errors->has('tnc'))
							@if(Session::has('user'))
							<span class="help-block">
								<strong> {{trans('app.tnc')}} </strong>
							</span>
							@endif
						@endif
					 
					
					</div>
                </div>
                <div class="form-actions">
                    <button type="button" id="register-back-btn" class="btn btn-default"> {{trans('app.back')}} </button>
                    <button type="submit" id="register-submit-btn" class="btn btn-green uppercase pull-right">{{trans('app.submit')}} </button>
                </div>
            </form>
            <!-- END REGISTRATION FORM - CLIENTS -->
			@else
            <!-- BEGIN REGISTRATION FORM - VENDORS -->
            <form class="register-vendor-form" action="{{ route('register') }}" method="post" style="display: none;">
				 {{ csrf_field() }}
				<p class="hint font-red"> {{trans('app.register_txt')}}:  </p>
                <h3 class="font-green">  {{trans('app.sign_up')}}  </h3>
                <p class="hint">  {{trans('app.enter_your_personal_details_below')}} : </p>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">  {{trans('app.companyname_or_service')}} </label>
                    <input class="form-control placeholder-no-fix" placeholder="{{trans('app.companyname_or_service')}} " name="name" type="text" value = "<?php
							if(Session::has('name_seller')){
								echo Session::get('name_seller');
							}
					 ?>"> 
					
					 @if ($errors->has('name'))
					 	 @if(Session::has('vendor'))
                         <span class="help-block">
                              <strong>{{ $errors->first('name') }}</strong>
						 </span>
						  @endif
                     @endif
				</div>
				
				
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">  {{trans('app.business_license_number')}} </label>
                    <input class="form-control placeholder-no-fix" placeholder=" {{trans('app.business_license_number')}} " name="license" type="text" value ="<?php
							if(Session::has('license_seller')){
								echo Session::get('license_seller');
							}
					 ?>"> 
					 @if ($errors->has('license'))
					 	 @if(Session::has('vendor'))
                          <span class="help-block">
                              <strong>{{ $errors->first('license') }}</strong>
                          </span>
                           @endif
                     @endif
				</div>
				
				<div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">  {{trans('app.email')}}</label>
                    <input class="form-control placeholder-no-fix" placeholder="{{trans('app.email')}}" name="email" type="text" value = "<?php
							if(Session::has('email_seller')){
								echo Session::get('email_seller');
							}
					 ?>"> 
					 @if ($errors->has('email'))
					 	 @if(Session::has('vendor'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
						 @endif
					 @endif
				</div>
           
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9"> {{trans('app.phone_number')}}  </label>
					<div class="intl-tel-input allow-dropdown">
							<div class="flag-container">
								<div class="selected-flag" tabindex="0">
									<div class="iti-flag sa"> </div> 
									<div class="iti-arrow1">(+966)</div>
								</div>
							</div>
								<input id="sellerphone"   class="form-control placeholder-no-fix"  name = "phone" placeholder=" {{trans('app.phone_number')}} "   type="tel" autocomplete="off" value = "<?php
								 	if(Session::has('phone_seller')){
										echo Session::get('phone_seller');
									}
					?>">
						</div>
 
					 @if ($errors->has('phone'))
					 	 @if(Session::has('vendor'))
							<span class="help-block">
								<strong>{{ $errors->first('phone') }}</strong>
							</span>
							 @endif
					 @endif
					 
				</div>
				
				<div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9"> {{trans('app.password')}}</label>
                    <input class="form-control placeholder-no-fix" placeholder=" {{trans('app.password')}}" name="password" type="password"> 
					 @if ($errors->has('password'))
					 	 @if(Session::has('vendor'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
						 @endif
					 @endif
				</div>
				  
				<div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">  {{trans('app.confirm_password')}}</label>
                    <input class="form-control placeholder-no-fix" placeholder="{{trans('app.confirm_password')}}" name="password_confirmation" type="password">
				</div>
				<input type = "hidden" name = "usertyper" value = "1">
				<div class="form-group margin-top-20 margin-bottom-20">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input name="tnc" type="checkbox">  {{trans('app.i_agree_to_the')}}
                        <a href="javascript:;">  {{trans('app.terms_of_service')}}  </a> &amp;
                        <a href="javascript:;"> {{trans('app.privacy_policy')}}   </a>
                        <span></span>
                    </label>
                    <div id="register_tnc_error">
						@if ($errors->has('tnc'))
							@if(Session::has('vendor'))
							<span class="help-block">
								<strong> {{trans('app.tnc')}} </strong>
							</span>
							@endif
						@endif
					 </div>
                </div>
                <div class="form-actions">
				
						<button type="button" id="vendor-register-back-btn" class="btn btn-default">  {{trans('app.back')}} </button>
						<button type="submit" id="register-submit-btn" class="btn btn-green uppercase pull-right"> {{trans('app.submit')}}</button>
				
                   
                </div>
            </form>
            <!-- END REGISTRATION FORM - VENDORS -->
			@endif
        </div>
        <div class="copyright"> 2017 © {{trans('app.selfstation')}}  </div>
		
	 
			<!-- Modal -->
		<div id="verifymodal" class="modal fade " role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"> {{trans('app.verify_phone_number')}} </h4>
				</div>
				<div class="modal-body">
						
						<div class="form-group">
							<label class="control-label visible-ie8 visible-ie9"> {{trans('app.verification_code')}}  </label>
							<input class="form-control placeholder-no-fix" placeholder="verification code" name="verficode_modal" type="text"> 
	
							@if(Session::has('wrongsms'))
									<span class="help-block">
										<strong>{{trans('app.wrongsms')}}</strong>
									</span>
							@endif
						</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning  verifycode-button" data-dismiss="modal"> {{trans('app.verify')}}  </button>

					<button type="button" class="btn btn-default" data-dismiss="modal"> {{trans('app.close')}}  </button>
					
				</div>
				</div>

			</div>
			</div>
		 
        <!--[if lt IE 9]>
		<script src="assets/plugins/respond.min.js"></script>
		<script src="assets/plugins/excanvas.min.js"></script> 
		<script src="assets/plugins/ie8.fix.min.js"></script> 
		<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
		<script type="text/javascript" src="{{URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
		<script type="text/javascript" src="{{URL::asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{URL::asset('assets/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
		<script type="text/javascript" src="{{URL::asset('assets/jquery-validation/jquery.validate.min.js') }}"></script>
		<script type="text/javascript" src="{{URL::asset('assets/jquery-validation/additional-methods.min.js') }}"></script>
		     
		<script type="text/javascript" src="{{URL::asset('assets/select2/select2.full.min.js') }}"></script>
        <!-- END PAGE LEVEL PLUGINS -->
		<script type="text/javascript" src="{{URL::asset('app-assets/build/js/intlTelInput.js') }}"></script>


        <!-- BEGIN THEME GLOBAL SCRIPTS -->
		<script type="text/javascript" src="{{URL::asset('assets/app.min.js') }}"></script>
		<script type="text/javascript">
			var is_register = <?php  
				if(isset($_GET['invite']))
					echo '1';
				else{
					if(Session::has('user')) 
						echo '1';
					else 
						echo '0';
				}
				?>;
			var is_register_vendor = <?php 
					if(Session::has('vendor') && !Session::has('signup')) 
						echo '1';
					else 
						echo '0';
				?>;

			var verifymodal =  <?php 
				if(Session::has('sellermessage')) 
					echo '1';
				else 
					echo '0';
			?>;
			
			

		</script>
		<script type="text/javascript" src="{{URL::asset('assets/login.min.js') }}"></script>

		
</body>

</html>