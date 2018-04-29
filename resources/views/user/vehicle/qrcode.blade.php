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
						<div class="form-group text-center col-sm-12">
							<h2 style = "direction: ltr;"> {{$vehicle->name}} </h2>
						</div>
						<div class="form-group text-center">
							<?php
								$style = "";
								$fuelname_en ="";
								$fuelname_sa ="";
								switch ($vehicle->fuel) {
									case 1:
										$style      = "border: solid 10px #4f4;";
										$fuelname_en   =  'Green Fuel91';
										$fuelname_sa   = 'اخضر 91';
										$fuelname   = trans('app.green_fuel');
										break;
									case 2:
										$style = "border: solid 10px #f00;";
										$fuelname_en   = 'Red Fuel95';
										$fuelname_sa   = 'احمر 95';
										$fuelname   = trans('app.red_fuel');
										break;
									case 3:
										$style = "border: solid 10px #00f;";
										$fuelname_en   = 'Diesel';
										$fuelname_sa   = 'ديزل';
										$fuelname   = trans('app.diesel');
										break;
									default:
										$fuelname   = trans('app.all');
										break;
								}
							?>
							<img src = "{{URL::to('/images/qr')}}/{{$vehicle->qrcode}}" style = "{{$style}}" height = "360"> 
						</div>
						
						<div class="form-group text-center">
							<h4 class = "pull-left"> <strong> {{$fuelname_en}} <strong>  <strong> {{$fuelname_sa}} <strong> </h4> 
						</div>
						
						<div class="form-group col-sm-12">
							<div class = "row">
								<div class = "col-sm-10">
									<input class="form-control border-warning" readonly type="url" placeholder="http://" value = "{{URL::to('/vehicles/qrcode/')}}/{{$vehicle->no}}" id="invitelink">
								</div>
								<div class = "col-sm-2">
									<button type="button" class="btn btn-warning" onclick="copyToClipboard('#invitelink')">
										<i class="icon-copy2"></i>  {{trans('app.invitation_link')}}
									</button>
								</div>
							</div>
						</div>

						<div class="form-group col-sm-12">
							<div class="col-sm-4">
								<input class="form-control border-warning"  type="text" placeholder="example@gmail.com" value = "" id="inviteaddresss_email">
							</div>
							<div class="col-sm-8">
								<button type="button" class="btn btn-warning emailsendto" data-type = "qrcode" data-content = "{{$vehicle->no}}">
									<i class="icon-envelope"></i>  {{trans('app.email_send_to')}} 
								</button>
								 
							</div>
						</div>
 
						<div class="form-group col-sm-12">
							<div class="col-sm-4">
								 
								<div class="intl-tel-input allow-dropdown">
									<div class="flag-container">
										<div class="selected-flag" tabindex="0">
											<div class="iti-flag sa"> </div> 
											<div class="iti-arrow1">(+966)</div>
										</div>
									</div>
										<input  id="inviteaddresss_sms" class="form-control border-warning" name = "phone"  placeholder = "123456789"  type="tel" autocomplete="off">
							    </div>
							</div>
							<div class="col-sm-8">
								<button type="button" class="btn btn-warning smssendto"   data-type = "qrcode"  data-content = "{{$vehicle->no}}">
									<i class="icon-paper-plane-o"></i>   {{trans('app.send_by_sms')}} 
								</button>					
								<button type="button" data-src = "{{URL::to('/images/qr')}}/{{$vehicle->qrcode}}" class="btn btn-warning  qrcodeprint"  data-name ="{{$vehicle->name}}" data-fuelname = "{{$fuelname}}"    data-type = "qrcode"  data-content = "{{$vehicle->no}}">
									<i class="icon-print"></i>   {{trans('app.print_qr')}} 
								</button>
								<a href = "{{URL::to('/user/vehicles')}}" type="button" class="btn btn-warning"  data-type = "qrcode"  data-content = "{{$vehicle->no}}">
									<i class="icon-undo"></i> {{trans('app.cancel')}} 
								</a>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	   		@push('scripts')
				<link href="{{ URL::asset('app-assets/build/css/intlTelInput.css') }}" rel="stylesheet" type="text/css">
				 <style>
						.iti-arrow1{
							position: absolute;
							margin-top: 2px;
							right: 6px;
							width: 0;
							height: 0;
							border-top: 4px solid #555;
						}
				</style>
				<script>
					// qrcode print
					$(document).on("click", ".qrcodeprint", function(event){
						event.stopPropagation();
						event.preventDefault();
						var width = $(window).width() * 0.9;
						var height = $(window).height() * 0.9;

						<?php
								$style = "";
								$fuelname_en ="";
								$fuelname_sa ="";
								switch ($vehicle->fuel) {
									case 1:
										$style      = "border: solid 10px #4f4;";
										$fuelname_en   =  'Green Fuel91';
										$fuelname_sa   = 'اخضر 91';
										$fuelname   = trans('app.green_fuel');
										break;
									case 2:
										$style = "border: solid 10px #f00;";
										$fuelname_en   = 'Red Fuel95';
										$fuelname_sa   = 'احمر 95';
										$fuelname   = trans('app.red_fuel');
										break;
									case 3:
										$style = "border: solid 10px #00f;";
										$fuelname_en   = 'Diesel';
										$fuelname_sa   = 'ديزل';
										$fuelname   = trans('app.diesel');
										break;
								}
							?>


						var content = '<!DOCTYPE html>' + 
									'<html>' +
									'<head><title></title></head>' +
									'<body style = "text-align: center;"  onload="window.focus(); window.print(); window.close();">' +  
									'<h1> '+ $(this).data('name')  +' </h1>' +
									'<img src="' + $(this).data('src') + '" style = "{{$style}}" />' +
									'<h3>  <strong> {{$fuelname_en}} <strong>   <strong> {{$fuelname_sa}} <strong> </h3>'+
									'</body>' +
									'</html>';
						var options = "toolbar=no,location=no,directories=no,menubar=no,scrollbars=yes,width=" + width + ",height=" + height;
						var printWindow = window.open('', 'print', options);
						printWindow.document.open();
						printWindow.document.write(content);
						printWindow.document.close();
						printWindow.focus();
					});

				</script>

		@endpush
</div>
@endsection