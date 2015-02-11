<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
<?php

$dat_date  = date('Y/m/d');
$dat_time  = date('H:i:s');
$dat_name .= $_SERVER['SCRIPT_NAME'];
$dat_ref .= $_SERVER['HTTP_REFERER'];
$dat_lang .= $_SERVER['HTTP_ACCEPT_LANGUAGE'];
$dat_agent .= $_SERVER['HTTP_USER_AGENT'];

if (@$_GET['u'] == '')	{
	list(,$_GET['u'], $_GET['w']) = explode('/', $_SERVER['PATH_INFO']);
}

$uid = @$_GET['u'];
$wid = @$_GET['w'];
$url = 'http://www.jawhm.or.jp';
$alt = '日本ワーキング・ホリデー協会';

try {
	$ini = parse_ini_file('../../bin/pdo_jawhm_bar.ini', FALSE);
	$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->query('SET CHARACTER SET utf8');
	$sql = 'INSERT INTO accesslog(vdate, vtime, vname, vref, vlang, vagent, vuid, vwid) VALUES(:vdate, :vtime, :vname, :vref, :vlang, :vagent, :vuid, :vwid)';
	$stt2 = $db->prepare($sql);
	$stt2->bindValue(':vdate', $dat_date);
	$stt2->bindValue(':vtime', $dat_time);
	$stt2->bindValue(':vname', $dat_name);
	$stt2->bindValue(':vref', $dat_ref);
	$stt2->bindValue(':vlang', $dat_lang);
	$stt2->bindValue(':vagent', $dat_agent);
	$stt2->bindValue(':vuid', $uid);
	$stt2->bindValue(':vwid', $wid);
	$stt2->execute();
	$db = NULL;
} catch (PDOException $e) {
	// die($e->getMessage());
}

if ($uid == '')	{
	print('<a href="'.$url.'">'.$alt.'</a><br/>');
	print("Specification method is incorrect.<br/>Please contact to info@jawhm.or.jp<br/>");
}else{
	if ($wid == '2')	{
		// barner 120 x 60
		print('<div style="background-color:white;text-align:center;">');
		print('<a href="'.$url.'" target="_blank">
			<img border="0"
				src="'.$url.'/e/jawhm120.jpg"
				alt="'.$alt.'"
				width="120"
				height="60" /></a><br/>');
		print('<a href="'.$url.'" target="_blank">We 応援 ワーホリ</a><br/>');
		print ('</div>');
	}else{
		// barner 234 x 60
		print('<div style="background-color:white;text-align:center;">');
		print('<a href="'.$url.'" target="_blank">
			<img border="0"
				src="'.$url.'/e/jawhm234.jpg"
				alt="'.$alt.'"
				width="234"
				height="60" /></a><br/>');
		print('<a href="'.$url.'" target="_blank">私達はワーホリを応援します</a><br/>');
		print ('</div>');
	}
}

?>
</body>
</html>

