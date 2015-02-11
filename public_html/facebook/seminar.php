<?

ini_set( "display_errors", "On");

	mb_language("Ja");
	mb_internal_encoding("utf8");

	// パラメータ確認
	$d = @$_GET['d'];

	// ログイン情報
	$mem_id = @$_SESSION['mem_id'];
	$mem_name = @$_SESSION['mem_name'];
	$mem_level = @$_SESSION['mem_level'];

	// 状態確認
	if ($mem_id <> '')	{
		try {
			$ini = parse_ini_file('../bin/pdo_mail_list.ini', FALSE);
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>無料セミナー情報 | 日本ワーキング・ホリデー協会</title>
<meta name="keywords" content="ワーキングホリデー,留学,オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,学生,留学,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館" />
<meta name="description" content="ワーキングホリデー協定国の最新のビザ取得方法や渡航情報などを発信しています。また、ワーキングホリデーをされる方向けの各種無料セミナーを開催しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデービザの取得が可能です。ワーキングホリデービザ以外に学生ビザでの留学などもお手伝い可能です。" />
<meta name="author" content="Japan Association for Working Holiday Makers" />
<meta name="copyright" content="Japan Association for Working Holiday Makers" />
<link rev="made" href="mailto:info@jawhm.or.jp" />
<link rel="Top" href="index.html" type="text/html" title="ホームページ(最初のページ)" />
<link rel="Index" href="index3.html" type="text/html" title="索引ページ" />
<link rel="Contents" href="content.html" type="text/html" title="目次ページ" />
<link rel="Search" href="search.html" type="text/html" title="検索できるページ" />
<link rel="Glossary" href="glossar.html" type="text/html" title="用語解説ページ" />
<link rel="Help" href="file://///Landisk-a14f96/smithsonian/80.ワーキングホリデー協会/Info/help.html" type="text/html" title="ヘルプページ" />
<link rel="First" href="sample01.html" type="text/html" title="最初の文書へ " />
<link rel="Prev" href="sample02.html" type="text/html" title="前の文書へ" />
<link rel="Next" href="sample04.html" type="text/html" title="次の文書へ" />
<link rel="Last" href="sample05.html" type="text/html" title="最後の文書へ" />
<link rel="Up" href="index2.html" type="text/html" title="一つ上の階層へ" />
<link rel="Copyright" href="copyrig.html" type="text/html" title="著作権についてのページへ" />
<link rel="Author" href="mailto:info@jawhm.or.jp " title="E-mail address" />

<script type="text/javascript" src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/jquery-easing.js"></script>
<script type="text/javascript" src="../js/scroll.js"></script>
<script type="text/javascript" src="../js/jquery.blockUI.js"></script>
<script type="text/javascript" src="../js/fixedui/fixedUI.js"></script>

<link type="text/css" href="../css/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<script type="text/javascript" src="../js/jquery-ui-1.8.16.custom.min.js"></script>

<style>
img {
    border: 0 none;
}

#accordion{
     border: 1px #ccc solid;
     border-top:none;
     width:500px;
     }
#accordion dt{
     background: orange;
     padding: 10px;
     border-top: 1px #ccc solid;
     }
     #accordion dt a{color: #000; text-decoration:none;display:block;}
#accordion dd{padding: 10px}

.button_yoyaku	{
	background-color: navy;
	color: white;
	cursor: pointer;
	padding: 0 5px 0 5px;
	margin: 0 0 3px 0;
	font-weight: bold;
}
.button_submit	{
	background: url(images/button_submit.png) no-repeat 0 0;
	padding-left: 16px;
	cursor: pointer;
}

.button_cancel	{
	background: url(images/button_cancel.png) no-repeat 0 0;
	padding-left: 16px;
	cursor: pointer;
}

