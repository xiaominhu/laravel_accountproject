
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
					<th align = "center">  <BR> 	{{trans('app.name')}}  </th>
					<th align = "center">  <BR> 	{{trans('app.message')}}  </th>
					<th align = "center">  <BR> 	{{trans('app.type_message')}}  </th>
					<th align = "center">  <BR> 	{{trans('app.status')}}  </th>
					<th align = "center">  <BR> 	{{trans('app.date_created')}}  </th>
				</tr>
				</thead>
				<tbody>	 			
					<?php  
						if(isset($_REQUEST['page'])){
								$i = ($i-1) *  10;
							}
							else  $i  = 0;
					?>
				@foreach($messages as $message)
					<tr>
						<td align = "center"> {{++$i}}    </td>
						<td align = "center">{{$message->name}}</td>
						<td align = "center">{{$message->content}}</td>
						<td align = "center"> 	
							@if($message->type == '0')
								 {{trans('app.technical')}} 
							@elseif($message->type == '1')
								  {{trans('app.deposit')}} 
							@elseif($message->type == '2')
								 {{trans('app.withrwal')}} 
							@endif
						</td>
						<td align = "center">
							@if($message->status == 1) 
								{{trans('app.solved')}}
							@else
								{{trans('app.not_solved')}} 
							@endif
						</td>
						<td align = "center"> {{$message->created_at}}  </td>
					</tr>
				@endforeach 
				</tbody>
		</table>

    </body>
</html>
