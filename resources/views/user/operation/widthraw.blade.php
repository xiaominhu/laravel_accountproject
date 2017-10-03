@extends('layouts.user')

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
				
			<br/>
			<br/>
			<form  action="/user/operations/widthraw" method="post">	
				{{csrf_field()}}
				<div class = "row">
						<div class="form-group col-sm-12">
						  <label for="amount" class="col-sm-2 control-label">   {{trans('app.amount')}}  </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="amount" name = "amount" placeholder="" value = "">
						  </div>
						</div>
				</div>	
			
			<div class = "row">
				<div class = "col-xs-12">
						<button type="submit" class="btn btn-primary  float-xs-right" style = "margin-right:50px;">
							  {{trans('app.apply')}}
						</button>
				</div>
			</div>
		</form>	
				
		</div>
@endsection