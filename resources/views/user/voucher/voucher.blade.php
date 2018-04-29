@extends('layouts.user')
@section('admincontent')
 <div class="content-header row">
 </div>
  
        <div class="content-body"><!-- stats -->
			<div class="row">
			<div class="col-xs-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title" id="basic-layout-form"> {{$title}} </h4>
						<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
						
							<div class="heading-elements">
								<ul class="list-inline mb-0">
									<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
									<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
									<li><a data-action="close"><i class="icon-cross2"></i></a></li>
								</ul>
							</div>
					</div>
					<div class="card-body collapse in">
						<div class="card-block">
							<form  action="{{route('redeem_voucher')}}" class = "sendmoneyform" method="post" class="card">	
								{{csrf_field()}}
								<div class = "row">
									<div class = "col-xs-12">
										<div class="card-body collapse in">
											<div class="card-block">
											@if(Session::has('success'))
												<div class="alert alert-warning mb-2" role="alert">
													  {{trans('app.request_sent_success')}}
												</div>
											@endif
												<div class="card-text text-center" style= "font-size: 80px;">
													<i class="icon-coin-dollar"></i>
												</div>
												<div class="card-text text-center">
													<h2 class="card-title text-center"> {{trans('app.redeem_voucher')}} </h2>
												</div>
												<div class="form-group col-sm-12 required">
													<div class = "row">
														 <h4 class="card-subtitle text-center col-sm-3 control-label">  {{trans('app.code')}} </h4>
														 <div class = "col-sm-6">
															<input  name = "code" class="form-control border-warning"  type="text" placeholder="{{trans('app.code')}}" value = "{{ old('code') }}">
															@if ($errors->has('code'))
																<span class="help-block">
																	<strong>{{ $errors->first('code')}}</strong>
																</span>
															@endif
														</div>
													</div>
												</div>
											  
												<div class="form-group col-sm-12 text-center">					 
													<button type="submit" class="btn btn-warning" id= "sendmoneyform">
														<i class="icon-paper-plane-o"></i>   {{trans('app.send')}} 
													</button>
												</div>

											</div>
										</div>
										
									</div>
								</div>
								
						</form>	
						</div>
					</div>
				</div>
			</div>
	</div>
		</div>
@endsection