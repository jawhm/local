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
<title>日本ワーキング・ホリデー協会　秋の留学＆ワーキングホリデーフェア2012 -</title>
<link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon" />
<meta name="keywords" content="オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館," />
<meta name="description" content="オーストラリア・ニュージーランド・カナダを初めとしたワーキングホリデー協定国の最新のビザ取得方法や渡航情報などを発信しています。" />
<meta name="author" content="Japan Association for Working Holiday Makers" />
<meta name="copyright" content="Japan Association for Working Holiday Makers" />
<link rev="made" href="mailto:info@jawhm.or.jp" />
<link rel="Top" href="index.html" type="text/html" title="一般社団法人 日本ワーキング・ホリデー協会" />
<link rel="Author" href="mailto:info@jawhm.or.jp" title="E-mail address" />

<link href="../css/headhootg-nav.css" rel="stylesheet" type="text/css" />
<link href="../css/base.css" rel="stylesheet" type="text/css" />
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
background:#F63;
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
<div align="center">

<div id="hc1" class="haccordion">
<ul>
	<li>
		<div class="hpanel" style="width:660px">
		<A Href="#seminar"><img src="03.png" style="float:left; padding-right:8px;" /></a>
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:660px">
		<A Href="#school"><img src="01.png" style="float:left; padding-right:8px;" /></a>
        </div>
	</li>

	<li>
		<div class="hpanel" style="width:660px">
		<A Href="#kouen"><img src="04.png" style="float:left; padding-right:8px;" /></a>
		</div>
	</li>

	<li>
		<div class="hpanel" style="width:660px">
		<A Href="#taiken"><img src="02.png" style="float:left; padding-right:8px;" /></a>
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
<p style="clear:center; margin-left:80px;"><a href="javascript:haccordion.expandli('hc1', 0)">留学&ワーホリセミナー</a> | <a href="javascript:haccordion.expandli('hc1', 1)">語学学校セミナー</a> | <a href="javascript:haccordion.expandli('hc1', 2)">講演会セミナー</a> | <a href="javascript:haccordion.expandli('hc1', 3)">帰国者体験談</a> | <a href="javascript:haccordion.expandli('hc1', 4)">個別カウンセリング</a> | <a href="javascript:haccordion.expandli('hc1', 5)">秋の留学＆ワーホリフェア</a> </p>


<a name="seminar"></a>
<h3 class="aki-title">セミナースケジュール</h3> 


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


<div style="border: 2px dotted #cccccc; font-size:10pt; margin: 10px 30px 10px 10px; padding: 10px 20px 10px 20px;" >
	ワーキングホリデーって何？　どんなことが出来るの？　予算はどのくらいかかるの？<br/>
	帰国してからの就職先が心配...　　初めての海外だけどワーホリで大丈夫？<br/>
	聞きたい事や、心配な事もたくさんあると思います。何でも聞いてください。<br/>
	セミナーの参加者は８割以上の方が、お１人での参加です。お気軽にご参加ください。<br/>
	<br/>
	<b><big>会場を選んで下さい。</big></b>
	<A href="/2012autumnfair/?p=tokyo#seminar"><img src="images/tokyo.gif" /></A>&nbsp;
	<A href="/2012autumnfair/?p=osaka#seminar"><img src="images/osaka.gif" /></A>&nbsp;
	<A href="/2012autumnfair/?p=fukuoka#seminar"><img src="images/fukuoka.gif" /></A><br />
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
		}
	}else{
		$region = @$_GET['p'];
	}

	if ( $region == 'tokyo' || $region == 'TOKYO')	{
		echo '<h3 id="tokyo"></h3>';
		calendar_display('tokyo', 2012, 10);
		calendar_display('tokyo', 2012, 11);
	}
	if ( $region == 'osaka' || $region == 'OSAKA')	{
		echo '<h3 id="osaka"></h3>';
		calendar_display('osaka', 2012, 10);
		calendar_display('osaka', 2012, 11);
	}
	if ( $region == 'fukuoka' || $region == 'FUKUOKA')	{
		echo '<h3 id="fukuoka"></h3>';
		calendar_display('fukuoka', 2012, 10);
		calendar_display('fukuoka', 2012, 11);
	}

?>

<div style="text-align:right;"><A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div><br />

<br />

<a name="school"></a>
<img src="images/school.png" style="margin-left:-5px;">

<style>
.waku	{
	background: white;
	padding: 4px 4px 4px 4px;
}
.naka	{
	background: white;

}

</style>

