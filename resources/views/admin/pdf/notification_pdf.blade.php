
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
		<title>Selfstation</title>
        <!-- Bootstrap Core CSS -->
		 
    </head>
    <body>
		<h1> {{$title}}</h1>
				<table border="1"  cellpadding="4">
					<thead>
						<tr>
							<th>      </th>
							<th align = "center">  <BR>  {{trans('app.no')}} 			       </th>
							<th align = "center">  <BR> 	{{trans('app.user_name')}} 		   </th>
							<th align = "center">  <BR> 	{{trans('app.name')}} 		       </th>
							<th align = "center">  <BR> 	{{trans('app.all_notification')}}  </th>
							<th align = "center">  <BR> 	{{trans('app.maximum_foramount')}} </th>
							<th align = "center">  <BR> {{trans('app.maximum_washes')}} </th>
							<th align = "center">  <BR>   {{trans('app.maximum_oil_changes')}}  </th>
							<th align = "center">  <BR> 	{{trans('app.maximum_times_day')}} </th>
							<th align = "center">  <BR> 	{{trans('app.status')}}             </th>
						</tr>
					</thead>
					<tbody>	 
					
				 	<?php  
						if(isset($_REQUEST['page'])){
								$i = ($i-1) *  10;
							}
							else  $i  = 0;
					?>
			  	
				@foreach($vehicles as $vehicle)
					<tr>
						<td align = "center"> {{++$i}}    </td>
						<td align = "center"> {{$vehicle->no}}</td>
						<td align = "center"> {{$vehicle->username}}</td>
						<td align = "center"> {{$vehicle->name}}</td>
					 
						<td align = "center">
							<?php
								switch($vehicle->usertype){
									case 0:
										echo  trans('app.yes');
										break;
									case 1:
										echo  trans('app.sms');
										break;
									case 2:
										echo trans('app.email');
										break;
								}
							?>
						</td>
					  
						<td align = "center"> {{$vehicle->not_amount}} </td>
						<td align = "center"> {{$vehicle->not_wash}} </td>
						<td align = "center"> {{$vehicle->not_oil}} </td>
						<td align = "center"> {{$vehicle->not_times}}  </td>
						<td align = "center"> 
							@if($vehicle->not_status)
									  {{trans('app.yes')}}
							@else
									 {{trans('app.no_en')}}
							@endif
						</td>
					</tr> 
				@endforeach
			</tbody>
		</table>

    </body>
</html>
