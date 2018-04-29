@extends('layouts.admin')
@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			
			<div class = "row">
				<div class = "col-md-4">
					<a  href = "{{URL::to('admin/notification/export'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
						 <i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
					<a  href = "{{URL::to('/admin/notification/export/pdf'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
						 <i class="icon-file-pdf"></i> {{trans('app.export_to_pdf')}}  
					</a>
				</div>	
			</div>
			<br>

			<div class="card">
				<div class="card-header">
	                <h4 class="card-title">{{$title}}</h4>
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
							<div class = "col-xs-8 col-md-4">
								<form class="form-horizontal" method = "get" action="{{route('adminnotification')}}">
									<fieldset class="form-group position-relative">
										<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" name = "key" value = "{{$setting['key']}}" placeholder="{{trans('app.search')}}">
										<div class="form-control-position">
											<i class="icon-ios-search-strong font-medium-4"></i>
										</div>
									</fieldset>
								</form>	
							</div>
							
							<div class = "col-xs-4 float-xs-right">
									<form id="w0" class="form-inline float-xs-right" action="{{route('adminnotification')}}" method="get">
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
								<div class="table-responsive">
									<form class="form-horizontal" method = "post" action="/admin/notification">
									{{csrf_field()}}
									<table class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>  </th>
												<th>  {{trans('app.no')}} </th>
												<th>  {{trans('app.user_name')}}  </th>
												<th>  {{trans('app.name')}}      </th>
												<th>  {{trans('app.all_notification')}}     </th>
												<th>  {{trans('app.maximum_foramount')}} </th>
												  
												<th>  {{trans('app.maximum_washes')}} </th>
												<th>  {{trans('app.maximum_oil_changes')}}  </th>
											
												<th>  {{trans('app.maximum_times_day')}}  </th>
												<th>  {{trans('app.limit_operation_not')}}  </th>
											</tr>
										</thead>
										<tbody>  
										<?php 
											$id = 0;
											if(isset($_REQUEST['page']))
												$id = ($_REQUEST['page'] - 1) * $setting['pagesize']; 									
										?>
										@foreach($vehicles as $vehicle)
											<tr>
												<th  scope="row">   {{++$id}} </th>
												<td>{{$vehicle->no}}</td>
												<td> {{$vehicle->username}} </td>
												<td> <span style = "direction:ltr;"> {{$vehicle->name}} </span> </td>
												<td> 
													<select class="form-control" name = "not_type_{{$vehicle->id}}"  onchange="this.form.submit()">
														<option value = "0" <?php  if($vehicle->not_type == 0) echo "selected" ?> >   {{trans('app.yes')}}    </option>
														<option value = "1" <?php  if($vehicle->not_type == 1) echo "selected" ?>>   {{trans('app.sms')}} </option>
														<option value = "2" <?php  if($vehicle->not_type == 2) echo "selected" ?>> {{trans('app.email')}}  </option>
													</select>
												</td>
												
												<td>  <input id = "createvehicle_coutry" type = "number" class = "form-control" name ="not_amount_{{$vehicle->id}}" value = "{{$vehicle->not_amount}}" onchange="this.form.submit()"> </td>
												
												<td>  <input id = "createvehicle_coutry" type = "number" class = "form-control" name ="not_wash_{{$vehicle->id}}" value = "{{$vehicle->not_wash}}" onchange="this.form.submit()"> </td>
												<td>  <input id = "createvehicle_coutry" type = "number" class = "form-control" name ="not_oil_{{$vehicle->id}}" value = "{{$vehicle->not_oil}}" onchange="this.form.submit()"> </td>
												
												<td>  <input id = "createvehicle_coutry" type = "number" class = "form-control" name ="not_times_{{$vehicle->id}}" value = "{{$vehicle->not_times}}" onchange="this.form.submit()"> </td>
												   
												 
														<td> 
															<select class="form-control" name = "not_status_{{$vehicle->id}}" onchange="this.form.submit()">
																<option value = "0" <?php  if($vehicle->not_status == 0) echo "selected" ?> > {{trans('app.no_en')}}   </option>
																<option value = "1" <?php  if($vehicle->not_status == 1) echo "selected" ?>> {{trans('app.notification_stop')}}     </option>
																<option value = "2" <?php  if($vehicle->not_status == 2) echo "selected" ?>> {{trans('app.notification')}}     </option>
															</select>
														</td>
												 
											</tr>
											
										@endforeach
										
										</tbody>
									</table>
									  
									</form>
									
								</div>
							
								<div class = "col-xs-12" style = "text-align:center;">
									{{$vehicles->links()}}
								</div>
							</div>
						</div>
						
					</div>
	            </div>
			</div>

		
		</div>
      

@endsection