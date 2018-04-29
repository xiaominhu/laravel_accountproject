@extends('layouts.seller')

@section('admincontent')

			<?php
				$flag = isset($selleremployee) ? 1 : 0;
			?>



 <div class="content-header row">
 </div>
      <div class="content-body"><!-- stats -->
			  
				<div class="row">
					<div class="col-xs-12">
								<div class="card">
							
												<div class="card-header">
													<h4 class="card-title" id="basic-layout-form"> {{$title}}</h4>
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
		 
			@if($flag)
				  <form class="form-horizontal" method = "post" action="/seller/employeers/update/{{$selleremployee->no}}">
			@else
					<form  action="/seller/employeers/create" method="post" enctype="multipart/form-data">
			@endif

				{{csrf_field()}}
				<div class = "row">
						
						<div class="form-group col-sm-12 required">
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
											@if($fuelstation->id == old('fuelstation'))
													<option value = "{{$fuelstation->id}}" selected> {{$fuelstation->name}}</option>
												@else
													<option value = "{{$fuelstation->id}}"> {{$fuelstation->name}}</option>
												@endif
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
								<select class="form-control" name = "service">
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
						
						
						<div class="form-group col-sm-12 required">
						  <label for="first_name" class="col-sm-2 control-label">   {{trans('app.first_name')}}   </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="first_name" name = "first_name" placeholder="{{trans('app.first_name')}}" value = "<?php
								if($flag) echo $selleremployee->first_name; 
								else      echo old('first_name'); 
								 
								  ?>">
							   @if ($errors->has('first_name'))
										<span class="help-block">
											<strong>{{ $errors->first('first_name')}}</strong>
										</span>
								@endif
						  </div>
						</div>
						
						
						<div class="form-group col-sm-12 required">
							<label for="last_name" class="col-sm-2 control-label">  {{trans('app.last_name')}}   </label>
							    <div class="col-sm-10">
									<input type="text" class="form-control" id="last_name" name = "last_name" placeholder="{{trans('app.last_name')}}" value = "<?php 
										if($flag) echo $selleremployee->last_name;
										else      echo old('last_name');
										
										?>">
										 @if ($errors->has('last_name'))
														<span class="help-block">
															<strong>{{ $errors->first('last_name')}}</strong>
														</span>
												@endif
								</div>
						</div>
						
						
						<div class="form-group col-sm-12 required">
						  <label for="email" class="col-sm-2 control-label">   {{trans('app.email')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="email" name = "email" placeholder="{{trans('app.email')}}" value = "<?php 
									if($flag) echo $selleremployee->email;  
									else      echo old('email');
									
									?>">
											 @if ($errors->has('email'))
														<span class="help-block">
															<strong>{{ $errors->first('email')}}</strong>
														</span>
												@endif
						  </div>
						</div>
					 
						<div class="form-group col-sm-12 required">
						  <label for="phone" class="col-sm-2 control-label">   {{trans('app.phone')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="phone" name = "phone" placeholder="{{trans('app.phone')}}" value = "<?php 
							
								if($flag) echo $selleremployee->phone;  
								else      echo old('phone');	
							?>">
											  @if ($errors->has('phone'))
														<span class="help-block">
															<strong>{{ $errors->first('phone')}}</strong>
														</span>
												@endif
						  </div>
						</div>
				 
						<div class="form-group col-sm-12 required">
						  <label for="password" class="col-sm-2 control-label">  {{trans('app.password')}} </label>
						  <div class="col-sm-10">
							<input type="password" class="form-control" id="password" name = "password" placeholder="{{trans('app.password')}}" value = "{{old('password')}}">
								        @if ($errors->has('password'))
														<span class="help-block">
															<strong>{{ $errors->first('password')}}</strong>
														</span>
												@endif
						  </div>
						</div>
						 
						<div class="form-group col-sm-12 required">
						  <label for="password_confirmation" class="col-sm-2 control-label">   {{trans('app.confirm_password')}}  </label>
						  <div class="col-sm-10">
							<input type="password" class="form-control" id="password_confirmation" name = "password_confirmation" placeholder="{{trans('app.password')}}" value = "{{old('password_confirmation')}}">
						  </div>
						</div>
				</div>	
				
				<div class = "row">
					<div class = "col-xs-12 text-center">
						<button type="submit" class="btn btn-warning  " style = "margin-right:50px;">
						   <i class="icon-paper-plane-o"></i>
							 {{trans('app.apply')}}  
						</button>
						<a href="{{URL::to('/seller/employeers')}}" class="btn btn-warning  " style = "margin-right:50px;">
						   <i class="icon-undo"></i>
							 {{trans('app.cancel')}}  
						</a>
					</div>
				</div>
	 	 </form>	
			
		</div>
		</div>
		</div>
								</div>
					</div>
		</div>


		<script>
			employee_role = 1;
		</script>
		
@endsection