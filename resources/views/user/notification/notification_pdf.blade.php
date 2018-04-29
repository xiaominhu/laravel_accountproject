
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
		<title>Selfstation</title>
    </head>
    <body>
	 	<h1> {{$title}}</h1>
		<table border="1"  cellpadding="4">
				<thead>
					 <tr>
					 	<th>      </th>
					 	<th align = "center">  <BR>  {{trans('app.no')}}  </th>
						<th align = "center">  <BR> 	{{trans('app.name')}}  </th>
						<th align = "center">  <BR>  {{trans('app.all_notification')}} 	   </th>
						<th align = "center">  <BR> {{trans('app.maximum_foramount')}}	   </th>
						<th align = "center">  <BR> {{trans('app.maximum_washes')}} </th>
						<th align = "center">  <BR>   {{trans('app.maximum_oil_changes')}}</th>
						<th align = "center">    {{trans('app.maximum_times_day')}}     </th>
						<th align = "center">  <BR> {{trans('app.limit_operation_not')}}   </th>
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
						<td align = "center">{{$vehicle->no}} </td>
						<td align = "center">{{$vehicle->name}} </td>
						<td align = "center">
							@if($vehicle->not_type == 0)
								{{trans('app.yes')}} 
							@elseif($vehicle->not_type == 1)
								{{trans('app.sms')}} 
							@elseif($vehicle->not_type == 2)
								{{trans('app.email')}}
							@endif
						</td>
						<td align = "center"> {{$vehicle->not_amount}}</td>
						<td align = "center"> {{$vehicle->not_times}} </td>
						<td align = "center"> {{$vehicle->not_wash}} </td>
						<td align = "center"> {{$vehicle->not_oil}} </td>	
						<td align = "center">
							@if($vehicle->not_status == 0)
								{{trans('app.no_en')}}  
							@elseif($vehicle->not_status == 1)
								{{trans('app.notification_stop')}}   
							@elseif($vehicle->not_status == 2)
								{{trans('app.notification')}} 
							@endif
						</td>
					</tr>
					@endforeach
			 </tbody>
		</table>
			
    </body>
</html>
