<?php
	//ログ出力する
	
	if( $log_sbt != 'T' ){
		//トランザクション以外（ N:通常ログ  W:警告  E:エラー ）
	
		$LOG_err_flg = 0;
	
		// "(ﾀﾞﾌﾞﾙｺｰﾃｰｼｮﾝ)を\"になおす
		$log_naiyou = str_replace('"','\"',"$log_naiyou");
		$log_err_inf = str_replace('"','\"',"$log_err_inf");
		
		// axdkanri を AXDシステム管理者 に置換する
		$log_naiyou = str_replace('axdkanri','<font color=\"green\">AXDシステム管理者</font>',"$log_naiyou");
		
		
		//ログの登録（INSERT)
		// 1/1000秒単位の現在時刻を取得
		$LOG_micro = sprintf("%s" , microtime() );
		$LOG_nowtime = date("YmdHis") . substr($LOG_micro ,2,4);
		
		//文字コード設定
		$zzmojicd_sql = "SET NAMES utf8";
		$zzmojicd_result = mysql_query($zzmojicd_sql);
		
		$LOG_query = 'insert into D_LOG values ( "' . $LOG_nowtime . '",';
		if( $log_sbt == '' ){
			$LOG_query .= 'NULL,';
		}else{
			$LOG_query .= '"' . $log_sbt . '",';
		}
		if( $log_kkstaff_kbn == '' ){
			$LOG_query .= 'NULL,';
		}else{
			$LOG_query .= '"' . $log_kkstaff_kbn . '",';
		}
		$LOG_query .=  '"' . $DEF_kg_cd . '",';
		if( $log_office_cd == '' ){
			$LOG_query .= 'NULL,';
		}else{
			$LOG_query .= '"' . $log_office_cd . '",';
		}
		if( $log_kaiin_no == '' ){
			$LOG_query .= 'NULL,';
		}else{
			$LOG_query .= '"' . $log_kaiin_no . '",';
		}
		if( $gmn_id == '' ){
			$LOG_query .= 'NULL,';
		}else{
			$LOG_query .= '"' . $gmn_id . '",';
		}
		if( $log_naiyou == '' ){
			$LOG_query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
		}else{
			$LOG_query .= 'ENCODE("' . $log_naiyou . '","' . $ANGpw . '"),';
		}
		if( $log_err_inf == '' ){
			$LOG_query .= 'ENCODE(NULL,"' . $ANGpw . '"));';
		}else{
			$LOG_query .= 'ENCODE("' . $log_err_inf . '","' . $ANGpw . '"));';
		}
	
		$LOG_result = mysql_query($LOG_query);
		if (!$LOG_result) {
			$LOG_err_flg = 1;
		}
		
		//エラー時は管理者にメール通知
		if( $log_sbt == 'E' ){
			
//			if( $errData_kaiin_no == '' ){
//				mb_language("Japanese");
//				mb_internal_encoding("SHIFT_JIS");
//				$mailto = 'sys@axd.co.jp';	//送信先アドレス
//				$mailfrom = 'From:' . $DEF_kg_cd . '_err@netdeyoyaku.net';		//送信元
//				$subject = 'ネットde予約【' . $DEF_kg_cd . '】異常終了通知';	//メールタイトル
//				//メール内容
//				$content = '予約システムにて障害発生が発生しました。
//		
//発生時刻[' . substr($LOG_nowtime,0,4) . '/' . substr($LOG_nowtime,4,2) . '/' . substr($LOG_nowtime,6,2) . ' ' . substr($LOG_nowtime,8,2) . ':' . //substr($LOG_nowtime,10,2) . ':' . substr($LOG_nowtime,12,2) . ']' . '
//ログ種別[' . $log_sbt . ']
//顧客店舗区分[' . $log_kktnp_kbn . ']
//店舗CD[' . $log_tenpo_cd . ']
//会員NO[' . $log_kaiin_no . ']
//画面ID[' . $gmn_id . ']
//内容[' . $log_naiyou . ']';
//				mb_send_mail($mailto,$subject,$content,$mailfrom);
//		
//				$errData_kaiin_no = $log_kaiin_no;
//			}
		}
	
	}else{
		//トランザクションの場合
		$LOG_err_flg = 0;
	
		// "(ﾀﾞﾌﾞﾙｺｰﾃｰｼｮﾝ)を\"になおす
		$log_naiyou = str_replace('"','\"',"$log_naiyou");
		$log_err_inf = str_replace('"','\"',"$log_err_inf");
		
		//ログの登録（INSERT)
		// 1/1000秒単位の現在時刻を取得
		$LOG_micro = sprintf("%s" , microtime() );
		$LOG_nowtime = date("YmdHis") . substr($LOG_micro ,2,4);
		
		//文字コード設定
		$zzmojicd_sql = "SET NAMES utf8";
		$zzmojicd_result = mysql_query($zzmojicd_sql);
		
		$LOG_query = 'insert into D_LOG_T values ( "' . $LOG_nowtime . '",';
		if( $log_sbt == '' ){
			$LOG_query .= 'NULL,';
		}else{
			$LOG_query .= '"' . $log_sbt . '",';
		}
		if( $log_kkstaff_kbn == '' ){
			$LOG_query .= 'NULL,';
		}else{
			$LOG_query .= '"' . $log_kkstaff_kbn . '",';
		}
		$LOG_query .=  '"' . $DEF_kg_cd . '",';
		if( $log_office_cd == '' ){
			$LOG_query .= 'NULL,';
		}else{
			$LOG_query .= '"' . $log_office_cd . '",';
		}
		if( $log_kaiin_no == '' ){
			$LOG_query .= 'NULL,';
		}else{
			$LOG_query .= '"' . $log_kaiin_no . '",';
		}
		if( $gmn_id == '' ){
			$LOG_query .= 'NULL,';
		}else{
			$LOG_query .= '"' . $gmn_id . '",';
		}
		if( $log_naiyou == '' ){
			$LOG_query .= 'ENCODE(NULL,"' . $ANGpw . '"),';
		}else{
			$LOG_query .= 'ENCODE("' . $log_naiyou . '","' . $ANGpw . '"),';
		}
		if( $log_err_inf == '' ){
			$LOG_query .= 'ENCODE(NULL,"' . $ANGpw . '"));';
		}else{
			$LOG_query .= 'ENCODE("' . $log_err_inf . '","' . $ANGpw . '"));';
		}
	
		$LOG_result = mysql_query($LOG_query);
		if (!$LOG_result) {
			$LOG_err_flg = 1;
		}

	}
	
?>