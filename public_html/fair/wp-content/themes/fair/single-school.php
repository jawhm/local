<?php
get_header()
?>

      <div class="underSec schoolList">
      
        <a href="" class="returnHd">学校一覧に戻る</a>      
        
        <!-- ▼ ワーキングホリデー＆留学フェアとは？ ▼ -->      
        <section class="normalBox">
            <p class="area aus"><?php $term = get_the_terms($post->ID, 'country'); echo $term[0]->name ?>　<?php the_field("place") ?></p>
            <h2 class="sclLogo"><img src="<?php the_field('logo') ?>" alt="<?php the_title() ?>"><span><?php the_title() ?></span></h2>
          <ul class="bxslider">
          	<li><img src="<?php the_field('image') ?>" alt="スライド画像"></li>
          </ul>
          
                             
          <div class="contentBox noPad"> 
                            
          	<div class="comment">
            	<h3>現地スタッフからのコメント</h3>
              <img class="left" src="<?php the_field('staff_image') ?>" alt="スタッフ写真">
              <p class="text">
              	<?php the_field('staff_comment') ?>
              </p><!-- /.text -->
            </div><!-- /.comment -->
            
            <div class="btnShadow2 mgb20 w90"><a href="" class="btn Orng">語学学校セミナーはこちら</a></div>
            
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
              <p class="mgt10 mgb30">セミナースケジュールが入ります</p>
            </section><!-- /.semSche -->
            
            <a class="returnFt spview" href="">学校一覧に戻る</a>
          </div><!-- /.contentBox -->         
        </section><!-- /.normalBpx -->
      </div><!-- /.underSec -->
      
       <div class="btnShadow w80 mgb30 spview"><a class="btn Orng" href="">スケジュール＆ご予約はこちら</a></div>
      
      <section class="normalBox footSec pad50">
      	<div class="btnShadow w60 mgb30"><a class="btn Orng" href="">スケジュール＆ご予約はこちら</a></div>  
	<?php get_footer() ?>