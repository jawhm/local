
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<?
//	ini_set( "display_errors", "On");
	require_once '../include/menubar.php';

function is_mobile () {
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

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>日本ワーキング・ホリデー協会　春の留学＆ワーキングホリデーフェア2012 -</title>
<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon" />
<meta name="keywords" content="オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館," />
<meta name="description" content="オーストラリア・ニュージーランド・カナダを初めとしたワーキングホリデー協定国の最新のビザ取得方法や渡航情報などを発信しています。" />
<meta name="author" content="Japan Association for Working Holiday Makers" />
<meta name="copyright" content="Japan Association for Working Holiday Makers" />
<link rev="made" href="mailto:info@jawhm.or.jp" />
<link rel="Top" href="index.html" type="text/html" title="一般社団法人 日本ワーキング・ホリデー協会" />
<link rel="Author" href="mailto:info@jawhm.or.jp" title="E-mail address" />

<link href="http://www.jawhm.or.jp/css/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://www.jawhm.or.jp/js/jquery.js"></script>
<script type="text/javascript" src="http://www.jawhm.or.jp/js/jquery-easing.js"></script>
<script type="text/javascript" src="http://www.jawhm.or.jp/js/scroll.js"></script>
<script type="text/javascript" src="http://www.jawhm.or.jp/js/linkboxes.js"></script>
<script type="text/javascript" src="../js/jquery.blockUI.js"></script>
<script type="text/javascript" src="js/jquery.tipTip.minified.js"></script>
<script type="text/javascript" src="js/fitiframe.js?auto=0"></script>
<link href="http://www.jawhm.or.jp/css/headhootg-nav.css" rel="stylesheet" type="text/css" />
<link href="css/contents_wide.css" rel="stylesheet" type="text/css" />
<link href="css/tipTip.css" rel="stylesheet" type="text/css" />

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

<style>
.button_yoyaku	{
	background-color: navy;
	color: white;
	cursor: pointer;
	padding: 0 5px 0 5px;
	margin: 0 0 3px 0;
	font-weight: bold;
}
.button_submit	{
	background: url(../images/button_submit.png) no-repeat 0 0;
	padding-left: 16px;
	cursor: pointer;
}

.button_cancel	{
	background: url(../images/button_cancel.png) no-repeat 0 0;
	padding-left: 16px;
	cursor: pointer;
}

.button_next	{
	background: url(../images/button_next.png) no-repeat 0 0;
	padding-left: 16px;
	cursor: pointer;
}

.shibori	{
	font-size: 10pt;

}
.open	{
	font-size:9pt;
	font-weight:bold;
	color : orange;
	cursor:pointer;
	margin: 0 0 10px 0;
}
</style>

<script type="text/javascript">

function fncplacesel(obj)	{
	if (jQuery(obj).attr('checked'))	{
		jQuery( 'input:checkbox', '#shiborikomi' ).button('destroy');
		if (obj.value != 'all')		{	jQuery('#place-all').removeAttr('checked');	}
		if (obj.value != 'tokyo')	{	jQuery('#place-tokyo').removeAttr('checked');	}
		if (obj.value != 'osaka')	{	jQuery('#place-osaka').removeAttr('checked');	}
		if (obj.value != 'sendai')	{	jQuery('#place-sendai').removeAttr('checked');	}
		if (obj.value != 'toyama')	{	jQuery('#place-toyama').removeAttr('checked');	}
		if (obj.value != 'fukuoka')	{	jQuery('#place-fukuoka').removeAttr('checked');	}
		if (obj.value != 'okinawa')	{	jQuery('#place-okinawa').removeAttr('checked');	}
	}
	fncsemiser();
}
function fnccountrysel()	{
	jQuery('#country-all').button('destroy');
	jQuery('#country-all').removeAttr('checked');
	jQuery('#country-all').button();
	fncsemiser();
}
function fnccountryall()	{
	if (jQuery('#country-all').attr('checked'))	{
		jQuery( 'input:checkbox', '#shiborikomi' ).button('destroy');
		jQuery('#country-aus').removeAttr('checked');
		jQuery('#country-nz').removeAttr('checked');
		jQuery('#country-can').removeAttr('checked');
		jQuery('#country-uk').removeAttr('checked');
		jQuery('#country-fra').removeAttr('checked');
		jQuery('#country-other').removeAttr('checked');
	}
	fncsemiser();
}
function fncknowsel()	{
	jQuery('#know-all').button('destroy');
	jQuery('#know-all').removeAttr('checked');
	jQuery('#know-all').button();
	fncsemiser();
}
function fncknowall()	{
	if (jQuery('#know-all').attr('checked'))	{
		jQuery( 'input:checkbox', '#shiborikomi' ).button('destroy');
		jQuery('#know-first').removeAttr('checked');
		jQuery('#know-sanpo').removeAttr('checked');
		jQuery('#know-sc').removeAttr('checked');
		jQuery('#know-ga').removeAttr('checked');
		jQuery('#know-si').removeAttr('checked');
	}
	fncsemiser();
}
function fncsemiser()	{
	jQuery('#semi_show').html('<div style="vertical-align:middle; text-align:center; margin:30px 0 30px 0; font-size:20pt;"><img src="../images/ajax-loader.gif">セミナーを探しています...</div>');
	$senddata = jQuery('#kensakuform').serialize();
	$.ajax({
		type: "POST",
		url: "/2012springfair/seminar_search.php",
		data: $senddata,
		success: function(msg){
			jQuery('#semi_show').html(msg);
		},
		error:function(){
			alert('通信エラーが発生しました。');
		}
	});
}

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
background: #91c835;
}

/*CSS for example Accordion #hc2*/

#hc2 li{
margin:0 0 0 0; /*Spacing between each LI container*/
border: 12px solid black;
}

#hc2 li .hpanel{
padding: 5px; /*Padding inside each content*/
background: #E2E9FF;
cursor: hand;
cursor: pointer;
}

