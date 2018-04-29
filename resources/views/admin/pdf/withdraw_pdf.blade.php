
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
						<th align = "center">  <BR>     {{trans('app.no')}}			 	 </th>
						<th align = "center">  <BR> 	{{trans('app.seller_name')}} 	 </th>
						<th align = "center">  <BR> 	{{trans('app.phone')}} 		 	 </th>
						<th align = "center">  <BR> 	{{trans('app.request_amount')}}   </th>
						<th align = "center">    	{{trans('app.withdrawl_amount')}}</th>
						<th align = "center">  <BR> 	{{trans('app.reg_date')}} 		  </th>
						<th align = "center">  <BR> 	{{trans('app.approve')}} 		</th>
				</tr>
				</thead>
				<tbody>
					<?php  
						if(isset($_REQUEST['page'])){
								$i = ($i-1) *  10;
							}
							else  $i  = 0;
					?>
			  
				@foreach($withdraws as $withdraw)
					<tr>
						 <td align = "center"> <?= ++$i; ?>   </td>
						 <td align = "center">{{$withdraw->no}} </td>
						 <td align = "center">{{$withdraw->name}}  </td>
						 <td align = "center">{{$withdraw->phone}}  </td>
						 <td align = "center">{{$withdraw->amount}}  </td>
						 <td align = "center">{{$withdraw->final_amount}}  </td>
						 <td align = "center">{{$withdraw->created_at}}  </td>
						<td align = "center">
							@if($withdraw->status == 1) 
								{{trans('app.approved')}}
							@else
								{{ trans('app.not_approved')}}
							@endif
						 </td>
					</tr> 
				@endforeach  
			</tbody>
		</table> 
    </body>
</html>
