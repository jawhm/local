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

include '../../seminar_module/seminar_module.php';

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
	'seminar_id' => array('8695','8696','8697','8690','8691','8692','8693','8694','8700','8698','8699','8701','8709','8710','8711','8712','8715','8713','8714','8707','8704','8394','8705','8358','8706'),
	'start_date' => '2014-06-22',
	'end_date' => '2014-8-17',
	'calendar' => array(
		//'title' => array(
		//	'日本全国留学・ワーキングホリデーセミナー', $sword
		//),
		'use_area' => 'off',
		//'place_list' => array($p),
		//'place_default' => $p,
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


	require_once '../../include/menubar.php';

require_once '../../include/header.php';

$header_obj = new Header();



$header_obj->title_page='日本全国留学・ワーキングホリデーセミナー2014';

$header_obj->keywords_page='ワーキングホリデー,仙台,福島,大宮,横浜,京都,神戸,広島,香川,留学,オーストラリア,ニュージーランド,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,学生,留学,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館';

$header_obj->description_page='今年もやります、日本全国ワーキングホリデー（ワーホリ）・留学セミナー。仙台・福島・大宮・横浜・京都・神戸・広島・香川〜etc ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';




$header_obj->add_style='<style>

.panel{

	cursor: pointer;

	position:relative;

	background-color:orange;

	filter: alpha(opacity=0);

	  -moz-opacity:0;

	  opacity:0;

}

.chiiki	{

	float: left;

	cursor: pointer;

	width: 80px;

	height: 30px;

	text-align: center;

	vertical-align: middle;

	font-size: 12pt;

	color: white;

	margin: 0 5px 5px 0;

}

.chiiki2	{

	float: left;

	cursor: pointer;

	width: 0px;

	height: 0px;

	text-align: center;

	vertical-align: middle;

	font-size: 12pt;

	color: white;

	margin: 0 5px 5px 0;

}

</style>';

$header_obj->add_js_files='<script type="text/javascript" src="/js/jquery.blockUI.js"></script>

<script type="text/javascript" src="/js/jquery.corner.js"></script>

<script type="text/javascript" src="sp.js"></script>

<script>

$(function () {

	$(".chiiki").corner();

	// イベント設定

	var obj = document.getElementsByTagName("div");

	for (idx=0; idx<obj.length; idx++)	{

		if (obj[idx].className == "panel")	{

			obj[idx].onmouseover = fncover;

			obj[idx].onmouseout = fncout;

			obj[idx].onclick = fncclick;

		}

		if (obj[idx].className == "chiiki")	{

			obj[idx].onclick = fncclick;

		}

		if (obj[idx].className == "chiiki2")	{

			obj[idx].onclick = fncclick;

		}

	}

});

function fncover()	{

	var id = this.getAttribute("id");

	jQuery("#"+id).css({ opacity: "0.4" });

}

function fncout()	{

	var id = this.getAttribute("id");

	jQuery("#"+id).css({ opacity: "0" });

}

function fncclick()	{

	var id = this.getAttribute("id");

	location.href = "./?key="+id+"#yoyaku";

}

function fnc_yoyaku(obj)	{

	document.getElementById("btn_soushin").disabled = false;

	document.getElementById("btn_soushin").value = "送信";

	document.getElementById("div_wait").style.display = "none";

	document.getElementById("form_title").innerHTML = obj.getAttribute("title");

	document.getElementById("txt_title").value = obj.getAttribute("title");

	document.getElementById("txt_id").value = obj.getAttribute("uid");

	$.blockUI({ message: $("#yoyakuform"),

	css: { 

		top:  ($(window).height() - 400) /2 + "px", 

		left: ($(window).width() - 600) /2 + "px", 

		width: "600px" 

	}

 }); 

}

function btn_cancel()	{

	$.unblockUI();

}

function btn_submit()	{

	obj = document.getElementById("txt_name");

	if (obj.value == "")	{

		alert("お名前（氏）を入力してください。");

		obj.focus();

		return false;

	}

	obj = document.getElementById("txt_name2");

	if (obj.value == "")	{

		alert("お名前（名）を入力してください。");

		obj.focus();

		return false;

	}

	obj = document.getElementById("txt_furigana");

	if (obj.value == "")	{

		alert("フリガナ（氏）を入力してください。");

		obj.focus();

		return false;

	}

	obj = document.getElementById("txt_furigana2");

	if (obj.value == "")	{

		alert("フリガナ（名）を入力してください。");

		obj.focus();

		return false;

	}

	obj = document.getElementById("txt_mail");

	if (obj.value == "")	{

		alert("メールアドレスを入力してください。");

		obj.focus();

		return false;

	}

	obj = document.getElementById("txt_tel");

	if (obj.value == "")	{

		alert("電話番号を入力してください。");

		obj.focus();

		return false;

	}



	if (!confirm("ご入力頂いた内容を送信します。よろしいですか？"))	{

		return false;

	}



	$senddata = $("form").serialize();



	document.getElementById("div_wait").style.display = "";



	document.getElementById("btn_soushin").value = "処理中...";

	document.getElementById("btn_soushin").disabled = true;



	$.ajax({

		type: "POST",

		url: "../../yoyaku/yoyaku.php",

		data: $senddata,

		success: function(msg){

			document.getElementById("div_wait").style.display = "none";

			alert(msg);

			$.unblockUI();

		},

		error:function(){

			alert("通信エラーが発生しました。");

			$.unblockUI();

		}

	});

}

</script>';



$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="images/mainimg.png" alt="" width="970" height="170" />';

$header_obj->fncMenuHead_h1text = '日本全国留学・ワーキングホリデーセミナー2014';



$header_obj->display_header();





	// パラメータ読み込0み

	$para = @$_GET['key'];



	// イベント読み込み

	$cal = array();



	$evt_ymd   = array();

	$evt_title = array();

	$evt_desc  = array();

	$evt_img   = array();

	$evt_btn   = array();

	$evt_id	   = array();

	$evt_date  = array();





	try {

		$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);

		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);

		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$db->query('SET CHARACTER SET utf8');

		$sql  = 'SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start FROM event_list WHERE ';

		if ($para <> '')	{

			$sql .= ' k_desc2 like "%'.$para.'%" and ';

		}

		$sql .= 'k_use = 1 ORDER BY hiduke, starttime, id';

		$rs = $db->query($sql);

		$cnt = 0;

		while($row = $rs->fetch(PDO::FETCH_ASSOC)){

			$cnt++;

			$year	= $row['yy'];

			$month  = $row['mm'];

			$day	= $row['dd'];



				// イベント

				$evt_id[] = $row['id'];

				$evt_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);

				$start = $row['start'];

				$start	= mb_ereg_replace('Mon', '月', $start);

				$start	= mb_ereg_replace('Tue', '火', $start);

				$start	= mb_ereg_replace('Wed', '水', $start);

				$start	= mb_ereg_replace('Thu', '木', $start);

				$start	= mb_ereg_replace('Fri', '金', $start);

				$start	= mb_ereg_replace('Sat', '土', $start);

				$start	= mb_ereg_replace('Sun', '日', $start);

				$evt_date[] = $start;

				$evt_title[] = $row['k_title1'];

				$evt_desc[]  = $row['k_desc1'];

				if ($row['k_stat'] == 1)	{

					if ($row['booking'] >= $row['pax'])	{

						$evt_img[]   	= '<img src="../../images/semi_full.jpg">';

					}else{

						$evt_img[]   	= '<img src="../../images/semi_now.jpg">';

					}

				}elseif ($row['k_stat'] == 2)	{

					$evt_img[]   	= '<img src="../../images/semi_full.jpg">';

				}else{

					if ($row['booking'] >= $row['pax'])	{

						$evt_img[]   	= '<img src="../../images/semi_full.jpg">';

					}else{

						if ($row['booking'] >= $row['pax'] / 2)	{

							$evt_img[]   	= '<img src="../../images/semi_now.jpg">';

						}else{

							$evt_img[]	= '';

						}

					}

				}

				if ($row['free'] == 1)	{

					$evt_btn[]	= '<div style="padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定イベントです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem">登録はこちらからどうぞ</a></div>';

				}else{

					if ($row['k_stat'] == 2)	{

						$evt_btn[]	= '';

					}else{

						if ($row['booking'] >= $row['pax'])	{

							$evt_btn[]	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[イベント]'.$start.' '.$row['k_title1'].'" uid="'.$row['id'].'">';

						}else{

							$evt_btn[]	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[イベント]'.$start.' '.$row['k_title1'].'" uid="'.$row['id'].'">';

						}

					}

				}

				$cal[$year.$month.$day] .= '<img src="../../images/sa04.jpg">';

		}

	} catch (PDOException $e) {

		die($e->getMessage());

	}





