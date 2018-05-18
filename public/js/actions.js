jQuery(document).ready(function ($) {

	$('#ticketback input[type=file]').change(function(){
		var fileName = $(this).val().split('/').pop().split('\\').pop();
		$('.filename').html(fileName)
	})	
	
 
	
	$('#ticketback').bootstrapValidator({
		preventSubmit: true,      
		message: 'This value is not valid',
		feedbackIcons: {
		    valid: 'dashicons dashicons-yes',
			invalid: 'dashicons dashicons-no',
			validating: 'dashicons dashicons-refresh'
		 },            

	}).on('success.form.bv', function(e) {
		e.preventDefault();		      
		$('body').animate({'opacity' : 0.7}, 400)
        var form = $(this);
        form.find('.faspin').html('<i class="fa fa-cog fa-spin"></>');
		console.log(form.find('input'));
        var fd = {};

        form.find('input').each(function () {
        	//console.log();
            fd[$(this).attr('name')] = $(this).val();
            //console.log($(this).attr('name'), $(this).val());
        });
        fd['message'] = form.find('textarea').val();
        //console.log(fd);
	 	/*var fd = new FormData($('#ticketback')[0]);
	    var file = jQuery(document).find('input[type="file"]');
	    var caption = jQuery('#ticketback').find('input[name=file]');
	         
	    var individual_file = file[0].files[0];	    
	    fd.append( "file", individual_file );
	    var individual_capt = caption.val();
	    fd.append("caption", individual_capt);*/
	    console.log('form : ' + form, 'object : ' +  JSON.stringify(fd));
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: global.url + 'create_ticket',
			headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "cache-control" : "no-cache"
			},
/*			timeout: 30000,*/
			//processData: false,
			data: fd,
			success: function(data){
				//data = JSON.parse(data);
				//console.log(data);
				if(data.success === true){
                    $('#ticket').addClass('popup-success');
                    $('#ticketback').hide();
                    $('#ticket .modal-header').hide();
                    $('#ticket .result').show();
                    $('body').animate({
                        'opacity': 1
                    }, 400);
				}
			} 
		});     
	});
	
	$('.tfa-check').change(function(){
		$('.tfa').toggleClass('hidden')	
	})
		
	$('.auth_form').bootstrapValidator({        
		preventSubmit: true,      
		message: 'This value is not valid',
		feedbackIcons: {
		    valid: 'dashicons dashicons-yes',
			invalid: 'dashicons dashicons-no',
			validating: 'dashicons dashicons-refresh'
		 },            

	}).on('success.form.bv', function(e) {
		e.preventDefault();		      
		$('body').animate({'opacity' : 0.7}, 400)
	 
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: global.url,
			data: $('.auth_form').serialize(),
			success: function(data){
			     $('body').animate({'opacity' :1}, 400) 
			     $('.login-result').html(data.message);
			    if (data.loggedin == true){
			    	
			        window.location.reload()
			    }
			} 
		});     
	})
	
			//registration
		$('#registration').each(function() {
			var that = $(this);
			$(this).bootstrapValidator({
				preventSubmit: true,
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'dashicons dashicons-yes',
					invalid: 'dashicons dashicons-no',
					validating: 'dashicon dashicon-refresh'
				},
				fields: {
 
					user_email: {
						validators: {
							remote: {
								type: 'GET',
								url: global.url,
								data: {
									action: 'bitmain_ajax_validation',
								},
								message: $('#user_email').attr('data-bv-remote-message')
							}
						}
					},
			 
	 
	  
				}
			})
			$(this).on('success.form.bv', function(e) {
				e.preventDefault();
				$('body').animate({
					'opacity': 0.7
				}, 400)
				var fd = new FormData($(this)[0]);
  
				$.ajax({
					url: global.url,
					data: fd,
					type: 'POST',
	 
					contentType: false,
					processData: false,
					success: function(data) {
	 				 console.log(data);
						that.next('.result').text(that.next('.result').attr('data-text'));
						$('body').animate({
							'opacity': 1
						}, 400);
						window.location.href += "#regsuccess";
						location.reload();
	 
					},
					error: function(errorThrown) {
						console.log(errorThrown);
					}
				});
			})
		});
		
	    $('#personalForm').on('submit', function (e) {
			e.preventDefault();
			var form = $(this);
            $(form).bootstrapValidator({
                preventSubmit: true,
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'dashicons dashicons-yes',
                    invalid: 'dashicons dashicons-no',
                    validating: 'dashicon dashicon-refresh'
                },
                fields: {

                    user_pass_confirm: {
                        validators: {
                            identical: {
                                field: 'user_pass',
                                message: $('#user_pass_confirm').attr('data-bv-identical-message')
                            }
                        }
                    },
                    user_pass: {
                        validators: {
                            identical: {
                                field: 'user_pass_confirm',
                                message: $('#user_pass').attr('data-bv-identical-message')
                            }
                        }
                    }
                }
            });

            var dat = {};
            form.find('input').each(function () {
				dat[$(this).attr('name')] = $(this).val();
            });
			//console.log(dat);
			$.ajax({
                url: global.url + 'profile',
				data: dat,
                method: 'post',
                //dataType: 'json',
                //data: $('.auth_form').serialize(),
                success: function(response){
                    if (response.success == true){
                        window.location.reload()
                    }
                }
            });
        });

	/*			//registration
		$('#personalForm ').each(function() {
			var that = $(this);
			$(this).bootstrapValidator({
				preventSubmit: true,
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'dashicons dashicons-yes',
					invalid: 'dashicons dashicons-no',
					validating: 'dashicon dashicon-refresh'
				},
				fields: {
					 
					user_pass_confirm: {
						validators: {
							identical: {
								field: 'user_pass',
								message: $('#user_pass_confirm').attr('data-bv-identical-message')
							}
						}
					},
				 	user_pass: {
						validators: {
							identical: {
								field: 'user_pass_confirm',
								message: $('#user_pass').attr('data-bv-identical-message')
							}
						}
					},


				}
			})
			$(this).on('success.form.bv', function(e) {
				e.preventDefault();
				$('body').animate({
					'opacity': 0.7
				}, 400)
				var fd = new FormData($(this)[0]);
				 
				$.ajax({
					url: global.url + 'profile',
					data: fd,
					type: 'POST',
					//dataType: 'json',
					contentType: false,
					processData: false,
					success: function(data) {

						that.next('.result').text(that.next('.result').attr('data-text'));
						$('body').animate({
							'opacity': 1
						}, 400);
					//	window.location.reload();
	 
					},
					error: function(errorThrown) {
						console.log(errorThrown);
					}
				});
			})
		});*/
	
	$('div.result').hide()
	$('#callback ').each(function() {
			var that = $(this);
			$(this).bootstrapValidator({
				preventSubmit: true,
				message: 'This value is not valid',
				feedbackIcons: {
					valid: 'dashicons dashicons-yes',
					invalid: 'dashicons dashicons-no',
					validating: 'dashicon dashicon-refresh'
				},
				fields: {
 
	  
				}
			})
			$(this).on('success.form.bv', function(e) {
				e.preventDefault();
				$(this).find('.faspin').html('<i class="fa fa-cog fa-spin"></i>');
				$('body').animate({
					'opacity': 0.7
				}, 400);
				var fd = new FormData($(this)[0]);
				var url = global.url + $('#callback').attr('action');
				$.ajax({
					url: url,
					data: fd,
					type: 'POST',
					//dataType: 'json',
					contentType: false,
					processData: false,
					success: function(data) {
	 				 console.log(data);
						$('#call').addClass('popup-success');
	 				 $('#callback').hide();
	 				 $('#call .modal-header').hide();
						that.next('.result').show();
						$('body').animate({
							'opacity': 1
						}, 400);
						
						
				 
	 
					},
					error: function(errorThrown) {
						console.log(errorThrown);
					}
				});
			})
		});



	/*$('#ticket').each(function() {
		var that = $(this);
		$(this).bootstrapValidator({
			preventSubmit: true,
			message: 'This value is not valid',
			feedbackIcons: {
				valid: 'dashicons dashicons-yes',
				invalid: 'dashicons dashicons-no',
				validating: 'dashicon dashicon-refresh'
			},
			fields: {


			}
		})
		$(this).on('success.form.bv', function(e) {
			e.preventDefault();
			$('body').animate({
				'opacity': 0.7
			}, 400);
			var form = $(this).find('form');
			var fd = [];

			form.find('input').each(function () {
				fd[$(this).attr('name')] = $(this).val();
            });
			fd['message'] = form.find('textarea').val();
            console.log(fd);
			//fd.append($(this)[0]).find('form');


			var url = global.url + 'create_ticket';

			$.ajax({
				url: url,
				data: fd,
				type: 'POST',
                async: false,
				//dataType: 'json',
				//contentType: 'multipart/form-data',
				//boundary: 'WebKitFormBoundaryCIkXuNWC8OhEuT3S',
				processData: false,
				success: function(data) {
					//console.log(data);
					data = JSON.parse(data);
					if(data.success){
                        $('#ticket').addClass('popup-success');
                        $('#ticketback').hide();
                        $('#ticket .modal-header').hide();
                        $('#ticket .result').show();
                        $('body').animate({
                            'opacity': 1
                        }, 400);
					}
				},
				error: function(errorThrown) {
					console.log(errorThrown);
				}
			});
		})
	});*/

	$('#checkout_form').on('submit', function (e) {
        e.preventDefault();
        $(this).bootstrapValidator({
            preventSubmit: true,
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'dashicons dashicons-yes',
                invalid: 'dashicons dashicons-no',
                validating: 'dashicon dashicon-refresh'
            },
            fields: {

            }
        });
        var data = {};
        $(this).find('input').each(function () {
            var elm = $(this);
            if(elm.attr('type') == 'radio' && !elm.attr('checked')){
                return;
            }
            data[elm.attr('name')] = elm.val();
        });
        data[$(this).find('select').attr('name')] = $(this).find('select').val();
        data[$(this).find('textarea').attr('name')] = $(this).find('textarea').val();

        $.ajax({
            url: $(this).attr('action'),
            data: data,
            type: 'POST',
            success: function (response) {
            	//console.log(response);
                if(response.success){
                    window.location = global.url + 'checkout/order_success/' + response.order.number;
                } else{
                    if(!response.session){
                        window.location = global.url + 'sso-login';
                    }
                }
            }
        });
    });
});