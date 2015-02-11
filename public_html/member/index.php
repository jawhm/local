<?php

//	ini_set( "display_errors", "On");

session_start();
mb_language("Ja");
mb_internal_encoding("utf8");

function getRandomString($nLengthRequired = 8){
    $sCharList = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
    mt_srand();
    $sRes = "";
    for($i = 0; $i < $nLengthRequired; $i++)
        $sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
    return $sRes;
}

	$act = @$_POST['act'];
	$email = @$_POST['email'];
	$pwd = @$_POST['pwd'];
	$uid = @$_POST['uid'];

	$msg = '';

	if (@$_SESSION['mem_id'] <> '')	{
		// 既にログイン済みの場合
		header("Location: /member/top.php");
		exit;
	}


	if ($act == 'login')	{
		// ログイン処理
		if ($email == '' || $pwd == '')	{
			$msg = '入力されたメールアドレスかパスワードに誤りがあります。';
		}else{
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$stt = $db->prepare('SELECT id, email, password, namae FROM memlist WHERE email = :email and state = "5" ');
				$stt->bindValue(':email', $email);
				$stt->execute();
				$cur_id = '';
				$cur_email = '';
				$cur_password = '';
				$cur_namae = '';
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$cur_id = $row['id'];
					$cur_email = $row['email'];
					$cur_password = $row['password'];
					$cur_namae = $row['namae'];
				}
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
			if ($cur_password == md5($pwd))	{
				// ログインOK
				$_SESSION['mem_id'] = $cur_id;
				$_SESSION['mem_name'] = $cur_namae;
				$_SESSION['mem_level'] = 0;
				header("Location: /member/top.php");
				exit;
			}else{
				$msg = '入力されたメールアドレスかパスワードに誤りがあります。';
			}
		}
	}

	if ($act == 'nopwd')	{
		// パスワード忘れ
		if ($email == '' || $uid == '')	{
			$msg = '入力されたメールアドレスか会員番号に誤りがあります。';
		}else{
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$stt = $db->prepare('SELECT id, email, password, namae FROM memlist WHERE email = :email and state = "5" ');
				$stt->bindValue(':email', $email);
				$stt->execute();
				$cur_id = '';
				$cur_email = '';
				$cur_password = '';
				$cur_namae = '';
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$cur_id = $row['id'];
					$cur_email = $row['email'];
					$cur_password = $row['password'];
					$cur_namae = $row['namae'];
				}
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
			if ($cur_id == $uid)	{
				$pwd = getRandomString(12);
				try {
					$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
					$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$db->query('SET CHARACTER SET utf8');
					$stt = $db->prepare('UPDATE memlist SET password = :password WHERE email = :email');
					$stt->bindValue(':email', $email);
					$stt->bindValue(':password', md5($pwd));
					$stt->execute();
					$db = NULL;
				} catch (PDOException $e) {
					die($e->getMessage());
				}

				// メールを送信
				$subject = "新しいパスワードをお送りします";
				$body  = '';
				$body .= '日本ワーキングホリデー協会です。';
				$body .= chr(10);
				$body .= 'メンバー専用ページへのログインに必要なパスワードの再発行を承りました。';
				$body .= chr(10);
				$body .= chr(10);
				$body .= '新しいパスワード（１２桁）は、以下の通りとなります。';
				$body .= chr(10);
				$body .= chr(10);
				$body .= 'パスワード [ '.$pwd.' ]';
				$body .= chr(10);
				$body .= chr(10);
				$body .= 'なお、ログイン後、新しいパスワードに変更することをお勧めいたします。';
				$body .= chr(10);
				$body .= '';
				$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
				mb_send_mail($email,$subject,$body,"From:".$from);

				$msg = '新しいパスワードをお送りしました。メールをご確認ください。';
			}else{
				$msg = '入力されたメールアドレスか会員番号に誤りがあります。';
			}
		}
	}