?>

	<div id="maincontent">

	  <?php echo $header_obj->breadcrumbs(); ?>
		<!--<h2 class="sec-title">日本全国留学・ワーキングホリデー無料セミナー　</h2>
	  <p class="text01">
			日本ワーキングホリデー協会では、全国でワーキングホリデーセミナーを随時開催しております。<br/>
			東京・大阪・福岡で通常開催されているセミナーに、ご近所の会場で参加することが出来ますので是非ご参加下さい。<br/>
		</p>
		<p>
			<center>
				<font color="red">★ 三重県セミナー開催決定　★</font><br/>
				<a href="http://www.jawhm.or.jp/event/mieseminar/"><img  src="http://www.jawhm.or.jp/ad/www/images/3599cd2b7ec7d37b4c195eba88f44972.gif" width="49%" style="margin-bottom: 10px;"/></a>
			</center>
		</p>
  	<table style="background-image:url(images/seminarmap.gif); background-repeat:no-repeat; margin-bottom: 20px;" width="110%" height="590px" >
		  <tr>
		    <td>
          <div class="chiiki2" id="iwate"><img  src="images/iwate_off.png"  style="margin:-30px 0px 0px 305px" /></div><br />
          <div class="chiiki2" id="fukushima"><img  src="images/fukushima_off.png"  style="margin:-35px 0px 0px 530px" /></div><br />
          <div class="chiiki2" id="kyoto"><img  src="images/kyoto_off.png"  style="margin:15px 0px 0px 200px" /></div><br />
          <div class="chiiki2" id="sendai"><img  src="images/sendai_off.png"  style="margin:10px 0px 0px 525px" /></div><br />
          <div class="chiiki2" id="nagasaki"><img  src="images/nagasaki_off.png"  style="margin:25px 0px 0px 15px" /></div><br />
          <div class="chiiki2" id="omiya"><img  src="images/omiya_off.png"  style="margin:70px 0px 0px 530px" /></div><br />
          <div class="chiiki2" id="yokohama"><img  src="images/yokohama_off.png"  style="margin:130px 0px 0px 395px" /></div><br />
          <div class="chiiki2" id="kagawa"><img  src="images/kagawa_off.png"  style="margin: 165px 0px 0px 200px" /></div><br />
	      </td>
		</tr>
		</table>-->
    
    <div id="seminarMap">
      <div id="seminarTitleBox">
        <p class="dateSeminnar replace">2014.06.27〜08.31</p>
        <h2 class="replace">日本全国ワーホリ留学セミナー</h2>
        <p class="sub">日本地図上、または以下リストより <br>会場を選択してください。</p>
      </div><!-- / #seminarTitleBox -->
      
      <ul id="regionLink">
        <li id="sapporo"><a href="../sapporoseminar/">札幌</a></li>
        <li id="sendai"><a href="../sendaiseminar/">仙台</a></li>
        <li id="omiya"><a href="../omiyaseminar/">大宮</a></li>
        <li id="chiba"><a href="../chibaseminar/">千葉</a></li>
        <li id="yokohama"><a href="../yokohamaseminar/">横浜</a></li>
        <li id="nigata"><a href="../niigataseminar/">新潟</a></li>
        <li id="nagano"><a href="../naganoseminar/">長野</a></li>
        <li id="shizuoka"><a href="../shizuokaseminar/">静岡</a></li>
        <li id="toyama"><a href="../toyamaseminar/">富山</a></li>
        <li id="fukui"><a href="../fukuiseminar/">福井</a></li>
        <li id="kyoto"><a href="../kyotoseminar/">京都</a></li>
        <li id="mie"><a href="../mieseminar/">三重</a></li>
        <li id="kobe"><a href="../kobeseminar/">神戸</a></li>
        <li id="nara"><a href="../naraseminar/">奈良</a></li>
        <li id="kagawa"><a href="../kagawaseminar/">香川</a></li>
        <li id="okayama"><a href="../okayamaseminar/">岡山</a></li>
        <li id="hiroshima"><a href="../hiroshimaseminar/">広島</a></li>
        <li id="kitakyusyu"><a href="../kitakyushuseminar/">北九州市</a></li>
        <li id="saga"><a href="../sagaseminar/">佐賀</a></li>
        <li id="nagasaki"><a href="../nagasakiseminar/">長崎</a></li>
        <li id="oita"><a href="../oitaseminar/">大分</a></li>
        <li id="kumamoto"><a href="../kumamotoseminar/">熊本</a></li>
        <li id="kagoshima"><a href="../kagoshimaseminar/">鹿児島</a></li>
      </ul><!-- / #regionLink -->
      
      <p id="normalSeminar"><a href="..//seminar/seminar/">東京・大阪・名古屋・福岡・沖縄 通常セミナーはこちら</a></p>
    </div><!-- / #seminarMap -->
    
    <h2 class="sec-title">会場一覧</h2>
    
    <div id="summaryList">
      <ul>
        <li id="sapporo" class="hokkaido"><a href="../sapporoseminar/">札幌</a></li>
        <li id="sendai" class="tohoku"><a href="../sendaiseminar/">仙台</a></li>
        <li id="omiya" class="kanto"><a href="../omiyaseminar/">大宮</a></li>
        <li id="chiba" class="kanto"><a href="../chibaseminar/">千葉</a></li>
        <li id="yokohama" class="kanto"><a href="../yokohamaseminar/">横浜</a></li>
        <li id="nigata" class="chubu"><a href="../niigataseminar/">新潟</a></li>
        <li id="nagano" class="chubu"><a href="../naganoseminar/">長野</a></li>
        <li id="shizuoka" class="chubu"><a href="../shizuokaseminar/">静岡</a></li>
        <li id="toyama" class="chubu"><a href="../toyamaseminar/">富山</a></li>
        <li id="fukui" class="chubu"><a href="../fukuiseminar/">福井</a></li>
        <li id="kyoto" class="kinki"><a href="../kyotoseminar/">京都</a></li>
        <li id="mie" class="kinki"><a href="../mieseminar/">三重</a></li>
        <li id="kobe" class="kinki"><a href="../kobeseminar/">神戸</a></li>
        <li id="nara" class="kinki"><a href="../naraseminar/">奈良</a></li>
        <li id="kagawa" class="shikoku"><a href="../kagawaseminar/">香川</a></li>
        <li id="okayama" class="chugoku"><a href="../okayamaseminar/">岡山</a></li>
        <li id="hiroshima" class="chugoku"><a href="../hiroshimaseminar/">広島</a></li>
        <li id="kitakyusyu" class="kyusyu"><a href="../kitakyushuseminar/">北九州市</a></li>
        <li id="saga" class="kyusyu"><a href="../sagaseminar/">佐賀</a></li>
        <li id="nagasaki" class="kyusyu"><a href="../nagasakiseminar/">長崎</a></li>
        <li id="oita" class="kyusyu"><a href="../oitaseminar/">大分</a></li>
        <li id="kumamoto" class="kyusyu"><a href="../kumamotoseminar/">熊本</a></li>
        <li id="kagoshima" class="kyusyu"><a href="../kagoshimaseminar/">鹿児島</a></li>
      </ul><!-- / .summaryList -->
    </div><!-- / #summaryList -->
    
		<div style="border: 2px dotted navy; font-size:10pt; margin: 10px 10px 25px 10px; padding: 10px 20px 10px 20px;">
			<b>留学</b> ・ <b>ワーキングホリデー</b> って何？　どんなことが出来るの？　予算はどのくらいかかるの？<br/>
			帰国してからの就職先が心配...　　初めての海外だけどワーホリで大丈夫？<br/>
			聞きたい事や、心配な事もたくさんあると思います。何でも聞いてください。<br/>
			セミナーの参加者は８割以上の方が、お１人での参加です。お気軽にご参加ください。<br/>
		</div>

		<center>
