<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='留学プログログラム変更・解約依頼';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->full_link_tag=true;
$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '留学プログログラム変更・解約依頼';

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


<h2 class="sec-title">留学プログログラム変更・解約依頼</h2>
<div style="padding-left:30px;">


<?php
	if ($act == 'send')	{

		$fname = $_POST['お名前'];
		$fmail = $_POST['連絡用・メールアドレス'];

		$vmail = 'toiawase@jawhm.or.jp,sodan@jawhm.or.jp,sodan-osaka@jawhm.or.jp,sodan-nagoya@jawhm.or.jp';
		$subject = "留学プログログラム変更・解約依頼　".$fname."様";

		$body  = '';
		$body .= '[留学プログログラム変更・解約依頼]';
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
		申込済み留学プログラムの変更又は解約を希望の場合、以下のフォームにご入力お願い致します。<br/>
	</p>
<!--
	<p style="margin:0px 0 10px 0;">
		※メンバー登録は当協会の各サービス提供前の場合のみ取消可能です。<br/>
		　また、登録料の返金を銀行振込にて行う場合は、振込手数料はお客様負担となります。<br/>
	</p>
-->

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

<form name="form1" method="post" action="./henkou.php" onSubmit="return fncCheck();">
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
		<td style="text-align:center;">変更・解約の内容</td>
		<td style="padding:8px 10px 8px 10px;">
			変更・解約の内容を選択し、詳細を入力してください。<br/>
			&nbsp;<br/>
			<input type="radio" name="変更解約内容" value="入学日変更">&nbsp;入学日を変更したい<br/>
			<input type="text" size="20" name="入学日変更・変更前" value="">&nbsp;から
			<input type="text" size="20" name="入学日変更・変更後" value="">&nbsp;に変更する<br/>
			&nbsp;<br/>
			<hr/>
			&nbsp;<br/>
			<input type="radio" name="変更解約内容" value="留学プログラム変更">&nbsp;留学プログラム（学校、コース等）を変更したい<br/>
			現在の内容：<br/>
			<textarea name="留学プログラム変更・変更前" cols="68" rows="2"></textarea></br>
			新しいの内容：<br/>
			<textarea name="留学プログラム変更・変更後" cols="68" rows="2"></textarea></br>

			&nbsp;<br/>
			<hr/>
			&nbsp;<br/>
			<input type="radio" name="変更解約内容" value="留学プログラム一部解約">&nbsp;留学プログラムの一部を解約したい<br/>
			一部解約する内容：<br/>
			<textarea name="留学プログラム一部解約内容" cols="68" rows="2"></textarea></br>

			&nbsp;<br/>
			<hr/>
			&nbsp;<br/>
			<input type="radio" name="変更解約内容" value="留学プログラム全部解約">&nbsp;留学プログラムの全てを解約したい<br/>
			解約の理由：<br/>
			<textarea name="留学プログラム全部解約理由" cols="68" rows="2"></textarea></br>

			&nbsp;<br/>
			<hr/>
			&nbsp;<br/>
			<input type="radio" name="変更解約内容" value="その他">&nbsp;その他<br/>
			内容を具体的にご記入ください：<br/>
			<textarea name="その他の変更・解約依頼内容" cols="68" rows="3"></textarea></br>

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
			<input type="checkbox" id="douicheck" name="同意確認" value="同意します">&nbsp;<b>私は、上記の通り申込済み留学プログラムの変更又は解約を希望します。<br/>
			また、この依頼に伴い、変更又は解約手数料が発生する場合があることを理解しています。</b>
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

