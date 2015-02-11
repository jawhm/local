<?php
//	ini_set( "display_errors", "On");

	session_start();

	mb_language("Ja");
	mb_internal_encoding("utf8");

	// パラメータ確認
	$d = @$_GET['d'];

	// ログイン情報
	$mem_id = @$_SESSION['mem_id'];
	$mem_name = @$_SESSION['mem_name'];
	$mem_level = @$_SESSION['mem_level'];


	// 状態確認
	if ($mem_id <> '')	
	{
		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$stt = $db->prepare('SELECT id, email, namae, furigana, tel, country FROM memlist WHERE id = :id ');
			$stt->bindValue(':id', $mem_id);
			$stt->execute();
			$mem_namae = '';
			$mem_furigana = '';
			$mem_tel = '';
			$mem_email = '';
			$mem_country = '';
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$mem_email = $row['email'];
				$mem_namae = $row['namae'];
				$mem_furigana = $row['furigana'];
				$mem_tel = $row['tel'];
				$mem_country = $row['country'];
			}
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

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
	
	require_once '../include/menubar.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>日本ワーキング・ホリデー協会　春の留学＆ワーキングホリデーフェア2013 -</title>
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

<!-- jQuery library (served from Google) -->
<script src="js/jquery.min.js"></script>
<!-- bxSlider Javascript file -->
<script src="js/jquery.bxslider.min.js"></script>
<!-- bxSlider CSS file -->
<link href="jquery.bxslider.css" rel="stylesheet" />


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

<script>
function fnc_next()	{
	document.getElementById('form1').style.display = 'none';
	document.getElementById('form2').style.display = '';
}

function fnc_yoyaku(obj)	{
	document.getElementById('form1').style.display = '';
	document.getElementById('form2').style.display = 'none';

	document.getElementById("btn_soushin").disabled = false;
	document.getElementById("btn_soushin").value = "送信";
	document.getElementById("div_wait").style.display = 'none';
	document.getElementById('form_title').innerHTML = obj.getAttribute('title');
	document.getElementById('txt_title').value = obj.getAttribute('title');
	document.getElementById('txt_id').value = obj.getAttribute('uid');
	$.blockUI({ message: $('#yoyakuform'),
	css: { 
		top:  ($(window).height() - 500) /2 + 'px', 
		left: ($(window).width() - 600) /2 + 'px', 
		width: '600px' 
	}
 }); 
}
function btn_cancel()	{
	$.unblockUI();
}
function btn_submit()	{
	obj = document.getElementById('txt_name');
	if (obj.value == '')	{
		alert('お名前（氏）を入力してください。');
		obj.focus();
		return false;
	}
	obj = document.getElementById('txt_name2');
	if (obj)	{
		if (obj.value == '')	{
			alert('お名前（名）を入力してください。');
			obj.focus();
			return false;
		}
	}
	obj = document.getElementById('txt_furigana');
	if (obj.value == '')	{
		alert('フリガナ（氏）を入力してください。');
		obj.focus();
		return false;
	}
	obj = document.getElementById('txt_furigana2');
	if (obj)	{
		if (obj.value == '')	{
			alert('フリガナ（名）を入力してください。');
			obj.focus();
			return false;
		}
	}
	obj = document.getElementById('txt_mail');
	if (obj.value == '')	{
		alert('メールアドレスを入力してください。');
		obj.focus();
		return false;
	}
	obj = document.getElementById('txt_tel');
	if (obj.value == '')	{
		alert('電話番号を入力してください。');
		obj.focus();
		return false;
	}

	if (!confirm('ご入力頂いた内容を送信します。よろしいですか？'))	{
		return false;
	}

	$senddata = $("#form_yoyaku").serialize();

	document.getElementById("div_wait").style.display = '';

	document.getElementById("btn_soushin").value = "処理中...";
	document.getElementById("btn_soushin").disabled = true;

	$.ajax({
		type: "POST",
		url: "http://www.jawhm.or.jp/yoyaku/yoyaku.php",
		data: $senddata,
		success: function(msg){
			document.getElementById("div_wait").style.display = 'none';
			alert(msg);
			$.unblockUI();
		},
		error:function(){
			alert('通信エラーが発生しました。');
			$.unblockUI();
		}
	});
}
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

</style><script type="text/javascript">
haccordion.setup({
	accordionid: 'hc1', //main accordion div id
	paneldimensions: {peekw:'38px', fullw:'550px', h:'400px'},
	selectedli: [4, false], //[selectedli_index, persiststate_bool]
	collapsecurrent: false //<- No comma following very last setting!
})

haccordion.setup({
	accordionid: 'hc2', //main accordion div id
	paneldimensions: {peekw:'38px', fullw:'550px', h:'400px'},
	selectedli: [5, true], //[selectedli_index, persiststate_bool]
	collapsecurrent: true //<- No comma following very last setting!
})

</script>



</head>
<body>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>

