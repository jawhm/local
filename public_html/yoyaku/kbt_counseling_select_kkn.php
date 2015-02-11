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
	$gmn_id = 'kbt_counseling_select_kkn.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kbt_counseling_select_jknkbn.php');
					
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
	$select_jknkbn = $_POST['select_jknkbn'];

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
			if ( $lang_cd == "" || $yykkey_ang_str == "" || $kaiin_id == "" || $kaiin_nm == "" || $kaiin_kbn == "" || $select_office_cd == "" || $select_ymd == "" || $select_jknkbn == "" ){
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

		$select_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), sprintf("%d",substr($select_ymd,6,2)), sprintf("%d",substr($select_ymd,0,4))));

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

			}
		}


		//初期化
		
		//興味のある国
		$kyoumi = "未使用";
		if( $select_yyk_kyoumi != "" ){
			$kyoumi = $select_yyk_kyoumi;
		}
		//時期
		$jiki = "未使用";
		if( $select_yyk_jiki != "" ){
			$jiki = $select_yyk_jiki;
		}
		//相談内容
		$soudan = "";
		if( $zz_yykinfo_soudan != "" ){
			$soudan = $zz_yykinfo_soudan;
		}else if( $select_yyk_no != "" && $soudan == "" ){
			$soudan = $zz_yykinfo_soudan;
		}
		
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

		//営業日フラグを求める
		$select_eigyoubi_flg = 0;
		if( $err_flg == 0 ){
			$select_eigyoubi_flg = 0;	//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
			$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD  = "' . $select_ymd . '";';
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
					$select_eigyoubi_flg = $row[0];		//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
				}
			}
		}
				
				
		//営業時間と定休日フラグを求める
		$select_eigyou_st_time = 0;
		$select_eigyou_ed_time = 0;
		$select_teikyubi_flg = 0;	//定休日フラグ　0:営業日 1:定休日
		$find_flg = 0;
		if( $select_eigyoubi_flg == 1 || $select_eigyoubi_flg == 9 ){
			//祝日のみ対応（土日祝の前日は非対応）
			$a = 0;
			while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
				if( $Meigyojkn_youbi_cd[$a] == 8 && $Meigyojkn_st_date[$a] <= $select_ymd && $select_ymd <= $Meigyojkn_ed_date[$a] ){
					if( $Meigyojkn_st_time[$a] != "" ){
						$select_eigyou_st_time = $Meigyojkn_st_time[$a];
						$select_eigyou_ed_time = $Meigyojkn_ed_time[$a];
						$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
						$find_flg = 1;
						
					}else{
						if( $Meigyojkn_teikyubi_flg[$a] != 1 ){
							//曜日で検索しなおし
							$a = 0;
							while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
								if( ( $Meigyojkn_youbi_cd[$a] == $target_youbi_cd ) &&
									( $Meigyojkn_st_date[$a] <= $select_ymd && $select_ymd <= $Meigyojkn_ed_date[$a] ) ){
									$select_eigyou_st_time = $Meigyojkn_st_time[$a];
									$select_eigyou_ed_time = $Meigyojkn_ed_time[$a];
									$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
									$find_flg = 1;
								}
								$a++;
							}
						}else{
							$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
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
					( $Meigyojkn_st_date[$a] <= $select_ymd && $select_ymd <= $Meigyojkn_ed_date[$a] ) ){
					if( $Meigyojkn_teikyubi_flg[$a] != 1 ){
						$select_eigyou_st_time = $Meigyojkn_st_time[$a];
						$select_eigyou_ed_time = $Meigyojkn_ed_time[$a];
						$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
						$find_flg = 1;
					}else{
						$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
						$find_flg = 1;
					}
				}
				$a++;
			}
		}
				
		//定休日の場合、営業日個別に登録されていた場合は、営業日扱いとする
		if( $select_teikyubi_flg == 1 ){
			$query = 'select OFFICE_ST_TIME,OFFICE_ED_TIME from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_ymd . '";';
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
						$select_eigyou_st_time = $row[0];
					}
					if( $row[1] != "" ){
						$select_eigyou_ed_time = $row[1];
					}
					$select_teikyubi_flg = 0;
				}
			}
		}

		//時間区分に該当する時間を取得する
		$Mclass_st_time = 0;
		$Mclass_ed_time = 0;
		$query = 'select ST_TIME,ED_TIME from M_CLASS_JKNWR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $select_jknkbn . '" and ST_DATE <= "' . $select_ymd . '" and ED_DATE >= "' . $select_ymd . '" and YUKOU_FLG = 1;';
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
				$Mclass_st_time = $row[0];	//開始時刻
				$Mclass_ed_time = $row[1];	//終了時刻
			}
			
			//過去時間チェック
			if( $select_ymd < $now_yyyymmdd ||
			   ( $select_ymd == $now_yyyymmdd && $Mclass_st_time <= (($now_hh * 100) + $now_ii) )  ){
				//開始時刻が過去時間
				$err_flg = 5;	//過去日時を選択
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
			
			print('<table border="0">');	//main
			print('<tr>');	//main
			print('<td width="700" align="center">');	//main
			
			if( $select_yyk_no == "" ){
				//新規予約登録時
			
				print('<table border="1" bordercolor="black">');
				print('<tr>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
				print('<td width="228" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_235x20.png"><font size="5">' . $Moffice_office_nm . '</font></td>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor.png" border="0"></td>');
				print('<td width="227" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_235x20.png">' . $Mstaff_open_staff_nm . '</td>');
				print('</tr>');
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_kimidori_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
				if( $select_eigyoubi_flg == 1 || $select_youbi_cd == 0 ){
					$fontcolor = "red";	//祝日/日曜
				}else if( $select_youbi_cd == 6 ){
					$fontcolor = "blue";	//土曜
				}else{
					$fontcolor = "black";	//平日
				}
				print('<td colspan="3" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_565x20.png">&nbsp;&nbsp;<font size="5" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="5">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
				print('</tr>');
				print('</table>');
				
			
			}else{
				//日時変更時
				
				print('<table border="0">');
				print('<tr>');
				print('<td width="675" align="center">');
				//「現在の予約内容です。」
				print('<img src="./img_' . $lang_cd . '/title_now_yykinfo.png" border="0">');
				print('</td>');
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
				
				//「↓」
				print('<img src="./img_' . $lang_cd . '/title_kbt_datecng_yajirushi.png" border="0"><br>');
			
				print('<table border="1" bordercolor="black">');
				print('<tr>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_yellow_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
				if( $select_eigyoubi_flg == 1 || $select_youbi_cd == 0 ){
					$fontcolor = "red";	//祝日/日曜
				}else if( $select_youbi_cd == 6 ){
					$fontcolor = "blue";	//土曜
				}else{
					$fontcolor = "black";	//平日
				}
				print('<td width="565" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_yellow_565x20.png">&nbsp;&nbsp;<font size="5" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="5">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
				print('</tr>');
				print('</table>');
			
			}
				
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_res.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
			print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
			print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
			print('<input type="hidden" name="select_jknkbn" value="' . $select_jknkbn . '">');
			//日時変更引数
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			
			if( $select_yyk_no == "" ){
				//新規予約登録時
				
				//「相談内容を記入後「予約する」ボタンを押してください。」
				print('<img src="./img_' . $lang_cd . '/title_kbt_kkn.png" border="0"><br>');
			
			}

			//興味のある国
			print('<input type="hidden" name="kyoumi" value="' . $kyoumi . '">');
//			print('<table border="0">');
//			print('<tr>');
//			print('<td width="700" align="left">');
//			print('<img src="./img_' . $lang_cd . '/title_kyoumi.png" border="0"><br>');
//			$tabindex++;
//			print('<input type="text" name="kyoumi" maxlength="100" size="30" value="' . $kyoumi . '" class="normal" tabindex="' . $tabindex . '" style="font-size:20pt; background-color: #E0FFFF; ime-mode:active; font-family: sans-serif;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
//			print('</td>');
//			print('</tr>');
//			print('</table>');

			//出発予定時期
			print('<input type="hidden" name="jiki" value="' . $jiki . '">');
//			print('<table border="0">');
//			print('<tr>');
//			print('<td width="700" align="left">');
//			print('<img src="./img_' . $lang_cd . '/title_jiki.png" border="0"><br>');
//			$tabindex++;
//			print('<input type="text" name="jiki" maxlength="100" size="30" value="' . $jiki . '" class="normal" tabindex="' . $tabindex . '" style="font-size:20pt; background-color: #E0FFFF; ime-mode:active; font-family: sans-serif;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
//			print('</td>');
//			print('</tr>');
//			print('</table>');

			//相談内容
			print('<table border="0">');
			print('<tr>');
			print('<td width="660" align="left">');
			print('<img src="./img_' . $lang_cd . '/title_soudan.png" border="0"><br>');
			$tabindex++;
			print('<textarea name="soudan" rows="8"  style="ime-mode:active; background-color: #E0FFFF; width:100%; font-size: 15px; font-family: sans-serif;" tabindex="' . $tabindex . '" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">' . $soudan . '</textarea>');
			print('</td>');
			print('</tr>');
			print('</table>');

			print('<table border="0">');
			print('<tr>');
			if( $select_yyk_no == "" ){
				//新規予約登録時
				print('<td width="510" align="left" valign="top">');
				//記入例
				print('<img src="./img_' . $lang_cd . '/title_kinyurei.png" border="0"><br>');
				print('</td>');
			}else{
				//日時変更時
				print('<td width="510" align="right" valign="middle">');
				//「日時変更をする場合はこのボタンを押下してください。」
				print('<img src="./img_' . $lang_cd . '/title_kbt_ksnkkn_btn.png" border="0">');
				print('</td>');
			}
			//個別カウンセリングを予約する ボタン
			print('<td width="190" align="right" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kbtcounseling_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_1.png\';" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');

			print('</form>');
			
			print('</td>');	//main
			print('</tr>');	//main
			print('</table>');	//main
			
			
			print('<hr>');
				
			print('<table border="0">');
			print('<tr>');
			print('<td width="565">&nbsp;</td>');
			//戻るボタン
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_jknkbn.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
			print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
			print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
			//日時変更引数
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="135" align="right" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');

			print('<hr>');

			
		}else if( $err_flg == 5 ){
			//過去日時を選択した場合
			
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
			
			print('<table border="0">');	//main
			print('<tr>');	//main
			print('<td width="700" align="center">');	//main

			//「エラーがあります」
			print('<img src="./img_' . $lang_cd . '/title_errmes.png" border="0"><br>');

			if( $select_yyk_no == "" ){
				//新規予約登録時

				//「選択日時は過去日時のため、選択できません」
				print('<img src="./img_' . $lang_cd . '/title_err_kakonichiji.png" border="0">');

				print('<table border="1" bordercolor="black">');
				print('<tr>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
				print('<td width="228" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_235x20.png"><font size="5">' . $Moffice_office_nm . '</font></td>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor.png" border="0"></td>');
				print('<td width="227" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_235x20.png">' . $Mstaff_open_staff_nm . '</td>');
				print('</tr>');
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_kimidori_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
				if( $select_eigyoubi_flg == 1 || $select_youbi_cd == 0 ){
					$fontcolor = "red";	//祝日/日曜
				}else if( $select_youbi_cd == 6 ){
					$fontcolor = "blue";	//土曜
				}else{
					$fontcolor = "black";	//平日
				}
				print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_kimidori_565x20.png">&nbsp;&nbsp;<font size="5" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="5">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
				print('</tr>');
				print('</table>');
			
			}else{
				//日時変更時
				
				print('<table border="0">');
				print('<tr>');
				print('<td width="675" align="center">');
				//「現在の予約内容です。」
				print('<img src="./img_' . $lang_cd . '/title_now_yykinfo.png" border="0">');
				print('</td>');
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
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
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
				
				//「選択日時は過去日時のため、選択できません」
				print('<img src="./img_' . $lang_cd . '/title_err_kakonichiji.png" border="0">');

				print('<table border="1" bordercolor="black">');
				print('<tr>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
				if( $select_eigyoubi_flg == 1 || $select_youbi_cd == 0 ){
					$fontcolor = "red";	//祝日/日曜
				}else if( $select_youbi_cd == 6 ){
					$fontcolor = "blue";	//土曜
				}else{
					$fontcolor = "black";	//平日
				}
				print('<td width="565" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_lightgrey_565x20.png">&nbsp;&nbsp;<font size="5" color="' . $fontcolor . '">' . substr($select_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,4,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($select_ymd,6,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$select_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="5">' . intval($Mclass_st_time / 100) . ':' . sprintf("%02d",($Mclass_st_time % 100)) . '&nbsp;-&nbsp;' . intval($Mclass_ed_time / 100) . ':' . sprintf("%02d",($Mclass_ed_time % 100)) . '</font></td>');
				print('</tr>');
				print('</table>');
			
			}
				
			print('</td>');	//main
			print('</tr>');	//main
			print('</table>');	//main
			
			print('<hr>');
				
			print('<table border="0">');
			print('<tr>');
			print('<td width="565">&nbsp;</td>');
			//戻るボタン
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_jknkbn.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
			print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
			print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
			//日時変更引数
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="135" align="right" valign="middle">');
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
	print('<img src="./img_' . $lang_cd . '/btn_kbtcounseling_2.png" width="0" height="0" style="visibility:hidden;">');
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

