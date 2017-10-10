@extends('layouts.seller')

@section('admincontent')

			<?php
				$flag = isset($selleremployee) ? 1 : 0;
			?>



 <div class="content-header row">
 </div>
      <div class="content-body"><!-- stats -->
			  
			<br/>
			<br/>

			@if($flag)
				  <form class="form-horizontal" method = "post" action="/seller/employeers/update/{{$selleremployee->no}}">
			@else
					<form  action="/seller/employeers/create" method="post" enctype="multipart/form-data">
			@endif

				{{csrf_field()}}
				<div class = "row">
						
						<div class="form-group col-sm-12">
							<label for="email" class="col-sm-2 control-label">   {{trans('app.fuelstation')}} </label>
							<div class="col-sm-10">
								<select class="form-control" name = "fuelstation">
									<option value = "">  --{{trans('app.choose_fuelstation')}}  --  </option>
									@foreach($fuelstations as $fuelstation)
										@if($flag)
												@if($fuelstation->id == $selleremployee->fuelstation_id)
													<option value = "{{$fuelstation->id}}" selected> {{$fuelstation->name}}</option>
												@else
													<option value = "{{$fuelstation->id}}"> {{$fuelstation->name}}</option>
												@endif
										@else
												<option value = "{{$fuelstation->id}}"> {{$fuelstation->name}}</option>
										@endif

										
									@endforeach
								</select>
									 @if ($errors->has('fuelstation'))
											<span class="help-block">
												<strong>{{ $errors->first('fuelstation')}}</strong>
											</span>
									@endif
							</div>
						</div>
						
						
						<div class="form-group col-sm-12">
							<label for="email" class="col-sm-2 control-label">   {{trans('app.service_type')}} </label>
							<div class="col-sm-10">
								<select class="form-control" name = "service" disabled = "disabled">
									<option>  --{{trans('app.choose_service')}}  --  </option>
									<option value = "1" selected> {{trans('app.fuel')}} </option>
									<option value = "2"> {{trans('app.oil')}}</option>
									<option value = "3">  {{trans('app.wash')}}</option>
								</select>
									      @if ($errors->has('service'))
														<span class="help-block">
															<strong>{{ $errors->first('service')}}</strong>
														</span>
												@endif


							</div>
						</div>
						
						
						<div class="form-group col-sm-12">
						  <label for="first_name" class="col-sm-2 control-label">   {{trans('app.first_name')}}   </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="first_name" name = "first_name" placeholder="" value = "<?php if($flag) echo $selleremployee->first_name;  ?>">
							   @if ($errors->has('first_name'))
										<span class="help-block">
											<strong>{{ $errors->first('first_name')}}</strong>
										</span>
								@endif
						  </div>
						</div>
						
						
						<div class="form-group col-sm-12">
							<label for="last_name" class="col-sm-2 control-label">  {{trans('app.last_name')}}   </label>
							    <div class="col-sm-10">
									<input type="text" class="form-control" id="last_name" name = "last_name" placeholder="" value = "<?php if($flag) echo $selleremployee->last_name;  ?>">
										 @if ($errors->has('last_name'))
														<span class="help-block">
															<strong>{{ $errors->first('last_name')}}</strong>
														</span>
												@endif
								</div>
						</div>
						
						
						<div class="form-group col-sm-12">
						  <label for="email" class="col-sm-2 control-label">   {{trans('app.email')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="email" name = "email" placeholder="" value = "<?php if($flag) echo $selleremployee->email;  ?>">
											 @if ($errors->has('email'))
														<span class="help-block">
															<strong>{{ $errors->first('email')}}</strong>
														</span>
												@endif
						  </div>
						</div>
					 
						<div class="form-group col-sm-12">
						  <label for="phone" class="col-sm-2 control-label">   {{trans('app.phone')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="phone" name = "phone" placeholder="" value = "<?php if($flag) echo $selleremployee->phone;  ?>">
											  @if ($errors->has('phone'))
														<span class="help-block">
															<strong>{{ $errors->first('phone')}}</strong>
														</span>
												@endif
						  </div>
						</div>
				 
						<div class="form-group col-sm-12">
						  <label for="password" class="col-sm-2 control-label">  {{trans('app.password')}} </label>
						  <div class="col-sm-10">
							<input type="password" class="form-control" id="password" name = "password" placeholder="" value = "">
								        @if ($errors->has('password'))
														<span class="help-block">
															<strong>{{ $errors->first('password')}}</strong>
														</span>
												@endif
						  </div>
						</div>
						 
						<div class="form-group col-sm-12">
						  <label for="password_confirmation" class="col-sm-2 control-label">   {{trans('app.confirm_password')}}  </label>
						  <div class="col-sm-10">
							<input type="password" class="form-control" id="password_confirmation" name = "password_confirmation" placeholder="" value = "">
						  </div>
						</div>
				</div>	
				
				<div class = "row">
					<div class = "col-xs-12 text-center">
						<button type="submit" class="btn btn-primary  " style = "margin-right:50px;">
						   <i class="icon-paper-plane-o"></i>
							 {{trans('app.apply')}}  
						</button>
						<a href="{{URL::to('/seller/employeers')}}" class="btn btn-primary  " style = "margin-right:50px;">
						   <i class="icon-undo"></i>
							 {{trans('app.cancel')}}  
						</a>
					</div>
				</div>
	 	 </form>	
			
		</div>
		<script>
			employee_role = 1;
		</script>
		
@endsection