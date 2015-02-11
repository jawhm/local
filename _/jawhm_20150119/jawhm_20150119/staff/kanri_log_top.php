<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－ログ参照</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
<style type="text/css">
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
}
option.color0 {
	color:#696969;
}
option.color1 {
	color:#0000ff;
}
option.color2 {
	color:#ff0000;
}
</style>
<SCRIPT type="text/javascript" language="JavaScript"> 
<!--
function winclose(){
	//「閉じようとしています」を表示させないため（２行追加）
　　var w=window.open("","_top");
　　w.opener=window;

	window.close(); // サブウィンドウを閉じる
}
//ローディングくるくる
function kurukuru(){
	jQuery(function($){
		$.fixedActivity(true)
	});
//	jQuery(function($){
//		$.fixedActivity(false)
//	});
}
jQuery(function($){
	$.fixedActivity = function(show){
		var o = $.fixedActivity;
		var body = $('body'),win = $(window);

		//ローディング中画面を透過にさせるラッパー要素
		if(!o.pageWrapper){
			o.pageWrapper = body.wrapInner('<div/>').find('> div').eq(0);
		}

		//アイコン表示
		body.activity(show);

		//表示位置を画面中央に設定
		if(show){
			//IE8以下だとshape、モダンブラウザだとdivになる
			var icon = body.find('> *').eq(0);
			icon.css({
				margin :0,
				position:'fixed',
				top:(win.height() - icon.height()) / 2,
				left:(win.width() - icon.width()) / 2
			});
		}

		//画面透過の切り替え
		o.pageWrapper.css({opacity: show ? .3 : 1});
	}
});
// -->
</script>
</head>
<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'kanri_log_top.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_top.php','kanri_log_top.php');

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

	$tabindex = 0;	//タブインデックス

	//日付関係
	require( '../zz_datetime.php' );

	//祝日情報
	require_once('../jp-holiday.php');

	if( $now_youbi == 0 || $dt->is_jp_holiday == true ){
		//日曜・祝日
		$zs_youbi_color = 'red';
	}else if( $now_youbi == 6 ){
		//土曜
		$zs_youbi_color = 'blue';
	}else{
		//平日
		$zs_youbi_color = 'black';
	}

	mb_language("Ja");
	mb_internal_encoding("utf-8");

	//***コーディングはここから**********************************************************************************

	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = $_POST['lang_cd'];
	$office_cd = $_POST['office_cd'];
	$staff_cd = $_POST['staff_cd'];
	
	//サーバー接続
	require( './zs_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}else{
		//画面ＩＤのチェック
		if( !in_array($prc_gmn , $ok_gmn) ){
			$err_flg = 2;
		}else{
			//引数入力チェック
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" ){
				$err_flg = 3;
			}else{
				//メンテナンス期間チェック
				require( './zs_mntchk.php' );
		
				if( $mntchk_flg == 1 || $mntchk_flg == 2 ){
					$err_flg = 80;	//メンテナンス中
				
				}else{
					//ログインチェック
					require( './zs_staff_loginchk.php' );	
					if ($LC_rtncd == 1){
						$err_flg = 9;
					}
				}
			}
		}
	}


	//エラー発生時
	if( $err_flg != 0 ){
		//エラー画面編集
		require( './zs_errgmn.php' );

	//エラーなし
	}else{

		//店舗メニューボタン表示
		require( './zs_menu_button.php' );

		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_kensaku_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_back50_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_next50_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="../img_' . $lang_cd . '/btn_hyouji_50x50_2.png" width="0" height="0" style="visibility:hidden;">');


		//ページ編集
		//*****入力されたデータを受け取る*****
		//日時
		$st_yyyy = $_POST['st_yyyy'];
		$st_mm = $_POST['st_mm'];
		$st_dd = $_POST['st_dd'];
		$st_time = $_POST['st_time'];
		$ed_yyyy = $_POST['ed_yyyy'];
		$ed_mm = $_POST['ed_mm'];
		$ed_dd = $_POST['ed_dd'];
		$ed_time = $_POST['ed_time'];
		
		//会員番号
		$select_kaiin_no = $_POST['select_kaiin_no'];
		
		//種別
		$select_log_sbt = $_POST['select_log_sbt'];
			
		//店舗区分
		$select_log_kkstaff_kbn = $_POST['select_log_kkstaff_kbn'];
			
		//*****表示件数*****
		$old_button = $_POST['old_button'];
		$next_button = $_POST['next_button'];
			
		$st_kensu = $_POST['st_kensu'];
		$ed_kensu = $_POST['ed_kensu'];
			
		//表示件数移動ボタンが押下された場合＋－５０件
		if( $next_button ){
			$st_kensu = $st_kensu + 50;
			$ed_kensu = $ed_kensu + 50;
		}else{	
			if( $old_button ){
				$st_kensu = $st_kensu - 50;
				$ed_kensu = $ed_kensu - 50;
			}else{
				//デフォルトは１～５０件
				$st_kensu = 0;
				$ed_kensu = 50;
			}
		}
		$h_st_kensu = $st_kensu + 1;

		//日時が入力されていなかったら値を与える　開始月は現在時刻－１　時間は現在時刻＋１
		if($st_yyyy == ''){
			$st_yyyy = $now_yyyy;
		}
		if($st_mm == ''){
			$st_mm = $now_mm;
		}
		if($st_dd == ''){
			$st_dd = $now_dd;
		}
		if($st_time == ''){
			$st_time = $now_hh;
		}
		if($ed_yyyy == ''){
			$ed_yyyy = $now_yyyy;
		}
		if($ed_mm == ''){
			$ed_mm = $now_mm;
		}
		if($ed_dd == ''){
			$ed_dd = $now_dd;
		}
		if($ed_time == ''){
			$ed_time = $now_hh + 1;
			if( $ed_time >= 24 ){
				$ed_time = 23;
			}
		}
		
		//選択されたラジオボタン
		$radio = $_POST['radio'];


		//ページ編集
		print('<center>');

		print('<table bgcolor="pink"><tr><td width="950">');
		print('<img src="./img_' . $lang_cd . '/bar_kanri_log.png" border="0">');
		print('</td></tr></table>');

		print('<table border="0">');
		print('<tr>');
		print('<td width="815" align="center"><font color="blue">※検索条件を選んで、検索ボタンを押下してください。</font></td>');
		print('<form method="post" action="kanri_top.php">');
		print('<td align="right">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');

		print('<form action="./kanri_log_top.php" method="POST">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');


		//*****ラジオボタン*****
		print('<table border="1">');
		print('<tr>');
		//最新５０件
		print('<td width="350" align="left" ');
		if( $radio == 1 or $radio == '' ){
			  print('background="../img_' . $lang_cd . '/bg_blue_350x20.png">');
		}else{
			  print('background="../img_' . $lang_cd . '/bg_yellow_350x20.png">');
			
		}
		if( $radio == 1 or $radio == '' ){
			print('<input type="radio" name="radio" tabindex="' . ($tabindex + 1) . '" value="1" checked>ログ時間順（最新５０件より表示）');
		}else{
			print('<input type="radio" name="radio" tabindex="' . ($tabindex + 1) . '" value="1">ログ時間順（最新５０件より表示）');
		}
		print('</td>');
			
		//会員番号・スタッフコード
		print('<td width="350" align="left" ');
		if( $radio == 2 ){
			  print('background="../img_' . $lang_cd . '/bg_blue_350x20.png">');
		}else{
			  print('background="../img_' . $lang_cd . '/bg_yellow_350x20.png">');
			
		}
		if( $radio == 2 ){
			print('<input type="radio" name="radio" tabindex="' . ($tabindex + 2) . '" value="2" checked>会員番号&nbsp;&nbsp;');
		}else{
			print('<input type="radio" name="radio" tabindex="' . ($tabindex + 2) . '" value="2">会員番号&nbsp;&nbsp;');
		}
		print('<input type="text" name="select_kaiin_no" maxlength="20" size="15" value="' . $select_kaiin_no . '" class="normal" tabindex="' . ($tabindex + 3) . '" style="ime-mode:disabled;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
		print('</td>');
			
		//検索ボタン
		print('<td width="135" rowspan="3" align="center" valign="middle" bgcolor="pink">');
		print('<input type="image" tabindex="' . ($tabindex + 17) . '" src="./img_' . $lang_cd . '/btn_kensaku_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kensaku_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kensaku_1.png\';" onClick="kurukuru()" border="0">');
		print('</td>');
			
		print('</tr>');
		print('<tr>');
			
		//ログ種別
		print('<td align="left" ');
		if( $radio == 4 ){
			print('background="../img_' . $lang_cd . '/bg_blue_350x20.png">');
			print('<input type="radio" name="radio" tabindex="' . ($tabindex + 4) . '" value="4" checked>ログ種別&nbsp;&nbsp;');
		}else{
			print('background="../img_' . $lang_cd . '/bg_yellow_350x20.png">');
			print('<input type="radio" name="radio" tabindex="' . ($tabindex + 4) . '" value="4" >ログ種別&nbsp;&nbsp;');
		}
		print('<select name="select_log_sbt" class="normal" tabindex="' . ($tabindex + 5) . '">');
		if( $select_log_sbt == 'N' || $select_log_sbt == '' ){
			print('<option value="N" class="color1" selected>通常　　</option>');
		}else{
			print('<option value="N" class="color1" >通常　　</option>');
		}
		if( $select_log_sbt == 'E'){
			print('<option value="E" class="color2" selected>エラー　　</option>');
		}else{
			print('<option value="E" class="color2">エラー　　</option>');
		}
		if( $select_log_sbt == 'W'){
			print('<option value="W" class="color2" selected>警告　　</option>');
		}else{
			print('<option value="W" class="color2">警告　　</option>');
		}
		print('</select>');
		print('</td>');
			
		//顧客スタッフ区分
		print('<td align="left" ');
		if( $radio == 7 ){
			print('background="../img_' . $lang_cd . '/bg_blue_350x20.png">');
			print('<input type="radio" name="radio" tabindex="' . ($tabindex + 6) . '" value="7" checked>会員またはスタッフ&nbsp;&nbsp;');
		}else{
			print('background="../img_' . $lang_cd . '/bg_yellow_350x20.png">');
			print('<input type="radio" name="radio" tabindex="' . ($tabindex + 6) . '" value="7">会員またはスタッフ&nbsp;&nbsp;');
		}
		print('<select name="select_log_kkstaff_kbn" class="normal" tabindex="' . ($tabindex + 7) . '">');
		if( $select_log_kkstaff_kbn == 'K' || $select_log_kkstaff_kbn == '' ){
			print('<option value="K" class="color1" selected>会員入力　</option>');
		}else{
			print('<option value="K" class="color1">会員入力　</option>');
		}
		if( $select_log_kkstaff_kbn == 'T' ){
			print('<option value="S" class="color2" selected>スタッフ　</option>');
		}else{
			print('<option value="S" class="color2">スタッフ　</option>');
		}
		print('</select>');
		print('</td>');
		print('</tr>');
		
		print('<tr>');
		//日時指定
		print('<td colspan="2" align="left" ');
		if( $radio == 5 ){
			print('background="../img_' . $lang_cd . '/bg_blue_700x20.png">');
			print('<input type="radio" name="radio" tabindex="' . ($tabindex + 8) . '" value="5" checked>日時指定&nbsp;&nbsp;');
		}else{
			print('background="../img_' . $lang_cd . '/bg_yellow_700x20.png">');
			print('<input type="radio" name="radio" tabindex="' . ($tabindex + 8) . '" value="5">日時指定&nbsp;&nbsp;');
		}
		print('<select name="st_yyyy" class="normal" tabindex="' . ($tabindex + 9) . '">');
		$i = 2011;
		while( $i < 2038 ){
			print('<option value="' . $i . '" ');
			if( $i == $st_yyyy ){
				print('selected');
			}
			print('>' . $i. '</option>');
			$i++;
		}
		print('</select>');
		print('<font size="1">年</font>');
		print('<select name="st_mm" class="normal" tabindex="' . ($tabindex + 10) . '">');
		$i = 1;
		while( $i < 13 ){
			print('<option value="' . $i . '" ');
			if( $i == $st_mm ){
				print('selected');
			}
			print('>' . $i. '</option>');
			$i++;
		}
		print('</select>');
		print('<font size="1">月</font>');
		print('<select name="st_dd" class="normal" tabindex="' . ($tabindex + 11) . '">');
		$i = 1;
		while( $i < 32 ){
			print('<option value="' . $i . '" ');
			if( $i == $st_dd ){
				print('selected');
			}
			print('>' . $i. '</option>');
		
			$i++;
		}
		print('</select>');
		print('<font size="1">日</font>');
		print('<select name="st_time" class="normal" tabindex="' . ($tabindex + 12) . '">');
		$i = 0;
		while( $i < 24 ){
			print('<option value="' . $i . '" ');
			if( $i == $st_time ){
				print('selected');
			}
			print('>' . $i. '</option>');
		
			$i++;
		}
		print('</select>');
		print('<font size="1">時から</font>&nbsp;&nbsp;');
		print('<select name="ed_yyyy" class="normal" tabindex="' . ($tabindex + 13) . '">');
		$i = 2011;
		while( $i < 2038 ){
			print('<option value="' . $i . '" ');
			if( $i == $ed_yyyy ){
				print('selected');
			}
			print('>' . $i. '</option>');
			$i++;
		}
		print('</select>');
		print('<font size="1">年</font>');
		print('<select name="ed_mm" class="normal" tabindex="' . ($tabindex + 14) . '">');
		$i = 1;
		while( $i < 13 ){
			print('<option value="' . $i . '" ');
			if( $i == $ed_mm ){
				print('selected');
			}
			print('>' . $i. '</option>');
			$i++;
		}
		print('</select>');
		print('<font size="1">月</font>');
		print('<select name="ed_dd" class="normal" tabindex="' . ($tabindex + 15) . '">');
		$i = 1;
		while( $i < 32 ){
			print('<option value="' . $i . '" ');
			if( $i == $ed_dd ){
				print('selected');
			}
			print('>' . $i. '</option>');
		
			$i++;
		}
		print('</select>');
		print('<font size="1">日</font>');
		print('<select name="ed_time" class="normal" tabindex="' . ($tabindex + 16) . '">');
		$i = 0;
		while( $i < 24 ){
			print('<option value="' . $i . '" ');
			if( $i == $ed_time ){
				print('selected');
			}
			print('>' . $i. '</option>');
		
			$i++;
		}
		print('</select>');
		print('<font size="1">時まで</font>');
		print('</td>');
			
		print('</tr>');
		print('</table>');
		print('</form>');

		print('<hr>');

		$tabindex += 17;	//調整

		//*****選択されたラジオボタンによってコメントとセレクト文変更*****
		$serch_title = "";
		switch( $radio ){
			//最新50件
			case 1:
				$serch_title = '<font size="5"><strong>ログ時間順&nbsp;で表示中</strong></font>';
				$query = 'select LOG_TIME,LOG_SBT,KKSTAFF_KBN,OFFICE_CD,KAIIN_NO,GMN_ID,DECODE(NAIYOU,"' . $ANGpw . '"),DECODE(ERR_INF,"' . $ANGpw . '") ' .
						 'from D_LOG where KG_CD = "' . $DEF_kg_cd . '" order by LOG_TIME desc LIMIT ' . $st_kensu . ',50;';
				break;
			//番号
			case 2:
				print('<font size="5"><strong>会員番号:「' . $select_kaiin_no . '」&nbsp;で表示中</strong></font>');
				$query = 'select LOG_TIME,LOG_SBT,KKSTAFF_KBN,OFFICE_CD,KAIIN_NO,GMN_ID,DECODE(NAIYOU,"' . $ANGpw . '"),DECODE(ERR_INF,"' . $ANGpw . '") ' . 
						 'from D_LOG where KG_CD = "' . $DEF_kg_cd . '" and KAIIN_NO = "' . $select_kaiin_no . '" order by LOG_TIME desc LIMIT ' . $st_kensu . ',50;';
				break;
			//画面名
			case 3:
//				print('<font size="5"><strong>画面名: '.$gmn_id.'</strong></font>');
//				$query = "select  LOG_TIME,LOG_SBT,KKSTAFF_KBN,OFFICE_CD,KAIIN_NO,GMN_ID,DECODE(NAIYOU,'".$ANGpw."'),DECODE(ERR_INF,'".$ANGpw."')"."
//				 			FROM D_LOG where KG_CD = "' . $DEF_kg_cd . '" and GMN_ID LIKE '%".$gmn_id."%' order by LOG_TIME desc LIMIT ".$st_kensu.",50;";
				break;
			//ログ種別
			case 4:
				if( $select_log_sbt == 'N' ){
					$serch_title = '<font size="5"><strong>ログ種別:&nbsp;「通常」で表示中</strong></font>';
				}else if( $select_log_sbt == 'E' ){
					$serch_title = '<font size="5"><strong>ログ種別:&nbsp;「エラー」で表示中</strong></font>';
				}else if( $select_log_sbt == 'W' ){
					$serch_title = '<font size="5"><strong>ログ種別:&nbsp;「警告」で表示中</strong></font>';
				}else{
					$serch_title = '<font size="5"><strong>ログ種別:&nbsp;（未定義）</strong></font>';
				}
				$query = 'select LOG_TIME,LOG_SBT,KKSTAFF_KBN,OFFICE_CD,KAIIN_NO,GMN_ID,DECODE(NAIYOU,"' . $ANGpw . '"),DECODE(ERR_INF,"' . $ANGpw . '") ' .
						 'from D_LOG where KG_CD = "' . $DEF_kg_cd . '" and LOG_SBT = "'. $select_log_sbt . '" order by LOG_TIME desc LIMIT ' . $st_kensu . ',50;';
				break;
			//店舗コード
			case 6:
//				print('<font size="5"><strong>店舗コード: '.$log_office_code.'</strong></font>');
//				$query = "select LOG_TIME,LOG_SBT,KKSTAFF_KBN,OFFICE_CD,KAIIN_NO,GMN_ID,DECODE(NAIYOU,'".$ANGpw."'),DECODE(ERR_INF,'".$ANGpw."')"."
//				 			FROM D_LOG where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = '".$log_office_code."' order by LOG_TIME desc LIMIT ".$st_kensu.",50;";
				break;
			//顧客スタッフ区分
			case 7:
				if( $select_log_kkstaff_kbn == 'S' ){
					$serch_title = '<font size="5"><strong>会員入力またはスタッフ入力:&nbsp;「スタッフ入力」で表示中</strong></font>';
				}else if( $select_log_kkstaff_kbn == 'K' ){
					$serch_title = '<font size="5"><strong>会員入力またはスタッフ入力:&nbsp;「会員入力」で表示中</strong></font>';
				}else{
					$serch_title = '<font size="5"><strong>会員入力またはスタッフ入力:&nbsp;（未定義）</strong></font>';
					
				}
				$query = 'select LOG_TIME,LOG_SBT,KKSTAFF_KBN,OFFICE_CD,KAIIN_NO,GMN_ID,DECODE(NAIYOU,"' . $ANGpw . '"),DECODE(ERR_INF,"' . $ANGpw . '") ' .
						 'from D_LOG where KG_CD = "' . $DEF_kg_cd . '" and KKSTAFF_KBN = "' . $select_log_kkstaff_kbn . '" order by LOG_TIME desc LIMIT ' . $st_kensu . ',50;';
				break;
			//日時
			case 5:
				//半角数字・指定の文字数で入力されているか調べる
				$err = 0;
				if(!ereg("[0-9]{4}",$st_yyyy)){	
					$err++;
				}
				if(!ereg("[1-9]",$st_mm) or $st_mm < 1 or $st_mm > 12){
					$err++;
				}
				if(!ereg("[1-9]",$st_dd) or $st_dd < 1 or $st_dd > 31){
					$err++;
				}
				if(!ereg("[1-9]",$st_time) or $st_time < 1 or $st_time > 24){
					$err++;
				}
				if(!ereg("[0-9]{4}",$ed_yyyy)){
					$err++;
				}
				if(!ereg("[1-9]",$ed_mm) or $ed_mm < 1 or $ed_mm > 12){
					$err++;
				}
				if(!ereg("[1-9]",$ed_dd) or $ed_dd < 1 or $ed_dd > 31){
					$err++;
				}
				if(!ereg("[1-9]",$ed_time) or $ed_time < 1 or $ed_time > 24){
					$err++;
				}
				//年月日時と合わせる
				$st_ymdt = $st_yyyy.sprintf("%02d",$st_mm).sprintf("%02d",$st_dd).sprintf("%02d",$st_time).'00000000';
				$ed_ymdt = $ed_yyyy.sprintf("%02d",$ed_mm).sprintf("%02d",$ed_dd).sprintf("%02d",$ed_time).'00000000';
					
				//開始日時の方が遅い場合はエラー
				if($st_ymdt >= $ed_ymdt){
					$err++;
				}
					
				if( $err > 0 ){
					//エラーがあった場合コメント出力し、最新50件表示
					print('<font color="red">※日時指定に不正な値が入力されています。<br>　半角数字で年は４桁で入力してください。<br></font>');
					$query = 'select  LOG_TIME,LOG_SBT,KKSTAFF_KBN,OFFICE_CD,KAIIN_NO,GMN_ID,DECODE(NAIYOU,"' . $ANGpw . '"),DECODE(ERR_INF,"' . $ANGpw . '")' .
							 'from D_LOG where KG_CD = "' . $DEF_kg_cd . '" order by LOG_TIME desc LIMIT ' . $st_kensu . ',50;';
				}else{
					//エラーがない場合
					$serch_title = '<strong>日時指定:&nbsp;' . $st_yyyy . '年' . sprintf("%01d",$st_mm) . '月' . sprintf("%01d",$st_dd) . '日' . sprintf("%01d",$st_time) . '時 ～' . $ed_yyyy . '年' . sprintf("%01d",$ed_mm) . '月' . sprintf("%01d",$ed_dd) . '日' . sprintf("%01d",$ed_time) .'時&nbsp;で表示中</strong>';
					$query = 'select LOG_TIME,LOG_SBT,KKSTAFF_KBN,OFFICE_CD,KAIIN_NO,GMN_ID,DECODE(NAIYOU,"' . $ANGpw . '"),DECODE(ERR_INF,"' . $ANGpw . '")' .
							 'from D_LOG where KG_CD = "' . $DEF_kg_cd . '" and  LOG_TIME BETWEEN "' . $st_ymdt . '" AND "' . $ed_ymdt . '" order by LOG_TIME desc LIMIT ' . $st_kensu . ',50;';
				}
				break;
			
			//最初にページに飛んできたとき、または開始件数が１の場合「最新50件」を表示　件数移動ボタンが押下されていた場合はその件数表示 
			default:
//				if( $old_button or $next_button ){
//					if($st_kensu != 0){						
//						print('<font size="5"><strong>' . $h_st_kensu . '件 ～ ' . $ed_kensu . '件</strong></font>');
//					}else{
//						print('<font size="5"><strong>ログ時間順</strong></font>');
//					}
//				}else{
//					print('<font size="5"><strong>最新50件</strong></font>');
//				}
				$serch_title = '<font size="5"><strong>ログ時間順&nbsp;で表示中</strong></font>';
				$query = 'select LOG_TIME,LOG_SBT,KKSTAFF_KBN,OFFICE_CD,KAIIN_NO,GMN_ID,DECODE(NAIYOU,"' . $ANGpw . '"),DECODE(ERR_INF,"' . $ANGpw . '")' .
						 'FROM D_LOG where KG_CD = "' . $DEF_kg_cd . '" order by LOG_TIME desc LIMIT ' . $st_kensu . ',50;';
				break;
		}

		$result = mysql_query($query);
		if (!$result) {
			print('<br><font color="red">ログマスタの取得失敗<br>お手数ですが管理者に問い合わせてください。</font>');

			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = 'ログの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************


		}else{
			//print("ログテーブルのselect成功 <BR>");

			//*****表示件数移動ボタン*****
			//前の件数と次の件数を表示するための変数
			if( $st_kensu != 0 ){
				$old_st_kensu = $st_kensu - 50;
				$old_ed_kensu = $ed_kensu - 50;
			}
			$next_st_kensu = $st_kensu + 50;
			$next_ed_kensu = $ed_kensu + 50;
				
			print('<table>');
			print('<tr>');
			print('<form action="kanri_log_top.php" method="POST">');
			print('<input type="hidden" name="prc_gmn" value="'.$gmn_id.'">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="'.$staff_cd.'">');
			print('<input type="hidden" name="st_kensu" value="' . $st_kensu . '" />');		//始件数
			print('<input type="hidden" name="ed_kensu" value="' . $ed_kensu . '" />');		//終件数
			print('<input type="hidden" name="radio" value="' . $radio . '" />');		//選択済ラジオボタン
			print('<input type="hidden" name="st_yyyy" value="' . $st_yyyy . '" />');		//開始年
			print('<input type="hidden" name="st_mm" value="' . $st_mm . '" />');			//開始月
			print('<input type="hidden" name="st_dd" value="' . $st_dd . '" />');			//開始日
			print('<input type="hidden" name="st_time" value="' . $st_time . '" />');		//開始時
			print('<input type="hidden" name="ed_yyyy" value="' . $ed_yyyy . '" />');		//終了年
			print('<input type="hidden" name="ed_mm" value="' . $ed_mm . '" />');			//終了月
			print('<input type="hidden" name="ed_dd" value="' . $ed_dd . '" />');			//終了日
			print('<input type="hidden" name="ed_time" value="' . $ed_time . '" />');		//終了時
			//print('<input type="hidden" name="gmn_id" value="' . $gmn_id . '" />');			//画面ＩＤ
			print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '" />');		//会員番号
			print('<input type="hidden" name="select_log_sbt" value="' . $select_log_sbt . '" />');			//ログ種別
			print('<input type="hidden" name="select_log_kkstaff_kbn" value="' . $select_log_kkstaff_kbn . '" />');			//顧客店舗区分
			//print('<input type="hidden" name="log_office_code" value="' . $log_office_code . '" />');			//店舗コード
			print('<input type="hidden" name="old_button" value="1" />');	//前の５０件ボタン押下
			print('<input type="hidden" name="next_button" value="0" />');	//次の５０件ボタン押下
			print('<input type="hidden" name="st_kensu" value="' . $st_kensu . '" />');	//開始件数
			print('<input type="hidden" name="ed_kensu" value="' . $ed_kensu . '" />');	//終了件数


			//前の件数ボタン　開始件数が１の場合ボタン表示しない
			print('<td width="150" align="center">');
			if( $st_kensu != 0 ){
				$old_st_kensu++;
				print( $old_st_kensu .'<font size="1">&nbsp;件目</font>～&nbsp;' . $old_ed_kensu . '<font size="1">&nbsp;件目</font><br>');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_back50_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_back50_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_back50_1.png\';" onClick="kurukuru()" border="0">');
			}else{
				print('&nbsp;');
			}
			print('</td>');
			print('</form>');
			
			print('<td width="650" align="center">');
			//現在の表示件数
			print( $serch_title . '<br><font size="5" color="blue">（' . $h_st_kensu . '</font><font size="2" color="blue">&nbsp;件目</font><font size="5" color="blue">～' . $ed_kensu . '</font><font size="2" color="blue">&nbsp;件目</font><font size="5" color="blue">）</font></td>');
			
			//次の件数ボタン
			print('<form action="kanri_log_top.php" method="POST">');
			print('<input type="hidden" name="prc_gmn" value="'.$gmn_id.'">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="'.$staff_cd.'">');
			print('<input type="hidden" name="st_kensu" value="' . $st_kensu . '" />');		//始件数
			print('<input type="hidden" name="ed_kensu" value="' . $ed_kensu . '" />');		//終件数
			print('<input type="hidden" name="radio" value="' . $radio . '" />');		//選択済ラジオボタン
			print('<input type="hidden" name="st_yyyy" value="' . $st_yyyy . '" />');		//開始年
			print('<input type="hidden" name="st_mm" value="' . $st_mm . '" />');			//開始月
			print('<input type="hidden" name="st_dd" value="' . $st_dd . '" />');			//開始日
			print('<input type="hidden" name="st_time" value="' . $st_time . '" />');		//開始時
			print('<input type="hidden" name="ed_yyyy" value="' . $ed_yyyy . '" />');		//終了年
			print('<input type="hidden" name="ed_mm" value="' . $ed_mm . '" />');			//終了月
			print('<input type="hidden" name="ed_dd" value="' . $ed_dd . '" />');			//終了日
			print('<input type="hidden" name="ed_time" value="' . $ed_time . '" />');		//終了時
			//print('<input type="hidden" name="gmn_id" value="' . $gmn_id . '" />');			//画面ＩＤ
			print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '" />');		//会員番号
			print('<input type="hidden" name="select_log_sbt" value="' . $select_log_sbt . '" />');			//ログ種別
			print('<input type="hidden" name="select_log_kkstaff_kbn" value="' . $select_log_kkstaff_kbn . '" />');			//顧客店舗区分
			//print('<input type="hidden" name="log_office_code" value="' . $log_office_code . '" />');			//店舗コード
			print('<input type="hidden" name="old_button" value="0" />');	//前の５０件ボタン押下
			print('<input type="hidden" name="next_button" value="1" />');	//次の５０件ボタン押下
			print('<input type="hidden" name="st_kensu" value="' . $st_kensu . '" />');	//開始件数
			print('<input type="hidden" name="ed_kensu" value="' . $ed_kensu . '" />');	//終了件数
			print('<td width="150" align="center">');
			$next_st_kensu++;
			print( $next_st_kensu . '<font size="1">&nbsp;件目</font>～' . $next_ed_kensu . '<font size="1">&nbsp;件目</font><br>');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_next50_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_next50_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_next50_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');

			//項目
			print('<table border="1">');
			print('<tr bgcolor="powderblue">');
			print('<th width="110" align="center">ログ時間</th>');
			print('<th width="55" align="center"><font size="2">ログ<br>種別</font></th>');
			print('<th width="55" align="center"><font size="2">入力</font></th>');
			print('<th width="110" align="center"><font size="2">会員&nbsp;or<br>スタッフ</font></th>');
			print('<th width="565" align="center">ログ内容</th>');
			//print('<th width bgcolor="#999999" scope="col">画面名</th>');
			
			//スタッフコードがＡＸＤ管理者の場合エラー情報項目表示
