<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<?
	require_once '../include/menubar.php';
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
	jQuery('#semi_show').html('<div style="vertical-align:middle; text-align:center; margin:30px 0 30px 0; font-size:20pt;"><img src="/images/ajax-loader.gif">セミナーを探しています...</div>');
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
		<img src="images/ajaxwait.gif">
		&nbsp;予約処理中です。しばらくお待ちください。&nbsp;
		<img src="images/ajaxwait.gif">
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

	<div id="maincontent" style="margin-left:40px;">
	<div id="top-main" style="width:300px;margin-bottom:20px;">

<h2 class="sec-title">★春の留学・ワーキングホリデーフェア開催！！★</h2>

	<div  style="width:830px;line-height:1.3" ><Font Size="2">本年、オーストラリアとの協定から始まったワーキングホリデー制度が30周年を迎え、
		日本人がワーキングホリデーを使って生活できる国は11カ国まで増えました。
		そんな節目の年に、日本ワーキング・ホリデー協会では春の留学＆ワーキングホリデーフェアを開催します。
		皆様が留学＆ワーキングホリデーを考えるきっかけとして、また、より一層素晴らしい留学＆ワーキング
		ホリデーにする為に、是非この機会にフェアにご参加下さい！</font><br /></div></div>


		<div class="top-entry01" style="width:850px;">


<div id="hc1" class="haccordion">
<ul>
	<li>
		<div class="hpanel" style="width:500px">
		<img src="03.png" style="float:left; padding-right:8px;" />
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:500px">
		<img src="01.png" style="float:left; padding-right:8px;" />
	</li>

	<li>
		<div class="hpanel" style="width:500px">
		<img src="04.png" style="float:left; padding-right:8px;" />
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:500px">
		<img src="02.png" style="float:left; padding-right:8px;" />
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:500px">
		<img src="05.png" style="float:left; padding-right:8px;" />
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:600px">
		<img src="top2.png" style="float:left; padding-right:8px;" />
		</div>
	</li>

</ul>
</div>

<p style="clear:center; margin-left:60px;"><a href="javascript:haccordion.expandli('hc1', 0)">留学&ワーホリセミナー</a> | <a href="javascript:haccordion.expandli('hc1', 1)">語学学校セミナー</a> | <a href="javascript:haccordion.expandli('hc1', 2)">講演会セミナー</a> | <a href="javascript:haccordion.expandli('hc1', 3)">帰国者体験談</a> | <a href="javascript:haccordion.expandli('hc1', 4)">個別カウンセリング</a> | <a href="javascript:haccordion.expandli('hc1', 5)">春の留学＆ワーホリフェア</a> </p>

<br />


<h2 class="sec-title">★春の留学・ワーキングホリデーフェアを予約する！！★</h2>

<div class="shibori" id="shiborikomi" style="display:none;">
<form id="kensakuform">
	<div style="margin: 0 20px 10px 20px; padding: 5px 10px 10px 10px; border: 2px orange solid;">
		会場を選択する<br/>
		<label for="place-all"    >全て</label><input id="place-all"     type="checkbox" name="place-1" value="all" checked />
		<label for="place-tokyo"  >東京</label><input id="place-tokyo"   type="checkbox" name="place-2" value="tokyo" />
		<label for="place-osaka"  >大阪</label><input id="place-osaka"   type="checkbox" name="place-3" value="osaka" />
		<label for="place-sendai" >仙台</label><input id="place-sendai"  type="checkbox" name="place-4" value="sendai" />
		<label for="place-toyama" >富山</label><input id="place-toyama"  type="checkbox" name="place-4" value="toyama" />
		<label for="place-fukuoka">福岡</label><input id="place-fukuoka" type="checkbox" name="place-5" value="fukuoka" />
		<label for="place-okinawa">沖縄</label><input id="place-okinawa" type="checkbox" name="place-6" value="okinawa" />
	</div>
	<div style="margin: 0 20px 10px 20px; padding: 5px 10px 10px 10px; border: 2px orange solid;">
		興味のある国を選択する（複数選択可能）<br/>
		<label for="country-all">全て</label>			<input id="country-all" 	type="checkbox" name="country-1" value="all" checked />
		<label for="country-aus">オーストラリア</label>		<input id="country-aus" 	type="checkbox" name="country-2" value="オーストラリア" />
		<label for="country-nz" >ニュージーランド</label>	<input id="country-nz"  	type="checkbox" name="country-3" value="ニュージーランド" />
		<label for="country-can">カナダ</label>			<input id="country-can" 	type="checkbox" name="country-4" value="カナダ" />
		<label for="country-uk" >イギリス</label>		<input id="country-uk"  	type="checkbox" name="country-5" value="イギリス" />
		<label for="country-fra">フランス</label>		<input id="country-fra" 	type="checkbox" name="country-6" value="フランス" />
		<label for="country-other">その他の国</label>		<input id="country-other" 	type="checkbox" name="country-7" value="other" />
	</div>
	<div style="margin: 0 20px 10px 20px; padding: 5px 10px 10px 10px; border: 2px orange solid;">
		セミナーの内容を選択する（複数選択可能）<br/>
		<label for="know-all">全て</label>		<input id="know-all" 	type="checkbox" name="know-1" value="all" checked />
		<label for="know-first" >初心者向け</label>	<input id="know-first" 	type="checkbox" name="know-2" value="初心者" />
		<label for="know-ga">語学学校</label>		<input id="know-ga" 	type="checkbox" name="know-5" value="語学学校" />
		<label for="know-sanpo">講演</label>		<input id="know-sanpo" 	type="checkbox" name="know-3" value="講演" />
		<label for="know-sc" >体験談</label>		<input id="know-sc" 	type="checkbox" name="know-4" value="体験談" />
	</div>
</form>

<input type="button" value="検索" onclick="fncsemiser();">

</div>

<a name="seminarlist" id="seminarlist"></a>

<div style="margin:20px 0 0 0 ;" id="semi_show" >
<?
	require_once 'seminar_search.php';
?>
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



	</div>
  </div>
  </div>
  </div>


<? fncMenuFooter(); ?>


</body>
</html>