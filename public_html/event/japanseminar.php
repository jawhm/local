<?php
require_once '../include/header.php';
$header_obj = new Header();

$header_obj->title_page='日本全国留学・ワーキングホリデーセミナー2012';
$header_obj->keywords_page='ワーキングホリデー,留学,オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,学生,留学,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館';
$header_obj->description_page='今年もやります。ワーキングホリデー（ワーホリ）・留学セミナー。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデー（ワーホリ）をされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';
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
	location.href = "./japanseminar.php?key="+id+"#yoyaku";
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

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/japanseminar/mainimg.gif" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '日本全国留学・ワーキングホリデーセミナー2012';

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
		<h2 class="sec-title">日本全国留学・ワーキングホリデー無料セミナー　</h2>

		<p class="text01">
			日本ワーキングホリデー協会では、全国でワーキングホリデーセミナーを随時開催しております。<br/>
			東京・大阪・福岡で通常開催されているセミナーに、ご近所の会場で参加することが出来ますので是非ご参加下さい。<br/>
		</p>
		<p class="text01">
		</p>
		<p class="text01">
		</p>

		<div style="border: 2px dotted navy; font-size:10pt; margin: 10px 10px 10px 10px; padding: 10px 20px 10px 20px;">
			<b>留学</b> ・ <b>ワーキングホリデー</b> って何？　どんなことが出来るの？　予算はどのくらいかかるの？<br/>
			帰国してからの就職先が心配...　　初めての海外だけどワーホリで大丈夫？<br/>
			聞きたい事や、心配な事もたくさんあると思います。何でも聞いてください。<br/>
			セミナーの参加者は８割以上の方が、お１人での参加です。お気軽にご参加ください。<br/>
		</div>
		
		<table style="background-image:url(../images/japanseminar/seminarmap.gif); background-repeat:no-repeat;">
		<tr>
		<td>
		<div class="chiiki2" id="sendai"><img  src="../images/japanseminar/sendai_off.gif"  style="margin:100px 0px 0px 490px" /></div><br />
		
		<div class="chiiki2" id="omiya"><img  src="../images/japanseminar/omiya_off.gif"  style="margin:163px 0px 0px 480px" /></div><br />
	
		<div class="chiiki2" id="fukuoka"><img  src="../images/japanseminar/fukuoka_off.gif" style="margin:180px 0px 0px 50px" /></div><br />

		<img  src="../images/japanseminar/chiba_off.gif" style="margin:210px 0px 0px 500px" /><br />

		<img  src="../images/japanseminar/yokohama_off.gif" style="margin:5px 0px 0px 440px" /><br />

		<div class="chiiki2" id="nagoya"><img  src="../images/japanseminar/nagoya_off.gif"  style="margin:-90px 0px 0px 290px" /></div><br />

		<div class="chiiki2" id="miyazaki"><img  src="../images/japanseminar/miyzaki.gif" style="margin:-40px 0px 0px 138px" /></div><br />

		<div class="chiiki2" id="okinawa"><img  src="../images/japanseminar/okinawa.gif" style="margin:-16px 0px 0px 30px" /></div><br />
		<br /><br />
		</td>
		</tr>
		</table>

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

	
	<p>
		&nbsp;<br/>
		日本地図上、又は以下から、会場を選択してください。<br/>
		&nbsp;<br/>
	</p>

	<table style="margin-left:15px;">
		<tr>
			<td>
				<div class="chiiki" style="background-color:#00a898" id="sendai">仙台</div>
				<div class="chiiki" style="background-color:#2bad36" id="omiya">大宮</div>
				<div class="chiiki" style="background-color:#047235" id="nagoya">名古屋</div>
				<div class="chiiki" style="background-color:#ea3621" id="fukuoka">福岡</div>
				<div class="chiiki" style="background-color:orange" id="miyazaki">宮崎</div>
				<div class="chiiki" style="background-color:#98148d" id="okinawa">沖縄</div>

			</td>
		</tr>
	
		</tr>
	</table>