<TABLE id="logo-list" style="margin-left:5px;">

	<tr>
		<TD>
	<div class="waku">
	<div class="naka">
		<a href="browns.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<center>
		<font size="1.5">最新の設備とカリキュラム <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="browns/browns_logo.jpg" height="40px">
		</center></a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="cic.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<center>
		<font size="1.5">メルボルンの歴史ある語学学校 <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="cic/CIC_logo.gif" height="50px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="ilsc.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<center>
		<font size="1.5">選択授業で自由に学べる <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="ilsc/ilsc_rogo.jpg" height="60px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="inforum.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<center>
		<font size="1.5">楽しみながら英語上達 <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font></small><br />
		<img src="inforum/inform_logo.jpg" height="60px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="selc.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<center>
		<font size="1.5">大人気のバリスタコース <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="selc/selc_logo.jpg" height="60px">
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
		<a href="viva.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">短期間で英語を習得！ <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="viva/viva_logo.jpg" height="42px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="ih_aus.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">英語の先生を目指そう <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="ih_sy/ih_logo.jpg" height="40px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="icqa.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">インターンシップで仕事経験 <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="icqa/icqa_logo.jpg" height="70px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="impact.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">充実サポートと豊富なコース<img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="impact/impact_logo.jpg" height="56px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="navitas.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">各都市にキャンパス！<img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="navitas/navitas_logo.jpg" height="45px">
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
		<a href="holmes.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">日本人率低めな英語環境 <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="holmes/holmes_logo.jpg" height="75px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="ilac.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">遊びも勉強も資格も！<img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
		<img src="ilac/ilac_rogo.jpg" height="55px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="kgic.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">英語でキャリアアップ <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
		<img src="kgic/kgic_rogo.jpg" height="60px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="umc.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">安心のアットホームさ <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
		<img src="umc/umc_logo.jpg" height="38px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="ccel.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">接客英語を学ぶならここ <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
		<img src="ccel/ccel_logo.jpg" height="25px">
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
		<a href="pgic.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">英語を本気でモノにする <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
		<img src="pgic/pgic_logo.jpg" height="50px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="ih_can.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">落ち着いた環境で英語上達 <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
		<img src="ih_van/ih_logo.jpg" height="40px">
		</center>
		</a>
	</div>
	</div>
		</TD>


		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="nzlc.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">NZの最高の環境で <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/New-Zealand.png"></font><br />
		<img src="nzlc/nzlc_logo.jpg" height="50px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="embassy.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">5カ国主要都市に点在する大規模校</font><br />
		<img src="embassy/embassy_logo.jpg" height="30px">
		</center>
		</a>
	</div>
	</div>
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
<div style="text-align:right;"><A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div>



<br />

	<h3 class="aki-title" id="kouen">講演セミナー</h3> 
    <br />
    <center>
        <table width="800" background="images/back.jpg" style="background-repeat:repeat" cellpadding="25">
            <tr>
                <td>
                    <A Href="#1106k"><font size=3> <font color=#ff6600>■</font>　<small>11月6日 (火) 11:00～</small>　<b><font color="#ff6600">カナダでスグに使える英語の体験レッスン</font></b>　<font size=2>（講師：UMC　財田　歩弥 様）</font></a><br />
                    <A Href="#1117k"><font size=3><font color=#ff6600>■</font>　<small>11月17日（金）14：00～</small>　<b><font color="#ff6600">体験談から学ぶ！就職力・転職力UP留学セミナー</font></b>　<font size=2>（講師：PGIC　佐々木　健志 様）</font></a><br />
                </td>
            </tr>
        </table>
          <table width="850"><tr><td><div style="text-align:right;"><A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div></td></tr></table>

    </center>

    <br />
    <br />
    <br />

	<center>
    <table id="1106k"  background="images/back.jpg" style="background-repeat:repeat" cellpadding="15">
        <tr>
            <td>
                <img src="images/kouen2.png"   Width="120px" hspace="20px">
            </td>
            <td>
                <font size="2" color="#ff6600"><b>11月6日 (火) 11:00～<br /></font>
                <font size="3">カナダでスグに使える英語の体験レッスン　</b><font size="1">講師：UMC(カナダ語学学校) 財田　歩弥 様</font></font>
       
                <br/>
        
                <div style="line-height:1.5;">
                    <HR size="1" color="brown" style="border-style:dotted" width="600">
 <br/>
			<p>
			中・高英語教員資格を持つカナダ語学学校日本人スタッフによる“カナダでスグに使える英語”の体験レッスン <br/>
 <br/>
			カナダトロントの語学学校で勤務している中・高英語教員資格を持つ日本人スタッフを招いて、 <br/>
			日本の英語教育とカナダの語学学校での英語教育の違いを模擬レッスンを通して体験できるイベントです。 <br/>
 <br/>
			日本にいる間に具体的なESLのカリキュラム内容を知ることで、 <br/>
			海外の語学学校に入ってからのビジョンを正確に描けることはもちろん、 <br/>
			日本にいる間にどのような英語学習をしておけば良いかを知るきっかけとなること間違いナシ！ <br/>
			留学前のモチベーションUPに繋がるセミナーです。    <br/>
			</p>
        		</div>
            	<br />
            	<div style="text-align:right;">
                	<b><font size="2"><font color="#ff6600">このセミナーを予約する >&gt;</font></b></font>
                    <font size ="2">
                        <input align='right' type="button" name="test" value="東京会場" onclick="fnc_yoyaku(this)" uid="1912" title="【東京】11月6日 (火) 11:00 カナダでスグに使える英語の体験レッスン"> 
                    </font>
            	</div>
            </td>
        </tr>
    </table>
	</center>
    <table width="850"><tr><td><div style="text-align:right;"><A Href="#kouen"><p>▲　講演会一覧</p></A></div></td></tr></table>

    <br />

	<center>
    <table id="1117k"  background="images/back.jpg" style="background-repeat:repeat" cellpadding="15">
        <tr>
            <td>
                <img src="images/kouen1.png"   Width="120px" hspace="20px">
            </td>
            <td>
                <font size="2" color="#ff6600"><b>11月17日（金）14：00～<br /></font>
                <font size="3">体験談から学ぶ！就職力・転職力UP留学セミナー </b><font size="1">講師：PGIC(カナダ語学学校)　佐々木　健志　様</font></font>
       
                <br/>
        
                <div style="line-height:1.5;">
                    <HR size="1" color="brown" style="border-style:dotted" width="600">
 <br/>
			<p>
			カナダ留学した帰国者の体験談が聞けるセミナーです。 <br/>
			留学前は英語が全くわからずTOEIC点数も300点以下からのスタートでしたが <br/>
			1年間英語漬けで努力しTOEIC900点以上リスニングほぼ満点まで語学力を伸ばし
			外資系企業に就職が決まりました。 <br/>
			ご自身の体験を含めながら英語上達のコツを聞く事が出来ます。 <br/>
			使える英語を身に付けたい方は特にご参加下さい。 <br/>
 <br/>

			-企業が求める人材とは- <br/>
 <br/>
			不況の今こそ、自分磨きの絶好のチャンス。留学後の就職・転職活動は留学前からすでに始まっています。 <br/>
			積極性やコミュニケーションスキル、問題解決能力など、企業が社員に求める能力には、 <br/>
			「留学・ワーキングホリデー」を通して得られるものが多くあります。 <br/>

 <br/>
			このセミナーでは、留学経験を就職や転職に活かした先輩達の実例をもとに、 <br/>
			効果的な留学をするためのポイントを伝授します。さらに、体験者の留学パターンと帰国後の仕事についてもお伝えします。 <br/>
			</p>

           		</div>
            	<br />
            	<div style="text-align:right;">
                	<b><font size="2"><font color="#ff6600">このセミナーを予約する >&gt;</font></font></b>
                    <font size ="2">
                        <input align='right' type="button" name="test" value="東京会場" onclick="fnc_yoyaku(this)" uid="1972" title="【東京】11月17日（金）14：00 就職力・転職力UP留学セミナー"> 
                    </font>
            	</div>
            </td>
        </tr>
    </table>
	</center>
    <table width="850"><tr><td><div style="text-align:right;"><A Href="#kouen"><p>▲　講演会一覧</p></A></div></td></tr></table>

 <br />
 <br />
    <br />
   
	<h3 class="aki-title" id="taiken">帰国者体験談セミナースケジュール</h3> 
    <br />
    <center>

