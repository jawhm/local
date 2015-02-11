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
$header_obj->fncMenuHead_h1text = '個別カウンセリング　予約空き情報';

$header_obj->display_header();

?>
<script type="text/javascript" src="../js/wz_tooltip.js"></script>

<div id="maincontent">
    
<?php echo $header_obj->breadcrumbs(); ?>
    
<h2 class="sec-title" id="kbtcounseling">個別カウンセリング　予約空き情報</h2>
    
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'list_kbt.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	//（オールOK）
					
	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	$tabindex = 0;	//タブインデックス

	//日付関係
	require( '../zz_datetime.php' );
	
	//***コーディングはここから**********************************************************************************
	
	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = "";
	$lang_cd = $_POST['lang_cd'];
	if( $lang_cd == "" ){
		$lang_cd = "J";
	}
	$select_office_cd = "";
	$select_office_cd = htmlspecialchars($_GET['c'],ENT_QUOTES,'auto');
	if( $select_office_cd == "" ){
		$select_office_cd = $_POST['select_office_cd'];
	}
	if( $select_office_cd == "" ){
		$select_office_cd = "tokyo";
	}
	$kaiin_id = "";
	$kaiin_id = $_POST['kaiin_id'];


	//サーバー接続
	require( './zy_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}else{
		//メンテナンス期間チェック
		require( './zy_mntchk.php' );
		
		if( $mntchk_flg == 1 || $mntchk_flg == 2 ){
			$err_flg = 80;	//メンテナンス中
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
			
			//スタッフスケジュールを参照する
			$date_sc_cnt[$d] = 0;	//スケジュールカウント（受付可能となっているスタッフスケジュール）
			$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $date_ymd[$d] . '" and CLASS_CD = "KBT" and OPEN_FLG = 1 and UKTK_FLG = 1';
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
					if( $row[0] != "" ){
						$date_sc_cnt[$d] += $row[0];
						
					}
				}
			}

			//実際に予約されている件数を取得する
			$date_yyk_cnt[$d] = 0;	//予約カウント（実際に予約されている件数）
			$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $date_ymd[$d] . '";';
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
				$date_yyk_cnt[$d] += $row[0];
			}

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


		if( $err_flg == 0 ){
			//エラーなし
			
			//画面編集
				
			print('<table border="0">');	//main
			print('<tr>');	//main
			print('<td width="700" align="center">');	//main

			//「※個別カウンセリング　予約状況」
			print('<img src="./img_' . $lang_cd . '/title_list_kbt.png" border="0"><br>');
			
			print('<table border="0"');
			print('<tr>');
			print('<td width="580" align="left" valign="top">');
			//「会場」
			print('<img src="./img_' . $lang_cd . '/bar_kaijyou.png" border="0"><br>');
			print('<font size="5" color="blue">' . $Moffice_office_nm . '</font>');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			

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
				
				print('<td align="center" valign="top" background="../img_' . $lang_cd . '/bg_' . $bgfile . '_80x20.png">');
				print('<font size="4" color="' . $fontcolor . '">' . $tmp_mm . '/' . $tmp_dd . '</font><br>');
				if( $date_eigyoubi_flg[$d] == 8 || $date_eigyoubi_flg[$d] == 9 ){
					//「お休みです」
					print('<img src="./img_' . $lang_cd . '/title_mini_oyasumi.png" border="0"><br>');
					
				}else if( $date_ymd[$d] < $now_yyyymmdd ){
					//「終了しました」
					print('<img src="./img_' . $lang_cd . '/title_mini_syuryou.png" border="0"><br>');			
					
				}else{
					if( $date_sc_cnt[$d] > 0 ){
						//受付人数登録あり
						if( $date_yyk_cnt[$d] == $date_sc_cnt[$d] ){
							//満席
							print('<img src="./img_' . $lang_cd . '/title_mini_manseki.png" border="0">');			
							
						}else{
							$tmp_persent = $date_yyk_cnt[$d] / $date_sc_cnt[$d] * 100;
							if( $tmp_persent >= 80 ){
								//残りわずか（８０％以上）
								print('<img src="./img_' . $lang_cd . '/title_mini_zansyou.png" border="0">');
							}else if( $tmp_persent >= 40 ){
								//若干の余裕あり（４０％以上）
								print('<img src="./img_' . $lang_cd . '/title_mini_jyakkan.png" border="0">');
							}else{
								//余裕あり
								print('<img src="./img_' . $lang_cd . '/title_mini_aki.png" border="0">');
							}
						}
						
					}else{
						//「受付開始前」
						print('<img src="./img_' . $lang_cd . '/title_mini_kaishimae.png" border="0"><br>');			
					}
					
				}
				print('</td>');
				
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

			print('<table border="0">');	//main2
			print('<tr>');	//main2
			print('<td width="700" align="right">');	//main2
			//予約状況メモ
			print('<img src="./img_' . $lang_cd . '/title_yyk_jyoukyou_memo.png" border="0"><br>');			
			print('</td>');	//main2
			print('</tr>');	//main2
			print('</table>');	//main2
			
			

			print('<hr>');

		}
	}

	//画像事前読み込み
	print('<img src="./img_' . $lang_cd . '/btn_menu_2.png" width="0" height="0" style="visibility:hidden;">');
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

