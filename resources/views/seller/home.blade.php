@extends('layouts.seller')

@section('admincontent')
 
    <div class="content-header row">
	</div>
	<div class="content-body"><!-- stats -->
		<div class="row">
			@if(Session::has('welcome'))
			 	@push('scripts')
					<script>
							swal({
								title: "{{trans('app.welcomeback_message', ['name' => Auth::user()->name])}}",
								button: "{{trans('app.close')}}",
							});
					</script>
				@endpush
			@endif
			<div class="col-xl-4 col-lg-6 col-xs-12">
				<div class="card">
					<div class="card-body">
						<div class="card-block">
							<div class="media">
								<div class="media-body text-xs-left">
									<h3 class="deep-orange">{{$balance}}</h3>
									<span>    {{trans('app.balance')}}  </span>
								</div>
								<div class="media-right media-middle">
									<i class="icon-diagram deep-orange font-large-2 float-xs-right"></i>
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
									<h3 class="deep-orange">  {{count($today_revenue)}} </h3>
									<span>    {{trans('app.operation_revenue_today')}}  </span>
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
									<a href = "{{route('sellerreports')}}"> <span>  {{trans('app.view_all')}}  </span>  <i class="icon-long-arrow-right"></i> </a> 
									
									<br>
										<br>
										<h6>  {{trans('app.pos_revenue_operations_today')}}  </h6>
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
							<h4 class="card-title">   {{trans('app.top_fuel_station_revenue')}} </h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>   </th>
											<th>{{trans('app.no')}} </th>
											<th> {{trans('app.name')}} </th>
											<th> {{trans('app.revenue_amount')}}   </th>
											
											<th> {{trans('app.reg_date')}}   </th>
										</tr>
									</thead>
									<tbody>
										<?php $i = 0; ?>
										@foreach($result_fuelstation as $operation)
										<tr>
											<th scope="row"> {{++$i}} </th>
											<td>{{$operation->no}}</td>
											<td> {{$operation->name}}    </td>
											<td>  {{$operation->expense}} </td>
											<td> {{$operation->created_at}}  </td>
										</tr>
										@endforeach
										
										<tr>
											<th scope="row" colspan = "11">
												<a  href = "{{route('sellerreports')}}"  type="button" class="btn btn-warning btn-block"> {{trans('app.view_all')}} </a>
											</th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
					
				
				
			</div>
			
		 
	</div>
  

      

@endsection