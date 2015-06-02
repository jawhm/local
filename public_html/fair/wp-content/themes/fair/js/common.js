$(function() {
// Button toTop  
    $('a#toTop').click(function() {
        $('html, body').animate({ scrollTop: 0 }, 400);
        return false;
    });
 });
 
 $(function(){
// Fade
  $(".fadeThis,a img").hover(function(){
			$(this).fadeTo("fast", 0.8);
		},function(){
  $(this).fadeTo("fast", 1.0);
  });
});



























   
	