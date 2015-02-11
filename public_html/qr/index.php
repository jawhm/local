<?php

	session_start();

	// ＩＰチェック
	$ip_acc = $_SERVER["REMOTE_ADDR"];
	$host = gethostbynamel('shinjuku-toratora.mydns.jp');
	$ip_base = $host[0];

	if ($ip_acc == $ip_base)	{
		// パラメータ設定
		$_SESSION['para_id']	= @$_GET['id'];		// 会員ＩＤ
		$_SESSION['para_p']	= @$_GET['p'];		// パスワード
		$_SESSION['para_s']	= @$_GET['s'];		// セミナー参加者ＩＤ
		header("Location: http://www.jawhm.or.jp/qr/office.php");
		exit;
	}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=280, ">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-control" CONTENT="no-store">
<META HTTP-EQUIV="Cache-control" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Mon, 1 Jan 1990 01:01:01 GMT">
<meta name="viewport" content="width=device-width" />
<title>日本ワーキング・ホリデー協会</title>
</head>

<?php

ini_set( 'display_errors', 1 ); 

	mb_language("Ja");
	mb_internal_encoding("utf8");

	// パラメータ受信
	$id = @$_GET['id'];
	$pwd = @$_GET['p'];
	$memchk = false;	// メンバーチェック
	$ipchk = false;		// ＩＰチェック

	// 登録状況確認
	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$stt = $db->prepare('SELECT id, email, password, namae, tel FROM memlist WHERE id = "'.$id.'" and state = "5" ');
		$stt->execute();
		$idx = 0;
		$cur_id = '';
		while($row = $stt->fetch(PDO::FETCH_ASSOC)){
			$idx++;
			$cur_id = $row['id'];
			$cur_email = $row['email'];
			$cur_password = $row['password'];
			$cur_namae = mb_convert_encoding($row['namae'], 'UTF-8', 'UTF-8');
			$cur_tel = mb_convert_encoding($row['tel'], 'UTF-8', 'UTF-8');
		}
		$db = NULL;
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	// メンバーチェック
	if ($cur_id <> '')	{
		if ($pwd == mb_substr($cur_password, 0, 6))	{
			$memchk = true;
		}
	}

?>
<body bgcolor="#FFFFFF" text="#333333"link="#0000CD" vlink="#5C82FF" alink="#FFFFFF" style="width:260px; font-size:10pt;">

<div align="left" >

<p align="center"><img src="img/top.jpg" width="240" height="77" align="middle"></p>
<Marquee bgcolor="#999999" width="240"><Font size="2" color="#FFFFFF">メンバー専用ページ</Font></Marquee>

<hr color="#000033">

<p align="left">

<?php

	if ($memchk)	{
		$youbi = Array("日","月","火","水","木","金","土");
		$msg = '';

		print '<p>'.$cur_namae.' 様</p>';

		// セミナー予約状況チェック
		$cur_tel = mb_ereg_replace('-', '', $cur_tel);
		$ser_tel = '%';
		for ($idx=0; $idx < mb_strlen($cur_tel); $idx++)	{
			$ser_tel .= mb_substr($cur_tel, $idx, 1).'%';
		}
		$sql  = "";
		$sql .= "SELECT";
		$sql .= " entrylist.id, seminarid, namae, email, tel, ninzu, stat, wait ";
		$sql .= " ,place, hiduke, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(hiduke,'%w') as yobi, date_format(starttime,'%k:%i') as sttime, k_title1";
		$sql .= " FROM entrylist , event_list ";
		$sql .= " WHERE";
		$sql .= " entrylist.seminarid = event_list.id";
		$sql .= " and tel like '".$ser_tel."'";
		$sql .= " and ( stat = '1' or stat = '0' )";
		$sql .= " order by hiduke ";

		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$stt = $db->prepare($sql);
			$stt->execute();
			$idx = 0;
			$cur_id = '';
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_seminarid = $row['seminarid'];
				$cur_email = $row['email'];
				$cur_stat = $row['stat'];
				$cur_wait = $row['wait'];
				$cur_y = $row['y'];
				$cur_m = $row['m'];
				$cur_d = $row['d'];
				$cur_yobi = $row['yobi'];
				$cur_sttime = $row['sttime'];
				$cur_title = strip_tags(mb_convert_encoding($row['k_title1'], 'UTF-8', 'UTF-8'));

				$msg .= '<tr style="background-color:#DEE7FF;">';
				$msg .= '<td><b>'.$cur_y.'年'.$cur_m.'月'.$cur_d.'日('.$youbi[$cur_yobi].')　';
				$msg .= ''.$cur_sttime.'開始</b></td></tr>';
				$msg .= '<tr><td colspan="1">'.$cur_title.'</td></tr>';

				$msg .= '<td style="text-align:right;">';
				if ($cur_wait == '1')	{
					$msg .= 'キャンセル待ち';
					$btn  = 'キャンセル';
				}else{
					if ($cur_stat == '0')	{
						$msg .= '仮予約';
						$btn  = '予約を確定する';
					}else{
						$msg .= '';
						$btn  = 'キャンセル';
					}
				}
				$msg .= '　<a href="http://www.jawhm.or.jp/yoyaku/disp/'.$cur_id.'/'.md5($cur_email).'">';
				$msg .= $btn;
				$msg .= '</a>';
				$msg .= '</td>';
				$msg .= '</tr>';
				$msg .= '<tr><td></td></tr>';
				$msg .= '<tr><td></td></tr>';
				$msg .= '<tr><td></td></tr>';

			}
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		if ($idx == 0)	{
			$msg = '<p style="maring:10px 0 0 0;">ご予約頂いているセミナーはありません。</p>';
		}else{
			$msg = '■ご予約中のセミナー<br/><table style="font-size:10pt;">'.$msg.'</table>';
		}

		print $msg;

	}else{
?>
	恐れ入りますが、会員情報が確認できません。
<?php
	}
?>

<br>
</p>

<table width="240" cellspacing="0" cellpadding="0" align="center">
<tr>
<td bgcolor="#DEE7FF">
<font size="2">
<br />
<a href="http://i.jawhm.or.jp/info/privacy.html">■個人情報の取り扱いについて</a>
<br />
<a href="http://i.jawhm.or.jp/info/access.html">■アクセス</a>
<br />

<a href="http://i.jawhm.or.jp/info/about.html">■一般社団法人日本ワーキング・ホリデー協会について</a>
<br />
<br />
</font>
</td>
</tr>
</table>

<br><br>

</Font>

<hr color="#000033">
<p align="center"><img src="img/footer.jpg" width="240" height="25" align="middle"></p>
</div>
</body>
</html>