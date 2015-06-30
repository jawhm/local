<?php
/*
 * Template name: school
 */
get_header()
?>

<div class="underSec schoolList">

    <a href="" class="returnHd">学校一覧に戻る</a>      

    <!-- ▼ ワーキングホリデー＆留学フェアとは？ ▼ -->      
    <section class="normalBox">
        <p class="area aus">オーストラリア　ゴールドコースト／ブリスベン</p>
        <h2 class="sclLogo"><img src="../../images/school/logo_browns.png" alt="BROWNS"><span>ブラウンズ</span></h2>

        <!-- Jssor Slider Begin -->
        <!-- To move inline styles to css file/block, please specify a class name for each element. --> 
        <div id="slider1_container" style="margin: 0 auto 20px; position: relative; top: 0px; left: 0px; width: 850px; height: 420px; overflow: hidden; ">

            <!-- Loading Screen -->
            <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                     background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
                </div>
                <div style="position: absolute; display: block; background: url(<?php echo get_template_directory_uri() ?>/js/jssor/img/loading.gif) no-repeat center center;
                     top: 0px; left: 0px;width: 100%;height:100%;">
                </div>
            </div>

            <!-- Slides Container -->
            <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 850px; height: 420px; overflow: hidden;">
                <div>
                    <img u="image" src="<?php echo get_template_directory_uri() ?>/images/slider/1.jpg" />
                </div>
                <div>
                    <img u="image" src="<?php echo get_template_directory_uri() ?>/images/slider/2.jpg" />
                </div>
                <div>
                    <img u="image" src="<?php echo get_template_directory_uri() ?>/images/slider/3.jpg" />
                </div>
                <div>
                    <img u="image" src="<?php echo get_template_directory_uri() ?>/images/slider/4.jpg" />
                </div>
            </div>

            <!--#region Bullet Navigator Skin Begin -->
            <style>
                /* jssor slider bullet navigator skin 05 css */
                .jssorb05 {
                    position: absolute;
                }
                .jssorb05 div, .jssorb05 div:hover, .jssorb05 .av {
                    position: absolute;
                    /* size of bullet elment */
                    width: 16px;
                    height: 16px;
                    background: url(<?php echo get_template_directory_uri() ?>/js/jssor/img/b05.png) no-repeat;
                    overflow: hidden;
                    cursor: pointer;
                }
                .jssorb05 div { background-position: -7px -7px; }
                .jssorb05 div:hover, .jssorb05 .av:hover { background-position: -37px -7px; }
                .jssorb05 .av { background-position: -67px -7px; }
                .jssorb05 .dn, .jssorb05 .dn:hover { background-position: -97px -7px; }
            </style>
            <!-- bullet navigator container -->
            <div u="navigator" class="jssorb05" style="bottom: 16px; right: 6px;">
                <!-- bullet navigator item prototype -->
                <div u="prototype"></div>
            </div>
            <!--#endregion Bullet Navigator Skin End -->

            <!--#region Arrow Navigator Skin Begin -->
            <style>
                /* jssor slider arrow navigator skin 12 css */
                .jssora14l, .jssora14r {
                    display: block;
                    position: absolute;
                    /* size of arrow element */
                    width: 30px;
                    height: 50px;
                    cursor: pointer;
                    background: url(<?php echo get_template_directory_uri() ?>/js/jssor/img/a14.png) no-repeat;
                    overflow: hidden;
                }
                .jssora14l { background-position: -15px -35px; }
                .jssora14r { background-position: -75px -35px; }
                .jssora14l:hover { background-position: -135px -35px; }
                .jssora14r:hover { background-position: -195px -35px; }
                .jssora14l.jssora14ldn { background-position: -255px -35px; }
                .jssora14r.jssora14rdn { background-position: -315px -35px; }
            </style>
            <!-- Arrow Left -->
            <span u="arrowleft" class="jssora14l" style="top: 180px; left: 0px;">
            </span>
            <!-- Arrow Right -->
            <span u="arrowright" class="jssora14r" style="top: 180px; right: 0px;">
            </span>
            <!--#endregion Arrow Navigator Skin End -->
        </div>
        <!-- Jssor Slider End -->

        <div class="contentBox noPad"> 

            <div class="comment">
                <h3>現地スタッフからのコメント</h3>
                <img class="left" src="../../images/school/browns/staff.jpg" alt="スタッフ写真">
                <p class="text">
                    BROWNS English Language Schoolはゴールドコーストとブリスベンにキャンパスを持つ家族経営の語学学校です。<br>
                    全教室に46インチの液晶テレビとPCを設置するなど、キャンパスには最新の設備とテクノロジーを導入しています。<br>
                    科目別レベル分けシステム（Active8)や教師から個別アドバイスがもらえた上で学習できるユニークなシステム（Accelerate）も大変好評で、当校を選ばれる一つの理由となっています。毎日無料のアクティビティも行っておりますので、世界各国からの学生さんと友達を作るためにも是非様々なイベントにご参加頂ければと思います。<br>
                    会場にて皆様にお会いできます事を楽しみに致しております。当日は是非何でもお気軽にご相談下さい。
                </p><!-- /.text -->
            </div><!-- /.comment -->

            <div class="btnShadow2 mgb20 w90"><a href="<?php bloginfo("url") ?>/seminar/?title=語学学校" class="btn Orng" style="background-color: <?php the_field("color") ?>">語学学校セミナーはこちら</a></div>

            <section class="feature">
                <h3>この語学学校の特徴</h3>
                <dl>
                    <dt>独自のプログラム Active8</dt>
                    <dd>Active8とは英語習得に必要な8分野のスキル（読む、書く、話す、聞く、語彙、文法、発音、場面英語）を総合的に学習するシステムです。</dd>

                    <dt>Accelerateでしっかりサポート！</dt>
                    <dd>ブラウンズパスポートを使用して、講師からアドバイスが届きます。弱点を把握した上でAccelerate の教材を使い勉強に集中できます。</dd>

                    <dt>ブラウンズならではの無料アクティビティ</dt>
                    <dd>週5回の無料のアクティビティーが行われています。世界各国からの学生と友達になるには、アクティビティの参加が近道！</dd>

                    <dt>大人気！学生アパートメント </dt>
                    <dd>学校から徒歩圏内で通える豪華学生アパートメントが人気。希望者が多い為、お早めにお問い合わせ下さい！</dd>

                    <dt>充実した英語プラスコース</dt>
                    <dd>5週間の短期集中バリスタコース（ブリスベンのみ）やビジネス専門学校への進学、企業インターンシップの手配なども行っています！</dd>              
                </dl>
            </section><!-- /.feature -->

            <section class="semSche">
                <h3>この語学学校のセミナースケジュール</h3>
                <p class="mgt10 mgb30">セミナースケジュールが入ります</p>
            </section><!-- /.semSche -->

            <a class="returnFt spview" href="">学校一覧に戻る</a>
        </div><!-- /.contentBox -->         
    </section><!-- /.normalBpx -->
</div><!-- /.underSec -->

<div class="btnShadow w80 mgb30 spview"><a class="btn Orng" href="">スケジュール＆ご予約はこちら</a></div>

<section class="normalBox footSec pad50">
    <div class="btnShadow w60 mgb30"><a class="btn Orng" href="">スケジュール＆ご予約はこちら</a></div>  
    <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/school.js"></script>
    <?php get_footer() ?>