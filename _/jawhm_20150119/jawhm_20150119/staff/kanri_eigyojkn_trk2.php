<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－営業時間（新規登録）結果</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
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
	$gmn_id = 'kanri_eigyojkn_trk2.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_eigyojkn_trk1.php');

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


		//ページ編集
		//固有引数の取得
		$teikyu_0 = $_POST['teikyu_0'];					//定休日チェックボックス（日曜） 'on':チェックあり
		$tnp_st_time_0 = $_POST['tnp_st_time_0'];		//開店時刻（日曜）
		$tnp_ed_time_0 = $_POST['tnp_ed_time_0'];		//閉店時刻（日曜）
		$teikyu_1 = $_POST['teikyu_1'];					//定休日チェックボックス（月曜） 'on':チェックあり
		$tnp_st_time_1 = $_POST['tnp_st_time_1'];		//開店時刻（月曜）
		$tnp_ed_time_1 = $_POST['tnp_ed_time_1'];		//閉店時刻（月曜）
		$teikyu_2 = $_POST['teikyu_2'];					//定休日チェックボックス（火曜） 'on':チェックあり
		$tnp_st_time_2 = $_POST['tnp_st_time_2'];		//開店時刻（火曜）
		$tnp_ed_time_2 = $_POST['tnp_ed_time_2'];		//閉店時刻（火曜）
		$teikyu_3 = $_POST['teikyu_3'];					//定休日チェックボックス（水曜） 'on':チェックあり
		$tnp_st_time_3 = $_POST['tnp_st_time_3'];		//開店時刻（水曜）
		$tnp_ed_time_3 = $_POST['tnp_ed_time_3'];		//閉店時刻（水曜）
		$teikyu_4 = $_POST['teikyu_4'];					//定休日チェックボックス（木曜） 'on':チェックあり
		$tnp_st_time_4 = $_POST['tnp_st_time_4'];		//開店時刻（木曜）
		$tnp_ed_time_4 = $_POST['tnp_ed_time_4'];		//閉店時刻（木曜）
		$teikyu_5 = $_POST['teikyu_5'];					//定休日チェックボックス（金曜） 'on':チェックあり
		$tnp_st_time_5 = $_POST['tnp_st_time_5'];		//開店時刻（金曜）
		$tnp_ed_time_5 = $_POST['tnp_ed_time_5'];		//閉店時刻（金曜）
		$teikyu_6 = $_POST['teikyu_6'];					//定休日チェックボックス（土曜） 'on':チェックあり
		$tnp_st_time_6 = $_POST['tnp_st_time_6'];		//開店時刻（土曜）
		$tnp_ed_time_6 = $_POST['tnp_ed_time_6'];		//閉店時刻（土曜）
		$teikyu_7 = $_POST['teikyu_7'];					//定休日チェックボックス（土日祝の前日） 'on':チェックあり
		$tnp_st_time_7 = $_POST['tnp_st_time_7'];		//開店時刻（土日祝の前日）
		$tnp_ed_time_7 = $_POST['tnp_ed_time_7'];		//閉店時刻（土日祝の前日）
		$teikyu_8 = $_POST['teikyu_8'];					//定休日チェックボックス（祝日） 'on':チェックあり
		$tnp_st_time_8 = $_POST['tnp_st_time_8'];		//開店時刻（祝日）
		$tnp_ed_time_8 = $_POST['tnp_ed_time_8'];		//閉店時刻（祝日）
		$yukou_flg = $_POST['yukou_flg'];	//有効フラグ
		$st_year = $_POST['st_year'];		//開始年
		$st_month = $_POST['st_month'];		//開始月
		$st_day = $_POST['st_day'];			//開始日
		$ed_year = $_POST['ed_year'];		//終了年
		$ed_month = $_POST['ed_month'];		//終了月
		$ed_day = $_POST['ed_day'];			//終了日
		
		//開始年月日
		$st_date = sprintf("%04d",$st_year) . '-' . sprintf("%02d",$st_month) . '-' . sprintf("%02d",$st_day);
		//終了年月日
		$ed_date = sprintf("%04d",$ed_year) . '-' . sprintf("%02d",$ed_month) . '-' . sprintf("%02d",$ed_day);

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

		//営業時間マスタの存在チェック
		$query = 'select count(*) from M_EIGYOJKN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and ST_DATE = "' . $st_date . '";';
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
			$log_naiyou = '営業時間マスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
			
		}else{
			$row = mysql_fetch_array($result);
		
			if( $row[0] > 0 ){
				//データが既に存在する場合
				//エラーメッセージ表示
				
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
				
				print('<br><font color="red">エラー：入力された営業時間の情報は既に登録されています。オフィスコード[' . $select_office_cd . '] 開始日[' . $st_date . ']</font><br><br>');
				print('<hr>');

				//**ログ出力**
				$log_sbt = 'W';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = $office_cd;	//オフィスコード
				$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
				$log_naiyou = '営業時間情報が既に登録されている。オフィスコード[' . $select_office_cd . '] 開始日[' . $st_date . ']';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************

				print('<form name="err3" method="post" action="./kanri_eigyojkn_select.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</form>');
				
				print('</center>');
				
				print('<hr>');
				
			}else{
			
				//営業時間マスタの登録
				$eigyo_query_cnt = 0;
				//日曜
				$eigyo_query[$eigyo_query_cnt] = 'insert into M_EIGYOJKN values ("' . $DEF_kg_cd . '","' . $select_office_cd . '",' . $eigyo_query_cnt . ',';
				if( $teikyu_0 == 'on' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '1,';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '0,';
				}
				if( $tnp_st_time_0 != '' && $tnp_ed_time_0 != '' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $tnp_st_time_0 . ',' . $tnp_ed_time_0 . ',';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . 'NULL,NULL,';
				}
				$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $yukou_flg .  ',"' . $st_date . '","' . $ed_date .'","' . date("YmdHis") . '","' . $staff_cd . '");';
				$eigyo_query_cnt++;
				//月曜
				$eigyo_query[$eigyo_query_cnt] = 'insert into M_EIGYOJKN values ("' . $DEF_kg_cd . '","' . $select_office_cd . '",' . $eigyo_query_cnt . ',';
				if( $teikyu_1 == 'on' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '1,';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '0,';
				}
				if( $tnp_st_time_1 != '' && $tnp_ed_time_1 != '' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $tnp_st_time_1 . ',' . $tnp_ed_time_1 . ',';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . 'NULL,NULL,';
				}
				$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $yukou_flg .  ',"' . $st_date . '","' . $ed_date .'","' . date("YmdHis") . '","' . $staff_cd . '");';
				$eigyo_query_cnt++;
				//火曜
				$eigyo_query[$eigyo_query_cnt] = 'insert into M_EIGYOJKN values ("' . $DEF_kg_cd . '","' . $select_office_cd . '",' . $eigyo_query_cnt . ',';
				if( $teikyu_2 == 'on' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '1,';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '0,';
				}
				if( $tnp_st_time_2 != '' && $tnp_ed_time_2 != '' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $tnp_st_time_2 . ',' . $tnp_ed_time_2 . ',';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . 'NULL,NULL,';
				}
				$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $yukou_flg .  ',"' . $st_date . '","' . $ed_date .'","' . date("YmdHis") . '","' . $staff_cd . '");';
				$eigyo_query_cnt++;
				//水曜
				$eigyo_query[$eigyo_query_cnt] = 'insert into M_EIGYOJKN values ("' . $DEF_kg_cd . '","' . $select_office_cd . '",' . $eigyo_query_cnt . ',';
				if( $teikyu_3 == 'on' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '1,';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '0,';
				}
				if( $tnp_st_time_3 != '' && $tnp_ed_time_3 != '' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $tnp_st_time_3 . ',' . $tnp_ed_time_3 . ',';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . 'NULL,NULL,';
				}
				$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $yukou_flg .  ',"' . $st_date . '","' . $ed_date .'","' . date("YmdHis") . '","' . $staff_cd . '");';
				$eigyo_query_cnt++;
				//木曜
				$eigyo_query[$eigyo_query_cnt] = 'insert into M_EIGYOJKN values ("' . $DEF_kg_cd . '","' . $select_office_cd . '",' . $eigyo_query_cnt . ',';
				if( $teikyu_4 == 'on' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '1,';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '0,';
				}
				if( $tnp_st_time_4 != '' && $tnp_ed_time_4 != '' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $tnp_st_time_4 . ',' . $tnp_ed_time_4 . ',';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . 'NULL,NULL,';
				}
				$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $yukou_flg .  ',"' . $st_date . '","' . $ed_date .'","' . date("YmdHis") . '","' . $staff_cd . '");';
				$eigyo_query_cnt++;
				//金曜
				$eigyo_query[$eigyo_query_cnt] = 'insert into M_EIGYOJKN values ("' . $DEF_kg_cd . '","' . $select_office_cd . '",' . $eigyo_query_cnt . ',';
				if( $teikyu_5 == 'on' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '1,';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '0,';
				}
				if( $tnp_st_time_5 != '' && $tnp_ed_time_5 != '' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $tnp_st_time_5 . ',' . $tnp_ed_time_5 . ',';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . 'NULL,NULL,';
				}
				$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $yukou_flg .  ',"' . $st_date . '","' . $ed_date .'","' . date("YmdHis") . '","' . $staff_cd . '");';
				$eigyo_query_cnt++;
				//土曜
				$eigyo_query[$eigyo_query_cnt] = 'insert into M_EIGYOJKN values ("' . $DEF_kg_cd . '","' . $select_office_cd . '",' . $eigyo_query_cnt . ',';
				if( $teikyu_6 == 'on' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '1,';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '0,';
				}
				if( $tnp_st_time_6 != '' && $tnp_ed_time_6 != '' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $tnp_st_time_6 . ',' . $tnp_ed_time_6 . ',';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . 'NULL,NULL,';
				}
				$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $yukou_flg .  ',"' . $st_date . '","' . $ed_date .'","' . date("YmdHis") . '","' . $staff_cd . '");';
				$eigyo_query_cnt++;
				//土日祝の前日
				$eigyo_query[$eigyo_query_cnt] = 'insert into M_EIGYOJKN values ("' . $DEF_kg_cd . '","' . $select_office_cd . '",' . $eigyo_query_cnt . ',';
				if( $teikyu_7 == 'on' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '1,';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '0,';
				}
				if( $tnp_st_time_7 != '' && $tnp_ed_time_7 != '' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $tnp_st_time_7 . ',' . $tnp_ed_time_7 . ',';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . 'NULL,NULL,';
				}
				$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $yukou_flg .  ',"' . $st_date . '","' . $ed_date .'","' . date("YmdHis") . '","' . $staff_cd . '");';
				$eigyo_query_cnt++;
				//祝日
				$eigyo_query[$eigyo_query_cnt] = 'insert into M_EIGYOJKN values ("' . $DEF_kg_cd . '","' . $select_office_cd . '",' . $eigyo_query_cnt . ',';
				if( $teikyu_8 == 'on' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '1,';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . '0,';
				}
				if( $tnp_st_time_8 != '' && $tnp_ed_time_8 != '' ){
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $tnp_st_time_8 . ',' . $tnp_ed_time_8 . ',';
				}else{
					$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . 'NULL,NULL,';
				}
				$eigyo_query[$eigyo_query_cnt] = $eigyo_query[$eigyo_query_cnt] . $yukou_flg .  ',"' . $st_date . '","' . $ed_date .'","' . date("YmdHis") . '","' . $staff_cd . '");';
				$eigyo_query_cnt++;
				
				$i = 0;
				while( $i < $eigyo_query_cnt && $err_flg == 0 ){
					//文字コード設定（insert/update時に必須）
					require( '../zz_mojicd.php' );
					
					$result = mysql_query($eigyo_query[$i]);
					if (!$result) {
						$err_flg = 4;
						//エラーメッセージ表示
						require( './zs_errgmn.php' );
						
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = $office_cd;	//オフィスコード
						$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
						$log_naiyou = '営業時間マスタの登録に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************
						
					}else{

						//**トランザクション出力**
						$log_sbt = 'T';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = $office_cd;	//オフィスコード
						$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
						$log_naiyou = '営業時間マスタを登録しました。オフィス[' . $select_office_cd . '] 開始日[' . $st_date . '] 曜日[' . $eigyo_query_cnt . ']';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************
						
					}
					$i++;
				}
				
				if( $err_flg == 0 ){
					
					//**ログ出力**
					$log_sbt = 'N';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = $office_cd;	//オフィスコード
					$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
					$log_naiyou = '営業時間マスタを登録しました。オフィス[' . $select_office_cd . '] 開始日[' . $st_date . ']';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
					

					//ページ編集
					print('<center>');
					
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
					
					print('<font color="blue">※登録しました。</font><br>');


					

					//開店時刻・閉店時刻
					print('<table border="0">');
					print('<tr>');
					print('<td align="left">');
					print('<font size="4"><b>開始時刻・終了時刻(*)</b></font>・・・オフィス営業時間<br>');
					print('<font size="2">※９時００分の場合は&nbsp;<font color="red">900</font> 、１２時３０分の場合は&nbsp;<font color="red">1230</font>、２３時００分の場合は&nbsp;<font color="red">2300</font>&nbsp;と入力してください</font><br>');
					print('<font size="2">※定休日の場合はチェックを入れてください（ただし、実際の営業日・非営業日はカレンダーの設定で判断します）</font><br>');
					print('<font size="2">※「土日祝の前日」「祝日」に時間を入力しない場合は、各曜日の時間と同様と判断します</font><br>');
					
					print('</td>');
					print('</tr>');
					print('<tr>');
					print('<td>');
					
					print('<table border="1">');
					print('<tr>');
					print('<td width="80" align="center" bgcolor="powderblue">曜日</td>');
					print('<td width="55" align="center" bgcolor="powderblue"><font size="2">定休</font></td>');
					print('<td width="80" align="center" bgcolor="powderblue"><font size="2">OPEN</font></td>');
					print('<td width="20" align="center" bgcolor="powderblue">～</td>');
					print('<td width="80" align="center" bgcolor="powderblue"><font size="2">CLOSE</font></td>');
					print('<td width="110" align="center" bgcolor="powderblue">曜日</td>');
					print('<td width="55" align="center" bgcolor="powderblue"><font size="2">定休</font></td>');
					print('<td width="80" align="center" bgcolor="powderblue"><font size="2">OPEN</font></td>');
					print('<td width="20" align="center" bgcolor="powderblue">～</td>');
					print('<td width="80" align="center" bgcolor="powderblue"><font size="2">CLOSE</font></td>');
					print('</tr>');
					//月曜・土曜
					print('<tr>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">月曜</td>');
					if( $teikyu_1 == 'on' ){
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><b>レ</b></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
					}else{
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">&nbsp;</td>');
						$div = intval($tnp_st_time_1 / 100);
						$mod = $tnp_st_time_1 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
						$div = intval($tnp_ed_time_1 / 100);
						$mod = $tnp_ed_time_1 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					}
					print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_110x20.png">土曜</td>');
					if( $teikyu_6 == 'on' ){
						print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_55x20.png"><b>レ</b></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_80x20.png">&nbsp;</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_20x20.png">～</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_80x20.png">&nbsp;</td>');
					}else{
						print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_55x20.png">&nbsp;</td>');
						$div = intval($tnp_st_time_6 / 100);
						$mod = $tnp_st_time_6 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_20x20.png">～</td>');
						$div = intval($tnp_ed_time_6 / 100);
						$mod = $tnp_ed_time_6 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod	) . '</b></font></td>');
					}
					print('</tr>');
					//火曜・日曜
					print('<tr>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">火曜</td>');
					if( $teikyu_2 == 'on' ){
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><b>レ</b></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
					}else{
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">&nbsp;</td>');
						$div = intval($tnp_st_time_2 / 100);
						$mod = $tnp_st_time_2 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
						$div = intval($tnp_ed_time_2 / 100);
						$mod = $tnp_ed_time_2 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					}
					print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_110x20.png">日曜</td>');
					if( $teikyu_0 == 'on' ){
						print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_55x20.png"><b>レ</b></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_80x20.png">&nbsp;</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_20x20.png">～</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_80x20.png">&nbsp;</td>');
					}else{
						print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_55x20.png">&nbsp;</td>');
						$div = intval($tnp_st_time_0 / 100);
						$mod = $tnp_st_time_0 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_20x20.png">～</td>');
						$div = intval($tnp_ed_time_0 / 100);
						$mod = $tnp_ed_time_0 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					}
					print('</tr>');
					//水曜・土日祝の前日
					print('<tr>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">水曜</td>');
					if( $teikyu_3 == 'on' ){
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><b>レ</b></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
					}else{
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">&nbsp;</td>');
						$div = intval($tnp_st_time_3 / 100);
						$mod = $tnp_st_time_3 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
						$div = intval($tnp_ed_time_3 / 100);
						$mod = $tnp_ed_time_3 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					}
					print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_110x20.png"><font size="2">土日祝の前日</font></td>');
					if( $teikyu_7 == 'on' ){
						print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_55x20.png"><b>レ</b></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png">&nbsp;</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_20x20.png">～</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png">&nbsp;</td>');
					}else{
						if( $tnp_st_time_7 == '' && $tnp_ed_time_7 == '' ){
							print('<td align="center" colspan="4" background="../img_' . $lang_cd . '/bg_kimidori_235x20.png"><font size="2" color="blue">各曜日の時間と同様</font></td>');
						}else{
							print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_55x20.png">&nbsp;</td>');
							$div = intval($tnp_st_time_7 / 100);
							$mod = $tnp_st_time_7 % 100;
							print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
							print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_20x20.png">～</td>');
							$div = intval($tnp_ed_time_7 / 100);
							$mod = $tnp_ed_time_7 % 100;
							print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
						}
					}
					print('</tr>');
					//木曜・祝日
					print('<tr>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">木曜</td>');
					print('<input type="hidden" name="teikyu_4" value="' . $teikyu_4 . '">');
					print('<input type="hidden" name="tnp_st_time_4" value="' . $tnp_st_time_4 . '">');
					print('<input type="hidden" name="tnp_ed_time_4" value="' . $tnp_ed_time_4 . '">');
					if( $teikyu_4 == 'on' ){
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><b>レ</b></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
					}else{
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">&nbsp;</td>');
						$div = intval($tnp_st_time_4 / 100);
						$mod = $tnp_st_time_4 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
						$div = intval($tnp_ed_time_4 / 100);
						$mod = $tnp_ed_time_4 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					}
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_110x20.png">祝日</td>');
					if( $teikyu_8 == 'on' ){
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_55x20.png"><b>レ</b></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_80x20.png">&nbsp;</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_20x20.png">～</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_80x20.png">&nbsp;</td>');
					}else{
						if( $tnp_st_time_8 == '' && $tnp_ed_time_8 == '' ){
							print('<td align="center" colspan="4" background="../img_' . $lang_cd . '/bg_mura_235x20.png"><font size="2" color="blue">各曜日の時間と同様</font>	</td>');
						}else{
							print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_55x20.png">&nbsp;</td>');
							$div = intval($tnp_st_time_8 / 100);
							$mod = $tnp_st_time_8 % 100;
							print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
							print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_20x20.png">～</td>');
							$div = intval($tnp_ed_time_8 / 100);
							$mod = $tnp_ed_time_8 % 100;
							print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
						}
					}
					print('</tr>');
					//金曜
					print('<tr>');
					print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">金曜</td>');
					if( $teikyu_5 == 'on' ){
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><b>レ</b></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">&nbsp;</td>');
					}else{
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">&nbsp;</td>');
						$div = intval($tnp_st_time_5 / 100);
						$mod = $tnp_st_time_5 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
						$div = intval($tnp_ed_time_5 / 100);
						$mod = $tnp_ed_time_5 % 100;
						print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><font color="blue"><b>' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</b></font></td>');
					}
					print('<td bgcolor="#cccccc">&nbsp;</td>');
					print('<td bgcolor="#cccccc">&nbsp;</td>');
					print('<td bgcolor="#cccccc">&nbsp;</td>');
					print('<td bgcolor="#cccccc">&nbsp;</td>');
					print('<td bgcolor="#cccccc">&nbsp;</td>');
					print('</tr>');
					print('</table>');
					
					print('</td>');
					print('</tr>');
					print('</table>');
					
					print('<br>');

					//有効期間
					print('<b>有効期間(*)</b>・・・上記営業時間の有効期間<br>');
					print('<table border="0">');
					print('<tr>');
					print('<td align="left">');
					print('開始日<br>');
					print('<font color="blue" size="5"><b>' . $st_year . '</b></font>');
					print('年');
					print('<font color="blue" size="5"><b>' . $st_month . '</b></font>');
					print('月');
					print('<font color="blue" size="5"><b>' . $st_day . '</b></font>');
					print('日 から');
					print('</td>');
					print('<td align="left">');
					print('終了日<font size="2">&nbsp;(現在の最大日は2037/12/31)</font><br>');
					print('<font color="blue" size="5"><b>' . $ed_year . '</b></font>');
					print('年');
					print('<font color="blue" size="5"><b>' . $ed_month . '</b></font>');
					print('月');
					print('<font color="blue" size="5"><b>' . $ed_day . '</b></font>');
					print('日 まで');
					print('</td>');
					print('</tr>');
					print('</table>');
		
					//有効無効／登録ボタン／戻るボタン
					print('<table border="0">');
					print('<tr>');
					print('<td width="815" align="left">');
					print('<b>有効／無効(*)</b><br>');
					if( $yukou_flg == 1 ){
						print('<font color="blue" size="5"><b>有効</b></font>');
					}else{
						print('<font color="red" size="5"><b>無効</b></font>');
					}
					print('<br><font size="2" color="red">&nbsp;無効&nbsp;</font><font size="2">にすると予約システム上には表示されません。</font>');
					print('</td>');
					print('<td align="right">');
					print('<form method="post" action="kanri_eigyojkn_select.php">');
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
	}

	mysql_close( $link );
?>
</body>
</html>
