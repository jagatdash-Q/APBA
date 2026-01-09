/*************************************
	* Ajax Form
	* Version 2.0.1
	
	VALIDATOR MESSAGE DESIGN CHANGE
	--------------------------------
	We can add custom error message design by adding TWO SIMPLE ATTRIBUTES
	i.e. -  data-msg="tooltip"
			data-tpos="top" //ex- top, right, bottom, left
			default is top.
	
************************************/

//AJAX Queue Function
(function($) {
	// jQuery on an empty object, we are going to use this as our Queue
	var ajaxQueue = $({});
	$.ajaxQueue = function( ajaxOpts ) {
		var jqXHR,
		dfd = $.Deferred(),
		promise = dfd.promise();
		// queue our ajax request
		ajaxQueue.queue( doRequest );
		// add the abort method
		promise.abort = function( statusText ) {
			// proxy abort to the jqXHR if it is active
			if ( jqXHR ) {
				return jqXHR.abort( statusText );
			}
			// if there wasn't already a jqXHR we need to remove from queue
			var queue = ajaxQueue.queue(),
			index = $.inArray( doRequest, queue );
			if ( index > -1 ) {
				queue.splice( index, 1 );
			}
			// and then reject the deferred
			dfd.rejectWith( ajaxOpts.context || ajaxOpts,
					[ promise, statusText, "" ] );
			return promise;
		};

		// Run the actual query
		function doRequest( next ) {
			jqXHR = $.ajax( ajaxOpts )
			.then( next, next )
			.done( dfd.resolve )
			.fail( dfd.reject );
		}
		return promise;
	};
})(jQuery);

