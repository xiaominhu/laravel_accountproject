
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
					<th align = "center">  <BR> {{trans('app.no')}} </th>
					<th align = "center">  <BR>  {{trans('app.fuelstation_name')}} </th>
					<th align = "center">  <BR> {{trans('app.operation_type')}} </th>
					<th align = "center">  <BR>  {{trans('app.service_type')}} </th>
					<th align = "center">  <BR>  {{trans('app.state')}}         </th>
					<th align = "center">  <BR>  {{trans('app.city')}}</th>
					<th align = "center">  <BR>  {{trans('app.amount')}}</th>
					<th align = "center">  <BR>  {{trans('app.date_opration')}}   </th>
				</tr>
				</thead>
				<tbody>	 	
					 <?php  
						if(isset($_REQUEST['page'])){
							$i = $i *  10;
						}
						else  $i  = 0;
					  ?>
					@foreach( $transactions as $operation)
						<tr>
							<td align = "center"> {{++$i}}    </td>
							<td align = "center"> {{$operation->no}}   </td>
							<td align = "center">
										@if($operation-> details !== null)
											{{$operation->details->name}}  
										@endif
											 </td>	
						<td align = "center">
											@if($operation->type == '4')
												{{trans('app.pos_revenue')}}
											@elseif($operation->type == '5')
												{{trans('app.subscription_fees')}}
											@elseif($operation->type == '1')
												{{trans('app.deposit')}}
											@elseif($operation->type == '2')
												{{trans('app.withdrawl')}}
											@elseif($operation->type == '3')
												{{trans('app.reward')}}
											@endif
										</td>
								<td align = "center">
												@if($operation-> details !== null)
													@if($operation-> details ->service_type == "1")
														{{trans('fuel')}}
													@elseif($operation->  details ->service_type == "2")
														{{trans('oil')}}
													@elseif($operation->  details ->service_type == "3")
														{{trans('wash')}}
													@else
												  
													@endif 
												@endif
										 </td>
								<td align = "center">
										@if($operation-> details !== null)
											{{$operation->details->state}}  
										@endif
									</td>
								<td align = "center"> 
												@if($operation-> details !== null)   
													{{$operation->details->city}}  
												@endif
								 </td>
						<td align = "center">  {{$operation->amount}} </td>
						<td align = "center">  {{$operation->created_at}}  </td>
					</tr>
					@endforeach 
			</tbody>
		</table>

    </body>
</html>
