<?php
	//エラー画面編集

	$zs_errmsg_txt = '';
	
	if( $lang_cd == "" ){
		$lang_cd = "J";	
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
	print('<img src="./img_' . $lang_cd . '/btn_modoru_2.png" width="0" height="0" style="visibility:hidden;">');
	
	if( $err_flg != 4 ){
			
		print('<font color="red">' . $zs_errmsg_txt . '</font><br><br>');

		//戻るボタン
		print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<td width="135" align="center" valign="middle">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');
	
		print('<hr>');
		
	}else if( $err_flg == 4 ){
		//DBエラー

		print('<font color="red">エラーが発生しました。</font><br><br>');
		
		//戻るボタン
		print('<form method="post" action="' . $sv_https_adr . 'yoyaku_mb/M-kbt_counseling.php">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
		print('<td width="135" align="center" valign="middle">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_modoru_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_modoru_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_modoru_1.png\';" border="0">');
		print('</td>');
		print('</form>');
		print('</tr>');
		print('</table>');
	
		print('<hr>');
		
	}
		
?>