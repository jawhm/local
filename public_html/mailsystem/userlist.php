
<? 

mb_language("Ja");
mb_internal_encoding("utf8");


include_once 'fnc_header.php';

?>


<style>
.list:link	{ color : white }
.list:visited	{ color : white }
.list:hover	{ color : white }
.list:active	{ color : white }
</style>


<h1>メーリングリスト管理</h1>

<?php


ini_set( "display_errors", "On");

function getRandomString($nLengthRequired = 8){
    $sCharList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";
    mt_srand();
    $sRes = "";
    for($i = 0; $i < $nLengthRequired; $i++)
        $sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
    return $sRes;
}


	$mode = @$_POST['mode'];
	if ($mode == '') { $mode = @$_GET['mode']; }
	$vtype = @$_POST['vtype'];
	if ($vtype == '') { $vtype = @$_GET['vtype']; }
	if ($vtype == '') { $vtype = 'tr'; }
	$selorder = @$_POST['selorder'];
	if ($selorder == '') { $selorder = @$_GET['selorder']; }
	if ($selorder == '') { $selorder = 'vmail'; }

	$arr_check['tr'] 	= '';
	$arr_check['or'] 	= '';
	$arr_check['kt_foregin'] 	= '';
	$arr_check['kt_ippan'] 	= '';
	$arr_check['kt'] = '';

	$arr_check[$vtype]	= 'checked';

?>

	<form action="./userlist.php" method="post">
		<input type="radio" name="vtype" value="tr" <? print $arr_check['tr']; ?> >トラトラ（東京）
		<input type="radio" name="vtype" value="or" <? print $arr_check['or']; ?> >トラトラ（大阪）
		<br/>
		<input type="radio" name="vtype" disabled value="kt_foregin" <? print $arr_check['kt_foregin']; ?> >協会（外国人）
		<input type="radio" name="vtype" value="kt_ippan" <? print $arr_check['kt_ippan']; ?> >協会（日本人）
		<input type="radio" name="vtype" value="kt" <? print $arr_check['kt']; ?> >協会（求職：外国人用）
		<input type="hidden" name="mode" value="ser">
		<input type="submit" value="　検索　">
	</form>

	<hr>

