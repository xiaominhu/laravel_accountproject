@extends('layouts.user')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->

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
				<?php
					$flag = isset($vehicle) ? 1 : 0;
					if($flag) {
						$name = explode(' ',$vehicle->name);
					}
				?>
			@if($flag)
			    <form class="form-horizontal" method = "post" action="/user/vehicles/update/{{$vehicle->id}}"  enctype="multipart/form-data"  autocomplete="off">
			@else
				<form class="form-horizontal" method = "post" action="/user/vehicles/create"  enctype="multipart/form-data"  autocomplete="off">
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
				 
				<div class="form-group col-sm-12 required">
					<label for="createvehicle_plate" class="col-sm-2 control-label">  {{trans('app.plate')}} </label>
					<div class="col-sm-10">
						
						<div class="container" style = "direction: ltr; text-align: <?php if(App::getLocale() == "sa") echo "right";  else "left"; ?> ;">
							<input type="text" name="createvehicle_name1" class="licenseplate" maxlength="1" placeholder="A" value = "<?php if($flag) echo $name[0];
							else  echo old('createvehicle_name1');
						 ?>" />

						 <input type="text" name="createvehicle_name2" class="licenseplate" maxlength="1" placeholder="B" value = "<?php if($flag) echo $name[1];
							else  echo old('createvehicle_name2');
						 ?>" /> 

						 <input type="text" name="createvehicle_name3" class="licenseplate" maxlength="1" placeholder="1" value = "<?php if($flag) echo $name[2];
							else  echo old('createvehicle_name3');
						 ?>" />

						 <input type="text" name="createvehicle_name4" class="licenseplate" maxlength="1" placeholder="2" value = "<?php if($flag) echo $name[3];
							else  echo old('createvehicle_name4');
						 ?>" />

						 <input type="text" name="createvehicle_name5" class="licenseplate" maxlength="1" placeholder="3" value = "<?php if($flag) echo $name[4];
							else  echo old('createvehicle_name5');
						 ?>" />

						 <input type="text" name="createvehicle_name6" class="licenseplate" maxlength="1" placeholder="4" value = "<?php if($flag) echo $name[5];
							else  echo old('createvehicle_name6');
						 ?>" />

						 <input type="text" name="createvehicle_name7" class="licenseplate" maxlength="1" placeholder="5" value = "<?php if($flag) echo $name[6];
							else  echo old('createvehicle_name7');
						 ?>" />

						</div>
							 
							@if($errors->has('createvehicle_name1') || $errors->has('createvehicle_name2') || $errors->has('createvehicle_name3') || $errors->has('createvehicle_name4') || $errors->has('createvehicle_name5') || $errors->has('createvehicle_name6') ||  $errors->has('createvehicle_name7')) 
								<span class="help-block">
									<strong>{{trans('app.plate_is_need')}}</strong>
								</span>
							@endif


							@if($errors->has('createvehicle_name')) 
								<span class="help-block">
									<strong>{{ $errors->first('createvehicle_name')}}</strong>
								</span>
							@endif
					</div>
				</div>

				
			
				<div class="form-group col-sm-12 required">
                  <label for="createvehicle_type" class="col-sm-2 control-label">  {{trans('app.type')}} </label>
                  <div class="col-sm-10">
                 	   <input type="text" class="form-control" id="createvehicle_type" name = "createvehicle_type" placeholder=" {{trans('app.type')}}" value = "<?php
							if($flag) echo $vehicle->type;
							else    echo old('createvehicle_type');
						
						 ?>">
											@if ($errors->has('createvehicle_type'))
														<span class="help-block">
															<strong>{{ $errors->first('createvehicle_type')}}</strong>
														</span>
											@endif
								  </div>
                </div>
				
				<div class="form-group col-sm-12 required">
                  <label for="createvehicle_mode" class="col-sm-2 control-label">   {{trans('app.model')}} </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="createvehicle_model" name = "createvehicle_model" placeholder="{{trans('app.model')}}" value = "<?php
							 if($flag) echo $vehicle->model; 
							 else      echo old('createvehicle_model');
							 ?>" autocomplete="createvehicle_model">
							@if ($errors->has('createvehicle_model'))
									<span class="help-block">
										<strong>{{ $errors->first('createvehicle_model')}}</strong>
									</span>
							@endif
					</div>
                </div>
				
				<div class="form-group col-sm-12 required">
                  <label for="createvehicle_fuel" class="col-sm-2 control-label">     {{trans('app.fuel')}}  </label>
                  <div class="col-sm-10">
							<select id = "createvehicle_fuel" class = "form-control" name ="createvehicle_fuel" >
								<option value="0" <?php 
									if($flag){
										if($vehicle->fuel == "0") echo "selected";
									}
									else{
										if(old('createvehicle_fuel')  == "0") echo "selected";
									}	
									 ?>>   {{trans('app.all')}}  </option>	
									<option value="1" <?php
										 if($flag){
											if($vehicle->fuel == "1") echo "selected";
										 }
										 else{
											if(old('createvehicle_fuel')  == "1") echo "selected";
										 }
								?>>  {{trans('app.green_fuel')}}  </option>	
								<option value="2" <?php 
										if($flag)
										{
											if($vehicle->fuel == "2") echo "selected";
										}
										else{
											if(old('createvehicle_fuel')  == "2") echo "selected";
										}
								 ?>>  {{trans('app.red_fuel')}}  </option>	
								<option value="3" <?php
									 if($flag) {
										 if($vehicle->fuel == "3") echo "selected";
									 }
									 else{
										 if(old('createvehicle_fuel')  == "3") echo "selected";
									 }
									 
									  ?>>   {{trans('app.diesel')}}  </option>	
							</select>

							@if ($errors->has('createvehicle_fuel'))
								<span class="help-block">
									<strong>{{ $errors->first('createvehicle_fuel')}}</strong>
								</span>
							@endif


                  </div>
                </div>
								
				 <!-- div class="form-group col-sm-12 required">
                  <label for="services" class="col-sm-2 control-label">  {{trans('app.services')}}   </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="services" name = "services" placeholder="{{trans('app.services')}}" value = "<?php 
							if($flag) echo $vehicle->services; 
						    else echo  old("services");
							?>" readonly  onfocus="this.removeAttribute('readonly');">
								@if ($errors->has('services'))
										<span class="help-block">
											<strong>{{ $errors->first('services')}}</strong>
										</span>
								@endif
					</div>
                </div -->

				<input style="display:none" type="text" name="fakeusernameremembered"/>
				<input style="display:none" type="password" name="fakepasswordremembered"/>


				<div class="form-group col-sm-12 required">
                  <label for="createvehicle_oil" class="col-sm-2 control-label">    {{trans('app.password')}}  </label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" placeholder = "{{trans('app.password')}}" id="createvehicle_password" readonly  onfocus="this.removeAttribute('readonly');"   name = "createvehicle_password">
  
					 	@push('scripts')
						 			<style>
										#services[readonly], #createvehicle_password[readonly] {
											background-color: #fff;
											opacity: 1;
										}
									</style>
									 
								@endpush
		
						@if ($errors->has('createvehicle_password'))
								<span class="help-block">
									<strong>{{ $errors->first('createvehicle_password')}}</strong>
								</span>
						@endif
					</div>
                </div>

				
				<div class="form-group col-sm-12 required">
                    <label for="createvehicle_oil" class="col-sm-2 control-label">    {{trans('app.city')}}  </label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="createvehicle_city" name = "createvehicle_city" placeholder="{{trans('app.city')}}" value = "<?php 
								if($flag) echo $vehicle->city; 
								else    echo old("createvehicle_city");
								?>">
											@if ($errors->has('createvehicle_city'))
														<span class="help-block">
															<strong>{{ $errors->first('createvehicle_city')}}</strong>
														</span>
												@endif
									</div>
                </div>
 
				<div class="form-group col-sm-12 required">
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
											<option value="{{$state->zone_id}}"  <?php if($state->zone_id == old('createvehicle_state')) echo "selected";  ?> >{{$state->name}}</option>
										@endforeach
								
								@endif
							</select>

								@if ($errors->has('createvehicle_state'))
										<span class="help-block">
											<strong>{{ $errors->first('createvehicle_state')}}</strong>
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
				
				
				<div class = "col-xs-12 text-center">
					<button type="submit" class="btn btn-warning">
						 {{trans('app.apply')}}
					</button>
					<a href = "{{URL::to('/user/vehicles')}}" class="btn btn-warning">
						 {{trans('app.cancel')}}
					</a>
				</div> 
			</form>   
		</div>
		 </div>
		<br>
	</div>
		</div>
		@push('scripts')
			<script>
			$(document).on( "keypress", ".licenseplate",  function(){
					$(this).val("");
				    var $canfocus = $('.licenseplate');
					var index = $canfocus.index(this) + 1;
					if (index >= $canfocus.length) index = 0;
					$canfocus.eq(index).focus();
			});
			</script>
		@endpush
@endsection