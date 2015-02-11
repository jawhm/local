
// Google分析ＪＳ
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20563699-1']);
  _gaq.push(['_setDomainName', '.jawhm.or.jp']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();


// マウスオーバー処理
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

