<?php
	//���O�o�͂���
	
	if( $log_sbt != 'T' ){
		//�g�����U�N�V�����ȊO�i N:�ʏ탍�O  W:�x��  E:�G���[ �j
	
		$LOG_err_flg = 0;
	
		// "(����ٺ�ð���)��\"�ɂȂ���
		$log_naiyou = str_replace('"','\"',"$log_naiyou");
		$log_err_inf = str_replace('"','\"',"$log_err_inf");
		
		// axdkanri �� AXD�V�X�e���Ǘ��� �ɒu������
		$log_naiyou = str_replace('axdkanri','<font color=\"green\">AXD�V�X�e���Ǘ���</font>',"$log_naiyou");
		
		
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
		if( $log_sbt == 'E' ){
			
//			if( $errData_kaiin_no == '' ){
//				mb_language("Japanese");
//				mb_internal_encoding("SHIFT_JIS");
//				$mailto = 'sys@axd.co.jp';	//���M��A�h���X
//				$mailfrom = 'From:' . $DEF_kg_cd . '_err@netdeyoyaku.net';		//���M��
//				$subject = '�l�b�gde�\��y' . $DEF_kg_cd . '�z�ُ�I���ʒm';	//���[���^�C�g��
//				//���[�����e
//				$content = '�\��V�X�e���ɂď�Q�������������܂����B
//		
//��������[' . substr($LOG_nowtime,0,4) . '/' . substr($LOG_nowtime,4,2) . '/' . substr($LOG_nowtime,6,2) . ' ' . substr($LOG_nowtime,8,2) . ':' . //substr($LOG_nowtime,10,2) . ':' . substr($LOG_nowtime,12,2) . ']' . '
//���O���[' . $log_sbt . ']
//�ڋq�X�܋敪[' . $log_kktnp_kbn . ']
//�X��CD[' . $log_tenpo_cd . ']
//���NO[' . $log_kaiin_no . ']
//���ID[' . $gmn_id . ']
//���e[' . $log_naiyou . ']';
//				mb_send_mail($mailto,$subject,$content,$mailfrom);
//		
//				$errData_kaiin_no = $log_kaiin_no;
//			}
		}
	
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