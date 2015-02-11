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
				$.blockUI({ message: $("#'.$selected_day_place.$yyy.$Ymd_month.$Ymd_day.'"),
				css: { 	top: ($(window).height() - 450) /2 + "px", 
						left: ($(window).width() - 800) /2 + "px",
						overflow: "auto",
						cursor:"default",
						width: "800px",
						height: "450px"
				}});
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
 
//$redirection='/seminar/ser/'.$mobile_place.$mobile_date;
//tanabe_ori
//接続キーを取得
$yykkey_ang_str = htmlspecialchars($_GET['k'],ENT_QUOTES,'auto');
$redirection='../yoyaku_mb/M-kbt_counseling_menu.php?k=' . $yykkey_ang_str;


require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='個別カウンセリング情報';
$header_obj->description_page='ワーキングホリデー（ワーホリ）や留学をされる方向けの無料セミナー等のご案内をしています。ワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。オーストラリア、ニュージーランド、カナダ、韓国、フランス、ドイツ、イギリス、アイルランド、デンマーク、台湾、香港でワーキングホリデー（ワーホリ）ビザの取得が可能です。ワーキングホリデー（ワーホリ）ビザ以外に学生ビザでの留学などもお手伝い可能です。';


$header_obj->fncFacebookMeta_function= true;

