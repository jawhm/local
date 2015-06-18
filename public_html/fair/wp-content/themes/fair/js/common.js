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

$(function () {
    // Slider
    $('.slide_body').bxSlider({
        slideWidth: 215,
        minSlides: 3,
        maxSlides: 3,
        moveSlides: 1,
        slideMargin: 0,
    });
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
        console.log(target);
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
    $('div.keyvisual').delay(500).fadeIn(5000);

    $('div.keyvisual p').delay(1000).animate({
        top: '-100%',
    }, {
        duration: 'fast',
        easing: 'swing'
    }).animate({
        top: '41%',
        opacity: 1
    }, {
        duration: 'slow',
        easing: 'swing'
    });

});