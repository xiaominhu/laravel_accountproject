
	@extends('layouts.admin')
@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			<?php
				$flag = isset($fuelstation) ? 1 : 0;
			?>
			@if($errors->any())
			   <div class="alert alert-warning">
					 <ul>
						   @foreach ($errors->all() as $error)
							  <li>{{ $error }}</li>
						  @endforeach
					  </ul> 
			  </div>
			@endif
			<form class="form-horizontal" method = "get" action="/admin/map">
				<input type = "hidden"  name = "lat" id = "lat" value = "<?php 
					if($flag) 
						echo $fuelstation->lat;
					else
						echo '24.71176900014207' ?>">
				<input type = "hidden"  name = "lng" id = "lng" value = "<?php 
					if($flag)
						echo $fuelstation->lng;
					else echo '46.6718788149592' ?>">
					
	            <div id="map" style="width:100%;height:500px"></div>
	           
				<br>
				<br>
				
				<div class="form-group col-sm-12">
                  <label for="emailtemplate_config_subject" class="col-sm-2 control-label">  {{trans('app.fuel_station_name')}}  </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name = "name" placeholder="" value = "{{ $setting_val['name']}}" onchange="this.form.submit()">
                  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_fuel" class="col-sm-2 control-label">  {{trans('app.fuel_type')}}   </label>
                  <div class="col-sm-10">
						<select id="fuelstation_fuel" class = "form-control" multiple="multiple" name ="fuel[]" onchange="this.form.submit()">
							<option value="1" >   {{trans('app.green_fuel')}}   </option>	
							<option value="2">    {{trans('app.red_fuel')}} </option>	
							<option value="3"> {{trans('app.diesel')}}   </option>	
							<option value="4">   {{trans('app.wash')}}   </option>
						</select>								 
                  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_state" class="col-sm-2 control-label">  {{trans('app.state')}}  </label>
                  <div class="col-sm-10">
						<select id = "createvehicle_state" class = "form-control" name ="state" onchange="this.form.submit()">
							<option value="">     {{trans('app.all_states')}} </option>
								@foreach($states as $state)
									<option value="{{$state->zone_id}}"  <?php if($state->zone_id == $setting_val['state']) echo "selected";  ?> >{{$state->name}}</option>
								@endforeach
						</select>
                  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_coutry" class="col-sm-2 control-label">  {{trans('app.country')}}  </label>
                  <div class="col-sm-10">
				    	<select id = "createvehicle_coutry" class = "form-control" name ="country" onchange="this.form.submit()" disabled ="disabled">
							<option value="">  {{trans('app.all_countries')}} </option>	
							@foreach($countries as $country)
									@if($country->country_id == '184')
										<option value="{{$country->country_id}}" selected>{{$country->name}}</option>
									@else
										<option value="{{$country->country_id}}">{{$country->name}}</option>
									@endif
							@endforeach
						</select>
                  </div>
                </div>
				
				<div class = "col-xs-4 pull-right">
					<button type="submit" class="btn btn-primary">
						 {{trans('app.apply')}} 
					</button>
				</div>
			</form>  				
		</div>
		
		<script>
		
		var fuel_selection = '<?php
			echo json_encode($setting_val['fuel']);
		?>';
		
		fuel_selection = JSON.parse(fuel_selection);
		map_search = 1;
	    
		function initMap() {
			var myLatLng = {lat: <?= $setting_val['lat']  ?>, lng: <?= $setting_val['lng']   ?>};
			
			
			var map = new google.maps.Map(document.getElementById('map'), {
			  zoom: 8,
			  center: myLatLng
			});

			var lat_json = '<?= $fuel_json ?>';
			
			var lat_array =  JSON.parse(lat_json);
			
			for(var i = 0; i < lat_array.length; i++){
				var marker = new google.maps.Marker({
					  position: lat_array[i],
					  map: map
				});
			}
			
		}
		</script>


        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyIXfep7919J0jwyVuxDzqzj_qI-A26lI&callback=initMap">
		</script>
   
	
@endsection