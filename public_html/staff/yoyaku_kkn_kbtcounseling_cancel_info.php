<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>個別カウンセリング予約 キャンセル一覧</title>
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
// -->
</script>
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
	$gmn_id = 'yoyaku_kkn_kbtcounseling_cancel_info.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('yoyaku_kkn_kbtcounseling_menu.php');

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
	$lang_cd = htmlspecialchars($_GET['l'],ENT_QUOTES,'utf-8');
	$select_office_cd = htmlspecialchars($_GET['o'],ENT_QUOTES,'utf-8');
	$select_ymd = htmlspecialchars($_GET['d'],ENT_QUOTES,'utf-8');
	$select_jkn_kbn = htmlspecialchars($_GET['j'],ENT_QUOTES,'utf-8');

	//サーバー接続
	require( './zs_svconnect.php' );
	
	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}else{
		//引数入力チェック
		if ( $select_office_cd == "" || $select_ymd == "" || $select_jkn_kbn == "" ){
			$err_flg = 3;
		}else{
			//メンテナンス期間チェック
			require( './zs_mntchk.php' );
	
			if( $mntchk_flg == 1 || $mntchk_flg == 2 ){
				$err_flg = 80;	//メンテナンス中
			}
		}
	}

	//エラー発生時
	if( $err_flg != 0 ){
		
		print('エラーが発生しました。[' . $err_flg . ']');
		

	//エラーなし
	}else{
		
		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_tojiru2_2.png" width="0" height="0" style="visibility:hidden;">');


		$select_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), sprintf("%d",substr($select_ymd,6,2)), sprintf("%d",substr($select_ymd,0,4))));

		//オフィスマスタの取得
		$query = 'select OFFICE_NM,TIME_DISP_FLG from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '";';
		$result = mysql_query($query);
		if (!$result) {
			$err_flg = 4;
			
			print('エラーが発生しました。[' . $err_flg . ']');
			
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';	//オフィスコード
			$log_kaiin_no = '';		//会員番号 または スタッフコード
			$log_naiyou = 'オフィスマスタの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
			
		}else{
			$row = mysql_fetch_array($result);
			$Moffice_office_nm = $row[0];		//オフィス名
			$Moffice_time_disp_flg = $row[1];	//時間表示フラグ  0:24H表示　1:12H表示
			
			//「オフィス」を「会場」に置換する
			$Moffice_office_nm = str_replace('オフィス','会場',$Moffice_office_nm );			
		}

		if( $err_flg == 0 ){
			//営業日フラグを求める
			$select_eigyoubi_flg = 0;
			if( $err_flg == 0 ){
				$select_eigyoubi_flg = 0;	//対象日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
				$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD  = "' . $select_ymd . '";';
				$result = mysql_query($query);
				if (!$result) {
					$err_flg = 4;
					print('エラーが発生しました。[' . $err_flg . ']');
				
					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = '';	//オフィスコード
					$log_kaiin_no = '';		//会員番号 または スタッフコード
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
		}

		if( $err_flg == 0 ){
			//営業時間マスタを読み込む（選択日の週の先頭以降）･･･９レコード１セット
			$Meigyojkn_cnt = 0;
			$query = 'select YOUBI_CD,TEIKYUBI_FLG,OFFICE_ST_TIME,OFFICE_ED_TIME,ST_DATE,ED_DATE from M_EIGYOJKN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YUKOU_FLG = 1 and ED_DATE >= "' . $select_ymd . '" order by YOUBI_CD,ST_DATE;';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				print('エラーが発生しました。[' . $err_flg . ']');
				
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';	//オフィスコード
				$log_kaiin_no = '';		//会員番号 または スタッフコード
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
				print('エラーが発生しました。[' . $err_flg . ']');
				
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';	//オフィスコード
				$log_kaiin_no = '';		//会員番号 または スタッフコード
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

		//選択時間帯のキャンセルデータの予約番号を取得する
		$cancel_cnt = 0;
		if( $err_flg == 0 ){
			$query = 'select YYK_NO from D_CLASS_YYK_CAN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $select_ymd . '" and JKN_KBN = "' . $select_jkn_kbn . '" order by CANCEL_TIME_R desc;';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				print('エラーが発生しました。[' . $err_flg . ']');
				
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';			//オフィスコード
				$log_kaiin_no = '';				//会員番号 または スタッフコード
				$log_naiyou = 'クラス予約キャンセルの参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
				
			}else{
				while( $row = mysql_fetch_array($result) ){
					$cancel_yyk_no[$cancel_cnt] = $row[0];	//予約番号
					$cancel_cnt++;
				}
			}
		}

		//開始時刻と終了時刻を求める
		$st_time = 0;
		$ed_time = 0;
		if( $err_flg == 0 ){
			$query = 'select ST_TIME,ED_TIME from M_CLASS_JKNWR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $select_jkn_kbn . '" and ST_DATE <= "' . $select_ymd . '" and "' . $select_ymd . '" <= ED_DATE and YUKOU_FLG = 1;';
			$result = mysql_query($query);
			if (!$result) {
				$err_flg = 4;
				print('エラーが発生しました。[' . $err_flg . ']');
							
				//**ログ出力**
				$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
				$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
				$log_office_cd = '';	//オフィスコード
				$log_kaiin_no = '';		//会員番号 または スタッフコード
				$log_naiyou = 'クラス時間割の参照に失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
			
			}else{
				while( $row = mysql_fetch_array($result) ){
					$st_time = $row[0];	//開始時刻
					$ed_time = $row[1];	//終了時刻
				}
			}
		}
		
		
		
		if( $err_flg == 0 ){
			//ページ編集
			
			print('<table border="0">');
			print('<tr>');
			print('<td width="550" align="left" valign="top"><img src="./img_' . $lang_cd . '/title_kbt_cancel_list.png" border="0"><br><img src="./img_' . $lang_cd . '/bar_kaijyou.png" border="0"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font></td>');
			print('<td width="100" align="left" valign="top">');
			//閉じるボタン
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_tojiru2_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_tojiru2_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_tojiru2_1.png\';" onClick=winclose() border="0">');
			print('</td>');
			print('</tr>');
			print('</table>');
		
			print('<hr>');

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

			//日付・時間帯
			print('<table border="0">');
			print('<tr>');
			print('<td id="' . $select_ymd . '" width="80" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/yyyy_' . substr($select_ymd,0,4) . '_black.png" border="0"></td>');	//年
			print('<td width="65" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/mm_' . sprintf("%d",substr($select_ymd,4,2)) . '_' . $fontcolor . '.png" border="0"></td>');	//月
			print('<td width="65" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/dd_' . sprintf("%d",substr($select_ymd,6,2)) . '_' . $fontcolor . '.png" border="0"></td>');	//日
			print('<td width="40" align="left" valign="bottom"><img src="./img_' . $lang_cd . '/youbi_' . $select_youbi_cd . '_' . $fontcolor . '.png" border="0"></td>');	//曜日
			if( $Moffice_time_disp_flg == 0 ){
				//24H表示
				print('<td align="left" valign="bottom"><font size="6">&nbsp;&nbsp;' . intval($st_time / 100) . ':' . sprintf("%02d",($st_time % 100)) . ' - ' . intval($ed_time / 100) . ':' . sprintf("%02d",($ed_time % 100)) . '</font></td>');	//時間帯
			}else{
				//12H表示
				print('<td align="left" valign="bottom"><font size="6">&nbsp;&nbsp;');
				if( intval($st_time / 100) < 12 ){
					print('am ' . intval($st_time / 100) . ':' . sprintf("%02d",($st_time % 100)) . ' -');
				}else{
					print('pm ' . (intval($st_time / 100) - 12) . ':' . sprintf("%02d",($st_time % 100)) . ' -');
				}
				if( intval($ed_time / 100) < 12 ){
					print(' ' . intval($ed_time / 100) . ':' . sprintf("%02d",($ed_time % 100)) . '</font></td>');
				}else{
					print(' ' . (intval($ed_time / 100) - 12) . ':' . sprintf("%02d",($ed_time % 100)) . '</font></td>');
				}
			}
			
			print('</tr>');
			print('</table>');
		
			if( $cancel_cnt == 0 ){
				print('キャンセルはありません。');
				
			}else{

				print('<table border="1">');
				//見出し部
				print('<tr bgcolor="moccasin">');
				print('<td width="180" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_cancel_date.png" border="0"></td>');	// 予約取消した日時
				print('<td width="80" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_no_80x20.png" border="0"></td>');		// 予約No
				print('<td width="235" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_id.png" border="0"></td>');			// ＩＤ／会員名
				print('<td width="180" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_cancel_naiyou.png" border="0"></td>');	// 取消内容
				print('</tr>');

				$i = 0;
				while( $i < $cancel_cnt ){
					
					//予約内容を読み込む
					$zz_yykinfo_yyk_no = $cancel_yyk_no[$i];
					require( '../zz_yykinfo_kako.php' );
					if( $zz_yykinfo_rtncd == 1 ){
						$err_flg = 4;
						
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = '';	//オフィスコード
						$log_kaiin_no = '';		//会員番号 または スタッフコード
						$log_naiyou = '予約内容の取り込みに失敗しました。[4]';	//内容
						$log_err_inf = '予約番号[' . $cancel_yyk_no[$i] . ']';	//エラー情報
						require( './zs_log.php' );
						//************
			
					}else if( $zz_yykinfo_rtncd == 8 ){
						//予約が無い
						$err_flg = 5;
						
						//**ログ出力**
						$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
						$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
						$log_office_cd = '';	//オフィスコード
						$log_kaiin_no = '';		//会員番号 または スタッフコード
						$log_naiyou = '予約内容の取り込みに失敗しました。[5]';	//内容
						$log_err_inf = '予約番号[' . $cancel_yyk_no[$i] . ']';	//エラー情報
						require( './zs_log.php' );
						//************
			
					}
					
					if( $err_flg == 0 ){
					
						//背景色
						if( $zz_yykinfo_kaiin_kbn == 1 ){
							//1:メンバー
							$bgfile = 'bg_kimidori';
						}else if( $zz_yykinfo_kaiin_kbn == 9 ){
							//9:一般（非メンバー）
							$bgfile = 'bg_pink';
						}else if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
							//0:仮登録
							$bgfile = 'bg_yellow';
						}else{
							$bgfile = 'bg_lightgrey';
						}
						
						print('<tr>');
						//キャンセル日時
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png">' . $zz_yykinfo_cancel_time_r . '</td>');
						//予約番号
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">' . sprintf("%07d",$cancel_yyk_no[$i]) . '</td>');
						//ＩＤ／会員名
						print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_235x20.png">');
						if( $zz_yykinfo_kaiin_kbn == 0 ){
							//仮登録
							print('&nbsp;<img src="./img_' . $lang_cd . '/title_kbt_yyk_kari.png" border="0"><br>&nbsp;' . $zz_yykinfo_yyk_staff_nm );
						}else if( $zz_yykinfo_kaiin_kbn == 1 ){
							//メンバー
							print('&nbsp;<font color="blue">' . $zz_yykinfo_kaiin_id . '</font>&nbsp;(<font color="blue">' . $zz_yykinfo_kaiin_mixi . '</font>)<br>&nbsp;' . $zz_yykinfo_kaiin_nm );
						}else if( $zz_yykinfo_kaiin_kbn == 9 ){
							//一般（非メンバー）
//							print('&nbsp;<img src="./img_' . $lang_cd . '/title_ippan.png" border="0"><br>&nbsp;<font color="blue">' . $zz_yykinfo_kaiin_id . '</font><br>&nbsp;' . $zz_yykinfo_kaiin_nm );
							print('&nbsp;<font color="blue">' . $zz_yykinfo_kaiin_id . '</font><br>&nbsp;' . $zz_yykinfo_kaiin_nm );
						}else{
							print('&nbsp;');	
						}
						print('</td>');
						//取消した人
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png">');
						if( $zz_yykinfo_status == 8 ){
							print('<font color="red">本人による取消し</font>');
						}else if( $zz_yykinfo_status == 9 ){
							print('<font size="2" color="red">スタッフによる取消し</font><br>' . $zz_yykinfo_cancel_staff_nm );
						}else if( $zz_yykinfo_status == 7 ){
							print('<font color="red">日時変更</font><br><font size="2">現在: ' . $zz_yykinfo_new_ymd . ' ' . intval($zz_yykinfo_new_st_time / 100 ) . ':' . sprintf("%02d",($zz_yykinfo_new_st_time % 100 )) . '</font>' );
						}else{
							print('不明');
						}
						print('</td>');
						
						
							
						print('</tr>');
					
					}
					
					$i++;	
				}
				
				print('</table>');
				
				print('<hr>');
			}
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