var AdminUpdate = function () {
	var root = '';
	var $ = jQuery;
	
	return {
		init: function() {
			
			var on_process = false;
			
			$('.admin_udpate_spot').mouseenter(function() {
				if (!on_process) {
					$(this).addClass('admin_update_hover');
					$(this).prepend('<a href="" class="button_update admin_tmp_obj">Update</a>')
				}
			});
			
			$('.admin_udpate_spot').mouseleave(function() {
				$(this).removeClass('admin_update_hover');
				$('.admin_tmp_obj').remove();
			});
			
			$('body').on('click', 'a.button_update', function(e) {
				e.preventDefault();
				var my_parent = $(this).closest('.admin_udpate_spot');
				
				var width = 0;
				var height = 0;
				
				var width_attr = my_parent.attr('data-width');
				var height_attr = my_parent.attr('data-height');
				
				console.log(width_attr);
				if (typeof width_attr != 'undefined')
					width = width_attr;
				else {
					width = my_parent.width();
					my_parent.attr('data-width', width);
				}
				
				if (typeof height_attr != 'undefined')
					height = height_attr;
				else {
					height = my_parent.height();
					my_parent.attr('data-height', height);
				}
				
				height = parseInt(height) + 20;
				if (width < 200) width = 200;
				
				
				var date_id = my_parent.attr('data-id');
				$(this).remove();
				var html= my_parent.html();
								
				var regex = /<br\s*[\/]?>/gi;
				html = html.replace(regex, "\n");
				
				on_process = true;
				
				var html_form="<div><input type='hidden' id='admin_update_id' value='" + date_id + "'/>" 
					+ "<div class='hidden' id='admin_update_current_value'></div>"
					+ "<textarea id='admin_update_content' style='width:" + width + "px;height:" + height + "px;'>" + html 
					+ "</textarea><br/>&nbsp;<br />"
					+ "<input type='button' value='Save' class='button_update_save'/>&nbsp;&nbsp;"
					+ "<input type='button' value='Cancel' class='button_update_cancel' /></div>";
				my_parent.html(html_form);
				my_parent.find("#admin_update_current_value").html(html);
			});
			
			$('body').on('click', '.button_update_cancel', function() {
				on_process = false;
				var old_html = $(this).closest('div').find('#admin_update_current_value').html();
				$(this).closest('.admin_udpate_spot').html(old_html);
				$('.admin_tmp_obj').remove();
			});
			
			$('body').on('click', '.button_update_save', function() {
				var update_elem = $(this).closest('.admin_udpate_spot');
				var data_loc = update_elem.attr('data-location');
				var data_id = update_elem.attr('data-id');
				var data_value = update_elem.find('#admin_update_content').val();
				var old_value = update_elem.find('#admin_update_current_value').html();
				
				//alert(data_loc + ' - ' + data_id + ' --- ' + data_value);
				
				$.ajax({
					type:"POST",
					url: root + "/ajax/",
					dataType:'json',
					data:{mode:'UPDATE_OPTION', data_id:data_id, data_value:data_value},
					success: function(data){
						if (data.hasOwnProperty('done') && data.done === true) {
							on_process = false;
							if (data.hasOwnProperty('value')) {
								update_elem.html(data.value);
							}
							else {
								update_elem.html(old_value);
							}
						}
					},
					complete: function(jqXHR, textStatus) {
						$('.admin_tmp_obj').remove();
					}
			  });
			});
		}
	}
}(jQuery);