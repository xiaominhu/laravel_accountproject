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
                    <li class="active"><a class="scroll-section scroll-section1"  href="{{route('login')}}">   تسجيل جديد / تسجيل دخول  </a></li>
                    <li><a class="dropdown-item language scroll-section1" href="#" data-lang="en"> English </a> </li>
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
                        
                        <li><a class="scroll-section"  href="{{URL::to('seller/login')}}"> تسجيل مزود الخدمة / تسجيل الدخول </a></li>
                        <li><a class="scroll-section" href="#contact">اتصل بنا</a></li>
                        <li><a class="scroll-section" href="#download">تحميل</a></li>
                        <li><a class="scroll-section" href="#screenshots">صور</a></li>
                        <li><a class="scroll-section" href="#features">مميزات التطبيق </a></li>
                        <li><a class="scroll-section" href="#about">نبذة عنا</a></li>
                        <li class="active"><a class="scroll-section" href="#home_banner">الرئيسية</a></li>
                            
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
                        <h3>المحطة الذاتية خيارك الأوفر ..</h3>
                        <p>خدمة المحطة الذاتية لتوفير التكاليف المهدرة في تعبئة الوقود عبر المحطات المنتشرة في المملكة العربية السعودية.</p>
                        <a class="btn btn-default scroll-section" href="#about" role="button">المزيد</a>
                        <a class="btn btn-default scroll-section" href="#features" role="button">المميزات </a>
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
                    <h3>نبذة عنا </h3>
                    <div class="space-25"></div>
                    <p>نتواجد لخدمتكم في كافة محطات الوقود المتاحة عبر خدمات
                    <br>
                      تطبيق المحطة الذاتية والتي تستهدف كافة المنشآت والأفراد</p>
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
                <p>حمل</p>
                </a></li>
              <li role="presentation"><a href="#strategy" aria-controls="strategy" role="tab" data-toggle="tab"><i class="fa fa-send-o" aria-hidden="true"></i>
                <p>سجل</p>
                </a></li>
              <li role="presentation"><a href="#optimization" aria-controls="optimization" role="tab" data-toggle="tab"><i class="fa fa-qrcode" aria-hidden="true"></i>
                <p>اشحن</p>
                </a></li>
              <li role="presentation"><a href="#content" aria-controls="content" role="tab" data-toggle="tab"><i class="fa fa-newspaper-o" aria-hidden="true"></i>
                <p>الوقود</p>
                </a></li>
              <li role="presentation"><a href="#reporting" aria-controls="reporting" role="tab" data-toggle="tab"><i class="fa fa-clipboard" aria-hidden="true"></i>
                <p>الدفع</p>
                </a></li>
            </ul>
            <!-- end design process steps--> 
            <!-- Tab panes -->
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="discover">
                <div class="design-process-content">
                  <h3 class="semi-bold">حمل تطبيق المحطة الذاتية</h3>
                 </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="strategy">
                <div class="design-process-content">
                  <h3 class="semi-bold">سجل حسابك في تطبيق المحطة الذاتية</h3>
                  </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="optimization">
                <div class="design-process-content">
                  <h3 class="semi-bold">اشحن رصيدك عن طريق التطبيق</h3>
                   </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="content">
                <div class="design-process-content">
                  <h3 class="semi-bold">قم بتعبئة الوقود من خلال الباركود</h3>            
                  </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="reporting">
                <div class="design-process-content">
                  <h3>سيتم الدفع لمزود الخدمة مباشرة عبر الباركود</h3>
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
                    <h3>مميزات التطبيق</h3>
                    <div class="space-25"></div>
                    <p>الكثير من المنشئات والأفراد يواجهون صعوبات في ضبط التكاليف الدورية الخاصة بتعبئة الوقود ومعرفة
                    <br>
                      مدى الاستهلاك المستمر ، لذا قُمنا بإيجاد الحل الأفضل </p>
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
                                        <h5>التعامل السريع</h5>
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
                                        <h5>الدفع الإلكتروني</h5>
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
                                        <h5>الخدمة الجغرافية</h5>
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
                                        <h5>تعدد الخيارات</h5>
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
                                        <h5>التعامل الآمن</h5>
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
                                        <h5>إهداء الغير</h5>
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
                    <h2>المحطة الذاتية لي ولك .. </h2>
                    <p>خدمة تشيل عنك الهم وتضبط لك أمر الصرف</p>
                    <a class="btn btn-default colored scroll-section" href="#download" role="button">حمل التطبيق الان</a>
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
                    <h3>شاهد الفيديو</h3>
                    <div class="space-25"></div>
                    <p>فيديو تعريفي يوضح خدمات تطبيق المحطة الذاتية</p>
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
                    <h3>صور تطبيق المحطة الذاتية</h3>
                    <div class="space-25"></div>
                    <p>الخدمة الذكية عبر هاتفك مباشرة</p>
                    <div class="space-50"></div>
                </div>
                <div class="col-md-offset-4 col-md-4 col-sm-offset-3 col-sm-6 text-center no-float screenshots">
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
                    <h3>تحميل التطبيق </h3>
                    <div class="space-25"></div>
                    <p>التطبيق متوفر في المتاجر حالياً ، ريح بالك وحمل تطبيقك : المحطة الذاتية </p>
                    <div class="space-50"></div>
                </div>
                <div class="col-md-6 text-center" data-aos="fade-right" data-aos-delay="300">
                    <a class="btn btn-default" style="float: left;" href="#" role="button"><i class="fa fa-apple" aria-hidden="true"></i> <span>متجر ابل</span></a>
                </div>
                <div class="col-md-6 text-center" data-aos="fade-up" data-aos-delay="300">
                    <a class="btn btn-default" href="#" role="button"><i class="fa fa-android" aria-hidden="true"></i> <span>متجر جوجل</span></a>
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
                    <h3>الاسئلة المتكررة</h3>
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
                                هل يمكن استخدام الخدمة عبر التطبيق أو الموقع الإلكتروني ؟
                            </a>
                                </h4>
                            </div>
                            <div id="collapse_1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="heading_1">
                                <div class="panel-body">
                                    نعم يمكن استخدام الخدمة في كلا الحالتين
                                </div>
                            </div>
                        </div>
                        <!---->
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="heading_2">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_2" aria-expanded="true" aria-controls="collapse_2">
                                هل تتوفر الخدمة في كافة محطات الوقود على مستوى المملكة
                            </a>
                                </h4>
                            </div>
                            <div id="collapse_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_2">
                                <div class="panel-body">
                                    متوفرة الان في الرياض - جدة - الشرقية - حائل وقريبا في مدن وطرق المملكة ودول الخليج
                                </div>
                            </div>
                        </div>
                        <!---->
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="heading_3">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_3" aria-expanded="true" aria-controls="collapse_2">
									كيف يمكن إضافة رصيد؟
									</a>
                                </h4>
                            </div>
                            <div id="collapse_3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_3">
                                <div class="panel-body">
                                    اسم الحساب: شركة المحطة الذاتية <br>
                                    مصرف الراجحي <br>
                                    118608010002425 <br>
                                    SA7480000118608010002425 <br>
                                    بنك الرياض <br>
                                    6221898409940 <br>
                                    SA6920000006221898409940 <br>
                                    مصرف الانماء <br>
                                    68201661338000 <br>
                                    SA3905000068201661338000
                                </div>
                            </div>
                        </div>
                        <!---->
                        <div class="panel">
                            <div class="panel-heading" role="tab" id="heading_4">
                                <h4 class="panel-title">
                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_4" aria-expanded="true" aria-controls="collapse_2">
                               هل تعمل الخدمة على مدار الساعة ؟
                            </a>
                                </h4>
                            </div>
                            <div id="collapse_4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_4">
                                <div class="panel-body">
                                    تعمل الخدمة في كافة الأماكن على مدار الساعة ( 24 ساعة )
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-md-6 " data-aos="fade-left" data-aos-delay="600">
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
                    <h3>تواصل معنا</h3>
                    <div class="space-25"></div>
                    <p>نسعد بتواصلكم المباشر واستقبال كافة الاقتراحات والاستفسارات عبر نموذج التواصل أو الاتصال المباشر </p>
                    <div class="space-50"></div>
                </div>
                <div class="col-md-8">
                    	@if(Session::has('message_sent'))
							<div id="sendmessage"><i> {{trans('app.your_message_has_been_sent')}} </i> </div>
						@endif

                   <form id="contact-form" action="{{URL::to('/getintouch')}}" method="post" role="form" class="contactForm">

                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <input  name="name" class="form-control" type="text" id="yourname" placeholder="ادخل اسمك" required value = "{{old('name')}}">
                                            @if ($errors->has('name'))
												<div class="validation"> {{ $errors->first('name') }} </div>
											@endif

                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <input type="email"     name="email"  class="form-control" id="youremail" placeholder="ادخل البريد الالكتروني" required value = "{{old('email')}}">
                                             @if ($errors->has('email'))
												<div class="validation"> {{ $errors->first('email') }} </div>
											@endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <input type="text"  name="subject"  class="form-control" value = "{{old('subject')}}"  id="yoursubject" placeholder="ادخل العنوان" required >
                                            @if ($errors->has('subject'))
												<div class="validation"> {{ $errors->first('subject') }} </div>
											@endif

                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                          <textarea class="form-control"  name="message"  id="yourmessage" rows="6" placeholder="ادخل عنوان الرسالة"  required>{{old('message')}}</textarea>
                               @if ($errors->has('subject'))
                                    <div class="validation"> {{ $errors->first('message') }} </div>
                                @endif

                        </div>

                        <button type="submit" class="btn btn-default center-block">ارسل</button>
                    </form>
                </div>
                <div class="col-md-4">
                    <ul class="list-unstyled contact-info">
                        <li>
                            <div class="icon"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                            <div class="text"> المملكة العربية السعودية / شركة المحطة الذاتية </div>
                        </li>
                        <li>
                            <div class="icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                            <div class="text">920020004</div>
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
