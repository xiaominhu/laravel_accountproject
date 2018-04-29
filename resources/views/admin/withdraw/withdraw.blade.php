@extends('layouts.admin')
@section('admincontent')
 <div class="content-header row"></div>
        <div class="content-body"><!-- stats -->
			<div class = "row">
				<div class = "col-md-4">
					<a  href = "{{URL::to('admin/withdrawmanagement/export'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
						 <i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
					<a  href = "{{URL::to('/admin/withdrawmanagement/export/pdf'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
						 <i class="icon-file-pdf"></i> {{trans('app.export_to_pdf')}}  
					</a>
				</div>	
			</div>
			<br>

			<div class = "row">
				<form id = "time-setting" class="form-horizontal" method = "post" action="{{URL::to('/admin/setting')}}">
					{{csrf_field()}}
					<label for="emailtemplate_config_subject" class="col-xs-7 col-sm-4 control-label">  {{trans('app.withdrawl_time_limit_setting')}} </label>
					<div class="col-sm-2 col-xs-5  form-group">
							<div class='input-group date' id='limit_to'>
								<input type='text' class="form-control" name = "setting[withdraw_limit]"  value = "{{$setting['withdraw_limit']}}" onchange="this.form.submit()" />
								<span class="input-group-addon">
									<i class="icon-calendar"></i>
								</span>
							</div>
					</div>
				</form>	 
			</div>
			
			<div class = "row">
				<div class = "col-sm-3">
					<form class="form-horizontal" method = "get" action="{{URL::to('/admin/withdrawmanagement')}}">
						<fieldset class="form-group position-relative">
							<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder="{{trans('app.search')}}"  onchange="this.form.submit()" name = "key" value = "{{$setting['key']}}">
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
				</div>
				<div class = "col-sm-7">
					<a href = "{{URL::to('/admin/withdrawmanagement/userrequest')}}" class="btn btn-warning mbbt-5">  {{trans('app.add_operation_withdrawl_for_user')}}  </a>
				    <a href = "{{route('adminwithdraw')}}" class="btn btn-warning">  {{trans('app.withdrawl_for_admin')}}  </a>
				</div>
				 
				<div class = "col-md-2 float-xs-right">
						<form id="w0" class="form-inline float-xs-right" action="/admin/withdrawmanagement" method="get">
							<select id="service" class="form-control" name="pagesize" onchange="this.form.submit()">
								<option value="10" <?php if($setting['pagesize'] == 10) echo "selected";?>><font><font>10</font></font></option>
								<option value="15" <?php if($setting['pagesize'] == 15) echo "selected";?>><font><font>15</font></font></option>
								<option value="20" <?php if($setting['pagesize'] == 20) echo "selected";?>><font><font>20</font></font></option>
								<option value="25" <?php if($setting['pagesize'] == 25) echo "selected";?>><font><font>25</font></font></option>
								<option value="30" <?php if($setting['pagesize'] == 30) echo "selected";?>><font><font>30</font></font></option>
							</select>
						</form>
				</div>
				
			</div>
			
			<form class="form-horizontal" method = "post" action=" {{ Request::url() . ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}">
							{{csrf_field()}}
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

							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th> </th>
											<th>{{trans('app.no')}}       </th>
											<th> {{trans('app.seller_name')}}  </th>
											<th>  {{trans('app.phone')}}</th>
											
											<th> {{trans('app.request_amount')}}    </th>
											<th> {{trans('app.withdrawl_amount')}}  </th>
										    <th> {{trans('app.reg_date')}}  </th>
										    <th> {{trans('app.approve')}}  </th>
										</tr>
									</thead>
									<tbody>
									
									<?php 
										$id = 0;
										if(isset($_REQUEST['page']))
											$id = $_REQUEST['page'] * 10; 									
									?>
								@if(count($withdraws))
									@foreach($withdraws as $withdraw)
										<tr>
											<th> <?= ++$id; ?> </th>
											<th scope="row">{{$withdraw->no}}</th>
											<td> {{$withdraw->name}} </td>
											<td> {{$withdraw->phone}} </td>
											<td> {{$withdraw->amount}}</td>
											<td> {{$withdraw->final_amount}} </td>
											<td> {{$withdraw->created_at}} </td>
											<td>
												<div class="checkbox">
													<label>
														<input type="checkbox" <?php  
															if($withdraw->status == 1) echo "checked  ";
														 	if(Auth::user()->usertype != '2') echo "disabled";
														?> value="1" name = "status_{{$withdraw->no}}" onchange="this.form.submit()" > 
														@if($withdraw->status == 1) 
															<span class = "deep-purple lighten-1"> {{trans('app.approved')}}   </span>
														@else 
															<span class = "pink lighten-1"> {{trans('app.not_approved')}}  </span>
														@endif

													</label>
												</div>

 

											</td>
											 
										</tr>
									@endforeach
									
								@else
									<tr> <td colspan = "10" align = "center">  {{trans('app.there_is_no_results')}} </tr>
								@endif
									
									</tbody>
								</table>
							</div>
						
						    	<div class = "col-xs-12" style = "text-align:center;">
									{{$withdraws->links()}}
								</div>
						</div>
					</div>
				</div>
				
				
			</div>
			
			</form>
		
		</div>

		@push('scripts')
 
	     <script>
				$('#limit_to').datetimepicker({
					format: 'HH:mm',			 
				});

				$('#limit_to').on('dp.change', function(e){ 
						 $("#time-setting").submit();
				 });


		</script>

		@endpush

@endsection