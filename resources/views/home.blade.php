
@extends('layouts.frontend')

@section('frontendcontent')
	<section class="hero" id="intro">
            <div class="container">
              <div class="row">
                <div class="col-md-12 text-right navicon">
                  <a id="nav-toggle" class="nav_slide_button" href="#"><span></span></a>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 col-md-offset-2 text-center inner">
					<div class="animatedParent">
						<h1 class="animated fadeInDown"> {{trans('app.selfstation')}} </h1>
						<p class="animated fadeInUp">{{trans('app.selfstation_show_message')}}  </p>
					</div>
			   </div>
              </div>
              <div class="row">
                <div class="col-md-6 col-md-offset-3 text-center">
                  <a href="#about" class="learn-more-btn btn-scroll">  {{trans('app.learn_more')}}  </a>
                </div>
              </div>
            </div>
    </section>
	
	<!-- Section: about -->
    <section id="about" class="home-section color-dark bg-white">
		<div class="container marginbot-50">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="animatedParent">
					<div class="section-heading text-center animated bounceInDown">
					<h2 class="h-bold">    {{trans('app.about_company')}} </h2>
					<div class="divider-header"></div>
					</div>
					</div>
				</div>
			</div>

		</div>

		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2 animatedParent">		
					<div class="text-center">
						<p>
						 {{trans('app.about_company_mess1')}} 
						</p>
						<p>
						 {{trans('app.about_company_mess2')}} 
						</p>
						<a href="#service" class="btn btn-skin btn-scroll">  {{trans('app.what_we_do')}}   </a>
					</div>
				</div>
			</div>		
		</div>

	</section>
	<!-- /Section: about -->
	
	<!-- Section: services -->
    <section id="service" class="home-section color-dark bg-gray">
		<div class="container marginbot-50">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div>
					<div class="section-heading text-center">
					<h2 class="h-bold">   {{trans('app.our_services')}}  </h2>
					<div class="divider-header"></div>
					</div>
					</div>
				</div>
			</div>
			
			 <div class="col-lg-8 col-lg-offset-2 animatedParent">		
				<div class="text-center">
					<br>
					<h6> {{trans('app.electroinic_payment')}}   </h6>
					<p>
					 {{trans('app.our_services_mess1')}}  
					</p>
					<h6>   {{trans('app.add_vehicle')}} </h6>
					
					<p>
					 {{trans('app.our_services_mess2')}}  
					</p>
					
				</div>
            </div>
			
			
		</div>
		
		<div class="text-center">
				<div class="row animatedParent">
					<div class="col-md-12 form-row">
					
					</div>
					<div class="col-md-12 form-row">
							
							<div class="xs-label-mute color1">
								<h4> <strong>  {{trans('app.use_our_services')}}      </strong></h4>
								<h6>  {{trans('app.you_can_get_our_services_easy_steps')}}    </h6>
							</div>
							<div class="xs-label-mute color2">
								<i class="fa fa-sign-in" aria-hidden="true"></i>
								<br>
								<span>  {{trans('app.sign_up')}}    </span>
							</div>
							<div class="xs-label-mute color3">
								<i class="fa fa-usd" aria-hidden="true"></i>
								<br>
								<span> {{trans('app.add_valance')}} </span>
							</div>
							<div class="xs-label-mute color4">
							
							
								<i class="fa fa-qrcode" aria-hidden="true"></i>
								<br>
								<span>   {{trans('app.pay_to_fuelstation')}} </span>
								<br>
								<span>  {{trans('app.through_barcode')}} </span>

							</div>
							<div class="xs-label-mute color5">
								<i class="fa fa-check" aria-hidden="true"></i>
								<br>
								<span> {{trans('app.payment_will_transfer_directly_to_seller_account')}}  </span>
							</div>
					
					</div>
	
			    </div>
		</div>
		
	</section>
	<!-- /Section: services -->
	
	<!-- Section: contact -->
    <section id="contact" class="home-section nopadd-bot color-dark bg-gray text-center">
		<div class = "contactpart">
			<div class=" marginbot-50">
				<div class="row">
					<div class="col-lg-8 col-lg-offset-2">
						<div class="animatedParent">
						<div class="section-heading text-center">
						<h2 class="h-bold animated bounceInDown">  {{trans('app.get_in_touch_with_us')}}  </h2>
						<div class="divider-header"></div>
						</div>
						</div>
					</div>
				</div>
			</div>
		
			<div class="">
				<div class="row marginbot-80">
					<div class="col-md-8 col-md-offset-2">
						@if(Session::has('message_sent'))
							<div id="sendmessage"> {{trans('app.your_message_has_been_sent')}} </div>
						@endif

						@if($errors->any())
							<div id="errormessage">{{trans('app.your_message_has_not_been_sent')}}</div>
						@endif

							<form id="contact-form" action="{{URL::to('/getintouch')}}" method="post" role="form" class="contactForm">
								{{csrf_field()}}
								<div class="row marginbot-20">
									<div class="col-md-12 xs-marginbot-20">
										<div class="form-group">
											<input type="text" name="name" class="form-control" id="name" placeholder="{{trans('app.your_name')}} " data-rule="minlen:4" data-msg=" {{trans('app.please_enter_atleast_4_chars')}}" />
											
											@if ($errors->has('name'))
												<div class="validation"> {{ $errors->first('name') }} </div>
											@endif

										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="email" class="form-control" name="email" id="email" placeholder="{{trans('app.your_email')}}" data-rule="email" data-msg="Please enter a valid email" />
										 
											@if ($errors->has('email'))
												<div class="validation"> {{ $errors->first('email') }} </div>
											@endif

										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<input type="text" class="form-control" name="phone" id="phone" placeholder="{{trans('app.phone')}}" value = "966" data-rule="minlen:4"  data-msg="Please enter a valid phone number" />
											
											@if ($errors->has('phone'))
												<div class="validation"> {{ $errors->first('phone') }} </div>
											@endif
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder=" {{trans('app.message')}} "></textarea>
											@if ($errors->has('message'))
												<div class="validation"> {{ $errors->first('message') }} </div>
											@endif
										</div>						
										<button type="submit" class="btn btn-skin btn-lg btn-block" id="btnContactUs">
											 {{trans('app.send_message')}} </button>
									</div>
								</div>
							</form>
					</div>
				</div>	

			</div>
			
		</div>
		
		<div  class = "contactpart contacts">
				<div class="row marginbot-20 contacts-internal">
					<div class="col-md-12 xs-marginbot-20 margintop-40">
						<h4>    {{trans('app.selfstation')}}  </h4>
					</div>
					<div class="col-md-12 marginbot-20">
						<p class = "subtitle">      {{trans('app.address')}}   </p>
						
						<p>    {{trans('app.street')}} </p>
					
						<p>    {{trans('app.city')}}  </p>
						<p>   {{trans('app.saudi_arabia')}} </p>
						
					</div>
					
					<div class="col-md-12 marginbot-20">
						<p  class = "subtitle">   {{trans('app.contacts')}}  </p>
						<p> {{trans('app.mobile')}} /12345</p>
						<p>  {{trans('app.telex')}} /124</p>
						
					</div>
				</div>
		</div>
		<div  class = "contactpart1">
		</div>
		
	</section>
	<!-- /Section: contact -->



@endsection