.button_next	{
	background: url(images/button_next.png) no-repeat 0 0;
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

<script type="text/javascript">
jQuery(function($) {
	jQuery( 'input:checkbox', '#shiborikomi' ).button();
});

function cplacesel()	{
	jQuery('#place-all').button('destroy');
	jQuery('#place-all').removeAttr('checked');
	jQuery('#place-all').button();
	fncsemiser();
}
function fncplacesel(obj)	{
	if (jQuery(obj).attr('checked'))	{
		jQuery( 'input:checkbox', '#shiborikomi' ).button('destroy');
		if (obj.value != 'all')		{	jQuery('#place-all').removeAttr('checked');	}
		if (obj.value != 'tokyo')	{	jQuery('#place-tokyo').removeAttr('checked');	}
		if (obj.value != 'osaka')	{	jQuery('#place-osaka').removeAttr('checked');	}
		if (obj.value != 'sendai')	{	jQuery('#place-sendai').removeAttr('checked');	}
		if (obj.value != 'fukuoka')	{	jQuery('#place-fukuoka').removeAttr('checked');	}
		if (obj.value != 'okinawa')	{	jQuery('#place-okinawa').removeAttr('checked');	}
		jQuery( 'input:checkbox', '#shiborikomi' ).button();
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
		jQuery( 'input:checkbox', '#shiborikomi' ).button();
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
		jQuery( 'input:checkbox', '#shiborikomi' ).button();
	}
	fncsemiser();
}
function fncsemiser()	{
	jQuery('#semi_show').html('<div style="vertical-align:middle; text-align:center; margin:5px 0 5px 0; font-size:20pt;"><img src="/images/ajax-loader.gif">セミナーを探しています...</div>');
	$senddata = jQuery('#kensakuform').serialize();
	$.ajax({
		type: "POST",
		url: "/seminar_search.php",
		data: $senddata,
		success: function(msg){
			jQuery('#semi_show').html(msg);
		},
		error:function(){
			alert('通信エラーが発生しました。');
			$.unblockUI();
		}
	});
}

</script>

</head>
<body style="width:500px;">


  <div id="contentsbox"><img id="bgtop" src="images/contents-bgtop.gif" alt="" />
  <div id="contents">

	<div id="maincontent">

<h2 class="sec-title">無料セミナーのご案内</h2>

	<div style="padding-left:15px; font-size:10pt;">
		日本ワーキングホリデー協会では、東京・大阪・福岡・沖縄の各会場でワーキングホリデーセミナーを実施しております。<br/>
		セミナーでは以下のような内容をご説明しております。<br/>
		　・　ワーキングホリデーのビザの取得方法<br/>
		　・　ワーキングホリデービザで出来ること<br/>
		　・　ワーキングホリデーに必要なもの<br/>
		　・　各国の特徴<br/>
		　・　ワーキングホリデー最近の傾向<br/>
		　・　現地でのアルバイトやシェアハウスの見つけ方等<br/>
		&nbsp;<br/>
		ワーキングホリデーに興味はあるけど何から始めていいのか分からない方、いろいろと考えすぎて判らなくなってしまった方。
		各セミナーには質疑応答時間もありますので、遠慮されずに積極的に質問してくださいね。
		なんでもご質問にお答え致します<br/>
	</div>

	<div style="border: 2px dotted navy; margin: 20px 0 10px 0; padding: 5px 10px 5px 10px; font-size:12pt;">
		セミナーには、どなたでもご参加できます。（無料です。）
	</div>

<?
	if (is_mobile())	{
?>
	<div style="border: 2px dotted navy; margin: 20px 0 10px 0; padding: 5px 10px 5px 10px; font-size:20pt;">
		スマートフォンでご覧頂いていますか？<br/>
		<a href="http://www.jawhm.or.jp/seminar/ser">無料セミナーが探せて、予約できるスマートフォン専用ページ</a>がございます。<br/>
		是非、ご利用ください。<br/>
	</div>
<?	}	?>

<div class="shibori" id="shiborikomi" style="display:none;">
<p style="margin: 0 0 8px 10px; font-size:11pt;">
参加したいセミナーの検索条件を指定してください。
</p>
<form id="kensakuform">
	<div style="margin: 0 20px 10px 20px; padding: 5px 10px 10px 10px; border: 2px orange solid;">
		会場を選択する<br/>
		<label for="place-all"    >全て</label><input id="place-all"     type="checkbox" name="place-1" onclick="fncplacesel(this);" value="all" checked />
		<label for="place-tokyo"  >東京</label><input id="place-tokyo"   type="checkbox" name="place-2" onclick="fncplacesel(this);" value="tokyo" />
		<label for="place-osaka"  >大阪</label><input id="place-osaka"   type="checkbox" name="place-3" onclick="fncplacesel(this);" value="osaka" />
		<label for="place-sendai" >仙台</label><input id="place-sendai"  type="checkbox" name="place-4" onclick="fncplacesel(this);" value="sendai" />
		<label for="place-fukuoka">福岡</label><input id="place-fukuoka" type="checkbox" name="place-5" onclick="fncplacesel(this);" value="fukuoka" />
		<label for="place-okinawa">沖縄</label><input id="place-okinawa" type="checkbox" name="place-6" onclick="fncplacesel(this);" value="okinawa" />
	</div>
	<div style="margin: 0 20px 10px 20px; padding: 5px 10px 10px 10px; border: 2px orange solid;">
		興味のある国を選択する（複数選択可能）<br/>
		<label for="country-all">全て</label><input id="country-all" type="checkbox" name="country-1" onclick="fnccountryall();" value="all" checked />
		<label for="country-aus">オーストラリア</label><input id="country-aus" type="checkbox" name="country-2" onclick="fnccountrysel();" value="オーストラリア" />
		<label for="country-nz" >ニュージーランド</label><input id="country-nz" type="checkbox" name="country-3" onclick="fnccountrysel();" value="ニュージーランド" />
		<label for="country-can">カナダ</label><input id="country-can" type="checkbox" name="country-4" onclick="fnccountrysel();" value="カナダ" />
		<label for="country-uk" >イギリス</label><input id="country-uk" type="checkbox" name="country-5" onclick="fnccountrysel();" value="イギリス" />
		<label for="country-fra">フランス</label><input id="country-fra" type="checkbox" name="country-6" onclick="fnccountrysel();" value="フランス" />
		<label for="country-other">その他の国</label><input id="country-other" type="checkbox" name="country-7" onclick="fnccountrysel();" value="other" />
	</div>
	<div style="margin: 0 20px 10px 20px; padding: 5px 10px 10px 10px; border: 2px orange solid;">
		セミナーの内容を選択する（複数選択可能）<br/>
		<label for="know-all">全て</label><input id="know-all" type="checkbox" name="know-1" onclick="fncknowall();" value="all" checked />
		<label for="know-first" >初心者向け</label><input id="know-first" type="checkbox" name="know-2" onclick="fncknowsel();" value="初心者向け" />
		<label for="know-sanpo">現地生活ガイド</label><input id="know-sanpo" type="checkbox" name="know-3" onclick="fncknowsel();" value="現地生活ガイド" />
		<label for="know-sc" >学生限定</label><input id="know-sc" type="checkbox" name="know-4" onclick="fncknowsel();" value="学生限定" />
		<label for="know-ga">語学学校</label><input id="know-ga" type="checkbox" name="know-5" onclick="fncknowsel();" value="語学学校" />
		<label for="know-si">資格</label><input id="know-si" type="checkbox" name="know-6" onclick="fncknowsel();" value="資格" />
	</div>
</form>
</div>

<h2 class="sec-title">無料セミナーを探そう！！</h2>
<div id="semi_show" style="margin-top:-30px;">
<?
	require_once 'seminar_search.php';
?>
</div>


<div style="height:30px;">&nbsp;</div>
<div style="text-align:center;">
	<img src="images/flag01.gif">
	<img src="images/flag03.gif">
	<img src="images/flag09.gif">
	<img src="images/flag05.gif">
	<img src="images/flag06.gif">
	<img src="images/mflag11.gif" width="40" height="26">
	<img src="images/flag08.gif">
	<img src="images/flag04.gif">
	<img src="images/flag02.gif">
	<img src="images/flag10.gif">
	<img src="images/flag07.gif">
</div>

	<div style="height:50px;">&nbsp;</div>

	</div>


	</div>
  </div>
  </div>

<script>
     jQuery('img').hover(function(){
        jQuery(this).attr('src', jQuery(this).attr('src').replace('_off', '_on'));
          }, function(){
             if (!jQuery(this).hasClass('currentPage')) {
             jQuery(this).attr('src', jQuery(this).attr('src').replace('_on', '_off'));
        }
   });

$(function() {
   $('#accordion dd').hide();
   $('#accordion dt a').click(function(){
       $('#accordion dd').slideUp();
       $(this).parent().next().slideDown();
       return false;
   });
});

</script>


</body>
</html>

