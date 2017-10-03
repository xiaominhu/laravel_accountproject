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
									<div class = "row">
										 <div class = "col-sm-10">
											<input class="form-control border-primary" readonly type="url" placeholder="http://" value = "{{URL::to('login')}}?invite={{$setting['link']}}" id="invitelink">
										</div>
										<div class = "col-sm-2">
											<button type="button" class="btn btn-primary" onclick="copyToClipboard('#invitelink')">
												<i class="icon-copy2"></i>  {{trans('app.invitation_link')}} 
											</button>
										</div>
									</div>
								   
									
								</div>
								
								
								<div class="form-group col-sm-12">
								 
								  <div class="col-sm-4">
										<input class="form-control border-primary"  type="text" placeholder="Email or Mobile Number" value = "" id="inviteaddresss">
								  </div>
								  
								   <div class="col-sm-4">
										<button type="button" class="btn btn-primary emailsendto" data-type = "fillingup" data-content = "">
											<i class="icon-envelope"></i>  {{trans('app.email_send_to')}} 
										</button>
										<button type="button" class="btn btn-primary smssendto" data-type = "fillingup" data-content = "">
											<i class="icon-paper-plane-o"></i>   {{trans('app.send_by_sms')}} 
										</button>
										
								  </div>
								</div>
						
						
						
								
							</div>
						</div>
						
						
					</div>
				</div>
				
				
			
		</form>	
				
		</div>
@endsection