</style><script type="text/javascript">
haccordion.setup({
	accordionid: 'hc1', //main accordion div id
	paneldimensions: {peekw:'38px', fullw:'600px', h:'400px'},
	selectedli: [5, false], //[selectedli_index, persiststate_bool]
	collapsecurrent: false //<- No comma following very last setting!
})

haccordion.setup({
	accordionid: 'hc2', //main accordion div id
	paneldimensions: {peekw:'38px', fullw:'600px', h:'400px'},
	selectedli: [5, true], //[selectedli_index, persiststate_bool]
	collapsecurrent: true //<- No comma following very last setting!
})

</script>



</head>
<body>


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
    <h1><a href="http://www.jawhm.or.jp/index.html"><img src="http://www.jawhm.or.jp/images/h1-logo.jpg" alt="一般社団法人日本ワーキング・ホリデー協会" width="410" height="33" /></a></h1>
</div>
  <div id="contentsbox"><img id="bgtop" src="http://www.jawhm.or.jp/images/contents-bgtop.gif" alt="" />
  <div id="contents">

	<div id="maincontent" style="margin-left:30px;">
	<div id="top-main" style="width:300px;margin-bottom:20px;">

<!--
	<h2 class="sec-title">★春の留学・ワーキングホリデーフェア開催！！★</h2>
	<div  style="width:830px;line-height:1.3" ><Font Size="2">本年、オーストラリアとの協定から始まったワーキングホリデー制度が30周年を迎え、
		日本人がワーキングホリデーを使って生活できる国は11カ国まで増えました。
		そんな節目の年に、日本ワーキング・ホリデー協会では春の留学＆ワーキングホリデーフェアを開催します。
		皆様が留学＆ワーキングホリデーを考えるきっかけとして、また、より一層素晴らしい留学＆ワーキング
		ホリデーにする為に、是非この機会にフェアにご参加下さい！</font><br />
	</div></div>
-->


		<div class="top-entry01" style="width:900px;">
<div align="center">

<div id="hc1" class="haccordion">
<ul>
	<li>
		<div class="hpanel" style="width:650px">
		<A Href="#seminar"><img src="03.png" style="float:left; padding-right:8px;" /></a>
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:660px">
		<A Href="#school"><img src="01.png" style="float:left; padding-right:8px;" /></a>
	</li>

	<li>
		<div class="hpanel" style="width:660px">
		<A Href="#kouen"><img src="04.png" style="float:left; padding-right:8px;" /></a>
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:660px">
		<A Href="#seminar"><img src="02.png" style="float:left; padding-right:8px;" /></a>
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:660px">
		<A Href="#seminar"><img src="05.png" style="float:left; padding-right:8px;" /></a>
		</div>
	</li>
	<li>
		<div class="hpanel" style="width:660px">
		<img src="00.png" style="float:left; padding-right:8px;" />
		</div>
	</li>
</ul>
</div>
</div>
<p style="clear:center; margin-left:80px;"><a href="javascript:haccordion.expandli('hc1', 0)">留学&ワーホリセミナー</a> | <a href="javascript:haccordion.expandli('hc1', 1)">語学学校セミナー</a> | <a href="javascript:haccordion.expandli('hc1', 2)">講演会セミナー</a> | <a href="javascript:haccordion.expandli('hc1', 3)">帰国者体験談</a> | <a href="javascript:haccordion.expandli('hc1', 4)">個別カウンセリング</a> | <a href="javascript:haccordion.expandli('hc1', 5)">春の留学＆ワーホリフェア</a> </p>



<img src="images/01.gif" style="margin-top:36px; margin-left:-20px;" id="seminar"> 


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


<div style="border: 2px dotted #cccccc; font-size:10pt; margin: 10px 10px 10px 10px; padding: 10px 20px 10px 20px;" >
	ワーキングホリデーって何？　どんなことが出来るの？　予算はどのくらいかかるの？<br/>
	帰国してからの就職先が心配...　　初めての海外だけどワーホリで大丈夫？<br/>
	聞きたい事や、心配な事もたくさんあると思います。何でも聞いてください。<br/>
	セミナーの参加者は８割以上の方が、お１人での参加です。お気軽にご参加ください。<br/>
	<br/>
	<b><big>会場を選んで下さい。</big></b>
	<A Href="#tokyo"><img src="images/tokyo.gif" /></A>&nbsp;
	<A Href="#osaka"><img src="images/osaka.gif" /></A><br />
	<br />
	<div style="line-height:1.2"><b>【ご注意：予約フォームが正しく機能しない場合】</b><br />
		<font size="1.5">スマートフォンなど、ＰＣ以外のブラウザからご利用された場合、予約フォームが正しく機能しない場合があります。<br />
		この場合、お手数ですが、以下の内容を <b>toiawase@jawhm.or.jp</b> までご連絡ください。<br />
		　・　参加希望のセミナー日程<br />
		　・　お名前<br />
		　・　当日連絡の付く電話番号<br />
		　・　興味のある国<br />
		　・　出発予定時期<br /></font>
	</div>
</div>

<br/>

<h3 id="tokyo">　<img src="images/01_tokyo.gif" >

