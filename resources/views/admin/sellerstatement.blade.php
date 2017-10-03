@extends('layouts.admin')

@section('admincontent')

 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			
			<div class = "row">
				
				<div class = "col-xs-4">
					<form class="form-horizontal" method = "get" action="{{URL::to('/users/statement/')}}">
						<fieldset class="form-group position-relative">
							<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder="{{trans('app.search')}}" value = "{{$setting['key']}}">
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
				</div>
				
				<div class = "col-xs-4 float-xs-right">
						<form id="w0" class="form-inline float-xs-right" action="/admin/users" method="get">
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
											<th>  {{trans('app.no_operation')}}  </th>
											<th>  {{trans('app.name')}}</th>
											<th>  {{trans('app.phone')}} </th>
											<th>  {{trans('app.type_operation')}} </th>
											<th>  {{trans('app.amount_operation')}}  </th>
											<th>  {{trans('app.attachment')}} </th>
											<th>  {{trans('app.date_operation')}} </th>
										</tr>
									</thead>
									<tbody>
										
										@foreach($transactions as $transaction)
										<tr>
											<td> 
												<a href = "{{URL::to('/admin/users/statement/details/')}}/{{$transaction->no}}"  class="onshownbtn"> {{$transaction->no}} </a> 
											</td>
											
											<td>
												@if($transaction->first_name)
													{{$transaction->first_name}} {{$transaction->last_name}}
												@else
													{{$transaction->name}}
												@endif

											</td>
											
											<td>{{$transaction->phone}}</td>
											<td>
												@if($transaction->type == '4')
													{{trans('app.pos_revenue')}} 
												@elseif($transaction->type == '1')
													{{trans('app.deposit')}}
												@endif
											 </td>
											 
											<td> {{$transaction->amount}} </td>
											
											<td>
												@if($transaction->attachment)
												<a href = "{{URL::to('admin/download/attachment')}}/{{$transaction->no}}" class="fonticon-wrap">
													<i class="icon-paperclip2"></i>
												</a> 
												@endif
											</td>

											<td>  	{{$transaction->operation_date}} </td>
										</tr>
										@endforeach

									</tbody>
								</table>
							</div>
						
						    	<div class = "col-xs-12" style = "text-align:center;">
									<?php //{{$users->links()}} ?>
								</div>
					</div>
				</div>
				
			</div>
			
		</div>
      
									<!-- Modal -->
<div class="modal fade text-xs-left" id="onshown" tabindex="-1" role="dialog" aria-labelledby="myModalLabel22" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
		 	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="myModalLabel22">   {{trans('app.operatoin_details')}}  </h4>
			</div>
		  	<div class="modal-body">
				<label> {{trans('app.no')}} : </label>
				<div class="form-group">
					<input id = "no_details"  type="text" readonly class="form-control">
				</div>
				
				<label>{{trans('app.name')}}: </label>
				<div class="form-group">
					<input id= "name_details" type="text" readonly class="form-control">
				</div>
				 
				<label>  {{trans('app.type_operation')}}  </label>
				<div class="form-group">
					<input id = "type_details" readonly="readonly" type="text"   class="form-control">
				</div>
				
				
				<label> {{trans('app.amount_operation')}} : </label>
				<div class="form-group">
					<input type="text" placeholder="Email Address" class="form-control">
				</div>
				
				<label>  {{trans('app.notes')}} : </label>
				<div class="form-group">
					<input type="text" placeholder="Email Address" class="form-control">
				</div>
				
				<label> {{trans('app.fuelstation_info')}}: </label>
				<div class="form-group">
					<input type="text" placeholder="Email Address" class="form-control">
				</div>
				
				<label>  {{trans('app.vehicle_info')}}: </label>
				<div class="form-group">
					<input type="text" placeholder="Email Address" class="form-control">
				</div>
				
				<label> {{trans('app.operation_date')}} : </label>
				<div class="form-group">
					<input type="text" placeholder="Email Address" class="form-control">
				</div>
			</div>
			<div class="modal-footer">
				<input type="reset" class="btn btn-outline-secondary btn-lg" data-dismiss="modal" value="close">
				<!-- input type="submit" class="btn btn-outline-primary btn-lg" value="Login" -->
			</div>
		</div>
	  </div>
</div>
							
							
							<!-- div>
							  $('#onshowbtn').on('click', function() {
									$('#onshow').on('show.bs.modal', function() {
										alert('onShow event fired.');
									});
								});
							</div -->
							

	  
	  
@endsection