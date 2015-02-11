<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='２０１１年夏セミナー';
$header_obj->keywords_page='オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館';
$header_obj->description_page='よくある質問：オーストラリア・ニュージーランド・カナダを初めとしたワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。';
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
	width: 80px;
	height: 30px;
	text-align: center;
	vertical-align: middle;
	font-size: 12pt;
	color: white;
	margin: 0 5px 5px 0;
}
</style>';
$header_obj->add_js_files='<script type="text/javascript" src="/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="/js/jquery.corner.js"></script>
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
	location.href = "./summer.php?key="+id+"#yoyaku";
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

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/summerevent/top.gif" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '２０１１年夏　留学・ワーキングホリデーセミナー';


$header_obj->display_header();

?>
<?php 

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

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$sql  = 'SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking FROM event_list WHERE ';
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

			if ($row['place'] == 'event' || $row['place'] == 'sendai' || $row['place'] == 'okinawa')	{
				// イベント
				$evt_id[] = $row['id'];
				$evt_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
				$evt_title[] = $row['k_title1'];
				$evt_desc[]  = $row['k_desc1'];
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
							$evt_btn[]	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[イベント]'.$row['k_title1'].'" uid="'.$row['id'].'">';
						}else{
							$evt_btn[]	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[イベント]'.$row['k_title1'].'" uid="'.$row['id'].'">';
						}
					}
				}
				$cal[$year.$month.$day] .= '<img src="../images/sa04.jpg">';
			}

		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}


?>
	<div id="maincontent">
	  <?php echo $header_obj->breadcrumbs(); ?>
		<h2 class="sec-title">夏限定！ 日本一周 ワーキングホリデーセミナーツアー 2011</h2>

		<p class="text01">
			日本ワーキングホリデー協会では、２０１１年夏に全国でワーキングホリデーセミナーを開催します。<br/>
			東京・大阪・福岡で通常開催されているセミナーに、ご近所の会場で参加することが出来ます。<br/>
		</p>
		<p class="text01">
		</p>
		<p class="text01">
		</p>

		<div style="border: 2px dotted navy; font-size:10pt; margin: 10px 10px 10px 10px; padding: 10px 20px 10px 20px;">
			ワーキングホリデーって何？　どんなことが出来るの？　予算はどのくらいかかるの？<br/>
			帰国してからの就職先が心配...　　初めての海外だけどワーホリで大丈夫？<br/>
			聞きたい事や、心配な事もたくさんあると思います。何でも聞いてください。<br/>
			セミナーの参加者は８割以上の方が、お１人での参加です。お気軽にご参加ください。<br/>
		</div>
			<img  src="../images/summerevent/muryouseminar.gif" /><br/>
		<br /><br />
		<div align="center" style="height:390px;">
			<img  src="../images/summerevent/map.gif" />


<!-- 順序入れ替え禁止！！　追加時は、一番したに！！ -->
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
<!-- 順序入れ替え禁止！！　追加時は、一番したに！！ -->

		</div>

<center>
	<p>
		&nbsp;<br/>
		日本地図上、又は以下から、会場を選択してください。<br/>
		&nbsp;<br/>
	</p>
	<table style="margin-left:15px;">
		<tr>
			<td>
				<div class="chiiki" style="background-color:#3153ff" id="sapporo">北海道</div>
				<div class="chiiki" style="background-color:#00a898" id="aomori">青森</div>
				<div class="chiiki" style="background-color:#00a898" id="sendai">仙台</div>
				<div class="chiiki" style="background-color:#00a898" id="fukushima">福島</div>
				<div class="chiiki" style="background-color:#00a898" id="niigata">新潟</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="chiiki" style="background-color:#2bad36" id="omiya">大宮</div>
				<div class="chiiki" style="background-color:#2bad36" id="chiba">千葉</div>
				<div class="chiiki" style="background-color:#2bad36" id="yokohama">横浜</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="chiiki" style="background-color:#047235" id="shizuoka">静岡</div>
				<div class="chiiki" style="background-color:#047235" id="nagoya">名古屋</div>
				<div class="chiiki" style="background-color:#f39a06" id="kyoto">京都</div>
				<div class="chiiki" style="background-color:#f39a06" id="kobe">神戸</div>
			</td>
		</tr>
		<tr>
			<td>
				<div class="chiiki" style="background-color:#ff7661" id="hiroshima">広島</div>
				<div class="chiiki" style="background-color:#ea5a16" id="kagawa">香川</div>
				<div class="chiiki" style="background-color:#ea3621" id="kumamoto">熊本</div>
				<div class="chiiki" style="background-color:#ea3621" id="kagoshima">鹿児島</div>
				<div class="chiiki" style="background-color:#98148d" id="okinawa">沖縄</div>
			</td>
		</tr>
	</table>
</center>

		<div style="height:50px;">
		<p class="text01"><div align="center" style="font-size:13pt;"><b><a href="../seminar.html">東京・大阪・福岡では通常通り随時開催中！</a></b></div></p>
		</div>
	<center>
		<table style="margin-left:15px;">
			<tr>
				<td>
					<a href="../seminar.html#tokyo-semi"><div class="chiiki" style="background-color:#add8e6;color:black;" id="tokyo">東京</div></a>
					<a href="../seminar.html#osaka-semi"><div class="chiiki" style="background-color:#add8e6;color:black;" id="osaka">大阪</div></a>
					<a href="../seminar.html#fukuoka-semi"><div class="chiiki" style="background-color:#add8e6;color:black;" id="fukuoka">福岡</div></a>
				</td>
			</tr>
		</table>
	</center>

		<h2 id="yoyaku" class="sec-title">ご予約</h2>
		<div style="height:50px;">&nbsp;</div>

	<div style="border: 2px dotted navy; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:10pt;">
		【ご注意：スマートフォンをご利用の方へ】<br/>
		スマートフォンなど、ＰＣ以外のブラウザからご利用された場合、予約フォームが正しく機能しない場合があります。<br/>
		この場合、お手数ですが、以下の内容を toiawase@jawhm.or.jp までご連絡ください。<br/>
		　・　参加希望のイベントの会場名、日程<br/>
		　・　お名前<br/>
		　・　当日連絡の付く電話番号<br/>
		　・　興味のある国<br/>
		　・　出発予定時期<br/>
	</div>
	<img  src="../images/summerevent/muryouseminar.gif" /><br/>

	<div style="padding-left:30px;">
