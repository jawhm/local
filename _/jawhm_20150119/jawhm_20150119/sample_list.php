<?php

session_start();

include './seminar_module/seminar_module.php';
$config1 = array(
	'view_mode' => 'list',
	'seminar_id' => array('6070', '7180', '6947', '6195', '2014'),
	'list' => array(
		//'past_view' => 'on',
		'count_field_active' => '',
	)
);
$sm1 = new SeminarModule($config1);
$redirection='/seminar/ser/place/event/';

require_once 'include/header.php';
$header_obj = new Header();
$header_obj->fncFacebookMeta_function=true;
//$header_obj->mobileredirect=$redirection;
$header_obj->title_page='イベントカレンダー';
$header_obj->description_page='ワーキングホリデー（ワーホリ）や留学をされる方向けの無料セミナー等のご案内をしています。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
$header_obj->add_css_files = $sm1->get_add_css();
$header_obj->add_style = $sm1->get_add_style();
$header_obj->add_js_files = $sm1->get_add_js();
//$header_obj->size_content_page='big';
$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="images/mainimg/event-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '日本ワーキングホリデー協会のイベントカレンダー';
$header_obj->display_header();
?>
<div id="maincontent">
	<?php echo $header_obj->breadcrumbs(); ?>
	<p style="margin-top: 30px;">
		ここからセミナー予約できます。
	</p>
	<div style="margin:20px 0 0 0 ;" id="semi_show1">
		<?php $count = $sm1->show(6195); ?>
	</div>
	<p>間に自由にテキストを挿入できます。</p>
	<div style="margin:20px 0 0 0 ;" id="semi_show2">
		<?php $count += $sm1->show(6070); ?>
	</div>
	<p>間に自由にテキストを挿入できます。</p>
	<div style="margin:20px 0 0 0 ;" id="semi_show3">
		<?php $count += $sm1->show(7180); ?>
	</div>
	<p>間に自由にテキストを挿入できます。</p>
	<div style="margin:20px 0 0 0 ;" id="semi_show4">
		<?php $count += $sm1->show(6947); ?>
	</div>
	<p>間に自由にテキストを挿入できます。</p>
	<div style="margin:20px 0 0 0 ;" id="semi_show5">
		<?php $count += $sm1->show(2014); ?>
	</div>
	<?php
	/*
	?>
	<hr><hr><hr><hr>
	<div style="margin:20px 0 0 0 ;" id="semi_show2">
		<?php $sm1->show(6947); ?>
	</div>
	<hr><hr><hr><hr>
	<div style="margin:20px 0 0 0 ;" id="semi_show3">
		<?php $sm1->show(6195); ?>
	</div>
	*/
	?>
</div>
</div>
</div>
<?php fncMenuFooter($header_obj->footer_type); ?>
</body>
</html>