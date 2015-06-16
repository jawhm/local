<?php get_header(); ?>

<div class="keyvisual">
    <?php if (get_banner_text_status()) { ?>
        <p><?php echo get_banner_text_1() ?></p><span><?php echo get_banner_text_2() ?></span>
    <?php } ?>
    <!--img src="images/icon_plane.png" alt="飛行機"-->
</div><!-- /.keyvisual -->      

<?php if (get_about_status()): ?>
    <!-- ▼ ワーキングホリデー＆留学フェアとは？ ▼ -->
    <section class="normalBox topSec1">
        <h2 class="hukidashi"><?php echo get_about_text() ?><span>ABOUT</span></h2>
        <img class="w100 spview" src="<?php echo get_template_directory_uri() ?>/images/sec01_key.jpg" alt="キービジュアル">

        <div class="contentBox">
            <?php if (get_about_image_url() != ''): ?>
                <img class="pcview left" src="<?php echo get_about_image_url() ?>" alt="キービジュアル">          
            <?php else: ?>
                <img class="pcview left" src="<?php echo get_template_directory_uri() ?>/images/sec01_key_pc.jpg" alt="キービジュアル">          
            <?php endif; ?>
            <p class="planeText mgb20 pdl430">
                <?php echo get_about_description() ?>
            </p><!-- /.planeText -->
            <ul class="btnList pdl55 about">
                <li class="left w60"><a class="btn Orng2" href="">セミナースケジュール</a></li>
                <li class="right w40"><a class="btn Orng2" href="">アクセス</a></li>
            </ul><!-- /.btnList -->
        </div><!-- /.contentBox -->
    </section><!-- /.normalBpx -->
<?php endif; ?>

<?php if (get_point_status()): ?>
    <!-- ▼ ワーキングホリデー＆留学フェアのポイント ▼ -->      
    <section class="normalBox">
        <h2 class="hukidashi"><?php echo get_point_text() ?><span>POINT</span></h2>
        <div class="contentBox topSec2">
            <ul class="point green mgb10">
                <li>
                    <p><span>PONIT.1</span>セミナーで<br>有益な情報収集</p>
                    <a class="btn" href="">+more</a>
                </li>
                <li>
                    <p><span>PONIT.2</span>学校スタッフと<br>直接話が出来る</p>
                    <a class="btn" href="">+more</a>
                </li>
            </ul><!-- /.point -->        
            <ul class="point green">
                <li>
                    <p><span>PONIT.3</span>その場での<br>お申込みが可能</p>
                    <a class="btn" href="">+more</a>
                </li>
                <li>
                    <p><span>PONIT.4</span>セミナー後に<br>質疑応答タイム有</p>
                    <a class="btn" href="">+more</a>
                </li>
            </ul><!-- /.point -->        
            <ul class="point green lastUl">
                <li>
                    <p><span>PONIT.5</span>参加者特典有り</p>
                    <a class="btn" href="">+more</a>
                </li>
                <!--li>
                  <p><span>PONIT.2</span>学校スタッフと直接話が出来る</p>
                  <a href="">+more</a>
                </li-->
            </ul><!-- /.point -->

            <div class="modal-area">
                <div class="modal panel01">
                    <p>ここに詳細説明を記述します。</p>
                    <div class="close"><span>close</span></div>
                </div><!-- /.panel01 -->

                <div class="modal panel02">
                    <p>ここに詳細説明を記述します。</p>
                    <div class="close"><span>close</span></div>
                </div><!-- /.panel01 -->

                <div class="modal panel03">
                    <p>ここに詳細説明を記述します。</p>
                    <div class="close"><span>close</span></div>
                </div><!-- /.panel01 -->

                <div class="modal panel04">
                    <p>ここに詳細説明を記述します。</p>
                    <div class="close"><span>close</span></div>
                </div><!-- /.panel01 -->

                <div class="modal panel05">
                    <p>ここに詳細説明を記述します。</p>
                    <div class="close"><span>close</span></div>
                </div><!-- /.panel01 -->          
            </div><!-- /.modal-area -->


            <div class="btnShadow mgt30 w60 pcview"><a class="btn Orng" href="">スケジュール＆ご予約はこちら</a></div>        
            <div class="btnShadow mgt30 w90 spview"><a class="btn Orng" href="">スケジュール＆ご予約はこちら</a></div>
        </div><!-- /.contentBox -->
    </section><!-- /.normalBpx -->
