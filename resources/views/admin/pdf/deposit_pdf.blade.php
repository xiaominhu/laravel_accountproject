
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
						<th align = "center">  <BR>     {{trans('app.no')}}     </th>
						<th align = "center">  <BR>  	{{trans('app.name')}}   </th>
						<th align = "center">  <BR>  	{{trans('app.phone')}}  </th>
						<th align = "center">  <BR>  	{{trans('app.type')}}   </th>
						<th align = "center">  <BR>  	{{trans('app.amount')}}  </th>
						<th align = "center">  <BR>  	{{trans('app.date')}}    </th>
						<th align = "center">  <BR>  	{{trans('app.approve')}} </th>
					</tr>
			</thead>
		<tbody>
				<?php  
					if(isset($_REQUEST['page'])){
						$i = $i *  10;
					}
					else  $i  = 0;
				 ?>
				@foreach($deposits as $deposit)
					<tr>
						<td align = "center"> <?= ++$i; ?>  </td>
						<td align = "center">{{$deposit->no}}</td>
						<td align = "center">{{$deposit->name}}</td>
						<td align = "center">{{$deposit->phone}}</td>
						<td align = "center">
							<?php
								switch($deposit->type){
									case 0:
										echo   trans('app.bank');
										break;
									case 1:
										echo   trans('app.master');
										break;
									case 2:
										echo   trans('app.visa');
										break;
									case 3:
										echo   trans('app.sdad');
										break;
								}
							?>
						</td>
						<td align = "center">{{$deposit->real_amount}}</td>
						<td align = "center">{{$deposit->created_at}}</td>
						<td align = "center">
							@if($deposit->status == 1) 
									  {{trans('app.approved')}}
							@else
									 {{trans('app.not_approved')}}
							@endif
						</td>
					</tr> 
				@endforeach  
			</tbody>
		</table>
    </body>
</html>
