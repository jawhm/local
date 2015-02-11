<?php
//	ini_set( "display_errors", "On");

	session_start();

	mb_language("Ja");
	mb_internal_encoding("utf8");

	function is_mobile () 
	{
		$useragents = array(
			'iPhone',         // Apple iPhone
			'iPod',           // Apple iPod touch
			'iPad',           // Apple iPad touch
			'Android',        // 1.5+ Android
			'dream',          // Pre 1.5 Android
			'CUPCAKE',        // 1.5+ Android
			'blackberry9500', // Storm
			'blackberry9530', // Storm
			'blackberry9520', // Storm v2
			'blackberry9550', // Storm v2
			'blackberry9800', // Torch
			'webOS',          // Palm Pre Experimental
			'incognito',      // Other iPhone browser
			'webmate'         // Other iPhone browser
		);
		
		$pattern = '/'.implode('|', $useragents).'/i';
		return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
	}



include '../seminar_module/seminar_module.php';

// 場所(tokyo,osaka,nagoya,fukuoka)
$p = @$_GET['p'];
if ($p == '')	{	$p = @$_SESSION['fair_p'];	}
if ($p == '')	{	$p = 'tokyo';			}
$_SESSION['fair_p'] = $p;

// 種類(first,school,taiken)
$s = @$_GET['s'];
//if ($s == '')	{	$s = @$_SESSION['fair_s'];	}
if ($s == '')	{	$s = 'all';			}
$_SESSION['fair_s'] = $s;

$sword = '';
switch($s)	{
	case 'first':
		$sword = '初心者向け';
		break;
	case 'school':
		$sword = 'の語学学校';
		break;
	case 'taiken':
		$sword = '体験談セミナー';
		break;
}

$config = array(
	'view_mode' => 'calendar',
	'seminar_id' => '',
	'start_date' => '2014-06-01',
	'end_date' => '2014-06-30',
	'calendar' => array(
		'title' => array(
			'春のワーホリ・留学フェア2014', $sword
		),
		'use_area' => 'off',
		'place_list' => array($p),
		'place_default' => $p,
		'place_active' => '',
		'country_active' => '',
		'know_active' => '',
		'calendar_icon_active' => '',
		'count_field_active' => '',
		'calendar_title_active' => '',
		'calendar_desc_active' => '',
		'footer_desc_active' => '',
	)
);

$sm = new SeminarModule($config);


	require_once '../include/menubar.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>日本ワーキング・ホリデー協会　春のワーキングホリデー＆留学フェア2014 -</title>
<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon" />
<meta name="keywords" content="オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館," />
<meta name="description" content="オーストラリア・ニュージーランド・カナダを初めとしたワーキングホリデー協定国の最新のビザ取得方法や渡航情報などを発信しています。" />
<meta name="author" content="Japan Association for Working Holiday Makers" />
<meta name="copyright" content="Japan Association for Working Holiday Makers" />
<link rev="made" href="mailto:info@jawhm.or.jp" />
<link rel="Top" href="index.html" type="text/html" title="一般社団法人 日本ワーキング・ホリデー協会" />

<link rel="Author" href="mailto:info@jawhm.or.jp" title="E-mail address" />

<link href="../css/headhootg-nav.css" rel="stylesheet" type="text/css" />
<link href="css/base.css" rel="stylesheet" type="text/css" />
<link href="css/contents_wide.css" rel="stylesheet" type="text/css" />
<link href="css/menu.css" rel="stylesheet" type="text/css" />
<link href="css/button.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-easing.js"></script>
<script type="text/javascript" src="../js/scroll.js"></script>
<script type="text/javascript" src="../js/linkboxes.js"></script>
<script type="text/javascript" src="../js/jquery.blockUI.js"></script>
<script type="text/javascript" src="../js/fixedui/fixedUI.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.tipTip.minified.js"></script>
<script type="text/javascript" src="js/fitiframe.js?auto=0"></script>
<script type="text/javascript" src="/js/img-rollover.js">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
<link href="css/flexslider.css" rel="stylesheet" type="text/css" />

<?php
	echo ($sm->get_add_js());
	echo ($sm->get_add_css());
	echo ($sm->get_add_style());

?>

<script type="text/javascript">
$("document").ready(function(){
    $('.flexslider').flexslider({
controlNav: false,
slideshowSpeed : 4000
});
});
</script>



