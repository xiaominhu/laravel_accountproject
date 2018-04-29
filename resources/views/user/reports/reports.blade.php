@extends('layouts.user')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->

			<div class = "row">
				<div class = "col-md-4">
					<a  href = "{{URL::to('/user/reports/export'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
						 <i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
					<a  href = "{{URL::to('/user/reports/export/pdf'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
						 <i class="icon-file-pdf"></i> {{trans('app.export_to_pdf')}} 
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
							<form class="form-horizontal" method = "get"  action=" {{ Request::url() . ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}">
								<div class="card-block">
									<div class="col-xl-5 col-lg-5 col-xs-12">
										<div class="row">
											<div class="col-xl-12 col-lg-12 col-xs-12 text-center">
												<h4> {{trans('app.operation_amount')}} </h4>
											</div>
											<div class="col-xl-12 col-lg-12 col-xs-12 text-center">
											
												<label for="expireyear" class="col-sm-2 col-xs-4 control-label mbbt-5">  {{trans('app.from')}}  </label>
												<div class="col-sm-4 col-xs-8 mbbt-5">
													<input id = "expireyear" class = "form-control" placeholder = "{{trans('app.from')}}" name ="from_amount" type = "text" value = "{{$setting['from_amount']}}"  onchange="this.form.submit()">
												</div>
												<label for="expireyear" class="col-sm-2 col-xs-4  control-label">  {{trans('app.to')}}  </label>
												<div class="col-sm-4 col-xs-8">
													<input type = "text" id = "expiremonth"placeholder = "{{trans('app.to')}}"   class = "form-control" name ="to_amount" value = "{{$setting['to_amount']}}"  onchange="this.form.submit()"/>
												</div>   
											</div>         
										</div>
									</div>  
									
									<div class="col-xl-7 col-lg-7 col-xs-12">
										<div class="row">
											<div class="col-xl-12 col-lg-12 col-xs-12 text-center">
												<h4>{{trans('app.operation_date')}}    </h4>
											</div>
											<div class="col-xl-12 col-lg-12 col-xs-12 text-center">
												<label for="from_date" class="col-sm-2 col-xs-4 control-label mbbt-5"> {{trans('app.from')}} </label>
												<div class="col-sm-4 col-xs-8 form-group">
													 <div class='input-group date' id='from_date'>
															<input type='text' class="form-control" placeholder = "{{trans('app.from')}}" name = "from_date" value = "" />
															<span class="input-group-addon">
																<i class="icon-calendar"></i>
															</span>
													 </div>
												</div> 
												<label for="to_date" class="col-sm-2 col-xs-4 control-label mbbt-5"> {{trans('app.to')}} </label>
												<div class="col-sm-4 col-xs-8 form-group">
													 <div class='input-group date' id='to_date'>
															<input type='text' class="form-control" placeholder = "{{trans('app.to')}}" name = "to_date" value = "" />
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
									<div class="col-md-2 mbbt-5">
										<div class = "row">
											<label for="vehicle" class="col-sm-12 control-label">   {{trans('app.vehicle_name')}} </label>
											<div class="col-xs-12">
												<select id = "vehicle" class = "form-control pospay" name ="vehicle"  <?php if($setting['service_type'] != "0") echo "disabled";?> >
													<option value = ""> {{trans('app.all')}} </option>
													@foreach($vehicles as $vehicle)
														@if($setting['vehicle'] == $vehicle->no)
															<option value="{{$vehicle->no}}" selected> {{$vehicle->name}}</option>	
														@else
															<option value="{{$vehicle->no}}"> {{$vehicle->name}}</option>	
														@endif
													@endforeach
												</select>
											</div>
										</div>
									</div>
									
									<div class="col-md-2 mbbt-5">
										<div class = "row">
											<label for="state" class="col-sm-12 control-label">   {{trans('app.state')}} </label>
											<div class="col-xs-12">
													<select id = "state" class = "form-control pospay" name ="state"  <?php if($setting['service_type'] != "0") echo "disabled";?> >
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
									
									<div class="col-md-2 mbbt-5">
										<div class = "row">
											<label for="city" class="col-sm-12 control-label">  {{trans('app.city')}}  </label>
											<div class="col-xs-12">
												<select id = "city" class = "form-control pospay" name ="city"  <?php if($setting['service_type'] != "0") echo "disabled";?>>
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
									
									<div class="col-md-2">
										<div class = "row">
											<label for="service_type" class="col-sm-12 control-label"> {{trans('app.service_type')}}  </label>
											<div class="col-xs-12">
													<select id = "service_type" class = "form-control" name ="service_type" >
														<option value=""> {{trans('app.all')}}</option>	
														<option value="0" <?php if($setting['service_type'] == "0") echo "selected";?>> {{trans('app.pos_payment')}}</option>	
														<option value="1" <?php if($setting['service_type'] == "1") echo "selected";?>> {{trans('app.deposit')}}  </option>	
														<option value="2" <?php if($setting['service_type'] == "2") echo "selected";?>> {{trans('app.withdrawl')}}  </option>	
														<option value="3" <?php if($setting['service_type'] == "3") echo "selected";?>> {{trans('app.reward')}}  </option>	
														<option value="5" <?php if($setting['service_type'] == "5") echo "selected";?>> {{trans('app.subscription_fees')}}  </option>	
														<option value="6" <?php if($setting['service_type'] == "6") echo "selected";?>> {{trans('app.send_money')}}  </option>	
														<option value="7" <?php if($setting['service_type'] == "7") echo "selected";?>> {{trans('app.accept_money')}}  </option>	
													</select>
											</div>
										</div>
									</div>
						 
									<div class="col-md-2" style = "margin-top: 20px;">
										<button type="submit" class="btn btn-warning btn-block"> {{trans('app.apply')}}</button>
									</div>				
								</div>
							</form>
						
						</div>
					</div>
				</div>
			
			</div>

			<div class = "row">
				<div class = "col-xs-8 col-md-4 col-sm-6">
					<form class="form-horizontal" method = "get" action="{{URL::to('/user/reports')}}">
						<fieldset class="form-group position-relative">
							<input type="text" name = "key"  class="form-control form-control-lg input-lg" id="iconLeft" placeholder="{{trans('search')}}"  value = "{{$setting['key']}}"/>
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
				</div>
				<div class = "col-xs-4 float-xs-right">
					<form id="w0" class="form-inline float-xs-right"  action=" {{ Request::url() . ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}" method="get">
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
								<div class="table-responsive">
									<table class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>  </th>
												<th>  {{trans('app.no')}}  </th>
												<th>  {{trans('app.vehicle_name')}}</th>
												<th>  {{trans('app.operation_type')}}  </th>
												<th>  {{trans('app.service_type')}} </th>
												<th>  {{trans('app.state')}} </th>
												<th>  {{trans('app.city')}}  </th>
												<th>  {{trans('app.amount')}}</th>
												<th>  {{trans('app.sum')}}   </th>
												<th>  {{trans('app.date_opration')}}   </th>
											</tr>
										</thead>
										<tbody>

											<?php 
												$id = 0;
												if(isset($_REQUEST['page']))
													$id = ($_REQUEST['page'] - 1 )  * $setting['pagesize']; 						
											?>

											@foreach($transactions as $operation)
											<tr>
												<th  scope="row">   {{++$id}} </th>
												<td><a href = "{{route('userreportdetails', $operation->no)}}"> {{$operation->no}} </a> </td>
												<td> 
													@if($operation-> details !== null)
														{{$operation-> details ->name}}  
													@endif
												</td>
												 
												<td>
													@if($operation->type == '4')
														{{trans('app.pos_revenue')}}
													@elseif($operation->type == '0')
														{{trans('app.pos_payment')}}
													@elseif($operation->type == '1')
														{{trans('app.deposit')}}
													@elseif($operation->type == '2')
														{{trans('app.withdrawl')}}
													@elseif($operation->type == '3')
														{{trans('app.reward')}}
													@elseif($operation->type == '5')
														{{trans('app.subscription_fees')}}
													@elseif($operation->type == '6')
														{{trans('app.send_money')}}
													@elseif($operation->type == '7')
														{{trans('app.accept_money')}}
													@elseif($operation->type == '8')
														{{trans('app.redeem_voucher')}}
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
												<td>  {{$operation->amount}} </td>
												<td>  {{$operation->profit}}</td>
												<td>  {{$operation->created_at}} </td>
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
			</div>
		</div>
      
    <script>
		reports = 1;
		
		var default_from  = "<?php if($setting['from_date'] != "")  echo  $setting['from_date'] ?>";
		var default_to    = "<?php if($setting['to_date'] != "")    echo  $setting['to_date'] ?>";
	</script>
@endsection