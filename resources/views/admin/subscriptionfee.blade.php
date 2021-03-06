@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			<div class="row">
				<div class="col-xs-12">
 
					<div class="card">
						 <div class="card-header">
							<h4 class="card-title"> {{trans('app.subscription_fees')}} </h4>
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
							<div class="table-responsive">

 
								<form class="form-horizontal feesmanagement-form" method = "post" action=" {{ Request::url() . ( Request::getQueryString() ? '?' . Request::getQueryString() : '')}}">
								{{csrf_field()}}
									<table class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>  </th>
												<th> {{trans('app.no')}} 		    </th>
												<th> {{trans('app.name')}}		    </th>
												<th> {{trans('app.free_if_exceed')}} 	    </th>
												<th> {{trans('app.select')}} 	    </th>
												<th> {{trans('app.amount')}}     </th>
											</tr> 
										</thead>
										<tbody>
												<?php 
													$id = 0;
													if(isset($_REQUEST['page']))
														$id = ($_REQUEST['page'] - 1) * 5; 									
												?>
											@foreach($subscripttionfees as $item)
												<tr>
													<th  scope="row">   {{++$id}} </th>
													<td> {{$item-> no}} </td>
													<td>   
														@if($item->usertype == '0')
														{{trans('app.user')}}
														@else
															{{trans('app.seller')}}
														@endif
													</td>
													<td>  
														@if($item->usertype == '0')
															<input type = "text" class = "form-control"    name ="freeamount_{{$item->no}}" value = "{{$item->freeamount}}" onchange="this.form.submit()"> 
														@endif
													</td>
													<td>     
														@if($item->name == "0")
															{{trans('all')}}
														@else
															{{$item->username}}
														@endif
													</td>
													<td> <input type = "text" class = "form-control"    name ="amount_{{$item->no}}" value = "{{$item->amount}}" onchange="this.form.submit()">  </td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</form>
									<div class = "col-xs-12" style = "text-align:center;">
										{{$subscripttionfees->links()}}
									</div>
								
 
								<div class = "col-md-12 text-right">
									 <button style = "margin-bottom: 15px" type="button" class="btn btn-outline-warning  btn-lg" data-toggle="modal" data-keyboard="false" data-target="#keyboard">
										{{trans('app.add_new')}}  
									</button>
									<!-- Modal -->
									<div class="modal fade text-xs-left" id="keyboard" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
									  <div class="modal-dialog" role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true">&times;</span>
											</button> 
											<h4 class="modal-title" id="myModalLabel3"> {{trans('app.add_subscripttion_fee')}}  </h4>
										  </div>
										  <div class="modal-body">
											 	<form class="form-horizontal row" method = "post" action="/admin/subscription/add">
														{{csrf_field()}}
													<div class="form-group col-sm-12 required">
														<label for="type_subscription" class="col-sm-4 control-label"> {{trans('app.type')}}    </label>
														<div class="col-sm-8">
															<select id="type_subscription" class = "form-control" name ="usertype" >
																<option value="" >    {{trans('app.select')}}  </option>
																<option value="0">    {{trans('app.user')}}    </option>
																<option value="1">    {{trans('app.seller')}}  </option>
															</select>
														</div>
													</div>
													<div class = "hidden name_subscription_hidden">
														<option value="0" > {{trans('app.all')}}  </option>
													</div>
													<div class="form-group col-sm-12 required">
														<label for="name_subscription" class="col-sm-4 control-label"> {{trans('app.name')}}  </label>
														<div class="col-sm-8">
														 
															<select class="selectpicker" data-show-subtext="true" data-live-search="true" id = "name_subscription" name = "name">
																<option value="0" >   {{trans('app.all')}}  </option>
															</select>
														</div>
													</div>

													<div class="form-group col-sm-12 userform hidden">
														<label for="freeamount_subscription" class="col-sm-4 control-label"> {{trans('app.free_if_exceed')}}  </label>
														<div class="col-sm-8">
															<input type="number" class="form-control"  id="freeamount_subscription" name = "freeamount" placeholder="{{trans('app.number')}}" value = "">
														</div>
													</div>

													<div class="form-group col-sm-12 required">
														<label for="amount_subscription" class="col-sm-4 control-label"> {{trans('app.amount')}}  </label>
														<div class="col-sm-8">
															<input type="text" class="form-control"  id="amount_subscription" name = "amount" placeholder="{{trans('app.amount')}}" value = "">
														</div>
													</div>
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
											<button type="submit" class="btn btn-outline-primary">{{trans('app.add_new')}}</button>
										  </div>
										  </form>
										</div>
									  </div>
									</div>
								</div>
								<br>


								
							</div>
						</div>
					</div>

					 

				</div>
	    
				
			</div>
			
		</div>
      

@endsection