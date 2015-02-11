<?php
require_once '../include/header.php';
$header_obj = new Header();

$header_obj->title_page='Working Holiday Very Merry Christmas!! 2013';
$header_obj->keywords_page='ワーキングホリデー,オーストラリア,ニュージーランド,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,学生,留学,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館,セミナー,語学学校,';
$header_obj->description_page='ワーホリ協会がお届けする、2013年最後のイベント♪夢に向かって進み始めたあなたへワーホリサンタからのクリスマスプレゼントです。
期間中に申し込みをされる方だけを対象に様々な割引をご用意しました！今年はワーホリサンタが皆さまに夢を届けます。来年は留学を体験した皆さまが別の誰かに夢を届けられると素敵ですね♪ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。ワーホリなら日本ワーキングホリデー協会';
$header_obj->pcmobile_type = true;

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
	height: 30px;
	text-align: center;
	vertical-align: middle;
	font-size: 12pt;
	color: white;
	margin: 0 5px 5px 0;
}



.xmas {
    background: none repeat scroll 0 0 #F3F3F3;
	padding: 10px;
    margin-top: 5px;
	height: 480px;
}

.effect1 {
    box-shadow: 0 10px 6px -6px #777777;
}

.sec-title-xmas {
	font-size: 15px;
	color: #00592c;
	background-image: url(images/sec-title.gif);
	background-repeat: no-repeat;
	font-weight: bold;
	width: 220px;
	height: 26px;
	margin-top: 10px;
	padding-left: 40px;
	padding-top: 6px;
}

.seminar-title {
	color: #00592c;
	font-weight: bold;
	font-size: 10.5pt;
}

.point {
	color: red;
	font-weight: bold;
}

.day1{
	font-family: "Century", serif;
	font-weight: bold;
	font-size: 25pt;
	color: #d70029;
}

.day2{
	font-family: "Century", serif;
	font-weight: bold;
	font-size: 25pt;
	color: #00592c;
}


