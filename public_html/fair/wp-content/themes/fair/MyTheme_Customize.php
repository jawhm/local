<?php

function theme_customize_register($wp_customize) { 
    //section definition
    //ここの記述は一例です。今後、他のカスタマイザー対応機能はこのような形で書いてください
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
    
    //setting definition
    $wp_customize->add_setting('about_text', array( 
        'default'  => 'ここはtトップページのアバウトのテキストエリアです', 
    ));
    $wp_customize->add_control( 'about_text_c', array( 
            'section' => 'index', 
            'settings' => 'about_text', 
            'label' => 'ABOUTのテキスト', 
            'type' => 'textarea', 
            'priority' => 1, 
    ));
    
    $wp_customize->add_setting('top_kevisual');
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'top_kevisual_c', array(
        'label' => 'キービジュアル', //設定ラベル
        'section' => 'index', //セクションID
        'settings' => 'top_kevisual', //セッティングID
        'description' => 'キービジュアルの画像設定',
    ) ) );
    
    //
    $wp_customize->add_setting('seminar_description', array( 
        'default'  => 'ここはフェアセミナーの説明文です', 
    ));
    $wp_customize->add_control( 'seminar_description_text', array( 
            'section' => 'seminar', 
            'settings' => 'seminar_description', 
            'label' => '説明', 
            'type' => 'textarea', 
            'priority' => 1, 
    ));
    
    //
    $wp_customize->add_setting('seminar_category', array( 
        'default'  => 'ここはフェアセミナーの説明文です', 
    ));
    $wp_customize->add_control( 'seminar_category_c', array( 
            'section' => 'seminar', 
            'settings' => 'seminar_category', 
            'label' => 'セミナーカテゴリを表示する', 
            'type' => 'checkbox', 
            'priority' => 2, 
    ));
    
    //school
    $wp_customize->add_setting('button_color', array( 
        'default'  => 'Navy2', 
    ));
    $wp_customize->add_control( 'button_color_c', array( 
        'section' => 'school', 
        'settings' => 'button_color', 
        'label' => 'ボタンの色', 
        'type' => 'radio', 
        'choices' => array(
            'orng' => 'Orange',
            'Navy' => 'Navy',
        ),
        'priority' => 1, 
    ));
}
add_action( 'customize_register', 'theme_customize_register' ); 

//css generate
function generate_css(){
    ?>
<style>
    div.keyvisual{
        background: url(<?php echo get_about_image_url() ?>) no-repeat center center !important;
    }
</style>
    <?php
}
add_action('wp_head', 'generate_css');

function get_about_text(){
    return get_theme_mod('about_text');
}
add_action('customize_register', 'get_about_text');

function the_seminar_description(){
    echo get_theme_mod('seminar_description');
}
add_action('customize_register', 'the_seminar_description');

function is_seminar_category_open(){
    return get_theme_mod('seminar_category');
}
add_action('customize_register', 'is_seminar_category_open');

//ロゴイメージURLの取得
function get_about_image_url(){
    return esc_url( get_theme_mod('top_kevisual') );
}
add_action('customize_register', 'get_about_image_url');

function get_button_color_class(){
    return get_theme_mod('button_color');
}
add_action('customize_register', 'get_button_color_class');