<style>
.waku	{
	background: white;
	padding: 4px 4px 4px 4px;
}
.naka	{
	background: white;

}

</style>

<TABLE id="taiken-list" stye="margin-left:30px;">


	<tr>
	<td colspan="3" height="50px">
	<font size="3"><b>　<font color="#F63"><u>◆ゲストによる帰国者体験談</u></font></b></font>
	</td>
	</tr>


<tr>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="#1004" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="2"><b>10.04.Thu 16:15</b> <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="images/kikokusya/1004.jpg" height="130px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<!--<div id="div_cic" class="waku">
	<div class="naka">
		<a href="ilac.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">遊びも勉強も資格も！<img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
		<img src="ilac/ilac_rogo.jpg" height="55px">
		</center>
		</a>
	</div>
	</div>-->
		</TD>

		<TD>
	<!--<div id="div_cic" class="waku">
	<div class="naka">
		<a href="kgic.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">英語でキャリアアップ <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"></font><br />
		<img src="kgic/kgic_rogo.jpg" height="60px">
		</center>
		</a>
	</div>
	</div>-->
		</TD>

	</tr>



	<tr>
	<td colspan="3" height="50px">
	<font size="3"><b>　<font color="#593AB3"><u>◆カウンセラーによる帰国者体験談</u></font></b></font>
	</td>
	</tr>

	<tr>
		<TD>
	<div class="waku">
	<div class="naka">
		<a href="#1016" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<center>
		<font size="2"><b>10.16.Sun 16：15</b> <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="images/kikokusya/1016.jpg" height="130px">
		</center></a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="#1017"  onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<center>
		<font size="2"><b>10.17.Wed 17:00 & 10.29.Mon 16:00</b>    <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/France.png"></font><br />
		<img src="images/kikokusya/1017.jpg" height="130px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="#1023" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;" >
		<center>
		<font size="2"><b>10.23.Tue 16：15</b> <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="images/kikokusya/1023.jpg" height="130px">
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
		<a href="#1024"  onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="2"><b>10.24.Wed 16:15</b> <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="images/kikokusya/1024.jpg" height="130px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<div id="div_cic" class="waku">
	<div class="naka">
		<a href="#1025" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="2"><b>10.25.Thu 16:15</b> <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Canada.png"> <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="images/kikokusya/1025.jpg" height="130px">
		</center>
		</a>
	</div>
	</div>
		</TD>

		<TD>
	<!--<div id="div_cic" class="waku">
	<div class="naka">
		<a href="icqa.html" target="school" onmouseover="jQuery(this).parent().parent().css('background','orange');" onmouseout="jQuery(this).parent().parent().css('background','white');" style="text-decoration:none;">
		<center>
		<font size="1.5">インターンシップで仕事経験 <img width="20" src="http://www.jawhm.or.jp/event/getlist/img/Australia.png"></font><br />
		<img src="icqa/icqa_logo.jpg" height="70px">
		</center>
		</a>
	</div>
	</div>-->
		</TD>

