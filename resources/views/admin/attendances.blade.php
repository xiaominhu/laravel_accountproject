@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			<div class = "row">
				<div class = "col-md-4">
					<a  href = "{{URL::to('/admin/attendances/export')}}"  class="btn btn-warning">
						 <i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
					<a  href = "{{URL::to('/admin/attendances/export/pdf')}}"  class="btn btn-warning">
						<i class="icon-file-pdf"></i> {{trans('app.export_to_pdf')}}  
					</a>
				</div>	
			</div>
			<br>
 
			<div class = "row">
				<div class = "col-md-4 col-xs-8">
					<form class="form-horizontal" method = "get" action="{{URL::to('/admin/attendances')}}">
						<fieldset class="form-group position-relative">
							<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" value = "{{$setting['key']}}" name = "key" placeholder=" {{trans('app.serach')}}">
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
				</div>
				
				<div class = "col-xs-4 col-md-4 float-xs-right">
					<form id="w0" class="form-inline float-xs-right" action="{{URL::to('/admin/attendances')}}" method="get">
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
							<h4 class="card-title"> {{$title}}  </h4>
							<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
							<div class="heading-elements">
								<ul class="list-inline mb-0">
									<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
									<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
									<li><a data-action="close"><i class="icon-cross2"></i></a></li>
								</ul> 
							</div>
						</div>
						<div class = "card-body">
							<div class="card-block">
								<div class="table-responsive">
									<table class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>  </th>
												<th> {{trans('app.no')}}          </th>
												<th> {{trans('app.name')}}        </th>
												<th> {{trans('app.phone')}}       </th>
												<th> {{trans('app.login_time')}}  </th>
												<th> {{trans('app.logout_time')}} </th>
												<th> </th>
											</tr>
										</thead>
										<tbody>
												<?php 
													$id = 0;
													if(isset($_REQUEST['page']))
														$id = $_REQUEST['page'] * $setting['pagesize']; 									
												?>
											@foreach($users as $useritem)
												<tr>
													<th  scope="row">   {{++$id}} </th>
													<td>{{$useritem->no}}</td>
													<td> {{$useritem->name}} </td>
													<td> {{$useritem->phone}} </td>
													<td> {{$useritem->last_login_at}}</td>
													<td>{{$useritem->created_at}}</td>
													<td>{{$useritem->created_at}}</td>

													<td> <a href = "/admin/users/updateemployee/{{$useritem->no}}"  type="button" class="btn btn-primary"> <i class="icon-edit"></i> </a> </td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
								<div class = "col-xs-12" style = "text-align:center;">
									{{$users->links()}}
								</div>
							</div>
						</div>
					 
				</div>
				 
				</div>
		</div>
      

@endsection