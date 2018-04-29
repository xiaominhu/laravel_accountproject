@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			<div class="row">
				<div class="col-xs-12">
					<div class="card">
					  <div class="card-header">
							<h4 class="card-title"> {{trans('app.fees_operation')}}  </h4>
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
						<div class="table-responsive">
							<form class="form-horizontal feesmanagement-form" method = "post" action="/admin/feesmanagement">
								{{csrf_field()}}
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th> {{trans('app.no')}}     </th>
											<th> {{trans('app.name')}}   </th>
											<th> {{trans('app.select')}} </th>
											<th> {{trans('app.percentage')}} </th>
											<th> {{trans('app.fixed_sar')}} </th>
										</tr>
									</thead>
												<?php 
													$id = 0;
													if(isset($_REQUEST['page']))
														$id = ($_REQUEST['page'] - 1) * 5; 									
												?>

									<tbody>
										@foreach($fees as $fee)
											<tr>
												<td scope="row">{{++$id}}</td>
												<td scope="row">{{$fee->name}}</td>
												<td>  

												@if($fee->specialuser == 0)	
													<select  class = "form-control" name ="type_{{$fee->id}}" onchange="this.form.submit()">
														@if(($fee->fee_key == 'deposit') || ($fee->fee_key == 'withrawal'))
															<option value="0" <?php if($fee->type == "0") echo 'selected';  ?> > {{trans('app.no_en')}}   </option>	
														@endif

														@if(($fee->fee_key == 'deposit') || ($fee->fee_key == 'withrawal'))
															<option value="1" <?php if($fee->type == "1") echo 'selected';  ?>>  {{trans('app.all')}}     </option>	
														@endif

														@if(($fee->fee_key != 'pospay') && ($fee->fee_key != 'sendmoney'))
														<option value="2" <?php if($fee->type == "2") echo 'selected';  ?>>  {{trans('app.seller')}} </option>	
														@endif
														
														@if(($fee->fee_key != 'posrev'))
															<option value="3" <?php if($fee->type == "3") echo 'selected';  ?>>  {{trans('app.user')}}    </option>	
														@endif
													</select>
												@else
													 {{trans('app.seller')}} 
												@endif


												</td>
												<td>  <input type = "text" class = "form-control feemanagement" data-sibling = "up" data-id= "{{$fee->id}}"  name ="percent_{{$fee->id}}" value = "{{$fee->percent}}"  > </td>
												<td>  <input type = "text" class = "form-control feemanagement" data-sibling = "down" data-id= "{{$fee->id}}" name ="fixed_{{$fee->id}}"   value ="{{$fee->fixed}}"   > </td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</form>

							<div class = "col-xs-12" style = "text-align:center;">
								{{$fees->links()}}
							</div>
						 
							<div class = "col-md-12 text-right">
									 <button style = "margin-bottom: 15px" type="button" class="btn btn-outline-warning  btn-lg" data-toggle="modal" data-keyboard="false" data-target="#keyboard">
										{{trans('app.add_new')}}  
									</button>
									<!-- Modal -->
									<div class="modal fade text-xs-left" id="keyboard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
									  <div class="modal-dialog" role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button>
											<h4 class="modal-title" id="myModalLabel3"> {{trans('app.add_pos_revenue_fee')}}  </h4>
										  </div>
										  <div class="modal-body">
											 	<form class="form-horizontal row" method = "post" action="{{route('adminfeesadd')}}">
														{{csrf_field()}}
												  
													<div class="form-group col-sm-12 required">
														<label for="name_subscription" class="col-sm-4 control-label"> {{trans('app.name')}}  </label>
														<div class="col-sm-8">
															<select class="selectpicker" data-show-subtext="true" data-live-search="true" name = "name">																
																@foreach($sellers as $seller)
																    <option value = "">   {{trans('app.choose_seller')}}  </option>
																	<option value="{{$seller->no}}">   {{$seller->name}}  </option>
																@endforeach
															</select>
														</div>
													</div>

											 
													<div class="form-group col-sm-12 required">
														<label for="amount_subscription" class="col-sm-4 control-label"> {{trans('app.percentage')}}  </label>
														<div class="col-sm-8">
															<input type="text" class="form-control"   name = "percentage" placeholder="{{trans('app.amount')}}">
														</div>
													</div>


													<div class="form-group col-sm-12 required">
														<label for="amount_subscription" class="col-sm-4 control-label"> {{trans('app.fixed_sar')}}  </label>
														<div class="col-sm-8">
															<input type="text" class="form-control"   name = "fixed_sar" placeholder="{{trans('app.amount')}}">
														</div>
													</div>


										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn orange btn-outline-warning" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-outline-warning">{{trans('app.add_new')}}</button>
										  </div>
										  </form>
										</div>
									  </div>
									</div>
								</div>
								<br>



						</div>
						</div>
					</div>
				</div>
				 
			</div>
			
		</div>
      

@endsection