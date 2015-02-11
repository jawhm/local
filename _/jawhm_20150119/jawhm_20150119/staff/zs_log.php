<?php
	//ログ出力する
	
	if( $log_sbt != 'T' ){
		//トランザクション以外（ N:通常ログ  W:警告  E:エラー ）
	
		$LOG_err_flg = 0;
	
		// "(ﾀﾞﾌﾞﾙｺｰﾃｰｼｮﾝ)を\"になおす
		$log_naiyou = str_replace('"', '\"', $log_naiyou);
		$log_err_inf = str_replace('"', '\"', $log_err_inf);
		
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
			//エラー発生時の緊急連絡先メールアドレス( [;]付けで複数登録可)
			if( $SVkankyo == 1 ){
				//本番環境
				$err_send_mail_adr = "meminfo@jawhm.or.jp;ienitukumadega-ensokudesu@docomo.ne.jp;oyatuha300@docomo.ne.jp;masaki@tora-tora.net;tanabe@axd.co.jp";
			}else{
				//開発環境
				$err_send_mail_adr = "tanabe@axd.co.jp";
			}
			
			//*** システム管理者へメール送信 ***
			//送信元
			$from_nm = '(WH)Web_system';
			$from_mail = 'info@jawhm.or.jp';
			//タイトル
			$subject = '(WH)システムエラーが発生しました';
			// 本文
			$content = "(WH)システムエラーが発生しました。\n";
			$content .= "日時[" . date("YmdHis") . "]\n";
			$content .= "PHP [" . $gmn_id . "]\n";
			$content .= "内容[" . $log_naiyou . "]\n";
			//メール送信
			mb_language("Ja");				//使用言語：Ja
			mb_internal_encoding("utf-8");	//文字コード：UTF-8
			$frname0 = mb_encode_mimeheader($from_nm);
			$sdmail0 = $err_send_mail_adr;
			$mailhead = "From:\"$frname0\" <$from_mail>\r\n";
//			$result = mb_send_mail( $sdmail0, $subject, $content, $mailhead );
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