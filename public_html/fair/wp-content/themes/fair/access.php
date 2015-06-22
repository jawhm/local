<?php
/*
 * Template name: access
 */
get_header();
?>

<div class="underSec access">

    <div class="keyvisual access">
        <p>会場アクセス</p>
        <!--img src="images/icon_plane.png" alt="飛行機"-->
    </div><!-- /.keyvisual -->      

    <!-- ▼ ワーキングホリデー＆留学フェアとは？ ▼ -->      
    <section class="normalBox">
        <h2 class="hukidashi">会場アクセス<span>ACCESS</span></h2> 

        <div class="contentBox">        
            <p class="planeText">
                各開催会場へのアクセス方法をご案内いたします。<br>※ご来場はすべてご予約制となっております。
            </p><!-- /.planeText -->

            <?php if (get_access_menu_status()): ?>
                <div class="srcArea">
                    <ul>
                        <?php if(get_access_tokyo_status()): ?><li><a class="btn Navy2" href="#tokyo">東京会場</a></li><?php endif ?>
                        <?php if(get_access_osaka_status()): ?><li><a class="btn Navy2" href="#osaka">大阪会場</a></li><?php endif ?>
                    </ul><!-- /.areaList -->
                    <ul>
                        <?php if(get_access_nagoya_status()): ?><li><a class="btn Navy2" href="#nagoya">名古屋会場</a></li><?php endif ?>
                        <?php if(get_access_fukuoka_status()): ?><li><a class="btn Navy2" href="#fukuoka">福岡会場</a></li><?php endif ?>
                    </ul><!-- /.areaList -->
                </div><!-- /.btnArea -->
            <?php endif; ?>

            <?php if (get_access_tokyo_status()): ?>
                <section class="areaBox" id="tokyo">
                    <h3>東京会場<span>TOKYO OFFICE</span></h3>
                    <?php if (get_access_tokyo_image()): ?>
                        <img src="<?php echo get_access_tokyo_image() ?>" alt="東京会場写真">
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri() ?>/images/access/tokyoImg_sp.jpg" alt="東京会場写真">
                    <?php endif; ?>
                    <p class="textArea">
                        <?php echo get_access_tokyo_info() ?>
                    </p><!-- /.planeText -->
                    <div class="btnShadow2 mgb20 w90"><a class="btn Orng" style="background: <?php echo get_access_button_color() ?> !important" href="">東京開催のセミナーはこちら</a></div>
                    <div class="mapArea">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d810.0858618679962!2d139.69881659999996!3d35.693165100000016!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188cd701e48371%3A0x392ba008ab2d3ff3!2z44CSMTYwLTAwMjMg5p2x5Lqs6YO95paw5a6_5Yy66KW_5paw5a6_77yR5LiB55uu77yT4oiS77yT!5e0!3m2!1sja!2sjp!4v1432282314238" width="100%" height="200px" frameborder="0" style="border:0"></iframe>
                        <a class="btn mapBtn" href="http://maps.google.com/maps?q=東京都新宿区西新宿1-3-3品川ステーションビル新宿"><span>行き方をみる</span></a>
                    </div><!-- /.mapArea -->
                </section><!-- /.areaBox -->
            <?php endif; ?>

            <?php if (get_access_osaka_status()): ?>
                <section class="areaBox" id="osaka">
                    <h3>大阪会場<span>OSAKA OFFICE</span></h3>
                    <?php if (get_access_osaka_image()): ?>
                        <img src="<?php echo get_access_osaka_image() ?>" alt="大阪会場写真">
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri() ?>/images/access/osakaImg_sp.jpg" alt="大阪会場写真">
                    <?php endif; ?>
                    <p class="textArea">
                        <?php echo get_access_osaka_info() ?>
                    </p><!-- /.planeText -->
                    <div class="btnShadow2 mgb20 w90"><a class="btn Orng" style="background: <?php echo get_access_button_color() ?> !important" href="">大阪開催のセミナーはこちら</a></div>
                    <div class="mapArea">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d205.013114775631!2d135.49870409999997!3d34.69988699999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6000e6ed22f796cf%3A0xd44698fd37ddab2b!2z5aSn6Ziq6aeF5YmN56ys77yU44OT44Or566h55CG5LqL5YuZ5omA!5e0!3m2!1sja!2sjp!4v1432286546608" width="100%" height="200px" frameborder="0" style="border:0"></iframe>
                        <a class="btn mapBtn" href="http://maps.google.com/maps?q=大阪市北区梅田1-11-4-500大阪駅前第4ビル"><span>行き方をみる</span></a>
                    </div><!-- /.mapArea -->
                </section><!-- /.areaBox -->
            <?php endif; ?>

            <?php if (get_access_nagoya_status()): ?>
                <section class="areaBox" id="nagoya">
                    <h3>名古屋会場<span>NAGOYA OFFICE</span></h3>
                    <?php if (get_access_nagoya_image()): ?>
                        <img src="<?php echo get_access_nagoya_image() ?>" alt="名古屋会場写真">
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri() ?>/images/access/nagoyaImg_sp.jpg" alt="名古屋会場写真">
                    <?php endif; ?>
                    <p class="textArea">
                        <?php echo get_access_nagoya_info() ?>
                    </p><!-- /.planeText -->
                    <div class="btnShadow2 mgb20 w90"><a class="btn Orng" style="background: <?php echo get_access_button_color() ?> !important" href="">名古屋開催のセミナーはこちら</a></div>
                    <div class="mapArea">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d407.66672881417384!2d136.88358378162243!3d35.17323126409777!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x600376e82242d7c5%3A0xb8e2e0ad74628d14!2z44CSNDUwLTAwMDIg5oSb55-l55yM5ZCN5Y-k5bGL5biC5Lit5p2R5Yy65ZCN6aeF77yS5LiB55uu77yU77yV4oiS77yR77yZIOahkeWxseODk-ODqw!5e0!3m2!1sja!2sjp!4v1432287224721" width="100%" height="200px" frameborder="0" style="border:0"></iframe>
                        <a class="btn mapBtn" href="http://maps.google.com/maps?q=名古屋市中村区名駅2-45-19桑山ビル"><span>行き方をみる</span></a>
                    </div><!-- /.mapArea -->
                </section><!-- /.areaBox -->
            <?php endif; ?>

            <?php if (get_access_fukuoka_status()): ?>
                <section class="areaBox" id="fukuoka">
                    <h3>福岡会場<span>FUKUOKA OFFICE</span></h3>
                    <?php if (get_access_fukuoka_image()): ?>
                        <img src="<?php echo get_access_fukuoka_image() ?>" alt="福岡会場写真">
                    <?php else: ?>
                        <img src="<?php echo get_template_directory_uri() ?>/images/access/fukuokaImg_sp.jpg" alt="福岡会場写真">
                    <?php endif; ?>
                    <p class="textArea">
                        <?php echo get_access_fukuoka_info() ?>
                    </p><!-- /.planeText -->
                    <div class="btnShadow2 mgb20 w90"><a class="btn Orng" style="background: <?php echo get_access_button_color() ?> !important" href="">福岡開催のセミナーはこちら</a></div>
                    <div class="mapArea">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d207.73387608066528!2d130.40245785!3d33.58604695000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3541919a91841cad%3A0x97bed4f6fd1f8963!2z44CSODEwLTAwMDQg56aP5bKh55yM56aP5bKh5biC5Lit5aSu5Yy65rih6L666YCa77yU5LiB55uu77yW4oiS77yS77yQIOaYn-mHjuODk-ODqw!5e0!3m2!1sja!2sjp!4v1432287370272" width="100%" height="200px" frameborder="0" style="border:0"></iframe>
                        <a class="btn mapBtn" href="http://maps.google.com/maps?q=福岡市中央区渡辺通4-6-20星野ビル"><span>行き方をみる</span></a>
                    </div><!-- /.mapArea -->
                </section><!-- /.areaBox -->
            <?php endif; ?>

        </div><!-- /.contentBox -->         
    </section><!-- /.normalBpx -->
</div><!-- /.underSec -->

<section class="normalBox footSec">      	
    <?php get_footer() ?>