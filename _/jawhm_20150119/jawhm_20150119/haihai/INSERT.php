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

	// 開始日時取得
	$start_time = date( "Y/m/d H:i:s", time() );
	print "[".$start_time."] start<br>";

	mb_language("Ja");
	mb_internal_encoding("utf8");

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

	// INSERT
	if($err_flg == 0){
		$fp = fopen("./tmp/insert_data.csv", "r");

		$i = 0;
		while( ($str = fgets($fp)) !== false ){
			if($i != 0){
				$data = mb_convert_encoding($str, "UTF-8", "SJIS");
				$data = explode(",", $data);
				$id 			 = str_replace("\"", "", $data[0]);
				$mail			 = str_replace("\"", "", $data[1]);
				$name			 = str_replace("\"", "", $data[2]);
				$number		 = str_replace("\"", "", $data[3]);
				$type			 = str_replace("\"", "", $data[4]);
				$url			 = str_replace("\"", "", $data[5]);

				if(strpos($url, "?u=") === false){
print $id."<br>";
//					$url = "";
				}

				//文字コード設定
				$zzmojicd_sql = "SET NAMES utf8";
				$zzmojicd_result = mysql_query($zzmojicd_sql);

				$sql  = "INSERT INTO Z_DATA(ID, MAIL_ADR, NM, K_NO, KYOTEN_CD, URL)";
				$sql .= " VALUES('".$id."', '".$mail."', '".$name."', '".$number."', '".$type."', '".$url."')";
//				$sql  = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

			}
			$i++;
		}
	}

	fclose($fp);

	// 終了日時取得
	$end_time = date( "Y/m/d H:i:s", time() );

//	$close_flag = mysql_close($link);

	print "<br>[".$end_time."] end";

	function wbsRequest($url, $params){
		$data = http_build_query($params);
		$content = file_get_contents($url.'?'.$data);
		return $content;
	}

?>


</body>
</html>

