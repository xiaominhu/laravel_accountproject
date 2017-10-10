@extends('layouts.seller')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			
			<div class = "row">
				<div class = "col-xs-4">
					<a  href = "{{URL::to('/seller/reports/export')}}"  class="btn btn-primary">
						 <i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
				</div>	
			</div>
			<br>

			
			<div class="row">
				<div class="col-xs-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">  {{trans('app.advanced_search')}} </h4>
							<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
							<div class="heading-elements">
								<ul class="list-inline mb-0">
									<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
									<li><a data-action="close"><i class="icon-cross2"></i></a></li>
								</ul>
							</div>
						</div>
						<div class="card-body collapse in">
							<form class="form-horizontal" method = "post" action="{{URL::to('/seller/reports')}}">
								{{csrf_field()}}
								<div class="card-block">
									<div class="col-xl-6 col-lg-6 col-xs-12">
										<div class="row">
											<div class="col-xl-12 col-lg-12 col-xs-12 text-center">
												<h4> {{trans('app.operation_amount')}} </h4>
											</div>
											<div class="col-xl-12 col-lg-12 col-xs-12 text-center">
											
												<label for="expireyear" class="col-sm-2 control-label">  {{trans('app.from')}}  </label>
												<div class="col-xs-4">
													<input id = "expireyear" class = "form-control" name ="from_amount" type = "number" value = "{{$setting['from_amount']}}"  onchange="this.form.submit()">
												</div>
												
												<label for="expireyear" class="col-sm-2 control-label">  {{trans('app.to')}}  </label>
												<div class="col-sm-4">
													<input type = "number" id = "expiremonth" class = "form-control" name ="to_amount" value = "{{$setting['to_amount']}}"  onchange="this.form.submit()"/>
												</div>
												
											</div>
										</div>
									</div>
									
									<div class="col-xl-6 col-lg-6 col-xs-12">
										<div class="row">
											<div class="col-xl-12 col-lg-12 col-xs-12 text-center">
												<h4>{{trans('app.operation_date')}}    </h4>
											</div>
											<div class="col-xl-12 col-lg-12 col-xs-12 text-center">
												
												<label for="from_date" class="col-sm-2 control-label"> {{trans('app.from')}} </label>
												<div class="col-xs-4 form-group">
													 <div class='input-group date' id='from_date'>
															<input type='text' class="form-control" name = "from_date" value = "" />
															<span class="input-group-addon">
																<i class="icon-calendar"></i>
															</span>
													 </div>
												</div>
												
												<label for="to_date" class="col-sm-2 control-label"> {{trans('app.to')}} </label>
												<div class="col-xs-4 form-group">
													 <div class='input-group date' id='to_date'>
															<input type='text' class="form-control" name = "to_date" value = "" />
															<span class="input-group-addon">
																<i class="icon-calendar"></i>
															</span>
													 </div>
												</div>	 
											</div>
										</div>
									</div>
								</div>
								
								<div class="card-block">
									<div class="col-xs-2">
										<div class = "row">
											<label for="fuelstation" class="col-sm-12 control-label">   {{trans('app.fuelstation_name')}} </label>
											<div class="col-xs-12">
													<select id = "fuelstation" class = "form-control pospay" name ="fuelstation"  <?php if($setting['service_type'] != "4") echo "disabled";?>>
														<option value = ""> {{trans('app.all')}} </option>
														@foreach($fuelstations as $fuelstation)
															@if($setting['fuelstation'] == $fuelstation->no)
																<option value="{{$fuelstation->no}}" selected> {{$fuelstation->name}}</option>	
															@else
																<option value="{{$fuelstation->no}}"> {{$fuelstation->name}}</option>	
															@endif
														@endforeach
													</select>
											</div>
										</div>
									</div>
									
									<div class="col-xs-2">
										<div class = "row">
											<label for="state" class="col-sm-12 control-label">   {{trans('app.state')}} </label>
											<div class="col-xs-12">
													<select id = "state" class = "form-control pospay" name ="state"  <?php if($setting['service_type'] != "4") echo "disabled";?>>
														<option value=""> {{trans('app.all')}}</option>	
														
														@foreach($states as $state)
															@if($setting['state'] == $state->zone_id)
																<option value="{{$state->zone_id}}" selected> {{$state->name}}</option>	
															@else
																<option value="{{$state->zone_id}}"> {{$state->name}}</option>	
															@endif
														@endforeach
														 
														 
													</select>
											</div>
										</div>
									</div>
									
									<div class="col-xs-2">
										<div class = "row">
											<label for="city" class="col-sm-12 control-label">  {{trans('app.city')}}  </label>
											<div class="col-xs-12">
													<select id = "city" class = "form-control pospay" name ="city"  <?php if($setting['service_type'] != "4") echo "disabled";?>>
														<option value=""> {{trans('app.all')}} </option>	
														@foreach($cities as $city)
															@if($setting['city'] == $city->city)
																<option value="{{$city->city}}" selected> {{$city->city}}</option>	
															@else
																<option value="{{$city->city}}"> {{$city->city}}</option>	
															@endif
														@endforeach
													</select>
											</div>
										</div>
									</div>
									
									<!-- div class="col-xs-2">
										<div class = "row">
											<label for="service_type" class="col-sm-12 control-label"> {{trans('app.service_type')}}</label>
											<div class="col-xs-12">
													<select id = "service_type" class = "form-control" name ="service_type" >
														<option value="">  {{trans('app.all')}} </option>	
														<option value="1" <?php if($setting['service_type'] == 1) echo "selected";?>>  {{trans('app.fuel')}}</option>	
														<option value="2" <?php if($setting['service_type'] == 2) echo "selected";?>>  {{trans('app.oil')}}</option>	
														<option value="3" <?php if($setting['service_type'] == 3) echo "selected";?>>  {{trans('app.wash')}}</option>	
													</select>
											</div>
										</div>
									</div -->
									
									
									<div class="col-xs-2">
										<div class = "row">
											<label for="service_type" class="col-sm-12 control-label"> {{trans('app.operation_type')}}  </label>
											<div class="col-xs-12">
													<select id = "service_type" class = "form-control" name ="service_type" >
														<option value=""> {{trans('app.all')}}</option>	
														<option value="4" <?php if($setting['service_type'] == "4") echo "selected";?>> {{trans('app.pos_revenue')}}</option>	
														<option value="2" <?php if($setting['service_type'] == "2") echo "selected";?>> {{trans('app.withdrawl')}}  </option>	
														<option value="5" <?php if($setting['service_type'] == "5") echo "selected";?>> {{trans('app.subscription_fees')}}  </option>	
													</select>
											</div>
										</div>
									</div>
						 
									<div class="col-xs-2" style = "margin-top: 20px;">
										<button type="submit" class="btn btn-warning btn-block"> {{trans('app.apply')}}</button>
									</div>				
								</div>
								
							</form>
						
						</div>
					</div>
				</div>
			
			</div>
		 
			<div class = "row">
				<div class = "col-xs-4">
					<form class="form-horizontal" method = "get" action="{{URL::to('/seller/reports')}}">
						<fieldset class="form-group position-relative">
							<input type="text" name = "key"  class="form-control form-control-lg input-lg" id="iconLeft" placeholder="{{trans('search')}}"  value = "{{$setting['key']}}"/>
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
				</div>
				
				<div class = "col-xs-4 float-xs-right">
					<form id="w0" class="form-inline float-xs-right" action="{{URL::to('/seller/reports')}}" method="get">
						<select id="schedulesearch-id_service" class="form-control" name="pagesize" onchange="this.form.submit()">
							<option value="10" <?php if($setting['pagesize'] == 10) echo "selected";?>><font><font>10</font></font></option>
							<option value="15" <?php if($setting['pagesize'] == 15) echo "selected";?>><font><font>15</font></font></option>
							<option value="20" <?php if($setting['pagesize'] == 20) echo "selected";?>><font><font>20</font></font></option>
							<option value="25" <?php if($setting['pagesize'] == 25) echo "selected";?>><font><font>25</font></font></option>
							<option value="30" <?php if($setting['pagesize'] == 30) echo "selected";?>><font><font>30</font></font></option>
						</select>
					</form>
				</div>
			</div>
			
			<div class="row">
				<div class="col-xs-12">
					<div class="card">
					  
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>  {{trans('app.no')}}             </th>
											<th> {{trans('app.fuelstation_name')}} </th>
								
											<th> {{trans('app.operation_type')}} </th>
											<th>  {{trans('app.service_type')}}  </th>
											<th> {{trans('app.state')}}</th>
											<th>  {{trans('app.city')}} </th>
											<th> {{trans('app.amount')}} </th>
											<th>  {{trans('app.date_opration')}}   </th>
										</tr>
									</thead>
									<tbody>
									
									@foreach( $transactions as $operation)
										<tr>
											<th scope="row"> <a href = "{{URL::to('/seller/reports/details/')}}/{{$operation->no}}"> {{$operation->no}} </a> </th>
											<td>@if($operation-> details !== null)
													{{$operation->details->name}}  
												@endif
											<td> 	
												@if($operation->type == '4')
													{{trans('app.pos_revenue')}}
												@elseif($operation->type == '5')
													{{trans('app.subscription_fees')}}
												@elseif($operation->type == '1')
													{{trans('app.deposit')}}
												@elseif($operation->type == '2')
													{{trans('app.withdrawl')}}
												@elseif($operation->type == '3')
													{{trans('app.reward')}}
												@endif
											</td>
											<td>
												@if($operation-> details !== null)
													@if($operation-> details ->service_type == "1")
														{{trans('fuel')}}
													@elseif($operation->  details ->service_type == "2")
														{{trans('oil')}}
													@elseif($operation->  details ->service_type == "3")
														{{trans('wash')}}
													@else
												  
													@endif 
												@endif
											</td>
											<td>
												@if($operation-> details !== null)
													{{$operation->details->state}}  
												@endif

											</td>
											<td>  
												@if($operation-> details !== null)   
													{{$operation->details->city}}  
												@endif

											</td>
											<td> {{$operation->amount}} </td>
											<td> {{$operation->created_at}}</td>
										</tr>
									@endforeach
										
										
									 
									   
									</tbody>
								</table>
							</div>
						<div class = "col-xs-12" style = "text-align:center;">
								{{$transactions->links()}}
						</div>
					</div>
				</div>
					
				
			</div>
			
		</div>
    <script>
		reports = 1;
		
		var default_from  = "<?php if($setting['from_date'] != "")  echo  $setting['from_date'] ?>";
		var default_to    = "<?php if($setting['to_date'] != "")    echo  $setting['to_date'] ?>";
			
	</script>

@endsection