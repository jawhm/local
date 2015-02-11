<?php
//ini_set( "display_errors", "On");

	session_start();

	ini_set( "display_errors", "Off");
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
?>
<?php

//if (is_mobile())	{
//	header('Location: http://www.jawhm.or.jp/seminar/ser') ;
//	exit();
//}

//get number from module calendar or banner
if(isset($_GET['num']) && !isset($_GET['navigation']))
{
	if(!empty($_GET['num']))
	{
		//secure data
		$num = htmlentities(trim($_GET['num']));
		$num = stripslashes(stripslashes($num));
	
		try 
		{
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			
			$stt = $db->query('SELECT place, year(hiduke) as yyy, month(hiduke) as mmm, day(hiduke) as ddd FROM event_list WHERE id = "'.$num.'"');
	

			while($row = $stt->fetch(PDO::FETCH_ASSOC))
			{
				$yyy	= $row['yyy'];
				$mmm  	= $row['mmm'];
				$ddd	= $row['ddd'];
				$selected_day_place	= $row['place'];
			}
			$db = NULL;
			
			//prepare date format for other function that use date(Ymd)
			if($mmm < 10)
				$Ymd_month = '0'.$mmm;
			else
				$Ymd_month = $mmm;
				
			if($ddd < 10)
				$Ymd_day = '0'.$ddd;
			else
				$Ymd_day = $ddd;
				

			//event pc seminar redirection
			if( $selected_day_place	== 'event')
			{
				if(!is_mobile())
				{
					
					header('Location:/event.html#'.$yyy.$Ymd_month.$Ymd_day) ;
					exit();
				}

			}
			
		} 
		catch (PDOException $e) 
		{
			die($e->getMessage());
		}
		//pc settings
		$selected_day = $ddd;
		$get_param = 0;
		
		$show_listing ='
		<script type="text/javascript">

			$(document).ready(function() {
				$.blockUI({
					message: $("#'.$selected_day_place.$yyy.$Ymd_month.$Ymd_day.'"),
					css: { 	left: ($(window).width()-800)/2 +"px",
							overflow: "auto",
							cursor:"default",
							width: "auto",
							height: "auto"
					}
				});
				
				$(".blockMsg").css("max-height", 90 +"%");
				$(".blockMsg").css("min-height",200 +"px");
				$(".blockMsg").css("max-width",800+"px");
				$(".blockMsg").css("top", ($(window).height()-$(".blockMsg").height())/2 +"px");
			});
		</script>';

		
		//mobile settings
		$mobile_place = 'place/'.$selected_day_place.'/';
		$mobile_date =  $yyy.'/'.$mmm.'/'.$ddd.'/'.$num;
	}
	else
	{
		$mobile_place = '';
		$mobile_date = '';
	}
}

 
$redirection='/seminar/ser/'.$mobile_place.$mobile_date;

require_once '../include/header.php';

$header_obj = new Header();

$title = 'ワーホリ（ワーキングホリデー）の無料セミナー（説明会）情報';
if (@$_GET['place_name'] == 'tokyo')	{	$title .= '【東京】';	}
if (@$_GET['place_name'] == 'osaka')	{	$title .= '【大阪】';	}
if (@$_GET['place_name'] == 'nagoya')	{	$title .= '【名古屋】';	}
if (@$_GET['place_name'] == 'fukuoka')	{	$title .= '【福岡】';	}
if (@$_GET['place_name'] == 'okinawa')	{	$title .= '【沖縄】';	}


$header_obj->title_page=$title;

$header_obj->description_page='ワーキングホリデー（ワーホリ）や留学をされる方向けの無料セミナー等のご案内をしています。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->fncFacebookMeta_function= true;

$header_obj->mobileredirect=$redirection;

$header_obj->size_content_page='big';

