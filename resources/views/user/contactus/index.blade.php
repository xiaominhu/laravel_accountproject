@extends('layouts.user')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			  
				@if($message != "")
					 <div class="alert alert-success">
						{{$message}}
				   </div>
				@endif
		<div class="row">
			<div class="col-xs-12">
				<div class="card">
					<div class="card-header">		
				<h4 class="card-title" id="basic-layout-form"> Notification</h4>
						<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
						
							<div class="heading-elements">
								<ul class="list-inline mb-0">
									<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
									<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
									<li><a data-action="close"><i class="icon-cross2"></i></a></li>
								</ul>
							</div>
					</div>
					<div class="card-body collapse in">
					<div class="card-block">
		
		 
			<br/>
			<form  action="/user/contactus" method="post">	
				
				{{csrf_field()}}
			
			<div class = "row">
			
					<select id="schedulesearch-id_service" class="form-control" name="type" >
						<option value=""> -- {{trans('app.choose_complaint')}} --   </option>
						<option value="1">    {{trans('app.deposit_operation')}}    </option>
						<option value="2"> {{trans('app.withdrawal_operation')}} </option>
						<option value="0"> {{trans('app.techical_support')}}   </option>
					</select>
						
					
					<br>
					<br>
					<div class="form-group required">
						<label for="userinput8" class = "control-label">  {{trans('app.message')}}  </label>
						<textarea id="content" rows="15" class="form-control border-warning" name="content" placeholder="content" style=" margin-bottom: 0px;"></textarea>
					</div>
								
			
			
			
			</div>	
			
			<div class = "row">
				<div class = "col-xs-12">
						<button type="submit" class="btn btn-warning  float-xs-right" style = "margin-right:50px;">
						   <i class="icon-paper-plane-o"></i>
							 {{trans('app.send')}}
						</button>
				</div>
			</div>
				
		</form>	
				
				
			</div>
					</div>
				</div>
			</div>
	</div>
		
		
		</div>
@endsection