<?
	if ($mode == 'resend')	{
		$vtype = @$_POST['vtype'];
		$vmail = @$_POST['vmail'];

		// 再送
		require_once 'myConfig.php';

		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$rs = $db->query('SELECT vmail as email, vname1 as namae , vcheck FROM maillist WHERE vmail = "'.$vmail.'" AND vtype = "'.$vtype.'"');
			$cnt = 0;
			while($row = $rs->fetch(PDO::FETCH_ASSOC)){
				$cnt++;

				$msg  = 'このメールは、日本ワーキング・ホリデー協会のメール会員様向けの確認メールです。';
				$msg .= chr(10).chr(13);
				$msg .= '◆メール会員の設定はこちらからお願いいたします。'.chr(10);
				$msg .= 'http://www.jawhm.or.jp/mail/?u='.$row['vcheck'].'&m='.md5($row['email']);
				$msg .= '';

				$headers = array(
                    //'From' => mb_encode_mimeheader('日本ワーキングホリデー協会','ISO-2022-JP').'<info@jawhm.or.jp>',
                    'From' => mb_encode_mimeheader('日本ワーキングホリデー協会','ISO-2022-JP').'<j-doi@plate.co.jp>',
					'To' => $row['email'],
					'Subject' => mb_encode_mimeheader('確認メール', 'ISO-2022-JP'));
				$q = new Mail_Queue($dbo, $mo);
				$mime = new Mail_mime();
				$mime->setTXTBody(mb_convert_encoding($msg, 'JIS'));
				$body = $mime->get(array('text_charset'=>'ISO-2022-JP'));
				$headers = $mime->headers($headers);
                //$q->put('info@jawhm.or.jp', $row['email'], $headers, $body);
                $q->put('j-doi@plate.co.jp', $row['email'], $headers, $body);
			}
			print ($vmail.'('.$cnt.')に送信しました。<br/>【注意】このページは、絶対にリロードしないように！！');

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	if ($mode == 'chksend')	{
		$vtype = @$_POST['vtype'];
		$vmail = @$_POST['vmail'];

		// 再送
		require_once 'myConfig.php';

		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$rs = $db->query('SELECT vmail as email, vname1 as namae , vcheck FROM maillist WHERE vmail = "'.$vmail.'" AND vtype = "'.$vtype.'"');
			$cnt = 0;
			while($row = $rs->fetch(PDO::FETCH_ASSOC)){
				$cnt++;

				$msg  = 'このメールは、日本ワーキング・ホリデー協会のメール会員様向けの確認メールです。';
				$msg .= chr(10).chr(13);
				$msg .= '◆メール会員の設定はこちらからお願いいたします。'.chr(10);
				$msg .= 'http://www.jawhm.or.jp/mail/?u='.$row['vcheck'].'&m='.md5($row['email']);
				$msg .= '';

				$headers = array(
                    //'From' => mb_encode_mimeheader('日本ワーキングホリデー協会','ISO-2022-JP').'<info@jawhm.or.jp>',
                    'From' => mb_encode_mimeheader('日本ワーキングホリデー協会','ISO-2022-JP').'<j-doi@plate.co.jp>',
                    //'To' => 'info@jawhm.or.jp',
                    'To' => 'j-doi@plate.co.jp',
					'Subject' => mb_encode_mimeheader('確認メール', 'ISO-2022-JP'));
				$q = new Mail_Queue($dbo, $mo);
				$mime = new Mail_mime();
				$mime->setTXTBody(mb_convert_encoding($msg, 'JIS'));
				$body = $mime->get(array('text_charset'=>'ISO-2022-JP'));
				$headers = $mime->headers($headers);
                //$q->put('info@jawhm.or.jp', 'info@jawhm.or.jp', $headers, $body);
                $q->put('j-doi@plate.co.jp', 'j-doi@plate.co.jp', $headers, $body);
			}
			print ('チェック情報を('.$cnt.')送信しました。<br/>【注意】このページは、絶対にリロードしないように！！');

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

?>


<?php
	if ($mode == 'new')	{
		// 新規登録フォーム
?>
		<form action="./userlist.php" method="post">
			<input type="hidden" name="mode" value="addcheck">
			<input type="hidden" name="vtype" value="<? print ($vtype); ?>">
			<table>
				<tr><th>メールアドレス</th><td><input type="text" size="50" name="vmail"></td></tr>
				<tr><th>名前</th><td><input type="text" size="30" name="vname1"></td></tr>
			</table>
			<input type="submit" value="　新規登録　">
		</form>
<?php
	}
	if ($mode == 'addnew')	{
		// 新規登録フォーム（外部から）
		$vtype = @$_GET['vtype'];
		$vmail = @$_GET['vmail'];
		$vname1 = mb_convert_encoding(@$_GET['vname1'],'UTF-8','SJIS');

		if ($vtype == '')	{
			dir('パラメータエラー');
		}
?>
		<form action="./userlist.php" method="post">
			<input type="hidden" name="mode" value="addcheck">
			<input type="hidden" name="vtype" value="<? print ($vtype); ?>">
			<table>
				<tr><th>メールアドレス</th><td><input type="text" size="50" name="vmail" value="<? print ($vmail); ?>"></td></tr>
				<tr><th>名前</th><td><input type="text" size="30" name="vname1" value="<? print ($vname1); ?>"></td></tr>
			</table>
			<input type="submit" value="　新規登録　">
		</form>
<?php
	}

	if ($mode == 'addcheck')	{
		// 新規登録チェック
		$vmail  = @$_POST['vmail'];
		$vname1 = @$_POST['vname1'];

		if ($vmail == '' || $vname1 == '')	{
			print '入力に不備があります。';
		}else{
			// 登録処理

			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$sql = 'INSERT INTO maillist(vtype, vmail, vname1, vname2, cdate, udate, vsend, vstat, vcheck, vid) VALUES(:vtype, :vmail, :vname1, :vname2, :cdate, :udate, :vsend, :vstat, :vcheck, :vid)';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':vtype', $vtype);
				$stt2->bindValue(':vmail', $vmail);
				$stt2->bindValue(':vname1', $vname1);
				$stt2->bindValue(':vname2', '');
				$stt2->bindValue(':cdate', date('Y/m/d'));
				$stt2->bindValue(':udate', date('Y/m/d'));
				$stt2->bindValue(':vsend', '1');
				$stt2->bindValue(':vstat', '登録');
				$stt2->bindValue(':vcheck', getRandomString(14));
				$stt2->bindValue(':vid', '00000');
				$stt2->execute();
				$db = NULL;
			} catch (PDOException $e) {
				if ($e->getCode() == 23000)	{
					die('このメールアドレスは既に登録されています。');
				}else{
					die($e->getMessage());
				}
			}
			print '登録しました。';
		}
	}
	if ($mode == 'setvcheck')	{
		// 送信対象外登録
		$vmail  = @$_POST['vmail'];
		$vsend  = @$_POST['vsend'];

		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$sql = 'UPDATE maillist SET vsend = :vsend , udate = :udate WHERE vtype = :vtype AND vmail = :vmail';
			$stt2 = $db->prepare($sql);
			$stt2->bindValue(':vtype', $vtype);
			$stt2->bindValue(':vmail', $vmail);
			$stt2->bindValue(':vsend', $vsend);
			$stt2->bindValue(':udate', date('Y/m/d'));
			$stt2->execute();
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		print '送信対象外に設定しました。';
	}
	if ($mode == 'modvname')	{
		// 名前変更
		$vmail  = @$_POST['vmail'];
		$vname1 = @$_POST['vname1'];

		if ($vname1 == '')	{
			print '名前を入力してください。';
		}else{
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$sql = 'UPDATE maillist SET vname1 = :vname1 , udate = :udate WHERE vtype = :vtype AND vmail = :vmail';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':vtype', $vtype);
				$stt2->bindValue(':vmail', $vmail);
				$stt2->bindValue(':vname1', $vname1);
				$stt2->bindValue(':udate', date('Y/m/d'));
				$stt2->execute();
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
			print '名前を変更しました。';
		}
	}
	if ($mode == 'delvmail')	{
		// 削除
		$vmail  = @$_POST['vmail'];

		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$sql = 'DELETE FROM maillist WHERE vtype = :vtype AND vmail = :vmail';
			$stt2 = $db->prepare($sql);
			$stt2->bindValue(':vtype', $vtype);
			$stt2->bindValue(':vmail', $vmail);
			$stt2->execute();
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		print 'メールアドレスを削除しました。';
	}

	if ($mode == 'ser')	{
		// 一覧表示
?>
		<form action="./userlist.php" method="post">
			<input type="hidden" name="mode" value="new">
			<input type="hidden" name="vtype" value="<? print ($vtype); ?>">
			<input type="submit" value="　新規登録　">
		</form>

		<table border="1">
		<tr>
		<th style="background-color:navy; color:white;">NO</th>
		<th style="background-color:navy; color:white;"><a class="list" href="./userlist.php?mode=ser&vtype=<? print $vtype; ?>&selorder=vname1">メールアドレス</a></th>
		<th style="background-color:navy; color:white;"><a class="list" href="./userlist.php?mode=ser&vtype=<? print $vtype; ?>&selorder=vmail">名前</a></th>
		<th style="background-color:navy; color:white;"><a class="list" href="./userlist.php?mode=ser&vtype=<? print $vtype; ?>&selorder=cdate">登録日</a></th>
		<th style="background-color:navy; color:white;"><a class="list" href="./userlist.php?mode=ser&vtype=<? print $vtype; ?>&selorder=udate">更新日</a></th>
		<th style="background-color:navy; color:white;"><a class="list" href="./userlist.php?mode=ser&vtype=<? print $vtype; ?>&selorder=vsend">送信対象</a></th>
		<th style="background-color:navy; color:white;"><a class="list" href="./userlist.php?mode=ser&vtype=<? print $vtype; ?>&selorder=vstat">状態</a></th>
		<th style="background-color:navy; color:white;">名前変更</th>
		<th style="background-color:navy; color:white;">削除</th>
		</tr>
<?php
		try {

			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$stt = $db->prepare('SELECT vmail, vname1, cdate, udate, vsend, vstat FROM maillist WHERE vtype = "'.$vtype.'" ORDER BY '.$selorder);
			$stt->execute();
			$idx = 0;

			while($row = $stt->fetch(PDO::FETCH_NUM)){
				print('<tr>');
				print('<td>'.++$idx.'</td>');
?>
				<td>
				<form action="./userlist.php" method="post" style="display: inline" onsubmit="return(confirm('[<? print ($row[0]); ?>]に確認メールを送信しますか？'));">
					<input type="hidden" name="mode" value="resend">
					<input type="hidden" name="vtype" value="<? print ($vtype); ?>">
					<input type="hidden" name="vmail" value="<? print ($row[0]); ?>">
					<input type="submit" value="送信">
				</form>
				<form action="./userlist.php" method="post" style="display: inline" onsubmit="return(confirm('[<? print ($row[0]); ?>]のチェックメールを送信しますか？'));">
					<input type="hidden" name="mode" value="chksend">
					<input type="hidden" name="vtype" value="<? print ($vtype); ?>">
					<input type="hidden" name="vmail" value="<? print ($row[0]); ?>">
					<input type="submit" value="チェック">
				</form>
				<? print ($row[0]); ?>
				</td>
<?
				print('<td>'.$row[1].'</td>');
				print('<td>'.$row[2].'</td>');
				print('<td>'.$row[3].'</td>');
				print('<td>');
				if ($row[4] == '1')	{
					print('対象');
?>
					<form action="./userlist.php" method="post" style="display: inline" onsubmit="return(confirm('[<? print ($row[0]); ?>]を送信対象外に設定しますか？'));">
						<input type="hidden" name="mode" value="setvcheck">
						<input type="hidden" name="vtype" value="<? print ($vtype); ?>">
						<input type="hidden" name="vmail" value="<? print ($row[0]); ?>">
						<input type="hidden" name="vsend" value="0">
						<input type="submit" value="解除">
					</form>
<?php
				}else{
					print('送信しない');
?>
					<form action="./userlist.php" method="post" style="display: inline" onsubmit="return(confirm('[<? print ($row[0]); ?>]を送信対象に設定しますか？'));">
						<input type="hidden" name="mode" value="setvcheck">
						<input type="hidden" name="vtype" value="<? print ($vtype); ?>">
						<input type="hidden" name="vmail" value="<? print ($row[0]); ?>">
						<input type="hidden" name="vsend" value="1">
						<input type="submit" value="対象">
					</form>
<?php
				}
				print('</td>');
				print('<td>'.$row[5].'</td>');
				print('<td>');
?>
				<form action="./userlist.php" method="post" style="display: inline" onsubmit="return(confirm('[<? print ($row[0]); ?>]の名前を更新しますか？'));">
					<input type="hidden" name="mode" value="modvname">
					<input type="hidden" name="vtype" value="<? print ($vtype); ?>">
					<input type="hidden" name="vmail" value="<? print ($row[0]); ?>">
					<input type="text" name="vname1" value="">
					<input type="submit" value="更新">
				</form>
<?
				print('</td>');
				print('<td>');
?>
				<form action="./userlist.php" method="post" style="display: inline" onsubmit="if(delok.checked){return(confirm('[<? print ($row[0]); ?>]を削除しますか？'));}else{alert('チェックを入れてください。');return false;}">
					<input type="hidden" name="mode" value="delvmail">
					<input type="hidden" name="vtype" value="<? print ($vtype); ?>">
					<input type="hidden" name="vmail" value="<? print ($row[0]); ?>">
					<input type="checkbox" name="delok">
					<input type="submit" value="削除する">
				</form>
<?
				print('</td>');
				print('</tr>');
			}

			$db = NULL;

		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

?>

</table>

<?
include_once 'fnc_footer.php';
?>
