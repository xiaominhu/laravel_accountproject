<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>  {{trans('app.selfstation')}}  </title>
    <!-- css -->
	@if(App::getLocale() == "sa")
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap-rtl.css') }}">
	@else
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/bootstrap.min.css') }}">
	@endif
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/nivo-lightbox.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/nivo-lightbox-theme/default/default.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/animations.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('color/default.css') }}">
	
    <!-- =======================================================
        Theme Name: Bocor
        Theme URL: https://bootstrapmade.com/bocor-bootstrap-template-nice-animation/
        Author: BootstrapMade
        Author URL: https://bootstrapmade.com
    ======================================================= -->

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-custom" class = "{{App::getLocale()}}">
	
	<section class="topheader" id="intro">
		<div class="container">
		 
			<div class = "row marginbot-20">
				<div class = "col-xs-8 col-md-6 singuppart text-center">
					<a type = "text" class = "btn btn-warning" href = "{{URL::to('/login')}}">    {{trans('app.signup_login')}} </a>
				</div>
				<div class = "col-xs-4 col-md-4">
					<img src = "{{URL::asset('img/logo.png')}}" height = "100"/>
				</div>
			</div>
			
			<div class = "row">
				<div class="dropdown pull-right ">
				
					<a id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="dropdown-toggle">
						@if(App::getLocale() == "sa")
							<!-- i class="flag-icon flag-icon-sa"></i -->
							<span class="selected-language">العربية</span>
						@else
							<!-- i class="flag-icon flag-icon-gb"></i -->
							<span class="selected-language">English</span>
						@endif
						
					</a>
					<ul aria-labelledby="dropdown-flag" class="dropdown-menu">
						<li><a href="#" class="dropdown-item language" data-lang="en"><!-- i class="flag-icon flag-icon-gb"></i --> English</a></li>
						<li><a href="#" class="dropdown-item language" data-lang="sa"><!-- i class="flag-icon flag-icon-sa"></i --> العربية </a></li>
					</ul>
				</div> 
			</div>
		</div>
    </section>
	
	
	<!-- Navigation -->
    <div id="navigation">
        <nav class="navbar navbar-custom" role="navigation">
			<div class="container">
				<div class="row">
					<div class="col-md-2">
						   <div class="site-logo">
									<a href="{{Url::to('/')}}" class="brand"> {{trans('app.selfstation')}} </a>
							</div>
					</div>
					  

					<div class="col-md-10">
	 
								  <!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#menu">
							<i class="fa fa-bars"></i>
							</button>
					</div>
								  <!-- Collect the nav links, forms, and other content for toggling -->
								  <div class="collapse navbar-collapse" id="menu">
										<ul class="nav navbar-nav navbar-right">
										<?php
											if(Request::url() !=  URL::to('/'))
												$url_home = URL::to('/') . '/';
											else
												$url_home = "";
										?>
												<li class="active"><a href="{{$url_home}}#intro"> {{trans('app.main_page')}}</a></li>
												<li><a href="{{$url_home}}#about">    {{trans('app.about_company')}} </a></li>
												<li><a href="{{$url_home}}#service">   {{trans('app.services')}}   </a></li>
											<li><a href="{{URL::to('/terms-and-conditions')}}">  {{trans('app.terms_and_conditions')}}  </a></li>	
											
											<li><a href="{{URL::to('/help')}}">  {{trans('app.help')}}  </a></li>	
											<li><a href="{{$url_home}}#contact"> {{trans('app.contact_us')}} </a></li>

											<li><a href="{{URL::to('/seller/login')}}"> {{trans('app.signup_login_seller')}} </a></li>

										</ul>
								  </div>
								  <!-- /.Navbar-collapse -->
		 
					  </div>
				</div>
		
			</div>
			<!-- /.container -->
        </nav>
    </div> 
    <!-- /Navigation -->  
	
	@yield('frontendcontent')
	
	<footer>
		<div class="container">
			<div class="row">
				 
				<div class = "col-md-6">
					<div class = "col-xs-4">
						<img src = "{{URL::asset('img/playstore_img.png')}}">
					</div>
					<div class = "col-xs-4">
						<img src = "{{URL::asset('img/appstore_img.png')}}">
					</div>
				</div>

				<div class="col-md-6 text-right copyright">
					&copy; {{trans('app.copyright')}}  -  {{trans('app.selfstation')}}. {{trans('app.all_rights_reserved')}} 
					<div class="credits">
					</div>
				</div>

			</div>	

			 
			
		</div>
	</footer>

    <!-- Core JavaScript Files -->
	<script src="{{  URL::asset('js/frontend/jquery.min.js') }}" type="text/javascript"></script>
	<script src="{{  URL::asset('js/frontend/bootstrap.min.js') }}" type="text/javascript"></script>
	<script src="{{  URL::asset('js/frontend/jquery.sticky.js') }}" type="text/javascript"></script>
	<script src="{{  URL::asset('js/frontend/jquery.easing.min.js') }}" type="text/javascript"></script>
	<script src="{{  URL::asset('js/frontend/jquery.scrollTo.js') }}" type="text/javascript"></script>
	<script src="{{  URL::asset('js/frontend/jquery.appear.js') }}" type="text/javascript"></script>
	<script src="{{  URL::asset('js/frontend/stellar.js') }}" type="text/javascript"></script>
	<script src="{{  URL::asset('js/frontend/nivo-lightbox.min.js') }}" type="text/javascript"></script>
	<script src="{{  URL::asset('js/frontend/custom.js') }}" type="text/javascript"></script>
	<script src="{{  URL::asset('js/frontend/css3-animate-it.js') }}" type="text/javascript"></script>
	
	<script>
		$.ajaxSetup({
			data: {
				'_token': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
    <script type="text/javascript" src="{{  URL::asset('js/usercustom.js') }}"></script>
</body>

</html>

