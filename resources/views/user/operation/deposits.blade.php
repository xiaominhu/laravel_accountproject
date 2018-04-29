@extends('layouts.user')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
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
				<div class="card-block">
			<div class = "row">
				<div class = "col-md-4">
					<form class="form-horizontal" method = "get" action="{{URL::to('/user/operations/deposits')}}">
						<fieldset class="form-group position-relative">
							<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder=" {{trans('app.search')}}" name = "key" value = "{{$setting['key']}}" >
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
				</div>
				<div class = "col-md-4">
					<a href = "{{URL::to('/user/operations/deposit?cardtype=bank')}}" class="btn btn-warning">  {{trans('app.deposit_request')}}  </a>
				</div>
				<div class = "col-md-4 float-xs-right">
					<form id="w0" class="form-inline float-xs-right" action="{{URL::to('/user/operations/deposits')}}" method="get">
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
			
			<form class="form-horizontal" method = "post" action="{{URL::to('/user/operations/deposits')}}">
			    {{csrf_field()}}
				<div class="row">
					<div class="col-xs-12">
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
										<th> {{trans('app.date')}}        </th>
										<th> {{trans('app.approve')}}   </th>
									</tr>
								</thead>
								<tbody>
								
									<?php 
										$id = 0;
										if(isset($_REQUEST['page']))
											$id = ($_REQUEST['page'] - 1 )  * $setting['pagesize']; 									
									?>

								@foreach($deposits as $deposit)
									<tr>
										<th  scope="row">   {{++$id}} </th>
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
												<a href = "{{URL::to('user/download/attachment')}}/{{$deposit->no}}" > <i class="icon-paperclip2"></i>  <a>
											@endif
										</td>
										<td>{{$deposit->created_at}}</td>
										<td> 
											@if($deposit->status == 1) 
												<span class = "deep-purple lighten-1">  {{trans('app.approved')}}    </span>
											@else 
												<span class = "pink lighten-1"> {{trans('app.not_approved')}}    </span>
											@endif
										</td>
									</tr>
								@endforeach
								
								</tbody>
							</table>
						</div>
						<div class = "col-xs-12" style = "text-align:center;">
							{{$deposits->links()}}
						</div>
					</div>
				</div>
			</form>
		</div>
				 </div>
    								  </div>
								</div>
					</div>
		</div>

@endsection