
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
					<th align = "center">  <BR> {{trans('app.no_operation')}}  </th>
					<th align = "center">  <BR>  {{trans('app.name')}}</th>
					<th align = "center">  <BR>  {{trans('app.phone')}} </th>
					<th align = "center">  <BR>  {{trans('app.type_operation')}} </th>
					<th align = "center">  <BR> {{trans('app.amount_operation')}}  </th>
					<th align = "center">  <BR>  {{trans('app.date_operation')}} </th>
				</tr>
				 <?php  
					if(isset($_REQUEST['page'])){
						$i = $i *  10;
					}
					else  $i  = 0;
				 ?>
			  	
				@foreach($transactions as $transaction)
					<tr>
						<td align = "center"> {{++$i}}    </td>
						<td align = "center"> {{$transaction->no}}</td>
						<td align = "center"> {{$transaction->name}}</td>
						<td align = "center">{{$transaction->phone}}</td>
						<td align = "center"> 
								@if($transaction->type == '4')
									{{trans('app.pos_revenue')}} 
								@elseif($transaction->type == '1')
									{{trans('app.deposit')}}
								@endif
						</td>
						<td align = "center">{{$transaction->amount}}</td>
						<td align = "center">{{$transaction->operation_date}}</td>
					</tr>
				@endforeach  
				 
			</tbody>
		</table>

    </body>
</html>
