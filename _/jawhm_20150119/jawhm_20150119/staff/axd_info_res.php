<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>管理情報（更新結果）</title>
<style type="text/css">
input.err,select.err,textarea.err {
	background-color: #FF0000;
}
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
	$gmn_id = 'axd_info_res.php';
	//遷移ＯＫとする遷移元の画面ＩＤ
	$ok_gmn = array('axd_info_trk.php','axd_info_res.php');

	$err_flg = 0;	//0:エラーなし　1:サーバー接続エラー　2:画面遷移エラー　3:引数エラー　4以降は画面毎に設定

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
		$idx = $_POST['idx'];				//通番
		$meishou = $_POST['meishou'];		//名称
		$ryakushou = $_POST['ryakushou'];	//略称
		$hp_adr = $_POST['hp_adr'];		//ホームページアドレス
		$send_mail_adr = $_POST['send_mail_adr'];		//送信メールアドレス
		$tensou_mail_adr = $_POST['tensou_mail_adr'];	//転送先メールアドレス
		$tenpo_cd = $_POST['tenpo_cd'];	//代表店舗コード
		$kado_flg = $_POST['kado_flg'];	//システム稼動フラグ
		$update_staff_cd = $_POST['update_staff_cd'];	//更新スタッフコード（全角ＯＫ）
		$update_cmt = $_POST['update_cmt'];				//更新コメント

		$err_cnt = 0;	//エラー件数

		//引数チェック
		//名称
		$err_meishou = 0;
		$strcng_bf = $meishou;
		require( '../zz_strcng.php' );	// 半角の ' " $ を全角に変換する
		$meishou = $strcng_af;

		//略称
		$err_ryakushou = 0;
		$strcng_bf = $ryakushou;
		require( '../zz_strcng.php' );	// 半角の ' " $ を全角に変換する
		$ryakushou = $strcng_af;

		//ホームページアドレス
		$err_hp_adr = 0;
		if( strpos($hp_adr,"'") > 0 ){
			$hp_adr = '';
			$err_hp_adr = 1;
			$err_cnt++;
		}
		if( strpos($hp_adr,'"') > 0 ){
			$hp_adr = '';
			$err_hp_adr = 1;
			$err_cnt++;
		}
		if( strpos($hp_adr,'$') > 0 ){
			$hp_adr = '';
			$err_hp_adr = 1;
			$err_cnt++;
		}

		//送信メールアドレス
		$err_send_mail_adr = 0;
		if( strpos($send_mail_adr,"'") > 0 ){
			$send_mail_adr = '';
			$err_send_mail_adr = 1;
			$err_cnt++;
		}
		if( strpos($send_mail_adr,'"') > 0 ){
			$send_mail_adr = '';
			$err_send_mail_adr = 1;
			$err_cnt++;
		}
		if( strpos($send_mail_adr,'$') > 0 ){
			$send_mail_adr = '';
			$err_send_mail_adr = 1;
			$err_cnt++;
		}

		//転送先メールアドレス
		$err_tensou_mail_adr = 0;
		if( strpos($tensou_mail_adr,"'") > 0 ){
			$tensou_mail_adr = '';
			$err_tensou_mail_adr = 1;
			$err_cnt++;
		}
		if( strpos($tensou_mail_adr,'"') > 0 ){
			$tensou_mail_adr = '';
			$err_tensou_mail_adr = 1;
			$err_cnt++;
		}
		if( strpos($tensou_mail_adr,'$') > 0 ){
			$tensou_mail_adr = '';
			$err_tensou_mail_adr = 1;
			$err_cnt++;
		}

		//代表店舗コード
		$err_tenpo_cd = 0;
		if( $tenpo_cd == '' ){
			$err_tenpo_cd = 1;
			$err_cnt++;
		}

		
		//オフィス情報の取得
		$tenpo_nm = '';
		$Mtenpo_cnt = 0;
		$query = 'select OFFICE_CD,OFFICE_NM,ST_DATE,ED_DATE from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and YUKOU_FLG = 1 order by OFFICE_CD;';
		$result = mysql_query($query);
		if (!$result) {
			print('<font color="red">※オフィスの取得エラー</font>');
		
		}else{
			while( $row = mysql_fetch_array($result) ){
				$Mtenpo_tenpo_cd[$Mtenpo_cnt] = $row[0];	//店舗コード
				$Mtenpo_tenpo_nm[$Mtenpo_cnt] = $row[1];	//店舗名
				$Mtenpo_st_date[$Mtenpo_cnt] = $row[2];		//開始日
				$Mtenpo_ed_date[$Mtenpo_cnt] = $row[3];		//終了日
				$Mtenpo_cnt++;
				if( $tenpo_cd == $row[0] ){
					$tenpo_nm = $row[1];
				}
			}
		}

		//訂正前の情報を取得する
		if( $idx > 0 ){
			//管理情報の取得
			$Minfo_cnt = 0;
			$query = 'select IDX,MEISHOU,RYAKUSHOU,DECODE(HP_ADR,"' . $ANGpw . '"),DECODE(SEND_MAIL_ADR,"' . $ANGpw . '"),DECODE(TENSOU_MAIL_ADR,"' . $ANGpw . '"),DAIHYO_OFFICE_CD,SYSTEM_KADO_FLG,UPDATE_TIME,UPDATE_STAFF_CD,DECODE(UPDATE_CMT,"' . $ANGpw . '") from M_KANRI_INFO where KG_CD = "' . $DEF_kg_cd . '" order by IDX desc LIMIT 1;';
			$result = mysql_query($query);
			if (!$result) {
				print('<font color="red">※管理情報の取得エラー</font>');

			}else{
				while( $row = mysql_fetch_array($result) ){
					$Minfo_idx = $row[0];				//通番
					$Minfo_meishou = $row[1];			//名称
					$Minfo_ryakushou = $row[2];			//略称
					$Minfo_hp_adr = $row[3];			//ホームページアドレス
					$Minfo_send_mail_adr = $row[4];		//送信メールアドレス
					$Minfo_tensou_mail_adr = $row[5];	//転送先メールアドレス
					$Minfo_tenpo_cd = $row[6];			//代表店舗コード
					$Minfo_kado_flg = $row[7];			//システム稼動フラグ
					$Minfo_update_time = $row[8];		//更新日時
					$Minfo_update_staff_cd = $row[9];	//更新スタッフコード
					$Minfo_update_cmt = $row[10];		//更新コメント
					$Minfo_cnt++;
				}
			
				if( $Minfo_tenpo_cd != '' ){
					//訂正前店舗名の取得
					$query = 'select OFFICE_NM from M_OFFICE where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $Minfo_tenpo_cd . '";';
					$result = mysql_query($query);
					if (!$result) {
						print('<font color="red">※店舗情報の取得エラー</font>');
	
					}else{
						$row = mysql_fetch_array($result);
						$Minfo_tenpo_nm = $row[0];		//代表店舗名
					}
				}
			}
		}
		
		
		//*******************************************************
		if( $err_cnt == 0 ){
			//エラーなし
			if( $Minfo_cnt == 0 ){
				$Minfo_idx = 1;
			}else{
				$Minfo_idx++;
			}

			$update_time = date("YmdHis");

			//文字コード設定（insert/update時に必須）
			require( '../zz_mojicd.php' );
				
			$query = 'insert into M_KANRI_INFO values("' . $DEF_kg_cd . '",' . $Minfo_idx . ',';
			if( $meishou != '' ){
				$query .= '"' . $meishou . '",';
			}else{
				$query .= 'NULL,';
			}
			if( $ryakushou != '' ){
				$query .= '"' . $ryakushou . '",';
			}else{
				$query .= 'NULL,';
			}
			if( $hp_adr != '' ){
				$query .= 'ENCODE("' . $hp_adr . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $send_mail_adr != '' ){
				$query .= 'ENCODE("' . $send_mail_adr . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $tensou_mail_adr != '' ){
				$query .= 'ENCODE("' . $tensou_mail_adr . '","' . $ANGpw . '"),';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
			}
			if( $tenpo_cd != '' ){
				$query .= '"' . $tenpo_cd . '",';
			}else{
				$query .= 'NULL,';
			}
			$query .= $kado_flg . ',';
			$query .= '"' . $update_time . '",';
			if( $update_staff_cd != '' ){
				$query .= '"' . $update_staff_cd . '",';
			}else{
				$query .= 'NULL,';
			}
			if( $update_cmt != '' ){
				$query .= 'ENCODE("' . $update_cmt . '","' . $ANGpw . '"));';
			}else{
				$query .= 'ENCODE(NULL,"' . $ANGpw . '"));';
			}
			$result = mysql_query($query);
			if (!$result) {
				print('<font color="red">※管理情報の登録(insert)に失敗しました。</font>');
			
			}else{
				
				print('<font size="5" color="blue">※管理情報を更新しました。</font><br><br>');

				//名称・略称
				print('<table border="0">');
				print('<tr>');
				print('<td width="500"><b>名称</b></td>');
				print('<td width="250"><b>略称</b></td>');
				print('</tr>');
				print('<tr>');
				print('<td>');
				if( $meishou == '' ){
					print('<font color="red">※未登録</font>');
				}else{
					print('<font size="5" color="blue">' . $meishou . '</font>');
				}
				print('</td>');
				print('<td>');
				if( $ryakushou == '' ){
					print('<font color="red">※未登録</font>');
				}else{
					print('<font size="5" color="blue">' . $ryakushou . '</font>');
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
				if( $hp_adr == '' ){
					print('<font color="red">※未登録</font>');
				}else{
					print('<font size="5" color="blue">' . $hp_adr . '</font>');
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
				if( $send_mail_adr == '' ){
					print('<font color="red">※未登録</font>');
				}else{
					print('<font size="5" color="blue">' . $send_mail_adr . '</font>');
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
				if( $tensou_mail_adr == '' ){
					print('<font color="red">※未登録</font>');
				}else{
					print('<font size="5" color="blue">' . $tensou_mail_adr . '</font>');
				}
				print('</td>');
				print('</tr>');
				print('</table>');

				//代表店舗コード
				print('<table border="0">');
				print('<tr>');
				print('<td width="750"><b>代表店舗コード</b></td>');
				print('</tr>');
				print('<tr>');
				print('<td>');
				if( $tenpo_cd == '' ){
					print('<font color="red">※未登録</font>');
				}else{
					print('<font size="5" color="blue">' . $tenpo_cd . '　' . $tenpo_nm . '</font>');
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
				if( $kado_flg == 0 ){
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
				print('<br>（通番：&nbsp;' . $Minfo_idx . '　最終更新日時：&nbsp;' . $update_time . '　担当：&nbsp;' . $update_staff_cd . '）');
				print('<pre>' . $update_cmt . '</pre>');
				print('</td>');
				print('<form method="post" action="axd_info.php">');
				print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
				print('<td width="100" align="right" valign="top">');
				print('<input type="submit" name="button" value="戻る" tabindex="16" style="width:100px;height:50px;">');
				print('</td>');
				print('</form>');
				print('</tr>');
				print('</table>');
			
				print('<hr>');
		
			}
		
		}else{
			//エラーあり
		
			print('<font size="5" color="red">※エラーがあります。</font><br><br>');
			
			print('<form method="post" action="axd_info_res.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<input type="hidden" name="idx" value="' . $idx . '">');

			//名称・略称
			print('<table border="0">');
			print('<tr>');
			print('<td width="500"><b>名称</b></td>');
			print('<td width="250"><b>略称</b></td>');
			print('</tr>');
			print('<tr>');
			print('<td>');
			print('<input type="text" name="meishou" maxlength="60" size="40" class="');
			if( $err_meishou == 0 ){
				print('normal');
			}else{
				print('err');
			}
			print('" tabindex="1" value="' . $meishou . '"  style="ime-mode:active; font-size:20px;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			if( $idx > 0 ){
				print('<br><font size="2" color="');
				if( $meishou == $Minfo_meishou ){
					print('#aaaaaa');
				}else{
					print('red');
				}
				print('">訂正前：' . $Minfo_meishou . '</font>');
			}
			print('</td>');
			print('<td>');
			print('<input type="text" name="ryakushou" maxlength="20" size="20" class="');
			if( $err_ryakushou == 0 ){
				print('normal');
			}else{
				print('err');
			}
			print('" tabindex="2" value="' . $ryakushou . '"  style="ime-mode:active; font-size:20px;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			if( $idx > 0 ){
				print('<br><font size="2" color="');
				if( $ryakushou == $Minfo_ryakushou ){
					print('#aaaaaa');
				}else{
					print('red');
				}
				print('">訂正前：' . $Minfo_ryakushou . '</font>');
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
			print('<input type="text" name="hp_adr" maxlength="100" size="40" class="');
			if( $err_hp_adr == 0 ){
				print('normal');
			}else{
				print('err');
			}
			print('" tabindex="3" value="' . $hp_adr . '" style="ime-mode:disabled; font-size:20px;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			if( $idx > 0 ){
				print('<br><font size="2" color="');
				if( $hp_adr == $Minfo_hp_adr ){
					print('#aaaaaa');
				}else{
					print('red');
				}
				print('">訂正前：' . $Minfo_hp_adr . '</font>');
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
			print('<input type="text" name="send_mail_adr" maxlength="100" size="60" class="');
			if( $err_send_mail_adr == 0 ){
				print('normal');
			}else{
				print('err');
			}
			print('" tabindex="4" value="' . $send_mail_adr . '" style="ime-mode:disabled; font-size:20px;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			if( $idx > 0 ){
				print('<br><font size="2" color="');
				if( $send_mail_adr == $Minfo_send_mail_adr ){
					print('#aaaaaa');
				}else{
					print('red');
				}
				print('">訂正前：' . $Minfo_send_mail_adr . '</font>');
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
			print('<input type="text" name="tensou_mail_adr" maxlength="100" size="60" class="');
			if( $err_tensou_mail_adr == 0 ){
				print('normal');
			}else{
				print('err');
			}
			print('" tabindex="5" value="' . $tensou_mail_adr . '" style="ime-mode:disabled; font-size:20px;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			if( $idx > 0 ){
				print('<br><font size="2" color="');
				if( $tensou_mail_adr == $Minfo_tensou_mail_adr ){
					print('#aaaaaa');
				}else{
					print('red');
				}
				print('">訂正前：' . $Minfo_tensou_mail_adr . '</font>');
			}
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
			if( $Mtenpo_cnt > 0 ){
				print('<select name="tenpo_cd" style="font-size:20px;" tabindex="6" class="normal">');
				print('<option value="">&nbsp;</option>');
				$i = 0;
				while( $i < $Mtenpo_cnt ){
					print('<option value="' . $Mtenpo_tenpo_cd[$i] . '" class="');
					if( str_replace('-','',$Mtenpo_ed_date[$i]) < $DFyyyymmdd ){
						print('color2');
					}else if( str_replace('-','',$Mtenpo_st_date[$i]) <= $DFyyyymmdd && $DFyyyymmdd <= str_replace('-','',$Mtenpo_ed_date[$i]) ){
						print('color1');
					}else{
						print('color0');
					}
					print('"');					
					if( $Mtenpo_tenpo_cd[$i] == $tenpo_cd ){
						print(' selected');	
					}
					print('>' . $Mtenpo_tenpo_cd[$i] . '：' . $Mtenpo_tenpo_nm[$i] . '（' . $Mtenpo_st_date[$i] . '～' . $Mtenpo_ed_date[$i] . '）</option>');
					$i++;
				}
				print('</select>');
				if( $err_tenpo_cd > 0 ){
					print('<br><font size="2" color="red">※店舗を選択してください。</font>');
				}
				if( $idx > 0 ){
					print('<br><font size="2" color="');
					if( $tenpo_cd == $Minfo_tenpo_cd ){
						print('#aaaaaa');
					}else{
						print('red');
					}
					print('">訂正前：' . $Minfo_tenpo_cd . '：' . $Minfo_tenpo_nm . '</font>');
				}
			
			}else{
				print('<font color="red">※店舗が未登録（店舗側に登録依頼してください。）</font>');
			}
			print('</td>');
			print('</tr>');
			print('</table>');
		
		
			print('<table border="0">');
			print('<tr>');
			print('<td width="550" align="left">');
			
			
			
			//更新日時・更新者・コメント
			print('<br>担当：<input type="text" name="update_staff_cd" maxlength="20" size="20" class="normal" tabindex="13" value="' . $update_staff_cd . '" style="ime-mode:active; font-size:20px;" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">');
			
			print('<textarea name="update_cmt" rows="6" cols="65" class="normal" tabindex="14" onfocus="this.style.backgroundColor=\'#cccccc\'" onblur="this.style.backgroundColor=\'#E0FFFF\'">' . $update_cmt . '</textarea>');
			print('</td>');
			print('<td width="100" align="right" valign="top">');
			print('<input type="submit" name="button" value="更新" tabindex="15" style="width:100px;height:50px;">');
			print('</td>');
			print('</form>');
			print('<form method="post" action="axd_info.php">');
			print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
			print('<td width="100" align="right" valign="top">');
			print('<input type="submit" name="button" value="戻る" tabindex="16" style="width:100px;height:50px;">');
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