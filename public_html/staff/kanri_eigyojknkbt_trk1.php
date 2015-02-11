<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－営業時間個別（新規登録）確認</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
<style type="text/css">
input.err,select.err,textarea.err {
	background-color: #FF0000;
}
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
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
	$gmn_id = 'kanri_eigyojknkbt_trk1.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_eigyojknkbt_trk0.php','kanri_eigyojknkbt_trk1.php');

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
	mb_internal_encoding("utf8");

	//***コーディングはここから**********************************************************************************

	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = $_POST['lang_cd'];
	$office_cd = $_POST['office_cd'];
	$staff_cd = $_POST['staff_cd'];

	$select_office_cd = $_POST['select_office_cd'];
	$select_year = $_POST['select_year'];	//選択年
	$select_month = $_POST['select_month'];	//選択月
	$select_day = $_POST['select_day'];		//選択日
	//$select_date = sprintf("%04d",$select_year) . '-' . sprintf("%02d",$select_month) . '-' . sprintf("%02d",$select_day);
	//（入力がエラーの可能性があるため）

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" ){
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
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');

		//ページ編集
		//固有引数の取得
		$tnp_st_time = $_POST['tnp_st_time'];	//開店時刻
		$tnp_ed_time = $_POST['tnp_ed_time'];	//閉店時刻

		$err_cnt = 0;	//エラー件数

		//引数チェック
		//選択年
		$err_select_year = 0;
		if($select_year == ''){
			$err_select_year = 1;
			$err_cnt++;
		}else if(!ereg('[0-9]{4}',$select_year)){
			$err_select_year = 1;
			$err_cnt++;
		}else if( $select_year < $now_yyyy || $select_year >= 2038 ){
			$err_select_year = 1;
			$err_cnt++;
		}
		//選択月
		$err_select_month = 0;
		if($select_month == ''){
			$err_select_month = 1;
			$err_cnt++;
		}elseif(!ereg('[1-9]',$select_month) or $select_month < 1 or $select_month > 12){
			$err_select_month = 1;
			$err_cnt++;
		}
		//選択日
		$err_select_day = 0;
		if( $err_select_year == 0 && $err_select_month == 0 ){
			//該当年月の日数を求める
			$DFmaxdd = cal_days_in_month(CAL_GREGORIAN, $select_month , $select_year );
			if($select_day == ''){
				$err_select_day = 1;
				$err_cnt++;
			}elseif(!ereg('[1-9]',$select_day) or $select_day < 1 or $select_day > $DFmaxdd ){
				$err_select_day = 1;
				$err_cnt++;
			}
		}
		
		//開店時刻
		$err_tnp_st_time = 0;
		if( strlen( $tnp_st_time ) == 0 ){
			$err_tnp_st_time = 1;
			$err_cnt++;
		
		}else if( is_numeric( $tnp_st_time ) ){
			$div = intval($tnp_st_time / 100);
			$mod = $tnp_st_time % 100;
			if(	$div  < 0 || $div >= 24 ){	//24時以降の入力はエラー
				$err_tnp_st_time = 1;
				$err_cnt++;
			}
			if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
				$err_tnp_st_time = 1;
				$err_cnt++;
			}

		}else{
			$err_tnp_st_time = 1;
			$err_cnt++;
		}
		
		//閉店時刻
		$err_tnp_ed_time = 0;
		if( strlen( $tnp_ed_time ) == 0 ){
			$err_tnp_ed_time = 1;
			$err_cnt++;
		
		}else if( is_numeric( $tnp_ed_time ) ){
			$div = intval($tnp_ed_time / 100);
			$mod = $tnp_ed_time % 100;
			if( $div < 10 ){
				$div = $div + 24;	//１０時未満の入力は２４時間を加算する
				$tnp_ed_time = $tnp_ed_time + 2400;
			}
			if(	$div  < 10 || $div >= 34 ){	//34時(翌10時)以降の入力はエラー
				$err_tnp_ed_time = 1;
				$err_cnt++;
			}
			if(	$mod  < 0 || $mod > 59 ){	//分が60～99の入力はエラー
				$err_tnp_ed_time = 1;
				$err_cnt++;
			}

		}else{
			$err_tnp_ed_time = 1;
			$err_cnt++;
		}
		
		//開店時間と閉店時間の比較チェック
		if( $err_tnp_st_time == 0 && $err_tnp_ed_time == 0 ){
			if( $tnp_st_time >= $tnp_ed_time ){
				$err_tnp_ed_time = 1;
				$err_cnt++;
			}
		}

		//対象日の重複チェック
		if( $err_cnt == 0 ){
			//該当日がすでに登録されているかチェック
			$select_date = sprintf("%04d",$select_year) . '-' . sprintf("%02d",$select_month) . '-' . sprintf("%02d",$select_day);
			$query = 'select count(*) from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_date . '";';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zs_errgmn.php' );
				
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = '営業時間個別の参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
			
			}else{
				$row = mysql_fetch_array($result);
				if( $row[0] != 0 ){
					$err_cnt = 999;
				}
			}
		}
				
		//オフィスマスタの取得
		$query = 'select OFFICE_NM,START_YOUBI from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '";';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			//エラーメッセージ表示
			require( './zs_errgmn.php' );
			
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = 'オフィスマスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************

		}else{
			$row = mysql_fetch_array($result);
			$Moffice_office_nm = $row[0];	//オフィス名
			$Moffice_start_youbi = $row[1];	//開始曜日（ 0:日曜始まり 1:月曜始まり ）
		}


		if( $err_cnt == 0 ){
			//カレンダーから営業日フラグを取得
			$eigyoubi_flg = 0;	//0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
			$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_date . '";';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				//エラーメッセージ表示
				require( './zs_errgmn.php' );
				
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = 'カレンダーの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************

			}else{
				while( $row = mysql_fetch_array($result) ){
					$eigyoubi_flg = $row[0];	//営業日フラグ
				}
			}
		}


		if( $err_flg == 0 ){
			
			//明細データにエラーがあるか？
			if( $err_cnt == 0 ){
				//エラーなし
				
				print('<center>');
				
				//ページ編集
				print('<table bgcolor="pink"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kanri_eigyojkn.png" border="0">');
				print('</td></tr></table>');
		
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
				print('<form method="post" action="kanri_eigyojknkbt_trk0.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_year" value="' . $select_year . '">');
				print('<input type="hidden" name="select_month" value="' . $select_month . '">');
				print('<input type="hidden" name="select_day" value="' . $select_day . '">');
				print('<input type="hidden" name="tnp_st_time" value="' . $tnp_st_time . '">');
				print('<input type="hidden" name="tnp_ed_time" value="' . $tnp_ed_time . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
	
				print('<hr>');
				
				print('<font color="blue">※以下の内容でよろしければ、登録ボタンを押下してください。</font><br>');
				print('<font color="red">（まだ登録されていません。）</font><br>');
				
				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
	
				//開店時刻・閉店時刻
				print('<font size="4"><b>対象日・開始時刻・終了時刻</b></font>・・・オフィス営業時間<br>');
				print('<font size="2">※９時００分の場合は&nbsp;<font color="red">900</font> 、１２時３０分の場合は&nbsp;<font color="red">1230</font>、２３時００分の場合は&nbsp;<font color="red">2300</font>&nbsp;と入力してください</font><br>');
				print('<font size="2">※入力可能範囲：開始時刻は 900～2359、終了時刻は 1000～3359(翌9:59）です</font><br>');
				print('<table border="1">');
				print('<tr>');
				print('<td width="350" align="center" bgcolor="powderblue">対象日</td>');
				print('<td width="80" align="center" bgcolor="powderblue"><font size="2">開始時間</font></td>');
				print('<td width="20" align="center" bgcolor="powderblue">～</td>');
				print('<td width="80" align="center" bgcolor="powderblue"><font size="2">終了時間</font></td>');
				print('</tr>');
				//明細
				$tmp_youbi = date("w", mktime(0, 0, 0, $select_month, $select_day, $select_year));
				$bgfile = 'bg_mizu';
				$fontcolor = "black";
				if( $eigyoubi_flg == 8 || $eigyoubi_flg == 9 ){
					//8:非営業日、9:祝日非営業日
					$bgfile = 'bg_lightgrey';
					$fontcolor = "gray";
				}else if( $eigyoubi_flg == 1 || $tmp_youbi == 0 ){
					//祝日 または 日曜日
					$bgfile = 'bg_pink';
					$fontcolor = "red";
				}else if( $tmp_youbi == 6 ){
					//土曜日
					$bgfile = 'bg_blue';
					$fontcolor = "blue";
				}
				print('<tr>');
				print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_350x20.png">');
				print('<font size="5" color="' . $fontcolor . '">' . $select_year . '</font>');
				print('<font size="2" color="' . $fontcolor . '">年&nbsp;</font>');
				print('<font size="5" color="' . $fontcolor . '">' . sprintf("%d",$select_month) . '</font>');
				print('<font size="2" color="' . $fontcolor . '">月&nbsp;</font>');
				print('<font size="5" color="' . $fontcolor . '">' . sprintf("%d",$select_day) . '</font>');
				print('<font size="2" color="' . $fontcolor . '">日&nbsp;(' . $week[$tmp_youbi]. ')</font>');
				if( $eigyoubi_flg == 8 || $eigyoubi_flg == 9 ){
					print('<br><font size="2" color="red">カレンダーは非営業日です</font>');
				}
				print('</td>');
				$div = intval($tnp_st_time / 100);
				$mod = $tnp_st_time % 100;
				print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
				print('<font size="5" color="blue">' . sprintf("%d",$div) . ':' . sprintf("%02d",$mod) . '</font>');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_20x20.png">～</td>');
				$div = intval($tnp_ed_time / 100);
				$mod = $tnp_ed_time % 100;
				print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
				print('<font size="5" color="blue">' . sprintf("%d",$div) . ':' . sprintf("%02d",$mod) . '</font>');
				print('</td>');
				print('</tr>');
				print('</table>');
				
				if( $eigyoubi_flg == 8 || $eigyoubi_flg == 9 ){
					print('<font color="red"><b>※注意：カレンダーでは非営業日となっております。</b></font><br><font size="2" color="red">（営業日とする場合はカレンダーの更新も必要です。）</font><br>');
				}
						
				print('</td>');
				print('</tr>');
				print('</table>');
					
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form name="form2" method="post" action="kanri_eigyojknkbt_trk2.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_year" value="' . $select_year . '">');
				print('<input type="hidden" name="select_month" value="' . $select_month . '">');
				print('<input type="hidden" name="select_day" value="' . $select_day . '">');
				print('<input type="hidden" name="tnp_st_time" value="' . $tnp_st_time . '">');
				print('<input type="hidden" name="tnp_ed_time" value="' . $tnp_ed_time . '">');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kanri_eigyojknkbt_trk0.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_year" value="' . $select_year . '">');
				print('<input type="hidden" name="select_month" value="' . $select_month . '">');
				print('<input type="hidden" name="select_day" value="' . $select_day . '">');
				print('<input type="hidden" name="tnp_st_time" value="' . $tnp_st_time . '">');
				print('<input type="hidden" name="tnp_ed_time" value="' . $tnp_ed_time . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
				
				print('</center>');
				
				print('<hr>');
				

			}else if( $err_cnt > 0 ){
				//エラーがある場合
				
				print('<center>');
				
				//ページ編集
				print('<table bgcolor="pink"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kanri_eigyojkn.png" border="0">');
				print('</td></tr></table>');
		
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
				print('<form method="post" action="kanri_eigyojkn_select.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
	
				print('<hr>');
				
				if( $err_cnt == 999 ){
					print('<font color="red">※選択日は既に登録されています。</font><br>');
				}else{
					print('<font color="red">※エラーがあります。</font><br>');
				}
				
				print('<form name="form2" method="post" action="kanri_eigyojknkbt_trk1.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');

				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');

				//開店時刻・閉店時刻
				print('<font size="4"><b>対象日・開始時刻・終了時刻</b></font>・・・オフィス営業時間<br>');
				print('<font size="2">※９時００分の場合は&nbsp;<font color="red">900</font> 、１２時３０分の場合は&nbsp;<font color="red">1230</font>、２３時００分の場合は&nbsp;<font color="red">2300</font>&nbsp;と入力してください</font><br>');
				print('<font size="2">※入力可能範囲：開始時刻は 900～2359、終了時刻は 1000～3359(翌9:59）です</font><br>');
				print('<table border="1">');
				print('<tr>');
				print('<td width="350" align="center" bgcolor="powderblue">対象日</td>');
				print('<td width="80" align="center" bgcolor="powderblue"><font size="2">開始時間</font></td>');
				print('<td width="20" align="center" bgcolor="powderblue">～</td>');
				print('<td width="80" align="center" bgcolor="powderblue"><font size="2">終了時間</font></td>');
				print('</tr>');
				//明細
				print('<tr bgcolor="moccasin">');
				print('<td align="center" background="../img_' . $lang_cd . '/');
				if( $err_cnt == 999 || $err_select_year != 0 || $err_select_month != 0 || $err_select_day != 0 ){
					print('bg_red');
				}else{
					print('bg_mizu');
				}
				print('_350x20.png">');
				$tabindex++;
				print('<select name="select_year" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = $now_yyyy;
				while( $i < 2038 ){
					print('<option value="' . $i . '" ');
					if( $i == $select_year ){
						print('selected');
					}
					print('>' . $i. '</option>');
				
					$i++;
				}
				print('</select>');
				print('年');
				$tabindex++;
				print('<select name="select_month" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 1;
				while( $i < 13 ){
					print('<option value="' . $i . '" ');
					if( $i == $select_month ){
						print('selected');
					}
					print('>' . $i. '</option>');
				
					$i++;
				}
				print('</select>');
				print('月');
				$tabindex++;
				print('<select name="select_day" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
				$i = 1;
				while( $i < 32 ){
					print('<option value="' . $i . '" ');
					if( $i == $select_day ){
						print('selected');
					}
					print('>' . $i. '</option>');
				
					$i++;
				}
				print('</select>');
				print('日');
				print('</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/');
				if( $err_tnp_st_time == 0 ){
					print('bg_mizu');
				}else{
					print('bg_red');
				}
				print('_80x20.png">');
				$tabindex++;
				print('<input type="text" name="tnp_st_time" size="4" style="ime-mode:disabled; font-size:24px; text-align:center;" ');
				print('tabindex="' . $tabindex . '" class="');
				if( $err_tnp_st_time == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_st_time . '></td>');
				print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
				print('<td align="center" background="../img_' . $lang_cd . '/');
				if( $err_tnp_ed_time == 0 ){
					print('bg_mizu');
				}else{
					print('bg_red');
				}
				print('_80x20.png">');
				$tabindex++;
				print('<input type="text" name="tnp_ed_time" size="4" style="ime-mode:disabled; font-size:24px; text-align:center;" ');
				print('tabindex="' . $tabindex . '" class="');
				if( $err_tnp_ed_time == 0 ){
					print('normal');
				}else{
					print('err');
				}
				print('" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_ed_time . '></td>');
				print('</tr>');
				print('</table>');
						
				print('</td>');
				print('</tr>');
				print('</table>');
				
				print('<table border="0">');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('<tr>');
				print('<td width="815" align="left">&nbsp;</td>');
				print('<form method="post" action="kanri_eigyojkn_select.php">');
				print('<td align="right">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');

				print('</center>');

				print('<hr>');

			}
		}
	}

	mysql_close( $link );
?>
</body>
</html>