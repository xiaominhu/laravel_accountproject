@extends('layouts.seller')

@section('admincontent')
	<div class="content-header row">
	</div>
	<div class="content-body"><!-- stats -->
		<div class = "row">
			<div class = "col-xs-4">
				<form class="form-horizontal" method = "get" action="{{URL::to('/seller/employeers')}}">
					<fieldset class="form-group position-relative">
						<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder="{{trans('app.search')}}" name = "key" value = "{{$setting['key']}}">
						<div class="form-control-position">
							<i class="icon-ios-search-strong font-medium-4"></i>
						</div>
					</fieldset>
				</form>	
			</div>
			
			<div class = "col-xs-4">
				<a  href = "{{URL::to('/seller/employeers/create')}}" class="btn btn-warning">   {{trans('app.add_pos_user')}}  </a>
			</div>
			 
			<div class = "col-xs-4 float-xs-right">
				<form id="w0" class="form-inline float-xs-right" action="/seller/fuelstation" method="get">
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
					<form class="form-horizontal" method = "post" action="{{URL::to('/seller/fuelstation')}}">
						{{csrf_field()}}
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th> {{trans('app.no')}}    </th>
										<th> {{trans('app.name')}}  </th>
										<th> {{trans('app.email')}}  </th>
										<th> {{trans('app.fuelstation')}}  </th>
										<th> {{trans('app.service_type')}}  </th>
									 
										<th>  {{trans('app.action')}}  </th>
									</tr>
								</thead>
								<tbody>
								@if(count($employeers))
									@foreach($employeers as $employeer)
									<tr>
										<td> {{$employeer->no}} </td>
										<td> {{$employeer->name}} </td>

										<td> {{$employeer->email}} </td>

										<td> {{$employeer->fuelstationname}} </td>
										<td>
											@if($employeer->service == "1")
												{{trans('app.fuel')}}
											@elseif($employeer->service == "2")
												{{trans('app.wash')}}
											@elseif($employeer->service == "3")
												{{trans('app.oil')}}
											@else
											@endif
											 
										</td>
										<td> 
											<div class="btn-group" role="group" aria-label="Basic example">
													<a href = "/seller/employeers/update/{{$employeer->no}}"  type="button" class="btn btn-primary">{{trans('app.edit')}}    </a>
													<a href = "/seller/employeers/delete/{{$employeer->no}}"  type="button" class="btn btn-danger"> {{trans('app.delete')}}  </a>
											</div>
										 </td>
									</tr>
									@endforeach
								@else
									<tr>  <td colspan= '6' class = "text-center"> {{trans('app.there_is_no_results')}} </td> </tr>
								@endif
								
								</tbody>
							</table>
						</div>
					
						<div class = "col-xs-12" style = "text-align:center;">
							 
						</div>
					</form>
					
				</div>
			</div>
			
			
		</div>
		
	</div>
@endsection