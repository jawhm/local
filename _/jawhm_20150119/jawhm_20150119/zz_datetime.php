<?php
	//日付 関係
	
	//本日日付
	$now_yyyy = date( "Y", time() );
	$now_mm = date( "m", time() );
	$now_dd = date( "d", time() );
	$now_hh = date( "H", time() );
	$now_ii = date( "i", time() );
	$now_ss = date( "s", time() );
	$now_yyyymmdd = $now_yyyy . sprintf("%02d",$now_mm) . sprintf("%02d",$now_dd);
	$now_yyyymmdd2 = $now_yyyy . '-' . sprintf("%02d",$now_mm) . '-' . sprintf("%02d",$now_dd);
	$now_time = date( "YmdHis", time() );
	//曜日（0:日,1:月,2:火,3:水,4:木,5:金,6:土）
	$now_youbi = date("w", mktime(0, 0, 0, $now_mm, $now_dd, $now_yyyy));
	$week = array("日", "月", "火", "水", "木", "金", "土");
	
	//当月
	$now_yyyymm = $now_yyyy . sprintf("%02d",$now_mm);
	//当月の１日	
	$now_1stday = $now_yyyy . sprintf("%02d",$now_mm) . '01';
	//当月の最終日
	$now_maxdd = cal_days_in_month(CAL_GREGORIAN, $now_mm , $now_yyyy );
	$now_lastday = $now_yyyy . sprintf("%02d",$now_mm) . sprintf("%02d",$now_maxdd);

	//前日
	$znjt_yyyymmdd = date("Ymd", mktime(0, 0, 0, $now_mm, ($now_dd - 1) , $now_yyyy) );

	//翌日
	$ykjt_yyyymmdd = date("Ymd", mktime(0, 0, 0, $now_mm, ($now_dd + 1) , $now_yyyy) );

	//前月
	$old_yyyy = $now_yyyy;
	$old_mm = $now_mm - 1;
	if( $old_mm < 1 ){
		$old_yyyy--;
		$old_mm = 12;
	}
	$old_yyyymm = $old_yyyy . sprintf("%02d",$old_mm);

	//翌月
	$next_yyyy = $now_yyyy;
	$next_mm = $now_mm + 1;
	if( $next_mm > 12 ){
		$next_yyyy++;
		$next_mm = 1;
	}
	$next_yyyymm = $next_yyyy . sprintf("%02d",$next_mm);
	//翌月の１日
	$next_1stday = $next_yyyy . sprintf("%02d",$next_mm) . '01';
	//翌月の最終日
	$next_maxdd = cal_days_in_month(CAL_GREGORIAN, $next_mm , $next_yyyy );
	$next_lastday = $next_yyyy . sprintf("%02d",$next_mm) . sprintf("%02d",$next_maxdd);
	
	//翌々月
	$nextnext_yyyy = $next_yyyy;
	$nextnext_mm = $next_mm + 1;
	if( $nextnext_mm > 12 ){
		$nextnext_yyyy++;
		$nextnext_mm = 1;
	}
	$nextnext_yyyymm = $nextnext_yyyy . sprintf("%02d",$nextnext_mm);
	//翌々月の１日
	$nextnext_1stday = $nextnext_yyyy . sprintf("%02d",$nextnext_mm) . '01';
	//翌々月の最終日
	$nextnext_maxdd = cal_days_in_month(CAL_GREGORIAN, $nextnext_mm , $nextnext_yyyy );
	$nextnext_lastday = $nextnext_yyyy . sprintf("%02d",$nextnext_mm) . sprintf("%02d",$nextnext_maxdd);
	
	
	//時間区分（表時間）
	$jkn_kbn_array_1 = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU');
	$jkn_kbn_array_1_count = count( $jkn_kbn_array_1 );
	//時間区分（裏時間：常連のみ）
	$jkn_kbn_array_2 = array('ZA','ZB','ZC','ZD','ZE','ZF','ZG','ZH','ZI','ZJ','ZK','ZL','ZM','ZN','ZO','ZP','ZQ','ZR','ZS','ZT','ZU','ZV','ZW','ZX','ZY','ZZ','YA','YB','YC','YD','YE','YF','YG','YH','YI','YJ','YK','YL','YM','YN','YO','YP','YQ','YR','YS','YT','YU');
	$jkn_kbn_array_2_count = count( $jkn_kbn_array_2 );
	
?>