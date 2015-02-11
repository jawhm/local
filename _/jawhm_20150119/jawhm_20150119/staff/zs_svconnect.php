<?php
	//サーバー情報
	$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
	$ini_svr = 'db1';
	$ini_usr = $ini['user'];
	$ini_pw = $ini['password'];
	$ini_db = $ini['user'];
	$ANGpw = 'G7yPl1sC';

	// サーバー接続
	$link = mysql_connect( $ini_svr, $ini_usr, $ini_pw );
	mysql_query('set character set utf8');

	// 接続確認
	if (!$link) {
		$svconnect_rtncd = 1;	//リターンコード「１」異常
	}else{
    	$db_selected = mysql_select_db( $ini_db , $link );
		$svconnect_rtncd = 0;	//リターンコード「０」正常
	}

	//環境フラグ
	$SVkankyo = 9;	//1:本番環境　9:開発環境

	//企業コード
	$DEF_kg_cd = 'jawhm';

	//HTTPアドレス（顧客）
	$sv_http_adr = 'http://www.jawhm.or.jp/';
	$sv_https_adr = 'http://www.jawhm.or.jp/';

	//HTTPアドレス（スタッフ）
	$sv_staff_adr = 'http://www.jawhm.or.jp/staff/';

	//住所入力例
	$ex_adr1 = '東京都新宿区西新宿';
	$ex_adr2 = '１－３－３　品川ステーションビル ５０７';

	//開発環境時のメール送信先（仮想お客様）
	$sv_test_cs_mailadr_cnt = 1;
	$sv_test_cs_mailadr[0] = "test_wh@axd.co.jp";
	
	//BCC送信メアド（複数の場合は , を入れて続けて入力）例： aaaaa@test.co.jp,bbbbb@test.co.jp
	if( $SVkankyo == 1 ){
		$sv_bcc_mailadr = "meminfo@jawhm.or.jp";
	}else{
		$sv_bcc_mailadr = "meminfo@jawhm.or.jp,test_wh@axd.co.jp";
	}

	//処理対象のID２桁
	$proc_id2keta = array('KT','KO','KN','KF','KK','TK','TO','OR');
	
	//カウンセラーフラグ
	$sv_counselor_flg_cnt = 2;
	$sv_counselor_flg[0] = 0;
	$sv_counselor_flg_nm[0] = "カウンセラーではない";
	$sv_counselor_flg[1] = 1;
	$sv_counselor_flg_nm[1] = "個別カウンセリングのカウンセラー";
	
	//講師フラグ
	$sv_koushi_flg_cnt = 2;
	$sv_koushi_flg[0] = 0;
	$sv_koushi_flg_nm[0] = "講師ではない";
	$sv_koushi_flg[1] = 1;
	$sv_koushi_flg_nm[1] = "英会話教室講師";
	

	//ＦＴＰ情報( $DEF_kg_cd /staff/ までのディレクトリ設定とする)
	$ftpinfo = parse_ini_file('../../bin/ftp.ini', FALSE);
	$ftp_server = $ftpinfo['ftpsv'];
	$ftp_user_name = $ftpinfo['ftpuser'];
	$ftp_user_pass = $ftpinfo['ftppassword'];

	//特定ディレクトリ情報
	//会員顔写真
	$dir_kaiin_img = 'Jk3es9Ws';

	//メールサーバー用メールパスワード
	$mail_pw = "pSa2co0bDl";

?>