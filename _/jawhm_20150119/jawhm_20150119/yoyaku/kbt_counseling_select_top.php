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
	$gmn_id = 'kbt_counseling_select_top.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kbt_counseling_menu.php','kbt_counseling_select_counselor.php');
					
	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	$tabindex = 0;	//タブインデックス

	//日付関係
	require( '../zz_datetime.php' );
	
	//***コーディングはここから**********************************************************************************
	
	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = $_POST['lang_cd'];
	$yykkey_ang_str = $_POST['yykkey_ang_str'];
	$kaiin_id = $_POST['kaiin_id'];
	$kaiin_nm = $_POST['kaiin_nm'];
	$kaiin_kbn = $_POST['kaiin_kbn'];
	$select_office_cd = $_POST['select_office_cd'];		//未入力OK
	
	//サーバー接続
	require( './zy_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}else{
		//画面ＩＤのチェック
		if( !in_array($prc_gmn , $ok_gmn) ){
			$err_flg = 2;
		}else{
			//引数入力チェック
			if ( $lang_cd == "" || $yykkey_ang_str == "" || $kaiin_id == "" || $kaiin_nm == "" || $kaiin_kbn == "" ){
				$err_flg = 3;
			}else{
				//メンテナンス期間チェック
				require( './zy_mntchk.php' );
		
				if( $mntchk_flg == 1 || $mntchk_flg == 2 ){
					$err_flg = 80;	//メンテナンス中
				}
			}
		}
	}
	

	//エラー発生時
	if( $err_flg != 0 ){
		//エラー画面編集
		require( './zy_errgmn.php' );
		
	}else{
		
		//テスト中メッセージ
		if( $SVkankyo == 9 ){
			print('<table border="0"><tr><td bgcolor="#FF0099"><font color="white">*** 現在、個別カウンセリングのページは作成中ですので、予約はできません。 ***</font></td></tr></table>');
		}

		//画像事前読み込み
		//（最終行に移動）
		
		$err_cnt = 0;
		$data_cnt = 0;
		
		
		//有効なオフィスを取得する
		$Moffice_cnt = 0;
		$query = 'select OFFICE_CD,OFFICE_NM from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and YUKOU_FLG = 1 ' . 
														   ' and OFFICE_CD in (select distinct OFFICE_CD from M_CLASS where KG_CD = "' . $DEF_kg_cd . '" and CLASS_CD = "KBT" and YUKOU_FLG = 1) order by ST_DATE;';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			//エラーメッセージ表示
			require( './zy_errgmn.php' );
			
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';			//オフィスコード
			$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
			$log_naiyou = 'オフィスマスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zy_log.php' );
			//************

		}else{
			while( $row = mysql_fetch_array($result) ){
				$Moffice_office_cd[$Moffice_cnt] = $row[0];	//オフィスコード
				$Moffice_office_nm[$Moffice_cnt] = $row[1];	//オフィス名
				
				//オフィスを会場に置換する
				$Moffice_office_nm[$Moffice_cnt] = str_replace('オフィス','会場',$Moffice_office_nm[$Moffice_cnt] );				
				
				$Moffice_cnt++;
			}
		}
		
		if( $err_flg == 0 ){

			//お客様氏名
			print('<table boeder="0">');
			print('<tr>');
			print('<td width="565" align="left" valign="middle">');
			print('<font size="4">' . $kaiin_nm . '</font>&nbsp;様');
			print('</td>');
			//メニューへ戻るボタン
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_menu.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<td width="135" align="left" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_menu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_menu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_menu_1.png\';" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
			
			print('<hr>');

			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_counselor.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
			print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
			print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');

			print('<table border="0">');	//main
			print('<tr>');	//main
			print('<td width="700" align="center">');	//main

			//「会場を選んでください」
			print('<img src="./img_' . $lang_cd . '/title_select_kaijyou.png" border="0"><br>');

			print('<table border="0">');
			print('<tr>');
			print('<td align="left" valign="middle">');
			print('<select name="select_office_cd" style="font-size:24px; background-color: #E0FFFF;">');
			$i = 0;
			while( $i < $Moffice_cnt ){
				print('<option value="' . $Moffice_office_cd[$i] . '"');
				if( $Moffice_office_cd[$i] == $select_office_cd ){
					print(' selected');
				}
				print('>' . $Moffice_office_nm[$i] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>');
				$i++;
			}
			print('</select>');
			print('</td>');			
			print('<td align="left" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_next_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_next_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_next_1.png\';" border="0">');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			print('</form>');

			print('</td>');	//main
			print('</tr>');	//main
			print('</table>');	//main

			print('<hr>');

			//戻るボタン
			print('<table border="0">');
			print('<tr>');
			print('<td width="565">&nbsp;</td>');
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_menu.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<td width="135" align="center" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
		
			print('<hr>');

			
		}else{
			//顧客情報が取得できなかった
			print('<font color="red">お手数ですが、始めからお願いします。</font><br><br>');
			
			//戻るボタン
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<td width="135" align="center" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
		
			print('<hr>');
			
		}
	}

	//画像事前読み込み
	print('<img src="./img_' . $lang_cd . '/btn_menu_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_next_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');


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

