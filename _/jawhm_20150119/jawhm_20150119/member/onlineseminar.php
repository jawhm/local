<?php

	require_once 'reqcheck.php';

?>
<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='オンラインセミナー';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
$header_obj->add_js_files='<script type="text/javascript" src="/js/jquery.corner.js"></script>
<script type="text/javascript">
$(function () {
	$("#div_mail").corner();
});
</script>
<script>
function fnc_logout()	{
	if (confirm("ログアウトしますか？"))	{
		location.href = "/member/logout.php";
	}
}
</script>
';
$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'オンラインセミナー | メンバー専用ページ';
$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs('member-top'); ?>

	<div id="logout-btn">
		<input type="button" value="　ログアウト　" onClick="fnc_logout();">
	</div>

<?php


	mb_language("Ja");
	mb_internal_encoding("utf8");

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
		$vsend = @$_POST['vsend'];
		if (mb_strlen($vname1) > 50)	{
			$msg = 'エラー：お名前は２０文字以内で入力してください。';
		}else{
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$sql = 'UPDATE maillist SET vname1 = :vname1 , vsend = :vsend , vstat = :vstat , udate = :udate WHERE vcheck = :vcheck';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':vcheck', $vcheck);
				$stt2->bindValue(':vname1', $vname1);
				$stt2->bindValue(':vsend', $vsend);
				$stt2->bindValue(':vstat', '登録');
				$stt2->bindValue(':udate', date('Y/m/d'));
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
		<div id="msg" class="short-msg">
			<?php print $msg; ?>
		</div>
<script>
var tim = null;
var wid = 500;
tim = setTimeout('fnc_msg()',3000);
function fnc_msg() {
	clearTimeout(tim);
	tim = setTimeout('fnc_msg_2()',20);
}
function fnc_msg_2()	{
	clearTimeout(tim);
	wid = wid - 30;
	if (wid <= 0)	{
		document.getElementById('msg').style.display = 'none';
	}else {
		document.getElementById('msg').innerHTML = '';
		document.getElementById('msg').style.width = wid + 'px';
		tim = setTimeout('fnc_msg_2()',20);
	}
}
</script>

<?php
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
<?php
		}else{
?>
			<p>登録内容を修正して、登録ボタンを押してください。</p>
<?php
		}
?>

		<p>&nbsp;</p>
		<form action="./pc.php" method="POST">
		<table class="mailtable ">
			<tr>
				<td class="mailtable-label">ご登録のメールアドレス</td>
				<td class="mailtable-data">
					<?php print $row['vmail']; ?></td>
			</tr>
			<tr>
				<td class="mailtable-label">お名前（ニックネーム可）</td>
				<td class="mailtable-data">
					<input id="onamae" name="vname1" type="text" size="20" maxlength="20" value="<?php print $row['vname1']; ?>"> さん</td>
			</tr>
			<tr>
				<td class="mailtable-label">配信状態</td>
				<td class="mailtable-data">
<?php
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
				</td>
			</tr>
			<tr>
			<td colspan="2" style="text-align:center;">
				<input type="hidden" name="act" value="upd">
				<input type="hidden" name="vstat" value="<?php print $row['vstat']; ?>">
				<input type="hidden" name="chkmail" value="<?php print $row['vmail']; ?>">
				<input type="hidden" name="vcheck" value="<?php print $vcheck; ?>">
				<input type="reset" value="リセット" style="width:80px; height:30px;">　　&nbsp;
				<input type="submit" value="登録" style="width:80px; height:30px;">
			</td>
			</tr>
		</table>
		</form>

		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>【ご注意】</p>
		<p>メールアドレスの変更は出来ません。新しいメールアドレスで登録してください。</p>
		<p></p>
		<p></p>
<?php
		}

		$db = NULL;

	} catch (PDOException $e) {
		die($e->getMessage());
	}

	if ($idx == 0)	{
?>

<?php
	}
?>

<script>
function fnc_onlinesemi()	{
	obj = document.getElementById('mailad');
	if (obj.value == '')	{
		alert('メールアドレスを入力してください');
		obj.focus();
		return false;
	}
	return true;
}
</script>

	<h2 id="onlinesemi" class="sec-title">オンラインセミナーに参加</h2>
	<div id="sitemapbox">
		<p>
			日本ワーキング・ホリデー協会のセミナーをネット上で見ることが出来ます。<br/>
			セミナーの開催日程は、<a href="../seminar.html">こちら</a>をご確認ください。<br/>
		</p>
