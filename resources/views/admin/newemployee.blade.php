@extends('layouts.admin')

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
			<br/>
			<?php  

					if(isset($user)) $flag = 1;
					else $flag = 0;

			?>

			@if($flag)
					  <form  action="/admin/users/updateemployee/{{$user->no}}" method="post" enctype="multipart/form-data">
			@else
						<form  action="/admin/users/addnewemployee" method="post" enctype="multipart/form-data">
			@endif

				{{csrf_field()}}
				<div class = "">
						<div class="form-group text-center col-sm-12">
							
							<img src = "/images/default-user.png" height = "120"> 
							
						</div>
						<div class="form-group">
							<label for="picture" >Picture</label>
							<input id="picture" type = "file" class="form-control border-primary" name="picture"></input>
								@if ($errors->has('picture'))
									<span class="help-block">
										<strong>{{ $errors->first('picture') }}</strong>
									</span>
								@endif
						</div>
						 
						<div class="form-group col-sm-12 required">
						  <label for="name" class="col-sm-2 control-label">   {{trans('app.name')}}   </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="name" name = "name" placeholder=" {{trans('app.name')}}" value = "<?php
											if(old('name')  !== null) echo old('name');
											elseif($flag) echo $user->name;
							?>">
								
								
								@if ($errors->has('name'))
									<span class="help-block">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
								@endif
						  </div>
						</div>
						
						<div class="form-group col-sm-12 required">
						  <label for="email" class="col-sm-2 control-label">   {{trans('app.email')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="email" name = "email" placeholder="{{trans('app.email')}}" value = "<?php
										
											if(old('email')  !== null) echo old('email');
											elseif($flag) echo $user->email;
							?>">
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
										<input id="phone"  class="form-control" name = "phone" placeholder = "{{trans('app.phone')}}"   type="tel" autocomplete="off" value = "<?php
										
											if(old('phone')  !== null) echo old('phone');
											elseif($flag) echo $user->phone;
							?>">
							    </div>
 
									@if ($errors->has('phone'))
										<span class="help-block">
											<strong>{{ $errors->first('phone') }}</strong>
										</span>
							  	    @endif
						  </div>
						</div>
						
						<div class="form-group col-sm-12">
						  <label for="createvehicle_state" class="col-sm-2 control-label"> {{trans('app.state')}}  </label>
						  <div class="col-sm-10">
								<select id = "createvehicle_state" class = "form-control" name ="state" >
									 <option value=""> --  {{trans('app.choose_state')}} -- </option>
									
										@foreach($states as $state)

											@if((old('state') !== null))
													@if(old('state') == $state->zone_id)
															<option value="{{$state->zone_id}}" selected> {{$state->name}}  </option>
													@else
															<option value="{{$state->zone_id}}"> {{$state->name}}  </option>
													@endif
											@elseif($flag)
													@if( $user->state == $state->zone_id)
															<option value="{{$state->zone_id}}" selected> {{$state->name}}  </option>
													@else
															<option value="{{$state->zone_id}}"> {{$state->name}}  </option>
													@endif
											@else
													<option value="{{$state->zone_id}}"> {{$state->name}}  </option>
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
						  <label for="createvehicle_coutry" class="col-sm-2 control-label"> {{trans('app.country')}}   </label>
						  <div class="col-sm-10">
								<select id = "createvehicle_coutry" class = "form-control" name ="country" disabled = "disabled">
									<option value=""> -- {{trans('app.choose_country')}}  -- </option>	
									@foreach($countries as $country)
										@if($country->country_id == '184')
												<option value="{{$country->country_id}}" selected>{{$country->name}}</option>
										@else
												<option value="{{$country->country_id}}">{{$country->name}}</option>
										@endif
									@endforeach
								</select>
									@if ($errors->has('country'))
										<span class="help-block">
											<strong>{{ $errors->first('country') }}</strong>
										</span>
							  	@endif  
						  </div>
						</div>

					<?php
						$userflag = 1;
						if($flag)
							if($user->usertype != '6')  $userflag = 0;
					?>

					@if($userflag)	 
						<div class="form-group col-sm-12 required">
							  <label for="role" class="col-sm-2 control-label">   {{trans('app.role')}}   </label>
							  <div class="col-sm-10">
									<select id="createemployee_role" class = "form-control" multiple="multiple" name ="role[]" >
									   	 
											<option value="13" <?php 
														if( null !==  old('role')){
															 if(in_array( '13', old('role'))){
																 echo "selected";
															 }
														}elseif($flag){
																if( $user->m_main == '1'){
																 echo "selected";
															  }
														}
												?> >  {{trans('app.main_page')}} </option>
											<option value="14" <?php 
														if( null !==  old('role')){
															 if(in_array( '14', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_map == '1'){
																 echo "selected";
															  }
														}
												?> > {{trans('app.maps')}}  </option>
											<option value="1" <?php 
														if( null !==  old('role')){
															 if(in_array( '1', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_user == '1'){
																 echo "selected";
															  }
														}
												?> >   {{trans('app.manager_users')}}  </option>

											<option value="2" <?php 
														if( null !==  old('role')){
															 if(in_array( '2', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_pay == '1'){
																 echo "selected";
															  }
														}
												?> >    {{trans('app.manager_paymentmethods')}}  </option>
											
											<option value="3" <?php 
														if( null !==  old('role')){
															 if(in_array( '3', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_fee == '1'){
																 echo "selected";
															  }
														}
												?> >     {{trans('app.manager_fees')}}  </option>
										 	<option value="4" <?php 
														if( null !==  old('role')){
															 if(in_array( '4', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_dep == '1'){
																 echo "selected";
															  }
														}
												?> >    {{trans('app.manager_operation_deposit')}}  </option>
								 			<!-- option value="5" <?php 
														if( null !==  old('role')){
															 if(in_array( '5', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_cup == '1'){
																 echo "selected";
															  }
														}
												?> >  {{trans('app.coupons')}}  </option -->

											<option value="6" <?php 
														if( null !==  old('role')){
															 if(in_array( '6', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_wir == '1'){
																 echo "selected";
															  }
														}
												?> >   {{trans('app.withdrawls')}}  </option>

											<option value="7" <?php 
														if( null !==  old('role')){
															 if(in_array( '7', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_not == '1'){
																 echo "selected";
															  }
														}
												?> >   {{trans('app.manager_notifications')}} </option>
 
										 		<option value="8" <?php 
														if( null !==  old('role')){
															 if(in_array( '8', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_mes == '1'){
																 echo "selected";
															  }
														}
												?> >   {{trans('app.messages')}} </option>

										 	<option value="9" <?php 
														if( null !==  old('role')){
															 if(in_array( '9', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_rep == '1'){
																 echo "selected";
															  }
														}
												?> > {{trans('app.reports')}} </option>
											
												<option value="10" <?php 
														if( null !==  old('role')){
															 if(in_array( '10', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_gtc == '1'){
																 echo "selected";
															  }
														}
												?> >    {{trans('app.get_in_touch')}}</option>

												<option value="11" <?php 
														if( null !==  old('role')){
															 if(in_array( '11', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_sub == '1'){
																 echo "selected";
															  }
														}
												?> >   {{trans('app.subscription_fee')}} </option>

												<option value="12" <?php 
														if( null !==  old('role')){
															 if(in_array( '12', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_atd == '1'){
																 echo "selected";
															  }
														}
												?> >   {{trans('app.attendances')}} </option>
												
												<!-- option value="15" <?php 
														if( null !==  old('role')){
															 if(in_array( '15', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_qrs == '1'){
																 echo "selected";
															  }
														}
												?> >   {{trans('app.qrstatus')}} </option -->


												<option value="16" <?php 
														if( null !==  old('role')){
															 if(in_array( '16', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_vrc == '1'){
																 echo "selected";
															  }
														}
												?> >   {{trans('app.redeem_voucher')}} </option>


												<option value="17" <?php 
														if( null !==  old('role')){
															 if(in_array( '17', old('role'))){
																 echo "selected";
															 }
														}
														elseif($flag){
																if( $user->m_udr == '1'){
																 echo "selected";
															  }
														}
												?> >   {{trans('app.deposit_for_user')}} </option>


									</select>
										@if ($errors->has('role'))
											<span class="help-block">
												<strong>{{ $errors->first('role') }}</strong>
											</span>
										@endif
							  </div>
						</div>

						<div class="form-group col-sm-12 required">
						  <label for="password" class="col-sm-2 control-label">  {{trans('app.new_password')}} </label>
						  <div class="col-sm-10">
							<input type="password" class="form-control" id="password" name = "password" placeholder="{{trans('app.password')}}" value = "{{old('password')}}">
									@if ($errors->has('password'))
											<span class="help-block">
												<strong>{{ $errors->first('password') }}</strong>
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
					@endif
				 
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
							margin-top: 1px;
							right: 6px;
							width: 0;
							height: 0;
							
							border-top: 4px solid #555;
						}
						
					.sa .iti-arrow1{
							position: absolute;
							margin-top: 1px;
							left: 16px;
							right: auto;
							width: 0;
							height: 0;
							border-top: 4px solid #555;
						}
				</style>
				 
		@endpush
		
@endsection