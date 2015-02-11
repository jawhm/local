<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>スケジュール－個別カウンセリング受付人数登録</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
<style type="text/css">
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
	$gmn_id = 'sc_kbt_trk_ninzu.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('sc_kbt_trk_selectdate.php','sc_kbt_trk_ninzu_res.php');

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
	$select_ymd = $_POST['select_ymd'];

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_ymd == "" ){
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
		
		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');

		//店舗メニューボタン表示
		require( './zs_menu_button.php' );


		//最大人数
		$max_ninzu = 5;


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
			$Moffice_office_nm = $row[0];		//オフィス名
			$Moffice_start_youbi = $row[1];	//開始曜日（ 0:日曜始まり 1:月曜始まり ）
		}


		//選択日の週の先頭を求める
		$tmp_sabun = 0;
		if( $Moffice_start_youbi == 0 ){
			//*** 日曜始まり ***
			//選択日の曜日を求める
			$tmp_sabun = date("w", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), sprintf("%d",substr($select_ymd,6,2)), sprintf("%d",substr($select_ymd,0,4))));
		}else{
			//*** 月曜始まり ***
			//選択日の曜日を求める
			$tmp_sabun = date("w", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), sprintf("%d",substr($select_ymd,6,2)), sprintf("%d",substr($select_ymd,0,4)))) - 1;
			if( $tmp_sabun < 0 ){
				$tmp_sabun += 6;
			}
		}
		$target_yyyymmdd = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), (sprintf("%d",substr($select_ymd,6,2)) - $tmp_sabun) , sprintf("%d",substr($select_ymd,0,4))) );
		$target_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), sprintf("%d",substr($target_yyyymmdd,6,2)), sprintf("%d",substr($target_yyyymmdd,0,4))));


		if( $err_flg == 0 ){
			//営業時間マスタを読み込む（選択日の週の先頭以降）･･･９レコード１セット
			$Meigyojkn_cnt = 0;
			$query = 'select YOUBI_CD,TEIKYUBI_FLG,OFFICE_ST_TIME,OFFICE_ED_TIME,ST_DATE,ED_DATE from M_EIGYOJKN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YUKOU_FLG = 1 and ED_DATE >= "' . $target_yyyymmdd . '" order by YOUBI_CD,ST_DATE;';
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
					$Meigyojkn_st_time[$Meigyojkn_cnt] = $row[2];		//開始時刻
					$Meigyojkn_ed_time[$Meigyojkn_cnt] = $row[3];		//終了時刻
					$tmp_date = $row[4];
					$Meigyojkn_st_date[$Meigyojkn_cnt] = intval(substr($tmp_date,0,4) . substr($tmp_date,5,2) . substr($tmp_date,8,2));
					$tmp_date = $row[5];
					$Meigyojkn_ed_date[$Meigyojkn_cnt] = intval(substr($tmp_date,0,4) . substr($tmp_date,5,2) . substr($tmp_date,8,2));
					$Meigyojkn_cnt++;
				}
			}
		}


		if( $err_flg == 0 ){
			//ページ編集
			print('<center>');
			
			print('<table bgcolor="lightgreen"><tr><td width="950">');
			print('<img src="./img_' . $lang_cd . '/bar_sc_kbt_menu.png" border="0">');
			print('</td></tr></table>');
	
			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
			print('<form method="post" action="sc_kbt_trk_selectdate.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_yyyy" value="' . substr($select_ymd,0,4) . '">');
			print('<input type="hidden" name="select_mm" value="' . sprintf("%d",substr($select_ymd,4,2)) . '">');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
		
			print('<hr>');
	
			print('<form method="post" action="sc_kbt_trk_ninzu_res.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
	
			$t = 0;
			while( $t < 7 ){
	
				//選択日に有効な時間割を取得する
				$Mclassjknwr_cnt = 0;
				$query = 'select JKN_KBN,ST_TIME,ED_TIME from M_CLASS_JKNWR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and ST_DATE <= "' . $target_yyyymmdd . '" and "' . $target_yyyymmdd . '" <= ED_DATE and YUKOU_FLG = 1 order by TSUBAN;';
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
					$log_naiyou = 'クラス時間割の参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
			
				}else{
					while( $row = mysql_fetch_array($result) ){
						$Mclassjknwr_jkn_kbn[$Mclassjknwr_cnt] = $row[0];	//時間区分
						$Mclassjknwr_st_time[$Mclassjknwr_cnt] = $row[1];	//開始時刻
						$Mclassjknwr_ed_time[$Mclassjknwr_cnt] = $row[2];	//終了時刻
						$Mclassjknwr_cnt++;
					}
				}
				
				//営業日フラグを求める
				$target_eigyoubi_flg = 0;
				if( $err_flg == 0 ){
					$target_eigyoubi_flg = 0;	//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
					$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD  = "' . $target_yyyymmdd . '";';
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
				}
				
				
				//営業時間と定休日フラグを求める
				$target_eigyou_st_time = 0;
				$target_eigyou_ed_time = 0;
				$target_teikyubi_flg = 0;	//定休日フラグ　0:営業日 1:定休日
				$find_flg = 0;
				if( $target_eigyoubi_flg == 1 || $target_eigyoubi_flg == 9 ){
					//祝日のみ対応（土日祝の前日は非対応）
					$a = 0;
					while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
						if( $Meigyojkn_youbi_cd[$a] == 8 && $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ){
							if( $Meigyojkn_st_time[$a] != "" ){
								$target_eigyou_st_time = $Meigyojkn_st_time[$a];
								$target_eigyou_ed_time = $Meigyojkn_ed_time[$a];
								$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
								$find_flg = 1;
								
							}else{
								if( $Meigyojkn_teikyubi_flg[$a] != 1 ){
									//曜日で検索しなおし
									$a = 0;
									while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
										if( ( $Meigyojkn_youbi_cd[$a] == $target_youbi_cd ) &&
											( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
											$target_eigyou_st_time = $Meigyojkn_st_time[$a];
											$target_eigyou_ed_time = $Meigyojkn_ed_time[$a];
											$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
											$find_flg = 1;
										}
										$a++;
									}
								}else{
									$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
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
							( $Meigyojkn_st_date[$a] <= $target_yyyymmdd && $target_yyyymmdd <= $Meigyojkn_ed_date[$a] ) ){
							if( $Meigyojkn_teikyubi_flg[$a] != 1 ){
								$target_eigyou_st_time = $Meigyojkn_st_time[$a];
								$target_eigyou_ed_time = $Meigyojkn_ed_time[$a];
								$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
								$find_flg = 1;
							}else{
								$target_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
								$find_flg = 1;
							}
						}
						$a++;
					}
				}
				
				//定休日の場合、営業日個別に登録されていた場合は、営業日扱いとする
				if( $target_teikyubi_flg == 1 ){
					$query = 'select OFFICE_ST_TIME,OFFICE_ED_TIME from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '";';
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
						while( $row = mysql_fetch_array($result) ){
							if( $row[0] != "" ){
								$target_eigyou_st_time = $row[0];
							}
							if( $row[1] != "" ){
								$target_eigyou_ed_time = $row[1];
							}
							$target_teikyubi_flg = 0;
						}
					}
				}
		
				//イベントチェック
				$event_cnt = 0;
				$query = 'select id,starttime,endtime,k_title2,group_color from event_list where hiduke = "' . $target_yyyymmdd . '" and place = "' . $select_office_cd . '" and k_use = 1 order by starttime;';
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
					$log_naiyou = 'イベントの参照に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
							
				}else{
					while( $row = mysql_fetch_array($result) ){
						$event_id[$event_cnt] = $row[0];			//イベントID
						$event_starttime[$event_cnt] = $row[1];		//イベント開始時刻
						$event_endtime[$event_cnt] = $row[2];		//イベント終了時刻
						$event_title[$event_cnt] = $row[3];			//イベント名
						$event_group_color[$event_cnt] = $row[4];	//グループカラー
						$event_cnt++;
					}
				}
				
	
				//年月日表示
				if( $target_eigyoubi_flg == 1 || $target_eigyoubi_flg == 9 ){
					//祝日
					$fontcolor = "red";
				}else if( $target_youbi_cd == 0 ){
					//日曜
					$fontcolor = "red";
				}else if( $target_youbi_cd == 6 ){
					//土曜
					$fontcolor = "blue";
				}else{
					//平日
					$fontcolor = "black";
				}
					
				
				print('<table width="880" border="0">');
				print('<tr>');
				print('<td id="' . $target_yyyymmdd . '" width="80" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/yyyy_' . substr($target_yyyymmdd,0,4) . '_black.png" border="0"></td>');	//年
				print('<td width="65" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/mm_' . sprintf("%d",substr($target_yyyymmdd,4,2)) . '_' . $fontcolor . '.png" border="0"></td>');	//月
				print('<td width="65" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/dd_' . sprintf("%d",substr($target_yyyymmdd,6,2)) . '_' . $fontcolor . '.png" border="0"></td>');	//日
				print('<td width="40" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/youbi_' . $target_youbi_cd . '_' . $fontcolor . '.png" border="0"></td>');	//曜日
				//一括セット セレクトボックス
				print('<td width="630" align="left" valign="bottom">');
				print('<img src="./img_' . $lang_cd . '/title_ikkatsusettei.png" border="0">');
				$tabindex++;
				print('<select name="ninzu_ikt' . $t . '" class="normal" style="font-size:16pt;" tabindex="' . $tabindex . '" >');
				print('<option value="">***</option>');
				$n = 0;
				while( $n <= $max_ninzu ){
					print('<option value="' . $n . '">' . $n . '名</option>');
					$n++;
				}
				print('</select>');
				print('<img src="./img_' . $lang_cd . '/title_ikkatsusettei_2.png" border="0">');
				print('</td>');
				print('</tr>');
				print('</table>');


				print('<table border="1">');
				print('<tr>');
				
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){
					print('<td width="110" align="center" valign="middle" ');
					if( $target_teikyubi_flg == 1 ){
						//定休日
						print('background="../img_' . $lang_cd . '/bg_yellow_110x20.png"');
					}else if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
						//営業時間外
						print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
					}else if( in_array($Mclassjknwr_jkn_kbn[$j] , $jkn_kbn_array_1) ){
						//メンバー および 一般 の時間区分
						print('background="../img_' . $lang_cd . '/bg_blue_110x20.png"');
					}else{
						//メンバーのみ の時間区分
						print('background="../img_' . $lang_cd . '/bg_pink_110x20.png"');
					}
					print('>');
					
					print( intval($Mclassjknwr_st_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_st_time[$j] % 100)) . '-' . intval($Mclassjknwr_ed_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_ed_time[$j] % 100)) );
					print('</td>');
					$j++;
				}			
				print('</tr>');
				
				//イベント情報
				$e = 0;
				while( $e < $event_cnt ){
					
					//開始時刻と終了時刻を求める
					$tmp_st_time = sprintf("%d",substr($event_starttime[$e],11,2)) * 100 + sprintf("%d",substr($event_starttime[$e],14,2));
					$tmp_ed_time = sprintf("%d",substr($event_endtime[$e],11,2)) * 100 + sprintf("%d",substr($event_endtime[$e],14,2));
				
					//時間割の何番目からスタートし、何番目で終了するかチェックする
					$tmp_st_cnt = 0;
					$tmp_ed_cnt = 0;
					$find_flg = 0;	//0:見つからない 1:開始見つかる 2:開始と終了みつかる
					while( $tmp_st_cnt < $Mclassjknwr_cnt && $find_flg == 0 ){
						if( $Mclassjknwr_st_time[$tmp_st_cnt] <= $tmp_st_time && $tmp_st_time < $Mclassjknwr_ed_time[$tmp_st_cnt] ){
							$find_flg = 1;
							$tmp_ed_cnt = $tmp_st_cnt;
							while( $tmp_ed_cnt < $Mclassjknwr_cnt && $find_flg == 1 ){
								if( $Mclassjknwr_st_time[$tmp_ed_cnt] < $tmp_ed_time && $tmp_ed_time <= $Mclassjknwr_ed_time[$tmp_ed_cnt] ){
									$find_flg = 2;
								}else if( $tmp_ed_time <= $Mclassjknwr_st_time[$tmp_ed_cnt] ){
									$find_flg = 2;
									$tmp_ed_cnt--;
								}else{
									$tmp_ed_cnt++;
								}
							}
							if( $find_flg == 1 ){
								$tmp_ed_cnt = $Mclassjknwr_cnt - 1;
							}
						}else{
							$tmp_st_cnt++;
						}
					}
					
					if( $find_flg != 0 ){
						//時間割の開始添字・終了添字が判明
						
						//前後の空白を求める
						$tmp_bf_colspan = 1 + $tmp_st_cnt - 1;
						$tmp_ev_colspan = $tmp_ed_cnt - $tmp_st_cnt + 1;
						$tmp_af_colspan = $Mclassjknwr_cnt - $tmp_ed_cnt - 1;
						
						print('<tr>');
						
						//イベント前
						if( $tmp_bf_colspan > 0 ){
							if( $tmp_bf_colspan <= $tmp_af_colspan ){
								//時刻表示
								print('<td align="right" valign="bottom" width="' . ($tmp_bf_colspan * 110) . '" colspan="' . $tmp_bf_colspan . '" bgcolor="lightgrey">');
								print('<font size="1">' . intval($tmp_st_time / 100) . ':' . sprintf("%02d",($tmp_st_time % 100)) . '-' . intval($tmp_ed_time / 100) . ':' . sprintf("%02d",($tmp_ed_time % 100)) . '</font>');
								if( $tmp_af_colspan == 0 ){
									//内容表示
									print('&nbsp;<font size="1">' . $event_title[$e] . '</font>');
								}
								print('</td>');
							}else{
								print('<td align="right" valign="bottom" width="' . ($tmp_bf_colspan * 110) . '" colspan="' . $tmp_bf_colspan . '" bgcolor="lightgrey">');
								if( $tmp_af_colspan == 0 ){
									//時刻表示
									print('<font size="1">' . intval($tmp_st_time / 100) . ':' . sprintf("%02d",($tmp_st_time % 100)) . '-' . intval($tmp_ed_time / 100) . ':' . sprintf("%02d",($tmp_ed_time % 100)) . '</font>&nbsp;');
								}
								//内容表示
								print('<font size="1">' . $event_title[$e] . '</font>');
								print('</td>');
							}
						}
						
						//イベント中
						print('<td align="center" valign="middle" colspan="' . $tmp_ev_colspan . '" bgcolor="' . $event_group_color[$e] . '">');
						print('<img src="./img_' . $lang_cd . '/bar_event_' . ($tmp_ev_colspan * 110) . 'x20.png" border="0" title="[' . $event_id[$e] . '] ' . intval($tmp_st_time / 100) . ':' . sprintf("%02d",($tmp_st_time % 100)) . '-' . intval($tmp_ed_time / 100) . ':' . sprintf("%02d",($tmp_ed_time % 100)) . '&nbsp;&nbsp;' . $event_title[$e] . '">');
						print('</td>');
						
						//イベント後
						if( $tmp_af_colspan > 0 ){
							if( $tmp_bf_colspan <= $tmp_af_colspan ){
								print('<td align="left" valign="bottom" width="' . ($tmp_af_colspan * 110) . '" colspan="' . $tmp_af_colspan . '" bgcolor="lightgrey">');
								if( $tmp_bf_colspan == 0 ){
									//時刻表示
									print('<font size="1">' . intval($tmp_st_time / 100) . ':' . sprintf("%02d",($tmp_st_time % 100)) . '-' . intval($tmp_ed_time / 100) . ':' . sprintf("%02d",($tmp_ed_time % 100)) . '</font>&nbsp;');
								}
								//内容表示
								print('<font size="1">' . $event_title[$e] . '</font>');
								print('</td>');
							}else{
								//時刻表示
								print('<td align="left" valign="bottom" colspan="' . $tmp_af_colspan . '" bgcolor="lightgrey">');
								print('<font size="1">' . intval($tmp_st_time / 100) . ':' . sprintf("%02d",($tmp_st_time % 100)) . '-' . intval($tmp_ed_time / 100) . ':' . sprintf("%02d",($tmp_ed_time % 100)) . '</font>');
								if( $tmp_bf_colspan == 0 ){
									//内容表示
									print('&nbsp;<font size="1">' . $event_title[$e] . '</font>');
								}
								print('</td>');
							}
						}
						
						print('</tr>');
					
					}
					
					$e++;
				}
								
				//人数セレクトボックス
				print('<tr>');
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){
					
					//該当日／時間割のスタッフスケジュールを参照し、現在の受付人数を取得する
					$tmp_uktk_ninzu = '';
					$query = 'select UKTK_NINZU from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '";';
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
						$log_naiyou = 'スタッフスケジュールの参照に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************
								
					}else{
						while( $row = mysql_fetch_array($result) ){
							$tmp_uktk_ninzu = $row[0];	//受付人数
						}
					}
				
					print('<td width="110" align="center" valign="middle" ');
					if( $target_teikyubi_flg == 1 ){
						//定休日
						print('background="../img_' . $lang_cd . '/bg_yellow_110x20.png"');
					}else if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
						//営業時間外
						print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
					}else if( in_array($Mclassjknwr_jkn_kbn[$j] , $jkn_kbn_array_1) ){
						//メンバー および 一般 の時間区分
						print('background="../img_' . $lang_cd . '/bg_blue_110x20.png"');
					}else{
						//メンバーのみ の時間区分
						print('background="../img_' . $lang_cd . '/bg_pink_110x20.png"');
					}
					print('>');

					if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
						//営業時間外
						print('<input type="hidden" name="ninzu' . $t . $Mclassjknwr_jkn_kbn[$j] . '" value="">');
						print('<img src="../img_' . $lang_cd . '/title_eigyou_jkngai.png" border="0">');
						
					}else{
						//営業時間内

						$tabindex++;
						print('<select name="ninzu' . $t . $Mclassjknwr_jkn_kbn[$j] . '" class="normal" style="font-size:16pt;" tabindex="' . $tabindex . '" >');
						print('<option value="" ');
						if( $tmp_uktk_ninzu == "" ){
							print(' selected');	
						}
						print('>***</option>');
						$n = 0;
						while( $n <= $max_ninzu ){
							print('<option value="' . $n . '"');
							if( $tmp_uktk_ninzu != "" && $tmp_uktk_ninzu == $n ){
								print(' selected');
							}
							print('>' . $n . '名</option>');
							$n++;
						}
						print('</select>');
					}
				
					print('</td>');
				
					$j++;
				}			
				print('</tr>');

				//現在予約数
				print('<tr>');
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){
					
					//該当日／時間割のスタッフスケジュールを参照し、現在の受付人数を取得する
					$tmp_yyk_cnt = 0;
					$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $target_yyyymmdd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '";';
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
						$log_naiyou = 'クラス予約の参照に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************
								
					}else{
						while( $row = mysql_fetch_array($result) ){
							$tmp_yyk_cnt = $row[0];		//現在予約数
						}
					}
				
					print('<td width="110" align="center" valign="middle" ');
					if( $target_teikyubi_flg == 1 ){
						//定休日
						print('background="../img_' . $lang_cd . '/bg_yellow_110x20.png"');
					}else if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
						//営業時間外
						print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
					}else if( in_array($Mclassjknwr_jkn_kbn[$j] , $jkn_kbn_array_1) ){
						//メンバー および 一般 の時間区分
						print('background="../img_' . $lang_cd . '/bg_blue_110x20.png"');
					}else{
						//メンバーのみ の時間区分
						print('background="../img_' . $lang_cd . '/bg_pink_110x20.png"');
					}
					print('>');

					if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
						//営業時間外
						print('<input type="hidden" name="ninzu' . $t . $Mclassjknwr_jkn_kbn[$j] . '" value="">');
						print('<img src="../img_' . $lang_cd . '/title_eigyou_jkngai.png" border="0">');
						
					}else{
						//営業時間内
						if( $tmp_yyk_cnt > 0 ){
							$fontcolor = "red";
						}else{
							$fontcolor = "blue";
						}
						print('<font size="1">予約数</font>&nbsp;<font color="' . $fontcolor . '">' . $tmp_yyk_cnt . '</font>&nbsp;<font size="1">名</font>');
					}
				
					print('</td>');
				
					$j++;
				}			
				print('</tr>');
				
				print('</table>');
	
				print('<hr>');
	
				//翌日にする
				$target_yyyymmdd = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), (sprintf("%d",substr($target_yyyymmdd,6,2)) + 1) , sprintf("%d",substr($target_yyyymmdd,0,4))) );
				$target_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), sprintf("%d",substr($target_yyyymmdd,6,2)), sprintf("%d",substr($target_yyyymmdd,0,4))));
				$t++;
			}
			
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
			print('<form method="post" action="sc_kbt_trk_selectdate.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_yyyy" value="' . substr($select_ymd,0,4) . '">');
			print('<input type="hidden" name="select_mm" value="' . sprintf("%d",substr($select_ymd,4,2)) . '">');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
	
			print('</center>');
				
			print('<hr>');
		}
	}

	mysql_close( $link );
?>
</body>
</html>