<?php
	if ($act == 'onlinesemi')	{

function getRandomString($nLengthRequired = 8){
    $sCharList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";
    mt_srand();
    $sRes = "";
    for($i = 0; $i < $nLengthRequired; $i++)
        $sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
    return $sRes;
}

	$vmail = @$_POST['mailad'];
	if ($vmail == '')	{
		$msg = 'メールアドレスが不正です。';
	}else{
		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$stt = $db->prepare('SELECT vcheck FROM semilist WHERE vmail = "'.$vmail.'"');
			$stt->execute();
			$idx = 0;
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$vcheck = $row['vcheck'];
			}
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		if ($idx > 0)	{
			// 更新
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$sql = 'UPDATE semilist SET udate = :udate WHERE vmail = :vmail';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':vmail', $vmail);
				$stt2->bindValue(':udate', date('Y/m/d'));
				$stt2->execute();
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}else{
			// 追加
			$vcheck = getRandomString(30);
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$sql = 'INSERT INTO semilist (vmail, cdate, udate, itimes, vcheck) VALUES (:vmail, :cdate, :udate, :itimes, :vcheck)';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':vmail', $vmail);
				$stt2->bindValue(':cdate', date('Y/m/d'));
				$stt2->bindValue(':udate', date('Y/m/d'));
				$stt2->bindValue(':itimes', '0');
				$stt2->bindValue(':vcheck', $vcheck);
				$stt2->execute();
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}

		// メール送信
		$subject = "オンラインセミナーの情報をお送りします";

		$body  = '';
		$body .= '日本ワーキングホリデー協会です。';
		$body .= chr(10);
		$body .= chr(10);
		$body .= 'オンラインセミナーへの御参加ありがとうございます。';
		$body .= chr(10);
		$body .= '次のＵＲＬのページを開いてセミナーをお聞きください。';
		$body .= chr(10);
		$body .= chr(10);
		$body .= 'http://www.jawhm.or.jp/semi/?u='.$vcheck.'&m='.md5($vmail);
		$body .= chr(10);
		$body .= chr(10);
		$body .= '◆このメールに覚えが無い場合◆';
		$body .= chr(10);
		$body .= '他の方がメールアドレスを間違えた可能性があります。';
		$body .= chr(10);
		$body .= 'お手数ですが、 info@jawhm.or.jp までご連絡頂ければ幸いです。';
		$body .= chr(10);
		$body .= '';
		$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
		mb_send_mail($vmail,$subject,$body,"From:".$from);

		// 社内通知
		$subject = "オンラインセミナーのＵＲＬが発行されました。";

		$body  = '';
		$body .= 'オンラインセミナーＵＲＬが発行されました。';
		$body .= chr(10);
		$body .= chr(10);
		$body .= '会員番号　：　'.$mem_id;
		$body .= chr(10);
		$body .= 'お名前　：　'.$mem_name;
		$body .= chr(10);
		$body .= 'メールアドレス　：　'.$vmail;
		$body .= chr(10);
		$body .= chr(10);
		$body .= 'http://www.jawhm.or.jp/semi/?u='.$vcheck.'&m='.md5($vmail);
		$body .= chr(10);
		$body .= '';
		$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
		mb_send_mail('meminfo@jawhm.or.jp',$subject,$body,"From:".$from);

		$msg = 'ご指定のメールアドレスにＵＲＬを送信しました。';
	}

		if ($msg != '')	{
?>
		<div id="msg" class="short-msg">
			<?php print $msg; ?>
		</div>
<script>
var tim = null;
var wid = 500;
tim = setTimeout('fnc_msg()',3000);
function fnc_msg() {
	clearTimeout(tim);
	tim = setTimeout('fnc_msg_2()',20);
}
function fnc_msg_2()	{
	clearTimeout(tim);
	wid = wid - 30;
	if (wid <= 0)	{
		document.getElementById('msg').style.display = 'none';
	}else {
		document.getElementById('msg').innerHTML = '';
		document.getElementById('msg').style.width = wid + 'px';
		tim = setTimeout('fnc_msg_2()',20);
	}
}
</script>

<?php
		}
	}
?>
		<div class="yellowblock">

			<p>オンラインセミナーへの参加方法</p>
			<p>　　１． 以下のフォームに、あなたのメールアドレスを入力してください。</p>
			<p>　　２． オンラインセミナー表示用のＵＲＬを、ご指定のメールアドレスに送信致しますので、</p>
			<p>　　　　 受信したメールの内容を確認してください。</p>
			<p>&nbsp;</p>

			<div id="div_mail" style="border:2px solid orange; padding: 5px 10px 5px 5px; width:95%;">
				<form action="./onlineseminar.php" method="post" onSubmit="return fnc_onlinesemi();" style="font-size:10pt;">
					メールアドレス&nbsp;&nbsp;
					<input type="text" value="<?php echo $mem_email; ?>" size="40" id="mailad" name="mailad">
					<input type="submit" value="送信" style="width:80px;">
					<input type="hidden" name="act" value="onlinesemi">
				</form>
			</div>
			<p>&nbsp;</p>
			<p>
				【ご注意】<br/>
				　　オンラインセミナーは、携帯からご覧いただくことは出来ません。<br/>
				　　ＰＣのメールアドレスをご利用ください。<br/>
			</p>
		</div>

	<div style="height:10px;">&nbsp;</div>
	</div>

	  <div class="top-move">
	    <p><a href="#header">▲ページのＴＯＰへ</a></p>
      </div>	  

      <div class="advbox03">
	    <p>108</p>
	  </div>	  
      <div class="advbox03">
	    <p>109</p>
	  </div>
	</div>
  </div>
  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>