</tr>


</TABLE>

    </center>


    <br />
    <br />
    <br />

<!-- Tatsuya 10月4日(木) -->


    <table id="1004">
        <tr>
        <td>
            <img src="images/kikokusya/1004.jpg" >
        </td>
        <td>
<table cellspacing="0" cellpadding="0" cellspacing="0">
<tr><td align="right">
<table width="1" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="2" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="4" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="8" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="10" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="12" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="12" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="10" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="8" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="4" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="2" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="1" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
</td><td align="right">
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="21" height="300" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
</td><td bgcolor="#ffe1a5" align="left">

	<div style="line-height:1.8;">
            <font size="2.5"><b><font color="#ff7507">10月4日(木) 16:15～</font><br />
		<font size="3"><b>オーストラリア 帰国者体験談</b>　<img src="images/aus.gif"></font></b>　（Sugawara Tatsuya）
		<HR size="1" color="#ff9a00" style="border-style:dotted" width="630">
	</div>
        <br />

        <div style="line-height:1.8;">
		<p>
		都内の私立大学に在学中の大学３年生です。<br />
		大学在学中に海外留学をしていたいと思っていて、昨年度１年間大学を休学し、シドニーに学生ビザで１年間滞在。<br />
<br />
		学生でありながらも、ローカルのレストランで約半年の間アルバイトをし、３週間のラウンドまでしてきました。<br />
<br />
		学生ならではの悩み、失敗談、英語がうまくなるコツ、また日本人が海外に出て学ばなくてはならないことなどを<br />
		お話させていただけたらと思っています。<br />
		</p>

        <div style="text-align:right;"><b><font size="2">このセミナーを予約する >></font></b><font size ="2">
        　<input align='right' type="button" name="test" value="10月4日(木) 16:15" onclick="fnc_yoyaku(this)" uid="2101" title="【TOKYO】10月4日(木) 16:15 オーストラリア帰国者体験談"> 
        </div>

	</div>

</td><td align="left">
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="21" height="300" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
</td></tr>
</table>
        </td>
        </tr>
    </table>
    <div style="text-align:right;"><A Href="#taiken"><font size=1>▲ 体験談一覧</font></A>　　<A Href="#top"><font size=1>▲ フェアトップにもどる</font></A></div><br />

<br />
    <HR size="1" color="#cccccc" style="border-style:dotted" id="0506">
<br/>
<br/>






<!-- Naho 10月16日(火) -->


    <table id="1016">
        <tr>
        <td>
            <img src="images/kikokusya/1016.jpg" >
        </td>
        <td>
<table cellspacing="0" cellpadding="0" cellspacing="0">
<tr><td align="right">
<table width="1" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="2" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="4" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="8" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="10" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="12" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="12" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="10" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="8" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="4" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="2" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="1" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
</td><td align="right">
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="21" height="400" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
</td><td bgcolor="#e6ccff" align="left">

	<div style="line-height:1.8;">
            <font size="2.5"><b><font color="#593AB3">10月16日(火) 16:15～</font><br />
		<font size="3"><b>オーストラリア 帰国者体験談</b>　<img src="images/aus.gif"></font></b>　（Matsumura Nahoko）
		<HR size="1" color="#593AB3" style="border-style:dotted" width="630">
	</div>
        <br />

        <div style="line-height:1.8;">
		<p>
		初めての海外は高校1年の時メルボルンに3週間ホームステイでした。<br />
		海外旅行が好きで行った事がある国は、<br />
		オーストラリア・アメリカ・カナダ・韓国・バリ・北京・イタリア・ベトナム・台湾・ハワイ・ニュージーランド。<br />
<br />
		大学卒業後就職をした会社が海外営業部という部署になり<br />
		英語が飛び交う環境の中で使える英語力がない無力感と英語を使えるようになりたいと思い<br />
		5年働いた会社を辞めオーストラリアのワーキングホリデーで2年間過ごしました。<br />
		体験としては語学学校、ラウンド、ファーム、ダイビング、仕事経験。<br />
<br />
		海外に行くと決めた方、行くか行かないか悩んでいる方、興味はあるが、心配と不安が多い方へ<br />
		行ったからこそ、見れた物、感じた事、出会えた仲間、<br />
		トラブルをどう対処したか、初めて体験したホームシック等のお話しも踏まえながら、<br />
		伝えたいメッセージも含めてお話しさせて頂きます。<br />
<br />
		体験談セミナーで皆様にお会い出来るのを楽しみにしております。<br />
		</p>

        <div style="text-align:right;"><b><font size="2">このセミナーを予約する >></font></b><font size ="2">
        　<input align='right' type="button" name="test" value="10月16日(火) 16:15" onclick="fnc_yoyaku(this)" uid="2105" title="【TOKYO】10月16日(火) 16:15 オーストラリア帰国者体験談"> 
        </div>

	</div>

