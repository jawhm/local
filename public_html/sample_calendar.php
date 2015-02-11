<?php

session_start();

include './seminar_module/seminar_module.php';

$config = array(
	'view_mode' => 'calendar',
	'seminar_id' => '',
	//'start_date' => '2014-01-01',
	//'end_date' => '2014-12-31',
	'calendar' => array(
		'use_area' => 'on',
		'place_list' => array('tokyo','osaka'),
		'place_default' => 'tokyo',
		'country_list' => array(
			array(
				'id' => 'all',
				'name' => '全て',
				'option' => 'single',
				'default' => 'off',
			),
			array(
				'id' => 'aus',
				'name' => 'オーストラリア',
				'word1' => array('オーストラリア','オージー'),
				'word2' => array('AUS','AUS2'),
				'default' => 'off',
			),
			array(
				'id' => 'eigo',
				'name' => '英語圏',
				'word1' => array('オーストラリア','カナダ','イギリス'),
				'default' => 'on',
			),
			array(
				'id' => 'uk',
				'active' => 'off'
			),
			array(
				'id' => 'can',
				'active' => 'off'
			),
			array(
				'id' => 'fra',
				'active' => 'off',
			),
			array(
				'id' => 'test',
				'name' => 'テストボタン',
				'word1' => array('日本'),
				'active' => 'on',
			)
		),
		'know_list' => array(
			array(
				'id' => 'first',
				'name' => '初心者',
				'word1' => array('初心者向けセミナー'),
			),
			array(
				'id' => 'motmot',
				'name' => 'もっともっとセミナー',
				'word1' => array('懇談セミナー','体験談セミナー'),
				'word2' => array('2014fair','taikendan'),
			),
			array(
				'id' => 'all',
				'name' => '全て',
				'option' => 'single',
				'default' => 'on',
			),
		),
	)
);

$sm = new SeminarModule($config);
$redirection='/seminar/ser/';

require_once 'include/header.php';
$header_obj = new Header();
$header_obj->fncFacebookMeta_function=true;
$header_obj->mobileredirect=$redirection;
$header_obj->title_page='カレンダー';
$header_obj->description_page='ワーキングホリデー（ワーホリ）や留学をされる方向けの無料セミナー等のご案内をしています。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
$header_obj->add_css_files = $sm->get_add_css();
$header_obj->add_style = $sm->get_add_style();
$header_obj->add_js_files = $sm->get_add_js();
$header_obj->size_content_page='big';
$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="images/mainimg/event-mainimg.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '日本ワーキングホリデー協会のイベントカレンダー';
$header_obj->display_header();
?>
<div id="maincontent">
	<?php echo $header_obj->breadcrumbs(); ?>
	<p style="margin: 0 0 8px 10px; font-size:11pt;">
		参加したいセミナーの検索条件を指定してください。 <br />
		<br />
	</p>
	<?php $isView = $sm->show();
	echo '<pre>';
	var_dump($isView);
	echo '</pre>';
	exit;
	?>
</div>
</div>
</div>
<?php fncMenuFooter($header_obj->footer_type); ?>
</body>
</html>