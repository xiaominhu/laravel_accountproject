@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
		 

 
			<div class="container">
	<div class="row">
     
			<div class="row">
				<div class="col-xl-4 col-lg-6 col-xs-12">
					<div class="card">
						<div class="card-body">

						
							<div class="card-block">
								<div class="media">
									<div class="media-body text-xs-left">
										<h3 class="deep-orange"> {{$today_withdrawl}} </h3>
										<span> {{trans('app.withdrawls_today')}} </span>
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
										<a href="{{route('withdrawmanagement')}}"> <span>  {{trans('app.view_all')}}   </span>  <i class="icon-long-arrow-right"></i> </a> 
										<br>
										<br>
										<h6>   {{trans('app.withdrawl_operatons_today')}}  </h6>
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
										<h3 class="deep-orange">{{$total_balance}}</h3>
										<span> {{trans('app.balance')}}  </span>
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
										<h3 class="deep-orange"> {{$today_deposit}} </h3>
										<span>  {{trans('app.deposit_today')}} </span>
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
										<a href="{{route('depositmanagement')}}"> <span> {{trans('app.view_all')}} </span>  <i class="icon-long-arrow-right"></i> </a> 
										<br>
										<br>
										<h6>  {{trans('app.today_deposit_operations')}}   </h6>
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
							<h4 class="card-title"> {{trans('app.latest_user')}}  </h4>
						</div>
						<div class="card-body">
						<div class="card-block">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>  </th>
											<th> {{trans('app.no')}}                 </th>
											<th> {{trans('app.name')}}               </th>
											<th> {{trans('app.email')}}              </th>
											<th> {{trans('app.phone')}}              </th>
											<th> {{trans('app.type')}}               </th>
											<th> {{trans('app.statement_account')}}  </th>
											<th> {{trans('app.status')}}</th>
											<th> {{trans('app.email_approve')}} </th>
											<th> {{trans('app.phone_approve')}} </th>
											<th> {{trans('app.last_login')}}    </th>
											<th> {{trans('app.reg_date')}}      </th>
										</tr>
									</thead>
									<tbody>
										<?php
											$id = 0;
										?>
										@foreach($latest_users as $user)
										<tr>
											<th  scope="row">   {{++$id}} </th>
											<td>{{$user->no}}</td>
											<td>
												{{$user->name}}
											</td>
											<td>{{$user->email}}</td>
											<td>  {{$user->phone}} </td>
											 
											<td> 	
												<?php
													switch($user->usertype){
														case 0:
															echo trans('app.user');
															break;
														case 1:
															echo  trans('app.seller');
															break;
														case 2:
															echo trans('app.admin');
															break;
													}
												?> 
											</td>
											<td> 
												 @if($user->usertype != 2)
													<a href = "{{URL::to('/admin/users/statement/')}}/{{$user->no}}"> <span class="text-bold-600">Statement</span> </a>
												  @endif 
											</td>
											<td>  
												@if($user->status == 1)  
													 {{trans('app.activated')}} 
												@else
													{{trans('app.deactivated')}} 
												@endif
											</td>
											<td> 	
												@if($user->email_verify)
														  {{trans('app.yes')}}
												@else
														 {{trans('app.no_en')}}
												@endif
											 </td>
											<td> 	
												@if($user->phone_verify)
														  {{trans('app.yes')}}
												@else
														 {{trans('app.no_en')}}
												@endif
												
											 </td>
											
											<td> {{$user->last_login_at}} </td>
											<td>{{$user->created_at}} </td>
										</tr>
										@endforeach
										<tr>
											<th scope="row" colspan = "11">
												<a href = "{{URL::to('/admin/users')}}" class="btn btn-warning btn-block"> {{trans('app.view_all')}}  </a>
											</th>
										</tr>
									   
									</tbody>
								</table>
							</div>
						</div>
						</div>
					</div>
				</div>
					
				<div class="col-xs-12">
					<div class="card">
					    <div class="card-header">
							<h4 class="card-title">  {{trans('app.latest_deposit_operations')}}  </h4>
						</div>
						<div class="card-body">
							<div class="card-block">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>  </th>
											<th> {{trans('app.no')}}</th>
											<th> {{trans('app.name')}}</th>
											<th> {{trans('app.phone')}}</th>
										 
											<th> {{trans('app.type_depo')}}  </th>
											<th> {{trans('app.amount_depo')}}   </th>
											<th> {{trans('app.attachment')}} </th>
											<th> {{trans('app.deposite_date')}} </th>
										</tr>
									</thead>
									<tbody>
									<?php

										$id = 0;
									?>
										@foreach($latest_deposits as $deposit)
											<tr>
												<th> {{++$id}} </th>
												<td> {{$deposit->no}}    </td>
												<td>             {{$deposit->name}}  </td>
												<td>             {{$deposit->phone}} </td>
											 
												<td> 
													<?php
														switch($deposit->type){
															case 0:
																echo trans('app.bank');
																break;
															case 1:
																echo trans('app.master');
																break;
															case 2:
																echo trans('app.visa');
																break;
															case 3:
																echo trans('app.sdad');
																break;
														}
													?>
												</td>
												<td> {{$deposit->amount}}</td>
												
												<td class = "text-center">  
													@if($deposit->notes)
														<a href = "{{URL::to('admin/download/attachment')}}/{{$deposit->no}}" > <i class="icon-paperclip2"></i>  <a>
													@endif
												</td>
												 
											
												<td>  {{$deposit->created_at}} </td>
											</tr>
										@endforeach


										<tr>
											<th scope="row" colspan = "11">
												
												<a  href="{{route('depositmanagement')}}" class="btn btn-warning btn-block"> {{trans('app.view_all')}}  </a>
												
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
		</div>
@endsection