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
				<div align="center" style="height:390px;">
			<img  src="../images/summerevent/mapafter.gif" />


		</div>
<br/><br/><br/>
		<div style="border: 2px dotted red; font-size:10pt; margin: 10px 10px 10px 10px; padding: 10px 20px 10px 20px;">
			<p>
			<a href="http://www.yomiuri.co.jp/job/news/20110817-OYT8T00723.htm" target="_blank"><b><big>読売新聞に掲載されました</b></big></a></p>
				<p>2011年8月17日　<br/>
				読売新聞に日本一周ワーキング・ホリデーセミナーツアーが取り上げられました。<br/>
				<a href="http://www.yomiuri.co.jp/job/news/20110817-OYT8T00723.htm" target="_blank">掲載記事はこちら</a>
				</p>
		</div>



		<div style="border: 2px dotted navy; font-size:10pt; margin: 10px 10px 10px 10px; padding: 10px 20px 10px 20px;">
			日本一周 ワーキングホリデーセミナーツアー 2011は9月3日をもちまして終了致しました。<br/>
			全国各地からたくさんのご参加本当にありがとうございました。<br/>
			<a href="http://www.jawhm.or.jp/seminar.html"><b>通常無料セミナーはこちら（東京・大阪・福岡）</b></a>
<br/>
<br/>
<br/>

			<FONT COLOR="#077835">●</FONT> ワーキングホリデーに行こうという気持ちがかなり強くなりました。説明会に来て良かったです。<B><FONT COLOR="#077835">(岐阜県)</FONT></B><br/>
			<div style="text-align:right;"><FONT COLOR="#626262"><small>男性（21）/イギリス、カナダ、オーストラリア希望</font></small><br/></div><br/>

			<FONT COLOR="#ea5a16">●</FONT> 知らないことがたくさん聞けて良かったです。またお話聞きたいです。<B><FONT COLOR="#ea5a16">(愛知県)</FONT></B>
			　<FONT COLOR="#626262"><small>女性（22）/イギリス希望</small><br/></FONT>
<br/>

			<FONT COLOR="#f39a06">●</FONT> 行ってみたいなと思っていたけど、わからないことも多かったので参加して良かったです。
<B><FONT COLOR="#f39a06">(京都府)</FONT></B><br/>
			<div style="text-align:right;"><FONT COLOR="#626262"><small>男性（23）/オーストラリア、イギリス、デンマーク希望</small></FONT><br/></div><br/>

			<FONT COLOR="#f39a06">●</FONT> 質問などができてよかった。自分が思っている事がわかってよかった。
<B><FONT COLOR="#f39a06">(大阪府)</FONT></B>
			<FONT COLOR="#626262"><small>男性（20）/オーストラリア希望</small><br/><br/></FONT>

			<FONT COLOR="#077835">●</FONT> 楽しかったですし、具体的な話が聞けて参考になりました。
<B><FONT COLOR="#077835">(岐阜県)</FONT></B>
			　<FONT COLOR="#626262"><small>男性（25）/希望国・ニュージーランド希望</small><br/></FONT>
<br/>
			<FONT COLOR="#f39a06">●</FONT> 色々なことを丁寧に説明していただいたのでわかりやすかったです。
<B><FONT COLOR="#f39a06">(京都府)</FONT></B>
			　<FONT COLOR="#626262"><div style="text-align:right;"><small>女性（22）/希望国・オーストラリア、カナダ希望</small></div><br/></FONT>

			<FONT COLOR="#ea3621">●</FONT> 知らないことだらけだったので、どんな感じなのか聞けて安心しました。面白かったです。

<B><FONT COLOR="#ea3621">(鹿児島県)</FONT></B>
			　<FONT COLOR="#626262"><div style="text-align:right;"><small>女性/希望国・オーストラリア、カナダ希望</small></div><br/></FONT>

			<FONT COLOR="#ea3621">●</FONT> ひとりひとりに質問する機会があってよかったです。知らないことをたくさん知れた。

<B><FONT COLOR="#ea3621">(鹿児島県)</FONT></B>
			　<FONT COLOR="#626262"><div style="text-align:right;"><small>女性(19)/オーストラリア、カナダ希望</small></div><br/></FONT>


			<FONT COLOR="#ea3621">●</FONT> ワーキングホリデーが具体的に見えてきた気がする。4月の実現を目指して進めていきたい。
<B><FONT COLOR="#ea3621">(大分県)</FONT></B>
			　<FONT COLOR="#626262"><div style="text-align:right;"><small>男性(20)/オーストラリア、カナダ、ニュージーランド、イギリス希望</small></div><br/></FONT>


			<FONT COLOR="#ea3621">●</FONT> オーストラリア経験者でしたが他の国の情報も知りたくて参加しました。いろいろな周りの方に伝えることができればなと思います。

<B><FONT COLOR="#ea3621">(鹿児島県)</FONT></B>
			　<FONT COLOR="#626262"><small>女性(31)</small><br/></FONT><br/>

			<FONT COLOR="#ea3621">●</FONT> 少人数だったので、ゆったりした雰囲気でいろいろ質問できて良かったです。

<B><FONT COLOR="#ea3621">(鹿児島県)</FONT></B>
			　<FONT COLOR="#626262"><div style="text-align:right;"><small>女性(26)/カナダ、イギリス、シンガポール希望</small></div><br/></FONT>

			<FONT COLOR="#ea3621">●</FONT> とても分かりやすく明確に教えて頂いたのでますますワーキングホリデーに行きたくなりました。

<B><FONT COLOR="#ea3621">(鹿児島県)</FONT></B>
			　<FONT COLOR="#626262"><div style="text-align:right;"><small>女性(28)/オーストラリア、カナダ、イギリス、フランス、デンマーク
希望</small></div><br/></FONT>

			<FONT COLOR="#f39a06">●</FONT> サポートとかしてもらえることがわかったので安心しました。
<B><FONT COLOR="#f39a06">(京都府)</FONT></B>
			　<FONT COLOR="#626262"><small>女性（23）/カナダ希望</small></FONT><br/>


<br/>
<br/>

		</div>
<br/>
		</p>

		
		<br />


<br /><br /><br />


<div style="height:30px;">&nbsp;</div>
<div style="text-align:center;">
	<img src="../images/flag01.gif">
	<img src="../images/flag02.gif">
	<img src="../images/flag03.gif">
	<img src="../images/flag04.gif">
	<img src="../images/flag05.gif">
	<img src="../images/flag06.gif">
	<img src="../images/flag07.gif">
	<img src="../images/flag08.gif">
	<img src="../images/flag09.gif">
	<img src="../images/flag10.gif">
	<img src="../images/mflag11.gif" width="40" height="26">
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