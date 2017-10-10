@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->

			<div class = "row">
				<div class = "col-xs-4">
					<a  href = "{{URL::to('/admin/messsages/export')}}"  class="btn btn-primary">
						 <i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
				</div>	
			</div>
			<br>



			<div class = "row">
				<div class = "col-xs-4">
					<form class="form-horizontal" method = "get" action="{{URL::to('/admin/messsages')}}">
						<fieldset class="form-group position-relative">
							<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder="  {{trans('app.search')}}" name = "key" value = "{{$setting['key']}}">
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
				</div>
				<div class = "col-xs-4 float-xs-right">
					<form id="w0" class="form-inline float-xs-right" action="/admin/messsages" method="get">
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
											<th> {{trans('app.no')}} </th>
											<th> {{trans('app.name')}}</th>
											<th> {{trans('app.message')}}</th>
											<th> {{trans('app.type_message')}} </th>
											<th> {{trans('app.status')}}       </th>
											<th> {{trans('app.date_created')}} </th>
										</tr>
									</thead>
									<tbody>
										@foreach($messages as $message)
											<tr>
												<th scope="row">{{$message->id}}</th>
												<td><a href = "#" class = "adminmessage" data-id = "{{$message->id}}"> {{$message->name}} </td>
												<td> {{ \Illuminate\Support\Str::words($message->content, 2)}} </td>
												<td> 
													@if($message->type == '0')
														 {{trans('app.technical')}} 
													@elseif($message->type == '1')
														  {{trans('app.deposit')}} 
													@elseif($message->type == '2')
														 {{trans('app.withrwal')}} 
													@endif
												</td>
												<td> 
													<select class="form-control"  name = "status_{{$message->id}}" onchange="this.form.submit()">
														<option value = "1" <?php  if($message->status == 1) echo "selected" ?> >  {{trans('app.solved')}}   </option>
														<option value = "0" <?php  if($message->status == 0) echo "selected" ?>>   {{trans('app.not_solved')}}   </option>
													</select>
												</td>
												<td>{{$message->created_at}}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</form>
							<div class = "col-xs-12" style = "text-align:center;">
								{{$messages->links()}}
							</div>
					</div>
				</div>
			</div>
		</div>

 
		<div class="adminmessagemodal fade text-xs-left modal" id="small" tabindex="-1" role="dialog" aria-labelledby="myModalLabel19" style="display: none;" aria-hidden="true">
			<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				<h4 class="modal-title" id="myModalLabel19">  {{trans('app.message')}}    </h4>
				</div>
				<div class="modal-body">
			 		
				 	<div class = "row">		 
						<div class="form-group col-sm-12">
						  <label for="first_name" class="col-sm-2 control-label">  {{trans('app.first_name')}}   </label>
						  <div class="col-sm-10">
							<input readonly  type="text" class="form-control" id="first_name" name = "first_name" placeholder="" value = "">
						  </div>
						</div>
					</div>
					<div class = "row">		 
						<div class="form-group col-sm-12">
						  <label for="last_name" class="col-sm-2 control-label">  {{trans('app.last_name')}}   </label>
						  <div class="col-sm-10">
							<input readonly type="text" class="form-control" id="last_name" name = "last_name" placeholder="" value = "">
						  </div>
						</div>
					</div>	

					<div class = "row">		 
						<div class="form-group col-sm-12">
						  <label for="phone" class="col-sm-2 control-label">  {{trans('app.phone')}}   </label>
						  <div class="col-sm-10">
							<input readonly type="text" class="form-control" id="phone" name = "phone" placeholder="" value = "">
						  </div>
						</div>
					</div>	



					<div class = "row">		 
						<div class="form-group col-sm-12">
						  <label for="email" class="col-sm-2 control-label">  {{trans('app.email')}}   </label>
						  <div class="col-sm-10">
							<input readonly type="text" class="form-control" id="email" name = "email" placeholder="" value = "">
						  </div>
						</div>
					</div>	


					<div class = "row">		 
						<div class="form-group col-sm-12">
						  <label for="content" class="col-sm-2 control-label">  {{trans('app.message')}}   </label>
						  <div class="col-sm-10">
							<textarea readonly id="content" rows="5" class="form-control border-primary" name="content" placeholder="content"  ></textarea>
						  </div>
						</div>
					</div>
						 
					 
			
			 


				</div>
				<div class="modal-footer">
				<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
				 
				</div>
			</div>
			</div>
		</div>


@endsection