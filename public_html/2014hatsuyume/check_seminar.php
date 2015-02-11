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

$header_obj->title_page='仮掲載確認用';
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
		url: "./check_seminar_search.php",
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
$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/seminar-mainimg.jpg" alt="" />';
$header_obj->fncMenuHead_h1text = 'ワーホリ・留学の無料セミナー（説明会）情報';

$header_obj->display_header();
?>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>

        <div id="maincontent">

		<div style="border:5px dotted red; padding:5px 20px 5px 20px;font-size:60pt; font-weight:bold; color:red;">仮掲載確認画面</div>
		<div style="margin-top:10px; font-size:18pt; font-weight:bold; color:red;">この画面は、お客さんは見られません。<br/>仮掲載及び本掲載のセミナーを確認する画面です。</div>
		<div style="margin-top:10px; font-size:18pt; font-weight:bold; color:navy;"><a target="_blank" href="/seminar/seminar">本物のセミナー予約画面はこちからどうぞ</a></div>


            <h2 class="sec-title">ワーホリ・留学の無料セミナーを探す</h2>
            
            <p style="margin: 0 0 8px 10px; font-size:11pt;">
            参加したいセミナーの検索条件を指定してください。 <br />
<br />
            </p>
    
            <?php
            
                if(isset($_GET['navigation']))
                {
                    $navigation_month = $_GET['month'];
                    $navigation_year = $_GET['year'];
                    
                    $yyy = $navigation_year;
                    $mmm = $navigation_month;
					
					$get_param = 1;
					
					//user start using navigation bar
					$navigation_used = $_GET['navigation'];
					
					//click on calendar module ?
					$selected_day = $_GET['day'];


                }
                elseif(!isset($_GET['num']))
                {
                    //Get year and month
                    $yyy = date('Y');
                    $mmm = date('n');
					$get_param = 0;
                }
            
				//unset($_COOKIE['seminar_choice']);

				//Get cookie data
				if(isset($_COOKIE['seminar_choice']) && !isset($_GET['num']))
				{
					$cookies = unserialize(base64_decode($_COOKIE['seminar_choice']));
					
					$place_name_cookie = $cookies['place_name'];
					$checked_countryname_cookie = $cookies['checked_countryname'];
					$checked_know_cookie = $cookies['checked_know'];
					
					$no_cookie = 0;
				}
				else
					$no_cookie = 1;
					
            ?>
            <div class="shibori" id="shiborikomi">
            
            <form id="kensakuform">
                <div class="orange-solid">
                    会場を選択する<br/>
                    <label for="place-tokyo"  >東京</label><input id="place-tokyo"   type="radio" name="place-name" onClick="fncplacesel(this);" value="tokyo" <?php 
					
					if ($_GET['place_name'] == 'tokyo'
						|| $selected_day_place == 'tokyo'
						|| ($get_param == 0 && $no_cookie == 1) 
						|| ($get_param == 0 && $no_cookie == 0 && $place_name_cookie == 'tokyo')
						)  
						echo 'checked'; ?> />
                        
                    <label for="place-osaka"  >大阪</label><input id="place-osaka"   type="radio" name="place-name" onClick="fncplacesel(this);" value="osaka" <?php 
					if ($_GET['place_name'] == 'osaka' || $selected_day_place == 'osaka' || ($get_param == 0 && $no_cookie == 0 && $place_name_cookie == 'osaka') ) echo 'checked'; ?>/>
                    
                    <label for="place-nagoya">名古屋<div class="new-element">new</div></label><input id="place-nagoya" type="radio" name="place-name" onClick="fncplacesel(this);" value="nagoya" <?php 
					if ($_GET['place_name'] == 'nagoya' || $selected_day_place == 'fukuoka' || ($get_param == 0 && $no_cookie == 0 && $place_name_cookie == 'nagoya') ) echo 'checked'; ?>/>
				 
				 <!--	
					<label for="place-sendai" >仙台</label><input id="place-sendai"  type="radio" name="place-name" onClick="fncplacesel(this);" value="sendai" <?php 
					 if ($_GET['place_name'] == 'sendai' || $selected_day_place == 'sendai' || ($get_param == 0 && $no_cookie == 0 && $place_name_cookie == 'sendai') ) echo 'checked'; ?>/>
                    
                   	<label for="place-toyama" >富山</label><input id="place-toyama"  type="radio" name="place-name" onClick="fncplacesel(this);" value="toyama" <?php 
					if ($_GET['place_name'] == 'toyama' || $selected_day_place == 'toyama' || ($get_param == 0 && $no_cookie == 0 && $place_name_cookie == 'toyama') ) echo 'checked'; ?>/>
                -->    
                    <label for="place-fukuoka">福岡</label><input id="place-fukuoka" type="radio" name="place-name" onClick="fncplacesel(this);" value="fukuoka" <?php 
					if ($_GET['place_name'] == 'fukuoka' || $selected_day_place == 'fukuoka' || ($get_param == 0 && $no_cookie == 0 && $place_name_cookie == 'fukuoka') ) echo 'checked'; ?>/>

				
                    
                    <label for="place-okinawa">沖縄</label><input id="place-okinawa" type="radio" name="place-name" onClick="fncplacesel(this);" value="okinawa" <?php 
					if ($_GET['place_name'] == 'okinawa' || $selected_day_place == 'okinawa' || ($get_param == 0 && $no_cookie == 0 && $place_name_cookie == 'okinawa') ) echo 'checked'; ?>/>
                </div>
                <p style="text-align:right;padding-right:20px;margin-bottom:10px;font-size:12px;">その他の都市でのセミナー開催日程は、<a href="/event.html" title="イベントカレンダー">イベントカレンダー</a>にてご案内いたします</p>
                
                <div class="orange-solid">
                    興味のある国を選択する（複数選択可能）<br/>
                    <label for="country-all">全て</label><input id="country-all" type="checkbox" name="country-1" onClick="fnccountryall();" value="all" <?php 
					
					if(	substr_count($_GET['checked_countryname'], 1) == 1 
						|| isset($num)
						|| ($get_param == 0 && $no_cookie == 1) 
						|| $_GET['checked_countryname'] == '0' 
						|| ($get_param == 0 && $no_cookie == 0/* && substr_count($checked_countryname_cookie, 1) == 1*/ )  
						/*|| ($get_param == 0 && $no_cookie == 0 && strlen($checked_countryname_cookie) == 1) */
						) 
						echo 'checked'; ?>/>
                    
                    <label for="country-aus">オーストラリア</label><input id="country-aus" type="checkbox" name="country-2" onClick="fnccountrysel();" value="オーストラリア" <?php 
					
						if(substr_count($_GET['checked_countryname'], 2) == 1 /*|| ($get_param == 0 && substr_count($checked_countryname_cookie, 2) == 1 )*/ ) echo 'checked'; ?>/>
                    
                    <label for="country-nz" >ニュージーランド</label><input id="country-nz" type="checkbox" name="country-3" onClick="fnccountrysel();" value="ニュージーランド" <?php 
					
						if(substr_count($_GET['checked_countryname'], 3) == 1/* || ($get_param == 0 && substr_count($checked_countryname_cookie, 3) == 1 )*/  ) echo 'checked'; ?>/>
                    
                    <label for="country-can">カナダ</label><input id="country-can" type="checkbox" name="country-4" onClick="fnccountrysel();" value="カナダ" <?php 
						
						if(substr_count($_GET['checked_countryname'], 4) == 1 /*|| ($get_param == 0 && substr_count($checked_countryname_cookie, 4) == 1 )*/  ) echo 'checked'; ?>/>
                    
                    <label for="country-uk" >イギリス</label><input id="country-uk" type="checkbox" name="country-5" onClick="fnccountrysel();" value="イギリス" <?php 
						
						if(substr_count($_GET['checked_countryname'], 5) == 1 /*|| ($get_param == 0 && substr_count($checked_countryname_cookie, 5) == 1 )*/  ) echo 'checked'; ?>/>
                    
                    <label for="country-fra">フランス</label><input id="country-fra" type="checkbox" name="country-6" onClick="fnccountrysel();" value="フランス" <?php 
						
						if(substr_count($_GET['checked_countryname'], 6) == 1 /*|| ($get_param == 0 && substr_count($checked_countryname_cookie, 6) == 1 ) */ ) echo 'checked'; ?>/>
                   
                    <label for="country-other">その他の国</label><input id="country-other" type="checkbox" name="country-7" onClick="fnccountrysel();" value="other" <?php 
						
						if(substr_count($_GET['checked_countryname'], 7) == 1 /*|| ($get_param == 0 && substr_count($checked_countryname_cookie, 7) == 1 )*/  ) echo 'checked'; ?> />
            
                </div>
                <div class="orange-solid">
                    セミナーの内容を選択する（複数選択可能）<br/>
                    <label for="know-all">全て</label><input id="know-all" type="checkbox" name="know-1" onClick="fncknowall();" value="all" <?php 
							
							if(	substr_count($_GET['checked_know'], 1) == 1
								|| isset($num)
								||( $get_param == 0 && $no_cookie == 1 )
								||$_GET['checked_know'] == '0' 
								||($get_param == 0 && $no_cookie == 0 /*&& substr_count($checked_know_cookie, 1) == 1*/)
								/*||($get_param == 0 && $no_cookie == 0 && strlen($checked_know_cookie) == 1)*/
							  	) 
							echo 'checked'; ?>/>
                    
                    <label for="know-first" >初心者向け</label><input id="know-first" type="checkbox" name="know-2" onClick="fncknowsel();" value="初心者向け" <?php
							
							if(substr_count($_GET['checked_know'], 2) == 1 /*|| (substr_count($checked_know_cookie, 2) == 1 && $get_param == 0)*/) echo 'checked'; ?>/>
                   
                    <label for="know-sanpo">人数限定！懇談セミナー</label><input id="know-sanpo" type="checkbox" name="know-3" onClick="fncknowsel();" value="懇談" <?php
							
							if(substr_count($_GET['checked_know'], 3) == 1 /*|| (substr_count($checked_know_cookie, 3) == 1 && $get_param == 0)*/) echo 'checked'; ?>/>
                    
                    <label for="know-sc" >もっと詳しく情報収集</label><input id="know-sc" type="checkbox" name="know-4" onClick="fncknowsel();" value="kuwashiku" <?php
                    
							if(substr_count($_GET['checked_know'], 4) == 1  /*|| (substr_count($checked_know_cookie, 4) == 1 && $get_param == 0)*/) echo 'checked'; ?>/>
                    
                    <label for="know-ga">語学学校セミナー</label><input id="know-ga" type="checkbox" name="know-5" onClick="fncknowsel();" value="語学学校" <?php
                    
							if(substr_count($_GET['checked_know'], 5) == 1  /*|| (substr_count($checked_know_cookie, 5) == 1 && $get_param == 0)*/) echo 'checked'; ?>/>
                    
                    <label for="know-si">注目！！人気のセミナー</label><input id="know-si" type="checkbox" name="know-6" onClick="fncknowsel();" value="chumoku" <?php
                    
							if(substr_count($_GET['checked_know'], 6) == 1 /* || (substr_count($checked_know_cookie, 6) == 1 && $get_param == 0)*/) echo 'checked'; ?>/>
                    
                    <label for="know-kouen">講演セミナー</label><input id="know-kouen" type="checkbox" name="know-7" onClick="fncknowsel();" value="講演" <?php
                    
							if(substr_count($_GET['checked_know'], 7) == 1 /* || (substr_count($checked_know_cookie, 7) == 1 && $get_param == 0)*/) echo 'checked'; ?>/>
                            
                </div>
                    <input type="hidden" name="month_date" value="<?php echo $mmm ?>" />
                    <input type="hidden" name="year_date" value="<?php echo $yyy ?>" />
                    <input type="hidden" name="navigation_used" value="<?php echo $navigation_used;?>" />
                    <input type="hidden" name="selected_day" value="<?php echo $selected_day?>" />
            </form>
            </div>
            <div style="margin:20px 0 0 0 ;" id="semi_show" >
            <?php
                require_once './check_seminar_search.php';
            ?>
            </div>

		<div style="border:5px dotted red; padding:5px 20px 5px 20px;font-size:60pt; font-weight:bold; color:red;">仮掲載確認画面</div>
		<div style="margin-top:10px; font-size:18pt; font-weight:bold; color:red;">この画面は、お客さんは見られません。<br/>仮掲載及び本掲載のセミナーを確認する画面です。</div>
		<div style="margin-top:10px; font-size:18pt; font-weight:bold; color:navy;"><a target="_blank" href="/seminar/seminar">本物のセミナー予約画面はこちからどうぞ</a></div>
    
            <div class="navy-dotted">
            【ご注意：スマートフォンをご利用の方へ】<br/>
            スマートフォンなど、ＰＣ以外のブラウザからご利用された場合、予約フォームが正しく機能しない場合があります。<br/>
            この場合、お手数ですが、以下の内容を toiawase@jawhm.or.jp までご連絡ください。<br/>
            　・　参加希望のセミナー日程<br/>
            　・　お名前<br/>
            　・　当日連絡の付く電話番号<br/>
            　・　興味のある国<br/>
            　・　出発予定時期<br/>
            </div>
    
            <!--
            <div style="margin: 10px 0 10px 0; padding: 10px 20px 10px 20px; border: 2px orange dotted; font-size:12pt; font-bold: bold; text-align:center;">
                留学・ワーキングホリデーフェア開催中！詳細は<a href="autumnfair/index.php">こちら！！</a><br/>
                <a href="autumnfair/index.php" onclick="javascript: _gaq.push(['_trackPageview' , '/banner_big/']);"><img  src="images/topbanner/banner-big_off.gif"></a>
            </div>
            
            <div style="font-size:12pt; font-weight:bold; margin: 20px 0 10px 30px;">
                参加したいセミナーの会場を選択してください。<br/>
                <table width="600px">
                    <tr>
                        <td width="200px"><a href="/seminar.html?p=tokyo"><img src="/images/btn_tokyo.gif"></a></td>
                        <td width="200px"><a href="/seminar.html?p=osaka"><img src="/images/btn_osaka.gif"></a></td>
                        <td width="200px"><a href="/seminar.html?p=sendai"><img src="/images/btn_sendai.gif"></a></td>
                    </tr>
                    <tr>
                        <td><a href="/seminar.html?p=fukuoka"><img src="/images/btn_fukuoka.gif"></a></td>
                        <td><a href="/seminar.html?p=okinawa"><img src="/images/btn_okinawa.gif"></a></td>
                        <td><a href="/event.html"><img src="/images/btn_event.gif"></a></td>
                    </tr>
                </table>
            </div>
           -->
    
    
            <div class="navy-dotted">
            【参加したいセミナーが無い場合】<br/>
            　　常設会場（東京・大阪）まで来られない<br/>
            　　希望の日程でセミナーが開催されていない<br/>
            　　セミナーの時間が合わない<br/>
            　など、参加したいセミナーが無い場合は、ご希望を教えてください。<br/>
            　セミナーの内容などについてもリクエストもお待ちしております。<br/>
            <div style="margin:10px 0 10px 0; text-align:center;"><img src="../images/seminarrequest_off.gif" class="feedshow"></div>
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
 <!-- </div>-->
