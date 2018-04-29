@extends('layouts.admin')
@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			
			<div class = "row">
				<div class = "col-md-4">
					<a  href = "{{URL::to('/admin/users/export'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
						 <i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
					<a  href = "{{URL::to('/admin/users/export/pdf'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
						 <i class="icon-file-pdf"></i> {{trans('app.export_to_pdf')}}  
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
				<div class = "col-xs-8 col-md-4">
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
											<th>  </th>
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
			
											@if(Auth::user()->usertype == '2')
										    	<th> {{trans('app.action')}}  </th>
										    @endif

										</tr>
									</thead>
									<tbody>

									<?php 
										$id = 0;
										if(isset($_REQUEST['page']))
											$id = $_REQUEST['page'] * $setting['pagesize'];									
									?>

								@if(count($users))
									@foreach($users as $useritem)
										<tr>
											<th  scope="row">   {{++$id}} </th>
											<td>
											
											@if(($useritem->usertype == "0") || ($useritem->usertype == "1"))
												<a href = "{{route('adminuserdetails', $useritem->no)}}">
														{{$useritem->no}}
												</a>
											@else
												{{$useritem->no}}
											@endif

											
											</td>
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
														default:
															echo trans('app.employeer');
															break;
													}
												?>
											</td>
											<td>
												@if(($useritem->usertype == 1) || ($useritem->usertype == 0))
													<a href = "{{URL::to('/admin/users/statement/')}}/{{$useritem->no}}"> <span class="text-bold-600">Statement</span> </a>
												@endif
											</td>
											<td> 
												<select class="form-control" name = "status_{{$useritem->no}}" onchange="this.form.submit()" style = "width:120px;">
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
											<td style = "display: block !important;width: 140px;">  
												<div class="btn-group" role="group" aria-label="Basic example">
													<a href = "/admin/users/updateemployee/{{$useritem->no}}"  type="button" class="btn btn-primary"> <i class="icon-edit"></i> </a>
													@if(Auth::user()->usertype == 2)
													<a href="/admin/user/delete/{{$useritem->no}}" type="button" class="btn btn-danger"> <i class="icon-trash"></i></a>  
													@endif
												</div>
											 </td>
										</tr>
									@endforeach
								@else
									<tr class = "text-center"><td colspan = "13"> {{trans('app.there_is_no_results')}} </td></tr>
								@endif	
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
		</div>
@endsection