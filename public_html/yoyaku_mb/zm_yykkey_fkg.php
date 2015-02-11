<?php
	// 予約キー複合化
	//
	// (Input)
	//  $yykkey_ang_str  : ダウンロードキー
	//
	// (Output)
	//  $yykkey_err_flg  : 0:エラー無し　1:ダウンロードキーエラー　2:有効期限エラー　3お客様番号エラー　5:システムエラー
	//  $yykkey_yuko_kgn : 有効期限(yyyymmddhh)
	//  $yykkey_kaiin_id : お客様番号
	//
	
	//ダウンロードキー文字列
	$yykkey_str = array('S','9','k','3','c','O','0','B','w','r','Q',
					   'o','Z','6','f','l','1','I','j','5','T','L',
					   'P','D','F','V','p','X','U','v','C','z','M',
					   'R','4','i','b','G','J','h','y','E','t','2',
					   'q','H','g','s','8','K','d','x','n','e','7',
					   'W','N','Y','m','u','A','a');

	$yykkey_err_flg = 0;	//0:エラー無し　1:ダウンロードキーエラー　2:有効期限エラー　3:アプリ番号エラー　4:会員番号エラー　5:システムエラー
	$yykkey_yuko_kgn = "";
	$yykkey_kaiin_id = "";
	
	$p1_str = substr($yykkey_ang_str,0,1);
	$tmp_str = substr($yykkey_ang_str,1,18);
	$p2_str = substr($yykkey_ang_str,19,1);
	$full_str = '';

	$p1_num = (-1);
	$yyk_x = 0;
	while( $yyk_x <= 61 && $p1_num == (-1) ){
		if( $p1_str == $yykkey_str[$yyk_x] ){
			$p1_num = $yyk_x;
		}
		$yyk_x++;
	}
	if( $p1_num == (-1) ){
		$yykkey_err_flg = 1;
//print('chk01[' . $p1_num . ']<br>');		
	}

	$p2_num = (-1);
	$yyk_x = 0;
	while( $yyk_x <= 61 && $p2_num == (-1) ){
		if( $p2_str == $yykkey_str[$yyk_x] ){
			$p2_num = $yyk_x;
		}
		$yyk_x++;
	}
	if( $p2_num == (-1) ){
		$yykkey_err_flg = 1;
//print('chk02[' . $p2_num . ']<br>');		
	}

	$yyk_i = 0;
	while( $yyk_i < 8 && $yykkey_err_flg == 0 ){
		$tmp_sho_str = substr($tmp_str,($yyk_i * 2),1);
		$tmp_amr_str = substr($tmp_str,(($yyk_i * 2) + 1),1);

		$tmp_sho_num[$yyk_i] = '';
		$find_flg = 0;
		$yyk_x = 0;
		while( $yyk_x <= 61 && $find_flg == 0 ){
			if( $tmp_sho_str == $yykkey_str[$yyk_x] ){
				$find_flg = 1;
				$tmp_sho_num[$yyk_i] = $yyk_x;
			}
			$yyk_x++;
		}
		if( $find_flg == 0 ){
			$yykkey_err_flg = 1;
//print('chk03[' . $find_flg . ']<br>');
		}

		$tmp_amr_num[$yyk_i] = '';
		$find_flg = 0;
		$yyk_x = 0;
		while( $yyk_x <= 61 && $find_flg == 0 ){
			if( $tmp_amr_str == $yykkey_str[$yyk_x] ){
				$tmp_amr_num[$yyk_i] = $yyk_x;
				$find_flg = 1;
			}
			$yyk_x++;
		}
		if( $find_flg == 0 ){
			$yykkey_err_flg = 1;
//print('chk04[' . $find_flg . ']<br>');
		}

		if( $yykkey_err_flg == 0 ){
			$full_str .= sprintf("%03d",(($tmp_sho_num[$yyk_i] * 61) + $tmp_amr_num[$yyk_i] ));
		}
		
		$yyk_i++;
	}

	$full_str .= substr($yykkey_ang_str,17,2);


	if( $yykkey_err_flg == 0 ){
		$total_cd = sprintf("%d",substr($full_str,0,7));
		$yykkey_yuko_kgn = substr($full_str,7,10);
		$yykkey_kaiin_id_1st = sprintf("%d",substr($full_str,17,4));
		$yykkey_kaiin_id_2nd = sprintf("%d",substr($full_str,21,3));
		$yykkey_kaiin_id_kigou_1 = substr($full_str,24,2);
		$yykkey_kaiin_id_kigou_2 = "-";
	}

	if( $yykkey_err_flg == 0 ){
		//パリティチェック
		$tmp_num = 0;
		$yyk_i = 0;
		while( $yyk_i < 24 ){
			$tmp_num += substr($full_str,$yyk_i,1);
			$yyk_i++;
		}
		
		if( $p1_num != ($tmp_num % 10) ){
			$yykkey_err_flg = 1;	//1:ダウンロードキーエラー
//print('chk05[' . $p1_num . ']<br>');
		}

		if( $p2_num != ($tmp_num % 61) ){
			$yykkey_err_flg = 1;	//1:ダウンロードキーエラー
//print('chk06[' . $p2_num . ']<br>');
		}

		$tmp_num = sprintf("%d",substr($yykkey_yuko_kgn,0,4)) + sprintf("%d",substr($yykkey_yuko_kgn,4,2)) + sprintf("%d",substr($yykkey_yuko_kgn,6,2)) + sprintf("%d",substr($yykkey_yuko_kgn,8,2)) + (sprintf("%d",$yykkey_kaiin_id_1st) * 1000) + sprintf("%d",$yykkey_kaiin_id_2nd);
		
		if( $total_cd != $tmp_num ){
			$yykkey_err_flg = 1;	//1:ダウンロードキーエラー
//print('chk07[' . $total_cd . '-' . $tmp_num . ']<br>');
		}
	}		

	if( $yykkey_err_flg == 0 ){
		$now_yyyymmddhh = date( "YmdH", time() );
		//有効期限チェック
		if( $yykkey_yuko_kgn < $now_yyyymmddhh ){
			$yykkey_err_flg = 2;
		}
	}

	if( $yykkey_err_flg == 0 ){
		//お客様番号の編集
		$yykkey_kaiin_id = $yykkey_kaiin_id_kigou_1 . sprintf("%04d",$yykkey_kaiin_id_1st) . $yykkey_kaiin_id_kigou_2 . sprintf("%03d",$yykkey_kaiin_id_2nd);
		
	}

?>