<!-- 順序入れ替え禁止！！　追加時は、一番したに！！ -->

<!--

<div class="panel" id="sapporo"		style="top:-385px; left: 235px; width:110px; height:30px;"></div>

<div class="panel" id="sendai"		style="top:-365px; left: 270px; width:100px; height:40px;"></div>

<div class="panel" id="fukushima"	style="top:-355px; left: 250px; width:100px; height:30px;"></div>

<div class="panel" id="omiya"		style="top:-345px; left: 230px; width:100px; height:30px;"></div>

<div class="panel" id="chiba"		style="top:-335px; left: 245px; width:100px; height:30px;"></div>

<div class="panel" id="yokohama"	style="top:-315px; left: 235px; width:100px; height:30px;"></div>

<div class="panel" id="shizuoka"	style="top:-315px; left: 200px; width:100px; height:55px;"></div>

<div class="panel" id="aomori"		style="top:-595px; left:  20px; width:100px; height:30px;"></div>

<div class="panel" id="niigata"		style="top:-575px; left:  25px; width:100px; height:40px;"></div>

<div class="panel" id="kyoto"		style="top:-605px; left:-110px; width:100px; height:40px;"></div>

<div class="panel" id="kobe"		style="top:-605px; left:-180px; width:100px; height:40px;"></div>

