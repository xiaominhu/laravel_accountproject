
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
						<th align = "center">  <BR>     {{trans('app.no')}} </th>
						<th align = "center">  <BR> 	{{trans('app.name')}} </th>
						<th align = "center">  <BR> 	{{trans('app.email')}} </th>
						<th align = "center">  	{{trans('app.phone')}}</th>
						<th align = "center">  <BR> 	{{trans('app.type')}} </th>
						<th align = "center">  <BR> 	{{trans('app.status')}} </th>
						<th align = "center">  <BR> 	{{trans('app.email_approve')}} </th>
						<th align = "center">   	{{trans('app.phone_approve')}} </th>
						<th align = "center">  <BR> 	{{trans('app.last_login')}} </th>
						<th align = "center">  <BR> 	{{trans('app.reg_date')}} </th>
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
					<td align = "center">{{$useritem->email}}</td>
					<td align = "center">{{$useritem->phone}}</td>
					<td align = "center">
							<?php
								switch($useritem->usertype){
									case 0:
										echo trans('app.user');
										break;
									case 1:
										echo  trans('app.seller');
										break;
									case 2:
										echo trans('app.admin');
										break;
								}
							?>
						</td>
					<td align = "center">
							@if($useritem->status == 1) 
								{{trans('app.activated')}}
							@else
								{{trans('app.deactivated')}} 
							@endif
					</td>
					<td align = "center">
								@if($useritem->email_verify)
										  {{trans('app.yes')}}
								@else
										 {{trans('app.no_en')}}
								@endif
					</td>
					<td align = "center">
								@if($useritem->phone_verify)
										  {{trans('app.yes')}}
								@else
										 {{trans('app.no_en')}}
								@endif
					</td>
					<td align = "center"> {{$useritem->last_login_at}}</td>
					<td align = "center"> {{$useritem->created_at}}</td>
					</tr> 
				@endforeach  
			 </tbody>
		</table>

    </body>
</html>
