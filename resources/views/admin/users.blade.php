@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			
			<div class = "row">
				<div class = "col-xs-4">
					<a  href = "{{URL::to('/admin/users/export')}}"  class="btn btn-primary">
						 <i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
				</div>	
			</div>
			<br>

			<div class = "row">
				<div class = "col-xs-4">
				<a href = "{{URL::to('/admin/users/addnewemployee')}}" class="btn btn-warning"> {{trans('app.add_new_employee')}}   </a>
				</div>
			</div>
			
			<br>
			
			<div class = "row">
				<div class = "col-xs-4">
					<form class="form-horizontal" method = "get" action="{{URL::to('/admin/users')}}">
						<fieldset class="form-group position-relative">
							<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder="{{trans('search')}}" name = "key" value = "{{$setting['key']}}">
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
				</div>
				
				<div class = "col-xs-4 float-xs-right">
						<form id="w0" class="form-inline float-xs-right" action="/admin/users" method="get">
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
						<form class="form-horizontal" method = "post" action="{{URL::to('/')}}<?= "$_SERVER[REQUEST_URI]"  ?>">
							{{csrf_field()}}
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>{{trans('app.no')}}  </th>
											<th>{{trans('app.name')}}</th>
											<th>{{trans('app.email')}} </th>
											<th>{{trans('app.phone')}} </th>
											<th>{{trans('app.type')}}</th>
											<th>{{trans('app.statement_account')}}</th>
											<th> {{trans('app.status')}}</th>
											<th> {{trans('app.email_approve')}} </th>
											<th> {{trans('app.phone_approve')}}</th>
											<th> {{trans('app.last_login')}}  </th>
											<th> {{trans('app.reg_date')}}  </th>
										</tr>
									</thead>
									<tbody>
									
									@foreach($users as $useritem)
										<tr>
											<th scope="row">{{$useritem->no}}</th>
											<td> {{$useritem->name}} </td>
											<td> {{$useritem->email}} </td>
											<td> {{$useritem->phone}} </td>
											<td> 
												<?php
													switch($useritem->usertype){
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
												@if($useritem->usertype != 2)
													<a href = "{{URL::to('/admin/users/statement/')}}/{{$useritem->no}}"> <span class="text-bold-600">Statement</span> </a>
												@endif
											</td>
											<td> 
												<select class="form-control" name = "status_{{$useritem->no}}" onchange="this.form.submit()">
													<option value = "1" <?php  if($useritem->status == 1) echo "selected" ?> >  {{trans('app.activated')}}  </option>
													<option value = "0" <?php  if($useritem->status == 0) echo "selected" ?>> {{trans('app.deactivated')}} </option>
												</select>
											</td>
											<td>  
												@if($useritem->email_verify)
														  {{trans('app.yes')}}
												@else
														 {{trans('app.no_en')}}
												@endif
											</td>
											<td> 	
												@if($useritem->phone_verify)
														  {{trans('app.yes')}}
												@else
														 {{trans('app.no_en')}}
												@endif
											 </td>
											
											<td>  {{$useritem->last_login_at}} </td>
											<td>{{$useritem->created_at}}</td>
										</tr>
									@endforeach
									
									</tbody>
								</table>
							</div>
						</form>
						    	<div class = "col-xs-12" style = "text-align:center;">
									{{$users->links()}}
								</div>
						
						
					</div>
				</div>
				
				
			</div>
			
		</div>
      

@endsection