<?php
	//*** メンテナンス期間チェック ***
	// zy_mntchk.php
	//
	//返却変数
	// $mntchk_flg				: システム稼動フラグ　0:稼動中　1:強制停止中　2:メンテナンス中　3:当日翌日にメンテあり　4:１時間以内にメンテあり
	// $mntchk_st_time			: メンテ開始時刻
	// $mntchk_ed_time			: メンテ終了時刻
	// $mntchk_display_time		: （表示用）メンテナンス期間
	//
	//
	
	//初期化
	//メンテナンス期間チェック
	$mntchk_flg = "";		//システム稼動フラグ　0:稼動中　1:強制停止中　2:メンテナンス中　3:当日翌日にメンテあり　4:１時間以内にメンテあり
	$mntchk_st_time = "";	//メンテ開始時刻
	$mntchk_ed_time = "";	//メンテ終了時刻
		
	$mntchk_query = 'select SYSTEM_KADO_FLG from M_KANRI_INFO where KG_CD = "' . $DEF_kg_cd . '" order by IDX desc LIMIT 1;';
	$mntchk_result = mysql_query($mntchk_query);
	if (!$mntchk_result) {
		//ＤＢエラー
		print('<font color="red">エラーが発生しました。(An error has occurred.)</font><BR>');
		$err_flg = 4;
			
		//**ログ出力**
		$log_sbt = 'E';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
		$log_kkstaff_kbn = 'K';		//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
		$log_office_cd = '';		//オフィスコード
		$log_kaiin_no = $kaiin_id;	//会員番号 または スタッフコード
		$log_naiyou = '管理情報の参照に失敗しました。';	//内容
		$log_err_inf = $mntchk_query;		//エラー情報
		require( '../zz_log.php' );
		//************
					
	}else{
		$mntchk_row = mysql_fetch_array($mntchk_result);
		$mntchk_flg = $mntchk_row[0];	//システム稼動フラグ　0:稼動中　1:強制停止中　2:メンテナンス中　3:当日翌日にメンテあり　4:１時間以内にメンテあり
	
	}
	
	if( $mntchk_flg == 0 ){
		$mntchk_query = 'select MNT_ST_TIME,MNT_ED_TIME from M_MENTE_INFO where KG_CD = "' . $DEF_kg_cd . '" and MNT_ED_TIME >= "' . $now_time . '" order by MNT_ST_TIME LIMIT 1;';
		$mntchk_result = mysql_query($mntchk_query);
		if (!$mntchk_result) {
			//ＤＢエラー
			print('<font color="red">エラーが発生しました。</font><BR>');
			$err_flg = 4;
		
			//**ログ出力**
			$log_sbt = 'E';				//ログ種別    （ N:通常ログ  W:警告  E:エラー ）
			$log_kkstaff_kbn = 'K';		//顧客店舗区分（ K:顧客サイト  S:スタッフサイト ）
			$log_office_cd = '';		//オフィスコード
			$log_kaiin_no = $kaiin_id;	//会員番号 または スタッフコード
			$log_naiyou = '管理情報の参照に失敗しました。';	//内容
			$log_err_inf = $mntchk_query;		//エラー情報
			require( '../zz_log.php' );
			//************
				
			}else{
			while( $mntchk_row = mysql_fetch_array($mntchk_result) ){
				$mntchk_st_time_d = $mntchk_row[0];
				$mntchk_ed_time_d = $mntchk_row[1];
			}
			if( $mntchk_st_time_d != "" ){
				$mntchk_st_time = substr($mntchk_st_time_d,0,4) . substr($mntchk_st_time_d,5,2) . substr($mntchk_st_time_d,8,2) . substr($mntchk_st_time_d,11,2) . substr($mntchk_st_time_d,14,2) . substr($mntchk_st_time_d,17,2);
				$mntchk_ed_time = substr($mntchk_ed_time_d,0,4) . substr($mntchk_ed_time_d,5,2) . substr($mntchk_ed_time_d,8,2) . substr($mntchk_ed_time_d,11,2) . substr($mntchk_ed_time_d,14,2) . substr($mntchk_ed_time_d,17,2);
				if( $mntchk_st_time <= $now_time && $now_time  <=  $mntchk_ed_time ){
					$mntchk_flg = 2;	//システム稼動フラグ　0:稼動中　1:強制停止中　2:メンテナンス中　3:当日翌日にメンテあり　4:１時間以内にメンテあり
					
				}else{
					//今日か翌日にメンテがある場合は表示する
					if( $now_yyyymmdd == substr($mntchk_st_time,0,8) || $ykjt_yyyymmdd == substr($mntchk_st_time,0,8) ){
						//1時間以内かチェックする
						if( $ykjt_yyyymmdd == substr($mntchk_st_time,0,8) ){
							$mntchk_remain_hour = 24 + substr($mntchk_st_time,8,2) - $now_hh;
						}else{
							$mntchk_remain_hour = substr($mntchk_st_time,8,2) - $now_hh;
						}
						if( $mntchk_remain_hour <= 1 ){
							//メンテ開始１時間前
							$mntchk_flg = 4;	//0:稼動中　1:強制停止中　2:メンテナンス中　3:当日翌日にメンテあり　4:１時間以内にメンテあり
						}else{
							$mntchk_flg = 3;	//0:稼動中　1:強制停止中　2:メンテナンス中　3:当日翌日にメンテあり　4:１時間以内にメンテあり
						}
						$mntchk_st_youbi = date("w", mktime(0, 0, 0, substr($mntchk_st_time_d,5,2), substr($mntchk_st_time_d,8,2), substr($mntchk_st_time_d,0,4)));
						$mntchk_ed_youbi = date("w", mktime(0, 0, 0, substr($mntchk_ed_time_d,5,2), substr($mntchk_ed_time_d,8,2), substr($mntchk_ed_time_d,0,4)));
						$mntchk_display_time = substr($mntchk_st_time_d,0,4) . '年&nbsp;' . sprintf("%d",substr($mntchk_st_time_d,5,2)) . '月&nbsp;' . sprintf("%d",substr($mntchk_st_time_d,8,2)) . '日(' . $week[$mntchk_st_youbi] . ')&nbsp;';
						if( intval(substr($mntchk_st_time_d,11,2)) < 12 ){
							$mntchk_display_time .= '午前&nbsp;' . sprintf("%d",substr($mntchk_st_time_d,11,2));
						}else if( intval(substr($mntchk_st_time_d,11,2)) == 12 ){
							$mntchk_display_time .= '午後&nbsp;' . sprintf("%d",substr($mntchk_st_time_d,11,2));
						}else{
							$mntchk_display_time .= '午後&nbsp;' . sprintf("%d",(intval(substr($mntchk_st_time_d,11,2)) - 12));
						}
						$mntchk_display_time .= '時' . substr($mntchk_st_time_d,14,2) . '分&nbsp;から&nbsp;' . substr($mntchk_ed_time_d,0,4) . '年&nbsp;' . sprintf("%d",substr($mntchk_ed_time_d,5,2)) . '月&nbsp;' . sprintf("%d",substr($mntchk_ed_time_d,8,2)) . '日(' . $week[$mntchk_ed_youbi] . ')&nbsp;';
						if( intval(substr($mntchk_ed_time_d,11,2)) < 12 ){
							$mntchk_display_time .= '午前&nbsp;' . sprintf("%d",substr($mntchk_ed_time_d,11,2));
						}else if( intval(substr($mntchk_ed_time_d,11,2)) == 12 ){
							$mntchk_display_time .= '午後&nbsp;' . sprintf("%d",substr($mntchk_ed_time_d,11,2));
						}else{
							$mntchk_display_time .= '午後&nbsp;' . sprintf("%d",(intval(substr($mntchk_ed_time_d,11,2)) - 12));
						}
						$mntchk_display_time .= '時' . substr($mntchk_ed_time_d,14,2) . '分&nbsp;まで';
					}
				}
			}
		}
	}
?>