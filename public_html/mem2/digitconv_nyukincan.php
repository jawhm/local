<?

	ini_set( "display_errors", "On");

	mb_language("Ja");
	mb_internal_encoding("utf8");

	// セキュリティー情報取得
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$ip = getenv("REMOTE_ADDR");
	$host = getenv("REMOTE_HOST");
	if ($host == null || $host == $ip)
	$host = gethostbyaddr($ip);

	// パラメータ取得
	$seq = @$_GET['SEQ'];
	if ($seq == '')		{ $seq = @$_POST['SEQ']; }
	$date = @$_GET['DATE'];
	if ($date == '')	{ $date = @$_POST['DATE']; }
	$sid = @$_GET['SID'];
	if ($sid == '')		{ $sid = @$_POST['SID']; }
	$kingaku = @$_GET['KINGAKU'];
	if ($kingaku == '')	{ $kingaku = @$_POST['KINGAKU']; }
	$fuka = @$_GET['FUKA'];
	if ($fuka == '')	{ $fuka = @$_POST['FUKA']; }

	// 社内通知
	$mailadd = 'meminfo@jawhm.or.jp';
	$subject = "★重要★【コンビニ決済取り消し通知】 会員番号 : ".$fuka;
	$body  = '';
	$body .= 'コンビニ決済での取り消しを受信しました。';
	$body .= chr(10);
	$body .= chr(10);
	$body .= '通知番号：'.$seq;
	$body .= chr(10);
	$body .= '入金日：'.$date;
	$body .= chr(10);
	$body .= 'SID：'.$sid;
	$body .= chr(10);
	$body .= '金額：'.$kingaku;
	$body .= chr(10);
	$body .= '付加情報：'.$fuka;
	$body .= chr(10);
	$body .= chr(10);
	$body .= '---------------------------------------------';
	$body .= chr(10);
	$body .= 'IP：'.$ip;
	$body .= chr(10);
	$body .= 'Host：'.$host;
	$body .= chr(10);
	$body .= 'Agent：'.$agent;
	$body .= chr(10);
	$body .= '';
	$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
	mb_send_mail($mailadd,$subject,$body,"From:".$from);


	// 社内通知
	$mailadd = 'toiawase@jawhm.or.jp';
	$subject = "★重要★【コンビニ決済取り消し通知】 会員番号 : ".$fuka;
	$body  = '';
	$body .= 'コンビニ決済での取り消しを受信しました。';
	$body .= chr(10);
	$body .= chr(10);
	$body .= '通知番号：'.$seq;
	$body .= chr(10);
	$body .= '入金日：'.$date;
	$body .= chr(10);
	$body .= 'SID：'.$sid;
	$body .= chr(10);
	$body .= '金額：'.$kingaku;
	$body .= chr(10);
	$body .= '付加情報：'.$fuka;
	$body .= chr(10);
	$body .= chr(10);
	$body .= '---------------------------------------------';
	$body .= chr(10);
	$body .= 'IP：'.$ip;
	$body .= chr(10);
	$body .= 'Host：'.$host;
	$body .= chr(10);
	$body .= 'Agent：'.$agent;
	$body .= chr(10);
	$body .= '';
	$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
	mb_send_mail($mailadd,$subject,$body,"From:".$from);


	header("Content-Type: text/plain; charset=Shift_JIS");
	print "0\r\n";

?>
