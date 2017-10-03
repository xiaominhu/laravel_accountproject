

/*****************  chanage language *************************************************/

$(document).on("click", ".dropdown-item.language", function(){
	
	$.ajax({
		url: "/languages",
		type: "POST",
		data: { locale :$(this).data('lang')},
		dataType: "json",
		beforeSend: function () {
			
		},
		success: function (data) {
		},
		complete: function () {
			window.location.reload(true);		
		}
	});
});

/****************** admin users  details *********************/

function choosefeetype(type){
	$('.feesmanagement').addClass('hidden');
	$('.' + type).removeClass('hidden');
}


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

	  toastr["success"]("Copied URL");

	}

	//invitefriend
	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}
	 
	function validatephonenumber(str) {
		var isphone = /^(1\s|1|)?((\(\d{3}\))|\d{3})((\(\d{3}\))|\d{3})(\-|\s)?(\d{3})(\-|\s)?(\d{3})$/.test(str);
		 return isphone;
		 //966543632203
		// 543 632 203
		// 18601239864
	  }
	 // telephoneCheck("15555555555");

	function sendInvite(type, address, branch, content){
		$.ajax({
			url: "/user/invite",
			type: "POST",
			data: { type : type, content: content, branch: branch, address:address},
			dataType: "json",
			beforeSend: function () {
			},
			success: function (data) {
				
				toastr["success"]("Success");
			},
			complete: function () {
			}
		});
	} 


	$(".emailsendto").click(function(){
		if(validateEmail($("#inviteaddresss").val())){
			sendInvite('email', $("#inviteaddresss").val(), $(this).data('type'), $(this).data('content'));
		}
		else{
			toastr["error"]("Please add the correct address");
		}
	});

	
	$(".smssendto").click(function(){
	 
		if(validatephonenumber($("#inviteaddresss").val())){
			sendInvite('sms', $("#inviteaddresss").val(), $(this).data('type'),  $(this).data('content'));
		}
		else{
			toastr["error"]("Please add the correct address");
		}
	});
   
// qrcode print

	$(document).on("click", ".qrcodeprint", function(event){
		event.stopPropagation();
		event.preventDefault();
		var width = $(window).width() * 0.9;
		var height = $(window).height() * 0.9;
		var content = '<!DOCTYPE html>' + 
					  '<html>' +
					  '<head><title></title></head>' +
					  '<body onload="window.focus(); window.print(); window.close();">' + 
					  '<img src="' + $(this).data('src') + '" style="width: 100%;" />' +
					  '</body>' +
					  '</html>';
		var options = "toolbar=no,location=no,directories=no,menubar=no,scrollbars=yes,width=" + width + ",height=" + height;
		var printWindow = window.open('', 'print', options);
		printWindow.document.open();
		printWindow.document.write(content);
		printWindow.document.close();
		printWindow.focus();
	
	});
	
	function is_numeric(str) {
		var result = /^\d{0,2}(?:\.\d{0,2}){0,1}$/.test(str);
		 return result;
	}
	  
	  
	 
	$(document).on("change", ".feemanagement", function(event){
		if(is_numeric($(this).val()))
		{
			//$(this).closest('tr').find('')
			var item_id = $(this).data('id');
			var item_sibling = $(this).data('sibling');
			$(".feemanagement").each(function(){
				if(($(this).data("id") == item_id) && ($(this).data("sibling") != item_sibling))
					$(this).val("0");
			});
			$(".feesmanagement-form").submit();
		}
	});
	
 
 
 
 
 
 
 