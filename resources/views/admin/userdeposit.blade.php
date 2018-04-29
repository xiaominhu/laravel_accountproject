@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
				  
			<form  action="{{route('admindeposit')}}" method="post" enctype="multipart/form-data">
				{{csrf_field()}}
				<div class = "row">
					<div class="col-xs-12">
					<div class="card">
							<div class="card-header">
								<h4 class="card-title"> {{$title}} </h4>
								<a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
									<div class="heading-elements">
											<ul class="list-inline mb-0">
												<li><a data-action="collapse"><i class="icon-minus4"></i></a></li>
												<li><a data-action="expand"><i class="icon-expand2"></i></a></li>
												<li><a data-action="close"><i class="icon-cross2"></i></a></li>
											</ul>
									</div> 
 
							</div> 
						<div class = "card-body"> 
            	    <div class = "card-block">     
							@if(Session::has('success'))
								<div class="alert alert-warning mb-2" role="alert">
										{{trans('app.request_sent_success')}}
								</div>
							@endif
							
						<div class="form-group col-sm-12 required">
						    <label for="user_id" class="col-sm-2 control-label">  {{trans('app.user')}}  </label>
							<div class="col-sm-10">
								<select  type="text" class="form-control selectpicker" id="user_id" name = "user_id" data-show-subtext="true" data-live-search="true" id = "name_subscription">
									<option> {{trans('app.choose_users')}} </option>
										@foreach($users as $user)	
											@if(old('user_id') == $user->no)
												<option value = "{{$user->no}}" selected data-tokens="{{$user->name}}  {{$user->no}} {{$user->phone}}"> {{$user->name}} - {{$user->no}}  </option>
											@else
												<option value = "{{$user->no}}"  data-tokens="{{$user->name}}  {{$user->no}} {{$user->phone}}"> {{$user->name}} </option>
											@endif
										@endforeach
								</select>
								@if ($errors->has('user_id'))
									<span class="help-block">
										<strong>{{ $errors->first('user_id')}}</strong>
									</span>
								@endif
							</div>
						</div>

                        <div class="form-group col-sm-12 required">
						    <label for="amount" class="col-sm-2 control-label">  {{trans('app.amount')}}  </label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="amount" name = "amount" placeholder="{{trans('app.amount')}}" value = "{{old('amount')}}">
								@if ($errors->has('amount'))
									<span class="help-block">
										<strong>{{ $errors->first('amount')}}</strong>
									</span>
								@endif
							</div>
						</div>


					
						<div class="form-group col-sm-12 required">
						  <label for="full_name" class="col-sm-2 control-label">  {{trans('app.full_name')}} </label>
						  <div class="col-sm-10">
								<input type="text" class="form-control" id="full_name" name = "full_name" placeholder=" {{trans('app.full_name')}} " value = "{{old('full_name')}}">
								@if ($errors->has('full_name'))
												<span class="help-block">
											<strong>{{ $errors->first('full_name')}}</strong>
										</span>
								@endif
						  </div>
						</div>
					
						<div class="form-group col-sm-12 required">
						  <label for="bank_name" class="col-sm-2 control-label">    {{trans('app.bank_name')}} </label>
						    <div class="col-sm-10">
								<select id="bank_name" name = "bank_name"   class="selectpicker form-control"  title="{{trans('app.choose_bank')}}">
										<option <?php if(old('bank_name') == "مصرف الراجحي") echo "selected"; ?>>مصرف الراجحي </option>
										<option <?php if(old('bank_name') == "بنك الرياض")   echo "selected"; ?>>بنك الرياض</option>
										<option <?php if(old('bank_name') == "مصرف الانماء")  echo "selected"; ?>>مصرف الانماء</option>
								</select> 
								@if ($errors->has('bank_name'))
									<span class="help-block">
										<strong>{{ $errors->first('bank_name')}}</strong>
									</span>
								@endif
						    </div>
						</div>
 
					 	<div class="form-group col-sm-12">
						  <label for="attachment" class="col-sm-2 control-label">    {{trans('app.attachment')}}   </label>
						  <div class="col-sm-10">
							<input type="file" class="form-control" id="attachment" name = "attachment" placeholder="" value = "">
							  @if ($errors->has('attachment'))
											<span class="help-block">
											<strong>{{ $errors->first('attachment')}}</strong>
										</span>
								@endif
						  </div>
						</div>
 
						<div class="form-group col-sm-12 required">
						  <label for="time" class="col-sm-2 control-label">  {{trans('app.time')}}  </label>
						  <div class="col-sm-10">
								<div class='input-group time' id='time'>
							  <input type="text" class="form-control"   name = "time" placeholder="{{trans('app.time')}}" value = "{{old('time')}}">
								<span class="input-group-addon">
									<i class="icon-calendar"></i>
								</span>
											@if ($errors->has('time'))
													<span class="help-block">
															<strong>{{ $errors->first('time')}}</strong>
													</span>
											@endif
										</div>
						  </div>
						</div>
						
						<div class="form-group col-sm-12 required">
							  <label for="date" class="col-sm-2 control-label"> {{trans('app.date')}} </label>
							  <div class="col-sm-10 form-group">
									<div class='input-group date' id='date'>
										<input type='text' class="form-control" placeholder = "{{trans('app.date')}}" name = "date" value = "{{old('date')}}" />
										<span class="input-group-addon">
											<i class="icon-calendar"></i>
										</span>
										@if ($errors->has('date'))
											 <span class="help-block">
												<strong>{{ $errors->first('date')}}</strong>
											 </span>
										@endif
									</div>
							  </div>
						</div>
						 

					</div>

				        </div>	
			
				<div class = "row text-center">
					<div class = "col-xs-12">
						<button type="submit" class="btn btn-warning" style = "margin-right:50px; text-align:center;">
							  {{trans('app.apply')}}
						</button>
				</div>
			
			</div>
				<br>
		</form>	
				 </div>
		 
		</div>
		</div>


        @push('scripts')
			<script>
				$('#date').datetimepicker({
						format: 'YYYY-MM-DD',
				});
				$('#time').datetimepicker({
						format: 'HH:mm',
				});
				
			
			</script>
		@endpush


@endsection