?>
<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='メンバーログイン';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
$header_obj->add_js_files='<script type="text/javascript" src="/js/jquery.corner.js"></script>
<script>
$(function(){
     $(".open1").click(function(){
      $("#slidebox1").slideToggle("slow");
     });
     $(".open2").click(function(){
      $("#slidebox2").slideToggle("slow");
     });
});
</script>
';

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'メンバーログイン | メンバー専用ページ';
$header_obj->full_link_tag = true;

$header_obj->display_header();

?>
<body>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs(); ?>

	<h2 class="sec-title">ログイン</h2>
	<div>
		<p class="text01">
			メンバー専用ページにログインします。<br/>
			ご登録頂いた、メールアドレスとパスワードでログインしてください。
		</p>
<?php
	if ($msg <> '' && $act == '')	{
		echo '&nbsp;<br/><p style="color:red; font-weight:bold;">'.$msg.'</p>';
	}
?>
		<div style="border: 1px dotted navy; margin: 20px 0 10px 0; padding: 10px 10px 10px 10px; font-size:11pt;">
			<form action="./index.php" method="post">
				<input type="hidden" name="act" value="login">
						<p class="text01" style="text-align:left;">メールアドレス&nbsp;<input type="text" size="30" name="email" value="" />&nbsp;<?php if(!$header_obj->computer_use())echo '<br />';?>
						パスワード&nbsp;<input type="password" size="20" name="pwd" <?php if(!$header_obj->computer_use())echo 'style="margin-left:24px;"';?> value="" />&nbsp;<?php if(!$header_obj->computer_use())echo '<br /><br />';?>
						<input type="submit" value="　ログイン　"></p>
			</form>
<?php
	if ($msg <> '' && $act == 'login')	{
		echo '<p style="color:red; font-weight:bold;">'.$msg.'</p>';
	}
?>
		</div>

		<p class="open1" style="background-color:orange; width:300px; max-width:100%; cursor:pointer; cursor:hand; font-size:11pt; padding:3px 0 3px 5px;">
			<img src="../images/arrow0303.gif"> パスワードをお忘れの場合
		</p>
<?php	if ($act == 'nopwd')	{	?>
		<div id="slidebox1" style="font-size:10pt; border: 1px dotted orange; padding:10px 20px 10px 20px;">
<?php	}else{				?>
		<div id="slidebox1" style="display:none; font-size:10pt; border: 1px dotted orange; padding:10px 20px 10px 20px;">
<?php	}				?>
			パスワードを忘れてしまった場合は、<br/>
			以下のフォームに、登録時のメールアドレスと会員番号を入力してください。<br/>
			ご登録頂いたメールアドレスに新しいパスワードをお送りいたします。<br/>
			&nbsp;<br/>
			協会オフィスにてメンバー登録された方で、パスワードが判らない場合も、<br/>
			こちらから新しいパスワードを設定してください。<br/>
			<div style="border: 1px dotted navy; margin: 20px 30px 10px 0; padding: 10px 20px 10px 20px; font-size:11pt;">
				<form action="./index.php" method="post">
					<input type="hidden" name="act" value="nopwd">
                    <p class="text01"><u>メールアドレス</u><br />
                    <input type="text" size="30" name="email" value=""><br /><br />
                   <u>会員番号</u><br />
                   <input type="text" size="20" name="uid" value=""><br /><br />
                   <input type="submit" value="　パスワード再発行　"></p>
				</form>
<?php
	if ($msg <> '' && $act == 'nopwd')	{
		echo '<p style="color:red; font-weight:bold;">'.$msg.'</p>';
	}
