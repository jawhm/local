<?php
/*
 * Template name: FAQ
 */
get_header()
?>

<div class="underSec faq">

    <div class="keyvisual faq">
        <p>会場アクセス</p>
        <!--img src="images/icon_plane.png" alt="飛行機"-->
    </div><!-- /.keyvisual -->      

    <!-- ▼ ワーキングホリデー＆留学フェアとは？ ▼ -->      
    <section class="normalBox">
        <h2 class="hukidashi">よくある質問<span>Q&amp;A</span></h2> 

        <div class="contentBox">        
            <p class="planeText mgb20">
                ワーキングホリデー＆留学フェアについて、みなさまからよくいただく質問を掲載しております。
            </p><!-- /.planeText -->

            <?php
            query_posts("post_type=question&posts_per_page=-1&orderby=date&order=asc");
            if (have_posts()): while (have_posts()): the_post();
                    ?>
                    <dl class="faqBox">
                        <dt><?php the_field("question") ?></dt>
                        <dd>
                            <span><?php the_field("caption") ?></span>
                            <?php the_field("answer") ?>
                        </dd>
                    </dl>
                <?php endwhile;
            endif; ?>

        </div><!-- /.contentBox -->         
    </section><!-- /.normalBpx -->
</div><!-- /.underSec -->

<div class="btnShadow w80 mgb30 spview"><a class="btn Orng" href="<?php bloginfo("url") ?>/seminar/">スケジュール＆ご予約はこちら</a></div>

<section class="normalBox footSec">
    <div class="btnShadow w60 mgb30"><a class="btn Orng" href="<?php bloginfo("url") ?>/seminar/">スケジュール＆ご予約はこちら</a></div>          	
<?php get_footer() ?>