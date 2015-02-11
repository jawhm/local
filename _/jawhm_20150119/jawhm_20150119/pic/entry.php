<?php

function getRandomString($nLengthRequired = 8){
    $sCharList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    mt_srand();
    $sRes = "";
    for($i = 0; $i < $nLengthRequired; $i++)
        $sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
    return $sRes;
}

	ini_set( "display_errors", "On");
	session_start();
	$id = session_id();

	mb_language("Ja");
	mb_internal_encoding("utf8");

	$mail = @$_POST['e'];
	$vmail1 = 'meminfo@jawhm.or.jp';

	// 社内通知
	$subject = "すまいるしょっとエントリー";
	$body  = '';
	$body .= '[すまいるしょっとエントリー]';
	$body .= chr(10);
	foreach($_POST as $post_name => $post_value){
		$body .= chr(10);
		$body .= $post_name." : ".$post_value;
	}
	$body .= chr(10);
	$body .= '--------------------------------------';
	$body .= chr(10);
	$body .= 'Mail : '.$mail;
	$body .= chr(10);
	$body .= 'URL : http://www.jawhm.or.jp/pic/pics/'.$id.'.png';
	$body .= chr(10);
	$body .= '--------------------------------------';
	$body .= chr(10);
	foreach($_SERVER as $post_name => $post_value){
		$body .= chr(10);
		$body .= $post_name." : ".$post_value;
	}
	$body .= '';
	$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
	mb_send_mail($vmail1,$subject,$body,"From:".$from);

	// 投稿者通知
	$subject = "すまいるしょっとへのエントリーありがとうございます";
	$body  = '';
	$body .= '[すまいるしょっとエントリー]';
	$body .= chr(10);
	$body .= chr(10);
	$body .= '日本ワーキング・ホリデー協会です。';
	$body .= chr(10);
	$body .= chr(10);
	$body .= 'この度は、すまいるしょっとへのエントリーありがとうございます。';
	$body .= chr(10);
	$body .= chr(10);
	$body .= 'エントリーされた写真は以下のＵＲＬで確認頂けます。';
	$body .= chr(10);
	$body .= chr(10);
	$body .= 'URL : http://www.jawhm.or.jp/pic/pics/'.$id.'.png';
	$body .= chr(10);
	$body .= chr(10);
	$body .= chr(10);
	$body .= '当選者の発表を楽しみにお待ちください。';
	$body .= chr(10);
	$body .= '';
	$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
	mb_send_mail($mail,$subject,$body,"From:".$from);


	$msg .= 'OK';
	echo $msg;

?>