<?
$seminars = array(
	array('2012429','0','29',''),
	array('2012430','0','30',''),
	array('201251','0','1',''),
	array('201252','0','2',''),
	array('201253','0','3',''),
	array('201254','0','4',''),
	array('201255','2','5','<img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">',''),
	array('201256','2','6','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">'),
	array('201257','1','7','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">'),
	array('201258','1','8',' <img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"><img src="http://www.jawhm.or.jp/event/getlist/img/New-Zealand.png"><img src="http://www.jawhm.or.jp/event/getlist/img/United-Kindom.png">'),
	array('201259','1','9','<img  width=17 src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img width=17 src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"><img width=17 src="http://www.jawhm.or.jp/event/getlist/img/New-Zealand.png"><img width=17 src="http://www.jawhm.or.jp/event/getlist/img/United-Kindom.png"><img width=17 src="http://www.jawhm.or.jp/event/getlist/img/France.png"><img width=17 src="http://jawhm.or.jp/images/Germany.png"><img width=17 src="http://www.jawhm.or.jp/event/getlist/img/Denmark.png">'),
	array('2012510','1','10','<img  width=21 src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/New-Zealand.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/United-Kindom.png">'),
	array('2012511','1','11',' <img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">',''),
	array('2012512','1','12',' <img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png">',''),
	array('2012513','2','13',' <img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">',''),
	array('2012514','1','14',' <img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img  src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">',''),
	array('2012515','1','15',' <img width=21 src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/New-Zealand.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/United-Kindom.png">',''),
	array('2012516','1','16',' <img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">',''),
	array('2012517','1','17',' <img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png">',''),
	array('2012518','1','18','<img width=21 src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/New-Zealand.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/United-Kindom.png">'),
	array('2012519','1','19',''),
	array('2012520','2','20',' <img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png">',''),
	array('2012521','1','21',' <img width=21 src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/New-Zealand.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/United-Kindom.png">'),
	array('2012522','1','22','<img  width=21 src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/New-Zealand.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/United-Kindom.png">'),
	array('2012523','1','23',''),
	array('2012524','1','24','<img  src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">'),
	array('2012525','1','25',''),
	array('2012526','1','26',''),
	array('2012527','2','27',' <img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">'),
	array('2012528','1','28','<img width=21 src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/New-Zealand.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/United-Kindom.png">'),
	array('2012529','1','29','<img width=17 src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"><img width=17 src="http://www.jawhm.or.jp/event/getlist/img/France.png"><img width=17 src="http://www.jawhm.or.jp/event/getlist/img/United-Kindom.png"><img width=17 src="http://jawhm.or.jp/images/Germany.png"><img width=17 src="http://www.jawhm.or.jp/event/getlist/img/Denmark.png">'),
	array('2012530','1','30','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png">'),
	array('2012531','1','31',''),
	array('','0','',''),
	array('','0','',''),

);

	foreach($seminars as $days)
	{
		$cal[$days[0]] = '';
		$cal_msg[$days[0]] = '';
		$cal_img[$days[0]] = '';
	}

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');

		$cal = array();
		$tyo_ymd   = array();
		$tyo_title = array();
		$tyo_desc  = array();
		$tyo_img   = array();
		$tyo_btn   = array();
		$tyo_id	   = array();

		$keyword = ' and hiduke >= "2012/05/05" and hiduke <= "2012/05/31" and k_title1 like "<img src=http://jawhm.or.jp/images/ajaxloadr.gif>%" and place = "tokyo"';

		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%a\') as youbi, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking, type FROM event_list WHERE k_use = 1 '.$keyword.' ORDER BY hiduke, starttime, id');
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

			$start	= $row['start'].'～';
			$start	= mb_ereg_replace('Mon', '月', $start);
			$start	= mb_ereg_replace('Tue', '火', $start);
			$start	= mb_ereg_replace('Wed', '水', $start);
			$start	= mb_ereg_replace('Thu', '木', $start);
			$start	= mb_ereg_replace('Fri', '金', $start);
			$start	= mb_ereg_replace('Sat', '土', $start);
			$start	= mb_ereg_replace('Sun', '日', $start);

			$youbi	= $row['youbi'];
			$youbi	= mb_ereg_replace('Mon', '月', $youbi);
			$youbi	= mb_ereg_replace('Tue', '火', $youbi);
			$youbi	= mb_ereg_replace('Wed', '水', $youbi);
			$youbi	= mb_ereg_replace('Thu', '木', $youbi);
			$youbi	= mb_ereg_replace('Fri', '金', $youbi);
			$youbi	= mb_ereg_replace('Sat', '土', $youbi);
			$youbi	= mb_ereg_replace('Sun', '日', $youbi);
			
			$title	= $start.' '.$row['k_title1'];

			$tyo_id[] = $row['id'];
			$tyo_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
			if ($row['free'] == 1)	{
				if ($mem_id == '')	{
					$c_title = '<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/register.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="/member">ログイン</a>するとご予約が可能となります。</div>';
				}else{
					$c_title = '';
				}
			}else{
				$c_title = '';
			}
			$c_desc = $row['k_desc1'];
			if ($row['k_stat'] == 1)	{
				if ($row['booking'] >= $row['pax'])	{
					$c_img   	= '[満席です]';
				}else{
					$c_img   	= '[残席わずかです。ご予約はお早めに]';
				}
			}elseif ($row['k_stat'] == 2)	{
				$c_img   	= '[満席です]';
			}else{
				if ($row['booking'] >= $row['pax'])	{
					$c_img   	= '[満席です]';
				}else{
					if ($row['booking'] >= $row['pax'] / 3)	{
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					}else{
						$c_img	= '';
					}
				}
			}
			if ($row['free'] == 1)	{
				if ($mem_id == '')	{
					$c_btn	= '[メンバー限定]';
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[東京]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[東京]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}
			}else{
				if ($row['k_stat'] == 2)	{
					$c_btn	= '[満席]';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[東京]'.$title.'" uid="'.$row['id'].'">';
					}else{
						$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[東京]'.$title.'" uid="'.$row['id'].'">';
					}
				}
			}

			$tyo_title[]	= $title.$c_title;
			$tyo_desc[]	= $c_desc;
			$tyo_img[]	= $c_img;
			$tyo_btn[]	= $c_btn;

			if ($c_img <> '')	{
				$c_img = '<div style="color:red; font-size:11pt; font-weight:bold; margin-left:150px;">'.$c_img.'</div>';
			}

			$cal[$year.$month.$day] .= '<img src="../images/sa05.jpg">';
			$c_msg  = '<tr><td nowrap style="vertical-align:top;">'.$row['starttime'].'～ </td><td nowrap style="vertical-align:top;">'.$c_btn.'</td>';
			$c_msg .= '<td>'.$row['k_title1'].'</td></tr><tr><td colspan="4">';
			$c_msg .= ''.$c_img.'<div class="open" style="margin-left:150px;">セミナー詳細はココをClick!!</div>';
			$c_msg .= '<div class="det" style="margin:5px 0 10px 50px; padding: 5px 0 13px 12px; display:none; border-left:1px dotted navy; border-bottom: 1px dotted navy;">'.$c_title.nl2br($c_desc).'</div></td></tr>';
			if ($cal_msg[$year.$month.$day] == '')	{
				$cal_msg[$year.$month.$day] .= '<div style="font-size:12pt; font-weight:bold; margin:8px 0 0 20px; text-align:left; cursor:default;">';
				$cal_msg[$year.$month.$day] .= '<input type="button" class="button_cancel" value="　戻る　" onclick="btn_cancel();">';
				$cal_msg[$year.$month.$day] .= '<span style="font-size:18pt; font-weight:bold; margin-left:50px;">'.$month.'</span>月 ';
				$cal_msg[$year.$month.$day] .= '<span style="font-size:18pt; font-weight:bold;">'.$day.'</span>日 ';
				$cal_msg[$year.$month.$day] .= '<span style="font-size:18pt; font-weight:bold; margin-left:10px;">'.$youbi.'</span>曜日 ';
				$cal_msg[$year.$month.$day] .= '<span style="font-size:14pt; font-weight:bold; margin-left:50px;"><a target="_blank" href="/event/map/?p=tokyo">東京会場</a></span>';
				$cal_msg[$year.$month.$day] .= '<div style="border: 2px dotted navy; padding: 3px 0 3px 0; margin: 10px 15px 5px 10px; text-align:center;">';
				$cal_msg[$year.$month.$day] .= 'セミナー参加が初めての場合は、「初心者向けセミナー」からご参加いただく様にお願いします。</div>';
				$cal_msg[$year.$month.$day] .= '</div>';
				$cal_msg[$year.$month.$day] .= '<div style="font-size:11pt; text-align:left; overflow:scroll; width:800px; height:500px; cursor:default;">';
				$cal_msg[$year.$month.$day] .= '<table style="margin: 10px 16px 12px 16px;">';
			}
			$cal_msg[$year.$month.$day] .= $c_msg;
			$cal_img[$year.$month.$day] .= '<img src="../images/seminaryoyaku/'.$row['type'].'.gif"><br/>';
		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}