<div class="panel" id="hiroshima"	style="top:-590px; left:-190px; width:100px; height:40px;"></div>

<div class="panel" id="kumamoto"	style="top:-575px; left:-245px; width:100px; height:40px;"></div>

<div class="panel" id="kagoshima"	style="top:-520px; left:-215px; width:120px; height:40px;"></div>

<div class="panel" id="nagoya"		style="top:-610px; left: 115px; width:120px; height:70px;"></div>

<div class="panel" id="kagawa"		style="top:-645px; left: -25px; width:100px; height:40px;"></div>

<div class="panel" id="okinawa"		style="top:-715px; left:-270px; width:100px; height:30px;"></div>

-->

<!-- 順序入れ替え禁止！！　追加時は、一番したに！！ -->
</center>



		<h2 id="yoyaku" class="sec-title">ご予約</h2>

		<div style="height:50px;">&nbsp;</div>





	<div style="padding-left:30px;">

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

	// カレンダー表示
	$isView = $sm->show();

?>
<?php/*

	if ($para == '')	{

?>

			<div style="border: 2px dotted #ccc; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">

				開催地を選択してください。

			</div>

<?php

	}else{

		if (count($evt_title) == 0)	{

?>

			<div style="border: 1px dotted #ccc; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">

				現在、詳細な情報がありません。<br/>

				準備ができ次第、こちらのページでご案内いたします。<br/>

				お手数をおかけいたしますが、今しばらくお待ちください。<br/>

				<a href="../event.html">すべての会場の情報を見る場合はこちら</a><br/>

			</div>

<?php

		}else{

			for ($idx=0; $idx<count($evt_title); $idx++)	{

				print '<div style="height:20px;" id="'.$evt_ymd[$idx].'"> </div>';

				print '<div style="width:620px; margin:7px 0 0 -15px; padding-left:15px; font-size:11pt; color:navy; border-left:3px solid red; border-bottom:1px solid red;">';

				if ($evt_ymd[$idx] < date('Ymd'))	{

					print '終了しました　<s>'.$evt_title[$idx].'</s>';

				}else{

					print '<table><tr><td>'.$evt_btn[$idx].'</td><td>&nbsp;</td><td>'.$evt_date[$idx].'～<br/>'.$evt_title[$idx].'</td></tr></table>';

		//			print $evt_btn[$idx].'&nbsp;&nbsp;'.$evt_title[$idx].' '.$evt_date[$idx].' '.$evt_time[$idx];

				}

				print '</div>';

				print '<table><tr><td>'.$evt_img[$idx].'</td>';

				print '<td><p>'.nl2br($evt_desc[$idx]).'</p></td></tr></table>';

			}

		}

	}

*/?>

	</div>



	<div style="border: 1px dotted navy; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">

		イベントのご予約は、各イベント日程に表示された「予約」ボタンをご利用ください。<br/>

		各イベントへのご質問は toiawase@jawhm.or.jp　にメールをお願いいたします。<br/>

		なお、当日のイベントのご予約は、03-6304-5858までご連絡ください。<br/>

	</div>

	<div style="border: 1px dotted navy; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:10pt;">

		【ご注意：予約フォームが動作しない・仮予約メールが届かない方へ】<br/>

		スマートフォンなど、ＰＣ以外のブラウザからご利用された場合、予約フォームが正しく機能しない場合があります。<br/>

		この場合、お手数ですが、以下の内容を toiawase@jawhm.or.jp までご連絡ください。<br/>

		　・　参加希望のイベントの会場名、日程<br/>

		　・　お名前<br/>

		　・　当日連絡の付く電話番号<br/>

		　・　興味のある国<br/>

		　・　出発予定時期<br/>

	</div>


	<h2 class="sec-title">セミナー・オフィスにご来店できない方でも大丈夫！メンバー登録で安心の渡航サポート</h2>

	<p>

		&nbsp;<br/>

		日本地図上、又は以下から、会場を選択してください。<br/>

	</p>



<!--		<h2 class="sec-title">会場のご案内</h2>

		<div style="height:50px;">&nbsp;</div>

