@extends('layouts.user')

@section('admincontent')
 
    <div class="content-header row">
	</div>
	<div class="content-body"><!-- stats -->
		<div class="row">
			
			<div class="col-xl-4 col-lg-6 col-xs-12">
				<div class="card">
					<div class="card-body">
						<div class="card-block">
							<div class="media">
								<div class="media-body text-xs-left">
									<h3 class="deep-orange">{{$balance}} </h3>
									<span>   </span>
								</div>
								<div class="media-right media-middle">
									<i class="icon-diagram deep-orange font-large-2 float-xs-right"></i>
								</div>
							</div>
							
							<div class="media">
								<div class="card-header">
									 <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
								</div>
								<div class="card-body">
									<a href = "{{route('userdeposit')}}"> <span> {{trans('app.balance_add')}} </span>  <i class="icon-long-arrow-right"></i> </a> 
									<br>
									<br>
									<h6>  {{trans('app.balance')}}   </h6>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="col-xl-4 col-lg-6 col-xs-12">
				<div class="card">
					<div class="card-body">
						<div class="card-block">
							<div class="media">
								<div class="media-body text-xs-left">
									<h3 class="deep-orange">{{$total_vehicle}}</h3>
									<span>  {{trans('app.vehicle')}}  </span>
								</div>
								<div class="media-right media-middle">
									<i class="icon-diagram deep-orange font-large-2 float-xs-right"></i>
								</div>
							</div>
							<div class="media">
								<div class="card-header">
									 <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
								</div>
								<div class="card-body">
									<a href = "{{URL::to('/user/vehicles')}}"> <span> {{trans('app.view_all')}} </span>  <i class="icon-long-arrow-right"></i> </a> 
									<br>
									<br>
									<h6>  {{trans('app.vehicles_amount')}}   </h6>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		
		</div>

		
		<div class="row">
			<div class="col-xs-12">
				<div class="card">
				    <div class="card-header">
						<h4 class="card-title"> {{trans('app.latest_added_vehicles')}} </h4>
					</div>
					<div class = "card-body">
						<div class="table-responsive">
							<table class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>  </th>
										<th>  {{trans('app.no')}}</th>
										<th>  {{trans('app.name')}}</th>
										<th>  {{trans('app.monthly_expense')}} </th>
										<th>  {{trans('app.reg_date')}} </th>
									</tr>
								</thead>
								<tbody>
								<?php

									$id = 0;
								?>
								@if(count($vehicles))
									@foreach($vehicles as $vehicle)
										<tr>
											<th  scope="row">   {{++$id}} </th>
											<td> {{$vehicle->no}}        </td>
											<td> <span style = "direction:ltr;"> {{$vehicle->name}} </span> </td>
											<td>  {{$vehicle->expense}} </td>
											<td>  {{$vehicle->created_at}}  </td>
										</tr>
									@endforeach	
									<tr>
										<th scope="row" colspan = "11">
											<a href = "{{URL::to('/user/vehicles')}}" class="btn btn-warning btn-block"><span>{{trans('app.view_all')}} </span><i class="icon-long-arrow-right"></i></a>
										</th>
									</tr>
								@else
									<tr> <td colspan = "4" class = "text-center"> {{trans('app.there_is_no_results')}} </td></tr>
								@endif
								   
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	 
      		@if(Session::has('welcome'))
			 	@push('scripts')	 
					<script>
						swal({
							title: "<?=  trans('app.welcomeback_message', ['name' => Auth::user()->name])?>",
							button: "<?= trans('app.close') ?>",
						});
					</script>
					 
				@endpush
			@endif

@endsection