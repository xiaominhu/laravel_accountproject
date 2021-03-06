@extends('layouts.seller')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			 
			@if(isset($sellercoupon))
				<form class="form-horizontal" method = "post" action="/seller/coupons/update/{{$sellercoupon->id}}">
			@else
				<form class="form-horizontal" method = "post" action="/seller/coupons/create">
			@endif`
				{{csrf_field()}}
				
			 
					
					<div class="form-group col-sm-12">
						<label for="emailtemplate_config_subject" class="col-sm-2 control-label"> {{trans('app.code')}}  </label>
						<div class="col-sm-10">
						@if(isset($sellercoupon))
							<input type="text" class="form-control" id="code" name = "code" placeholder="" value = "{{$sellercoupon->code}}">
						@else
						    <input type="text" class="form-control" id="code" name = "code" placeholder="" value = " 3dd">
						@endif`

							 @if ($errors->has('code'))
									<span class="help-block">
										<strong>{{ $errors->first('code')}}</strong>
									</span>
							@endif
						</div>
					</div>
		 
					
			
				
				
				<div class="form-group col-sm-12">
					  <label for="type" class="col-sm-2 control-label"> {{trans('app.type')}}  </label>
					  <div class="col-sm-10">
							<select id = "type" class = "form-control" name ="type" >
								  <option value=""  <?php if(!isset($sellercoupon)) echo 'selected'; ?> > Choose Type </option>	
								  <option value="0"  <?php if(isset($sellercoupon))  if(!$sellercoupon->status) echo 'selected'; ?> >   {{trans('app.percentage')}}   </option>	
								  <option value="1"  <?php if(isset($sellercoupon))  if($sellercoupon->status) echo 'selected'; ?>> Fixed </option>
							</select>
							 @if ($errors->has('type'))
									<span class="help-block">
										<strong>{{ $errors->first('type')}}</strong>
									</span>
							@endif
					  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="emailtemplate_config_subject" class="col-sm-2 control-label">  {{trans('app.amount')}} </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="amount" name = "amount" placeholder="" value = "<?php if(isset($sellercoupon)) echo $sellercoupon->amount ?>">
                  </div>
                </div>
				
				
				<div class="form-group col-sm-12">
                  <label for="emailtemplate_config_subject" class="col-sm-2 control-label">   {{trans('app.start_date')}}  </label>
				  <div class="col-sm-10 form-group">
						 <div class='input-group date' id='startdate'>
								<input type='text' class="form-control" name = "startdate" value = "" />
								<span class="input-group-addon">
									<i class="icon-calendar"></i>
								</span>
						 </div>

						    @if ($errors->has('start_date'))
									<span class="help-block">
										<strong>{{ $errors->first('start_date')}}</strong>
									</span>
							@endif
				  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="emailtemplate_config_subject" class="col-sm-2 control-label">  {{trans('app.end_date')}} </label>
                  <div class="col-sm-10 form-group">
						<div class='input-group date' id='enddate'>
							<input type='text' class="form-control" name = "enddate" value = "" />
							<span class="input-group-addon">
									<i class="icon-calendar"></i>
							</span>
						</div>

						    @if ($errors->has('end_date'))
									<span class="help-block">
										<strong>{{ $errors->first('end_date')}}</strong>
									</span>
							@endif


					</div>
                </div>
				
				<div class = "col-xs-4 pull-right">
					<button type="submit" class="btn btn-primary">
						 {{trans('app.apply')}}
					</button>
					
					<a href = "{{route('sellercoupons')}}" class="btn btn-primary">
						 {{trans('app.cancel')}}
					</a>
					
				</div>
			</form>  				
		</div>
		
	<script>
		coupon_create = 1;
		var default_sart  = "<?php if(isset($sellercoupon))  echo  $sellercoupon->startdate  ?>"
		var default_end   = "<?php if(isset($sellercoupon))  echo  $sellercoupon->enddate  ?>"
	</script>
@endsection