<?php

		$kaijo  = '';

		$kaijo .= '現在、詳細な情報がありません。<br/>';

		$kaijo .= '準備ができ次第、こちらのページでご案内いたします。<br/>';

		$kaijo .= 'お手数をおかけいたしますが、今しばらくお待ちください。<br/>';



		switch ($para)	{

			case "":

				$kaijo  = '';

				$kaijo .= '開催地を選択してください。';

				break;

			case "sendai":

				$kaijo  = '';

				$kaijo .= '<div style="padding:10px 20px 10px 20px; font-size:12pt; font-weight:bold; color:red; border: 1px dotted navy;">';

				$kaijo .= '※　ご注意<br/>';

				$kaijo .= '　　日程により会場が異なります。お間違いのないようにご注意ください。<br/>';

				$kaijo .= '</div>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '【2013年9月21日 (土) 仙台セミナー会場】<br/>';

				$kaijo .= '<big><strong>AERビル内仙台市情報・産業文化センター</strong></big> セミナールーム(1)B<br/>';

				$kaijo .= '仙台市青葉区中央1丁目3番1号<br/>';

				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.siip.city.sendai.jp/netu/accessmap.html">http://www.siip.city.sendai.jp/netu/accessmap.html</a><br/>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.jp/maps?ie=UTF8&amp;cid=4103052185506506088&amp;q=%E4%BB%99%E5%8F%B0%E5%B8%82%E6%83%85%E5%A0%B1%E3%83%BB%E7%94%A3%E6%A5%AD%E3%83%97%E3%83%A9%E3%82%B6&amp;gl=JP&amp;hl=ja&amp;ll=38.262574,140.881324&amp;spn=0.006295,0.006295&amp;t=m&amp;iwloc=A&amp;brcurrent=3,0x5f8a281814f9d7b7:0xa8eac763be24222f,0&amp;output=embed"></iframe><br /><small><a href="https://maps.google.co.jp/maps?ie=UTF8&amp;cid=4103052185506506088&amp;q=%E4%BB%99%E5%8F%B0%E5%B8%82%E6%83%85%E5%A0%B1%E3%83%BB%E7%94%A3%E6%A5%AD%E3%83%97%E3%83%A9%E3%82%B6&amp;gl=JP&amp;hl=ja&amp;ll=38.262574,140.881324&amp;spn=0.006295,0.006295&amp;t=m&amp;iwloc=A&amp;brcurrent=3,0x5f8a281814f9d7b7:0xa8eac763be24222f,0&amp;source=embed" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '【2013年10月20日(日)・2013年11月16日(土) 仙台セミナー会場】<br/>';

				$kaijo .= '<big><strong>エル・ソーラ仙台</strong></big> 28階　研修室<br/>';

				$kaijo .= '仙台市青葉区中央1丁目3-1 アエル28階<br/>';

				$kaijo .= 'アクセスマップ ： <a target="_blank" href="http://www.sendai-l.jp/whats_ls/">http://www.sendai-l.jp/whats_ls/</a><br/>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=+%E4%BB%99%E5%8F%B0%E5%B8%82%E7%94%B7%E5%A5%B3%E5%85%B1%E5%90%8C%E5%8F%82%E7%94%BB%E6%8E%A8%E9%80%B2%E3%82%BB%E3%83%B3%E3%82%BF%E3%83%BC+%E3%82%A8%E3%83%AB%E3%83%BB%E3%82%BD%E3%83%BC%E3%83%A9%E4%BB%99%E5%8F%B0&amp;aq=&amp;sll=38.266893,140.881119&amp;sspn=0.090301,0.175781&amp;brcurrent=3,0x5f8bd5431ea0bbe7:0xa6eec68d4dd8c141,0&amp;ie=UTF8&amp;hq=%E4%BB%99%E5%8F%B0%E5%B8%82%E7%94%B7%E5%A5%B3%E5%85%B1%E5%90%8C%E5%8F%82%E7%94%BB%E6%8E%A8%E9%80%B2%E3%82%BB%E3%83%B3%E3%82%BF%E3%83%BC+%E3%82%A8%E3%83%AB%E3%83%BB%E3%82%BD%E3%83%BC%E3%83%A9%E4%BB%99%E5%8F%B0&amp;ll=38.26263,140.881099&amp;spn=0.022576,0.043945&amp;t=m&amp;z=14&amp;iwloc=A&amp;cid=9919188986570218261&amp;output=embed"></iframe><br /><small><a href="https://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=+%E4%BB%99%E5%8F%B0%E5%B8%82%E7%94%B7%E5%A5%B3%E5%85%B1%E5%90%8C%E5%8F%82%E7%94%BB%E6%8E%A8%E9%80%B2%E3%82%BB%E3%83%B3%E3%82%BF%E3%83%BC+%E3%82%A8%E3%83%AB%E3%83%BB%E3%82%BD%E3%83%BC%E3%83%A9%E4%BB%99%E5%8F%B0&amp;aq=&amp;sll=38.266893,140.881119&amp;sspn=0.090301,0.175781&amp;brcurrent=3,0x5f8bd5431ea0bbe7:0xa6eec68d4dd8c141,0&amp;ie=UTF8&amp;hq=%E4%BB%99%E5%8F%B0%E5%B8%82%E7%94%B7%E5%A5%B3%E5%85%B1%E5%90%8C%E5%8F%82%E7%94%BB%E6%8E%A8%E9%80%B2%E3%82%BB%E3%83%B3%E3%82%BF%E3%83%BC+%E3%82%A8%E3%83%AB%E3%83%BB%E3%82%BD%E3%83%BC%E3%83%A9%E4%BB%99%E5%8F%B0&amp;ll=38.26263,140.881099&amp;spn=0.022576,0.043945&amp;t=m&amp;z=14&amp;iwloc=A&amp;cid=9919188986570218261" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '<hr/>';

				break;

			case "omiya":

				$kaijo  = '';

				$kaijo .= '<big><strong>大宮ソニックシティ</strong></big><br/>';

				$kaijo .= '〒330-8669　埼玉県さいたま市大宮区桜木町1-7-5<br/>';

				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.sonic-city.or.jp/modules/access/">http://www.sonic-city.or.jp/modules/access/</a><br/>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E5%9F%BC%E7%8E%89%E7%9C%8C%E3%81%95%E3%81%84%E3%81%9F%E3%81%BE%E5%B8%82%E5%A4%A7%E5%AE%AE%E5%8C%BA%E6%A1%9C%E6%9C%A8%E7%94%BA1-7-5&amp;sll=36.5626,136.362305&amp;sspn=36.481686,80.068359&amp;brcurrent=3,0x6018c142ea54e365:0x8d82184f7b9ddb15,0&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%9F%BC%E7%8E%89%E7%9C%8C%E3%81%95%E3%81%84%E3%81%9F%E3%81%BE%E5%B8%82%E5%A4%A7%E5%AE%AE%E5%8C%BA%E6%A1%9C%E6%9C%A8%E7%94%BA%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%97%E2%88%92%EF%BC%95&amp;t=m&amp;z=14&amp;ll=35.905323,139.619835&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E5%9F%BC%E7%8E%89%E7%9C%8C%E3%81%95%E3%81%84%E3%81%9F%E3%81%BE%E5%B8%82%E5%A4%A7%E5%AE%AE%E5%8C%BA%E6%A1%9C%E6%9C%A8%E7%94%BA1-7-5&amp;sll=36.5626,136.362305&amp;sspn=36.481686,80.068359&amp;brcurrent=3,0x6018c142ea54e365:0x8d82184f7b9ddb15,0&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%9F%BC%E7%8E%89%E7%9C%8C%E3%81%95%E3%81%84%E3%81%9F%E3%81%BE%E5%B8%82%E5%A4%A7%E5%AE%AE%E5%8C%BA%E6%A1%9C%E6%9C%A8%E7%94%BA%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%97%E2%88%92%EF%BC%95&amp;t=m&amp;z=14&amp;ll=35.905323,139.619835" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';

				$kaijo .= '<hr/>';

				break;

			case "fukushima":

				$kaijo  = '';

				$kaijo .= '<big><strong>福島県福島市コラッセふくしま</strong></big><br/>';

				$kaijo .= '福島県福島市三河南町1番20号<br/>';

				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.corasse.com/category/access">http://www.corasse.com/category/access</a><br/>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E6%97%A5%E6%9C%AC%E7%A6%8F%E5%B3%B6%E7%9C%8C%E7%A6%8F%E5%B3%B6%E5%B8%82%E4%B8%89%E6%B2%B3%E5%8D%97%E7%94%BA%EF%BC%91%E2%88%92%EF%BC%92%EF%BC%90+%E3%82%B3%E3%83%A9%E3%83%83%E3%82%BB%E3%81%B5%E3%81%8F%E3%81%97%E3%81%BE&amp;aq=0&amp;oq=%E3%82%B3%E3%83%A9%E3%83%83%E3%82%BB&amp;sll=37.766372,140.458145&amp;sspn=0.04546,0.087891&amp;ie=UTF8&amp;hq=&amp;hnear=%E6%97%A5%E6%9C%AC,+%E7%A6%8F%E5%B3%B6%E7%9C%8C%E7%A6%8F%E5%B3%B6%E5%B8%82%E4%B8%89%E6%B2%B3%E5%8D%97%E7%94%BA%EF%BC%91%E2%88%92%EF%BC%92%EF%BC%90+%E3%82%B3%E3%83%A9%E3%83%83%E3%82%BB%E3%81%B5%E3%81%8F%E3%81%97%E3%81%BE&amp;t=m&amp;z=14&amp;iwloc=A&amp;ll=37.756786,140.458175&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E6%97%A5%E6%9C%AC%E7%A6%8F%E5%B3%B6%E7%9C%8C%E7%A6%8F%E5%B3%B6%E5%B8%82%E4%B8%89%E6%B2%B3%E5%8D%97%E7%94%BA%EF%BC%91%E2%88%92%EF%BC%92%EF%BC%90+%E3%82%B3%E3%83%A9%E3%83%83%E3%82%BB%E3%81%B5%E3%81%8F%E3%81%97%E3%81%BE&amp;aq=0&amp;oq=%E3%82%B3%E3%83%A9%E3%83%83%E3%82%BB&amp;sll=37.766372,140.458145&amp;sspn=0.04546,0.087891&amp;ie=UTF8&amp;hq=&amp;hnear=%E6%97%A5%E6%9C%AC,+%E7%A6%8F%E5%B3%B6%E7%9C%8C%E7%A6%8F%E5%B3%B6%E5%B8%82%E4%B8%89%E6%B2%B3%E5%8D%97%E7%94%BA%EF%BC%91%E2%88%92%EF%BC%92%EF%BC%90+%E3%82%B3%E3%83%A9%E3%83%83%E3%82%BB%E3%81%B5%E3%81%8F%E3%81%97%E3%81%BE&amp;t=m&amp;z=14&amp;iwloc=A&amp;ll=37.756786,140.458175" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';

				$kaijo .= '<hr/>';

				break;

			case "yokohama":

				$kaijo  = '';

				$kaijo .= '<big><strong>TKP横浜駅西口カンファレンスセンター</strong></big><br/>';

				$kaijo .= '神奈川県横浜市神奈川区鶴屋町2-24-1 横浜谷川ビルディングANNEX 地下2階 <br/>';

				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://tkpyokohama.net/access.shtml">http://tkpyokohama.net/access.shtml</a><br/>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=TKP%E6%A8%AA%E6%B5%9C%E9%A7%85%E8%A5%BF%E5%8F%A3%E3%82%AB%E3%83%B3%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9%E3%82%BB%E3%83%B3%E3%82%BF%E3%83%BC&amp;aq=&amp;sll=35.468779,139.621468&amp;sspn=0.09367,0.175781&amp;ie=UTF8&amp;hq=TKP%E6%A8%AA%E6%B5%9C%E9%A7%85%E8%A5%BF%E5%8F%A3%E3%82%AB%E3%83%B3%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9%E3%82%BB%E3%83%B3%E3%82%BF%E3%83%BC&amp;hnear=&amp;ll=35.468794,139.620853&amp;spn=0.093652,0.175781&amp;t=m&amp;z=13&amp;iwloc=A&amp;cid=16530936181563193880&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=TKP%E6%A8%AA%E6%B5%9C%E9%A7%85%E8%A5%BF%E5%8F%A3%E3%82%AB%E3%83%B3%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9%E3%82%BB%E3%83%B3%E3%82%BF%E3%83%BC&amp;aq=&amp;sll=35.468779,139.621468&amp;sspn=0.09367,0.175781&amp;ie=UTF8&amp;hq=TKP%E6%A8%AA%E6%B5%9C%E9%A7%85%E8%A5%BF%E5%8F%A3%E3%82%AB%E3%83%B3%E3%83%95%E3%82%A1%E3%83%AC%E3%83%B3%E3%82%B9%E3%82%BB%E3%83%B3%E3%82%BF%E3%83%BC&amp;hnear=&amp;ll=35.468794,139.620853&amp;spn=0.093652,0.175781&amp;t=m&amp;z=13&amp;iwloc=A&amp;cid=16530936181563193880" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';

				break;

			case "kyoto":

				$kaijo  = '';

				$kaijo .= '<div style="padding:10px 20px 10px 20px; font-size:12pt; font-weight:bold; color:red; border: 1px dotted navy;">';

				$kaijo .= '※　ご注意<br/>';

				$kaijo .= '　　日程により会場が異なります。お間違いのないようにご注意ください。<br/>';

				$kaijo .= '</div>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '<big><strong>キャンパスプラザ京都</strong></big><br/>';

				$kaijo .= '京都市下京区西洞院通塩小路下る<br/>';

				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.consortium.or.jp/contents_detail.php?co=cat&frmId=585&frmCd=14-3-0-0-0">http://www.consortium.or.jp/contents_detail.php</a><br/>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%91%E3%82%B9%E3%83%97%E3%83%A9%E3%82%B6%E4%BA%AC%E9%83%BD&amp;aq=&amp;sll=35.010683,135.787468&amp;sspn=0.02355,0.043945&amp;ie=UTF8&amp;hq=%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%91%E3%82%B9%E3%83%97%E3%83%A9%E3%82%B6%E4%BA%AC%E9%83%BD&amp;hnear=&amp;t=m&amp;z=14&amp;iwloc=A&amp;cid=7287166566354890349&amp;ll=34.986375,135.75572&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%91%E3%82%B9%E3%83%97%E3%83%A9%E3%82%B6%E4%BA%AC%E9%83%BD&amp;aq=&amp;sll=35.010683,135.787468&amp;sspn=0.02355,0.043945&amp;ie=UTF8&amp;hq=%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%91%E3%82%B9%E3%83%97%E3%83%A9%E3%82%B6%E4%BA%AC%E9%83%BD&amp;hnear=&amp;t=m&amp;z=14&amp;iwloc=A&amp;cid=7287166566354890349&amp;ll=34.986375,135.75572" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';

				$kaijo .= '<hr/>';

				break;

			case "kagawa":

				$kaijo  = '';

				$kaijo .= '<big><strong>アイパル香川</strong> 香川国際交流会館3階　第1会議</big><br/>';

				$kaijo .= '香川県高松市番町一丁目 11‐63<br/>';

				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.i-pal.or.jp/what/">http://www.i-pal.or.jp/what/</a><br/>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E3%82%A2%E3%82%A4%E3%83%91%E3%83%AB%E9%A6%99%E5%B7%9D&amp;aq=&amp;sll=34.34379,134.045992&amp;sspn=0.01187,0.021973&amp;g=%E9%A6%99%E5%B7%9D%E7%9C%8C%E9%AB%98%E6%9D%BE%E5%B8%82%E7%95%AA%E7%94%BA%E4%B8%80%E4%B8%81%E7%9B%AE+11%E2%80%9063&amp;ie=UTF8&amp;ll=34.341994,134.046002&amp;spn=0.01187,0.021973&amp;t=m&amp;z=14&amp;iwloc=A&amp;cid=17205331481353556075&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E3%82%A2%E3%82%A4%E3%83%91%E3%83%AB%E9%A6%99%E5%B7%9D&amp;aq=&amp;sll=34.34379,134.045992&amp;sspn=0.01187,0.021973&amp;g=%E9%A6%99%E5%B7%9D%E7%9C%8C%E9%AB%98%E6%9D%BE%E5%B8%82%E7%95%AA%E7%94%BA%E4%B8%80%E4%B8%81%E7%9B%AE+11%E2%80%9063&amp;ie=UTF8&amp;ll=34.341994,134.046002&amp;spn=0.01187,0.021973&amp;t=m&amp;z=14&amp;iwloc=A&amp;cid=17205331481353556075" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';

				$kaijo .= '<hr/>';

				break;

			case "kobe":

				$kaijo  = '';

				$kaijo .= '<big><strong>神戸国際会館</strong></big><br/>';

				$kaijo .= '兵庫県神戸市中央区御幸通8丁目1番6号<br/>';

				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.kih.co.jp/access/index.html">http://www.kih.co.jp/access/</a><br/>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E7%A5%9E%E6%88%B8%E5%9B%BD%E9%9A%9B%E4%BC%9A%E9%A4%A8&amp;sll=35.673343,139.710388&amp;sspn=0.373725,0.703125&amp;brcurrent=3,0x60008e662ccb3b91:0xb3ec5b3de85e530f,0&amp;ie=UTF8&amp;hq=%E7%A5%9E%E6%88%B8%E5%9B%BD%E9%9A%9B%E4%BC%9A%E9%A4%A8&amp;hnear=&amp;radius=15000&amp;ll=34.692178,135.195911&amp;spn=0.094551,0.175781&amp;t=m&amp;z=13&amp;iwloc=A&amp;cid=16511898958572823139&amp;output=embed"></iframe><br /><small><a href="https://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E7%A5%9E%E6%88%B8%E5%9B%BD%E9%9A%9B%E4%BC%9A%E9%A4%A8&amp;sll=35.673343,139.710388&amp;sspn=0.373725,0.703125&amp;brcurrent=3,0x60008e662ccb3b91:0xb3ec5b3de85e530f,0&amp;ie=UTF8&amp;hq=%E7%A5%9E%E6%88%B8%E5%9B%BD%E9%9A%9B%E4%BC%9A%E9%A4%A8&amp;hnear=&amp;radius=15000&amp;ll=34.692178,135.195911&amp;spn=0.094551,0.175781&amp;t=m&amp;z=13&amp;iwloc=A&amp;cid=16511898958572823139" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';

				$kaijo .= '<hr/>';

				break;

				case "hiroshima":

				$kaijo  = '';

				$kaijo .= '<big><strong>中区民文化センター</strong></big><br/>';

				$kaijo .= '広島県広島市中区加古町４−１７<br/>';

				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.cf.city.hiroshima.jp/naka-cs/riyou/riyou.html">http://www.cf.city.hiroshima.jp/naka-cs/riyou/riyou.html</a><br/>';

				$kaijo .= '&nbsp;<br/>';

				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E4%B8%AD%E5%8C%BA%E6%B0%91%E6%96%87%E5%8C%96%E3%82%BB%E3%83%B3%E3%82%BF%E3%83%BC&amp;aq=&amp;sll=34.705493,135.195866&amp;sspn=0.094551,0.175781&amp;brcurrent=3,0x355a9908eef34fbb:0x7e4ce50cfc1f772,0&amp;ie=UTF8&amp;hq=%E4%B8%AD%E5%8C%BA%E6%B0%91%E6%96%87%E5%8C%96%E3%82%BB%E3%83%B3%E3%82%BF%E3%83%BC&amp;hnear=&amp;radius=15000&amp;t=m&amp;z=12&amp;iwloc=A&amp;cid=16449615921165286334&amp;ll=34.387661,132.448001&amp;output=embed"></iframe><br /><small><a href="https://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E4%B8%AD%E5%8C%BA%E6%B0%91%E6%96%87%E5%8C%96%E3%82%BB%E3%83%B3%E3%82%BF%E3%83%BC&amp;aq=&amp;sll=34.705493,135.195866&amp;sspn=0.094551,0.175781&amp;brcurrent=3,0x355a9908eef34fbb:0x7e4ce50cfc1f772,0&amp;ie=UTF8&amp;hq=%E4%B8%AD%E5%8C%BA%E6%B0%91%E6%96%87%E5%8C%96%E3%82%BB%E3%83%B3%E3%82%BF%E3%83%BC&amp;hnear=&amp;radius=15000&amp;t=m&amp;z=12&amp;iwloc=A&amp;cid=16449615921165286334&amp;ll=34.387661,132.448001" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';

				$kaijo .= '<hr/>';

				break;



		}