<div id="feedbox" style="display:none;">
<div style="color:navy; font-weight:bold; font-size:12pt;">
ご希望のセミナーが無い場合は、あなたが理想とするセミナーをリクエストしてください
</div>

<form id="feedform">
<center>
	<table border="1">
		<tr>
			<th>希望地域</th>
			<th>希望曜日</th>
			<th>希望時間</th>
			<th>セミナー内容</th>
			<th>その他</th>
		</tr>
		<tr>
			<td nowrap style="text-align:left; vertical-align:top; padding: 3px 4px 0 6px;">
				<input type="checkbox" name="開催地1" value="東京"> 東京　
				<input type="checkbox" name="開催地2" value="大阪"> 大阪<br/>
				<input type="checkbox" name="開催地3" value="福岡"> 福岡　
				<input type="checkbox" name="開催地4" value="沖縄"> 沖縄<br/>
				<div style="font-size:8pt; font-weight:bold; margin-top:5px;">
					常設会場以外の地域でも<br/>　　リクエストしてください
				</div>
				その他：<input type="text" name="開催地T" value="" size="10"><br/>
			</td>
			<td nowrap style="text-align:left; vertical-align:top; padding: 3px 4px 0 6px;">
				<input type="checkbox" name="曜日1" value="月曜日"> 月曜日　
				<input type="checkbox" name="曜日2" value="火曜日"> 火曜日<br/>
				<input type="checkbox" name="曜日3" value="水曜日"> 水曜日　
				<input type="checkbox" name="曜日4" value="木曜日"> 木曜日<br/>
				<input type="checkbox" name="曜日5" value="金曜日"> 金曜日　
				<input type="checkbox" name="曜日6" value="土曜日"> 土曜日<br/>
				<input type="checkbox" name="曜日7" value="日曜日"> 日曜日　
				<input type="checkbox" name="曜日8" value="祝祭日"> 祝祭日<br/>
			</td>
			<td nowrap style="text-align:left; vertical-align:top; padding: 3px 4px 0 6px;">
				<input type="checkbox" name="時間1" value="午前（１１時頃）"> 午前（１１時頃から）<br/>
				<input type="checkbox" name="時間2" value="午後（１時頃）"> 午後（１時頃から）<br/>
				<input type="checkbox" name="時間3" value="午後（３時頃）"> 午後（３時頃から）<br/>
				<input type="checkbox" name="時間4" value="夕方（５時頃）"> 夕方（５時頃から）<br/>
				<input type="checkbox" name="時間5" value="夜間（７時頃）"> 夜間（７時頃から）<br/>
			</td>
			<td nowrap style="text-align:left; vertical-align:top; padding: 3px 4px 0 6px;">
				<input type="checkbox" name="内容1" value="ビザについて"> ビザについて<br/>
				<input type="checkbox" name="内容2" value="海外生活について"> 海外生活について<br/>
				<input type="checkbox" name="内容3" value="語学の勉強について"> 語学の勉強について<br/>
				<input type="checkbox" name="内容4" value="都市の案内"> 都市の案内<br/>
				<input type="checkbox" name="内容5" value="資格について"> 資格について<br/>
			</td>
			<td nowrap style="text-align:left; vertical-align:top; padding: 3px 4px 0 6px;">
				ご自由にどうそ<br/>
				<textarea cols="5" rows="4" name="備考"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="5">
				ご連絡を希望される場合に入力してください。<br/>
				　　お名前 <input type="text" name="お名前" value="" size="20">　　
				　　メール <input type="text" name="メール" value="" size="40">
			</td>
		</tr>
	</table>
	<div style="margin-top:10px;">
		<input style="background:gainsboro; font-weight:bold;" id="feedhide" type="button" value="　　閉じる　　" />　　
		<input style="background:gainsboro; font-weight:bold;" type="submit" value="　リクエストする（送信）　" />
	</div>
