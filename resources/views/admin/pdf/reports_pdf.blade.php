
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
					<th align = "center">  <BR>  {{trans('app.no')}}	  </th>
					<th align = "center">   {{trans('app.name')}}	  </th>
					<th align = "center">  <BR> {{trans('app.vehicle')}} / {{trans('app.fuelstation')}} </th>
					<th align = "center">  <BR> {{trans('app.operation_type')}}  </th>
					<th align = "center">  <BR> {{trans('app.fees_type')}}  {{trans('app.operation')}}</th>
					<th align = "center">  <BR> {{trans('app.fees_type')}}  {{trans('app.subscription')}} </th>
					<th align = "center">  <BR> {{trans('app.state')}} </th>
					<th align = "center">  <BR> {{trans('app.city')}} </th>
					<th align = "center">  <BR> {{trans('app.amount')}}</th>
					<th align = "center">  <BR> {{trans('app.final_amount')}}</th>
					<th align = "center">  <BR> {{trans('app.admin_profit')}}</th>
					<th align = "center">  <BR> {{trans('app.sum')}}  </th>
					<th align = "center">  <BR>  {{trans('app.date_opration')}} </th>
				</tr>
				</thead>
				<tbody>	 			
					<?php  
						if(isset($_REQUEST['page'])){
								$i = ($i-1) *  10;
							}
							else  $i  = 0;
					?>
				@foreach($transactions as $transaction)
					<tr>
						<td align = "center"> {{++$i}}    </td>
						<td align = "center">{{$transaction->no}} </td>
						<td align = "center">
							@if($transaction->first_name)
								{{$transaction->first_name}} {{$transaction->last_name}}
							@else
								{{$transaction->name}}
							@endif
						 </td>
						 
						<td align = "center">
							@if($transaction->details !== null)
								{{$transaction->details->name}}
							@endif
						 </td>
						
						<td align = "center">
								@if($transaction->type == '4')
									{{trans('app.pos_revenue')}}
								@elseif($transaction->type == '0')
									{{trans('app.pos_payment')}}
								@elseif($transaction->type == '1')
									{{trans('app.deposit')}}
								@elseif($transaction->type == '2')
									{{trans('app.withdrawl')}}
								@elseif($transaction->type == '3')
									{{trans('app.reward')}}
								@elseif($transaction->type == '5')
									{{trans('app.subscription_fees')}}
								@elseif($transaction->type == '6')
									{{trans('app.send_money')}}
								@elseif($transaction->type == '7')
									{{trans('app.accept_money')}}
								@endif
						 </td>
						<td align = "center"> 
								@if($transaction->type == '4')
									{{trans('app.pos_revenue')}}
								@elseif($transaction->type == '0')
									{{trans('app.pos_payment')}}
								@elseif($transaction->type == '1')
									{{trans('app.deposit')}}
								@elseif($transaction->type == '2')
									{{trans('app.withdrawl')}}
								@elseif($transaction->type == '3')
									{{trans('app.reward')}}
								@elseif($transaction->type == '5')
									{{trans('app.subscription_fees')}}
								@elseif($transaction->type == '6')
									{{trans('app.send_money')}}
								@elseif($transaction->type == '7')
									{{trans('app.accept_money')}}
								@endif
						 </td>
						<td align = "center"> 
								@if($transaction->usertype == 0)
									{{trans('app.user')}}
								@endif
								@if($transaction->usertype == 1)
									{{trans('app.seller')}}
								@endif
						 </td>
						<td align = "center">
							@if($transaction->details !== null)
								{{$transaction->details->state}}
							@endif
						 </td>
						<td align = "center">
							@if($transaction->details !== null)
								{{$transaction->details->city}}
							@endif
						 </td>
						<td align = "center">{{$transaction->amount}} </td>
						<td align = "center">{{$transaction->final_amount}} </td>
						<td align = "center">
								{{$transaction->fee_amount}}
						 </td>
						<td align = "center">{{$transaction->profit}} </td>
						<td align = "center">{{$transaction->regdate}} </td>
					</tr>
				@endforeach  
			</tbody>
		</table>
    </body>
</html>