<?php endif; ?>

<?php if (get_guide_status()): ?>
    <!-- ▼ フェアセミナー参加ガイドここから ▼ -->      
    <section class="normalBox">
        <h2 class="hukidashi"><?php echo get_guide_text() ?><span>GUIDE</span></h2>
        <div class="contentBox">
            <section class="semBox mgb30">
                <h3 class="step1"><span>STEP1</span><?php echo get_guide_step_1_text() ?></h3>
                <div class="inner">
                    <?php if (get_guide_step_1_image() != ''): ?>
                        <img src="<?php echo get_guide_step_1_image() ?>" alt="セミナー画像">
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri() ?>/images/photo_step01.jpg" alt="セミナー画像">
                    <?php endif; ?>
                    <p>
                        <?php echo get_guide_step_1_description() ?>
                        <?php echo get_guide_step_1_button() ?>
                    </p>
                </div><!-- /.inner -->
                <?php echo get_guide_step_1_button_sp() ?>
            </section><!-- /.semBox -->

            <section class="semBox">
                <h3 class="step2"><span>STEP2</span><?php echo get_guide_step_2_text() ?></h3>
                <div class="inner">
                    <?php if (get_guide_step_2_image() != ''): ?>
                        <img src="<?php echo get_guide_step_2_image() ?>" alt="セミナー画像">
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri() ?>/images/photo_step02.jpg" alt="セミナー画像">
                    <?php endif; ?>
                    <p>
                        <?php echo get_guide_step_2_description() ?>
                        <?php echo get_guide_step_2_button() ?>
                    </p>
                </div><!-- /.inner -->
                <?php echo get_guide_step_2_button_sp() ?>
            </section><!-- /.semBox -->
        </div><!-- /.contentBox -->
    </section><!-- /.normalBox -->
<?php endif; ?>

<?php if (get_index_seminar_status()): ?>
    <!-- ▼ セミナー紹介ここから ▼ -->            
    <section class="normalBox">
        <h2 class="hukidashi"><?php echo get_index_seminar_text() ?><span>SEMINAR</span></h2>
        <div class="contentBox">
            <?php if(get_index_seminar_description() != ''): ?>
            <p class="planeText mgb20"><?php echo get_index_seminar_description() ?></p>
            <?php endif; ?>

            <section class="semBox2 firstSem">
                <div class="inner">
                    <img src="<?php echo get_template_directory_uri() ?>/images/photo_sem01.jpg" alt="セミナー画像">
                    <div class="textBox">
                        <h3>初心者向けセミナー</h3>
                        <p>ワーキングホリデー・留学の基本が1日でわかる大人気のセミナーです。初めの方はまずこちらにご参加ください。</p>
                    </div><!-- /.textBox -->
                </div><!-- /.inner -->
                <ul class="feature">
                    <li>一度にワーホリ＆留学の基本がわかるセミナー</li>
                    <li>ビザ～準備まで全ての疑問不安を解決できます！</li>
                    <li>当協会カウンセラーがわかりやすくご説明します</li>
                </ul><!-- /.feature -->
                <div class="btnShadow2 w90"><a class="btn Green" href="">このセミナーを予約する</a></div>
            </section><!-- /.semBox2 firstSem -->

            <section class="semBox2 blueSem">
                <div class="inner">
                    <img src="<?php echo get_template_directory_uri() ?>/images/photo_sem02.jpg" alt="セミナー画像">
                    <div class="textBox">
                        <h3>語学学校セミナー</h3>
                        <p>来日中の語学学校スタッフによる特別セミナー。セミナー後には直接ご相談が可能！不安や疑問を解決できます。</p>
                    </div><!-- /.textBox -->
                </div><!-- /.inner -->
                <ul class="feature">
                    <li>語学学校によるフェアだけの特別セミナー</li>
                    <li>来日中の学校スタッフと直接話して疑問解決！</li>
                    <li>渡航費用が安くなる！？特典＆即日お申込みも</li>
                </ul><!-- /.feature -->
                <div class="btnShadow2 w90"><a class="btn Blue" href="">このセミナーを予約する</a></div>
            </section><!-- /.semBox2 blueSem -->

            <div class="pcview clearfix"></div>

            <section class="semBox2 orangeSem">
                <div class="inner">
                    <img src="<?php echo get_template_directory_uri() ?>/images/photo_sem03.jpg" alt="セミナー画像">
                    <div class="textBox">
                        <h3>体験談セミナー</h3>
                        <p>よかったことはもちろん失敗したことまでワーホリ・留学体験者とお話ができる少人数制の人気セミナー。</p>
                    </div><!-- /.textBox -->
                </div><!-- /.inner -->
                <ul class="feature">
                    <li>経験者だからお話出来る現地の生の声</li>
                    <li>よかったことはもちろん失敗したことまで渡航前の皆さんのタメになる内容です</li>
                </ul><!-- /.feature -->
                <div class="btnShadow2 w90"><a class="btn Orng" href="">このセミナーを予約する</a></div>
            </section><!-- /.semBox2 blueSem -->

            <section class="semBox2 pinkSem">
                <div class="inner">
                    <img src="<?php echo get_template_directory_uri() ?>/images/photo_sem04.jpg" alt="セミナー画像">
                    <div class="textBox">
                        <h3>懇談カウンセリング</h3>
                        <p>プロのカウンセラーに渡航の相談ができる少人数制のカウンセリング。プランニングに最適なセミナーです。</p>
                    </div><!-- /.textBox -->
                </div><!-- /.inner -->
                <ul class="feature">
                    <li>渡航の相談・プランニングが可能</li>
                    <li>小人数制なので一人一人にあった内容をお話</li>
                    <li>渡航経験のあるプロのカウンセラーが担当</li>
                </ul><!-- /.feature -->
                <div class="btnShadow2 w90"><a class="btn Pink" href="">このセミナーを予約する</a></div>
            </section><!-- /.semBox2 blueSem -->

        </div><!-- /.contentBox -->        
    </section><!-- /.normalBox -->
