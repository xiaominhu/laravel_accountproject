@extends('layouts.seller')

@section('admincontent')
 <div class="content-header row">
 </div>
        <div class="content-body"><!-- stats -->
			<?php
				$flag = isset($fuelstation) ? 1 : 0;
			?>
			@if($flag)
				<form class="form-horizontal" method = "post" action="/seller/fuelstation/update/{{$fuelstation->id}}">
			@else
				<form class="form-horizontal" method = "post" action="/seller/fuelstation/create">
			@endif
			
				{{csrf_field()}}
				
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
                  <label for="emailtemplate_config_subject" class="col-sm-2 control-label">  {{trans('app.name')}}  </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="name" name = "name" placeholder="" value = "<?php if($flag) echo $fuelstation->name;  ?>">
						@if ($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
                  </div>
                </div>
			
			
			
				<div class="form-group col-sm-12">
                  <label for="createvehicle_fuel" class="col-sm-2 control-label"> {{trans('app.fuel_type')}} </label>
                  <div class="col-sm-10">
						<select id="fuelstation_fuel" class = "form-control" multiple="multiple" name ="fuel[]" >
							<option value="1" <?php 
								if($flag) 
									if($fuelstation->f_g) echo "selected"; ?>> {{trans('app.green_fuel')}} </option>	
							<option value="2" <?php 
								if($flag) 
									if($fuelstation->f_r) echo "selected";?>>  {{trans('app.red_fuel')}} </option>	
							<option value="3" <?php if($flag) 
									if($fuelstation->f_d) echo "selected";?>> {{trans('app.diesel')}} </option>	
						</select>								 
                  </div>
                </div>
								 
								   
				<div class="form-group col-sm-12 invisible">
                  <label for="createvehicle_oil" class="col-sm-2 control-label">   {{trans('app.service_type')}} </label>
                  <div class="col-sm-10">
                    
					<select id="fuelstation_oil" class = "form-control" multiple="multiple" name ="oil[]" >
							<option value="1" <?php 
								if($flag)
									if($fuelstation->s_f) echo "selected";?> >   {{trans('app.fuel')}} </option>	
							<option value="2" <?php if($flag)
									if($fuelstation->s_w) echo "selected"; ?>>    {{trans('app.wash')}} </option>	
							<option value="3" <?php //if($lang == "en") echo "selected" ?>> {{trans('app.oil')}} </option>	
					</select>	
						
                  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_oil" class="col-sm-2 control-label">  {{trans('app.city')}} </label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="createvehicle_city" name = "city" placeholder="" value = "<?php if($flag) echo $fuelstation->city;  ?>">
						@if ($errors->has('city'))
							<span class="help-block">
								<strong>{{ $errors->first('city') }}</strong>
							</span>
						@endif
                  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_state" class="col-sm-2 control-label">   {{trans('app.state')}}  </label>
                  <div class="col-sm-10">
                    
					
						<select id = "createvehicle_state" class = "form-control" name ="state" >
							<option value=""> -- {{trans('app.choose_state')}} -- </option>	
							@if($flag)
								@foreach($states as $state)
									<option value="{{$state->zone_id}}"  <?php if($state->zone_id == $fuelstation->state) echo "selected";  ?> >{{$state->name}}</option>
								@endforeach
							@else
								@foreach($states as $state)
									<option value="{{$state->zone_id}}">{{$state->name}}</option>
								@endforeach
							@endif
						</select>
						@if ($errors->has('state'))
							<span class="help-block">
								<strong>{{ $errors->first('state') }}</strong>
							</span>
						@endif
                  </div>
                </div>
				
				<div class="form-group col-sm-12">
                  <label for="createvehicle_coutry" class="col-sm-2 control-label">  {{trans('app.country')}}  </label>
                  <div class="col-sm-10">
				    	<select id = "createvehicle_coutry" class = "form-control" name ="country" disabled>
							<option value=""> --{{trans('app.choose_country')}} -- </option>	
							@foreach($countries as $country)
								@if($flag)
									@if($country->country_id == $fuelstation->country)
										<option value="{{$country->country_id}}" selected>{{$country->name}}</option>
									@else
										<option value="{{$country->country_id}}">{{$country->name}}</option>
									@endif
								@else
									@if($country->country_id == '184')
										<option value="{{$country->country_id}}" selected>{{$country->name}}</option>
									@else
										<option value="{{$country->country_id}}">{{$country->name}}</option>
									@endif
								@endif
							  
							@endforeach
						</select>
                  </div>
                </div>
				
				<div class = "col-xs-12 text-center">
					<button type="submit" class="btn btn-primary">
						 {{trans('app.apply')}} 
					</button>
					<a href = "{{URL::to('/seller/fuelstation')}}" class="btn btn-primary">
						 {{trans('app.cancel')}} 
					</a>
				</div>
			</form>  				
		</div>
		<script>
		seller_create  = 1;
		var fuel_selection = '<?php
			$fule_array = array();
			if($flag){
				if($fuelstation->f_g) $fule_array[] = "1";
				if($fuelstation->f_r) $fule_array[] = "2";
				if($fuelstation->f_d) $fule_array[] = "3";
			}
			echo json_encode($fule_array);
		?>';
		
		var service_selection = '<?php
			
			$service_array = array();
			if($flag){
				if($fuelstation->s_f) $service_array[] = "1";
				if($fuelstation->s_w) $service_array[] = "2";
				if($fuelstation->s_o) $service_array[] = "3";
			}
			echo json_encode($service_array);
		?>';
		
		service_selection = JSON.parse(service_selection);
//Set up some of our variables.
var map; //Will contain map object.
var marker = false; ////Has the user plotted their location marker? 
        
		
		
function myMap() {
       //The center location of our map.
    var centerOfMap = new google.maps.LatLng(  <?php 
					if($flag) 
						echo $fuelstation->lat;
					else
						echo '24.71176900014207' ?>, <?php 
					if($flag)
						echo $fuelstation->lng;
					else echo '46.6718788149592' ?>);
 
    //Map options.
    var options = {
      center: centerOfMap, //Set center.
        zoom: 7,//The zoom value.
    };
 
     //Create the map object.
      map = new google.maps.Map(document.getElementById('map'), options);
 
     var myLatLng = {lat: <?php 
					if($flag) 
						echo $fuelstation->lat;
					else
						echo '24.71176900014207' ?>, lng: <?php 
					if($flag)
						echo $fuelstation->lng;
					else echo '46.6718788149592' ?>};

     var marker = new google.maps.Marker({
          position: myLatLng,
          map: map,
          title: ''
       });

    //Listen for any clicks on the map.
    google.maps.event.addListener(map, 'click', function(event) {                
        //Get the location that the user clicked.
        var clickedLocation = event.latLng;
        //If the marker hasn't been added.
        if(marker === false){
            //Create the marker.
            marker = new google.maps.Marker({
                position: clickedLocation,
                map: map,
                draggable: true //make it draggable
            });
            //Listen for drag events!
            google.maps.event.addListener(marker, 'dragend', function(event){
                markerLocation();
            });
        } else{
            //Marker has already been added, so just change its location.
            marker.setPosition(clickedLocation);
        }
        //Get the marker's location.
        markerLocation();
    });

	
	function markerLocation(){
		//Get location.
		var currentLocation = marker.getPosition();
		//Add lat and lng values to a field that we can save.
		document.getElementById('lat').value = currentLocation.lat(); //latitude
		document.getElementById('lng').value = currentLocation.lng(); //longitude
	}
	
}
		</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAsrLlI_6pd7UEiJBJCea3yOdZ6glxVzXk&callback=myMap"></script>		
@endsection