<div id="yoyakuform" style="display:none; margin:15px 20px 15px 20px; font-size:10pt; cursor:default;">

	<div id="form1" style="">

		<div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">セミナー　予約フォーム</div>

		<div style="font-size:9pt; font-weight:bold; margin:10px 0 10px 0; border: 1px dotted navy;;">
			セミナーのご予約に際し、以下の内容をご確認ください。
		</div>

		<div style="font-size:9pt; font-weight:; text-align:left; margin:10px 0 10px 20px;">
			１．　このフォームでは、仮予約の受付を行います。<br/>
			　　　予約確認のメールをお送りしますので、メールの指示に従って予約を確定してください。<br/>
			　　　ご予約が確定されない場合、２４時間で仮予約は自動的にキャンセルされ<br/>
			　　　セミナーにご参加頂けません。ご注意ください。<br/>
			&nbsp;<br/>
			２．　携帯のメールアドレスをご使用の場合、info@jawhm.or.jp からのメール（ＰＣメール）が<br/>
			　　　受信できるできる状態にしておいてください。<br/>
			&nbsp;<br/>
			３．　Ｈｏｔｍａｉｌ、Ｙａｈｏｏメールなどをご利用の場合、予約確認のメールが遅れて<br/>
			　　　到着する場合があります。時間をおいてから受信確認を行うようにしてください。<br/>
			&nbsp;<br/>
			４．　予約確認メールが届かない場合、toiawase@jawhm.or.jp までご連絡ください。<br/>
			　　　なお、迷惑フォルダ等に分類される場合もありますので、併せてご確認ください。<br/>
			&nbsp;<br/>
			最近、会場を間違えてご予約される方が増えております。<br/>
			セミナー内容・会場・日程等を十分ご確認の上、ご予約頂けますようお願い申し上げます。<br/>
		</div>

		<div style="margin-top:10px;">
			<input type="button" class="button_cancel" value=" 取消 " onclick="btn_cancel();">　　　　　
			<input type="button" class="button_submit" value="次へ" onclick="fnc_next();">
		</div>

	</div>

	<div id="form2" style="display:none;">

	<div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">セミナー　予約フォーム</div>

<?	if ($mem_id <> '')	{	?>
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
			<td style="border-bottom: 1px dotted pink; text-align:left;"><? echo $mem_namae; ?>様
				<input type="hidden" name="お名前" id="txt_name" value="<? echo $mem_namae; ?>" size=20>
				<input type="hidden" name="フリガナ" id="txt_furigana" value="<? echo $mem_furigana; ?>" size=20>
				<input type="hidden" name="メール" id="txt_mail" value="<? echo $mem_email; ?>" size=40><br/>
				<input type="hidden" name="電話番号" id="txt_tel" value="<? echo $mem_tel; ?>" size=20>
			</td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">興味のある国&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="興味国" id="txt_kuni" value="<? echo $mem_country; ?>" size=50></td>
		</tr>
		<tr>
			<td nowrap style="border-bottom: 1px dotted pink; text-align:right;">出発予定時期&nbsp;</td>
			<td style="border-bottom: 1px dotted pink; text-align:left;"><input type="text" name="出発時期" id="txt_jiki" value="" size=50></td>
		</tr>
		<tr style="background-color:white;">
			<td nowrap style="text-align:right;">その他&nbsp;</td>
			<td style="text-align:left;"><input type="text" name="その他" id="txt_memo" value="" size=50></td>
		</tr>
	</table>
	</form>
<?	}else{		?>
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
<?	}	?>
	<div style="font-size:9pt; font-weight:bold; margin:10px 0 10px 0; border: 1px dotted navy;;">
		このフォームでは仮予約を行います。<br/>
		予約確認のメールをお送りしますので、メールの指示に従って予約を確定させてください。<br/>
	</div>

	<div id="div_wait" style="display:none;">
		<img src="../images/ajaxwait.gif">
		&nbsp;予約処理中です。しばらくお待ちください。&nbsp;
		<img src="../images/ajaxwait.gif">
	</div>

	<input type="button" class="button_cancel" value=" 取消 " onclick="btn_cancel();">　　　　　
	<input type="button" class="button_submit" value=" 送信 " id="btn_soushin" onclick="btn_submit();">

	</div>

</div>
<div id="header">
	<font color="#ffffff">春の留学＆ワーキングホリデーフェア2013</font><br/>
    <h1><a href="http://www.jawhm.or.jp/index.html"><img src="http://www.jawhm.or.jp/images/h1-logo.jpg" alt="一般社団法人日本ワーキング・ホリデー協会" width="410" height="33" /></a></h1>
</div>
  <div id="contentsbox"><img id="bgtop" src="http://www.jawhm.or.jp/images/contents-bgtop.gif" alt="" />
  <div id="contents">

	<div id="maincontent" style="margin-left:30px;">
	<div id="top-main" style="width:300px;margin-bottom:20px;">

<!--
	<h2 class="sec-title">★秋の留学・ワーキングホリデーフェア開催！！★</h2>
	<div  style="width:830px;line-height:1.3" ><Font Size="2">本年、オーストラリアとの協定から始まったワーキングホリデー制度が30周年を迎え、
		日本人がワーキングホリデーを使って生活できる国は11カ国まで増えました。
		そんな節目の年に、日本ワーキング・ホリデー協会では秋の留学＆ワーキングホリデーフェアを開催します。
		皆様が留学＆ワーキングホリデーを考えるきっかけとして、また、より一層素晴らしい留学＆ワーキング
		ホリデーにする為に、是非この機会にフェアにご参加下さい！</font><br />
	</div></div>
-->

		<div class="top-entry01" style="width:900px;">
			
<div class="top-entry0">

<br />

<script>

$(function(){
	$('#slider11').bxSlider({
		auto:true,
		nextSelector: 'none',
		prevSelector: 'none',
		speed:1000,
		mode: 'fade',
		captions: true,
		pagerCustom:'none'
	});
});