</style>';
$header_obj->add_js_files='<script type="text/javascript" src="/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="/js/jquery.corner.js"></script>
<script type="text/javascript" src="sp.js"></script>
<script type="text/javascript">
jQuery(function($) {
	jQuery(".open").click(function(){
		jQuery(this).parent().children(".det").slideToggle("slow");
	});
});
</script>
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
	document.getElementById("form_title").innerHTML = obj.getAttribute("name");
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
		url: "../yoyaku/yoyaku.php",
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

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="images/mainimg.gif" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = 'Working Holiday Very Merry Christmas!! 2013';

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
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
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
			
				//set place
				$place = translate_city ($row['place']);



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
				$kaijo[] = $place.'会場';
				if ($row['k_stat'] == 1)	{
					if ($row['booking'] >= $row['pax'])	{
						$evt_img[]   	= '<img src="../images/semi_full.jpg">';
					}else{
						$evt_img[]   	= '<img src="../images/semi_now.jpg">';
					}
				}elseif ($row['k_stat'] == 2)	{
					$evt_img[]   	= '<img src="../images/semi_full.jpg">';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$evt_img[]   	= '<img src="../images/semi_full.jpg">';
					}else{
						if ($row['booking'] >= $row['pax'] / 2)	{
							$evt_img[]   	= '<img src="../images/semi_now.jpg">';
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
				$cal[$year.$month.$day] .= '<img src="../images/sa04.jpg">';
		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}


?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs(); ?>
		<!--<h2 class="sec-title">Working Holiday Very Merry Christmas!! 2013</h2>-->

<!--<div align="center"><img  src="images/mainimage.jpg" /></div>-->
		&nbsp;<br/>
		<center>
		<div style="width: 88%;">
		<span style="float: right;"><img src="images/pre.png" width="100%"></span>
			<p>
			<img src="images/copy.png"><br/>
			ワーホリ協会がお届けする、2013年最後のイベント♪<br/>
			期間中に申し込みをされる方だけを対象に様々な特典をご用意しました！<br/>
			今年はワーホリサンタが皆さまに夢を届けます。<br/>
			来年は留学を体験した皆さまが別の誰かに夢を届けられると素敵ですね♪<br/>
		</p>
		</div>	
		</center>
		
		&nbsp;<br/>
		&nbsp;<br/>
		
				<!-- 12月8.9 -->
		
		<div class="xmas effect1" style="float: left; width: 300px; margin: 5px 0px 10px 15px;">
			<span class="day1">08<font size="4">(<font color="red">Sun</font>) Australia</font></span> <img  src="images/aus.gif" width="30px"/>
				<center><img src="images/p8.gif" style="margin-bottom: 8px;"></center>
			<p class="text01">
			
				<span class="seminar-title">初心者向けセミナー(オーストラリア)</span><br/>
				<?php
				$keyword = '●初心者';
				include './seminar_school.php';
				?>
			</p>
					&nbsp;<br/>
			<p class="text01">
				<span class="seminar-title">オーストラリア語学学校(Navitas)セミナー</span><br/>
			
			<div style="border: 1px dotted navy; margin: -8px 0px 15px 10px; padding: 5px 5px 5px 5px; width: 270px;">
				<span class="point">この学校のおススメポイント</span><br/>
				オーストラリア各都市にキャンパスを持つ語学学校。<br/>
				在校中にキャンパスの変更が可能なので、色々なオーストラリアの都市に滞在したい人にぴったり。<br/>
			</div>
				<?php
				$keyword = 'navitas';
				include './seminar_school.php';
				?>
			</p>
		</div>	
		
			<div class="xmas effect1" style="float: right; width: 300px; margin: 5px 15px 10px 0px;">
				<span class="day2">09<font size="4">(Mon) Australia</font></span> <img  src="images/aus.gif" width="30px"/>
				<center><img src="images/p9.gif" style="margin-bottom: 8px;"></center>
			<p class="text01">
			
				<span class="seminar-title">初心者向けセミナー(オーストラリア)</span><br/>
				<?php
				$keyword = '◆初心者';
				include './seminar_school.php';
				?>
			</p>
					&nbsp;<br/>
			<p class="text01">
				<span class="seminar-title">オーストラリア語学学校(SELC)セミナー</span><br/>
			
			<div style="border: 1px dotted navy; margin: -8px 0px 15px 10px; padding: 5px 5px 5px 5px; width: 270px;">
				<span class="point">この学校のおススメポイント</span><br/>
				接客英語＆バリスタを学べるプログラムが大人気。<br/>
				海の近くのキャンパスでオーストラリア生活を満喫できます。<br/>
			</div>
				<?php
				$keyword = 'selc';
				include './seminar_school.php';
				?>
			</p>
		</div>	
		<br clear="both" />
		
		<!-- 12月10.11 -->
		
				<div class="xmas effect1" style="float: left; width: 300px; margin: 5px 0px 10px 15px;">
				<span class="day2">10<font size="4">(Tue) Canada</font></span> <img  src="images/can.gif" width="30px"/>
				<center><img src="images/p10.gif" style="margin-bottom: 8px;"></center>
			<p class="text01">
			
				<span class="seminar-title">初心者向けセミナー(カナダ)</span><br/>
				<?php
				$keyword = '□初心者';
				include './seminar_school.php';
				?>
			</p>
					&nbsp;<br/>
			<p class="text01">
				<span class="seminar-title">カナダ語学学校(CCEL)セミナー</span><br/>
			
			<div style="border: 1px dotted navy; margin: -8px 0px 15px 10px; padding: 5px 5px 5px 5px; width: 270px;">
				<span class="point">この学校のおススメポイント</span><br/>
				接客英語を学んでカナダでお仕事をゲットしよう。<br/>
				インターンシップ＆ビジネス英語にも強く、英語を使って働きたい！仕事重視の方におススメな学校。<br/>
			</div>
				<?php
				$keyword = 'ccel';
				include './seminar_school.php';
				?>
			</p>
		</div>	
		
			<div class="xmas effect1" style="float: right; width: 300px; margin: 5px 15px 10px 0px;">
				<span class="day1">11<font size="4">(Wed) Canada</font></span> <img  src="images/can.gif" width="30px"/>
				<center><img src="images/p11.gif" style="margin-bottom: 8px;"></center>
			<p class="text01">
			
				<span class="seminar-title">初心者向けセミナー(カナダ)</span><br/>
				<?php
				$keyword = '■初心者';
				include './seminar_school.php';
				?>
			</p>
					&nbsp;<br/>
			<p class="text01">
				<span class="seminar-title">カナダ語学学校(Ih vancouver)セミナー</span><br/>
			
			<div style="border: 1px dotted navy; margin: -8px 0px 15px 10px; padding: 5px 5px 5px 5px; width: 270px;">
				<span class="point">この学校のおススメポイント</span><br/>
				カナダの郊外にキャンパスを持ち、落ち着いた雰囲気の中しっかり勉強ができます。
				カナダならではのアクティビティも豊富。勉強も遊びも両立したい方は必見です。<br/>
			</div>
				<?php
				$keyword = 'Ih';
				include './seminar_school.php';
				?>
			</p>
		</div>	
		<br clear="both" />
		
		
		<!-- 12月12.13 -->
		
		
				<div class="xmas effect1" style="float: left; width: 300px; margin: 5px 0px 10px 15px;">
				<span class="day1">12<font size="4">(Thu) Australia</font></span> <img  src="images/aus.gif" width="30px"/>
				<center><img src="images/p12.gif" style="margin-bottom: 8px;"></center>
			<p class="text01">
			
				<span class="seminar-title">初心者向けセミナー(オーストラリア)</span><br/>
				<?php
				$keyword = '◇初心者';
				include './seminar_school.php';
				?>
			</p>
					&nbsp;<br/>
			<p class="text01">
				<span class="seminar-title">オーストラリア語学学校(Academies Australasia)セミナー</span><br/>
			
			<div style="border: 1px dotted navy; margin: -8px 0px 15px 10px; padding: 5px 5px 5px 5px; width: 270px;">
				<span class="point">この学校のおススメポイント</span><br/>
				語学学校・高校・専門学校・大学の学位までさまざまなコースをご用意。
				英語＋様々な専門課程を学びたい方やオーストラリアで資格を取得したい方におススメの学校です。<br/>
			</div>
				<?php
				$keyword = 'Academies Australasia';
				include './seminar_school.php';
				?>
			</p>
		</div>	
		
			<div class="xmas effect1" style="float: right; width: 300px; margin: 5px 15px 10px 0px;">
				<span class="day2">13<font size="4">(Fri) WorldWide</font></span> <img  src="images/can.gif" width="30px"/>
				<center><img src="images/p13.gif" style="margin-bottom: 8px;"></center>
			<p class="text01">
			
				<span class="seminar-title">初心者向けセミナー(英語圏)</span><br/>
				<?php
				$keyword = '◎初心者';
				include './seminar_school.php';
				?>
			</p>
					&nbsp;<br/>
			<p class="text01">
				<span class="seminar-title">オーストラリア語学学校(Embassy)セミナー</span><br/>
			
			<div style="border: 1px dotted navy; margin: -8px 0px 15px 10px; padding: 5px 5px 5px 5px; width: 270px;">
				<span class="point">この学校のおススメポイント</span><br/>
				電子黒板などの最先端技術で、授業効率をアップ、必然的に話す機会を増やし参加するだけでスピーキング力アップに繋がる授業が特徴。
				レベルアップ補償もあるので、英語に自信がない方でも安心です。<br/>

			</div>
				<?php
				$keyword = 'embassy';
				include './seminar_school.php';
				?>
			</p>
		</div>	
		<br clear="both" />
		
		
				<!-- 12月14.15 -->
				
				<div class="xmas effect1" style="float: left; width: 300px; margin: 5px 0px 10px 15px;">
				<span class="day2">14<font size="4">(<font color="blue">Sat</font>) Australia</font></span> <img  src="images/aus.gif" width="30px"/>
				<center><img src="images/p14.gif" style="margin-bottom: 8px;"></center>
			<p class="text01">
			
				<span class="seminar-title">初心者向けセミナー(オーストラリア)</span><br/>
				<?php
				$keyword = '☆初心者';
				include './seminar_school.php';
				?>
			</p>
					&nbsp;<br/>
			<p class="text01">
				<span class="seminar-title">オーストラリア語学学校(VIVA)セミナー</span><br/>
			
			<div style="border: 1px dotted navy; margin: -8px 0px 15px 10px; padding: 5px 5px 5px 5px; width: 270px;">
				<span class="point">この学校のおススメポイント</span><br/>
				スピーキングに特化した実践的な授業内容によって英語を話す実力が身に付きます。
				資格取得にも特化した語学学校。どんどんスキルを身に付けたい方におススメ。<br/>
			</div>
				<?php
				$keyword = 'viva';
				include './seminar_school.php';
				?>
			</p>
		</div>	
		
			<div class="xmas effect1" style="float: right; width: 300px; margin: 5px 15px 10px 0px;">
				<span class="day1">15<font size="4">(<font color="red">Sun</font>) Canada</font></span> <img  src="images/can.gif" width="30px"/>
				<center><img src="images/p15.gif" style="margin-bottom: 8px;"></center>
			<p class="text01">
			
				<span class="seminar-title">初心者向けセミナー(カナダ)</span><br/>
				<?php
				$keyword = '★初心者';
				include './seminar_school.php';
				?>
			</p>
					&nbsp;<br/>
			<p class="text01">
				<span class="seminar-title">オーストラリア語学学校(PGIC)セミナー</span><br/>
			
			<div style="border: 1px dotted navy; margin: -8px 0px 15px 10px; padding: 5px 5px 5px 5px; width: 270px;">
				<span class="point">この学校のおススメポイント</span><br/>
				「英語を本気でモノにする」徹底した母国語禁止制度と豊富な選択授業が人気。
				生きた英語を話す自信をつけ、楽しみながら英語力を高めることができる語学学校です。<br/>
			</div>
				<?php
				$keyword = 'PGIC';
				include './seminar_school.php';
				?>
			</p>
		</div>	
		<br clear="both" />
		
				<!-- 
			
		<div class="xmas effect1" style="float: left; width: 202px;">
			<p>
				<center><img src="images/p.gif"></center>
				aaaaaaaaaaaaaaaaaaaaaa
			</p>
		</div>	

		<div class="xmas effect1" style="float: left; width: 202px; margin-left:7px;">
				<center><img src="images/p.gif"></center>
			<p>
				bbbbbbbbbbbbbbbbbbbb
							<?php
	$keyword = '初心者';
	include './seminar_school.php';
		?>
			</p>
		</div>
		
		<div class="xmas effect1" style="float: right; width: 202px; margin-top:-0px;">
			<p>
				<center><img src="images/p.gif"></center>
				cccccccccccccccccc
			</p>
		</div>
		
		<br clear="both" />
		
			<?php
	$keyword = '初心者';
	include './seminar_school.php';
		?>
ここまで -->
	<!--
	<h2 class="sec-title-xmas">興味のあることからさがす</h2>
		<table style="margin-left:15px;">
		<tr>
			<td>
				<div class="chiiki" style="background-color:#efa800" id="sendai">英語が話せるようになりたい</div>
				<div class="chiiki" style="background-color:#efa800" id="fukushima">働くためのスキルがほしい</div>
				<div class="chiiki" style="background-color:#efa800" id="omiya">帰国後などに活かせる資格をとりたい</div>
				<div class="chiiki" style="background-color:#efa800" id="yokohama">観光や遊びなど海外を楽しみたい</div><br/>
				<div class="chiiki" style="background-color:#efa800" id="yokohama">渡航者の体験談が聞きたい</div>
				<div class="chiiki" style="background-color:#efa800" id="yokohama">ワーホリ＆留学友達をつくりたい</div>
			</td>
		</tr>
		</tr>
	</table>
	-->
	<table style="margin-left:15px; margin-top:20px;">
		<tr>
			<td>
			<div class="chiiki" style="background-color:#e80605; width: 610px;" id="xmas_shoshin">セミナーに初めてご参加の方は【初心者向けセミナー】から！</div>
			</td>
		</tr>
		</tr>
	</table>


		<div style="border: 2px dotted navy; font-size:10pt; margin: 30px 10px 25px 10px; padding: 10px 20px 10px 20px;">
			<b>留学</b> ・ <b>ワーキングホリデー</b> って何？　どんなことが出来るの？　予算はどのくらいかかるの？<br/>
			帰国してからの就職先が心配...　　初めての海外だけどワーホリで大丈夫？<br/>
			聞きたい事や、心配な事もたくさんあると思います。何でも聞いてください。<br/>
			セミナーの参加者は８割以上の方が、お１人での参加です。お気軽にご参加ください。<br/>
		</div>

	<div style="padding-left:30px;">
<?php
	if ($para == '')	{
?>
			
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
					print '<table><tr><td>'.$evt_btn[$idx].'</td><td>&nbsp;</td><td>'.$evt_date[$idx].'～<br/>'.$evt_title[$idx].'&nbsp;'.$kaijo[$idx].'</td></tr></table>';
		//			print $evt_btn[$idx].'&nbsp;&nbsp;'.$evt_title[$idx].' '.$evt_date[$idx].' '.$evt_time[$idx];
				}
				print '</div>';
				print '<div class="open" align="right">セミナー詳細はココをClick!!</div>';
				print '<div class="det" style="margin:5px 0 10px 0px; padding: 5px 0 13px 12px; display:none; border-left:1px dotted navy; border-bottom: 1px dotted navy;"><table><tr><td>'.$evt_img[$idx].'</td>';
				print '<td><p>'.nl2br($evt_desc[$idx]).'</p></td></tr></table></div>';
			}
		}
	}
