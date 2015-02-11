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
	$gmn_id = 'kbt_counseling_select_jknkbn.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kbt_counseling_select_date.php','kbt_counseling_select_jknkbn.php','kbt_counseling_select_kkn.php');
					
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
	$select_office_cd = $_POST['select_office_cd'];
	$select_staff_cd = $_POST['select_staff_cd'];
	$select_ymd = $_POST['select_ymd'];

	//日時変更時のみ
	$select_yyk_no = $_POST['select_yyk_no'];
	
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
			if ( $lang_cd == "" || $yykkey_ang_str == "" || $kaiin_id == "" || $kaiin_nm == "" || $kaiin_kbn == "" || $select_office_cd == "" || $select_ymd == "" ){
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
		
		//選択した会場（オフィス）を取得する
		$Moffice_cnt = 0;
		$query = 'select OFFICE_NM,START_YOUBI from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '";';
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
				$Moffice_office_nm = $row[0];	//オフィス名
				$Moffice_start_youbi = $row[1];	//開始曜日  0:日曜始まり 1:月曜始まり
				
				//オフィスを会場に置換する
				$Moffice_office_nm = str_replace('オフィス','会場',$Moffice_office_nm );				
				
				$Moffice_cnt++;
			}
		}
		
		//カウンセラー指名がある場合、公開スタッフ名を求める
		$Mstaff_cnt = 0;
		$Mstaff_open_staff_nm = '(指名なし)';
		if( $select_staff_cd != "" ){
			$query = 'select DECODE(OPEN_STAFF_NM,"' . $ANGpw. '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and STAFF_CD = "' . $select_staff_cd . '";';
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
				$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zy_log.php' );
				//************
	
			}else{
				while( $row = mysql_fetch_array($result) ){
					$Mstaff_open_staff_nm = $row[0];	//公開スタッフ名
					$Mstaff_cnt++;
				}
			}
		}

		//選択日情報
		$target_yyyymmdd = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), sprintf("%d",substr($select_ymd,6,2)) , sprintf("%d",substr($select_ymd,0,4))) );
		$target_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), sprintf("%d",substr($target_yyyymmdd,6,2)), sprintf("%d",substr($target_yyyymmdd,0,4))));
		
		//表示最大日付の判定用日付
		$tmp_sabun = 0;
		if( $Moffice_start_youbi == 0 ){
			//*** 日曜始まり ***
			$tmp_sabun = 7 - $now_youbi + (($sv_max_disp_week - 2) * 8);
		}else{
			//*** 月曜始まり ***
			if( $now_youbi == 0 ){
				$tmp_sabun = 1 + (($sv_max_disp_week - 2) * 8);
			}else{
				$tmp_sabun = 7 + 1 - $now_youbi + (($sv_max_disp_week - 2) * 8);
			}
		}
		$max_disp_yyyymmdd = date("Ymd", mktime(0, 0, 0, $now_mm, ($now_dd + $tmp_sabun) , $now_yyyy) );

		//選択日の前週
		$bfweek_date = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), (sprintf("%d",substr($target_yyyymmdd,6,2)) - 7) , sprintf("%d",substr($target_yyyymmdd,0,4))) );
		//選択日の翌週
		$afweek_date = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), (sprintf("%d",substr($target_yyyymmdd,6,2)) + 7) , sprintf("%d",substr($target_yyyymmdd,0,4))) );


		if( $err_flg == 0 ){
			//営業時間マスタを読み込む（選択日の週の先頭以降）･･･９レコード１セット
			$Meigyojkn_cnt = 0;
			$query = 'select YOUBI_CD,TEIKYUBI_FLG,OFFICE_ST_TIME,OFFICE_ED_TIME,ST_DATE,ED_DATE from M_EIGYOJKN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YUKOU_FLG = 1 and ED_DATE >= "' . $target_yyyymmdd . '" order by YOUBI_CD,ST_DATE;';
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
				$log_naiyou = '営業時間マスタの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zy_log.php' );
				//************
				
			}else{
				while( $row = mysql_fetch_array($result) ){
					$Meigyojkn_youbi_cd[$Meigyojkn_cnt] = $row[0];		//曜日コード  0:日,1:月,2:火,3:水,4:木,5:金,6:土,7:土日祝の前日.8:祝日
					$Meigyojkn_teikyubi_flg[$Meigyojkn_cnt] = $row[1];	//定休日フラグ  0:営業日 1:定休日
					$Meigyojkn_st_time[$Meigyojkn_cnt] = $row[2];		//開始時刻
					$Meigyojkn_ed_time[$Meigyojkn_cnt] = $row[3];		//終了時刻
					$tmp_date = $row[4];
					$Meigyojkn_st_date[$Meigyojkn_cnt] = intval(substr($tmp_date,0,4) . substr($tmp_date,5,2) . substr($tmp_date,8,2));
					$tmp_date = $row[5];
					$Meigyojkn_ed_date[$Meigyojkn_cnt] = intval(substr($tmp_date,0,4) . substr($tmp_date,5,2) . substr($tmp_date,8,2));
					$Meigyojkn_cnt++;
				}
			}
		}

		//日時変更の場合のみ
		if( $select_yyk_no != "" ){
			//予約内容を取得する
			$zz_yykinfo_yyk_no = $select_yyk_no;
			require( '../zz_yykinfo.php' );
			if( $zz_yykinfo_rtncd == 1 ){
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zy_errgmn.php' );
				
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = '予約内容の取り込みに失敗しました。[1]';	//内容
				$log_err_inf = '予約番号[' . $select_yyk_no . ']';	//エラー情報
				require( './zy_log.php' );
				//************
				
			}else if( $zz_yykinfo_rtncd == 8 ){
				//予約が無くなった
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zy_errgmn.php' );

				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = '予約内容の取り込みに失敗しました。[8]';	//内容
				$log_err_inf = '予約番号[' . $select_yyk_no . ']';	//エラー情報
				require( './zy_log.php' );
				//************

			}else{
				//比較用に予約日のyyyymmdd型を用意する
				$zz_yykinfo_ymd_yyyymmdd = substr($zz_yykinfo_ymd,0,4) . substr($zz_yykinfo_ymd,5,2) . substr($zz_yykinfo_ymd,8,2);
				
			}
		}


		if( $err_flg == 0 ){
			//エラーなし
			
			//画面編集
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

			if( $select_yyk_no == "" ){
				//新規予約登録時
				
				print('<table border="0"');
				print('<tr>');
				print('<td width="565" align="left" valign="top">');
				print('&nbsp;');
				print('</td>');
				//戻るボタン
				print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_date.php#kbtcounseling">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
				print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
				print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
				print('<td width="135" align="right" valign="top">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');

				print('<hr>');
				
				print('<table border="0"');
				print('<tr>');
				//「会場」
				print('<td width="350" align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/bar_kaijyou_340.png" border="0"><br>');
				print('<font size="5" color="blue">' . $Moffice_office_nm . '</font>');
				print('</td>');
				//「カウンセラー」
				print('<td width="350" align="left" valign="top">');
				print('<img src="./img_' . $lang_cd . '/bar_counselor_340.png" border="0"><br>');
				print('<font size="5" color="blue">' . $Mstaff_open_staff_nm . '</font>');
				print('</td>');
				print('</tr>');
				print('</table>');

			}else{
				//日時変更時
				
				print('<table border="0">');
				print('<tr>');
				print('<td width="135">&nbsp;</td>');
				print('<td width="430" align="center" valign="middle">');
				//「現在の予約内容です。」
				print('<img src="./img_' . $lang_cd . '/title_now_yykinfo.png" border="0">');
				print('</td>');
				//戻るボタン
				print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_date.php#kbtcounseling">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
				print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
				print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
				print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
				print('<td width="135" align="right" valign="top">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');	
				
				print('<table border="1" bordercolor="black">');
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
				print('<td colspan="3" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_pink_565x20.png"><font color="blue" size="5">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
				print('</tr>');
				print('<tr>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
				print('<td width="228" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_235x20.png"><font size="5">' . $zz_yykinfo_office_nm . '</font></td>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor.png" border="0"></td>');
				print('<td width="227" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_235x20.png">');
				if( $zz_yykinfo_staff_cd != "" ){
					print( $zz_yykinfo_open_staff_nm );
				}else{
					print('(指名なし)');
				}
				print('</td>');
				print('</tr>');
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_kimidori_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
				if( $zz_yykinfo_eigyoubi_flg == 1 || $zz_yykinfo_youbi_cd == 0 ){
					$fontcolor = "red";	//祝日/日曜
				}else if( $zz_yykinfo_youbi_cd == 6 ){
					$fontcolor = "blue";	//土曜
				}else{
					$fontcolor = "black";	//平日
				}
				print('<td colspan="3" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_565x20.png">&nbsp;&nbsp;<font size="5" color="' . $fontcolor . '">' . substr($zz_yykinfo_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,8,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$zz_yykinfo_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="5">' . intval($zz_yykinfo_st_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . '&nbsp;-&nbsp;' . intval($zz_yykinfo_ed_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) . '</font></td>');
				print('</tr>');
				print('</table>');
				
			}

			print('<hr>');
			
			print('<table border="0">');
			print('<tr>');
			//前週表示ボタン
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_jknkbn.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
			print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
			print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $bfweek_date . '">');
			//日時変更引数
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="135">');
			if( $target_yyyymmdd > $now_yyyymmdd ){
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_zensyu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_zensyu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_zensyu_1.png\';" border="0">');
			}else{
				print('&nbsp;');	
			}
			print('</td>');
			print('</form>');
			print('<td width="430" align="center" valign="middle">');
			//「時間帯を選択してください。」
			print('<img src="./img_' . $lang_cd . '/title_select_jikantai.png" border="0">');
			print('</td>');
			//翌週表示ボタン
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_jknkbn.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
			print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
			print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $afweek_date . '">');
			//日時変更引数
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="135">');
			if( $afweek_date <= $max_disp_yyyymmdd ){
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_yokusyu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_yokusyu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_yokusyu_1.png\';" border="0">');
			}else{
				print('&nbsp;');	
			}
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
			
			print('<hr>');
			
			$t = 0;
			while( $t < 7 ){
	
				//選択日に有効な時間割を取得する
				$Mclassjknwr_cnt = 0;
				$query = 'select JKN_KBN,ST_TIME,ED_TIME from M_CLASS_JKNWR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and ST_DATE <= "' . $target_yyyymmdd . '" and "' . $target_yyyymmdd . '" <= ED_DATE and YUKOU_FLG = 1 order by TSUBAN;';
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
					$log_naiyou = 'クラス時間割の参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zy_log.php' );
					//************
			
				}else{
					while( $row = mysql_fetch_array($result) ){
						$Mclassjknwr_jkn_kbn[$Mclassjknwr_cnt] = $row[0];	//時間区分
						$Mclassjknwr_st_time[$Mclassjknwr_cnt] = $row[1];	//開始時刻
						$Mclassjknwr_ed_time[$Mclassjknwr_cnt] = $row[2];	//終了時刻
						$Mclassjknwr_cnt++;
					}
				}
				
				//営業日フラグを求める
				$target_eigyoubi_flg = 0;
				if( $err_flg == 0 ){
					$target_eigyoubi_flg = 0;	//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
					$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD  = "' . $target_yyyymmdd . '";';
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
						$log_naiyou = 'カレンダーの参照に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zy_log.php' );
						//************
						
					}else{
						while( $row = mysql_fetch_array($result) ){
							$target_eigyoubi_flg = $row[0];		//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
						}
					}
				}
				
				
				//営業時間と定休日フラグを求める
				$target_eigyou_st_time = 0;
				$target_eigyou_ed_time = 0;
				$target_teikyubi_flg = 0;	//定休日フラグ　0:営業日 1:定休日
				$find_flg = 0;
				if( $target_eigyoubi_flg == 1 || $target_eigyoubi_flg == 9 ){
					//祝日のみ対応（土日祝の前日は非対応）
					$a = 0;
					while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
						if( $Meigyojkn_youbi_cd[$a] == 8 && $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ){
							if( $Meigyojkn_st_time[$a] != "" ){
								$target_eigyou_st_time = $Meigyojkn_st_time[$a];
								$target_eigyou_ed_time = $Meigyojkn_ed_time[$a];
								$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
								$find_flg = 1;
								
							}else{
								if( $Meigyojkn_teikyubi_flg[$a] != 1 ){
									//曜日で検索しなおし
									$a = 0;
									while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
										if( ( $Meigyojkn_youbi_cd[$a] == $target_youbi_cd ) &&
											( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
											$target_eigyou_st_time = $Meigyojkn_st_time[$a];
											$target_eigyou_ed_time = $Meigyojkn_ed_time[$a];
											$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
											$find_flg = 1;
										}
										$a++;
									}
								}else{
									$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
									$find_flg = 1;
								}
							}
						}
						
						$a++;
					}
					
				}else{
					//非祝日
					$a = 0;
					while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
						if( ( $Meigyojkn_youbi_cd[$a] == $target_youbi_cd ) &&
							( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
							if( $Meigyojkn_teikyubi_flg[$a] != 1 ){
								$target_eigyou_st_time = $Meigyojkn_st_time[$a];
								$target_eigyou_ed_time = $Meigyojkn_ed_time[$a];
								$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
								$find_flg = 1;
							}else{
								$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
								$find_flg = 1;
							}
						}
						$a++;
					}
				}
				
				//定休日の場合、営業日個別に登録されていた場合は、営業日扱いとする
				if( $target_teikyubi_flg == 1 ){
					$query = 'select OFFICE_ST_TIME,OFFICE_ED_TIME from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '";';
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
						$log_naiyou = '営業時間個別の参照に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zy_log.php' );
						//************
								
					}else{
						while( $row = mysql_fetch_array($result) ){
							if( $row[0] != "" ){
								$target_eigyou_st_time = $row[0];
							}
							if( $row[1] != "" ){
								$target_eigyou_ed_time = $row[1];
							}
							$target_teikyubi_flg = 0;
						}
					}
				}
				
				//その日にスケジュールを公開しているスタッフがいるか？
				$tmp_open_flg = 0;
				$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '" and CLASS_CD = "KBT" and OPEN_FLG = 1;';
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
					$log_naiyou = 'スタッフスケジュールの参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zy_log.php' );
					//************
								
				}else{
					$row = mysql_fetch_array($result);
					if( $row[0] > 0 ){
						$tmp_open_flg = 1;
					}
				}

				//年月日表示
				if( $target_eigyoubi_flg == 1 || $target_eigyoubi_flg == 9 ){
					//祝日
					$fontcolor = "red";
				}else if( $target_youbi_cd == 0 ){
					//日曜
					$fontcolor = "red";
				}else if( $target_youbi_cd == 6 ){
					//土曜
					$fontcolor = "blue";
				}else{
					//平日
					$fontcolor = "black";
				}
					
				//年月日表示
				print('<table border="0">');
				print('<tr>');
				print('<td id="' . $target_yyyymmdd . '" width="80" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/yyyy_' . substr($target_yyyymmdd,0,4) . '_black.png" border="0"></td>');	//年
				print('<td width="65" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/mm_' . sprintf("%d",substr($target_yyyymmdd,4,2)) . '_' . $fontcolor . '.png" border="0"></td>');	//月
				print('<td width="65" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/dd_' . sprintf("%d",substr($target_yyyymmdd,6,2)) . '_' . $fontcolor . '.png" border="0"></td>');	//日
				print('<td width="40" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/youbi_' . $target_youbi_cd . '_' . $fontcolor . '.png" border="0"></td>');	//曜日
				print('<td width="390">&nbsp;</td>');
				print('</tr>');
				print('</table>');


				print('<table border="1" bordercolor="black">');
				print('<tr>');
				
				//時間帯表示
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){
					
					//非メンバーの予約数を求める
					$notmember_yyk_cnt[$j] = 0;
					$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $target_yyyymmdd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and KAIIN_KBN = 9;';
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
						$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zy_log.php' );
						//************
								
					}else{
						$row = mysql_fetch_array($result);
						$notmember_yyk_cnt[$j] = $row[0];	//非メンバーの予約数
					}
					
					print('<td width="85" align="center" valign="middle" ');
					if( $target_teikyubi_flg == 1 ){
						//定休日
						print('background="../img_' . $lang_cd . '/bg_yellow_80x20.png"');
					}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
						//非営業日
						print('background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"');
					}else if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
						//営業時間外
						print('background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"');
					}else if( $target_yyyymmdd < $now_yyyymmdd || ( $target_yyyymmdd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] < (($now_hh * 100) + $now_ii)) ){
						//過去時間帯
						print('background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"');
						
						
//					}else if( $notmember_yyk_cnt[$j] < $notmember_max_entry ){
					}else{
						//非メンバーの予約可能数を下回っている場合
						//メンバー および 一般 の時間区分
						print('background="../img_' . $lang_cd . '/bg_mizu_80x20.png"');
//					}else{
//						//メンバーのみ の時間区分
//						print('background="../img_' . $lang_cd . '/bg_pink_80x20.png"');
					}
					print('>');
					
					print( intval($Mclassjknwr_st_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_st_time[$j] % 100)) . '-' . intval($Mclassjknwr_ed_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_ed_time[$j] % 100)) );
					print('</td>');
					$j++;
				}			
				print('</tr>');
				

				//選択ボタン
				print('<tr>');
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){
					
					//該当日／時間割のクラス予約を参照し、現在の個別カウンセリングの予約を取得する（全員分）
					$tmp_yyk_cnt = 0;
					$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $target_yyyymmdd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '";';
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
						$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zy_log.php' );
						//************
								
					}else{
						while( $row = mysql_fetch_array($result) ){
							$tmp_yyk_cnt = $row[0];		//現在予約数
						}
					}

					//該当日／時間割のスタッフスケジュールを参照し、現在の受付人数を取得する（全員分）
					$tmp_uktk_ninzu = 0;
					$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and OPEN_FLG = 1 and UKTK_FLG = 1;';
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
						$log_naiyou = 'スタッフスケジュールの参照に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zy_log.php' );
						//************
								
					}else{
						$row = mysql_fetch_array($result);
						$tmp_uktk_ninzu = $row[0];	//受付人数
					}
					
					//カウンセラー指名の場合
					$tmp_shimei_flg = 0;
					$tmp_uktk_flg = 0;
					if( $select_staff_cd != "" ){
						//カウンセラー指名の場合、指名予約があるかチェックする
						$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $target_yyyymmdd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and STAFF_CD = "' . $select_staff_cd . '";';
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
							$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zy_log.php' );
							//************
									
						}else{
							$row = mysql_fetch_array($result);
							if( $row[0] > 0 ){
								$tmp_shimei_flg = 1;
							}
						}
						
						//そのカウンセラーは予約受付登録しているかチェックする
						$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '" and STAFF_CD = "' .  $select_staff_cd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and OPEN_FLG = 1 and UKTK_FLG = 1;';
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
							$log_naiyou = 'スタッフスケジュールの参照に失敗しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zy_log.php' );
							//************
									
						}else{
							$row = mysql_fetch_array($result);
							if( $row[0] > 0 ){
								$tmp_uktk_flg = 1;
							}
						}
					}
					
					//選択ボタン
					if( $tmp_yyk_cnt < $tmp_uktk_ninzu && ($target_eigyoubi_flg == 0 || $target_eigyoubi_flg == 1) && $target_teikyubi_flg == 0 ){
						print('<form method="post" action="kbt_counseling_select_kkn.php#kbtcounseling">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
						print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '" />');
						print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
						print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
						print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
						print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
						print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
						print('<input type="hidden" name="select_ymd" value="' . $target_yyyymmdd . '">');
						print('<input type="hidden" name="select_jknkbn" value="' . $Mclassjknwr_jkn_kbn[$j] . '">');						
						//日時変更引数
						print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
					}
					
					print('<td align="center" valign="middle" ');
					if( $target_teikyubi_flg == 1 ){
						//定休日
						print('background="../img_' . $lang_cd . '/bg_yellow_80x20.png"');
					}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
						//非営業日
						print('background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"');
					}else if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
						//営業時間外
						print('background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"');
					}else if( $target_yyyymmdd < $now_yyyymmdd || ( $target_yyyymmdd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] < (($now_hh * 100) + $now_ii)) ){
						//過去時間帯
						print('background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"');
//					}else if( $notmember_yyk_cnt[$j] < $notmember_max_entry ){
					}else{
						//非メンバーの予約可能数を下回っている場合
						//メンバー および 一般 の時間区分
						print('background="../img_' . $lang_cd . '/bg_mizu_80x20.png"');
//					}else{
//						//メンバーのみ の時間区分
//						print('background="../img_' . $lang_cd . '/bg_pink_80x20.png"');
					}
					print('>');

					if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
						//営業時間外
						print('<img src="./img_' . $lang_cd . '/title_eigyou_jkngai_78x30.png" border="0">');
						
					}else{
						//営業時間内
						if( $tmp_yyk_cnt < $tmp_uktk_ninzu && ($target_eigyoubi_flg == 0 || $target_eigyoubi_flg == 1) && $target_teikyubi_flg == 0 ){

							//過去日／過去時間はダメ
							if( $target_yyyymmdd < $now_yyyymmdd || ($target_yyyymmdd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] <= (($now_hh * 100) + $now_ii)) ){
								//「終了しました。」
								print('<img src="./img_' . $lang_cd . '/title_mini_syuryou.png" border="0">');
							
							}else if( $zz_yykinfo_ymd_yyyymmdd == $target_yyyymmdd && $zz_yykinfo_st_time == $Mclassjknwr_st_time[$j] ){
								//日時変更時の変更前の時間帯
								//「現在の選択」
								print('<img src="./img_' . $lang_cd . '/title_mini_now_selecttime.png" border="0">');
							
							}else{
								if( $select_staff_cd == "" ){
									//全員分
									if( $tmp_uktk_ninzu > 0 ){
										//選択ボタン
										$tabindex++;
										print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sentaku_mini_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sentaku_mini_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sentaku_mini_1.png\';" border="0">');
									}else{
										//受付不可	
										print('<img src="../img_' . $lang_cd . '/title_uktk_fuka.png" border="0">');
									}
								}else{
									//カウンセラー指名
									if( $tmp_shimei_flg == 0 && $tmp_uktk_flg == 1 ){
										//指名予約は無いので選択ボタンを表示
										//選択ボタン
										$tabindex++;
										print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sentaku_mini_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sentaku_mini_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sentaku_mini_1.png\';" border="0">');
									}else if( $tmp_shimei_flg == 1 && $tmp_uktk_flg == 1 ){
										//指名予約があるので満席表示
										print('<img src="./img_' . $lang_cd . '/title_manseki_78x30.png" border="0">');
									}else{
										//受付不可	
										print('<img src="./img_' . $lang_cd . '/title_mini_fuka.png" border="0">');
									}
								}
							}
							
						}else{
							if( $target_teikyubi_flg == 1 ){
								print('&nbsp;<br>定休日<br>&nbsp;');							
							}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
								print('&nbsp;<br>お休みです<br>&nbsp;');
							}else if( $zz_yykinfo_ymd_yyyymmdd == $target_yyyymmdd && $zz_yykinfo_st_time == $Mclassjknwr_st_time[$j] ){
								//日時変更時の変更前の時間帯
								//「現在の選択」
								print('<img src="./img_' . $lang_cd . '/title_mini_now_selecttime.png" border="0">');
							}else if( $target_yyyymmdd < $now_yyyymmdd || ($target_yyyymmdd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] <= (($now_hh * 100) + $now_ii)) ){
								//「終了しました。」
								print('<img src="./img_' . $lang_cd . '/title_mini_syuryou.png" border="0">');
							}else if( $tmp_open_flg == 0 ){
								//「受付開始前」
								print('<img src="./img_' . $lang_cd . '/title_mini_kaishimae.png" border="0">');							
							}else if( $tmp_uktk_ninzu != 0 && $tmp_yyk_cnt == $tmp_uktk_ninzu ){
								//満席
								print('<img src="./img_' . $lang_cd . '/title_manseki_78x30.png" border="0">');
							}else{
								//受付不可	
								print('<img src="./img_' . $lang_cd . '/title_mini_fuka.png" border="0">');
							}
						}
					}
				
					print('</td>');
					if( $tmp_yyk_cnt < $tmp_uktk_ninzu && ($target_eigyoubi_flg == 0 || $target_eigyoubi_flg == 1) && $target_teikyubi_flg == 0 ){
						print('</form>');
					}
				
					$j++;
				}			
				print('</tr>');

				print('</table>');
	
				print('<hr>');
	
				//翌日にする
				$target_yyyymmdd = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), (sprintf("%d",substr($target_yyyymmdd,6,2)) + 1) , sprintf("%d",substr($target_yyyymmdd,0,4))) );
				$target_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), sprintf("%d",substr($target_yyyymmdd,6,2)), sprintf("%d",substr($target_yyyymmdd,0,4))));
				$t++;
				
				
				if( $target_yyyymmdd > $max_disp_yyyymmdd ){
					//表示最大日を越えた場合は、終了
					break;
				}
			}

			print('<table border="0">');
			print('<tr>');
			//前週表示ボタン
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_jknkbn.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
			print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
			print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $bfweek_date . '">');
			//日時変更引数
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="135">');
			$tmp_yyyymmdd = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), sprintf("%d",substr($select_ymd,6,2)) , sprintf("%d",substr($select_ymd,0,4))) );
			if( $tmp_yyyymmdd > $now_yyyymmdd ){
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_zensyu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_zensyu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_zensyu_1.png\';" border="0">');
			}else{
				print('&nbsp;');	
			}
			print('</td>');
			print('</form>');
			print('<td width="430" align="center" valign="middle">&nbsp;</td>');
			//翌週表示ボタン
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_jknkbn.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
			print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
			print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $afweek_date . '">');
			//日時変更引数
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="135">');
			if( $afweek_date <= $max_disp_yyyymmdd ){
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_yokusyu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_yokusyu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_yokusyu_1.png\';" border="0">');
			}else{
				print('&nbsp;');	
			}
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
			
			print('<hr>');
			
			print('<table border="0">');
			print('<tr>');
			print('<td width="565">&nbsp;</td>');
			//戻るボタン
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_date.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
			print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
			print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			//日時変更引数
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td align="right" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
			

		}else if( $err_flg == 0 && $data_cnt != 1 ){
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
	print('<img src="./img_' . $lang_cd . '/btn_zensyu_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_yokusyu_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_sentaku_mini_2.png" width="0" height="0" style="visibility:hidden;">');
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

