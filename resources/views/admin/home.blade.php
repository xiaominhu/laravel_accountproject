@extends('layouts.admin')

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
										<h3 class="deep-orange"> 12 </h3>
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
										<h3 class="deep-orange">1205480</h3>
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
										<h3 class="deep-orange">74</h3>
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
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
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
										<tr>
											<th scope="row">123</th>
											<td>Ahmed</td>
											<td>whitebear619@hotmail.com</td>
											<td>  123445</td>
											<td>  </td>
											<td>  </td>
											<td> Activated </td>
											<td> Yes </td>
											<td> Yes </td>
											
											<td> 2104. april 12:15:22 </td>
											<td> 2104. april 12:15:22 </td>
										</tr>
										
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
					
				<div class="col-xs-12">
					<div class="card">
					    <div class="card-header">
							<h4 class="card-title">  {{trans('app.top_fuel_station_revenue')}}  </h4>
						</div>
						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th> {{trans('app.no')}}</th>
											<th> {{trans('app.name')}}</th>
											<th> {{trans('app.phone')}}</th>
											<th> {{trans('app.depo_no')}}  </th>
											<th> {{trans('app.type_depo')}}  </th>
											<th> {{trans('app.amount_depo')}}   </th>
											<th> {{trans('app.notes')}}   </th>
											<th> {{trans('app.attachment')}} </th>
											<th> {{trans('app.deposite_date')}} </th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<th scope="row">205</th>
											<td>Ahmed</td>
											
											<td>  123445</td>
											<td> 123445 </td>
											<td> Visa </td>
											<td> 12345 </td>
											<td> Example </td>
											<td> <div class="fonticon-wrap"><i class="icon-paperclip2"></i></div> </td>
											
										
											<td> 2104. april 12:15:22 </td>
										</tr>
										
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
      

@endsection