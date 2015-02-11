<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<?
	require_once '../include/menubar.php';
?>
<head><script src="/A2EB891D63C8/avg_ls_dom.js" type="text/javascript"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>メンバー登録取り消し申請 | 日本ワーキング・ホリデー協会</title>
<meta name="keywords" content="ワーキングホリデー,留学,オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,学生,留学,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館" />
<meta name="description" content="ワーキングホリデー協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデーをされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデービザの取得が可能です。ワーキングホリデービザ以外に学生ビザでの留学などもお手伝い可能です。" />
<meta name="author" content="Japan Association for Working Holiday Makers" />
<meta name="copyright" content="Japan Association for Working Holiday Makers" />

<link rev="made" href="mailto:info@jawhm.or.jp" />
<link rel="Top" href="../index.html" type="text/html" title="ホームページ(最初のページ)" />
<link rel="Index" href="../index3.html" type="text/html" title="索引ページ" />
<link rel="Contents" href="../content.html" type="text/html" title="目次ページ" />
<link rel="Search" href="../search.html" type="text/html" title="検索できるページ" />
<link rel="Glossary" href="../glossar.html" type="text/html" title="用語解説ページ" />
<link rel="Help" href="file://///Landisk-a14f96/smithsonian/80.ワーキングホリデー協会/Info/help.html" type="text/html" title="ヘルプページ" />
<link rel="First" href="sample01.html" type="text/html" title="最初の文書へ " />
<link rel="Prev" href="sample02.html" type="text/html" title="前の文書へ" />
<link rel="Next" href="sample04.html" type="text/html" title="次の文書へ" />
<link rel="Last" href="sample05.html" type="text/html" title="最後の文書へ" />
<link rel="Up" href="../index2.html" type="text/html" title="一つ上の階層へ" />
<link rel="Copyright" href="../copyrig.html" type="text/html" title="著作権についてのページへ" />
<link rel="Author" href="mailto:info@jawhm.or.jp " title="E-mail address" />

<link href="../css/base.css" rel="stylesheet" type="text/css" />
<link href="../css/headhootg-nav.css" rel="stylesheet" type="text/css" />
<link href="../css/contents.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.js"></script>

<? fncMenuScript(); ?>

</head>

<body>

<? fncMenuHead('<img id="top-mainimg" src="../images/top-mainimg.jpg" alt="" width="970" height="170" />','メンバー登録取り消し申請'); ?>

  <div id="contentsbox"><img id="bgtop" src="../images/contents-bgtop.gif" alt="" />
  <div id="contents">

<? fncMenubar(); ?>

	<div id="maincontent">
	  <p id="topicpath"><a href="../index.html">トップ</a>　> メンバー登録取り消し申請 </p>

<?php

	mb_language("Ja");
	mb_internal_encoding("utf8");

	$e = @$_GET['e'];
	$act = @$_POST['act'];

?>


<h2 class="sec-title">メンバー登録取り消し申請</h2>
<div style="padding-left:30px;">


<?
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
	<p style="margin-top:20px;">
		ご入力ありがとうございました。<br/>
		内容を確認の上、担当者よりご連絡申し上げます。<br/>
		３営業日以内に連絡が無い場合は、お手数ですがご一報頂ければと存じます。<br/>
	</p>

<?
	}else{
?>
	<p style="margin:10px 0 6px 0; font-size:10pt; font-weight:bold;">
		メンバー登録の取り消しを申請する場合、以下のフォームにご入力をお願い致します。<br/>
	</p>
	<p style="margin:0px 0 10px 0;">
		※メンバー登録は当協会の各サービス提供前の場合のみ取消可能です。<br/>
		　また、登録料の返金を銀行振込にて行う場合は、振込手数料はお客様負担となります。<br/>
	</p>

<form method="post" action="./kaiyaku.php" onsubmit="return confirm('メンバー登録の取り消しを申請します。よろしいですか？')">
	<input type="hidden" name="act" value="send">
	<table style="font-size:10pt;" border="1">

	<tr>
		<td style="text-align:center;">会員番号</td>
		<td style="padding:8px 10px 8px 10px;">
			<input type="text" size="20" name="会員番号" value="">
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">お名前</td>
		<td style="padding:8px 10px 8px 10px;">
			<input type="text" size="30" name="お名前" value="">
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">生年月日</td>
		<td style="padding:8px 10px 8px 10px;">
			<input type="text" size="10" name="生年月日：年" value="">年　
			<input type="text" size="6" name="生年月日：月" value="">月　
			<input type="text" size="6" name="生年月日：日" value="">日
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">登録電話番号</td>
		<td style="padding:8px 10px 8px 10px;">
			メンバー登録時の電話番号をご入力ください。<br/>
			<input type="text" size="50" name="登録時電話番号" value=""><br/>
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">ご連絡先</td>
		<td style="padding:8px 10px 8px 10px;">
			※　メンバー登録時の電話番号・メールアドレス以外にご連絡を希望する場合にご記入ください。<br/>
			&nbsp;<br/>
			電話番号：<br/>
			<input type="text" size="50" name="連絡用：電話番号" value=""><br/>
			メールアドレス：<br/>
			<input type="text" size="50" name="連絡用：メールアドレス" value=""><br/>
		</td>
	</tr>
	<tr>
		<td style="text-align:center;">返金方法</td>
		<td style="padding:8px 10px 8px 10px;">
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
		<td style="padding:8px 10px 8px 10px;">
			<input type="checkbox" name="取消理由1" value="渡航する予定が無くなった">&nbsp;渡航する予定が無くなった
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="取消理由2" value="間違えてメンバー登録をした">&nbsp;間違えてメンバー登録をした
			<br/>
			<input type="checkbox" name="取消理由3" value="協会のサービスが不要となった">&nbsp;協会のサービスが不要となった
			&nbsp;&nbsp;&nbsp;
			<input type="checkbox" name="取消理由4" value="その他">&nbsp;その他
			<br/>
		</td>
	</tr>
	<tr>
		<td>≪ご意見≫</br>ご自由に<br/>ご記入ください</td>
		<td style="padding:8px 10px 8px 10px;">
			<textarea name="感想" cols="68" rows="5"></textarea></br>
			※今後の協会運営の参考とさせて頂きます。ご自由にご記入下さい。<br/>
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

<?
	}
?>

	</div>


	</div>
  </div>
  </div>
  <div id="footer">

<? fncMenuFooter(); ?>

</body>
</html>