$header_obj->add_js_files = '<script type="text/javascript" src="/js/jquery.blockUI.js"></script>
<script type="text/javascript" src="/js/fixedui/fixedUI.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript">
jQuery(function($) {
	$(".feedshow").click(function() {
	  $.fixedUI("#feedbox");
	});
	$("#feedhide").click(function() {
	  $.unfixedUI();
	});
	$("#feedform").submit(function() {
		$senddata = $("#feedform").serialize();
		$.ajax({
			type: "POST",
			url: "http://www.jawhm.or.jp/feedback/sendmail.php",
			data: $senddata + "&subject=Seminar Request",
			success: function(msg){
				alert("リクエストありがとうございました。");
				$.unfixedUI();
			},
			error:function(){
				alert("通信エラーが発生しました。");
				$.unfixedUI();
			}
		});
	  return false;
	});

	jQuery( "input:checkbox", "#shiborikomi" ).button();
	jQuery( "input:radio", "#shiborikomi" ).button();
//	fncsemiser();

});

function cplacesel()	{
	jQuery("#place-tokyo").button("destroy");
	jQuery("#place-tokyo").removeAttr("checked");
	jQuery("#place-tokyo").button();
	fncsemiser();
}
function fncplacesel(obj)	{
	if (jQuery(obj).attr("checked"))	{
		jQuery( "input:radio", "#shiborikomi" ).button("destroy");
		if (obj.value != "tokyo")	{	jQuery("#place-tokyo").removeAttr("checked");	}
		if (obj.value != "osaka")	{	jQuery("#place-osaka").removeAttr("checked");	}
		if (obj.value != "sendai")	{	jQuery("#place-sendai").removeAttr("checked");	}
		if (obj.value != "nagoya")	{	jQuery("#place-nagoya").removeAttr("checked");	}
		if (obj.value != "toyama")	{	jQuery("#place-toyama").removeAttr("checked");	}
		if (obj.value != "fukuoka")	{	jQuery("#place-fukuoka").removeAttr("checked");	}
		if (obj.value != "okinawa")	{	jQuery("#place-okinawa").removeAttr("checked");	}
		jQuery( "input:radio", "#shiborikomi" ).button();
	}
	fncsemiser();
}
function fnccountrysel()	{
	jQuery("#country-all").button("destroy");
	jQuery("#country-all").removeAttr("checked");
	jQuery("#country-all").button();
	fncsemiser();
}
function fnccountryall()	{
	if (jQuery("#country-all").attr("checked"))	{
		jQuery("input:checkbox", "#shiborikomi" ).button("destroy");
		jQuery("#country-aus").removeAttr("checked");
		jQuery("#country-nz").removeAttr("checked");
		jQuery("#country-can").removeAttr("checked");
		jQuery("#country-uk").removeAttr("checked");
		jQuery("#country-fra").removeAttr("checked");
		jQuery("#country-other").removeAttr("checked");
		jQuery( "input:checkbox", "#shiborikomi" ).button();
	}
	fncsemiser();
}
function fncknowsel()	{
	jQuery("#know-all").button("destroy");
	jQuery("#know-all").removeAttr("checked");
	jQuery("#know-all").button();
	fncsemiser();
}
function fncknowall()	{
	if (jQuery("#know-all").attr("checked"))	{
		jQuery("input:checkbox", "#shiborikomi" ).button("destroy");
		jQuery("#know-first").removeAttr("checked");
		jQuery("#know-sanpo").removeAttr("checked");
		jQuery("#know-sc").removeAttr("checked");
		jQuery("#know-ga").removeAttr("checked");
		jQuery("#know-si").removeAttr("checked");
		jQuery("#know-kouen").removeAttr("checked");
		jQuery( "input:checkbox", "#shiborikomi" ).button();
	}
	fncsemiser();
}
function fncsemiser()	{
	jQuery("#semi_show").html("<div style=\"vertical-align:middle; text-align:center; margin:30px 0 30px 0; font-size:20pt;\"><img src=\"../images/ajax-loader.gif\">セミナーを探しています...</div>");
	$senddata = jQuery("#kensakuform").serialize();
	$.ajax({
		type: "POST",
		url: "./seminar_search.php",
		data: $senddata,
		success: function(msg){
			jQuery("#semi_show").html(msg);
		},
		error:function(){
			alert("通信エラーが発生しました。");
			$.unblockUI();
		}
	});
}

</script>

