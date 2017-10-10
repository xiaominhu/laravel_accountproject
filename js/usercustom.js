
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
					  '<body style = "text-align: center;">' +   // onload="window.focus(); window.print(); window.close();"
					  '<h1> '+ $(this).data('name')  +' </h1>'+
					  '<img src="' + $(this).data('src') + '" style="width: 50%;" />' +
					  '<h3> '+ $(this).data('fuelname')  +' </h3>'+
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
	  

	$(document).on("click", ".sellersale  .input-group-addon", function(){

		var mindate = '', maxdate = '';

		if($(this).hasClass('min')){
			maxdate =	$(this).closest('tr').find('.maxdate').val();
		}
		else{
			mindate =  $(this).closest('tr').find('.mindate').val();
		 
		}

		if($('#datetimepicker12').data("DateTimePicker")  === undefined){

		}
		else
			$('#datetimepicker12').data("DateTimePicker").destroy();

		$('#datetimepicker12').datetimepicker({
			inline: true,
			format: 'YYYY-MM-DD',
			sideBySide: true
		});

	 
		if(maxdate != '')
			$('#datetimepicker12').data("DateTimePicker").maxDate(maxdate);
		
		if(mindate != '')
			$('#datetimepicker12').data("DateTimePicker").minDate(mindate);
		
		$(".timepickermodal .apply").attr('data-id', $(this).attr('id'));
		
		$(".timepickermodal").modal('show');
	});

	$(".timepickermodal .apply").click(function(){
		 var current_date = $('#datetimepicker12').data("date");
		 $("#" + $(this).attr('data-id')+ 'val').val(current_date);
		 $(".timepickermodal").modal('hide');
	});


	$('#service_type').change(function(event){
 
		if($(this).val() == "0" || $(this).val() == "4"){
			$(".pospay").each(function(){
				$(this).prop("disabled", false);
			});
		}
		else{
			$(".pospay").each(function(){
				$(this).prop("disabled", true);
			});
		}
	});

	/***********************************************************************************************************
	* 
	*				admin part  
	* 
	* 
	************************************************************************************************************/
	// add subscription


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

	function addSubscriptionName($type){

		$.ajax({
			url: "/admin/getallusers",
			type: "POST",
			data: {type: $type},
			dataType: "json",
			beforeSend: function () {
				$("#name_subscription").html( $(".name_subscription_hidden").html());
			},
			success: function (data) {
				if(data.status){
					var result = data. data, html= $(".name_subscription_hidden").html();
					for(var i = 0; i < result.length; i++){
						html += '<option value="'+ result[i].no +'">'+  result[i].name  +'</option>';
					}
					$("#name_subscription").html(html);
				 
				}
			},
			complete: function () {
			 
			}
		});
	}

	$(document).on("change", "#type_subscription", function(event){
		 if($(this).val() == "0"){
			 $(".userform").removeClass("hidden");
			 addSubscriptionName('user');
		 }

		 if($(this).val() == "1"){
			 $(".userform").addClass("hidden");
			 addSubscriptionName('seller');
		 }
	});

	$(document).on('click', '.adminmessage', function(){
		$.ajax({
			url: "/admin/message/item",
			type: "POST",
			data: { id :$(this).data('id')},
			dataType: "json",
			beforeSend: function () {
				
			},
			success: function (data) {
				 
				if(data.status){
					var data = data.data;
					$("#first_name").val(data.first_name);
					$("#last_name").val(data.first_name);
					$("#phone").val(data.phone);
					$("#email").val(data.email);
					$("#content").val(data.content);
					$(".adminmessagemodal").modal('show');
				}
			
				//$(".adminmessagemodal").modal('show');
			},
			complete: function () {
				//window.location.reload(true);		
			}
		});
	});
	
	 
 
 
 
 
 