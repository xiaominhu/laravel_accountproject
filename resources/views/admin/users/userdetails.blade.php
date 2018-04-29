@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
				@if($errors->any())
				   <div class="alert alert-warning">
						 <ul>
							   @foreach ($errors->all() as $error)
								  <li>{{ $error }}</li>
							  @endforeach
						  </ul>
				   </div>
				@endif
		
			<div class = "row">

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

				<div class="form-group col-sm-12">
				  <label for="createvehicle_oil" class="col-sm-2 control-label">  {{trans('app.no')}}  </label>
				  <div class="col-sm-10">
					<input type="text" class="form-control"  readonly="readonly"  placeholder="" value = "{{$transaction->no}}">
				  </div>
				</div>
					
					
				<div class="form-group col-sm-12">
				  <label for="createvehicle_oil" class="col-sm-2 control-label"> {{trans('app.name')}}  </label>
				  <div class="col-sm-10">
					<input type="text" class="form-control" readonly="readonly"   placeholder="" value = "{{$transaction->name}}">
				  </div>
				</div>

				<!--div class="form-group col-sm-12 displaynone">
				  <label for="createvehicle_oil" class="col-sm-2 control-label"> {{trans('app.type')}}  </label>
				  <div class="col-sm-10">
				  	@if($transaction->type == "4")
						<input type="text" class="form-control"  readonly="readonly" value = "{{trans('app.pos_revenue')}} ">
						@elseif($transaction->type == "0")
							<input type="text" class="form-control"  readonly="readonly" value = "{{trans('app.pos_payment')}} ">
						@elseif($transaction->type == "1")
							<input type="text" class="form-control"  readonly="readonly" value = "{{trans('app.withdrawl')}}">
						@elseif($transaction->type == "2")
							<input type="text" class="form-control"  readonly="readonly" value = "{{trans('app.deposit')}} ">
						@elseif($transaction->type == "3")
							<input type="text" class="form-control"  readonly="readonly" value = "{{trans('app.reward')}}">
						@endif
				  </div>
				</div -->

				<div class="form-group col-sm-12">
				  <label for="createvehicle_oil" class="col-sm-2 control-label"> {{trans('app.amount')}}  </label>
				  <div class="col-sm-10">
				  	 
					<input type="text" class="form-control"  readonly="readonly" value = "{{$transaction->amount}}">
					 
				  </div>
				</div>

				@if($transaction->type == "0")
					<div class="form-group col-sm-12">
					  <label for="createvehicle_oil" class="col-sm-2 control-label"> {{trans('app.vehicle')}}  </label>
					  <div class="col-sm-10">
						<input type="text" class="form-control"  readonly="readonly" value = "{{$transaction->details->name}} - {{$transaction->details->state}}-{{$transaction->details->city}}">
					  </div>
					</div>
				@endif

				<div class="form-group col-sm-12">
				  <label for="createvehicle_oil" class="col-sm-2 control-label"> {{trans('app.date_opration')}}  </label>
				  <div class="col-sm-10">
					<input type="text" class="form-control"  readonly="readonly" value = "{{$transaction->regdate}}">
				  </div>
				</div>
			</div>	
			
			<div class = "row">
				<div class = "col-xs-12">
						<a href="{{URL::to('/admin/users/statement')}}/{{$transaction->sellerno}}" class="btn btn-primary  float-xs-right" style = "margin-right:50px;">
							{{trans('app.return')}}
						</a>
				</div>
			</div>

			</div>
		</div>
@endsection
 