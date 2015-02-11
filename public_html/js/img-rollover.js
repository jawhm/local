// rollover img link
//
// ロールオーバー用ＪＳスクリプト
//
jQuery(function(){
	 jQuery('a img').hover(function(){
		jQuery(this).attr('src', jQuery(this).attr('src').replace('_off', '_on'));
		  }, function(){
			 if (!jQuery(this).hasClass('currentPage')) {
			 jQuery(this).attr('src', jQuery(this).attr('src').replace('_on', '_off'));
		}
   });

	var images = jQuery("img");
	for(var i=0; i < images.size(); i++) {
		if(images.eq(i).attr("src").match("/ad/www/images/.")) {
			jQuery("img").eq(i).hover(function() {
				jQuery(this).css('opacity', '0.6');
			}, function() {
				jQuery(this).css('opacity', '1');
			});
		}
	}

});
