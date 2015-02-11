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
	$gmn_id = 'kbt_counseling_can2.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kbt_counseling_can1.php');
					
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
	$select_yyk_no = $_POST['select_yyk_no'];
	
	//ユーザーエージェントチェック
	require( './zy_uachk.php' );
	
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
			if ( $lang_cd == "" || $yykkey_ang_str == "" || $kaiin_id == "" || $kaiin_nm == "" || $kaiin_kbn == "" || $select_yyk_no == "" ){
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
		
		//予約内容を読み込む
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
			$log_naiyou = '予約内容の取り込みに失敗しました。';	//内容
			$log_err_inf = '予約番号[' . $select_yyk_no . ']';	//エラー情報
			require( './zy_log.php' );
			//************
			
		}else if( $zz_yykinfo_rtncd == 8 ){
			//予約が無い
			$err_flg = 5;

			//クラス予約キャンセルから最新内容を取得する
			$zz_yykinfo_yyk_no = $select_yyk_no;
			require( '../zz_yykinfo_kako.php' );
			if( $zz_yykinfo_rtncd == 1 ){
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zy_errgmn.php' );
						
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = 'クラス予約キャンセル内容の取り込みに失敗しました。';	//内容
				$log_err_inf = '予約番号[' . $select_yyk_no . ']';	//エラー情報
				require( './zy_log.php' );
				//************
			
			}
		}
		

		if( $err_flg == 0 ){
			//エラーなし

			//文字コード設定（insert/update時に必須）
			require( '../zz_mojicd.php' );

			//クラス予約キャンセルへ登録する
			$query = 'insert into D_CLASS_YYK_CAN values("' . $DEF_kg_cd . '","' . $zz_yykinfo_office_cd . '","' . $zz_yykinfo_class_cd . '","' . $zz_yykinfo_ymd . '","' . $zz_yykinfo_jkn_kbn . '",' . $select_yyk_no . ',' . $zz_yykinfo_kaiin_kbn . ',"' . $zz_yykinfo_kaiin_id . '",ENCODE("' . $zz_yykinfo_kaiin_nm . '","' . $ANGpw . '"),';
			if( $zz_yykinfo_kaiin_mixi == "" ){
				$query .= 'NULL,';
			}else{
				$query .= '"' . $zz_yykinfo_kaiin_mixi . '",';
			}
			if( $zz_yykinfo_staff_cd == "" ){
				$query .= 'NULL,';
			}else{
				$query .= '"' . $zz_yykinfo_staff_cd . '",';
			}
			$query .= '8,';
			if( $zz_yykinfo_kyoumi == "" ){
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE("' . $zz_yykinfo_kyoumi . '","' . $ANGpw . '"),';
			}
			if( $zz_yykinfo_jiki == "" ){
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE("' . $zz_yykinfo_jiki . '","' . $ANGpw . '"),';
			}
			if( $zz_yykinfo_soudan == "" ){
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE("' . $zz_yykinfo_soudan . '","' . $ANGpw . '"),';
			}
			if( $zz_yykinfo_bikou == "" ){
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE("' . $zz_yykinfo_bikou . '","' . $ANGpw . '"),';
			}
			$query .= $zz_yykinfo_znz_mail_send_flg . ',' . $zz_yykinfo_tjt_mail_send_flg . ',"' . $zz_yykinfo_yyk_time . '","' . $zz_yykinfo_cancel_time . '","' . $now_time . '",';
			if( $zz_yykinfo_yyk_staff_cd == "" ){
				$query .= 'NULL,';
			}else{
				$query .= '"' . $zz_yykinfo_yyk_staff_cd . '",';
			}
			$query .= 'NULL);';
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
				$log_naiyou = 'クラス予約キャンセルの登録に失敗しました。';	//内容
				$log_err_inf = $query;	//エラー情報
				require( './zy_log.php' );
				//************

			}else{

				//**トランザクション出力**
				$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
				$log_naiyou = 'クラス予約キャンセルを登録しました。';	//内容
				$log_err_inf = $query;	//エラー情報
				require( './zy_log.php' );
				//************
				
				//クラス予約を削除する
				$query = 'delete from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $zz_yykinfo_office_cd . '" and CLASS_CD = "' . $zz_yykinfo_class_cd . '" and YMD = "' . $zz_yykinfo_ymd . '" and JKN_KBN = "' . $zz_yykinfo_jkn_kbn . '" and YYK_NO = ' . $select_yyk_no . ';';
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
					$log_naiyou = 'クラス予約の削除に失敗しました。';	//内容
					$log_err_inf = $query;	//エラー情報
					require( './zy_log.php' );
					//************
	
				}else{

					//**トランザクション出力**
					$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = '';			//オフィスコード
					$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
					$log_naiyou = 'クラス予約を削除しました。（予約キャンセル）';	//内容
					$log_err_inf = $query;	//エラー情報
					require( './zy_log.php' );
					//************

					//googleカレンダーから削除する
					if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
						
						//個別カウンセリングの開始日時を編集  [YYYY-MM-DD HH:ii:SS]形式
						$yoyakudate = substr($zz_yykinfo_ymd,0,4) . '-' . sprintf("%02d",substr($zz_yykinfo_ymd,5,2)) . '-' . sprintf("%02d",substr($zz_yykinfo_ymd,8,2)) . ' ' . sprintf("%02d",intval($zz_yykinfo_st_time / 100)) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . ':00';

						// カレンダー削除
						$url = 'https://toratoracrm.com/crm/gc_yoyaku.php?pwd=303pittST&act=set';
						$data = array(
							'kbn'	=> 2,
							'id'	=> $zz_yykinfo_kaiin_id,
							'place' => $zz_yykinfo_office_nm,
							'yoyakudate' => $yoyakudate,
							'tantou' 	=> "",
							'yoyakumsg' => $zz_yykinfo_soudan,
							'namae1' 	=> $zz_yykinfo_kaiin_nm_1,
							'namae2' 	=> $zz_yykinfo_kaiin_nm_2,
							'firigana1' => $zz_yykinfo_kaiin_nm_k_1,
							'firigana2' => $zz_yykinfo_kaiin_nm_k_2,
							'tel'	=> "",
							'email' => ""
						);
			
						$options = array('http' => array(
										'method' => 'POST',
										'content' => http_build_query($data),
									));
						$contents = file_get_contents($url, false, stream_context_create($options));
						$ret = json_decode($contents, true);
						if ($ret['result'] == 'OK')	{
							//削除成功
							//なにもしない
						
						}else{
							//削除失敗
							$err_flg = 4;
							//エラーメッセージ表示
							require( './zy_errgmn.php' );
	
							//**ログ出力**
							$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
							$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
							$log_office_cd = '';			//オフィスコード
							$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
							$log_naiyou = 'googleカレンダーからの削除に失敗しました。RESULT[' . $ret['result'] . ']';	//内容
							$log_err_inf = '会場[' . $zz_yykinfo_office_nm . '] 予約日時[' . $yoyakudate . '] お客様番号[' . $zz_yykinfo_kaiin_id . ']';			//エラー情報
							require( './zy_log.php' );
							//************
							
						}
					}
				}
			}
		}


		//*** メール通知 ***
		$send_mail_flg = 0;			//メール送信フラグ  0:未送信 1:送信した
		$send_mail_adr_cnt = 0;	//送信対象メアド
		$ipn_kaiin_tel = "";		//会員電話番号
		$ipn_kaiin_tel_keitai = "";	//会員携帯電話

		if( $err_flg == 0 && ($zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9) ){
			
			
			//半角小文字を半角大文字に変換する
			$zz_yykinfo_kaiin_id = strtoupper( $zz_yykinfo_kaiin_id );	//小文字を大文字にする
				
			// ＣＲＭに転送
			$data = array(
				 'pwd' => '303pittST'
				,'serch_id' => $zz_yykinfo_kaiin_id
			);
			$url = 'https://toratoracrm.com/crm/CS_serch_id.php';
			$val = wbsRequest($url, $data);
			$ret = json_decode($val, true);
			if ($ret['result'] == 'OK')	{
				// OK
				$msg = $ret['msg'];
				$rtn_cd = $ret['rtn_cd'];
				$data_cnt = $ret['data_cnt'];
				if( $data_cnt > 0 ){
					$i = 0;
					while( $i < $data_cnt ){
						$name = "data_id_" . $i;
						$data_kaiin_no[$i] = $ret[$name];			//会員番号
						$name = "data_name_" . $i;
						$data_kaiin_nm[$i] = $ret[$name];			//会員名
						$name = "data_name_k_" . $i;
						$data_kaiin_nm_k[$i] = $ret[$name];			//会員名カナ
						$name = "data_mail_" . $i;
						$tmp_mail = $ret[$name];			//会員メールアドレス
						$tmp_mail = str_replace(',','<br>',$tmp_mail );
						
						//送信先メールアドレスを確定する
				
						//ログインキー発行に存在する場合はログインキー取得時のメアドのみとする
						$query = 'select DECODE(LOGIN_MAIL_ADR,"' . $ANGpw . '") from D_LOGIN_KEY where KG_CD = "' . $DEF_kg_cd . '" and LOGIN_KEY = "' . $yykkey_ang_str . '";';
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
							$log_naiyou = 'ログインキー発行の参照に失敗しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zy_log.php' );
							//************
							
						}else{
							while( $row = mysql_fetch_array($result) ){
								$send_kaiin_nm[0] = $data_kaiin_nm[$i];
								$send_mail_adr[0] = $row[0];
								$send_mail_adr_cnt++;
							}
		
							if( $send_mail_adr_cnt == 0 ){
								//無かった（ログイン画面から予約した場合）
						
								$tmp_mail_len = strlen($tmp_mail);
								while( $tmp_mail_len > 0 ){
									$tmp_mail_pos = strpos($tmp_mail,"<br>");
									if( $tmp_mail_pos === false ){
										//見つからなかった
										//メアドの整合性チェック
										$chk_mailadr_flg = 0;
										if( strlen( $tmp_mail ) != mb_strlen( $tmp_mail ) ){
											//全角が含まれている
											$chk_mailadr_flg = 1;
										}else if( !preg_match('/^[-+.\\w]+@[-a-z0-9]+(\\.[-a-z0-9]+)*\\.[a-z]{2,6}$/i', $tmp_mail) ){
											//メールアドレスとしてふさわしくない
											$chk_mailadr_flg = 2;
										}
								
										if( $chk_mailadr_flg == 0 ){
											//メアドチェックＯＫ なので 送信対象とする
											$send_kaiin_nm[$send_mail_adr_cnt] = $data_kaiin_nm[$i];
											$send_mail_adr[$send_mail_adr_cnt] = $tmp_mail;
											$send_mail_adr_cnt++;
									
										}else{
												
											//**ログ出力**
											$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
											$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
											$log_office_cd = '';			//オフィスコード
											$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
											$log_naiyou = 'メールアドレスとしてＮＧなので送信対象外としました。<br>会員[' . $select_kaiin_no . '] メアド[' . $tmp_member_mail_adr . ']';	//内容
											$log_err_inf = '';				//エラー情報
											require( './zy_log.php' );
											//************
		
										}
										
										$tmp_mail_len = 0;
									
									}else{
										//見つかった
										//メアドの整合性チェック
										$chk_mailadr = substr($tmp_mail,0,$tmp_mail_pos);
										$chk_mailadr_flg = 0;
										if( strlen( $chk_mailadr ) != mb_strlen( $chk_mailadr ) ){
											//全角が含まれている
											$chk_mailadr_flg = 1;
										}else if( !preg_match('/^[-+.\\w]+@[-a-z0-9]+(\\.[-a-z0-9]+)*\\.[a-z]{2,6}$/i', $chk_mailadr) ){
											//メールアドレスとしてふさわしくない
											$chk_mailadr_flg = 2;
										}
										
										if( $chk_mailadr_flg == 0 ){
											//メアドチェックＯＫ なので 送信対象とする
											$send_kaiin_nm[$send_mail_adr_cnt] = $data_kaiin_nm[$i];
											$send_mail_adr[$send_mail_adr_cnt] = substr($tmp_mail,0,$tmp_mail_pos);
											$send_mail_adr_cnt++;
										
										}else{
											
											//**ログ出力**
											$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
											$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
											$log_office_cd = '';			//オフィスコード
											$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
											$log_naiyou = 'メールアドレスとしてＮＧなので送信対象外としました。<br>会員[' . $select_kaiin_no . '] メアド[' . $chk_mailadr . ']';	//内容
											$log_err_inf = '';			//エラー情報
											require( './zy_log.php' );
											//************
											
										}
											
										$tmp_mail = substr($tmp_mail,($tmp_mail_pos + 4),($tmp_mail_len - ($tmp_mail_pos + 4)));
										$tmp_mail_len = strlen($tmp_mail);
										
									}
								}
							}
						}
						
						$i++;
					}
				}
					
