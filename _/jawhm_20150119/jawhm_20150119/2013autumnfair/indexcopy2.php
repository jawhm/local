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
<title>日本ワーキング・ホリデー協会　秋の留学＆ワーキングホリデーフェア2013 -</title>
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
	<font color="#ffffff">秋の留学＆ワーキングホリデーフェア2013</font><br/>
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
		speed:800,
		captions: true,
		pagerCustom:'none'
	});
});
</script>



<style type="text/css">
.bx-custom-pager{bottom: -35px !important;}
.bx-custom-pager .bx-pager-item{width: 20%}
.bx-pager-item .active img{opacity: 0.1}
</style>

<table>
<tr>
<td>
<div id="slider11">
	<li><img src="images/main1.jpg" align="left"/></li>
	<li><img src="images/main2.jpg" align="left"/></li>
	<li><img src="images/main3.jpg" align="left"/></li>
	<li><img src="images/main4.jpg" align="left"/></li>
	<li><img src="images/main5.jpg" align="left"/></li>
	<li><img src="images/main6.jpg" align="left"/></li>
	<li><img src="images/main7.jpg" align="left"/></li>
	<li><img src="images/main8.jpg" align="left"/></li>
	<li><img src="images/main9.jpg" align="left"/></li>
	<li><img src="images/main10.jpg" align="left"/></li>
	<li><img src="images/main11.jpg" align="left"/></li>
</div>
<td>
	<A href="#seminar"><img src="images/m_seminar_off.png" /></A><br/>
	<A href="#school"><img src="images/m_school_off.png" /></A>
</td>
</tr>
</table>
<table cellpadding="5">
<tr>
<td width="41%" background="images/hukidashi.gif">
	<p>ワーホリって何？どんなことが出来るの？予算はどのくらいかかるの？
	帰国してからの就職先が心配...
	聞きたい事や、心配な事もたくさんあると思います。何でも聞いてください。
	セミナーの参加者は８割以上の方が、お１人での参加です。お気軽にご参加ください。<br/>
	&nbsp;<br/>
	&nbsp;<br/>
	&nbsp;<br/>
	&nbsp;<br/>
	</p>
</td>
<td>
	<img src="images/m_kouen_off.png" />
	<img src="images/m_taiken_off.png" /></A>
	<img src="images/m_plan_off.png" />
</td>
</tr>
</table>

</div>

<a name="seminar"></a>
<h2 class="aki-title" id="seminar">セミナースケジュール</h2> 

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

<center>
	<p><strong>お近くの会場をクリックしてください。</p></strong>
	<A href="/2013autumnfair/indexcopy.php?p=tokyo#seminar"><img src="images/tokyo_off.png" width="20%" /></A>
	<A href="/2013autumnfair/indexcopy.php?p=osaka#seminar"><img src="images/osaka_off.png" width="20%"/></A>
	<A href="/2013autumnfair/indexcopy.php?p=nagoya#seminar"><img src="images/nagoya_off.png" width="20%"/></A>
	<A href="/2013autumnfair/indexcopy.php?p=fukuoka#seminar"><img src="images/fukuoka_off.png" width="20%"/></A>
</center>

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
		calendar_display('osaka', 2013, 10);
	}
	if ( $region == 'fukuoka' || $region == 'FUKUOKA')	{
		echo '<h3 id="fukuoka"></h3>';
		calendar_display('fukuoka', 2013, 10);
	}
	if ( $region == 'nagoya' || $region == 'AICHI')	{
		echo '<h3 id="fukuoka"></h3>';
		calendar_display('nagoya', 2013, 10);
	}
?>

<div style="text-align:right;"><A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div><br />


<h2 class="aki-title" id="school">参加語学学校</h2> 
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



			&nbsp;<br/>
			&nbsp;<br/>
			
			
			
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