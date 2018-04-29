@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			 
			<div class = "row">
				<div class = "col-xs-4">
					<form class="form-horizontal" method = "get" action="{{route('adminuserdetails', $setting['userno'])}}">
						<fieldset class="form-group position-relative">
							<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder="{{trans('search')}}" name = "key" value = "{{$setting['key']}}">
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form> 
				</div>
				<div class = "col-xs-4 float-xs-right">
					<form id="w0" class="form-inline float-xs-right" action="{{URL::to('/')}}<?= "$_SERVER[REQUEST_URI]"  ?>" method="get">
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

						<form class="form-horizontal" method = "post" action="{{URL::to('/')}}<?= "$_SERVER[REQUEST_URI]"  ?>">
							{{csrf_field()}}
							<div class="table-responsive">
								 
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>                             </th>
											<th>   {{trans('app.no')}}       </th>
											<th>   {{trans('app.name')}}     </th>
											<th>   {{trans('app.plate')}}     </th>
											<th>   {{trans('app.location')}} </th>
											<th>   {{trans('app.reg_date')}} </th>
											<th>   {{trans('app.status')}}   </th>
										</tr>
									</thead>
									<tbody>

									<?php 
										$id = 0;
										if(isset($_REQUEST['page']))
											$id = ($_REQUEST['page'] -1) * $setting['pagesize'];									
									?>

								@if(count($vehicles))
									@foreach($vehicles as $vehicle)
										<tr>
											<td> {{++$id}} 		     </td>
											<td> {{$vehicle->no}}    </td>
											<td> {{$vehicle->name}} </td>
											<td> {{$vehicle->plate}} </td>
											<td> {{$vehicle->statename}} - {{$vehicle->city}}  </td>
											<td> {{$vehicle->created_at}} </td>
											<td>
												<select class="form-control" name = "status_{{$vehicle->no}}"   onchange="this.form.submit()">
													<option value = "0" <?php  if($vehicle->status == 0) echo "selected" ?> >  {{trans('app.no_en')}}   </option>
													<option value = "1" <?php  if($vehicle->status == 1) echo "selected" ?>>   {{trans('app.yes')}}      </option>
												</select>
											</td>
										</tr>
									@endforeach
								@else
									<tr class = "text-center"><td colspan = "12"> {{trans('app.there_is_no_results')}} </td></tr>
								@endif	
									</tbody>
								</table>
  
							</div>
						</form>
							<div class = "col-xs-12" style = "text-align:center;">
								{{$vehicles->links()}}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection