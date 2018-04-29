@extends('layouts.user')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
		 
				
				@if($message != "")
					 <div class="alert alert-success">
						{{$message}}
				   </div>
				@endif
				 
			<br/>

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
			<form  action="/user/usersettings" method="post" enctype="multipart/form-data">	
				{{csrf_field()}}
				<div class = "row">
						<div class="form-group text-center">
							@if($user->picture)
								<img src = "/images/userprofile/{{$user->picture}}" height = "200"> 
							@else
								<img src = "/images/default-user.png" height = "200"> 
							@endif
						</div>
						<div class="form-group col-sm-12">
							<label for="userinput8" > {{trans('app.picture')}} </label>
							<input id="content" type = "file" class="form-control border-primary " name="picture"></input>
						</div>
						 
						<div class="form-group col-sm-12 required">
						  <label for="createvehicle_oil" class="col-sm-2 control-label">  {{trans('app.name')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="name" name = "name" placeholder="{{trans('app.name')}}" value = "{{$user->name}}">

											@if ($errors->has('name'))
												<span class="help-block">
													<strong>{{ $errors->first('name')}}</strong>
												</span>
											@endif


						  </div>
						</div>
						 
						
						<div class="form-group col-sm-12 required">
						  <label for="createvehicle_oil" class="col-sm-2 control-label"> {{trans('app.email')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="email" name = "email" placeholder="{{trans('app.email')}}" value = "{{$user->email}}" >

											@if ($errors->has('email'))
												<span class="help-block">
													<strong>{{ $errors->first('email')}}</strong>
												</span>
											@endif


						  </div>
						</div>
						
						<div class="form-group col-sm-12">
						  <label for="createvehicle_oil" class="col-sm-2 control-label">   {{trans('app.no')}}  </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" readonly id="no" name = "no" placeholder="" value = "{{$user->no}}">
						  </div>
						</div>
						
						
						<div class="form-group col-sm-12 required">
						  <label for="createvehicle_oil" class="col-sm-2 control-label"> {{trans('app.phone')}} </label>
						  <div class="col-sm-10">
						 
							<div class="intl-tel-input allow-dropdown">
									<div class="flag-container">
										<div class="selected-flag" tabindex="0">
											<div class="iti-flag sa"> </div> 
											<div class="iti-arrow1">(+966)</div>
										</div>
									</div>
										<input id="phone"  class="form-control" name = "phone"   type="tel" autocomplete="off" value = "<?php
										
											if(old('phone')  !== null) echo old('phone');
											else     echo $user->phone;
										?>" placeholder = "{{trans('app.phone')}}">
							    </div>
							

						  </div>
						</div>
						
						<div class="form-group col-sm-12">
						  <label for="createvehicle_state" class="col-sm-2 control-label"> {{trans('app.state')}} </label>
						  <div class="col-sm-10">
								<select id = "createvehicle_state" class = "form-control" name ="state" >
									<option value=""> --{{trans('app.choose_state')}} -- </option>
									
									@foreach($states as $state)
										@if($user->state == $state->zone_id)
											<option  selected  value="{{$state->zone_id}}"> {{$state->name}} </option>
										@else
											<option value="{{$state->zone_id}}">{{$state->name}}</option>
										@endif
									@endforeach
								</select>
						  </div>
						</div>
						
						<div class="form-group col-sm-12">
						  <label for="createvehicle_coutry" class="col-sm-2 control-label"> Country </label>
						  <div class="col-sm-10">
								<select id = "createvehicle_coutry" class = "form-control" disabled = "disabled" name ="country" >
									  <option value=""> -- {{trans('app.choose_country')}}-- </option>	
												@foreach($countries as $country)
													@if($country->country_id == '184')
														<option  selected value="{{$country->country_id}}">{{$country->name}}</option>
													@else
														<option value="{{$country->country_id}}">{{$country->name}}</option>
													@endif
												@endforeach
								</select>
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
					<br>
	 	 </form>	
				</div>
		</div>
								</div>
					</div>
		</div>


	@push('scripts')
				<link href="{{ URL::asset('app-assets/build/css/intlTelInput.css') }}" rel="stylesheet" type="text/css">
				 <style>
						.iti-arrow1{
							position: absolute;
							margin-top: 3px;
							right: 6px;
							width: 0;
							height: 0;
							border-top: 4px solid #555;
						}

					 
				</style>
		@endpush
		</div>
@endsection