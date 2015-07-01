$(function () {
    // Button toTop  
    $('a#toTop , a#toTopSp').click(function () {
        $('html, body').animate({scrollTop: 0}, 400);
        return false;
    });
});

$(function () {
    // Fade
    $(".fadeThis,a img").hover(function () {
        $(this).fadeTo("fast", 0.8);
    }, function () {
        $(this).fadeTo("fast", 1.0);
    });
});

/* Khang school list bxslider */
$(document).ready(function(){
    // Slider
    function FixBxSliderPC() {
        var opts = {
            slideWidth: 215,
            minSlides: 3,
            maxSlides: 3,
            moveSlides: 1,
            slideMargin: 0,
            controls: false,
            translateValue: 190,
            oneWrapperWidth: 260,
            oneTranslateValue: -270
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
            controls: false,
            translateValue: 50,
            oneWrapperWidth: 260,
            oneTranslateValue: -175
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

$(function () {
    // Toggle
    $("dl.faqBox dt").on("click", function () {
        $(this).next().slideToggle();
        $(".underSec.faq dl.faqBox").toggleClass("active");
    });
});

function adjustStyle(width) {
    // CSS Fix
    width = parseInt(width);
    if (width > 699) {
        $("#size-stylesheet").attr("href", "/fairtest/css/style_pc.css");
    } else {
        $("#size-stylesheet").attr("href", "/fairtest/css/style_sp.css");
    }
}
$(function () {
    adjustStyle($(this).width());
    $(window).resize(function () {
        adjustStyle($(this).width());
    });
});


/* Khang outside to close menu*/
$(document).on('click', function (e) {

    var container = $('#sidr');

    if (!container.is(e.target) && container.has(e.target).length === 0) {
        $.sidr('close', 'sidr');
    }

});

/* Khang simple modal window */
$(function () {
    var target = '';
    $(".more-btn").click(function () {
        // Get the second class of "btn" class
        target = $(this).get(0).className.split(" ")[2];
        // Set the target modal window
        target = $(".modal." + target);
        // Show modal window
        if (target.is(":hidden")) {
            target.fadeIn(600);
            $(".container").addClass("bg-blur");
        } else {
            target.hide();
            $(".container").removeClass("bg-blur");
        }
    });

    // Hide modal window
    $(".close, .modal").click(function () {
        $(".modal").hide();
        $(".container").removeClass("bg-blur");
    });
});

/* Khang fadein */
$(window).load(function () {
    $('div.keyvisual').css({'overflow': 'hidden'}).fadeIn(3000, function () {
        $('div.keyvisual p').animate({
            top: '41%',
            opacity: 1
        }, 1000, function () {
            var curWidth = $(window).width();
            var startPos = -100;
            var midPos = (curWidth / 2) + (startPos / 2);
            var endPos = curWidth;

            $('#flight').animate({opacity: 1, left: midPos}, 5000, function () {
                $(this).animate({opacity: 0, left: endPos}, 3000, function () {
                    $(this).remove();
                });
            });
        });
    });
});

/* Khang slider */
jQuery(document).ready(function ($) {

    if ($('#slider1_container').length > 0) {

        var _SlideshowTransitions = [
            //Shift LR
            {$Duration: 1200, x: 1, $Easing: {$Left: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear}, $Opacity: 2, $Brother: {$Duration: 1200, x: -1, $Easing: {$Left: $JssorEasing$.$EaseInOutQuart, $Opacity: $JssorEasing$.$EaseLinear}, $Opacity: 2}}
        ];

        var options = {
            $AutoPlay: true, //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
            $AutoPlaySteps: 1, //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
            $AutoPlayInterval: 3000, //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
            $PauseOnHover: 1, //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

            $ArrowKeyNavigation: true, //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
            $SlideDuration: 500, //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
            $MinDragOffsetToSlide: 20, //[Optional] Minimum drag offset to trigger slide , default value is 20
            //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
            //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
            $SlideSpacing: 0, //[Optional] Space between each slide in pixels, default value is 0
            $DisplayPieces: 1, //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
            $ParkingPosition: 0, //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
            $UISearchMode: 1, //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
            $PlayOrientation: 1, //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
            $DragOrientation: 3, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

            $SlideshowOptions: {//[Optional] Options to specify and enable slideshow or not
                $Class: $JssorSlideshowRunner$, //[Required] Class to create instance of slideshow
                $Transitions: _SlideshowTransitions, //[Required] An array of slideshow transitions to play slideshow
                $TransitionsOrder: 1, //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
                $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
            },
            $BulletNavigatorOptions: {//[Optional] Options to specify and enable navigator or not
                $Class: $JssorBulletNavigator$, //[Required] Class to create navigator instance
                $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                $AutoCenter: 1, //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                $Steps: 1, //[Optional] Steps to go for each navigation request, default value is 1
                $Lanes: 1, //[Optional] Specify lanes to arrange items, default value is 1
                $SpacingX: 10, //[Optional] Horizontal space between each item in pixel, default value is 0
                $SpacingY: 10, //[Optional] Vertical space between each item in pixel, default value is 0
                $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
            },
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$, //[Requried] Class to create arrow navigator instance
                $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
            }
        };
        var jssor_slider1 = new $JssorSlider$("slider1_container", options);

        //responsive code begin
        //you can remove responsive code if you don't want the slider scales while window resizes
        function ScaleSlider() {
            var parentWidth = jssor_slider1.$Elmt.parentNode.parentNode.parentNode.clientWidth;
            if (parentWidth)
                jssor_slider1.$ScaleWidth(Math.min(parentWidth, 850));
            else
                window.setTimeout(ScaleSlider, 30);
        }
        ScaleSlider();

        $(window).bind("load", ScaleSlider);
        $(window).bind("resize", ScaleSlider);
        $(window).bind("orientationchange", ScaleSlider);
        //responsive code end
    }
});