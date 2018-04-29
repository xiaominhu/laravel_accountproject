@extends('layouts.user')
@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
				@if($errors->any())
				   <div class="alert alert-warning">
						 <ul>
							   @foreach ($errors->all() as $error)
								  <li>{{ $error }}</li>
							  @endforeach
						  </ul>
				  </div>
				@endif
				
			<br/>
			<br/>
			<form  action="/user/fillingup" method="post" class="card">	
				{{csrf_field()}}
				<div class = "row">
					<div class = "col-xs-12">
						<div class="card-header">
							<h1 class="card-title text-center"> <strong>   {{trans('app.get_now_10_sar_as_fee_balance')}}  </strong></h1>
						</div>
						
						<div class="card-body collapse in">
							<div class="card-block">
								<div class="card-text text-center" style= "font-size: 140px;">
									<i class="icon-envelope"></i>
								</div>
								
								<div class="card-text text-center">
									<h2 class="card-title text-center"> {{trans('app.when_your_selfstation_and_do_his_first_fillup_you_get_sar')}} </h2>
								</div>
								
								
								<div class="card-text text-center">
									<h3 class="card-subtitle text-center text-muted">  {{trans('app.invitation_link')}} </h3>
								</div>
								
								<div class="form-group col-sm-12">
									 
										 <div class = "col-sm-10 mbbt-5">
											<input class="form-control border-warning" readonly type="url" placeholder="http://" value = "{{URL::to('login')}}?invite={{$setting['link']}}" id="invitelink">
										</div>
										<div class = "col-sm-2">
											<button type="button" class="btn btn-warning" onclick="copyToClipboard('#invitelink')">
												<i class="icon-copy2"></i>  {{trans('app.invitation_link')}} 
											</button>
										</div>
									 
								    
								</div>
								
								
								<div class="form-group col-md-12">
								 
								  <div class="col-sm-3 mbbt-5">
										<input class="form-control border-warning"  type="text" placeholder="exmple@example.com" value = "" id="inviteaddresss_email">
								  </div>
								  
									<div class="col-sm-3 mbbt-5">
								  		<button type="button" class="btn btn-warning emailsendto" data-type = "fillingup" data-content = "">
											<i class="icon-envelope"></i>  {{trans('app.email_send_to')}} 
										</button>
									</div>

									 <div class="col-sm-3 mbbt-5">
										 
										<div class="intl-tel-input allow-dropdown">
												<div class="flag-container">
													<div class="selected-flag" tabindex="0">
														<div class="iti-flag sa"> </div> 
														<div class="iti-arrow1">(+966)</div>
													</div>
												</div>
													<input   class="form-control border-warning"  placeholder = "12345678"   id="inviteaddresss_sms"  type="tel" autocomplete="off" >
											</div>
								  	</div>

								   <div class="col-sm-3 mbbt-5">
										<button type="button" class="btn btn-warning smssendto" data-type = "fillingup" data-content = "">
											<i class="icon-paper-plane-o"></i>   {{trans('app.send_by_sms')}} 
										</button>
									  </div>
								</div>
							</div>
						</div>
						
						
					</div>
				</div>
		</form>	
				
		@push('scripts')
				<link href="{{ URL::asset('app-assets/build/css/intlTelInput.css') }}" rel="stylesheet" type="text/css">
				 <style>
					.iti-arrow1{
							position: absolute;
							margin-top: 1px;
							right: 6px;
							width: 0;
							height: 0;
							border-top: 4px solid #555;
						}

				 
				</style>
		@endpush
		


		</div>
@endsection