<HTML>
<HEAD>
<title>クレジットカード決済登録完了(V2)</title>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
</HEAD>
<?

	mb_language("Ja");
	mb_internal_encoding("utf8");

	$sid = @$_GET['SID'];
	$fuka = @$_GET['FUKA'];

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');

		// とりあえず仮更新
		$stt = $db->prepare('UPDATE memlist SET state = "5", upddate = "'.date('Y/m/d H:i:s').'" WHERE id = "'.$fuka.'" ');
		$stt->execute();

		$db = NULL;
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	$mailadd = 'meminfo@jawhm.or.jp';

	// 社内通知
	$subject = "【メンバー登録：クレジットカード決済完了（速報】  ".$fuka;
	$body  = '';
	$body .= 'デジタルチェックにてクレジットカード決済登録が完了しました。';
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
クレジットカードでのお支払ありがとうございます。<br/>
元のウィンドウに戻って<b>「次へ」</b>をクリックしてください。<BR>
<BR><HR WIDTH="100%" SIZE="3"><BR><BR>
このページは閉じて構いません。<BR><BR>
<input type="button" value="　閉じる　" onclick="window.close();">
</CENTER>
</BLOCKQUOTE>
</BODY>
</HTML>
