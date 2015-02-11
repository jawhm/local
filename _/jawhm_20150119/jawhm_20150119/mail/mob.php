<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Cache-control" CONTENT="no-store">
<META HTTP-EQUIV="Cache-control" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Mon, 1 Jan 1990 01:01:01 GMT">
<title>日本ワーキング・ホリデー協会</title>
</head>
<body bgcolor="#FFFFFF" text="#333333"link="#0000CD" vlink="#5C82FF" alink="#FFFFFF">
<div align="left" >
<p align="center"><img src="../i/img/top.jpg" width="240" height="77" align="middle"></p>
<Marquee bgcolor="#999999" width="240"><Font size="4" color="#FFFFFF">メール会員情報変更</Font></Marquee>

<hr color="#000033">

<?php

//ini_set( "display_errors", "On");

	$act = @$_POST['act'];
	$vcheck = @$_GET['u'];
	if ($vcheck == '')	{
		$vcheck = @$_POST['vcheck'];
	}
	$chkmail = @$_GET['m'];
	if ($chkmail == '')	{
		$chkmail = @$_POST['chkmail'];
	}

	$msg = '';
	if ($act == 'upd')	{
		$vname1 = @$_POST['vname1'];
		if ($vname1 == '')	{
			$vname1 = '名無し';
		}
		$vsend = trim(@$_POST['vsend']);
		if (mb_strlen($vname1) > 50)	{
			$msg = 'エラー：お名前は２０文字以内で入力してくだ'.$vname1.'さい。'.mb_strlen($vname1);
		}else{
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$sql = 'UPDATE maillist SET haihai = 1, vname1 = :vname1 , vsend = :vsend , vstat = :vstat , udate = :udate WHERE vcheck = :vcheck';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':vcheck', $vcheck);
				$stt2->bindValue(':vname1', $vname1);
				$stt2->bindValue(':vsend', $vsend);
				$stt2->bindValue(':vstat', '登録');
				$stt2->bindValue(':udate', date('Y/m/d'));
				$stt2->execute();

				// メアドでの一括更新
				$sql = 'UPDATE maillist SET haihai = 1, vsend = :vsend , vstat = :vstat , udate = :udate WHERE vmail = :vmail';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':vsend', $vsend);
				$stt2->bindValue(':vstat', '登録');
				$stt2->bindValue(':udate', date('Y/m/d'));
				$stt2->bindValue(':vmail', $chkmail);
				$stt2->execute();

				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
			$msg = '登録内容を変更しました。';
		}
	}

	if ($msg != '')	{
?>
		<div id="msg" style="background-color:orange; color:black; font-weight:bold; margin:0 0 10px 0;">
			<? print $msg; ?>
		</div>
<?
	}

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$stt = $db->prepare('SELECT vmail, vname1, vsend, vstat FROM maillist WHERE vcheck = "'.$vcheck.'"');
		$stt->execute();
		$idx = 0;
		while($row = $stt->fetch(PDO::FETCH_ASSOC)){
			$idx++;
			if (md5($row['vmail']) == @$_GET['m'])	{
				$chkmail = $row['vmail'];
			}
		}
		$db = NULL;
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$stt = $db->prepare('SELECT vmail, vname1, vsend, vstat FROM maillist WHERE vcheck = "'.$vcheck.'" AND vmail = "'.$chkmail.'"');
		$stt->execute();
		$idx = 0;
		while($row = $stt->fetch(PDO::FETCH_ASSOC)){
			$idx++;

		if ($row['vstat'] == '仮登録')	{
?>
			<p>お名前を入力して、登録ボタンを押して下さい。</p>
<?
		}else{
?>
			<p>登録内容を修正して、登録ボタンを押してください。</p>
<?
		}
?>

		<form action="./mob.php" method="POST">
		■ご登録のメールアドレス<br/>
		<? print $row['vmail']; ?><br/>
		&nbsp;<br/>
		■お名前（ニックネーム可）
		<input id="onamae" name="vname1" type="text" size="20" maxlength="20" value="<? print $row['vname1']; ?>"> さん<br/>
		&nbsp;<br/>
		■配信状態<br/>
<?
				if ($row['vstat'] == '登録')	{
					if ($row['vsend'] == '1')	{
						print '<input type="radio" name="vsend" value="1" checked>配信　';
						print '<input type="radio" name="vsend" value="0">配信停止';
					}else{
						print '<input type="radio" name="vsend" value="1">配信　';
						print '<input type="radio" name="vsend" value="0" checked>配信停止';
					}
				}else{
					print '仮登録';
					print '<input type="hidden" name="vsend" value="1">';
				}
?>
		<br/>
		&nbsp;<br/>
		<input type="hidden" name="act" value="upd">
		<input type="hidden" name="vstat" value="<? print $row['vstat']; ?>">
		<input type="hidden" name="chkmail" value="<? print $row['vmail']; ?>">
		<input type="hidden" name="vcheck" value="<? print $vcheck; ?>">
		<input type="submit" value="　　登録　　"><br/>
		<input type="reset" value="リセット">
		<br/>
		</form>

		<p>【ご注意】<br/>
		メールアドレスの変更は出来ません。新しいメールアドレスで登録してください。<br/>
		また、システムの都合上、配信状態を「配信停止」に変更した後、４８時間程度はメールが送信されてしまう可能性があります。恐れ入りますがご了承ください。</p>

<?
		}

		$db = NULL;

	} catch (PDOException $e) {
		die($e->getMessage());
	}

	if ($idx == 0)	{
?>
		<p>メール会員になりませんか？</p>

		<p>登録方法は簡単</p>
		<p>１． reg@jawhm.or.jp に空メールを送信してください。<br/>
		（ご注意：携帯から登録される方へ<br/>
		ＵＲＬが記載されたメールをお送りしますので、メールの拒否設定を行っている場合は、解除してから空メールをお送りください。）<br/>
		また、ドメイン規制を行っている場合は、 jawhm.or.jp のドメインを許可してください。<br/>
		</p>
		<p>２． 登録用のＵＲＬが送られてくるので、お名前（ニックネーム可）を登録してください。</p>
		<p>以上で完了です。</p>
		<p></p>
		<p></p>
<?
	}
?>





<hr color="#000033">
<p align="center"><img src="../i/img/footer.jpg" width="240" height="25" align="middle"></p>
</div>

</body>
</html>