@extends('layouts.seller')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
		
			<div class = "row">
				<div class = "col-xs-4">
					<a  href = "{{URL::to('/seller/fuelstation/export')}}"  class="btn btn-primary">
						 <i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
				</div>	
			</div>
			<br>
			
			<div class = "row">
				<div class = "col-xs-4">
					<form class="form-horizontal" method = "get" action="{{URL::to('/seller/fuelstation')}}">
						<fieldset class="form-group position-relative">
							<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder="{{trans('app.search')}}" name = "key" value = "{{$setting['key']}}">
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
				</div>
				
				<div class = "col-xs-4">
					<a  href = "{{URL::to('/seller/fuelstation/create')}}" class="btn btn-warning">   {{trans('app.add_fuelstation')}}  </a>
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
											<th> {{trans('app.position')}}   </th>
											<th> {{trans('app.status')}}   </th>
											<th> {{trans('app.pos_status')}} </th>
											<th>  {{trans('app.reg_date')}} </th>
											<th>  {{trans('app.action')}}  </th>
										</tr>
									</thead>
									<tbody>
									
									@foreach($fuelstations as $fuelstation)
										<tr>
											<th scope="row">{{$fuelstation->no}}</th>
											<td> {{$fuelstation->name}} </td>
											<td> 
												 {{$fuelstation->statename}} -  {{$fuelstation->city}}
											</td>
											<td> 
												<select class="form-control"   name = "status_{{$fuelstation->id}}" onchange="this.form.submit()" >
													<option value = "1" <?php  if($fuelstation->status == 1) echo "selected" ?> > {{trans('app.working')}}  </option>
													<option value = "0" <?php  if($fuelstation->status == 0) echo "selected" ?>> {{trans('app.not_working')}}  </option>
												</select>
												
												
											</td>
											<td>
												<select class="form-control"   name = "pos_status_{{$fuelstation->id}}" onchange="this.form.submit()">
													<option value = "1" <?php  if($fuelstation->pos_status == 1) echo "selected" ?> > {{trans('app.working')}}  </option>
													<option value = "0" <?php  if($fuelstation->pos_status == 0) echo "selected" ?>> {{trans('app.not_working')}}  </option>
												</select>
											</td>
											
											<td> 
												{{$fuelstation->created_at}}
											</td>
											
											<td> 
												<div class="btn-group" role="group" aria-label="Basic example">
													<a href = "/seller/fuelstation/update/{{$fuelstation->id}}"  type="button" class="btn btn-primary">{{trans('app.edit')}}    </a>
													<a href = "/seller/fuelstation/delete/{{$fuelstation->id}}"  type="button" class="btn btn-danger"> {{trans('app.delete')}}  </a>
												</div>
											</td>
										</tr>
										
									@endforeach
									
									</tbody>
								</table>
							</div>
						
							<div class = "col-xs-12" style = "text-align:center;">
								{{$fuelstations->links()}}
							</div>
						</form>
						
					</div>
				</div>
				
				
			</div>
			
		</div>
      

@endsection