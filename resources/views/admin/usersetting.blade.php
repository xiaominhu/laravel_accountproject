@extends('layouts.admin')

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
				
				@if($message != "")
					 <div class="alert alert-success">
						{{$message}}
				   </div>
				@endif
				
			<br/>
			<br/>
			<form  action="/admin/usersettings" method="post" enctype="multipart/form-data">	
				{{csrf_field()}}
				<div class = "row">
						<div class="form-group text-center">
							@if($user->picture)
								<img src = "/images/userprofile/{{$user->picture}}" height = "200"> 
							@else
								<img src = "/images/default-user.png" height = "200"> 
							@endif
						</div>
						<div class="form-group">
							<label for="userinput8" >  {{trans('app.picture')}}</label>
							<input id="content" type = "file" class="form-control border-primary" name="picture"></input>
						</div>
						
						
						<div class="form-group col-sm-12">
						  <label for="createvehicle_oil" class="col-sm-2 control-label"> {{trans('app.first_name')}}  </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="first_name" name = "first_name" placeholder="" value = "{{$user->first_name}}">
						  </div>
						</div>
						
						
						<div class="form-group col-sm-12">
						  <label for="createvehicle_oil" class="col-sm-2 control-label">  {{trans('app.last_name')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="last_name" name = "last_name" placeholder="" value = "{{$user->last_name}}">
						  </div>
						</div>
						
						
						<div class="form-group col-sm-12">
						  <label for="createvehicle_oil" class="col-sm-2 control-label">  {{trans('app.email')}}  </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="email" name = "email" placeholder="" value = "{{$user->email}}">
						  </div>
						</div>
						
						<div class="form-group col-sm-12">
						  <label for="createvehicle_oil" class="col-sm-2 control-label">  {{trans('app.no')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" readonly id="id" name = "id" placeholder="" value = "{{$user->no}}">
						  </div>
						</div>
						
						
						<div class="form-group col-sm-12">
						  <label for="createvehicle_oil" class="col-sm-2 control-label">   {{trans('app.phone')}}  </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="phone" name = "phone" placeholder="" value = "{{$user->phone}}">
						  </div>
						</div>
						
						<div class="form-group col-sm-12">
						  <label for="createvehicle_state" class="col-sm-2 control-label">  {{trans('app.state')}} </label>
						  <div class="col-sm-10">
								<select id = "createvehicle_state" class = "form-control" name ="state" >
									<option value=""> -- {{trans('app.choose_state')}} -- </option>
									
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
						  <label for="createvehicle_coutry" class="col-sm-2 control-label">  {{trans('app.country')}} </label>
						  <div class="col-sm-10">
								<select id = "createvehicle_coutry" class = "form-control" name ="country"  disabled = "disabled">
									<option value=""> -- {{trans('app.choose_country')}} -- </option>	
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
						<button type="submit" class="btn btn-primary  float-xs-right" style = "margin-right:50px;">
						   <i class="icon-paper-plane-o"></i>
							    {{trans('app.apply')}}
						</button>
					</div>
				</div>
	 	 </form>	
				
				
			
		
		
		</div>
@endsection