</center>

		<div style="height:50px;">
		<p class="text01"><div align="center" style="font-size:13pt;"><b><a href="../seminar.html">東京・大阪では通常通り随時開催中！</a></b></div></p>
		</div>

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
					print '<table><tr><td>'.$evt_btn[$idx].'</td><td>&nbsp;</td><td>'.$evt_date[$idx].'～<br/>'.$evt_title[$idx].'</td></tr></table>';
		//			print $evt_btn[$idx].'&nbsp;&nbsp;'.$evt_title[$idx].' '.$evt_date[$idx].' '.$evt_time[$idx];
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
			case "sendai":
				$kaijo  = '';
				$kaijo .= '産業・情報プラザ　ＡＥＲ５階　６階<br/>';
				$kaijo .= '〒980-6105　仙台市青葉区中央1丁目3番1号<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.siip.city.sendai.jp/netu/accessmap.html">http://www.siip.city.sendai.jp/netu/accessmap.html</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E4%BB%99%E5%8F%B0%E5%B8%82%E9%9D%92%E8%91%89%E5%8C%BA%E4%B8%AD%E5%A4%AE1%E4%B8%81%E7%9B%AE3%E7%95%AA1%E5%8F%B7&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=53.771526,87.978516&amp;brcurrent=3,0x5f8a28222db8bb65:0x7f2e7ec545495424,0,0x5f8a28222ba1a875:0xb340d14dbb8a6f6b&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%AE%AE%E5%9F%8E%E7%9C%8C%E4%BB%99%E5%8F%B0%E5%B8%82%E9%9D%92%E8%91%89%E5%8C%BA%E4%B8%AD%E5%A4%AE%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%93%E2%88%92%EF%BC%91&amp;ll=38.262648,140.881119&amp;spn=0.023587,0.036478&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E4%BB%99%E5%8F%B0%E5%B8%82%E9%9D%92%E8%91%89%E5%8C%BA%E4%B8%AD%E5%A4%AE1%E4%B8%81%E7%9B%AE3%E7%95%AA1%E5%8F%B7&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=53.771526,87.978516&amp;brcurrent=3,0x5f8a28222db8bb65:0x7f2e7ec545495424,0,0x5f8a28222ba1a875:0xb340d14dbb8a6f6b&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%AE%AE%E5%9F%8E%E7%9C%8C%E4%BB%99%E5%8F%B0%E5%B8%82%E9%9D%92%E8%91%89%E5%8C%BA%E4%B8%AD%E5%A4%AE%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%93%E2%88%92%EF%BC%91&amp;ll=38.262648,140.881119&amp;spn=0.023587,0.036478&amp;z=14&amp;iwloc=A" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "omiya":
				$kaijo  = '';
				$kaijo .= '大宮ソニックシティ';
				$kaijo .= '〒330-8669　埼玉県さいたま市大宮区桜木町1-7-5<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.sonic-city.or.jp/modules/access/">http://www.sonic-city.or.jp/modules/access/</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E5%9F%BC%E7%8E%89%E7%9C%8C%E3%81%95%E3%81%84%E3%81%9F%E3%81%BE%E5%B8%82%E5%A4%A7%E5%AE%AE%E5%8C%BA%E6%A1%9C%E6%9C%A8%E7%94%BA1-7-5&amp;sll=36.5626,136.362305&amp;sspn=36.481686,80.068359&amp;brcurrent=3,0x6018c142ea54e365:0x8d82184f7b9ddb15,0&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%9F%BC%E7%8E%89%E7%9C%8C%E3%81%95%E3%81%84%E3%81%9F%E3%81%BE%E5%B8%82%E5%A4%A7%E5%AE%AE%E5%8C%BA%E6%A1%9C%E6%9C%A8%E7%94%BA%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%97%E2%88%92%EF%BC%95&amp;t=m&amp;z=14&amp;ll=35.905323,139.619835&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E5%9F%BC%E7%8E%89%E7%9C%8C%E3%81%95%E3%81%84%E3%81%9F%E3%81%BE%E5%B8%82%E5%A4%A7%E5%AE%AE%E5%8C%BA%E6%A1%9C%E6%9C%A8%E7%94%BA1-7-5&amp;sll=36.5626,136.362305&amp;sspn=36.481686,80.068359&amp;brcurrent=3,0x6018c142ea54e365:0x8d82184f7b9ddb15,0&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%9F%BC%E7%8E%89%E7%9C%8C%E3%81%95%E3%81%84%E3%81%9F%E3%81%BE%E5%B8%82%E5%A4%A7%E5%AE%AE%E5%8C%BA%E6%A1%9C%E6%9C%A8%E7%94%BA%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%97%E2%88%92%EF%BC%95&amp;t=m&amp;z=14&amp;ll=35.905323,139.619835" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "fukuoka":
				$kaijo  = '';
				$kaijo .= '<div style="padding:10px 20px 10px 20px; font-size:12pt; font-weight:bold; color:red; border: 1px dotted navy;">';
				$kaijo .= '※　ご注意<br/>';
				$kaijo .= '　　日程により会場が異なります。お間違いのないようにご注意ください。<br/>';
				$kaijo .= '</div>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '【メイン会場】<br/>';
				$kaijo .= 'CafeBar Manly　マンリーカフェ<br/>';
				$kaijo .= '福岡県福岡市中央区今泉1‐18‐55<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.jawhm.or.jp/office/fukuoka/map.php">http://www.jawhm.or.jp/office/fukuoka/map.php</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://www.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E4%BB%8A%E6%B3%891%E2%80%9018%E2%80%9055&amp;aq=&amp;sll=33.588254,130.398928&amp;sspn=0.01228,0.015492&amp;brcurrent=3,0x35419184ecdc54dd:0xceb5791848afad89,0,0x35419184f4c9ca99:0xa5ae37e483390143&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E4%BB%8A%E6%B3%89%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%EF%BC%98%E2%88%92%EF%BC%95%EF%BC%95&amp;view=map&amp;t=m&amp;z=14&amp;ll=33.584819,130.398944&amp;output=embed"></iframe><br /><small><a href="http://www.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E4%BB%8A%E6%B3%891%E2%80%9018%E2%80%9055&amp;aq=&amp;sll=33.588254,130.398928&amp;sspn=0.01228,0.015492&amp;brcurrent=3,0x35419184ecdc54dd:0xceb5791848afad89,0,0x35419184f4c9ca99:0xa5ae37e483390143&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E4%BB%8A%E6%B3%89%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%EF%BC%98%E2%88%92%EF%BC%95%EF%BC%95&amp;view=map&amp;t=m&amp;z=14&amp;ll=33.584819,130.398944" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '【１０月１２日の会場】<br/>';
				$kaijo .= '福岡国際交流センター<br/>';
				$kaijo .= '810-0001　福岡県福岡市中央区天神１丁目１番１号（アクロス福岡内）<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.kokusaihiroba.or.jp/access/">http://www.kokusaihiroba.or.jp/access/</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E5%A4%A9%E7%A5%9E%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%E7%95%AA%EF%BC%91%E5%8F%B7&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=18.748175,78.486328&amp;brcurrent=3,0x35419191dd5af22d:0x9c07829023e90e72,0&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E5%A4%A9%E7%A5%9E%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%E2%88%92%EF%BC%91&amp;ll=33.591471,130.402349&amp;spn=0.004755,0.019162&amp;t=m&amp;z=14&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E5%A4%A9%E7%A5%9E%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%E7%95%AA%EF%BC%91%E5%8F%B7&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=18.748175,78.486328&amp;brcurrent=3,0x35419191dd5af22d:0x9c07829023e90e72,0&amp;ie=UTF8&amp;hq=&amp;hnear=%E7%A6%8F%E5%B2%A1%E7%9C%8C%E7%A6%8F%E5%B2%A1%E5%B8%82%E4%B8%AD%E5%A4%AE%E5%8C%BA%E5%A4%A9%E7%A5%9E%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%E2%88%92%EF%BC%91&amp;ll=33.591471,130.402349&amp;spn=0.004755,0.019162&amp;t=m&amp;z=14" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				$kaijo .= '<hr/>';
				break;
			case "nagoya":
				$kaijo  = '';
				$kaijo .= '名古屋国際センター<br/>';
				$kaijo .= '450-0001 名古屋市中村区那古野一丁目47番1号 名古屋国際センター<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.nic-nagoya.or.jp/japanese/nicnews/aramashi/nicaccess">http://www.nic-nagoya.or.jp/japanese/nicnews/aramashi/nicaccess</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E9%82%A3%E5%8F%A4%E9%87%8E%E4%B8%80%E4%B8%81%E7%9B%AE47%E7%95%AA1%E5%8F%B7&amp;aq=&amp;sll=34.692049,135.195828&amp;sspn=0.006845,0.01074&amp;brcurrent=3,0x600376dbae2f60bb:0xedc83b4b7f98b25f,0,0x600376dbade7db2f:0x6a8daf90d8b21e89&amp;ie=UTF8&amp;hq=&amp;hnear=%E6%84%9B%E7%9F%A5%E7%9C%8C%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E9%82%A3%E5%8F%A4%E9%87%8E%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%94%EF%BC%97%E2%88%92%EF%BC%91&amp;z=14&amp;ll=35.172805,136.890288&amp;output=embed"></iframe><br /><small><a href="http://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E9%82%A3%E5%8F%A4%E9%87%8E%E4%B8%80%E4%B8%81%E7%9B%AE47%E7%95%AA1%E5%8F%B7&amp;aq=&amp;sll=34.692049,135.195828&amp;sspn=0.006845,0.01074&amp;brcurrent=3,0x600376dbae2f60bb:0xedc83b4b7f98b25f,0,0x600376dbade7db2f:0x6a8daf90d8b21e89&amp;ie=UTF8&amp;hq=&amp;hnear=%E6%84%9B%E7%9F%A5%E7%9C%8C%E5%90%8D%E5%8F%A4%E5%B1%8B%E5%B8%82%E4%B8%AD%E6%9D%91%E5%8C%BA%E9%82%A3%E5%8F%A4%E9%87%8E%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%94%EF%BC%97%E2%88%92%EF%BC%91&amp;z=14&amp;ll=35.172805,136.890288" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "miyazaki":
				$kaijo  = '';
				$kaijo .= '';
				$kaijo .= '宮崎市民プラザ<br/>';
				$kaijo .= '宮崎市橘通西１丁目１番２号<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.siminplaza.com/access.html">http://www.siminplaza.com/access.html</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E5%AE%AE%E5%B4%8E%E5%B8%82%E6%A9%98%E9%80%9A%E8%A5%BF%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%E7%95%AA%EF%BC%92%E5%8F%B7&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=48.824335,83.320313&amp;brcurrent=3,0x3538b712a4a0ecff:0x94e12b384eb028d3,0,0x3538b712a5e38bdf:0x7baf20b0e79d1053&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%AE%AE%E5%B4%8E%E7%9C%8C%E5%AE%AE%E5%B4%8E%E5%B8%82%E6%A9%98%E9%80%9A%E8%A5%BF%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%E2%88%92%EF%BC%92&amp;t=m&amp;z=14&amp;ll=31.908368,131.420297&amp;output=embed"></iframe><br /><small><a href="https://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E5%AE%AE%E5%B4%8E%E5%B8%82%E6%A9%98%E9%80%9A%E8%A5%BF%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%E7%95%AA%EF%BC%92%E5%8F%B7&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=48.824335,83.320313&amp;brcurrent=3,0x3538b712a4a0ecff:0x94e12b384eb028d3,0,0x3538b712a5e38bdf:0x7baf20b0e79d1053&amp;ie=UTF8&amp;hq=&amp;hnear=%E5%AE%AE%E5%B4%8E%E7%9C%8C%E5%AE%AE%E5%B4%8E%E5%B8%82%E6%A9%98%E9%80%9A%E8%A5%BF%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%91%E2%88%92%EF%BC%92&amp;t=m&amp;z=14&amp;ll=31.908368,131.420297" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
				break;
			case "okinawa":
				$kaijo  = '';
				$kaijo .= '';
				$kaijo .= 'ｅ－ｓａ （イーサ）<br/>';
				$kaijo .= '沖縄県浦添市宮城２－３９－５ 花水木ビル１F<br/>';
				$kaijo .= '当日の連絡先：098-927-5388<br/>';
				$kaijo .= 'アクセスマップ　：　<a target="_blank" href="http://www.jawhm.or.jp/event/map/?p=okinawa">http://www.jawhm.or.jp/event/map/?p=okinawa</a><br/>';
				$kaijo .= '&nbsp;<br/>';
				$kaijo .= '<iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.jp/maps?f=q&amp;source=s_q&amp;hl=ja&amp;geocode=&amp;q=%E6%B2%96%E7%B8%84%E7%9C%8C%E6%B5%A6%E6%B7%BB%E5%B8%82%E5%AE%AE%E5%9F%8E%EF%BC%92%EF%BC%8D%EF%BC%93%EF%BC%99%EF%BC%8D%EF%BC%95+%E8%8A%B1%E6%B0%B4%E6%9C%A8%E3%83%93%E3%83%AB%EF%BC%91F&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=48.824335,83.320313&amp;brcurrent=3,0x34e56b9711f3acef:0x100b98c92deca54f,0&amp;ie=UTF8&amp;hq=%E8%8A%B1%E6%B0%B4%E6%9C%A8%E3%83%93%E3%83%AB%EF%BC%91F&amp;hnear=%E6%B2%96%E7%B8%84%E7%9C%8C%E6%B5%A6%E6%B7%BB%E5%B8%82%E5%AE%AE%E5%9F%8E%EF%BC%92%E4%B8%81%E7%9B%AE%EF%BC%93%EF%BC%99%E2%88%92%EF%BC%95&amp;ll=26.249516,127.701894&amp;spn=0.006295,0.006295&amp;t=m&amp;output=embed"></iframe><br /><small><a href="https://maps.google.co.jp/maps?f=q&amp;source=embed&amp;hl=ja&amp;geocode=&amp;q=%E6%B2%96%E7%B8%84%E7%9C%8C%E6%B5%A6%E6%B7%BB%E5%B8%82%E5%AE%AE%E5%9F%8E%EF%BC%92%EF%BC%8D%EF%BC%93%EF%BC%99%EF%BC%8D%EF%BC%95+%E8%8A%B1%E6%B0%B4%E6%9C%A8%E3%83%93%E3%83%AB%EF%BC%91F&amp;aq=&amp;sll=36.5626,136.362305&amp;sspn=48.824335,83.320313&amp;brcurrent=3,0x34e56b9711f3acef:0x100b98c92deca54f,0&amp;ie=UTF8&amp;hq=%E8%8A%B1%E6%B0%B4%E6%9C%A8%E3%83%93%E3%83%AB%EF%BC%91F&amp;hnear=%E6%B2%96%E7%B8%84%E7%9C%8C%E6%B5%A6%E6%B7%BB%E5%B8%82%E5%AE%AE%E5%9F%8E%EF%BC%92%E4%B8%81%E7%9B%AE%EF%BC%93%EF%BC%99%E2%88%92%EF%BC%95&amp;ll=26.249516,127.701894&amp;spn=0.006295,0.006295&amp;t=m" style="color:#0000FF;text-align:left">大きな地図で見る</a></small>';
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