$(function(){
	$('#slider4').bxSlider({
		auto:true,
		speed:1000,
		captions: true,
		nextSelector: 'none',
		prevSelector: 'none',
		buildPager: function(slideIndex){
			switch(slideIndex){
				case 0:
				return '<img src="images/step1.png" width="90%">';
				case 1:
				return '<img src="images/step2.png" width="90%">';
				case 2:
				return '<img src="images/step3.png" width="90%">';
				case 3:
				return '<img src="images/step4.png" width="90%">';
				case 4:
				return '<img src="images/step5.png" width="90%">';
			}
		}
	});
});
</script>



<style type="text/css">
.bx-custom-pager{bottom: -35px !important;}
.bx-custom-pager .bx-pager-item{width: 20%}
.bx-pager-item .active img{opacity: 0.1}
</style>


<div id="slider11">
	<li><img src="images/pic0.gif" align="left"/></li>
	<li><img src="images/pic00.gif" align="left"/></li>
</div>

<div id="slider4">
	<li><img src="images/pic01.gif" align="left"/>
  <p style="padding: 25px 15px 0 0px;">
<img src="images/step1.png"/><br>
ワーキングホリデーって何？どんなことができるの？予算はどれくらいかかるの？ワーキングホリデー・留学を考えるにあたってわからないことや心配なことがたくさんあると思います。難しいビザのお話から、国の魅力まで、１からわかりやすくお話しします。初めのご来店であれば「ワーキングホリデー・留学初心者向けセミナー」にご参加下さい。ワーキングホリデー・留学の第一歩、情報収集としてお気軽にご予約下さいませ！</p>
<br clear="all">
	</li>

	<li><img src="images/pic02.gif" align="left"/>
  <p style="padding: 25px 15px 0 0px;">
<img src="images/step2.png"/><br>
ワーキングホリデーや留学などで長期滞在するにあたり、語学力は必要不可欠。留学＆ワーキングホリデーフェアでは、語学学校の現地スタッフの方を多数お呼びして特別セミナーを開催します。語学学校ってどんなところ？コースはどんなものがあるの？お金はどれくらいかかるの？…現地のスタッフと話をすることでワーキングホリデー、留学をするにあたっての不安を全て解決！あなたにぴったりの語学学校が見つかるはずです！ </p>
<br clear="all">
	</li>
	
		<li><img src="images/pic03.gif" align="left"/>
  <p style="padding: 25px 10px 0 0px;">
<img src="images/step3.png"/><br>
「留学前に日本で出来る英語の上達法」「日本から持っていく！使える英単語カードの作り方」「就職力・転職力アップ！留学セミナー」「英語教員による英語の体験レッスン」ワーキングホリデー・留学に興味がある人なら必ず気になった事のある各項目に各テーマにスポットをあて、普段のセミナーとはひと味違った講演形式のセミナーを開催します。各国からゲストをお呼びして行う充実のラインナップです。これからワーキングホリデー・留学を考える方必見です！ </p>
<br clear="all">
	</li>
	
	
		<li><img src="images/pic04.gif" align="left"/>
  <p style="padding: 20px 15px 0 0px;">
<img src="images/step4.png"/><br>
実際にワーキングホリデー・留学を経験された方による体験談セミナーを開催します。ワーキングホリデー・留学経験者だからお話できる現地での生活、語学学校、ホームステイ、失敗談、海外に行こうと思ったきっかけ…などなかなか聞けない生の声を皆様にお届けします！大学を休学して渡航された方、お仕事を辞めた方、休学して帰国後も大学生の方…様々な方をお呼びする予定です。少人数制なのでお気軽にご質問も可能！いろいろな経験談を聞いて、たくさん質問して、ワーキングホリデー・留学に対する不安や疑問を無くしましょう。 </p>
<br clear="all">
	</li>
	
		<li><img src="images/pic05.gif" align="left"/>
  <p style="padding: 30px 15px 0 0px;">
<img src="images/step5.png"/><br>
目的・予算・期間などあなたの理想のプランにあわせてカウンセリングで計画を進めていきましょう。実際に海外渡航経験のあるカウンセラーが皆様の留学＆ワーキングホリデーをお手伝いします。フェアではお試しでカウンセリングをご予約なしで受ける事ができます。この機会になんでもご相談下さい。<br>
※東京会場のみの開催、１５分制、予約無し先着順<br>
</p>
<br clear="all">
	</li>	
	
</div>

</div>

<a name="seminar"></a>
<h2 class="aki-title">セミナースケジュール</h2> 

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


<div style="border: 2px dotted #cccccc; font-size:10pt; margin: 10px 30px 10px 10px; padding: 10px 20px 10px 20px; background:url(images/guidebook.gif) no-repeat right bottom;" >
	<br/>
	ワーキングホリデーって何？　どんなことが出来るの？　予算はどのくらいかかるの？<br/>
	帰国してからの就職先が心配...　　初めての海外だけどワーホリで大丈夫？<br/>
	聞きたい事や、心配な事もたくさんあると思います。何でも聞いてください。<br/>
	セミナーの参加者は８割以上の方が、お１人での参加です。お気軽にご参加ください。<br/>
	<br/>
	<b><big>会場を選んで下さい。</big></b><br/>
	<br/>
	<A href="/2013springfair/indexcopy.php?p=tokyo#seminar"><img src="images/tokyo.gif" /></A>&nbsp;
	<A href="/2013springfair/indexcopy.php?p=osaka#seminar"><img src="images/osaka.gif" /></A>&nbsp;
	<A href="/2013springfair/indexcopy.php?p=nagoya#seminar"><img src="images/nagoya.gif" /></A>&nbsp;
	<A href="/2013springfair/indexcopy.php?p=fukuoka#seminar"><img src="images/fukuoka.gif" /></A><br />
	<br />
	<div style="line-height:1.2"><b>【ご注意：予約フォームが正しく機能しない場合】</b><br />
		<font size="1.5">　スマートフォンなど、ＰＣ以外のブラウザからご利用された場合、<br />
		　予約フォームが正しく機能しない場合があります。<br />
		　この場合、お手数ですが、以下の内容を <b>toiawase@jawhm.or.jp</b> までご連絡ください。<br />
		　・　参加希望のセミナー日程<br />
		　・　お名前<br />
		　・　当日連絡の付く電話番号<br />
		　・　興味のある国<br />
		　・　出発予定時期<br /></font>
	<br />
	</div>