<link href="css/tipTip.css" rel="stylesheet" type="text/css" />

<!--[if lte IE 8 ]>
    <link rel="stylesheet" href="../css/style_ie.css" />
<![endif]-->

<link type="text/css" href="../css/jquery-ui-1.8.16.custom.css" rel="stylesheet" />';


<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20563699-1']);
  _gaq.push(['_setDomainName', '.jawhm.or.jp']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!--Make sure your page contains a valid doctype at the very top-->
<link rel="stylesheet" type="text/css" href="css/haccordion.css" />

<script type="text/javascript" src="js/haccordion.js">
/***********************************************
* Horizontal Accordion script- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
***********************************************/

</script><style type="text/css">

/*CSS for example Accordion #hc1*/

#hc1 li{
margin:0 3px 0 0; /*Spacing between each LI container*/
}

#hc1 li .hpanel{
padding: 5px; /*Padding inside each content*/
background:#8bdc13;
}

/*CSS for example Accordion #hc2*/

#hc2 li{
margin:0 0 0 0; /*Spacing between each LI container*/
border: 12px solid black;
}

#hc2 li .hpanel{
padding: 5px; /*Padding inside each content*/
background: #8bdc13;
cursor: hand;
cursor: pointer;
}
</style>
<style>
.fbox {
    position: relative;
    display:inline-block;
    text-align:center;
    background-color:#efffc5;
    margin: 2px 5px 22px 22px;
    padding: 26px 20px 32px 20px;
    border-radius: 5px ;
}
.fbox:after, .fbox:before {
    content: "";
    position: absolute;
    height: 0;
    width: 0;
}
.fbox:after {
    top: 98%;
    left: 680px;
    border: 40px solid transparent;
    border-top: 40px solid #efffc5; /*10px*/
}
.fbox:before {
    top: 100%;
    left: 680px;
    border: 40px solid transparent;
    border-top: 43px solid #ffffff; /*13px*/
}
</style>

<script>
jQuery(function($) {
  
var nav    = $('#fixedbox'),
    offset = nav.offset();
  
$(window).scroll(function () {
  if($(window).scrollTop() > offset.top) {
    nav.addClass('fixed');
  } else {
    nav.removeClass('fixed');
  }
});
  
});
</script>
<style>
.fixed {
    position: fixed;
    top: 50px;
    width: 878px;
    z-index: 10000;
	background-color:white;
	height:28px;
}
.navi	{
	margin:-52px -20px 0px -20px;
	padding: 58px 6px 0px 6px;

}
</style>

</head>
<body>

<script type="text/javascript" src="../js/wz_tooltip.js"></script>

<div id="header">
	<font color="#ffffff">春のワーキングホリデー＆留学フェア2014</font><br/>
    <h1><a href="http://www.jawhm.or.jp/index.html"><img src="http://www.jawhm.or.jp/images/h1-logo.jpg" alt="一般社団法人日本ワーキング・ホリデー協会" width="410" height="33" /></a></h1>
</div>
  <div id="contentsbox"><img id="bgtop" src="images/top.gif" alt="" />
  <div id="contents">

	<div id="maincontent" style="margin-left:30px;">
	<div id="top-main" style="width:300px;margin-bottom:20px;">

		<div class="top-entry01" style="width:900px;">
			
<div class="top-entry0">


<div class="flexslider" id="top">
   <ul class="slides">
       <li>
       <img src="images/top/2.jpg" />
    </li>
    <li>
       <img src="images/top/1.jpg" />
    </li>

    </ul>
</div>


<div id="fixedbox" class="navi">
	<ul id="menu">
	  <li><a href="./">留学&ワーホリフェアって?</a></li>
	  <li><a href="./schedule.php">ご予約・スケジュール</a></li>
	  <li><a href="./school.php">参加学校</a></li>
	  <li><a href="./qanda.php">よくある質問</a></li>
	  <li><a href="./voice.php">参加者の声</a></li>
	</ul>
</div>

&nbsp;<br/>

<a name="schedule"></a>
<h3> <img width="25" src="images/title/2_icon.png">　ご予約・スケジュール</h3>

<br/>

