@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			<?php
				$flag = isset($voucher) ? 1 : 0;
			?>
				 
		<div class="row">
			<div class="col-xs-12">
				<div class="card">		
					<div class="card-header">
								<h4 class="card-title"> {{$title}}  </h4>
								<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
								<div class="heading-elements">
									<ul class="list-inline mb-0">
										<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
										<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
										<li><a data-action="close"><i class="icon-cross2"></i></a></li>
									</ul>
								</div>
							</div>
							<div class = "card-body">
								@if($flag)
		 							<form class="form-horizontal" method = "post" action="{{route('voucherupdate', $voucher->id)}}">
								@else
									<form class="form-horizontal" method = "post" action="{{URL::to('admin/vouchers/create')}}">
								@endif
									{{csrf_field()}}
								<br>
									<div class="form-group col-sm-12 required">
										<label for="createvehicle_oil" class="col-sm-3 control-label">    {{trans('app.code')}}</label>
										<div class="col-sm-9">
											<input type="text" class="form-control"  id="code" name = "code" placeholder="{{trans('app.code')}}" value = "<?php 
												if($flag)
													echo $voucher->code;  
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
									  <label for="emailtemplate_config_subject" class="col-sm-3 control-label">    {{trans('app.limit_date')}}  </label>
									  <div class="col-sm-9 form-group">
											 <div class='input-group date' id='limit_date'>
													<input type='text' class="form-control" name = "limit_date" value = ""  placeholder = "{{trans('app.limit_date')}}"/>
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
									 
									<div class="form-group col-sm-12 required">
										<label for="createvehicle_oil" class="col-sm-3 control-label">    {{trans('app.limit_number_users')}}  </label>
										<div class="col-sm-9">
											<input type="text" class="form-control" id="limit_users" name = "limit_users" placeholder="{{trans('app.limit_number_users')}}" value = "<?php if($flag) echo $voucher->limit_users;  ?>">
										</div>
									</div>

									<div class="form-group col-sm-12 required">
									  <label for="createvehicle_oil" class="col-sm-3 control-label">  {{trans('app.amount')}}  </label>
									  <div class="col-sm-9">
										<input type="text" class="form-control" id="amount" name = "amount" placeholder="{{trans('app.amount')}}" value = "<?php
											if(old('amount'))
												echo old('amount');
											else
												if($flag) echo $voucher->amount;  
											
										?>">
									  </div>
									</div>
									
									 
									<div class = "col-xs-12 text-center">
										<button type="submit" class="btn btn-warning">
											  {{trans('app.apply')}}
										</button>
										
										<a href = "{{route('vouchermanagement')}}" class="btn btn-warning">
											   {{trans('app.cancel')}}
										</a>
										
									</div>
								</form>
								<div class = "clearfix"> </div> 
								<br>
								<br>
							</div>	
					</div>
			</div>
		</div>
					
		</div>
		@push('scripts')
			<script>
				var default_sart  = "<?php if(isset($voucher))  echo  $voucher->limit_date  ?>";
				 
				$('#limit_date').datetimepicker({
					defaultDate: default_sart
				});
			</script>
		@endpush

@endsection