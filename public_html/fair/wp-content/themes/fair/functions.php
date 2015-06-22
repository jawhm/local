<?php

include_once(dirname(__FILE__) . '/MyTheme_Customize.php');
include_once(dirname(__FILE__) . '/cpt_acf_definitions.php');

function jquery() {
    wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'jquery');

/* Khang add javascript */
function scripts() {

    global $wp_query;
    if (is_page('school')) {
        wp_register_script('school-js', get_template_directory_uri() . '/js/school.js');
        wp_enqueue_script('school-js');
    }
    
    if (is_page('school_list')){
        wp_register_script('school-list-js', get_template_directory_uri() . '/js/school-list.js');
        wp_enqueue_script('school-list-js');
    }

}

add_action('wp_print_scripts', 'scripts');
