@extends('layouts.seller')
@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
		
			
			<br>
			
			<div class = "row">
				
				<div class = "col-xs-4">
					<form  action="/seller/coupons" method="get">
						<fieldset class="form-group position-relative">
							<input type="text" name = "key" value = "{{$setting['key']}}" class="form-control form-control-lg input-lg" id="iconLeft" placeholder=" {{trans('app.search')}} ">
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>
				</div>


				<div class = "col-xs-4 float-xs-right">
						<form id="w0" class="form-inline float-xs-right" action="/seller/coupons" method="get">
							<select id="schedulesearch-id_service" class="form-control" name="pagesize" onchange="this.form.submit()">
								<option value="10" <?php if($setting['pagesize'] == 10) echo "selected";?>><font><font>10</font></font></option>
								<option value="15" <?php if($setting['pagesize'] == 15) echo "selected";?>><font><font>15</font></font></option>
								<option value="20" <?php if($setting['pagesize'] == 20) echo "selected";?>><font><font>20</font></font></option>
								<option value="25" <?php if($setting['pagesize'] == 25) echo "selected";?>><font><font>25</font></font></option>
								<option value="30" <?php if($setting['pagesize'] == 30) echo "selected";?>><font><font>30</font></font></option>
							</select>
						</form>
				</div>
				
			</div>
			
			
			<div class="row">
				<div class="col-xs-12">
					<div class="card">
					<form class="form-horizontal" method = "post" action="{{URL::to('/')}}<?= "$_SERVER[REQUEST_URI]"  ?>">
						{{csrf_field()}}
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>{{trans('app.no')}}</th>
											<th>{{trans('app.name')}}</th>
											<th> {{trans('app.status')}} </th>
											<th> {{trans('app.type')}} </th>
											<th>  {{trans('app.amount')}} </th>
											<th> {{trans('app.start_date')}}  </th>
											<th> {{trans('app.end_date')}}  </th>
										</tr>
									</thead>
									<tbody>
								@if(count($coupons))	
									@foreach($coupons as $coupon)
										<tr>
											<th scope="row">{{$coupon->no}} </th>
											<th scope="row">{{$coupon->name}} </th>
											<td> 
												<select  class = "form-control" name ="sale_status_{{$coupon->no}}">
														<option value="1" <?php if($coupon->sale_status == "1") echo 'selected';  ?> > {{trans('app.working')}}   </option>	
														<option value="0" <?php if($coupon->sale_status == "0") echo 'selected';  ?> > {{trans('app.not_working')}} </option>	
												</select>
											</td>
											<td>
												<select  class = "form-control" name ="sale_type_{{$coupon->no}}">	
														<option value="0" <?php if($coupon->sale_type == "0") echo 'selected';  ?> > {{trans('app.fixed')}} </option>	
														<option value="1" <?php if($coupon->sale_type == "1") echo 'selected';  ?> > {{trans('app.percentage')}}   </option>
												</select>

											 
											</td>
											<td>   <input type = "text"  class = "form-control" name ="sale_amount_{{$coupon->no}}" onchange="this.form.submit()" value = "{{$coupon->sale_amount}}">   </td>
											<td>
												<div class='input-group date startdate sellersale'>
													<input id = "{{$coupon->no}}minval" type='text' class="form-control mindate" name = "startdate_{{$coupon->no}}" value = "{{$coupon->startdate}}" />
													<span class="input-group-addon min" id = "{{$coupon->no}}min" data-id = "{{$coupon->no}}">
														<i class="icon-calendar"></i>
													</span>
												</div>
											</td>

											<td>
												 <div class='input-group date enddate sellersale'>
													<input type='text' id = "{{$coupon->no}}maxval"   class="form-control maxdate" name = "enddate_{{$coupon->no}}" value = "{{$coupon->enddate}}"  />
													<span class="input-group-addon max" id = "{{$coupon->no}}max"  data-id = "{{$coupon->no}}">
														<i class="icon-calendar"></i>
													</span>
												</div>
											 </td>
										</tr>
									@endforeach
								@else
									<tr> <td colspan  = "8" class = "text-center">  {{trans('app.there_is_no_results')}}   </td></tr>
								@endif
									</tbody>
								</table>
							</div>
						
							<div class = "col-xs-12 text-center" style = "margin-bottom:15px;">
								{{$coupons->links()}}
							</div>

							<div class = "col-xs-12">
								<div class = "col-xs-12 text-center">
									<button type = "submit" class="btn btn-warning">  {{trans('app.apply')}} </a>
								</div>
							</div>


						</form>

					</div>
				</div>
				
				
			</div>
			

			
		</div>	
      


	  <div class=" timepickermodal modal fade text-xs-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				 
				</div>
				<div class="modal-body text-center">
				
					<div class="form-group">
						<div class="row">
							<div class="col-md-12">
								<div id="datetimepicker12"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal"> {{trans('app.close')}}</button>
				<button type="button" class="btn btn-outline-primary apply"> {{trans('app.apply')}}  </button>
				</div>
			</div>
			</div>
		</div>



@endsection