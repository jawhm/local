<?php
	//���O�o�͂���
	
	if( $log_sbt != 'T' ){
		//�g�����U�N�V�����ȊO�i N:�ʏ탍�O  W:�x��  E:�G���[ �j
	
		$LOG_err_flg = 0;
	
		// "(����ٺ�ð���)��\"�ɂȂ���
		$log_naiyou = str_replace('"', '\"', $log_naiyou);
		$log_err_inf = str_replace('"', '\"', $log_err_inf);
		
		//���O�̓o�^�iINSERT)
		// 1/1000�b�P�ʂ̌��ݎ������擾
		$LOG_micro = sprintf("%s" , microtime() );
		$LOG_nowtime = date("YmdHis") . substr($LOG_micro ,2,4);
		
		//�����R�[�h�ݒ�
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
		
		//�G���[���͊Ǘ��҂Ƀ��[���ʒm
//		if( $log_sbt == 'E' ){
//			//���[�����M���Ȃ�
//		}
	
	}else{
		//�g�����U�N�V�����̏ꍇ
		$LOG_err_flg = 0;
	
		// "(����ٺ�ð���)��\"�ɂȂ���
		$log_naiyou = str_replace('"','\"',"$log_naiyou");
		$log_err_inf = str_replace('"','\"',"$log_err_inf");
		
		//���O�̓o�^�iINSERT)
		// 1/1000�b�P�ʂ̌��ݎ������擾
		$LOG_micro = sprintf("%s" , microtime() );
		$LOG_nowtime = date("YmdHis") . substr($LOG_micro ,2,4);
		
		//�����R�[�h�ݒ�
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