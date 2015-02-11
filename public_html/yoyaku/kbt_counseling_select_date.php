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
	$gmn_id = 'kbt_counseling_select_date.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kbt_counseling_select_counselor.php','kbt_counseling_select_jknkbn.php','kbt_counseling_kkn.php');
					
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
	$select_staff_cd = $_POST['select_staff_cd'];		//未入力OK
	
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
			if ( $lang_cd == "" || $yykkey_ang_str == "" || $kaiin_id == "" || $kaiin_nm == "" || $kaiin_kbn == "" || $select_office_cd == "" ){
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
		
		$sv_max_disp_week = 8;		//表示週　８週
		
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


		if( $err_flg == 0 ){
			//営業時間マスタを読み込む･･･９レコード１セット
			$Meigyojkn_cnt = 0;
			$query = 'select YOUBI_CD,TEIKYUBI_FLG,OFFICE_ST_TIME,ST_DATE,ED_DATE from M_EIGYOJKN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YUKOU_FLG = 1 order by YOUBI_CD,ST_DATE;';
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
					$Meigyojkn_st_time[$Meigyojkn_cnt] = $row[2];		//開店時刻
					$tmp_date = $row[3];
					$Meigyojkn_st_date[$Meigyojkn_cnt] = intval(substr($tmp_date,0,4) . substr($tmp_date,5,2) . substr($tmp_date,8,2));
					$tmp_date = $row[4];
					$Meigyojkn_ed_date[$Meigyojkn_cnt] = intval(substr($tmp_date,0,4) . substr($tmp_date,5,2) . substr($tmp_date,8,2));
					$Meigyojkn_cnt++;
				}
			}
		}

		//*** 日付配列を作成する ***
		//基準日（今日の日曜日を基準日とする）
		$tag_yyyy = $now_yyyy;
		$tag_mm = $now_mm;
		if( $Moffice_start_youbi == 0 ){
			$tag_dd = $now_dd - $now_youbi;
		}else{
			$tag_dd = $now_dd - $now_youbi + 1;
		}
		if( $tag_dd <= 0 ){
			$tag_mm--;
			if( $tag_mm <= 0 ){
				$tag_mm = 12;
				$tag_yyyy--;
			}
			$tmp_maxdd = cal_days_in_month(CAL_GREGORIAN, $tag_mm , $tag_yyyy );
			$tag_dd = $tmp_maxdd + $tag_dd;
		}
		$tag_maxdd = cal_days_in_month(CAL_GREGORIAN, $tag_mm , $tag_yyyy );

		$d = 0;
		while( $d < ($sv_max_disp_week * 7) ){
			$date_ymd[$d] = $tag_yyyy . sprintf("%02d",$tag_mm) . sprintf("%02d",$tag_dd);
			$date_youbi[$d] = date("w", mktime(0, 0, 0, $tag_mm, $tag_dd, $tag_yyyy));
			//営業日フラグを求める
			$date_eigyoubi_flg[$d] = 0;	//営業日フラグ 0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
			$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $date_ymd[$d] . '";';
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
					$date_eigyoubi_flg[$d] = $row[0];	//営業日フラグ
				}
			}
			//定休日フラグを求める
			$date_teikyubi_flg[$d] = 0;	//定休日フラグ　0:営業日 1:定休日
			if( $date_eigyoubi_flg[$d] == 1 || $date_eigyoubi_flg[$d] == 9 ){
				//祝日ロジック
				$find_flg = 0;
				$a = 0;
				while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
					if( $Meigyojkn_youbi_cd[$a] == 8 && ($Meigyojkn_st_date[$a] <= $date_ymd[$d] && $date_ymd[$d] <= $Meigyojkn_ed_date[$a]) ){
						if( $Meigyojkn_st_time[$a] != "" && $Meigyojkn_teikyubi_flg[$a] == 0 ){
							$date_teikyubi_flg[$d] = 0;
						}else if( $Meigyojkn_teikyubi_flg[$a] == 1 ){
							$date_teikyubi_flg[$d] = 1;
						}else{
							//曜日で検索しなおし
							$a = 0;
							while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
								if( $Meigyojkn_youbi_cd[$a] == $date_youbi[$d] && ($Meigyojkn_st_date[$a] <= $date_ymd[$d] && $date_ymd[$d] <= $Meigyojkn_ed_date[$a]) ){
									$date_teikyubi_flg[$d] = $Meigyojkn_teikyubi_flg[$a];
									$find_flg = 1;
								}
								$a++;
							}
						}
						$find_flg = 1;
					}
					
					$a++;	
				}
				
			}else{
				//通常曜日
				$find_flg = 0;
				$a = 0;
				while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
					if( $Meigyojkn_youbi_cd[$a] == $date_youbi[$d] && ($Meigyojkn_st_date[$a] <= $date_ymd[$d] && $date_ymd[$d] <= $Meigyojkn_ed_date[$a]) ){
						$date_teikyubi_flg[$d] = $Meigyojkn_teikyubi_flg[$a];
						$find_flg = 1;
					}
					$a++;
				}
			}
			//定休日の場合、営業日個別に登録されていた場合は、営業日扱いとする
			if( $date_teikyubi_flg[$d] == 1 ){
				$query = 'select count(*) from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $date_ymd[$d]  . '";';
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
					$row = mysql_fetch_array($result);
					if( $row[0] != 0 ){
						$date_teikyubi_flg[$d] = 0;
					}else{
						//定休日の場合、営業日フラグを非営業日にする
						if( $date_eigyoubi_flg[$d] == 0 ){
							$date_eigyoubi_flg[$d] = 8;
						}else if( $date_eigyoubi_flg[$d] == 1 ){
							$date_eigyoubi_flg[$d] = 9;
						}
					}
				}
			}
			
			//スタッフスケジュールを確認する
			$rtn_str = sc_chk($DEF_kg_cd,$kaiin_id,$select_office_cd,$date_ymd[$d],$select_staff_cd);
			$date_sc_all_open_su[$d] = $rtn_str['all_open_su'];
			$date_sc_open_su[$d] = $rtn_str['open_su'];
			$date_sc_trk_su[$d] = $rtn_str['trk_su'];
			$date_sc_yyk_kano_flg[$d] = $rtn_str['yyk_kano_flg'];
			
			
			//翌日にする
			$tag_dd++;
			if( $tag_dd > $tag_maxdd ){
				$tag_dd = 1;
				$tag_mm++;
				if( $tag_mm > 12 ){
					$tag_mm = 1;
					$tag_yyyy++;
				}
				$tag_maxdd = cal_days_in_month(CAL_GREGORIAN, $tag_mm , $tag_yyyy );
			}
				
			$d++;
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
				print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_counselor.php#kbtcounseling">');
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
				
				print('<table border="0"');
				print('<tr>');
				print('<td width="135">&nbsp;</td>');
				print('<td width="430" align="center" valign="middle">');
				//「現在の予約内容です。」
				print('<img src="./img_' . $lang_cd . '/title_now_yykinfo.png" border="0">');
				print('</td>');
				//戻るボタン
				print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_kkn.php#kbtcounseling">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
				print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
				print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
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
			
			
			print('<table border="0">');	//main
			print('<tr>');	//main
			print('<td width="700" align="center">');	//main

			//「日付を選択してください。」
			print('<img src="./img_' . $lang_cd . '/title_select_date.png" border="0"><br>');			

			//見出し部
			print('<table border="1" bordercolor="black">');
			print('<tr>');
			if( $Moffice_start_youbi == 0 ){
				print('<td width="80" align="center" background="../img_' . $lang_cd . '/bg_pink_80x20.png">日</td>');
			}
			print('<td width="80" align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">月</td>');
			print('<td width="80" align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">火</td>');
			print('<td width="80" align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">水</td>');
			print('<td width="80" align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">木</td>');
			print('<td width="80" align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">金</td>');
			print('<td width="80" align="center" background="../img_' . $lang_cd . '/bg_blue_80x20.png"><font color="blue">土</font></td>');
			if( $Moffice_start_youbi == 1 ){
				print('<td width="55" align="center" background="../img_' . $lang_cd . '/bg_pink_80x20.png"><font color="red">日</font></td>');
			}
			print('</tr>');


			$d = 0;
			while( $d < ($sv_max_disp_week * 7) ){
				//週開始タグ
				if( $Moffice_start_youbi == 0 ){
					if( $date_youbi[$d] == 0 ){
						print('<tr>');
					}
				}else if( $Moffice_start_youbi == 1 ){
					if( $date_youbi[$d] == 1 ){
						print('<tr>');
					}
				}
				
				//文字色
				if( $date_youbi[$d] == 0 || $date_eigyoubi_flg[$d] == 1 || $date_eigyoubi_flg[$d] == 9 ){
					$fontcolor = "red";
				}else if( $date_youbi[$d] == 6 ){
					$fontcolor = "blue";
				}else{
					$fontcolor = "black";
				}
				
				//背景色
				if( $date_youbi[$d] == 0 || $date_eigyoubi_flg[$d] == 1 ){
					$bgfile = "pink";
				}else if( $date_eigyoubi_flg[$d] == 8 || $date_eigyoubi_flg[$d] == 9 ){
					$bgfile = "lightgrey";
				}else if( $date_youbi[$d] == 6 ){
					$bgfile = "blue";
				}else{
					$bgfile = "mizu";
				}
					
				//日にち
				$tmp_mm = sprintf("%d",substr($date_ymd[$d],4,2));
				$tmp_dd = sprintf("%d",substr($date_ymd[$d],6,2));
				if( $date_sc_open_su[$d] > 0 ){
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_jknkbn.php#kbtcounseling">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
					print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
					print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
					print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
					print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
					print('<input type="hidden" name="select_ymd" value="' . $date_ymd[$d] . '">');
					//日時変更引数
					print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
				}
				print('<td align="center" valign="top" background="../img_' . $lang_cd . '/bg_' . $bgfile . '_80x20.png">');
				print('<font size="4" color="' . $fontcolor . '">' . $tmp_mm . '/' . $tmp_dd . '</font><br>');
				if( $date_eigyoubi_flg[$d] == 8 || $date_eigyoubi_flg[$d] == 9 ){
					//「お休みです」
					print('<img src="./img_' . $lang_cd . '/title_mini_oyasumi.png" border="0"><br>');
					
				}else if( $date_ymd[$d] < $now_yyyymmdd ){
					//「終了しました」
					print('<img src="./img_' . $lang_cd . '/title_mini_syuryou.png" border="0"><br>');			
					
				}else{
					if( $date_sc_open_su[$d] > 0 && $date_sc_trk_su[$d] > 0 && $date_sc_yyk_kano_flg[$d] == 1 ){
						//公開されていて、受付可能があり、予約可能であれば、選択ボタンを表示する
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sentaku_mini_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sentaku_mini_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sentaku_mini_1.png\';" border="0">');
					
					}else if( $date_sc_open_su[$d] > 0 && $date_sc_trk_su[$d] > 0 ){
						//登録はあるが予約可能ではない場合は満席と判断「Ｘ 満席」
						print('<img src="./img_' . $lang_cd . '/title_manseki_78x30.png" border="0">');			
					}else if( $date_sc_all_open_su[$d] == 0 ){
						//「受付開始前」
						print('<img src="./img_' . $lang_cd . '/title_mini_kaishimae.png" border="0">');			
					}else{
						//「Ｘ 不可」
						print('<img src="./img_' . $lang_cd . '/title_mini_fuka.png" border="0">');
					}
					
				}
				print('</td>');
				if( $date_sc_open_su[$d] > 0 ){
					print('</form>');
				}
				
				//週終了タグ
				if( $Moffice_start_youbi == 0 ){
					if( $date_youbi[$d] == 6 ){
						print('</tr>');
					}
				}else if( $Moffice_start_youbi == 1 ){
					if( $date_youbi[$d] == 0 ){
						print('</tr>');
					}
				}
				
				$d++;	
			}
			
			print('</table>');
			
			print('</td>');	//main
			print('</tr>');	//main
			print('</table>');	//main


			print('<hr>');

			//戻るボタン
			print('<table border="0">');
			print('<tr>');
			print('<td width="565">&nbsp;</td>');
			if( $select_yyk_no == "" ){
				//新規予約登録時
				print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_counselor.php#kbtcounseling">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
				print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
				print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			}else{
				//日時変更時
				print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_kkn.php#kbtcounseling">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
				print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
				print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
				print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			}
			print('<td width="135" align="center" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
		
			print('<hr>');

			
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
	print('<img src="./img_' . $lang_cd . '/btn_sentaku_mini_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');



	//予約可能であるかチェックする関数
	function sc_chk($DEF_kg_cd,$kaiin_id,$select_office_cd,$target_yyyymmdd,$select_staff_cd){

		$tmp_sc_all_open_su = 0;	//公開スケジュール数（公開中の全スタッフ数x8）
		$tmp_sc_open_su = 0;		//公開スケジュール数（公開中の指名スタッフx8）
		$tmp_sc_trk_su = 0;			//スケジュール数（公開中で受付可能なスケジュール）
		$yyk_kano_flg = 0;			//予約可能フラグ  0:予約不可 1;予約可能


		//スタッフスケジュールの公開状況を求める（全員）	
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
			$tmp_sc_all_open_su = $row[0];
		}

		//スタッフスケジュールの公開状況を求める（カウンセラー指名）
		$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '"';
		if( $select_staff_cd != "" ){
			$query .= ' and STAFF_CD = "' . $select_staff_cd . '"';
		}
		$query .= ' and CLASS_CD = "KBT" and OPEN_FLG = 1;';
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
			$tmp_sc_open_su = $row[0];
		}
		
		if( $tmp_sc_open_su > 0 ){
			
			//スタッフスケジュールの受付可能数を求める
			$query = 'select distinct(JKN_KBN) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '"';
			if( $select_staff_cd != "" ){
				$query .= ' and STAFF_CD = "' . $select_staff_cd . '"';
			}
			$query .= ' and CLASS_CD = "KBT" and OPEN_FLG = 1 and UKTK_FLG = 1 order by JKN_KBN;';
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
				while( $row = mysql_fetch_array($result) ){
					$tmp_jkn_kbn = $row[0];	//受付可能となっている時間区分
					
					//全員を対象とした受付可能数を求める
					$tmp_uktk_su = 0;
					$query2 = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '"';
					$query2 .= ' and CLASS_CD = "KBT" and JKN_KBN = "' . $tmp_jkn_kbn . '" and OPEN_FLG = 1 and UKTK_FLG = 1;';
					$result2 = mysql_query($query2);
					if (!$result2) {
						$err_flg = 4;
						//エラーメッセージ表示
						require( './zy_errgmn.php' );
			
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = '';			//オフィスコード
						$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
						$log_naiyou = 'スタッフスケジュールの参照に失敗しました。';	//内容
						$log_err_inf = $query2;			//エラー情報
						require( './zy_log.php' );
						//************
						
					}else{
						$row2 = mysql_fetch_array($result2);
						$tmp_uktk_su = $row2[0];
					}
					
					//実際の予約数を求める
					$tmp_yyk_su = 0;
					$query2 = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $target_yyyymmdd . '"';
					$query2 .= ' and JKN_KBN = "' . $tmp_jkn_kbn . '";';
					$result2 = mysql_query($query2);
					if (!$result2) {
						$err_flg = 4;
						//エラーメッセージ表示
						require( './zy_errgmn.php' );
			
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = '';			//オフィスコード
						$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
						$log_naiyou = 'スタッフスケジュールの参照に失敗しました。';	//内容
						$log_err_inf = $query2;			//エラー情報
						require( './zy_log.php' );
						//************
						
					}else{
						$row2 = mysql_fetch_array($result2);
						$tmp_yyk_su = $row2[0];
					}
					
					//カウンセラー指名の場合、そのカウンセラーの実予約があるかチェックする
					$tmp_shimei_flg = 0;
					if( $select_staff_cd != "" ){
						$query2 = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $target_yyyymmdd . '" and STAFF_CD = "' . $select_staff_cd . '"';
						$query2 .= ' and JKN_KBN = "' . $tmp_jkn_kbn . '";';
						$result2 = mysql_query($query2);
						if (!$result2) {
							$err_flg = 4;
							//エラーメッセージ表示
							require( './zy_errgmn.php' );
				
							//**ログ出力**
							$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = '';			//オフィスコード
							$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
							$log_naiyou = 'スタッフスケジュールの参照に失敗しました。';	//内容
							$log_err_inf = $query2;			//エラー情報
							require( './zy_log.php' );
							//************
							
						}else{
							$row2 = mysql_fetch_array($result2);
							if( $row2[0] > 0 ){
								$tmp_shimei_flg = 1;
							}
						}
					}
						
					//指名予約がなく、実予約が予約可能数を下回っている場合は予約可能とする
					if( $tmp_shimei_flg == 0 && $tmp_yyk_su < $tmp_uktk_su ){
						$yyk_kano_flg = 1;		//予約可能フラグ  0:予約不可 1;予約可能
					}
					
					$tmp_sc_trk_su++;
				}
			}
		}

		$rtn_str['all_open_su'] = $tmp_sc_all_open_su;
		$rtn_str['open_su'] = $tmp_sc_open_su;
		$rtn_str['trk_su'] = $tmp_sc_trk_su;
		$rtn_str['yyk_kano_flg'] = $yyk_kano_flg;
		
		return $rtn_str;

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