<?php endif; ?>

<?php if (get_voice_status()): ?>
    <!-- ▼ セミナー参加者の声 ▼ -->            
    <section class="normalBox mgb30">
        <h2 class="hukidashi"><?php echo get_voice_text() ?><span>VOICE</span></h2>
        <div class="contentBox">
            <ul class="voiceList">
                <li>
                    <img src="<?php echo get_template_directory_uri() ?>/images/photo_voice01.jpg" alt="参加者の写真">
                    <p>
                        様々な留学への考えやきっかけを聞けたのは非常に貴重でした。<br>
                        自分のやりたいことをもっと具体的にしぼっていかないといけないと思いました。
                        <span>（女性）</span>
                    </p>
                </li>          
                <li>
                    <img src="<?php echo get_template_directory_uri() ?>/images/photo_voice02.jpg" alt="参加者の写真">
                    <p>
                        カウンセラーの方のお話がいい事も悪い事もリアルで泣きそうになった。<br>
                        色んな年齢、職業の人がどのような目的やきっかけで海外に行こうと思ったかなど話が聞けて楽しかった。
                        <span>（26歳　女性　美容師）</span>
                    </p>
                </li>          
                <li>
                    <img src="<?php echo get_template_directory_uri() ?>/images/photo_voice03.jpg" alt="参加者の写真">
                    <p>
                        海外での生活、ワーキングホリデーに行くまでの経緯、感じたことなど色々お話しをきけて、これから何を準備すればいいか、目的意識など考えるきっかけになりました。また同じ悩みをもった人たちと交流出来て楽しかったです。
                        <span>（25歳　男性）</span>
                    </p>
                </li>        
            </ul><!-- /.voiceList -->
        </div><!-- /.contentBox -->
    </section><!-- /.normalBox -->
<?php endif; ?>

<div class="btnShadow w80 mgb30 spview"><a class="btn Orng" href="">スケジュール＆ご予約はこちら</a></div>

<section class="normalBox footSec">
    <div class="btnShadow w60 mgb30"><a class="btn Orng" href="">スケジュール＆ご予約はこちら</a></div>      
    <?php get_footer(); ?>