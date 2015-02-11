<?php
	//オフィス名の取得
	$office_nm = '';
	require( './zs_office_nm.php' );

	//スタッフ名の取得
	$staff_nm = '';
	$zs_kanrisya_flg = 0;
	require( './zs_staff_nm.php' );

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

	//画像事前読み込み
	print('<img src="./img_' . $lang_cd . '/btn_logout_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_kbtcounseling_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_english_school_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_mail_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_kaiininfo_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_yykkkn_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_sc_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_mail_2.png" width="0" height="0" style="visibility:hidden;">');
	print('<img src="./img_' . $lang_cd . '/btn_entry_2.png" width="0" height="0" style="visibility:hidden;">');

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
	if( $SVkankyo == 9 ){
		print('<div align="center" style="background-color:#FF0099"><font size="2" color="white">*** 開発環境 ***</font></div>');
	}
	print('</td>');
	//ログアウト
	print('<form method="post" action="' . $sv_staff_adr . 'end.php">');
	print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '">');
	print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '">');
	print('<input type="hidden" name="office_cd" value="' . $office_cd . '">');
	print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '">');
	print('<td width="135" align="center" valign="middle">');
	$tabindex++;
	print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_logout_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_logout_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_logout_1.png\';" onClick="kurukuru()" border="0">');
	print('</td>');
	print('</form>');
	print('</tr>');
	print('</table>');
	
	//メニューボタン
	print('<table width="950" border="0">');
	print('<tr>');
	print('<td bgcolor="lightblue" align="center" colspan="3"><img src="./img_' . $lang_cd . '/bar_okyakusamakanren.png" border="0"></td>');
	if( $zs_ope_auth >= 100 ){
		//エントリー表示　業務権限が 100以上は colspan="4"
		print('<td bgcolor="lightgreen" align="center" colspan="4"><img src="./img_' . $lang_cd . '/bar_staffkanren_4.png" border="0"></td>');
	}else{
		//エントリー表示　業務権限が 100未満は colspan="3"
		print('<td bgcolor="lightgreen" align="center" colspan="3"><img src="./img_' . $lang_cd . '/bar_staffkanren.png" border="0"></td>');
	}
	print('</tr>');
	print('<tr align="left">');
	//個別カウンセリング
	print('<form name="form3" method="post" action="' . $sv_staff_adr . 'kbtcounseling_trk_selectstaff.php">');
	print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
	print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
	print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
	print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');
	print('<td width="135" align="center" valign="middle" bgcolor="lightblue">');
	$tabindex++;
	print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kbtcounseling_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kbtcounseling_1.png\';" onClick="kurukuru()" border="0">');	
	print('</td>');
	print('</form>');
	//英会話教室
	print('<form name="form3" method="post" action="' . $sv_staff_adr . 'english_sc_top.php">');
	print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
	print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
	print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
	print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');
	print('<td width="135" align="center" valign="middle" bgcolor="lightblue">');
	$tabindex++;
	print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_english_school_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_english_school_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_english_school_1.png\';" onClick="kurukuru()" border="0">');	
	print('</td>');
	print('</form>');
	//メール処理
//	print('<form name="form3" method="post" action="' . $sv_staff_adr . 'mail_top.php">');
//	print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
//	print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
//	print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
///	print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');
//	print('<td width="135" align="center" valign="middle" bgcolor="lightblue">');
//	$tabindex++;
//	print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_mail_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_mail_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_mail_1.png\';" onClick="kurukuru()" border="0">');	
//	print('</td>');
//	print('</form>');
	//会員情報
	print('<form name="form3" method="post" action="' . $sv_staff_adr . 'kaiin_top.php">');
	print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
	print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
	print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
	print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');
	print('<td width="135" align="center" valign="middle" bgcolor="lightblue">');
	$tabindex++;
	print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_kaiininfo_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_kaiininfo_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_kaiininfo_1.png\';" onClick="kurukuru()" border="0">');
	print('</td>');
	print('</form>');
	//予約確認
	print('<form name="form11" method="post" action="' . $sv_staff_adr . 'yoyaku_kkn_top.php">');
	print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
	print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
	print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
	print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');
	print('<td width="135" align="center" valign="middle" bgcolor="lightgreen">');
	$tabindex++;
	print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_yykkkn_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_yykkkn_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_yykkkn_1.png\';" onClick="kurukuru()" border="0">');
	print('</td>');
	print('</form>');
	//スケジュール
	print('<form name="form12" method="post" action="' . $sv_staff_adr . 'sc_top.php">');
	print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
	print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
	print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
	print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');
	print('<td width="135" align="center" valign="middle" bgcolor="lightgreen">');
	$tabindex++;
	print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sc_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sc_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sc_1.png\';" onClick="kurukuru()" border="0">');
	print('</td>');
	print('</form>');
	//その他
//	print('<form name="form13" method="post" action="' . $sv_staff_adr . 'sonota_top.php">');
//	print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
//	print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
//	print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
//	print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');
//	print('<td width="135" align="center" valign="middle" bgcolor="lightgreen">');
//	$tabindex++;
//	print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_sonota_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_sonota_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_sonota_1.png\';" onClick="kurukuru()" border="0">');
//	print('</td>');
//	print('</form>');
	//メール
	//if( $staff_cd == 'zz_tanabe' ){
	if( 1 ){
		print('<form name="form13" method="post" action="http://192.168.11.118/mail/mail_list2.php" target="_mail">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');
		print('<input type="hidden" name="mail_pw" value="' . $mail_pw . '" />');
		print('<input type="hidden" name="kkn_flg" value="0">');
		print('<input type="hidden" name="cs_flg" value="0">');
		print('<input type="hidden" name="keyword" value="">');
		print('<input type="hidden" name="block_disp_flg" value="0">');
		print('<td width="135" align="center" valign="middle" bgcolor="lightgreen">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_mail_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_mail_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_mail_1.png\';" border="0">');
		print('</td>');
		print('</form>');
	}else{
		print('<td width="135" align="center" valign="middle" bgcolor="lightgreen">');
		print('<font size="2" color="red">メール調整中</font>');
		print('</td>');
	}
	
	//エントリー
	if( $zs_ope_auth >= 100 ){	//業務権限が 100以上のみ表示
		print('<form name="form14" method="post" action="http://192.168.11.118/entry/index.php" target="_entry">');
		print('<input type="hidden" name="prc_gmn" value="' . $gmn_id . '" />');
		print('<input type="hidden" name="lang_cd" value="' . $lang_cd . '" />');
		print('<input type="hidden" name="office_cd" value="' . $office_cd . '" />');
		print('<input type="hidden" name="staff_cd" value="' . $staff_cd . '" />');
		print('<input type="hidden" name="ope_auth" value="' . $zs_ope_auth . '" />');
		print('<td width="135" align="center" valign="middle" bgcolor="lightgreen">');
		$tabindex++;
		print('<input type="image" tabindex="' . $tabindex . '" src="./img_' . $lang_cd . '/btn_entry_1.png" onmouseover="this.src=\'./img_' . $lang_cd . '/btn_entry_2.png\';" onmouseout="this.src=\'./img_' . $lang_cd . '/btn_entry_1.png\';" border="0">');
		print('</td>');
		print('</form>');
	}
	print('</tr>');
	print('</table>');
	
	print('</center>');
	print('<hr>');
?>