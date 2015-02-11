<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='留学プログログラム同意確認';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->full_link_tag=true;
$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '留学プログログラム同意確認';

$header_obj->display_header();

?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs(); ?>

<?php

	mb_language("Ja");
	mb_internal_encoding("utf8");

	$e = @$_GET['e'];
	$act = @$_POST['act'];

?>


<h2 class="sec-title">留学プログログラム同意確認</h2>
<div style="padding-left:30px;">


<?php
	if ($act == 'send')	{

		$fname = $_POST['お名前'];
		$fmail = $_POST['連絡用・メールアドレス'];

		$vmail = 'toiawase@jawhm.or.jp,sodan@jawhm.or.jp,sodan-osaka@jawhm.or.jp,sodan-nagoya@jawhm.or.jp';
		$subject = "留学プログログラム同意確認　".$fname."様";

		$body  = '';
		$body .= '[留学プログログラム同意確認]';
		$body .= chr(10);
		foreach($_POST as $post_name => $post_value){
			$body .= chr(10);
			$body .= $post_name." : ".$post_value;
		}
		$body .= chr(10);
		$body .= chr(10);
		$body .= '--------------------------------------';
		$body .= chr(10);
		foreach($_SERVER as $post_name => $post_value){
			$body .= chr(10);
			$body .= $post_name." : ".$post_value;
		}
		$body .= '';
		$from = mb_encode_mimeheader(mb_convert_encoding($fname,"JIS"))."<$fmail>";
		mb_send_mail($vmail,$subject,$body,"From:".$from);


?>
	<p style="margin-top:20px;">
		ご入力ありがとうございました。<br/>
		内容を確認の上、担当者よりご連絡申し上げます。<br/>
	</p>

<?php
	}else{
?>
	<p style="margin:10px 0 6px 0; font-size:10pt; font-weight:bold;">
		留学プログラムの申込にあたり、以下の内容を確認の上、フォームにご入力お願い致します。<br/>
	</p>

	<p style="margin:0px 0 10px 0;">
		※申込者が未成年者の場合、このフォーマットはご利用頂けません。<br/>
		　必ず、<b>書面</b>による同意書のご提出をお願い致します。<br/>
	</p>
	<p style="margin:0px 0 10px 0;">
		※留学プログラム基本約款、及び、書面による同意書は<a href="./download.php" target="_blank">こちら</a>からご確認いただけます。<br/>
	</p>

	<div style="margin:20px 0 30px 0; padding: 10px 20px 10px 20px; background-color:#90EE90; font-size:10.5pt;">
	<<　重要事項説明　>><br/>
	&nbsp;<br/>
	１．当協会はお客様の希望する留学先及びその内容を考慮の上、お客様が希望する留学先・滞在先の手続き代行を行いますが、お客様が希望する資格の取得、試験の合格、その後の留学先への合格など、留学プログラム期間中及び終了後のお客様に対し、何ら保証を行うものではありません。（基本約款：第４条）<br/>
	&nbsp;<br/>
	２．当協会からお客様に提供される情報は、提供時点でのものであり、その後、予告なく変更される可能性もあります。その変更に気付かず行ったお客様のいかなる行動も当協会では責任を負いかねます。（基本約款：第４条（１０））<br/>
	&nbsp;<br/>
	３．当協会が留学プログラムの実施に障害があると判断した場合、当協会はお客様の申し込みを拒否又は解約することがあります。（お客様の虚偽申告・既往症、官公庁・公的機関からの命令・勧告など）（基本約款：第３条及び第４条（４））<br/>
	&nbsp;<br/>
	４．申込済み留学プログラムの変更及び解約の際は、手数料等が発生します。（基本約款：第８条、第９条、第１０条）<br/>
	&nbsp;<br/>
	５．留学先学校の判断により、コース未開講又は、その内容・条件が変更される場合があります。その場合、他キャンパス、他コースへの振替や返金の対応を致します。（基本約款：第１３条（１）（２）<br/>
	&nbsp;<br/>
	６．現地サポートは、国や都市によって内容や条件が異なり、別途費用が発生する場合があります。（基本約款：第４条（３）<br/>
	&nbsp;<br/>
	７．渡航中に発生した問題は、当協会及び各受入機関は、相談及びその問題解決に可能な限りサポートしますが、まずは、お客様との直接関係による解決を試みてください。特にホームステイ先での家庭内のトラブルが多くあります。ホームステイの心得を出発前に確認してください。（基本約款：第４条（５）（９）<br/>
	&nbsp;<br/>
	８．ホームステイや寮等の滞在先を手配する場合、滞在先の場所や設備などの希望をお伺いしますが、あくまでも希望であり、その希望に添えない場合があります。（基本約款：第４条（８））<br/>
	&nbsp;<br/>
	９．当協会から旅行会社、保険会社、クレジットカード会社等を紹介する場合がありますが、必ずの利用をお願いするものではありません。また、当協会が代理店業務を行う場合であっても留学プログラムの契約とは別契約であり、留学プログラムの変更・解約を行った場合でも、それらの契約内容に変更はありません。（基本約款：第１３条）<br/>
	</div>

<script>
function fncCheck()	{
	if (jQuery('#douicheck').get(0).checked)	{
		return confirm('入力内容を送信します。よろしいですか？')
	}else{
		alert('確認にチェックをお願いします。');
	}
	return false;
}
</script>

<form name="form1" method="post" action="./keiyaku.php" onSubmit="return fncCheck();">
	<input type="hidden" name="act" value="send">
	<table style="font-size:10pt;" border="1">

	<tr>
		<td style="text-align:center;">お名前</td>
		<td style="padding:8px 10px 8px 10px;">
			<input type="text" size="20" name="お名前" value="">
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">記入日</td>
		<td style="padding:8px 10px 8px 10px;">
			<input type="text" size="10" name="記入日・年" value="<?php echo date("Y"); ?>">年　
			<input type="text" size="6" name="記入日・月" value="<?php echo date("m"); ?>">月　
			<input type="text" size="6" name="記入日・日" value="<?php echo date("d"); ?>">日
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">ご連絡先</td>
		<td style="padding:8px 10px 8px 10px;">
			電話番号：<br/>
			<input type="text" size="50" name="連絡用・電話番号" value=""><br/>
			メールアドレス：<br/>
			<input type="text" size="50" name="連絡用・メールアドレス" value=""><br/>
		</td>
	</tr>
	<tr>
		<td>その他連絡事項があれば<br/>ご自由にご記入ください</td>
		<td style="padding:8px 10px 8px 10px;">
			<textarea name="連絡事項" cols="68" rows="5"></textarea></br>
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">確認</td>
		<td style="padding:8px 10px 8px 10px;">
			<input type="checkbox" id="douicheck" name="同意確認" value="同意します">&nbsp;<b>私は、留学プログラム基本約款及び、上記の重要事項の内容を十分に理解した上で、留学プログラムの申し込みを行います。</b><br/>
		</td>
	</tr>

	<tr>
		<td colspan="2">
			<p align="right" style="font-size:11pt; margin:15px 0 15px 0;">
				内容を確認の上、送信ボタンをクリックしてください。
			</p>
		</td>
	</tr>

</table>

	<input class="submit" type="submit" value="送信" style="width:150px; height:30px; margin:18px 0 30px 400px; font-size:11pt; font-weight:bold;" />

</form>

</div>

<?php
	}
?>

	</div>


	</div>
  </div>
  </div>
  <div id="footer">

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>

