$(function () {
    $(".sclList ul li.sclBox").heightLine({
    });
});
//
$(document).ready(function(){
    // Slider
    function FixBxSliderPC() {
        var opts = {
            slideWidth: 215,
            minSlides: 3,
            maxSlides: 3,
            moveSlides: 1,
            slideMargin: 0,
            autoControls: false,
            controls: false,
            translateValue: 190
        };
        $('.slide_body').bxSlider(opts);
    }
    function FixBxSliderSP() {
        var opts = {
            slideWidth: 215,
            minSlides: 3,
            maxSlides: 3,
            moveSlides: 1,
            slideMargin: 0,
            autoControls: false,
            controls: false,
            translateValue: 50
        };
        $('.slide_body').bxSlider(opts);
    }

    //you can remove responsive code if you don't want the slider scales while window resizes
    function ScaleBxSlider() {
        var windowWidth = $(window).width();
        if (windowWidth < 699) {
            FixBxSliderSP();
        } else {
            FixBxSliderPC();
        }
    }
    ScaleBxSlider();

    $('#rePoint .btn').on('click', function () {
        document.cookie = 'SchoolArea=' + $(this).attr('href');
    });

    $(window).resize(function () {
        window.location.href = '/fair/school' + getCookie('SchoolArea');
    });
    //responsive code end
    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ')
                c = c.substring(1);
            if (c.indexOf(name) == 0)
                return c.substring(name.length, c.length);
        }
        return "";
    }
});