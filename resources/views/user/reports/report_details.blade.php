@extends('layouts.user')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			<div class="row">
				<div class="col-xs-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title">  {{$title}} </h4>
							<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
							<div class="heading-elements">
								<ul class="list-inline mb-0">
									<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
									<li><a data-action="close"><i class="icon-cross2"></i></a></li>
								</ul>
							</div>
						</div>
						<div class="card-body collapse in">
							<form class="form-horizontal" method = "post"  action=" {{ Request::url() . ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}">
								{{csrf_field()}}
							 	<div class="card-block">
										<div class="row">
												<div class="col-md-6 offset-md-3">
													<p class="lead">No {{$transaction->no}}</p>
													<div class="table-responsive">
														<table class="table table-borderless table-sm">
														  <tbody>
															<tr>
																<td> {{trans('app.type_operation')}} </td>
																<td class="text-xs-right blue"> 
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
																	@endif
																</td>
															</tr>
															 
															<tr>
																<td> {{trans('app.amount_operation')}} </td>
																<td class="text-xs-right"> {{$transaction->amount}} </td>
															</tr>
															<tr>
																<td> {{trans('app.operation_fee')}}  </td>
																<td class="  text-xs-right">  (-) {{$transaction->fee_amount}} </td>
															</tr>
															
															<tr>
																<td class="text-bold-800">{{trans('app.final_amount')}}  </td>
																<td class="text-bold-800 text-xs-right">   {{$transaction->final_amount}}  </td>
															</tr>
															
															 <tr>
																<td> {{trans('app.reg_date')}} </td>
																<td class="text-xs-right"> {{$transaction->created_at}} </td>
															 </tr>

														@if($transaction->type  == '0') 
															 <tr>
																<td> {{trans('app.vehicle_info')}} </td>
																<td class="text-xs-right"> 
																	@if($transaction->vehicle !== null)
																		{{$transaction->vehicle->name}}
																	@endif

																</td>
															 </tr>
															<tr>
																<td> {{trans('app.fuelstation_info')}} </td>
																<td class="text-xs-right"> 
																	@if($transaction->fuelstation !== null)
																		{{$transaction->fuelstation->name}}
																	@endif
																</td>
															</tr>

															<tr>
																<td> {{trans('app.fuelstation_location')}} </td>
																<td class="text-xs-right"> 
																	@if($transaction->fuelstation !== null)
																		{{$transaction->fuelstation->statename}}  {{$transaction->fuelstation->city}}
																	@endif
																</td>
															</tr>
 
															<tr>
																<td> {{trans('app.posuser_name')}} </td>
																<td class="text-xs-right"> 
																	@if($transaction->posuer !== null)
																		{{$transaction->posuer->name}}
																	@endif
																</td>
															 </tr>

															 
														@elseif($transaction->type  == '1')
															<tr>
																<td> {{trans('app.approve_time')}} </td>
																<td class="text-xs-right"> 
																	@if($transaction->deposit !== null)
																		{{$transaction->deposit->updated_at}}
																	@endif
																</td>
															</tr>
														@endif
															
														  </tbody>
														</table>
													</div>
													 
												</div>
										</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			
			</div>

		 
			 
		</div>
      
     
@endsection