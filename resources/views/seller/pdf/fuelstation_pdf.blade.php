
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
					<th align = "center">  <BR>   {{trans('app.no')}} </th>
					<th align = "center">  <BR> 	{{trans('app.name')}} </th>
					<th align = "center">  <BR>	{{trans('app.position')}} </th>
					<th align = "center">  <BR> 	{{trans('app.status')}} </th>
					<th align = "center">  <BR>	{{trans('app.pos_status')}} </th>
					<th align = "center">  <BR> 	{{trans('app.reg_date')}} </th>
					</tr>
				</thead>
				<tbody>	 	
					 <?php  
						if(isset($_REQUEST['page'])){
							$i = $i *  10;
						}
						else  $i  = 0;
					  ?>
					@foreach($fuelstations as $fuelstation)
						<tr>
							<td align = "center"> {{++$i}}    </td>
							<td align = "center"> {{$fuelstation->no}}   							     </td>
							<td align = "center"> {{$fuelstation->name}} 							     </td>
							<td align = "center"> {{$fuelstation->statename}} -  {{$fuelstation->city}} </td>
							<td align = "center"> 	
								@if($fuelstation->status == 1)
									 {{trans('app.working')}}
								@else
									 {{trans('app.not_working')}} 
								@endif
							</td>
							<td align = "center">
								@if($fuelstation->pos_status == 1)
									{{trans('app.working')}} 
								@else
									{{trans('app.not_working')}} 
								@endif
							</td>
							<td align = "center"> {{$fuelstation->created_at}} </td>
						</tr>
					@endforeach 
				 
			</tbody>
		</table>
		 

    </body>
</html>