?>
	</div>


	<div style="border: 1px dotted navy; margin: 30px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
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
		<h2 class="sec-title">スペシャルゲスト　参加語学学校のご案内</h2>
		<div style="height:50px;">&nbsp;</div>
<?php
		$kaijo  = '';
		$kaijo .= '現在、詳細な情報がありません。<br/>';
		$kaijo .= '準備ができ次第、こちらのページでご案内いたします。<br/>';
		$kaijo .= 'お手数をおかけいたしますが、今しばらくお待ちください。<br/>';

		switch ($para)	{
			case "":
				$kaijo  = '';
				$kaijo .= '	
				<table class="shool-event">
					<tr>
						<th>
							<a href="/school/aus_selc/" target="_top"><img src="/school/aus_selc/p01.jpg"   width="120"  alt="" /></a>
						</th>
						<td>
							<a href="/school/aus_selc/" target="_top">シドニー・イングリッシュ・ランゲージ・センター(Sydney English Language Centre / SELC)</a><br/>
							<font color="#333333">
							セルクは1985年に創立したオーストラリアを代表する老舗の英語学校です。一般英語はもちろんのこと、多彩なコースと豊富なレベルをご用意しています。
							ワーホリの方向けには接客英語を勉強しながらコーヒー作りのプロを目指すバリスタコースがあります。何ヶ月も前から予約が一杯になる程の人気コースです！
							またセルクでは、個々の学生たちに勉強法や生活アドバイスなどといったきめ細かいサポートにも定評があります。
							</font>
						</td>
						<td class="kuni">
							<a href="/school/aus.html" target="_top"><img src="../images/flag01.gif" alt="" /><br/>Australia</a>
						</td>
					</tr>
				</table>
				<table class="shool-event">
						<tr>
							<th>
								<a href="/school/aus_navitas/" target="_top"><img src="/school/aus_navitas/p01.jpg" alt="" width="120"/></a>
							</th>
							<td>
								<a href="/school/aus_navitas/" target="_top">ナビタス・イングリッシュ（Navitas English / Navitas）</a><br/>
								<font color="#333333">
								Navitas Englishは、1981年創立のオーストラリアで最も歴史ある英語学校です。オーストラリアの主要都市にキャンパスがあり、転校も可能です。
								また国籍バランス、豊富な英語コース、講師の高い質、進学提携校数の多さ、学生サポートにも定評があります。
								放課後・週末には楽しいアクティビティも提供していて、勉強面でも生活面でも、生徒一人一人しっかりとケアをします。
								</font>
							</td>
							<td class="kuni">
								<a href="/school/aus.html" target="_top"><img src="../images/flag01.gif" alt="" /><br/>Australia</a>
							</td>
						</tr>
					</table>

						<table class="shool-event">
							<tr>
								<th>
									<a href="/school/aus_viva/" target="_top"><img src="/school/aus_viva/p01.jpg" alt="" width="110"/></a>
								</th>
								<td>
									<a href="/school/aus_viva/" target="_top">ビバ・カレッジ（Viva College / Viva）</a><br/>
									<font color="#333333">
									質の高い授業およびケアーの行き届い学校として知られているブリスベンにあるViva Collegeは1993 年に留学生の為の英語コースを提供する学校としてスタートし、
									後にビジネスコースおよび英語教師訓練コースを設置しました。人気のコースは会話集中コースのSmart Talk、苦手なスキルを伸ばし全体的な英語レベルを向上させるFocus English、
									就職後に役立つビジネスコースです。中規模の学校だから成せる、留学生それぞれが求めるサポートを提供しています。  
									</font>
								</td>
								<td class="kuni">
									<a href="/school/aus.html" target="_top"><img src="../images/flag01.gif" alt="" /><br/>Australia</a>
								</td>
							</tr>
						</table>
				<table class="shool-event">
					<tr>
						<th>
						<a href="/school/can_ccel/" target="_top"><img src="/school/can_ccel/p01.jpg" alt="" width="140"/></a>
						</th>
							<td>
								<a href="/school/can_ccel/" target="_top">カナディアン・カレッジ・オブ・イングリッシュ・ランゲージ（Canadian College of English Language / CCEL）</a><br/>
								<font color="#333333">
								・１９９１年創立以来２１年間、国際的な評価を得る伝統校<br />
								・Languages Canada認定校、 Quality English認定校、東日本大震災被災者救済ホーププロジェクト対象校<br />
								・PCTIA（BC州専門学協会）認定校<br />
								・EQA（BC州教育クオリティ認定協会）認定校<br />
								・学生数： ５００－６００名（語学、専門含む）<br />
								・アメリカに姉妹校(SCEL)あり。転校や「２カ国留学」も可能 
								</font>
							</td>
							<td class="kuni">
								<a href="/school/can.html" target="_top"><img src="../images/flag03.gif" alt="" /><br/>Canada</a>
							</td>
						</tr>
					</table>
					<table class="shool-event">
						<tr>
							<th>
								<a href="/school/can_ih/" target="_top"><img src="/school/can_ih/p01.jpg" alt="" width="130"/></a>
							</th>
							<td>
								<a href="/school/can_ih/" target="_top">インターナショナル・ハウス / バンクーバー校（ih Vancouver）</a><br/>
								<font color="#333333">
								ダウンタウンから少し離れたキツラノエリアに位置しており、学校からダウンタウンや山々の眺めは最高。 
								INTERNATIONAL　HOUSE（IH）は、イギリスのロンドンを本部に世界47カ国、140箇所に学校がを展開している組織です。
								その為バンクーバー校にもヨーロッパを中心に、様々な国籍の生徒が在籍しています。IHグループが定めた質の高い講師陣と多様なプログラムがあり、
								短期間の生徒から長期間の生徒まで様々な目的で多くの学生がが学んでいます。 </font>
							</td>
							<td class="kuni">
								<a href="/school/can.html" target="_top"><img src="../images/flag03.gif" alt="" /><br/>Canada</a>
							</td>
						</tr>
					</table>
					<table class="shool-event">
						<tr>
							<th>
							<a href="/school/can_pgic/" target="_top"><img src="/school/can_pgic/p01.jpg" alt="" width="160"/></a>
							</th>
							<td>
								<a href="/school/can_pgic/" target="_top">ピージーアイシー（PGIC Vancouver/ Toronto/ Victoria）</a><br/>
								<font color="#333333">
								Loyalist Group Limitedはカナダの教育業界で唯一の上場企業であり、4つの学校、6つのキャンパスを展開し、2013年TSX(トロント証券)TOP50に選ばれた現在、最も注目されている企業である。
								PGICはその中でも独自の教育方針やカリキュラムの質の高さで定評があり、1994年の開校以来、「英語を本気でモノにしたい！！」という学生が世界中から集まります。
								その理由のひとつは4週間1セッションの固定クラスでしっかり学習できること。学生の入れ替わりも少ないので多国籍のクラスメートとお友達になりやすいのもポイントです。
								また、授業では就職活動やグローバル社会では欠かせない自己アピール力、論理的思考力、プレゼンテーション力などのユニークなプログラムが多数あり、英語プラスαのスキルを身につけることができます。 
								また徹底されたEnglish Only Policyは自然に英語を話す勇気を与えてくれ、地元カナダ人との会話クラブや街でネイティブスピーカーに話しかけるトーキングコンテストなど、
								生きた英語を話す自信をつけ、楽しみながら英語力を高めることができるオンリー1の学校です。			</font>
							</td>
							<td class="kuni">
								<a href="/school/can.html" target="_top"><img src="../images/flag03.gif" alt="" /><br/>Canada</a>
							</td>
						</tr>
					</table>
					<table class="shool-event">
						<tr>
							<th>
							<a href="/school/worldwide_embassy/"><img src="/school/worldwide_embassy/p01.jpg" alt="" width="120"/></a>
							</th>
							<td>
								<a href="/school/worldwide_embassy/">エンバシー（Embassy English）</a><br/>
								<font color="#333333">
								 エンバシーは今年設立40周年を迎え、アメリカ、カナダ、イギリス、オーストラリア、ニュージーランドの5カ国主要都市に23のセンターを持つ語学学校です。
								</font>
							</td>
							<td class="kuni">
								<a href="/school/worldwide.html"><img src="../images/worldwide_flag.gif" alt="" /><br/>World wide</a>
							</td>
						</tr>
					</table>
				';
				break;
			case "aus":
				$kaijo  = '';
				$kaijo .= '	
				<table class="shool-event">
					<tr>
						<th>
							<a href="/school/aus_selc/" target="_top"><img src="/school/aus_selc/p01.jpg"   width="120"  alt="" /></a>
						</th>
						<td>
							<a href="/school/aus_selc/" target="_top">シドニー・イングリッシュ・ランゲージ・センター(Sydney English Language Centre / SELC)</a><br/>
							<font color="#333333">
							セルクは1985年に創立したオーストラリアを代表する老舗の英語学校です。一般英語はもちろんのこと、多彩なコースと豊富なレベルをご用意しています。
							ワーホリの方向けには接客英語を勉強しながらコーヒー作りのプロを目指すバリスタコースがあります。何ヶ月も前から予約が一杯になる程の人気コースです！
							またセルクでは、個々の学生たちに勉強法や生活アドバイスなどといったきめ細かいサポートにも定評があります。
							</font>
						</td>
						<td class="kuni">
							<a href="/school/aus.html" target="_top"><img src="../images/flag01.gif" alt="" /><br/>Australia</a>
						</td>
					</tr>
				</table>
				<table class="shool-event">
						<tr>
							<th>
								<a href="/school/aus_navitas/" target="_top"><img src="/school/aus_navitas/p01.jpg" alt="" width="120"/></a>
							</th>
							<td>
								<a href="/school/aus_navitas/" target="_top">ナビタス・イングリッシュ（Navitas English / Navitas）</a><br/>
								<font color="#333333">
								Navitas Englishは、1981年創立のオーストラリアで最も歴史ある英語学校です。オーストラリアの主要都市にキャンパスがあり、転校も可能です。
								また国籍バランス、豊富な英語コース、講師の高い質、進学提携校数の多さ、学生サポートにも定評があります。
								放課後・週末には楽しいアクティビティも提供していて、勉強面でも生活面でも、生徒一人一人しっかりとケアをします。
								</font>
							</td>
							<td class="kuni">
								<a href="/school/aus.html" target="_top"><img src="../images/flag01.gif" alt="" /><br/>Australia</a>
							</td>
						</tr>
					</table>

						<table class="shool-event">
							<tr>
								<th>
									<a href="/school/aus_viva/" target="_top"><img src="/school/aus_viva/p01.jpg" alt="" width="110"/></a>
								</th>
								<td>
									<a href="/school/aus_viva/" target="_top">ビバ・カレッジ（Viva College / Viva）</a><br/>
									<font color="#333333">
									質の高い授業およびケアーの行き届い学校として知られているブリスベンにあるViva Collegeは1993 年に留学生の為の英語コースを提供する学校としてスタートし、
									後にビジネスコースおよび英語教師訓練コースを設置しました。人気のコースは会話集中コースのSmart Talk、苦手なスキルを伸ばし全体的な英語レベルを向上させるFocus English、
									就職後に役立つビジネスコースです。中規模の学校だから成せる、留学生それぞれが求めるサポートを提供しています。  
									</font>
								</td>
								<td class="kuni">
									<a href="/school/aus.html" target="_top"><img src="../images/flag01.gif" alt="" /><br/>Australia</a>
								</td>
							</tr>
						</table>
					<table class="shool-event">
						<tr>
							<th>
							<a href="/school/worldwide_embassy/"><img src="/school/worldwide_embassy/p01.jpg" alt="" width="120"/></a>
							</th>
							<td>
								<a href="/school/worldwide_embassy/">エンバシー（Embassy English）</a><br/>
								<font color="#333333">
								 エンバシーは今年設立40周年を迎え、アメリカ、カナダ、イギリス、オーストラリア、ニュージーランドの5カ国主要都市に23のセンターを持つ語学学校です。
								</font>
							</td>
							<td class="kuni">
								<a href="/school/worldwide.html"><img src="../images/worldwide_flag.gif" alt="" /><br/>World wide</a>
							</td>
						</tr>
					</table>';
				break;
			case "can":
				$kaijo  = '';
				$kaijo .= '
				<table class="shool-event">
					<tr>
						<th>
						<a href="/school/can_ccel/" target="_top"><img src="/school/can_ccel/p01.jpg" alt="" width="140"/></a>
						</th>
							<td>
								<a href="/school/can_ccel/" target="_top">カナディアン・カレッジ・オブ・イングリッシュ・ランゲージ（Canadian College of English Language / CCEL）</a><br/>
								<font color="#333333">
								・１９９１年創立以来２１年間、国際的な評価を得る伝統校<br />
								・Languages Canada認定校、 Quality English認定校、東日本大震災被災者救済ホーププロジェクト対象校<br />
								・PCTIA（BC州専門学協会）認定校<br />
								・EQA（BC州教育クオリティ認定協会）認定校<br />
								・学生数： ５００－６００名（語学、専門含む）<br />
								・アメリカに姉妹校(SCEL)あり。転校や「２カ国留学」も可能 
								</font>
							</td>
							<td class="kuni">
								<a href="/school/can.html" target="_top"><img src="../images/flag03.gif" alt="" /><br/>Canada</a>
							</td>
						</tr>
					</table>
					<table class="shool-event">
						<tr>
							<th>
								<a href="/school/can_ih/" target="_top"><img src="/school/can_ih/p01.jpg" alt="" width="130"/></a>
							</th>
							<td>
								<a href="/school/can_ih/" target="_top">インターナショナル・ハウス / バンクーバー校（ih Vancouver）</a><br/>
								<font color="#333333">
								ダウンタウンから少し離れたキツラノエリアに位置しており、学校からダウンタウンや山々の眺めは最高。 
								INTERNATIONAL　HOUSE（IH）は、イギリスのロンドンを本部に世界47カ国、140箇所に学校がを展開している組織です。
								その為バンクーバー校にもヨーロッパを中心に、様々な国籍の生徒が在籍しています。IHグループが定めた質の高い講師陣と多様なプログラムがあり、
								短期間の生徒から長期間の生徒まで様々な目的で多くの学生がが学んでいます。 </font>
							</td>
							<td class="kuni">
								<a href="/school/can.html" target="_top"><img src="../images/flag03.gif" alt="" /><br/>Canada</a>
							</td>
						</tr>
					</table>
					<table class="shool-event">
						<tr>
							<th>
							<a href="/school/can_pgic/" target="_top"><img src="/school/can_pgic/p01.jpg" alt="" width="160"/></a>
							</th>
							<td>
								<a href="/school/can_pgic/" target="_top">ピージーアイシー（PGIC Vancouver/ Toronto/ Victoria）</a><br/>
								<font color="#333333">
								Loyalist Group Limitedはカナダの教育業界で唯一の上場企業であり、4つの学校、6つのキャンパスを展開し、2013年TSX(トロント証券)TOP50に選ばれた現在、最も注目されている企業である。
								PGICはその中でも独自の教育方針やカリキュラムの質の高さで定評があり、1994年の開校以来、「英語を本気でモノにしたい！！」という学生が世界中から集まります。
								その理由のひとつは4週間1セッションの固定クラスでしっかり学習できること。学生の入れ替わりも少ないので多国籍のクラスメートとお友達になりやすいのもポイントです。
								また、授業では就職活動やグローバル社会では欠かせない自己アピール力、論理的思考力、プレゼンテーション力などのユニークなプログラムが多数あり、英語プラスαのスキルを身につけることができます。 
								また徹底されたEnglish Only Policyは自然に英語を話す勇気を与えてくれ、地元カナダ人との会話クラブや街でネイティブスピーカーに話しかけるトーキングコンテストなど、
								生きた英語を話す自信をつけ、楽しみながら英語力を高めることができるオンリー1の学校です。			</font>
							</td>
							<td class="kuni">
								<a href="/school/can.html" target="_top"><img src="../images/flag03.gif" alt="" /><br/>Canada</a>
							</td>
						</tr>
					</table>
					<table class="shool-event">
						<tr>
							<th>
							<a href="/school/worldwide_embassy/"><img src="/school/worldwide_embassy/p01.jpg" alt="" width="120"/></a>
							</th>
							<td>
								<a href="/school/worldwide_embassy/">エンバシー（Embassy English）</a><br/>
								<font color="#333333">
								 エンバシーは今年設立40周年を迎え、アメリカ、カナダ、イギリス、オーストラリア、ニュージーランドの5カ国主要都市に23のセンターを持つ語学学校です。
								</font>
							</td>
							<td class="kuni">
								<a href="/school/worldwide.html"><img src="../images/worldwide_flag.gif" alt="" /><br/>World wide</a>
							</td>
						</tr>
					</table>';
				break;
			case "ww":
				$kaijo  = '';
				$kaijo .= '
					<table class="shool-event">
						<tr>
							<th>
							<a href="/school/worldwide_embassy/"><img src="/school/worldwide_embassy/p01.jpg" alt="" width="120"/></a>
							</th>
							<td>
								<a href="/school/worldwide_embassy/">エンバシー（Embassy English）</a><br/>
								<font color="#333333">
								 エンバシーは今年設立40周年を迎え、アメリカ、カナダ、イギリス、オーストラリア、ニュージーランドの5カ国主要都市に23のセンターを持つ語学学校です。
								</font>
							</td>
							<td class="kuni">
								<a href="/school/worldwide.html"><img src="../images/worldwide_flag.gif" alt="" /><br/>World wide</a>
							</td>
						</tr>
					</table>';
				break;
			case "other":
				$kaijo  = '';
				$kaijo .= '	
				<table class="shool-event">
					<tr>
						<th>
							<a href="/school/aus_selc/" target="_top"><img src="/school/aus_selc/p01.jpg"   width="120"  alt="" /></a>
						</th>
						<td>
							<a href="/school/aus_selc/" target="_top">シドニー・イングリッシュ・ランゲージ・センター(Sydney English Language Centre / SELC)</a><br/>
							<font color="#333333">
							セルクは1985年に創立したオーストラリアを代表する老舗の英語学校です。一般英語はもちろんのこと、多彩なコースと豊富なレベルをご用意しています。
							ワーホリの方向けには接客英語を勉強しながらコーヒー作りのプロを目指すバリスタコースがあります。何ヶ月も前から予約が一杯になる程の人気コースです！
							またセルクでは、個々の学生たちに勉強法や生活アドバイスなどといったきめ細かいサポートにも定評があります。
							</font>
						</td>
						<td class="kuni">
							<a href="/school/aus.html" target="_top"><img src="../images/flag01.gif" alt="" /><br/>Australia</a>
						</td>
					</tr>
				</table>
					<table class="shool-event">
						<tr>
							<th>
								<a href="/school/aus_navitas/" target="_top"><img src="/school/aus_navitas/p01.jpg" alt="" width="120"/></a>
							</th>
							<td>
								<a href="/school/aus_navitas/" target="_top">ナビタス・イングリッシュ（Navitas English / Navitas）</a><br/>
								<font color="#333333">
								Navitas Englishは、1981年創立のオーストラリアで最も歴史ある英語学校です。オーストラリアの主要都市にキャンパスがあり、転校も可能です。
								また国籍バランス、豊富な英語コース、講師の高い質、進学提携校数の多さ、学生サポートにも定評があります。
								放課後・週末には楽しいアクティビティも提供していて、勉強面でも生活面でも、生徒一人一人しっかりとケアをします。
								</font>
							</td>
							<td class="kuni">
								<a href="/school/aus.html" target="_top"><img src="../images/flag01.gif" alt="" /><br/>Australia</a>
							</td>
						</tr>
					</table>
						<table class="shool-event">
							<tr>
								<th>
									<a href="/school/aus_viva/" target="_top"><img src="/school/aus_viva/p01.jpg" alt="" width="110"/></a>
								</th>
								<td>
									<a href="/school/aus_viva/" target="_top">ビバ・カレッジ（Viva College / Viva）</a><br/>
									<font color="#333333">
									質の高い授業およびケアーの行き届い学校として知られているブリスベンにあるViva Collegeは1993 年に留学生の為の英語コースを提供する学校としてスタートし、
									後にビジネスコースおよび英語教師訓練コースを設置しました。人気のコースは会話集中コースのSmart Talk、苦手なスキルを伸ばし全体的な英語レベルを向上させるFocus English、
									就職後に役立つビジネスコースです。中規模の学校だから成せる、留学生それぞれが求めるサポートを提供しています。  
									</font>
								</td>
								<td class="kuni">
									<a href="/school/aus.html" target="_top"><img src="../images/flag01.gif" alt="" /><br/>Australia</a>
								</td>
							</tr>
						</table>
				<table class="shool-event">
					<tr>
						<th>
						<a href="/school/can_ccel/" target="_top"><img src="/school/can_ccel/p01.jpg" alt="" width="140"/></a>
						</th>
							<td>
								<a href="/school/can_ccel/" target="_top">カナディアン・カレッジ・オブ・イングリッシュ・ランゲージ（Canadian College of English Language / CCEL）</a><br/>
								<font color="#333333">
								・１９９１年創立以来２１年間、国際的な評価を得る伝統校<br />
								・Languages Canada認定校、 Quality English認定校、東日本大震災被災者救済ホーププロジェクト対象校<br />
								・PCTIA（BC州専門学協会）認定校<br />
								・EQA（BC州教育クオリティ認定協会）認定校<br />
								・学生数： ５００－６００名（語学、専門含む）<br />
								・アメリカに姉妹校(SCEL)あり。転校や「２カ国留学」も可能 
								</font>
							</td>
							<td class="kuni">
								<a href="/school/can.html" target="_top"><img src="../images/flag03.gif" alt="" /><br/>Canada</a>
							</td>
						</tr>
					</table>
					<table class="shool-event">
						<tr>
							<th>
								<a href="/school/can_ih/" target="_top"><img src="/school/can_ih/p01.jpg" alt="" width="130"/></a>
							</th>
							<td>
								<a href="/school/can_ih/" target="_top">インターナショナル・ハウス / バンクーバー校（ih Vancouver）</a><br/>
								<font color="#333333">
								ダウンタウンから少し離れたキツラノエリアに位置しており、学校からダウンタウンや山々の眺めは最高。 
								INTERNATIONAL　HOUSE（IH）は、イギリスのロンドンを本部に世界47カ国、140箇所に学校がを展開している組織です。
								その為バンクーバー校にもヨーロッパを中心に、様々な国籍の生徒が在籍しています。IHグループが定めた質の高い講師陣と多様なプログラムがあり、
								短期間の生徒から長期間の生徒まで様々な目的で多くの学生がが学んでいます。 </font>
							</td>
							<td class="kuni">
								<a href="/school/can.html" target="_top"><img src="../images/flag03.gif" alt="" /><br/>Canada</a>
							</td>
						</tr>
					</table>
					<table class="shool-event">
						<tr>
							<th>
							<a href="/school/can_pgic/" target="_top"><img src="/school/can_pgic/p01.jpg" alt="" width="160"/></a>
							</th>
							<td>
								<a href="/school/can_pgic/" target="_top">ピージーアイシー（PGIC Vancouver/ Toronto/ Victoria）</a><br/>
								<font color="#333333">
								Loyalist Group Limitedはカナダの教育業界で唯一の上場企業であり、4つの学校、6つのキャンパスを展開し、2013年TSX(トロント証券)TOP50に選ばれた現在、最も注目されている企業である。
								PGICはその中でも独自の教育方針やカリキュラムの質の高さで定評があり、1994年の開校以来、「英語を本気でモノにしたい！！」という学生が世界中から集まります。
								その理由のひとつは4週間1セッションの固定クラスでしっかり学習できること。学生の入れ替わりも少ないので多国籍のクラスメートとお友達になりやすいのもポイントです。
								また、授業では就職活動やグローバル社会では欠かせない自己アピール力、論理的思考力、プレゼンテーション力などのユニークなプログラムが多数あり、英語プラスαのスキルを身につけることができます。 
								また徹底されたEnglish Only Policyは自然に英語を話す勇気を与えてくれ、地元カナダ人との会話クラブや街でネイティブスピーカーに話しかけるトーキングコンテストなど、
								生きた英語を話す自信をつけ、楽しみながら英語力を高めることができるオンリー1の学校です。			</font>
							</td>
							<td class="kuni">
								<a href="/school/can.html" target="_top"><img src="../images/flag03.gif" alt="" /><br/>Canada</a>
							</td>
						</tr>
					</table>
					<table class="shool-event">
						<tr>
							<th>
							<a href="/school/worldwide_embassy/"><img src="/school/worldwide_embassy/p01.jpg" alt="" width="120"/></a>
							</th>
							<td>
								<a href="/school/worldwide_embassy/">エンバシー（Embassy English）</a><br/>
								<font color="#333333">
								 エンバシーは今年設立40周年を迎え、アメリカ、カナダ、イギリス、オーストラリア、ニュージーランドの5カ国主要都市に23のセンターを持つ語学学校です。
								</font>
							</td>
							<td class="kuni">
								<a href="/school/worldwide.html"><img src="../images/worldwide_flag.gif" alt="" /><br/>World wide</a>
							</td>
						</tr>
					</table>';
				break;
			case "20131208":
				$kaijo  = '';
				$kaijo .= '
					<table class="shool-event">
						<tr>
							<th>
								<a href="/school/aus_navitas/" target="_top"><img src="/school/aus_navitas/p01.jpg" alt="" width="120"/></a>
							</th>
							<td>
								<a href="/school/aus_navitas/" target="_top">ナビタス・イングリッシュ（Navitas English / Navitas）</a><br/>
								<font color="#333333">
								Navitas Englishは、1981年創立のオーストラリアで最も歴史ある英語学校です。オーストラリアの主要都市にキャンパスがあり、転校も可能です。
								また国籍バランス、豊富な英語コース、講師の高い質、進学提携校数の多さ、学生サポートにも定評があります。
								放課後・週末には楽しいアクティビティも提供していて、勉強面でも生活面でも、生徒一人一人しっかりとケアをします。
								</font>
							</td>
							<td class="kuni">
								<a href="/school/aus.html" target="_top"><img src="../images/flag01.gif" alt="" /><br/>Australia</a>
							</td>
						</tr>
					</table>
				';
				break;
			case "20131209":
				$kaijo  = '';
				$kaijo .= '
				<table class="shool-event">
					<tr>
						<th>
							<a href="/school/aus_selc/" target="_top"><img src="/school/aus_selc/p01.jpg"   width="120"  alt="" /></a>
						</th>
						<td>
							<a href="/school/aus_selc/" target="_top">シドニー・イングリッシュ・ランゲージ・センター(Sydney English Language Centre / SELC)</a><br/>
							<font color="#333333">
							セルクは1985年に創立したオーストラリアを代表する老舗の英語学校です。一般英語はもちろんのこと、多彩なコースと豊富なレベルをご用意しています。
							ワーホリの方向けには接客英語を勉強しながらコーヒー作りのプロを目指すバリスタコースがあります。何ヶ月も前から予約が一杯になる程の人気コースです！
							またセルクでは、個々の学生たちに勉強法や生活アドバイスなどといったきめ細かいサポートにも定評があります。
							</font>
						</td>
						<td class="kuni">
							<a href="/school/aus.html" target="_top"><img src="../images/flag01.gif" alt="" /><br/>Australia</a>
						</td>
					</tr>
				</table>
				';
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
				case "20131214":
				$kaijo  = '
						<table class="shool-event">
							<tr>
								<th>
									<a href="/school/aus_viva/" target="_top"><img src="/school/aus_viva/p01.jpg" alt="" width="110"/></a>
								</th>
								<td>
									<a href="/school/aus_viva/" target="_top">ビバ・カレッジ（Viva College / Viva）</a><br/>
									<font color="#333333">
									質の高い授業およびケアーの行き届い学校として知られているブリスベンにあるViva Collegeは1993 年に留学生の為の英語コースを提供する学校としてスタートし、
									後にビジネスコースおよび英語教師訓練コースを設置しました。人気のコースは会話集中コースのSmart Talk、苦手なスキルを伸ばし全体的な英語レベルを向上させるFocus English、
									就職後に役立つビジネスコースです。中規模の学校だから成せる、留学生それぞれが求めるサポートを提供しています。  
									</font>
								</td>
								<td class="kuni">
									<a href="/school/aus.html" target="_top"><img src="../images/flag01.gif" alt="" /><br/>Australia</a>
								</td>
							</tr>
						</table>
				';
				break;
				case "20131214":
				$kaijo  = '
				<table class="shool-event">
					<tr>
						<th>
						<a href="/school/can_ccel/" target="_top"><img src="/school/can_ccel/p01.jpg" alt="" width="140"/></a>
						</th>
							<td>
								<a href="/school/can_ccel/" target="_top">カナディアン・カレッジ・オブ・イングリッシュ・ランゲージ（Canadian College of English Language / CCEL）</a><br/>
								<font color="#333333">
								・１９９１年創立以来２１年間、国際的な評価を得る伝統校<br />
								・Languages Canada認定校、 Quality English認定校、東日本大震災被災者救済ホーププロジェクト対象校<br />
								・PCTIA（BC州専門学協会）認定校<br />
								・EQA（BC州教育クオリティ認定協会）認定校<br />
								・学生数： ５００－６００名（語学、専門含む）<br />
								・アメリカに姉妹校(SCEL)あり。転校や「２カ国留学」も可能 
								</font>
							</td>
							<td class="kuni">
								<a href="/school/can.html" target="_top"><img src="../images/flag03.gif" alt="" /><br/>Canada</a>
							</td>
						</tr>
					</table>
				';
				break;
				case "20131211":
				$kaijo  = '
					<table class="shool-event">
						<tr>
							<th>
								<a href="/school/can_ih/" target="_top"><img src="/school/can_ih/p01.jpg" alt="" width="130"/></a>
							</th>
							<td>
								<a href="/school/can_ih/" target="_top">インターナショナル・ハウス / バンクーバー校（ih Vancouver）</a><br/>
								<font color="#333333">
								ダウンタウンから少し離れたキツラノエリアに位置しており、学校からダウンタウンや山々の眺めは最高。 
								INTERNATIONAL　HOUSE（IH）は、イギリスのロンドンを本部に世界47カ国、140箇所に学校がを展開している組織です。
								その為バンクーバー校にもヨーロッパを中心に、様々な国籍の生徒が在籍しています。IHグループが定めた質の高い講師陣と多様なプログラムがあり、
								短期間の生徒から長期間の生徒まで様々な目的で多くの学生がが学んでいます。 </font>
							</td>
							<td class="kuni">
								<a href="/school/can.html" target="_top"><img src="../images/flag03.gif" alt="" /><br/>Canada</a>
							</td>
						</tr>
					</table>
				';
				break;
				case "20131215":
				$kaijo  = '
					<table class="shool-event">
						<tr>
							<th>
							<a href="/school/can_pgic/" target="_top"><img src="/school/can_pgic/p01.jpg" alt="" width="160"/></a>
							</th>
							<td>
								<a href="/school/can_pgic/" target="_top">ピージーアイシー（PGIC Vancouver/ Toronto/ Victoria）</a><br/>
								<font color="#333333">
								Loyalist Group Limitedはカナダの教育業界で唯一の上場企業であり、4つの学校、6つのキャンパスを展開し、2013年TSX(トロント証券)TOP50に選ばれた現在、最も注目されている企業である。
								PGICはその中でも独自の教育方針やカリキュラムの質の高さで定評があり、1994年の開校以来、「英語を本気でモノにしたい！！」という学生が世界中から集まります。
								その理由のひとつは4週間1セッションの固定クラスでしっかり学習できること。学生の入れ替わりも少ないので多国籍のクラスメートとお友達になりやすいのもポイントです。
								また、授業では就職活動やグローバル社会では欠かせない自己アピール力、論理的思考力、プレゼンテーション力などのユニークなプログラムが多数あり、英語プラスαのスキルを身につけることができます。 
								また徹底されたEnglish Only Policyは自然に英語を話す勇気を与えてくれ、地元カナダ人との会話クラブや街でネイティブスピーカーに話しかけるトーキングコンテストなど、
								生きた英語を話す自信をつけ、楽しみながら英語力を高めることができるオンリー1の学校です。			</font>
							</td>
							<td class="kuni">
								<a href="/school/can.html" target="_top"><img src="../images/flag03.gif" alt="" /><br/>Canada</a>
							</td>
						</tr>
					</table>
				';
				break;
				case "20131213":
				$kaijo  = '
					<table class="shool-event">
						<tr>
							<th>
							<a href="/school/worldwide_embassy/"><img src="/school/worldwide_embassy/p01.jpg" alt="" width="120"/></a>
							</th>
							<td>
								<a href="/school/worldwide_embassy/">エンバシー（Embassy English）</a><br/>
								<font color="#333333">
								 エンバシーは今年設立40周年を迎え、アメリカ、カナダ、イギリス、オーストラリア、ニュージーランドの5カ国主要都市に23のセンターを持つ語学学校です。
								</font>
							</td>
							<td class="kuni">
								<a href="/school/worldwide.html"><img src="../images/worldwide_flag.gif" alt="" /><br/>World wide</a>
							</td>
						</tr>
					</table>
				';
				break;
		}

