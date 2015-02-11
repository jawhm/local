<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>店舗：管理画面－営業時間（更新）</title>
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
	$gmn_id = 'kanri_eigyojkn_ksn0.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_eigyojkn_select.php','kanri_eigyojkn_ksn1.php','kanri_eigyojkn_del1.php');

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
	
	$select_office_cd = $_POST['select_office_cd'];	//登録対象のオフィスコード
	$select_st_date = $_POST['select_st_date'];		//開始日
	$select_ed_date = $_POST['select_ed_date'];		//終了日
	
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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" || $select_office_cd == "" || $select_st_date == "" || $select_ed_date == "" ){
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
		print('<img src="./img_' . $lang_cd . '/btn_sakujyo_2.png" width="0" height="0" style="visibility:hidden;">');


		//ページ編集
		//初期値セット
		if( $prc_gmn == 'kanri_eigyojkn_select.php' || $prc_gmn == 'kanri_eigyojkn_del1.php' ){

			// 営業時間マスタの情報取得
			$query = 'select YOUBI_CD,TEIKYUBI_FLG,OFFICE_ST_TIME,OFFICE_ED_TIME,YUKOU_FLG,ST_DATE,ED_DATE,UPDATE_TIME,UPDATE_STAFF_CD from M_EIGYOJKN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and ST_DATE = "' . $select_st_date . '" order by YOUBI_CD;';
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
				$Meigyojkn_cnt = 0;
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
				
				if( $Meigyojkn_cnt == 9 ){
					//正常取得
					$teikyu_0 = $Meigyojkn_teikyubi_flg[0];		//定休日チェックボックス（日曜） 'on':チェックあり
					$tnp_st_time_0 = $Meigyojkn_st_time[0];		//開店時刻（日曜）
					$tnp_ed_time_0 = $Meigyojkn_ed_time[0];		//閉店時刻（日曜）
					$teikyu_1 = $Meigyojkn_teikyubi_flg[1];		//定休日チェックボックス（月曜） 'on':チェックあり
					$tnp_st_time_1 = $Meigyojkn_st_time[1];		//開店時刻（日曜）
					$tnp_ed_time_1 = $Meigyojkn_ed_time[1];		//閉店時刻（日曜）
					$teikyu_2 = $Meigyojkn_teikyubi_flg[2];		//定休日チェックボックス（火曜） 'on':チェックあり
					$tnp_st_time_2 = $Meigyojkn_st_time[2];		//開店時刻（日曜）
					$tnp_ed_time_2 = $Meigyojkn_ed_time[2];		//閉店時刻（日曜）
					$teikyu_3 = $Meigyojkn_teikyubi_flg[3];		//定休日チェックボックス（水曜） 'on':チェックあり
					$tnp_st_time_3 = $Meigyojkn_st_time[3];		//開店時刻（日曜）
					$tnp_ed_time_3 = $Meigyojkn_ed_time[3];		//閉店時刻（日曜）
					$teikyu_4 = $Meigyojkn_teikyubi_flg[4];		//定休日チェックボックス（木曜） 'on':チェックあり
					$tnp_st_time_4 = $Meigyojkn_st_time[4];		//開店時刻（日曜）
					$tnp_ed_time_4 = $Meigyojkn_ed_time[4];		//閉店時刻（日曜）
					$teikyu_5 = $Meigyojkn_teikyubi_flg[5];		//定休日チェックボックス（金曜） 'on':チェックあり
					$tnp_st_time_5 = $Meigyojkn_st_time[5];		//開店時刻（日曜）
					$tnp_ed_time_5 = $Meigyojkn_ed_time[5];		//閉店時刻（日曜）
					$teikyu_6 = $Meigyojkn_teikyubi_flg[6];		//定休日チェックボックス（土曜） 'on':チェックあり
					$tnp_st_time_6 = $Meigyojkn_st_time[6];		//開店時刻（日曜）
					$tnp_ed_time_6 = $Meigyojkn_ed_time[6];		//閉店時刻（日曜）
					$teikyu_7 = $Meigyojkn_teikyubi_flg[7];		//定休日チェックボックス（土日祝の前日） 'on':チェックあり
					$tnp_st_time_7 = $Meigyojkn_st_time[7];		//開店時刻（日曜）
					$tnp_ed_time_7 = $Meigyojkn_ed_time[7];		//閉店時刻（日曜）
					$teikyu_8 = $Meigyojkn_teikyubi_flg[8];		//定休日チェックボックス（祝日） 'on':チェックあり
					$tnp_st_time_8 = $Meigyojkn_st_time[8];		//開店時刻（日曜）
					$tnp_ed_time_8 = $Meigyojkn_ed_time[8];		//閉店時刻（日曜）
					$yukou_flg = $Meigyojkn_yukou_flg[0];		//有効フラグ
					$st_year = substr($Meigyojkn_st_date[0],0,4);					//開始年
					$st_month = sprintf("%d",substr($Meigyojkn_st_date[0],5,2));	//開始月
					$st_day = sprintf("%d",substr($Meigyojkn_st_date[0],8,2));		//開始日
					$ed_year = substr($Meigyojkn_ed_date[0],0,4);					//終了年
					$ed_month = sprintf("%d",substr($Meigyojkn_ed_date[0],5,2));	//終了月
					$ed_day = sprintf("%d",substr($Meigyojkn_ed_date[0],8,2));		//終了日
				
				}else{
					$err_flg = 4;
					//エラーメッセージ表示
					require( './zs_errgmn.php' );
					
					//**ログ出力**
					$log_sbt = 'E';					//ログ種別    （ N:通常ログ  W:警告  E:エラー T:トランザクション ）
					$log_kkstaff_kbn = 'S';			//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
					$log_office_cd = $office_cd;	//オフィスコード
					$log_kaiin_no = $staff_cd;		//会員番号 または スタッフコード
					$log_naiyou = '営業時間マスタからの配列作成に失敗しました。';	//内容
					$log_err_inf = $query;			//エラー情報
					require( './zs_log.php' );
					//************
					
				}
			}
		
		}else{
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
		}
		
		//適用期間に予約があるか確認。（予約ありの場合は開始時刻・終了時間は更新できない）
		$lock_flg = 0;	//ロックフラグ 0:ロックしない　1：開始時刻・終了時刻はロックする

		$query = 'select count(*) from D_CLASS_YYK where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD >= "' . $select_st_date . '" and YMD <= "' . $select_ed_date . '";';
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
				//予約データがあるの常連フラグ・開始時刻・終了時刻はロックする
				$lock_flg = 1;
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


		if( $err_flg == 0 ){
			
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
			
			print('<font color="blue">※更新後、登録ボタンを押下してください。（*印の項目は必須入力となります。)</font><br>');
			if( $lock_flg == 1 ){
				print('<font color="blue">（有効期間内に予約データが存在するため、営業時間の変更および削除はできません。）</font><br>');
			}

			print('<table border="0">');
			print('<tr>');
			print('<form name="form2" method="post" action="kanri_eigyojkn_ksn1.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
			print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
			print('<td align="left">');

			//開店時刻・閉店時刻
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
			print('<td width="70" align="center" bgcolor="powderblue"><font size="2">CLOSE</font></td>');
			print('<td width="110" align="center" bgcolor="powderblue">曜日</td>');
			print('<td width="55" align="center" bgcolor="powderblue"><font size="2">定休</font></td>');
			print('<td width="80" align="center" bgcolor="powderblue"><font size="2">OPEN</font></td>');
			print('<td width="20" align="center" bgcolor="powderblue">～</td>');
			print('<td width="80" align="center" bgcolor="powderblue"><font size="2">CLOSE</font></td>');
			print('</tr>');
			//月曜・土曜
			print('<tr>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">月曜</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><input type="checkbox" tabindex="' . ( $tabindex + 1 ) . '" name="teikyu_1" ');
			if( $teikyu_1 == 'on' || $teikyu_1 == 1 ){
				print('checked');
			}
			if( $lock_flg == 1 ){
				print(' disabled');
			}
			print('></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><input type="text" name="tnp_st_time_1" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 2 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_st_time_1 . '></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><input type="text" name="tnp_ed_time_1" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 3 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_ed_time_1 . '></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_110x20.png">土曜</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_55x20.png"><input type="checkbox" tabindex="' . ( $tabindex + 16 ) . '" name="teikyu_6" ');
			if( $teikyu_6 == 'on' || $teikyu_6 == 1 ){
				print('checked');
			}
			if( $lock_flg == 1 ){
				print(' disabled');
			}
			print('></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_80x20.png"><input type="text" name="tnp_st_time_6" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 17 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_st_time_6 . '></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_20x20.png">～</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_blue_80x20.png"><input type="text" name="tnp_ed_time_6" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 18 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_ed_time_6 . '></td>');
			print('</tr>');
			//火曜・日曜
			print('<tr>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">火曜</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><input type="checkbox" tabindex="' . ( $tabindex + 4 ) . '" name="teikyu_2" ');
			if( $teikyu_2 == 'on' || $teikyu_2 == 1 ){
				print('checked');
			}
			if( $lock_flg == 1 ){
				print(' disabled');
			}
			print('></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><input type="text" name="tnp_st_time_2" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 5 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_st_time_2 . '></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><input type="text" name="tnp_ed_time_2" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 6 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_ed_time_2 . '></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_110x20.png">日曜</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_55x20.png"><input type="checkbox" tabindex="' . ( $tabindex + 19 ) . '" name="teikyu_0" ');
			if( $teikyu_0 == 'on' ||  $teikyu_0 == 1 ){
				print('checked');
			}
			if( $lock_flg == 1 ){
				print(' disabled');
			}
			print('></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_80x20.png"><input type="text" name="tnp_st_time_0" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 20 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_st_time_0 . '></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_20x20.png">～</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_pink_80x20.png"><input type="text" name="tnp_ed_time_0" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 21 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_ed_time_0 . '></td>');
			print('</tr>');
			//水曜・土日祝の前日
			print('<tr>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">水曜</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><input type="checkbox" tabindex="' . ( $tabindex + 7 ) . '" name="teikyu_3" ');
			if( $teikyu_3 == 'on' || $teikyu_3 == 1 ){
				print('checked');
			}
			if( $lock_flg == 1 ){
				print(' disabled');
			}
			print('></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><input type="text" name="tnp_st_time_3" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 8 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_st_time_3 . '></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><input type="text" name="tnp_ed_time_3" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 9 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_ed_time_3 . '></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_110x20.png"><font size="2">土日祝の前日</font></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_55x20.png"><input type="checkbox" tabindex="' . ( $tabindex + 22 ) . '" name="teikyu_7" ');
			if( $teikyu_7 == 'on' || $teikyu_7 == 1 ){
				print('checked');
			}
			if( $lock_flg == 1 ){
				print(' disabled');
			}
			print('></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"><input type="text" name="tnp_st_time_7" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 23 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_st_time_7 . '></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_20x20.png">～</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_kimidori_80x20.png"><input type="text" name="tnp_ed_time_7" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 24 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_ed_time_7 . '></td>');
			print('</tr>');
			//木曜・祝日
			print('<tr>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">木曜</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><input type="checkbox" tabindex="' . ( $tabindex + 10 ) . '" name="teikyu_4" ');
			if( $teikyu_4 == 'on' || $teikyu_4 == 1 ){
				print('checked');
			}
			if( $lock_flg == 1 ){
				print(' disabled');
			}
			print('></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><input type="text" name="tnp_st_time_4" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 11 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_st_time_4 . '></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><input type="text" name="tnp_ed_time_4" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 12 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_ed_time_4 . '></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_110x20.png">祝日</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_55x20.png"><input type="checkbox" tabindex="' . ( $tabindex + 25 ) . '" name="teikyu_8" ');
			if( $teikyu_8 == 'on' || $teikyu_8 == 1 ){
				print('checked');
			}
			if( $lock_flg == 1 ){
				print(' disabled');
			}
			print('></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_80x20.png"><input type="text" name="tnp_st_time_8" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 26 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_st_time_8 . '></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_20x20.png">～</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mura_80x20.png"><input type="text" name="tnp_ed_time_8" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 27 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_ed_time_8 . '></td>');
			print('</tr>');
			//金曜
			print('<tr>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png">金曜</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_55x20.png"><input type="checkbox" tabindex="' . ( $tabindex + 13 ) . '" name="teikyu_5" ');
			if( $teikyu_5 == 'on' || $teikyu_5 == 1 ){
				print('checked');
			}
			if( $lock_flg == 1 ){
				print(' disabled');
			}
			print('></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><input type="text" name="tnp_st_time_5" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 14 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_st_time_5 . '></td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_20x20.png">～</td>');
			print('<td align="center" background="../img_' . $lang_cd . '/bg_mizu_80x20.png"><input type="text" name="tnp_ed_time_5" size="4" style="ime-mode:disabled; font-size:16px; text-align:center;" ');
			if( $lock_flg == 1 ){
				print(' readonly ');
			}
			print('tabindex="' . ( $tabindex + 15 ) . '" class="normal" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'" value=' . $tnp_ed_time_5 . '></td>');
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

			$tabindex += 27;	//タブインデックス調整(3x9)

			print('<br>');

			//有効期間
			print('<b>有効期間(*)</b>・・・上記営業時間の有効期間<br>');
			print('<table border="0">');
			print('<tr>');
			print('<td align="left">');
			print('開始日<br>');
			$tabindex++;
			print('<select name="st_year" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 2012;
			while( $i < 2038 ){
				print('<option value="' . $i . '" ');
				if( $i == $st_year ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
			print('</select>');
			print('年');
			$tabindex++;
			print('<select name="st_month" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 1;
			while( $i < 13 ){
				print('<option value="' . $i . '" ');
				if( $i == $st_month ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
			print('</select>');
			print('月');
			$tabindex++;
			print('<select name="st_day" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 1;
			while( $i < 32 ){
				print('<option value="' . $i . '" ');
				if( $i == $st_day ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
				print('</select>');
			print('日 から');
			print('</td>');
			print('<td align="left">');
			print('終了日<font size="2">&nbsp;(現在の最大日は2037/12/31)</font><br>');
			$tabindex++;
			print('<select name="ed_year" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 2012;
			while( $i < 2038 ){
				print('<option value="' . $i . '" ');
				if( $i == $ed_year ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
			print('</select>');
			print('年');
			$tabindex++;
			print('<select name="ed_month" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 1;
			while( $i < 13 ){
				print('<option value="' . $i . '" ');
				if( $i == $ed_month ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
			print('</select>');
			print('月');
			$tabindex++;
			print('<select name="ed_day" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '">');
			$i = 1;
			while( $i < 32 ){
				print('<option value="' . $i . '" ');
				if( $i == $ed_day ){
					print('selected');
				}
				print('>' . $i. '</option>');
			
				$i++;
			}
			print('</select>');
			print('日 まで');
			print('</td>');
			print('</tr>');
			print('</table>');

			//有効無効／登録ボタン／戻るボタン
			print('<table border="0">');
			print('<tr>');
			print('<td width="815" align="left">');
			print('<b>有効／無効(*)</b><br>');
			$tabindex++;
			print('<select name="yukou_flg" class="normal" style="font-size:20pt;" tabindex="' . $tabindex . '" >');
			if( $yukou_flg == 0 ){
				print('<option value="0" class="color2" selected>無効</option>');
				print('<option value="1" class="color1">有効</option>');
			}else{
				if(	$lock_flg == 1 ){
					print('<option value="1" class="color1" selected>有効</option>');
				}else{
					print('<option value="0" class="color2">無効</option>');
					print('<option value="1" class="color1" selected>有効</option>');
				}
			}
			
			print('</select>');
			print('<font size="2" color="red">&nbsp;無効&nbsp;</font><font size="2">にすると予約システム上には表示されません。</font>');
			print('</td>');
			print('<td align="right">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
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
			print('<tr>');
			print('<td width="815" align="left">&nbsp;</td>');
			print('<form method="post" action="kanri_eigyojkn_del1.php">');
			print('<td align="right">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
			print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
			print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
			print('<input type="hidden" name="select_office_cd" value="' . $select_office_cd . '">');
			print('<input type="hidden" name="select_st_date" value="' . $select_st_date . '">');
			print('<input type="hidden" name="select_ed_date" value="' . $select_ed_date . '">');
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sakujyo_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sakujyo_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sakujyo_1.png\';" onClick="kurukuru()" border="0">');
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
