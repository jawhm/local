<?php

	mb_language("Ja");
	mb_internal_encoding("utf8");

	$subject = $namae."テストメール";
	$body  = '';
	$body .= '[無料セミナー予約フォーム]';
	$body .= chr(10);
	$body .= '--------------------------------------';
	$body .= chr(10);
	foreach($_SERVER as $post_name => $post_value){
		$body .= chr(10);
		$body .= $post_name." : ".$post_value;
	}
	$body .= '';
	$vmail2 = 'masaki@tora-tora.net,oyatuha300@docomo.ne.jp,masaki@sumimasa.com,ienitukumadega-ensokudesu@docomo.ne.jp';

//$parameter="-f info@jawhm.or.jp";

	$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
//	if (mb_send_mail($vmail2,$subject,$body,"From:".$from,$parameter))	{
	if (mb_send_mail($vmail2,$subject,$body,"From:".$from))	{
		print 'OK';
	}else{
		print 'NG';
	}

?>