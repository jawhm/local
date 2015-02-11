<?php

//ini_set( 'display_errors', 1 ); 

	$code = @$_GET['code'];
	if ($code == '')	{
		$code = '123456789012';
	}

	header('Content-Type: image/png');

	$in_img = imagecreatefrompng('http://www.jawhm.or.jp/barcode/barcode.php?code='.$code.'&scale=2&mode=png&encoding=EAN'); 
	$out_img = imagecreatetruecolor( 220, 30 );

	imagecopy($out_img, $in_img, 0, 0, 7, 10, 220, 30);

	imagepng($out_img);

	imagedestroy($in_img);
	imagedestroy($out_img);

?>