<?php

include_once(dirname(__FILE__) . '/MyTheme_Customize.php');
include_once(dirname(__FILE__) . '/cpt_acf_definitions.php');

function jquery() {
    wp_enqueue_script('jquery');
}

add_action('wp_enqueue_scripts', 'jquery');
