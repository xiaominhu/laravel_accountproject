@extends('layouts.user')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			
			<div class = "row">
				<div class = "col-xs-4">
					<a  href = "{{URL::to('/user/notification/export')}}"  class="btn btn-primary">
						 <i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
				</div>	
			</div>
			<br>


			<div class = "row">
				<div class = "col-xs-4">
					<form class="form-horizontal" method = "get" action="{{URL::to('/user/notification')}}">
						<fieldset class="form-group position-relative">
							<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder="{{trans('app.select')}}" name = "key" value = "{{$setting['key']}}">
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
				</div>
				
				<div class = "col-xs-4 float-xs-right">
						<form id="w0" class="form-inline float-xs-right" action="/user/vehicles" method="get">
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
								<form class="form-horizontal" method = "post" action="{{URL::to('/')}}<?= "$_SERVER[REQUEST_URI]"  ?>">
								{{csrf_field()}}
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>  {{trans('app.no')}}    </th>
											<th>  {{trans('app.name')}}</th>
											<th>  {{trans('app.all_notification')}}</th>
											<th>  {{trans('app.maximum_foramount')}}(SAR) </th>
											@if(0)
												<th>  {{trans('app.maximum_washes')}} </th>
												<th>  {{trans('app.maximum_oil_changes')}}</th>
											@endif
											<th>  {{trans('app.maximum_times_day')}} </th>
											<th>  {{trans('app.limit_operation_not')}}  </th>
										</tr>
									</thead>
									<tbody>
									
									@foreach($vehicles as $vehicle)
										<tr>
											<th scope="row">{{$vehicle->id}}</th>
											<td> {{$vehicle->name}} </td>
											<td> 
												<select class="form-control" name = "not_type_{{$vehicle->id}}"  onchange="this.form.submit()">
													<option value = "0" <?php  if($vehicle->not_type == 0) echo "selected" ?> > {{trans('app.yes')}}   </option>
													<option value = "1" <?php  if($vehicle->not_type == 1) echo "selected" ?>> {{trans('app.sms')}}  </option>
													<option value = "2" <?php  if($vehicle->not_type == 2) echo "selected" ?>> {{trans('app.email')}} </option>
												</select>
											</td>
											
											<td>  <input id = "createvehicle_coutry" type = "number" class = "form-control" name ="not_amount_{{$vehicle->id}}" value = "{{$vehicle->not_amount}}" onchange="this.form.submit()"> </td>
											@if(0)
											<td>  <input id = "createvehicle_coutry" type = "number" class = "form-control" name ="not_wash_{{$vehicle->id}}" value = "{{$vehicle->not_wash}}" onchange="this.form.submit()"> </td>
											<td>  <input id = "createvehicle_coutry" type = "number" class = "form-control" name ="not_oil_{{$vehicle->id}}" value = "{{$vehicle->not_oil}}" onchange="this.form.submit()"> </td>
											@endif
											
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
      

@endsection