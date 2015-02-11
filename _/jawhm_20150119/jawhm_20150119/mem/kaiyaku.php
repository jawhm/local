<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='メンバー登録取り消し申請';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->full_link_tag=true;
$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'メンバー登録取り消し申請';

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


<h2 class="sec-title">メンバー登録取り消し申請</h2>
<div style="float:none;">


<?php
	if ($act == 'send')	{

		$vmail = 'toiawase@jawhm.or.jp';
		$subject = "メンバー登録取り消し申請";

		$body  = '';
		$body .= '[メンバー登録取り消し申請]';
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
		$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
		mb_send_mail($vmail,$subject,$body,"From:".$from);


?>
	<p  class="text01">
		ご入力ありがとうございました。<br/>
		内容を確認の上、担当者よりご連絡申し上げます。<br/>
		３営業日以内に連絡が無い場合は、お手数ですがご一報頂ければと存じます。<br/>
	</p>

<?php
	}else{
?>
	<p class="text01">
		<strong>メンバー登録の取り消しを申請する場合、以下のフォームにご入力をお願い致します。</strong><br/>
	</p>
	<p class="text01">
		※メンバー登録は当協会の各サービス提供前の場合のみ取消可能です。<br/>
		　また、登録料の返金を銀行振込にて行う場合は、振込手数料はお客様負担となります。<br/>
	</p>

<form method="post" action="./kaiyaku.php" onSubmit="return confirm('メンバー登録の取り消しを申請します。よろしいですか？')">
	<input type="hidden" name="act" value="send">
	<table id="kaiyaku" style="font-size:10pt;" border="1">

	<tr>
		<td style="text-align:center;" id="membership-num">会員番号</td>
		<td>
			<input type="text" name="会員番号" value="">
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">お名前</td>
		<td >
			<input type="text" size="30" name="お名前" value="">
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">生年月日</td>
		<td>
			<input type="text" size="10" name="生年月日：年" value="">年　
			<input type="text" size="6"  name="生年月日：月" value="">月　
			<input type="text" size="6"  name="生年月日：日" value="">日
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">登録電話番号</td>
		<td>
			メンバー登録時の電話番号をご入力ください。<br/>
			<input type="text" size="30" name="登録時電話番号" value=""><br/>
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">ご連絡先</td>
		<td>
			※　メンバー登録時の電話番号 ・ メールアドレス以外にご連絡を希望する場合にご記入ください。<br />
			&nbsp;<br/>
			電話番号：<br/>
			<input type="text" size="30" name="連絡用：電話番号" value=""><br/>
			メールアドレス：<br/>
			<input type="text" size="30" name="連絡用：メールアドレス" value=""><br/>
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">返金方法</td>
		<td>
			メンバー登録料の返金方法をお選びください。<br/>
			&nbsp;<br/>
			<input type="radio" name="返金方法" value="クレジットカード">&nbsp;クレジットカード<br/>
			　※　メンバー登録料をクレジットカードにてお支払頂いた場合のみお選び頂けます。<br/>
			&nbsp;<br/>
			<input type="radio" name="返金方法" value="銀行振込">&nbsp;銀行振込<br/>
			　※　振込手数料はお客様のご負担となります。<br/>
			　　　返金振込先は別途ご指示頂きますので、当協会からの連絡をお待ちください。<br/>
		</td>
	</tr>

	<tr>
		<td style="text-align:center;">取消理由</td>
		<td>
			<input type="checkbox" name="取消理由1" value="渡航する予定が無くなった">&nbsp;渡航する予定が無くなった<br />
			<input type="checkbox" name="取消理由2" value="間違えてメンバー登録をした">&nbsp;間違えてメンバー登録をした<br/>
			<input type="checkbox" name="取消理由3" value="協会のサービスが不要となった">&nbsp;協会のサービスが不要となった<br/>
			<input type="checkbox" name="取消理由4" value="その他">&nbsp;その他
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">≪ご意見≫<br />ご自由に<br/>ご記入ください</td>
		<td>
			<textarea name="感想" cols="30" rows="5"></textarea><br />
			※今後の協会運営の参考とさせて頂きます。ご自由にご記入下さい。<br/>
		</td>
	</tr>

	<tr>
		<td colspan="2" align="right">
				内容を確認の上、送信ボタンをクリックしてください。
		</td>
	</tr>

</table>
	<div style="text-align:right;">
	<input class="submit" type="submit" value="送信" style="width:150px; height:30px; margin:18px 30px 30px 0; font-size:11pt; font-weight:bold;" />
    </div>
</form>

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