?>

<img src="../images/seminaryoyaku/week.gif">
<div id="calshow" style="maring-top:0px; width:910px;">
	<div class="sponsorListHolder">
        <?php
		$divblock = '';
		foreach($seminars as $days)
		{
			$daystyle = '';
			if ( $days[1] == '0' )	{	$daystyle = 'color:#cccccc;';	}
			if ( $days[1] == '1' )	{	$daystyle = 'color:#000000;';	}
			if ( $days[1] == '2' )	{	$daystyle = 'color:#FF0000;';	}
			if ( $cal_img[$days[0]] == '' )	{
				$pointstyle = 'cursor:auto;';
				$divtitle = '';
				$onclick = '';
			}else{
				$pointstyle = 'cursor:pointer;';
				$divtitle = 'title="クリックして詳細を表示"';
				$onclick = 'onclick="$.blockUI({ message: $(\'#tokyo'.$days[0].'\'),css: { top: ($(window).height() - 650) /2 + \'px\', left: ($(window).width() - 800) /2 + \'px\', width: \'800px\' }});"';
				$divblock .= '
<div id="tokyo'.$days[0].'" style="display:none;">
		'.$cal_msg[$days[0]].'</table>
	</div>
</div>';
			}

			echo'
			<div class="calender" '.$divtitle.' style="border:1px solid #cccccc; width:122px; height:160px; margin-bottom:4px; margin-left:3px; float:left; '.$pointstyle.'" '.$onclick.'>
				<div style="margin:3px 0 0 5px;"><span style="font-size:14pt; font-weight:bold;'.$daystyle.'">'.$days[2].'</span>
				'.$days[3].'</div>				
				<div style="margin:3px 0 0 5px;">'.$cal_img[$days[0]].'</div>
				<div style="margin:3px 0 0 5px;">'.$days[4].'</div>				
			</div>
			';
		}
	?>
	<div style="clear:both;"></div>
    </div>
</div>

<? echo $divblock; ?>

<div style="text-align:center;"><font size=2><b><font color=blue>青</font>⇒オーストラリア語学学校セミナー　<font color=red>赤</font>⇒カナダ語学学校セミナー　<font color=orange>橙</font>⇒ワーホリ協会セミナー　<font color=green>緑</font>⇒少人数懇談セミナー</font></b>
</div>

<div style="text-align:right;"><A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div><br />


		<HR size="1" color="#cccccc" style="border-style:dotted">
<br />
<br />

<h3 id="osaka">　<img src="images/01_osaka.gif" >