</div>

<br/>

<?php	include('fair_search.php'); ?>

<?php

	if (@$_GET['p'] == '')	{
		require_once('../calendar_module/ip2locationlite.class.php');
		//Load the class
		$ipLite = new ip2location_lite;
		$ipLite->setKey('04ba8ecc1a53f099cdbb3859d8290d9a9dced56a68f4db46e3231397d1dfa5e6');
		
		$visitorGeolocation = $ipLite->getCity($_SERVER['REMOTE_ADDR']); // test for osaka 125.2.111.125 or $_SERVER['REMOTE_ADDR'] (SENDAI 202.211.5.240 TOYAMA 202.95.177.129)
		
		// if no error
		if ($visitorGeolocation['statusCode'] == 'OK') 
		{
		//if value exist
			if($visitorGeolocation['regionName'] != '-')
			{
				$region = $visitorGeolocation['regionName'];
			}
			else
				$region = 'TOKYO';
			}
		else
			$region = 'TOKYO';

		switch($region)
		{
			case 'FUKUSHIA':
				$region = 'tokyo';	break;
			case 'TOCHIGI':
			 	$region = 'tokyo';	break;
			case 'GUNMA':
		 		$region = 'tokyo';	break;
			case 'SAITAMA':
			 	$region = 'tokyo';	break;
			case 'IBATAKI':
			 	$region = 'tokyo';	break;
			case 'YAMANASHI':
			 	$region = 'tokyo';	break;
			case 'TOKYO':
		 		$region = 'tokyo';	break;
			case 'CHIBA':
		 		$region = 'tokyo';	break;
			case 'KANAGAWA':
			 	$region = 'tokyo';	break;
			case 'NAGANO':
		 		$region = 'tokyo';	break;
			case 'SHIZUOKA':
			 	$region = 'tokyo';	break;
			case 'SHIGA':
				$region = 'osaka';	break;
			case 'MIE':
				$region = 'osaka';	break;
			case 'KYOTO':
				$region = 'osaka';	break;
			case 'OSAKA':
				$region = 'osaka';	break;
			case 'NARA':
				$region = 'osaka';	break;
			case 'WAKAYAMA':
				$region = 'osaka';	break;
			case 'HYOGO':
				$region = 'osaka';	break;
			case 'OKAYAMA':
				$region = 'osaka';	break;
			case 'FUKUOKA':
				$region = 'fukuoka';	break;
			case 'OITA':
				$region = 'fukuoka';	break;
			case 'SAGA':
				$region = 'fukuoka';	break;
			case 'NAGASAKI':
				$region = 'fukuoka';	break;
			case 'KUMAMOTO':
			 	$region = 'fukuoka';	break;
			case 'MIYAZAKI':
			 	$region = 'fukuoka';	break;
			case 'KAGOSHIMA':
			 	$region = 'fukuoka';	break;
			case 'OKINAWA':
			 	$region = 'okinawa';	break;
			case 'MIYAGI':
		 		$region = 'sendai';	break;
			case 'TOYAMA':
				$region = 'toyama';	break;
			case 'AICHI':
				$region = 'nagoya';	break;
		}
	}else{
		$region = @$_GET['p'];
	}

	if ( $region == 'tokyo' || $region == 'TOKYO')	{
	echo '<h3 id="tokyo"></h3> ';
	print '<p><b>＜東京会場からのお知らせ＞<br>
※ フェア期間中は多くのお客様がご来店されるため、通常のカウンセリングではなく、各日とも先着順、各15分程度でお話させていただいております。<br>
　 事前のご予約には対応出来かねますのでご了承くださいませ。</b></p>';

		calendar_display('tokyo', 2013, 5);
		
	}
	if ( $region == 'osaka' || $region == 'OSAKA')	{
		echo '<h3 id="osaka"></h3>';
		calendar_display('osaka', 2013, 5);
	}
	if ( $region == 'fukuoka' || $region == 'FUKUOKA')	{
		echo '<h3 id="fukuoka"></h3>';
		calendar_display('fukuoka', 2013, 5);
	}
	if ( $region == 'nagoya' || $region == 'AICHI')	{
		echo '<h3 id="fukuoka"></h3>';
		calendar_display('nagoya', 2013, 5);
	}
?>

<div style="text-align:right;"><A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div><br />


<a name="school"></a>
<h2 class="aki-title">参加語学学校</h2> 
<!--<img src="images/school.png" style="margin-left:-5px;">-->

<style>
.waku	{
	background: white;
	width: 150px;
}
.naka	{
	background: white;

}

</style>

<TABLE id="logo-list" align="center">

	<tr>
		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/browns.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> BROWNS </div>
		<center>
		<img src="images/browns.gif">
		</center>
		<p>綺麗な校舎と最新設備。独自の"Active8"は必見！</p>
		</center>
		</a>
	</div>
	</div>
		</TD>

