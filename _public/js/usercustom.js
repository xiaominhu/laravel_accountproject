

/************************* create new vehicle part **************************************/

$("#createvehicle_coutry").change(function(){
	
	var country_code = $(this).val();
	
	$.ajax({
		url: "/getcities",
		type: "POST",
		data: { country_code :country_code},
		dataType: "json",
		beforeSend: function () {
			
		},
		success: function (data) {
			
			$("#createvehicle_state").html("");
			
			var html = "<option value=''> -- Choose State -- </option>";
			
			if(data.status){
				for(var i = 0;  i < data.zones.length; i++){
					
					html += "<option value='"+  data.zones[i]['zone_id'] +"'>" +  data.zones[i]['name'] + "</option>";
				}
			}
			
			$("#createvehicle_state").html(html);
		},
		complete: function () {
			
		
		}
	});
	
});


// clpboard  
	function copyToClipboard(element) {
	  var $temp = $("<input>");
	  $("body").append($temp);
	  $temp.val($(element).val()).select();
	  document.execCommand("copy");
	  $temp.remove();
	}