//			if( $staff_cd == "axdkanri" ){
				print('<th width="55" align="center"><font size="1">エラー<br>情報</font></th>');
//			}
			print('</tr>');

			$log_cnt = 0;
			while( $row = mysql_fetch_array($result) ){
			
				$log_time = $row[0];		//ログ時刻
				$log_sbt = $row[1];			//ログ種別
				$log_kkstaff_kbn = $row[2];	//顧客スタッフ区分
				$log_office_cd = $row[3];	//オフィスコード
				$log_kaiin_no = $row[4];	//会員番号
				$log_gmn_nm	= $row[5];		//画面名
				$log_naiyou	= $row[6];		//内容
				$log_err_inf = $row[7];		//エラー情報

				//ログ時刻をyyyy-mm-dd time:min:secに直す
				$log_y = substr($log_time, 0, 4);	//年
				$log_m = substr($log_time, 4, 2);	//月
				$log_d = substr($log_time, 6, 2);	//日
				$log_t = substr($log_time, 8, 2);	//時間
				$log_min = substr($log_time, 10, 2);	//分
				$log_sec = substr($log_time, 12, 2);	//秒
				$log_sec_m = substr($log_time, 14, 4);	//秒以下
				$log_time_edit = $log_y.'-'.$log_m.'-'.$log_d.'<br>'.$log_t.':'.$log_min.':'.$log_sec;
					
				//店舗コードと会員番号がヌルの場合空白を与える
				if($log_office_cd == ''){
					$log_office_cd = '&nbsp';
				}
				if($log_kaiin_no == ''){
					$log_kaiin_no = '&nbsp';
				}
					
				print('<tr>');
				//ログ時間
				print('<td align="center" ');
				if( $log_sbt == 'N' ){
					if( $log_kkstaff_kbn == "K" ){
						print('background="../img_' . $lang_cd . '/bg_kimidori_110x20.png">');
					}else{
						print('background="../img_' . $lang_cd . '/bg_mizu_110x20.png">');
					}
				}else if( $log_sbt == 'E' ){
					print('background="../img_' . $lang_cd . '/bg_pink_110x20.png">');
				}else if( $log_sbt == 'W' ){
					print('background="../img_' . $lang_cd . '/bg_yellow_110x20.png">');
				}else{
					print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png">');
				}
				print('<font size="2">' . $log_time_edit . '</font></td>');
				//ログ種別
				print('<td align="center" ');
				if( $log_sbt == 'N' ){
					if( $log_kkstaff_kbn == "K" ){
						print('background="../img_' . $lang_cd . '/bg_kimidori_55x20.png">');
					}else{
						print('background="../img_' . $lang_cd . '/bg_mizu_55x20.png">');
					}
					print('通常');
				}else if( $log_sbt == 'E' ){
					print('background="../img_' . $lang_cd . '/bg_pink_55x20.png">');
					print('<font size="2" color="red">エラー</font>');
				}else if( $log_sbt == 'W' ){
					print('background="../img_' . $lang_cd . '/bg_yellow_55x20.png">');
					print('<font size="2" color="red">警告</font>');
				}else{
					print('background="../img_' . $lang_cd . '/bg_lightgrey_55x20.png">');
					print('***');
				}
				print('</td>');
				//顧客スタッフ区分
				print('<td align="center" ');
				if( $log_sbt == 'N' ){
					if( $log_kkstaff_kbn == "K" ){
						print('background="../img_' . $lang_cd . '/bg_kimidori_55x20.png">');
					}else{
						print('background="../img_' . $lang_cd . '/bg_mizu_55x20.png">');
					}
				}else if( $log_sbt == 'E' ){
					print('background="../img_' . $lang_cd . '/bg_pink_55x20.png">');
				}else if( $log_sbt == 'W' ){
					print('background="../img_' . $lang_cd . '/bg_yellow_55x20.png">');
				}else{
					print('background="../img_' . $lang_cd . '/bg_lightgrey_55x20.png">');
				}
				if( $log_kkstaff_kbn == 'K' ){
					print('会員');
				}else if( $log_kkstaff_kbn == 'S' ){
					print('<font size="2">STAFF</font>');
				}else{
					print('***');
				}
				print('</td>');
				//会員番号・スタッフコード
				print('<td align="center" ');
				if( $log_sbt == 'N' ){
					if( $log_kkstaff_kbn == "K" ){
						print('background="../img_' . $lang_cd . '/bg_kimidori_110x20.png">');
					}else{
						print('background="../img_' . $lang_cd . '/bg_mizu_110x20.png">');
					}
				}else if( $log_sbt == 'E' ){
					print('background="../img_' . $lang_cd . '/bg_pink_110x20.png">');
				}else if( $log_sbt == 'W' ){
					print('background="../img_' . $lang_cd . '/bg_yellow_110x20.png">');
				}else{
					print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png">');
				}
				print( $log_kaiin_no );
				print('</td>');
				//ログ内容
				print('<td align="left" ');
				if( $log_sbt == 'N' ){
					if( $log_kkstaff_kbn == "K" ){
						print('background="../img_' . $lang_cd . '/bg_kimidori_565x20.png">');
					}else{
						print('background="../img_' . $lang_cd . '/bg_mizu_565x20.png">');
					}
				}else if( $log_sbt == 'E' ){
					print('background="../img_' . $lang_cd . '/bg_pink_565x20.png">');
				}else if( $log_sbt == 'W' ){
					print('background="../img_' . $lang_cd . '/bg_yellow_565x20.png">');
				}else{
					print('background="../img_' . $lang_cd . '/bg_lightgrey_565x20.png">');
				}
				print( $log_naiyou );
				print('</td>');
				//エラー情報がある場合はログイン者が管理者の場合のみ表示ボタン設置
//				if( $staff_cd == "axdkanri" ){
					if( $log_err_inf != '' ){
						print('<form action="kanri_log_err.php" method="POST" target="blank">');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_55x20.png">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
						print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
						print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
						print('<input type="hidden" name="log_time" value="' . $log_time . '">');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="../img_' . $lang_cd . '/btn_hyouji_50x50_1.png" onmouseover="this.src=\'../img_' . $lang_cd . '/btn_hyouji_50x50_2.png\';" onmouseout="this.src=\'../img_' . $lang_cd . '/btn_hyouji_50x50_1.png\';" onClick="kurukuru()" border="0">');
						print('</td>');
						print('</form>');
					
					}else{
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">');
						print('&nbsp;');
						print('</td>');
						
					}
//				}
				print('</tr>');
				
				$log_cnt++;
			}
			
			if( $log_cnt == 0 ){
				//条件に該当するログが無い
				print('<tr>');
				print('<td colspan="6" height="100" align="center" valign="middle" bgcolor="lightgrey">※該当するログは&nbsp;ありません。</td>');
				print('</tr>');
			
			}
			
			
			print('</table>');
			
			if( $log_cnt >= 15 ){
				print('<table>');
				print('<tr>');
				print('<form action="kanri_log_top.php" method="POST">');
				print('<input type="hidden" name="prc_gmn" value="'.$gmn_id.'">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="'.$staff_cd.'">');
				print('<input type="hidden" name="st_kensu" value="' . $st_kensu . '" />');		//始件数
				print('<input type="hidden" name="ed_kensu" value="' . $ed_kensu . '" />');		//終件数
				print('<input type="hidden" name="radio" value="' . $radio . '" />');		//選択済ラジオボタン
				print('<input type="hidden" name="st_yyyy" value="' . $st_yyyy . '" />');		//開始年
				print('<input type="hidden" name="st_mm" value="' . $st_mm . '" />');			//開始月
				print('<input type="hidden" name="st_dd" value="' . $st_dd . '" />');			//開始日
				print('<input type="hidden" name="st_time" value="' . $st_time . '" />');		//開始時
				print('<input type="hidden" name="ed_yyyy" value="' . $ed_yyyy . '" />');		//終了年
				print('<input type="hidden" name="ed_mm" value="' . $ed_mm . '" />');			//終了月
				print('<input type="hidden" name="ed_dd" value="' . $ed_dd . '" />');			//終了日
				print('<input type="hidden" name="ed_time" value="' . $ed_time . '" />');		//終了時
				//print('<input type="hidden" name="gmn_id" value="' . $gmn_id . '" />');			//画面ＩＤ
				print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '" />');		//会員番号
				print('<input type="hidden" name="select_log_sbt" value="' . $select_log_sbt . '" />');			//ログ種別
				print('<input type="hidden" name="select_log_kkstaff_kbn" value="' . $select_log_kkstaff_kbn . '" />');			//顧客店舗区分
				//print('<input type="hidden" name="log_office_code" value="' . $log_office_code . '" />');			//店舗コード
				print('<input type="hidden" name="old_button" value="1" />');	//前の５０件ボタン押下
				print('<input type="hidden" name="next_button" value="0" />');	//次の５０件ボタン押下
				print('<input type="hidden" name="st_kensu" value="' . $st_kensu . '" />');	//開始件数
				print('<input type="hidden" name="ed_kensu" value="' . $ed_kensu . '" />');	//終了件数
	
				//前の件数ボタン　開始件数が１の場合ボタン表示しない
				print('<td width="150" align="center">');
				if( $st_kensu != 0 ){
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_back50_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_back50_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_back50_1.png\';" onClick="kurukuru()" border="0"><br>');
					print( $old_st_kensu .'<font size="1">&nbsp;件目</font>～&nbsp;' . $old_ed_kensu . '<font size="1">&nbsp;件目</font>');
				}else{
					print('&nbsp;');
				}
				print('</td>');
				print('</form>');
				
				print('<td width="650" align="center">&nbsp;</td>');
			
				if( $log_cnt == 50 ){
					//次の件数ボタン
					print('<form action="kanri_log_top.php" method="POST">');
					print('<input type="hidden" name="prc_gmn" value="'.$gmn_id.'">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="'.$staff_cd.'">');
					print('<input type="hidden" name="st_kensu" value="' . $st_kensu . '" />');		//始件数
					print('<input type="hidden" name="ed_kensu" value="' . $ed_kensu . '" />');		//終件数
					print('<input type="hidden" name="radio" value="' . $radio . '" />');		//選択済ラジオボタン
					print('<input type="hidden" name="st_yyyy" value="' . $st_yyyy . '" />');		//開始年
					print('<input type="hidden" name="st_mm" value="' . $st_mm . '" />');			//開始月
					print('<input type="hidden" name="st_dd" value="' . $st_dd . '" />');			//開始日
					print('<input type="hidden" name="st_time" value="' . $st_time . '" />');		//開始時
					print('<input type="hidden" name="ed_yyyy" value="' . $ed_yyyy . '" />');		//終了年
					print('<input type="hidden" name="ed_mm" value="' . $ed_mm . '" />');			//終了月
					print('<input type="hidden" name="ed_dd" value="' . $ed_dd . '" />');			//終了日
					print('<input type="hidden" name="ed_time" value="' . $ed_time . '" />');		//終了時
					//print('<input type="hidden" name="gmn_id" value="' . $gmn_id . '" />');			//画面ＩＤ
					print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_no . '" />');		//会員番号
					print('<input type="hidden" name="select_log_sbt" value="' . $select_log_sbt . '" />');			//ログ種別
					print('<input type="hidden" name="select_log_kkstaff_kbn" value="' . $select_log_kkstaff_kbn . '" />');			//顧客店舗区分
					//print('<input type="hidden" name="log_office_code" value="' . $log_office_code . '" />');			//店舗コード
					print('<input type="hidden" name="old_button" value="0" />');	//前の５０件ボタン押下
					print('<input type="hidden" name="next_button" value="1" />');	//次の５０件ボタン押下
					print('<input type="hidden" name="st_kensu" value="' . $st_kensu . '" />');	//開始件数
					print('<input type="hidden" name="ed_kensu" value="' . $ed_kensu . '" />');	//終了件数
					print('<td width="150" align="center">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_next50_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_next50_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_next50_1.png\';" onClick="kurukuru()" border="0"><br>');
					print( $next_st_kensu . '<font size="1">&nbsp;件目</font>～' . $next_ed_kensu . '<font size="1">&nbsp;件目</font>');
					print('</td>');
					print('</form>');
				
				}else{
					print('<td width="150" align="center">&nbsp;</td>');
					
				}
					
				print('</tr>');
				print('</table>');
					
			
			}
			
			print('<hr>');
			
		}
	
		//戻るボタン
		print('<table border="0">');
		print('<tr>');
		print('<td width="815" align="left">&nbsp;</td>');
		print('<form method="post" action="kanri_top.php">');
		print('<td align="right">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');
		
		print('</center>');
			
	}

	mysql_close( $link );
?>
</body>
</html>
