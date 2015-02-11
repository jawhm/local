jQuery(function() {
        $("a[href^='http://']").attr("target","_blank");
        $(".open").click(function(){
        $("#slideBox").slideToggle("slow");
          });
     });
