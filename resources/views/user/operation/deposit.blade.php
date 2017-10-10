@extends('layouts.user')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			  
				
			<div class = "row">
				<div class = "col-xs-6 float-xs-right">
						<form id="w0" class="form-inline float-xs-right" action="/user/operations/deposit" method="get">
							<select id="schedulesearch-id_service" class="form-control" name="cardtype" onchange="this.form.submit()" disabled>
								<option value=""> -- choose type -- </option>
								<option value="card" <?php if($setting['type'] == 'card') echo "selected";?>>    {{trans('app.visa_master_card')}}  </option>
								<option value="bank" <?php if($setting['type'] == 'bank') echo "selected";?>>   {{trans('app.transfer_bank')}}    </option>
								<option value="exist" <?php if($setting['type'] == 'exist') echo "selected";?>> {{trans('app.already_added_card')}}   </option>
								
							</select>
						</form>
				</div>
			</div>
			
			<br/>
			<br/>
			<form  action="/user/operations/deposit?cardtype={{$setting['type']}}" method="post"  enctype="multipart/form-data">	
				
				{{csrf_field()}}
			
			<div class = "row">
				@if($setting['type'] == 'bank')
						<div class="form-group col-sm-12">
						  <label for="amount" class="col-sm-2 control-label">  {{trans('app.amount')}}  </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="amount" name = "amount" placeholder="" value = "">
									@if ($errors->has('amount'))
											<span class="help-block">
												<strong>{{ $errors->first('amount')}}</strong>
											</span>
									@endif
					</div>
				</div>
					
						<div class="form-group col-sm-12">
						  <label for="full_name" class="col-sm-2 control-label">  {{trans('app.full_name')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="full_name" name = "full_name" placeholder="" value = "">
												@if ($errors->has('full_name'))
																<span class="help-block">
															<strong>{{ $errors->first('full_name')}}</strong>
														</span>
												@endif
						  </div>
						</div>
					
						<div class="form-group col-sm-12">
						  <label for="bank_name" class="col-sm-2 control-label">    {{trans('app.bank_name')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="bank_name" name = "bank_name" placeholder="" value = "">
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
						  </div>
						</div>


						<div class="form-group col-sm-12">
						  <label for="time" class="col-sm-2 control-label">  {{trans('app.time')}}  </label>
						  <div class="col-sm-10">
								<div class='input-group time' id='time'>
							  <input type="text" class="form-control"   name = "time" placeholder="" value = "">
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
						
						<div class="form-group col-sm-12">
						   
							  <label for="date" class="col-sm-2 control-label"> {{trans('app.date')}} </label>
								<div class="col-sm-10 form-group">
										<div class='input-group date' id='date'>
											<input type='text' class="form-control" name = "date" value = "" />
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
						
						
				
				@elseif($setting['type'] == 'card')
						
						<div class="form-group col-sm-12">
						  <label for="amount" class="col-sm-2 control-label">    {{trans('app.amount')}} </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="amount" name = "amount" placeholder="" value = "">
						  </div>
						</div>
					
						<div class="form-group col-sm-12">
							  <label for="cardno" class="col-sm-2 control-label">  {{trans('app.card_no')}} </label>
							  <div class="col-sm-10">
								<input type="text" class="form-control" id="cardno" name = "cardno" placeholder="" value = "">
							  </div>
						</div>
				
						<div class="form-group col-sm-12">
						  <label for="expireyear" class="col-sm-2 control-label">   {{trans('app.expire_date')}} </label>
						  <div class="col-xs-5">
							<select id = "expireyear" class = "form-control" name ="expireyear" >
								<?php 
									$year = (int) Date("Y");
									for($i = 0; $i < 30; $i++){ 
								?>								
									<option value="{{$year}}"> {{$year}} </option>	
								<?php $year++;  }?>
							</select>
						  </div>
						  
						   <div class="col-sm-5">
						    <select id = "expiremonth" class = "form-control" name ="expiremonth" >
								<?php 
									for($i = 0; $i < 12; $i++){ 
								?>								
									<option value="{{$i}}"> {{$i + 1}} </option>	
								<?php  }?>
							</select>
						  </div>
						</div>
				
						<div class="form-group col-sm-12">
						  <label for="holdername" class="col-sm-2 control-label">   {{trans('app.holder_name')}}    </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="holdername" name = "holdername" placeholder="" value = "">
						  </div>
						</div>
					
						<div class="form-group col-sm-12">
							  <label for="country" class="col-sm-2 control-label">    {{trans('app.issued_country')}}   </label>
							  <div class="col-sm-10">
							   
									<select id = "country" class = "form-control" name ="country" >
										<option value=""> --   {{trans('app.choose_country')}} -- </option>	
										
										@foreach($setting['countries'] as $country)
										  <option value="{{$country->country_id}}">{{$country->name}}</option>
										@endforeach
									</select>
							  </div>
						</div>
					
						<div class="form-group col-sm-12">
						  <label for="postalcode" class="col-sm-2 control-label">  {{trans('app.postal_code')}}   </label>
						  <div class="col-sm-10">
							<input type="text" class="form-control" id="postalcode" name = "postalcode" placeholder="" value = "">
						  </div>
						</div>
				
					
					
					
				@elseif($setting['type'] == 'exist')
					
					<div class="form-group col-sm-12">
						  <label for="cardno" class="col-sm-2 control-label"> {{trans('app.card_no')}}   </label>
						  <div class="col-sm-10">
								<select id = "existing_card" class = "form-control" name ="existing_card" >
										<option value=""> --  {{trans('app.choose_card')}} -- </option>	
										
										@foreach($setting['cards'] as $card)
										  <option value="{{$card->id}}">{{$card->cardno}}</option>
										@endforeach
								</select>
						  </div>
					</div>
							
					<div class="form-group col-sm-12">
					  <label for="amount" class="col-sm-2 control-label">   {{trans('app.amount')}}</label>
					  <div class="col-sm-10">
						<input type="text" class="form-control" id="amount" name = "amount" placeholder="" value = "">
											 
					  </div>
					</div>
				@else
				@endif

						<div class="form-group col-sm-12">
								<label for="coupon" class="col-sm-2 control-label">   {{trans('app.coupon')}}</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="coupon" name = "coupon" placeholder="" value = "">	
									   	@if ($errors->has('coupon'))
																<span class="help-block">
															<strong>{{ $errors->first('coupon')}}</strong>
														</span>
											@endif

										 

								</div>
						</div>

			</div>	
			
			<div class = "row">
				<div class = "col-xs-12 text-center">
						<button type="submit" class="btn btn-primary " style = "margin-right:50px;">
							 {{trans('app.apply')}}
						</button>

						<a type="submit" href = "{{URL::to('/user/operations/deposits')}}" class="btn btn-primary" style = "margin-right:50px;">
							 {{trans('app.cancel')}}
						</a>
				</div>
			</div>
			
			
		</form>	
				
				<script>
					deposit = 1;
				</script>
			
		
		
		</div>
@endsection