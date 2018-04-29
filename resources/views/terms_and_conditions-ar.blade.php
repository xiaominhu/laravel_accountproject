<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Self Station | المحطة الذاتية</title>

    <link rel="icon" href="{{ URL::asset('frontend/assets/img/favicon.png')}}">
    <!-- Bootstrap CSS -->
    <link href="{{ URL::asset('frontend/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="{{ URL::asset('frontend/assets/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- Owl Carousel CSS -->
    <link href="{{ URL::asset('frontend/assets/css/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('frontend/assets/css/owl.theme.default.min.css')}}" rel="stylesheet">
    <!-- Animate CSS -->
    <link href="{{ URL::asset('frontend/assets/css/animate.css')}}" rel="stylesheet">
    <!-- AOS CSS -->
    <link href="{{ URL::asset('frontend/assets/css/aos.css')}}" rel="stylesheet">
    <!-- Lity CSS -->
    <link href="{{ URL::asset('frontend/assets/css/lity.min.css')}}" rel="stylesheet">
    <!-- Our Min CSS -->
	<link href="{{ URL::asset('frontend/assets/css/main-ar.css')}}" rel="stylesheet">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-101939576-3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-101939576-3');
    </script>

</head>

<body>
    <!-- Start Preloader -->
    <div class="preloader">
        <div class="spinner">
            <div class="cube1"></div>
            <div class="cube2"></div>
        </div>
    </div>
    <!-- End Preloader -->
    <!-- Start Header -->
    <header>
        <!-- Start Nav -->
        <nav class="navbar navbar-default appy-menu" data-spy="appy-menu">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <ul class="nav nav-login navbar-nav navbar-right">
                    <li class="active"><a class="scroll-section scroll-section1"  href="{{route('login')}}">   تسجيل العملاء / تسجيل الدخول </a></li>
                </ul>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main_menu" aria-expanded="false">
                        <span class="sr-only">القائمة</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand scroll-section" href="{{URL::to('/')}}"><img src="{{ URL::asset('frontend/assets/img/logo.png')}}" class="img-responsive logo-main" alt=""></a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="main_menu">
                    <ul class="nav navbar-nav navbar-right"> 
                        <a class="dropdown-item language" href="#" data-lang="en"> English </a>
                        <li><a class="scroll-section"  href="{{URL::to('seller/login')}}"> بروفيدر تسجيل / تسجيل الدخول </a></li>
                        <li><a class="scroll-section" href="{{URL::to('/#contact')}}">اتصل بنا</a></li>
                        <li><a class="scroll-section" href="{{URL::to('/#download')}}">تحميل</a></li>
                        <li><a class="scroll-section" href="{{URL::to('/#screenshots')}}">صور</a></li>
                        <li><a class="scroll-section" href="{{URL::to('/#features')}}">مميزات التطبيق </a></li>
                        <li><a class="scroll-section" href="{{URL::to('/#about')}}">نبذة عنا</a></li>
                        <li class="active"><a class="scroll-section" href="#home_banner">الرئيسية</a></li>
                        
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
        <!-- End Nav -->
        <!-- Start Home Banner -->
        <section id="home_banner" class="home-slide" style="background-image: url('assets/img/bg.jpg'); background-size: cover; background-position: 50% 50%;background-attachment: fixed;">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mt-150"></div>
                        <h3> {{trans('app.terms_and_conditions')}}</h3>
						 <div class="mt-100"></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Home Banner -->
    </header>
    <!-- End Header -->
    <!-- Start About Section -->
    <section id="about" class="pt-100">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heade text-center">
                    
                     <p>  {{trans('app.about_company_mess1')}}   </p>
                     <div class="space-25"></div>
                     
                </div>
            </div>
        </div>
    </section>
    <!-- End About Section -->
    
   
    <footer class="text-center"> 
		<p><a href="{{URL::to('/terms-and-conditions')}}">  {{trans('app.terms_and_conditions')}}</a> </p>
		<p> © 2017 المحطة الذاتية</p> 
	</footer>


   
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="{{ URL::asset('frontend/assets/js/jquery.min.js')}}"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Bootstrap JS -->
    <script src="{{ URL::asset('frontend/assets/js/bootstrap.min.js')}}"></script>
    <!-- Owl Carousel JS -->
    <script src="{{ URL::asset('frontend/assets/js/owl.carousel.min.js')}}"></script>
    <!-- Counterup JS -->
    <script src="{{ URL::asset('frontend/assets/js/waypoints.min.js')}}"></script>
    <script src="{{ URL::asset('frontend/assets/js/jquery.counterup.js')}}"></script>
    <!-- AOS JS -->
    <script src="{{ URL::asset('frontend/assets/js/aos.js')}}"></script>
    <!-- lity JS -->
    <script src="{{ URL::asset('frontend/assets/js/lity.min.js')}}"></script>
    <!-- Our Main JS -->
    <script src="{{ URL::asset('frontend/assets/js/main.js')}}"></script>
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
