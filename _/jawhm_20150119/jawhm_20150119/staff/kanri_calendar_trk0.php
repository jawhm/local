<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>管理画面－カレンダー（編集中）</title>
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
	$gmn_id = 'kanri_calendar_trk0.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_calendar_list.php','kanri_calendar_trk0.php','kanri_calendar_trk2.php');

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

	//固有引数の取得
	$select_office_cd = $_POST['select_office_cd'];	//選択したオフィスコード
	$select_yyyy = $_POST['select_yyyy'];			//選択した年
	$select_mm = $_POST['select_mm'];				//選択した月

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_yyyy == "" || $select_mm == "" ){
				$err_flg = 3;
			}else{
				//数字チェック（年）
				if( is_numeric( $select_yyyy ) ){
					if( $select_yyyy < 2012 || 2037 < $select_yyyy ){
						$err_flg = 3;
					}
				}else{
					$err_flg = 3;
				}
					
				//数字チェック（月）
				if( is_numeric( $select_mm ) ){
					if( $select_mm < 1 || 12 < $select_mm ){
						$err_flg = 3;
					}
				}else{
					$err_flg = 3;
				}
				
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

		//メニューボタン表示
		require( './zs_menu_button.php' );

		//オフィスマスタの取得
		$query = 'select OFFICE_NM,START_YOUBI,ST_DATE,ED_DATE from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '";';
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
			$Moffice_start_youbi = $row[1];	//開始曜日　0:日曜始まり　1:月曜始まり
			$Moffice_st_date = $row[2];		//開始日
			$Moffice_ed_date = $row[3];		//終了日
			
		}

		//前月を求める
		$zen_yyyy = $select_yyyy;
		$zen_mm = $select_mm - 1;
		if( $zen_mm == 0 ){
			$zen_yyyy--;
			$zen_mm = 12;
		}
		//翌月を求める
		$yoku_yyyy = $select_yyyy;
		$yoku_mm = $select_mm + 1;
		if( $yoku_mm == 13 ){
			$yoku_yyyy++;
			$yoku_mm = 1;
		}
		
		//営業時間マスタを読み込む（終了日が表示年月１日以降）
		$Meigyojkn_cnt = 0;
		$query = 'select YOUBI_CD,TEIKYUBI_FLG,OFFICE_ST_TIME,ST_DATE,ED_DATE from M_EIGYOJKN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YUKOU_FLG = 1 and ED_DATE >= "' . $select_yyyy . '-' . sprintf("%02d",$select_mm) . '-01" order by YOUBI_CD,ST_DATE;';
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
		
		//カレンダーマスタを読み込む（表示年月１日のみ）
		$target_eigyoubi_flg = 0;	//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
		$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD  = "' . $select_yyyy . '-' . sprintf("%02d",$select_mm) . '-01";';
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
			$log_naiyou = 'カレンダーマスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************

		}else{
			while( $row = mysql_fetch_array($result) ){
				$target_eigyoubi_flg = $row[0];		//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
			}
		}

		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_zengetsu_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_yokugetsu_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');

		
		if( $err_flg == 0 ){
			//登録フォーム
			
			print('<center>');
		
			//ページ編集
			print('<table bgcolor="pink"><tr><td width="950">');
			print('<img src="./img_' . $lang_cd . '/bar_kanri_calender.png" border="0">');
			print('</td></tr></table>');

			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
			print('<form method="post" action="kanri_calendar_list.php">');
			print('<td align="right">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_yyyy" value="' . $select_yyyy . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
	
			print('<hr>');
	
			print('<table border="0">');
			print('<tr>');
			
			//前月表示ボタン
			print('<form method="post" action="kanri_calendar_trk0.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_yyyy" value="' . $zen_yyyy . '">');
			print('<input type="hidden" name="select_mm" value="' . $zen_mm . '">');
			print('<td width="140" align="center" valign="middle">');
			if( $zen_yyyy < 2012 ){
				print('&nbsp;');
			}else{
				print('<font size="2">' . $zen_yyyy . '年&nbsp;' . $zen_mm .'月へ</font><br>');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_zengetsu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_zengetsu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_zengetsu_1.png\';" onClick="kurukuru()" border="0">');
			}
			print('</td>');
			print('</form>');
			
			print('<td align="center" valign="middle">');
			print('<font size="6">&nbsp;&nbsp;&nbsp;&nbsp;'. $select_yyyy . '年&nbsp;' . $select_mm . '月　編集中&nbsp;&nbsp;&nbsp;&nbsp;</font><br><font size="2" color="red">（※内容変更した場合は&nbsp;登録ボタン&nbsp;を押下してください。）</font>');
			print('</td>');
			
			//翌月表示ボタン
			print('<form method="post" action="kanri_calendar_trk0.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_yyyy" value="' . $yoku_yyyy . '">');
			print('<input type="hidden" name="select_mm" value="' . $yoku_mm . '">');
			print('<td width="140" align="center" valign="middle">');
			if( $yoku_yyyy >= 2038 ){
				print('&nbsp;');
			}else{
				print('<font size="2">' . $yoku_yyyy . '年&nbsp;' . $yoku_mm .'月へ</font><br>');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_yokugetsu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_yokugetsu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_yokugetsu_1.png\';" onClick="kurukuru()" border="0">');
			}
			print('</td>');
			print('</form>');
			
			print('</tr>');
			print('</table>');

			print('<form method="post" action="kanri_calendar_trk2.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_yyyy" value="' . $select_yyyy . '">');
			print('<input type="hidden" name="select_mm" value="' . $select_mm . '">');
	
			//色説明
			print('<table border="0">');
			print('<tr>');
			print('<td width="950" align="center">');
			
			print('<table border="1">');
			print('<tr>');
			print('<td width="80" align="center" bgcolor="white">平日</td>');
			print('<td width="80" align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">土曜</td>');
			print('<td width="80" align="center" background="../img_' . $lang_cd . '/bg_pink_80x20.png">日曜</td>');
			print('<td width="80" align="center" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"><font size="1">土日祝の前日</font></td>');
			print('<td width="80" align="center" background="../img_' . $lang_cd . '/bg_mura_80x20.png">祝日</td>');
			print('<td width="80" align="center" background="../img_' . $lang_cd . '/bg_yellow_80x20.png"><font size="2">定休日</font></td>');
			print('<td width="80" align="center" background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"><font size="2">非営業日</font></td>');
			print('</tr>');
			print('</table>');

			print('</td>');
			print('</tr>');
			print('</table>');
	
			//カレンダー
			print('<table border="1">');
			//曜日編集
			print('<tr>');
			if( $Moffice_start_youbi == 0 ){	//日曜始まり
				print('<td width="110" align="center" background="../img_' . $lang_cd . '/bg_pink_110x20.png">日</td>');
			}
			print('<td width="110" align="center" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png">月</td>');
			print('<td width="110" align="center" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png">火</td>');
			print('<td width="110" align="center" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png">水</td>');
			print('<td width="110" align="center" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png">木</td>');
			print('<td width="110" align="center" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png">金</td>');
			print('<td width="110" align="center" background="../img_' . $lang_cd . '/bg_mizu_110x20.png">土</td>');
			if( $Moffice_start_youbi == 1 ){	//月曜始まり
				print('<td width="110" align="center" background="../img_' . $lang_cd . '/bg_pink_110x20.png">日</td>');
			}
			print('</tr>');
			$d = 1;	//添字（日）
			$max_dd = cal_days_in_month(CAL_GREGORIAN, $select_mm , $select_yyyy );
			//１週目の処理
			$tmp_youbi = date("w", mktime(0, 0, 0, $select_mm, $d, $select_yyyy));	//１日の曜日を求める
			print('<tr>');
			if( $Moffice_start_youbi == 0 ){	//日曜始まり
				$i = 0;
				while( $i < $tmp_youbi ){
					print('<td align="center" bgcolor="lightgrey">-</td>');
					$i++;
				}
				while( $i < 7 ){
					//現在処理している日
					$target_yyyymmdd = intval( $select_yyyy . sprintf("%02d",$select_mm) . sprintf("%02d",$d) );
						
					//翌日の営業日フラグを求める
					$zz_next_eigyoubi_flg_yyyy = $select_yyyy;
					$zz_next_eigyoubi_flg_mm = $select_mm;
					$zz_next_eigyoubi_flg_dd = $d;
					require( '../zz_next_eigyoubi_flg.php' );

					//対象日の曜日コードを求める
					$target_youbi = $i;
					if( $target_eigyoubi_flg == 1 || $target_eigyoubi_flg == 9 ){
						//祝日
						$target_youbi = 8;	//8:祝日
					
					}else if( $i == 5 ){
						//金曜
						$target_youbi = 7;	//7:土日祝の前日
							
					}else if( ($i >= 1 && $i <= 4 ) && ($zz_next_eigyoubi_flg == 1 || $zz_next_eigyoubi_flg == 9 ) ){
						//月曜から木曜 で かつ 翌日が 祝日
						$target_youbi = 7;	//7:土日祝の前日
					}
						
					//定休日フラグを求める
					$target_teikyubi_flg = 0;	//定休日フラグ　0:営業日 1:定休日
					$find_flg = 0;
					$a = 0;
					while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
						//開始日と終了日の範囲内の曜日から定休日フラグを設定する
						if( ( $Meigyojkn_youbi_cd[$a] == $target_youbi ) &&
							( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
							if( $Meigyojkn_st_time[$a] != "" || $Meigyojkn_teikyubi_flg[$a] == 1 ){
								$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
							}else{
								//曜日で検索しなおし
								$a = 0;
								while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
									if( ( $Meigyojkn_youbi_cd[$a] == $i ) &&
										( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
										$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
										$find_flg = 1;
									}
									$a++;
								}
							}
							$find_flg = 1;
						}
						$a++;	
					}
					//定休日の場合、営業日個別に登録されていた場合は、営業日扱いとする
					if( $target_teikyubi_flg == 1 ){
						$query = 'select count(*) from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_yyyy . '-' . sprintf("%02d",$select_mm) . '-' . sprintf("%02d",$d)  . '";';
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
							if( $row[0] == 1 ){
								$target_teikyubi_flg = 0;
							}
						}
					}
					
					//背景色
					$bgfile = "";
					if( $target_youbi == 8 ){
						//祝日
						$bgfile = "bg_mura";
					}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
						//非営業日
						$bgfile = "bg_lightgrey";
					}else if( $target_teikyubi_flg == 1 ){
						//定休日
						$bgfile = "bg_yellow";
					}else if( $target_youbi == 0 ){
						//日曜
						$bgfile = "bg_pink";
					}else if( $target_youbi == 6 ){
						//土曜
						$bgfile = "bg_mizu";
					}else if( $target_youbi == 7 ){
						//土日祝の前日
						$bgfile = "bg_kimidori";
					}
					
					//編集
					if( $bgfile == "" ){
						print('<td align="center" valign="top" bgcolor="white">');
					}else{
						print('<td align="center" valign="top" background="../img_' . $lang_cd . '/' . $bgfile . '_110x20.png">');
					}
					print('<font size="6" ');
					if( $target_youbi == 0 || $target_youbi == 8 ){
						print('color="red"');
					}else if( $target_youbi == 6 ){
						print('color="blue"');
					}else{
						print('color="black"');
					}
					print('>' . $d . '</font><br>');
					if( $target_teikyubi_flg == 1 ){
						print('<font color="red">定休日</font><br>');
//						print('<input type="hidden" name="eigyoubi_flg' . $d . '" value="' . $target_eigyoubi_flg . '">');
						$tabindex++;
						print('<select name="eigyoubi_flg' . $d . '" class="normal" tabindex="' . $tabindex . '">');
						print('<option value="0" class="color1" ');
						if( $target_eigyoubi_flg == 0 ){
						   print('selected');
						}
						print('>営業日</option>');
						print('<option value="8" ');
						if( $target_eigyoubi_flg == 8 ){
						   print('selected');
						}
						print('>非営業日</option>');
						print('<option value="1" class="color2" ');
						if( $target_eigyoubi_flg == 1 ){
						   print('selected');
						}
						print('>祝日営業日</option>');
						print('<option value="9" ');
						if( $target_eigyoubi_flg == 9 ){
						   print('selected');
						}
						print('>祝日非営業日</option>');
						print('</select>');
					}else{
						if( $target_eigyoubi_flg == 0 ){
							print('<font color="blue">営業日</font><br>');
						}else if( $target_eigyoubi_flg == 1 ){
							print('<font color="red">祝日営業日</font><br>');
						}else if( $target_eigyoubi_flg == 8 ){
							print('非営業日<br>');
						}else if( $target_eigyoubi_flg == 9 ){
							print('祝日非営業日<br>');
						}
						$tabindex++;
						print('<select name="eigyoubi_flg' . $d . '" class="normal" tabindex="' . $tabindex . '">');
						print('<option value="0" class="color1" ');
						if( $target_eigyoubi_flg == 0 ){
						   print('selected');
						}
						print('>営業日</option>');
						print('<option value="8" ');
						if( $target_eigyoubi_flg == 8 ){
						   print('selected');
						}
						print('>非営業日</option>');
						print('<option value="1" class="color2" ');
						if( $target_eigyoubi_flg == 1 ){
						   print('selected');
						}
						print('>祝日営業日</option>');
						print('<option value="9" ');
						if( $target_eigyoubi_flg == 9 ){
						   print('selected');
						}
						print('>祝日非営業日</option>');
						print('</select>');
					}
					print('</td>');
					
					//次の処理のため、翌日の営業日フラグを当日分にコピーする
					$target_eigyoubi_flg = $zz_next_eigyoubi_flg;
					
					$i++;
					$d++;
				}
				
			}else{	//月曜始まり
				$i = 1;
				if( $tmp_youbi == 0 ){
					$tmp_youbi = 7;
				}
				while( $i < $tmp_youbi ){
					print('<td align="center" bgcolor="lightgrey">-</td>');
					$i++;
				}
				while( $i < 8 ){
					//現在処理している日
					$target_yyyymmdd = intval( $select_yyyy . sprintf("%02d",$select_mm) . sprintf("%02d",$d) );
					
					//翌日の営業日フラグを求める
					$zz_next_eigyoubi_flg_yyyy = $select_yyyy;
					$zz_next_eigyoubi_flg_mm = $select_mm;
					$zz_next_eigyoubi_flg_dd = $d;
					require( '../zz_next_eigyoubi_flg.php' );
					
					//対象日の曜日コードを求める
					$target_youbi = $i;
					if($target_youbi == 7 ){
						$target_youbi = 0;	//日曜日の曜日コード
					}
					if( $target_eigyoubi_flg == 1 || $target_eigyoubi_flg == 9 ){
						//祝日
						$target_youbi = 8;	//8:祝日
					
					}else if( $i == 5 ){
						//金曜
						$target_youbi = 7;	//7:土日祝の前日
						
					}else if( ($i >= 1 && $i <= 4 ) && ($zz_next_eigyoubi_flg == 1 || $zz_next_eigyoubi_flg == 9 ) ){
						//月曜から木曜 で かつ 翌日が 祝日
						$target_youbi = 7;	//7:土日祝の前日
					}
					
					//定休日フラグを求める
					$target_teikyubi_flg = 0;	//定休日フラグ　0:営業日 1:定休日
					$find_flg = 0;
					$a = 0;
					while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
						//開始日と終了日の範囲内の曜日から定休日フラグを設定する
						if( ( $Meigyojkn_youbi_cd[$a] == $target_youbi ) &&
							( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
							if( $Meigyojkn_st_time[$a] != "" || $Meigyojkn_teikyubi_flg[$a] == 1 ){
								$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
							}else{
								//曜日で検索しなおし
								$a = 0;
								while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
									if( $i != 7 ){
										if( ( $Meigyojkn_youbi_cd[$a] == $i ) &&
											( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
											$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
											$find_flg = 1;
										}
									}else{
										if( ( $Meigyojkn_youbi_cd[$a] == 0 ) &&
											( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
											$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
											$find_flg = 1;
										}
										
									}
									$a++;
								}
							}
							$find_flg = 1;
						}
						$a++;	
					}
					//定休日の場合、営業日個別に登録されていた場合は、営業日扱いとする
					if( $target_teikyubi_flg == 1 ){
						$query = 'select count(*) from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_yyyy . '-' . sprintf("%02d",$select_mm) . '-' . sprintf("%02d",$d)  . '";';
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
							if( $row[0] == 1 ){
								$target_teikyubi_flg = 0;
							}
						}
					}
					
					//背景色
					$bgfile = "";
					if( $target_youbi == 8 ){
						//祝日
						$bgfile = "bg_mura";
					}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
						//非営業日
						$bgfile = "bg_lightgrey";
					}else if( $target_teikyubi_flg == 1 ){
						//定休日
						$bgfile = "bg_yellow";
					}else if( $target_youbi == 0 ){
						//日曜
						$bgfile = "bg_pink";
					}else if( $target_youbi == 6 ){
						//土曜
						$bgfile = "bg_mizu";
					}else if( $target_youbi == 7 ){
						//土日祝の前日
						$bgfile = "bg_kimidori";
					}
					
					//編集
					if( $bgfile == "" ){
						print('<td align="center" valign="top" bgcolor="white">');
					}else{
						print('<td align="center" valign="top" background="../img_' . $lang_cd . '/' . $bgfile . '_110x20.png">');
					}
					print('<font size="6" ');
					if( $target_youbi == 0 || $target_youbi == 8 ){
						print('color="red"');
					}else if( $target_youbi == 6 ){
						print('color="blue"');
					}else{
						print('color="black"');
					}
					print('>' . $d . '</font><br>');
					if( $target_teikyubi_flg == 1 ){
						print('<font color="red">定休日</font><br>');
//						print('<input type="hidden" name="eigyoubi_flg' . $d . '" value="' . $target_eigyoubi_flg . '">');
						$tabindex++;
						print('<select name="eigyoubi_flg' . $d . '" class="normal" tabindex="' . $tabindex . '">');
						print('<option value="0" class="color1" ');
						if( $target_eigyoubi_flg == 0 ){
						   print('selected');
						}
						print('>営業日</option>');
						print('<option value="8" ');
						if( $target_eigyoubi_flg == 8 ){
						   print('selected');
						}
						print('>非営業日</option>');
						print('<option value="1" class="color2" ');
						if( $target_eigyoubi_flg == 1 ){
						   print('selected');
						}
						print('>祝日営業日</option>');
						print('<option value="9" ');
						if( $target_eigyoubi_flg == 9 ){
						   print('selected');
						}
						print('>祝日非営業日</option>');
						print('</select>');
					}else{
						if( $target_eigyoubi_flg == 0 ){
							print('<font color="blue">営業日</font><br>');
						}else if( $target_eigyoubi_flg == 1 ){
							print('<font color="red">祝日営業日</font><br>');
						}else if( $target_eigyoubi_flg == 8 ){
							print('非営業日<br>');
						}else if( $target_eigyoubi_flg == 9 ){
							print('祝日非営業日<br>');
						}
						$tabindex++;
						print('<select name="eigyoubi_flg' . $d . '" class="normal" tabindex="' . $tabindex . '">');
						print('<option value="0" class="color1" ');
						if( $target_eigyoubi_flg == 0 ){
						   print('selected');
						}
						print('>営業日</option>');
						print('<option value="8" ');
						if( $target_eigyoubi_flg == 8 ){
						   print('selected');
						}
						print('>非営業日</option>');
						print('<option value="1" class="color2" ');
						if( $target_eigyoubi_flg == 1 ){
						   print('selected');
						}
						print('>祝日営業日</option>');
						print('<option value="9" ');
						if( $target_eigyoubi_flg == 9 ){
						   print('selected');
						}
						print('>祝日非営業日</option>');
						print('</select>');
					}
					
					print('</td>');

					//次の処理のため、翌日の営業日フラグを当日分にコピーする
					$target_eigyoubi_flg = $zz_next_eigyoubi_flg;

					$i++;
					$d++;
				}
			}
			print('</tr>');
			
			//２週目以降の処理
			while( $d <= $max_dd ){
				if( $Moffice_start_youbi == 0 ){	//日曜始まり
					print('<tr>');
					$y = 0;
					while( $d <= $max_dd && $y < 7 ){
								
						//現在処理している日
						$target_yyyymmdd = intval( $select_yyyy . sprintf("%02d",$select_mm) . sprintf("%02d",$d) );
						
						//翌日の営業日フラグを求める
						$zz_next_eigyoubi_flg_yyyy = $select_yyyy;
						$zz_next_eigyoubi_flg_mm = $select_mm;
							$zz_next_eigyoubi_flg_dd = $d;
						require( '../zz_next_eigyoubi_flg.php' );

						//対象日の曜日コードを求める
						$target_youbi = $y;
						if( $target_eigyoubi_flg == 1 || $target_eigyoubi_flg == 9 ){
							//祝日
							$target_youbi = 8;	//8:祝日
						
						}else if( $y == 5 ){
							//金曜
							$target_youbi = 7;	//7:土日祝の前日
							
						}else if( ($y >= 1 && $y <= 4 ) && ($zz_next_eigyoubi_flg == 1 || $zz_next_eigyoubi_flg == 9 ) ){
							//月曜から木曜 で かつ 翌日が 祝日
							$target_youbi = 7;	//7:土日祝の前日
						}
					
						//定休日フラグを求める
						$target_teikyubi_flg = 0;	//定休日フラグ　0:営業日 1:定休日
						$find_flg = 0;
						$a = 0;
						while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
							//開始日と終了日の範囲内の曜日から定休日フラグを設定する
							if( ( $Meigyojkn_youbi_cd[$a] == $target_youbi ) &&
								( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
								if( $Meigyojkn_st_time[$a] != "" || $Meigyojkn_teikyubi_flg[$a] == 1 ){
									$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
								}else{
									//曜日で検索しなおし
									$a = 0;
									while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
										if( ( $Meigyojkn_youbi_cd[$a] == $y ) &&
											( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
											$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
											$find_flg = 1;
										}
										$a++;
									}
								}
								$find_flg = 1;
							}
							$a++;	
						}
						//定休日の場合、営業日個別に登録されていた場合は、営業日扱いとする
						if( $target_teikyubi_flg == 1 ){
							$query = 'select count(*) from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_yyyy . '-' . sprintf("%02d",$select_mm) . '-' . sprintf("%02d",$d)  . '";';
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
								if( $row[0] == 1 ){
									$target_teikyubi_flg = 0;
								}
							}
						}
				
						//背景色
						$bgfile = "";
						if( $target_youbi == 8 ){
							//祝日
							$bgfile = "bg_mura";
						}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
							//非営業日
							$bgfile = "bg_lightgrey";
						}else if( $target_teikyubi_flg == 1 ){
							//定休日
							$bgfile = "bg_yellow";
						}else if( $target_youbi == 0 ){
							//日曜
							$bgfile = "bg_pink";
						}else if( $target_youbi == 6 ){
							//土曜
							$bgfile = "bg_mizu";
						}else if( $target_youbi == 7 ){
							//土日祝の前日
							$bgfile = "bg_kimidori";
						}
						
						//編集
						if( $bgfile == "" ){
							print('<td align="center" valign="top" bgcolor="white">');
						}else{
							print('<td align="center" valign="top" background="../img_' . $lang_cd . '/' . $bgfile . '_110x20.png">');
						}
						print('<font size="6" ');
						if( $target_youbi == 0 || $target_youbi == 8 ){
							print('color="red"');
						}else if( $target_youbi == 6 ){
							print('color="blue"');
						}else{
							print('color="black"');
						}
						print('>' . $d . '</font><br>');
						if( $target_teikyubi_flg == 1 ){
							print('<font color="red">定休日</font><br>');
//							print('<input type="hidden" name="eigyoubi_flg' . $d . '" value="' . $target_eigyoubi_flg . '">');
							$tabindex++;
							print('<select name="eigyoubi_flg' . $d . '" class="normal" tabindex="' . $tabindex . '">');
							print('<option value="0" class="color1" ');
							if( $target_eigyoubi_flg == 0 ){
							   print('selected');
							}
							print('>営業日</option>');
							print('<option value="8" ');
							if( $target_eigyoubi_flg == 8 ){
							   print('selected');
							}
							print('>非営業日</option>');
							print('<option value="1" class="color2" ');
							if( $target_eigyoubi_flg == 1 ){
							   print('selected');
							}
							print('>祝日営業日</option>');
							print('<option value="9" ');
							if( $target_eigyoubi_flg == 9 ){
							   print('selected');
							}
							print('>祝日非営業日</option>');
							print('</select>');
						}else{
							if( $target_eigyoubi_flg == 0 ){
								print('<font color="blue">営業日</font><br>');
							}else if( $target_eigyoubi_flg == 1 ){
								print('<font color="red">祝日営業日</font><br>');
							}else if( $target_eigyoubi_flg == 8 ){
								print('非営業日<br>');
							}else if( $target_eigyoubi_flg == 9 ){
								print('祝日非営業日<br>');
							}
							$tabindex++;
							print('<select name="eigyoubi_flg' . $d . '" class="normal" tabindex="' . $tabindex . '">');
							print('<option value="0" class="color1" ');
							if( $target_eigyoubi_flg == 0 ){
							   print('selected');
							}
							print('>営業日</option>');
							print('<option value="8" ');
							if( $target_eigyoubi_flg == 8 ){
							   print('selected');
							}
							print('>非営業日</option>');
							print('<option value="1" class="color2" ');
							if( $target_eigyoubi_flg == 1 ){
							   print('selected');
							}
							print('>祝日営業日</option>');
							print('<option value="9" ');
							if( $target_eigyoubi_flg == 9 ){
							   print('selected');
							}
							print('>祝日非営業日</option>');
							print('</select>');
						}
						
						print('</td>');

						//次の処理のため、翌日の営業日フラグを当日分にコピーする
						$target_eigyoubi_flg = $zz_next_eigyoubi_flg;
						
						$d++;
						$y++;
					}
				
				}else{	//月曜始まり
					print('<tr>');
					$y = 1;
					while( $d <= $max_dd && $y < 8 ){
						
						//現在処理している日
						$target_yyyymmdd = intval( $select_yyyy . sprintf("%02d",$select_mm) . sprintf("%02d",$d) );
						
						//翌日の営業日フラグを求める
						$zz_next_eigyoubi_flg_yyyy = $select_yyyy;
						$zz_next_eigyoubi_flg_mm = $select_mm;
						$zz_next_eigyoubi_flg_dd = $d;
						require( '../zz_next_eigyoubi_flg.php' );

						//対象日の曜日コードを求める
						$target_youbi = $y;
						if( $target_youbi == 7 ){
							$target_youbi = 0;
						}
							
						if( $target_eigyoubi_flg == 1 || $target_eigyoubi_flg == 9 ){
							//祝日
							$target_youbi = 8;	//8:祝日
						
						}else if( $y == 5 ){
							//金曜
							$target_youbi = 7;	//7:土日祝の前日
							
						}else if( ($y >= 1 && $y <= 4 ) && ($zz_next_eigyoubi_flg == 1 || $zz_next_eigyoubi_flg == 9 ) ){
							//月曜から木曜 で かつ 翌日が 祝日
							$target_youbi = 7;	//7:土日祝の前日
						}
					
						//定休日フラグを求める
						$target_teikyubi_flg = 0;	//定休日フラグ　0:営業日 1:定休日
						$find_flg = 0;
						$a = 0;
						while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
							//開始日と終了日の範囲内の曜日から定休日フラグを設定する
							if( ( $Meigyojkn_youbi_cd[$a] == $target_youbi ) &&
								( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
								if( $Meigyojkn_st_time[$a] != "" || $Meigyojkn_teikyubi_flg[$a] == 1 ){
									$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
								}else{
									//曜日で検索しなおし
									$a = 0;
									while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
										if( $y != 7 ){
											if( ( $Meigyojkn_youbi_cd[$a] == $y ) &&
												( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
												$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
												$find_flg = 1;
											}
										}else{
											if( ( $Meigyojkn_youbi_cd[$a] == 0 ) &&
												( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
												$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
												$find_flg = 1;
											}
										}
										$a++;
									}
								}
								$find_flg = 1;
							}
							$a++;	
						}
						//定休日の場合、営業日個別に登録されていた場合は、営業日扱いとする
						if( $target_teikyubi_flg == 1 ){
							$query = 'select count(*) from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_yyyy . '-' . sprintf("%02d",$select_mm) . '-' . sprintf("%02d",$d)  . '";';
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
								if( $row[0] == 1 ){
									$target_teikyubi_flg = 0;
								}
							}
						}
					
						//背景色
						$bgfile = "";
						if( $target_youbi == 8 ){
							//祝日
							$bgfile = "bg_mura";
						}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
							//非営業日
							$bgfile = "bg_lightgrey";
						}else if( $target_teikyubi_flg == 1 ){
								//定休日
							$bgfile = "bg_yellow";
						}else if( $target_youbi == 0 ){
							//日曜
							$bgfile = "bg_pink";
						}else if( $target_youbi == 6 ){
							//土曜
							$bgfile = "bg_mizu";
						}else if( $target_youbi == 7 ){
							//土日祝の前日
							$bgfile = "bg_kimidori";
						}
						
						//編集
						if( $bgfile == "" ){
							print('<td align="center" valign="top" bgcolor="white">');
						}else{
							print('<td align="center" valign="top" background="../img_' . $lang_cd . '/' . $bgfile . '_110x20.png">');
						}
						print('<font size="6" ');
						if( $target_youbi == 0 || $target_youbi == 8 ){
							print('color="red"');
						}else if( $target_youbi == 6 ){
							print('color="blue"');
						}else{
							print('color="black"');
						}
						print('>' . $d . '</font><br>');
						if( $target_teikyubi_flg == 1 ){
							print('<font color="red">定休日</font><br>');
//							print('<input type="hidden" name="eigyoubi_flg' . $d . '" value="' . $target_eigyoubi_flg . '">');
							$tabindex++;
							print('<select name="eigyoubi_flg' . $d . '" class="normal" tabindex="' . $tabindex . '">');
							print('<option value="0" class="color1" ');
							if( $target_eigyoubi_flg == 0 ){
							   print('selected');
							}
							print('>営業日</option>');
							print('<option value="8" ');
							if( $target_eigyoubi_flg == 8 ){
							   print('selected');
							}
							print('>非営業日</option>');
							print('<option value="1" class="color2" ');
							if( $target_eigyoubi_flg == 1 ){
							   print('selected');
							}
							print('>祝日営業日</option>');
							print('<option value="9" ');
							if( $target_eigyoubi_flg == 9 ){
							   print('selected');
							}
							print('>祝日非営業日</option>');
							print('</select>');
						}else{
							if( $target_eigyoubi_flg == 0 ){
								print('<font color="blue">営業日</font><br>');
							}else if( $target_eigyoubi_flg == 1 ){
								print('<font color="red">祝日営業日</font><br>');
							}else if( $target_eigyoubi_flg == 8 ){
								print('非営業日<br>');
							}else if( $target_eigyoubi_flg == 9 ){
								print('祝日非営業日<br>');
							}
							$tabindex++;
							print('<select name="eigyoubi_flg' . $d . '" class="normal" tabindex="' . $tabindex . '">');
							print('<option value="0" class="color1" ');
							if( $target_eigyoubi_flg == 0 ){
							   print('selected');
							}
							print('>営業日</option>');
							print('<option value="8" ');
							if( $target_eigyoubi_flg == 8 ){
							   print('selected');
							}
							print('>非営業日</option>');
							print('<option value="1" class="color2" ');
							if( $target_eigyoubi_flg == 1 ){
							   print('selected');
							}
							print('>祝日営業日</option>');
							print('<option value="9" ');
							if( $target_eigyoubi_flg == 9 ){
							   print('selected');
							}
							print('>祝日非営業日</option>');
							print('</select>');
						}
						
						print('</td>');

						//次の処理のため、翌日の営業日フラグを当日分にコピーする
						$target_eigyoubi_flg = $zz_next_eigyoubi_flg;
						
						$d++;
						$y++;
					}
				
				}
			}
			
			//最終週の後処理
			if( $Moffice_start_youbi == 0 ){	//日曜始まり
				while( $y < 7 ){
					print('<td align="center" bgcolor="lightgrey">-</td>');
					$y++;
				}
				print('</tr>');
			
			}else{	//月曜始まり
				while( $y < 8 ){
					print('<td align="center" bgcolor="lightgrey">-</td>');
					$y++;
				}
				print('</tr>');
			
			}
			
			print('</table>');
			
			print('<br>');

			//登録ボタン
			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">&nbsp;</td>');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_trk_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_trk_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_trk_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			//戻るボタン
			print('<tr>');
			print('<td width="815" align="left">&nbsp;</td>');
			print('<form method="post" action="kanri_calendar_list.php">');
			print('<td align="right">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_yyyy" value="' . $select_yyyy . '">');
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

	mysql_close( $link );
?>
</body>
</html>
