<?php 
/*
 * Template name: seminar
 */
get_header();
?>

      <div class="underSec seminar">
      
        <div class="keyvisual">
          <p>ワーキングホリデー＆留学フェアのセミナー一覧</p>
          <!--img src="images/icon_plane.png" alt="飛行機"-->
        </div><!-- /.keyvisual -->      
        
        <!-- ▼ ワーキングホリデー＆留学フェアとは？ ▼ -->      
        <section class="normalBox">
          <h2 class="hukidashi">セミナースケジュール<span>SEMINAR SCHEDULE</span></h2> 
                             
          <div class="contentBox noPad">        
            <p class="planeText mgb20">
              <?php the_seminar_description() ?>
            </p><!-- /.planeText -->
            
            <div class="btnArea">
            	<p class="mgb10">お近くの会場をクリックしてください。</p>
              <ul>
                <li><a class="tokyo" href="">東京会場</a></li>
                <li><a class="osaka off" href="">大阪会場</a></li>
              </ul><!-- /.areaList -->
              <ul>
                <li><a class="nagoya off" href="">名古屋会場</a></li>
                <li><a class="fukuoka off" href="">福岡会場</a></li>
              </ul><!-- /.areaList -->
            </div><!-- /.btnArea -->
            <?php if(is_seminar_category_open()): ?>
            <div class="btnArea2">
            	<p class="mgb10">お好みのセミナーをクリックしてください。</p>
              <ul>
                <li><a class="first" href="">初心者セミナー</a></li>
                <li><a class="taiken off" href="">体験談セミナー</a></li>
              </ul><!-- /.areaList -->
              <ul>
                <li><a class="gogaku off" href="">語学学校セミナー</a></li>
                <li><a class="all off" href="">全てのセミナー</a></li>
              </ul><!-- /.areaList -->
            </div><!-- /.btnArea -->
            <?php endif; ?>
            
            <section class="semListArea">            	
            	<h3 class="spview">東京会場<span>の</span>初心者セミナー</h3>
              <div class="pcview clearfix">
              	<p class="left">東京会場</p>
                <p class="right">全てのセミナー<span>を表示しています</span></p>
              </div>
              
              <p>ここにセミナーの情報が入ります</p>   
              <div class="btnShadow2 mgt30 spview"><a class="btn moreView" href=""><span>もっと見る</span></a></div>
            </section><!-- /.semListArea -->         
          </div><!-- /.contentBox -->         
        </section><!-- /.normalBpx -->
      </div><!-- /.underSec -->
      
      <section class="normalBox footSec">      	
	<?php get_footer() ?>