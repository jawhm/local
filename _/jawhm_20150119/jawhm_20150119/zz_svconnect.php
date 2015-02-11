<?php
	//サーバー情報
	$ini = parse_ini_file('../bin/pdo_mail_list.ini', FALSE);
	$ini_svr = 'db1';
	$ini_usr = $ini['user'];
	$ini_pw = $ini['password'];
	$ini_db = $ini['user'];
	$ANGpw = 'G7yPl1sC';

	// サーバー接続
	$link = mysql_connect( $ini_svr, $ini_usr, $ini_pw );
	// 接続確認
	if (!$link) {
		$svconnect_rtncd = 1;	//リターンコード「１」異常
	}else{
    	$db_selected = mysql_select_db( $ini_db , $link );
		$svconnect_rtncd = 0;	//リターンコード「０」正常
	}

	//環境フラグ
	$SVkankyo = 1;	//1:本番環境　9:開発環境

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

?>