@extends('layouts.admin')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			<div class = "row">
				<div class = "col-xs-4">
					<a  href = "{{URL::to('/admin/getintouch/export')}}"  class="btn btn-primary">
						<i class="icon-file-excel"></i> {{trans('app.export_to_excel')}}  
					</a>
				</div>	
			</div>
			<br>
			<div class = "row">
				<div class = "col-xs-4">
					<form class="form-horizontal" method = "get" action="{{URL::to('/admin/getintouch')}}">
						<fieldset class="form-group position-relative">
							<input type="text" class="form-control form-control-lg input-lg" id="iconLeft" placeholder="  {{trans('app.serach')}}" name = "key" value = "{{$setting['key']}}">
							<div class="form-control-position">
								<i class="icon-ios-search-strong font-medium-4"></i>
							</div>
						</fieldset>
					</form>	
				</div>
				<div class = "col-xs-4 float-xs-right">
					<form id="w0" class="form-inline float-xs-right" action="{{URL::to('/admin/getintouch')}}" method="get">
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
						<form class="form-horizontal" method = "post" action="{{URL::to('/')}}<?= "$_SERVER[REQUEST_URI]" ?>">
							{{csrf_field()}}
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead>
										<tr>
											<th> {{trans('app.no')}}       </th>
											<th> {{trans('app.name')}}     </th>
											<th> {{trans('app.message')}}  </th>
											<th> {{trans('app.status')}}   </th>
											<th> {{trans('app.date_created')}} </th>
										</tr>
									</thead>
									<tbody>
										@if(count($messages))
											@foreach($messages as $message)
												<tr>
													<th scope="row">{{$message->no}}</th>
													<td> {{$message->name}} </td>
													<td> {{$message->message}} </td>
													<td> 
														<select class="form-control"  name = "status_{{$message->no}}" onchange="this.form.submit()">
															<option value = "1" <?php  if($message->status == 1) echo "selected" ?> >  {{trans('app.solved')}}   </option>
															<option value = "0" <?php  if($message->status == 0) echo "selected" ?>>   {{trans('app.not_solved')}}   </option>
														</select>
													</td>
													<td>{{$message->created_at}}</td>
												</tr>
											@endforeach
										@else
											<tr class = "text-center"> <td  colspan = '5'>	{{trans('there_is_no_results')}} </td> </tr>
										@endif
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
      

@endsection