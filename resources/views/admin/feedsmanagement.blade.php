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
									<li><a data-action="reload"><i class="icon-reload"></i></a></li>
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
											<th> {{trans('app.phone')}} 	    </th>
											<th> {{trans('app.depo_no')}} 	    </th>
											<th> {{trans('app.type_depo')}}     </th>
											<th> {{trans('app.amount_depo')}}   </th>
											<th> {{trans('app.notes')}}         </th>
											<th> {{trans('app.attachment')}}    </th>
											<th> {{trans('app.deposite_date')}} </th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th scope="row">205</th>
											<td>Ahmed</td>
											
											<td>  123445</td>
											<td> 123445 </td>
											<td> Visa </td>
											<td> 12345 </td>
											<td> Example </td>
											<td> <div class="fonticon-wrap"><i class="icon-paperclip2"></i></div> </td>
											
										
											<td> 2104. april 12:15:22 </td>
										</tr>
										
										<tr>
											<th scope="row" colspan = "11">
												<button type="button" class="btn btn-warning btn-block"> {{trans('app.view_all')}} </button>
											</th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
	    
				
			</div>
			
		</div>
      

@endsection