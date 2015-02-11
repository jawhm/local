<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>data_ins</title>
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

	mb_language("Ja");
	mb_internal_encoding("utf8");

	// 開始日時取得
	$start_time = date( "Y/m/d H:i:s", time() );
	print "[".$start_time."] start<br>";
/*
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
*/
	// INSERT
	if($err_flg == 0){
		$fp  = fopen("./tmp/customer_data_303_0_20121128_152419.csv", "r");
		$fp2 = fopen("./tmp/insert_data.csv", "a");
/*
		$main = "\"ID\",\"メールアドレス\",\"お名前\",\"お客様番号\",\"拠点名\",\"配信設定URL\"\r\n";
		$main = mb_convert_encoding($main, "SJIS", "UTF-8");
		fwrite($fp2, $main);
*/
		$i = 0;
		while( ($str = fgets($fp)) !== false ){
			if($i != 0){
				$data = explode(",", $str);
				$id 			 = $data[0];
				$mail			 = $data[2];
				$name			 = $data[9];
				$number		 = $data[15];
				$type			 = $data[17];
				$url			 = $data[21];

				$main = "\"".$id."\",\"".$mail."\",\"".$name."\",\"".$number."\",\"".$type."\",\"".$url."\"\r\n";
//print $main."<br>";
				$main = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);
			}
			$i++;
		}
	}

	fclose($fp);
	fclose($fp2);

	// 終了日時取得
	$end_time = date( "Y/m/d H:i:s", time() );

//	$close_flag = mysql_close($link);

	print "<br>[".$end_time."] end";
/*
	function wbsRequest($url, $params){
		$data = http_build_query($params);
		$content = file_get_contents($url.'?'.$data);
		return $content;
	}
*/
?>


</body>
</html>

