<!doctype html>
<html>
  <head>
    <title>留学・ワーキングホリデーフェア2015年秋</title>
    <meta name="description" content="ディスクリプションが入ります" />
		<meta name="keywords" content="ワーキングホリデー,ワーホリ,留学,セミナー,海外,語学学校" />
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/3.18.1/build/cssreset/cssreset-min.css">
    <link id="size-stylesheet" rel="stylesheet" href="<?php echo get_template_directory_uri() ?>/css/style_pc.css">     
    
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/css/jquery.bxslider.css">   
    <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/common.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/jquery.smoothScroll.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/jquery.bxslider.min.js"></script>
    <!--[if lt IE 9]>
      <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script> 
   	<![endif]-->
    <!--[if lt IE 8]><script type="text/javascript" src="/fairtest/jsselectivizr.js"></script><![endif]-->
    <!--[if lte IE 6]>
       <script type="text/javascript" src="js/DD_belatedPNG_0.0.8a.js"></script>
       <script type="text/javascript">
         DD_belatedPNG.fix('img , div , li');
    	</script>
    <![endif]-->
    <script>
			$(function(){
				$('.slide_body').bxSlider({
					slideWidth: 215,
					minSlides: 3,
					maxSlides: 3,
					moveSlides: 1,
					slideMargin: 0
				});
			});

			$(function(){
					$("dl.faqBox dt").on("click", function() {
							$(this).next().slideToggle();
							$(".underSec.faq dl.faqBox").toggleClass("active");
					});
			});

			function adjustStyle(width) {
				width = parseInt(width);
				if (width < 699) {
					$("#size-stylesheet").attr("href", "/fairtest/css/style_sp.css");
				} else {
					 $("#size-stylesheet").attr("href", "/fairtest/css/style_pc.css"); 
				}
			}
			
			$(function() {
				adjustStyle($(this).width());
				$(window).resize(function() {
					adjustStyle($(this).width());
				});
			});
    </script>
    <?php wp_head() ?>
  </head>

  <body id="top">
  	<div class="wrapper">
      <header class="head">
        <h1><a href="/fairtest/">ワーキングホリデー＆留学フェア2015年秋</a></h1>       
        <nav class="topNav pcview clearfix">
        	<a class="btn reserve pcview" href="">セミナー予約</a>
          <a class="nav01" href="/fair/seminar/">セミナースケジュール</a>
          <a class="nav02" href="/fair/school/">参加語学学校紹介</a>
          <a class="nav03" href="/fair//faq/">よくある質問</a>
          <a class="nav04" href="/fair/access/">会場アクセス</a>
        </nav><!-- topNav / pcview -->
        
        <ul class="topNav spview">
          <li><a class="reserve" href="">セミナー予約</a></li>
          <li><a class="menu" href="">MENU</a></li>
        </ul><!-- topNav / spview -->
      </header>