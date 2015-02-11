<? include_once 'fnc_header.php'; ?>
<h1 style="color:white;background-color:orangered;font-size:22px;">トラトラ（大阪）の一括送信</h1>
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
		$rs = $db->query('SELECT vmail as email, vname1 as namae , vcheck FROM maillist WHERE vsend = "1" AND vtype = "or"');
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;

			$msg  = '';
			$msg .= chr(10).chr(13);
			$msg .= '---';
			$msg .= chr(10).chr(13);
			$msg .= '◆メール会員の登録内容変更、配信中止はこちらからお願いします。'.chr(10);
			$msg .= 'http://www.tora-tora.net/mail/?u='.$row['vcheck'].'&m='.md5($row['email']);
			$msg .= chr(10).chr(13);
			$msg .= '---';
			$msg .= chr(10).chr(13);
			$msg .= '';

			$headers = array(
				'From' => mb_encode_mimeheader('トラトラ大阪','ISO-2022-JP').'<osaka@tora-tora.net>',
				'To' => mb_encode_mimeheader($row['namae'],'ISO-2022-JP').'<'.$row['email'].'>',
				'Subject' => mb_encode_mimeheader($_POST['subject'], 'ISO-2022-JP'));
			$q = new Mail_Queue($dbo, $mo);
			$mime = new Mail_mime();
			$mime->setTXTBody(mb_convert_encoding($row['namae'].'さん'.chr(10).chr(13).$_POST['body'].$msg.$_POST['sig'], 'JIS'));
			$body = $mime->get(array('text_charset'=>'ISO-2022-JP'));
			$headers = $mime->headers($headers);
			$q->put('osaka@tora-tora.net', $row['email'], $headers, $body);
		}
		print ($cnt.'件のメールを送信予約しました。<br/>&nbsp;<br/>');
		print ('【注意】このページは、絶対にリロードしないように！！');
	} catch (PDOException $e) {
		die($e->getMessage());
	}
}else{
?>
	<form method="POST" action="put_or.php" onsubmit="return(confirm('本当に送信しますか？'));">
		件名：<br />
		<input type="text" name="subject" size="50" maxlength="255" /><br />
		本文：<br />
		（自動的に、先頭にお名前が入ります。）<br/>
		<textarea name="body" cols="60" rows="20"></textarea><br />
		署名：<br/>
<textarea name="sig" cols="60" rows="10">
---------
株式会社TRAVEL&TRAVEL【トラトラ大阪】
 Mail：osaka@tora-tora.net
 URL:www.tora-tora.net/　
---------
</textarea><br />
		<input type="submit" name="submit" value="　送信　" />
	</form>
<?
}
?>

<? include_once 'fnc_footer.php'; ?>
