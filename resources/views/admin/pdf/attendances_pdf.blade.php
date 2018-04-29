
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
				<th align = "center">  <BR>     {{trans('app.no')}}  </th>
				<th align = "center">  <BR> 	{{trans('app.name')}}  </th>
				<th align = "center">  <BR> 	{{trans('app.phone')}}  </th>
				<th align = "center">  <BR> 	{{trans('app.login_time')}} </th>
				<th align = "center">  <BR> 	{{trans('app.logout_time')}}  </th>
					</tr>
				</thead>
				<tbody>	 			
					<?php  
						if(isset($_REQUEST['page'])){
								$i = ($i-1) *  10;
							}
							else  $i  = 0;
					?>						
		 				
				@foreach($users as $useritem)
					<tr>
						<td align = "center"> {{++$i}}    </td>
						<td align = "center">{{$useritem->no}}</td>
						<td align = "center">{{$useritem->name}}</td>
						<td align = "center">{{$useritem->phone}}</td>
						<td align = "center">{{$useritem->last_login_at}}</td>
						<td align = "center">{{$useritem->created_at}}</td>
					</tr>
				@endforeach  
			 </tbody>
		</table>

    </body>
</html>
