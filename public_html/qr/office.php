<?php

	session_start();

	// ＩＰチェック
	$ip_acc = $_SERVER["REMOTE_ADDR"];
	$host = gethostbynamel('shinjuku-toratora.mydns.jp');
	$ip_base = $host[0];

	if ($ip_acc <> $ip_base)	{
		exit;
	}

	$cur_namae = 'パラメータ不正';
	$cur_furigana = '';

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=260, ">
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
	mb_internal_encoding("sjis");

	// パラメータ受信
	$id = @$_SESSION['para_id'];
	$pwd = @$_SESSION['para_p'];
	$memchk = false;	// メンバーチェック
	$ipchk = false;		// ＩＰチェック

	// 登録状況確認
	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$stt = $db->prepare('SELECT id, email, password, namae, furigana, tel, state FROM memlist WHERE id = "'.$id.'" ');
		$stt->execute();
		$idx = 0;
		$cur_id = '';
		$cur_state = '';
		while($row = $stt->fetch(PDO::FETCH_ASSOC)){
			$idx++;
			$cur_id = $row['id'];
			$cur_email = $row['email'];
			$cur_password = $row['password'];
			$cur_namae = mb_convert_encoding($row['namae'], 'UTF-8', 'UTF-8');
			$cur_furigana = mb_convert_encoding($row['furigana'], 'UTF-8', 'UTF-8');
			$cur_tel = mb_convert_encoding($row['tel'], 'UTF-8', 'UTF-8');
			$cur_state = $row['state'];
		}
		$db = NULL;
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	switch($cur_state)	{
		case '0':
			$cur_state_name = '×仮登録';
			break;
		case '1':
			$cur_state_name = '×メアド承認';
			break;
		case '5':
			$cur_state_name = '○通常';
			break;
		case '9':
			$cur_state_name = '×期限切れ';
			break;
		default:
			$cur_state_name = '';
			break;
	}

	// メンバーチェック
	if ($cur_id <> '')	{
// 業務専用ページなのでＰＷＤチェックなし！！
//		if ($pwd == mb_substr($cur_password, 0, 6))	{
			$memchk = true;
//		}
	}

?>
<body bgcolor="#FFFFFF" text="#333333"link="#0000CD" vlink="#5C82FF" alink="#FFFFFF" style="width:260px; font-size:10pt;">

<div align="left" >

<p align="center"><img src="img/top.jpg" width="240" height="77" align="middle"></p>
<Marquee bgcolor="#999999" width="240"><Font size="2" color="#FFFFFF">東京オフィスページ</Font></Marquee>

<hr color="#000033">

<p align="left">

<?php

	print '会員番号：'.$id;
	print '　　状態：'.$cur_state_name;
	print '<br/>';
	print ''.$cur_namae.' ('.$cur_furigana.')　様';
	print '<br/>';




	if ($memchk)	{

		print '<hr/>';

		$youbi = Array("日","月","火","水","木","金","土");
		$msg = '';

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

		<p>パラメタ―情報が確認できません。</p>

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