<?php
	if ($para == '')	{
?>
			<div style="border: 2px dotted pink; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
				開催地を選択してください。
			</div>
<?php
	}else{
		if (count($evt_title) == 0)	{
?>
			<div style="border: 2px dotted pink; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
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
					print $evt_btn[$idx].'&nbsp;&nbsp;'.$evt_title[$idx];
				}
				print '</div>';
				print '<table><tr><td>'.$evt_img[$idx].'</td>';
				print '<td><p>'.nl2br($evt_desc[$idx]).'</p></td></tr></table>';
			}
		}
	}
?>
	</div>


	<div style="border: 2px dotted navy; margin: 10px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
		イベントのご予約は、各イベント日程に表示された「予約」ボタンをご利用ください。<br/>
		各イベントへのご質問は toiawase@jawhm.or.jp　にメールをお願いいたします。<br/>
		なお、当日のイベントのご予約は、03-6304-5858までご連絡ください。<br/>
	</div>

		<h2 class="sec-title">会場のご案内</h2>
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
			case "sapporo":
				$kaijo  = '';
				$kaijo .= '北方圏センター札幌国際センター<br/>';
				$kaijo .= '〒003-0026 札幌市白石区本通16丁目南４番25号<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.nrc.or.jp/center/smap.html">http://www.nrc.or.jp/center/smap.html</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E6%9C%AD%E5%B9%8C%E5%B8%82%E7%99%BD%E7%9F%B3%E5%8C%BA%E6%9C%AC%E9%80%9A16%E4%B8%81%E7%9B%AE%E5%8D%97%EF%BC%94%E7%95%AA25%E5%8F%B7&amp;aq=&amp;sll=43.037152,141.389236&amp;sspn=0.090714,0.237236&amp;brcurrent=3,0x5f0b2b0b0159256b:0xcfab34325ce97107,0,0x5f0b2b0babd6e6e3:0x59b778dde6c8c4fe&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%8C%97%E6%B5%B7%E9%81%93%E6%9C%AD%E5%B9%8C%E5%B8%82%E7%99%BD%E7%9F%B3%E5%8C%BA%E6%9C%AC%E9%80%9A%EF%BC%88%E5%8D%97%EF%BC%89+%EF%BC%91%EF%BC%96%E4%B8%81%E7%9B%AE%E5%8D%97%EF%BC%94%E2%88%92%EF%BC%92%EF%BC%95&amp;ll=43.03577,141.432221&amp;spn=0.01134,0.021479&amp;z=14&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E6%9C%AD%E5%B9%8C%E5%B8%82%E7%99%BD%E7%9F%B3%E5%8C%BA%E6%9C%AC%E9%80%9A16%E4%B8%81%E7%9B%AE%E5%8D%97%EF%BC%94%E7%95%AA25%E5%8F%B7&amp;aq=&amp;sll=43.037152,141.389236&amp;sspn=0.090714,0.237236&amp;brcurrent=3,0x5f0b2b0b0159256b:0xcfab34325ce97107,0,0x5f0b2b0babd6e6e3:0x59b778dde6c8c4fe&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%8C%97%E6%B5%B7%E9%81%93%E6%9C%AD%E5%B9%8C%E5%B8%82%E7%99%BD%E7%9F%B3%E5%8C%BA%E6%9C%AC%E9%80%9A%EF%BC%88%E5%8D%97%EF%BC%89+%EF%BC%91%EF%BC%96%E4%B8%81%E7%9B%AE%E5%8D%97%EF%BC%94%E2%88%92%EF%BC%92%EF%BC%95&amp;ll=43.03577,141.432221&amp;spn=0.01134,0.021479&amp;z=14" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "sendai":
				$kaijo  = '';
				$kaijo .= '産業・情報プラザ　ＡＥＲ５階　６階<br/>';
				$kaijo .= '〒980-6105　仙台市青葉区中央1丁目3番1号<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.siip.city.sendai.jp/netu/accessmap.html">http://www.siip.city.sendai.jp/netu/accessmap.html</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E4%BB%99%E5%8F%B0%E5%B8%82%E9%9D%92%E8%91%89%E5%8C%BA%E4%B8%AD%E5%A4%AE1%E4%B8%81%E7%9B%AE3%E7%95%AA1%E5%8F%B7&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=53.771526,87.978516&amp;brcurrent=3,0x5f8a28222db8bb65:0x7f2e7ec545495424,0,0x5f8a28222ba1a875:0xb340d14dbb8a6f6b&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%AE%AE%E5%9F%8E%E7%9C%8C%E4%BB%99%E5%8F%B0%E5%B8%82%E9%9D%92%E8%91%89%E5%8C%BA%E4%B8%AD%E5%A4%AE%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%93%E2%88%92%EF%BC%91&amp;ll=38.262648,140.881119&amp;spn=0.023587,0.036478&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E4%BB%99%E5%8F%B0%E5%B8%82%E9%9D%92%E8%91%89%E5%8C%BA%E4%B8%AD%E5%A4%AE1%E4%B8%81%E7%9B%AE3%E7%95%AA1%E5%8F%B7&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=53.771526,87.978516&amp;brcurrent=3,0x5f8a28222db8bb65:0x7f2e7ec545495424,0,0x5f8a28222ba1a875:0xb340d14dbb8a6f6b&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%AE%AE%E5%9F%8E%E7%9C%8C%E4%BB%99%E5%8F%B0%E5%B8%82%E9%9D%92%E8%91%89%E5%8C%BA%E4%B8%AD%E5%A4%AE%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%93%E2%88%92%EF%BC%91&amp;ll=38.262648,140.881119&amp;spn=0.023587,0.036478&amp;z=14&amp;iwloc=A" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "fukushima":
				$kaijo  = '';
				$kaijo .= 'コロッセ福島<br/>';
				$kaijo .= '福島県福島市三河南町1番20号<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.corasse.com/category/access">http://www.corasse.com/category/access</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E7%A6%8F%E5%B3%B6%E7%9C%8C%E7%A6%8F%E5%B3%B6%E5%B8%82%E4%B8%89%E6%B2%B3%E5%8D%97%E7%94%BA1%E7%95%AA20%E5%8F%B7&amp;aq=&amp;sll=40.824464,140.756842&amp;sspn=0.01174,0.021479&amp;brcurrent=3,0x5f8a85c6493610c9:0x1ff6c154267ef60,0,0x5f8a85c635630d21:0xacf56135c71a647c&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%A6%8F%E5%B3%B6%E7%9C%8C%E7%A6%8F%E5%B3%B6%E5%B8%82%E4%B8%89%E6%B2%B3%E5%8D%97%E7%94%BA%EF%BC%91%E2%88%92%EF%BC%92%EF%BC%90&amp;z=14&amp;ll=37.756817,140.458127&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E7%A6%8F%E5%B3%B6%E7%9C%8C%E7%A6%8F%E5%B3%B6%E5%B8%82%E4%B8%89%E6%B2%B3%E5%8D%97%E7%94%BA1%E7%95%AA20%E5%8F%B7&amp;aq=&amp;sll=40.824464,140.756842&amp;sspn=0.01174,0.021479&amp;brcurrent=3,0x5f8a85c6493610c9:0x1ff6c154267ef60,0,0x5f8a85c635630d21:0xacf56135c71a647c&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%A6%8F%E5%B3%B6%E7%9C%8C%E7%A6%8F%E5%B3%B6%E5%B8%82%E4%B8%89%E6%B2%B3%E5%8D%97%E7%94%BA%EF%BC%91%E2%88%92%EF%BC%92%EF%BC%90&amp;z=14&amp;ll=37.756817,140.458127" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "omiya":
				break;
			case "chiba":
				$kaijo  = '';
				$kaijo .= '千葉市生涯学習センター<br/>';
				$kaijo .= '〒260-0045　千葉市中央区弁天3丁目7番7号<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://chiba-gakushu.jp/know/know_04.html">http://chiba-gakushu.jp/know/know_04.html</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E5%8D%83%E8%91%89%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E5%BC%81%E5%A4%A93%E4%B8%81%E7%9B%AE7%E7%95%AA7%E5%8F%B7&amp;aq=&amp;sll=32.801993,130.705065&amp;sspn=0.00652,0.01074&amp;brcurrent=3,0x602284bc65322679:0x5ab7539a20d1c49b,0,0x602284bc7b15bfdb:0xb2d2deeeb063be91&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%8D%83%E8%91%89%E7%9C%8C%E5%8D%83%E8%91%89%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E5%BC%81%E5%A4%A9%EF%BC%93%E4%B8%81%E7%9B%AE%EF%BC%97%E2%88%92%EF%BC%97&amp;z=14&amp;ll=35.618257,140.114337&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E5%8D%83%E8%91%89%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E5%BC%81%E5%A4%A93%E4%B8%81%E7%9B%AE7%E7%95%AA7%E5%8F%B7&amp;aq=&amp;sll=32.801993,130.705065&amp;sspn=0.00652,0.01074&amp;brcurrent=3,0x602284bc65322679:0x5ab7539a20d1c49b,0,0x602284bc7b15bfdb:0xb2d2deeeb063be91&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%8D%83%E8%91%89%E7%9C%8C%E5%8D%83%E8%91%89%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E5%BC%81%E5%A4%A9%EF%BC%93%E4%B8%81%E7%9B%AE%EF%BC%97%E2%88%92%EF%BC%97&amp;z=14&amp;ll=35.618257,140.114337" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "yokohama":
				$kaijo  = '';
				$kaijo .= 'TKP横浜駅西口ビジネスセンター<br/>';
				$kaijo .= '〒221-0835 神奈川県横浜市神奈川区鶴屋町2-24-1<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://tkpyokohama.net/access/">http://tkpyokohama.net/access/</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E7%A5%9E%E5%A5%88%E5%B7%9D%E7%9C%8C%E6%A8%AA%E6%B5%9C%E5%B8%82%E7%A5%9E%E5%A5%88%E5%B7%9D%E5%8C%BA%E9%B6%B4%E5%B1%8B%E7%94%BA2-24-1&amp;aq=&amp;sll=35.618257,140.114337&amp;sspn=0.006306,0.01074&amp;brcurrent=3,0x60185c11c8e36b19:0xa3b1d91840cfb242,0,0x60185c11c8e36b19:0xc5827e77394d9e7a&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%A5%9E%E5%A5%88%E5%B7%9D%E7%9C%8C%E6%A8%AA%E6%B5%9C%E5%B8%82%E7%A5%9E%E5%A5%88%E5%B7%9D%E5%8C%BA%E9%B6%B4%E5%B1%8B%E7%94%BA%EF%BC%92%E4%B8%81%E7%9B%AE%EF%BC%92%EF%BC%94%E2%88%92%EF%BC%91&amp;z=14&amp;ll=35.468758,139.620734&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E7%A5%9E%E5%A5%88%E5%B7%9D%E7%9C%8C%E6%A8%AA%E6%B5%9C%E5%B8%82%E7%A5%9E%E5%A5%88%E5%B7%9D%E5%8C%BA%E9%B6%B4%E5%B1%8B%E7%94%BA2-24-1&amp;aq=&amp;sll=35.618257,140.114337&amp;sspn=0.006306,0.01074&amp;brcurrent=3,0x60185c11c8e36b19:0xa3b1d91840cfb242,0,0x60185c11c8e36b19:0xc5827e77394d9e7a&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%A5%9E%E5%A5%88%E5%B7%9D%E7%9C%8C%E6%A8%AA%E6%B5%9C%E5%B8%82%E7%A5%9E%E5%A5%88%E5%B7%9D%E5%8C%BA%E9%B6%B4%E5%B1%8B%E7%94%BA%EF%BC%92%E4%B8%81%E7%9B%AE%EF%BC%92%EF%BC%94%E2%88%92%EF%BC%91&amp;z=14&amp;ll=35.468758,139.620734" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "shizuoka":
				$kaijo  = '';
				$kaijo .= '<div style="padding:10px 20px 10px 20px; font-size:12pt; font-weight:bold; color:red; border: 1px dotted navy;">';
				$kaijo .= '※　ご注意<br/>';
				$kaijo .= '　　日程により会場が異なります。お間違いのないようにご注意ください。<br/>';
				$kaijo .= '</div>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '【８月１３日の会場】<br/>';
				$kaijo .= '静岡市民文化会館<br/>';
				$kaijo .= '〒420-0856　静岡県静岡市葵区駿府町2－90<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.scch.shizuoka-city.or.jp/page019.html">http://www.scch.shizuoka-city.or.jp/page019.html</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E9%9D%99%E5%B2%A1%E7%9C%8C%E9%9D%99%E5%B2%A1%E5%B8%82%E8%91%B5%E5%8C%BA%E9%A7%BF%E5%BA%9C%E7%94%BA2%EF%BC%8D90&amp;aq=&amp;sll=38.26263,140.881099&amp;sspn=0.006537,0.01074&amp;brcurrent=3,0x601a4a1b6dc3f609:0x1fa482344972a3f,0,0x601a4a1ba6c0a4a7:0x1f4abb1d7c0d4120&amp;ie=UTF8&amp;hq=&amp;hnear=%E9%9D%99%E5%B2%A1%E7%9C%8C%E9%9D%99%E5%B2%A1%E5%B8%82%E8%91%B5%E5%8C%BA%E9%A7%BF%E5%BA%9C%E7%94%BA%EF%BC%92%E2%88%92%EF%BC%99%EF%BC%90&amp;z=14&amp;ll=34.98085,138.387067&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E9%9D%99%E5%B2%A1%E7%9C%8C%E9%9D%99%E5%B2%A1%E5%B8%82%E8%91%B5%E5%8C%BA%E9%A7%BF%E5%BA%9C%E7%94%BA2%EF%BC%8D90&amp;aq=&amp;sll=38.26263,140.881099&amp;sspn=0.006537,0.01074&amp;brcurrent=3,0x601a4a1b6dc3f609:0x1fa482344972a3f,0,0x601a4a1ba6c0a4a7:0x1f4abb1d7c0d4120&amp;ie=UTF8&amp;hq=&amp;hnear=%E9%9D%99%E5%B2%A1%E7%9C%8C%E9%9D%99%E5%B2%A1%E5%B8%82%E8%91%B5%E5%8C%BA%E9%A7%BF%E5%BA%9C%E7%94%BA%EF%BC%92%E2%88%92%EF%BC%99%EF%BC%90&amp;z=14&amp;ll=34.98085,138.387067" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<hr/>';
				$kaijo .= '【８月２７，２９日の会場】<br/>';
				$kaijo .= '静岡県教育会館<br/>';
				$kaijo .= '〒420ｰ0856　静岡市葵区駿府町1-12<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www6.ocn.ne.jp/~s-kyoiku/">http://www6.ocn.ne.jp/~s-kyoiku/</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E9%9D%99%E5%B2%A1%E5%B8%82%E8%91%B5%E5%8C%BA%E9%A7%BF%E5%BA%9C%E7%94%BA1-12+&amp;aq=&amp;sll=37.756817,140.458127&amp;sspn=0.012266,0.021479&amp;brcurrent=3,0x601a4a1d9769dbf5:0x66bc74389bbc71f,0,0x601a4a1c55afbfcb:0x2f088dde633a4a33&amp;ie=UTF8&amp;hq=&amp;hnear=%E9%9D%99%E5%B2%A1%E7%9C%8C%E9%9D%99%E5%B2%A1%E5%B8%82%E8%91%B5%E5%8C%BA%E9%A7%BF%E5%BA%9C%E7%94%BA%EF%BC%91%E2%88%92%EF%BC%91%EF%BC%92&amp;z=14&amp;ll=34.975729,138.385668&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E9%9D%99%E5%B2%A1%E5%B8%82%E8%91%B5%E5%8C%BA%E9%A7%BF%E5%BA%9C%E7%94%BA1-12+&amp;aq=&amp;sll=37.756817,140.458127&amp;sspn=0.012266,0.021479&amp;brcurrent=3,0x601a4a1d9769dbf5:0x66bc74389bbc71f,0,0x601a4a1c55afbfcb:0x2f088dde633a4a33&amp;ie=UTF8&amp;hq=&amp;hnear=%E9%9D%99%E5%B2%A1%E7%9C%8C%E9%9D%99%E5%B2%A1%E5%B8%82%E8%91%B5%E5%8C%BA%E9%A7%BF%E5%BA%9C%E7%94%BA%EF%BC%91%E2%88%92%EF%BC%91%EF%BC%92&amp;z=14&amp;ll=34.975729,138.385668" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "aomori":
				$kaijo  = '';
				$kaijo .= '青森市文化会館<br/>';
				$kaijo .= '〒030-0812　青森市堤町一丁目4番1号<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.city.aomori.aomori.jp/view.rbz?cd=1716">http://www.city.aomori.aomori.jp/view.rbz?cd=1716</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E9%9D%92%E6%A3%AE%E5%B8%82%E5%A0%A4%E7%94%BA%E4%B8%80%E4%B8%81%E7%9B%AE4%E7%95%AA1%E5%8F%B7&amp;aq=&amp;sll=43.035772,141.436315&amp;sspn=0.01134,0.021479&amp;brcurrent=3,0x5f9b9efbfd1d3bdf:0x5565598c91b4aedb,0,0x5f9b9efbfd6b0209:0x757d581708270775&amp;ie=UTF8&amp;hq=&amp;hnear=%E9%9D%92%E6%A3%AE%E7%9C%8C%E9%9D%92%E6%A3%AE%E5%B8%82%E5%A0%A4%E7%94%BA%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%94%E2%88%92%EF%BC%91&amp;z=14&amp;ll=40.824464,140.756842&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E9%9D%92%E6%A3%AE%E5%B8%82%E5%A0%A4%E7%94%BA%E4%B8%80%E4%B8%81%E7%9B%AE4%E7%95%AA1%E5%8F%B7&amp;aq=&amp;sll=43.035772,141.436315&amp;sspn=0.01134,0.021479&amp;brcurrent=3,0x5f9b9efbfd1d3bdf:0x5565598c91b4aedb,0,0x5f9b9efbfd6b0209:0x757d581708270775&amp;ie=UTF8&amp;hq=&amp;hnear=%E9%9D%92%E6%A3%AE%E7%9C%8C%E9%9D%92%E6%A3%AE%E5%B8%82%E5%A0%A4%E7%94%BA%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%94%E2%88%92%EF%BC%91&amp;z=14&amp;ll=40.824464,140.756842" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "niigata":
				$kaijo  = '';
				$kaijo .= '新潟国際友好会館<br/>';
				$kaijo .= '新潟市中央区礎町3ノ町2086番地　クロスパルにいがた内<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.city.niigata.jp/info/kokusai/09_kaikan/kaikantop.htm">http://www.city.niigata.jp/info/kokusai/09_kaikan/kaikantop.htm</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E6%96%B0%E6%BD%9F%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E7%A4%8E%E7%94%BA3%E3%83%8E%E7%94%BA2086%E7%95%AA%E5%9C%B0&amp;aq=&amp;sll=34.98085,138.387067&amp;sspn=0.006822,0.01074&amp;g=%E9%9D%99%E5%B2%A1%E7%9C%8C%E9%9D%99%E5%B2%A1%E5%B8%82%E8%91%B5%E5%8C%BA%E9%A7%BF%E5%BA%9C%E7%94%BA2%EF%BC%8D90&amp;brcurrent=3,0x5ff4c993759d1efd:0x868d0c7f591b741,0&amp;ie=UTF8&amp;hq=%E7%A4%8E%E7%94%BA3%E3%83%8E%E7%94%BA2086%E7%95%AA%E5%9C%B0&amp;hnear=%E6%96%B0%E6%BD%9F%E7%9C%8C%E6%96%B0%E6%BD%9F%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA&amp;ll=37.919391,139.043434&amp;spn=0.007256,0.017059&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E6%96%B0%E6%BD%9F%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E7%A4%8E%E7%94%BA3%E3%83%8E%E7%94%BA2086%E7%95%AA%E5%9C%B0&amp;aq=&amp;sll=34.98085,138.387067&amp;sspn=0.006822,0.01074&amp;g=%E9%9D%99%E5%B2%A1%E7%9C%8C%E9%9D%99%E5%B2%A1%E5%B8%82%E8%91%B5%E5%8C%BA%E9%A7%BF%E5%BA%9C%E7%94%BA2%EF%BC%8D90&amp;brcurrent=3,0x5ff4c993759d1efd:0x868d0c7f591b741,0&amp;ie=UTF8&amp;hq=%E7%A4%8E%E7%94%BA3%E3%83%8E%E7%94%BA2086%E7%95%AA%E5%9C%B0&amp;hnear=%E6%96%B0%E6%BD%9F%E7%9C%8C%E6%96%B0%E6%BD%9F%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA&amp;ll=37.919391,139.043434&amp;spn=0.007256,0.017059" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "kyoto":
				$kaijo  = '';
				$kaijo .= '<div style="padding:10px 20px 10px 20px; font-size:12pt; font-weight:bold; color:red; border: 1px dotted navy;">';
				$kaijo .= '※　ご注意<br/>';
				$kaijo .= '　　日程により会場が異なります。お間違いのないようにご注意ください。<br/>';
				$kaijo .= '</div>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '【８月１５日の会場】<br/>';
				$kaijo .= '京都会館<br/>';
				$kaijo .= '〒606-8342 京都市左京区岡崎最勝寺町13番地<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.kyoto-ongeibun.jp/kyotokaikan/map.php">http://www.kyoto-ongeibun.jp/kyotokaikan/map.php</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E4%BA%AC%E9%83%BD%E5%B8%82%E5%B7%A6%E4%BA%AC%E5%8C%BA%E5%B2%A1%E5%B4%8E%E6%9C%80%E5%8B%9D%E5%AF%BA%E7%94%BA13%E7%95%AA%E5%9C%B0&amp;aq=&amp;sll=37.919391,139.043434&amp;sspn=0.013136,0.021479&amp;brcurrent=3,0x600108e59bdf819d:0xe4a97525be89197a,0,0x600108e5bde211f3:0xb44e2496f582b5a&amp;ie=UTF8&amp;hq=&amp;hnear=%E4%BA%AC%E9%83%BD%E5%BA%9C%E4%BA%AC%E9%83%BD%E5%B8%82%E5%B7%A6%E4%BA%AC%E5%8C%BA%E5%B2%A1%E5%B4%8E%E6%9C%80%E5%8B%9D%E5%AF%BA%E7%94%BA%EF%BC%91%EF%BC%93&amp;z=14&amp;ll=35.014619,135.781425&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E4%BA%AC%E9%83%BD%E5%B8%82%E5%B7%A6%E4%BA%AC%E5%8C%BA%E5%B2%A1%E5%B4%8E%E6%9C%80%E5%8B%9D%E5%AF%BA%E7%94%BA13%E7%95%AA%E5%9C%B0&amp;aq=&amp;sll=37.919391,139.043434&amp;sspn=0.013136,0.021479&amp;brcurrent=3,0x600108e59bdf819d:0xe4a97525be89197a,0,0x600108e5bde211f3:0xb44e2496f582b5a&amp;ie=UTF8&amp;hq=&amp;hnear=%E4%BA%AC%E9%83%BD%E5%BA%9C%E4%BA%AC%E9%83%BD%E5%B8%82%E5%B7%A6%E4%BA%AC%E5%8C%BA%E5%B2%A1%E5%B4%8E%E6%9C%80%E5%8B%9D%E5%AF%BA%E7%94%BA%EF%BC%91%EF%BC%93&amp;z=14&amp;ll=35.014619,135.781425" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<hr/>';
				$kaijo .= '【８月３０日の会場】<br/>';
				$kaijo .= '京都市国際交流協会<br/>';
				$kaijo .= '〒606-8536 京都市左京区粟田口鳥居町2番地の1<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.kcif.or.jp/jp/access/">http://www.kcif.or.jp/jp/access/</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E4%BA%AC%E9%83%BD%E5%B8%82%E5%B7%A6%E4%BA%AC%E5%8C%BA%E7%B2%9F%E7%94%B0%E5%8F%A3%E9%B3%A5%E5%B1%85%E7%94%BA2%E7%95%AA%E5%9C%B0%E3%81%AE1&amp;aq=&amp;sll=34.975729,138.385668&amp;sspn=0.006356,0.01074&amp;brcurrent=3,0x600108de2c13990d:0x3a3373b2f0336137,0,0x60010920ccac4747:0x10c34bc490ff75f5&amp;ie=UTF8&amp;hq=&amp;hnear=%E4%BA%AC%E9%83%BD%E5%BA%9C%E4%BA%AC%E9%83%BD%E5%B8%82%E5%B7%A6%E4%BA%AC%E5%8C%BA%E7%B2%9F%E7%94%B0%E5%8F%A3%E9%B3%A5%E5%B1%85%E7%94%BA%EF%BC%92%E2%88%92%EF%BC%91&amp;z=14&amp;ll=35.010684,135.787447&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E4%BA%AC%E9%83%BD%E5%B8%82%E5%B7%A6%E4%BA%AC%E5%8C%BA%E7%B2%9F%E7%94%B0%E5%8F%A3%E9%B3%A5%E5%B1%85%E7%94%BA2%E7%95%AA%E5%9C%B0%E3%81%AE1&amp;aq=&amp;sll=34.975729,138.385668&amp;sspn=0.006356,0.01074&amp;brcurrent=3,0x600108de2c13990d:0x3a3373b2f0336137,0,0x60010920ccac4747:0x10c34bc490ff75f5&amp;ie=UTF8&amp;hq=&amp;hnear=%E4%BA%AC%E9%83%BD%E5%BA%9C%E4%BA%AC%E9%83%BD%E5%B8%82%E5%B7%A6%E4%BA%AC%E5%8C%BA%E7%B2%9F%E7%94%B0%E5%8F%A3%E9%B3%A5%E5%B1%85%E7%94%BA%EF%BC%92%E2%88%92%EF%BC%91&amp;z=14&amp;ll=35.010684,135.787447" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "kobe":
				$kaijo  = '';
				$kaijo .= '神戸国際協力交流センター<br/>';
				$kaijo .= '〒651-0087 神戸市中央区御幸通8-1-6 神戸国際会館20階<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.kicc.jp/access/index.html">http://www.kicc.jp/access/index.html</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E7%A5%9E%E6%88%B8%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E5%BE%A1%E5%B9%B8%E9%80%9A8-1-6&amp;aq=&amp;sll=35.014619,135.781425&amp;sspn=0.006819,0.01074&amp;brcurrent=3,0x60008efa86a3b94f:0xbc05c6cefb88335f,0,0x60008efa8552c729:0x3a1e0a6ea70cd511&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%85%B5%E5%BA%AB%E7%9C%8C%E7%A5%9E%E6%88%B8%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E5%BE%A1%E5%B9%B8%E9%80%9A%EF%BC%98%E4%B8%81%E7%9B%AE%EF%BC%91%E2%88%92%EF%BC%96&amp;z=14&amp;ll=34.692049,135.195828&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E7%A5%9E%E6%88%B8%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E5%BE%A1%E5%B9%B8%E9%80%9A8-1-6&amp;aq=&amp;sll=35.014619,135.781425&amp;sspn=0.006819,0.01074&amp;brcurrent=3,0x60008efa86a3b94f:0xbc05c6cefb88335f,0,0x60008efa8552c729:0x3a1e0a6ea70cd511&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%85%B5%E5%BA%AB%E7%9C%8C%E7%A5%9E%E6%88%B8%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E5%BE%A1%E5%B9%B8%E9%80%9A%EF%BC%98%E4%B8%81%E7%9B%AE%EF%BC%91%E2%88%92%EF%BC%96&amp;z=14&amp;ll=34.692049,135.195828" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "hiroshima":
				$kaijo  = '';
				$kaijo .= 'ひろしま国際センター<br/>';
				$kaijo .= '〒730-0037 広島市中区中町8-18 広島クリスタルプラザ6F<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://hiroshima-ic.or.jp/">http://hiroshima-ic.or.jp/</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E5%BA%83%E5%B3%B6%E5%B8%82%E4%B8%AD%E5%8C%BA%E4%B8%AD%E7%94%BA8-18&amp;aq=&amp;sll=34.341994,134.046002&amp;sspn=0.006405,0.01074&amp;brcurrent=3,0x355aa211f420a51d:0x3e76eb64220660f1,0,0x355aa211f21fde53:0xd49d5a52733ba856&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%BA%83%E5%B3%B6%E7%9C%8C%E5%BA%83%E5%B3%B6%E5%B8%82%E4%B8%AD%E5%8C%BA%E4%B8%AD%E7%94%BA%EF%BC%98%E2%88%92%EF%BC%91%EF%BC%98&amp;z=14&amp;ll=34.389964,132.457942&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E5%BA%83%E5%B3%B6%E5%B8%82%E4%B8%AD%E5%8C%BA%E4%B8%AD%E7%94%BA8-18&amp;aq=&amp;sll=34.341994,134.046002&amp;sspn=0.006405,0.01074&amp;brcurrent=3,0x355aa211f420a51d:0x3e76eb64220660f1,0,0x355aa211f21fde53:0xd49d5a52733ba856&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%BA%83%E5%B3%B6%E7%9C%8C%E5%BA%83%E5%B3%B6%E5%B8%82%E4%B8%AD%E5%8C%BA%E4%B8%AD%E7%94%BA%EF%BC%98%E2%88%92%EF%BC%91%EF%BC%98&amp;z=14&amp;ll=34.389964,132.457942" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "kumamoto":
				$kaijo  = '';
				$kaijo .= '熊本交流会館<br/>';
				$kaijo .= '〒860-0806　熊本市花畑町４番８号<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.kumamoto-if.or.jp/kcic/access/access.asp">http://www.kumamoto-if.or.jp/kcic/access/access.asp</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E7%86%8A%E6%9C%AC%E5%B8%82%E8%8A%B1%E7%95%91%E7%94%BA%EF%BC%94%E7%95%AA%EF%BC%98%E5%8F%B7&amp;aq=&amp;sll=34.389964,132.457942&amp;sspn=0.006401,0.01074&amp;brcurrent=3,0x3540f412b01b8327:0x41ab85f37c39875d,0,0x3540f412a583ad15:0xd637a79a20553b8c&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%86%8A%E6%9C%AC%E7%9C%8C%E7%86%8A%E6%9C%AC%E5%B8%82%E8%8A%B1%E7%95%91%E7%94%BA%EF%BC%94%E2%88%92%EF%BC%98&amp;z=14&amp;ll=32.801995,130.705061&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E7%86%8A%E6%9C%AC%E5%B8%82%E8%8A%B1%E7%95%91%E7%94%BA%EF%BC%94%E7%95%AA%EF%BC%98%E5%8F%B7&amp;aq=&amp;sll=34.389964,132.457942&amp;sspn=0.006401,0.01074&amp;brcurrent=3,0x3540f412b01b8327:0x41ab85f37c39875d,0,0x3540f412a583ad15:0xd637a79a20553b8c&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%86%8A%E6%9C%AC%E7%9C%8C%E7%86%8A%E6%9C%AC%E5%B8%82%E8%8A%B1%E7%95%91%E7%94%BA%EF%BC%94%E2%88%92%EF%BC%98&amp;z=14&amp;ll=32.801995,130.705061" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "kagoshima":
				$kaijo  = '';
				$kaijo .= 'かごしま県民交流センター<br/>';
				$kaijo .= '〒892-0816　鹿児島市山下町１４－５０<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.kagoshima-pac.jp/jp/center/access/index.html">http://www.kagoshima-pac.jp/jp/center/access/index.html</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E9%B9%BF%E5%85%90%E5%B3%B6%E5%B8%82%E5%B1%B1%E4%B8%8B%E7%94%BA%EF%BC%91%EF%BC%94%EF%BC%8D%EF%BC%95%EF%BC%90&amp;aq=&amp;sll=35.010684,135.787447&amp;sspn=0.006353,0.01074&amp;brcurrent=3,0x353e5e08a7e80629:0x93561e433aabfa03,0,0x353e5e061c481533:0x330accf6027db88b&amp;ie=UTF8&amp;hq=&amp;hnear=%E9%B9%BF%E5%85%90%E5%B3%B6%E7%9C%8C%E9%B9%BF%E5%85%90%E5%B3%B6%E5%B8%82%E5%B1%B1%E4%B8%8B%E7%94%BA%EF%BC%91%EF%BC%94%E2%88%92%EF%BC%95%EF%BC%90&amp;z=14&amp;ll=31.59957,130.557804&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E9%B9%BF%E5%85%90%E5%B3%B6%E5%B8%82%E5%B1%B1%E4%B8%8B%E7%94%BA%EF%BC%91%EF%BC%94%EF%BC%8D%EF%BC%95%EF%BC%90&amp;aq=&amp;sll=35.010684,135.787447&amp;sspn=0.006353,0.01074&amp;brcurrent=3,0x353e5e08a7e80629:0x93561e433aabfa03,0,0x353e5e061c481533:0x330accf6027db88b&amp;ie=UTF8&amp;hq=&amp;hnear=%E9%B9%BF%E5%85%90%E5%B3%B6%E7%9C%8C%E9%B9%BF%E5%85%90%E5%B3%B6%E5%B8%82%E5%B1%B1%E4%B8%8B%E7%94%BA%EF%BC%91%EF%BC%94%E2%88%92%EF%BC%95%EF%BC%90&amp;z=14&amp;ll=31.59957,130.557804" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "nagoya":
				$kaijo  = '';
				$kaijo .= '名古屋国際センター<br/>';
				$kaijo .= '450-0001 名古屋市中村区那古野一丁目47番1号 名古屋国際センター<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.nic-nagoya.or.jp/japanese/nicnews/aramashi/nicaccess">http://www.nic-nagoya.or.jp/japanese/nicnews/aramashi/nicaccess</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E9%82%A3%E5%8F%A4%E9%87%8E%E4%B8%80%E4%B8%81%E7%9B%AE47%E7%95%AA1%E5%8F%B7&amp;aq=&amp;sll=34.692049,135.195828&amp;sspn=0.006845,0.01074&amp;brcurrent=3,0x600376dbae2f60bb:0xedc83b4b7f98b25f,0,0x600376dbade7db2f:0x6a8daf90d8b21e89&amp;ie=UTF8&amp;hq=&amp;hnear=%E6%84%9B%E7%9F%A5%E7%9C%8C%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E9%82%A3%E5%8F%A4%E9%87%8E%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%94%EF%BC%97%E2%88%92%EF%BC%91&amp;z=14&amp;ll=35.172805,136.890288&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E9%82%A3%E5%8F%A4%E9%87%8E%E4%B8%80%E4%B8%81%E7%9B%AE47%E7%95%AA1%E5%8F%B7&amp;aq=&amp;sll=34.692049,135.195828&amp;sspn=0.006845,0.01074&amp;brcurrent=3,0x600376dbae2f60bb:0xedc83b4b7f98b25f,0,0x600376dbade7db2f:0x6a8daf90d8b21e89&amp;ie=UTF8&amp;hq=&amp;hnear=%E6%84%9B%E7%9F%A5%E7%9C%8C%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E9%82%A3%E5%8F%A4%E9%87%8E%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%94%EF%BC%97%E2%88%92%EF%BC%91&amp;z=14&amp;ll=35.172805,136.890288" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "kagawa":
				$kaijo  = '';
				$kaijo .= '香川国際交流会館（アイパル香川）<br/>';
				$kaijo .= '〒760-0017　 香川県高松市番町一丁目 11‐63<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.i-pal.or.jp/what/">http://www.i-pal.or.jp/what/</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E9%A6%99%E5%B7%9D%E7%9C%8C%E9%AB%98%E6%9D%BE%E5%B8%82%E7%95%AA%E7%94%BA%E4%B8%80%E4%B8%81%E7%9B%AE+11%E2%80%9063&amp;aq=&amp;sll=31.59957,130.557804&amp;sspn=0.006607,0.01074&amp;brcurrent=3,0x3553eb91205eee39:0x3abbbae67b91ee8c,0,0x3553eb90daa188f7:0xc2f2138e1801b4f4&amp;ie=UTF8&amp;hq=&amp;hnear=%E9%A6%99%E5%B7%9D%E7%9C%8C%E9%AB%98%E6%9D%BE%E5%B8%82%E7%95%AA%E7%94%BA%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%EF%BC%91%E2%88%92%EF%BC%96%EF%BC%93&amp;z=14&amp;ll=34.341994,134.046002&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E9%A6%99%E5%B7%9D%E7%9C%8C%E9%AB%98%E6%9D%BE%E5%B8%82%E7%95%AA%E7%94%BA%E4%B8%80%E4%B8%81%E7%9B%AE+11%E2%80%9063&amp;aq=&amp;sll=31.59957,130.557804&amp;sspn=0.006607,0.01074&amp;brcurrent=3,0x3553eb91205eee39:0x3abbbae67b91ee8c,0,0x3553eb90daa188f7:0xc2f2138e1801b4f4&amp;ie=UTF8&amp;hq=&amp;hnear=%E9%A6%99%E5%B7%9D%E7%9C%8C%E9%AB%98%E6%9D%BE%E5%B8%82%E7%95%AA%E7%94%BA%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%EF%BC%91%E2%88%92%EF%BC%96%EF%BC%93&amp;z=14&amp;ll=34.341994,134.046002" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "okinawa":
				$kaijo  = '';
				$kaijo .= '';
				$kaijo .= 'ｅ－ｓａ （イーサ）<br/>';
				$kaijo .= '沖縄県中頭郡北谷町美浜１５−６９ カーニバルパークミハマ１F<br/>';
				$kaijo .= '当日の連絡先：098-926-0667<br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E6%B2%96%E7%B8%84%E7%9C%8C%E4%B8%AD%E9%A0%AD%E9%83%A1%E5%8C%97%E8%B0%B7%E7%94%BA%E7%BE%8E%E6%B5%9C%EF%BC%91%EF%BC%95%E2%88%92%EF%BC%96%EF%BC%99&amp;aq=&amp;sll=26.318471,127.760702&amp;sspn=0.007463,0.01074&amp;brcurrent=3,0x34e513050874a5e5:0x93e8709ac2999766,0,0x34e51305bc2c1d0b:0x8b071c54c8ecb0be&amp;ie=UTF8&amp;hq=&amp;hnear=%E6%B2%96%E7%B8%84%E7%9C%8C%E4%B8%AD%E9%A0%AD%E9%83%A1%E5%8C%97%E8%B0%B7%E7%94%BA%E7%BE%8E%E6%B5%9C%EF%BC%88%E5%AD%97%EF%BC%89+%EF%BC%91%EF%BC%95%E2%88%92%EF%BC%96%EF%BC%99&amp;ll=26.318469,127.760707&amp;spn=0.007463,0.01074&amp;z=14&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E6%B2%96%E7%B8%84%E7%9C%8C%E4%B8%AD%E9%A0%AD%E9%83%A1%E5%8C%97%E8%B0%B7%E7%94%BA%E7%BE%8E%E6%B5%9C%EF%BC%91%EF%BC%95%E2%88%92%EF%BC%96%EF%BC%99&amp;aq=&amp;sll=26.318471,127.760702&amp;sspn=0.007463,0.01074&amp;brcurrent=3,0x34e513050874a5e5:0x93e8709ac2999766,0,0x34e51305bc2c1d0b:0x8b071c54c8ecb0be&amp;ie=UTF8&amp;hq=&amp;hnear=%E6%B2%96%E7%B8%84%E7%9C%8C%E4%B8%AD%E9%A0%AD%E9%83%A1%E5%8C%97%E8%B0%B7%E7%94%BA%E7%BE%8E%E6%B5%9C%EF%BC%88%E5%AD%97%EF%BC%89+%EF%BC%91%EF%BC%95%E2%88%92%EF%BC%96%EF%BC%99&amp;ll=26.318469,127.760707&amp;spn=0.007463,0.01074&amp;z=14" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
		}

?>
		<div style="border: 1px dotted pink; font-size:11pt; margin: 10px 10px 10px 10px; padding: 10px 20px 10px 20px;">
			<?php echo $kaijo; ?>
		</div>

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
		<img src="../images/ajaxwait.gif">
		&nbsp;予約処理中です。しばらくお待ちください。&nbsp;
		<img src="../images/ajaxwait.gif">
	</div>

	<input type="button" class="button_cancel" value=" 取消 " onClick="btn_cancel();">　　　　　
	<input type="button" class="button_submit" value=" 送信 " id="btn_soushin" onClick="btn_submit();">

</div>

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>