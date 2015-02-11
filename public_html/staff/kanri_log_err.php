<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>ログ詳細</title>
<style type="text/css">
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
}
</style><script type="text/javascript">
<!--
function winclose(){
	//「閉じようとしています」を表示させないため（２行追加）
　　var w=window.open("","_top");
　　w.opener=window;

	window.close(); // サブウィンドウを閉じる
}
// -->
</script>
</head>
<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'kanri_log_top.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('kanri_top.php','kanri_log_top.php');

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
	mb_internal_encoding("utf-8");

	//***コーディングはここから**********************************************************************************

	//引数の入力
	$prc_gmn = $_POST['prc_gmn'];
	$lang_cd = $_POST['lang_cd'];
	$office_cd = $_POST['office_cd'];
	$staff_cd = $_POST['staff_cd'];
	
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
			if ( $lang_cd == "" || $office_cd == "" || $staff_cd == "" ){
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

		//固有引数の取得
		$log_time = $_POST['log_time'];		//ログ時間

		$log_y = substr($log_time, 0, 4);	//年
		$log_m = substr($log_time, 4, 2);	//月
		$log_d = substr($log_time, 6, 2);	//日
		$log_t = substr($log_time, 8, 2);	//時間
		$log_min = substr($log_time, 10, 2);	//分
		$log_sec = substr($log_time, 12, 2);	//秒
		$log_sec_m = substr($log_time, 14, 4);	//秒以下
		$log_time_edit = $log_y . '-' . $log_m . '-' . $log_d . '&nbsp;' . $log_t . ':' . $log_min . ':' . $log_sec;


		//ログ情報の取得
		$query = 'select LOG_SBT,KKSTAFF_KBN,OFFICE_CD,KAIIN_NO,GMN_ID,DECODE(NAIYOU,"' . $ANGpw . '"),DECODE(ERR_INF,"' . $ANGpw . '") ' .
				 'from D_LOG where KG_CD = "' . $DEF_kg_cd . '" and LOG_TIME = "' . $log_time . '";';
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
			$log_naiyou = 'ログの参照に失敗しました。';	//内容
			$log_err_inf = $query;			//エラー情報
			require( './zs_log.php' );
			//************
				
		}else{
			while( $row = mysql_fetch_array($result) ){
				$Dlog_log_sbt = $row[0];		//ログ種別　N:通常ログ W:警告  E:エラー　T:トランザクション
				$Dlog_kkstaff_kbn = $row[1];	//顧客スタッフ区分　K：顧客サイト 、 S：スタッフサイト
				$Dlog_office_cd = $row[2];		//オフィスコード
				$Dlog_kaiin_no = $row[3];		//会員番号
				$Dlog_gmn_id = $row[4];			//画面ＩＤ
				$Dlog_naiyou = $row[5];			//内容
				$Dlog_err_inf = $row[6];		//エラー情報
			}
		}


		//画面編集
		print('<center>');
		
		print('<table border="0">');
		print('<tr>');
		print('<td width="370" align="left">');
		print('<img src="./img_' . $lang_cd . '/logo.png" border="0">');
		print('</td>');
		print('<td width="257" align="left" valign="top">');
		print('&nbsp;');
		print('</td>');
		print('<td width="180" align="center" valign="top">');
		print('&nbsp;');
		print('</td>');
		print('<td width="135" align="center" valign="middle">');
		print('<input type="button" name="button" style="WIDTH: 100px; HEIGHT: 50px;" value="閉じる" onClick=winclose() />');
		print('</td>');
		print('</tr>');
		print('</table>');

		print('<hr>');
		
		print('<table bgcolor="pink"><tr><td width="950">');
		print('<img src="./img_' . $lang_cd . '/bar_kanri_log.png" border="0">');
		print('</td></tr></table>');
		
		print('<br>');

		//BGCOLOR
		if( $Dlog_log_sbt == 'N' ){
			$bgcolor = 'aliceblue';
		}else if( $Dlog_log_sbt == 'W' ){
			$bgcolor = 'moccasin';
		}else if( $Dlog_log_sbt == 'E' ){
			$bgcolor = 'pink';
		}else if( $Dlog_log_sbt == 'T' ){
			$bgcolor = 'lightgreen';
		}else{
			$bgcolor = 'white';
		}
		
		
		
		print('<table border="1">');
		print('<tr bgcolor="lightgrey">');
		print('<td width="180" align="center">ログ時間</td>');
		print('<td width="110" align="center">ログ種別</td>');
		print('<td width="110" align="center">会員店舗</td>');
		print('<td width="150" align="center">店舗コード</td>');
		print('<td width="135" align="center">会員番号</td>');
		print('<td width="235" align="center">画面ＩＤ</td>');
		print('</tr>');
		print('<tr bgcolor="' . $bgcolor . '">');
		print('<td align="center">' . $log_time_edit . '</td>');
		print('<td align="center">');
		if( $Dlog_log_sbt == 'N' ){
			print('<font color="blue">通常ログ</font>');
		}else if( $Dlog_log_sbt == 'W' ){
			print('<font color="red">警告</font>');
		}else if( $Dlog_log_sbt == 'E' ){
			print('<font color="red">エラー</font>');
		}else if( $Dlog_log_sbt == 'T' ){
			print('<font color="green">トラン</font>');
		}else{
			print('<font color="green">未定義</font>');
		}
		print('</td>');
		print('<td align="center">');
		if( $Dlog_kkstaff_kbn == 'K' ){
			print('会員入力');
		}else if( $Dlog_kkstaff_kbn == 'S' ){
			print('スタッフ入力');
		}else{
			print('未定義');
		}
		print('</td>');
		print('<td align="center">' . $Dlog_office_cd . '</td>');
		print('<td align="center">' . $Dlog_kaiin_no . '</td>');
		print('<td align="center">' . $Dlog_gmn_id . '</td>');
		print('</tr>');
		print('<tr bgcolor="lightgrey">');
		print('<td colspan="6" align="center">内容</td>');
		print('</tr>');
		print('<tr bgcolor="' . $bgcolor . '">');
		print('<td colspan="6" align="left">' . $Dlog_naiyou . '<br><br></td>');
		print('</tr>');
		print('<tr bgcolor="lightgrey">');
		print('<td colspan="6" align="center">エラー情報</td>');
		print('</tr>');
		print('<tr bgcolor="' . $bgcolor . '">');
		print('<td colspan="6" align="left">' . $Dlog_err_inf . '<br><br></td>');
		print('</tr>');
		print('</table>');




		print('</center>');
		
		print('<hr>');
	
	}

	mysql_close( $link );
?>
</body>
</html>
