<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='留学プログラム申込約款・同意書ダウンロード';
$header_obj->description_page='ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->full_link_tag=true;
$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/top-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '留学プログラム申込約款・同意書ダウンロード';

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


<h2 class="sec-title">留学プログラム申込約款・同意書ダウンロード</h2>
<div style="padding-left:30px;">


	<p style="margin:10px 0 6px 0; font-size:10pt; font-weight:bold;">
		以下から、必要な書類をダウンロードしてください。
	</p>
	<p style="margin:0px 0 10px 0;">
		※各書類の表示には、Adobe Readerプラグイン（無料）が必要です。<br/>最新版のAdobe Readerはアドビシステムズ社よりダウンロードが可能です。<br/>
		<a href="http://get.adobe.com/jp/reader/" target="_blank">Adobe Reader（ダウンロードサイトへ）</a>
	</p>

	<div style="margin:20px 20px 10px 0px; padding:10px 20px 10px 20px; font-size:11pt; background-color:#90EE90;">
		<a target="_blank" href="./kihon_yakkan.pdf">留学プログラム基本約款 (PDF)</a>
	</div>

	<div style="margin:20px 20px 10px 0px; padding:10px 20px 10px 20px; font-size:11pt; background-color:#90EE90;">
		<a target="_blank" href="./douisho.pdf">留学プログラム申込の重要事項確認及び同意書 (PDF)</a>
	</div>

	<p style="margin:30px 0 10px 0;">
		※各書類をダウンロードする場合は、リンクを右クリックし「名前を付けてリンク先を保存」を選択してください。<br/>
		詳細は、ご利用中のブラウザの取扱説明書をご確認ください。<br/>
	</p>


</div>


	</div>
  </div>
  </div>
  <div id="footer">

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>

