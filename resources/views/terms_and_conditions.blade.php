@extends('layouts.frontend')

@section('frontendcontent')
	
	<!-- Section: about -->
    <section id="about" class="home-section color-dark bg-white">
		<div class="container marginbot-50">
			<div class="row">
				<div class="col-lg-8 col-lg-offset-2">
					<div class="animatedParent">
					<div class="section-heading text-center animated bounceInDown">
					<h2 class="h-bold">   {{trans('app.terms_and_conditions')}} </h2>
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
						 
					</div>
				</div>
			</div>		
		</div>

	</section>
	<!-- /Section: about -->
	
@endsection