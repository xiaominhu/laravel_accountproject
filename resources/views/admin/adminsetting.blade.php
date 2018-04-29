@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
      <div class="content-body"><!-- stats -->
		<div class = "row">
			<div class = "col-xs-12">
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
					<form  action="{{URL::to('/admin/setting')}}" method="post" enctype="multipart/form-data">	
					{{csrf_field()}}
					<br>
					<div class = "row">
						<div class="form-group col-sm-12">
							<label for="createvehicle_oil" class="col-sm-3 control-label"> {{trans('app.reward_amount')}}  </label>
							<div class="col-sm-4">
							<input type="text" class="form-control" id="reward" name = "setting[reward]" placeholder="" value = "{{$settings['reward']}}">
							</div>
						</div>

						<div class="form-group col-sm-12">
							<label for="qrcodelimit" class="col-sm-3 control-label"> {{trans('app.minimum_cars_for_qrcode')}}  </label>
							<div class="col-sm-4">
							<input type="text" class="form-control" id="qrcodelimit" name = "setting[qrcodelimit]" placeholder="" value = "{{$settings['qrcodelimit']}}">
							</div>
						</div>


						<div class = "clearfix"> </div>
					</div>	
					<div class = "clearfix"> </div>
					<div class = "row">
						<div class = "col-xs-12 text-center">
							<button type="submit" class="btn btn-warning" style = "margin-right:50px;">
								<i class="icon-paper-plane-o"></i>
									{{trans('app.apply')}}
							</button>
						</div>
					</div>
					<div class = "clearfix"> </div>
				</form>
				</div>
				<br>
			</div>
		</div>
		</div>
@endsection