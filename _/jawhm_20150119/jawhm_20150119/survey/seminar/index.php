<?php
require_once '../../include/header.php';

$header_obj = new Header();

$header_obj->title_page='ワーキングホリデー＆留学　パッケージプラン紹介';
$header_obj->description_page='ワーキングホリデー（ワーホリ）や留学中の、語学学校のプランをご紹介します。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/package_mainimage.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'ワーキングホリデー＆留学　パッケージプラン紹介';

$header_obj->display_header();

include('../calendar_module/mod_event_horizontal.php');
?>	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs(); ?>
	  <h2 class="sec-title">ご希望のセミナーが無い場合は、あなたが理想とするセミナーをリクエストしてください。</h2>
		<iframe src="https://docs.google.com/forms/d/1In75SuOXPk4tkUDRHV9oZtlrz21WmACnQPEhAVtpKXI/viewform?embedded=true" width="100%" height="1000px" frameborder="0" marginheight="0" marginwidth="0" scrolling="yes">読み込み中...</iframe>
	</div>
	  

  </div>
  </div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>