@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			<div class = "row">
				<div class = "col-xs-4">
				<a href = "/admin/coupons/create" class="btn btn-warning"> Add New Coupon </a>
				</div>
			</div>
			
			<br>
			
			<div class = "row">
				
				<div class = "col-xs-4">
					
					<fieldset class="form-group position-relative">
						<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder="Explore Robust ...">
						<div class="form-control-position">
							<i class="icon-ios-search-strong font-medium-4"></i>
						</div>
					</fieldset>
				</div>

				<div class = "col-xs-4 float-xs-right">
						<form id="w0" class="form-inline float-xs-right" action="/admin/coupons" method="get">
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
											<th>No</th>
											<th>Code</th>
											<th> Type </th>
											<th> Amount </th>
											<th>Limited Users </th>
											<th>Limited Date</th>
											<th>Fuel Station Name</th>
											<th>Reg Date</th>
										</tr>
									</thead>
									<tbody>
								@if(count($coupons))	
									@foreach($coupons as $coupon)
										<tr>
											<th scope="row">{{$coupon->id}}</th>
											<td> {{$coupon->code}} </td>
											<td> 
												<?php
													switch($coupon->type){
														case 0:
															echo 'Percentage';
															break;
														case 1:
															echo 'Fixed';
															break;
													}
												?>
											</td>
											<td> {{$coupon->amount}} </td>
											<td> {{$coupon->limit_users}} </td>
											<td> {{$coupon->limit_date}} </td>
											<td>
												@if($coupon->fuelstation_id)
													{{$coupon->name}} 
												@else
													All
												@endif
											</td>
											<td>{{$coupon->created_at}}</td>
											<td> 
												<div class="btn-group" role="group" aria-label="Basic example">
													<a href = "/admin/coupons/update/{{$coupon->id}}"  type="button" class="btn btn-primary">Edit</a>
													<a href = "/admin/coupons/delete/{{$coupon->id}}"  type="button" class="btn btn-danger">Delete</a>
												</div>
											</td>
										</tr>
									@endforeach
								@else
									<tr> <td colspan  = "8" class = "text-center"> There is no results. </td></tr>
								@endif
									</tbody>
								</table>
							</div>
						
						    	<div class = "col-xs-12" style = "text-align:center;">
									{{$coupons->links()}}
								</div>
						
						
					</div>
				</div>
				
				
			</div>
			
		</div>
      

@endsection