<TD>
		<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/ilsc.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> ILSC </div>
		<center>
		<img src="images/ilsc.gif">
		</center>
		<p>豊富な選択授業で自分の目的にあったカリキュラム。
	</p>
		</center>
		</a>
	</div>
	</div>
		</TD>


		<TD>
		<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/inforum.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> Inforum </div>
		<center>
		<img src="images/inforum.gif">
		</center>
		<p>海外初心者の方へ。アットホームな雰囲気もGOOD！</p>
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/selc.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> SELC </div>
		<center>
		<img src="images/selc.gif">
		</center>
		<p>接客英語習得やバリスタを目指そう。</p>
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/viva.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> Viva </div>
		<center>
		<img src="images/viva.gif">
		</center>
		<p>多国籍な環境で、実践的な英語”Smart Talk”を。</p>
		</center>
		</a>
	</div>
	</div>
		</TD>
</tr>
<tr>
		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/ih_aus.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> IH Sydney </div>
		<center>
		<img src="images/ih_sy.gif">
		</center>
		<p>英語の先生になれる資格 "J-shine"をとるならココ。</p>
		</center>
		</a>
	</div>
	</div>
		</TD>

<TD>
		<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/icqa.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> ICQA </div>
		<center>
		<img src="images/icqa.gif">
		</center>
		<p>ホテルインターンやボランティアが充実した学校。</p>
		</center>
		</a>
	</div>
	</div>
		</TD>


		<TD>
		<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/impact.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> Impact </div>
		<center>
		<img src="images/impact.gif">
		</center>
		<p>徹底したEnglish Onlyポリシーが大人気。</p>
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/navitas.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> Navitas </div>
		<center>
		<img src="images/navitas.gif">
		</center>
		<p>海外で大学進学を目指すならNavitas！</p>
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/holmes.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> Holmes </div>
		<center>
		<img src="images/holmes.gif">
		</center>
		<p>日本人が少ない環境で勉強したい方におススメ。</p>
		</center>
		</a>
	</div>
	</div>
		</TD>
</tr>

  </tbody>
</table>






<TABLE id="logo-list2" align="center">
	<tr>
		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/ilac.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"> ILAC </div>
		<center>
		<img src="images/ilac.gif">
		</center>
		<p>世界70カ国以上の仲間と、国際社会へ飛び出そう！</p>
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
		<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/kgic.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"> KGIC </div>
		<center>
		<img src="images/kgic.gif">
		</center>
		<p>スキルごとのレベルで自分に合った英語を学べる！</p>
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/umc.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"> UMC </div>
		<center>
		<img src="images/umc.gif">
		</center>
		<p>アットホームな環境で安心して勉強できる学校</p>
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/ccel.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"> CCEL </div>
		<center>
		<img src="images/ccel.gif">
		</center>
		<p>接客英語を学ぶなら!バンクーバー有数の大規模校
		</p>
		</center>
		</a>
	</div>
	</div>
		</TD>
</tr>

<tr>
		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/pgic.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"> PGIC </div>
		<center>
		<img src="images/pgic.gif">
		</center>
		<p>英語を本気でモノに!本物のコミュニケーション力を。</p>
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
		<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/ih_can.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"> IH vancouver </div>
		<center>
		<img src="images/ih_can.gif">
		</center>
		<p>大都市から少し離れ落ち着いた環境で学びたい方へ。</p>
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/quest.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"> QUEST </div>
		<center>
		<img src="images/quest.gif">
		</center>
		<p>Questで英語を学び、新たな機会を発見しよう！</p>
		</center>
		</a>
	</div>
	</div>
		</TD>
		
				<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/nzlc.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo3"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/New-Zealand.png"> NZLC </div>
		<center>
		<img src="images/nzlc.gif">
		</center>
		<p>生徒数No.1！ニュージーランドで最も歴史ある学校。</p>
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
		<div id="div_cic" class="waku">
	<div class="naka">
		<a href="../fair/embassy.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<div class="logo4"><img width="15" src="images/worldwide.gif">Embassy</div>
		<center>
		<img src="images/embassy.gif">
		</center>
		<p>人気の英語圏にキャンパスを持つ大規模校！</p>
		</center>
		</a>
	</div>
	</div>
		</TD>
		
</tr>
</TABLE>


<br />
<div align="center">
<table cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="5" height="5" background="images/hidariue.gif"></td>
      <td background="images/ue.gif"></td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td background="images/hidari.gif"></td>
      <td width="850" style="padding: 5px 5px 5px 5px;">


<iframe src="../fair/top.html" width="880" height="500" frameborder="0" name="school" marginwidth="0" marginheight="0" hspace="0" vspace="0" onload="fitIfr();">お使いのブラウザはフレームに対応しておりません。</iframe>


</td>
      <td width="5" background="images/migi.gif"></td>
    </tr>
    <tr>
      <td height="5" background="images/hidarisita.gif"></td>
      <td background="images/sita.gif"></td>
      <td background="images/migisita.gif"></td>
    </tr>
  </tbody>
</table>
</div>

<br />
<div style="text-align:right;"><A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div>



	<h2 class="aki-title" id="kouen">講演セミナー</h2> 
    <br />
	
<style>
.waku2	{
	background: white;
	width: 400px;
}
.naka2	{
	background: white;
	vertical-align: top;
}

