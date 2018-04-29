@extends('layouts.seller')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->

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
						   
			 		@if(Session::has('success'))
						<div class="alert alert-success">
								 {{trans('app.success')}} 
						</div>
					@endif
			<br/>
			<form  action="/seller/workers/create" method="post" enctype="multipart/form-data">	
				{{csrf_field()}}
				<div class = "row">
						<div class="form-group text-center">
							<img src = "/images/default-user.png" height = "200"> 
						</div>
						<div class="form-group">
							<label for="picture" >Picture</label>
							<input id="picture" type = "file" class="form-control border-warning" name="picture"></input>
								@if ($errors->has('picture'))
									<span class="help-block">
										<strong>{{ $errors->first('picture') }}</strong>
									</span>
								@endif
						</div>
						
						
						<div class="form-group col-sm-12 required">
						  <label for="first_name" class="col-sm-2 control-label">   {{trans('app.first_name')}}   </label>
						  <div class="col-sm-10">
								<input type="text" class="form-control" id="first_name" name = "first_name" placeholder="{{trans('app.first_name')}}" value = "{{old('first_name')}}">
									@if ($errors->has('first_name'))
										<span class="help-block">
											<strong>{{ $errors->first('first_name') }}</strong>
										</span>
									@endif
						  </div>
						</div>
						
						
						<div class="form-group col-sm-12 required">
						  <label for="last_name" class="col-sm-2 control-label">  {{trans('app.last_name')}}   </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="last_name" name = "last_name" placeholder="{{trans('app.last_name')}}" value = "{{old('last_name')}}">
									@if ($errors->has('last_name'))
										<span class="help-block">
											<strong>{{ $errors->first('last_name') }}</strong>
										</span>
									@endif
						  </div>
						</div>
						
						
						<div class="form-group col-sm-12 required">
						  <label for="email" class="col-sm-2 control-label">   {{trans('app.email')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="email" name = "email" placeholder="{{trans('app.email')}}" value = "{{old('email')}}">
									@if ($errors->has('email'))
										<span class="help-block">
											<strong>{{ $errors->first('email') }}</strong>
										</span>
									@endif
						  </div>
						</div>
 
					  
							<div class="form-group col-sm-12 required">
									<label for="phone" class="col-sm-2 control-label">  {{trans('app.phone')}}  </label>
									<div class="col-sm-10">
									
									
									<div class="intl-tel-input allow-dropdown">
												<div class="flag-container">
													<div class="selected-flag" tabindex="0">
														<div class="iti-flag sa"> </div> 
														<div class="iti-arrow1">(+966)</div>
													</div>
												</div>
													<input id="phone"  class="form-control" id="phone" name = "phone"   type="tel" autocomplete="off" value = "{{old('phone')}}"
													 placeholder = " {{trans('app.phone')}}">
												</div>
													@if ($errors->has('phone'))
														<span class="help-block">
															<strong>{{ $errors->first('phone') }}</strong>
														</span>
													@endif
									</div>
							</div>
							
							
					<div class="form-group col-sm-12 required">
						<label for="role" class="col-sm-2 control-label">  {{trans('app.fuelstation')}}   </label>
						<div class="col-sm-10">
								<select id="createvehicle_fuelstation1" class = "form-control" multiple="multiple" name ="fuelstation[]" >
									@foreach($fuelstations as $fuelstation)
										<option value="{{$fuelstation->no}}"  data-state = "{{$fuelstation->state}}"  >{{$fuelstation->name}}</option>
									@endforeach
								</select>  
								
								@if($errors->has('fuelstation'))
									<span class="help-block">
										<strong>{{ $errors->first('fuelstation') }}</strong>
									</span>
								@endif
						</div>
					</div>
				
				

					<!-- div class="form-group col-sm-12">
						  <label for="createvehicle_state" class="col-sm-2 control-label"> {{trans('app.fuelstation')}}  </label>
						  <div class="col-sm-10">
								<select id = "createvehicle_fuelstation" class = "form-control" name ="fuelstation" >
									<option value="">  {{trans('app.all')}} </option>
										@foreach($fuelstations as $fuelstation)
												@if(old('fuelstation') == $fuelstation->no)
													<option value="{{$fuelstation->no}}"  data-state = "{{$fuelstation->state}}"  selected>{{$fuelstation->name}}</option>
												@else 
													<option value="{{$fuelstation->no}}"  data-state = "{{$fuelstation->state}}"  >{{$fuelstation->name}}</option>
												@endif
										@endforeach
								</select>
									@if ($errors->has('fuelstation'))
										<span class="help-block">
											<strong>{{ $errors->first('fuelstation') }}</strong>
										</span>
									@endif
						  </div>
					</div -->
 
						<div class="form-group col-sm-12">
						  <label for="createvehicle_state" class="col-sm-2 control-label"> {{trans('app.state')}}  </label>
						  <div class="col-sm-10">
								<select id = "createvehicle_state" class = "form-control" name ="state" >
									<option value="">  {{trans('app.all')}} </option>
										@foreach($states as $state)
												@if( old('state') == $state->zone_id)
													<option value="{{$state->zone_id}}" selected>{{$state->name}}</option>
												@else
													<option value="{{$state->zone_id}}">{{$state->name}}</option>
												@endif
												
										@endforeach
								</select>
									@if ($errors->has('state'))
										<span class="help-block">
											<strong>{{ $errors->first('state') }}</strong>
										</span>
									@endif
						  </div>
						</div>
						
						<div class="form-group col-sm-12">
						  <label for="createvehicle_coutry" class="col-sm-2 control-label"> {{trans('app.country')}} </label>
						  <div class="col-sm-10">
								<select id = "createvehicle_coutry" disabled = "disabled" class = "form-control" name ="country" >
									<option value="0"> -- {{trans('app.choose_country')}}  -- </option>	
									@foreach($countries as $country)
									  @if($country->country_id == '184')
											<option value="{{$country->country_id}}" selected>{{$country->name}}</option>
										@else
											<option value="{{$country->country_id}}">{{$country->name}}</option>
										@endif
									@endforeach
								</select>

						  </div>
						</div>
						
						<div class="form-group col-sm-12 required">
							  <label for="role" class="col-sm-2 control-label">   {{trans('app.role')}}   </label>
							  <div class="col-sm-10">
									<select id="createemployee_role" class = "form-control" multiple="multiple" name ="role[]" >

								    @if(old('role') !== null)	    	 
											@if(in_array('1', old('role')))
													<option value="1" selected>   {{trans('app.manager_fuel_station')}}    </option>
											@else
													<option value="1">   {{trans('app.manager_fuel_station')}}    </option>
											@endif
									@else
										  <option value="1">   {{trans('app.manager_fuel_station')}}    </option>
									@endif
					 
									 @if(old('role') !== null)	    	 
											@if(in_array('2', old('role')))
											  	<option value="2" selected>   {{trans('app.reports')}} </option>
											@else
													<option value="2">   {{trans('app.reports')}} </option>
											@endif
									@else
										  		<option value="2">   {{trans('app.reports')}} </option>
									@endif

									 @if(old('role') !== null)	    	 
											@if(in_array('3', old('role')))
												 <option value="3" selected>   {{trans('app.coupons')}}  </option>
											@else
													<option value="3">   {{trans('app.coupons')}}  </option>
											@endif
									@else
										 	<option value="3">   {{trans('app.coupons')}}  </option>
									@endif
 
									@if(old('role') !== null)	    	 
											@if(in_array('4', old('role')))
												 <option value="4" selected>   {{trans('app.main_page')}}  </option>
											@else
													<option value="4">   {{trans('app.main_page')}}  </option>
											@endif
									@else
										 	<option value="4">   {{trans('app.main_page')}}  </option>
									@endif


									</select>
									
									@if($errors->has('role'))
										<span class="help-block">
											<strong>{{ $errors->first('role') }}</strong>
										</span>
									@endif
							  </div>
						</div>
				
						<div class="form-group col-sm-12 required">
						  <label for="password" class="col-sm-2 control-label">  {{trans('app.new_password')}} </label>
						  <div class="col-sm-10">
								<input type="password" class="form-control" id="password" name = "password" placeholder="{{trans('app.password')}}" value = "">
									@if($errors->has('password'))
										<span class="help-block">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
									@endif
						  </div>
						</div>
						
						
						<div class="form-group col-sm-12 required">
						  <label for="password_confirmation" class="col-sm-2 control-label">   {{trans('app.confirm_password')}}  </label>
						  <div class="col-sm-10">
							<input type="password" class="form-control" id="password_confirmation" name = "password_confirmation" placeholder="{{trans('app.password')}}" value = "">
						  </div>
						</div>
						 
				</div>	
				
				<div class = "row">
					<div class = "col-xs-12">
						<button type="submit" class="btn btn-warning  float-xs-right" style = "margin-right:50px;">
						   <i class="icon-paper-plane-o"></i>
							 {{trans('app.apply')}}  
						</button>
					</div>
				</div>
	 	 </form>	
			</div>
					</div>
				</div>
		</div>
		<script>
			employee_role = 1;
		</script>
							@push('scripts')
								<link href="{{ URL::asset('app-assets/build/css/intlTelInput.css') }}" rel="stylesheet" type="text/css">
								<style>
										.iti-arrow1{
											position: absolute;
											margin-top: 2px;
											right: 6px;
											width: 0;
											height: 0;
											border-top: 4px solid #555;
										}		
								</style>
 
							<script>
									$(document).on("change", "#createvehicle_state", function(event){
										//$("#createvehicle_fuelstation1").multiselect('destroy');
									  	init();
										$("#createvehicle_fuelstation").val("");
									});  
 
									function init(){
										if($("#createvehicle_state").val() != ""){
											item_id = $("#createvehicle_state").val();
											$("#createvehicle_fuelstation option").each(function(){
												$(this).show();
												if($(this).val() != "")
													if($(this).data("state") != item_id)
															$(this).hide();
											});
											
											/*
											$("#createvehicle_fuelstation1 option").each(function(){
												if($(this).val() != "")
													if($(this).data("state") != item_id)
															$(this).hide();
											});*/
										}
										
										$('#createvehicle_fuelstation1').multiselect('select', []);
									}
									init();
							</script>
						@endpush
 
		
@endsection