<?php
	//*** �����e�i���X���ԃ`�F�b�N ***
	// zy_mntchk.php
	//
	//�ԋp�ϐ�
	// $mntchk_flg				: �V�X�e���ғ��t���O�@0:�ғ����@1:������~���@2:�����e�i���X���@3:���������Ƀ����e����@4:�P���Ԉȓ��Ƀ����e����
	// $mntchk_st_time			: �����e�J�n����
	// $mntchk_ed_time			: �����e�I������
	// $mntchk_display_time		: �i�\���p�j�����e�i���X����
	//
	//
	
	//������
	//�����e�i���X���ԃ`�F�b�N
	$mntchk_flg = "";		//�V�X�e���ғ��t���O�@0:�ғ����@1:������~���@2:�����e�i���X���@3:���������Ƀ����e����@4:�P���Ԉȓ��Ƀ����e����
	$mntchk_st_time = "";	//�����e�J�n����
	$mntchk_ed_time = "";	//�����e�I������
		
	$mntchk_query = 'select SYSTEM_KADO_FLG from M_KANRI_INFO where KG_CD = "' . $DEF_kg_cd . '" order by IDX desc LIMIT 1;';
	$mntchk_result = mysql_query($mntchk_query);
	if (!$mntchk_result) {
		//�c�a�G���[
		print('<font color="red">�G���[���������܂����B(An error has occurred.)</font><BR>');
		$err_flg = 4;
			
		//**���O�o��**
		$log_sbt = 'E';				//���O���    �i N:�ʏ탍�O  W:�x��  E:�G���[ �j
		$log_kkstaff_kbn = 'K';		//�ڋq�X�܋敪�i K:�ڋq�T�C�g  S:�X�^�b�t�T�C�g �j
		$log_office_cd = '';		//�I�t�B�X�R�[�h
		$log_kaiin_no = $kaiin_id;	//����ԍ� �܂��� �X�^�b�t�R�[�h
		$log_naiyou = '�Ǘ����̎Q�ƂɎ��s���܂����B';	//���e
		$log_err_inf = $mntchk_query;		//�G���[���
		require( '../zz_log.php' );
		//************
					
	}else{
		$mntchk_row = mysql_fetch_array($mntchk_result);
		$mntchk_flg = $mntchk_row[0];	//�V�X�e���ғ��t���O�@0:�ғ����@1:������~���@2:�����e�i���X���@3:���������Ƀ����e����@4:�P���Ԉȓ��Ƀ����e����
	
	}
	
	if( $mntchk_flg == 0 ){
		$mntchk_query = 'select MNT_ST_TIME,MNT_ED_TIME from M_MENTE_INFO where KG_CD = "' . $DEF_kg_cd . '" and MNT_ED_TIME >= "' . $now_time . '" order by MNT_ST_TIME LIMIT 1;';
		$mntchk_result = mysql_query($mntchk_query);
		if (!$mntchk_result) {
			//�c�a�G���[
			print('<font color="red">�G���[���������܂����B</font><BR>');
			$err_flg = 4;
		
			//**���O�o��**
			$log_sbt = 'E';				//���O���    �i N:�ʏ탍�O  W:�x��  E:�G���[ �j
			$log_kkstaff_kbn = 'K';		//�ڋq�X�܋敪�i K:�ڋq�T�C�g  S:�X�^�b�t�T�C�g �j
			$log_office_cd = '';		//�I�t�B�X�R�[�h
			$log_kaiin_no = $kaiin_id;	//����ԍ� �܂��� �X�^�b�t�R�[�h
			$log_naiyou = '�Ǘ����̎Q�ƂɎ��s���܂����B';	//���e
			$log_err_inf = $mntchk_query;		//�G���[���
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
					$mntchk_flg = 2;	//�V�X�e���ғ��t���O�@0:�ғ����@1:������~���@2:�����e�i���X���@3:���������Ƀ����e����@4:�P���Ԉȓ��Ƀ����e����
					
				}else{
					//�����������Ƀ����e������ꍇ�͕\������
					if( $now_yyyymmdd == substr($mntchk_st_time,0,8) || $ykjt_yyyymmdd == substr($mntchk_st_time,0,8) ){
						//1���Ԉȓ����`�F�b�N����
						if( $ykjt_yyyymmdd == substr($mntchk_st_time,0,8) ){
							$mntchk_remain_hour = 24 + substr($mntchk_st_time,8,2) - $now_hh;
						}else{
							$mntchk_remain_hour = substr($mntchk_st_time,8,2) - $now_hh;
						}
						if( $mntchk_remain_hour <= 1 ){
							//�����e�J�n�P���ԑO
							$mntchk_flg = 4;	//0:�ғ����@1:������~���@2:�����e�i���X���@3:���������Ƀ����e����@4:�P���Ԉȓ��Ƀ����e����
						}else{
							$mntchk_flg = 3;	//0:�ғ����@1:������~���@2:�����e�i���X���@3:���������Ƀ����e����@4:�P���Ԉȓ��Ƀ����e����
						}
						$mntchk_st_youbi = date("w", mktime(0, 0, 0, substr($mntchk_st_time_d,5,2), substr($mntchk_st_time_d,8,2), substr($mntchk_st_time_d,0,4)));
						$mntchk_ed_youbi = date("w", mktime(0, 0, 0, substr($mntchk_ed_time_d,5,2), substr($mntchk_ed_time_d,8,2), substr($mntchk_ed_time_d,0,4)));
						$mntchk_display_time = substr($mntchk_st_time_d,0,4) . '�N&nbsp;' . sprintf("%d",substr($mntchk_st_time_d,5,2)) . '��&nbsp;' . sprintf("%d",substr($mntchk_st_time_d,8,2)) . '��(' . $week[$mntchk_st_youbi] . ')&nbsp;';
						if( intval(substr($mntchk_st_time_d,11,2)) < 12 ){
							$mntchk_display_time .= '�ߑO&nbsp;' . sprintf("%d",substr($mntchk_st_time_d,11,2));
						}else if( intval(substr($mntchk_st_time_d,11,2)) == 12 ){
							$mntchk_display_time .= '�ߌ�&nbsp;' . sprintf("%d",substr($mntchk_st_time_d,11,2));
						}else{
							$mntchk_display_time .= '�ߌ�&nbsp;' . sprintf("%d",(intval(substr($mntchk_st_time_d,11,2)) - 12));
						}
						$mntchk_display_time .= '��' . substr($mntchk_st_time_d,14,2) . '��&nbsp;����&nbsp;' . substr($mntchk_ed_time_d,0,4) . '�N&nbsp;' . sprintf("%d",substr($mntchk_ed_time_d,5,2)) . '��&nbsp;' . sprintf("%d",substr($mntchk_ed_time_d,8,2)) . '��(' . $week[$mntchk_ed_youbi] . ')&nbsp;';
						if( intval(substr($mntchk_ed_time_d,11,2)) < 12 ){
							$mntchk_display_time .= '�ߑO&nbsp;' . sprintf("%d",substr($mntchk_ed_time_d,11,2));
						}else if( intval(substr($mntchk_ed_time_d,11,2)) == 12 ){
							$mntchk_display_time .= '�ߌ�&nbsp;' . sprintf("%d",substr($mntchk_ed_time_d,11,2));
						}else{
							$mntchk_display_time .= '�ߌ�&nbsp;' . sprintf("%d",(intval(substr($mntchk_ed_time_d,11,2)) - 12));
						}
						$mntchk_display_time .= '��' . substr($mntchk_ed_time_d,14,2) . '��&nbsp;�܂�';
					}
				}
			}
		}
	}
?>