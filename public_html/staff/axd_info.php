<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理情報</title>
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
</head>
<body bgcolor="white">
<?php
	//***共通情報************************************************************************************************
	//画面情報
	//当画面の画面ＩＤ
	$gmn_id = 'axd_info.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('axd_info.php','axd_info_trk.php','axd_info_res.php');

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
	//$tenpo_cd = $_POST['tenpo_cd'];
	//$staff_cd = $_POST['staff_cd'];

	//デフォルト年月を求める
	$DFyyyy = date( "Y", time() );
	$DFmm = date( "m", time() );
	$DFdd = date( "d", time() );	
	$DFyyyymmdd = date( "Ymd", time() );

	//サーバー接続
	require( './zs_svconnect.php' );

	//接続結果
	if( $svconnect_rtncd == 1 ){
		$err_flg = 1;
	}
		
	//画面ＩＤのチェック
	//if( !in_array($prc_gmn , $ok_gmn) ){
	//	$err_flg = 2;
	//}

	//サーバー接続エラー
	if( $err_flg == 1 ){
		print('<font color="red">※サーバー接続エラー</font>');
		
	//画面遷移エラー
	}else if( $err_flg == 2 ){
		print('<font color="red">※画面遷移エラー</font>');

	//エラーなし
	}else{
		
		//変数初期化
		$Minfo_idx = 0;					//通番
		$Minfo_meishou = '';			//名称
		$Minfo_ryakushou = '';			//略称
		$Minfo_hp_adr = '';				//ホームページアドレス
		$Minfo_send_mail_adr = '';		//送信メールアドレス
		$Minfo_tensou_mail_adr = '';	//転送先メールアドレス
		$Minfo_office_cd = '';			//代表オフィスコード
		$Minfo_kado_flg = '';			//システム稼動フラグ
		$Minfo_update_time = '';		//更新日時
		$Minfo_update_staff_cd = '';	//更新スタッフコード
		$Minfo_update_cmt = '';			//更新コメント
		$Minfo_office_nm = '';			//代表オフィス名

		//管理情報の取得
		$query = 'select IDX,MEISHOU,RYAKUSHOU,DECODE(HP_ADR,"' . $ANGpw . '"),DECODE(SEND_MAIL_ADR,"' . $ANGpw . '"),DECODE(TENSOU_MAIL_ADR,"' . $ANGpw . '"),DAIHYO_OFFICE_CD,SYSTEM_KADO_FLG,UPDATE_TIME,UPDATE_STAFF_CD,DECODE(UPDATE_CMT,"' . $ANGpw . '") from M_KANRI_INFO where KG_CD = "' . $DEF_kg_cd . '" order by IDX desc LIMIT 1;';
		$result = mysql_query($query);
		if (!$result) {
			print('<font color="red">※管理情報の取得エラー</font>');
			print('<br>' . $query );

		}else{
			while( $row = mysql_fetch_array($result) ){
				$Minfo_idx = $row[0];				//通番
				$Minfo_meishou = $row[1];			//名称
				$Minfo_ryakushou = $row[2];			//略称
				$Minfo_hp_adr = $row[3];			//ホームページアドレス
				$Minfo_send_mail_adr = $row[4];		//送信メールアドレス
				$Minfo_tensou_mail_adr = $row[5];	//転送先メールアドレス
				$Minfo_office_cd = $row[6];			//代表オフィスコード
				$Minfo_kado_flg = $row[7];			//システム稼動フラグ
				$Minfo_update_time = $row[8];		//更新日時
				$Minfo_update_staff_cd = $row[9];	//更新スタッフコード
				$Minfo_update_cmt = $row[10];		//更新コメント
			}
			
			if( $Minfo_office_cd != '' ){
				//代表オフィス名の取得
				$query = 'select OFFICE_NM from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $Minfo_office_cd . '";';
				$result = mysql_query($query);
				if (!$result) {
					print('<font color="red">※オフィス名の取得エラー</font>');

				}else{
					$row = mysql_fetch_array($result);
					$Minfo_office_nm = $row[0];		//代表オフィス名
				}
			}


			//名称・略称
			print('<table border="0">');
			print('<tr>');
			print('<td width="500"><b>名称</b></td>');
			print('<td width="250"><b>略称</b></td>');
			print('</tr>');
			print('<tr>');
			print('<td>');
			if( $Minfo_meishou == '' ){
				print('<font color="red">※未登録</font>');
			}else{
				print('<font size="5" color="blue">' . $Minfo_meishou . '</font>');
			}
			print('</td>');
			print('<td>');
			if( $Minfo_ryakushou == '' ){
				print('<font color="red">※未登録</font>');
			}else{
				print('<font size="5" color="blue">' . $Minfo_ryakushou . '</font>');
			}
			print('</td>');
			print('</tr>');
			print('</table>');
		
			//ホームページアドレス
			print('<table border="0">');
			print('<tr>');
			print('<td width="750"><b>ホームページアドレス</b></td>');
			print('</tr>');
			print('<tr>');
			print('<td>');
			if( $Minfo_hp_adr == '' ){
				print('<font color="red">※未登録</font>');
			}else{
				print('<font size="5" color="blue">' . $Minfo_hp_adr . '</font>');
			}
			print('</td>');
			print('</tr>');
			print('</table>');

			//送信メールアドレス
			print('<table border="0">');
			print('<tr>');
			print('<td width="750"><b>送信メールアドレス</b>（システム側から顧客側へメールする場合のメールアドレス）</td>');
			print('</tr>');
			print('<tr>');
			print('<td>');
			if( $Minfo_send_mail_adr == '' ){
				print('<font color="red">※未登録</font>');
			}else{
				print('<font size="5" color="blue">' . $Minfo_send_mail_adr . '</font>');
			}
			print('</td>');
			print('</tr>');
			print('</table>');

			//転送先メールアドレス
			print('<table border="0">');
			print('<tr>');
			print('<td width="750"><b>転送先メールアドレス</b>（顧客側からの返信メールを転送する店舗側メールアドレス）</td>');
			print('</tr>');
			print('<tr>');
			print('<td>');
			if( $Minfo_tensou_mail_adr == '' ){
				print('<font color="red">※未登録</font>');
			}else{
				print('<font size="5" color="blue">' . $Minfo_tensou_mail_adr . '</font>');
			}
			print('</td>');
			print('</tr>');
			print('</table>');

			//代表オフィスコード
			print('<table border="0">');
			print('<tr>');
			print('<td width="750"><b>代表店舗コード</b></td>');
			print('</tr>');
			print('<tr>');
			print('<td>');
			if( $Minfo_office_cd == '' ){
				print('<font color="red">※未登録</font>');
			}else{
				print('<font size="5" color="blue">' . $Minfo_office_cd . '　' . $Minfo_office_nm . '</font>');
			}
			print('</td>');
			print('</tr>');
			print('</table>');
		
			//システム稼動フラグ
			print('<table border="0">');
			print('<tr>');
			print('<td width="250"><b>システム稼動フラグ</b></td>');
			print('</tr>');
			print('<tr>');
			print('<td>');
			if( $Minfo_kado_flg == 0 ){
				print('<font size="6" color="blue">稼動中</font>');
			}else{
				print('<font size="6" color="red">強制停止中</font>');
			}
			print('</td>');
			print('</tr>');
			print('</table>');	
			
			
			print('<table border="0">');
			print('<tr>');
			print('<td width="650" align="left">');
		
			//更新日時・更新者・コメント
			if( $Minfo_update_time != '' ){
				print('<br>（通番：&nbsp;' . $Minfo_idx .'　最終更新日時：&nbsp;' . $Minfo_update_time . '　担当：&nbsp;' . $Minfo_update_staff_cd . '）');
				print('<pre>' . $Minfo_update_cmt . '</pre>');
			}else{
				print('&nbsp;');
			}
			print('</td>');
			print('<form method="post" action="axd_info_trk.php">');
			print('<td width="100" align="right" valign="top">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="submit" name="button" value="更新" tabindex="10" style="width:100px;height:50px;">');
			print('</td>');
			print('</form>');
			print('</tr>');
			print('</table>');
			
			print('<hr>');
		}
	}

	mysql_close( $link );
?>
</body>
</html>