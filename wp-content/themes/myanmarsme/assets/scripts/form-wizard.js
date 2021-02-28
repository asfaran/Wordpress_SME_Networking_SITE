var FormWizard = function () {
	
	var image_on = template_directory_uri + '/images/check_box_status_1.png';
	var image_off = template_directory_uri + '/images/check_box_status_0.gif';
	
	change_child_status = function(s_ele, ele, status) {
		s_ele.closest('.panel-heading').find('.check-sign').remove();
		s_ele.hide();
		if (status == true) {
			$('input[type=text]', ele).removeAttr("readonly");
			$('input[type=checkbox]', ele).removeAttr("disabled");
			$('input[type=radio]', ele).removeAttr("disabled");			
			s_ele.before('<div style="background:url(\'' + image_on + '\') 50% 50% no-repeat;width:25px;height:16px;" class="pull-left check-sign"></div>');
			//s_ele.after("<div class='check-sign pull-right' style='color:green;font-size:120%;'><i class='fa fa-check-square-o'> </i></div>");
		}
		else {
			$('input[type=text]', ele).attr("readonly", "readonly");
			$('input[type=checkbox]', ele).attr("disabled", "disabled");
			$('input[type=radio]', ele).attr("disabled", "disabled");
			s_ele.before('<div style="background:url(\'' + image_off + '\') 50% 50% no-repeat;width:25px;height:16px;" class="pull-left check-sign"></div>');
			//s_ele.after("<div class='check-sign pull-right' style='color:grey'><i class='fa fa-check-square-o'> </i></div>");
		}
	};
	
	update_initial_status = function(target) {
		//target.css("display", "none");
		target.closest('.panel-heading').css("cursor","pointer");
		var is_checked = target.is(":checked");
        var next_item = target.closest('.panel-heading').next();
        change_child_status(target, next_item, is_checked);     
        target.closest('.panel-heading').click(function() {
        	target.trigger("click");
        });
        
        target.mouseenter(function() {
        	//target.attr('disabled', 'disabled');
        })
        .mouseleave(function() {
        	//target.removeAttr('disabled');
        });
	};
	
	var verify_company_email = function() {
		$('.company_email_verify').blur(function() {
			var email = $(this).val();
			if (email.length > 0) {
				ajax_check_if_email_exists(email);
			}
		});
	};
	
	var ajax_check_if_email_exists = function(email) {
		$.ajax({
			type:"POST",
			url:site_url + "/ajax/",
			dataType:'json',
			data:{mode:'FIND_COMPANY_BY_EMAIL', email: email},
			success: function(data){
				if (data.hasOwnProperty('success') && data.success === true) {
					if (data.hasOwnProperty('company_id') && data.company_id > 0) {
						bootbox.alert('A company named "' + data.company_name + '" is already registred with the given email address.');
					}
				}   
				else if (data.hasOwnProperty('done') && data.done == false) {
					if (data.hasOwnProperty('message')) {
						//bootbox.alert(data.message);
					}
				}
			}
	  });
	};

    return {
        //main function to initiate the module
        init: function () {
            if (!jQuery().bootstrapWizard) {
                return;
            }

            function format(state) {
                if (!state.id) return state.text; // optgroup
                return "<img class='flag' src='assets/img/flags/" + state.id.toLowerCase() + ".png'/>&nbsp;&nbsp;" + state.text;
            }

            $("#country_list").select2({
                placeholder: "Select",
                allowClear: true,
                formatResult: format,
                formatSelection: format,
                escapeMarkup: function (m) {
                    return m;
                }
            });
            
            verify_company_email();
            
            
            
            /*$("input[name=biz_needs_partner_in\\[\\]]").click(function() {
            	var is_checked = $(this).is(':checked');
            	if (is_checked) {
            		$("input[name=biz_need_partner]").prop('checked', true);
            	}
            });*/

            var form = $('#submit_form');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);

            form.validate({
                doNotHideMessage: true, //this option enables to show the error/success messages on tab switch.
                errorElement: 'span', //default input error message container
                errorClass: 'help-block', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                rules: {
                    //general info
                    company_name: {
                        minlength: 5,
                        required: true
                    },
                    country_of_incorporate: {
                        required: true
                    },
                    location_head_office: {
                        required: true
                    },
					
					/*year_of_incorporate: {
						digits: true,
                        required: true,
						min: 1820,
						max: 2015
                    },*/
					business_registration: {
                        required: true
                    },
                    //mailing address
                    address_number: {
						//digits: true,
                        required: true
                    },
					
                    address_city: {
                        required: true
                    },
                    address_country: {
                        required: true
                    },
                   
                    //contact details
                    contact_person: {
                        required: true
                    },
                    contact_telephone: {
                        required: true,
                    },
					address_country: {
                        required: true
                    },
                    contact_email: {
                        required: true,
						email: true,
                    },
                    contact_position: {
                        required: true
                    },
			summary: {
				maxlength: 360
			},
                },

                invalidHandler: function (event, validator) { //display error alert on form submit   
                    success.hide();
                    error.show();
                    App.scrollTo(error, -850);
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },

                success: function (label) {
                    if (label.attr("for") == "gender" || label.attr("for") == "payment[]") { // for checkboxes and radio buttons, no need to show OK icon
                        label
                            .closest('.form-group').removeClass('has-error').addClass('has-success');
                        label.remove(); // remove error label here
                    } else { // display success icon for other inputs
                        label
                            .addClass('valid') // mark the current input as valid and display OK icon
                        .closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    }
                },

                submitHandler: function (form) {
                    success.show();
                    error.hide();
                    //add here some ajax code to submit your form or just call form.submit() if you want to submit the form without ajax
                }

            });

            var displayConfirm = function() {
                $('#tab5 .form-control-static', form).each(function(){
                    
					var input = $('[name="'+$(this).attr("data-display")+'"]', form);
					
                    if (input.is(":radio")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
					
					if (input.is(":checkbox")) {
                        input = $('[name="'+$(this).attr("data-display")+'"]:checked', form);
                    }
					
					if (input.is(":text") || input.is("textarea")) {
                        $(this).html(input.val());
                    } else if (input.is("select")) {
                        $(this).html(input.find('option:selected').text());
                    } else if (input.is(":radio") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));
						
					} else if (input.is(":checkbox") && input.is(":checked")) {
                        $(this).html(input.attr("data-title"));	
                											
                    } else if ($(this).attr("data-display") == 'company_biz_types') {
						var company_biz_types = [];
						$('[name="company_biz_types[]"]').each(function(){
                            if($(this).is(':checked'))
								company_biz_types.push($(this).attr('data-title'));
                        });
						$(this).html(company_biz_types.join("<br>"));
					} else if ($(this).attr("data-display") == 'company_industries') {
						var company_industries = [];
						$('[name="company_industries[]"]').each(function(){
							if($(this).is(':checked'))
                            	company_industries.push($(this).attr('data-title'));
                        });
						$(this).html(company_industries.join("<br>"));
					}   else if ($(this).attr("data-display") == 'biz_needs_partner_in') {
						var biz_needs_partner_in = [];
						$('[name="biz_needs_partner_in[]"]').each(function(){
							if($(this).is(':checked'))
                            	biz_needs_partner_in.push($(this).attr('data-title'));
                        });
						$(this).html(biz_needs_partner_in.join("<br>"));
					} else if ($(this).attr("data-display") == 'biz_needs_partner_in_ind') {
						var biz_needs_partner_in_ind = [];
						$('[name="biz_needs_partner_in_ind[]"]').each(function(){
							if($(this).is(':checked'))
                            	biz_needs_partner_in_ind.push($(this).attr('data-title'));
                        });
						$(this).html(biz_needs_partner_in_ind.join("<br>"));
					} else if ($(this).attr("data-display") == 'biz_need_invest_ind') {
						var biz_need_invest_ind = [];
						$('[name="biz_need_invest_ind[]"]').each(function(){
							if($(this).is(':checked'))
                            	biz_need_invest_ind.push($(this).attr('data-title'));
                        });
						$(this).html(biz_need_invest_ind.join("<br>"));
					} else if ($(this).attr("data-display") == 'biz_give_invest_ind') {
						var biz_give_invest_ind = [];
						$('[name="biz_give_invest_ind[]"]').each(function(){
							if($(this).is(':checked'))
                            	biz_give_invest_ind.push($(this).attr('data-title'));
                        });
						$(this).html(biz_give_invest_ind.join("<br>"));
					} else if ($(this).attr("data-display") == 'biz_needs_service_provide') {
						var biz_needs_service_provide = [];
						$('[name="biz_needs_service_provide[]"]').each(function(){
							if($(this).is(':checked'))
                            	biz_needs_service_provide.push($(this).attr('data-title'));
                        });
						$(this).html(biz_needs_service_provide.join("<br>"));
					} else if ($(this).attr("data-display") == 'biz_give_service_provide') {
						var biz_give_service_provide = [];
						$('[name="biz_give_service_provide[]"]').each(function(){
							if($(this).is(':checked'))
                            	biz_give_service_provide.push($(this).attr('data-title'));
                        });
						$(this).html(biz_give_service_provide.join("<br>"));
					}  else if ($(this).attr("data-display") == 'biz_need_ngo_supp_serv_type') {
						var biz_need_ngo_supp_serv_type = [];
						$('[name="biz_need_ngo_supp_serv_type[]"]').each(function(){
							if($(this).is(':checked'))
                            	biz_need_ngo_supp_serv_type.push($(this).attr('data-title'));
                        });
						$(this).html(biz_need_ngo_supp_serv_type.join("<br>"));
					} 
                });
            }

            var handleTitle = function(tab, navigation, index) {
                var total = navigation.find('li').length;
                var current = index + 1;
                // set wizard title
                $('.step-title', $('#form_wizard_1')).text('Step ' + (index + 1) + ' of ' + total);
                // set done steps
                jQuery('li', $('#form_wizard_1')).removeClass("done");
                var li_list = navigation.find('li');
                for (var i = 0; i < index; i++) {
                    jQuery(li_list[i]).addClass("done");
                }

                if (current == 1) {
                    $('#form_wizard_1').find('.button-previous').hide();
                } else {
                    $('#form_wizard_1').find('.button-previous').show();
                }

                if (current >= total) {
                    $('#form_wizard_1').find('.button-next').hide();
                    $('#form_wizard_1').find('.button-submit').show();
                    displayConfirm();
                } else {
                    $('#form_wizard_1').find('.button-next').show();
                    $('#form_wizard_1').find('.button-submit').hide();
                }
                App.scrollTo($('.page-title'));
            }

            // default form wizard
            $('#form_wizard_1').bootstrapWizard({
                'nextSelector': '.button-next',
                'previousSelector': '.button-previous',
                onTabClick: function (tab, navigation, index, clickedIndex) {
                    success.hide();
                    error.hide();
                    if (form.valid() == false) {
                        return false;
                    }
                    handleTitle(tab, navigation, clickedIndex);
                },
                onNext: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    if (form.valid() == false) {
                        return false;
                    }

                    handleTitle(tab, navigation, index);
                },
                onPrevious: function (tab, navigation, index) {
                    success.hide();
                    error.hide();

                    handleTitle(tab, navigation, index);
                },
                onTabShow: function (tab, navigation, index) {
                    var total = navigation.find('li').length;
                    var current = index + 1;
                    var $percent = (current / total) * 100;
                    $('#form_wizard_1').find('.progress-bar').css({
                        width: $percent + '%'
                    });
                }
            });

            $('#form_wizard_1').find('.button-previous').hide();
            $('#form_wizard_1 .button-submit').click(function () {
               
			   if($('#terms_and_conditions').is(':checked')){
				
					var datastring = $(form).serialize();
					$.ajax({
						type:'POST',
						url: '/ajax/', 	
						data: datastring,
						success: function(data,id){
							//alert("Form has been submitted.");
							//window.location = "/thank-you";
							var success = false;
							if (data.hasOwnProperty('success')) {
								if (data.success === true) {
									success = true;
									window.location.href = "/thank-you";
								}
							}
							if (data.hasOwnProperty('validation_errors_count') && !success) {
								if (data.hasOwnProperty('validation_errors')) {
									
									var error_messages = '';
									$.each(data.validation_errors, function(key, value){
											error_messages += value +'\n';
									});
									
									$('#error_message').text(error_messages).addClass('alert alert-danger');
									
								}
								else {
									//alert('there is an error in form');
									$('#error_message').text('there is an error in form').addClass('alert alert-danger');
								}
							}
						},
						error: function(data){
							$('#error_message').text('there is an error in form').addClass('alert alert-danger');
						}
					});
				
			   } else {
					alert("Please check the Terms and Conditions.");   
			   }
				
            }).hide();
            
            
            // triggers for business partners
            
            //$("input[name=biz_need_partner]").mouseenter(function() {
            	//$(this).attr('disabled', 'disabled');
            //});
            
            $("input[name=biz_need_partner]").click(function() {
            	var next_item = $(this).closest('.panel-heading').next();
            	var is_checked = $(this).is(':checked');
            	change_child_status($(this), next_item, is_checked);
            });
            
            $("input[name=biz_give_invest]").click(function() {
            	var next_item = $(this).closest('.panel-heading').next();
            	var is_checked = $(this).is(':checked');
            	change_child_status($(this), next_item, is_checked);
            });
            
            $("input[name=biz_give_service_provide_bool]").click(function() {
            	var next_item = $(this).closest('.panel-heading').next();
            	var is_checked = $(this).is(':checked');
            	change_child_status($(this), next_item, is_checked);
            });
            
            $("input[name=biz_need_invest]").click(function() {
            	var next_item = $(this).closest('.panel-heading').next();
            	var is_checked = $(this).is(':checked');
            	change_child_status($(this), next_item, is_checked);
            });
            
            $("input[name=biz_needs_service_provide_bool]").click(function() {
            	var next_item = $(this).closest('.panel-heading').next();
            	var is_checked = $(this).is(':checked');
            	change_child_status($(this), next_item, is_checked);
            });
            
            $("input[name=biz_need_ngo_supp_serv]").click(function() {
            	var next_item = $(this).closest('.panel-heading').next();
            	var is_checked = $(this).is(':checked');
            	change_child_status($(this), next_item, is_checked);
            });
            
            var target = $("input[name=biz_need_partner]");
            update_initial_status(target);
            
            var target = $("input[name=biz_give_invest]");
            update_initial_status(target);
            
            var target = $("input[name=biz_give_service_provide_bool]");
            update_initial_status(target);
                        
            var target = $("input[name=biz_need_invest]");
            update_initial_status(target);
            
            var target = $("input[name=biz_needs_service_provide_bool]");
            update_initial_status(target);
            
            var target = $("input[name=biz_need_ngo_supp_serv]");
            update_initial_status(target);            
            // end triggers
        }

    };

}();