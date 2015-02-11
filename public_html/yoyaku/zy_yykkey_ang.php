<?php
	// 予約キー暗号化
	//
	// (Input)
	//  $yykkey_kaiin_id  : お客様番号(ZZ9999-999)
	//
	// (Output)
	//  $yykkey_err_flg  : 0:エラー無し　1:キー生成エラー
	//  $yykkey_ang_str  : 暗号キー
	//
	
	//有効時間（例：24:２４時間後＋α分）αは分を時に切り上げするため
	$yykkey_yukou_hh = 24;	//単位（時）
	$yykkey_yukou_hh++;		//α

	//ダウンロードキー文字列
	$yykkey_str = array('S','9','k','3','c','O','0','B','w','r','Q',
					   'o','Z','6','f','l','1','I','j','5','T','L',
					   'P','D','F','V','p','X','U','v','C','z','M',
					   'R','4','i','b','G','J','h','y','E','t','2',
					   'q','H','g','s','8','K','d','x','n','e','7',
					   'W','N','Y','m','u','A','a');

	$yykkey_err_flg = 0;

	//お客様番号
	if( $yykkey_kaiin_id == '' ){
		$yykkey_err_flg = 1;
	}else if( strlen($yykkey_kaiin_id) != 10 ){
		$yykkey_err_flg = 1;
	}else{
		//数字4桁、数字3桁を抽出する
		$yykkey_kaiin_id_1st = substr($yykkey_kaiin_id,2,4);
		$yykkey_kaiin_id_2nd = substr($yykkey_kaiin_id,7,3);
		$yykkey_kaiin_id_kigou_1 = substr($yykkey_kaiin_id,0,2);
		$yykkey_kaiin_id_kigou_2 = substr($yykkey_kaiin_id,6,1);
	}
	
	if( $yykkey_err_flg == 0 ){
		//現在時刻に有効時間を加算する
		$yykkey_add_dd = intval($yykkey_yukou_hh / 24);
		$yykkey_add_hh = $yykkey_yukou_hh % 24;
		
		$kgn_yyyy = date( "Y", time() );
		$kgn_mm = date( "m", time() );
		$kgn_dd = date( "d", time() ) + $yykkey_add_dd;
		$kgn_hh = date( "H", time() ) + $yykkey_add_hh;
		$kgn_maxdd = cal_days_in_month(CAL_GREGORIAN, $kgn_mm , $kgn_yyyy );
		if( $kgn_hh >= 24 ){
			$kgn_dd++;
			$kgn_hh -= 24;
		}
		if( $kgn_dd > $kgn_maxdd ){
			$kgn_dd -= $kgn_maxdd;
			$kgn_mm++;
			if( $kgn_mm > 12 ){
				$kgn_mm = 1;
				$kgn_yyyy++;
			}
		}
		$total_cd = $kgn_yyyy + $kgn_mm + $kgn_dd + $kgn_hh + (sprintf("%d",$yykkey_kaiin_id_1st) * 1000) + sprintf("%d",$yykkey_kaiin_id_2nd);
		
		$full_str = sprintf("%07d",$total_cd) . $kgn_yyyy . sprintf("%02d",$kgn_mm) . sprintf("%02d",$kgn_dd) . sprintf("%02d",$kgn_hh) . $yykkey_kaiin_id_1st . $yykkey_kaiin_id_2nd;
		
		$tmp_str = '';
		$ang_i = 0;
		while($ang_i < 24){
			$tmp_int1 = intval(substr($full_str,$ang_i,3));
			$tmp_int2 = intval($tmp_int1 / 61);
			$tmp_int3 = $tmp_int1 % 61;
			$tmp_str .= $yykkey_str[$tmp_int2] . $yykkey_str[$tmp_int3];
			$ang_i += 3;
		}
		
		$p1_int = 0;
		$p2_int = 0;
		$ang_i = 0;
		while($ang_i < 24){
			$p1_int += intval(substr($full_str,$ang_i,1));
			$ang_i++;
		}
		$p2_int = $p1_int;
		$p1_int = $p1_int % 10;
		$p2_int = $p2_int % 61;
		
		$p1_str = $yykkey_str[$p1_int];
		$p2_str = $yykkey_str[$p2_int];
		
		$yykkey_ang_str = $p1_str . $tmp_str . $yykkey_kaiin_id_kigou_1 . $p2_str;
	
	}

?>