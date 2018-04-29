@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			
			<div class = "row">
				<div class = "col-md-4">
					<a  href = "{{URL::to('/admin/reports/export'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
						 <i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
					<a  href = "{{URL::to('/admin/reports/export/pdf'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
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
							<form class="form-horizontal" method = "get" action="{{URL::to('/admin/reports')}}">
								<div class="card-block">
									<div class="col-xl-5 col-lg-5 col-xs-12">
										<div class="row">
											<div class="col-xl-12 col-lg-12 col-xs-12 text-center">
												<h4> {{trans('app.operation_amount')}} </h4>
											</div>
											<div class="col-xl-12 col-lg-12 col-xs-12 text-center">
												<label for="expireyear" class="col-sm-2 col-xs-4 control-label mbbt-5">  {{trans('app.from')}}  </label>
												<div class="col-sm-4 col-xs-8 mbbt-5">
													<input id = "expireyear" class = "form-control" name ="from_amount" type = "text" value = "{{$setting['from_amount']}}" placeholder= "{{trans('app.from')}}"  onchange="this.form.submit()">
												</div>
												
												<label for="expireyear" class="col-sm-2 col-xs-4  control-label">  {{trans('app.to')}}  </label>
												<div class="col-sm-4 col-xs-8">
													<input type = "text" id = "expiremonth" class = "form-control" name ="to_amount" value = "{{$setting['to_amount']}}" placeholder= "{{trans('app.to')}}"   onchange="this.form.submit()"/>
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
															<input type='text' class="form-control" name = "from_date" value = "" placeholder = "{{trans('app.from')}}" />
															<span class="input-group-addon">
																<i class="icon-calendar"></i>
															</span>
													 </div>
												</div>
												
												<label for="to_date" class="col-sm-2 col-xs-4 control-label mbbt-5"> {{trans('app.to')}} </label>
												<div class="col-sm-4 col-xs-8 form-group">
													 <div class='input-group date' id='to_date'>
															<input type='text' class="form-control" name = "to_date" value = "" placeholder = "{{trans('app.to')}}" />
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
			
			<div class="col-md-2">
				<div class = "row">
					<div class="col-xs-12">
							  <input type="radio" name="feesmanagement" value="seller_type" onclick="choosefeetype('seller_type')" <?php if($setting['feesmanagement'] == 'seller_type') echo 'checked="checked"'; ?>> {{trans('app.seller')}}  
							  <br>
							  <br>
							  <input type="radio" name="feesmanagement" value="user_type" onclick="choosefeetype('user_type')" <?php if($setting['feesmanagement'] == 'user_type') echo 'checked="checked"'; ?>>  {{trans('app.user')}}  
							  <br>	
							  <br>
							  <input type="radio" name="feesmanagement" value="operation_fee_type" onclick="choosefeetype('operation_fee_type')" <?php if($setting['feesmanagement'] == 'operation_fee_type') echo 'checked="checked"'; ?>>{{trans('app.operation_fee')}} 
							  <br>
							  <br>
							  <input type="radio" name="feesmanagement" value="subscription_fee_type" onclick="choosefeetype('subscription_fee_type')" <?php if($setting['feesmanagement'] == 'subscription_fee_type') echo 'checked="checked"'; ?>>{{trans('app.subscription_fee')}} 
					</div>
				</div>
			</div>

			<div class="col-md-2 <?php if($setting['feesmanagement'] != 'operation_fee_type') echo 'hidden'; ?>  feesmanagement operation_fee_type ">
				<div class = "row">
					<label for="vehicle" class="col-sm-12 control-label">   {{trans('app.operation_fee')}} </label>
					<div class="col-xs-12">
							<select   class = "form-control" name ="service_type_op">
								<option value = ""> {{trans('app.all')}}  </option>
								<option value="0"  <?php if($setting['service_type_op'] == "0") echo "selected";?>> {{trans('app.pos_payment')}}</option>	
								<option value="1"  <?php if($setting['service_type_op'] == "1") echo "selected";?>> {{trans('app.deposit')}}  </option>	
								<option value="2"  <?php if($setting['service_type_op'] == "2") echo "selected";?>> {{trans('app.withdrawl')}}  </option>	
								<option value="3"  <?php if($setting['service_type_op'] == "4") echo "selected";?>> {{trans('app.pos_revenue')}}  </option>		
								<option value="6"  <?php if($setting['service_type_op'] == "6") echo "selected";?>> {{trans('app.send_money')}}  </option>	
							</select>
					</div>
				</div>
			</div>
			<div class="col-md-2 <?php if($setting['feesmanagement'] !=  'subscription_fee_type') echo 'hidden'; ?>  feesmanagement subscription_fee_type">
				<div class = "row">
					<label for="vehicle" class="col-sm-12 control-label">   {{trans('app.subscripton_fee')}} </label>
					<div class="col-xs-12">
							<select id = "vehicle" class = "form-control" name ="subscription_fee_name" >
								<option value = ""> {{trans('app.all')}}  </option>
								<option value = "0"   <?php if($setting['subscription_fee_name'] == "0") echo "selected";?>> {{trans('app.user')}}  </option>
								<option value = "1" <?php if($setting['subscription_fee_name'] == "1")  echo "selected";?>> {{trans('app.seller')}}  </option>
							</select>
					</div>
				</div>
			</div>

			<div class="col-xs-2 <?php if($setting['feesmanagement'] !=  'seller_type') echo 'hidden'; ?> feesmanagement seller_type">
					<div class = "row">
						<label for="fuelstation" class="col-sm-12 control-label">   {{trans('app.fuelstation_name')}} </label>
						<div class="col-xs-12">
								<select id = "fuelstation" class = "form-control pospay" name ="fuelstation_seller"  <?php if($setting['service_type_seller'] != "4") echo "disabled";?>>
									<option value = ""> {{trans('app.all')}} </option>
									@foreach($fuelstations as $fuelstation)
										@if($setting['fuelstation_seller'] == $fuelstation->no)
											<option value="{{$fuelstation->no}}" selected> {{$fuelstation->name}}</option>	
										@else
											<option value="{{$fuelstation->no}}"> {{$fuelstation->name}}</option>	
										@endif
									@endforeach
								</select>
						</div>
					</div>
				</div>
				
				<div class="col-md-2 <?php if($setting['feesmanagement'] !=  'seller_type') echo 'hidden'; ?> feesmanagement seller_type">
					<div class = "row">
						<label for="state" class="col-sm-12 control-label">   {{trans('app.state')}} </label>
						<div class="col-xs-12">
								<select id = "state" class = "form-control pospay" name ="state_seller"  <?php if($setting['service_type_seller'] != "4") echo "disabled";?>>
									<option value=""> {{trans('app.all')}}</option>
									@foreach($states as $state)
										@if($setting['state_seller'] == $state->zone_id)
											<option value="{{$state->zone_id}}" selected> {{$state->name}}</option>	
										@else
											<option value="{{$state->zone_id}}"> {{$state->name}}</option>	
										@endif
									@endforeach
								</select>
						</div>
					</div>
				</div>
				
				<div class="col-md-2 <?php if($setting['feesmanagement'] !=  'seller_type') echo 'hidden'; ?> feesmanagement seller_type">
					<div class = "row">
						<label for="city" class="col-sm-12 control-label">  {{trans('app.city')}}  </label>
						<div class="col-xs-12">
								<select id = "city" class = "form-control pospay" name ="city_seller"  <?php if($setting['service_type_seller'] != "4") echo "disabled";?>>
									<option value=""> {{trans('app.all')}} </option>	
									@foreach($cities as $city)
										@if($setting['city_seller'] == $city->city)
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
						<label for="service_type" class="col-sm-12 control-label"> {{trans('app.service_type_seller')}}</label>
						<div class="col-xs-12">
								<select id = "service_type" class = "form-control" name ="service_type_seller" >
									<option value="">  {{trans('app.all')}} </option>	
									<option value="1" <?php if($setting['service_type_seller'] == 1) echo "selected";?>>  {{trans('app.fuel')}}</option>	
									<option value="2" <?php if($setting['service_type_seller'] == 2) echo "selected";?>>  {{trans('app.oil')}}</option>	
									<option value="3" <?php if($setting['service_type_seller'] == 3) echo "selected";?>>  {{trans('app.wash')}}</option>	
								</select>
						</div>
					</div>
				</div -->
				
				
				<div class="col-md-2 <?php if($setting['feesmanagement'] !=  'seller_type') echo 'hidden'; ?> feesmanagement seller_type">
					<div class = "row">
						<label for="service_type" class="col-sm-12 control-label"> {{trans('app.operation_type')}}  </label>
						<div class="col-xs-12">
								<select id = "service_type" class = "form-control" name ="service_type_seller" >
									<option value=""> {{trans('app.all')}}</option>	
									<option value="4" <?php if($setting['service_type_seller'] == "4") echo "selected";?>> {{trans('app.pos_revenue')}}</option>	
									<option value="2" <?php if($setting['service_type_seller'] == "2") echo "selected";?>> {{trans('app.withdrawl')}}  </option>	
									<option value="5" <?php if($setting['service_type_seller'] == "5") echo "selected";?>> {{trans('app.subscription_fees')}}  </option>	
								</select>
						</div>
					</div>
				</div>

				<!----------------------------------------------------User part---------------------->

				<div class="col-md-2 <?php if($setting['feesmanagement'] !=  'user_type') echo 'hidden'; ?> feesmanagement user_type">
					<div class = "row">
						<label for="vehicle" class="col-sm-12 control-label">   {{trans('app.vehicle_name')}} </label>
						<div class="col-xs-12">
								<select id = "vehicle" class = "form-control pospay_user" name ="vehicle_user"  <?php if($setting['service_type_user'] != "0") echo "disabled";?> >
									<option value = ""> {{trans('app.all')}} </option>
									@foreach($vehicles as $vehicle)
										@if($setting['vehicle_user'] == $vehicle->no)
											<option value="{{$vehicle->no}}" selected> {{$vehicle->name}}</option>	
										@else
											<option value="{{$vehicle->no}}"> {{$vehicle->name}}</option>	
										@endif
									@endforeach
								</select>
						</div>
					</div>
				</div>
				
				<div class="col-md-2 <?php if($setting['feesmanagement'] !=  'user_type') echo 'hidden'; ?> feesmanagement user_type">
					<div class = "row">
						<label for="state" class="col-sm-12 control-label">   {{trans('app.state')}} </label>
						<div class="col-xs-12">
								<select id = "state" class = "form-control pospay_user" name ="state_user"  <?php if($setting['service_type_user'] != "0") echo "disabled";?> >
									<option value=""> {{trans('app.all')}}</option>
									@foreach($states_user as $state)
										@if($setting['state_user'] == $state->zone_id)
											<option value="{{$state->zone_id}}" selected> {{$state->name}}</option>	
										@else
											<option value="{{$state->zone_id}}"> {{$state->name}}</option>	
										@endif
									@endforeach
								</select>
						</div>
					</div>
				</div>
				
				<div class="col-md-2 <?php if($setting['feesmanagement'] !=  'user_type') echo 'hidden'; ?> feesmanagement user_type">
					<div class = "row">
						<label for="city" class="col-sm-12 control-label">  {{trans('app.city')}}  </label>
						<div class="col-xs-12">
								<select id = "city" class = "form-control pospay_user" name ="city_user"  <?php if($setting['service_type_user'] != "0") echo "disabled";?>>
									<option value=""> {{trans('app.all')}} </option>	
									@foreach($cities_user as $city)
										@if($setting['city_user'] == $city->city)
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
						<label for="service_type_user" class="col-sm-12 control-label"> {{trans('app.service_type_user')}}</label>
						<div class="col-xs-12">
								<select id = "service_type_user" class = "form-control" name ="service_type_user" >
									<option value="">  {{trans('app.all')}} </option>	
									<option value="1" <?php if($setting['service_type_user'] == 1) echo "selected";?>>  {{trans('app.fuel')}}</option>	
									<option value="2" <?php if($setting['service_type_user'] == 2) echo "selected";?>>  {{trans('app.oil')}}</option>	
									<option value="3" <?php if($setting['service_type_user'] == 3) echo "selected";?>>  {{trans('app.wash')}}</option>	
								</select>
						</div>
					</div>
				</div -->
				
				<div class="col-md-2 <?php if($setting['feesmanagement'] !=  'user_type') echo 'hidden'; ?> feesmanagement user_type">
					<div class = "row">
						<label for="service_type" class="col-sm-12 control-label"> {{trans('app.service_type')}}  </label>
						<div class="col-xs-12">
								<select id = "service_type_user" class = "form-control" name ="service_type_user" >
									<option value=""> {{trans('app.all')}}</option>	
									<option value="0" <?php if($setting['service_type_user'] == "0") echo "selected";?>> {{trans('app.pos_payment')}}</option>	
									<option value="1" <?php if($setting['service_type_user'] == "1") echo "selected";?>> {{trans('app.deposit')}}  </option>	
									<option value="2" <?php if($setting['service_type_user'] == "2") echo "selected";?>> {{trans('app.withdrawl')}}  </option>	
									<option value="3" <?php if($setting['service_type_user'] == "3") echo "selected";?>> {{trans('app.reward')}}  </option>	
									<option value="5" <?php if($setting['service_type_user'] == "5") echo "selected";?>> {{trans('app.subscription_fees')}}  </option>	
									<option value="6" <?php if($setting['service_type_user'] == "6") echo "selected";?>> {{trans('app.send_money')}}  </option>	
									<option value="7" <?php if($setting['service_type_user'] == "7") echo "selected";?>> {{trans('app.accept_money')}}  </option>	
								</select>
						</div>
					</div>
				</div>



		 
			<div class="col-md-2 float-xs-right" style = "margin-top: 20px;">
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
					<form class="form-horizontal" method = "get" action="{{URL::to('/admin/reports')}}">
						<fieldset class="form-group position-relative">
							<input type="text" name = "key"  class="form-control form-control-lg input-lg" id="iconLeft" placeholder="{{trans('search')}}"  value = "{{$setting['key']}}"/>
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
				</div>
				
				<div class = "col-xs-4 float-xs-right">
						<form id="w0" class="form-inline float-xs-right" action="/admin/reports" method="get">
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
							<div class = "card-block">
								<div class="table-responsive">
									
									<table class="table table-bordered table-striped">
											<thead>
												<tr>
													<th>  </th>
													<th>  {{trans('app.no')}}  </th> 
													<th>  {{trans('app.name')}}</th>
													<th>  {{trans('app.vehicle')}} / {{trans('app.fuelstation')}} </th>
													<th>  {{trans('app.operation_type')}}  </th>
													<th>  {{trans('app.fees_type')}}  {{trans('app.operation')}} </th>
													<th>  {{trans('app.fees_type')}}  {{trans('app.subscription')}} </th>
													<th>  {{trans('app.state')}} </th>
													<th>  {{trans('app.city')}}  </th>
													<th>  {{trans('app.amount')}}</th>
													<th>  {{trans('app.final_amount')}}</th>
													<th>  {{trans('app.admin_profit')}}</th>
													<th>  {{trans('app.sum')}}   </th>
													<th>  {{trans('app.date_opration')}}   </th>
												</tr>
											</thead>
											<tbody>
													<?php 
														$id = 0;
														if(isset($_REQUEST['page']))
															$id = ($_REQUEST['page'] -1) * $setting['pagesize']; 									
													?>
											@if(count($transactions))
												@foreach($transactions as $transaction)
													<tr>	
														<th  scope="row">   {{++$id}} </th>
														
														@if(($transaction->type != 0) && ($transaction->type != 4) && ($transaction->type != 1))
															<td>{{$transaction->no}}</td>
														@else
															<td> <a href = "{{URL::to('/admin/reports/details/')}}/{{$transaction->no}}"> {{$transaction->no}} </a> </td>
														@endif
 
														<td>	
															@if($transaction->first_name)
																{{$transaction->first_name}} {{$transaction->last_name}}
															@else
																{{$transaction->name}}
															@endif
														</td>
														<td>
															@if($transaction->details != "")
																{{$transaction->details->name}}
															@endif
														</td>
														<td>
															@if($transaction->type == '4')
																{{trans('app.pos_revenue')}}
															@elseif($transaction->type == '0')
																{{trans('app.pos_payment')}}
															@elseif($transaction->type == '1')
																{{trans('app.deposit')}}
															@elseif($transaction->type == '2')
																{{trans('app.withdrawl')}}
															@elseif($transaction->type == '3')
																{{trans('app.reward')}}
															@elseif($transaction->type == '5')
																{{trans('app.subscription_fees')}}
															@elseif($transaction->type == '6')
																{{trans('app.send_money')}}
															@elseif($transaction->type == '7')
																{{trans('app.accept_money')}}
															@elseif($transaction->type == '8')
																{{trans('app.redeem_voucher')}}
															@elseif($transaction->type == '9')
																{{trans('app.admin_withdraw')}}
															@endif
														 </td>
														  <td>
																@if($transaction->type == '4')
																	{{trans('app.pos_revenue')}}
																@elseif($transaction->type == '0')
																	{{trans('app.pos_payment')}}
																@elseif($transaction->type == '1')
																	{{trans('app.deposit')}}
																@elseif($transaction->type == '2')
																	{{trans('app.withdrawl')}}
																@elseif($transaction->type == '3')
																	{{trans('app.reward')}}
																@elseif($transaction->type == '5')
																	{{trans('app.subscription_fees')}}
																@elseif($transaction->type == '6')
																	{{trans('app.send_money')}}
																@elseif($transaction->type == '7')
																	{{trans('app.accept_money')}}
																@endif
														 </td>
														<td>
															@if($transaction->usertype == 0)
																{{trans('app.user')}}
															@endif
															@if($transaction->usertype == 1)
																{{trans('app.seller')}}
															@endif
														</td>
														<td>
															@if($transaction->details != "")
																{{$transaction->details->state}}
															@endif
														</td>
														<td>
															@if($transaction->details != "")
																{{$transaction->details->city}}
															@endif
														</td>
														<td>
															{{$transaction->amount}}
														</td>
														<td>  {{$transaction->final_amount}}</td>
														<td> 
															@if($transaction->type == '5')
																 {{$transaction->final_amount}}
															@else
																 {{$transaction->fee_amount}}
															@endif
														</td>
														<td>  {{$transaction->profit}}</td>
														<td>{{$transaction->regdate}}</td>
													</tr>
												@endforeach
												@else
													<tr> <td colspan = '20' class = "text-center"> {{trans('app.there_is_no_results')}} </td></tr>
												@endif
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