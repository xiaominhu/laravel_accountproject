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
			<form  action="/admin/users/addnewemployee" method="post" enctype="multipart/form-data">	
				{{csrf_field()}}
				<div class = "row">
						<div class="form-group text-center">
							
							<img src = "/images/default-user.png" height = "200"> 
							
						</div>
						<div class="form-group">
							<label for="picture" >Picture</label>
							<input id="picture" type = "file" class="form-control border-primary" name="picture"></input>
						</div>
						
						
						<div class="form-group col-sm-12">
						  <label for="first_name" class="col-sm-2 control-label">   {{trans('app.first_name')}}   </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="first_name" name = "first_name" placeholder="" value = "">
						  </div>
						</div>
						
						
						<div class="form-group col-sm-12">
						  <label for="last_name" class="col-sm-2 control-label">  {{trans('app.last_name')}}   </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="last_name" name = "last_name" placeholder="" value = "">
						  </div>
						</div>
						
						
						<div class="form-group col-sm-12">
						  <label for="email" class="col-sm-2 control-label">   {{trans('app.email')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="email" name = "email" placeholder="" value = "">
						  </div>
						</div>
					
						
						<div class="form-group col-sm-12">
						  <label for="phone" class="col-sm-2 control-label">  {{trans('app.phone')}}  </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="phone" name = "phone" placeholder="" value = "">
						  </div>
						</div>
						
						<div class="form-group col-sm-12">
						  <label for="createvehicle_state" class="col-sm-2 control-label"> {{trans('app.state')}}  </label>
						  <div class="col-sm-10">
								<select id = "createvehicle_state" class = "form-control" name ="state" >
									<option value=""> --  {{trans('app.choose_state')}} -- </option>
									
									
								</select>
						  </div>
						</div>
						
						<div class="form-group col-sm-12">
						  <label for="createvehicle_coutry" class="col-sm-2 control-label"> {{trans('app.country')}}   </label>
						  <div class="col-sm-10">
								<select id = "createvehicle_coutry" class = "form-control" name ="country" >
									<option value=""> -- {{trans('app.choose_country')}}  -- </option>	
									@foreach($countries as $country)
										<option value="{{$country->country_id}}">{{$country->name}}</option>
									@endforeach
								</select>
						  </div>
						</div>
						
						<div class="form-group col-sm-12">
							  <label for="role" class="col-sm-2 control-label">   {{trans('app.role')}}   </label>
							  <div class="col-sm-10">
									<select id="createemployee_role" class = "form-control" multiple="multiple" name ="role[]" >
											<option value="1">   {{trans('app.manager_users')}}   </option>
											<option value="2">   {{trans('app.manager_paymentmethods')}} </option>
											<option value="3">   {{trans('app.manager_fees')}}  </option>
											<option value="4">   {{trans('app.manager_operation_deposit')}} </option>
											<option value="5">   {{trans('app.manager_operations')}}</option>
											<option value="6">   {{trans('app.withdrawls')}} </option>
											<option value="7">   {{trans('app.manager_notifications')}} </option>
									</select>
							  </div>
						</div>
				
						<div class="form-group col-sm-12">
						  <label for="password" class="col-sm-2 control-label">  {{trans('app.new_password')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="password" name = "password" placeholder="" value = "">
						  </div>
						</div>
						
						
						<div class="form-group col-sm-12">
						  <label for="password_confirmation" class="col-sm-2 control-label">   {{trans('app.confirm_password')}}  </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="password_confirmation" name = "password_confirmation" placeholder="" value = "">
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
		<script>
			employee_role = 1;
		</script>
		
@endsection