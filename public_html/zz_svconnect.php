<?php
	//�T�[�o�[���
	$ini = parse_ini_file('../bin/pdo_mail_list.ini', FALSE);
	$ini_svr = 'db1';
	$ini_usr = $ini['user'];
	$ini_pw = $ini['password'];
	$ini_db = $ini['user'];
	$ANGpw = 'G7yPl1sC';

	// �T�[�o�[�ڑ�
	$link = mysql_connect( $ini_svr, $ini_usr, $ini_pw );
	// �ڑ��m�F
	if (!$link) {
		$svconnect_rtncd = 1;	//���^�[���R�[�h�u�P�v�ُ�
	}else{
    	$db_selected = mysql_select_db( $ini_db , $link );
		$svconnect_rtncd = 0;	//���^�[���R�[�h�u�O�v����
	}

	//���t���O
	$SVkankyo = 1;	//1:�{�Ԋ��@9:�J����

	//��ƃR�[�h
	$DEF_kg_cd = 'jawhm';

	//HTTP�A�h���X�i�ڋq�j
	$sv_http_adr = 'http://www.jawhm.or.jp/';
	$sv_https_adr = 'http://www.jawhm.or.jp/';

	//HTTP�A�h���X�i�X�^�b�t�j
	$sv_staff_adr = 'http://www.jawhm.or.jp/staff/';

	//�Z�����͗�
	$ex_adr1 = '�����s�V�h�搼�V�h';
	$ex_adr2 = '�P�|�R�|�R�@�i��X�e�[�V�����r�� �T�O�V';

?>