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
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/css/jquery.sidr.dark.css">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/css/simple.modal.css">

        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script> 
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script> 
        <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/jquery.smoothScroll.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/jquery.bxslider.min.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/prefixfree.min.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/jquery.sidr.min.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/jquery.heightLine.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/jssor/js/jssor.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/jssor/js/jssor.slider.js"></script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/common.js"></script>
        
        <script>
            $(document).ready(function () {
                $('#openMenu').sidr({
                    side: 'right'
                });
            });
        </script>

        <script>
            $(function () {
                $(".sclList ul li.sclBox").heightLine({
                });
            });
        </script>

        <!--[if lt IE 9]>
          <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
          <script src="<?php echo get_template_directory_uri() ?>/js/html5shiv.min.js"></script>
            <![endif]-->

        <!--[if lt IE 8]>
            <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/selectivizr.js"></script>
        <![endif]-->

        <!--[if lte IE 6]>
           <script type="text/javascript" src="js/DD_belatedPNG_0.0.8a.js"></script>
           <script type="text/javascript">
             DD_belatedPNG.fix('img , div , li');
            </script>
        <![endif]-->
        <?php wp_head() ?>
    </head>

    <body id="top">
        <div class="wrapper">
            <header class="head">
                <h1><a href="/fair">ワーキングホリデー＆留学フェア2015年秋</a></h1>       
                <nav class="topNav pcview clearfix">
                    <a class="btn reserve pcview" href="">セミナー予約</a>
                    <a class="nav01" href="/fair/seminar/">セミナースケジュール</a>
                    <a class="nav02" href="/fair/school/">参加語学学校紹介</a>
                    <a class="nav03" href="/fair/faq/">よくある質問</a>
                    <a class="nav04" href="/fair/access/">会場アクセス</a>
                </nav><!-- topNav / pcview -->

                <ul class="topNav spview">
                    <li><a class="reserve" href="">セミナー予約</a></li>
                    <li><a id="openMenu" class="menu" href="#sidr">MENU</a></li>
                </ul><!-- topNav / spview -->        
                <img class="tabImg pcview" src="<?php echo get_template_directory_uri() ?>/images/bgTabImg.png" alt="">
            </header>

            <div id="sidr" class="spview">
                <ul>
                    <li><a class="nav01" href="/fair/seminar/">セミナースケジュール</a></li>
                    <li><a class="nav02" href="/fair/school/">参加語学学校紹介</a></li>
                    <li><a class="nav03" href="/fair/faq/">よくある質問</a></li>
                    <li><a class="nav04" href="/fair/access/">会場アクセス</a></li>
                </ul>
            </div>


