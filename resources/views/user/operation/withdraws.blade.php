@extends('layouts.user')

@section('admincontent')
 <div class="content-header row"></div>
        <div class="content-body"><!-- stats -->
		
		@if(Session::has('status'))
			<div class="alert alert-primary alert-dismissible fade in mb-2" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<strong>Success!</strong>  
			</div> 
		@endif

			
					
			<div class = "row">
				<div class = "col-xs-4">
					
					<fieldset class="form-group position-relative">
						<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder=" {{trans('app.search')}} ">
						<div class="form-control-position">
							<i class="icon-ios-search-strong font-medium-4"></i>
						</div>
					</fieldset>
				</div>
				<div class = "col-xs-4">
					<a href = "{{URL::to('/user/operations/widthraw')}}" class="btn btn-warning">  {{trans('app.withdraw_request')}}  </a>
				</div>
				
				<div class = "col-xs-4 float-xs-right">
						<form id="w0" class="form-inline float-xs-right" action="{{URL::to('/user/operations/widthrawls')}}" method="get">
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
			
			<form class="form-horizontal" method = "post" action="{{URL::to('/user/operations/widthrawls')}}">
							{{csrf_field()}}
			<div class="row">
				
				<div class="col-xs-12">
					<div class="card">
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>  {{trans('app.no')}}  </th>
											<th> {{trans('app.withdrawl_amount')}} </th>
											<th>  {{trans('app.reg_date')}}  </th>
											<th>  {{trans('app.status')}} </th>
										</tr>
									</thead>
									<tbody>
									
									@foreach($withdraws as $withdraw)
										<tr>
											<th scope="row">{{$withdraw->no}}</th>
										
											<td> {{$withdraw->amount}}</td>
											<td>{{$withdraw->created_at}}</td>
											<td> 
												@if($withdraw->status == 1) 
													{{trans('app.approved')}}    
												@else 
													{{trans('app.not_approved')}}    
												@endif
											</td>
										</tr>
									@endforeach
									
									</tbody>
								</table>
							</div>
							
						 
						    	<div class = "col-xs-12" style = "text-align:center;">
									{{$withdraws->links()}}
								</div>
					</div>
				</div>
			</div>
			</form>
		</div>
		
@endsection