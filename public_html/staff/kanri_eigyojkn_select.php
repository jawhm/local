<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理画面－営業時間（選択）</title>
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
	$gmn_id = 'kanri_eigyojkn_select.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_top.php','kanri_eigyojkn_top.php',
					'kanri_eigyojkn_trk0.php','kanri_eigyojkn_trk1.php','kanri_eigyojkn_trk2.php',
					'kanri_eigyojkn_ksn0.php','kanri_eigyojkn_ksn1.php','kanri_eigyojkn_ksn2.php',
					'kanri_eigyojkn_del1.php','kanri_eigyojkn_del2.php',
					'kanri_eigyojknkbt_trk0.php','kanri_eigyojknkbt_trk1.php','kanri_eigyojknkbt_trk2.php',
					'kanri_eigyojknkbt_ksn0.php','kanri_eigyojknkbt_ksn1.php','kanri_eigyojknkbt_ksn2.php',
					'kanri_eigyojknkbt_del1.php','kanri_eigyojknkbt_del2.php'
					);

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

	//表示用現在時刻を求める
	$DFymdHis = date( "Y-m-d H:i:s", time() );

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
		print('<img src="./img_' . $lang_cd . '/btn_shinkitrk_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_henkou_2.png" width="0" height="0" style="visibility:hidden;">');


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
				
		
		//データが存在するかチェックする
		//営業時間マスタ
		$Meigyojkn_cnt = 0;
		$query = 'select YOUBI_CD,TEIKYUBI_FLG,OFFICE_ST_TIME,OFFICE_ED_TIME,YUKOU_FLG,ST_DATE,ED_DATE,UPDATE_TIME,UPDATE_STAFF_CD from M_EIGYOJKN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" order by ST_DATE desc,YOUBI_CD;';
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
			while( $row = mysql_fetch_array($result) ){
				$Meigyojkn_youbi_cd[$Meigyojkn_cnt] = $row[0];		//曜日コード 0:日,1:月,2:火,3:水,4:木,5:金,6:土,7:土日祝の前日.8:祝日
				$Meigyojkn_teikyubi_flg[$Meigyojkn_cnt] = $row[1];	//定休日フラグ 0:営業日 1:定休日
				$Meigyojkn_st_time[$Meigyojkn_cnt] = $row[2];		//開店時刻
				$Meigyojkn_ed_time[$Meigyojkn_cnt] = $row[3];		//閉店時刻
				$Meigyojkn_yukou_flg[$Meigyojkn_cnt] = $row[4];		//有効フラグ 0：無効　1:有効
				$Meigyojkn_st_date[$Meigyojkn_cnt] = $row[5];		//開始日
				$Meigyojkn_ed_date[$Meigyojkn_cnt] = $row[6];		//終了日
				$Meigyojkn_update_time[$Meigyojkn_cnt] = $row[7];	//更新日時
				$Meigyojkn_update_staff[$Meigyojkn_cnt] = $row[8];	//更新スタッフコード
				$Meigyojkn_cnt++;
			}
		}
		
		//営業時間個別
		$Deigyojknkbt_cnt = 0;
		$query = 'select YMD,OFFICE_ST_TIME,OFFICE_ED_TIME,UPDATE_TIME,UPDATE_STAFF_CD from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" order by YMD desc;';
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
			$log_naiyou = '営業時間個別マスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
						
		}else{
			while( $row = mysql_fetch_array($result) ){
				$Deigyojknkbt_ymd[$Deigyojknkbt_cnt] = $row[0];
				$Deigyojknkbt_st_time[$Deigyojknkbt_cnt] = $row[1];
				$Deigyojknkbt_ed_time[$Deigyojknkbt_cnt] = $row[2];
				$Deigyojknkbt_update_time[$Deigyojknkbt_cnt] = $row[3];
				$Deigyojknkbt_update_staff[$Deigyojknkbt_cnt] = $row[4];
				$Deigyojknkbt_cnt++;
			}
		}
		
		//登録オフィス数を求める（全期間・無効を含む）
		$trk_office_su = 0;
		$query = 'select count(*) from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '";';
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
			$trk_office_su = $row[0];
		}
		
		
		if( $err_flg == 0 ){
			
			print('<center>');
		
			//ページ編集
			print('<table bgcolor="pink"><tr><td width="950">');
			print('<img src="./img_' . $lang_cd . '/bar_kanri_eigyojkn.png" border="0">');
			print('</td></tr></table>');
	
			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
			if( $trk_office_su == 1 ){
				print('<form method="post" action="kanri_top.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			}else{
				print('<form method="post" action="kanri_eigyojkn_top.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			}
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');

			print('<hr>');

			//登録フォーム
			print('【曜日指定】・・・曜日毎に営業時間を設定します。<br>');

			//（曜日別）新規登録ボタン
			$edit_flg = 0;
			if( $Meigyojkn_cnt == 0 ){
				$edit_flg = 1;
			}else if( $Meigyojkn_ed_date[0] != "2037-12-31" ){
				$edit_flg = 1;
			}
			if( $edit_flg == 1 ){
				print('<form name="form2" method="post" action="kanri_eigyojkn_trk0.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_shinkitrk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_shinkitrk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_shinkitrk_1.png\';" onClick="kurukuru()" border="0">');
				print('</form>');
			}else{
				print('<br><font size="2" color="red">（期間追加する場合は、登録済みの有効期間を短縮してください。）</font>');
				
			}


			if( $Meigyojkn_cnt > 0 ){
				print('<font size="2">（' . $DFymdHis . ' 時点）</font>');
				print('<table border="1">');
				print('<tr>');
				print('<td width="80" align="center" bgcolor="powderblue">&nbsp;</td>');
				print('<td width="180" align="center" bgcolor="powderblue">有効期間<br><font size="2">（開始日～終了日）</font></td>');
				if( $Moffice_start_youbi == 0 ){
					print('<td width="55" align="center" background="../img_' . $lang_cd . '/bg_pink_55x20.png"><font color="red">日</font></td>');
				}
				print('<td width="55" align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">月</td>');
				print('<td width="55" align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">火</td>');
				print('<td width="55" align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">水</td>');
				print('<td width="55" align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">木</td>');
				print('<td width="55" align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png">金</td>');
				print('<td width="55" align="center" background="../img_' . $lang_cd . '/bg_blue_55x20.png"><font color="blue">土</font></td>');
				if( $Moffice_start_youbi == 1 ){
					print('<td width="55" align="center" background="../img_' . $lang_cd . '/bg_pink_55x20.png"><font color="red">日</font></td>');
				}
				print('<td width="55" align="center" background="../img_' . $lang_cd . '/bg_kimidori_55x20.png">休前</td>');
				print('<td width="55" align="center" background="../img_' . $lang_cd . '/bg_mura_55x20.png"><font color="red">祝日</font></td>');
				print('<td width="110" align="center" bgcolor="powderblue">更新者</td>');
				print('</tr>');
				
				$i = 0;
				while($i < $Meigyojkn_cnt ){
					
					//タイトル編集（変更ボタン・有効期間）
					if( ($Moffice_start_youbi == 0 && $Meigyojkn_youbi_cd[$i] == 0 ) ||
						($Moffice_start_youbi == 1 && $Meigyojkn_youbi_cd[$i] == 1 ) ){
						//日曜始まりで日曜日 または 月曜始まりで月曜日の場合
						
						//背景色設定
						if($Meigyojkn_yukou_flg[$i] == 0 || $Meigyojkn_ed_date[$i] < $now_yyyymmdd2 ){
							//無効 または 過去データ
							$bgfile_1 = 'bg_lightgrey';	//平日色
							$bgfile_2 = 'bg_lightgrey';	//土曜色
							$bgfile_3 = 'bg_lightgrey';	//日曜色
							$bgfile_4 = 'bg_lightgrey';	//休前日色
							$bgfile_5 = 'bg_lightgrey';	//祝日
						}else if( $Meigyojkn_st_date[$i] <= $now_yyyymmdd2 && $now_yyyymmdd2 <= $Meigyojkn_ed_date[$i] ){
							//現在データ
							$bgfile_1 = 'bg_mizu';	//平日色
							$bgfile_2 = 'bg_blue';	//土曜色
							$bgfile_3 = 'bg_pink';	//日曜色
							$bgfile_4 = 'bg_kimidori';	//休前日色
							$bgfile_5 = 'bg_mura';	//祝日
						}else{
							//未来データ
							$bgfile_1 = 'bg_yellow';	//平日色
							$bgfile_2 = 'bg_yellow';	//土曜色
							$bgfile_3 = 'bg_yellow';	//日曜色
							$bgfile_4 = 'bg_yellow';	//休前日色
							$bgfile_5 = 'bg_yellow';	//祝日
						}
						print('<tr>');
						print('<form name="form3' . sprintf("%02d",$i) . '" method="post" action="kanri_eigyojkn_ksn0.php">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
						print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
						print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
						print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
						print('<input type="hidden" name="select_st_date" value="' . $Meigyojkn_st_date[$i] . '">');
						print('<input type="hidden" name="select_ed_date" value="' . $Meigyojkn_ed_date[$i] . '">');
	
						print('<td width="50" height="40" align="center" background="../img_' . $lang_cd . '/' . $bgfile_1 . '_80x20.png">');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="../img_' . $lang_cd . '/btn_henkou_1.png" onmouseover="this.src=\'../img_' . $lang_cd . '/btn_henkou_2.png\';" onmouseout="this.src=\'../img_' . $lang_cd . '/btn_henkou_1.png\';" onClick="kurukuru()" border="0">');
						print('</td>');
						print('</form>');
						
						print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile_1 . '_180x20.png"><font size="2">' . substr($Meigyojkn_st_date[$i],0,4) . '年&nbsp;' . sprintf("%d",substr($Meigyojkn_st_date[$i],5,2)) . '月&nbsp;' . sprintf("%d",substr($Meigyojkn_st_date[$i],8,2)) . '日&nbsp;から<br>' . substr($Meigyojkn_ed_date[$i],0,4) . '年&nbsp;' . sprintf("%d",substr($Meigyojkn_ed_date[$i],5,2)) . '月&nbsp;' . sprintf("%d",substr($Meigyojkn_ed_date[$i],8,2)) . '日&nbsp;まで</font>');
						if( $Meigyojkn_yukou_flg[$i] == 0 ){
							print('<br><font size="1" color="red">【無効】</font>');
						}
						print('</td>');
					}
					
					
					//月曜始まりの場合、土曜日の後に日曜日を表示する
					if( $Moffice_start_youbi == 1 && ( ( $i % 9 ) == 7 ) ){
						 //休前日の前に日曜を表示する
						print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile_3 . '_55x20.png">');
						if( $Meigyojkn_teikyubi_flg[($i-7)] == 1 ){
							print('<font size="2">定休日</font>');
						}else if( $Meigyojkn_st_time[($i-7)] != '' && $Meigyojkn_ed_time[($i-7)] != '' ){
							$div = intval($Meigyojkn_st_time[($i-7)] / 100);
							$mod = $Meigyojkn_st_time[($i-7)] % 100;
							print('<font size="2">' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '<br>');
							$div = intval($Meigyojkn_ed_time[($i-7)] / 100);
							$mod = $Meigyojkn_ed_time[($i-7)] % 100;
							print('～' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</font>');
						}else{
							print('←');
						}
						print('</td>');
					}
					
					//曜日毎の編集
					//if( $Moffice_start_youbi == 1 && ( ( $i % 9 ) != 0 ) ){
					if( $Moffice_start_youbi == 0 || ( $Moffice_start_youbi == 1 && ( ( $i % 9 ) != 0 ) ) ){
						print('<td align="center" background="../img_' . $lang_cd . '/');
						if( $Meigyojkn_youbi_cd[$i] == 0 ){
							//日曜
							print( $bgfile_3 );
						}else if( $Meigyojkn_youbi_cd[$i] == 6 ){
							//土曜
							print( $bgfile_2 );
						}else if( $Meigyojkn_youbi_cd[$i] == 7 ){
							//休前日
							print( $bgfile_4 );
						}else if( $Meigyojkn_youbi_cd[$i] == 8 ){
							//祝日
							print( $bgfile_5 );
						}else{
							//平日
							print( $bgfile_1 );
						}
						print('_55x20.png">');
						if( $Meigyojkn_teikyubi_flg[$i] == 1 ){
							print('<font size="2" color="red">定休日</font>');
						}else if( $Meigyojkn_st_time[$i] != '' && $Meigyojkn_ed_time[$i] != '' ){
							$div = intval($Meigyojkn_st_time[$i] / 100);
							$mod = $Meigyojkn_st_time[$i] % 100;
							print('<font size="2">' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '<br>');
							$div = intval($Meigyojkn_ed_time[$i] / 100);
							$mod = $Meigyojkn_ed_time[$i] % 100;
							print('～' . sprintf("%02d",$div) . ':' . sprintf("%02d",$mod) . '</font>');
						}else{
							print('←');
						}
						print('</td>');
					}
					
					//祝日データの後に更新者を表示する
					if( $Meigyojkn_youbi_cd[$i] == 8 ){	//祝日データの場合のみ
						// 更新者・更新日時
						print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile_1 . '_110x20.png">');
						print( $Meigyojkn_update_staff[$i] );
						print('<br><font size="1">' . $Meigyojkn_update_time[$i] . '</font></td>');
						print('</tr>');
					}
					$i++;
				}
				print('</table>');
			}

			if( $Meigyojkn_cnt == 0 ){
				print('<font color="blue">※登録データはありません。</font><br>');	
			}


			print('<hr>');
			print('【個別指定】・・・日付指定で営業時間を設定します<br>');

			//（個別）新規登録ボタン
			print('<form name="form2" method="post" action="kanri_eigyojknkbt_trk0.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_shinkitrk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_shinkitrk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_shinkitrk_1.png\';" onClick="kurukuru()" border="0">');
			print('</form>');

			if( $Deigyojknkbt_cnt > 0 ){
				print('<font size="2">（' . $DFymdHis . ' 時点）</font>');
				print('<table border="1">');
				print('<tr>');
				print('<td width="80" bgcolor="powderblue" align="center">&nbsp;</td>');
				print('<td width="235" bgcolor="powderblue" align="center">対象日</font></td>');
				print('<td width="180" bgcolor="powderblue" align="center">営業時間</td>');
				print('<td width="110" bgcolor="powderblue" align="center">更新者</td>');
				print('</tr>');
				$i = 0;
				while($i < $Deigyojknkbt_cnt ){
					$select_year = substr($Deigyojknkbt_ymd[$i],0,4);					//対象年
					$select_month = sprintf("%d",substr($Deigyojknkbt_ymd[$i],5,2));	//対象月
					$select_day = sprintf("%d",substr($Deigyojknkbt_ymd[$i],8,2));		//対象月
					
					
					
					//カレンダーから営業日フラグを取得
					$eigyoubi_flg = 8;	//0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
					$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $Deigyojknkbt_ymd[$i] . '";';
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
						while( $row = mysql_fetch_array($result) ){
							$eigyoubi_flg = $row[0];	//営業日フラグ
						}
					}
					
					//背景色とフォント色を決める
					$tmp_yyyy = substr( $Deigyojknkbt_ymd[$i],0,4);	//対象年
					$tmp_mm = substr( $Deigyojknkbt_ymd[$i],5,2);	//対象月
					$tmp_dd = substr( $Deigyojknkbt_ymd[$i],8,2);	//対象日
					$tmp_youbi = date("w", mktime(0, 0, 0, $tmp_mm, $tmp_dd, $tmp_yyyy));
					$bgfile = 'bg_mizu';
					$fontcolor = "black";
					if( $eigyoubi_flg == 8 || $eigyoubi_flg == 9 ){
						//非営業日
						$bgfile = 'bg_lightgrey';
						$fontcolor = "gray";
					}elseif( $eigyoubi_flg == 1 || $tmp_youbi == 0 ){
						//祝日・日曜
						$bgfile = 'bg_pink';
						$fontcolor = "red";
					}elseif( $tmp_youbi == 6 ){
						//土曜
						$bgfile = 'bg_blue';
						$fontcolor = "blue";
					}
					
					print('<tr>');
					print('<form name="form4' . sprintf("%02d",$i) . '" method="post" action="kanri_eigyojknkbt_ksn0.php">');
					print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
					print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
					print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
					print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
					print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
					print('<input type="hidden" name="select_year" value="' . $select_year . '">');
					print('<input type="hidden" name="select_month" value="' . $select_month . '">');
					print('<input type="hidden" name="select_day" value="' . $select_day . '">');
	
					print('<td width="50" height="40" align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					$tabindex++;
					print('<input type="image" tabindex="' . $tabindex . '" src="../img_' . $lang_cd . '/btn_henkou_1.png" onmouseover="this.src=\'../img_' . $lang_cd . '/btn_henkou_2.png\';" onmouseout="this.src=\'../img_' . $lang_cd . '/btn_henkou_1.png\';" onClick="kurukuru()" border="0">');
					print('</td>');
					print('</form>');
					
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_235x20.png">');
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
					
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png">');
					if( $eigyoubi_flg == 8 || $eigyoubi_flg == 9 ){
						print('<font color="gray">');	
					}
					$div = intval($Deigyojknkbt_st_time[$i] / 100);
					$mod = $Deigyojknkbt_st_time[$i] % 100;
					print('<font size="5">' . $div . ':' . sprintf("%02d",$mod ) . '</font>');
					print('&nbsp;～&nbsp;');
					$div = intval($Deigyojknkbt_ed_time[$i] / 100);
					$mod = $Deigyojknkbt_ed_time[$i] % 100;
					print('<font size="5">' . $div . ':' . sprintf("%02d",$mod ) . '</font>');
					if( $eigyoubi_flg == 8 || $eigyoubi_flg == 9 ){
						print('</font><br><font size="2" color="red">非営業日</font>');
					}
					print('</td>');
					
					print('<td align="center" background="../img_' . $lang_cd . '/' . $bgfile . '_110x20.png">');
					print( $Deigyojknkbt_update_staff[$i] );
					print('<br><font size="1">' . $Deigyojknkbt_update_time[$i] . '</font></td>');
					print('</tr>');

					$i++;
				}
				print('</table>');
			}
			if( $Deigyojknkbt_cnt == 0 ){
				print('<font color="blue">※登録データはありません。</font><br>');	
			}
						
			print('</center>');
			
			print('<hr>');
		}
	}

	mysql_close( $link );
?>
</body>
</html>