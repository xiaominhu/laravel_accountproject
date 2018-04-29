@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			
			<div class="row">
				<div class="col-xs-12">
					<div class="card">
						<div class="card-header">
								<h4 class="card-title" id="basic-layout-form"> {{ trans('app.fuelstation_info') }} </h4>
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
												<th>  </th>
												<th>{{trans('app.no')}}  </th>
												<th>{{trans('app.name')}}</th>
												<th>{{trans('app.location')}}</th>
												<th>{{trans('app.reg_date')}}</th>
											</tr>
										</thead>
										<?php  $id = 0; ?>
										<tbody>
												@if(count($fuelstations))
													@foreach($fuelstations as $fuelstation)
														<tr>
															<td>  {{++$id}} </td>
															<td> {{$fuelstation->no}} </td>
															<td> {{$fuelstation->name}} </td>
															<td> {{$fuelstation->statename}} - {{$fuelstation->city}}   </td>
															<td> {{$fuelstation->created_at}} </td>
														</tr>
													@endforeach
												@else
													<tr class = "text-center"><td colspan = "12"> {{trans('app.there_is_no_results')}} </td></tr>
												@endif	
												
										</tbody>
									</table>
								</div>
							</form>
								
						</div>
					</div>
				</div>
				 
			</div>
			
			<div class="row">
				<div class="col-xs-12">
					<div class="card">
						<div class="card-header">
								<h4 class="card-title" id="basic-layout-form"> {{ trans('app.pos_employeers') }}  </h4>
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
												<th>  </th>
												<th>{{trans('app.no')}}  </th>
												<th>{{trans('app.name')}}</th>
												<th>{{trans('app.email')}}</th>
												<th>{{trans('app.phone')}}</th>
												<th>{{trans('app.fuelstation')}}</th>
												<th>{{trans('app.reg_date')}}</th>
											</tr>
										</thead>
											<?php  $id = 0; ?>
											
										<tbody>
											@if(count($pos_employeers))
													@foreach($pos_employeers as $useritem)
														<tr>
															<td>  {{++$id}} </td>
															<td> {{$useritem->no}} </td>
															<td> {{$useritem->name}} </td>
															<td> {{$useritem->email}} </td>
															<td> {{$useritem->phone}} </td>
															<td> {{$useritem->fuelstation}} </td>
															<td> {{$useritem->created_at}} </td>
														</tr>
													@endforeach
												@else
													<tr class = "text-center"><td colspan = "12"> {{trans('app.there_is_no_results')}} </td></tr>
												@endif	
									
 
										</tbody>
									</table>
								</div>
							</form>
								
						</div>
					</div>
				</div>
				 
			</div>
			
			<div class="row">
				<div class="col-xs-12">
					<div class="card">
						<div class="card-header">
								<h4 class="card-title" id="basic-layout-form">  {{ trans('app.employeers') }}   </h4>
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
												<th>  </th>
												<th>{{trans('app.no')}}  </th>
												<th>{{trans('app.name')}}</th>
												<th>{{trans('app.email')}}</th>
												<th>{{trans('app.phone')}}</th>
												<th>{{trans('app.reg_date')}}</th>
											
											</tr>
										</thead>
										<tbody>
												<?php  $id = 0; ?>
												@if(count($selleremployeers))
													@foreach($selleremployeers as $useritem)
														<tr>
															<td>  {{++$id}} </td>
															<td> {{$useritem->no}} </td>
															<td> {{$useritem->name}} </td>
															<td> {{$useritem->email}} </td>
															<td> {{$useritem->phone}} </td>
															<td> {{$useritem->created_at}} </td>
														</tr>
													@endforeach
												@else
													<tr class = "text-center"><td colspan = "12"> {{trans('app.there_is_no_results')}} </td></tr>
												@endif												
											
										</tbody>
									</table>
								</div>
							</form>
								
						</div>
					</div>
				</div>
				 
			</div>
			
			
		</div>
@endsection