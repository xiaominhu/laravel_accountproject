@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			<?php
				$flag = isset($coupon) ? 1 : 0;
			?>
				@if($errors->any())
				   <div class="alert alert-warning">
						 <ul>
							   @foreach ($errors->all() as $error)
								  <li>{{ $error }}</li>
							  @endforeach
						  </ul>
				  </div>
				@endif
			
			@if($flag)
				<form class="form-horizontal" method = "post" action="/admin/coupons/update/{{$coupon->id}}">
			@else
				<form class="form-horizontal" method = "post" action="/admin/coupons/create">
			@endif
				{{csrf_field()}}
			
				<div class="form-group col-sm-12">
					<label for="createvehicle_oil" class="col-sm-2 control-label">    {{trans('app.code')}}</label>
					<div class="col-sm-10">
						<input type="text" class="form-control"  id="code" name = "code" placeholder="" value = "<?php 
							if($flag)
								echo $coupon->code;  
							else
								echo $code;
						?>">

						@if ($errors->has('code'))
								<span class="help-block">
									<strong>{{ $errors->first('code') }}</strong>
								</span>
						@endif


					</div>
				</div> 
				 
				<div class="form-group col-sm-12">
                  <label for="emailtemplate_config_subject" class="col-sm-2 control-label">    {{trans('app.limit_date')}}  </label>
				  <div class="col-sm-10 form-group">
						 <div class='input-group date' id='limit_date'>
								<input type='text' class="form-control" name = "limit_date" value = "" />
								<span class="input-group-addon">
									<i class="icon-calendar"></i>
								</span>

								@if ($errors->has('limit_date'))
										<span class="help-block">
											<strong>{{ $errors->first('limit_date') }}</strong>
										</span>
								@endif
						 </div>
				  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_oil" class="col-sm-2 control-label">    {{trans('app.limit_number_users')}}  </label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="limit_users" name = "limit_users" placeholder="" value = "<?php if($flag) echo $coupon->limit_users;  ?>">
                  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_oil" class="col-sm-2 control-label">  {{trans('app.amount')}}  </label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="amount" name = "amount" placeholder="" value = "<?php if($flag) echo $coupon->amount;  ?>">
                  </div>
                </div>
				
								   
				<div class="form-group col-sm-12">
                  <label for="createvehicle_oil" class="col-sm-2 control-label">  {{trans('app.type')}}  </label>
                  <div class="col-sm-10">
					<select id="type" class = "form-control"  name ="type" >
							<option value="1" <?php  if($flag) 
								if($coupon->type == "1") echo 'selected';
							   ?> >  {{trans('app.percentage')}}   </option>	
							<option value="0" <?php  if($flag) 
								if($coupon->type == "0") echo 'selected';
							   ?>>  {{trans('app.fixed')}}   </option>	
					</select>
								@if ($errors->has('type'))
										<span class="help-block">
											<strong>{{ $errors->first('type') }}</strong>
										</span>
								@endif


                  </div>
                </div>
				<div class = "col-xs-4 pull-right">
					<button type="submit" class="btn btn-primary">
						  {{trans('app.apply')}}
					</button>
					
					<a href = "/admin/coupons" class="btn btn-primary">
						   {{trans('app.cancel')}}
					</a>
					
				</div>
			</form>  				
		</div>
		
		<script>
			coupon_create  = 1;
			var default_sart  = "<?php if(isset($coupon))  echo  $coupon->limit_date  ?>"
		</script>

@endsection