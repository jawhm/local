<?php

header('Content-Type: text/html; charset=utf-8');

require_once '../lib/TemplateFile.php';
require_once '../lib/Template.php';

$template = "Dear {{customer}}<br/><br/>I want you to know you have an exceptional employee, blablabla...<br/><br/>{{my_name}} <br/><br/>-----{{company}}-----";
$data = array(
    'customer' => 'Ms. Brown',
    'my_name' => 'The Flash',
    'not_in_template' => 'xxx xxx xxx',
    );

$string = new TemplateFile($template, $data);

$model = new Template($template, $data);
$out_temp = $model->render();


echo '<pre>';
var_dump($string);
echo '<hr>';
echo $string;
echo '<hr>';
echo $model;
echo '<br>';
echo $out_temp;

