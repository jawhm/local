<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>個別カウンセリング予約一覧</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="js/jquery.activity-indicator-1.0.0.min.js"></script> 
<style type="text/css">
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
}
</style>
<script type="text/javascript">
<!--
function disp(url){
	window.open(url, "window_name", "width=700,height=500,scrollbars=yes,resizable=no,menubar=no,toolbar=no,location=no,directories=no,status=no");
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
	$gmn_id = 'yoyaku_kkn_kbtcounseling_menu.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('yoyaku_kkn_top.php','yoyaku_kkn_kbtcounseling_top.php','yoyaku_kkn_kbtcounseling_menu.php','yoyaku_kkn_kbtcounseling_kkn.php','yoyaku_kkn_kbtcounseling_can1.php','yoyaku_kkn_kbtcounseling_can2.php',
					'kbtcounseling_trk_serch.php','kbtcounseling_trk_selectdate.php','kbtcounseling_trk_selectjknkbn.php','kbtcounseling_trk_serch_kkn0.php','kbtcounseling_trk_serch_kkn1.php',
					'kbtcounseling_trk_kari_serch_new2.php','kbtcounseling_trk_kari_serch_kkn0.php','kbtcounseling_trk_kari_serch_kkn1.php','kbtcounseling_trk_kari_new2.php','kbtcounseling_trk_kari.php');

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
		print('<img src="./img_' . $lang_cd . '/btn_cng_kaijyou_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_zenjitsu_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_yokujitsu_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_sentakubi_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_cancel_disp_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_refresh_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_yyk_mini_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_mini_syousai2_2.png" width="0" height="0" style="visibility:hidden;">');
		
		print('<img src="../img_' . $lang_cd . '/btn_select2_2.png" width="0" height="0" style="visibility:hidden;">');


		//店舗メニューボタン表示
		require( './zs_menu_button.php' );

		
		//各時間区分における非メンバーの予約可能数
		$notmember_max_entry = 1;

		$select_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), sprintf("%d",substr($select_ymd,6,2)), sprintf("%d",substr($select_ymd,0,4))));
		$select_ymd_znjt = date("Ymd", mktime(0, 0, 0, substr($select_ymd,4,2) , (substr($select_ymd,6,2) - 1) , substr($select_ymd,0,4)) );
		$select_ymd_ykjt = date("Ymd", mktime(0, 0, 0, substr($select_ymd,4,2) , (substr($select_ymd,6,2) + 1) , substr($select_ymd,0,4)) );

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
			
			//「オフィス」を「会場」に置換する
			$Moffice_office_nm = str_replace('オフィス','会場',$Moffice_office_nm );			
		}


		if( $err_flg == 0 ){
			//営業時間マスタを読み込む（選択日の週の先頭以降）･･･９レコード１セット
			$Meigyojkn_cnt = 0;
			$query = 'select YOUBI_CD,TEIKYUBI_FLG,OFFICE_ST_TIME,OFFICE_ED_TIME,ST_DATE,ED_DATE from M_EIGYOJKN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YUKOU_FLG = 1 and ED_DATE >= "' . $select_ymd . '" order by YOUBI_CD,ST_DATE;';
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
			$query = 'select STAFF_CD,DECODE(STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and (CLASS_CD1 = "KBT" || CLASS_CD2 = "KBT" || CLASS_CD3 = "KBT" || CLASS_CD4 = "KBT" || CLASS_CD5 = "KBT" ) and YUKOU_FLG = 1 and ED_DATE >= "' . $select_ymd . '" order by ST_DATE,STAFF_CD;';
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
					$Mstaff_cnt++;
				}
			}
		}

		//選択日にキャンセルデータが存在するかチェックする
		$cancel_umu = 0;
		if( $err_flg == 0 ){
			$query = 'select count(*) from D_CLASS_YYK_CAN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $select_ymd . '";';
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
				$log_naiyou = 'クラス予約キャンセルの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
				
			}else{
				while( $row = mysql_fetch_array($result) ){
					if( $row[0] > 0 ){
						$cancel_umu = 1;
					}
				}
			}
		}
		
		
		if( $err_flg == 0 ){
			//ページ編集
			print('<center>');
			
			print('<table><tr>');
			print('<td width="950" bgcolor="lightgreen"><img src="./img_' . $lang_cd . '/bar_yykkkn_kbtcounseling_menu.png" border="0"></td>');
			print('</tr></table>');
	
			print('<table border="0">');
			print('<tr>');
			//会場変更ボタン
			print('<form method="post" action="yoyaku_kkn_kbtcounseling_top.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_cng_kaijyou_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_cng_kaijyou_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_cng_kaijyou_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('<td width="680" align="left"><img src="./img_' . $lang_cd . '/bar_kaijyou.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
			//戻るボタン
			print('<form method="post" action="yoyaku_kkn_top.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
		
			print('<hr>');
	
	
			//選択日に有効な時間割を取得する
			$Mclassjknwr_cnt = 0;
			$query = 'select JKN_KBN,ST_TIME,ED_TIME from M_CLASS_JKNWR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and ST_DATE <= "' . $select_ymd . '" and "' . $select_ymd . '" <= ED_DATE and YUKOU_FLG = 1 order by TSUBAN;';
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
			$select_eigyoubi_flg = 0;
			if( $err_flg == 0 ){
				$select_eigyoubi_flg = 0;	//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
				$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD  = "' . $select_ymd . '";';
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
						$select_eigyoubi_flg = $row[0];		//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
					}
				}
			}
				
				
			//営業時間と定休日フラグを求める
			$select_eigyou_st_time = 0;
			$select_eigyou_ed_time = 0;
			$select_teikyubi_flg = 0;	//定休日フラグ　0:営業日 1:定休日
			$find_flg = 0;
			if( $select_eigyoubi_flg == 1 || $select_eigyoubi_flg == 9 ){
				//祝日のみ対応（土日祝の前日は非対応）
				$a = 0;
				while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
					if( $Meigyojkn_youbi_cd[$a] == 8 && $Meigyojkn_st_date[$a] <= $select_ymd && $select_ymd <= $Meigyojkn_ed_date[$a] ){
						if( $Meigyojkn_st_time[$a] != "" ){
							$select_eigyou_st_time = $Meigyojkn_st_time[$a];
							$select_eigyou_ed_time = $Meigyojkn_ed_time[$a];
							$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
							$find_flg = 1;
							
						}else{
							if( $Meigyojkn_teikyubi_flg[$a] != 1 ){
								//曜日で検索しなおし
								$a = 0;
								while( $a < $Meigyojkn_cnt && $find_flg == 0 ){
									if( ( $Meigyojkn_youbi_cd[$a] == $select_youbi_cd ) &&
										( $Meigyojkn_st_date[$a] <= $select_ymd && $select_ymd <= $Meigyojkn_ed_date[$a] ) ){
										$select_eigyou_st_time = $Meigyojkn_st_time[$a];
										$select_eigyou_ed_time = $Meigyojkn_ed_time[$a];
										$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
										$find_flg = 1;
									}
									$a++;
								}
							}else{
								$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
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
					if( ( $Meigyojkn_youbi_cd[$a] == $select_youbi_cd ) &&
						( $Meigyojkn_st_date[$a] <= $select_ymd && $select_ymd <= $Meigyojkn_ed_date[$a] ) ){
						if( $Meigyojkn_teikyubi_flg[$a] != 1 ){
							$select_eigyou_st_time = $Meigyojkn_st_time[$a];
							$select_eigyou_ed_time = $Meigyojkn_ed_time[$a];
							$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
							$find_flg = 1;
						}else{
							$select_teikyubi_flg = $Meigyojkn_teikyubi_flg[$a];
							$find_flg = 1;
						}
					}
					$a++;
				}
			}
			
			//定休日の場合、営業日個別に登録されていた場合は、営業日扱いとする
			if( $select_teikyubi_flg == 1 ){
				$query = 'select OFFICE_ST_TIME,OFFICE_ED_TIME from D_EIGYOJKN_KBT where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_ymd . '";';
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
							$select_eigyou_st_time = $row[0];
						}
						if( $row[1] != "" ){
							$select_eigyou_ed_time = $row[1];
						}
						$select_teikyubi_flg = 0;
					}
				}
			}
		
			//イベントチェック
			$event_cnt = 0;
			$query = 'select id,starttime,endtime,k_title2,group_color from event_list where hiduke = "' . $select_ymd . '" and place = "' . $select_office_cd . '" and k_use = 1 order by starttime;';
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
			
			//受付可能人数／予約登録人数を求める
			if( $err_flg == 0 ){
				$i = 0;
				while( $i < $Mclassjknwr_cnt ){
					
					//受付人数を求める
					$Mclassjknwr_uktk_ninzu[$i] = 0;	//受付人数
					
					$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD  = "' . $select_ymd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$i] . '" and OPEN_FLG = 1 and UKTK_FLG = 1;';
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
						$Mclassjknwr_uktk_ninzu[$i] = $row[0];
					}
					
					//予約登録者（予約登録人数）を求める
					$Mclassjknwr_yyktrk_ninzu[$i] = 0;	//予約登録人数
					
					$query = 'select YYK_NO,KAIIN_KBN,KAIIN_ID,DECODE(KAIIN_NM,"' . $ANGpw . '"),STAFF_CD,YYK_STAFF_CD from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD  = "' . $select_ymd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$i] . '" order by YYK_NO;';
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
						$j = 0;
						while( $row = mysql_fetch_array($result) ){
							$yyktrk_yyk_no[$i][$j] = $row[0];		//予約番号
							$yyktrk_kaiin_kbn[$i][$j] = $row[1];	//会員区分 0:仮押さえ 1:有料メンバー 9:無料メンバー 
							$yyktrk_kaiin_id[$i][$j] = $row[2];		//会員ＩＤ （スタッフによる仮予約時は "kari" 設定）
							$yyktrk_kaiin_nm[$i][$j] = $row[3];		//会員名
							$yyktrk_staff_cd[$i][$j] = $row[4];		//スタッフコード（カウンセラーを指定した場合のみ）
							$yyktrk_yyk_staff_cd[$i][$j] = $row[5];	//予約受付スタッフ
							$j++;
						
						}

						$Mclassjknwr_yyktrk_ninzu[$i] = $j;

						//会員名を求める
						$j = 0;
						while( $j < $Mclassjknwr_yyktrk_ninzu[$i] ){
							if( $yyktrk_kaiin_kbn[$i][$j] == 0 ){
								//仮登録
								$query = 'select DECODE(STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $yyktrk_yyk_staff_cd[$i][$j] . '";';
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
									$row = mysql_fetch_array($result);
									$yyktrk_kaiin_nm[$i][$j] = $row[0];	//スタッフ名（仮登録者）
								}
								
							}else if( $yyktrk_kaiin_kbn[$i][$j] == 1 || $yyktrk_kaiin_kbn[$i][$j] == 9 ){
								//有料メンバー または 無料メンバー
								//（上で取得済み）
								
								//初期値
//								$yyktrk_kaiin_nm[$i][$j] = "取得エラー";

//								//半角小文字を半角大文字に変換する
//								$serch_id = strtoupper( $yyktrk_kaiin_id[$i][$j] );	//小文字を大文字にする
//					
//								// ＣＲＭに転送
//								$data = array(
//									 'pwd' => '303pittST'
//									,'serch_id' => $serch_id
//								);
//								$url = 'https://toratoracrm.com/crm/CS_serch_id.php';
//								$val = wbsRequest($url, $data);
//								$ret = json_decode($val, true);
//								if ($ret['result'] == 'OK')	{
//									// OK
//									$msg = $ret['msg'];
//									$rtn_cd = $ret['rtn_cd'];
//									$member_cnt = $ret['data_cnt'];
//									if( $member_cnt > 0 ){
//										$name = "data_name_0";
//										$yyktrk_kaiin_nm[$i][$j] = $ret[$name];			//会員名
//									}
//								}
								
							}else{
								//その他（ここは通らない）	
								$yyktrk_kaiin_nm[$i][$j] = "エラー";
								
							}
							
							$j++;
						}
					}
					
					$i++;
				}
			}

			//キャンセル有無を求める
			if( $err_flg == 0 ){
				$i = 0;
				while( $i < $Mclassjknwr_cnt ){
					
					//キャンセルデータ数を求める
					$Mclassjknwr_cancel_cnt[$i] = 0;	//キャンセル数
					
					$query = 'select count(*) from D_CLASS_YYK_CAN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD  = "' . $select_ymd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$i] . '";';
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
						$log_naiyou = 'クラス予約キャンセルの参照に失敗しました。';	//内容
						$log_err_inf = $query;			//エラー情報
						require( './zs_log.php' );
						//************
						
					}else{
						$row = mysql_fetch_array($result);
						$Mclassjknwr_cancel_cnt[$i] = $row[0];
					}
					
					$i++;
				}
			}
						
			//年月日表示
			if( $select_eigyoubi_flg == 1 || $select_eigyoubi_flg == 9 ){
				//祝日
				$fontcolor = "red";
			}else if( $select_youbi_cd == 0 ){
				//日曜
				$fontcolor = "red";
			}else if( $select_youbi_cd == 6 ){
				//土曜
				$fontcolor = "blue";
			}else{
				//平日
				$fontcolor = "black";
			}
					
				
			print('<table width="950" border="0">');
			print('<tr>');
			//前日ボタン
			print('<td align="right">');
			print('<form method="post" action="yoyaku_kkn_kbtcounseling_menu.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $select_ymd_znjt . '">');
//			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_zenjitsu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_zenjitsu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_zenjitsu_1.png\';" onClick="kurukuru()" border="0">');
//			print('</td>');
			print('</form>');
			print('</td>');
			print('<td id="' . $select_ymd . '" width="80" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/yyyy_' . substr($select_ymd,0,4) . '_black.png" border="0"></td>');	//年
			print('<td width="65" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/mm_' . sprintf("%d",substr($select_ymd,4,2)) . '_' . $fontcolor . '.png" border="0"></td>');	//月
			print('<td width="65" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/dd_' . sprintf("%d",substr($select_ymd,6,2)) . '_' . $fontcolor . '.png" border="0"></td>');	//日
			print('<td width="40" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/youbi_' . $select_youbi_cd . '_' . $fontcolor . '.png" border="0"></td>');	//曜日
			//翌日ボタン
			print('<td align="right">');
			print('<form method="post" action="yoyaku_kkn_kbtcounseling_menu.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $select_ymd_ykjt . '">');
//			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_yokujitsu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_yokujitsu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_yokujitsu_1.png\';" onClick="kurukuru()" border="0">');
//			print('</td>');
			print('</form>');
			print('</td>');
			//日付選択ボタン
			print('<td align="center">');
			print('<form method="post" action="yoyaku_kkn_kbtcounseling_menu.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
//			print('<td align="center">');
			$tabindex++;
			print('<select name="select_ymd" class="normal" style="font-size:14px;">');
			//今月分
			$tmp_dd = 1;
			while( $tmp_dd <= $now_maxdd ){
				$tmp_youbi = date("w", mktime(0, 0, 0, $now_mm, $tmp_dd, $now_yyyy));
				print('<option value="' . $now_yyyy . sprintf("%02d",$now_mm) . sprintf("%02d",$tmp_dd) . '"');
				if( $tmp_dd == $now_dd ){
					print(' selected');	
				}
				print('>' . sprintf("%d",$now_mm) . '月' . sprintf("%d",$tmp_dd) . '日(' . $week[$tmp_youbi] .  ')</option>');
				$tmp_dd++;
			}
			//翌月分
			$tmp_dd = 1;
			while( $tmp_dd <= $next_maxdd ){
				$tmp_youbi = date("w", mktime(0, 0, 0, $next_mm, $tmp_dd, $next_yyyy));
				print('<option value="' . $next_yyyy . sprintf("%02d",$next_mm) . sprintf("%02d",$tmp_dd) . '">' . sprintf("%d",$next_mm) . '月' . sprintf("%d",$tmp_dd) . '日(' . $week[$tmp_youbi] .  ')</option>');
				$tmp_dd++;
			}
			print('</select><br>');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sentakubi_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sentakubi_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sentakubi_1.png\';" onClick="kurukuru()" border="0">');
//			print('</td>');
			print('</form>');
			print('</td>');
			//リフレッシュボタン
			print('<td width="295" align="right" valign="bottom">');
			print('<form method="post" action="yoyaku_kkn_kbtcounseling_menu.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
//			print('<td width="295" align="right" valign="bottom">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_refresh_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_refresh_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_refresh_1.png\';" onClick="kurukuru()" border="0"><br>');
			print('<font size="2" color="lightgrey">[&nbsp;' . date( "Y-m-d H:i:s", time() ) . '&nbsp;]</font>');
//			print('</td>');
			print('</form>');
			print('</td>');
			print('</tr>');
			print('</table>');

			print('<table border="1">');
			print('<tr>');
			print('<td colspan="2" align="center" valign="middle" bgcolor="moccasin"><img src="./img_' . $lang_cd . '/title_jkntai.png" border="0"></td>');
			
			$j = 0;
			while( $j < $Mclassjknwr_cnt ){
					
				//無料メンバーの予約数を求める
				$notmember_yyk_cnt[$j] = 0;
				$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $select_ymd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and KAIIN_KBN = 9;';
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
					$notmember_yyk_cnt[$j] = $row[0];	//非メンバーの予約数
				}

				//時間帯背景色
				if( $select_teikyubi_flg == 1 ){
					//定休日
					$Mclassjknwr_bgfile[$j] = 'bg_yellow';
				}else if( $select_eigyoubi_flg == 8 || $select_eigyoubi_flg == 9 ){
					//非営業日
					$Mclassjknwr_bgfile[$j] = 'bg_lightgrey';
				}else if( !($select_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $select_eigyou_ed_time) ){
					//営業時間外
					$Mclassjknwr_bgfile[$j] = 'bg_lightgrey';
				}else if( $notmember_yyk_cnt[$j] < $notmember_max_entry ){
					//無料メンバーの予約可能数を下回っている場合
					//有料メンバー および 無料メンバー の時間区分
					$Mclassjknwr_bgfile[$j] = 'bg_mizu';
				}else{
					//有料メンバーのみ の時間区分
					$Mclassjknwr_bgfile[$j] = 'bg_pink';
				}

				print('<td width="85" align="center" valign="middle" background="../img_' . $lang_cd . '/' . $Mclassjknwr_bgfile[$j] . '_80x20.png">');
				print('<b><font size="2">' . intval($Mclassjknwr_st_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_st_time[$j] % 100)) . '-' . intval($Mclassjknwr_ed_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_ed_time[$j] % 100)) . '</font></b>');
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
					print('<td colspan="2" align="left" valign="middle" bgcolor="lightgrey">&nbsp;&nbsp;[' . $event_id[$e] . '] ' . intval($tmp_st_time / 100) . ':' . sprintf("%02d",($tmp_st_time % 100)) . '-' . intval($tmp_ed_time / 100) . ':' . sprintf("%02d",($tmp_ed_time % 100)) . '</td>');
					
					//イベント前
					if( $tmp_bf_colspan > 0 ){
						if( $tmp_bf_colspan <= $tmp_af_colspan ){
							//時刻表示
							print('<td align="right" valign="bottom" width="' . ($tmp_bf_colspan * 85) . '" colspan="' . $tmp_bf_colspan . '" bgcolor="lightgrey">');
							print('<font size="1">' . intval($tmp_st_time / 100) . ':' . sprintf("%02d",($tmp_st_time % 100)) . '-' . intval($tmp_ed_time / 100) . ':' . sprintf("%02d",($tmp_ed_time % 100)) . '</font>');
							if( $tmp_af_colspan == 0 ){
								//内容表示
								print('&nbsp;<font size="1">' . $event_title[$e] . '</font>');
							}
							print('</td>');
						}else{
							print('<td align="right" valign="bottom" width="' . ($tmp_bf_colspan * 85) . '" colspan="' . $tmp_bf_colspan . '" bgcolor="lightgrey">');
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
							print('<td align="left" valign="bottom" width="' . ($tmp_af_colspan * 85) . '" colspan="' . $tmp_af_colspan . '" bgcolor="lightgrey">');
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

			$max_yyk_cnt = 0;
			if( ($select_eigyoubi_flg == 0 || $select_eigyoubi_flg == 1) && $select_teikyubi_flg == 0 ){
				//現在予約数
				print('<tr>');
				print('<td colspan="2" align="center" valign="middle" bgcolor="#d6fafa"><img src="./img_' . $lang_cd . '/title_jitsu_yyksu.png" border="0"></td>');
				
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){
					
					//該当日／時間割のクラス予約を参照し、現在の個別カウンセリングの予約数を取得する
					$Mclassjknwr_yyk_cnt[$j] = 0;
					$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $select_ymd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '";';
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
							$Mclassjknwr_yyk_cnt[$j] = $row[0];		//実予約数
							
							//同一時間帯の予約数の最大を求める（表示行判定のため）
							if( $max_yyk_cnt < $Mclassjknwr_yyk_cnt[$j] ){
								$max_yyk_cnt = $Mclassjknwr_yyk_cnt[$j];
							}
						}
					}


					//該当日／時間割のスタッフスケジュールを参照し、現在の受付人数を取得する
					$Mclassjknwr_uktk_ninzu[$j] = '';
					$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_ymd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and OPEN_FLG = 1 and UKTK_FLG = 1;';
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
							$Mclassjknwr_uktk_ninzu[$j] = $row[0];	//受付可能数
						}
					}
			
					print('<td align="center" valign="middle" ');
					if( $Mclassjknwr_yyk_cnt[$j] > $Mclassjknwr_uktk_ninzu[$j] ){
						//実予約数が受付可能数を越えている場合（予約後にカウンセラーが非公開としたパターン）
						print('background="../img_' . $lang_cd . '/bg_red_80x20.png"');
					}else if( $select_teikyubi_flg == 1 ){
						//定休日
						print('background="../img_' . $lang_cd . '/bg_yellow_80x20.png"');
					}else if( $select_eigyoubi_flg == 8 || $select_eigyoubi_flg == 9 ){
						//非営業日
						print('background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"');
					}else if( !($select_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $select_eigyou_ed_time) ){
						//営業時間外
						print('background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"');
					//}else if( in_array($Mclassjknwr_jkn_kbn[$j] , $jkn_kbn_array_1) ){
					}else if( $notmember_yyk_cnt[$j] < $notmember_max_entry ){
						//無料メンバーの予約可能数を下回っている場合
						//メンバー および 一般 の時間区分
						print('background="../img_' . $lang_cd . '/bg_blue_80x20.png"');
					}else{
						//有料メンバーのみ の時間区分
						print('background="../img_' . $lang_cd . '/bg_pink_80x20.png"');
					}
					print('>');

					if( $select_teikyubi_flg == 1 ){
						//定休日
						print('<img src="../img_' . $lang_cd . '/title_teikyubi_80.png" border="0">');
						
					}else if( !($select_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $select_eigyou_ed_time) ){
						//営業時間外
						print('<input type="hidden" name="ninzu' . $t . $Mclassjknwr_jkn_kbn[$j] . '" value="">');
						print('<img src="../img_' . $lang_cd . '/title_eigyou_jkngai_80.png" border="0">');
						
					}else{
						//営業時間内
						if( $Mclassjknwr_yyk_cnt[$j] > 0 ){
							$fontcolor = "red";
						}else{
							$fontcolor = "blue";
						}
						if( $Mclassjknwr_uktk_ninzu[$j] == "" ){
							//未登録
							print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');							
						}else{
							print('<font color="' . $fontcolor . '">' . $Mclassjknwr_yyk_cnt[$j] . '</font>&nbsp;/&nbsp;' . $Mclassjknwr_uktk_ninzu[$j] );
						}
					}
				
					print('</td>');
				
					$j++;
				}			
				print('</tr>');
			}

			if( $cancel_umu == 1 ){
				//キャンセル表示
				print('<tr>');
				print('<td colspan="2" align="center" valign="middle" bgcolor="pink"><img src="./img_' . $lang_cd . '/title_cancel_disp.png" border="0"></td>');
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){

					print('<td align="center" valign="middle" ');
					if( $select_teikyubi_flg == 1 ){
						//定休日
						print('background="../img_' . $lang_cd . '/bg_yellow_80x20.png"');
					}else if( $select_eigyoubi_flg == 8 || $select_eigyoubi_flg == 9 ){
						//非営業日
						print('background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"');
					}else if( !($select_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $select_eigyou_ed_time) ){
						//営業時間外
						print('background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png"');
					}else{
						print('background="../img_' . $lang_cd . '/bg_pink_80x20.png"');
					}
					print('>');

					if( $select_teikyubi_flg == 1 ){
						//定休日
						print('<img src="../img_' . $lang_cd . '/title_teikyubi_80.png" border="0">');
						
					}else if( !($select_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $select_eigyou_ed_time) ){
						//営業時間外
						print('<img src="../img_' . $lang_cd . '/title_eigyou_jkngai_80.png" border="0">');
						
					}else if( $Mclassjknwr_cancel_cnt[$j] > 0 ){
						//取消予約一覧ボタン
						print('<a href="yoyaku_kkn_kbtcounseling_cancel_info.php?l=' . $lang_cd . '&o=' . $select_office_cd . '&d=' . $select_ymd . '&j=' . $Mclassjknwr_jkn_kbn[$j] . '" target="window_name" onClick="disp(\'yoyaku_kkn_kbtcounseling_cancel_info.php?l=' . $lang_cd . '&o=' . $select_office_cd . '&d=' . $select_ymd . '&j=' . $Mclassjknwr_jkn_kbn[$j] . ' \')">');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_cancel_disp_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_cancel_disp_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_cancel_disp_1.png\';" onClick="kurukuru()" border="0">');
						print('</a>');					
					}else{
						//キャンセルなし
						print('<img src="./img_' . $lang_cd . '/title_nodata_cancel.png" border="0">');
					}
					print('</td>');
					
					$j++;
				}
				print('</tr>');
			}


			//時刻表示
			if( $select_teikyubi_flg == 0 && ($select_eigyoubi_flg == 0 || $select_eigyoubi_flg == 1) ){
				//営業日の場合のみ表示
				print('<tr>');
				print('<td colspan="2" align="center" valign="middle" bgcolor="moccasin"><img src="./img_' . $lang_cd . '/title_jkntai.png" border="0"></td>');
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){
						
					print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $Mclassjknwr_bgfile[$j] . '_80x20.png">');
					print('<b><font size="2">' . intval($Mclassjknwr_st_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_st_time[$j] % 100)) . '-' . intval($Mclassjknwr_ed_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_ed_time[$j] % 100)) . '</font></b>');
					//担当不足発生か？
					if( $Mclassjknwr_yyk_cnt[$j] > $Mclassjknwr_uktk_ninzu[$j] ){
						print('<br><font size="1" color="red">担当不足発生</font>');
					}
					print('</td>');
					
					$j++;
				}			
				print('</tr>');
			}


			//カウンセラー指定なし
			if( $select_teikyubi_flg == 0 && ($select_eigyoubi_flg == 0 || $select_eigyoubi_flg == 1) ){
				//営業日の場合のみ表示
				print('<tr>');
				print('<td colspan="2" align="right" valign="middle" bgcolor="#d7fed5"><img src="./img_' . $lang_cd . '/title_shitei_nashi.png" border="0"></td>');
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){
	
					if( $select_ymd > $now_yyyymmdd || ( $select_ymd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] > ( $now_hh * 100 + $now_ii ) ) ){
						//営業時間内
						$tmp_bgfile = 'bg_kimidori';
					}else{
						//営業時間外
						$tmp_bgfile = 'bg_lightgrey';
					}
					
					if( !($select_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $select_eigyou_ed_time) ){
						//営業時間外
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $tmp_bgfile . '_80x20.png">');
						print('<img src="../img_' . $lang_cd . '/title_eigyou_jkngai_80.png" border="0">');
						print('</td>');
						
					}else if( $Mclassjknwr_yyk_cnt[$j] < $Mclassjknwr_uktk_ninzu[$j] ){
						//受付可能
						
						if( $select_ymd > $now_yyyymmdd || ( $select_ymd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] > ( $now_hh * 100 + $now_ii ) ) ){
							//予約可能（予約可能ボタン）
							print('<form method="post" action="kbtcounseling_trk_serch.php">');
							print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
							print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
							print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
							print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
							print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
							print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
							print('<input type="hidden" name="select_jknkbn" value="' . $Mclassjknwr_jkn_kbn[$j] . '">');
							print('<input type="hidden" name="select_staff_cd" value="">');
							print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $tmp_bgfile . '_80x20.png">');
							print('<img src="./img_' . $lang_cd . '/title_uktk_ok.png"><br>');
							$tabindex++;
							print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_yyk_mini_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_yyk_mini_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_yyk_mini_1.png\';" onClick="kurukuru()" border="0">');
							print('</td>');
							print('</form>');
								
						}else{
							//過去日時（予約可能ボタン）
							print('<form method="post" action="kbtcounseling_trk_serch.php">');
							print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
							print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
							print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
							print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
							print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
							print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
							print('<input type="hidden" name="select_jknkbn" value="' . $Mclassjknwr_jkn_kbn[$j] . '">');
							print('<input type="hidden" name="select_staff_cd" value="">');
							print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $tmp_bgfile . '_80x20.png">');
							print('<img src="./img_' . $lang_cd . '/title_uktk_kako.png" border="0"><br>');
							$tabindex++;
							print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_yyk_mini_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_yyk_mini_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_yyk_mini_1.png\';" onClick="kurukuru()" border="0">');
							print('</td>');
							print('</form>');
							
						}
							
					}else{
						//満席
						// Ｘ 受付不可
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $tmp_bgfile . '_80x20.png">');
						print('<img src="./img_' . $lang_cd . '/title_uktk_ng.png">');
						print('</td>');
					}
	
					$j++;
				}
				print('</tr>');
			}


			//カウンセラー（スタッフ）
			$edit_staff_cnt = 0;
			$s = 0;
			while( $s < $Mstaff_cnt ){

				//公開フラグを求める
				$tmp_open_flg = 0;	//公開フラグ  0:非公開 1:公開
				$query = 'select OPEN_FLG from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_ymd . '" and STAFF_CD = "' . $Mstaff_staff_cd[$s] . '" and CLASS_CD = "KBT" order by JKN_KBN LIMIT 1;';
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

				if( $tmp_open_flg == 1 ){
					//公開スタッフのみ表示

					print('<tr>');
	
					//背景色設定
					if( $tmp_open_flg == 0 ){
						//非公開
						$bgfile = "bg_yellow";
					}else{
						//公開
						$bgfile = "bg_blue";
					}
					
					//公開・非公開
					print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
					if( $tmp_open_flg == 0 ){
						//非公開
						print('<img src="./img_' . $lang_cd . '/title_uktk_open_ng.png">');
					}else{
						//公開中
						print('<img src="./img_' . $lang_cd . '/title_uktk_open_ok.png">');
					}
					print('</td>');
					
					//スタッフ名
					print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_110x20.png"><b>' . $Mstaff_staff_nm[$s] . '</b></td>');
					
					$j = 0;
					while( $j < $Mclassjknwr_cnt ){
							
						//該当時間帯のスタッフスケジュールを参照する
						$tmp_uktk_flg = 0;
						$query = 'select UKTK_FLG from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $select_ymd . '" and STAFF_CD = "' . $Mstaff_staff_cd[$s] . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '";';
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
						$tmp_shimei_yyk_no = "";
						$query = 'select YYK_NO,YYK_STAFF_CD from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $select_ymd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and STAFF_CD = "' . $Mstaff_staff_cd[$s] . '";';
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
								$tmp_shimei_yyk_no = $row[0];
								$tmp_shimei_yyk_staff_cd = $row[1];
								if( $tmp_shimei_yyk_staff_cd == "" ){
									$tmp_shimei_flg = 1;
								}else{
									$tmp_shimei_flg = 2;
								}
							}
						}
	
						//背景色
						if( !($select_ymd > $now_yyyymmdd || ( $select_ymd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] > ( $now_hh * 100 + $now_ii ))) ){
							//過去時間
							$tmp_bgfile = 'bg_lightgrey';
						}else if( $tmp_shimei_flg >= 1 ){
							//カウンセラー指名の予約あり
							$tmp_bgfile = 'bg_blue';
						}else if( $select_teikyubi_flg == 1 ){
							//定休日
							$tmp_bgfile = 'bg_yellow';
						}else if( !($select_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $select_eigyou_ed_time) ){
							//営業時間外
							$tmp_bgfile = 'bg_lightgrey';
						}else if( $tmp_open_flg == 0 ){
							//非公開
							$tmp_bgfile = 'bg_yellow';
						}else if( $tmp_uktk_flg == 2 ){
							//受付不可
							$tmp_bgfile = 'bg_pink';
						}else if( $tmp_uktk_flg == 0 ){
							//未登録
							$tmp_bgfile = 'bg_yellow';
						}else if( $notmember_yyk_cnt[$j] < $notmember_max_entry ){
							//メンバー および 一般 の時間区分
							if( $select_ymd > $now_yyyymmdd || ( $select_ymd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] > ( $now_hh * 100 + $now_ii ) ) ){
								$tmp_bgfile = 'bg_blue';
							}else{
								$tmp_bgfile = 'bg_lightgrey';
							}
						}else{
							//メンバーのみ の時間区分
							if( $select_ymd > $now_yyyymmdd || ( $select_ymd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] > ( $now_hh * 100 + $now_ii ) ) ){
								$tmp_bgfile = 'bg_kimidori';
							}else{
								$tmp_bgfile = 'bg_lightgrey';
							}
						}
	
						if( $tmp_shimei_flg >= 1 ){
							// ☆ 指名予約
							print('<td width="85" align="center" valign="middle" background="../img_' . $lang_cd . '/' . $tmp_bgfile . '_80x20.png">');
							if( $tmp_shimei_flg == 1 ){
								//お客様からの指定
								print('<img src="./img_' . $lang_cd . '/title_uktk_select_staff.png"><br><font size="2">[</font><font size="2" color="blue"><b>' . sprintf("%07d",$tmp_shimei_yyk_no) .'</b></font><font size="2">]</font>' );
							}else{
								//スタッフによるカウンセラー登録
								print('<img src="./img_' . $lang_cd . '/title_uktk_yyk_ari.png"><br><font size="2">[</font><font size="2" color="blue"><b>' . sprintf("%07d",$tmp_shimei_yyk_no) .'</b></font><font size="2">]</font>' );
							}
							print('</td>');
							
						}else if( !($select_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $select_eigyou_ed_time) ){
							//営業時間外
							print('<td width="85" align="center" valign="middle" background="../img_' . $lang_cd . '/' . $tmp_bgfile . '_80x20.png">');
							print('<img src="../img_' . $lang_cd . '/title_eigyou_jkngai_80.png" border="0">');
							print('</td>');
							
						}else if( $tmp_open_flg == 0 && $tmp_uktk_flg == 1 ){
							//非公開で 受付可
							print('<td width="85" align="center" valign="middle" background="../img_' . $lang_cd . '/' . $tmp_bgfile . '_80x20.png">');
							print('<img src="./img_' . $lang_cd . '/title_uktk_ok.png">');
							print('</td>');
							
						}else if( $tmp_open_flg == 1 && $tmp_uktk_flg == 1 ){
							//公開中で 受付可
							
							if( $Mclassjknwr_yyk_cnt[$j] < $Mclassjknwr_uktk_ninzu[$j] ){
								//予約数が受付可能数を下回っていれば、予約するボタンを表示する
								print('<form method="post" action="kbtcounseling_trk_serch.php">');
								print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
								print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
								print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
								print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
								print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
								print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
								print('<input type="hidden" name="select_jknkbn" value="' . $Mclassjknwr_jkn_kbn[$j] . '">');
								print('<input type="hidden" name="select_staff_cd" value="' . $Mstaff_staff_cd[$s] . '">');
								print('<td width="85" align="center" valign="middle" background="../img_' . $lang_cd . '/' . $tmp_bgfile . '_80x20.png">');
								$tabindex++;
								print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_yyk_mini_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_yyk_mini_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_yyk_mini_1.png\';" onClick="kurukuru()" border="0">');
								print('</td>');
								print('</form>');
								
							}else{
								// ★ 予約あり
								print('<td width="85" align="center" valign="middle" background="../img_' . $lang_cd . '/' . $tmp_bgfile . '_80x20.png">');
								print('<img src="./img_' . $lang_cd . '/title_uktk_yyk_ari.png">');
								print('</td>');
								
							}
								
								
						}else if( $tmp_uktk_flg == 2 ){
							// Ｘ 受付不可
							print('<td width="85" align="center" valign="middle" background="../img_' . $lang_cd . '/' . $tmp_bgfile . '_80x20.png">');
							print('<img src="./img_' . $lang_cd . '/title_uktk_ng.png">');
							print('</td>');
							
						}else{
							//未登録
							print('<td width="85" align="center" valign="middle" background="../img_' . $lang_cd . '/' . $tmp_bgfile . '_80x20.png">');
							print('<img src="./img_' . $lang_cd . '/title_uktk_mitrk.png">');
							print('</td>');
						}
					
						$j++;
					
					}
					print('</tr>');
				}

				$s++;
			}

			//実予約の表示
			if( $max_yyk_cnt == 0 ){
				//実予約がない
				print('<tr>');
				print('<td colspan="2" bgcolor="lightgrey">&nbsp;</td>');
				print('<td colspan="' . $Mclassjknwr_cnt . '" align="center"  valign="middle" bgcolor="lightgrey"><img src="./img_' . $lang_cd . '/title_kbt_yyk_nothing.png" border="0"></td>');
				print('</tr>');
				
			}else{
				//実予約がある
			
				//時刻表示
				print('<tr>');
				print('<td colspan="2" align="center" valign="middle" bgcolor="moccasin"><img src="./img_' . $lang_cd . '/title_jkntai.png" border="0"></td>');
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){
						
					print('<td width="85" align="center" valign="middle" background="../img_' . $lang_cd . '/' . $Mclassjknwr_bgfile[$j] . '_80x20.png">');
					print('<b><font size="2">' . intval($Mclassjknwr_st_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_st_time[$j] % 100)) . '-' . intval($Mclassjknwr_ed_time[$j] / 100) . ':' . sprintf("%02d",($Mclassjknwr_ed_time[$j] % 100)) . '</font></b>');
					print('</td>');
					
					$j++;
				}			
				print('</tr>');

				//実予約を表示
				print('<tr>');
				print('<td rowspan="' . $max_yyk_cnt . '" colspan="2" align="center" valign="middle" bgcolor="moccasin">&nbsp;</td>');
				$row = 0;
				while( $row < $max_yyk_cnt ){
					
					if( $row != 0 ){
						print('<tr>');	
					}
					
					$j = 0;
					while( $j < $Mclassjknwr_cnt ){

						if( $row < $Mclassjknwr_yyktrk_ninzu[$j] ){
							//予約登録済み
							if( $yyktrk_kaiin_kbn[$j][$row] == 0 ){
								$bgcolor = "yellow";	//仮登録
							}else if( $yyktrk_kaiin_kbn[$j][$row] == 1 ){
								$bgcolor = "kimidori";	//有料メンバー
							}else if( $yyktrk_kaiin_kbn[$j][$row] == 9 ){
								$bgcolor = "pink";		//無料メンバー
							}else{
								$bgcolor = "lightgrey"; //判別不明
							}
							print('<form method="post" action="yoyaku_kkn_kbtcounseling_kkn.php">');
							print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
							print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
							print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
							print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
							print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
							print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
							print('<input type="hidden" name="select_yyk_no" value="' . $yyktrk_yyk_no[$j][$row] . '">');
							print('<td width="85" align="left" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgcolor . '_80x20.png">');
							print('<font size="2">&nbsp;[</font><font size="2" color="blue"><b>' . sprintf("%07d",$yyktrk_yyk_no[$j][$row]) . '</b></font><font size="2">]</font><br>');
							if( $yyktrk_kaiin_kbn[$j][$row] == 0 ){
								//「仮予約」
								print('<img src="./img_' . $lang_cd . '/title_kbt_yyk_kari.png" border="0"><br>');
							}else{
								print('<font size="1">&nbsp;' . $yyktrk_kaiin_id[$j][$row] . '</font><br>');
							}
							if( strlen( $yyktrk_kaiin_nm[$j][$row] ) <= 6 ){
								print('<font size="2">&nbsp;' . $yyktrk_kaiin_nm[$j][$row] . '</font><br>');
							}else{
								print('<font size="1">&nbsp;' . $yyktrk_kaiin_nm[$j][$row] . '</font><br>');
							}
							$tabindex++;
							print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_mini_syousai2_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_mini_syousai2_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_mini_syousai2_1.png\';" onClick="kurukuru()" border="0">');
							print('</td>');
							print('</form>');
							
						}else{
							//予約なし
							print('<td width="85" align="center" valign="middle" bgcolor="lightgrey">－</td>');
						}
						$j++;
					}
					$row++;
					print('</tr>');
				}
			}










			//*** 予約状況 ***
			$col = 0;
			while( $col < $max_uktk_ninzu ){
				
				print('<tr>');
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){
					
					if( $col < $Mclassjknwr_uktk_ninzu[$j] ){
						//予約受付人数 内
						
						//予約があるか
						if( $col < $Mclassjknwr_yyktrk_ninzu[$j] ){
							//予約登録済み
							if( $yyktrk_kaiin_kbn[$j][$col] == 0 ){
								$bgcolor = "yellow";	//仮登録
							}else if( $yyktrk_kaiin_kbn[$j][$col] == 1 ){
								$bgcolor = "kimidori";	//有料メンバー
							}else if( $yyktrk_kaiin_kbn[$j][$col] == 9 ){
								$bgcolor = "pink";		//無料メンバー
							}else{
								$bgcolor = "lightgrey"; //判別不明
							}
							print('<td width="80" align="left" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgcolor . '_80x20.png">');
							print('<table border="0">');
							print('<tr>');
							//詳細ボタン
							print('<form method="post" action="yoyaku_kkn_kbtcounseling_kkn.php">');
							print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
							print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
							print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
							print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
							print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
							print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
							print('<input type="hidden" name="select_yyk_no" value="' . $yyktrk_yyk_no[$j][$col] . '">');
							print('<td width="50" align="center" valign="middle">');
							$tabindex++;
							print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_mini_syousai2_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_mini_syousai2_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_mini_syousai2_1.png\';" onClick="kurukuru()" border="0">');
							print('</td>');
							print('</form>');
							print('<td width="60" align="center" valign="middle">');
							print('<img src="./img_' . $lang_cd . '/title_mini2_yykno.png" border="0"><br>');	//予約No.
							print('<font color="blue">' . sprintf("%05d",$yyktrk_yyk_no[$j][$col]) . '</font>');
							print('</td>');
							print('</tr>');
							print('<tr>');
							if( $yyktrk_kaiin_kbn[$j][$col] == 0 ){
								//「仮登録」
								print('<td colspan="2" align="center" valign="middle">');
								print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">');
								print('</td>');
							}else if( $yyktrk_kaiin_kbn[$j][$col] == 1 || $yyktrk_kaiin_kbn[$j][$col] == 9 ){
								print('<td colspan="2" align="left" valign="middle">');
								print('&nbsp;<font size="2" color="blue">' . $yyktrk_kaiin_id[$j][$col] . '</font>');
								print('</td>');
							}
							print('</tr>');
							print('<tr>');
							print('<td colspan="2" align="left" valign="middle">');
							if( $yyktrk_kaiin_id[$j][$col] != "kari" ){
								print('&nbsp;<font size="2" color="blue">' . $yyktrk_kaiin_nm[$j][$col] . '</font><font size="1">&nbsp;様</font>');
							}else{
								print('&nbsp;<font size="2" color="blue">' . $yyktrk_kaiin_nm[$j][$col] . '</font>');
							}
							print('</td>');
							print('</tr>');
							print('</table>');
							
							print('</td>');
							
						}else{
							
							if( $select_ymd > $now_yyyymmdd || ( $select_ymd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] > ( $now_hh * 100 + $now_ii ) ) ){
								//予約可能（予約可能ボタン）
								print('<form method="post" action="kbtcounseling_trk_serch.php">');
								print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
								print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
								print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
								print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
								print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
								print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
								print('<input type="hidden" name="select_jknkbn" value="' . $Mclassjknwr_jkn_kbn[$j] . '">');
								print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">');
								print('<img src="./img_' . $lang_cd . '/title_yyk_kanou.png" border="0"><br>');
								$tabindex++;
								print('<input type="image" tabindex="' . $tabindex . '" src="../img_' . $lang_cd . '/btn_select2_1.png" onmouseover="this.src=\'../img_' . $lang_cd . '/btn_select2_2.png\';" onmouseout="this.src=\'../img_' . $lang_cd . '/btn_select2_1.png\';" onClick="kurukuru()" border="0">');
								print('</td>');
								print('</form>');
								
							}else{
								//過去日時（予約可能ボタン）
								print('<form method="post" action="kbtcounseling_trk_serch.php">');
								print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
								print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
								print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
								print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
								print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
								print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
								print('<input type="hidden" name="select_jknkbn" value="' . $Mclassjknwr_jkn_kbn[$j] . '">');
								print('<td width="80" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_80x20.png">');
								print('<img src="./img_' . $lang_cd . '/title_kakonichiji.png" border="0"><br>');
								$tabindex++;
								print('<input type="image" tabindex="' . $tabindex . '" src="../img_' . $lang_cd . '/btn_select2_1.png" onmouseover="this.src=\'../img_' . $lang_cd . '/btn_select2_2.png\';" onmouseout="this.src=\'../img_' . $lang_cd . '/btn_select2_1.png\';" onClick="kurukuru()" border="0">');
								print('</td>');
								print('</form>');
								
							}
						}
						
					}else{
						//予約受付人数 外
						print('<td width="80" align="center" valign="middle" bgcolor="lightgrey">－</td>');
					
					}

					$j++;
				}
				print('</tr>');
				
				$col++;
			}

			print('</table>');

			print('<hr>');

			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">&nbsp;</td>');
			print('<form method="post" action="yoyaku_kkn_top.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
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

	function wbsRequest($url, $params)
	{
		$data = http_build_query($params);
		$content = file_get_contents($url.'?'.$data);
		return $content;
	}

?>
</body>
</html>