<?
$seminars = array(
	array('2012429','0','29','',''),
	array('2012430','0','30','',''),
	array('201251','0','1','',''),
	array('201252','0','2','',''),
	array('201253','0','3','',''),
	array('201254','0','4','',''),
	array('201255','1','5','',''),
	array('201256','2','6','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png">',''),
	array('201257','1','7','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">','<img src="images/chuukei.gif">'),
	array('201258','1','8','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"><img src="http://www.jawhm.or.jp/event/getlist/img/New-Zealand.png"><img src="http://www.jawhm.or.jp/event/getlist/img/United-Kindom.png">','<img src="images/chuukei.gif">'),
	array('201259','1','9','',''),
	array('2012510','1','10','',''),
	array('2012511','1','11','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">','<img src="images/chuukei.gif">'),
	array('2012512','1','12','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png">','<img src="images/chuukei.gif">'),
	array('2012513','2','13','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">','<img src="images/chuukei.gif">'),
	array('2012514','1','14','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png">',''),
	array('2012515','1','15','',''),
	array('2012516','1','16','',''),
	array('2012517','1','17','',''),
	array('2012518','1','18','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">',''),
	array('2012519','1','19','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png">'),
	array('2012520','2','20','',''),
	array('2012521','1','21','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">',''),
	array('2012522','1','22','<img src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"><img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">',''),
	array('2012523','1','23','',''),
	array('2012524','1','24','',''),
	array('2012525','1','25','',''),
	array('2012526','1','26','',''),
	array('2012527','2','27',' <img src="http://www.jawhm.or.jp/event/getlist/img/Canada.png">','<img src="images/chuukei.gif">'),
	array('2012528','1','28','',''),
	array('2012529','1','29','<img width=21 src="http://www.jawhm.or.jp/event/getlist/img/France.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/United-Kindom.png"><img width=21 src="http://jawhm.or.jp/images/Germany.png"><img width=21 src="http://www.jawhm.or.jp/event/getlist/img/Denmark.png">','<img src="images/chuukei.gif">'),
	array('2012530','1','30','',''),
	array('2012531','1','31','',''),
	array('','0','','',''),
	array('','0','','',''),

);

	foreach($seminars as $days)
	{
		$cal[$days[0]] = '';
		$cal_msg[$days[0]] = '';
		$cal_img[$days[0]] = '';
	}

	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');

		$cal = array();
		$tyo_ymd   = array();
		$tyo_title = array();
		$tyo_desc  = array();
		$tyo_img   = array();
		$tyo_btn   = array();
		$tyo_id	   = array();

		$keyword = ' and hiduke >= "2012/05/05" and hiduke <= "2012/05/31" and k_title1 like "<img src=http://jawhm.or.jp/images/ajaxloadr.gif>%" and place = "osaka"';

		$rs = $db->query('SELECT id, year(hiduke) as yy, month(hiduke) as mm, day(hiduke) as dd, date_format(starttime, \'%c月%e日 (%a) %k:%i\') as start, date_format(starttime, \'%a\') as youbi, date_format(starttime, \'%k:%i\') as starttime, title, memo, place, k_use, k_title1, k_desc1, k_stat, free, pax, booking, type FROM event_list WHERE k_use = 1 '.$keyword.' ORDER BY hiduke, starttime, id');
		$cnt = 0;
		while($row = $rs->fetch(PDO::FETCH_ASSOC)){
			$cnt++;
			$year	= $row['yy'];
			$month  = $row['mm'];
			$day	= $row['dd'];

			$start	= $row['start'].'～';
			$start	= mb_ereg_replace('Mon', '月', $start);
			$start	= mb_ereg_replace('Tue', '火', $start);
			$start	= mb_ereg_replace('Wed', '水', $start);
			$start	= mb_ereg_replace('Thu', '木', $start);
			$start	= mb_ereg_replace('Fri', '金', $start);
			$start	= mb_ereg_replace('Sat', '土', $start);
			$start	= mb_ereg_replace('Sun', '日', $start);

			$youbi	= $row['youbi'];
			$youbi	= mb_ereg_replace('Mon', '月', $youbi);
			$youbi	= mb_ereg_replace('Tue', '火', $youbi);
			$youbi	= mb_ereg_replace('Wed', '水', $youbi);
			$youbi	= mb_ereg_replace('Thu', '木', $youbi);
			$youbi	= mb_ereg_replace('Fri', '金', $youbi);
			$youbi	= mb_ereg_replace('Sat', '土', $youbi);
			$youbi	= mb_ereg_replace('Sun', '日', $youbi);
			
			$title	= $start.' '.$row['k_title1'];

			$tyo_id[] = $row['id'];
			$tyo_ymd[] = $year.substr('00'.$month,-2).substr('00'.$day,-2);
			if ($row['free'] == 1)	{
				if ($mem_id == '')	{
					$c_title = '<div style="margin: 10px 0 10px 0; padding:5px 20px 5px 20px; border: 1px solid navy;">【こちらはメンバー様限定セミナーです】<br/>メンバー登録を行って頂くとご予約が可能となります。<a href="./mem/register.php">登録はこちらからどうぞ</a><br/>メンバーの方は、<a href="/member">ログイン</a>するとご予約が可能となります。</div>';
				}else{
					$c_title = '';
				}
			}else{
				$c_title = '';
			}
			$c_desc = $row['k_desc1'];
			if ($row['k_stat'] == 1)	{
				if ($row['booking'] >= $row['pax'])	{
					$c_img   	= '[満席です]';
				}else{
					$c_img   	= '[残席わずかです。ご予約はお早めに]';
				}
			}elseif ($row['k_stat'] == 2)	{
				$c_img   	= '[満席です]';
			}else{
				if ($row['booking'] >= $row['pax'])	{
					$c_img   	= '[満席です]';
				}else{
					if ($row['booking'] >= $row['pax'] / 3)	{
						$c_img   	= '[残席わずかです。ご予約はお早めに]';
					}else{
						$c_img	= '';
					}
				}
			}
			if ($row['free'] == 1)	{
				if ($mem_id == '')	{
					$c_btn	= '[メンバー限定]';
				}else{
					if ($row['k_stat'] == 2)	{
						$c_btn	= '[満席]';
					}else{
						if ($row['booking'] >= $row['pax'])	{
							$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[大阪]'.$title.'" uid="'.$row['id'].'">';
						}else{
							$c_btn	= '<input class="button_yoyaku" type="button" value="メンバー専用予約" onclick="fnc_yoyaku(this);" title="[大阪]'.$title.'" uid="'.$row['id'].'">';
						}
					}
				}
			}else{
				if ($row['k_stat'] == 2)	{
					$c_btn	= '[満席]';
				}else{
					if ($row['booking'] >= $row['pax'])	{
						$c_btn	= '<input class="button_yoyaku" type="button" value="キャンセル待ち" onclick="fnc_yoyaku(this);" title="[大阪]'.$title.'" uid="'.$row['id'].'">';
					}else{
						$c_btn	= '<input class="button_yoyaku" type="button" value="予約" onclick="fnc_yoyaku(this);" title="[大阪]'.$title.'" uid="'.$row['id'].'">';
					}
				}
			}

			$tyo_title[]	= $title.$c_title;
			$tyo_desc[]	= $c_desc;
			$tyo_img[]	= $c_img;
			$tyo_btn[]	= $c_btn;

			if ($c_img <> '')	{
				$c_img = '<div style="color:red; font-size:11pt; font-weight:bold; margin-left:150px;">'.$c_img.'</div>';
			}

			$cal[$year.$month.$day] .= '<img src="../images/sa05.jpg">';
			$c_msg  = '<tr><td nowrap style="vertical-align:top;">'.$row['starttime'].'～ </td><td nowrap style="vertical-align:top;">'.$c_btn.'</td>';
			$c_msg .= '<td>'.$row['k_title1'].'</td></tr><tr><td colspan="4">';
			$c_msg .= ''.$c_img.'<div class="open" style="margin-left:150px;">セミナー詳細はココをClick!!</div>';
			$c_msg .= '<div class="det" style="margin:5px 0 10px 50px; padding: 5px 0 13px 12px; display:none; border-left:1px dotted navy; border-bottom: 1px dotted navy;">'.$c_title.nl2br($c_desc).'</div></td></tr>';
			if ($cal_msg[$year.$month.$day] == '')	{
				$cal_msg[$year.$month.$day] .= '<div style="font-size:12pt; font-weight:bold; margin:8px 0 0 20px; text-align:left; cursor:default;">';
				$cal_msg[$year.$month.$day] .= '<input type="button" class="button_cancel" value="　戻る　" onclick="btn_cancel();">';
				$cal_msg[$year.$month.$day] .= '<span style="font-size:18pt; font-weight:bold; margin-left:50px;">'.$month.'</span>月 ';
				$cal_msg[$year.$month.$day] .= '<span style="font-size:18pt; font-weight:bold;">'.$day.'</span>日 ';
				$cal_msg[$year.$month.$day] .= '<span style="font-size:18pt; font-weight:bold; margin-left:10px;">'.$youbi.'</span>曜日 ';
				$cal_msg[$year.$month.$day] .= '<span style="font-size:14pt; font-weight:bold; margin-left:50px;"><a target="_blank" href="/event/map/?p=osaka">大阪会場</a></span>';
				$cal_msg[$year.$month.$day] .= '<div style="border: 2px dotted navy; padding: 3px 0 3px 0; margin: 10px 15px 5px 10px; text-align:center;">';
				$cal_msg[$year.$month.$day] .= 'セミナー参加が初めての場合は、「初心者向けセミナー」からご参加いただく様にお願いします。</div>';
				$cal_msg[$year.$month.$day] .= '</div>';
				$cal_msg[$year.$month.$day] .= '<div style="font-size:11pt; text-align:left; overflow:scroll; width:800px; height:500px; cursor:default;">';
				$cal_msg[$year.$month.$day] .= '<table style="margin: 10px 16px 12px 16px;">';
			}
			$cal_msg[$year.$month.$day] .= $c_msg;
			$cal_img[$year.$month.$day] .= '<img src="../images/seminaryoyaku/'.$row['type'].'.gif"><br/>';
		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}

