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
	$gmn_id = 'yoyaku_kkn_kbtcounseling_kkn.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('yoyaku_kkn_kbtcounseling_menu.php','yoyaku_kkn_kbtcounseling_can1.php',
					'kbtcounseling_trk_selectdate.php','kbtcounseling_trk_kari_serch.php','kbtcounseling_trk_kari_serch_kkn0.php',
					'kaiin_kkn1.php');

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
	$select_yyk_no = $_POST['select_yyk_no'];

	$select_kaiin_id = $_POST['select_kaiin_id'];	//未入力OK

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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_ymd == "" || $select_yyk_no == "" ){
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
		print('<img src="./img_' . $lang_cd . '/btn_select_kaiin_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_date_change_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_cancel_2.png" width="0" height="0" style="visibility:hidden;">');

		//店舗メニューボタン表示
		require( './zs_menu_button.php' );

		//予約内容を読み込む
		$zz_yykinfo_yyk_no = $select_yyk_no;
		require( '../zz_yykinfo.php' );
		if( $zz_yykinfo_rtncd == 1 ){
			$err_flg = 4;
			
			//エラーメッセージ表示
			require( './zs_errgmn.php' );
			
			//**ログ出力**
			$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
			$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = $office_cd;	//オフィスコード
			$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
			$log_naiyou = '予約内容の取り込みに失敗しました。';	//内容
			$log_err_inf = '予約番号[' . $select_yyk_no . ']';	//エラー情報
			require( './zs_log.php' );
			//************
		
		}else if( $zz_yykinfo_rtncd == 8 ){
			//予約が無い
			$err_flg = 5;
			
		}
		

		if( $err_flg == 0 && ( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ) ){

			//現在（今日以降）の予約数を求める
			$new_yyk_cnt = 0;
			$query = 'select A.OFFICE_CD,A.CLASS_CD,A.YMD,A.JKN_KBN,A.YYK_NO,A.STAFF_CD,A.YYK_TIME,A.CANCEL_TIME,A.YYK_STAFF_CD,' .
			         'B.OFFICE_NM,C.ST_TIME,C.ED_TIME from D_CLASS_YYK A,M_OFFICE B,M_CLASS_JKNWR C ' .
					 ' where A.KG_CD = "' . $DEF_kg_cd . '" and A.KAIIN_ID = "' . $zz_yykinfo_kaiin_id . '" and A.YMD >= "' . $now_yyyymmdd . '" and A.KG_CD = B.KG_CD and A.OFFICE_CD = B.OFFICE_CD and B.ST_DATE <= "' . $now_yyyymmdd . '" and B.ED_DATE >= "' . $now_yyyymmdd . '"' .
					 ' and A.KG_CD = C.KG_CD and A.OFFICE_CD = C.OFFICE_CD and A.CLASS_CD = C.CLASS_CD and C.ST_DATE <= "' . $now_yyyymmdd . '" and C.ED_DATE >= "' . $now_yyyymmdd . '" and A.JKN_KBN = C.JKN_KBN ' .
					 ' order by A.YMD desc,A.JKN_KBN;';
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
				$log_naiyou = 'クラス予約のselectに失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
				
			}else{
				while( $row = mysql_fetch_array($result) ){
					$new_yyk_office_cd[$new_yyk_cnt] = $row[0];		//店舗コード
					$new_yyk_class_cd[$new_yyk_cnt] = $row[1];		//クラスコード
					$new_yyk_ymd[$new_yyk_cnt] = $row[2];			//年月日
					$new_yyk_jkn_kbn[$new_yyk_cnt] = $row[3];		//時間区分
					$new_yyk_yyk_no[$new_yyk_cnt] = $row[4];		//予約番号
					$new_yyk_staff_cd[$new_yyk_cnt] = $row[5];		//スタッフコード（カウンセラー指名）
					$new_yyk_yyk_time[$new_yyk_cnt] = $row[6];		//予約日時
					$new_yyk_cancel_time[$new_yyk_cnt] = $row[7];	//キャンセル可能日時
					$new_yyk_yyk_staff_cd[$new_yyk_cnt] = $row[8];	//予約受付スタッフコード
					$new_yyk_office_nm[$new_yyk_cnt] = $row[9];		//オフィス名
					$new_yyk_st_time[$new_yyk_cnt] = $row[10];		//開始時刻
					$new_yyk_ed_time[$new_yyk_cnt] = $row[11];		//終了時刻
					
					//「オフィス」を「会場」に置換する
					$new_yyk_office_nm[$new_yyk_cnt] = str_replace('オフィス','会場',$new_yyk_office_nm[$new_yyk_cnt] );			
					
					$new_yyk_cnt++;
				}
			}

			//過去の予約数を求める
			$old_yyk_cnt = 0;
			$query = 'select A.OFFICE_CD,A.CLASS_CD,A.YMD,A.JKN_KBN,A.YYK_NO,A.STAFF_CD,A.YYK_TIME,A.CANCEL_TIME,A.YYK_STAFF_CD,' .
			         'B.OFFICE_NM,C.ST_TIME,C.ED_TIME from D_CLASS_YYK A,M_OFFICE B,M_CLASS_JKNWR C ' .
					 ' where A.KG_CD = "' . $DEF_kg_cd . '" and A.KAIIN_ID = "' . $zz_yykinfo_kaiin_id . '" and A.YMD < "' . $now_yyyymmdd . '" and A.KG_CD = B.KG_CD and A.OFFICE_CD = B.OFFICE_CD and B.ST_DATE <= "' . $now_yyyymmdd . '" and B.ED_DATE >= "' . $now_yyyymmdd . '"' .
					 ' and A.KG_CD = C.KG_CD and A.OFFICE_CD = C.OFFICE_CD and A.CLASS_CD = C.CLASS_CD and C.ST_DATE <= "' . $now_yyyymmdd . '" and C.ED_DATE >= "' . $now_yyyymmdd . '" and A.JKN_KBN = C.JKN_KBN ' .
					 ' order by A.YMD desc,A.JKN_KBN;';
					 
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
				$log_naiyou = 'クラス予約のselectに失敗しました。';	//内容
				$log_err_inf = $query;			//エラー情報
				require( './zs_log.php' );
				//************
			
			}else{
				while( $row = mysql_fetch_array($result) ){
					$old_yyk_office_cd[$old_yyk_cnt] = $row[0];		//店舗コード
					$old_yyk_class_cd[$old_yyk_cnt] = $row[1];		//クラスコード
					$old_yyk_ymd[$old_yyk_cnt] = $row[2];			//年月日
					$old_yyk_jkn_kbn[$old_yyk_cnt] = $row[3];		//時間区分
					$old_yyk_yyk_no[$old_yyk_cnt] = $row[4];		//予約番号
					$old_yyk_staff_cd[$new_yyk_cnt] = $row[5];		//スタッフコード（カウンセラー指名）
					$old_yyk_yyk_time[$old_yyk_cnt] = $row[6];		//予約日時
					$old_yyk_cancel_time[$old_yyk_cnt] = $row[7];	//キャンセル可能日時
					$old_yyk_yyk_staff_cd[$old_yyk_cnt] = $row[8];	//予約受付スタッフコード
					$old_yyk_office_nm[$old_yyk_cnt] = $row[9];		//オフィス名
					$old_yyk_st_time[$old_yyk_cnt] = $row[10];		//開始時刻
					$old_yyk_ed_time[$old_yyk_cnt] = $row[11];		//終了時刻
					//「オフィス」を「会場」に置換する
					$old_yyk_office_nm[$old_yyk_cnt] = str_replace('オフィス','会場',$old_yyk_office_nm[$old_yyk_cnt] );			
					$old_yyk_cnt++;
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
			print('<td width="135" align="left">&nbsp;</td>');
			print('<td width="680" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_kbtcounseling_syosai.png" border="0"></td>');
			//戻るボタン
			if( $select_kaiin_id == "" ){
				print('<form method="post" action="yoyaku_kkn_kbtcounseling_menu.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
			}else{
				print('<form method="post" action="kaiin_kkn1.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="serch_flg" value="1">');
				print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_id . '">');
			}
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
		
			print('<hr>');
	
			//過去日時であれば、注意文を表示する
			if( $zz_yykinfo_ymd < $now_yyyymmdd2 || ($zz_yykinfo_ymd == $now_yyyymmdd2 && $zz_yykinfo_st_time < ($now_hh * 100 + $now_ii) )){
				//「過去日時を選択しています」
				print('<img src="./img_' . $lang_cd . '/warning_kakojikoku.png" border="0"><br>');
			}
			
			//年月日表示
			if( $zz_yykinfo_eigyoubi_flg == 1 || $zz_yykinfo_eigyoubi_flg == 9 ){
				//祝日
				$fontcolor = "red";
			}else if( $zz_yykinfo_youbi_cd == 0 ){
				//日曜
				$fontcolor = "red";
			}else if( $zz_yykinfo_youbi_cd == 6 ){
				//土曜
				$fontcolor = "blue";
			}else{
				//平日
				$fontcolor = "black";
			}
			
			
			//背景色
			if( $zz_yykinfo_ymd > $now_yyyymmdd2 || ($zz_yykinfo_ymd == $now_yyyymmdd2 && $zz_yykinfo_st_time > ($now_hh * 100 + $now_ii) )){
				//未来
				$bgfile_1 = "mizu";
				$bgcolor_1 = "#d6fafa";
			}else{
				//過去
				$bgfile_1 = "lightgrey";
				$bgcolor_1 = "#d3d3d3";
			}
			
			if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
				//仮登録
				$bgfile_2 = "yellow";
				$bgcolor_2 = "#fffa6e";
			}else if( $zz_yykinfo_kaiin_kbn == 1 ){
				//メンバー
				$bgfile_2 = "kimidori";
				$bgcolor_2 = "#aefd9f";
			}else if( $zz_yykinfo_kaiin_kbn == 9 ){
				//非メンバー（一般）
				$bgfile_2 = "pink";
				$bgcolor_2 = "#ffc0cb";
			}
			
			print('<table border="1">');
			//予約番号／ステータス
			print('<tr>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
			print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png"><font size="6" color="blue">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_status.png" border="0"></td>');
			print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png">');
			if( $zz_yykinfo_status == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else if( $zz_yykinfo_status == 0 ){
				print('<font size="4" color="blue">本人登録</font>');
			}else if( $zz_yykinfo_status == 1 ){
				print('<font size="4" color="blue">スタッフ受付</font><font size="2" color="blue">(' . $zz_yykinfo_yyk_staff_nm . ')</font>');
			}else if( $zz_yykinfo_status == 2 ){
				print('<font size="4" color="red">非来店</font>');
			}else if( $zz_yykinfo_status == 3 ){
				print('<font size="4" color="blue">来店</font>');
			}else if( $zz_yykinfo_status == 8 ){
				print('<font size="4" color="blue">本人キャンセル</font>');
			}else if( $zz_yykinfo_status == 9 ){
				print('<font size="4" color="blue">スタッフキャンセル</font>');
			}else{
				print('<font size="4" color="red">エラー</font>');
			}
			print('</td>');
			print('</tr>');
			
			//日時
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
			print('<td colspan="3" align="center" valign="middle" bgcolor="' . $bgcolor_1 . '"><font size="6" color="' . $fontcolor . '">' . substr($zz_yykinfo_ymd,0,4) . '</font><font size="2" color="' . $fontcolor . '">&nbsp;年&nbsp;</font><font size="6" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . '</font><font size="2" color="' . $fontcolor . '">&nbsp;月&nbsp;</font><font size="6" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,8,2))  . '</font><font size="2" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$zz_yykinfo_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="6">' .  intval( $zz_yykinfo_st_time / 100 ) . ':' . sprintf("%02d",( $zz_yykinfo_st_time % 100 )) . '&nbsp;-&nbsp;' . intval( $zz_yykinfo_ed_time / 100 ) . ':' . sprintf("%02d",( $zz_yykinfo_ed_time % 100 )) . '</font></td>');
			print('</tr>');
			
			//会場／カウンセラー
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png"><font size="4" color="blue">' . $zz_yykinfo_office_nm . '</font></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_counselor.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png">');
			if( $zz_yykinfo_open_staff_nm == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else{
				print('<font size="4" color="blue">' . $zz_yykinfo_open_staff_nm . '</font>&nbsp;<font size="2" color="blue">（' . $zz_yykinfo_staff_nm . '）</font>');
			}
			print('</td>');
			print('</tr>');
			
			//お客様番号／氏名
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_okyakusamano.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
			if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
				//仮登録
				print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">&nbsp;&nbsp;<font size="2" color="blue">(' . $zz_yykinfo_yyk_staff_nm . ')</font>');	//仮登録
			}else if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
				print('<font size="5" color="blue">' . $zz_yykinfo_kaiin_id . '</font>');
				if( $zz_yykinfo_kaiin_kbn == 1 ){
					//メンバー
					print('<br><font size="2">(' . $zz_yykinfo_kaiin_mixi . ')</font>');
				}else if( $zz_yykinfo_kaiin_kbn == 9 ){
					//一般（無料メンバー）
					print('<br><img src="./img_' . $lang_cd . '/title_ippan.png" border="0">');
				}
			}else{
				print('<font size="4" color="red">エラー</font>');
			}
			print('</td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_shimei.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
			if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">&nbsp;&nbsp;<font size="2" color="blue">(' . $zz_yykinfo_yyk_staff_nm . ')</font>');	//仮登録
			}else if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
				
				print('<table border="0">');
				print('<tr>');
				print('<td align="left" valign="middle">');
				if( $zz_yykinfo_kaiin_nm_k != "" &&  $zz_yykinfo_kaiin_nm_k != "　" ){
					print('<font size="2" color="blue">' . $zz_yykinfo_kaiin_nm_k . '</font><br>');
				}
				print('<font size="4" color="blue">' . $zz_yykinfo_kaiin_nm . '</font>');
				print('</td>');
				print('<td valign="bottom"><font size="2">様</font></td>');
				print('</tr>');
				print('</table>');
				
			}else{
				print('<font size="4" color="red">エラー</font>');
			}
			print('</td>');
			print('</tr>');

			//興味のある国／出発予定時期
