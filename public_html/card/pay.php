<?php

	list(,$get_authcd) = explode('/', $_SERVER['PATH_INFO']);

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$stt = $db->prepare('SELECT sendid, amount, namae, youto, paydate FROM card WHERE authcd = "'.$get_authcd.'" ');
		$stt->execute();
		$idx = 0;
		$cur_sendid = '';
		$cur_amount = '';
		while($row = $stt->fetch(PDO::FETCH_ASSOC)){
			$idx++;
			$cur_sendid = $row['sendid'];
			$cur_amount = $row['amount'];
			$cur_namae = $row['namae'];
			$cur_youto = $row['youto'];
			$cur_paydate = $row['paydate'];
		}
		$db = NULL;
	} catch (PDOException $e) {
		die($e->getMessage());
	}
?>
<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='クレジットカード決済';
$header_obj->keywords_page='ワーキングホリデー,ワーホリ,オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館';
$header_obj->description_page='オーストラリア・ニュージーランド・カナダを初めとしたワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。';

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '一般社団法人日本ワーキング・ホリデー協会';
$header_obj->fncMenuHead_link='nolink';

$header_obj->fncMenubar_function=false;

$header_obj->display_header();

?>
	<div id="maincontent" style="margin-left:150px;">
	<div id="top-main" style="width:700px;margin-bottom:20px; font-size:12pt; margin: 20px 0 20px 0;">

<?php
	if ($cur_sendid == '')	{
?>
		決済コードが確認できません。<br/>
		お手数ですが info@jawhm.or.jp までお問い合わせください。<br/>
		&nbsp;<br/>
		Sorry, Invalid requiest.<br/>
		Please contact to us. info@jawhm.or.jp<br/>

<?php	}else{
		if ($cur_paydate <> '')	{
?>

			この決済は既にお支払済みです。<br/>
			ご不明な場合は、info@jawhm.or.jp までお問い合わせください。<br/>

<?php
		}else{
?>

		当協会では、クレジットカードのお支払の場合、株式会社デジタルチェックのシステムを利用しております。<br/>
		以下のボタンをクリックして、支払手続きをお願いいたします。<br/>
		&nbsp;<br/>
		<center>
			<p style="font-size:14pt;">【　　お支払内容の確認　　】</p>
			&nbsp;<br/>
			<table style="font-size:12pt;">
				<tr><td style="width:200px; text-align:right; border-bottom:1px dotted navy;">お名前　　</td><td style="width:300px; border-bottom:1px dotted navy;"><?php echo $cur_namae; ?>　様</td></tr>
				<tr><td style="text-align:right; border-bottom:1px dotted navy;">お支払額　　</td><td style="border-bottom:1px dotted navy;"><?php echo $cur_amount; ?>　円</td></tr>
				<tr><td style="text-align:right; border-bottom:1px dotted navy;">適用　　</td><td style="border-bottom:1px dotted navy;"><?php echo $cur_youto; ?></td></tr>
			</table>
		</center>
		&nbsp;<br/>
		<form method="post" action="https://www.digitalcheck.jp/settle/settle3/bp3.dll" target="_blank" accept-charset="Shift_JIS" onSubmit="document.charset='SHIFT-JIS';document.getElementById('btnsubmit').disabled=true;">
			<input type="hidden" name="IP" value="A363045858">
			<input type="hidden" name="SID" value="<?php echo $cur_sendid; ?>">
			<input type="hidden" name="FUKA" value="<?php echo $cur_sendid; ?>">
			<input type="hidden" name="N1" value="日本ワーキングホリデー協会">
			<input type="hidden" name="MAIL" value="info@jawhm.or.jp">
			<input type="hidden" name="NAME1" value="<?php echo $cur_namae; ?>">
			<input type="hidden" name="K1" value="<?php echo $cur_amount; ?>">
			<input type="hidden" name="STORE" value="51">
			<input type="hidden" name="KAKUTEI" value="1">
			<input type="submit" value="クレジットカードでお支払" id="btnsubmit" style="width:350px; height:30px; margin:18px 0 10px 180px; font-size:11pt; font-weight:bold;">
		</form>
		&nbsp;<br/>
		&nbsp;<br/>
		<strong>クレジットカードのお支払は SSLというシステムを利用しております。カード番号等の情報は暗号化されて送信されます。ご安心下さい。</strong><br/>
		※なお、カード決済ページは別ウィンドウで開きます。<br/>

<?php	} }	?>

	</div><!--top-mainEND-->
	</div><!--maincontentEND-->

  </div><!--contentsEND-->
  </div><!--contentsboxEND-->
<?php fncMenuFooter('nolink'); ?>
</body>
</html>