</td><td align="left">
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="21" height="400" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
</td></tr>
</table>
        </td>
        </tr>
    </table>
    <div style="text-align:right;"><A Href="#taiken"><font size=1>▲ 体験談一覧</font></A>　　<A Href="#top"><font size=1>▲ フェアトップにもどる</font></A></div><br />


<!-- Ami 10月17日(水)17時～　10月29日(月)16時～ -->


    <table id="1017">
        <tr>
        <td>
            <img src="images/kikokusya/1017.jpg" >
        </td>
        <td>
<table cellspacing="0" cellpadding="0" cellspacing="0">
<tr><td align="right">
<table width="1" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="2" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="4" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="8" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="10" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="12" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="12" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="10" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="8" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="4" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="2" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="1" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
</td><td align="right">
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="21" height="620" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
</td><td bgcolor="#ffe1a5" align="left">

	<div style="line-height:2.2;">
            <font size="2.5"><b>第１回：<font color="#ff7507">10月17日(水)17：00～</font>　第２回：<font color="#ff7507">10月29日(月)16：00～　</font><br />
		<font size="3"><b>フランス 帰国者体験談</b>　<img src="images/fra.gif"></font></b>　（Komagine Ami）
		<HR size="1" color="#ff9a00" style="border-style:dotted" width="630">
	</div>
        <br />

        <div style="line-height:1.8;">
		<p>
		“aile”(エル)<br />
<br />
		フランス語で「彼女」は“elle”(エル)<br />
<br />
		「翼」は“aile”(エル)<br />
<br />
		女は確かに deux L (ドゥーズエル)、<br />
<br />
		つまり２つの翼をもって韻を踏んでさらにもうひとつの“エル”になる。　<br />
<br />
		　***
<br />
		一所懸命、自分の名前にエルを探してみたけど見つからなかった私の口癖が、<br />
		”いつかフランスに行く！”<br />
<br />
		実際に行くことが決まった時、友人は「夢を叶えに行くんだね」と応援してくれました。<br />
<br />
		最初は憧れから入ったフランスへの渡航希望でしたが、、<br />
		関連する好きなモノが増えるに連れて”目標”に変わっていったのです。<br />
<br />
		大事なことは口に出す事<br />
		そして憧れを目標に昇華することだと思います。<br />
<br />
		フランスに興味のある方、休学をして留学を考えている方<br />
<br />
		などなど、私の経験が役に立てば幸いです
    		</p>
<br />
        <div style="text-align:right;"><b><font size="2">このセミナーを予約する >></font></b><font size ="2">
        　<input align='right' type="button" name="test" value="10月17日(水)17：00" onclick="fnc_yoyaku(this)" uid="2030" title="【TOKYO】10月17日(水)17：00 フランス帰国者体験談"> 
	　<input align='right' type="button" name="test" value="10月29日(月)16：00" onclick="fnc_yoyaku(this)" uid="2031" title="【TOKYO】10月29日(月)16：00 フランス帰国者体験談"> 

        </div>

	</div>

</td><td align="left">
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="21" height="620" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
</td></tr>
</table>
        </td>
        </tr>
    </table>
    <div style="text-align:right;"><A Href="#taiken"><font size=1>▲ 体験談一覧</font></A>　　<A Href="#top"><font size=1>▲ フェアトップにもどる</font></A></div><br />

<!-- Sabu 10月23日(火) -->


    <table id="1023">
        <tr>
        <td>
            <img src="images/kikokusya/1023.jpg" >
        </td>
        <td>
<table cellspacing="0" cellpadding="0" cellspacing="0">
<tr><td align="right">
<table width="1" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="2" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="4" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="8" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="10" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="12" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="12" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="10" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="8" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="4" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="2" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="1" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
</td><td align="right">
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="21" height="350" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
</td><td bgcolor="#e6ccff" align="left">

	<div style="line-height:1.8;">
            <font size="2.5"><b><font color="#593AB3">10月23日(火) 16:15～</font><br />
		<font size="3"><b>オーストラリア 帰国者体験談</b>　<img src="images/aus.gif"></font></b>　（Onaga Kousaburou）
		<HR size="1" color="#593AB3" style="border-style:dotted" width="630">
	</div>
        <br />

        <div style="line-height:1.8;">
		<p>
		初一人旅、初海外、すべてが初めての体験。<br />
		１６歳の時に、海外に行き、日本では経験できない事をたくさんしました。<br />
<br />
		英語がまったくできない私が、半年後には現地のハイスクールに!!!<br />
		英語はできなくてもいいんです！渡航してから学びましょう！<br />
<br />
		当日は、英語の伸ばし方や、私が経験した事、ホームステイの事に関して、お話させて頂きます!!<br />
<br />
		また、学生ビザとワーキングホリデービザで悩んでいる方！<br />
		両方ともに経験した、私からいいお話がが出来たらと思います!!<br />
		当日、みなさまと楽しい時間が過ごせるのを楽しみにしております！<br />
		</p>

        <div style="text-align:right;"><b><font size="2">このセミナーを予約する >></font></b><font size ="2">
        　<input align='right' type="button" name="test" value="10月23日(火) 16:15" onclick="fnc_yoyaku(this)" uid="2106" title="【TOKYO】10月23日(火) 16:15 オーストラリア帰国者体験談"> 
        </div>

	</div>

