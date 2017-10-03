@extends('layouts.user')

@section('admincontent')
 <div class="content-header row">
 </div>
        
		<div class="content-body"><!-- stats -->
			<div class="form-group text-center col-sm-12">
				<h2> {{$vehicle->name}} </h2>
			</div>
			<div class="form-group text-center">
				<?php
					$style = "";
					$fuelname ="";
					$n = 11;
					switch ($vehicle->fuel) {
						case 1:
							 $style      = "border: solid 10px #4f4;";
							 $fuelname   = trans('app.green_fuel');
							break;
						case 2:
							  $style = "border: solid 10px #f00;";
							  $fuelname   = trans('app.red_fuel');
							break;
						case 3:
							  $style = "border: solid 10px #A52A2A;";
							  $fuelname   = trans('app.diesel');
							 break;
					}
				//border: solid 10px #f00;
				?>
				<img src = "{{URL::to('/images/qr')}}/{{$vehicle->qrcode}}" style = "{{$style}}" height = "360"> 
			</div>
			
			<div class="form-group text-center">
				 <h4 class = "pull-left"> <strong> {{$fuelname}} <strong> </h4> 
			</div>
			
			<div class="form-group col-sm-12">
				<div class = "row">
					 <div class = "col-sm-10">
						<input class="form-control border-primary" readonly type="url" placeholder="http://" value = "{{URL::to('/images/qr')}}/{{$vehicle->qrcode}}" id="invitelink">
					</div>
					<div class = "col-sm-2">
						<button type="button" class="btn btn-primary" onclick="copyToClipboard('#invitelink')">
							<i class="icon-copy2"></i>  {{trans('app.invitation_link')}}
						</button>
					</div>
				</div>
			</div>
								
								
			
			<div class="form-group col-sm-12">
			    <div class="col-sm-4">
					<input class="form-control border-primary"  type="text" placeholder="Email or Mobile Number" value = "" id="inviteaddresss">
			    </div>
			    <div class="col-sm-8">
					<button type="button" class="btn btn-primary emailsendto" data-type = "qrcode" data-content = "{{$vehicle->no}}">
						<i class="icon-envelope"></i>  {{trans('app.email_send_to')}} 
					</button>
					<button type="button" class="btn btn-primary smssendto"   data-type = "qrcode"  data-content = "{{$vehicle->no}}">
						<i class="icon-paper-plane-o"></i>   {{trans('app.send_by_sms')}} 
					</button>
					 							
					<button type="button" data-src = "{{URL::to('/images/qr')}}/{{$vehicle->qrcode}}" class="btn btn-primary  qrcodeprint"   data-type = "qrcode"  data-content = "{{$vehicle->no}}">
						<i class="icon-print"></i>   {{trans('app.print_qr')}} 
					</button>
					
					<a href = "{{URL::to('/user/vehicles')}}" type="button" class="btn btn-primary"   data-type = "qrcode"  data-content = "{{$vehicle->no}}">
						<i class="icon-undo"></i> {{trans('app.cancel')}} 
					</a>
					
			    </div>
			</div>
			
		</div>
@endsection