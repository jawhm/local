<?php

	mb_language("Ja");
	mb_internal_encoding("utf8");

	$vmail = 'toiawase@jawhm.or.jp';
	$subject = $_POST['お名前']."様 お問い合わせありがとうございます。";

	$body  = '';
	$body .= '[無料セミナー予約フォーム]';
	$body .= chr(10);
	foreach($_POST as $post_name => $post_value){
		$body .= chr(10);
		$body .= $post_name." : ".$post_value;
	}
	$body .= chr(10);
	$body .= chr(10);
	$body .= '--------------------------------------';
	$body .= chr(10);
	foreach($_SERVER as $post_name => $post_value){
		$body .= chr(10);
		$body .= $post_name." : ".$post_value;
	}
	$body .= '';
	//$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
	$from = $_POST['メール'];
	mb_send_mail($vmail,$subject,$body,"From:".$from);

	echo 'OK';

?>
