@extends('layouts.user')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			
			<div class = "row">
				<div class = "col-md-4">
					<a  href = "{{URL::to('/user/vehicles/export'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
						 <i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
					<a  href = "{{URL::to('/user/vehicles/export/pdf'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
						<i class="icon-file-pdf"></i> {{trans('app.export_to_pdf')}}  
					</a>
				</div>	
			</div>
			<br>

			<div class = "row">
				<div class = "col-md-4 col-sm-6">
					<form class="form-horizontal" method = "get" action="{{URL::to('/user/vehicles')}}">
						<fieldset class="form-group position-relative">
							<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder="{{trans('app.search')}}" name = "key" value = "{{$setting['key']}}">
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
					
				</div>
				
				<div class = "col-md-4 col-sm-6">
					<a  href = "/user/vehicles/create" class="btn btn-warning">  {{trans('app.add_vehicle')}}</a>
					<a href = "{{route('userusersettings')}}"  class="btn btn-warning">
						  {{trans('app.add_logo')}} 
					</a>
				</div>
				<div class = "col-md-4 float-xs-right col-sm-6">
					<form id="w0" class="form-inline float-xs-right" action="{{URL::to('/user/vehicles')}}" method="get">
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
						<div class="card-header">
								<h4 class="card-title" id="basic-layout-form"> {{$title}}</h4>
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
							<div class="table-responsive">
							<form class="form-horizontal" method = "post" action="{{URL::to('/')}}<?= "$_SERVER[REQUEST_URI]"  ?>">
								{{csrf_field()}}
								 
								<input type = "hidden" name = "pagesize" value = "{{$setting['pagesize']}}">
								
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>  </th>
											<th>  {{trans('app.no')}}      </th>
											<th>  {{trans('app.plate')}}    </th>
											<th>  {{trans('app.status')}}  </th>
											<th>  {{trans('app.reg_date')}}</th>
											<th>  {{trans('app.action')}}  </th>
										</tr>
									</thead>
									<tbody>
										<?php   
											$id = 0;    
											if(isset($_REQUEST['page']))
												$id = ( $_REQUEST['page'] - 1 ) * $setting['pagesize']; 									
										?>                 
									@foreach($vehicles as $vehicle)
										<tr>
											<th  scope="row">   {{++$id}} </th>
											<th>{{$vehicle->no}}</th> 
											<td> <span style = "direction:ltr"> {{$vehicle->name}} </span> </td>
											<td> 
												<select class="form-control"   name = "status_{{$vehicle->id}}" onchange="this.form.submit()" >
													<option value = "1" <?php  if($vehicle->status == 1) echo "selected" ?> > {{trans('app.working')}}  </option>
													<option value = "0" <?php  if($vehicle->status == 0) echo "selected" ?>> {{trans('app.deleted')}} </option>
												</select>
											</td>
											<td> 
												{{$vehicle->created_at}}
											</td>
											<td>
												<div class="btn-group" role="group" aria-label="Basic example">
													<button  style = "display:none" data-src = "{{URL::to('/images/qr')}}/{{$vehicle->qrcode}}" class="btn btn-warning qrcodeprint">  </button>
													<a href = "{{URL::to('/user/vehicles/qrcode')}}/{{$vehicle->no}}"  type="button" class="btn btn-warning">  <i class="icon-qrcode"></i>  </a>
													<a href = "/user/vehicles/update/{{$vehicle->id}}"  type="button" class="btn btn-primary"> <i class="icon-edit"></i> </a>
													<a href = "/user/vehicles/delete/{{$vehicle->id}}"  type="button" class="btn btn-danger"> <i class="icon-trash"></i> </a>
												</div>
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
      

@endsection