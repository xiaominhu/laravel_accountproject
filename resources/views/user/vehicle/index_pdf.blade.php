
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
						<th align = "center"> 	{{trans('app.no')}}       </th>
						<th align = "center">    {{trans('app.name')}}  </th>
						<th align = "center">    {{trans('app.status')}}	 </th>
						<th align = "center">    {{trans('app.reg_date')}}  </th>
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
						<td align = "center">{{++$i}}</td>
						<td align = "center">{{$vehicle->no}}</td>
						<td align = "center">{{$vehicle->name}}</td>
						<td align = "center">
							@if($vehicle->status == 1) 
								{{trans('app.working')}} 
							@else
								{{trans('app.deleted')}} 
							@endif
						</td>
						<td align = "center"> {{$vehicle->created_at}}  </td>
					</tr>
					@endforeach  
				</tbody>
			</table>
    </body>
</html>
