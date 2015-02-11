<?php

	require_once 'reqcheck.php';


	$act = @$_POST['act'];
	$oldpwd = @$_POST['oldpwd'];
	$newpwd = @$_POST['newpwd'];

	$msg = '';

	if ($act == 'changepwd')	{
		// パスワード変更
		if ($oldpwd == '' || $newpwd == '')	{
			if ($newpwd == '')	{
				$msg = '新しいパスワードを入力してください。';
			}
			if ($oldpwd == '')	{
				$msg = '現在のパスワードを入力してください。';
			}
		}else{
			if (mb_strlen($newpwd) < 5)	{
				$msg = '新しいパスワードは、５文字以上で設定してください。';
			}else{
				try {
					$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
					$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$db->query('SET CHARACTER SET utf8');
					$stt = $db->prepare('SELECT id, email, password, namae FROM memlist WHERE id = :id ');
					$stt->bindValue(':id', $mem_id);
					$stt->execute();
					$cur_password = '';
					while($row = $stt->fetch(PDO::FETCH_ASSOC)){
						$cur_password = $row['password'];
					}
					if ($cur_password == md5($oldpwd))	{
						// 更新処理
						$stt = $db->prepare('UPDATE memlist SET password = :password WHERE id = :id ');
						$stt->bindValue(':id', $mem_id);
						$stt->bindValue(':password', md5($newpwd));
						$stt->execute();
						$msg = 'パスワードを変更しました。次回ログイン時より有効です。';
					}else{
						$msg = '入力された現在のパスワードに誤りがあります。';
					}
					$db = NULL;
				} catch (PDOException $e) {
					die($e->getMessage());
				}
			}
		}
	}




?>
<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='会員情報変更';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
$header_obj->add_js_files='<script type="text/javascript" src="/js/jquery.corner.js"></script>
<script>
function fnc_logout()	{
	if (confirm("ログアウトしますか？"))	{
		location.href = "/member/logout.php";
	}
}
</script>
';

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '会員情報変更 | メンバー専用ページ';
$header_obj->full_link_tag = true;

$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs('member-top'); ?>
      

	<div id="logout-btn">
		<input type="button" value="　ログアウト　" onClick="fnc_logout();">
	</div>

	<h2 class="sec-title">ログインパスワードを変更する</h2>
	<div style="padding-left:30px;">
		<p>
			ログインパスワードを変更する場合は、こちらのフォームをご利用ください。
		</p>
			<div style="border: 1px dotted navy; margin: 20px 30px 10px 0; padding: 10px 20px 10px 20px; font-size:11pt;">
				<form action="./memreg.php" method="post">
					<input type="hidden" name="act" value="changepwd">
					<table>
						<tr>
							<td>現在のパスワード</td>
							<td><input type="text" size="20" name="oldpwd" value=""></td>
						</tr>
						<tr>
							<td>新しいパスワード</td>
							<td><input type="text" size="20" name="newpwd" value=""></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td style="text-align:right;">
								<input type="submit" value="　パスワード変更　">
							</td>
						</tr>
					</table>
				</form>
<?php
	if ($msg <> '' && $act == 'changepwd')	{
		echo '<p style="color:red; font-weight:bold;">'.$msg.'</p>';
	}
?>
			</div>

	</div>

	<h2 class="sec-title" id="event">会員情報を修正する</h2>
	<div style="padding-left:30px;">
		<p>
			ご登録頂いた住所、電話番号等の変更は、現在WEB上から行うことができません。<br/>
			お手数ですが、会員番号と変更内容を明記の上、 toiawase@jawhm.or.jp までご連絡ください。<br/>
		</p>
	</div>

	<div style="padding-left:30px;">

	</div>

	<div style="height:30px;">&nbsp;</div>

<div style="height:30px;">&nbsp;</div>
<div style="text-align:center;">
	<img src="../images/flag01.gif">
	<img src="../images/flag03.gif">
	<img src="../images/flag09.gif">
	<img src="../images/flag05.gif">
	<img src="../images/flag06.gif">
	<img src="../images/mflag11.gif" width="40" height="26">
	<img src="../images/flag08.gif">
	<img src="../images/flag04.gif">
	<img src="../images/flag02.gif">
	<img src="../images/flag10.gif">
	<img src="../images/flag07.gif">
</div>

	<div style="height:50px;">&nbsp;</div>

	</div>


	</div>
  </div>
  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>

