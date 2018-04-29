@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
				  
			<form  action="/admin/withdrawmanagement/userrequest" method="post">	
				{{csrf_field()}}
				<div class = "row">
					<div class="col-xs-12">
					<div class="card">
							<div class="card-header">
								<h4 class="card-title"> {{$title}} </h4>
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
					 
	<br>
						<div class="form-group col-sm-12 required">
						  <label for="no" class="col-sm-2 control-label">   {{trans('app.no')}}  </label>
						  <div class="col-sm-6">
							<input type="text" class="form-control" id="no" name = "no" placeholder="{{trans('app.no')}}" value = "">
											@if ($errors->has('no'))
												<span class="help-block">
													<strong>{{ $errors->first('no')}}</strong>
												</span>
											@endif
						  </div>
						</div>
						
						<div class="form-group col-sm-12 required">
						  <label for="amount" class="col-sm-2 control-label">   {{trans('app.amount')}}  </label>
						  <div class="col-sm-6">
							<input type="text" class="form-control" id="amount" name = "amount" placeholder="{{trans('app.amount')}}" value = "">
											@if ($errors->has('amount'))
												<span class="help-block">
													<strong>{{ $errors->first('amount')}}</strong>
												</span>
											@endif
						  </div>
						</div>
				</div>	
			
				<div class = "row text-center">
					<div class = "col-xs-12">
						<button type="submit" class="btn btn-warning" style = "margin-right:50px; text-align:center;">
							  {{trans('app.apply')}}
						</button>
				</div>
			
			</div>
				<br>
		</form>	
				 </div>
		 
		</div>
		</div>
@endsection