//ユーザーエージェント
require( './zy_uachk.php' );
if( $mobile_kbn == "A" || $mobile_kbn == "B" || $mobile_kbn == "I" || $mobile_kbn == "D" || $mobile_kbn == "U" || $mobile_kbn == "S" || $mobile_kbn == "W" ){
	//ガラケーだったらリダイレクトする
	$header_obj->mobileredirect=$redirection;
}

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
</script>'.$show_listing;
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
	$gmn_id = 'kbt_counseling_menu.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	//（オールOK）

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	$tabindex = 0;	//タブインデックス

	//日付関係
	require( '../zz_datetime.php' );
	
	//***コーディングはここから**********************************************************************************
	
	$prc_gmn = $_POST['prc_gmn'];
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
			print('<table border="0"><tr><td bgcolor="#FF0099"><font color="white">*** 現在、個別カウンセリングのページは作成中ですので、予約はできません。 ***</font></td></tr></table>');
		}

		//画像事前読み込み
		//（最終行に移動）

		//接続キーを取得
		$yykkey_ang_str = htmlspecialchars($_GET['k'],ENT_QUOTES,'auto');
		if( $yykkey_ang_str == "" ){
			$yykkey_ang_str = $_POST['yykkey_ang_str'];
		}
			
		if( strlen($yykkey_ang_str) == 20 ){
			//キーを複合化
			$yykkey_ang_str = $yykkey_ang_str;
			require( './zy_yykkey_fkg.php' );
			
		}else{
			//２０文字ではない
			$yykkey_err_flg = 1;
			
		}


		if( $yykkey_err_flg == 0 ){
			//正常処理
			
			//ユーザーエージェント
			require( './zy_uachk.php' );
			
			if( $prc_gmn == "" ){
				//**ログ出力**
				$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $yykkey_kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = '個別カウンセリングのメニューを表示しました。';	//内容
				$log_err_inf = 'kbn[' . $mobile_kbn . '] ip[' . $ip_adr . '] agent1[' . $agent1 . ']';	//エラー情報
				require( './zy_log.php' );
				//************
			}
			
			$err_cnt = 0;
			$data_cnt = 0;
			
			//顧客情報を参照する			
			// ＣＲＭに転送
			$data = array(
				 'pwd' => '303pittST'
				,'serch_id' => $yykkey_kaiin_id
			);
			$url = 'https://toratoracrm.com/crm/CS_serch_id.php';
			$val = wbsRequest($url, $data);
			$ret = json_decode($val, true);
			if ($ret['result'] == 'OK')	{
				// OK
				$msg = $ret['msg'];
				$rtn_cd = $ret['rtn_cd'];
				$member_cnt = $ret['data_cnt'];
				if( $member_cnt > 0 ){
					$i = 0;
					while( $i < $member_cnt ){
						$name = "data_id_" . $i;
						$data_kaiin_no[$data_cnt] = $ret[$name];			//会員番号
						$name = "data_name_" . $i;
						$data_kaiin_nm[$data_cnt] = $ret[$name];			//会員名
						$name = "data_name_k_" . $i;
						$data_kaiin_nm_k[$data_cnt] = $ret[$name];			//会員名カナ
						$name = "data_mixi_" . $i;
						$data_kaiin_mixi[$data_cnt] = $ret[$name];			//ＭＩＸＩ名
						$name = "data_yotei_" . $i;
						$data_kaiin_kyoumi[$data_cnt] = $ret[$name];		//予定国（興味のある国に設定）
						$name = "data_bikou_" . $i;
						$data_kaiin_bikou[$data_cnt] = $ret[$name];			//基本情報メモ（備考）
						$name = "data_mail_" . $i;
						$tmp_mail = $ret[$name];			//会員メールアドレス
						$tmp_mail = str_replace(',','<br>',$tmp_mail );
						$data_kaiin_mail[$data_cnt] = $tmp_mail;			//会員メールアドレス
						$name = "data_tel_" . $i;
						$tmp_tel = $ret[$name];			//会員電話番号
						$data_kaiin_tel[$data_cnt] = str_replace(',','<br>',$tmp_tel );		//[,]を改行コードに置換する
						$data_kaiin_tel_keitai[$data_cnt] = "";		//会員電話番号
						
						//会員名カナの調整
						if( $data_kaiin_nm_k[$data_cnt] == "　" ){
							$data_kaiin_nm_k[$data_cnt] = "";	
						}
								
						//会員区分の判定
						$data_kaiin_mixi[$data_cnt] = strtoupper($data_kaiin_mixi[$data_cnt]);	//小文字を大文字に変換する
						$tmp_pos = strpos($data_kaiin_mixi[$data_cnt],"JW");
						if( $tmp_pos !== false ){
							//メンバー
							$data_kaiin_kbn[$data_cnt] = 1;	//会員区分  0:仮登録　1:メンバー　9:一般（無料メンバー）
						}else{
							//一般（無料メンバー）
							$data_kaiin_kbn[$data_cnt] = 9;	//会員区分  0:仮登録　1:メンバー　9:一般（無料メンバー）
						}
						$i++;								
						$data_cnt++;
					}
				}
						
			}else{
				// NG	
				$err_cnt++;
				
			}

			if( $data_cnt == 1 ){
				//１件ヒット
				
				//現在（今日以降）の予約数を求める
				$new_yyk_cnt = 0;
				$query = 'select A.OFFICE_CD,A.CLASS_CD,A.YMD,A.JKN_KBN,A.YYK_NO,A.YYK_TIME,A.CANCEL_TIME,A.YYK_STAFF_CD,' .
				         'B.OFFICE_NM,C.ST_TIME,C.ED_TIME from D_CLASS_YYK A,M_OFFICE B,M_CLASS_JKNWR C ' .
						 ' where A.KG_CD = "' . $DEF_kg_cd . '" and A.KAIIN_ID = "' . $yykkey_kaiin_id . '" and A.YMD >= "' . $now_yyyymmdd . '" and A.KG_CD = B.KG_CD and A.OFFICE_CD = B.OFFICE_CD and B.ST_DATE <= "' . $now_yyyymmdd . '" and B.ED_DATE >= "' . $now_yyyymmdd . '"' .
						 ' and A.KG_CD = C.KG_CD and A.OFFICE_CD = C.OFFICE_CD and A.CLASS_CD = C.CLASS_CD and C.ST_DATE <= "' . $now_yyyymmdd . '" and C.ED_DATE >= "' . $now_yyyymmdd . '" and A.JKN_KBN = C.JKN_KBN ' .
						 ' order by A.YMD desc,A.JKN_KBN;';
				$result = mysql_query($query);
				if (!$result) {
					$err_flg = 4;
					//エラーメッセージ表示
					print('<font color="red">エラーが発生しました。</font>');

					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = '';			//オフィスコード
					$log_kaiin_no = $yykkey_kaiin_id;		//会員番号 または スタッフコード
					$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
					$log_err_inf = $query;	//エラー情報
					require( './zy_log.php' );
					//************
					
				}else{
					while( $row = mysql_fetch_array($result) ){
						$new_yyk_office_cd[$new_yyk_cnt] = $row[0];		//店舗コード
						$new_yyk_class_cd[$new_yyk_cnt] = $row[1];		//クラスコード
						$new_yyk_ymd[$new_yyk_cnt] = $row[2];			//年月日
						$new_yyk_jkn_kbn[$new_yyk_cnt] = $row[3];		//時間区分
						$new_yyk_yyk_no[$new_yyk_cnt] = $row[4];		//予約番号
						$new_yyk_yyk_time[$new_yyk_cnt] = $row[5];		//予約日時
						$new_yyk_cancel_time[$new_yyk_cnt] = $row[6];	//キャンセル可能日時
						$new_yyk_staff_cd[$new_yyk_cnt] = $row[7];		//予約受付スタッフコード
						$new_yyk_office_nm[$new_yyk_cnt] = $row[8];		//オフィス名
						$new_yyk_st_time[$new_yyk_cnt] = $row[9];		//開始時刻
						$new_yyk_ed_time[$new_yyk_cnt] = $row[10];		//終了時刻
						
						//「オフィス」を「会場」に置換する
						$new_yyk_office_nm[$new_yyk_cnt] = str_replace('オフィス','会場',$new_yyk_office_nm[$new_yyk_cnt] );			
						
						$new_yyk_cnt++;
					}
				}

				//過去の予約数を求める
				$old_yyk_cnt = 0;
				$query = 'select A.OFFICE_CD,A.CLASS_CD,A.YMD,A.JKN_KBN,A.YYK_NO,A.YYK_TIME,A.CANCEL_TIME,A.YYK_STAFF_CD,' .
				         'B.OFFICE_NM,C.ST_TIME,C.ED_TIME from D_CLASS_YYK A,M_OFFICE B,M_CLASS_JKNWR C ' .
						 ' where A.KG_CD = "' . $DEF_kg_cd . '" and A.KAIIN_ID = "' . $yykkey_kaiin_id . '" and A.YMD < "' . $now_yyyymmdd . '" and A.KG_CD = B.KG_CD and A.OFFICE_CD = B.OFFICE_CD and B.ST_DATE <= "' . $now_yyyymmdd . '" and B.ED_DATE >= "' . $now_yyyymmdd . '"' .
						 ' and A.KG_CD = C.KG_CD and A.OFFICE_CD = C.OFFICE_CD and A.CLASS_CD = C.CLASS_CD and C.ST_DATE <= "' . $now_yyyymmdd . '" and C.ED_DATE >= "' . $now_yyyymmdd . '" and A.JKN_KBN = C.JKN_KBN ' .
						 ' order by A.YMD desc,A.JKN_KBN;';
				$result = mysql_query($query);
				if (!$result) {
					$err_flg = 4;
					print('<font color="red">エラーが発生しました。</font>');

					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = '';			//オフィスコード
					$log_kaiin_no = $yykkey_kaiin_id;		//会員番号 または スタッフコード
					$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
					$log_err_inf = $query;	//エラー情報
					require( './zy_log.php' );
					//************
			
				}else{
					while( $row = mysql_fetch_array($result) ){
						$old_yyk_office_cd[$old_yyk_cnt] = $row[0];		//店舗コード
						$old_yyk_class_cd[$old_yyk_cnt] = $row[1];		//クラスコード
						$old_yyk_ymd[$old_yyk_cnt] = $row[2];			//年月日
						$old_yyk_jkn_kbn[$old_yyk_cnt] = $row[3];		//時間区分
						$old_yyk_yyk_no[$old_yyk_cnt] = $row[4];		//予約番号
						$old_yyk_yyk_time[$old_yyk_cnt] = $row[5];		//予約日時
						$old_yyk_cancel_time[$old_yyk_cnt] = $row[6];	//キャンセル可能日時
						$old_yyk_staff_cd[$old_yyk_cnt] = $row[7];		//予約受付スタッフコード
						$old_yyk_office_nm[$old_yyk_cnt] = $row[8];		//オフィス名
						$old_yyk_st_time[$old_yyk_cnt] = $row[9];		//開始時刻
						$old_yyk_ed_time[$old_yyk_cnt] = $row[10];		//終了時刻
	
						//「オフィス」を「会場」に置換する
						$old_yyk_office_nm[$old_yyk_cnt] = str_replace('オフィス','会場',$old_yyk_office_nm[$old_yyk_cnt] );			

						$old_yyk_cnt++;
					}
				}
			}

			//お客様氏名
			print('<table boeder="0">');
			print('<tr>');
			print('<td width="565" align="left" valign="middle">');
			print('<font size="4">' . $data_kaiin_nm[0] . '</font>&nbsp;様');
			print('</td>');
			print('<td width="135" align="left" valign="middle">');
			print('&nbsp;');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			print('<hr>');

			//***現在の予約********************************************************************
			print('<table border="0">');	//genzai
			print('<tr>');	//genzai
			print('<td width="700" align="center">');	//genzai
			
			print('<table bgcolor="orange"><tr><td width="650">');
			print('<img src="./img_' . $lang_cd . '/bar_genzaiyyk.png" border="0">');
			print('</td></tr></table>');

			//現在の予約
			if( $new_yyk_cnt == 0 ){
				//「※現在、予約はありません。」
				print('<br><img src="./img_' . $lang_cd . '/title_yoyaku_zero.png" bordrr="0"><br>');
				
				//予約するボタン
				print('<table border="0">');
				print('<tr>');
				print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_top.php#kbtcounseling">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
				print('<input type="hidden" name="kaiin_id" value="' . $yykkey_kaiin_id . '">');
				print('<input type="hidden" name="kaiin_nm" value="' . $data_kaiin_nm[0] . '">');
				print('<input type="hidden" name="kaiin_kbn" value="' . $data_kaiin_kbn[0] . '">');
				print('<td width="600" align="center">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kbtcounseling_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_1.png\';" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
				
				
			}else{
				//予約あり
				
				print('<table border="1" bordercolor="black">');
				print('<tr bgcolor="powderblue">');
				print('<td width="80" align="center" valign="middle">&nbsp;</td>');	//詳細ボタン
				print('<td width="80" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_no_80x20.png" border="0"></td>');	//予約No
				print('<td width="140" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_time_80x20.png" border="0"></td>');	//予約日時
				print('<td width="235" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_kaijyou_80x20.png" border="0"></td>');	//予約内容
				print('<td width="80" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_access_80x20.png" border="0"></td>');	//地図
				print('</tr>');


				$mirai_cnt = 0;
				$i = 0;
				while( $i < $new_yyk_cnt ){
							
					//曜日コードを求める
					$youbi_cd = date("w", mktime(0, 0, 0, substr($new_yyk_ymd[$i],5,2), substr($new_yyk_ymd[$i],8,2) , substr($new_yyk_ymd[$i],0,4)) );							
					//営業日フラグを求める
					$eigyoubi_flg = 0;	//0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
					$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $new_yyk_office_cd[$i] . '" and YMD = "' . $new_yyk_ymd[$i] . '";';
					$result = mysql_query($query);
					if (!$result) {
						$err_flg = 4;
						print('<font color="red">エラーが発生しました。</font>');
	
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = '';			//オフィスコード
						$log_kaiin_no = $yykkey_kaiin_id;		//会員番号 または スタッフコード
						$log_naiyou = 'カレンダーの参照に失敗しました。';	//内容
						$log_err_inf = $query;	//エラー情報
						require( './zy_log.php' );
						//************
						
					}else{
						while( $row = mysql_fetch_array($result) ){
							$eigyoubi_flg = $row[0];	//営業日フラグ
						}
					}
					
					//背景色
					if( $new_yyk_ymd[$i] == $now_yyyymmdd2 ){
						//本日予約
						$bgfile = "bg_mizu";
						if( $new_yyk_st_time[$i] >= (($now_hh * 100) + $now_ii) ){
							$mirai_cnt++;
						}
						
					}else{
						//未来日
						$bgfile = "bg_yellow";
						$mirai_cnt++;
					}
				
					print('<tr>');
					//変更／取消ボタン
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_kkn.php#kbtcounseling">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
					print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
					print('<input type="hidden" name="kaiin_id" value="' . $yykkey_kaiin_id . '">');
					print('<input type="hidden" name="kaiin_nm" value="' . $data_kaiin_nm[0] . '">');
					print('<input type="hidden" name="kaiin_kbn" value="' . $data_kaiin_kbn[0] . '">');
					print('<input type="hidden" name="select_yyk_no" value="' . $new_yyk_yyk_no[$i] . '">');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_mini_change_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_mini_change_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_mini_change_1.png\';" border="0">');
					print('</td>');
					print('</form>');
					//予約番号
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					print('<font size="2">' . sprintf("%05d",$new_yyk_yyk_no[$i]) . '</font>');
					print('</td>');
					//予約日／時間
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_130x20.png">');
					if( $youbi_cd == 0 || $eigyoubi_flg == 1 || $eigyoubi_flg == 9 ){
						//日曜・祝日
						$fontcolor = 'red';
					}else if( $youbi_cd == 6 ){
						//土曜
						$fontcolor = 'blue';
					}else{
						$fontcolor = 'black';
					}
					print('<font size="2" color="' . $fontcolor . '">' . $new_yyk_ymd[$i] . '&nbsp;' . $week[$youbi_cd] .'</font><br><font size="2">' . intval($new_yyk_st_time[$i] / 100 ) . ':' . sprintf("%02d",($new_yyk_st_time[$i] % 100 )) . '～' . intval($new_yyk_ed_time[$i] / 100 ) . ':' . sprintf("%02d",($new_yyk_ed_time[$i] % 100 )) . '</font>');
					print('</td>');
					//予約会場
					print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_235x20.png">');
					print('<font size="2" color="blue">&nbsp;&nbsp;' . $new_yyk_office_nm[$i] . '</font>');
					print('</td>');
					//地図
					print('<form method="post" action="http://www.jawhm.or.jp/event/map?p=' . $new_yyk_office_cd[$i] . '" target="_blank">');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_map_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_map_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_map_1.png\';" border="0">');
					print('</td>');
					print('</form>');
					print('</tr>');
				
					$i++;
				}
				print('</table>');
				
				
				if( $mirai_cnt == 0 ){
					//明日以降の予約が無ければ、予約するボタンを表示する
					
					//予約するボタン
					print('<table border="0">');
					print('<tr>');
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_select_top.php#kbtcounseling">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
					print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
					print('<input type="hidden" name="kaiin_id" value="' . $yykkey_kaiin_id . '">');
					print('<input type="hidden" name="kaiin_nm" value="' . $data_kaiin_nm[0] . '">');
					print('<input type="hidden" name="kaiin_kbn" value="' . $data_kaiin_kbn[0] . '">');
					print('<td width="600" align="center">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kbtcounseling_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_1.png\';" border="0">');
					print('</td>');
					print('</form>');
					print('</tr>');
					print('</table>');
					
				}else{
					//明日以降の予約がある場合は、新規の予約は出来ない
					//「※新たな予約は１人１件とさせていただいております。」
					print('<img src="./img_' . $lang_cd . '/title_1kenmade.png" bordrr="0">');
					
				}

			}
			
			print('</td>');	//genzai
			print('</tr>');	//genzai
			print('</table>');	//genzai

			print('<hr>');
			
			//***過去の予約********************************************************************
			print('<table border="0">');	//kako
			print('<tr>');	//kako
			print('<td width="700" align="center">');	//kako
			
			print('<table bgcolor="lightgrey"><tr><td width="650">');
			print('<img src="./img_' . $lang_cd . '/bar_kakoyyk.png" border="0">');
			print('</td></tr></table>');
			if( $old_yyk_cnt == 0 ){
				//「※現在、予約はありません。」
				print('<br><img src="./img_' . $lang_cd . '/title_yoyaku_zero.png" bordrr="0"><br><br><br>');
				
			}else{
				//予約あり
				
				print('<table border="1" bordercolor="black">');
				print('<tr bgcolor="powderblue">');
				print('<td width="80" align="center" valign="middle">&nbsp;</td>');	//詳細ボタン
				print('<td width="80" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_no_80x20.png" border="0"></td>');	//予約No
				print('<td width="140" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_time_80x20.png" border="0"></td>');	//予約日時
				print('<td width="235" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_kaijyou_80x20.png" border="0"></td>');	//予約内容
				print('<td width="80" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_access_80x20.png" border="0"></td>');	//地図
				print('</tr>');

				$i = 0;
				while( $i < $old_yyk_cnt ){
					//曜日コードを求める
					$youbi_cd = date("w", mktime(0, 0, 0, substr($old_yyk_ymd[$i],5,2), substr($old_yyk_ymd[$i],8,2) , substr($old_yyk_ymd[$i],0,4)) );							
					//営業日フラグを求める
					$eigyoubi_flg = 0;	//0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
					$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $old_yyk_office_cd[$i] . '" and YMD = "' . $old_yyk_ymd[$i] . '";';
					$result = mysql_query($query);
					if (!$result) {
						$err_flg = 4;
						print('<font color="red">エラーが発生しました。</font>');
	
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = '';			//オフィスコード
						$log_kaiin_no = $yykkey_kaiin_id;		//会員番号 または スタッフコード
						$log_naiyou = 'カレンダーの参照に失敗しました。';	//内容
						$log_err_inf = $query;	//エラー情報
						require( './zy_log.php' );
						//************
		
					}else{
						while( $row = mysql_fetch_array($result) ){
							$eigyoubi_flg = $row[0];	//営業日フラグ
						}
					}
							
					//背景色
					$bgfile = "bg_lightgrey";
				
					print('<tr>');
					//詳細ボタン
					print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_kkn.php#kbtcounseling">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
					print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
					print('<input type="hidden" name="kaiin_id" value="' . $yykkey_kaiin_id . '">');
					print('<input type="hidden" name="kaiin_nm" value="' . $data_kaiin_nm[0] . '">');
					print('<input type="hidden" name="kaiin_kbn" value="' . $data_kaiin_kbn[0] . '">');
					print('<input type="hidden" name="select_yyk_no" value="' . $old_yyk_yyk_no[$i] . '">');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_mini_syousai_78x40_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_mini_syousai_78x40_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_mini_syousai_78x40_1.png\';" border="0">');
					print('</td>');
					print('</form>');
					//予約No
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					print('<font size="2">' . sprintf("%05d",$old_yyk_yyk_no[$i]) . '</font>');
					print('</td>');
					//予約日／時間
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_130x20.png">');
					if( $youbi_cd == 0 || $eigyoubi_flg == 1 || $eigyoubi_flg == 9 ){
						//日曜・祝日
						$fontcolor = 'red';
					}else if( $youbi_cd == 6 ){
						//土曜
						$fontcolor = 'blue';
					}else{
						$fontcolor = 'black';
					}
					print('<font size="2" color="' . $fontcolor . '">' . $old_yyk_ymd[$i] . '&nbsp;' . $week[$youbi_cd] .'</font><br><font size="2">' . intval($old_yyk_st_time[$i] / 100 ) . ':' . sprintf("%02d",($old_yyk_st_time[$i] % 100 )) . '～' . intval($old_yyk_ed_time[$i] / 100 ) . ':' . sprintf("%02d",($old_yyk_ed_time[$i] % 100 )) . '</font>');
					print('</td>');
					//予約会場
					print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_235x20.png">');
					print('<font size="2" color="blue">&nbsp;&nbsp;' . $old_yyk_office_nm[$i] . '</font>');
					print('</td>');
					//地図
					print('<form method="post" action="http://www.jawhm.or.jp/event/map?p=' . $old_yyk_office_cd[$i] . '" target="_blank">');
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_map_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_map_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_map_1.png\';" border="0">');
					print('</td>');
					print('</form>');
					print('</tr>');
					
					$i++;
				}
				print('</table>');
				
			}
			
			print('</td>');	//kako
			print('</tr>');	//kako
			print('</table>');	//kako

			print('<br>');	//調整
			
			print('<hr>');


		}else if( $yykkey_err_flg == 1 ){
			//複合エラー
		
			//画面編集
			//「アドレス確認エラーとなりました」
			print('<img src="./img_' . $lang_cd . '/title_adr_err.png" bordrr="0"><br>');

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
			print('<font size="2">');
			print('<br>');
			print('・事前に登録済みのメールアドレスで送信してください。<br>（未登録の場合は オフィスまでお問い合わせください）<br>');
			print('・自動的に 個別カウンセリングの予約ページのアドレスを<br>　送られてきたメールアドレス宛に返信します。<br>');
			print('（ info@jawhm.or.jp から送信しますので、<br>　メール受信ができるようメール受信設定をお願いします。）');
			print('</font>');
			print('</td>');
			print('</tr>');
			print('</table>');

			print('<hr>');

			
		}else if( $yykkey_err_flg == 2 ){
			//有効期限切れ
			
			//画面編集
			//「有効期限切れとなりました」
			print('<img src="./img_' . $lang_cd . '/title_yukoukigengire.png" bordrr="0"><br>');


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
			print('<font size="2">');
			print('<br>');
			print('・事前に登録済みのメールアドレスで送信してください。<br>（未登録の場合は オフィスまでお問い合わせください）<br>');
			print('・自動的に 個別カウンセリングの予約ページのアドレスを<br>　送られてきたメールアドレス宛に返信します。<br>');
			print('（ info@jawhm.or.jp から送信しますので、<br>　メール受信ができるようメール受信設定をお願いします。）');
			print('</font>');
			print('</td>');
			print('</tr>');
			print('</table>');

			print('<hr>');
			
			
		}else{
			//エラー（3お客様番号エラー　5:システムエラー）
			print('<font size="3" color="red">エラーが発生しました。<br>お手数ですが、オフィスまでお問い合わせください。</font>');
			
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';			//オフィスコード
			$log_kaiin_no = '';		//会員番号 または スタッフコード
			$log_naiyou = '個別カウンセリングのメニューにて、システムエラーが発生しました。<br>';	//内容
			$log_err_inf = 'yykkey_err_flg[' . $yykkey_err_flg . '] yykkey_ang_str[' . $yykkey_ang_str . ']';	//エラー情報
			require( './zy_log.php' );
			//************

		}
	}

	//画像事前読み込み
	print('<img src="./img_' . $lang_cd . '/btn_mini_change_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_mini_syousai_78x40_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_map_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_kbtcounseling_2.png" width="0" height="0" style="visibility:hidden;">');


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

