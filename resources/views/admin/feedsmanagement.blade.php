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
									<li><a data-action="reload"><i class="icon-reload"></i></a></li>
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
									<tbody>
									
										@foreach($fees as $fee)
											<tr>
												<td scope="row">{{$fee->id}}</td>
												<td scope="row">{{$fee->name}}</td>
												<td>  
													<select  class = "form-control" name ="type_{{$fee->fee_key}}" onchange="this.form.submit()">
														@if(($fee->fee_key == 'deposit') || ($fee->fee_key == 'withrawal'))
															<option value="0" <?php if($fee->type == "0") echo 'selected';  ?> > {{trans('app.no_en')}}   </option>	
														@endif

														@if(($fee->fee_key == 'deposit') || ($fee->fee_key == 'withrawal'))
														<option value="1" <?php if($fee->type == "1") echo 'selected';  ?>>  {{trans('app.all')}}     </option>	
														@endif

														@if(($fee->fee_key != 'pospay'))
														<option value="2" <?php if($fee->type == "2") echo 'selected';  ?>>  {{trans('app.seller')}} </option>	
														@endif
														
														@if(($fee->fee_key != 'posrev'))
															<option value="3" <?php if($fee->type == "3") echo 'selected';  ?>>  {{trans('app.user')}}    </option>	
														@endif
													</select>
												</td>
												<td>  <input type = "text" class = "form-control feemanagement" data-sibling = "up" data-id= "{{$fee->id}}"  name ="percent_{{$fee->fee_key}}" value = "{{$fee->percent}}"  > </td>
												<td>  <input type = "text" class = "form-control feemanagement" data-sibling = "down" data-id= "{{$fee->id}}" name ="fixed_{{$fee->fee_key}}"   value ="{{$fee->fixed}}"   > </td>
											</tr>
										@endforeach
									</tbody>
								</table>
								
							</form>
						</div>
						</div>
					</div>
				</div>
					
				<div class="col-xs-12">
					<div class="card">
						 <div class="card-header">
							<h4 class="card-title"> {{trans('app.subscription_fees')}} </h4>
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
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th> {{trans('app.no')}} 		    </th>
											<th> {{trans('app.name')}}		    </th>
											<th> {{trans('app.free_if_exceed')}} 	    </th>
											<th> {{trans('app.select')}} 	    </th>
											<th> {{trans('app.amount')}}     </th>
											 
										</tr>
									</thead>
									<tbody>
										@foreach($subscripttionfees as $item)
											<tr>
												<th scope="row">205</th>
												<td>Ahmed</td>
												<td>  123445</td>
												<td> 123445 </td>
												<td> Visa </td>
											</tr>
										@endforeach
									</tbody>
								</table>

								


								<div class = "col-md-12 text-center">
									 
									 <button style = "margin-bottom: 15px" type="button" class="btn btn-outline-primary  btn-lg" data-toggle="modal" data-keyboard="false" data-target="#keyboard">
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
											<h4 class="modal-title" id="myModalLabel3">Add Subscripttion Fee</h4>
										  </div>
										  <div class="modal-body">
											
											 	<form class="form-horizontal row" method = "post" action="/admin/subscription/add">
													<div class="form-group col-sm-12">
														<label for="type_subscription" class="col-sm-4 control-label"> {{trans('app.type')}}    </label>
														<div class="col-sm-8">
																<select id="type_subscription" class = "form-control" name ="type" >
																	    <option value="" >    {{trans('app.select')}}  </option>
																		<option value="0">    {{trans('app.user')}}    </option>
																		<option value="1">    {{trans('app.seller')}}  </option>
																</select>
														</div>
													</div>

													<div class = "hidden name_subscription_hidden">
														<option value="" >   {{trans('app.select')}}  </option>
													</div>

													<div class="form-group col-sm-12">
														<label for="name_subscription" class="col-sm-4 control-label"> {{trans('app.name')}}  </label>
														<div class="col-sm-8">
															<select id="name_subscription" class = "form-control" name ="name" >
																	<option value="" >   {{trans('app.select')}}  </option>
															</select>
														</div>
													</div>

													<div class="form-group col-sm-12 userform hidden">
														<label for="freeamount_subscription" class="col-sm-4 control-label"> {{trans('app.free_if_exceed')}}  </label>
														<div class="col-sm-8">
															<input type="number" class="form-control"  id="freeamount_subscription" name = "freeamount" placeholder="" value = "">
														</div>
													</div>

													<div class="form-group col-sm-12">
														<label for="amount_subscription" class="col-sm-4 control-label"> {{trans('app.amount')}}  </label>
														<div class="col-sm-8">
															<input type="text" class="form-control"  id="amount_subscription" name = "amount" placeholder="" value = "">
														</div>
													</div>
												</form>
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
											<button type="button" class="btn btn-outline-primary">{{trans('app.add_new')}}</button>
										  </div>
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