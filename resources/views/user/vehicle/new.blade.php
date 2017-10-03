@extends('layouts.user')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
				<?php
					$flag = isset($vehicle) ? 1 : 0;
				?>
			@if($flag)
			    <form class="form-horizontal" method = "post" action="/user/vehicles/update/{{$vehicle->id}}"  enctype="multipart/form-data">
			@else
				<form class="form-horizontal" method = "post" action="/user/vehicles/create"  enctype="multipart/form-data">
			@endif
			
				{{csrf_field()}}
				
				<div class="form-group text-center">
					@if($flag)
						@if($vehicle->picture)
							<img src = "/images/vehicle/{{$vehicle->picture}}" height = "200"> 
						@else
							<img src = "/images/default-vehicle.png" height = "200"> 
						@endif
					@else
							<img src = "/images/default-vehicle.png" height = "200"> 
					@endif
				</div>
				
				<div class="form-group">
					<label for="picture" > {{trans('app.picture')}}   </label>
					<input id="picture" type = "file" class="form-control border-primary" name="picture"></input>
				</div>
					
				
				
				<div class="form-group col-sm-12">
					<label for="emailtemplate_config_subject" class="col-sm-2 control-label">  {{trans('app.name')}} </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="createvehicle_name" name = "createvehicle_name" placeholder="" value = "<?php if($flag) echo $vehicle->name; ?>">

							 @if ($errors->has('createvehicle_name'))
									<span class="help-block">
										<strong>{{ $errors->first('createvehicle_name')}}</strong>
									</span>
							@endif

					
					</div>
				</div>
			
				<div class="form-group col-sm-12">
                  <label for="createvehicle_type" class="col-sm-2 control-label">  {{trans('app.type')}} </label>
                  <div class="col-sm-10">
                 	   <input type="text" class="form-control" id="createvehicle_type" name = "createvehicle_type" placeholder="" value = "<?php if($flag) echo $vehicle->type; ?>">
											 @if ($errors->has('createvehicle_type'))
														<span class="help-block">
															<strong>{{ $errors->first('createvehicle_type')}}</strong>
														</span>
												@endif
								  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_model" class="col-sm-2 control-label">   {{trans('app.model')}} </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="createvehicle_model" name = "createvehicle_model" placeholder="" value = "<?php if($flag) echo $vehicle->model; ?>">
										    @if ($errors->has('createvehicle_model'))
														<span class="help-block">
															<strong>{{ $errors->first('createvehicle_model')}}</strong>
														</span>
												@endif
									</div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_fuel" class="col-sm-2 control-label">     {{trans('app.fuel')}}  </label>
                  <div class="col-sm-10">
										<select id = "createvehicle_fuel" class = "form-control" name ="createvehicle_fuel" >
											<option value="0" <?php if($flag) if($vehicle->fuel == "0") echo "selected" ?>>   {{trans('app.all')}}  </option>	
											<option value="1" <?php if($flag) if($vehicle->fuel == "1") echo "selected" ?>>  {{trans('app.green_fuel')}}  </option>	
											<option value="2" <?php if($flag) if($vehicle->fuel == "2") echo "selected" ?>>  {{trans('app.red_fuel')}}  </option>	
											<option value="3" <?php if($flag) if($vehicle->fuel == "3") echo "selected" ?>>   {{trans('app.diesel')}}  </option>	
										</select>

											 @if ($errors->has('createvehicle_fuel'))
														<span class="help-block">
															<strong>{{ $errors->first('createvehicle_fuel')}}</strong>
														</span>
												@endif


                  </div>
                </div>
								
								<div class="form-group col-sm-12" style = "display:none;">
                  <label for="createvehicle_oil" class="col-sm-2 control-label">  {{trans('app.oil')}}   </label>
                  <div class="col-sm-10">
                    <input type="hidden" class="form-control" id="createvehicle_oil" name = "createvehicle_oil" placeholder="" value = "<?php if($flag) echo $vehicle->oil; ?>">
												@if ($errors->has('createvehicle_oil'))
														<span class="help-block">
															<strong>{{ $errors->first('createvehicle_oil')}}</strong>
														</span>
												@endif
									</div>
                </div>

								<div class="form-group col-sm-12">
                  <label for="createvehicle_oil" class="col-sm-2 control-label">    {{trans('app.password')}}  </label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="createvehicle_password" name = "createvehicle_password" placeholder="" value = "">
										  	@if ($errors->has('createvehicle_password'))
														<span class="help-block">
															<strong>{{ $errors->first('createvehicle_password')}}</strong>
														</span>
												@endif
									</div>
                </div>

				
								<div class="form-group col-sm-12">
                  <label for="createvehicle_oil" class="col-sm-2 control-label">    {{trans('app.city')}}  </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="createvehicle_city" name = "createvehicle_city" placeholder="" value = "<?php if($flag) echo $vehicle->city; ?>">
											@if ($errors->has('createvehicle_city'))
														<span class="help-block">
															<strong>{{ $errors->first('createvehicle_city')}}</strong>
														</span>
												@endif
									</div>
                </div>


				
				<div class="form-group col-sm-12">
					<label for="createvehicle_state" class="col-sm-2 control-label"> {{trans('app.state')}} </label>
					<div class="col-sm-10">
							<select id = "createvehicle_state" class = "form-control" name ="createvehicle_state" >
								<option value=""> --  {{trans('app.choose_state')}} -- </option>
								@if($flag)
										@foreach($states as $state)
											<option value="{{$state->zone_id}}"  <?php if($state->zone_id == $vehicle->state) echo "selected";  ?> >{{$state->name}}</option>
										@endforeach
								@else

										@foreach($states as $state)
											<option value="{{$state->zone_id}}">{{$state->name}}</option>
										@endforeach
								
								@endif
							</select>

								@if ($errors->has('createvehicle_city'))
										<span class="help-block">
											<strong>{{ $errors->first('createvehicle_city')}}</strong>
										</span>
								@endif

					</div>
				</div>
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_coutry" class="col-sm-2 control-label">  {{trans('app.country')}} </label>
                  <div class="col-sm-10">
                   
				    	<select id = "createvehicle_coutry" class = "form-control" name ="createvehicle_coutry" disabled ="disabled">
							<option value=""> -- {{trans('app.choose_country')}}-- </option>	
							@foreach($countries as $country)
								@if($flag)
									@if($country->country_id == $vehicle->country)
										<option value="{{$country->country_id}}" selected>{{$country->name}}</option>
									@else
										<option value="{{$country->country_id}}">{{$country->name}}</option>
									@endif
								@else

									@if($country->country_id == '184')
										<option value="{{$country->country_id}}" selected>{{$country->name}}</option>
									@endif

								@endif
							@endforeach
						</select>
					
					
                  </div>
                </div>
				
				
				<div class = "col-xs-4 pull-right">
					<button type="submit" class="btn btn-primary">
						 {{trans('app.apply')}}
					</button>
					<a href = "{{URL::to('/user/vehicles')}}" class="btn btn-primary">
						 {{trans('app.cancel')}}
					</a>
				</div>
			</form>  				
		</div>
@endsection