<?php
	//エラー画面編集

	$zs_errmsg_txt = '';
	
	//初期値設定
	if( $lang_cd == "" ){
		$lang_cd = "J";
	}
	if( $office_nm == "" ){
		$office_nm = "&nbsp;";
	}
	if( $staff_nm == "" ){
		$staff_nm = "&nbsp;";
	}
	
	
	if( $lang_cd == 'J' ){
		//日本語
		
		if( $err_flg == 1 ){
			$zs_errmsg_txt = '※エラーが発生しました。<br>（※サーバー管理者へ連絡してください。）';
		}else if( $err_flg == 2 ){
			$zs_errmsg_txt = '※お手数ですが、ログイン画面からやりなおししてください。';
		}else if( $err_flg == 3 && $gmn_id != 'menu.php' ){
			$zs_errmsg_txt = '※引数エラー<br>（※サーバー管理者へ連絡してください。）';
		}else if( $err_flg == 3 && $gmn_id == 'menu.php' ){
			$zs_errmsg_txt = '<img src="./img_' . $lang_cd . '/title_login_err1.png" border="0">';
		}else if( $err_flg == 4 ){
			$zs_errmsg_txt = '※エラーが発生しました。<br>（※サーバー管理者へ連絡してください。）';
		}else if( $err_flg == 9 ){
			$zs_errmsg_txt = '※一定時間を越えたため、再度ログインをお願いします。';
		}else if( $err_flg == 80 ){
			$zs_errmsg_txt = '※ただいまメンテナンス中です。';
		}
		
	}else if( $lang_cd == 'E' ){
		
		if( $err_flg == 1 ){
			$zs_errmsg_txt = 'An error has occurred.<br>(Please contact the server administrator.)';
		}else if( $err_flg == 2 ){
			$zs_errmsg_txt = 'Please try again from the login screen.';
		}else if( $err_flg == 3 && $gmn_id != 'menu.php' ){
			$zs_errmsg_txt = 'Argument error.<br>(Please contact the server administrator.)';
		}else if( $err_flg == 3 && $gmn_id == 'menu.php' ){
			$zs_errmsg_txt = '<img src="./img_' . $lang_cd . '/title_login_err1.png" border="0">';
		}else if( $err_flg == 4 ){
			$zs_errmsg_txt = 'An error has occurred.<br>(Please contact the server administrator.)';
		}else if( $err_flg == 9 ){
			$zs_errmsg_txt = 'For a certain period of time has been exceeded, please log in again.';
		}else if( $err_flg == 80 ){
			$zs_errmsg_txt = 'This site is under maintenance.';
		}		
		
	}
	
	//画像事前読み込み
	print('<img src="./img_' . $lang_cd . '/btn_login_2.png" width="0" height="0" style="visibility:hidden;">');
	
	print('<center>');
	
	if( $err_flg != 4 ){
			
		//メニュー画面
		print('<center>');
		print('<table border="0">');
		print('<tr>');
		//ロゴ
		print('<td width="370" align="center" valign="middle">');
		print('<img src="./img_' . $lang_cd . '/logo.png" border="0">');
		print('</td>');
		//オフィス名・スタッフ名
		print('<td width="265" align="left" valign="top">');
		print('<table width="265" border="0">');
		print('<tr><td align="left"><img src="./img_' . $lang_cd . '/bar_officenm.png" border="0"></td></tr>');
		print('<tr><td><font size="2" color="blue">' . $office_nm . '</font></td></tr>');
		print('<tr><td align="left"><img src="./img_' . $lang_cd . '/bar_loginstaff.png" border="0"></td></tr>');
		print('<tr><td><font size="2" color="blue">' . $staff_nm . '</font></td></tr>');
		print('</table>');		
		print('</td>');
		//本日日付
		print('<td width="180" align="left">');
		if( $mntchk_flg == 3 || $mntchk_flg == 4 ){
			//3:当日翌日にメンテあり, 4:１時間以内にメンテあり
			print('<img src="./img_' . $lang_cd . '/bar_mente.png" border="0"><br>');
			if( $mntchk_flg == 3 ){
				print('<font size="1">以下の期間は操作ができません。</font><br>');
			}else{
				print('<font size="1" color="red">まもなくメンテナンスとなります。<br>開始時刻までに終了してください。<br></font>');
			}
			//メンテ開始時刻と終了時刻が同一日である場合
			if( substr($mntchk_st_time,0,8) == substr($mntchk_ed_time,0,8) ){
				//同一日
				print('<font size="3">' . substr($mntchk_st_time,0,4) . '</font><font size="1">&nbsp;年&nbsp;</font><font size="3">' . sprintf("%d",substr($mntchk_st_time,4,2)) . '</font><font size="1">&nbsp;月&nbsp;</font><font size="3">' . sprintf("%d",substr($mntchk_st_time,6,2)) . '</font><font size="1">&nbsp;日(' . $week[$mntchk_st_youbi] . ')</font><font size="3"><br>' . sprintf("%d",substr($mntchk_st_time,8,2)) . ':' . sprintf("%02d",substr($mntchk_st_time,10,2)) . '&nbsp;～&nbsp;' . sprintf("%d",substr($mntchk_ed_time,8,2)) . ':' . sprintf("%02d",substr($mntchk_ed_time,10,2)) . '</font><font size="1">&nbsp;終了予定</font>' );
			}else{
				//異なる日にち
				print('<font size="1">');
				print( substr($mntchk_st_time,0,4) . '年' . sprintf("%d",substr($mntchk_st_time,4,2)) . '月' . sprintf("%d",substr($mntchk_st_time,6,2)) . '日(' . $week[$mntchk_st_youbi] . ')&nbsp;' . sprintf("%d",substr($mntchk_st_time,8,2)) . ':' . sprintf("%02d",substr($mntchk_st_time,10,2)) . '&nbsp;から<br>' . substr($mntchk_ed_time,0,4) . '年' . sprintf("%d",substr($mntchk_ed_time,4,2)) . '月' . sprintf("%d",substr($mntchk_ed_time,6,2)) . '日(' . $week[$mntchk_ed_youbi] . ')&nbsp;' . sprintf("%d",substr($mntchk_ed_time,8,2)) . ':' . sprintf("%02d",substr($mntchk_ed_time,10,2)) . '&nbsp;まで' );
				print('</font>');	
			}
		}else{
			print('<img src="./img_' . $lang_cd . '/yyyy_' . $now_yyyy . '_black.png" border="0"><br><img src="./img_' . $lang_cd . '/mm_' . sprintf("%d",$now_mm) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/dd_' . sprintf("%d",$now_dd) . '_' . $zs_youbi_color . '.png" border="0"><img src="./img_' . $lang_cd . '/youbi_' . $now_youbi . '_' . $zs_youbi_color .'.png" border="0"></font>');
		}
		print('</td>');
		//ログアウト
		print('<form method="post" action="' . $sv_staff_adr . 'end.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
		print('<td width="135" align="center" valign="middle">');
		if( $staff_cd != "" ){
			$tabindex++;
			print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_logout_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_logout_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_logout_1.png\';" border="0">');
		}else{
			print('&nbsp;');	
		}
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');
	
		print('<hr>');
	}
	
	print('<br><br>');
	
	//エラーメッセージ表示
	print('<font color="red">' . $zs_errmsg_txt . '</font><br><br><br>');
	
	print('<form name="err3" method="post" action="' . $sv_staff_adr . 'index_p.php">');
	print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
	print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
	print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
	print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
	$tabindex++;
	print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_login_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_login_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_login_1.png\';" border="0">');
	print('</form>');
		
	print('</center>');
	
	print('<br><br>');
	
	print('<hr>');
	
?>