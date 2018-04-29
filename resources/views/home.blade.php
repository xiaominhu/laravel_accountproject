<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Self Station | المحطة الذاتية</title>
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon -->
	
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
    <link href="{{ URL::asset('frontend/assets/css/main.css')}}" rel="stylesheet">
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
                    <li class="active"><a class="scroll-section scroll-section1"  href="{{route('login')}}">CUSTOMER REGISTER/LOGIN</a></li>
                    <li><a class="dropdown-item language scroll-section1" href="#" data-lang="sa"> عربي  </a> </li>
                </ul>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main_menu" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand scroll-section" href="./"><img src="{{ URL::asset('frontend/assets/img/logo.png')}}" class="img-responsive logo-main" alt=""></a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="main_menu">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a class="scroll-section" href="#home_banner">home</a></li>
                        <li><a class="scroll-section" href="#about">About us</a></li>
                        <li><a class="scroll-section" href="#features">features</a></li>
                        <li><a class="scroll-section" href="#screenshots">screenshots</a></li>
                        <li><a class="scroll-section" href="#download">Download</a></li>
                        <li><a class="scroll-section" href="#contact">contact</a></li>
                        <li><a class="scroll-section" href="{{URL::to('seller/login')}}">PROVIDER REGISTER/LOGIN</a></li>
                       
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
        <!-- End Nav -->
        <!-- Start Home Banner -->
        <section id="home_banner" class="home-slide" style="background-image: url('frontend/assets/img/bg.jpg'); background-size: cover; background-position: 50% 50%;background-attachment: fixed;">
            <div class="overlay"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-250"></div>
                        <h3>Self Station is your best choice ..</h3>
                        <p>Self Station service is to save the wasted costs in fuel filling stations located in Saudi Arabia.</p>
                        <a class="btn btn-default scroll-section" href="#about" role="button">Read More</a>
                        <a class="btn btn-default scroll-section" href="#features" role="button">Features</a>
                    </div>
                    <div class="col-md-6">
                        <div class="mt-200 hidden-sm hidden-xs"></div>
                        <img src="{{ URL::asset('frontend/assets/img/slide-mobile-2.png')}}" class="img-responsive center-block" alt="">
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
                    <h3>About us</h3>
                    <div class="space-25"></div>
                    <p>We are available to serve you in all fuel stations available through
                    <br>
                      self-station services targeting all facilities and individuals</p>
                      <div class="space-50"></div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Section -->
    
    <section class="design-process-section" id="process-tab">
      <div class="container">
        <div class="row">
          <div class="col-xs-12"> 
            <!-- design process steps--> 
            <!-- Nav tabs -->
            <ul class="nav nav-tabs process-model more-icon-preocess" role="tablist">
              <li role="presentation" class="active"><a href="#discover" aria-controls="discover" role="tab" data-toggle="tab"><i class="fa fa-search" aria-hidden="true"></i>
                <p>Download</p>
                </a></li>
              <li role="presentation"><a href="#strategy" aria-controls="strategy" role="tab" data-toggle="tab"><i class="fa fa-send-o" aria-hidden="true"></i>
                <p>Sign Up</p>
                </a></li>
              <li role="presentation"><a href="#optimization" aria-controls="optimization" role="tab" data-toggle="tab"><i class="fa fa-qrcode" aria-hidden="true"></i>
                <p>Add</p>
                </a></li>
              <li role="presentation"><a href="#content" aria-controls="content" role="tab" data-toggle="tab"><i class="fa fa-newspaper-o" aria-hidden="true"></i>
                <p>Fuel</p>
                </a></li>
              <li role="presentation"><a href="#reporting" aria-controls="reporting" role="tab" data-toggle="tab"><i class="fa fa-clipboard" aria-hidden="true"></i>
                <p>Payment</p>
                </a></li>
            </ul>
            <!-- end design process steps--> 
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="discover">
                <div class="design-process-content">
                  <h3 class="semi-bold">Download Our App from Google Play & App Store</h3>
                 </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="strategy">
                <div class="design-process-content">
                  <h3 class="semi-bold">Sign up with using our website or app</h3>
                  </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="optimization">
                <div class="design-process-content">
                  <h3 class="semi-bold">Add Balance through your account</h3>
                   </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="content">
                <div class="design-process-content">
                  <h3 class="semi-bold">Fill the fuel through the barcode</h3>            
                  </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="reporting">
                <div class="design-process-content">
                  <h3>The seller will paid directly through the barcode</h3>
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </section>
    
    <!-- Start Features Section -->
    <section id="features" class="pt-100" style="background-image: url('frontend/assets/img/bg.jpg'); background-size: cover; background-position: 50% 50%;background-attachment: fixed;">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heade white text-center">
                    <h3>features</h3>
                    <div class="space-25"></div>
                    <p>Many facilities and individuals have difficulties in controlling the periodic costs of fuel filling and knowing the extent of continued consumption, so we have found the best solution.</p>
                    <div class="space-50"></div>
                </div>
                <div class="col-md-4 text-right">
                    <div class="features-wrapper right-icon">
                        <ul class="list-unstyled">
                            <li>
                                <div class="single-feature" data-aos="fade-right" data-aos-delay="200">
                                    <div class="features-icon">
                                        <img src="{{ URL::asset('frontend/assets/img/icon-4.png')}}" class="img-responsive" alt="">
                                    </div>
                                    <div class="features-details">
                                        <h5>Fast handling</h5>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <li>
                                <div class="single-feature" data-aos="fade-right" data-aos-delay="400">
                                    <div class="features-icon">
                                        <img src="{{ URL::asset('frontend/assets/img/icon-5.png')}}" class="img-responsive" alt="">
                                    </div>
                                    <div class="features-details">
                                        <h5>Electronic payment</h5>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <li>
                                <div class="single-feature" data-aos="fade-right" data-aos-delay="600">
                                    <div class="features-icon">
                                        <img src="{{ URL::asset('frontend/assets/img/icon-6.png')}}" class="img-responsive" alt="">
                                    </div>
                                    <div class="features-details">
                                        <h5>Geographical service</h5>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 text-center about-box hidden-sm hidden-xs" data-aos="fade-up">
                    <img src="{{ URL::asset('frontend/assets/img/features-img.jpg')}}" class="img-responsive center-block" alt="">
                </div>
                <div class="col-md-4 text-left about-box">
                    <div class="features-wrapper left-icon">
                        <ul class="list-unstyled">
                            <li>
                                <div class="single-feature" data-aos="fade-left" data-aos-delay="200">
                                    <div class="features-icon">
                                        <img src="{{ URL::asset('frontend/assets/img/icon-7.png')}}" class="img-responsive" alt="">
                                    </div>
                                    <div class="features-details">
                                        <h5>Multiple options</h5>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <li>
                                <div class="single-feature" data-aos="fade-left" data-aos-delay="400">
                                    <div class="features-icon">
                                        <img src="{{ URL::asset('frontend/assets/img/icon-8.png')}}" class="img-responsive" alt="">
                                    </div>
                                    <div class="features-details">
                                        <h5>Safety</h5>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                            <li>
                                <div class="single-feature" data-aos="fade-left" data-aos-delay="600">
                                    <div class="features-icon">
                                        <img src="{{ URL::asset('frontend/assets/img/icon-9.png')}}" class="img-responsive" alt="">
                                    </div>
                                    <div class="features-details">
                                        <h5>Gift to someone</h5>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Start Features Section -->
    <!-- Start One Feature Section -->
    <section class="one-feature padding-100">
        <div class="container">
            <div class="row">
                <div class="col-md-6" data-aos="fade-right" data-aos-delay="600">
                    <img src="{{ URL::asset('frontend/assets/img/section-img.jpg')}}" class="img-responsive center-block" alt="">
                </div>
                <div class="col-md-6" data-aos="fade-left" data-aos-delay="200">
                    <h2>Self-Station for you and me</h2>
                    <p>You get to be in more control than ever.</p>
                    <a class="btn btn-default colored scroll-section" href="#download" role="button">Download</a>
                </div>
            </div>
        </div>
    </section>
    <!-- End One Feature Section -->
    <!-- Start Video Section -->
    <section id="video" class="padding-100" style="background-image: url('frontend/assets/img/bg.jpg'); background-size: cover; background-position: 50% 50%;background-attachment: fixed;">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heade white text-center">
                    <h3>Watch video</h3>
                    <div class="space-25"></div>
                    <p>Introductory video showing Self-Station services</p>
                    <div class="space-50"></div>
                </div>
                <div class="col-md-12 text-center">
                    <a href="http://www.youtube.com/watch?v=XSGBVzeBUbk" data-lity>
                        <img src="{{ URL::asset('frontend/assets/img/icon-14.png')}}" class="img-responsive center-block" alt="">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Video Section -->
    <!-- Start Screenshots Section -->
    <section id="screenshots" class="padding-100">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heade text-center">
                    <h3>screenshots</h3>
                    <div class="space-25"></div>
                    <p>Smart service directly over your phone</p>
                    <div class="space-50"></div>
                </div>
                <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6 text-center">
                    <div class="screenshots-slider owl-carousel owl-theme">
                        <div class="item"><img src="{{ URL::asset('frontend/assets/img/screenshot.jpg')}}" class="img-responsive" alt=""></div>
                        <div class="item"><img src="{{ URL::asset('frontend/assets/img/screenshot.jpg')}}" class="img-responsive" alt=""></div>
                        <div class="item"><img src="{{ URL::asset('frontend/assets/img/screenshot.jpg')}}" class="img-responsive" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Screenshots Section -->
    <!-- Start Download Section -->
    <section id="download" class="padding-100" style="background-image: url('frontend/assets/img/bg.jpg'); background-size: cover; background-position: 50% 50%;background-attachment: fixed;">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heade white text-center">
                    <h3>Download App</h3>
                    <div class="space-25"></div>
                    <p>Our app is currently available in both App Store & Google Play.</p>
                    <div class="space-50"></div>
                </div>
                <div class="col-md-6 text-center" data-aos="fade-right" data-aos-delay="300">
                    <a class="btn btn-default" href="#" role="button"><i class="fa fa-apple" aria-hidden="true"></i> <span>App Store</span></a>
                </div>
                <div class="col-md-6 text-center" data-aos="fade-up" data-aos-delay="300">
                    <a class="btn btn-default" href="#" role="button"><i class="fa fa-android" aria-hidden="true"></i> <span>Google Play</span></a>
                </div>
            </div>
        </div>
    </section>
    <!-- End Download Section -->
    <!-- Start FAQ Section -->
    <section id="faq" class="padding-100">
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heade text-center">
                    <h3>faq</h3>
                    <div class="space-25"></div>
                </div>
                <div class="col-md-6" data-aos="fade-right" data-aos-delay="200">
                    <div class="space-50"></div>
                    <div class="space-50"></div>
                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="heading_1">
                                <h4 class="panel-title">
                                    <a class="" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_1" aria-expanded="true" aria-controls="collapse_1">
                                Can I use the service through the application or the website?
                            </a>
                                </h4>
                            </div>
                            <div id="collapse_1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_1">
                                <div class="panel-body">
                                    Yes, the service can be used in both cases.
                                </div>
                            </div>
                        </div>
                        <!---->
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="heading_2">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_2" aria-expanded="true" aria-controls="collapse_2">
                                Is the service available in all regions of Saudi Arabia?
                            </a>
                                </h4>
                            </div>
                            <div id="collapse_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_2">
                                <div class="panel-body">
                                    Currently available in Hail and Riyadh and soon we will reach all GCC countries.
                                </div>
                            </div>
                        </div>
                        <!---->
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="heading_3">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_3" aria-expanded="true" aria-controls="collapse_2">
                                Is the service available at all stations?
                            </a>
                                </h4>
                            </div>
                            <div id="collapse_3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_3">
                                <div class="panel-body">
                                    At Self-Station, we are working on contracts with all fuel companies on the roads and we will be available to everyone soon.
                                </div>
                            </div>
                        </div>
                        <!---->
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="heading_4">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_4" aria-expanded="true" aria-controls="collapse_2">
                                Does the service work around the clock?
                            </a>
                                </h4>
                            </div>
                            <div id="collapse_4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_4">
                                <div class="panel-body">
                                    The service is available 24 hours a day.
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left" data-aos-delay="600">
                    <img src="{{ URL::asset('frontend/assets/img/faq.jpg')}}" class="img-responsive center-block" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- End FAQ Section -->
    <!-- Start Contact Section -->
    <section id="contact" class="padding-100" style="background-image: url('frontend/assets/img/bg.jpg'); background-size: cover; background-position: 50% 50%;background-attachment: fixed;">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12 section-heade white text-center">
                    <h3>get in touch</h3>
                    <div class="space-25"></div>
                    <p>We are pleased to contact you directly and receive all suggestions and inquiries via the form of communication or direct contact.</p>
                    <div class="space-50"></div>
                </div>
                <div class="col-md-8">
                    	@if(Session::has('message_sent'))
							<div id="sendmessage"> <i> {{trans('app.your_message_has_been_sent')}} </i> </div>
						@endif
                    <form id="contact-form" action="{{URL::to('/getintouch')}}" method="post" role="form" class="contactForm">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="name"   type="text" id="yourname" placeholder="Enter Your Name" required value = "{{old('name')}}">
                                           @if ($errors->has('name'))
												<div class="validation"> {{ $errors->first('name') }} </div>
											@endif
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <input type="email" name="email"  class="form-control" id="youremail" placeholder="Enter Your Email" required value = "{{old('email')}}">
                                            @if ($errors->has('email'))
												<div class="validation"> {{ $errors->first('email') }} </div>
											@endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <input type="text" value = "{{old('subject')}}"  name="subject"  class="form-control" id="yoursubject" placeholder="Enter Your Subject" required>
                                           @if ($errors->has('subject'))
												<div class="validation"> {{ $errors->first('subject') }} </div>
											@endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <textarea class="form-control"  name="message"  id="yourmessage" rows="6" placeholder="Enter Your Message" required>{{old('message')}}</textarea>
                                @if ($errors->has('subject'))
                                    <div class="validation"> {{ $errors->first('message') }} </div>
                                @endif
                        </div>

                        <button type="submit" class="btn btn-default center-block">submit</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <ul class="list-unstyled contact-info">
                        <li>
                            <div class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                            <div class="text">Riyadh, Saudi Arabia</div>
                        </li>
                        <li>
                            <div class="icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                            <div class="text">0123456778</div>
                        </li>
                        <li>
                            <div class="icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                            <div class="text"><a href="mailto:info@selfstation.sa">info@selfstation.sa</a></div>
                        </li>
                    </ul>
                    <ul class="list-inline social-icons">
                        <li class="facebook"><a href="#" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li class="twitter"><a href="#" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li class="google-plus"><a href="#" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                        <li class="linkedin"><a href="#" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                        <li class="pinterest"><a href="#" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- End Contact Section -->
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
