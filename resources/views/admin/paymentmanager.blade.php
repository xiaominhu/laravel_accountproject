@extends('layouts.admin')

@section('admincontent')

 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			<form  action="/admin/paymentmanager" method="post">
			
			 {{csrf_field()}}
			
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
 
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th> {{trans('app.no')}} </th>
											<th>{{trans('app.name')}}</th>
											<th> {{trans('app.status')}} </th>
										</tr>
									</thead>
									<tbody>
									
									@foreach($payments as $payment)
										<tr>
											<th scope="row">{{$payment->id}}</th>
											<td> {{$payment->name}} </td>
											<td> 
												<select class="form-control" name = "paymentmanager_{{$payment->id}}">
													<option value = "1" <?php  if($payment->status == 1) echo "selected" ?> > {{trans('app.activated')}}   </option>
													<option value = "0" <?php  if($payment->status == 0) echo "selected" ?>>  {{trans('app.deactivated')}}     </option>
												</select>
											</td>
										</tr>
										
									@endforeach
									
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>				
			</div>
			
			<div class = "row">
				<div class = "col-xs-10 text-right">
					<button type="submit" class="btn btn-warning">
						  {{trans('app.apply')}}
					</button>
				</div>
			</div>
		   	
			</form>
			
		</div>
      

@endsection