</center>
</form>

</div>

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
			<input type="button" class="button_cancel" value=" 取消 " onClick="btn_cancel();">　　　　　
			<input type="button" class="button_submit" value="次へ" onClick="fnc_next();">
		</div>

	</div>

	<div id="form2" style="display:none;">

	<div style="font-size:12pt; font-weight:bold; margin:0 0 8px 0;">セミナー　予約フォーム</div>

<?php	if ($mem_id <> '')	{	?>
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
<?php	}else{		?>
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
<?php	}	?>
	<div style="font-size:9pt; font-weight:bold; margin:10px 0 10px 0; border: 1px dotted navy;;">
		このフォームでは仮予約を行います。<br/>
		予約確認のメールをお送りしますので、メールの指示に従って予約を確定させてください。<br/>
	</div>

	<div id="div_wait" style="display:none;">
		<img src="../images/ajaxwait.gif">
		&nbsp;予約処理中です。しばらくお待ちください。&nbsp;
		<img src="../images/ajaxwait.gif">
	</div>

	<input type="button" class="button_cancel" value=" 取消 " onClick="btn_cancel();">　　　　　
	<input type="button" class="button_submit" value=" 送信 " id="btn_soushin" onClick="btn_submit();">

	</div>

</div>
<?php fncMenuFooter($header_obj->footer_type); ?>

</body>
</html>

