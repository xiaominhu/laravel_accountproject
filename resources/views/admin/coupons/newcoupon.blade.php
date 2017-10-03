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
					<label for="createvehicle_oil" class="col-sm-2 control-label"> Code </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" readonly id="code" name = "code" placeholder="" value = "<?php if($flag) echo $coupon->code;  ?>">
					</div>
				</div>
				
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_oil" class="col-sm-2 control-label"> Fuel Station </label>
                  <div class="col-sm-10">
                    
					<select id="fuelstation_id" class = "form-control" name ="fuelstation_id" >
							<option value="0" > All </option>	
						   @foreach($fuelstations as $fuelstation)
								<option value="{{$fuelstation->id}}"> {{$fuelstation->name}} </option>	
						   @endforeach
					</select>
                  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="emailtemplate_config_subject" class="col-sm-2 control-label"> Limite Date </label>
				  <div class="col-sm-10 form-group">
						 <div class='input-group date' id='limit_date'>
								<input type='text' class="form-control" name = "limit_date" value = "" />
								<span class="input-group-addon">
									<i class="icon-calendar"></i>
								</span>
						 </div>
				  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_oil" class="col-sm-2 control-label"> Limite Number Of Users </label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="limit_users" name = "limit_users" placeholder="" value = "<?php if($flag) echo $coupon->limit_users;  ?>">
                  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_oil" class="col-sm-2 control-label"> Amount </label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" id="amount" name = "amount" placeholder="" value = "<?php if($flag) echo $coupon->amount;  ?>">
                  </div>
                </div>
				
								   
				<div class="form-group col-sm-12">
                  <label for="createvehicle_oil" class="col-sm-2 control-label"> Type </label>
                  <div class="col-sm-10">
					<select id="type" class = "form-control"  name ="type" >
							<option value="1" <?php  if($flag) 
								if($coupon->type == "1") echo 'selected';
							   ?> >  Percent </option>	
							<option value="0" <?php  if($flag) 
								if($coupon->type == "0") echo 'selected';
							   ?>>  Fixed </option>	
					</select>
                  </div>
                </div>
				<div class = "col-xs-4 pull-right">
					<button type="submit" class="btn btn-primary">
						Apply
					</button>
					
					<a href = "/admin/coupons" class="btn btn-primary">
						Cancel
					</a>
					
				</div>
			</form>  				
		</div>
		
		<script>
			coupon_create  = 1;
			var default_sart  = "<?php if(isset($coupon))  echo  $coupon->limit_date  ?>"
		</script>

@endsection