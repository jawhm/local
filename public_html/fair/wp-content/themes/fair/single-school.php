<?php
get_header();

if(wp_is_mobile()){
    $config = array(
        'view_mode' => 'list',
        'start_date' => get_start_date(),
        'end_date' => get_end_date(),
        'list' => array(
            'place_default' => '',
            'title' => get_the_title(),
            'count_field_active' => 'deactive',
        ),
    );
}else{
    $config = array(
        'start_date' => get_start_date(),
        'end_date' => get_end_date(),
        'view_mode' => 'list',
        'calendar' => array(
            'place_default' => '',
            'title' => get_the_title(),
            'place_active' => 'deactive',
            'country_active' => 'deactive',
            'know_active' => 'deactive',
            'calendar_icon_active' => 'deactive',
            'count_field_active' => 'deactive',
            'calendar_title_active' => 'deactive',
            'calendar_desc_active' => 'deactive',
            'footer_desc_active' => 'deactive',
        )
    );
}
$sm = new SeminarModule($config);
?>

      <div class="underSec schoolList">
      
        <a href="<?php bloginfo("url") ?>/seminar/" class="returnHd">学校一覧に戻る</a>      
        
        <!-- ▼ ワーキングホリデー＆留学フェアとは？ ▼ -->      
        <section class="normalBox">
            <p class="area aus"><?php $term = get_the_terms($post->ID, 'country'); echo $term[0]->name ?>　<?php the_field("place") ?></p>
            <h2 class="sclLogo"><img src="<?php the_field('logo') ?>" alt="<?php the_title() ?>"><span><?php the_title() ?></span></h2>
          <!--<ul class="bxslider">
          	<li><img src="<?php the_field('image') ?>" alt="スライド画像"></li>
          </ul>-->
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
                <?php
                foreach (get_field("images") as $image):
                ?>
                <div>
                    <img u="image" src="<?php echo $image["image"] ?>" />
                </div>
                <?php endforeach; ?>
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
                            
              <div class="comment" style="border-color: <?php the_field("color") ?>">
            	<h3>現地スタッフからのコメント</h3>
              <img class="left" src="<?php the_field('staff_image') ?>" alt="スタッフ写真">
              <p class="text">
              	<?php the_field('staff_comment') ?>
              </p><!-- /.text -->
            </div><!-- /.comment -->
            
            <div class="btnShadow2 mgb20 w90"><a href="<?php bloginfo("url") ?>/seminar/?title=語学学校" class="btn Orng" style="background-color: <?php the_field("color") ?>">語学学校セミナーはこちら</a></div>
            
            <section class="feature">
            	<h3>この語学学校の特徴</h3>
              <dl>
                <?php
                   foreach (get_field('features') as $feature):
                ?>
                    <dt><?php echo $feature['caption'] ?></dt>
                    <dd><?php echo $feature['text'] ?></dd>
                <?php endforeach; ?>             
              </dl>
            </section><!-- /.feature -->
            
            <section class="semSche">
            	<h3>この語学学校のセミナースケジュール</h3>
              <?php $sm->show() ?>
            </section><!-- /.semSche -->
            
            <a class="returnFt spview" href="<?php bloginfo("url") ?>/seminar/">学校一覧に戻る</a>
          </div><!-- /.contentBox -->         
        </section><!-- /.normalBpx -->
      </div><!-- /.underSec -->
      
       <div class="btnShadow w80 mgb30 spview"><a class="btn Orng" href="<?php bloginfo("url") ?>/seminar/" style="background-color: <?php the_field("color") ?>">スケジュール＆ご予約はこちら</a></div>
       <style>
           .seminar_date{
               background-color: <?php the_field("color") ?> !important;
           }
       </style>
      <section class="normalBox footSec pad50">
          <div class="btnShadow w60 mgb30"><a class="btn Orng" href="<?php bloginfo("url") ?>/seminar/">スケジュール＆ご予約はこちら</a></div>  
        <script type="text/javascript" src="<?php echo get_template_directory_uri() ?>/js/school.js"></script>
	<?php get_footer() ?>