</td><td align="left">
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="21" height="350" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
</td></tr>
</table>
        </td>
        </tr>
    </table>
    <div style="text-align:right;"><A Href="#taiken"><font size=1>▲ 体験談一覧</font></A>　　<A Href="#top"><font size=1>▲ フェアトップにもどる</font></A></div><br />




<!-- Saori 10月24日(水) -->


    <table id="1024">
        <tr>
        <td>
            <img src="images/kikokusya/1024.jpg" >
        </td>
        <td>
<table cellspacing="0" cellpadding="0" cellspacing="0">
<tr><td align="right">
<table width="1" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="2" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="4" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="8" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="10" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="12" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="12" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="10" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="8" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="4" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="2" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="1" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
</td><td align="right">
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="21" height="450" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
</td><td bgcolor="#ffe1a5" align="left">
	<div style="line-height:1.8;">

            <font size="2.5"><b><font color="#ff7507">10月24日(水)16:15～</font><br />
		<font size="3"><b>オーストラリア 帰国者体験談</b>　<img src="images/aus.gif"></font></b>　（Mizuguchi Saori）
		<HR size="1" color="#ff9a00" style="border-style:dotted" width="630">
	</div>
        <br />

        <div style="line-height:1.8;">
		<p>
		初めてオーストラリアを訪れたのは高校1年生の時。<br />
		ブリスベンが私にとって初めてのオーストラリアでした。<br />
<br />
		そして、いつか必ず海外で勉強する！という目標を抱いたのもこの頃です。<br />
		その後も何度か旅行で訪れ、ケアンズからメルボルンまで、東側の主要都市は訪れています。<br />
<br />
		そして海外留学の夢を叶えることなく学校を卒業してしまいましたが、ついに
		「その時」が来ました。<br />
		18歳の頃に「ワーホリ」という言葉を初めて知ってから数年がたち…<br />
		念願のオーストラリアでのワーキングホリデーを実現させました。<br />
<br />
		帰国後の就職を考え、資格取得を目指される方が多いですが、私もその一人でした。<br />
		語学学校で、日本ではあまり馴染みのない「IELTS（アイエルツ）」の準備コースを受講し、<br />
		最終的に受験してから帰国しました。<br />
<br />
		オーストラリアのこと、海外での生活はもちろん、どんな資格を取得したら良いのか、<br />
		他のコースと資格準備コースの違い等もお話いたします。<br />
		当日お会い出来ることを楽しみにしております。<br />
		</P>

        <div style="text-align:right;"><b><font size="2">このセミナーを予約する >></font></b><font size ="2">
        　<input align='right' type="button" name="test" value="10月24日(水) 16:15" onclick="fnc_yoyaku(this)" uid="2107" title="【TOKYO】10月24日(水) 16:15 オーストラリア帰国者体験談"> 
        </div>

	</div>

</td><td align="left">
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="21" height="450" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#ffe1a5"><tr><td></td></tr></table>
</td></tr>
</table>
        </td>
        </tr>
    </table>
    <div style="text-align:right;"><A Href="#taiken"><font size=1>▲ 体験談一覧</font></A>　　<A Href="#top"><font size=1>▲ フェアトップにもどる</font></A></div><br />





<!-- Takuya 1025 -->

    <table id="1025">
        <tr>
        <td>
            <img src="images/kikokusya/1025.jpg" >
        </td>
        <td>
<table cellspacing="0" cellpadding="0" cellspacing="0">
<tr><td align="right">
<table width="1" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="2" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="4" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="8" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="10" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="12" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="12" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="10" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="8" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="4" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="2" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="1" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
</td><td align="right">
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="21" height="300" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
</td><td bgcolor="#e6ccff" align="left">

<div style="line-height:1.8;">
            <font size="2.5"><b><font color="#593AB3">10月25日(木) 16:15～</font><br />
		<font size="3"><b>カナダ・オーストラリア 帰国者体験談</b>　<img src="images/can.gif"> <img src="images/aus.gif">　</font></b>　（Nagashima Takuya）
		<HR size="1" color="#593AB3" style="border-style:dotted" width="630">
	</div>
    
        <div style="line-height:1.8;">
	<p>
<br />	
	日本ではミュージシャンとして活動し、まったく英語が出来ないままカナダ・トロントにワーキングホリデーで渡航。<br />
	学校で英語を学びながらメキシカン料理とテキーラのショットバーで仕事をしてカナダ生活を１年間満喫する。<br />
<br />
	オーストラリアではセカンドワーキングホリデービザを取得のためにファームで<br />
	スーパーバイザーをして通訳や仕事の割り振りなどの仕事も経験。<br />
	オーストラリアには約１年半滞在して、途中にニュージランドを車で一周もして2010年に帰国。<br />
<br />
	いろいろな国の経験や英語がまったく話せなかった時の失敗談、
	海外での英語の伸ばし方などを話せればと思います。<br />
<br />
	</p>

        <div style="text-align:right;"><b><font size="2">このセミナーを予約する >></font></b><font size ="2">
        <input align='right' type="button" name="test" value="10月25日（木）16：15" onclick="fnc_yoyaku(this)" uid="2108" title="【TOKYO】10月25日(木) 16：15 カナダ・オーストラリア帰国者体験談"></font></div>
        </div>
	</div>