</style>	
	
	<TABLE align="center" cellpadding="17">

	<tr>
		<TD>
		<div id="div_cic" class="waku2">
			<div class="naka2">
		<div class="kouen"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> 「英語が伸びる単語カードの作り方」講座 </div>
		<div align="right"><font size="1"><a href="../fair/inforum.html" target="school">講師：Inforum (オーストラリア語学学校) Jun 様</a></font><br/></div>
		<center>
		<img src="images/kouen1.jpg" style="padding-top:15px; padding-bottom:10px;">
		</center>
		<p>
		留学、ワーキングホリデー中にみんなが感じることは、<br/>
		「語彙力が足りない！」「もっと日本でやっておけばよかった！」<br/>
		毎回参加者の満足度の高い、Inforumの単語カードの作り方講座。
		受験に使っていた単語カード、そこへちょっとプラスするだけで、英語が伸びる最強カードへ！
		渡航前に500単語「覚える」じゃなく「使える」ようにする単語カードの作り方を一緒に勉強しましょう。<br/>
		<br/>
		</p>
		<?php
	$keyword = '英語が伸びる単語カードの作り方';
	include './seminar_school.php';
		?>
	</div>
	</div>
		</TD>

		<TD>
		<div id="div_cic" class="waku2">
	<div class="naka2">
		<div class="kouen"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> 語学学校Inforum発音クラス体験 </div>
		<div align="right"><font size="1"><a href="../fair/inforum.html" target="school">講師：Inforum (オーストラリア語学学校) 様</a></font><br/></div>
		<center>
		<img src="images/kouen2.jpg" style="padding-top:15px; padding-bottom:10px;">
		</center>
		<p>
	毎日開催されるインフォーラムの放課後無料レッスンで一番人気、校長Simonが行う楽しい発音クラスを体験してみませんか？<br/>
	校長のSimonはイギリス、ポルトガル、トルコ、日本でも英語を教えて来た教育者。
	発音だけでなく、学校やゴールドコーストなど、色々な事についても聞いてみましょう！<br/>
		<br/>
		</p>
		<?php
	$keyword = '発音クラス体験';
	include './seminar_school.php';
?>
	</div>
	</div>
		</TD>
  </tbody>
</table>

    <br />
    <br />
	
	<h2 class="aki-title" id="taikendan">ワーホリ＆留学帰国者体験談セミナー</h2> 
    <br />
	

	<TABLE align="center" cellpadding="20">

	<tr>
		<TD>
		<div id="div_cic" class="waku2">
	<div class="naka2">
		<div class="kouen2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"> <img src="http://www.jawhm.or.jp/images/uploads/files/USA.png"  width="15"> アメリカ＆カナダ体験談セミナー <img src=http://www.jawhm.or.jp/images/uploads/files/hana01.png height=15 width=15></div>
		<div align="right"><font size="1">講師：Kon Sachiko</font><br/></div>
		<center>
		<img src="images/taiken/sachiko.jpg" style="padding-top:15px; padding-bottom:10px;">
		</center>
		<p>
			それぞれの国の特徴や語学学校について。カナダへはワーキングホリデービザで渡航したので、お仕事探し、現地での仕事経験もしています。実体験を元にお話させていただきます。<br/>
			&nbsp;<br/>
		</p>
		<?php
	$keyword = 'Kon';
	include './seminar_school.php';
		?>
	</div>
	</div>
		</TD>

		<TD>
		<div id="div_cic" class="waku2">
	<div class="naka2">
		<div class="kouen2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png">　<font size="2">オーストラリア留学体験談～オーストラリアの楽しみ方～ <img src=http://www.jawhm.or.jp/images/uploads/files/hana01.png height=15 width=15></font></div>
		<div align="right"><font size="1">講師：Yamazaki Asami</font><br/></div>
		<center>
		<img src="images/taiken/asami.jpg" style="padding-top:15px; padding-bottom:10px;">
		</center>
		<p>
	23歳になる直前に天職だと思っていたアパレルの仕事を退職し、<br/>
	フィリピン留学を経てオーストラリアにワーホリへ！
	英語を勉強して海外で生活するなんて夢にも思ってなかった私が単身オーストラリアへ！！<br/>
 <br/>
	都市ごとに違う顔を持つオーストラリアの魅力や、英語の生活に格闘し、
	なにもわからなかった私が1年の生活でたくさんのことを経験しました。<br/>
 <br/>
	自分なりに成長出来たと思う私のオーストラリアのワーホリ体験を
	みなさんにお話しして少しでも参考にしていただけたらと思います。<br/>
 <br/>
	≪海外渡航履歴≫
	オーストラリア、フィリピン、韓国、ニューヨーク、タイランド、グアム<br/>
 			&nbsp;<br/>
		<br/>
		</p>
		<?php
	$keyword = 'Asami';
	include './seminar_school.php';
?>
	</div>
	</div>
		</TD>
  </tbody>
</table>
			&nbsp;<br/>
<TABLE align="center" cellpadding="17">

	<tr>
		<TD>
		<div id="div_cic" class="waku2">
			<div class="naka2">
				<div class="kouen2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> <img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"> <font size="2">オーストラリア&カナダ留学 ～僕が見た広い世界 <img src=http://www.jawhm.or.jp/images/uploads/files/hana01.png height=15 width=15></font> </div>
		<div align="right"><font size="1">講師：Sakurada Hiroyuki</font><br/></div>
		<center>
		<img src="images/taiken/hiroyuki.jpg" style="padding-top:15px; padding-bottom:10px;">
		</center>
		<p>
			多感な思春期、遊びに恋に勉強に日々充実した時間を過ごしているだろうそこのあなた！その思い出、海外でも経験してみませんか？<br/>
			&nbsp;<br/>
