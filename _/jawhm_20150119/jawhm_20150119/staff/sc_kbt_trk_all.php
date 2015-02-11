<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>スケジュール－個別カウンセリング受付登録</title>
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
	$gmn_id = 'sc_kbt_trk_all.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('sc_kbt_trk_selectdate.php','sc_kbt_trk_all.php','sc_kbt_trk_all_res.php');

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
	$select_staff_cd = $_POST['select_staff_cd'];	//未入力可（設定した場合、このスタッフコードのみ表示する）

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
		print('<img src="./img_' . $lang_cd . '/btn_cng_mini_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_trk_2.png" width="0" height="0" style="visibility:hidden;">');

		//店舗メニューボタン表示
		require( './zs_menu_button.php' );

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

		//個別カウンセラーを求める
		$Mstaff_cnt = 0;
		if( $err_flg == 0 ){
			$query = 'select STAFF_CD,DECODE(STAFF_NM,"' . $ANGpw . '"),ST_DATE,ED_DATE from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and (CLASS_CD1 = "KBT" || CLASS_CD2 = "KBT" || CLASS_CD3 = "KBT" || CLASS_CD4 = "KBT" || CLASS_CD5 = "KBT" ) and YUKOU_FLG = 1 and ED_DATE >= "' . $target_yyyymmdd . '" order by ST_DATE,STAFF_CD;';
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
				$log_naiyou = 'スタッフマスタの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
				
			}else{
				while( $row = mysql_fetch_array($result) ){
					$Mstaff_staff_cd[$Mstaff_cnt] = $row[0];	//スタッフコード
					$Mstaff_staff_nm[$Mstaff_cnt] = $row[1];	//スタッフ名
					$Mstaff_st_date[$Mstaff_cnt] = substr($row[2],0,4) . substr($row[2],5,2) . substr($row[2],8,2);		//開始日
					$Mstaff_ed_date[$Mstaff_cnt] = substr($row[3],0,4) . substr($row[3],5,2) . substr($row[3],8,2);		//終了日
					$Mstaff_cnt++;
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
			print('<td width="415" align="left"><img src="./img_' . $lang_cd . '/bar_officenm2.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
			print('<td width="400" align="left" valign="middle">');
			
			print('<table border="0">');	//sub
			print('<tr>');	//sub
			print('<td colspan="2" align="left" valign="middle"><img src="./img_' . $lang_cd . '/bar_disp_cng.png" border="0"></td>');
			print('</tr>');
			print('<tr>');
			print('<form method="post" action="sc_kbt_trk_all.php#' . $target_yyyymmdd . '">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $target_yyyymmdd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<td align="left" valign="middle">');
			$tabindex++;
			print('<select name="select_staff_cd" class="normal" style="font-size:12pt;" tabindex="' . $tabindex . '" >');
			print('<option value="" class="color2" ');
			if( $select_staff_cd == "" ){
				print(' selected');	
			}
			print('>全員表示</option>');
			$s = 0;
			while( $s < $Mstaff_cnt ){
				print('<option value="' . $Mstaff_staff_cd[$s] . '" class="color1" ');
				if( $select_staff_cd == $Mstaff_staff_cd[$s] ){
					print(' selected');	
				}
				print('>' . $Mstaff_staff_nm[$s] . '</option>');
				$s++;
			}
			print('</select>');
			print('</td>');
			print('<td align="left" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_cng_mini_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_cng_mini_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_cng_mini_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');	//sub
			print('</table>');	//sub
			
			print('</td>');
			print('<form method="post" action="sc_kbt_trk_selectdate.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_yyyy" value="' . substr($select_ymd,0,4) . '">');
			print('<input type="hidden" name="select_mm" value="' . sprintf("%d",substr($select_ymd,4,2)) . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
		
			print('<hr>');
	
			print('<form method="post" action="sc_kbt_trk_all_res.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
	
			$t = 0;
			while( $t < 7 ){

				print('<input type="hidden" name="edit_ymd_' . $t . '" value="' . $target_yyyymmdd . '">');

				$yykerr_flg = 0;

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
					
				

				print('<table border="1">');
				print('<tr>');
				
				print('<td colspan="3" align="center" valign="middle" bgcolor="moccasin">');
				print('<table border="0">');
				print('<tr>');
				print('<td id="' . $target_yyyymmdd . '" width="80" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/yyyy_' . substr($target_yyyymmdd,0,4) . '_black.png" border="0"></td>');	//年
				print('<td width="65" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/mm_' . sprintf("%d",substr($target_yyyymmdd,4,2)) . '_' . $fontcolor . '.png" border="0"></td>');	//月
				print('<td width="65" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/dd_' . sprintf("%d",substr($target_yyyymmdd,6,2)) . '_' . $fontcolor . '.png" border="0"></td>');	//日
				print('<td width="40" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/youbi_' . $target_youbi_cd . '_' . $fontcolor . '.png" border="0"></td>');	//曜日
				print('</tr>');
				print('</table>');
				
				print('</td>');
				
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){
					
					//現在の実予約数を取得する
					$yyk_cnt[$j] = 0;
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
						$row = mysql_fetch_array($result);
						$yyk_cnt[$j] = $row[0];		//実予約数
					}
					
					//該当日／時間割のスタッフスケジュールを参照し、現在の受付人数を取得する
					$uktk_cnt[$j] = 0;
					$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and OPEN_FLG = 1 and UKTK_FLG = 1;';
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
						$row = mysql_fetch_array($result);
						$uktk_cnt[$j] = $row[0];		//受付可能数
					}

					print('<td width="80" align="center" valign="middle" ');
					if( $yyk_cnt[$j] > $uktk_cnt[$j] ){
						//実予約数オーバー
						print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
						$yykerr_flg = 1;
						
					}else if( $target_teikyubi_flg == 1 ){
						//定休日
						print('background="../img_' . $lang_cd . '/bg_yellow_80x20.png"');
					}else if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
						//営業時間外
						print('background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"');
					}else if( in_array($Mclassjknwr_jkn_kbn[$j] , $jkn_kbn_array_1) ){
						//メンバー および 一般 の時間区分
						print('background="../img_' . $lang_cd . '/bg_mizu_80x20.png"');
					}else{
						//メンバーのみ の時間区分
						print('background="../img_' . $lang_cd . '/bg_pink_80x20.png"');
					}
					print('>');
					
					print('<b><font size="2">' . intval($Mclassjknwr_st_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_st_time[$j] % 100)) . '-' . intval($Mclassjknwr_ed_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_ed_time[$j] % 100)) );
					print('</font></b><br>');
					
					//現在予約数
					if( $target_teikyubi_flg == 1 ){
						//定休日
						print('<img src="./img_' . $lang_cd . '/title_teikyubi_80.png" border="0">');
					
					}else if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
						//営業時間外
						print('<img src="../img_' . $lang_cd . '/title_eigyou_jkngai_80.png" border="0">');
						
					}else{
						//営業時間内
						if( $yyk_cnt[$j] > 0 ){
							$fontcolor = "red";
						}else{
							$fontcolor = "blue";
						}
						print('<font size="1">予約数</font>&nbsp;<font color="' . $fontcolor . '">' . $yyk_cnt[$j] . '</font>&nbsp;<font size="1">名</font>');
					}
					
					print('</td>');
					
					
					//カウンセラーの予約受付可能数を求める
					$uktk_ok_cnt[$j] = 0;
					$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and OPEN_FLG = 1 and UKTK_FLG = 1;';
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
						$row = mysql_fetch_array($result);
						$uktk_ok_cnt[$j] = $row[0];		//予約受付可能数
					}
					
					
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
						print('<td colspan="3" align="left" valign="middle" bgcolor="lightgrey">&nbsp;&nbsp;[' . $event_id[$e] . '] ' . intval($tmp_st_time / 100) . ':' . sprintf("%02d",($tmp_st_time % 100)) . '-' . intval($tmp_ed_time / 100) . ':' . sprintf("%02d",($tmp_ed_time % 100)) . '</td>');
						
						//イベント前
						if( $tmp_bf_colspan > 0 ){
							if( $tmp_bf_colspan <= $tmp_af_colspan ){
								//時刻表示
								print('<td align="right" valign="bottom" width="' . ($tmp_bf_colspan * 80) . '" colspan="' . $tmp_bf_colspan . '" bgcolor="lightgrey">');
								print('<font size="1">' . intval($tmp_st_time / 100) . ':' . sprintf("%02d",($tmp_st_time % 100)) . '-' . intval($tmp_ed_time / 100) . ':' . sprintf("%02d",($tmp_ed_time % 100)) . '</font>');
								if( $tmp_af_colspan == 0 ){
									//内容表示
									print('&nbsp;<font size="1">' . $event_title[$e] . '</font>');
								}
								print('</td>');
							}else{
								print('<td align="right" valign="bottom" width="' . ($tmp_bf_colspan * 80) . '" colspan="' . $tmp_bf_colspan . '" bgcolor="lightgrey">');
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
						print('<img src="./img_' . $lang_cd . '/bar_event_' . ($tmp_ev_colspan * 80) . 'x20.png" border="0" title="[' . $event_id[$e] . '] ' . intval($tmp_st_time / 100) . ':' . sprintf("%02d",($tmp_st_time % 100)) . '-' . intval($tmp_ed_time / 100) . ':' . sprintf("%02d",($tmp_ed_time % 100)) . '&nbsp;&nbsp;' . $event_title[$e] . '">');
						print('</td>');
						
						//イベント後
						if( $tmp_af_colspan > 0 ){
							if( $tmp_bf_colspan <= $tmp_af_colspan ){
								print('<td align="left" valign="bottom" width="' . ($tmp_af_colspan * 80) . '" colspan="' . $tmp_af_colspan . '" bgcolor="lightgrey">');
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
								
				//カウンセラー（スタッフ）
				$edit_staff_cnt = 0;
				$s = 0;
				while( $s < $Mstaff_cnt ){
					
					if( ($select_staff_cd == "" || $select_staff_cd == $Mstaff_staff_cd[$s]) && $Mstaff_st_date[$s] <= $target_yyyymmdd && $target_yyyymmdd <= $Mstaff_ed_date[$s] ){

						//引数設定
						print('<input type="hidden" name="edit_staff_cd_' . $t . '_' . $edit_staff_cnt . '" value="' . $Mstaff_staff_cd[$s] . '">');
						
						//公開フラグを求める
						$tmp_open_flg = 0;	//公開フラグ  0:非公開 1:公開
						$query = 'select OPEN_FLG from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '" and STAFF_CD = "' . $Mstaff_staff_cd[$s] . '" and CLASS_CD = "KBT" order by JKN_KBN LIMIT 1;';
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
								$tmp_open_flg = $row[0];	//公開フラグ  0:非公開 1:公開
							}
						}
						
						
						//背景色設定
						if( $tmp_open_flg == 0 ){
							//非公開
							$bgfile = "bg_yellow";
						}else{
							//公開
							$bgfile = "bg_blue";
						}
						
						print('<tr>');
						//公開非公開フラグ
						print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
						if( $tmp_open_flg == 0 ){
							//非公開
							print('<img src="./img_' . $lang_cd . '/title_uktk_open_ng.png">');
						}else{
							//公開中
							print('<img src="./img_' . $lang_cd . '/title_uktk_open_ok.png">');
						}
						print('<br>');
						$tabindex++;
						print('<select name="edit_open_flg_' . $t . '_' . $edit_staff_cnt . '" class="normal" style="font-size:8pt;" tabindex="' . $tabindex . '" >');
						if( $tmp_open_flg == 0 ){
							print('<option value="0" class="color2" selected>非公開</option>');
							print('<option value="1" class="color1" >公開</option>');
						}else{
							print('<option value="0" class="color2" >非公開</option>');
							print('<option value="1" class="color1" selected>公開</option>');
						}
						print('</select>');
						print('</td>');
						//スタッフ名
						print('<td width="110" align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_110x20.png"><b>&nbsp;&nbsp;' . $Mstaff_staff_nm[$s] . '</b></td>');
						//一括登録
						print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
						print('<img src="./img_' . $lang_cd . '/title_uktk_ikt.png"><br>');
						print('<select name="edit_ikt_flg_' . $t . '_' . $edit_staff_cnt . '" class="normal" style="font-size:8pt;" tabindex="' . $tabindex . '" >');
						print('<option value="0" class="color0" selected>***</option>');
						print('<option value="1" class="color1" >受付可</option>');
						print('<option value="2" class="color2" >受付不可</option>');
						print('</select>');
						print('</td>');
						
						$j = 0;
						while( $j < $Mclassjknwr_cnt ){
	
							//該当時間帯のスタッフスケジュールを参照する
							$tmp_uktk_flg = 0;
							$query = 'select UKTK_FLG from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '" and STAFF_CD = "' . $Mstaff_staff_cd[$s] . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '";';
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
									$tmp_uktk_flg = $row[0];	//受付フラグ  0:未登録 1:受付可 2:受付不可
								}
							}
							
							//カウンセラー指名の予約があるかチェックする
							$tmp_shimei_flg = 0;
							$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $target_yyyymmdd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and STAFF_CD = "' . $Mstaff_staff_cd[$s] . '" ;';
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
								$row = mysql_fetch_array($result);
								if( $row[0] > 1 ){
									$tmp_shimei_flg = 1;
								}
							}
							
							
							print('<td width="80" align="center" valign="middle" ');
							if( $tmp_shimei_flg == 1 ){
								//カウンセラー指名の予約あり
								print('background="../img_' . $lang_cd . '/bg_blue_80x20.png"');
							}else if( $target_teikyubi_flg == 1 ){
								//定休日
								print('background="../img_' . $lang_cd . '/bg_yellow_80x20.png"');
							}else if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
								//営業時間外
								print('background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"');
							}else if( $tmp_open_flg == 0 ){
								//非公開
								print('background="../img_' . $lang_cd . '/bg_yellow_80x20.png"');
							}else if( $tmp_shimei_flg == 1 ){
								//指名予約
								print('background="../img_' . $lang_cd . '/bg_blue_80x20.png"');
							}else if( $tmp_uktk_flg == 2 ){
								//受付不可
								print('background="../img_' . $lang_cd . '/bg_pink_80x20.png"');
							}else if( $tmp_uktk_flg == 0 ){
								//未登録
								print('background="../img_' . $lang_cd . '/bg_yellow_80x20.png"');
							}else if( in_array($Mclassjknwr_jkn_kbn[$j] , $jkn_kbn_array_1) ){
								//メンバー および 一般 の時間区分
								print('background="../img_' . $lang_cd . '/bg_blue_80x20.png"');
							}else{
								//メンバーのみ の時間区分
								print('background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"');
							}
							print('>');
								
							if( $tmp_shimei_flg == 1 ){
								// ☆ 指名予約
								print('<img src="./img_' . $lang_cd . '/title_uktk_select_staff.png">');
							}else if( $tmp_uktk_flg == 1 ){
								// Ｏ 受付可
								print('<img src="./img_' . $lang_cd . '/title_uktk_ok.png">');
							}else if( $tmp_uktk_flg == 2 ){
								// Ｘ 受付不可
								print('<img src="./img_' . $lang_cd . '/title_uktk_ng.png">');
							}else{
								//未登録
								print('<img src="./img_' . $lang_cd . '/title_uktk_mitrk.png">');
							}
							print('<br>');
							$tabindex++;
							print('<select name="edit_uktk_flg_' . $t . '_' . $edit_staff_cnt . '_' . $Mclassjknwr_jkn_kbn[$j] . '" class="normal" style="font-size:8pt;" tabindex="' . $tabindex . '" >');
							if( $tmp_shimei_flg == 1 ){
								//指名あり
								print('<option value="1" class="color1" >受付可</option>');
								
							}else if( $tmp_open_flg == 1 && $tmp_uktk_flg == 1 && $yyk_cnt[$j] >= $uktk_ok_cnt[$j] ){
								//公開中で受付可で現在の予約数が受付可能数の場合は変更不可
								print('<option value="1" class="color1" >受付可</option>');	
								
							}else if( $tmp_uktk_flg == 0 ){
								print('<option value="0" class="color0" selected>***</option>');
								print('<option value="1" class="color1" >受付可</option>');
								print('<option value="2" class="color2" >受付不可</option>');
								
							}else if( $tmp_uktk_flg == 1 ){
								print('<option value="0" class="color0" >***</option>');
								print('<option value="1" class="color1" selected>受付可</option>');
								print('<option value="2" class="color2" >受付不可</option>');
								
							}else if( $tmp_uktk_flg == 2 ){
								print('<option value="0" class="color0" >***</option>');
								print('<option value="1" class="color1">受付可</option>');
								print('<option value="2" class="color2" selected>受付不可</option>');
								
							}
							print('</select>');
							
							print('</td>');
						
							$j++;

						}
						print('</tr>');
						
						$edit_staff_cnt++;
						
					}
					
					$s++;
				}
				
				print('</table>');

				//実予約数が予約可能数を上回っている
				if( $yykerr_flg == 1 ){
					//「予約可能数を超える予約があります。確認してください。」
					print('<img src="./img_' . $lang_cd . '/title_err_yyk_over.png" border="0">');
				}

				//引数設定
				print('<input type="hidden" name="edit_staff_cnt_' . $t . '" value="' . $edit_staff_cnt . '">');

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
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<td align="right">');
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