</td><td align="left">
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="21" height="300" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="20" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="19" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="18" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="17" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="16" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="15" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="14" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="13" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="11" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="9" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
<table width="6" height="1" cellspacing="0" cellpadding="0" bgcolor="#e6ccff"><tr><td></td></tr></table>
</td></tr>
</table>
        </font>
        </td>
        </tr>
    </table>
    <div style="text-align:right;"><A Href="#taiken"><font size=1>▲ 体験談一覧</font></A>　　<A Href="#top"><font size=1>▲ フェアトップにもどる</font></A></div><br />




<!-- ここまで帰国者体験談 -->



    <HR size="1" color="#cccccc" style="border-style:dotted" id="0506">
    <br />
    <table>
        <tr>
        <td>
            <img src="images/taikendan_2.jpg">
        </td>
        <td>
    <br />
    
            <font size="2.5"><b>第１回：<font color="#33cc33">5月6日（日）15：00</font>　第２回：<font color="#33cc33">5月13日（日）15：00　</font><br />
            <div style="line-height:1.8;">
            <font size="3"><b>オーストラリア帰国者体験談</b>　<img src="images/aus.gif"></font></font></b>　（岡部　なほ）


        <div style="line-height:1.8;">
            <HR size="1" color="#cccccc" style="border-style:dotted" width="650">
            <font size="2">
            
            大学を1年休学しオーストラリアへワーキングホリデーに行ってきました。<br />
            シドニーのボンダイジャンクションの学校だったので、週に何度もバーベキューをビーチでしたり<br />
            学校の仲間と飲みに行ったり楽しくて学校を卒業するのがさみしかったです。<br />
    <br />
            その後児童英語の資格を取りましたが、想像以上にハードでした。
            朝８時に学校へ行き、帰るころには外は真っ暗。<br />
            家に帰ってからも夜ごはん食べながらレッスンプランを考え、
            夜中までフラットメイトを巻き込んで授業の練習。<br />
            みんなが寝静まったあともリビングで１人で次の日の準備。<br />
            その中での幼稚園研修、小学校研修げっそりでしたが、この生活が終わった後、<br />
            今まで経験したことのない達成感でいっぱいになり
            頑張って良かったね、ってクラスメ―トのみんなと号泣しました。<br />
            この辛かった日々を一緒に乗り切った仲間は、本当に一生物です。
    <br /><br />
            ファーム経験、バックパック経験もあります。<br />
            そんな体験談を聞きにお越しください。写真もお見せします。	</div></font>
        </div>
        <br />
        <div style="text-align:right;"><b><font size="2">このセミナーを予約する >></font></b><font size ="2">
        　<input align='right' type="button" name="test" value="5月6日（日）" onclick="fnc_yoyaku(this)" uid="1353" title="【TOKYO】5月6日（日）15：00 オーストラリア帰国者体験談"> 
        <input align='right' type="button" name="test" value="5月13日（日）" onclick="fnc_yoyaku(this)" uid="1357" title="【TOKYO】5月13日（日）15：00 オーストラリア帰国者体験談"></font></div>
    <br />
    
        </div>
        </td>
        </tr>
    </table>
    <br />

    <div style="text-align:right;"><A Href="#taiken"><font size=2>▲　体験談一覧</font></A>　　<A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div><br />

    <HR size="1" color="#cccccc" style="border-style:dotted" id="0512">
    <br />
    <table>
        <tr>
        <td>
            <img src="images/taikendan_3.jpg" >
        </td>
        <td>
    <br />
            <font size="2.5"><b>第１回：<font color="#33cc33">5月12日（土）15：00</font>　第２回：<font color="#33cc33">5月14日（月）16：00　</font><br />
            <div style="line-height:1.8;">
            <font size="3"><b>オーストラリア帰国者体験談</b>　<img src="images/aus.gif"></font></font></b>　（東京経済大学2年生　平川　大樹）
        <div style="line-height:1.8;">
            <font size="2">
    
            <HR size="1" color="#cccccc" style="border-style:dotted" width="650">
                去年一年大学を休学してオーストラリア（シドニーとブリスベン）に一年学生ビザで英語を勉強しました。<br />
                1年でTOEIC300点以上伸びました。<br />
    
                去年一年はとても濃い一年で振り返りきれないくらい思い出がありますほんとうに留学して良かったと思います。<br />
                これは留学した人じゃないと分からない感覚だと思います。<br />
    
    <br />			一つ言えることは一度日本を出てみてください。伸びるのは英語だけではありません！！人としても成長出来ると思います。<br />
    <br />
                例えば自分はこの間東南アジアに一人旅に行って来ましたが、留学する前の自分だったら<br />
                絶対にこんな事出来ないだろうし、したいとも思わなかったと思います。<br />
    <br />
                ほんとうにたくさんの事を経験した一年でしたし、たくさんの人に出会った一年でした。<br />
                留学しようか迷っている方、行くと決めた方体験談を聞きにお越しください。<br />
            </font>
    </div>
        </div>
        <br />
        <div style="text-align:right;"><b><font size="2">このセミナーを予約する >></font></b><font size ="2">
        　<input align='right' type="button" name="test" value="5月12日（土）" onclick="fnc_yoyaku(this)" uid="1356" title="【TOKYO】5月12日（土）15：00　オーストラリア帰国者体験談"> 
        <input align='right' type="button" name="test" value="5月14日（月）" onclick="fnc_yoyaku(this)" uid="1359" title="【TOKYO】5月14日（月）16：00 オーストラリア帰国者体験談"></font></div>
    <br />
    
        </div>
        </td>
        </tr>
    </table>

    <br />

    <div style="text-align:right;"><A Href="#taiken"><font size=2>▲　体験談一覧</font></A>　　<A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div><br />
    
    
            <HR size="1" color="#cccccc" style="border-style:dotted" id="0514">
    <br />
    <table>
        <tr>
        <td>
            <img src="images/taikendan_5.jpg">
        </td>
        <td>
    <br />
    
            <font size="2.5"><b>第１回：<font color="#33cc33">5月14日（月）16：00</font></font><br />
            <div style="line-height:1.8;">
            <font size="3"><b>オーストラリア帰国者体験談</b>　<img src="images/aus.gif"></font></font></b>　（高野　陽一）
    
    
    
        <div style="line-height:1.8;">
            <HR size="1" color="#cccccc" style="border-style:dotted" width="650">
            <font size="2">
                大学一年時の冬休みに植林のボランティアで一カ月オーストラリアに行きました。<br />
                英語力が足りないことを実感し、大学二年が終わってから休学をして
                一年間オーストラリアへ留学してきました。<br />
    
                語学学校で4カ月みっちり勉強して英語力がつきました。<br />
                ワーキングホリデーで行ったため、アジア人が居ないダーウィンで
                2カ月ファームや日雇いの仕事をしたりしました。<br />
                学校終了後はとにかく会話がしたかったためメルボルンやシドニーのバックパッカーを回りました。<br />
    
                よくバーに行ってたので日本人（多くは25～30歳）の友達も多く、<br />
                いろいろと聞いているので興味ある方は体験談を聞きにお越しください。	<br />	</font>
    
        </div>
        </div>
        <br />
        <div style="text-align:right;"><b><font size="2">このセミナーを予約する >></font></b><font size ="2">
        　<input align='right' type="button" name="test" value="5月14日（月）" onclick="fnc_yoyaku(this)" uid="1359" title="【TOKYO】5月14日（月）16：00 オーストラリア帰国者体験談"> 
    
        </div>
        </td>
        </tr>
    </table>
    <br /><br />

    <div style="text-align:right;"><A Href="#taiken"><font size=2>▲　体験談一覧</font></A>　　<A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div><br />

    <HR size="1" color="#cccccc" style="border-style:dotted"id="0516">
    <br />
    <table>
        <tr>
            <td>
                <img src="images/taikendan_4.jpg" >
            </td>
            <td>
                    <br />
                    <font size="2.5"><b>第１回：<font color="#33cc33">5月16日（水）17：00</font>　</font><br />
                    <div style="line-height:1.8;">
                    <font size="3"><b>カナダ・オーストラリア帰国者体験談</b>　<img src="images/can.gif"> <img src="images/aus.gif"></font></b>　（永島　拓也）　
    
                        <div style="line-height:1.8;">
                            <HR size="1" color="#cccccc" style="border-style:dotted" width="650">
			<p>
                            日本ではミュージシャンとして活動し、まったく英語が出来ないままカナダ・トロントにワーキングホリデーで渡航。<br />
                            学校で英語を学びながらメキシカン料理とテキーラのショットバーで仕事をしてカナダ生活を１年間満喫する。<br />
                            日本に帰国後すぐにオーストラリアにワーキングホリデーで渡豪。<br />
                            オーストラリアではセカンドワーキングホリデービザを取得のためにファームでスーパーバイザーをして<br />
                            通訳や仕事の割り振りなどの仕事も経験。<br />
                            オーストラリアには約１年半滞在して、途中にニュージランドを車で一周もして2010年に帰国。<br />
                            いろいろな国の経験や英語がまったく話せなかった時の失敗談、海外での英語の伸ばし方などを話せればと思います。<br />
    			</p>
                    </div>
                </div>
                <br />
                <div style="text-align:right;"><b><font size="2">このセミナーを予約する >></font></b><font size ="2">
                　<input align='right' type="button" name="test" value="5月16日（水）" onclick="fnc_yoyaku(this)" uid="1360" title="【TOKYO】5月16日（水）17：00 カナダ・オーストラリア帰国者体験談"> 
                    <br />
                    <br />
                </div>
            </td>
        </tr>
	</table>
    <br />
    <div style="text-align:right;"><A Href="#taiken"><font size=2>▲　体験談一覧</font></A>　　<A Href="#top"><font size=2>▲　フェアトップにもどる</font></A></div><br />
    <br />

    <HR size="1" color="#cccccc" style="border-style:dotted">

    <br />
    <br />
    <br />
    <br /> -->

	</div>


	</div>
  </div>
  </div>



	</div>
  </div>
  </div>
  </div>


<?php fncMenuFooter(); ?>


</body>
</html>