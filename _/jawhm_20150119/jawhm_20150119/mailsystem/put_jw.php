<? include_once 'fnc_header.php'; ?>
<h1 style="color:white;background-color:#525D76;font-size:22px;">協会（メンバー）の一括送信</h1>
<?php

//ini_set( "display_errors", "On");

mb_language("Ja");
mb_internal_encoding("utf8");

if($_POST['submit'] != NULL){

	if ($_POST['subject'] == '')	{
		die('件名が入力されていません。');
	}
	if ($_POST['body'] == '')	{
		die('本文が入力されていません。');
	}

	require_once 'myConfig.php';

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$rs = $db->query('SELECT vmail as email, vname1 as namae , vcheck FROM maillist WHERE vsend = "1" AND vtype = "jw"');
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;

			$msg  = '';
			$msg .= chr(10).chr(13);
			$msg .= '---';
			$msg .= chr(10).chr(13);
			$msg .= '◆メール配信の登録内容変更、中止はこちらからお願いします。'.chr(10);
			$msg .= 'http://www.jawhm.or.jp/mail/?u='.$row['vcheck'].'&m='.md5($row['email']);
			$msg .= chr(10).chr(13);
			$msg .= '---';
			$msg .= chr(10).chr(13);
			$msg .= '';

			$headers = array(
                //'From' => mb_encode_mimeheader('日本ワーキングホリデー協会','ISO-2022-JP').'<info@jawhm.or.jp>',
                'From' => mb_encode_mimeheader('日本ワーキングホリデー協会','ISO-2022-JP').'<j-doi@plate.co.jp>',
				'To' => mb_encode_mimeheader($row['namae'],'ISO-2022-JP').'<'.$row['email'].'>',
				'Subject' => mb_encode_mimeheader($_POST['subject'], 'ISO-2022-JP'));
			$q = new Mail_Queue($dbo, $mo);
			$mime = new Mail_mime();
			$mime->setTXTBody(mb_convert_encoding($row['namae'].'さん'.chr(10).chr(13).$_POST['body'].$msg.$_POST['sig'], 'JIS'));
			$body = $mime->get(array('text_charset'=>'ISO-2022-JP'));
			$headers = $mime->headers($headers);
            //$q->put('info@jawhm.or.jp', $row['email'], $headers, $body);
            $q->put('j-doi@plate.co.jp', $row['email'], $headers, $body);
		}
		print ($cnt.'件のメールを送信予約しました。<br/>&nbsp;<br/>');
		print ('【注意】このページは、絶対にリロードしないように！！');
	} catch (PDOException $e) {
		die($e->getMessage());
	}
}else{
?>
	<form method="POST" action="put_jw.php" onsubmit="return(confirm('本当に送信しますか？'));">
		件名：<br />
		<input type="text" name="subject" size="50" maxlength="255" /><br />
		本文：<br />
		（自動的に、先頭にお名前が入ります。）<br/>
		<textarea name="body" cols="60" rows="20"></textarea><br />
		署名：<br/>
<textarea name="sig" cols="60" rows="10">

----------
  Japan Association for Working Holiday Makers.
  一般社団法人　日本ワーキング・ホリデー協会
  mail:info@jawhm.or.jp  tel:03-6304-5858
----------
</textarea><br />
		<input type="submit" name="submit" value="　送信　" />
	</form>
<?
}
?>

<? include_once 'fnc_footer.php'; ?>
