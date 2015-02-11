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
if ($s == '')	{	$s = @$_SESSION['fair_s'];	}
if ($s == '')	{	$s = '';			}
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
	'start_date' => '2014-04-20',
	'end_date' => '2014-06-14',
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

<h3 id="fair"> <img width="25" src="images/title/1_icon.png">　留学&ワーホリフェアって?</h3>
&nbsp;<br/>
&nbsp;<br/>
<center>
<div style="width: 33%; float: left;"> 

<p　style="position: relative;">
	<span style="position: absolute; margin: -35px 0px 0px 10px;">
	<a href="./schedule.php?s=first#schedule" id="button">ワーホリ&留学を知ろう! ▶︎︎</a>
	</span>
	<img src="images/seminar/1.png">
</p>

		<p class="seminar">初心者向けセミナー</p>
		<p style="margin-top: -10px;">
		▶︎ 一度にワーホリ&留学の基本がわかる<br/>
		▶︎ ビザ〜準備まで全ての疑問不安を解決!<br/>
		▶︎ 当協会カウンセラーがわかりやすくご説明<br/>
</p>
</div>

<div style="width: 33%; float: left;"> 

<p　style="position: relative;">
	<span style="position: absolute; margin: -35px 0px 0px 10px;">
	<a href="./schedule.php?s=school#schedule" id="button">語学学校スタッフと相談 ▶︎︎</a>
	</span>
	<img src="images/seminar/2.png">
</p>

<p class="seminar">語学学校セミナー</p>
	<p style="margin-top: -10px;">
		▶︎ 語学学校による春フェアだけの特別セミナー<br/>
		▶︎ 来日中の学校スタッフと直接話して疑問解決!<br/>
		▶︎ 渡航費用が安くなる!?特典&即日お申し込みも<br/><br/>
	</p>
</div>

<div style="width: 33%; float: left;"> 

<p　style="position: relative;">
	<span style="position: absolute; margin: -35px 0px 0px 10px;">
	<a href="./schedule.php?s=taiken#schedule" id="button">体験談からプラン作成 ▶︎︎</a>
	</span>
	<img src="images/seminar/3.png">
</p>

		<p class="seminar">帰国者体験談</p>
		<p style="margin-top: -10px;">
		▶︎ 経験者だからお話しできる現地の生の声<br/>
		▶︎ よかったことはもちろん失敗したことまで<br/>渡航前の皆さんのタメになる内容です<br/><br/>
		</p>
</div>
</center>
<br clear="both" />
&nbsp;<br/>
<p>
	<big>
	カナダ・オーストラリア・イギリスなどなど、様々な国の語学学校がワーホリ協会に集結し、ワーホリ＆留学に役立つ情報を皆様にお届けします。
	ワーホリ＆留学の学校で悩まれている方はもちろん、まだ漠然と「海外に行きたい！」と考えている人も、
	パンフレットやウェブサイトでは得られない生の情報を入手できるこの機会を、ぜひぜひご活用ください！
	</big>
</p>
&nbsp;<br/>

&nbsp;<br/>
<center>
	<a href="./schedule.php#schedule" id="button_wide">フェアスケジュール＆ご予約はこちら　▶▶︎︎</a>
</center>

<div class="arrow_box">


	   <br />
	   <p class="seminar">セミナー後には一人一人とカウンセリング</p>
	    <p>
	   フェアセミナー後には、カウンセリングブースにご案内致します。<br />
		少人数の懇談形式となるため、質問やご相談がお気軽に可能です。<br />
<br />
		語学学校の現地スタッフの方は今回のフェアの為に来日! 直接お話できる滅多に無い機会です。 <br />学校に行く事が決まっている方はもちろん、少しでも興味のある方は是非この機会にお越し下さい。<br />
		そして、当協会カウンセラーは全員ワーキングホリデー、留学経験者です。<br />
		お客様が有意義な海外生活をおくれるよう一人一人のプランをご提案させて頂きます。<br />
<br />
		<small>※ 少人数形式のため、ご案内に少々お時間を頂く場合がございます。<br />
		※ 会場・当日のスケジュールによりブース形態等が変わります。セミナー後ご案内させて頂きます。<br /></small>
   </p>
   <p>
	   <img src="images/seminar/counseling.png" style="float: right; margin-top: -165px;">
   </p>
   
</div>
<br clear="both">


&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>

<div align="right"><a href="#top"><img src="images/pagetop_off.png" /></a></div>
&nbsp;<br/>

<a href="./schedule.php#schedule" id="button_wide2">全フェアスケジュール＆ご予約はこちら▶▶︎︎</a><A href="javascript:w=window.open('bamukun.html','','scrollbars=yes,Width=800,Height=700');w.focus();"><img src="images/bakukun_off.png" style="margin-left:70%; margin-top: -80px;"></a>
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