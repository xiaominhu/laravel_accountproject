<html>
	<head>
	<title></title>
	</head>
	<body style="text-align: center;">
						<?php
								$style = "";
								$fuelname_en ="";
								$fuelname_sa ="";
								switch ($vehicle->fuel) { 
									case 1:
										$style      = "border: solid 10px #4f4;width: 400px;";
										$fuelname_en   =  'Green Fuel91';
										$fuelname_sa   = 'اخضر 91';
										$fuelname   = trans('app.green_fuel');
										break;
									case 2:
										$style = "border: solid 10px #f00;width: 400px;";
										$fuelname_en   = 'Red Fuel95';
										$fuelname_sa   = 'احمر 95';
										$fuelname   = trans('app.red_fuel');
										break;
									case 3:
										$style = "border: solid 10px #00f; width: 400px;";
										$fuelname_en   = 'Diesel';
										$fuelname_sa   = 'ديزل';  
										$fuelname   = trans('app.diesel');
										break;
									default: 
										 $fuelname_en   = 'All';
										 $fuelname_sa   = 'الكل';
								}
							//border: solid 10px #f00;
							?>
		<h1> {{$vehicle->name}} </h1>
			<img src="{{URL::to('/')}}/images/qr/{{$vehicle->qrcode}}"   style = "{{$style}}" >
		 
		<h4 class = "pull-left"> <strong> {{$fuelname_en}} <strong>  <strong> {{$fuelname_sa}} <strong> </h4> 
	</body>
</html>