?>

		<div style="border: 1px dotted #ccc; font-size:11pt; margin: 10px 10px 10px 10px; padding: 10px 20px 10px 20px;">

			<?php echo $kaijo; ?>

		</div>

-->

<div style="height:30px;">&nbsp;</div>

<div style="text-align:center;">

	<img src="../../images/flag01.gif">

	<img src="../../images/flag03.gif">

	<img src="../../images/flag09.gif">

	<img src="../../images/flag05.gif">

	<img src="../../images/flag06.gif">

	<img src="../../images/mflag11.gif" width="40" height="26">

	<img src="../../images/flag08.gif">

	<img src="../../images/flag04.gif">

	<img src="../../images/flag02.gif">

	<img src="../../images/flag10.gif">

	<img src="../../images/flag07.gif">

</div>



	<div style="height:50px;">&nbsp;</div>





	</div>

	</div>

	</div>

  </div>

  

  <div id="yoyakuform" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">



	<div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">イベント　予約フォーム</div>



	<form name="form_yoyaku">

	<table style="width:560px;">

		<tr style="background-color:lightblue;">

			<td nowrap style="text-align:right;">イベント名&nbsp;</td>

			<td id="form_title" style="text-align:left;"></td>

			<input type="hidden" name="セミナー名" id="txt_title" value="">

			<input type="hidden" name="セミナー番号" id="txt_id" value="">

		</tr>

		<tr>

			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">お名前&nbsp;</td>

			<td style="border-bottom: 1px dotted pink; text-align:left;">

				(氏)<input type="text" name="お名前" id="txt_name" value="" size=10>

				(名)<input type="text" name="お名前2" id="txt_name2" value="" size=10>

			</td>

		</tr>

		<tr>

			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">フリガナ&nbsp;</td>

			<td style="border-bottom: 1px dotted pink; text-align:left;">

				(氏)<input type="text" name="フリガナ" id="txt_furigana" value="" size=10>

				(名)<input type="text" name="フリガナ2" id="txt_furigana2" value="" size=10>

			</td>

		</tr>

		<tr style="background-color:white;">

			<td nowrap valign="top" style="border-bottom: 1px dotted pink; text-align:right;">メールアドレス&nbsp;</td>

			<td style="border-bottom: 1px dotted pink; text-align:left;">

				<input type="text" name="メール" id="txt_mail" value="" size=40><br/>

				<span style="font-size:8pt;">

				※予約確認のメールをお送りします。必ず有効なアドレスを入力してください。<br/>

				</span>

			</td>

		</tr>

		<tr>

			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">当日連絡の付く電話番号&nbsp;</td>

			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="電話番号" id="txt_tel" value="" size=20></td>

		</tr>

		<tr style="background-color:white;">

			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">興味のある国&nbsp;</td>

			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="興味国" id="txt_kuni" value="" size=50></td>

		</tr>

		<tr>

			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">出発予定時期&nbsp;</td>

			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="出発時期" id="txt_jiki" value="" size=50></td>

		</tr>

		<tr>

			<td nowrap valign="top" style="border-bottom: 1px dotted pink; text-align:right;">同伴者有無&nbsp;</td>

			<td style="border-bottom: 1px dotted pink; text-align:left;">

				<input type="checkbox" name="同伴者" id="txt_dohan"> 同伴者あり<br/>

				<span style="font-size:8pt;">

				　　※同伴者ありの場合、２人分の席を確保致します。<br/>

				　　※３名以上でご参加の場合は、メールにてご連絡ください。<br/>

				</span>

			</td>

		</tr>

		<tr>

			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">今後のご案内&nbsp;</td>

			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="checkbox" name="メール会員" id="txt_mailmem" checked> このメールアドレスをメール会員(無料)に登録する</td>

		</tr>

		<tr style="background-color:white;">

			<td nowrap style="text-align:right;">その他&nbsp;</td>

			<td style="text-align:left;"><input type="text" name="その他" id="txt_memo" value="" size=50></td>

		</tr>

	</table>

	</form>



	<div style="font-size:9pt; font-weight:bold; margin:10px 0 10px 0; border: 1px dotted navy;;">

		【携帯のメールアドレスをご利用の方へ】<br/>

		予約確認のメールをお送り致しますので、<br/>

		jawhm.or.jpからのメール（ＰＣメール）が受信できる状態にしておいてください。<br/>

	</div>



	<div id="div_wait" style="display:none;">

		<img src="../../images/ajaxwait.gif">

		&nbsp;予約処理中です。しばらくお待ちください。&nbsp;

		<img src="../../images/ajaxwait.gif">

	</div>



	<input type="button" class="button_cancel" value=" 取消 " onClick="btn_cancel();">　　　　　

	<input type="button" class="button_submit" value=" 送信 " id="btn_soushin" onClick="btn_submit();">



</div>



<?php fncMenuFooter($header_obj->footer_type); ?>



</body>

</html>