?>

<img src="../images/seminaryoyaku/week.gif">
<div id="calshow" style="maring-top:0px; width:910px;">
	<div class="sponsorListHolder">
        <?php
		$divblock = '';
		foreach($seminars as $days)
		{
			$daystyle = '';
			if ( $days[1] == '0' )	{	$daystyle = 'color:#cccccc;';	}
			if ( $days[1] == '1' )	{	$daystyle = 'color:#000000;';	}
			if ( $days[1] == '2' )	{	$daystyle = 'color:#FF0000;';	}
			if ( $cal_img[$days[0]] == '' )	{
				$pointstyle = 'cursor:auto;';
				$divtitle = '';
				$onclick = '';
			}else{
				$pointstyle = 'cursor:pointer;';
				$divtitle = 'title="クリックして詳細を表示"';
				$onclick = 'onclick="$.blockUI({ message: $(\'#osaka'.$days[0].'\'),css: { top: ($(window).height() - 650) /2 + \'px\', left: ($(window).width() - 800) /2 + \'px\', width: \'800px\' }});"';
				$divblock .= '
<div id="osaka'.$days[0].'" style="display:none;">
		'.$cal_msg[$days[0]].'</table>
	</div>
</div>';
			}

			echo'
			<div class="calender" '.$divtitle.' style="border:1px solid #cccccc; width:122px; height:160px; margin-bottom:4px; margin-left:3px; float:left; '.$pointstyle.'" '.$onclick.'>
				<div style="margin:3px 0 0 5px;"><span style="font-size:14pt; font-weight:bold;'.$daystyle.'">'.$days[2].'</span>
				'.$days[3].'</div>				
				<div style="margin:3px 0 0 5px;">'.$cal_img[$days[0]].'</div>
				<div style="margin:3px 0 0 5px;">'.$days[4].'</div>				

			</div>
			';
		}
	?>
	<div style="clear:both;"></div>
    </div>
</div>

<? echo $divblock; ?>
<div style="text-align:center;"><font size=2><b><font color=blue>青</font>⇒オーストラリア語学学校セミナー　<font color=red>赤</font>⇒カナダ語学学校セミナー　<font color=orange>橙</font>⇒ワーホリ協会セミナー　<font color=green>緑</font>⇒少人数懇談セミナー</font></b>
</div>

<div style="text-align:right;"><A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div><br />


<img src="images/02.gif" style="margin-top:36px; margin-left:-20px;" id="kouen">
<br />
<br />
<br />