何事に対してもだらしなかった私が多種多様な言語、文化、そして人々に触れることによって「学ぶ」ことの楽しさを覚えました。そして支えてくれた家族や仲間への感謝も覚えました。もちろん肝心の語学力も向上し、帰国後には英検準1級を取得しました。<br/>
			&nbsp;<br/>
オーストラリアとカナダの2国にはそれぞれに魅力があります。それらの魅力を精一杯お伝えしたいと思っているので是非ご参加頂ければ幸いです。外国だって単に１つの国家です、住めば都です。悩んでても仕方ありません、じゃあいつ行くか？今ですよ！<br/>
			&nbsp;<br/>
		</p>
		<?php
	$keyword = 'Hiroyuki';
	include './seminar_school.php';
		?>
	</div>
	</div>
		</TD>

		<TD>
		<div id="div_cic" class="waku2">
	<div class="naka2">
		<div class="kouen2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/France.png"> <font size="2">フランス留学体験談～長年の夢を叶えに海外へ！～ <img src=http://www.jawhm.or.jp/images/uploads/files/hana01.png height=15 width=15></font></div>
		<div align="right"><font size="1">講師：Komagine Amy</font><br/></div>
		<center>
		<img src="images/taiken/amy.jpg" style="padding-top:15px; padding-bottom:10px;">
		</center>
		<p>
”いつかフランスに行く！”　思えば、中学生のころからの口癖でした。最初は環境への憧れから入ったフランスへの渡航希望でしたが、、、関連する好きなモノが増えるに連れて”目標”に変わっていったのです。<br/>
<br/>
趣味が高じて学生時代にフランス映画の研究をしてからは、日本から得られる情報の限界を感じて渡航を決意。<br/>
<br/>
渡航当初は、大好きな文化のある国に滞在していることに満足をしておりました。
不思議なことですが、文化や芸術をつくるのは人間なのに、渡航までは現地の人間に興味が全くなかった。<br/>
<br/>
しかし、滞在をしてからは”Bonjour！”を言うのが精いっぱい。
 友達を作ろうとしても意思をうまく伝えられずにもどかしい思いばかり。<br/>
<br/>

そこで必死にコミュニケーションをとり、初めてできた友人に”あなたに会えてよかった”を伝えられた時、確かに気持ちが通じた感動を覚えています。どこにいても人間関係の大切さや温かさを感じた瞬間でした。<br/>
<br/>
仕事経験や語学力の上達など人生に役立つものを得ることもできます。しかし、人生の豊かするものとして、日本では得られない大切なことを学ぶこともできるのです。<br/>
<br/>
わたしの渡仏経験が、皆様の背中を押す手助けとなると幸いです。
ぜひ、お待ちしております。<br/>
 
			&nbsp;<br/>
		</p>
		<?php
	$keyword = 'amy';
	include './seminar_school.php';
?>
	</div>
	</div>
		</TD>
  </tbody>
</table>

			&nbsp;<br/>

<TABLE align="center" cellpadding="17">
	<tr>
		<TD>
		<div id="div_cic" class="waku2">
			<div class="naka2">
				<div class="kouen2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><font size="2"> 憧れの海外へ！現地生活も資格も叶える！ <img src=http://www.jawhm.or.jp/images/uploads/files/hana01.png height=15 width=15></font> </div>
		<div align="right"><font size="1">講師：Mizuguchi Saori</font><br/></div>
		<center>
		<img src="images/taiken/saori.jpg" style="padding-top:15px; padding-bottom:10px;">
		</center>
		<p>
			学生の今、やりたいこと、叶えたいことは何ですか？<br/>
			&nbsp;<br/>
			高校生の頃から一度は留学したいという思いを抱きながらも
			なかなか踏み出せず、でも英語を話せるようになりたいという気持ちは強まり
			高校卒業後に外国語の専門学校へ進学しました。
			<br/>
			そのまま就職し、留学という夢からは遠ざかってしまいましたが、
			あきらめきれず、最終的には退職し、ワーキングホリデーでその想いを実現させました。<br/>
			&nbsp;<br/>
			せっかく行ったのだから、何か英語の資格が欲しいと思い
			IELTSという英語検定のコースに入り、現地で受験しました。<br/>
			&nbsp;<br/>
			休学して留学？
			卒業後の留学？
			それとも一度社会に出てから…？<br/>
			&nbsp;<br/>
			やりたいことがあるのに、どうしたらいいかわからない。
			海外には行きたいけれど、いつ行けばいいのか分からない。<br/>
			&nbsp;<br/>
			体験談とともに、皆さんの疑問を少しでも解消し、
			夢のための答えを見つけていただける時間になればと思います。<br/>
			&nbsp;<br/>
		</p>
		<?php
	$keyword = 'saori';
	include './seminar_school.php';
		?>
	</div>
	</div>
		</TD>

		<TD>
		<div id="div_cic" class="waku2">
	<div class="naka2">
		<div class="kouen2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> <font size="2">オーストラリア留学体験談～現地進学も夢じゃない！～ <img src=http://www.jawhm.or.jp/images/uploads/files/hana01.png height=15 width=15></font></div>
		<div align="right"><font size="1">講師：Onaga kosaburou</font><br/></div>
		<center>
		<img src="images/taiken/sabu.jpg" style="padding-top:15px; padding-bottom:10px;">
		</center>
		<p>
			初一人旅、初海外、すべてが初めての体験。１６歳の時に、海外に行き、日本では経験できない事をたくさんしました。
			英語がまったくできない私が、半年後には現地のハイスクールに!!!;<br/>
			&nbsp;<br/>
			最初は自分の殻にこもり、友達が出来なくて一人でさびしくランチを食べていた日々。。
			それは、自分が悪いと気付かされたとき、ある方法によって友達がどんどんできました！<br/>
			&nbsp;<br/>
			英語はできなくてもいいんです！渡航してから学びましょう！
			英語の伸ばし方や、私が経験した事、ホームステイの事に関して、
			そして友達の作り方をお話させて頂きます!!<br/>
			&nbsp;<br/>
			長期で学校に行きたい方！高校や大学に行きたい方！
			ワーキングホリデービザで悩んでいる方！　
			ともに経験した、私からアドバイスを!!
			１人１人にあった、お話が出来たらと思います。
			当日はお話を出来るのを楽しみにしております。<br/>
			&nbsp;<br/>
		</p>
		<?php
	$keyword = 'sabu';
	include './seminar_school.php';