?>




			<?php echo $kaijo; ?>


<div style="height:30px;">&nbsp;</div>
<div style="text-align:center;">
	<img src="../images/flag01.gif">
	<img src="../images/flag03.gif">
	<img src="../images/flag09.gif">
	<img src="../images/flag05.gif">
	<img src="../images/flag06.gif">
	<img src="../images/mflag11.gif" width="40" height="26">
	<img src="../images/flag08.gif">
	<img src="../images/flag04.gif">
	<img src="../images/flag02.gif">
	<img src="../images/flag10.gif">
	<img src="../images/flag07.gif">
</div>

	<div style="height:50px;">&nbsp;</div>


	</div>
	</div>
	</div>
  </div>
  
  <div id="yoyakuform" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">

	<div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">イベント　予約フォーム</div>

	<form name="form_yoyaku" id="form_yoyaku">
	<table style="width:560px;">
		<tr style="background-color:lightblue;">
			<td nowrap style="text-align:right;">セミナー名&nbsp;</td>
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
		<img src="../images/ajaxwait.gif">
		&nbsp;予約処理中です。しばらくお待ちください。&nbsp;
		<img src="../images/ajaxwait.gif">
	</div>

	<input type="button" class="button_cancel" value=" 取消 " onClick="btn_cancel();">　　　　　
	<input type="button" class="button_submit" value=" 送信 " id="btn_soushin" onClick="btn_submit();">

</div>
<?php 
	//---------------------------------------------------
	//Function to translate City name English to Japanese
	//---------------------------------------------------
	function translate_city ($cityname = 'tokyo')
	{
	
		$array_cities = array(	'tokyo' 		=> '東京',
								'osaka' 		=> '大阪',
								'sendai'		=> '仙台',
								'toyama' 		=> '大阪',
								'fukuoka'		=> '福岡',
								'okinawa'		=> '沖縄',
								'toyama'		=> '富山',
								'nagoya'		=> '名古屋',
								'event'			=> 'イベント'
							);
		
		$japanese_cityname = $array_cities[$cityname];
		
		return $japanese_cityname;
	}
?>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>