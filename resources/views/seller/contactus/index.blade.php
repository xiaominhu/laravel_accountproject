@extends('layouts.seller')
@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
				@if($errors->any())
				   <div class="alert alert-warning">
						 <ul>
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						  </ul>
				   </div>
				@endif
				@if($message != "")
					 <div class="alert alert-success">
						{{$message}}
				   </div>
				@endif
				
			<br/>
			<br/>
			<form  action="/seller/contactus" method="post">	
				
				{{csrf_field()}}
			
			<div class = "row">
			
					<select id="schedulesearch-id_service" class="form-control" name="type" >
						<option value=""> -- {{trans('app.choose_complaint')}}  --   </option>
						<option value="1">  {{trans('app.deposit_operation')}}     </option>
						<option value="2">   {{trans('app.withdrawal_operation')}}  </option>
						<option value="0">   {{trans('app.techical_support')}}    </option>
					</select>
					<br>
					<br>
					<div class="form-group">
						<label for="userinput8">   {{trans('app.message')}}     </label>
						<textarea id="content" rows="15" class="form-control border-primary" name="content" placeholder="content" style=" margin-bottom: 0px;"></textarea>
					</div>
			</div>	
			
			<div class = "row">
				<div class = "col-xs-12">
						<button type="submit" class="btn btn-primary  float-xs-right" style = "margin-right:50px;">
						   <i class="icon-paper-plane-o"></i>
							 {{trans('app.send')}}
						</button>
				</div>
			</div>
		</form>	
		</div>
@endsection