<table>
	<tr>
	<td>
		<img src="images/kouen1.jpg" Width="130px" hspace="30px" style="border: 1px dotted #555555;padding: 5px 5px 5px 5px;">
	</td>
	<td>
		<font size="2" color="#33cc33">
		<b>5月8日（火）13：00<br /></font>
		<font size="3">
		 これから求められるグローバル人材について</b></font>
	<font size="1" color="#373737">
		　講師：UMC　財田　歩弥 様<br/>

	<div style="line-height:1.5;">
		<HR size="1" color="#cccccc" style="border-style:dotted" width="600">
		企業の海外進出、日本の不景気による海外就職への関心など、
		今日の日本人に求められている「グローバル人材」<br>
		グローバル人材、よく聞く言葉ですが、どのような人材かご存じですか？<br/>
		まずはじめに浮かぶのは語学力かもしれません。<br/>
		実際に海外で働く講師の目から見た
		グローバル人材に必要な要素、そしてその活躍の場などをお話します。<br/>
	</div>
	</font>
	</td>
	</tr>
        <tr>
            <td><input type="button" name="test" value="テスト"></td>
        </tr>
</table>

<br /><br /><br /><br />

<table>
	<tr>
	<td>
		<img src="images/kouen2.jpg"   Width="130px" hspace="30px" style="border: 1px dotted #555555;padding: 5px 5px 5px 5px;">
	</td>
	<td>
		<font size="2" color="#33cc33">
		<b>5月11日（金）15：00<br /></font>
		<font size="3">
		 オーストラリアでの仕事探しについて</b></font>
	<font size="1" color="#373737">
		　講師：BROWNS　西村　リョウヘイ 様<br/>

	<div style="line-height:1.5;">
		<HR size="1" color="#cccccc" style="border-style:dotted" width="650">
			<b>◆仕事探しの常識</b>-　日本とオーストラリアのココが違う!!
			　目安となる給料は？-　フルタイム、パートタイム、カジュアル<br />
			　　　　　　　　　　　　　　英語力の有無　仕事探しに必要なこと<br />
