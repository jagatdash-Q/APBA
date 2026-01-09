/*************************************
	* Ajax Form
	* Version 2.0.1 // customized
	
	VALIDATOR MESSAGE DESIGN CHANGE
	--------------------------------
	We can add custom error message design by adding TWO SIMPLE ATTRIBUTES
	i.e. -  data-msg="tooltip"
			data-tpos="top" //ex- top, right, bottom, left
			default is top.
	
************************************/
$(document).ready(function(event){

	// TEXT BOX VALIDATION
	var textinputfields = 'input[type="text"], textarea, input[type="email"], input[type="password"], input[type="tel"], input[type="url"], input[type="file"], select:not(.optional)';
	
	if($('form.ajaxform').find(textinputfields).length > 0){
		$(textinputfields).each(function(){
			$(this).after('<span class="pr-field"></span>');
			$(this).appendTo($(this).next());
		});
	}
	
	$(".only-number").keydown(function(event) {
		if ( event.keyCode == 46 || event.keyCode == 8 ) {
			return true;
		}
		else {
			if (event.keyCode < 48 || event.keyCode > 57 ){
				event.preventDefault();    
			}    
		}
	});
			
	$(".all-number").keydown(function(event) {
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 110 || event.keyCode == 190) {
            return true;
        }
        else {
			if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) || (event.shiftKey && event.which == 190)) && (event.keyCode < 96 || event.keyCode > 105))
			{
                event.preventDefault();    
            }    
        }
    });
	
	$(".decimal-number").keydown(function(event) {
		var txt = $(this).val();
		console.log(txt);
		var charCode = (event.which) ? event.which : event.keyCode;
		console.log(charCode);
		   if (charCode == 46 || charCode == 190) {
		       //Check if the text already contains the . character
		       if (txt.indexOf('.') === -1) {
		           return true;
		       } else {
		    	   event.preventDefault();
		       }
		   } else {
		       if (charCode > 31 && (charCode < 48 || charCode > 57))
		       {
		    	   event.preventDefault();
		       }
		   }
		   return true;
    });
			
	$(".decimal-number").keydown(function(event) {
		var txt = $(this).val();
		console.log(txt);
		var charCode = (event.which) ? event.which : event.keyCode;
		console.log(charCode);
		if (charCode == 46 || charCode == 190) {
			//Check if the text already contains the . character
			if (txt.indexOf('.') === -1) {
				return true;
			} else {
				event.preventDefault();
			}
		} else {
			if (charCode > 31 && (charCode < 48 || charCode > 57))
			{
				event.preventDefault();
			}
		}
		return true;
	});
	
	$('form.ajaxform, .validator').on('submit', function(t){
		
		// Check for Add Questions
		if( $('.questions').length > 0){
            var ql = $('.questions').length;
            var qc = 1;
            $('.questions').each(function(){
                var qus = 0;
                $(this).find('input.qus').each(function(){
                    if($(this).val() != ''){
                        qus++ ;
                    }
                });
                if(qus == 0 && qc < ql){
                    $(this).parent().slideUp(300, function(){
                        $(this).remove();
                    });
                    qc++;
                }
            });
        }
		
		var disForm = $(this);
		var msgType = disForm.data('msg') || 'p';
		var ttPos = disForm.data('tpos') || 'top';
		
		var err_count = 0;
			
			if(msgType == 'p'){
				disForm.find('p.err').remove();
			}else if(msgType == 'tooltip'){
				disForm.find('.error_msg').removeClass('error_msg');
				disForm.find('.duplicate_error_msg').remove();
				$(this).parents('.pr-field').find('.err-icon').remove();
			}
			
			if ($('.check-duplicate').length > 0){
				if ($('.duplicate').val() > 0){
					$('.check-duplicate').addClass('error_msg');
					if($('[name="current_market_id"]').length > 0){
						$('.check-duplicate').after('<br /><span class="duplicate_error_msg">This product already exists in this market.</span>');
					} else {
						$('.check-duplicate').after('<br /><span class="duplicate_error_msg">This name is already associated to an existing case type in the system. Please use another one.</span>');
					}
					
					err_count++;
				}
				
				if(err_count==1){
					var target = $(this);
					$('html, body').animate({
					  scrollTop: (target.offset().top) - 30
					}, 1000);
				}
			}
			
			if ($('.name-duplicate').length > 0){
				if (disForm.find('.name-duplicate').parents('form').find('.duplicate').val() > 0){
					disForm.find('.name-duplicate').addClass('error_msg');
					disForm.find('.name-duplicate').addClass('error_msg');
					disForm.find('.name-duplicate').parent().prepend('<span class="err-icon">* <span class="pr-tooltip">'+$('.name-duplicate').attr('placeholder')+' already exists in database.</span></span>');
	        		   err_count++;
					}
				
				if(err_count==1){
					var target = $(this);
					$('html, body').animate({
					  scrollTop: (target.offset().top) - 30
					}, 1000);
				}
			}
			
			// TEXT BOX VALIDATION
			
			 if(disForm.find(textinputfields).length > 0){
				var ffGroup = [];
                 disForm.find(textinputfields).each(function(){
					var dn = $(this).attr('data-name') || 'nope';
					if( ffGroup.indexOf($(this).attr('name')) < 0 ){
						ffGroup.push($(this).attr('name'));
					}
					if(dn != 'nope' && ffGroup.indexOf(dn)<0 ){
						ffGroup.push(dn);
					}
                });
                
				for(var c=0; c<ffGroup.length; c++){
					disForm.find('[name="' +ffGroup[c]+ '"],[data-name="' +ffGroup[c]+ '"]').each(function(){
						var dpos = $(this).attr('data-tpos') || ttPos;
						if($(this).val().trim() == '' && (!$(this).hasClass("optional")) && (!$(this).is(":disabled"))){
				 //alert(err_count);
							var title = $(this).attr('data-title') || 'This field';
							var errmsg = $(this).attr('data-msg') || title+' is required';
							if(msgType == 'p'){
								$(this).parent().append('<p class="err">'+title+' is required</p>');
							}else if(msgType == 'tooltip'){
								$(this).addClass('error_msg');
								$(this).parent().prepend('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
							}
							err_count++;
							
							// FOR ltpl-accordion forms
							if( $(this).parents('.ltpl-accordion').length > 0 ){
								$(this).parents('.description').slideDown(300);
							}
							
							// Scroll to first error
							if(err_count==1){
								var target = $(this);
								$('html, body').animate({
								  scrollTop: (target.offset().top) - 100
								}, 1000);
							}
						}
					});
				}
            }
			 
			//CUSTOM VALIDATION
			
			if(disForm.find('.simple_name').length>0)
            {
				disForm.find('.simple_name').each(function(){
					var full_name=$(this).val();
					var alpha_space_pattern= /^[a-zA-Z ]*$/;
					if(!(alpha_space_pattern).test(full_name)){
						$(this).addClass('error_msg');
						$(this).parents('.pr-field').prepend('<span class="err-icon">* <span class="pr-tooltip top">Only alphabets allowed.</span></span>');
						err_count++;
						
						// FOR ltpl-accordion forms
						if( $(this).parents('.ltpl-accordion').length > 0 ){
							$(this).parents('.description').slideDown(300);
						}
						
						// Scroll to first error
						if(err_count==1){
							var target = $(this);
							$('html, body').animate({
							  scrollTop: (target.offset().top) - 30
							}, 1000);
						}
					}
				});
            }
			
			if(disForm.find('.alpha_num').length>0)
			{
				var user_val=disForm.find('.alpha_num').val();
				var alpha_num_pattern1= /^(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/;
				var alpha_num_pattern2= /^[a-zA-Z][a-zA-Z0-9.,$;]+$/;
				if(!(alpha_num_pattern2).test(user_val)){
					$(this).addClass('error_msg');
					disForm.find('.alpha_num').parents('.pr-field').prepend('<span class="err-icon">* <span class="pr-tooltip top">User Name Should be an alpha numeric and first letter should be an alphabet.</span></span>');
					err_count++;
					
					// FOR ltpl-accordion forms
					if( $(this).parents('.ltpl-accordion').length > 0 ){
						$(this).parents('.description').slideDown(300);
					}
					
					// Scroll to first error
					if(err_count==1){
						var target = $(this);
						$('html, body').animate({
						  scrollTop: (target.offset().top) - 30
						}, 1000);
					}
				}
				else if(!(alpha_num_pattern1).test(user_val)){
					$(this).addClass('error_msg');
					disForm.find('.alpha_num').parents('.pr-field').prepend('<span class="err-icon">* <span class="pr-tooltip top">Please Enter alphabets & numbers only.</span></span>');
					err_count++;
					
					// FOR ltpl-accordion forms
					if( $(this).parents('.ltpl-accordion').length > 0 ){
						$(this).parents('.description').slideDown(300);
					}
					
					// Scroll to first error
					if(err_count==1){
						var target = $(this);
						$('html, body').animate({
						  scrollTop: (target.offset().top) - 30
						}, 1000);
					}
				}
			}

			if(disForm.find('.alphanumeric').length>0)
			{
				var user_val=disForm.find('.alphanumeric').val();
				var alpha_num_pattern1= /^(?=.*[a-zA-Z])([a-zA-Z0-9]+)$/;
				var alpha_num_pattern2= /^[a-zA-Z][a-zA-Z0-9.,$;]+$/;
				/*if(!(alpha_num_pattern2).test(user_val)){
					disForm.find('.alphanumeric').parents('.pr-field').append('<span class="err-icon">* <span class="pr-tooltip top">PAN/Adhaar Number Should be an alpha numeric </span></span>');
					err_count++;
					
					// FOR ltpl-accordion forms
					if( $(this).parents('.ltpl-accordion').length > 0 ){
						$(this).parents('.description').slideDown(300);
					}
					
					// Scroll to first error
					if(err_count==1){
						var target = $(this);
						$('html, body').animate({
						  scrollTop: (target.offset().top) - 30
						}, 1000);
					}
				}
				else*/ if(!(alpha_num_pattern1).test(user_val)){
							$(this).addClass('error_msg');
					disForm.find('.alphanumeric').parents('.pr-field').prepend('<span class="err-icon">* <span class="pr-tooltip top">PAN/Adhaar Number Should be an alpha numeric.</span></span>');
					err_count++;
					
					// FOR ltpl-accordion forms
					if( $(this).parents('.ltpl-accordion').length > 0 ){
						$(this).parents('.description').slideDown(300);
					}
					
					// Scroll to first error
					if(err_count==1){
						var target = $(this);
						$('html, body').animate({
						  scrollTop: (target.offset().top) - 30
						}, 1000);
					}
				}
			}
			
			if(disForm.find('.passwd_format').length>0)
			{
				var password_val=disForm.find('.passwd_format').val();
				var pass_pattern = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/;
				if(!(pass_pattern).test(password_val)){
					$(this).addClass('error_msg');
      				disForm.find('.passwd_format').parents('.pr-field').prepend('<span class="err-icon">* <span class="pr-tooltip top">Password should contain minimum 8 characters, at least 1 Alphabet, 1 Number & 1 Special Character.</span></span>');
					err_count++;
					
					// FOR ltpl-accordion forms
					if( $(this).parents('.ltpl-accordion').length > 0 ){
						$(this).parents('.description').slideDown(300);
					}
					
					// Scroll to first error
					if(err_count==1){
						var target = $(this);
						$('html, body').animate({
						  scrollTop: (target.offset().top) - 30
						}, 1000);
					}
				}
			}
			
			//END CUSTOM VALIDATION
			
			
			// CHECKBOX VALIDATION
			 if(disForm.find('input[type="checkbox"]').length > 0){
				var checkGroup = [];
                disForm.find('input[type="checkbox"][name]').each(function(){
					if( checkGroup.indexOf($(this).attr('name')) < 0 ){
						checkGroup.push($(this).attr('name'));
					}
                });
				
				for(var c=0; c<checkGroup.length; c++){
					var c_err = 0;
					disForm.find('input[name="' +checkGroup[c]+ '"]').each(function(){
						if($(this).is(':checked') || $(this).hasClass('optional')){
							c_err++;
						}
					});
					if(c_err <= 0){
						var dpos = disForm.find('input[name="' +checkGroup[c]+ '"]').parent().parent().attr('data-tpos') || ttPos;
						var title = disForm.find('input[name="' +checkGroup[c]+ '"]').parent().attr('data-title') || 'This field';
						var errmsg = disForm.find('input[name="' +checkGroup[c]+ '"]').parent().parent().attr('data-msg') || title+' is required';
						
						if(msgType == 'p'){
							disForm.find('input[name="' +checkGroup[c]+ '"]').parent().parent().append('<p class="err">'+title+' is required</p>');
						}else if(msgType == 'tooltip'){
							disForm.find('input[name="' +checkGroup[c]+ '"]').parent().parent().append('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
						}
						err_count++;
						
						// FOR ltpl-accordion forms
						if( $(this).parents('.ltpl-accordion').length > 0 ){
							$(this).parents('.description').slideDown(300);
						}
						
						// Scroll to first error
						if(err_count==1){
							var target = $(this);
							$('html, body').animate({
							  scrollTop: (target.offset().top) - 30
							}, 1000);
						}
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
					var r_err = 0;
					disForm.find('input[name="' +radioGroup[c]+ '"]').each(function(){
						if($(this).is(':checked') || $(this).hasClass('optional')){
							r_err++;
						}
					});
					if(r_err <= 0){
						var dpos = disForm.find('input[name="' +radioGroup[c]+ '"]').parent().parent().attr('data-tpos') || ttPos;
						var title = disForm.find('input[name="' +radioGroup[c]+ '"]').parent().parent().attr('data-title') || 'This field';
						var errmsg = disForm.find('input[name="' +radioGroup[c]+ '"]').parent().parent().attr('data-msg') || title+' is required';
						if(msgType == 'p'){
							disForm.find('input[name="' +radioGroup[c]+ '"]').parent().parent().append('<p class="err">'+title+' is required</p>');
						}else if(msgType == 'tooltip'){
							disForm.find('input[name="' +radioGroup[c]+ '"]').parent().parent().append('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
						}
						err_count++;
						
						// FOR ltpl-accordion forms
						if( $(this).parents('.ltpl-accordion').length > 0 ){
							$(this).parents('.description').slideDown(300);
						}
					
						// Scroll to first error
						if(err_count==1){
							var target = disForm.find('input[name="' +radioGroup[c]+ '"]');
							console.log(target.attr('name'));
							$('html, body').animate({
							  scrollTop: (target.offset().top) - 30
							}, 1000);
						}
					}
				}
            }
			//--------
			
		
		
		
		if(disForm.find(".pass").length > 0 && disForm.find(".re_pass").length > 0){
			var dpos = disForm.find('.re_pass').attr('data-tpos') || ttPos;
			var title = disForm.find('.re_pass').attr('data-title') || 'This field';
			var errmsg = disForm.find('.re_pass').attr('data-msg') || title+' is required';
			if((disForm.find(".pass").val() != disForm.find(".re_pass").val()) && (disForm.find(".re_pass").val() != '')){
				disForm.find(".re_pass").val('');
				if(msgType == 'p'){
					disForm.find(".re_pass").parent().append('<p class="err">Password do not match</p>');
				}else if(msgType == 'tooltip'){
					$(this).addClass('error_msg');
					disForm.find(".re_pass").parent().prepend('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+"Passwords do not match"+'</span></span>');
				}
				err_count++;
				
				// FOR ltpl-accordion forms
				if( $(this).parents('.ltpl-accordion').length > 0 ){
					$(this).parents('.description').slideDown(300);
				}
					
				// Scroll to first error
				if(err_count==1){
					var target = $(this);
					$('html, body').animate({
					  scrollTop: (target.offset().top) - 30
					}, 1000);
				}
			}
		}
		
		
		if(disForm.find(".email").length > 0 && disForm.find(".re_email").length > 0){
			var dpos = disForm.find('.re_email').attr('data-tpos') || ttPos;
			var title = disForm.find('.re_email').attr('data-title') || 'This field';
			var errmsg = disForm.find('.re_email').attr('data-msg') || title+' is required';
			if(disForm.find(".email").val() != disForm.find(".re_email").val()){
				disForm.find(".re_email").val('');
				if(msgType == 'p'){
					disForm.find(".re_email").parent().append('<p class="err">Email do not match</p>');
				}else if(msgType == 'tooltip'){
					$(this).addClass('error_msg');
					disForm.find(".re_email").parent().prepend('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
				}
				err_count++;
				
				// FOR ltpl-accordion forms
				if( $(this).parents('.ltpl-accordion').length > 0 ){
					$(this).parents('.description').slideDown(300);
				}
					
				// Scroll to first error
				if(err_count==1){
					var target = $(this);
					$('html, body').animate({
					  scrollTop: (target.offset().top) - 30
					}, 1000);
				}
			}
		}

		if(disForm.find(".all-number").length > 0){ // NUMBER AND FLOAT ARE VALID
			disForm.find(".all-number").each(function(){
				var dpos = $(this).attr('data-tpos') || ttPos;
				var title = $(this).attr('data-title') || 'This field';
				var errmsg = title+' is for numbers/decimal';
				var product_credit = $(this).val();
				if( product_credit != '' && isNaN(product_credit)){
					if(msgType == 'p'){
						$(this).parent().append('<p class="err">Only Number</p>');
					}else if(msgType == 'tooltip'){
						$(this).addClass('error_msg');
						$(this).parent().prepend('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
					
					// FOR ltpl-accordion forms
					if( $(this).parents('.ltpl-accordion').length > 0 ){
						$(this).parents('.description').slideDown(300);
					}
					
					// Scroll to first error
					if(err_count==1){
						var target = $(this);
						$('html, body').animate({
						  scrollTop: (target.offset().top) - 30
						}, 1000);
					}
				}
			});
		}
		
		if(disForm.find(".only-number").length > 0){ // NUMBER ARE VALID
			disForm.find(".only-number").each(function(){
				var dpos = $(this).attr('data-tpos') || ttPos;
				var title = $(this).attr('data-title') || 'This field';
				var errmsg = title+' is for numbers';
				var product_credit = $(this).val();
				var reg = /^[0-9]*$/;
				if( product_credit != '' && (!product_credit.match(reg))){
					if(msgType == 'p'){
						$(this).parent().append('<p class="err">Only Number</p>');
					}else if(msgType == 'tooltip'){
						$(this).addClass('error_msg');
						$(this).parent().prepend('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
					
					// FOR ltpl-accordion forms
					if( $(this).parents('.ltpl-accordion').length > 0 ){
						$(this).parents('.description').slideDown(300);
					}
					
					// Scroll to first error
					if(err_count==1){
						var target = $(this);
						$('html, body').animate({
						  scrollTop: (target.offset().top) - 30
						}, 1000);
					}
				}
			});
		}
		
		if(disForm.find(".decimal-number").length > 0){ // NUMBER AND FLOAT ARE VALID
			disForm.find(".decimal-number").each(function(){
				var dpos = $(this).attr('data-tpos') || ttPos;
				var title = $(this).attr('data-title') || 'This field';
				var errmsg = title+' is for numbers';
				var product_credit = $(this).val();
				var reg = /^\d+(?:\.\d\d?)?$/;
				if( product_credit != '' && (!product_credit.match(reg))){
					if(msgType == 'p'){
						$(this).parent().append('<p class="err">Only Decimal Number</p>');
					}else if(msgType == 'tooltip'){
						$(this).addClass('error_msg');
						$(this).parent().prepend('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
					
					// FOR ltpl-accordion forms
					if( $(this).parents('.ltpl-accordion').length > 0 ){
						$(this).parents('.description').slideDown(300);
					}
					
					// Scroll to first error
					if(err_count==1){
						var target = $(this);
						$('html, body').animate({
						  scrollTop: (target.offset().top) - 30
						}, 1000);
					}
				}
			});
		}
		
		if(disForm.find("[data-min]").length > 0){
			disForm.find("[data-min]").each(function(){
				var setmin = $(this).attr('data-min');
				var dpos = $(this).attr('data-tpos') || ttPos;
				var errmsg = 'Minimum '+setmin+' character required';
				var minlen = $(this).val().length;
				if( minlen > 0 && minlen < setmin){
					if(msgType == 'p'){
						$(this).parent().append('<p class="err">Minimum '+setmin+' character required</p>');
					}else if(msgType == 'tooltip'){
						$(this).addClass('error_msg');
						$(this).parent().prepend('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
					
					// FOR ltpl-accordion forms
					if( $(this).parents('.ltpl-accordion').length > 0 ){
						$(this).parents('.description').slideDown(300);
					}
					
					// Scroll to first error
					if(err_count==1){
						var target = $(this);
						$('html, body').animate({
						  scrollTop: (target.offset().top) - 30
						}, 1000);
					}
				}
			});
		}
		
		if(disForm.find("[maxlength]").length > 0){
			disForm.find("[maxlength]").each(function(){
				var setmax = $(this).attr('maxlength');
				var dpos = $(this).attr('data-tpos') || ttPos;
				var errmsg = 'Maximum '+setmax+' character allowed';
				var maxlen = $(this).val().length;
				if( maxlen > setmax){
					if(msgType == 'p'){
						$(this).parent().append('<p class="err">Maximum '+setmax+' character allowed</p>');
					}else if(msgType == 'tooltip'){
						$(this).addClass('error_msg');
						$(this).parent().prepend('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
					
					// FOR ltpl-accordion forms
					if( $(this).parents('.ltpl-accordion').length > 0 ){
						$(this).parents('.description').slideDown(300);
					}
					
					// Scroll to first error
					if(err_count==1){
						var target = $(this);
						$('html, body').animate({
						  scrollTop: (target.offset().top) - 30
						}, 1000);
					}
				}
			});
		}
		
		
		if(disForm.find("[type=email]").length > 0){
			disForm.find("[type=email]").each(function(){
				var dpos = $(this).attr('data-tpos') || ttPos;
				var errmsg = 'Enter a valid email';
				var email = $(this);
				var emailText = email.val();
				var pattern = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/;
				if (!pattern.test(emailText) && emailText != '') {
					if(msgType == 'p'){
						$(this).parent().append('<p class="err">Enter a valid email</p>');
					}else if(msgType == 'tooltip'){
						$(this).addClass('error_msg');
						$(this).parent().prepend('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
					
					// FOR ltpl-accordion forms
					if( $(this).parents('.ltpl-accordion').length > 0 ){
						$(this).parents('.description').slideDown(300);
					}
					
					// Scroll to first error
					if(err_count==1){
						var target = $(this);
						$('html, body').animate({
						  scrollTop: (target.offset().top) - 30
						}, 1000);
					}
				}
			});
		}
		
		if(disForm.find("[type=url]").length > 0){
			disForm.find("[type=url]").each(function(){
				var dpos = $(this).attr('data-tpos') || ttPos;
				var errmsg = 'Enter a valid url';
				var url = $(this);
				var urlText = url.val();
				var pattern = /((ftp|https?):\/\/)?(www\.)?[a-z0-9\-\.]{3,}\.[a-z]{3}$/;
				if (!pattern.test(urlText) && urlText != '') {
					if(msgType == 'p'){
						url.parent().append('<p class="err">Enter a valid url</p>');
					}else if(msgType == 'tooltip'){
						$(this).addClass('error_msg');
						$(this).parent().prepend('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
					
					// FOR ltpl-accordion forms
					if( $(this).parents('.ltpl-accordion').length > 0 ){
						$(this).parents('.description').slideDown(300);
					}
					
					// Scroll to first error
					if(err_count==1){
						var target = $(this);
						$('html, body').animate({
						  scrollTop: (target.offset().top) - 30
						}, 1000);
					}
				}
			});
		}
		
		if( disForm.find("[type=tel]").length > 0 ){
			disForm.find("[type=tel]").each(function(){
				var dpos = $(this).attr('data-tpos') || ttPos;
				var errmsg = 'Enter a valid phone number ( Should be 10 digits )';
				var phoneno = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
				if (!phoneno.test($(this).val()) && $(this).val() != '') {
					if(msgType == 'p'){
						$(this).parent().append('<p class="err">Enter a valid phone number ( Should be 10 digits )</p>');
					}else if(msgType == 'tooltip'){
						$(this).addClass('error_msg');
						$(this).parent().prepend('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
					err_count++;
					
					// FOR ltpl-accordion forms
					if( $(this).parents('.ltpl-accordion').length > 0 ){
						$(this).parents('.description').slideDown(300);
					}
					
					// Scroll to first error
					if(err_count==1){
						var target = $(this);
						$('html, body').animate({
						  scrollTop: (target.offset().top) - 30
						}, 1000);
					}
				}
			});
		}
		
		
		disForm.find('[name],[data-name]').focus(function(){
			if(msgType == 'p'){
				$(this).parent().children('.err').remove();
			}else if(msgType == 'tooltip'){
				$(this).parents('.pr-field').find('.error_msg').removeClass('error_msg');
				$(this).parents('.pr-field').find('.err-icon').remove();
				$(this).parents('.pr-field').find('.duplicate_error_msg').remove();
			}
		});	
		
		disForm.find('.c-check input').focus(function(){
			$(this).parents('.bif').find('.err-icon').remove();
		});	
		
		if( disForm.find('.redactor-box').length > 0 ){
			disForm.find('.redactor-box').each(function(){
				$(this).find('.redactor-editor').focus(function(){
					if(msgType == 'p'){
						$(this).parents('.redactor-box').find('.err').remove();
					}
				});
			});
		}
		
		if( disForm.find('.error').length > 0 ){
			disForm.find(".error").each(function(){
				var errmsg = 'UserName already exist !';
				var dpos = $(this).attr('data-tpos') || ttPos;
				if(msgType == 'p'){
						$(this).parent().append('<p class="err">'+errmsg+'</p>');
					}else if(msgType == 'tooltip'){
						$(this).addClass('error_msg');
						$(this).parent().prepend('<span class="err-icon">* <span class="pr-tooltip '+dpos+'">'+errmsg+'</span></span>');
					}
				err_count++;
				// FOR ltpl-accordion forms
				if( $(this).parents('.ltpl-accordion').length > 0 ){
					$(this).parents('.description').slideDown(300);
				}
				
				// Scroll to first error
				if(err_count==1){
					var target = $(this);
					$('html, body').animate({
					  scrollTop: (target.offset().top) - 30
					}, 1000);
				}
			});
		}
		
		
		if(disForm.find('.err-icon').parents('[data-tab]').parents('form').length > 0){
            var activetab = 0;
            disForm.find('[data-tab]').hide();
            disForm.find('.err-icon').each(function(){
                activetab++;
                if(activetab == 1){
                    var tabli = $(this).parents('[data-tab]').attr('data-tab');
                    disForm.find('[data-taber]').removeClass('active');
                    disForm.find('[data-taber="'+tabli+'"]').addClass('active');
                    disForm.find(this).parents('[data-tab]').show();
                }
                
            });
        }
		
		if(err_count > 0){
			//t.preventDefault();
			t.preventDefault();
			t.stopPropagation();
			//t.stopPropagation();
			return false;
		}else if(!$(this).hasClass('ajaxform')){
			return true;
		}else{
			var fdata = new FormData(this);
			console.log(fdata);			
			var disForm = $(this);
			var act = disForm.data('action');
			var ajaxFormAlert = disForm.data('alert') || '';
			var ajaxFormCallback = disForm.data('callback') || '';
			var ajaxFormLoader = disForm.data('loader') || 0;
			var loaderIcon = 'data:image/gif;base64,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';
			var loaderType = disForm.data('loader-type') || 'default';
			var ajaxFormLoaderIcon = disForm.data('loader-icon') || loaderIcon;
			var ajaxFormRedirect = disForm.data('redirect') || '';
			var ajaxSubmitTransition = disForm.data('submit-transition') || 'slide';
			var ajaxFormType = disForm.attr('method') || 'POST';
			
			$.ajax({
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
						alert(data);
					}else if(ajaxFormAlert != ''){
						alert(ajaxFormAlert);
					}
					//eval(ajaxFormCallback);
					var fns = ajaxFormCallback.split(';');
					for(var i=0; i<fns.length; i++){
						var fnName_arr = fns[i].split('(');
						var fnName = fnName_arr[0];
						var options_arr = fnName_arr[1].split(')')[0];
						var options = options_arr.split(',');
						
						for(var j=0; j<options.length; j++){
							if(!isNaN(options[j])){
								options[j] = +options[j];
							}else if(options[j].indexOf("'") == 0 || options[j].indexOf('"') == 0){
								options[j] = options[j].substr(1, options[j].length -2);
							}
							else{
								if(options[j] == 'data'){
								    options[j] = data;
								}else if(options[j] == 'disForm'){
								    options[j] = disForm;
								}
							}
						} 
						//console.log(options);
						var fn = window[fnName];
						if (typeof fn === "function") fn.apply(null, options);
					}
					// ======================= */
					
				},
				error: function(jqXHR, textStatus, errorThrown) 
				{
					//if fails
					$('#ajaxFormLoader').fadeOut(300, function(){
						$(this).remove();
					});
					console.log(textStatus+errorThrown);
				}
			});
			t.preventDefault(); //STOP default action
		}
		
	});
});



