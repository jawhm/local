/*
 * contactable 1.2.1 - jQuery Ajax contact form
 *
 * Copyright (c) 2009 Philip Beel (http://www.theodin.co.uk/)
 * Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php) 
 * and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
 *
 * Revision: $Id: jquery.contactable.js 2010-01-18 $
 *
 */
 
//extend the plugin
(function($){

	//define the new for the plugin ans how to call it	
	jQuery.fn.contactable = function(options) {
		//set default options  
		var defaults = {
			url: 'http://www.jawhm.or.jp/feedback/mail.php',
			name: 'お名前',
			email: 'メールアドレス',
			message : 'メッセージ',
			subject : 'ＷＥＢフィードバック',
			submit : '送信',
			recievedMsg : 'ご意見ありがとうございました。',
			notRecievedMsg : '恐れ入りますが送信に失敗しました。<br/>時間を置いて再度送信してください。',
			disclaimer: '当協会へのご意見・ご感想・お問い合わせなどをお送りください。<br/>各種お問い合わせ等で、返信が必要な場合は、必ずお名前とメールアドレスを入力してください。',
			hideOnSubmit: true

		};

		//call in the default otions
		var options = jQuery.extend(defaults, options);
		//act upon the element that is passed into the design    
		return this.each(function() {
			//construct the form
			var this_id_prefix = '#'+this.id+' ';
			$(this).html('<div id="contactable_inner"></div><form id="contactForm" method="" action=""><div id="loading"></div><div id="callback"></div><div class="holder"><p><label for="name">'+options.name+'</label><br /><input id="name" class="contact" name="name"/></p><p><label for="email">'+options.email+'</label><br /><input id="email" class="contact" name="email" /></p><p><label for="message">'+options.message+' <span class="red"> * </span></label><br /><textarea id="message" name="message" class="message" rows="4" cols="30" ></textarea></p><p><input class="submit" type="submit" value="'+options.submit+'"/></p><p class="disclaimer">'+options.disclaimer+'</p></div></form>');
			//show / hide function
			$(this_id_prefix+'div#contactable_inner').toggle(function() {
				$(this_id_prefix+'#overlay').css({display: 'block'});
				$(this).animate({"marginLeft": "-=5px"}, "fast"); 
				$(this_id_prefix+'#contactForm').animate({"marginLeft": "-=0px"}, "fast");
				$(this).animate({"marginLeft": "+=387px"}, "slow"); 
				$(this_id_prefix+'#contactForm').animate({"marginLeft": "+=390px"}, "slow"); 
			}, 
			function() {
				$(this_id_prefix+'#contactForm').animate({"marginLeft": "-=390px"}, "slow");
				$(this).animate({"marginLeft": "-=387px"}, "slow").animate({"marginLeft": "+=5px"}, "fast"); 
				$(this_id_prefix+'#overlay').css({display: 'none'});
			});
			
			//validate the form 
			$(this_id_prefix+"#contactForm").validate({
				//set the rules for the fild names
				rules: {
					name: {
					},
					email: {
					},
					message: {
						required: true
					}
				},
				//set messages to appear inline
					messages: {
						name: "",
						email: "",
						message: ""
					},			

				submitHandler: function() {
					$(this_id_prefix+'.holder').hide();
					$(this_id_prefix+'#loading').show();
jQuery.ajax({
  type: 'POST',
  url: options.url,
  data: {subject:options.subject, name:$(this_id_prefix+'#name').val(), email:$(this_id_prefix+'#email').val(), message:$(this_id_prefix+'#message').val()},
  success: function(data){
						$(this_id_prefix+'#loading').css({display:'none'}); 
						if( data == 'success') {
							$(this_id_prefix+'#callback').show().append(options.recievedMsg);
							if(options.hideOnSubmit == true) {
								//hide the tab after successful submition if requested
								$(this_id_prefix+'#contactForm').animate({dummy:1}, 2000).animate({"marginLeft": "-=450px"}, "slow");
								$(this_id_prefix+'div#contactable_inner').animate({dummy:1}, 2000).animate({"marginLeft": "-=447px"}, "slow").animate({"marginLeft": "+=5px"}, "fast"); 
								$(this_id_prefix+'#overlay').css({display: 'none'});	
							}
						} else {
							$(this_id_prefix+'#callback').show().append(options.notRecievedMsg);
							setTimeout(function(){
								$(this_id_prefix+'.holder').show();
								$(this_id_prefix+'#callback').hide().html('');
							},2000);
						}
					},
  error:function(err){
							$(this_id_prefix+'#loading').hide();
							$(this_id_prefix+'#callback').show().append(options.recievedMsg);
							if(options.hideOnSubmit == true) {
								//hide the tab after successful submition if requested
								$(this_id_prefix+'#contactForm').animate({dummy:1}, 2000).animate({"marginLeft": "-=450px"}, "slow");
								$(this_id_prefix+'div#contactable_inner').animate({dummy:1}, 2000).animate({"marginLeft": "-=447px"}, "slow").animate({"marginLeft": "+=5px"}, "fast"); 
								$(this_id_prefix+'#overlay').css({display: 'none'});	
							}else{

							}
//						$(this_id_prefix+'#loading').css({display:'none'}); 
//						$(this_id_prefix+'#callback').show().append(options.notRecievedMsg);
                                        }
});		
				}
			});
		});
	};
 
})(jQuery);