<?
	if (is_mobile())	{
?>
	<div style="border: 2px dotted navy; margin: 20px 0 10px 0; padding: 5px 10px 5px 10px; font-size:20pt;">
		スマートフォンでご覧頂いていますか？<br/>
		このページは、一部正しく機能しない場合があります。<br/>
		<a href="http://www.jawhm.or.jp/seminar/ser">無料セミナーが探せて、予約できるスマートフォン専用ページ</a>がございます。<br/>
		是非、ご利用ください。<br/>
	</div>
<?	}	?>


<?php
	$b_size = array(
			'tokyo' => '16%',
			'osaka' => '16%',
			'nagoya' => '16%',
			'fukuoka' => '16%',
			'all' => '16%',
			'first' => '16%',
			'school' => '16%',
			'taiken' => '16%',
		);
	$b_size[$p] = '22%';
	$b_size[$s] = '22%';

	switch($p)	{
		case 'tokyo':
			$kaijo = '東京会場';
			break;
		case 'osaka':
			$kaijo = '大阪会場';
			break;
		case 'nagoya':
			$kaijo = '名古屋会場';
			break;
		case 'fukuoka':
			$kaijo = '福岡会場';
			break;
	}
	switch($s)	{
		case 'first':
			$joken = './images/category/syoshin.png';
			break;
		case 'school':
			$joken = './images/category/school.png';
			break;
		case 'taiken':
			$joken = './images/category/taikendan.png';
			break;
		default:
			$joken = './images/category/all.png';
			break;
	}
?>

<a name="seminar"></a>
<div class="fbox">
	<p style="width:96%; text-align:left; font-size:12pt; background-color:#ffa500; color:white; padding-left:20px; "><strong>■　お近くの会場をクリックしてください。</p></strong>
	<A href="./schedule.php?p=tokyo&s=<?php echo (@$_SESSION['fair_s']); ?>#schedule"><img src="images/tokyo_off.png" width="<?php echo $b_size['tokyo']; ?>" /></A>
	<A href="./schedule.php?p=osaka&s=<?php echo (@$_SESSION['fair_s']); ?>#schedule"><img src="images/osaka_off.png" width="<?php echo $b_size['osaka']; ?>"/></A>
	<A href="./schedule.php?p=nagoya&s=<?php echo (@$_SESSION['fair_s']); ?>#schedule"><img src="images/nagoya_off.png" width="<?php echo $b_size['nagoya']; ?>"/></A>
	<A href="./schedule.php?p=fukuoka&s=<?php echo (@$_SESSION['fair_s']); ?>#schedule"><img src="images/fukuoka_off.png" width="<?php echo $b_size['fukuoka']; ?>"/></A>
&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>
	<p style="width:96%; text-align:left; font-size:12pt; background-color:#ffa500; color:white; padding-left:20px; "><strong>■　お好みのセミナーをクリックしてください。</p></strong>
	<a href="./schedule.php?s=first#schedule"><img src="images/category/syoshin_off.png" width="<?php echo $b_size['first']; ?>"></a>
	<a href="./schedule.php?s=school#schedule"><img src="images/category/school_off.png" width="<?php echo $b_size['school']; ?>"></a>
	<a href="./schedule.php?s=taiken#schedule"><img src="images/category/taikendan_off.png" width="<?php echo $b_size['taiken']; ?>"></a>
	<a href="./schedule.php?s=all#schedule"><img src="images/category/all_off.png" width="<?php echo $b_size['all']; ?>"></a>
</div>

<br/>

<div id="place-date-seminar" class="<?php echo $p; ?>">
	<div style="float:left;">
		<?php echo $kaijo; ?>
	</div>
	<div style="width:730px; text-align:right; font-size:70%;padding-top:25px;">
		<?php echo '<img src="'.$joken.'" style="vertical-align:middle;"> を表示しています'; ?>
	</div>
</div>


<?php

	// カレンダー表示
	$isView = $sm->show();

?>


&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>

<div align="right"><a href="#top"><img src="images/pagetop_off.png" /></a></div>
&nbsp;<br/>
<div style="height:55px;">&nbsp;</div>

<A href="javascript:w=window.open('bamukun.html','','scrollbars=yes,Width=800,Height=700');w.focus();"><img src="images/bakukun_off.png" style="margin-left:70%; margin-top: -80px;"></a>
	</div>
	</div>
	

  </div>
  
	</div>
		
    	<center><img src="images/back.png" style=" margin-top: -39px; margin-left:-10px;"></center>

	
  </div>

  </div>

  </div>


<?php fncMenuFooter(); ?>


</body>
</html>