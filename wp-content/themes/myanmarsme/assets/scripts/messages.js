var Messages = function () {
	var view_url = '';
	var ajax_url = '';
	var current_company_id = 0;
	
	var mark_as_read = function(elem, id)
	{		
		$.ajax({
			url: ajax_url,
			type:"POST",
			dataType:'json',
			data:{mode:'MESSAGE_MARK_READ', message_id: id }			
		}).done(function(data) {
			if (data.hasOwnProperty('done') && data.done === true) {
				if (data.hasOwnProperty('success') && data.success === true) {
					$(elem).removeClass('unread');
				}
			}
		});
	}
	
	var send_message = function(message, to_company_id, msg_reply_to_id)
	{
    	$('.loading').removeClass('hidden');
    	$("#send_message").prop('disabled', true);
    	$.ajax({
        	type: "POST",
        	url: ajax_url,
			dataType:'json',
			data:{mode:'SEND_MESSAGE',s_cid:current_company_id, t_cid:to_company_id, message: message, reply_to : msg_reply_to_id},
			success: function(data){
				if (data.hasOwnProperty('done') && data.done === true) {
					if (data.hasOwnProperty('success') && data.success === true) {
						$('.alert-success').html('<i class="fa fa-check"></i> Your message was sent');
						$('.alert-success').removeClass('hidden');
						$("#send_message").prop('disabled', true);
						sent = true;
					}
					else {
						$('.alert-danger').html('<i class="fa fa-warning"></i> There was a problem sending your message');
						$('.alert-danger').removeClass('hidden');
					}
				}
				else {
					$('.alert-danger').html('<i class="fa fa-warning"></i> There was a problem sending your message');
					$('.alert-danger').removeClass('hidden');
				}
				$('.loading').addClass('hidden');
			},
			complete : function() {
    			if (!sent)
    			    $("#send_message").prop('disabled', false);
			}
        });
	}
	
    return {
        //main function to initiate the module
        init: function (_view_url, _ajax_url, _current_company_id) {
        	view_url = _view_url;
        	ajax_url = _ajax_url;
        	current_company_id = _current_company_id;
        	
        	$('.message_row td').hide();
        	
            $('.mail-group-checkbox').click(function() {
            	if ($(this).is(":checked"))
            		$('.mail-checkbox').prop('checked', true);
            	else
            		$('.mail-checkbox').prop('checked', false);
            });
            
            $('.data_message').click(function() {
            	var id = $(this).attr('data-id');
            	var read = $(this).attr('data-read');
            	
            	if (id > 0) {
	            	$('.message_row td').hide('fast');
	            	$('.message_row').addClass('hidden');
	            	$('#message_row_' + id).removeClass('hidden');
	            	$('#message_row_' + id + ' td').show('fast');
	            	
	            	if (read == 0)
	            		mark_as_read(this, id);
            	}
            });
            
            $(".btn_reply").click(function(e) {
            	e.preventDefault();
            	var to_company_id = $(this).attr('rel');
            	var msg_reply_to_id = $(this).attr('data-id');
            	
            	
            	if (to_company_id) {
            		$("#to_company_id").val(to_company_id);
            		$("#msg_reply_to_id").val(msg_reply_to_id);
            		var company_name = $(this).attr('data-name');
            		if (company_name.length > 0)
            			$("#reply_to_company_name").text(company_name);            		
            		$("#modal_message_window").modal();
            	}
            });
            
            $("#send_message").click(function() {
            	var to_company_id = $("#to_company_id").val();
            	var msg_reply_to_id = $("#msg_reply_to_id").val();
            	var message = $("#message_text").val();

            	if (to_company_id > 0 && message.length > 5)
            		send_message(message, to_company_id, msg_reply_to_id);
            	else if (message.length < 5) {
            		$('.alert-danger').html('Message text is too small');
                    $('.alert-danger').removeClass('hidden');
            	}
            	else {
            		$('.alert-danger').html('There is a problem sending your message');
                    $('.alert-danger').removeClass('hidden');
            	}
            });
        }

    };

}();