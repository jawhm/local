<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Access-Control-Allow-Origin:*');//全ドメイン許可する場合 
error_reporting(E_ALL & ~E_NOTICE);
include '../seminar_module.php';
$config = json_decode($_POST['config_json'], true);
/*
$config = array(
    'view_mode' => 'calendar',
    'list' => array(
        'past_view' => '',
        'count_field_active' => '',
        'place_default' => 'event',
        //'detail_open' => 'on'
    )
);
*/
$sm = new SeminarModule($config);

//$config['calendar']['title'] = "イギリス";
//echo "TITLE = ".$config['calendar']['title'];

echo $sm->get_add_js();
echo $sm->get_add_css();
echo $sm->get_add_style();

echo '<link rel="stylesheet" href="http://'.$_SERVER['SERVER_NAME'].'/css/seminar-contents.css" type="text/css">';
echo '<link rel="stylesheet" href="http://'.$_SERVER['SERVER_NAME'].'/css/contents.css" type="text/css">';
echo '<link rel="stylesheet" href="http://'.$_SERVER['SERVER_NAME'].'/css/seminar_widget.css" type="text/css">';

$sm->show();

