<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Robust admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, robust admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
    <title> {{trans('app.home')}} </title>
	
    <link rel="apple-touch-icon" sizes="60x60" href="../../app-assets/images/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../../app-assets/images/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../../app-assets/images/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../../app-assets/images/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../app-assets/images/ico/favicon.ico">
    <link rel="shortcut icon" type="image/png" href="../../app-assets/images/ico/favicon-32.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
	
	<?php
		$suffix = "";
		if(App::getLocale() == "sa")
			$suffix = "-rtl";
	?>
		
	@if(App::getLocale() == "sa")
	    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css-rtl/bootstrap.css') }}">
	@else
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/bootstrap.css') }}">
	@endif
	
	
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/fonts/icomoon.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/fonts/flag-icon-css/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{URL::asset('app-assets/vendors/css/extensions/pace.css')}}">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
	@if(App::getLocale() == "sa")
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css-rtl/bootstrap-extended.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css-rtl/app.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css-rtl/colors.css') }}">
		
		 <!-- BEGIN Page Level CSS-->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css-rtl/core/menu/menu-types/vertical-overlay-menu.css')}}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css-rtl/core/colors/palette-gradient.css')}}">
    <!-- END Page Level CSS-->
	
	
    @else
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/bootstrap-extended.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/app.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/colors.css') }}">
		
		    <!-- BEGIN Page Level CSS-->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/menu/menu-types/vertical-overlay-menu.css')}}">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('app-assets/css/core/colors/palette-gradient.css')}}">
	
	@endif
	
	
    <!-- END ROBUST CSS-->
   
	
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-multiselect.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-datetimepicker.min.css') }}">
	@if(App::getLocale() == "sa")
		 <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style-rtl.css')}}">
	@else
    <!-- BEGIN Custom CSS-->
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/style.css')}}">
    <!-- END Custom CSS-->
	@endif
  </head>
  
  
  <script>	
		var employee_role   = 0;
		var map_search 		= 0;
		var coupon_create   = 0;
		var withdrawmanagement   = 0;
		var reports   = 0;
  </script>
  
  <body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns  fixed-navbar">

    <!-- navbar-fixed-top-->
    <nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
      <div class="navbar-wrapper">
        <div class="navbar-header">
		
          <ul class="nav navbar-nav">
            <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a></li>
            <li class="nav-item"><a href="{{Url::to('/')}}" class="navbar-brand nav-link"><img alt="branding logo" src="{{URL::asset('app-assets/images/logo/robust-logo-light.png')}}" data-expand="{{URL::asset('app-assets/images/logo/robust-logo-light.png')}}" data-collapse="{{URL::asset('app-assets/images/logo/robust-logo-small.png')}}" class="brand-logo"></a></li>
            <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
          </ul>
		  
        </div>
        <div class="navbar-container content container-fluid">
          <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
            <ul class="nav navbar-nav">
              <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5">         </i></a></li>
              <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-link-expand"><i class="ficon icon-expand2"></i></a></li>
             
            </ul>
            <ul class="nav navbar-nav float-xs-right">
              
			@if(App::getLocale() == "sa")
				 <li class="dropdown dropdown-language nav-item"><a id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link"><i class="flag-icon flag-icon-sa"></i><span class="selected-language">العربية</span></a>
			@else
				<li class="dropdown dropdown-language nav-item"><a id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link"><i class="flag-icon flag-icon-gb"></i><span class="selected-language">English</span></a>
			@endif
			 
			  
			  
                <div aria-labelledby="dropdown-flag" class="dropdown-menu">
					<a href="#" class="dropdown-item language" data-lang = "en"><i class="flag-icon flag-icon-gb"></i> English</a>
					<a href="#" class="dropdown-item language" data-lang = "sa"><i class="flag-icon flag-icon-sa"></i> العربية </a>
                </li>
			  
			  
			 <li class="dropdown dropdown-user nav-item">
			 
				 <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
				 
				 
				 <span class="avatar avatar-online">
					@if(Auth::user()->picture)
						<img src = "/images/userprofile/{{Auth::user()->picture}}" height = "200"> 
					@else
						<img src = "/images/default-user.png" height = "200"> 
					@endif
						<i></i>
					</span>
				 
				 <span class="user-name"> 
						@if(Auth::user()->first_name)
							{{Auth::user()->first_name}}   {{Auth::user()->last_name}} 
						@else
							{{Auth::user()->name}}
						@endif 
				</span>
				 </a>
			 
			 
                <div class="dropdown-menu dropdown-menu-right">
					<a href="{{route('adminusersettings')}}" class="dropdown-item">
						<i class="icon-head"></i>  {{trans('app.edit_profile')}} 
					</a>
					
					<a href="{{route('messages')}}" class="dropdown-item"><i class="icon-mail6"></i> {{trans('app.messages')}} </a>
					
					<div class="dropdown-divider"></div>
				 
				  
					<a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item"><i class="icon-power3"></i> {{trans('app.log_out')}} </a>
					    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
						</form>
				  
                </div>
              </li>
			  
		 </div>
        </div>
      </div>
    </nav>

    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <!-- main menu-->
    <div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow">
      <!-- main menu header-->
      <div class="main-menu-header">
        <input type="text" placeholder="Search" class="menu-search form-control round"/>
      </div>
      <!-- / main menu header-->
      <!-- main menu content-->
      <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
          
		  
		 <li class=" nav-item"><a href="{{URL::to('/home')}}"><i class="icon-home3"></i><span data-i18n="nav.dash.main" class="menu-title"> {{trans('app.main_page')}} </span></a></li>
		  
		
		 <li class=" nav-item"><a href="{{URL::to('/admin/users')}}"><i class="icon-users3"></i><span data-i18n="nav.dash.main" class="menu-title"> {{trans('app.user_management')}} </span></a></li>
		  
		 <li class=" nav-item"><a href="{{route('paymentmanager')}}"><i class="icon-money"></i><span data-i18n="nav.dash.main" class="menu-title"> {{trans('app.payment_manager_methods')}} </span></a></li>
		  
		 <li class=" nav-item"><a href="{{route('feedsmanagement')}}"><i class="icon-paper"></i><span data-i18n="nav.dash.main" class="menu-title">{{trans('app.feeds_management')}} </span></a></li>
		 
		 <li class=" nav-item"><a href="{{route('depositmanagement')}}"><i class="icon-compass3"></i><span data-i18n="nav.dash.main" class="menu-title"> {{trans('app.operation_manager_deposit')}} </span></a></li>
		 
		 <li class=" nav-item"><a href="{{route('withdrawmanagement')}}"><i class="icon-compass3"></i><span data-i18n="nav.dash.main" class="menu-title"> {{trans('app.operation_manager_withdrawl')}}  </span></a></li>
		 
		 <li class=" nav-item"><a href="{{route('adminnotification')}}"><i class="icon-envelope"></i><span data-i18n="nav.dash.main" class="menu-title">{{trans('app.manager_notifications')}} </span></a></li>
		 
		 <li class=" nav-item"><a href="{{route('adminreport')}}"><i class="icon-book2"></i><span data-i18n="nav.dash.main" class="menu-title"> {{trans('app.reports')}} </span></a></li>
		
		 <li class=" nav-item"><a href="{{route('attendances')}}"><i class="icon-pencil3"></i><span data-i18n="nav.dash.main" class="menu-title"> {{trans('app.attendances')}} </span></a></li>
		
		 <li class=" nav-item"><a href="{{route('adminmap')}}"><i class="icon-map22"></i><span data-i18n="nav.dash.main" class="menu-title"> {{trans('app.maps')}}  </span></a></li>
		
		 <li class=" nav-item"><a href="{{route('couponsmanagement')}}"><i class="icon-eye6"></i><span data-i18n="nav.dash.main" class="menu-title"> {{trans('app.coupons')}} </span></a></li>
		
		 <li class=" nav-item"><a href="{{route('messages')}}"><i class="icon-paper-plane-o"></i><span data-i18n="nav.dash.main" class="menu-title"> {{trans('app.messages')}} </span></a></li>
		
	 	 <li class=" nav-item"><a href="{{route('adminusersettings')}}"><i class="icon-user4"></i><span data-i18n="nav.dash.main" class="menu-title"> {{trans('app.user_settings')}} </span></a></li>
		 
        </ul>
      </div>
      <!-- /main menu content-->
      <!-- main menu footer-->
      <!-- include includes/menu-footer-->
      <!-- main menu footer-->
    </div>
    <!-- / main menu-->

    <div class="app-content content container-fluid">
      <div class="content-wrapper">
		
		 @yield('admincontent')
	  
	  </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->


    <footer class="footer footer-static footer-light navbar-border">
     
    </footer>

    <!-- BEGIN VENDOR JS-->
    <script src="{{  URL::asset('app-assets/js/core/libraries/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{  URL::asset('app-assets/vendors/js/ui/tether.min.js') }}" type="text/javascript"></script>
    <script src="{{  URL::asset('app-assets/js/core/libraries/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{  URL::asset('app-assets/vendors/js/ui/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{  URL::asset('app-assets/vendors/js/ui/unison.min.js') }}" type="text/javascript"></script>
    <script src="{{  URL::asset('app-assets/vendors/js/ui/blockUI.min.js') }}" type="text/javascript"></script>
    <script src="{{  URL::asset('app-assets/vendors/js/ui/jquery.matchHeight-min.js') }}" type="text/javascript"></script>
    <script src="{{  URL::asset('app-assets/vendors/js/ui/screenfull.min.js') }}" type="text/javascript"></script>
    <script src="{{  URL::asset('app-assets/vendors/js/extensions/pace.min.js') }}" type="text/javascript"></script>
	
	 <script src="{{  URL::asset('js/bootstrap-multiselect.js') }}" type="text/javascript"></script>
	 <script src="{{  URL::asset('js/moment/moment.min.js') }}" type="text/javascript"></script>
     <script src="{{  URL::asset('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	
    <!-- BEGIN VENDOR JS-->
    <!-- BEGIN PAGE VENDOR JS-->
   
    <!-- END PAGE VENDOR JS-->
    <!-- BEGIN ROBUST JS-->
    <script src="{{  URL::asset('app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
    <script src="{{  URL::asset('app-assets/js/core/app.js') }}" type="text/javascript"></script>
    <!-- END ROBUST JS-->
    <!-- BEGIN PAGE LEVEL JS-->
   
      <script>
			$.ajaxSetup({
				data: {
					'_token': $('meta[name="csrf-token"]').attr('content')
				}
			});
		
			$(document).ready(function() {
				if(employee_role){//fuel_selection
					$('#createemployee_role').multiselect('select', []);
				}
				
				if(map_search){
					$('#fuelstation_fuel').multiselect('select', fuel_selection);
				}
				
				if(coupon_create)
					$('#limit_date').datetimepicker({
						defaultDate: default_sart
					});
					
				if(withdrawmanagement){
					$('#limit_to').datetimepicker({
						format: 'HH:mm',
                        				 
					});
				}

				if(reports){
					$('#from_date').datetimepicker({
						  format: 'YYYY-MM-DD',
						defaultDate: default_from
					});
					$('#to_date').datetimepicker({
						  format: 'YYYY-MM-DD',
						  useCurrent: false, //Important! See issue #1075
						  defaultDate: default_to
					});
					$("#from_date").on("dp.change", function (e) {
							$('#to_date').data("DateTimePicker").minDate(e.date);
					});
					$("#to_date").on("dp.change", function (e) {
						$('#from_date').data("DateTimePicker").maxDate(e.date);
					});
				}
			});
		</script>
	
	<script type="text/javascript" src="{{  URL::asset('js/usercustom.js') }}"></script>
    <!-- END PAGE LEVEL JS-->
  </body>
</html>
