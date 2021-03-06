@extends('layouts.admin')
 
@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			<div class = "row">
				<div class = "col-md-4">
					<a  href = "{{URL::to('admin/depositmanagement/export'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
						 <i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
					<a  href = "{{URL::to('/admin/depositmanagement/export/pdf'). ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}"  class="btn btn-warning">
						<i class="icon-file-pdf"></i> {{trans('app.export_to_pdf')}}  
					</a>
				</div>
			</div>
			<br>
			<div class = "row">
				<div class = "col-md-4 col-xs-8">
					<form class="form-horizontal" method = "get" action="{{URL::to('/admin/depositmanagement')}}">
						<fieldset class="form-group position-relative">
							<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder=" {{trans('app.search')}}" name = "key" value = "{{$setting['key']}}" >
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
				</div>
				
				<div class = "col-xs-4 float-xs-right">
					<form id="w0" class="form-inline float-xs-right" action="/admin/depositmanagement" method="get">
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
											<th>  </th>
											<th> {{trans('app.no')}}         </th>
											<th> {{trans('app.name')}}       </th>
											<th> {{trans('app.phone')}}      </th>
											<th> {{trans('app.type')}}       </th>
											<th> {{trans('app.amount')}}     </th>
										 
											<th> {{trans('app.attachment')}} </th>
											<th>{{trans('app.date')}}        </th>
											<th>  {{trans('app.approve')}}   </th>
										</tr>
									</thead>
									<tbody>
									<?php 
										$id = 0;
										if(isset($_REQUEST['page']))
											$id = ($_REQUEST['page'] -1 ) * 10; 									
									?>
								@if(count($deposits))	
									@foreach($deposits as $deposit)
										<tr>
											<th> <?= ++$id; ?> </th>
											<th scope="row"> {{$deposit->no}}    </th>
											<td>             {{$deposit->name}}  </td>
											<td>             {{$deposit->phone}} </td>
											<td> 
												<?php
													switch($deposit->type){
														case 0:
															echo   trans('app.bank');
															break;
														case 1:
															echo   trans('app.master');
															break;
														case 2:
															echo   trans('app.visa');
															break;
														case 3:
															echo   trans('app.sdad');
															break;
													}
												?>
											</td>
											<td> {{$deposit->real_amount}}</td>
											<td class = "text-center">  
													@if($deposit->notes)
														<a href = "{{URL::to('admin/download/attachment')}}/{{$deposit->no}}" > <i class="icon-paperclip2"></i>  <a>
													@endif
											</td>

											<td>{{$deposit->created_at}}</td>
											<td> 
												 
												
												<div class="checkbox">
													<label>
														<input type="checkbox" <?php  
															if($deposit->status == 1){
																 echo "checked  ";
																 if(Auth::user()->usertype!= "2")  echo "disabled";
															}
														?> value="1" name = "status_{{$deposit->no}}" onchange="this.form.submit()" > 
														@if($deposit->status == 1) 
															<span class = "deep-purple lighten-1"> {{trans('app.approved')}}   </span>
														@else 
															<span class = "pink lighten-1"> {{trans('app.not_approved')}}  </span>
														@endif
												
												
													</label>
												</div>


											</td>
										</tr>
									@endforeach
									
									</tbody>
								</table>
							
								@else
									<tr> <td colspan = "10" align = "center">  {{trans('app.there_is_no_results')}} </tr>
								@endif
							
							</div>
						
						    	<div class = "col-xs-12" style = "text-align:center;">
									{{$deposits->links()}}
								</div>
						</div>
					</div>
				</div>
				
				
			</div>
			
			</form>
		
		</div>
      

@endsection