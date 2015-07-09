<?php
/*
 * Template name: school_list
 */
get_header()
?>

<div class="underSec school">

    <div class="keyvisual school">
        <p>ワーキングホリデー＆留学フェアに参加している語学学校一覧</p>
    </div><!-- /.keyvisual -->      

    <!-- ▼ ワーキングホリデー＆留学フェアとは？ ▼ -->      
    <section class="normalBox">
        <h2 class="hukidashi">参加語学学校一覧<span>SCHOOL LIST</span></h2> 

        <div class="contentBox noPad">        
            <p class="planeText mgb20">
                ワーキングホリデー＆留学フェアには世界中から30校以上の海外語学学校スタッフのみなさまが来日されます。気になる語学学校がありましたらぜひこの機会にセミナーにお越しください！
            </p><!-- /.planeText -->            
            <div class="srcArea" id="rePoint">
                <h3>学校を国から探す</h3>

                <?php
                $args = array('hide_empty=0');
                $terms = get_terms('country', $args);
                $i = 1;
                $open_flag = false;
                $loop_category = '';
                $section_count = count($terms);
                foreach ($terms as $term):

                    if ($i % 2 !== 0) {
                        if ($open_flag == false) {
                            $loop_category .= '<ul>';
                            $open_flag = true;
                        }
                        $loop_category .= '<li><a class="btn Navy2" style="background: ' . get_school_button_bg() . ' !important;color: ' . get_school_button_color() . ' !important;border-color: ' . get_school_button_color() . '" href="#' . $term->slug . '">' . $term->name . '</a></li>';
                        //
                        if ($i == $section_count) {
                            $loop_category .= '</ul> <!-- /.areaList -->';
                        }
                    } else {
                        $loop_category .= '<li><a class="btn Navy2" style="background: ' . get_school_button_bg() . ' !important;color: ' . get_school_button_color() . ' !important;border-color: ' . get_school_button_color() . '" href="#' . $term->slug . '">' . $term->name . '</a></li>';
                        if ($open_flag == true) {
                            $loop_category .= '</ul> <!-- /.areaList -->';
                            $open_flag = false;
                        }
                    }

                    $i++;

                endforeach;
                ?>
                <?php wp_reset_postdata(); ?>

                <?php echo $loop_category ?>

            </div><!-- /.srcArea -->

            <?php
            $args = array('hide_empty=0');
            $terms = get_terms('country', $args);
            $i = 1;
            $loop_temp = '';
            $section_count = count($terms);
            foreach ($terms as $term):

                $args = array(
                    'post_type' => 'school',
                    'posts_per_page' => 5,
                    'offset' => 0,
                    'orderby' => array('date' => 'ASC'),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'country',
                            'field' => $term->slug,
                            'terms' => array($term->term_id),
                        )
                    )
                );
                $loop = new WP_Query($args);
                //
                $args = array(
                    'post_type' => 'school',
                    'posts_per_page' => 12,
                    'offset' => 0,
                    'orderby' => array('date' => 'ASC'),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'country',
                            'field' => $term->slug,
                            'terms' => array($term->term_id),
                        )
                    )
                );
                $loop_list = new WP_Query($args);

                $article_count = $loop->post_count;
                $section_class = ($i == $section_count) ? 'pdb30' : '';
                $diag_color = array(1 => 'orange', 2 => 'pink', 3 => 'green', 4 => 'aqua');
                $sclBox_color = array(1 => 'sclOrange', 2 => 'sclPink', 3 => 'sclGreen', 4 => 'sclAqua');

                //
                $loop_temp .= '<section class="schoolArea ' . $section_class . '" id="' . $term->slug . '">';
                $loop_temp .= '<h3 class="diag ' . $diag_color[$i] . '">' . $term->name . 'の語学学校<span>' . $term->slug . '</span></h3>';

                $loop_temp .= '<div class="container">';
                $loop_temp .= '<div class="slide_wrap">';
                $loop_temp .= '<ul class="slide_body">';

                while ($loop->have_posts()): $loop->the_post();
                    $loop_temp .= '<li class="slide">';
                    $loop_temp .= '<img src="' . get_field('image') . '" alt="' . get_the_title() . '">';
                    $loop_temp .= '<h4><a href="' . get_post_permalink() . '"><span>' . get_field('rubi') . '</span>' . get_the_title() . '</a></h4>';
                    $loop_temp .= '<p>' . get_field('catchphrase') . '</p>';
                    $loop_temp .= '</li>';
                endwhile;

                $loop_temp .= '</ul>';
                $loop_temp .= '</div>';
                $loop_temp .= '</div>';

                $loop_li = '';
                $k = 1;
                $open_flag = false;
                $loop_temp .= '<div class="sclList"> ';
                while ($loop_list->have_posts()): $loop_list->the_post();

                    if ($k % 2 !== 0) {
                        if ($open_flag == false) {
                            $loop_li .= ' <ul class="clearfix">';
                            $open_flag = true;
                        }
                        $loop_li .= '<li class="sclBox ' . $sclBox_color[$i] . '">';
                        $loop_li .= '<a href="' . get_post_permalink() . '">' . get_the_title() . '</a>';
                        $loop_li .= '<p class="name"><span>' . get_field('rubi') . '</span>' . get_the_title() . '</p>';
                        $loop_li .= '<img class="logo" src="' . get_field('logo') . '" alt="' . get_the_title() . '">';
                        $loop_li .= '<p class="caption">' . get_field('catchphrase') . '</p>';
                        $loop_li .= '</li><!-- /.sclBox -->';
                        //
                        if ($k == $loop_list->post_count) {
                            $loop_li .= '</ul> ';
                        }
                    } else {
                        $loop_li .= '<li class="sclBox ' . $sclBox_color[$i] . '">';
                        $loop_li .= '<a href="' . get_post_permalink() . '">' . get_the_title() . '</a>';
                        $loop_li .= '<p class="name"><span>' . get_field('rubi') . '</span>' . get_the_title() . '</p>';
                        $loop_li .= '<img class="logo" src="' . get_field('logo') . '" alt="' . get_the_title() . '">';
                        $loop_li .= '<p class="caption">' . get_field('catchphrase') . '</p>';
                        $loop_li .= '</li><!-- /.sclBox -->';
                        if ($open_flag == true) {
                            $loop_li .= '</ul> ';
                            $open_flag = false;
                        }
                    }

                    $k++;
                endwhile;

                $loop_temp .= $loop_li;
                $loop_temp .= '<div class="clearfix mgt20"><a href="#rePoint" class="btn Navy3 right w60">国選択へもどる</a></div>';
                $loop_temp .= '</div>';
                $loop_temp .= '</section><!-- /.schoolArea -->';

                $i++;
            endforeach;
            ?>
            <?php wp_reset_postdata(); ?>

            <?php echo $loop_temp ?>

        </div><!-- /.contentBox -->         
    </section><!-- /.normalBpx -->
</div><!-- /.underSec -->

<section class="normalBox footSec">      	      	
    <?php get_footer() ?>