?>
	</div>
	</div>
		</TD>
  </tbody>
</table>

			&nbsp;<br/>

<TABLE align="center" cellpadding="17">
	<tr>
		<TD>
		<div id="div_cic" class="waku2">
			<div class="naka2">
				<div class="kouen2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"> <font size="2">思い切って仕事を退職・・・海外へ☆</font> <img src=http://www.jawhm.or.jp/images/uploads/files/hana01.png height=15 width=15></div>
		<div align="right"><font size="1">講師：Matsumura Nahoko</font><br/></div>
		<center>
		<img src="images/taiken/naho.jpg" style="padding-top:15px; padding-bottom:10px;">
		</center>
		<p>
			初めての海外は高校1年の時オーストラリアメルボルンでした。<br/>
			&nbsp;<br/>
			その経験もあり、就職した会社が国際支店海外営業部。
			英語が飛び交う環境の中で使える英語力がない無力感と英語を使えるようになりたいと思い
			5年働いた会社を辞めオーストラリアのワーキングホリデーで2年間過ごしました。<br/>
			&nbsp;<br/>
			体験としては語学学校、ラウンド、ファーム、ダイビング、仕事経験。<br/>
			&nbsp;<br/>
			海外に行くと決めた方、行くか行かないか悩んでいる方、興味はあるが、心配と不安が多い方へ行ったからこそ、
			見れた物、感じた事、出会えた仲間、トラブルをどう対処したか、
			初めて体験したホームシック等のお話しも踏まえながら、伝えたいメッセージも含めてお話しさせて頂きます。<br/>
			&nbsp;<br/>
			体験談セミナーで皆様にお会い出来るのを楽しみにしております。<br/>
			&nbsp;<br/>
		</p>
		<?php
	$keyword = 'naho';
	include './seminar_school.php';
		?>
	</div>
	</div>
		</TD>

		<TD>
		<div id="div_cic" class="waku2">
	<div class="naka2">
		<div class="kouen2"><img width="15" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"> <img src="http://www.jawhm.or.jp/images/uploads/files/USA.png"  width="15"> アメリカ＆カナダ体験談セミナー <img src=http://www.jawhm.or.jp/images/uploads/files/hana01.png height=15 width=15></div>
		<div align="right"><font size="1">講師：Ishikawa Mika</font><br/></div>
		<center>
		<img src="images/taiken/mika.jpg" style="padding-top:15px; padding-bottom:10px;">
		</center>
		<p>
		私は高校三年間を中国にあるカナディアンインターナショナルスクールで過ごし、その後、大学でアメリカオレゴン州での一年間の交換留学を経験しました。<br/>
			&nbsp;<br/>
		アメリカでの交換留学では、現地の学生となるべく多く交流するように心がけ、友達と動物園に行ったり、ショッピングに行ったり、日本料理を作ったり、日本語を教える代わりに英語を教えてもらいながら一緒に勉強したりと本当にいろいろなことをしました。<br/>
			&nbsp;<br/>
		また、ホームステイも経験し、アメリカ人のライフスタイルを知るだけでなく、クリスマスやサンクスギビングなどの伝統的なイベントを体験し、アメリカ文化に対する理解も深められました。<br/>
			&nbsp;<br/>
		渡航前は人見知りがちで英語を話すことにも自信がありませんでした。 しかし一年間の交換留学を通して、アメリカ人の明るくポジティブな性格に刺激され、人と話すことが楽しくなりました。そして現地で学校に通って生きた英語を学ぶことで、自分の英語力にも自信を持てました。<br/>
			&nbsp;<br/>
		この経験を生かして、セミナーでは私の現地での体験談以外にも、渡航前の英語の勉強法、現地での住まい、ホームステイについて、現地の人との交流、海外生活においての注意点などについてお話させていただきます。<br/>
			&nbsp;<br/>
		また渡航中にアメリカ・カナダの主要都市を旅行しましたので、アメリカ・カナダで都市を迷われている方へのアドバイスもさせていただきます。<br/>
			&nbsp;<br/>
		</p>
		<?php
	$keyword = 'mika';
	include './seminar_school.php';
?>
	</div>
	</div>
		</TD>
  </tbody>
</table>

<div style="text-align:right;"><A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div>
			&nbsp;<br/>
			&nbsp;<br/>
			
			
			
	</div>


	</div>
  </div>
  </div>

&nbsp;<br/>
			&nbsp;<br/>

	</div>
  </div>
  </div>
  </div>


<?php fncMenuFooter(); ?>


</body>
</html>