//##############################################################
//開発テスト時はお客様へメールせず、設定されたメアドに変更する
				if( $SVkankyo == 9 ){
					$send_mail_adr_cnt = $sv_test_cs_mailadr_cnt;
					$m = 0;
					while( $m < $send_mail_adr_cnt ){
						$send_mail_adr[$m] = $sv_test_cs_mailadr[$m];
						$m++;
					}
				}
//##############################################################

			}

			//メアドがあり、処理時点以降の時間帯であればメール送信する
			$tmp_zz_yykinfo_ymd = substr($zz_yykinfo_ymd,0,4) . sprintf("%02d",substr($zz_yykinfo_ymd,5,2)) . sprintf("%02d",substr($zz_yykinfo_ymd,8,2));
			if( $send_mail_adr_cnt > 0 && ($tmp_zz_yykinfo_ymd > $now_yyyymmdd || ( $tmp_zz_yykinfo_ymd == $now_yyyymmdd && $zz_yykinfo_st_time >= ($now_hh * 100 + $now_ii) )) ){

				//管理情報から略称を求める
				$Mkanri_meishou = '';
				$Mkanri_ryakushou = '';
				$Mkanri_hp_adr = '';
				$query = 'select MEISHOU,RYAKUSHOU,DECODE(HP_ADR,"' . $ANGpw . '"),DECODE(SEND_MAIL_ADR,"' . $ANGpw . '") from M_KANRI_INFO where KG_CD = "' . $DEF_kg_cd . '" order by IDX desc LIMIT 1;';
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
					$log_naiyou = '管理情報の参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zy_log.php' );
					//************
					
				}else{
					$row = mysql_fetch_array($result);
					$Mkanri_meishou = $row[0];			//名称
					$Mkanri_ryakushou = $row[1];		//略称
					$Mkanri_hp_adr = $row[2];			//ホームページアドレス
					$Mkanri_send_mail_adr = $row[3];	//送信メールアドレス
				}
				

				//電話番号を判定する（携帯電話優先）･･･一般（非メンバー）のみ
				$yusen_tel = "";
				if( $zz_yykinfo_kaiin_kbn == 9 ){
					 $yusen_tel = $ipn_kaiin_tel_keitai;
					if( $yusen_tel == '' ){
						$yusen_tel = $ipn_kaiin_tel;
					}
				}
				
				
				// 登録完了メールを送信
				
				$m = 0;
				while( $m < $send_mail_adr_cnt ){
			
					//登録完了メール送信
					//送信元
					$from_nm = $Mkanri_meishou;
					$from_mail = $Mkanri_send_mail_adr;
					//宛て先
					$to_nm = $send_kaiin_nm[$m] . ' 様';
					
					//メールアドレス
					$to_mail = $send_mail_adr[$m];
				
					//タイトル
					if( $Mkanri_ryakushou != '' ){
						$subject = '(' . $Mkanri_ryakushou . ')';
					}else{
						$subject = '';	
					}
					$subject .= '個別カウンセリングの予約を取消しました';
			
					// 本文
					$content = $send_kaiin_nm[$m] . " 様\n\n";
					$content .= $Mkanri_meishou . "です。\n";
					$content .= "当協会の個別カウンセリングの予約を\n";
					$content .= "取消しましたのでお知らせします。\n\n";
					$content .= "---------------\n";
					$content .= "▼取消した予約内容\n";
					$content .= "---------------\n";
					$content .= "個別カウンセリング\n\n";
					$content .= "予約No: " . sprintf("%05d",$select_yyk_no) . "\n";
					$content .= "会場: " . $zz_yykinfo_office_nm . "\n";
					$content .= "日付: " . substr($zz_yykinfo_ymd,0,4) . "年" . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . "月" . sprintf("%d",substr($zz_yykinfo_ymd,8,2)) . "日(" . $week[$zz_yykinfo_youbi_cd] . ")\n";
					$content .= "時間: " . intval($zz_yykinfo_st_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . " - " . intval($zz_yykinfo_ed_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) ."\n";
					$content .= "※予約取消しました。\n\n";
					$content .= "---------------\n";
					$content .= $Mkanri_meishou . "\n";
					$content .= $Mkanri_hp_adr . "\n";
					$content .= "メール: " . $Mkanri_send_mail_adr . "\n";
					if( $Moffice_bikou != '' ){
						$content .=  $Moffice_bikou . "\n";
					}
					$content .= "---------------\n";
						
					   
					//メール送信
					mb_language("Ja");				//使用言語：Ja
					mb_internal_encoding("utf-8");	//文字コード：UTF-8
					$frname0 = mb_encode_mimeheader($from_nm);
					$toname0 = mb_encode_mimeheader($to_nm);
					$sdmail0 = "$toname0 <$to_mail>";
					$mailhead = "From:\"$frname0\" <$from_mail>\n";
					if( $sv_bcc_mailadr != "" ){
						$mailhead .= "Bcc: $sv_bcc_mailadr";
					}
					$result = mb_send_mail( $sdmail0, $subject, $content, $mailhead );
				
					$m++;

					$send_mail_flg = 1;

				}
			}
		}


		if( $err_flg == 0 ){

			//**ログ出力**
			$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'K';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';			//オフィスコード
			$log_kaiin_no = $kaiin_id;		//会員番号 または スタッフコード
			$log_naiyou = '個別カウンセリング予約をキャンセルしました。<br>予約No[' . sprintf("%05d",$select_yyk_no) . '] 会場[' . $zz_yykinfo_office_nm . '] 日時[' . $zz_yykinfo_ymd . ' ' . intval($zz_yykinfo_st_time / 100 ) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . "-" . intval($zz_yykinfo_ed_time / 100 ) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) . ']<br>お客様番号[' . $zz_yykinfo_kaiin_id . ']';	//内容
			$log_err_inf = 'mb[' . $mobile_kbn . '] ua[' . $agent1 . '] ip[' . $ip_adr . ']';	//エラー情報
			require( './zy_log.php' );
			//************

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

			print('<table border="0">');	//main
			print('<tr>');	//main
			print('<td width="700" align="center">');	//main
			
			//「以下の予約を取消しました。」
			print('<img src="./img_' . $lang_cd . '/title_cancel_ok.png" border="0"><br>');			

			print('<table border="1" bordercolor="black">');
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
			print('<td colspan="3" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_lightgrey_565x20.png"><font color="gray" size="5">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
			print('</tr>');
			print('<tr>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
			print('<td width="228" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_235x20.png"><font size="5" color="gray">' . $zz_yykinfo_office_nm . '</font></td>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor.png" border="0"></td>');
			print('<td width="227" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_235x20.png"><font color="gray">');
			if( $zz_yykinfo_staff_cd != "" ){
				print( $zz_yykinfo_open_staff_nm );
			}else{
				print('(指名なし)');
			}
			print('</font></td>');
			print('</tr>');
			
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
			$fontcolor = "gray";
			print('<td colspan="3" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_lightgrey_565x20.png">&nbsp;&nbsp;<font size="5" color="' . $fontcolor . '">' . substr($zz_yykinfo_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,8,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$zz_yykinfo_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="5" color="gray">' . intval($zz_yykinfo_st_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . '&nbsp;-&nbsp;' . intval($zz_yykinfo_ed_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) . '</font></td>');
			print('</tr>');
			//興味のある国
//			print('<tr>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kyoumi.png" border="0"></td>');
//			print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_565x20.png">');
//			print('<font color="gray">&nbsp;&nbsp;' . $zz_yykinfo_kyoumi . '</font>');
//			print('</td>');
//			print('</tr>');
			//出発予定時期
//			print('<tr>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_jiki.png" border="0"></td>');
//			print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_565x20.png">');
//			print('<font color="gray">&nbsp;&nbsp;' . $zz_yykinfo_jiki . '</font>');
//			print('</td>');
//			print('</tr>');
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_soudannaiyou.png" border="0"></td>');
			print('<td colspan="3" align="left" valign="top" background="../img_' . $lang_cd . '/bg_lightgrey_565x20.png">');
			print('<font color="gray"><div style="margin: 10px"><pre>' . $zz_yykinfo_soudan . '</pre></div></font>');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			print('</td>');	//main
			print('</tr>');	//main
			print('</table>');	//main
			
			print('<hr>');

			print('<table border="0">');
			print('<tr>');
			print('<td width="565">&nbsp;</td>');
			//戻るボタン
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_menu.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
			print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
			print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="135" align="right" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
			
			
		}else if( $err_flg == 5 ){
			//予約が無くなった
			//（Ｆ５キーやボタン連打時を想定）
			
			//戻るボタン
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

			print('<table border="0">');	//main
			print('<tr>');	//main
			print('<td width="700" align="center">');	//main
			
			//「以下の予約を取消しました。」
			print('<img src="./img_' . $lang_cd . '/title_cancel_ok.png" border="0"><br>');			

			print('<table border="1" bordercolor="black">');
			print('<tr>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
			print('<td width="565" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_lightgrey_565x20.png"><font color="gray" size="5">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
			print('</tr>');
			print('<tr>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
			print('<td width="565" align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_lightgrey_565x20.png"><font size="5" color="gray">' . $zz_yykinfo_office_nm . '</font></td>');
			print('</tr>');
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
			$fontcolor = "gray";
			print('<td align="center" valign="bottom" background="../img_' . $lang_cd . '/bg_lightgrey_565x20.png">&nbsp;&nbsp;<font size="5" color="' . $fontcolor . '">' . substr($zz_yykinfo_ymd,0,4) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;年</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;月</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,8,2)) . '</font><font size="1" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$zz_yykinfo_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="5" color="gray">' . intval($zz_yykinfo_st_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_st_time % 100)) . '&nbsp;-&nbsp;' . intval($zz_yykinfo_ed_time / 100) . ':' . sprintf("%02d",($zz_yykinfo_ed_time % 100)) . '</font></td>');
			print('</tr>');
			//興味のある国
//			print('<tr>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kyoumi.png" border="0"></td>');
//			print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_565x20.png">');
//			print('<font color="gray">&nbsp;&nbsp;' . $zz_yykinfo_kyoumi . '</font>');
//			print('</td>');
//			print('</tr>');
			//出発予定時期
//			print('<tr>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_jiki.png" border="0"></td>');
//			print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_565x20.png">');
//			print('<font color="gray">&nbsp;&nbsp;' . $zz_yykinfo_jiki . '</font>');
//			print('</td>');
//			print('</tr>');
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_soudannaiyou.png" border="0"></td>');
			print('<td align="left" valign="top" background="../img_' . $lang_cd . '/bg_lightgrey_565x20.png">');
			print('<font color="gray"><div style="margin: 10px"><pre>' . $zz_yykinfo_soudan . '</pre></div></font>');
			print('</td>');
			print('</tr>');
			print('</table>');
			
			print('</td>');	//main
			print('</tr>');	//main
			print('</table>');	//main
			
			print('<hr>');

			print('<table border="0">');
			print('<tr>');
			print('<td width="565">&nbsp;</td>');
			//戻るボタン
			print('<form method="post" action="' . $sv_https_adr . 'yoyaku/kbt_counseling_menu.php#kbtcounseling">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
			print('<input type="hidden" name="yykkey_ang_str" value="' . $yykkey_ang_str . '">');
			print('<input type="hidden" name="kaiin_id" value="' . $kaiin_id . '">');
			print('<input type="hidden" name="kaiin_nm" value="' . $kaiin_nm . '">');
			print('<input type="hidden" name="kaiin_kbn" value="' . $kaiin_kbn . '">');
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="135" align="right" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');

		}
	}

	//画像事前読み込み
	print('<img src="./img_' . $lang_cd . '/btn_menu_2.png" width="0" height="0" style="visibility:hidden;">');
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

