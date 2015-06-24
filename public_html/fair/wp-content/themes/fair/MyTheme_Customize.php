<?php
/*
  Template Name: TEST CUSTOMIZE THEME
 */

function theme_customize_register($wp_customize) {
    //section definition
    //ここの記述は一例です。今後、他のカスタマイザー対応機能はこのような形で書いてください
    $wp_customize->add_section('banner', array(
        'title' => 'BANNER',
        'priority' => 20,
    ));
    $wp_customize->add_section('index', array(
        'title' => 'INDEX',
        'priority' => 21,
    ));
    $wp_customize->add_section('seminar', array(
        'title' => 'SEMINAR',
        'priority' => 22,
    ));
    $wp_customize->add_section('school', array(
        'title' => 'SCHOOL',
        'priority' => 23,
    ));
    $wp_customize->add_section('access', array(
        'title' => 'ACCESS',
        'priority' => 24,
    ));
    $wp_customize->add_section('faq', array(
        'title' => 'FAQ',
        'priority' => 25,
    ));

    //setting definition
    /* INDEX - about */
    $wp_customize->add_setting('about_status', array(
        'default' => '状態',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('about_status_c', array(
        'label' => 'ABOUTの表示非表示のON/OFF',
        'section' => 'index',
        'settings' => 'about_status',
        'type' => 'checkbox',
        'priority' => 1,
    ));

    $wp_customize->add_setting('about_text', array(
        'default' => 'ここはトップページのアバウトのテキストエリアです',
    ));
    $wp_customize->add_control('about_text_c', array(
        'section' => 'index',
        'settings' => 'about_text',
        'label' => 'ABOUTのテキスト',
        'type' => 'text',
        'priority' => 1,
    ));

    $wp_customize->add_setting('about_description', array(
        'default' => 'ここはトップページのアバウトの詳細です',
    ));
    $wp_customize->add_control('about_description_c', array(
        'section' => 'index',
        'settings' => 'about_description',
        'label' => 'ABOUTの詳細',
        'type' => 'textarea',
        'priority' => 1,
    ));

    $wp_customize->add_setting('top_kevisual');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'top_kevisual_c', array(
        'label' => 'アバウトの画像', //設定ラベル
        'section' => 'index', //セクションID
        'settings' => 'top_kevisual', //セッティングID
        'description' => 'キービジュアルの画像設定',
        'priority' => 1,
    )));

    $wp_customize->add_setting('about_button_color', array(
        'default' => '#ffffff',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'about_button_color_c', array(
        'label' => 'ボタンカラーBG変更',
        'section' => 'index',
        'settings' => 'about_button_color',
        'priority' => 1,
    )));

    $wp_customize->add_setting('about_button_border_color', array(
        'default' => '#fe7608',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'about_button_border_color_c', array(
        'label' => 'ボタンカラーBorder変更',
        'section' => 'index',
        'settings' => 'about_button_border_color',
        'priority' => 1,
    )));

    /* INDEX - point */
    $wp_customize->add_setting('point_status', array(
        'default' => '状態',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('point_status_c', array(
        'label' => 'POINTの表示非表示のON/OFF',
        'section' => 'index',
        'settings' => 'point_status',
        'type' => 'checkbox',
        'priority' => 1,
    ));

    $wp_customize->add_setting('point_text', array(
        'default' => 'ここはトップページのポイントのテキストエリアです',
    ));
    $wp_customize->add_control('point_text_c', array(
        'section' => 'index',
        'settings' => 'point_text',
        'label' => 'POINTのテキスト',
        'type' => 'text',
        'priority' => 1,
    ));

    $wp_customize->add_setting('point_more_button_color', array(
        'default' => '#12b49b',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'point_more_button_color_c', array(
        'label' => '+moreボタンカラー変更',
        'section' => 'index',
        'settings' => 'point_more_button_color',
        'priority' => 1,
    )));

    $wp_customize->add_setting('point_button_color', array(
        'default' => '#12b49b',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'point_button_color_c', array(
        'label' => '予約ボタンカラー変更',
        'section' => 'index',
        'settings' => 'point_button_color',
        'priority' => 1,
    )));

    /* INDEX - guide */
    $wp_customize->add_setting('guide_status', array(
        'default' => '状態',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('guide_status_c', array(
        'label' => 'GUIDEの表示非表示のON/OFF',
        'section' => 'index',
        'settings' => 'guide_status',
        'type' => 'checkbox',
        'priority' => 1,
    ));

    /* INDEX - seminar */
    $wp_customize->add_setting('index_seminar_status', array(
        'default' => '状態',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('index_seminar_status_c', array(
        'label' => 'SEMINARの表示非表示のON/OFF',
        'section' => 'index',
        'settings' => 'index_seminar_status',
        'type' => 'checkbox',
        'priority' => 1,
    ));

    $wp_customize->add_setting('index_seminar_text', array(
        'default' => 'ここはトップページのセミナーのテキストエリアです',
    ));
    $wp_customize->add_control('index_seminar_text_c', array(
        'section' => 'index',
        'settings' => 'index_seminar_text',
        'label' => 'SEMINARのテキスト',
        'type' => 'text',
        'priority' => 1,
    ));

    $wp_customize->add_setting('index_seminar_description', array(
        'default' => '',
    ));
    $wp_customize->add_control('index_seminar_description_c', array(
        'section' => 'index',
        'settings' => 'index_seminar_description',
        'label' => 'SEMINARの詳細',
        'type' => 'textarea',
        'priority' => 1,
    ));

    /* INDEX - voice */

    $wp_customize->add_setting('voice_status', array(
        'default' => '状態',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('voice_status_c', array(
        'label' => 'VOICEの表示非表示のON/OFF',
        'section' => 'index',
        'settings' => 'voice_status',
        'type' => 'checkbox',
        'priority' => 1,
    ));

    $wp_customize->add_setting('voice_text', array(
        'default' => 'ここはトップページのセミナー参加者の声のテキストエリアです',
    ));
    $wp_customize->add_control('voice_text_c', array(
        'section' => 'index',
        'settings' => 'voice_text',
        'label' => 'VOICEのテキスト',
        'type' => 'text',
        'priority' => 1,
    ));


    //SEMINAR
    $wp_customize->add_setting('seminar_keyvisual', array(
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'seminar_keyvisual_c', array(
        'label' => __('キービジュアル', ''),
        'section' => 'seminar',
        'settings' => 'seminar_keyvisual',
        'priority' => 1,
    )));

    $wp_customize->add_setting('seminar_description', array(
        'default' => 'ここはフェアセミナーの説明文です',
    ));
    $wp_customize->add_control('seminar_description_text', array(
        'section' => 'seminar',
        'settings' => 'seminar_description',
        'label' => '説明',
        'type' => 'textarea',
        'priority' => 1,
    ));

    //
    $wp_customize->add_setting('seminar_category', array(
        'default' => 'ここはフェアセミナーの説明文です',
    ));
    $wp_customize->add_control('seminar_category_c', array(
        'section' => 'seminar',
        'settings' => 'seminar_category',
        'label' => 'セミナーカテゴリを表示する',
        'type' => 'checkbox',
        'priority' => 2,
    ));

    //SCHOOL
    $wp_customize->add_setting('school_keyvisual', array(
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'school_keyvisual_c', array(
        'label' => __('キービジュアル', ''),
        'section' => 'school',
        'settings' => 'school_keyvisual',
        'priority' => 1,
    )));

    $wp_customize->add_setting('school_button_bg', array(
        'default' => '#fff',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'school_button_bg_c', array(
        'section' => 'school',
        'settings' => 'school_button_bg',
        'label' => 'ボタンのBG色',
        'priority' => 1,
    )));
    
    $wp_customize->add_setting('school_button_color', array(
        'default' => '#284189',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'school_button_color_c', array(
        'section' => 'school',
        'settings' => 'school_button_color',
        'label' => 'ボタンのTEXT色',
        'priority' => 1,
    )));

    /* BANNER register to db & add control */
    $wp_customize->add_setting('banner_upload', array(
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banner_upload_c', array(
        'label' => __('キービジュアル背景', ''),
        'section' => 'banner',
        'settings' => 'banner_upload',
        'priority' => 1,
    )));

    $wp_customize->add_setting('banner_upload_sp', array(
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banner_upload_sp_c', array(
        'label' => 'SPファイルをアップロード',
        'section' => 'banner',
        'settings' => 'banner_upload_sp',
        'priority' => 1,
    )));

    $wp_customize->add_setting('banner_text', array(
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banner_text_c', array(
        'label' => __('キービジュアル正面画像', ''),
        'section' => 'banner',
        'settings' => 'banner_text',
        'priority' => 1,
    )));

    $wp_customize->add_setting('banner_text_status', array(
        'default' => '画像を表示',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('banner_text_status_c', array(
        'label' => '表示非表示のON/OFF',
        'section' => 'banner',
        'settings' => 'banner_text_status',
        'type' => 'checkbox',
        'priority' => 3,
    ));

    // ACCESS
    $wp_customize->add_setting('access_keyvisual', array(
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'access_keyvisual_c', array(
        'label' => __('キービジュアル', ''),
        'section' => 'access',
        'settings' => 'access_keyvisual',
        'priority' => 1,
    )));

    $wp_customize->add_setting('access_menu_status', array(
        'default' => '状態',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('access_menu_status_c', array(
        'label' => '表示非表示のON/OFF',
        'section' => 'access',
        'settings' => 'access_menu_status',
        'type' => 'checkbox',
        'priority' => 1,
    ));

    $wp_customize->add_setting('access_menu_color', array(
        'default' => '#ffffff',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'access_menu_color_c', array(
        'label' => 'ボタンのBGカラー変更',
        'section' => 'access',
        'settings' => 'access_menu_color',
        'priority' => 1,
    )));

    $wp_customize->add_setting('access_menu_border_color', array(
        'default' => '#284189',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'access_menu_border_color_c', array(
        'label' => 'ボタンのBorderカラー変更',
        'section' => 'access',
        'settings' => 'access_menu_border_color',
        'priority' => 1,
    )));

    $wp_customize->add_setting('access_button_color', array(
        'default' => '#ffffff',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'access_button_color_c', array(
        'label' => '各会場のボタンカラー',
        'section' => 'access',
        'settings' => 'access_button_color',
        'priority' => 1,
    )));

    // access - tokyo
    $wp_customize->add_setting('access_tokyo_status', array(
        'default' => '状態',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('access_tokyo_status_c', array(
        'label' => '「東京」の表示非表示のON/OFF',
        'section' => 'access',
        'settings' => 'access_tokyo_status',
        'type' => 'checkbox',
        'priority' => 2,
    ));

    $wp_customize->add_setting('access_tokyo_image', array(
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'access_tokyo_image_c', array(
        'label' => '「東京」画像をアップロード',
        'section' => 'access',
        'settings' => 'access_tokyo_image',
        'priority' => 2,
    )));

    $wp_customize->add_setting('access_tokyo_info', array(
        'default' => '情報を入力',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('access_tokyo_info_c', array(
        'label' => '「東京」情報',
        'section' => 'access',
        'settings' => 'access_tokyo_info',
        'type' => 'textarea',
        'priority' => 2,
    ));

    // access - osaka
    $wp_customize->add_setting('access_osaka_status', array(
        'default' => '状態',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('access_osaka_status_c', array(
        'label' => '「大阪」の表示非表示のON/OFF',
        'section' => 'access',
        'settings' => 'access_osaka_status',
        'type' => 'checkbox',
        'priority' => 3,
    ));

    $wp_customize->add_setting('access_osaka_image', array(
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'access_osaka_image_c', array(
        'label' => '「大阪」画像をアップロード',
        'section' => 'access',
        'settings' => 'access_osaka_image',
        'priority' => 3,
    )));

    $wp_customize->add_setting('access_osaka_info', array(
        'default' => '情報を入力',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('access_osaka_info_c', array(
        'label' => '「大阪」情報',
        'section' => 'access',
        'settings' => 'access_osaka_info',
        'type' => 'textarea',
        'priority' => 3,
    ));

    // access - nagoya
    $wp_customize->add_setting('access_nagoya_status', array(
        'default' => '状態',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('access_nagoya_status_c', array(
        'label' => '「名古屋」の表示非表示のON/OFF',
        'section' => 'access',
        'settings' => 'access_nagoya_status',
        'type' => 'checkbox',
        'priority' => 4,
    ));

    $wp_customize->add_setting('access_nagoya_image', array(
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'access_nagoya_image_c', array(
        'label' => '「名古屋」画像をアップロード',
        'section' => 'access',
        'settings' => 'access_nagoya_image',
        'priority' => 4,
    )));

    $wp_customize->add_setting('access_nagoya_info', array(
        'default' => '情報を入力',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('access_nagoya_info_c', array(
        'label' => '「名古屋」情報',
        'section' => 'access',
        'settings' => 'access_nagoya_info',
        'type' => 'textarea',
        'priority' => 4,
    ));

    // access - fukuoka
    $wp_customize->add_setting('access_fukuoka_status', array(
        'default' => '状態',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('access_fukuoka_status_c', array(
        'label' => '「福岡」の表示非表示のON/OFF',
        'section' => 'access',
        'settings' => 'access_fukuoka_status',
        'type' => 'checkbox',
        'priority' => 5,
    ));

    $wp_customize->add_setting('access_fukuoka_image', array(
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'access_fukuoka_image_c', array(
        'label' => '「福岡」画像をアップロード',
        'section' => 'access',
        'settings' => 'access_fukuoka_image',
        'priority' => 5,
    )));

    $wp_customize->add_setting('access_fukuoka_info', array(
        'default' => '情報を入力',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('access_fukuoka_info_c', array(
        'label' => '「福岡」情報',
        'section' => 'access',
        'settings' => 'access_fukuoka_info',
        'type' => 'textarea',
        'priority' => 5,
    ));

    //faq
    $wp_customize->add_setting('faq_keyvisual', array(
        'capability' => 'edit_theme_options',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'faq_keyvisual_c', array(
        'label' => __('キービジュアル', ''),
        'section' => 'faq',
        'settings' => 'faq_keyvisual',
        'priority' => 1,
    )));
}

add_action('customize_register', 'theme_customize_register');

//css generate
function generate_css() {
    ?>
    <style>
        div.keyvisual-text{
            background: url(<?php echo get_banner_text() ?>) no-repeat center center !important;
        }
        /*sp*/
        @media screen and (max-device-width: 700px){
            div.keyvisual.index{
                background: url("<?php echo get_banner_sp_image_url() ?>") no-repeat scroll center center rgba(0, 0, 0, 0) !important;
            }
        }
        /*pc*/
        @media screen and (min-device-width: 699px){
            div.keyvisual.index{
                background: url("<?php echo get_banner_image_url() ?>") no-repeat scroll center center / auto 100% rgba(0, 0, 0, 0) !important;
            }
            div.keyvisual.access{
                background: url(<?php echo get_access_keyvisual() ?>) no-repeat center center !important;
            }
            div.keyvisual.school{
                background: url(<?php echo get_school_keyvisual() ?>) no-repeat center center !important;
            }
            div.keyvisual.seminar{
                background: url(<?php echo get_seminar_keyvisual() ?>) no-repeat center center !important;
            }
        }
        .access .btn.Navy2{
            background: <?php echo get_access_menu_color() ?> !important;
            color: <?php echo get_access_menu_border_color() ?> !important;
            border: 2px solid <?php echo get_access_menu_border_color() ?> !important;
        }

        .about .btn.Orng2{
            background: <?php echo get_about_button_color() ?> !important;
            color: <?php echo get_about_button_border_color() ?> !important;
            border: 2px solid <?php echo get_about_button_border_color() ?> !important;
        }
        ul.point li > a.btn{
            background: <?php echo get_point_more_button_color() ?> !important;
        }
    </style>
    <?php
}

add_action('wp_head', 'generate_css');

/* INDEX - About */

function get_about_status() {
    return get_theme_mod('about_status');
}

add_action('customize_register', 'get_about_status');

function get_about_text() {
    return get_theme_mod('about_text');
}

add_action('customize_register', 'get_about_text');

//ロゴイメージURLの取得
function get_about_image_url() {
    return esc_url(get_theme_mod('top_kevisual'));
}

add_action('customize_register', 'get_about_image_url');

function get_about_description() {
    return get_theme_mod('about_description');
}

add_action('customize_register', 'get_about_description');

function get_about_button_color() {
    return get_theme_mod('about_button_color');
}

add_action('customize_register', 'get_about_button_color');

function get_about_button_border_color() {
    return get_theme_mod('about_button_border_color');
}

add_action('customize_register', 'get_about_button_border_color');

/* INDEX - Point */

function get_point_status() {
    return get_theme_mod('point_status');
}

add_action('customize_register', 'get_point_status');

function get_point_text() {
    return get_theme_mod('point_text');
}

add_action('customize_register', 'get_point_text');

function get_point_more_button_color() {
    return get_theme_mod('point_more_button_color');
}

add_action('customize_register', 'get_point_more_button_color');

/* INDEX - guide */

function get_guide_status() {
    return get_theme_mod('guide_status');
}

add_action('customize_register', 'get_guide_status');

function get_guide_text() {
    return get_theme_mod('guide_text');
}

add_action('customize_register', 'get_guide_text');

function get_guide_step_1_text() {
    return get_theme_mod('guide_step_1_text');
}

add_action('customize_register', 'get_guide_step_1_text');

function get_guide_step_1_image() {
    return esc_url_raw(get_theme_mod('guide_step_1_image'));
}

add_action('customize_register', 'get_guide_step_1_image');

function get_guide_step_1_description() {
    return get_theme_mod('guide_step_1_description');
}

add_action('customize_register', 'get_guide_step_1_description');

function get_guide_step_1_button() {
    return get_theme_mod('guide_step_1_button');
}

add_action('customize_register', 'get_guide_step_1_button');

function get_guide_step_1_button_sp() {
    return get_theme_mod('guide_step_1_button_sp');
}

add_action('customize_register', 'get_guide_step_1_button_sp');

function get_guide_step_2_text() {
    return get_theme_mod('guide_step_2_text');
}

add_action('customize_register', 'get_guide_step_2_text');

function get_guide_step_2_image() {
    return esc_url_raw(get_theme_mod('guide_step_2_image'));
}

add_action('customize_register', 'get_guide_step_2_image');

function get_guide_step_2_description() {
    return get_theme_mod('guide_step_2_description');
}

add_action('customize_register', 'get_guide_step_2_description');

function get_guide_step_2_button() {
    return get_theme_mod('guide_step_2_button');
}

add_action('customize_register', 'get_guide_step_2_button');

function get_guide_step_2_button_sp() {
    return get_theme_mod('guide_step_2_button_sp');
}

add_action('customize_register', 'get_guide_step_2_button_sp');

/* INDEX - Seminar */

function get_index_seminar_status() {
    return get_theme_mod('index_seminar_status');
}

add_action('customize_register', 'get_index_seminar_status');

function get_index_seminar_text() {
    return get_theme_mod('index_seminar_text');
}

add_action('customize_register', 'get_index_seminar_text');

function get_index_seminar_description() {
    return get_theme_mod('index_seminar_description');
}

add_action('customize_register', 'get_index_seminar_description');


/* INDEX - Voice */

function get_voice_status() {
    return get_theme_mod('voice_status');
}

add_action('customize_register', 'get_voice_status');

function get_voice_text() {
    return get_theme_mod('voice_text');
}

add_action('customize_register', 'get_voice_text');

//////////////////// ------------------------------------
//SEMINAR
function get_seminar_keyvisual() {
    return esc_url_raw(get_theme_mod('seminar_keyvisual'));
}

add_action('customize_register', 'get_seminar_keyvisual');

function the_seminar_description() {
    echo get_theme_mod('seminar_description');
}

add_action('customize_register', 'the_seminar_description');

function is_seminar_category_open() {
    return get_theme_mod('seminar_category');
}

add_action('customize_register', 'is_seminar_category_open');


// BANNER
function get_banner_image_url() {
    return esc_url_raw(get_theme_mod('banner_upload'));
}

add_action('customize_register', 'get_banner_image_url');

function get_banner_sp_image_url() {
    return esc_url_raw(get_theme_mod('banner_upload_sp'));
}

add_action('customize_register', 'get_banner_sp_image_url');

function get_banner_text() {
    return esc_url_raw(get_theme_mod('banner_text'));
}

add_action('customize_register', 'get_banner_text');

function get_banner_text_status() {
    return get_theme_mod('banner_text_status');
}

add_action('customize_register', 'get_banner_text_status');


/* ACCESS */

function get_access_keyvisual() {
    return esc_url_raw(get_theme_mod('access_keyvisual'));
}

add_action('customize_register', 'get_access_keyvisual');

function get_access_menu_status() {
    return get_theme_mod('access_menu_status');
}

add_action('customize_register', 'get_access_menu_status');

function get_access_menu_color() {
    return get_theme_mod('access_menu_color');
}

add_action('customize_register', 'get_access_menu_color');

function get_access_menu_border_color() {
    return get_theme_mod('access_menu_border_color');
}

add_action('customize_register', 'get_access_menu_border_color');

/* ACCESS - TOKYO */

function get_access_tokyo_status() {
    return get_theme_mod('access_tokyo_status');
}

add_action('customize_register', 'get_access_tokyo_status');

function get_access_tokyo_image() {
    return esc_url_raw(get_theme_mod('access_tokyo_image'));
}

add_action('customize_register', 'get_access_tokyo_image');

function get_access_tokyo_info() {
    return get_theme_mod('access_tokyo_info');
}

add_action('customize_register', 'get_access_tokyo_info');

/* ACCESS - OSAKA */

function get_access_osaka_status() {
    return get_theme_mod('access_osaka_status');
}

add_action('customize_register', 'get_access_osaka_status');

function get_access_osaka_image() {
    return esc_url_raw(get_theme_mod('access_osaka_image'));
}

add_action('customize_register', 'get_access_osaka_image');

function get_access_osaka_info() {
    return get_theme_mod('access_osaka_info');
}

add_action('customize_register', 'get_access_osaka_info');

/* ACCESS - NAGOYA */

function get_access_nagoya_status() {
    return get_theme_mod('access_nagoya_status');
}

add_action('customize_register', 'get_access_nagoya_status');

function get_access_nagoya_image() {
    return esc_url_raw(get_theme_mod('access_nagoya_image'));
}

add_action('customize_register', 'get_access_nagoya_image');

function get_access_nagoya_info() {
    return get_theme_mod('access_nagoya_info');
}

add_action('customize_register', 'get_access_nagoya_info');

/* ACCESS - FUKUOKA */

function get_access_fukuoka_status() {
    return get_theme_mod('access_fukuoka_status');
}

add_action('customize_register', 'get_access_fukuoka_status');

function get_access_fukuoka_image() {
    return esc_url_raw(get_theme_mod('access_fukuoka_image'));
}

add_action('customize_register', 'get_access_fukuoka_image');

function get_access_fukuoka_info() {
    return get_theme_mod('access_fukuoka_info');
}

add_action('customize_register', 'get_access_fukuoka_info');

function get_access_button_color() {
    return get_theme_mod('access_button_color');
}

add_action('customize_register', 'get_access_button_color');

function get_point_button_color() {
    return get_theme_mod('point_button_color');
}

add_action('customize_register', 'get_point_button_color');

//FAQ
function get_faq_keyvisual() {
    return esc_url_raw(get_theme_mod('faq_keyvisual'));
}

add_action('customize_register', 'get_faq_keyvisual');

//SCHOOL
function get_school_keyvisual() {
    return esc_url_raw(get_theme_mod('school_keyvisual'));
}

add_action('customize_register', 'get_school_keyvisual');

function get_school_button_bg() {
    return get_theme_mod('school_button_bg');
}

add_action('customize_register', 'get_school_button_bg');

function get_school_button_color() {
    return get_theme_mod('school_button_color');
}

add_action('customize_register', 'get_school_button_color');