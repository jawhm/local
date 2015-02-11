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
/*
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
*/	
?>
<?php

//if (is_mobile())	{
//	header('Location: http://www.jawhm.or.jp/seminar/ser') ;
//	exit();
//}

//redirection for mobile
if(isset($_GET['num']))
{
	if(!empty($_GET['place_name']))
	{
		$mobile_place = 'place/'.$_GET['place_name'].'/';
		$mobile_date =  $_GET['year'].'/'.$_GET['month'].'/'.$_GET['day'].'/'.$_GET['num'];
;
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

$header_obj->title_page='個別カウンセリング情報';
$header_obj->description_page='ワーキングホリデーや留学をされる方向けの無料セミナー等のご案内をしています。ワーキングホリデー協定国の最新のビザ取得方法や渡航情報などを発信しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデービザの取得が可能です。ワーキングホリデービザ以外に学生ビザでの留学などもお手伝い可能です。';

$header_obj->fncFacebookMeta_function= true;

$header_obj->mobileredirect=$redirection;

$header_obj->size_content_page='';

$header_obj->add_js_files = '<script type="text/javascript" src="../js/jquery.blockUI.js"></script>
<script type="text/javascript" src="../js/fixedui/fixedUI.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.16.custom.min.js"></script>
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

</script>';
$header_obj->add_css_files='
<!--[if lte IE 8 ]>
    <link rel="stylesheet" href="/css/style_ie.css" />
<![endif]-->

<link type="text/css" href="/css/jquery-ui-1.8.16.custom.css" rel="stylesheet" />';

$header_obj->full_link_tag = true;
$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="./img_J/counseling-mainimg.png" alt="" />';
$header_obj->fncMenuHead_h1text = '個別カウンセリング情報';

$header_obj->display_header();

?>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>

<div id="maincontent">
    
<?php echo $header_obj->breadcrumbs(); ?>
    
<h2 class="sec-title" id="kbtcounseling">個別カウンセリングのご案内</h2>
    
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'kbt_counseling.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	//（オールOK）

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	$tabindex = 0;	//タブインデックス

	//日付関係
	require( '../zz_datetime.php' );
	
	//***コーディングはここから**********************************************************************************
	
	$lang_cd = "J";	//言語  J:日本語 E:英語 K:韓国語
	
	//サーバー接続
	require( './zy_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
		print('<font color="red">※エラーが発生しました。</font>');
		
	}else{
		
		//テスト中メッセージ
		if( $SVkankyo == 9 ){
			print('<table border="0"><tr><td bgcolor="#FF0099"><font color="white">*** 現在、個別カウンセリングのページは作成中ですので、実際の予約はできません。 ***</font></td></tr></table>');
		}

		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_kbtcounseling_2.png" width="0" height="0" style="visibility:hidden;">');

		if( $mem_id != "" ){
			//メンバー
			
			//お客様番号を求める
			// ＣＲＭに転送
			$data = array(
				 'pwd' => '303pittST'
				,'serch_id' => $mem_id
			);
			$url = 'https://toratoracrm.com/crm/CS_serch_id.php';
			$val = wbsRequest($url, $data);
			$ret = json_decode($val, true);
			if ($ret['result'] == 'OK')	{
				// OK
				$msg = $ret['msg'];
				$rtn_cd = $ret['rtn_cd'];
				$member_cnt = $ret['data_cnt'];
				if( $member_cnt == 1 ){
					//データが見つかった（１件のみ）
					
					$kaiin_id = $ret["data_id_0"];			//お客様番号
					$kaiin_nm = $ret["data_name_0"];			//氏名
//					$data_kaiin_nm_k = $ret["data_name_k_0"];			//フリガナ
//					$data_kaiin_mixi = $ret["data_mixi_0"];			//ＭＩＸＩ名
//					$data_kaiin_kyoumi = $ret["data_yotei_0"];		//予定国（興味のある国に設定）
//					$data_kaiin_bikou = $ret["data_bikou_0"];			//基本情報メモ（備考）
//					$tmp_mail = $ret["data_mail_0"];			//会員メールアドレス
//					$tmp_mail = str_replace(',','<br>',$tmp_mail );
//					$data_kaiin_mail = $tmp_mail;			//会員メールアドレス
//					$tmp_tel = $ret["data_tel_0"];			//会員電話番号
//					$data_kaiin_tel = str_replace(',','<br>',$tmp_tel );		//[,]を改行コードに置換する
//					$data_kaiin_tel_keitai = "";		//会員電話番号
//						
//					//会員名カナの調整
//					if( $data_kaiin_nm_k == "　" ){
//						$data_kaiin_nm_k = "";	
//					}

					
					//暗号化する
					$yykkey_kaiin_id = $kaiin_id;
					require( './zy_yykkey_ang.php' );
					if( $yykkey_err_flg != 0 ){
						// NG	
						$err_flg = 6;	//暗号キー生成エラー
						
					}
					
				}else{
					// NG	
					$err_flg = 5;	//お客様番号を求められなかった
					
				}
					
			}else{
				// NG	
				$err_flg = 5;	//お客様番号を求められなかった
				
			}
			
		}


 
		if( $err_flg == 0 && $mem_id == "" ){
			//一般（無料メンバー）と判断

			//画面編集
			//「個別カウンセリングの予約について」
			print('<img src="./img_' . $lang_cd . '/title_kbt_main.png" bordrr="0"><br>');

			print('<table border="0">');
			print('<tr>');
			print('<td width="450" align="left" valign="top">');
			//「メールアドレス」
			print('<img src="./img_' . $lang_cd . '/title_mailadr.png" bordrr="0"><br>');
			print('<a href="mailto:' . $sv_yyk_request_mailadr . '?subject=Request&body=Request" style="text-decoration: none;"><font size="5" color="blue">' . $sv_yyk_request_mailadr . '</font></a><br>');
			print('</td>');
			print('<td width="250" rowspan="2" align="center" valign="top">');
			//ＱＲコード(238x237)
			print('<img src="./img_' . $lang_cd . '/qr_mailadr.png" bordrr="0"><br>');
			print('</td>');
			print('</tr>');
			print('<tr>');
			print('<td align="left" valign="top">');
			print('<br>');
			print('<font size="2" color="red">・初回の方は申し訳ありませんが、オフィスへご連絡ください。<br></font>');
			print('<font size="2">');
			print('・事前に登録済みのメールアドレスで送信してください。<br>（未登録の場合は オフィスへご連絡ください）<br>');
			print('・自動的に 個別カウンセリングの予約ページのアドレスを<br>　送られてきたメールアドレス宛に返信します。<br>');
			print('（ info@jawhm.or.jp から送信しますので、<br>　メール受信ができるようメール受信設定をお願いします。）');
			print('</font>');
			print('</td>');
			print('</tr>');
			print('</table>');

			print('<hr>');
			

		}else if( $err_flg == 0 && $mem_id != "" ){
			//メンバーと判断
			
			//画面編集
			//「下のログインボタンを押してください。」
			print('<img src="./img_' . $lang_cd . '/title_kbt_main_login_1.png" bordrr="0"><br>');

			print('<table border="0">');
			print('<tr>');
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_menu.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="J">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<td width="700" align="center">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kbt_menu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kbt_menu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kbt_menu_1.png\';" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');

			print('<img src="./img_' . $lang_cd . '/title_kbt_main_login_2.png" bordrr="0"><br>');

			print('<hr>');

			
		}else if( $err_flg != 0 ){
			//エラー

			//画面編集
			//「エラーが発生しました。」
			print('<img src="./img_' . $lang_cd . '/title_kbt_main_err.png" bordrr="0"><br>');

			print('<hr>');
			
		}
	}

	function wbsRequest($url, $params)
	{
		$data = http_build_query($params);
		$content = file_get_contents($url.'?'.$data);
		return $content;
	}

?>

</div>
<?php
//fncMenuFooter();
?>

</body>
</html>

