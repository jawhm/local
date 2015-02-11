<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>delsent</title>
<style type="text/css">
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
}
</style>
</head>
<body bgcolor="white">

<?php

	// エラーフラグ、正常：0、異常：1
	$err_flg = 0;
	// 登録件数用カウント
	$all_cnt = 0;

	// 開始日時取得
	$start_time = date( "Y/m/d H:i:s", time() );
	print "[".$start_time."] start<br><br>";

	// DB接続
	$link = mysql_connect('localhost', 'mail_list', 'r2d2c3po303pittst');
	if (!$link) {
		$error = mysql_error();
		print('接続失敗です。'.mysql_error());
		$err_flg = 1;
	}

	mysql_query("SET NAMES utf8",$link); //クエリの文字コードを設定

	// データベースを選択する
	if($err_flg == 0){
		$sdb = mysql_select_db("mail_list", $link);
		if(!$sdb){
			$error = mysql_error();
			print("<p>データベースの選択に失敗しました。</p>");
			$err_flg = 1;
		}
	}

	ob_flush();
	flush();


	//*** DB切断(ODBC) ***
	try {
		$db = NULL;
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	// 使用した配列を初期化
	$seq 		= array();
	$email 	= array();
	$kyoten = array();
	$namae 	= array();
	$url	 	= array();
	$ptnid	= array();

	// 終了日時取得
	$end_time = date( "Y/m/d H:i:s", time() );
/*
	mb_language("Japanese");
	mb_internal_encoding("UTF-8");

	$to		 = "meminfo@jawhm.or.jp";
	$title = "【ステップ登録】「メアド情報送信」";
	$main	 = "開始日時：".$start_time."\r\n";
	$main	.= "終了日時：".$end_time."\r\n";
	$main	.= "処理件数：".$all_cnt."件\r\n";
	$main	.= "エラー　：";
	if($err_flg == 0){
		$main .= "なし";
	}else{
		$main .= $error;
	}

	$from	 = "From: ptndelb_log";

	if (!mb_send_mail($to, $title, $main, $from)) {
		print "<p>メールの送信に失敗しました。</p>";
	}
*/
	print "<br>[".$end_time."] end";

	function wbsRequest($url, $params){
		$data = http_build_query($params);
		$content = file_get_contents($url.'?'.$data);
		return $content;
	}

?>


</body>
</html>

