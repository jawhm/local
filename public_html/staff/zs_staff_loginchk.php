<?php
	//スタッフのログインチェック
	
	//現在の時間を求める（単位秒）
	$LC_now = mktime(date("H"),date("i"),date("s"),date("m"),date("d"),date("Y"));
		
	//ログイン情報を読み込む
	$LC_query = 'select LOGIN_FLG,LOGIN_TIME FROM D_STAFF_LOGIN where KG_CD = "' . $DEF_kg_cd . '" and OFFICE_CD = "' . $office_cd . '" and STAFF_CD = "' . $staff_cd . '";';
	$LC_result = mysql_query($LC_query);
	if (!$LC_result) {
		//ログイン情報が無いので 1:エラー
		$LC_rtncd = 1;
	}else{
		$LC_row = mysql_fetch_array($LC_result);
			
		//データの格納
		$LC_login_flg = $LC_row[0];		//ログインフラグ
		$LC_login_time = $LC_row[1];	//ログイン時刻
			
		//ログイン時刻を秒に変換する
		$LC_dbstr = mb_ereg_replace('[^0-9]','',$LC_login_time);
		$LC_bdyyyy = substr($LC_dbstr,0,4);
		$LC_bdmm = substr($LC_dbstr,4,2);
		$LC_bddd = substr($LC_dbstr,6,2);
		$LC_bdhh = substr($LC_dbstr,8,2);
		$LC_bdii = substr($LC_dbstr,10,2);
		$LC_bdss = substr($LC_dbstr,12,2);
		$LC_db = mktime($LC_bdhh,$LC_bdii,$LC_bdss,$LC_bdmm,$LC_bddd,$LC_bdyyyy);
			
		//現在時刻とログイン時刻の差分を求める（単位秒）
		$LC_sabun = $LC_now - $LC_db;
			
		//ログインフラグが "1" で、ログイン時刻との差が３０分以内（1800秒）なら ＯＫとする。			
		if ( $LC_login_flg == 1 && 	$LC_sabun <= 7200 ){	//現在 ２時間設定
			$LC_rtncd = 0;
		}else{
			$LC_rtncd = 1;
		}
	}
?>