?>
			</div>
		</div>

		<div style="height:10px;">&nbsp;</div>

		<p class="open2" style="background-color:orange; width:300px; max-width:100%; cursor:pointer; cursor:hand; font-size:11pt; padding:3px 0 3px 5px;">
			<img src="../images/arrow0303.gif" /> 登録時のメールアドレスをお忘れの場合
		</p>
		<div id="slidebox2" style="display:none; font-size:10pt; border: 1px dotted orange; padding:10px 20px 10px 20px;">
			ご登録頂いたメールアドレスが解らない場合は、お手数ですが以下の内容を toiawase@jawhm.or.jp までご連絡ください。<br/>
			　・　お名前<br/>
			　・　会員番号<br/>
			　・　生年月日<br/>
			　・　ご登録頂いた電話番号<br/>
		</div>

	</div>

	&nbsp;<br/>
	&nbsp;<br/>

	<h2 class="sec-title" id="event">メンバー登録のお願い</h2>
		<p class="text01">
			こちらから先は、メンバー登録を済まされた方専用となります。<br/>
			<a href="../mem">メンバー登録をご希望の場合は、こちらからお願いいたします。</a><br/>
		</p>
	<div style="margin-top:30px; text-align:center;">
		<a href="/mem/"><img src="/images/katsuyou_mem_big_off.gif"></a>
	</div>

	&nbsp;<br/>
	&nbsp;<br/>


	<h2 class="sec-title" id="event">メンバーの更新手続きについて</h2>
		<p class="text01">
			初回のメンバー登録は、登録日より３年間が有効期限となります。<br/>
			この後、メンバー登録を更新する場合、更新料として2,000円かかります。<br/>
			更新手続きにより、現在の有効期限の翌日から２年間が新しい有効期限となります。<br/>
		</p>
		<p class="text01" style="margin-top:10px;">
			【メンバー更新時のご注意】<br/>
			メンバー登録の更新をご希望の場合は、<u>現在のメンバー登録の有効期限内に更新手続きを行ってください。</u><br/>
			<u>有効期限が過ぎてからの更新は出来ません。</u><br/>
			<u>この場合、新規メンバーとして登録（登録料 5,000円 / ３年間有効）となります。</u><br/>
		</p>
		<p class="text01" style="margin-top:20px;">
			【メンバー更新の手続き方法】<br/>
			メンバー登録の更新をご希望の場合は、以下の手順で手続きをしてください。<br/>
			&nbsp;<br/>
			　１．　お電話又はメールにて、メンバー登録の更新をご希望の旨、ご連絡下さい。<br/>
			　　　　メールでご連絡頂く場合、必ず「会員番号」と「お名前」をご明記ください。<br/>
			　２．　更新料のお振込み先をご案内しますので、１週間以内に更新料(2,000円)をお支払ください。<br/>
			　　　　※<u>メンバー更新料のお支払方法は「銀行振込」のみとなります。</u><br/>
			　　　　　クレジットカード又はコンビニエンス決済ではお支払頂けません。<br/>
			　　　　　なお、振込手数料は、お客様の負担となります。<br/>
			　３．　ご入金を確認後、新しいメンバーカードをお送り致します。<br/>
		</p>


	&nbsp;<br/>
	&nbsp;<br/>


	<h2 class="sec-title" id="event">メンバーカードの再発行手続きについて</h2>
		<p class="text01">
			【メンバーカード再発行の手続き方法】<br/>
			メンバーカードの紛失、盗難等によりカードの再発行が必要な場合は、以下の手順で手続きをしてください。<br/>
			&nbsp;<br/>
			　１．　お電話又はメールにて、カード再発行をご希望の旨、ご連絡下さい。<br/>
			　　　　メールでご連絡頂く場合、必ず「会員番号」と「お名前」をご明記ください。<br/>
			　　　　会員番号が解らない場合、「お名前」「生年月日」「ご登録頂いた電話番号」をご明記ください。<br/>
			　２．　カード再発行手数料のお振込み先をご案内しますので、１週間以内に手数料(1,000円)をお支払ください。<br/>
			　　　　※<u>カード再発行手数料のお支払方法は「銀行振込」のみとなります。</u><br/>
			　　　　　クレジットカード又はコンビニエンス決済ではお支払頂けません。<br/>
			　　　　　なお、振込手数料は、お客様の負担となります。<br/>
			　３．　ご入金を確認後、新しいメンバーカードをお送り致します。<br/>
		</p>


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

