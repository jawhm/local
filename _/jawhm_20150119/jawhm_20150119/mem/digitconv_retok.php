<HTML>
<HEAD>
<title>コンビニ決済登録完了</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</HEAD>
<?

	mb_language("Ja");
	mb_internal_encoding("utf8");

	$sid = @$_GET['SID'];
	$fuka = @$_GET['FUKA'];

	$mailadd = 'meminfo@jawhm.or.jp';

	// 社内通知
	$subject = "【メンバー登録：コンビニ決済予約完了】  ".$fuka;
	$body  = '';
	$body .= 'デジタルチェックにてコンビニ決済登録が完了しました。';
	$body .= chr(10);
	$body .= chr(10);
	$body .= '会員番号：'.$fuka;
	$body .= chr(10);
	$body .= 'SID：'.$sid;
	$body .= chr(10);
	$body .= '';
	$body .= '-------------------------------------------------';
	$body .= chr(10);
	foreach($_SERVER as $post_name => $post_value){
		$body .= chr(10);
		$body .= $post_name." : ".$post_value;
	}
	$body .= '';

	$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
	mb_send_mail($mailadd,$subject,$body,"From:".$from);

?>
<BODY TEXT="#000000" BGCOLOR="#FFFFFF" LINK="#0000EE" VLINK="#551A8B" ALINK="#FF0000">
<BLOCKQUOTE>
<center>
<HR WIDTH="100%" SIZE="3">
<BR>
元のウィンドウに戻って手続きを行ってください。<BR>
<BR><HR WIDTH="100%" SIZE="3"><BR><BR>
このページは閉じて構いません。<BR><BR>
<input type="button" value="　閉じる　" onclick="window.close();">
</CENTER>
</BLOCKQUOTE>
</BODY>
</HTML>
