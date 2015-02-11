<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>田辺テスト</title>
<style type="text/css">
input.err,select.err,textarea.err {
	background-color: #FF0000;
}
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
}
option.color0 {
	color:#696969;
}
option.color1 {
	color:#0000ff;
}
option.color2 {
	color:#ff0000;
}
</style>
</head>
<body bgcolor="white">
<?php
//	$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
	//$ini_svr = 'jawhm.or.jp';
	$ini_svr = 'db1';
	$ini_usr = 'mail_list';
	$ini_pw = 'r2d2c3po303pittst';
	$ini_db = 'mail_list';

	// サーバー接続
	$link = mysql_connect( $ini_svr, $ini_usr, $ini_pw );
	mysql_query('set character set utf8');

	// 接続確認
	if (!$link) {
		print('<font color="red">接続失敗</font>');
		
	}else{
    	$db_selected = mysql_select_db( $ini_db , $link );
		print('<font color="blue">接続OK</font>');
	}


	mysql_close( $link );

?>
</body>
</html>