<script>
function fnc_next()	{
	document.getElementById("form1").style.display = "none";
	document.getElementById("form2").style.display = "";
}

function fnc_yoyaku(obj)	{
	document.getElementById("form1").style.display = "";
	document.getElementById("form2").style.display = "none";

	document.getElementById("btn_soushin").disabled = false;
	document.getElementById("btn_soushin").value = "送信";
	document.getElementById("div_wait").style.display = "none";


	document.getElementById("form_title").innerHTML = obj.getAttribute("name");
	document.getElementById("txt_title").value = obj.getAttribute("name");
	document.getElementById("txt_id").value = obj.getAttribute("uid");
	$.blockUI({ message: $("#yoyakuform"),
	css: { 
		top:  ($(window).height() - 500) /2 + "px", 
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
	if (obj)	{
		if (obj.value == "")	{
			alert("お名前（名）を入力してください。");
			obj.focus();
			return false;
		}
	}
	obj = document.getElementById("txt_furigana");
	if (obj.value == "")	{
		alert("フリガナ（氏）を入力してください。");
		obj.focus();
		return false;
	}
	obj = document.getElementById("txt_furigana2");
	if (obj)	{
		if (obj.value == "")	{
			alert("フリガナ（名）を入力してください。");
			obj.focus();
			return false;
		}
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

	$senddata = $("#form_yoyaku").serialize();

	document.getElementById("div_wait").style.display = "";

	document.getElementById("btn_soushin").value = "処理中...";
	document.getElementById("btn_soushin").disabled = true;

	$.ajax({
		type: "POST",
		url: "http://www.jawhm.or.jp/yoyaku/yoyaku.php",
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
</script>'.$show_listing.
'<script type="text/javascript">
	$(document).ready(function() {

		$(".day_information").bind("mouseenter", function() {
			this.position = setInterval(function (){
				
				if($(".day_information .det").is(":animated")){$(".blockMsg").css("top", ($(window).height()-$(".blockMsg").height())/2 +"px");}
							
			},1);
		}).bind("mouseleave", function() {
			//this.position && clearInterval(this.position);
		});
		
		$(window).resize(function () {
			if(($(window).width()-800)/2 >10)
			{
				$(".blockMsg").css("left", ($(window).width()-800)/2 +"px");
				
			}
			else
			{
				$(".blockMsg").css("left", "2%");
				$(".blockMsg").css("width", "95%");
			}
			$(".blockMsg").css("top", ($(window).height()-$(".blockMsg").height())/2 +"px");
		});
	});
</script>';
$header_obj->add_css_files='
<!--[if lte IE 8 ]>
    <link rel="stylesheet" href="/css/style_ie.css" />
<![endif]-->

<link type="text/css" href="/css/jquery-ui-1.8.16.custom.css" rel="stylesheet" />';

$header_obj->add_style='<style>
.selected_day_in_list{
	background-color:#FFFFAA;
}
</style>';

$header_obj->full_link_tag = true;
$header_obj->fncMenuHead_h1text = 'ワーホリ・留学の無料セミナー（説明会）情報';

/*
  // member
  define('MAX_PATH', '/var/www/html/ad');
  if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
    if (!isset($phpAds_context)) {
      $phpAds_context = array();
    }
    // function view_local($what, $zoneid=0, $campaignid=0, $bannerid=0, $target='', $source='', $withtext='', $context='', $charset='')
    $phpAds_raw = view_local('', 144, 0, 0, '', '', '0', $phpAds_context, '');
    echo $phpAds_raw['html'];
  }
*/

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="images/topbanner.png" alt="" />';


$header_obj->display_header();
?>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>

        <div id="maincontent">
    
	  <?php echo $header_obj->breadcrumbs(); ?>
    
    
            <div style="padding-left:20px; float:left; margin-bottom: 0px; margin-top: 30px; width:100%;" >

		<center><p><img src="images/summerevent.png" style="margin-bottom: -15px;"><br/>
		<font color="orange"><big><strong>夏のプチ留学フェア　～体験談・現地情報を体感し世界を身近に感じませんか？～</big></strong></font></p>
		</center>

            <div style="padding-left:180px; float:left; margin-bottom: 10px;  margin-top: 10px; width:100%;" >
		<p>夏休みも始まり、本格的な夏到来！<br/>
			年末や来年渡航予定の方も、そろそろ具体的なスケジュールを作っておいた方がいい時期になってきましたね。<br/>
			フェア期間中は語学学校セミナーと帰国者体験談セミナーに力を入れ、留学の準備を進めている方はもちろん、<br/>
			まだ何も決まっていない方でもより具体的な留学のイメージを持って頂けるように、セミナーを展開していきます。</p>
	</div></div>


	<h2 class="sec-title">夏のプチ留学フェア2013は終了致しました</h2>
	<p class="text01">
		夏のプチ留学フェア2013は2013年8月31日をもちまして終了致しました。<br/>
		全国各地からたくさんのご参加本当にありがとうございました。<br/>
	<center><a href="http://www.jawhm.or.jp/seminar.html"><img src="../images/fair_seminar_off.png" width="40%"></a>　<a href="http://www.jawhm.or.jp/ja/4377"><img src="../images/fair_log_off.png"  width="40%"></a></center><br/>
	</p>



<h2 class="sec-title">ワーキング・ホリデー協会　夏のプチ留学フェアって？？</h2>

            <div style="padding-left:20px; float:left; margin-bottom: 10px; margin-top: 10px; width:100%;" >

		<table style="margin: 10px 0 10px 20px;">
			<tr>
			<td colspan="3">
			<center><img src="images/first.png" alt="はじめての方はここから！ワーホリ＆留学初心者向けセミナー"><br/>
			<p>
			気になることNo.1のビザの内容から、失敗しない渡航準備・海外生活の為のお話。<br/>
			ワーホリ＆留学の基本を１日で知ることができるセミナーです！<br/></p>
			<img src="images/chart.png" alt="初心者向けセミナーでワーホリ＆留学についてはなんとなくわかった！じゃあ次は…？"><br/>
			</center>
			</td>	
			</tr>
			<tr>
				<td width="408">
					<img src="images/taikendan.png" alt="海外経験は十人十色！ワーホリ＆留学体験談セミナー"><br/>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><img src="images/school.png" alt="現地情報が聞ける！ワーホリ＆留学語学学校セミナー"  style="margin-top: -30px;">
				</td>

			</tr>
			<tr>
				<td>
					<p>帰国者体験談セミナーでは、海外生活を経験したスタッフが
					持って行った方が良い物、現地での仕事や宿の探し方など自分の体験を元に皆さまのご質問にお答えさせて頂きます。
					少人数制なのでたくさんご質問ください！渡航のきっかけから失敗したことまで、生の声が聞けると評判の当協会人気セミナーです。<br />
					</p>
				</td>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>
					<p style="width: 408px;">
					語学学校セミナーでは、実際に現地で働かれている語学学校スタッフの方にお越し頂き、
					語学学校の説明はもちろん、国や地域の紹介、費用の解説、なぜ学校に通うことが大切なのかなど、皆さまの様々な質問にお答えさせて頂きます。
					ご予約いただいた先着数名様には素敵なプレゼントも…♪<br />
					</p>
				</td>

			</tr>

		</table>
	</div>
				        


		<h2 class="sec-title">次回の留学・ワーキングホリデーフェアは2013年秋を予定しております。</h2>
	<p class="text01">
		当協会留学・ワーキングホリデーフェアは毎年二回、春（5月～）と秋（10月～）に開催しております。<br/>
		またミニフェアとして初夢フェア（1月～）や夏休み日本一周ワーホリ留学出張セミナー（7月～）なども不定期に開催しております。<br/>
		今回残念ながらご参加できなかった方は次回のご参加を心よりお待ちしております。<br/>
		スケジュールは<strong><a href="/">当協会トップページ</a></strong>、<strong><a href="http://www.jawhm.or.jp/seminar.html">無料セミナーページ</a></strong>より順次お知らせいたします。<br/>
	</p>
            
    
            <div style="height:50px;">&nbsp;</div>

        </div>

	</div>    	

   </div> 

<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>

