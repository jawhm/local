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

	//住所入力例
	$ex_adr1 = '東京都新宿区西新宿';
	$ex_adr2 = '１－３－３　品川ステーションビル ５０７';
	
	
	$sv_max_disp_week = 8;	//最大表示週
	
	//予約受付メールアドレス
	$sv_yyk_request_mailadr = "yoyaku@jawhm.or.jp";
	
	
	//開発環境時のメール送信先（仮想お客様）
	$sv_test_cs_mailadr_cnt = 1;	//件数
	$sv_test_cs_mailadr[0] = "test_wh@axd.co.jp";
	//$sv_test_cs_mailadr[1] = "test_wh@axd.co.jp";
	//$sv_test_cs_mailadr[2] = "test_wh@axd.co.jp";
	
	//BCC送信メアド（複数の場合は , を入れて続けて入力）例： aaaaa@test.co.jp,bbbbb@test.co.jp
	if( $SVkankyo == 1 ){
		$sv_bcc_mailadr = "meminfo@jawhm.or.jp";
	}else{
		$sv_bcc_mailadr = "meminfo@jawhm.or.jp,test_wh@axd.co.jp";
	}


?>