<br />
			<b>◆仕事探しの準備</b>-　日本から準備出来ること(PCスキル、Facebook、自己分析）… 履歴書　情報源<br />
		<br />
			<b>◆成功の秘訣</b>　…　積極性　受身では成功しにくい　失敗を恐れずに、失敗は恥ずかしくない　Can Do Attitude!<br />
	</div>
	</font>
	</td>
	</tr>
</table>

<br /><br /><br /><br />

<table>
	<tr>
	<td>
		<img src="images/kouen3.jpg" Width="130px"  hspace="30px" style="border: 1px dotted #555555;padding: 5px 5px 5px 5px;"> 
	</td>
	<td>
		<font size="2" color="#33cc33">
		<b>5月11日（金）16：00<br /></font>
		<font size="3">
		 海外留学、そして海外就職</b></font>
	<font size="1" color="#373737">
		　講師：ILAC　山口　ひかり 様<br/>

	<div style="line-height:1.5;">
		<HR size="1" color="#cccccc" style="border-style:dotted" width="650">
		高校卒業後すぐにカナダに留学しESLを就学後カレッジ進学を
		アルバータ州のグランドペリーにあるカレッジにてアドミニストレーション
		を2年間学ぶ。<br/>
		その後バンクーバに戻り旅行会社のバンクーバ支店で勤務。<br/>
		仕事の評価もあり、その後ILACさんにヘッドハンティングされ就職。<br/>
<br/>
		カナダ留学を決意した理由、留学前の英語力、カナダでの留学お仕事経験等
		体験談を中心にお話しさせて頂きます。
	</div>
	</font>
	</td>
	</tr>
</table>

<br /><br /><br /><br />


<table>
	<tr>
	<td>
		<img src="images/kouen4.jpg" Width="130px" hspace="30px" style="border: 1px dotted #555555;padding: 5px 5px 5px 5px;">
	</td>
	<td>
		<font size="2" color="#33cc33">
		<b>5月17日（木）15：00<br /></font>
		<font size="3">
		 オーストラリアでの経験を帰国後の仕事に生かすためには</b></font>
	<font size="1" color="#373737">
		　講師：VIVA　COLLEGE　田村　雪江 様<br/>

	<div style="line-height:1.5;">
		<HR size="1" color="#cccccc" style="border-style:dotted" width="650">
			皆さん、こんにちは。オーストラリア、ブリスベンにある語学学校Viva Collegeの田村雪江です。<br/>
			オーストラリアで勉強する利点と将来に必ず役立つスキルをテーマに、私の経験も交え、皆さんに直接お話をさせていただきます。
<br/><br/>
			<b>オーストラリアが就学に適している理由</b> 　Ø 質の良い教育 Ø 生活環境<br/>
			<b>オーストラリアで身につけられる知識＆スキル</b>
			　Ø 英語 Ø カスタマーサービススキル Ø ビジネススキル Ø 異文化理解 Ø 自信<br/>
	</div>
	</font>
	</td>
	</tr>
</table>

<br /><br /><br /><br />


<table>
	<tr>
	<td>
		<img src="images/kouen5.jpg"  Width="130px" hspace="30px" style="border: 1px dotted #555555;padding: 5px 5px 5px 5px;">
	</td>
	<td>
		<font size="2" color="#33cc33">
		<b>5月22日（火）12：00<br /></font>
		<font size="2">
		 海外へ行く前に語彙力をつけよう</font><font size="3">「英語が延びる単語カードの作り方」講座</b></font>
	<font size="1" color="#373737">
		　講師：INFORUM　Craft　JUN 様<br/>

	<div style="line-height:1.3;">
		<HR size="1" color="#cccccc" style="border-style:dotted" width="650">
		こんにちは。ゴールドコースト、Inforum (インフォーラム)のJunです。<br />
		留学、ワーキングホリデー中にみんなが感じることは、「語彙力が足りない！」「もっと日本でやっておけばよかった！」。<br />
		受験に使っていた単語カード、そこへちょっとプラスするだけで、英語が伸びる最強カードへ！<br />
		渡航前に500単語「覚える」じゃなく、「使える」ようにする単語カードの作り方を一緒に勉強しましょう。<br />
		その他、ゴールドコーストの事、Inforumの学校の事についてもっと知りたい方、是非遊びに来てください！	</font>
	</div>
	</td>
	</tr>
</table>


<br />
<br />
<br />

	<img src="images/03.gif" style="margin-top:36px; margin-left:-20px;" id="school">

<TABLE style="border: 2px dotted #a6e82c; margin-top:15px; margin-left:-20px;" cellpadding="10" width="900px">

	<tr>
		<TD  height="100px" width="120px">
	<center>
	<font size="1.5">最新の設備とカリキュラム <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
	<a href="browns.html" target="school"><img src="browns/browns_logo.jpg" height="40px"></a>
	</center>
		</TD>

		<TD height="100px" width="120px">
	<center>
	<font size="1.5">メルボルンの歴史ある語学学校 <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
	<a href="cic.html" target="school"><img src="cic/CIC_logo.gif" height="50px"></a>
	</center>
		</TD>

		<TD  height="100px" width="120px">
	<center>
	<font size="1.5">選択授業で自由に学べる <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
	<a href="ilsc.html" target="school"><img src="ilsc/ilsc_rogo.jpg" height="60px"></a>
	</center>
		</TD>

		<TD  height="100px" width="120px">
	<center>
	<font size="1.5">楽しみながら英語上達 <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font></small><br />
	<a href="inforum.html" target="school"><img src="inforum/inform_logo.jpg" height="60px"></a>
	</center>
		</TD>

		<TD  height="100px" width="120px">
	<center>
	<font size="1.5">大人気のバリスタコース <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
	<a href="selc.html" target="school"><img src="selc/selc_logo.jpg" height="60px"></a>
	</center>
		</TD>

	</tr>
		<tr>

		<TD  height="100px" width="120px">
	<center>
	<font size="1.5">短期間で英語を習得！ <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
	<a href="viva.html" target="school"><img src="viva/viva_logo.jpg" height="42px"></a>
	</center>

		<TD height="100px" width="120px">
	<center>
	<font size="1.5">英語の先生を目指そう <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
	<a href="ih_aus.html" target="school"><img src="ih_sy/ih_logo.jpg" height="40px"></a>
	</center>
		</TD>


		<TD height="100px" width="120px">
	<center>
	<font size="1.5">インターンシップで仕事経験 <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
	<a href="icqa.html" target="school"><img src="icqa/icqa_logo.jpg" height="70px"></a>
	</center>
		</TD>

			<TD height="100px" width="120px">
		<center>
		<font size="1.5">遊びも勉強も資格も！<img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
		<a href="ilac.html" target="school"><img src="ilac/ilac_rogo.jpg" height="55px"></a>
		</center>
			</TD>

		<TD height="100px" width="120px">
	<center>
	<font size="1.5">英語でキャリアアップ <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
	<a href="kgic.html" target="school"><img src="kgic/kgic_rogo.jpg" height="60px"></a>
	</center>
		</TD>
	<tr>
		<TD height="100px" width="120px">
	<center>
	<font size="1.5">安心のアットホームさ <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
	<a href="umc.html" target="school"><img src="umc/umc_logo.jpg" height="38px"></a>
	</center>
		</TD>

		<TD height="100px" width="120px">
	<center>
	<font size="1.5">接客英語を学ぶならここ <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
	<a href="ccel.html" target="school"><img src="ccel/ccel_logo.jpg" height="25px"></a>
	</center>
		</TD>

		<TD height="100px" width="120px">
	<center>
	<font size="1.5">英語を本気でモノにする <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
	<a href="pgic.html" target="school"><img src="pgic/pgic_logo.jpg" height="50px"></a>
	</center>
		</TD>

		<TD height="100px" width="120px">
	<center>
	<font size="1.5">落ち着いた環境で英語上達 <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
	<a href="ih_can.html" target="school"><img src="ih_van/ih_logo.jpg" height="40px"></a>
	</center>

		</TD>



		</tr>
<tr>
		<TD height="100px" width="120px">
	<center>
	<font size="1.5">NZの最高の環境で <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/New-Zealand.png"></font><br />
	<a href="nzlc.html" target="school"><img src="nzlc/nzlc_logo.jpg" height="50px"></a>
	</center>
		</TD>
		<TD height="100px" width="120px">
	<center>
	<font size="1.5">5カ国主要都市に点在する大規模校</font><br />
	<a href="embassy.html" target="school"><img src="embassy/embassy_logo.jpg" height="30px"></a>
	</center>
		</TD>

</tr>

</TABLE>

<br />

<table cellpadding="0" cellspacing="0">
  <tbody>
    <tr>
      <td width="5" height="5" background="images/hidariue.gif"></td>
      <td background="images/ue.gif"></td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td background="images/hidari.gif"></td>
      <td width="850" background="images/back.gif" style="padding: 5px 5px 5px 5px;">


<iframe src="top.html" width="850" height="500" frameborder="0" name="school" marginwidth="0" marginheight="0" hspace="0" vspace="0" onload="fitIfr();">お使いのブラウザはフレームに対応しておりません。</iframe>


</td>
      <td width="5" background="images/migiue.gif"></td>
    </tr>
    <tr>
      <td height="5" background="images/migiue.gif"></td>
      <td background="images/migiue.gif"></td>
      <td background="images/hidarisita.gif"></td>
    </tr>
  </tbody>
</table>

<br />
<div style="text-align:right;"><A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div><br />



	</div>


	</div>
  </div>
  </div>



	</div>
  </div>
  </div>
  </div>

<script type="text/javascript">
jQuery(function($) {
	jQuery(".open").click(function(){
		jQuery(this).parent().children(".det").slideToggle("slow");
		jQuery(this).slideToggle("hide");
	});
});
</script>


<? fncMenuFooter(); ?>


</body>
</html>