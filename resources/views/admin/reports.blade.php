@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			
			<div class = "row">
				<div class = "col-xs-4">
					<a  href = "{{URL::to('/admin/reports/export')}}"  class="btn btn-primary">
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
							<form class="form-horizontal" method = "post" action="{{URL::to('/admin/reports')}}">
								{{csrf_field()}}
								<div class="card-block">
									<div class="col-xl-5 col-lg-5 col-xs-12">
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
									
									<div class="col-xl-7 col-lg-7 col-xs-12">
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
					<div class="col-xs-12">
							  <input type="radio" name="feesmanagement" value="operation_fee_type" onclick="choosefeetype('operation_fee_type')"> Operation Fees
							  <br>
							  <br>
							  <input type="radio" name="feesmanagement" value="subscription_fee_type" onclick="choosefeetype('subscription_fee_type')"> Subscription Fees
							  <br>
					</div>
				</div>
			</div>

			<div class="col-xs-2 hidden feesmanagement operation_fee_type ">
				<div class = "row">
					<label for="vehicle" class="col-sm-12 control-label">   {{trans('app.operation_fee')}} </label>
					<div class="col-xs-12">
							<select   class = "form-control" name ="operation_fee_type" >
								<option value = ""> {{trans('app.all')}}  </option>
								<option value = "1"> {{trans('app.deposit')}}  </option>
								<option value = "2"> {{trans('app.withdrawl')}}  </option>
								<option value = "4"> {{trans('app.pos_revenue')}}  </option>
								<option value = "0"> {{trans('app.pos_payment')}}  </option>
							</select>
					</div>
				</div>
			</div>

			<div class="col-xs-2 hidden feesmanagement subscription_fee_type">
				<div class = "row">
					<label for="vehicle" class="col-sm-12 control-label">   {{trans('app.subscripton_fee')}} </label>
					<div class="col-xs-12">
							<select id = "vehicle" class = "form-control" name ="subscription_fee_type" >
								<option value = ""> {{trans('app.all')}}  </option>
								<option value = "user"> {{trans('app.user')}}  </option>
								<option value = "seller"> {{trans('app.seller')}}  </option>
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
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>  {{trans('app.no')}}  </th>
											<th>  {{trans('app.name')}}</th>
											<th>  {{trans('app.vehicle')}} / 	    {{trans('app.fuelstation')}} </th>
											<th>  {{trans('app.operation_type')}}  </th>
											<th>  {{trans('app.fees_type')}}  {{trans('app.operation')}} </th>
											<th>  {{trans('app.fees_type')}}  {{trans('app.subscription')}} </th>
											<th>  {{trans('app.state')}} </th>
											<th>  {{trans('app.city')}}  </th>
											<th> {{trans('app.amount')}}</th>
											<th>  {{trans('app.date_opration')}}   </th>
										</tr>
									</thead>
									<tbody>
										@foreach($transactions as $transaction)
											<tr>
												<td>{{$transaction->no}}</td>
												<td>	
													@if($transaction->first_name)
														{{$transaction->first_name}} {{$transaction->last_name}}
													@else
														{{$transaction->name}}
													@endif
												</td>
												<td>
													@if($transaction->details !== null)
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
													@if($transaction->details !== null)
														{{$transaction->details->state}}
													@endif
												 </td>

												 <td>
													@if($transaction->details !== null)
														{{$transaction->details->city}}
													@endif
												 </td>
												<td>
													{{$transaction->amount}}
												 
												 </td>
												<td>{{$transaction->regdate}}</td>
												 
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