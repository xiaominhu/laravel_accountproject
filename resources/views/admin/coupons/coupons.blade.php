@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->

		<div class="row">
				<div class="col-xs-12">
					<div class="card">
						<div class="card-header">
							<h4 class="card-title"> {{$title}}  </h4>
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
			<div class = "row">
				<div class = "col-xs-4">
				<a href = "{{URL::to('/admin/coupons/create')}}" class="btn btn-warning">    {{trans('app.add_new_coupon')}}    </a>
				</div>
			</div>
			
			<br>
			
			<div class = "row">
				<div class = "col-xs-4">
					<form class="form-horizontal" method = "get" action="{{URL::to('/admin/coupons')}}">	
						<fieldset class="form-group position-relative">
							<input type="text" name = "key" value = "{{$setting['key']}}" class="form-control form-control-lg input-lg" id="iconLeft" placeholder=" {{trans('app.search')}} ">
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>
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
			
			
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th> {{trans('app.no')}}</th> 
											<th> {{trans('app.code')}}</th>
											<th> {{trans('app.type')}} </th>
											<th> {{trans('app.amount')}}  </th>
											<th> {{trans('app.status')}}  </th>
											<th> {{trans('app.limit_number_users')}}</th>
											<th> {{trans('app.limit_date')}}  </th>
											<th> {{trans('app.reg_date')}} </th>
											 <th> {{trans('app.action')}} </th>
										</tr>
									</thead>
									<tbody>

									<?php
										if(isset($_REQUEST['page']))
											$id = $_REQUEST['page'] * 10;
										else 
											$id = 0;
									?>

								@if(count($coupons))
									@foreach($coupons as $coupon)
										<tr>
											<th scope="row"> <a href = "{{URL::to('admin/coupon/usage')}}/{{$coupon->code}}"> <?= ++$id; ?> </a> </th>
											<td> {{$coupon->code}} </td>
											<td> 
												<?php
													switch($coupon->type){
														case 1:
															echo trans('app.percentage');
															break;
														case 0:
															echo trans('app.fixed');
															break;
													}
												?>
											</td>
											<td> {{$coupon->amount}} </td>
											
											<td> 
													@if($coupon->status)
														<span class="label label-success">  {{trans('app.available')}} </span> 
													@else
														<span class="label label-danger">   {{trans('app.expired')}} </span> 
													@endif
											</td>

 
											<td> {{$coupon->limit_users}} </td>
											<td> {{$coupon->limit_date}} </td>
											<td>{{$coupon->created_at}}</td>
											<td> 
												<div class="btn-group" role="group" aria-label="Basic example">
													<a href = "/admin/coupons/update/{{$coupon->id}}"  type="button" class="btn btn-primary"><i class="icon-edit"></i></a>
													<a href = "/admin/coupons/delete/{{$coupon->id}}"  type="button" class="btn btn-danger"><i class="icon-trash"></i></a>
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
				
			</div>
			
		</div>
      

@endsection