<?php
ini_set( 'display_errors', 1 ); 

session_start();
$id = session_id();

$data = 'http://www.jawhm.or.jp/pic/pics/'.$id.'.png';

require("./qrcode_img.php");
Header("Content-type: image/png");
$z=new Qrcode_image;
$z->qrcode_image_out($data,"png");

?>