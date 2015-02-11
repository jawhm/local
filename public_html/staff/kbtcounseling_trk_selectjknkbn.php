<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>個別カウンセリング（時間選択）</title>
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
	$gmn_id = 'kbtcounseling_trk_selectjknkbn.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kbtcounseling_trk_selectdate.php','kbtcounseling_trk_selectjknkbn.php','kbtcounseling_trk_serch.php',
					'kbtcounseling_trk_serch_kkn0.php','kbtcounseling_trk_serch_kkn1.php');

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
	$select_staff_cd = $_POST['select_staff_cd'];	//未入力可（カウンセラーを指定した場合のみ設定される）
	$select_ymd = $_POST['select_ymd'];
	//日時変更用
	$select_yyk_no = $_POST['select_yyk_no'];		//(未入力OK)　日時変更時に変更対象となる予約番号が設定される


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

		//各時間区分における非メンバーの予約可能数
		$notmember_max_entry = 99;

		//画像事前読み込み
		print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_zensyu_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="./img_' . $lang_cd . '/btn_yokusyu_2.png" width="0" height="0" style="visibility:hidden;">');
		print('<img src="../img_' . $lang_cd . '/btn_select2_2.png" width="0" height="0" style="visibility:hidden;">');

		//店舗メニューボタン表示
		require( './zs_menu_button.php' );

		if( $select_yyk_no != "" ){
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
			
			if( $zz_yykinfo_ymd != "" ){
				$zz_yykinfo_ymd_yyyymmdd = substr($zz_yykinfo_ymd,0,4) . substr($zz_yykinfo_ymd,5,2) . substr($zz_yykinfo_ymd,8,2);
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
			$Moffice_office_nm = $row[0];		//オフィス名
			$Moffice_start_youbi = $row[1];	//開始曜日（ 0:日曜始まり 1:月曜始まり ）
			
			//「オフィス」を「会場」に置換する
			$Moffice_office_nm = str_replace('オフィス','会場',$Moffice_office_nm );			
		}

		//個別カウンセラーを求める
		$Mstaff_staff_nm = "指名なし";
		$Mstaff_open_staff_nm = "全員対象";
		$Mstaff_st_date = "2012-01-01";
		$Mstaff_ed_date = "2037-12-31";
		if( $select_staff_cd != "" ){
			$query = 'select DECODE(STAFF_NM,"' . $ANGpw . '"),DECODE(OPEN_STAFF_NM,"' . $ANGpw . '"),ST_DATE,ED_DATE from M_STAFF where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and STAFF_CD = "' . $select_staff_cd . '";';
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
					$Mstaff_staff_nm = $row[0];			//スタッフ名
					$Mstaff_open_staff_nm = $row[1];	//公開スタッフ名
					$Mstaff_st_date = substr($row[2],0,4) . substr($row[2],5,2) . substr($row[2],8,2);		//開始日
					$Mstaff_ed_date = substr($row[3],0,4) . substr($row[3],5,2) . substr($row[3],8,2);		//終了日
				}
			}
		}

		//選択日情報
		$target_yyyymmdd = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($select_ymd,4,2)), sprintf("%d",substr($select_ymd,6,2)) , sprintf("%d",substr($select_ymd,0,4))) );
		$target_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), sprintf("%d",substr($target_yyyymmdd,6,2)), sprintf("%d",substr($target_yyyymmdd,0,4))));

		//選択日の前週
		$bfweek_date = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), (sprintf("%d",substr($target_yyyymmdd,6,2)) - 7) , sprintf("%d",substr($target_yyyymmdd,0,4))) );
		//選択日の翌週
		$afweek_date = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), (sprintf("%d",substr($target_yyyymmdd,6,2)) + 7) , sprintf("%d",substr($target_yyyymmdd,0,4))) );

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
			
			print('<table><tr>');
			print('<td width="950" bgcolor="lightblue"><img src="./img_' . $lang_cd . '/bar_kbtcounseling_menu.png" border="0"></td>');
			print('</tr></table>');

			if( $select_yyk_no == "" ){
				//新規予約時

				print('<table border="0">');
				print('<tr>');
				print('<td width="405" align="left">');
				//会場名
				print('<img src="./img_' . $lang_cd . '/bar_kaijyou.png"><br><font size="5" color="blue">' . $Moffice_office_nm . '</font>');
				print('</td>');
				print('<td width="410" align="left">');
				//カウンセラー名
				print('<img src="./img_' . $lang_cd . '/bar_counselor.png"><br><font size="5" color="blue">' . $Mstaff_open_staff_nm . '</font><font color="blue">(' . $Mstaff_staff_nm . ')</font>');
				print('</td>');
				print('<form method="post" action="kbtcounseling_trk_selectdate.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_yyyy" value="' . substr($select_ymd,0,4) . '">');
				print('<input type="hidden" name="select_mm" value="' . sprintf("%d",substr($select_ymd,4,2)) . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
				print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
			
				print('<hr>');
				
			}else{
				//予約日時変更時
				
				print('<table border="0">');
				print('<tr>');
				print('<td width="135">&nbsp;</td>');
				print('<td width="680" align="center" valign="middle">');
				//「個別カウンセリング　日時変更　（現在の予約内容）」
				print('<img src="./img_' . $lang_cd . '/title_kbtcounseling_genzainaiyou.png" border="0"><br>');
				print('</td>');
				print('<form method="post" action="kbtcounseling_trk_selectdate.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
				print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
				print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
				print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
				print('<input type="hidden" name="select_yyyy" value="' . substr($select_ymd,0,4) . '">');
				print('<input type="hidden" name="select_mm" value="' . sprintf("%d",substr($select_ymd,4,2)) . '">');
				print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
				//日時変更引数
				print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
				print('<td align="right">');
				$tabindex++;
				print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
				
				//現在の予約内容を表示する
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
					$bgcolor_2 = "#fffa6e";
					$bgfile_2 = "yellow";
				}else if( $zz_yykinfo_kaiin_kbn == 1 ){
					//メンバー
					$bgcolor_2 = "#aefd9f";
					$bgfile_2 = "kimidori";
				}else if( $zz_yykinfo_kaiin_kbn == 9 ){
					//一般（無料メンバー）
					$bgcolor_2 = "#ffc0cb";
					$bgfile_2 = "pink";
				}
						
				//年月日表示
				if( $zz_yykinfo_eigyoubi_flg == 1 || $zz_yykinfo_eigyoubi_flg == 9 ){
					//祝日
					$fontcolor_2 = "red";
				}else if( $zz_yykinfo_youbi_cd == 0 ){
					//日曜
					$fontcolor_2 = "red";
				}else if( $zz_yykinfo_youbi_cd == 6 ){
					//土曜
					$fontcolor_2 = "blue";
				}else{
					//平日
					$fontcolor_2 = "black";
				}
			
				print('<table border="1">');
				//予約番号／会場
				print('<tr>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_yykno.png" border="0"></td>');
				print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png"><font size="6" color="blue">' . sprintf("%05d",$select_yyk_no) . '</font></td>');
				print('<td width="110" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_kaijyou.png" border="0"></td>');
				print('<td width="300" align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_300x20.png"><font size="4" color="blue">' . $zz_yykinfo_office_nm . '</font>');
				if( $zz_yykinfo_staff_cd != "" ){
					print('<font size="2" color="blue">&nbsp;(&nbsp;' . $zz_yykinfo_open_staff_nm . '&nbsp;)</font>');
				}
				print('</td>');
				print('</tr>');
				
				//日時
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_1 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_nichiji.png" border="0"></td>');
				print('<td colspan="3" align="center" valign="middle" bgcolor="' . $bgcolor_1 . '"><font size="6" color="' . $fontcolor . '">' . substr($zz_yykinfo_ymd,0,4) . '</font><font size="2" color="' . $fontcolor . '">&nbsp;年&nbsp;</font><font size="6" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,5,2)) . '</font><font size="2" color="' . $fontcolor . '">&nbsp;月&nbsp;</font><font size="6" color="' . $fontcolor . '">' . sprintf("%d",substr($zz_yykinfo_ymd,8,2))  . '</font><font size="2" color="' . $fontcolor . '">&nbsp;日</font>&nbsp;<font size="5" color="' . $fontcolor . '">' . $week[$zz_yykinfo_youbi_cd] . '</font><font size="1" color="' . $fontcolor . '">&nbsp;曜日</font>&nbsp;<font size="6">' .  intval( $zz_yykinfo_st_time / 100 ) . ':' . sprintf("%02d",( $zz_yykinfo_st_time % 100 )) . '&nbsp;-&nbsp;' . intval( $zz_yykinfo_ed_time / 100 ) . ':' . sprintf("%02d",( $zz_yykinfo_ed_time % 100 )) . '</font></td>');
				print('</tr>');
				
				//お客様番号／氏名
				print('<tr>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_110x20.png"><img src="./img_' . $lang_cd . '/title_mini_okyakusamano.png" border="0"></td>');
				print('<td align="center" valign="middle" background="../img_' . $lang_cd . '/bg_' . $bgfile_2 . '_300x20.png">');
				if( $zz_yykinfo_kaiin_kbn != "" && $zz_yykinfo_kaiin_kbn == 0 ){
					print('<img src="./img_' . $lang_cd . '/title_mini_karitrk.png" border="0">&nbsp;&nbsp;<font size="2" color="blue">(' . $zz_yykinfo_yyk_staff_nm . ')</font>');	//仮登録
				}else if( $zz_yykinfo_kaiin_kbn == 1 ){
					//メンバー
					print('<font size="5" color="blue">' . $zz_yykinfo_kaiin_id . '</font><br>(' . $zz_yykinfo_kaiin_mixi . ')');
				}else if( $zz_yykinfo_kaiin_kbn == 9 ){
					//一般（無料メンバー）
					print('<font size="5" color="blue">' . $zz_yykinfo_kaiin_id . '</font><br><img src="./img_' . $lang_cd . '/title_ippan.png" border="0">');
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
					if( $zz_yykinfo_kaiin_nm_k != "" ){
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
				print('</table>');
				
				print('<hr>');
			
			}

			print('<table border="0">');
			print('<tr>');
			//前週表示ボタン
			print('<form method="post" action="' . $sv_https_adr . 'staff/kbtcounseling_trk_selectjknkbn.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $bfweek_date . '">');
			//日時変更引数
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="135" align="center" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_zensyu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_zensyu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_zensyu_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('<td width="680" align="center" valign="middle">');
			if( $select_yyk_no == "" ){
				//新規登録時
				
				//「時間帯を選択してください。」
				print('<img src="./img_' . $lang_cd . '/title_select_jikantai.png" border="0">');
				
			}else{
				//日付変更時
				
				//カウンセラー名
				print('<table border="0">');
				print('<tr>');
				print('<td align="left">');
				print('<img src="./img_' . $lang_cd . '/bar_counselor.png"><br><font size="5" color="blue">' . $Mstaff_open_staff_nm . '</font><font color="blue">(' . $Mstaff_staff_nm . ')</font>');
				print('</td>');
				print('</tr>');
				print('</table>');

			}
			print('</td>');
			//翌週表示ボタン
			print('<form method="post" action="' . $sv_https_adr . 'staff/kbtcounseling_trk_selectjknkbn.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $afweek_date . '">');
			//日時変更引数
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="135" align="center" valign="middle">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_yokusyu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_yokusyu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_yokusyu_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
			
			print('<hr>');
	
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
				print('<td width="630" align="left" valign="bottom">');
				print('&nbsp;');
				print('</td>');
				print('</tr>');
				print('</table>');

				print('<table border="1">');
				print('<tr>');
				
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){
					
					//非メンバーの予約数を求める
					$notmember_yyk_cnt[$j] = 0;
					$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $target_yyyymmdd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and KAIIN_KBN = 9;';
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
					
					print('<td width="110" align="center" valign="middle" ');
					if( $target_teikyubi_flg == 1 ){
						//定休日
						print('background="../img_' . $lang_cd . '/bg_yellow_110x20.png"');
					}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
						//非営業日
						print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
					}else if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
						//営業時間外
						print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
					}else if( $target_yyyymmdd < $now_yyyymmdd || ( $target_yyyymmdd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] < (($now_hh * 100) + $now_ii)) ){
						//過去時間帯
						print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
					//}else if( in_array($Mclassjknwr_jkn_kbn[$j] , $jkn_kbn_array_1) ){
					}else if( $notmember_yyk_cnt[$j] < $notmember_max_entry ){
						//非メンバーの予約可能数を下回っている場合
						//メンバー および 一般 の時間区分
						print('background="../img_' . $lang_cd . '/bg_mizu_110x20.png"');
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
								
				//選択ボタン
				print('<tr>');
				$j = 0;
				while( $j < $Mclassjknwr_cnt ){
					
					//該当日／時間割のクラス予約を参照し、現在の個別カウンセリングの予約を取得する（全員分）
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


					//該当日／時間割のスタッフスケジュールを参照し、現在の受付人数を取得する（全員分）
					$tmp_uktk_ninzu = '';
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
						while( $row = mysql_fetch_array($result) ){
							$tmp_uktk_ninzu = $row[0];	//受付人数
						}
					}
					
					//カウンセラー指名の場合
					$tmp_shimei_flg = 0;
					$tmp_uktk_flg = 0;
					if( $select_staff_cd != "" ){
						//カウンセラー指名の予約があるかチェックする
						$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and CLASS_CD = "KBT" and YMD = "' . $target_yyyymmdd . '" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and STAFF_CD = "' . $select_staff_cd . '";';
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
							if( $row[0] > 0 ){
								$tmp_shimei_flg = 1;
							}
						}
						
						//そのカウンセラーは予約受付登録しているかチェックする
						$query = 'select count(*) from D_STAFF_SC where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD = "' . $target_yyyymmdd . '" and STAFF_CD = "' . $select_staff_cd . '" and CLASS_CD = "KBT" and JKN_KBN = "' . $Mclassjknwr_jkn_kbn[$j] . '" and OPEN_FLG = 1 and UKTK_FLG = 1;';
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
							if( $row[0] > 0 ){
								$tmp_uktk_flg = 1;	//受付人数
							}
						}
						
					}
							
					
					//選択ボタン
					if( $tmp_yyk_cnt < $tmp_uktk_ninzu && ($target_eigyoubi_flg == 0 || $target_eigyoubi_flg == 1) && $target_teikyubi_flg == 0 ){
						if( $select_yyk_no == "" ){
							//新規予約時
							print('<form method="post" action="kbtcounseling_trk_serch.php">');
							print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
							print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
							print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
							print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
							print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
							print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
							print('<input type="hidden" name="select_ymd" value="' . $target_yyyymmdd . '">');
							print('<input type="hidden" name="select_jknkbn" value="' . $Mclassjknwr_jkn_kbn[$j] . '">');						
							print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
							
						}else{
							//日時変更時	
							print('<form method="post" action="kbtcounseling_trk_serch_kkn0.php">');
							print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
							print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
							print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
							print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
							print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
							print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
							print('<input type="hidden" name="select_ymd" value="' . $target_yyyymmdd . '">');
							print('<input type="hidden" name="select_jknkbn" value="' . $Mclassjknwr_jkn_kbn[$j] . '">');						
							//日時変更引数
							print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
							
							print('<input type="hidden" name="serch_flg" value="1">');
							print('<input type="hidden" name="select_kaiin_no" value="' . $zz_yykinfo_kaiin_id . '">');
							print('<input type="hidden" name="select_kaiin_nm" value="">');
							print('<input type="hidden" name="select_kaiin_mail" value="">');
							print('<input type="hidden" name="select_kaiin_tel" value="">');
							
						}
					}
					
					print('<td width="110" align="center" valign="middle" ');
					if( $target_teikyubi_flg == 1 ){
						//定休日
						print('background="../img_' . $lang_cd . '/bg_yellow_110x20.png"');
					}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
						//非営業日
						print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
					}else if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
						//営業時間外
						print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
					}else if( $target_yyyymmdd < $now_yyyymmdd || ( $target_yyyymmdd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] < (($now_hh * 100) + $now_ii)) ){
						//過去時間帯
						print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
					//}else if( in_array($Mclassjknwr_jkn_kbn[$j] , $jkn_kbn_array_1) ){
					}else if( $notmember_yyk_cnt[$j] < $notmember_max_entry ){
						//非メンバーの予約可能数を下回っている場合
						//メンバー および 一般 の時間区分
						print('background="../img_' . $lang_cd . '/bg_mizu_110x20.png"');
					}else{
						//メンバーのみ の時間区分
						print('background="../img_' . $lang_cd . '/bg_pink_110x20.png"');
					}
					print('>');

					if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
						//営業時間外
						print('<img src="../img_' . $lang_cd . '/title_eigyou_jkngai.png" border="0">');
						
					}else{
						//営業時間内
						if( $tmp_yyk_cnt < $tmp_uktk_ninzu && ($target_eigyoubi_flg == 0 || $target_eigyoubi_flg == 1) && $target_teikyubi_flg == 0 ){
							//選択ボタン
							
							if( $zz_yykinfo_ymd_yyyymmdd == $target_yyyymmdd && $select_yyk_st_time == $Mclassjknwr_st_time[$j] ){
								//日時変更時の変更前の時間帯
								//「現在の選択」
								print('<img src="./img_' . $lang_cd . '/title_mini_now_selecttime.png" border="0">');
							
							}else{
								
								if( $select_staff_cd == "" ){
									//全員分
									
									if( $tmp_uktk_ninzu > 0 ){
										//過去日も入力可とする
										$tabindex++;
										print('<input type="image" tabindex="' . $tabindex . '" src="../img_' . $lang_cd . '/btn_select2_1.png" onmouseover="this.src=\'../img_' . $lang_cd . '/btn_select2_2.png\';" onmouseout="this.src=\'../img_' . $lang_cd . '/btn_select2_1.png\';" onClick="kurukuru()" border="0">');
									}else{
										//受付不可	
										print('<img src="../img_' . $lang_cd . '/title_uktk_fuka.png" border="0">');
									}
									
								}else{
									//カウンセラー指名
									if( $tmp_shimei_flg == 0 && $tmp_uktk_flg == 1 ){
										//指名予約は無いので選択ボタンを表示
										//過去日も入力可とする
										$tabindex++;
										print('<input type="image" tabindex="' . $tabindex . '" src="../img_' . $lang_cd . '/btn_select2_1.png" onmouseover="this.src=\'../img_' . $lang_cd . '/btn_select2_2.png\';" onmouseout="this.src=\'../img_' . $lang_cd . '/btn_select2_1.png\';" onClick="kurukuru()" border="0">');
									}else if( $tmp_shimei_flg == 1 && $tmp_uktk_flg == 1 ){
										//指名予約があるので満席表示
										print('<img src="../img_' . $lang_cd . '/title_manseki.png" border="0">');
									}else{
										//受付不可	
										print('<img src="../img_' . $lang_cd . '/title_uktk_fuka.png" border="0">');
									}
								}
							}
							
						}else{
							if( $target_teikyubi_flg == 1 ){
								print('定休日');							
							}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
								print('非営業日');
							}else if( $tmp_uktk_ninzu == "" ){
								//未登録
								print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');							
							}else if( $tmp_uktk_ninzu > 0 ) {
								//満席
								print('<img src="../img_' . $lang_cd . '/title_manseki.png" border="0">');
							}else{
								//受付不可	
								print('<img src="../img_' . $lang_cd . '/title_uktk_fuka.png" border="0">');
							}
						}
					}
				
					print('</td>');
					if( $tmp_yyk_cnt < $tmp_uktk_ninzu && ($target_eigyoubi_flg == 0 || $target_eigyoubi_flg == 1) && $target_teikyubi_flg == 0 ){
						print('</form>');
					}
				
					$j++;
				}			
				print('</tr>');

				if( ($target_eigyoubi_flg == 0 || $target_eigyoubi_flg == 1) && $target_teikyubi_flg == 0 ){
					//現在予約数
					print('<tr>');
					$j = 0;
					while( $j < $Mclassjknwr_cnt ){
						
						//該当日／時間割のクラス予約を参照し、現在の個別カウンセリングの予約を取得する
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
	
	
						//該当日／時間割のスタッフスケジュールを参照し、現在の受付人数を取得する
						$tmp_uktk_ninzu = '';
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
							while( $row = mysql_fetch_array($result) ){
								$tmp_uktk_ninzu = $row[0];	//受付人数
							}
						}
				
						print('<td width="110" align="center" valign="middle" ');
						if( $target_teikyubi_flg == 1 ){
							//定休日
							print('background="../img_' . $lang_cd . '/bg_yellow_110x20.png"');
						}else if( $target_eigyoubi_flg == 8 || $target_eigyoubi_flg == 9 ){
							//非営業日
							print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
						}else if( !($target_eigyou_st_time <= $Mclassjknwr_st_time[$j] && $Mclassjknwr_ed_time[$j] <= $target_eigyou_ed_time) ){
							//営業時間外
							print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
						}else if( $target_yyyymmdd < $now_yyyymmdd || ( $target_yyyymmdd == $now_yyyymmdd && $Mclassjknwr_st_time[$j] < (($now_hh * 100) + $now_ii)) ){
							//過去時間帯
							print('background="../img_' . $lang_cd . '/bg_lightgrey_110x20.png"');
						//}else if( in_array($Mclassjknwr_jkn_kbn[$j] , $jkn_kbn_array_1) ){
						}else if( $notmember_yyk_cnt[$j] < $notmember_max_entry ){
							//非メンバーの予約可能数を下回っている場合
							//メンバー および 一般 の時間区分
							print('background="../img_' . $lang_cd . '/bg_mizu_110x20.png"');
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
							if( $tmp_uktk_ninzu == "" ){
								//未登録
								print('<img src="./img_' . $lang_cd . '/mitrk.png" border="0">');							
							}else{
							print('<font color="' . $fontcolor . '">' . $tmp_yyk_cnt . '</font>&nbsp;/&nbsp;' . $tmp_uktk_ninzu );
							}
						}
					
						print('</td>');
					
						$j++;
					}			
					print('</tr>');
				}
				
				print('</table>');
	
				print('<hr>');
	
				//翌日にする
				$target_yyyymmdd = date("Ymd", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), (sprintf("%d",substr($target_yyyymmdd,6,2)) + 1) , sprintf("%d",substr($target_yyyymmdd,0,4))) );
				$target_youbi_cd = date("w", mktime(0, 0, 0, sprintf("%d",substr($target_yyyymmdd,4,2)), sprintf("%d",substr($target_yyyymmdd,6,2)), sprintf("%d",substr($target_yyyymmdd,0,4))));
				$t++;
			}

			print('<table border="0">');
			print('<tr>');
			//前週表示ボタン
			print('<form method="post" action="' . $sv_https_adr . 'staff/kbtcounseling_trk_selectjknkbn.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $bfweek_date . '">');
			//日時変更引数
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="135">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_zensyu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_zensyu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_zensyu_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('<td width="680" align="center" valign="middle">&nbsp;</td>');
			//翌週表示ボタン
			print('<form method="post" action="' . $sv_https_adr . 'staff/kbtcounseling_trk_selectjknkbn.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			print('<input type="hidden" name="select_ymd" value="' . $afweek_date . '">');
			//日時変更引数
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td width="135">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_yokusyu_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_yokusyu_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_yokusyu_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
			
			print('<hr>');

			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">&nbsp;</td>');
			print('<form method="post" action="kbtcounseling_trk_selectdate.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_yyyy" value="' . substr($select_ymd,0,4) . '">');
			print('<input type="hidden" name="select_mm" value="' . sprintf("%d",substr($select_ymd,4,2)) . '">');
			print('<input type="hidden" name="select_staff_cd" value="' . $select_staff_cd . '">');
			//日時変更引数
			print('<input type="hidden" name="select_yyk_no" value="' . $select_yyk_no . '">');
			print('<td align="right">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" onClick="kurukuru()" border="0">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
	
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