$(document).ready(function(event){
	
	// TEXT BOX VALIDATION
			var textinputfields = 'input[type="text"], textarea, input[type="email"], input[type="password"], input[type="tel"], input[type="number"], input[type="url"], input[type="file"], select';
			
			if($(textinputfields).length > 0){
                $(textinputfields).each(function(){
					$(this).after('<span class="pr-field"></span>');
					$(this).appendTo($(this).next());
                });
            }
	
	
	$('form.ajaxform, .validator').submit(function(t){
		
		var disForm = $(this);
		var msgType = disForm.data('msg') || 'p';
		var ttPos = disForm.data('tpos') || 'top';
		
		var err_count = 0;
			
			if(msgType == 'p'){
				//disForm.find('p.err').remove();
				disForm.find('input, select').css('border', '');
			}
			
			// TEXT BOX VALIDATION
			
			 if(disForm.find(textinputfields).length > 0){
				var ffGroup = [];
                disForm.find(textinputfields).each(function(){
					if( ffGroup.indexOf($(this).attr('name')) < 0 ){
						ffGroup.push($(this).attr('name'));
					}
                });
				
				for(var c=0; c<ffGroup.length; c++){
					disForm.find('[name="' +ffGroup[c]+ '"]').each(function(){
						var dpos = $(this).attr('data-tpos') || ttPos;
						if($(this).val() == '' && (!$(this).hasClass("optional"))){
							var title = $(this).attr('data-title') || 'This field';
							var errmsg = $(this).attr('data-msg') || title+' is required';
							if(msgType == 'p'){
								//$(this).parent().append('<p class="err">'+title+' is required</p>');
								$(this).css('border', '1px solid #f30');
							}else if(msgType == 'tooltip'){
								$(this).parent().append('<span class="err-icon">! <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
							}
							err_count++;
						}
					});
				}
            }
			
			
			// CHECKBOX VALIDATION
			 if(disForm.find('input[type="checkbox"]').length > 0){
				var checkGroup = [];
                disForm.find('input[type="checkbox"]').each(function(){
					if( checkGroup.indexOf($(this).attr('name')) < 0 ){
						checkGroup.push($(this).attr('name'));
					}
                });
				
				for(var c=0; c<checkGroup.length; c++){
					var c_err = 0;
					disForm.find('input[name="' +checkGroup[c]+ '"]').each(function(){
						if($(this).is(':checked')){
							c_err++;
						}
					});
					if(c_err <= 0){
						var title = disForm.find('input[name="' +checkGroup[c]+ '"]').parent().attr('data-title') || 'This field';
						if(msgType == 'p'){
							//disForm.find('input[name="' +checkGroup[c]+ '"]').parent().parent().append('<p class="err">'+title+' is required</p>');
						}else if(msgType == 'tooltip'){
							//disForm.find('input[name="' +checkGroup[c]+ '"]').parent().append('<span class="err-icon">! <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
						}
						//err_count++;
					}
				}
            }
			//--------
			
			// Radio button VALIDATION
			 if(disForm.find('input[type="radio"]').length > 0){
				var radioGroup = [];
                disForm.find('input[type="radio"]').each(function(){
					if( radioGroup.indexOf($(this).attr('name')) < 0 ){
						radioGroup.push($(this).attr('name'));
					}
                });
				
				for(var c=0; c<radioGroup.length; c++){
					var c_err = 0;
					disForm.find('input[name="' +radioGroup[c]+ '"]').each(function(){
						if($(this).is(':checked')){
							c_err++;
						}
					});
					if(c_err <= 0){
						var dpos = disForm.find('input[name="' +radioGroup[c]+ '"]').parent().parent().attr('data-tpos') || ttPos;
						var title = disForm.find('input[name="' +radioGroup[c]+ '"]').parent().parent().attr('data-title') || 'This field';
						var errmsg = disForm.find('input[name="' +radioGroup[c]+ '"]').parent().parent().attr('data-msg') || title+' is required';
						if(msgType == 'p'){
							disForm.find('input[name="' +radioGroup[c]+ '"]').parent().parent().append('<p class="err">'+title+' is required</p>');
						}else if(msgType == 'tooltip'){
							disForm.find('input[name="' +radioGroup[c]+ '"]').parent().parent().append('<span class="err-icon">! <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
						}
						err_count++;
					}
				}
            }
			//--------
			
		if($(".pass").length > 0 && $(".re_pass").length > 0){
			var dpos = disForm.find('.re_pass').attr('data-tpos') || ttPos;
			var title = disForm.find('.re_pass').attr('data-title') || 'This field';
			var errmsg = disForm.find('.re_pass').attr('data-msg') || title+' is required';
			if(($(".pass").val() != $(".re_pass").val()) && ($(".re_pass").val() != '')){
				$(".re_pass").val('');
				if(msgType == 'p'){
					$(".re_pass").parent().append('<p class="err">Password do not match</p>');
				}else if(msgType == 'tooltip'){
					$(".re_pass").parent().append('<span class="err-icon">! <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
				}
				err_count++;
			}
		}
		
		if($(".email").length > 0 && $(".re_email").length > 0){
			var dpos = disForm.find('.re_email').attr('data-tpos') || ttPos;
			var title = disForm.find('.re_email').attr('data-title') || 'This field';
			var errmsg = disForm.find('.re_email').attr('data-msg') || title+' is required';
			if($(".email").val() != $(".re_email").val()){
				$(".re_email").val('');
				if(msgType == 'p'){
					$(".re_email").parent().append('<p class="err">Email do not match</p>');
				}else if(msgType == 'tooltip'){
					$(".re_email").parent().append('<span class="err-icon">! <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
				}
				err_count++;
			}
		}
		if($(".only-number").length > 0){ // NUMBER AND FLOAT ARE VALID
			$(".only-number").each(function(){
				var dpos = $(this).attr('data-tpos') || ttPos;
				var title = $(this).attr('data-title') || 'This field';
				var errmsg = title+' is for numbers';
				var product_credit = $(this).val();
				if( product_credit != '' && isNaN(product_credit)){
					if(msgType == 'p'){
						$(this).parent().append('<p class="err">Only Number</p>');
					}else if(msgType == 'tooltip'){
						$(this).parent().append('<span class="err-icon">! <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
				}
			});
		}
		if($("[data-min]").length > 0){
			$("[data-min]").each(function(){
				var setmin = $(this).attr('data-min');
				var dpos = $(this).attr('data-tpos') || ttPos;
				var errmsg = 'Minimum '+setmin+' character required';
				var minlen = $(this).val().length;
				if( minlen > 0 && minlen < setmin){
					if(msgType == 'p'){
						$(this).parent().append('<p class="err">Minimum '+setmin+' character required</p>');
					}else if(msgType == 'tooltip'){
						$(this).parent().append('<span class="err-icon">! <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
				}
			});
		}
		
		if($("[maxlength]").length > 0){
			$("[maxlength]").each(function(){
				var setmax = $(this).attr('maxlength');
				var dpos = $(this).attr('data-tpos') || ttPos;
				var errmsg = 'Maximum '+setmax+' character allowed';
				var maxlen = $(this).val().length;
				if( maxlen > setmax){
					if(msgType == 'p'){
						$(this).parent().append('<p class="err">Maximum '+setmax+' character allowed</p>');
					}else if(msgType == 'tooltip'){
						$(this).parent().append('<span class="err-icon">! <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
				}
			});
		}
		
		
		if($("[type=email]").length > 0){
			$("[type=email]").each(function(){
				var dpos = $(this).attr('data-tpos') || ttPos;
				var errmsg = 'Enter a valid email';
				var email = $(this);
				var emailText = email.val();
				//var pattern = /((ftp|https?):\/\/)?(www\.)?[a-z0-9\-\.]{3,}\.[a-z]{3}$/;
				var pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				if (!pattern.test(emailText) && emailText != '') {
					if(msgType == 'p'){
						$(this).parent().append('<p class="err">Enter a valid email</p>');
					}else if(msgType == 'tooltip'){
						$(this).parent().append('<span class="err-icon">! <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
				}
			});
		}
		
		if($("[type=url]").length > 0){
			$("[type=url]").each(function(){
				var dpos = $(this).attr('data-tpos') || ttPos;
				var errmsg = 'Enter a valid url';
				var url = $(this);
				var urlText = url.val();
				var pattern = /((ftp|https?):\/\/)?(www\.)?[a-z0-9\-\.]{3,}\.[a-z]{3}$/;
				if (!pattern.test(urlText) && urlText != '') {
					if(msgType == 'p'){
						url.parent().append('<p class="err">Enter a valid url</p>');
					}else if(msgType == 'tooltip'){
						$(this).parent().append('<span class="err-icon">! <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
				}
			});
		}
		
		if( $("[type=tel]").length > 0 ){
			$("[type=tel]").each(function(){
				var dpos = $(this).attr('data-tpos') || ttPos;
				var errmsg = 'Enter a valid phone number ( Should be 10 digits )';
				var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
				if (!phoneno.test($(this).val()) && $(this).val() != '') {
					if(msgType == 'p'){
						$(this).parent().append('<p class="err">Enter a valid phone number ( Should be 10 digits )</p>');
					}else if(msgType == 'tooltip'){
						$(this).parent().append('<span class="err-icon">! <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
				}
			});
		}
		
		
		$('[name]').focus(function(){
			if(msgType == 'p'){
				//$(this).parent().children('.err').remove();
				$(this).css('border', '');
			}else if(msgType == 'tooltip'){
				$(this).parent().children('.err-icon').remove();
			}
		});	
		
		if( $('.redactor-box').length > 0 ){
			$('.redactor-box').each(function(){
				$(this).find('.redactor-editor').focus(function(){
					if(msgType == 'p'){
						$(this).parents('.redactor-box').find('.err').remove();
					}else if(msgType == 'tooltip'){
						$(this).parents('.redactor-box').find('.err-icon').remove();
					}
				});
			});
		}
		
		
		if(err_count > 0){
			t.preventDefault();
			return false;
		}else if(!$(this).hasClass('ajaxform')){
			return true;
		}else{
			var fdata = new FormData(this);
			var act = $(this).attr("action");
			var disForm = $(this);
			var ajaxFormAlert = disForm.data('alert') || '';
			var ajaxFormCallback = disForm.attr('data-callback') || '';
			var ajaxFormLoader = disForm.attr('data-loader') || 0;
			var loaderIcon = 'data:image/gif;base64,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';
			var loaderType = disForm.data('loader-type') || 'default';
			var ajaxFormLoaderIcon = disForm.data('loader-icon') || loaderIcon;
			var ajaxFormRedirect = disForm.data('redirect') || '';
			var ajaxSubmitTransition = disForm.data('submit-transition') || 'slide';
			var ajaxFormType = disForm.attr('method') || 'POST';
			$.ajaxQueue({
				url : act,
				type: ajaxFormType,
				data : fdata,
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false, 
				beforeSend: function() {
					if(ajaxFormLoader != 'no'){
						if( loaderType == 'inline' ){
							disForm.append('<div id="ajaxFormLoader" style="display:inline-block; width: 20px; height: 20px; background: rgba(0,0,0,0.03) url('+ajaxFormLoaderIcon+') no-repeat center; background-size: 95%; border-radius: 50%; position: relative; top: 6px;"></div>');
						}else if( loaderType == 'inside' ){
							if(disForm.css('position')=='static'){
								disForm.css('position', 'relative');
							}
							disForm.prepend('<div id="ajaxFormLoader" style="position:absolute; top:0; right: 0; bottom:0; left:0; z-index: 10000;"><div style="background: rgba(0,0,0,0.3) url('+ajaxFormLoaderIcon+') no-repeat center; background-size: 60%; width: 40px; height: 40px; border-radius: 50%; position: absolute; top: 50%; left: 50%; margin-top: -20px; margin-left: -20px;"></div></div>');
						}else{
							$('body').prepend('<div id="ajaxFormLoader" style="position:fixed; top:0; right: 0; bottom:0; left:0; z-index: 10000; background: rgba(51, 136, 204, 0.3) url('+ajaxFormLoaderIcon+') no-repeat center;"></div>');
						}
					}
				},
				success:function(data, textStatus, jqXHR){
					$('#ajaxFormLoader').fadeOut(300, function(){
						$(this).remove();
						if($('input.txtbx').length > 0){
							$('input.txtbx').blur();
						}
					});
					if(ajaxFormAlert == 'data'){
						console.log(data);
					}else if(ajaxFormAlert != ''){
						console.log(ajaxFormAlert);
					}
					eval(ajaxFormCallback);
				},
				error: function(jqXHR, textStatus, errorThrown) 
				{
					//if fails
					$('#ajaxFormLoader').fadeOut(300, function(){
						$(this).remove();
					});
					Swal.fire("Error", "Something went wrong! Please check your network connection.", "error")
					console.log(textStatus+errorThrown);
				}
			});
			t.preventDefault(); //STOP default action
		}
		
	});
});
