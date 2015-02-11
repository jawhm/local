<?php
	//指定日の翌日の営業日フラグを求める
	//【input】
	//$zz_next_eigyoubi_flg_yyyy  指定日の年
	//$zz_next_eigyoubi_flg_mm    指定日の月
	//$zz_next_eigyoubi_flg_dd    指定日の日
	//【output】	
	// $zz_next_eigyoubi_flg  翌日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
	//（見つからない場合は営業日とする）
	

	$zz_next_eigyoubi_flg = 0;
	
	//指定日の翌日を求める
	$zz_next_eigyoubi_yyyymmdd = date("Ymd", mktime(0, 0, 0, $zz_next_eigyoubi_flg_mm, ($zz_next_eigyoubi_flg_dd + 1) , $zz_next_eigyoubi_flg_yyyy) );

	//カレンダーマスタより営業日を求める
	$zz_query = 'select EIGYOUBI_FLG from M_CALENDAR where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $select_office_cd . '" and YMD  = "' . $zz_next_eigyoubi_yyyymmdd . '";';
	$zz_result = mysql_query($zz_query);
	if (!$zz_result) {
		//失敗した場合は 営業日 とする
		$zz_next_eigyoubi_flg = 0;
	}else{
		while( $zz_row = mysql_fetch_array($zz_result) ){
			$zz_next_eigyoubi_flg = $zz_row[0];		//翌日の営業日フラグ　0:営業日、1:祝日営業日、8:非営業日、9:祝日非営業日
		}
	}

?>