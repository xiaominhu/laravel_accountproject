@extends('layouts.user')
@section('admincontent')
 <div class="content-header row">
 </div>
  

        <div class="content-body"><!-- stats -->
			 

			 
			<form  action="{{URL::to('/user/sendmoney')}}" method="post" class="card">	
				{{csrf_field()}}
				<div class = "row">
					<div class = "col-xs-12">
						   
						<div class="card-body collapse in">

							<div class="card-block">

							@if(Session::has('success'))
								<div class="alert alert-primary mb-2" role="alert">
									<strong>Success</strong> Your money is sent successfully.
								</div>
							@endif

								<div class="card-text text-center" style= "font-size: 80px;">
									<i class="icon-coin-dollar"></i>
								</div>

								
								
								<div class="card-text text-center">
									<h2 class="card-title text-center"> {{trans('app.send_money')}} </h2>
								</div>
								
							 
								
								<div class="form-group col-sm-12">
									<div class = "row">
										 <h4 class="card-subtitle text-center col-sm-3">  {{trans('app.amount')}} </h4>
										 <div class = "col-sm-6">
											<input  name = "amount" class="form-control border-primary"  type="text" placeholder="" value = " ">
											@if ($errors->has('amount'))
												<span class="help-block">
													<strong>{{ $errors->first('amount')}}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>
								
								
								
								<div class="form-group col-sm-12">
								 	<div class = "row">
										<h4 class="card-subtitle text-center col-sm-3">  {{trans('app.to')}} </h4>
										<div class="col-sm-6">
											<input class="form-control border-primary"  type="text" placeholder="Email or Mobile Number" value = "" name="reference_id">
											@if ($errors->has('reference_id'))
												<span class="help-block">
													<strong>{{ $errors->first('reference_id')}}</strong>
												</span>
											@endif
										</div>
								    </div>
								</div>

								<div class="form-group col-sm-12 text-center">					 
										<button type="submit" class="btn btn-primary" >
											<i class="icon-paper-plane-o"></i>   {{trans('app.send')}} 
										</button>
								</div>
								
									 
								
							</div>
						</div>
						
						
					</div>
				</div>
				
				
			
		</form>	
				
		</div>
@endsection