//			print('<tr>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kyoumi.png" border="0"></td>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
//			if( $zz_yykinfo_kyoumi != "" ){
//				print('<font color="blue">' . $zz_yykinfo_kyoumi . '</font>');
//			}else{
//				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
//			}
//			print('</td>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_jiki.png" border="0"></td>');
//			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
//			if( $zz_yykinfo_jiki != "" ){
//				print('<font color="blue">' . $zz_yykinfo_jiki . '</font>');
//			}else{
//				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
//			}
//			print('</td>');
//			print('</tr>');

			//相談内容
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_soudannaiyou.png" border="0"></td>');
			print('<td colspan="3" align="left" valign="middle" bgcolor="' . $bgcolor_2 . '">');
			if( $zz_yykinfo_soudan != "" ){
				print('<font color="blue"><div style="margin: 10px"><pre>' . $zz_yykinfo_soudan . '</pre></div></font>');
			}else{
				print('&nbsp;&nbsp;&nbsp;<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}
			print('</td>');
			print('</tr>');
			
			//前日メール／当日メール
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_znjt_mail.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
			if( $zz_yykinfo_znz_mail_send_flg == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else if( $zz_yykinfo_znz_mail_send_flg == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_misoushin.png" border="0">');	//未送信
			}else if( $zz_yykinfo_znz_mail_send_flg == 1 ){
				print('<img src="./img_' . $lang_cd . '/title_soushinzumi.png" border="0">');	//送信済み
			}else{
				print('<img src="./img_' . $lang_cd . '/title_error.png" border="0">');	//エラー
			}
			print('</td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_tjt_mail.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
			if( $zz_yykinfo_tjt_mail_send_flg == "" ){
				print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');	//未登録
			}else if( $zz_yykinfo_tjt_mail_send_flg == 0 ){
				print('<img src="./img_' . $lang_cd . '/title_misoushin.png" border="0">');	//未送信
			}else if( $zz_yykinfo_tjt_mail_send_flg == 1 ){
				print('<img src="./img_' . $lang_cd . '/title_soushinzumi.png" border="0">');	//送信済み
			}else{
				print('<img src="./img_' . $lang_cd . '/title_error.png" border="0">');	//エラー
			}
			print('</td>');
			print('</tr>');

			//予約日時／キャンセル可能期限
			print('<tr>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yyktime.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">' . $zz_yykinfo_yyk_time . '</td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_canceltime.png" border="0"></td>');
			print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">' . $zz_yykinfo_cancel_time . '</td>');
			print('</tr>');

			print('</table>');

			print('<table border="0">');
			print('<tr>');
			print('<td width="535">&nbsp;</td>');
			if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
				//日時変更
				print('<form method="post" action="kbtcounseling_trk_selectdate.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_yyyy" value="' . substr($select_ymd,0,4) . '">');
				print('<input type="hidden" name="select_mm" value="' . substr($select_ymd,4,2) . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $zz_yykinfo_staff_cd . '">');
				print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
				print('<td width="135" align="center" valign="middle">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_date_change_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_date_change_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_date_change_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
			
			}else if( $zz_yykinfo_kaiin_kbn == 0 ){
				//会員の選択
				print('<form method="post" action="kbtcounseling_trk_kari_serch.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
				print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
				print('<td width="135" align="center" valign="middle">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_select_kaiin_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_select_kaiin_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_select_kaiin_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				
			}else{
				print('<td width="135" align="center" valign="middle">&nbsp;</td>');
			}
			//キャンセル
			print('<form method="post" action="yoyaku_kkn_kbtcounseling_can1.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="150" align="center" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_cancel_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_cancel_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_cancel_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');

			print('<hr>');

			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">&nbsp;</td>');
			//戻るボタン
			if( $select_kaiin_id == "" ){
				print('<form method="post" action="yoyaku_kkn_kbtcounseling_menu.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
			}else{
				print('<form method="post" action="kaiin_kkn1.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="serch_flg" value="1">');
				print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_id . '">');
			}
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
	
			print('<hr>');

			if( $zz_yykinfo_kaiin_kbn == 1 || $zz_yykinfo_kaiin_kbn == 9 ){
				
				//***現在の予約********************************************************************
				print('<table bgcolor="orange"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_genzaiyyk.png" border="0">');
				print('</td></tr></table>');
				
				//「本日以降の予約数」
				print('<table border="0">');
				print('<tr>');
				print('<td valign="bottom"><img src="./img_' . $lang_cd . '/title_honjitsuikounoyyksu.png" border="0"></td>');
				print('<td valign="bottom"><font size="5" color="blue">' . $new_yyk_cnt . '</font></td>');
				print('<td valign="bottom"><img src="./img_' . $lang_cd . '/title_ken.png" border="0"></td>');
				print('</tr>');
				print('</table>');
				
				if( $new_yyk_cnt == 0 ){
					//「※現在、予約はありません。」
					print('<img src="./img_' . $lang_cd . '/title_yoyaku_zero.png" bordrr="0"><br>');
				
				}else{
					
					print('<table border="1">');
					print('<tr bgcolor="powderblue">');
					print('<td width="55" align="center" valign="middle">&nbsp;</td>');	//詳細ボタン
					print('<td width="80" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_no_80x20.png" border="0"></td>');	//予約No
					print('<td width="130" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_time_80x20.png" border="0"></td>');	//予約日時
					print('<td width="235" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_naiyou_80x20.png" border="0"></td>');	//予約内容
					print('<td width="235" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_kaijyou_80x20.png" border="0"></td>');	//予約会場
					print('<td width="180" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_trkbi_170x20.png" border="0"></td>');	//予約登録日／登録者
					print('</tr>');
					
					$i = 0;
					while( $i < $new_yyk_cnt ){
						
						//曜日コードを求める
						$youbi_cd = date("w", mktime(0, 0, 0, substr($new_yyk_ymd[$i],5,2), substr($new_yyk_ymd[$i],8,2) , substr($new_yyk_ymd[$i],0,4)) );							
						//営業日フラグを求める
						$eigyoubi_flg = 0;	//0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
						$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $new_yyk_office_cd[$i] . '" and YMD = "' . $new_yyk_ymd[$i] . '";';
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
						
						//背景色
						if( $new_yyk_ymd[$i] == $now_yyyymmdd2 ){
							//本日予約
							$bgfile = "bg_mizu";
						}else{
							//未来日
							$bgfile = "bg_yellow";
						}
					
						print('<tr>');
						//詳細ボタン
						print('<form method="post" action="yoyaku_kkn_kbtcounseling_kkn.php">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
						print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
						print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
						print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
						print('<input type="hidden" name="select_ymd" value="' . substr($new_yyk_ymd[$i],0,4) . substr($new_yyk_ymd[$i],5,2) . substr($new_yyk_ymd[$i],8,2) . '">');
						print('<input type="hidden" name="select_yyk_no" value="' . $new_yyk_yyk_no[$i] . '">');
						print('<input type="hidden" name="select_kaiin_id" value="' . $data_kaiin_no[0] . '">');
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_mini_syousai_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_mini_syousai_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_mini_syousai_1.png\';" onClick="kurukuru()" border="0">');
						print('</td>');
						print('</form>');
						//予約No
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
						print('<font size="2">' . sprintf("%05d",$new_yyk_yyk_no[$i]) . '</font>');
						print('</td>');
						//予約日／時間
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_130x20.png">');
						if( $youbi_cd == 0 || $eigyoubi_flg == 1 || $eigyoubi_flg == 9 ){
							//日曜・祝日
							$fontcolor = 'red';
						}else if( $youbi_cd == 6 ){
							//土曜
							$fontcolor = 'blue';
						}else{
							$fontcolor = 'black';
						}
						print('<font size="2" color="' . $fontcolor . '">' . $new_yyk_ymd[$i] . '&nbsp;' . $week[$youbi_cd] .'</font><br><font size="2">' . intval($new_yyk_st_time[$i] / 100 ) . ':' . sprintf("%02d",($new_yyk_st_time[$i] % 100 )) . '～' . intval($new_yyk_ed_time[$i] / 100 ) . ':' . sprintf("%02d",($new_yyk_ed_time[$i] % 100 )) . '</font>');
						print('</td>');
						//予約内容
						print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_235x20.png">');
						//クラス名を求める
						$Dclass_class_nm = "";
						$query = 'select CLASS_NM from M_CLASS ' .
								 ' where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $new_yyk_office_cd[$i] . '" and CLASS_CD = "' . $new_yyk_class_cd[$i] . '";';
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
							$log_naiyou = 'クラスマスタの参照に失敗しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zs_log.php' );
							//************
							
						}else{
							$row = mysql_fetch_array($result);
							$Dclass_class_nm = $row[0];	//クラス名
						}
						print('<font color="blue">&nbsp;&nbsp;' . $Dclass_class_nm . '</font>');
						print('</td>');
						//予約会場
						print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_235x20.png">');
						print('<font size="2" color="blue">&nbsp;&nbsp;' . $new_yyk_office_nm[$i] . '</font>');
						if( $new_yyk_staff_cd[$i] != "" ){
							//カウンセラー指名あり
							$query = 'select DECODE(OPEN_STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $new_yyk_staff_cd[$i] . '";';
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
								$new_yyk_staff_nm[$i] = $row[0];
							}
							print('<br><font size="1" color="blue">&nbsp;&nbsp;(&nbsp;' . $new_yyk_staff_nm[$i] . '&nbsp;)</font>');
						}
						print('</td>');
						//予約登録日／受付者
						$new_yyk_yyk_staff_nm[$i] = '';
						if( $new_yyk_yyk_staff_cd[$i] != '' ){
						
							//受付スタッフ名の取得（今回、検索条件からオフィスコードは外しておく）
							$query = 'select DECODE(STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $new_yyk_yyk_staff_cd[$i] . '";';
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
								$new_yyk_yyk_staff_nm[$i] = $row[0];
							}
						}
						print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png">');
						print('<font size="2">&nbsp;&nbsp;' . $new_yyk_yyk_time[$i] . '<br>&nbsp;&nbsp;');
						if( $new_yyk_yyk_staff_cd[$i] == '' ){
							print('会員入力');
						}else{
							print('<font size="1">受付：</font>'. $new_yyk_yyk_staff_nm[$i] );
						}
						print('</font>');
						print('</td>');
						print('</tr>');
					
						$i++;
					}
					print('</table>');
					
				}
				
				print('<hr>');
				
				//***過去の予約********************************************************************
				print('<table bgcolor="lightgrey"><tr><td width="950">');
				print('<img src="./img_' . $lang_cd . '/bar_kakoyyk.png" border="0">');
				print('</td></tr></table>');
				
				//「過去の予約数」
				print('<table border="0">');
				print('<tr>');
				print('<td valign="bottom"><img src="./img_' . $lang_cd . '/title_kakonoyyksu.png" border="0"></td>');
				print('<td valign="bottom"><font size="5" color="blue">' . $old_yyk_cnt . '</font></td>');
				print('<td valign="bottom"><img src="./img_' . $lang_cd . '/title_ken.png" border="0"></td>');
				print('</tr>');
				print('</table>');
				
				if( $old_yyk_cnt == 0 ){
					//「※現在、予約はありません。」
					print('<img src="./img_' . $lang_cd . '/title_yoyaku_zero.png" bordrr="0"><br>');
				
				}else{
					
					print('<table border="1">');
					print('<tr bgcolor="powderblue">');
					print('<td width="55" align="center" valign="middle">&nbsp;</td>');	//詳細ボタン
					print('<td width="80" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_no_80x20.png" border="0"></td>');	//予約No
					print('<td width="130" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_time_80x20.png" border="0"></td>');	//予約日時
					print('<td width="235" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_naiyou_80x20.png" border="0"></td>');	//予約内容
					print('<td width="235" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_kaijyou_80x20.png" border="0"></td>');	//予約会場
					print('<td width="180" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_yyk_trkbi_170x20.png" border="0"></td>');	//予約登録日／登録者
					print('</tr>');
					
					$i = 0;
					while( $i < $old_yyk_cnt ){
						
						//曜日コードを求める
						$youbi_cd = date("w", mktime(0, 0, 0, substr($old_yyk_ymd[$i],5,2), substr($old_yyk_ymd[$i],8,2) , substr($old_yyk_ymd[$i],0,4)) );							
						//営業日フラグを求める
						$eigyoubi_flg = 0;	//0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
						$query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $old_yyk_office_cd[$i] . '" and YMD = "' . $old_yyk_ymd[$i] . '";';
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
						
						//背景色
						$bgfile = "bg_lightgrey";
					
						print('<tr>');
						//詳細ボタン
						print('<form method="post" action="yoyaku_kkn_kbtcounseling_kkn.php">');
						print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
						print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
						print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
						print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
						print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
						print('<input type="hidden" name="select_ymd" value="' . substr($old_yyk_ymd[$i],0,4) . substr($old_yyk_ymd[$i],5,2) . substr($old_yyk_ymd[$i],8,2) . '">');
						print('<input type="hidden" name="select_yyk_no" value="' . $old_yyk_yyk_no[$i] . '">');
						print('<input type="hidden" name="select_kaiin_id" value="' . $data_kaiin_no[0] . '">');
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
						$tabindex++;
						print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_mini_syousai_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_mini_syousai_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_mini_syousai_1.png\';" onClick="kurukuru()" border="0">');
						print('</td>');
						print('</form>');
						//予約No
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_80x20.png">');
						print('<font size="2">' . sprintf("%05d",$old_yyk_yyk_no[$i]) . '</font>');
						print('</td>');
						//予約日／時間
						print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_130x20.png">');
						if( $youbi_cd == 0 || $eigyoubi_flg == 1 || $eigyoubi_flg == 9 ){
							//日曜・祝日
							$fontcolor = 'red';
						}else if( $youbi_cd == 6 ){
							//土曜
							$fontcolor = 'blue';
						}else{
							$fontcolor = 'black';
						}
						print('<font size="2" color="' . $fontcolor . '">' . $old_yyk_ymd[$i] . '&nbsp;' . $week[$youbi_cd] .'</font><br><font size="2">' . intval($old_yyk_st_time[$i] / 100 ) . ':' . sprintf("%02d",($old_yyk_st_time[$i] % 100 )) . '～' . intval($old_yyk_ed_time[$i] / 100 ) . ':' . sprintf("%02d",($old_yyk_ed_time[$i] % 100 )) . '</font>');
						print('</td>');
						//予約内容
						print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_235x20.png">');
						//クラス名を求める
						$query = 'select CLASS_NM from M_CLASS ' .
								 ' where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $old_yyk_office_cd[$i] . '" and CLASS_CD = "' . $old_yyk_class_cd[$i] . '";';
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
							$log_naiyou = 'クラスマスタの参照に失敗しました。';	//内容
							$log_err_inf = $query;			//エラー情報
							require( './zs_log.php' );
							//************
				
						}else{
							$row = mysql_fetch_array($result);
							$Dclassyyk_class_nm = $row[0];	//クラス名
						}
						print('<font color="blue">&nbsp;&nbsp;' . $Dclassyyk_class_nm . '</font>');
						print('</td>');
						//予約会場
						print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_235x20.png">');
						print('<font size="2" color="blue">&nbsp;&nbsp;' . $old_yyk_office_nm[$i] . '</font>');
						if( $old_yyk_staff_cd[$i] != "" ){
							//カウンセラー指名あり
							$query = 'select DECODE(OPEN_STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $old_yyk_staff_cd[$i] . '";';
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
								$old_yyk_staff_nm[$i] = $row[0];
							}
							print('<br><font size="1" color="blue">&nbsp;&nbsp;(&nbsp;' . $old_yyk_staff_nm[$i] . '&nbsp;)</font>');
						}
						print('</td>');
						//予約登録日／受付者
						$old_yyk_yyk_staff_nm[$i] = '';
						if( $old_yyk_yyk_staff_cd[$i] != '' ){
							//受付スタッフ名の取得（今回、検索条件からオフィスコードは外しておく）
							$query = 'select DECODE(STAFF_NM,"' . $ANGpw . '") from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and STAFF_CD = "' . $old_yyk_yyk_staff_cd[$i] . '";';
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
								$old_yyk_yyk_staff_nm[$i] = $row[0];
							}
						}
						print('<td align="left" valign="middle" background="../img_' . $lang_cd . '/' . $bgfile . '_180x20.png">');
						print('<font size="2">&nbsp;&nbsp;' . $old_yyk_yyk_time[$i] . '<br>&nbsp;&nbsp;');
						if( $old_yyk_yyk_staff_cd[$i] == '' ){
							print('会員入力');
						}else{
							print('<font size="1">受付：</font>'. $old_yyk_yyk_staff_nm[$i] );
						}
						print('</font>');
						print('</td>');
						print('</tr>');
					
						$i++;
					}
					print('</table>');
					
				}
				
				print('<hr>');
				
			}

			print('</center>');


		}else if( $err_flg == 5 ){
			//予約が無い
			
			//ページ編集
			print('<center>');
			
			print('<table><tr>');
			print('<td width="950" bgcolor="lightgreen"><img src="./img_' . $lang_cd . '/bar_yykkkn_kbtcounseling_menu.png" border="0"></td>');
			print('</tr></table>');
	
			print('<table border="0">');
			print('<tr>');
			print('<td width="135" align="left">&nbsp;</td>');
			print('<td width="680" align="center" valign="middle"><img src="./img_' . $lang_cd . '/title_kbtcounseling_syosai.png" border="0"></td>');
			//戻るボタン
			if( $select_kaiin_id == "" ){
				print('<form method="post" action="yoyaku_kkn_kbtcounseling_menu.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_ymd" value="' . $select_ymd . '">');
			}else{
				print('<form method="post" action="kaiin_kkn1.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="serch_flg" value="1">');
				print('<input type="hidden" name="select_kaiin_no" value="' . $select_kaiin_id . '">');
			}
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
		
			print('<br>');
			
			//「この予約はキャンセル済みです。」
			print('<img src="./img_' . $lang_cd . '/title_cancel_delzumi.png" border="0"><br>');

			print('<table border="1">');
			print('<tr>');
			print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
			print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_lightgrey_300x20.png"><font size="6" color="gray">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
			print('</tr>');
			print('</table>');
			
			print('<br><br><br><br><br><br><br><br>');
			
			print('<hr>');
			
			print('</center>');

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