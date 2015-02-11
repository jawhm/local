<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理情報（更新）</title>
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
	$gmn_id = 'axd_info_trk.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('axd_info.php','axd_info_res.php');

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
	if( !in_array($prc_gmn , $ok_gmn) ){
		$err_flg = 2;
	}

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
		$Minfo_office_cd = '';			//代表店舗コード
		$Minfo_kado_flg = '';			//システム稼動フラグ
		$Minfo_update_time = '';		//更新日時
		$Minfo_update_staff_cd = '';	//更新スタッフコード
		$Minfo_update_cmt = '';			//更新コメント
		$Minfo_office_nm = '';			//代表店舗名

		//管理情報の取得
		$query = 'select IDX,MEISHOU,RYAKUSHOU,DECODE(HP_ADR,"' . $ANGpw . '"),DECODE(SEND_MAIL_ADR,"' . $ANGpw . '"),DECODE(TENSOU_MAIL_ADR,"' . $ANGpw . '"),DAIHYO_OFFICE_CD,SYSTEM_KADO_FLG,UPDATE_TIME,UPDATE_STAFF_CD,DECODE(UPDATE_CMT,"' . $ANGpw . '") from M_KANRI_INFO where KG_CD = "' . $DEF_kg_cd . '" order by IDX desc LIMIT 1;';
		$result = mysql_query($query);
		if (!$result) {
			print('<font color="red">※管理情報の取得エラー１</font>');

		}else{
			while( $row = mysql_fetch_array($result) ){
				$Minfo_idx = $row[0];				//通番
				$Minfo_meishou = $row[1];			//名称
				$Minfo_ryakushou = $row[2];			//略称
				$Minfo_hp_adr = $row[3];			//ホームページアドレス
				$Minfo_send_mail_adr = $row[4];		//送信メールアドレス
				$Minfo_tensou_mail_adr = $row[5];	//転送先メールアドレス
				$Minfo_office_cd = $row[6];			//代表店舗コード
				$Minfo_kado_flg = $row[7];			//システム稼動フラグ
				$Minfo_update_time = $row[8];		//更新日時
				$Minfo_update_staff_cd = $row[9];	//更新スタッフコード
				$Minfo_update_cmt = $row[10];		//更新コメント
			}
			
			if( $Minfo_office_cd != '' ){
				//代表店舗名の取得
				$query = 'select OFFICE_NM from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $Minfo_office_cd . '";';
				$result = mysql_query($query);
				if (!$result) {
					print('<font color="red">※オフィス名の取得エラー</font>');

				}else{
					$row = mysql_fetch_array($result);
					$Minfo_office_nm = $row[0];		//代表店舗名
				}
			}

			//店舗情報の取得
			$Moffice_cnt = 0;
			$query = 'select OFFICE_CD,OFFICE_NM,ST_DATE,ED_DATE from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and YUKOU_FLG = 1 order by OFFICE_CD;';
			$result = mysql_query($query);
			if (!$result) {
				print('<font color="red">※店舗情報の取得エラー２</font>');

			}else{
				while( $row = mysql_fetch_array($result) ){
					$Moffice_office_cd[$Moffice_cnt] = $row[0];	//店舗コード
					$Moffice_office_nm[$Moffice_cnt] = $row[1];	//店舗名
					$Moffice_st_date[$Moffice_cnt] = $row[2];	//開始日
					$Moffice_ed_date[$Moffice_cnt] = $row[3];	//終了日
					$Moffice_cnt++;
				}
			}

			
			print('<form method="post" action="axd_info_res.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="idx" value="' . $Minfo_idx . '">');

			//名称・略称
			print('<table border="0">');
			print('<tr>');
			print('<td width="500"><b>名称</b></td>');
			print('<td width="250"><b>略称</b></td>');
			print('</tr>');
			print('<tr>');
			print('<td>');
			print('<input type="text" name="meishou" maxlength="60" size="40" class="normal" tabindex="1" value="' . $Minfo_meishou . '"  style="ime-mode:active; font-size:20px;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			print('</td>');
			print('<td>');
			print('<input type="text" name="ryakushou" maxlength="20" size="20" class="normal" tabindex="2" value="' . $Minfo_ryakushou . '"  style="ime-mode:active; font-size:20px;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
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
			print('<input type="text" name="hp_adr" maxlength="100" size="40" class="normal" tabindex="3" value="' . $Minfo_hp_adr . '" style="ime-mode:disabled; font-size:20px;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
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
			print('<input type="text" name="send_mail_adr" maxlength="100" size="60" class="normal" tabindex="4" value="' . $Minfo_send_mail_adr . '" style="ime-mode:disabled; font-size:20px;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
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
			print('<input type="text" name="tensou_mail_adr" maxlength="100" size="60" class="normal" tabindex="5" value="' . $Minfo_tensou_mail_adr . '" style="ime-mode:disabled; font-size:20px;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			print('</td>');
			print('</tr>');
			print('</table>');

			//代表店舗コード
			print('<table border="0">');
			print('<tr>');
			print('<td width="750"><b>代表店舗コード</b>（青時は有効期間内、赤時は過去期間、灰色は未来期間）</td>');
			print('</tr>');
			print('<tr>');
			print('<td>');
			if( $Moffice_cnt > 0 ){
				print('<select name="tenpo_cd" style="font-size:20px;" tabindex="6" class="normal">');
				print('<option value="">&nbsp;</option>');
				$i = 0;
				while( $i < $Moffice_cnt ){
					print('<option value="' . $Moffice_office_cd[$i] . '" class="');
					if( str_replace('-','',$Moffice_ed_date[$i]) < $DFyyyymmdd ){
						print('color2');
					}else if( str_replace('-','',$Moffice_st_date[$i]) <= $DFyyyymmdd && $DFyyyymmdd <= str_replace('-','',$Moffice_ed_date[$i]) ){
						print('color1');
					}else{
						print('color0');
					}
					print('"');					
					if( $Moffice_office_cd[$i] == $Minfo_office_cd ){
						print(' selected');	
					}
					print('>' . $Moffice_office_cd[$i] . '：' . $Moffice_office_nm[$i] . '（' . $Moffice_st_date[$i] . '～' . $Moffice_ed_date[$i] . '）</option>');
					$i++;
				}
				print('</select>');
			
			}else{
				print('<font color="red">※店舗が未登録（店舗側に登録依頼してください。）</font>');
			}
			print('</td>');
			print('</tr>');
			print('</table>');
		
			//システム利用開始日・システム利用可能期限
			print('<table border="0">');
			print('<tr>');
			print('<td width="250"><b>システム稼動フラグ</b></td>');
			print('</tr>');
			print('<tr>');
			print('<td>');
			print('<select name="kado_flg" class="normal" style="font-size:20pt;">');
			if( $Minfo_kado_flg == 0 ){
				print('<option value="0" selected>稼動のまま</option>');
				print('<option value="1">強制停止へ変更</option>');
			}else{
				print('<option value="0">稼動へ変更</option>');
				print('<option value="1" selected>強制停止のまま</option>');
			}
			print('</select>');
			print('</td>');
			print('</tr>');
			print('</table>');	


			print('<table border="0">');
			print('<tr>');
			print('<td width="550" align="left">');
		
			//更新日時・更新者・コメント
			print('<br>担当：<input type="text" name="update_staff_cd" maxlength="20" size="20" class="normal" tabindex="15" value="' . $Minfo_update_staff_cd . '" style="ime-mode:active; font-size:20px;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			
		print('<textarea name="update_cmt" rows="6" cols="65" class="normal" tabindex="16" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">' . $Minfo_update_cmt . '</textarea>');
			print('</td>');
			print('<td width="100" align="right" valign="top">');
			print('<input type="submit" name="button" value="更新" tabindex="17" style="width:100px;height:50px;">');
			print('</td>');
			print('</form>');
			print('<form method="post" action="axd_info.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<td width="100" align="right" valign="top">');
			print('<input type="submit" name="button" value="戻る" tabindex="18" style="width:100px;height:50px;">');
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