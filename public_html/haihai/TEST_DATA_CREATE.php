<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>ptn2</title>
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
/*
		$fp = fopen("./tmp/dummy.csv", "r");
		$fp2 = fopen("./tmp/original_data.csv", "a");

		$csv_header .= "\"mdptn\",\"email\",\"kyoten\",\"namae\",\"url\",\"ptnid\",\"insdate\",\"sent\",\"sentdate\"\r\n";
		$csv_header  = mb_convert_encoding($csv_header, "SJIS", "UTF-8");
		fwrite($fp2, $csv_header);

		$i = 0;
		while( ($str = fgets($fp)) !== false ){
			if($i != 0){
				$data = mb_convert_encoding($str, "UTF-8", "SJIS");
				$data = explode(",", $data);
				$name = $data[0];
				$mail = substr( $data[1], 0, (strlen($data[1])-1) );

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '10', '".$mail."', 'jw', '".$name."', 'http://test_data/sample/test_no_".$i."', NULL, '2012-11-28 18:50:00', 0, NULL)";
print $mail."<br>";
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$main  = "\"10\",\"". $mail ."\",\"jw\",\"". $name ."\",\"http://test_data/sample/test_no_".$i."\"";
				$main .= ",\"\",\"2012-11-28 18:50:00\",\"0\",\"\"\r\n";
				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);
			}
			$i++;
		}


		$fp = fopen("./tmp/dummy2.csv", "r");

		$i = 0;
		while( ($str = fgets($fp)) !== false ){
			if($i != 0){
				$data = mb_convert_encoding($str, "UTF-8", "SJIS");
				$data = explode(",", $data);
				$name = $data[0];
				$mail = substr( $data[1], 0, (strlen($data[1])-1) );

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '20', '".$mail."', NULL, NULL, NULL, NULL, '2012-11-28 18:50:00', 0, NULL)";
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$main  = "\"20\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"2012-11-28 18:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";
				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);
			}
			$i++;
		}


		$fp = fopen("./tmp/dummy3.csv", "r");

		$i = 0;
		while( ($str = fgets($fp)) !== false ){
			if($i != 0){
				$data = mb_convert_encoding($str, "UTF-8", "SJIS");
				$data = explode(",", $data);
				$name = $data[0];
				$mail = substr( $data[1], 0, (strlen($data[1])-1) );

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '30', '".$mail."', NULL, NULL, NULL, '7', '2012-11-28 18:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '30', '".$mail."', NULL, NULL, NULL, '3', '2012-11-28 18:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '30', '".$mail."', NULL, NULL, NULL, '2', '2012-11-28 18:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '30', '".$mail."', NULL, NULL, NULL, '5', '2012-11-28 18:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$main  = "\"30\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"7\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";

				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);

				$main  = "\"30\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"3\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";

				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);

				$main  = "\"30\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"2\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";

				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);

				$main  = "\"30\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"5\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";

				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);
			}
			$i++;
		}


		$fp = fopen("./tmp/dummy4.csv", "r");

		$i = 0;
		while( ($str = fgets($fp)) !== false ){
			if($i != 0){
				$data = mb_convert_encoding($str, "UTF-8", "SJIS");
				$data = explode(",", $data);
				$name = $data[0];
				$mail = substr( $data[1], 0, (strlen($data[1])-1) );

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '40', '".$mail."', NULL, NULL, NULL, '7', '2012-11-28 18:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '40', '".$mail."', NULL, NULL, NULL, '3', '2012-11-28 18:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '40', '".$mail."', NULL, NULL, NULL, '2', '2012-11-28 18:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '40', '".$mail."', NULL, NULL, NULL, '5', '2012-11-28 18:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$main1  = "\"40\"";
				$main1 .= ",\"".$mail."\"";
				$main1 .= ",\"\"";
				$main1 .= ",\"\"";
				$main1 .= ",\"\"";
				$main1 .= ",\"7\"";
				$main1 .= ",\"2012-11-28 18:50:00\"";
				$main1 .= ",\"0\"";
				$main1 .= ",\"\"\r\n";

				$main1  = mb_convert_encoding($main1, "SJIS", "UTF-8");
				fwrite($fp2, $main1);

				$main2  = "\"40\"";
				$main2 .= ",\"".$mail."\"";
				$main2 .= ",\"\"";
				$main2 .= ",\"\"";
				$main2 .= ",\"\"";
				$main2 .= ",\"3\"";
				$main2 .= ",\"2012-11-28 18:50:00\"";
				$main2 .= ",\"0\"";
				$main2 .= ",\"\"\r\n";

				$main2  = mb_convert_encoding($main2, "SJIS", "UTF-8");
				fwrite($fp2, $main2);

				$main3  = "\"40\"";
				$main3 .= ",\"".$mail."\"";
				$main3 .= ",\"\"";
				$main3 .= ",\"\"";
				$main3 .= ",\"\"";
				$main3 .= ",\"2\"";
				$main3 .= ",\"2012-11-28 18:50:00\"";
				$main3 .= ",\"0\"";
				$main3 .= ",\"\"\r\n";

				$main3  = mb_convert_encoding($main3, "SJIS", "UTF-8");
				fwrite($fp2, $main3);

				$main4  = "\"40\"";
				$main4 .= ",\"".$mail."\"";
				$main4 .= ",\"\"";
				$main4 .= ",\"\"";
				$main4 .= ",\"\"";
				$main4 .= ",\"5\"";
				$main4 .= ",\"2012-11-28 18:50:00\"";
				$main4 .= ",\"0\"";
				$main4 .= ",\"\"\r\n";

				$main4  = mb_convert_encoding($main4, "SJIS", "UTF-8");
				fwrite($fp2, $main4);
			}
			$i++;
		}
*/





		$fp2 = fopen("./tmp/original_data.csv", "a");

		$csv_header .= "\"seq\",\"mdptn\",\"email\",\"kyoten\",\"namae\",\"url\",\"ptnid\",\"insdate\",\"sent\",\"sentdate\"\r\n";
		$csv_header  = mb_convert_encoding($csv_header, "SJIS", "UTF-8");
		fwrite($fp2, $csv_header);

		$fp = fopen("./tmp/900_dummy4.csv", "r");

		$i = 0;
		while( ($str = fgets($fp)) !== false ){
			if($i != 0){
				$data = mb_convert_encoding($str, "UTF-8", "SJIS");
				$data = explode(",", $data);
				$name = $data[0];
				$mail = substr( $data[1], 0, (strlen($data[1])-1) );

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '40', '".$mail."', NULL, NULL, NULL, '7', '2012-11-28 11:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '40', '".$mail."', NULL, NULL, NULL, '3', '2012-11-28 11:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '40', '".$mail."', NULL, NULL, NULL, '2', '2012-11-28 11:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '40', '".$mail."', NULL, NULL, NULL, '5', '2012-11-28 11:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$main  = "\"".$i."\"";
				$main .= ",\"40\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"7\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";

				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);

				$main  = "\"".$i."\"";
				$main .= ",\"40\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"3\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";

				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);

				$main  = "\"".$i."\"";
				$main .= ",\"40\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"2\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";

				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);

				$main  = "\"".$i."\"";
				$main .= ",\"40\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"5\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";

				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);
			}
			$i++;
		}
		fclose($fp);


		$fp = fopen("./tmp/900_dummy3.csv", "r");

		$i = 0;
		while( ($str = fgets($fp)) !== false ){
			if($i != 0){
				$data = mb_convert_encoding($str, "UTF-8", "SJIS");
				$data = explode(",", $data);
				$name = $data[0];
				$mail = substr( $data[1], 0, (strlen($data[1])-1) );

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '30', '".$mail."', NULL, NULL, NULL, '7', '2012-11-28 11:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '30', '".$mail."', NULL, NULL, NULL, '3', '2012-11-28 11:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '30', '".$mail."', NULL, NULL, NULL, '2', '2012-11-28 11:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '30', '".$mail."', NULL, NULL, NULL, '5', '2012-11-28 11:50:00', 0, NULL)";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$main  = "\"".$i."\"";
				$main .= ",\"30\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"7\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";

				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);

				$main  = "\"".$i."\"";
				$main .= ",\"30\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"3\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";

				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);

				$main  = "\"".$i."\"";
				$main .= ",\"30\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"2\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";

				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);

				$main  = "\"".$i."\"";
				$main .= ",\"30\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"5\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";

				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);
			}
			$i++;
		}
		fclose($fp);


		$fp = fopen("./tmp/900_dummy2.csv", "r");

		$i = 0;
		while( ($str = fgets($fp)) !== false ){
			if($i != 0){
				$data = mb_convert_encoding($str, "UTF-8", "SJIS");
				$data = explode(",", $data);
				$name = $data[0];
				$mail = substr( $data[1], 0, (strlen($data[1])-1) );

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '20', '".$mail."', NULL, NULL, NULL, NULL, '2012-11-28 11:50:00', 0, NULL)";
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$main  = "\"".$i."\"";
				$main .= ",\"20\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";
				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);
			}
			$i++;
		}
		fclose($fp);

		$fp = fopen("./tmp/900_dummy.csv", "r");

		$i = 0;
		while( ($str = fgets($fp)) !== false ){
			if($i != 0){
				$data = mb_convert_encoding($str, "UTF-8", "SJIS");
				$data = explode(",", $data);
				$name = $data[0];
				$mail = substr( $data[1], 0, (strlen($data[1])-1) );

				$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
				$sql .= "VALUES(NULL, '10', '".$mail."', 'jw', '".$name."', 'http://test_data/sample/test_no_".$i."', NULL, '2012-11-28 11:50:00', 0, NULL)";
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}

				$main  = "\"".$i."\"";
				$main .= ",\"10\"";
				$main .= ",\"".$mail."\"";
				$main .= ",\"jw\"";
				$main .= ",\"".$name."\"";
				$main .= ",\"http://test_data/sample/test_no_".$i."\"";
				$main .= ",\"\"";
				$main .= ",\"2012-11-28 11:50:00\"";
				$main .= ",\"0\"";
				$main .= ",\"\"\r\n";
				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);
			}
			$i++;
		}
		fclose($fp);








/*
		// haihai 全件出力
		$fp = fopen("./tmp/original_data.csv", "w");

		$csv_header .= "\"seq\",\"mdptn\",\"email\",\"kyoten\",\"namae\",\"url\",\"ptnid\",\"insdate\",\"sent\",\"sentdate\"\r\n";
		$csv_header  = mb_convert_encoding($csv_header, "SJIS", "UTF-8");
		fwrite($fp, $csv_header);

		$sql = "SELECT seq, mdptn, email,kyoten, namae, url, ptnid, insdate, sent, sentdate FROM haihai ORDER BY seq";
		$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
		$result = mysql_query($sql, $link);

		if(!$result){
			$error = mysql_error();
			print("クエリの送信に失敗しました。<br />SQL:".$sql);
			$err_flg = 1;
		}else{
			while ($row = mysql_fetch_assoc($result)) {
				$main  = "\"".$row['seq']."\"";
				$main .= ",\"".$row['mdptn']."\"";
				$main .= ",\"".$row['email']."\"";
				$main .= ",\"".$row['kyoten']."\"";
				$main .= ",\"".$row['namae']."\"";
				$main .= ",\"".$row['url']."\"";
				$main .= ",\"".$row['ptnid']."\"";
				$main .= ",\"".$row['insdate']."\"";
				$main .= ",\"".$row['sent']."\"";
				$main .= ",\"".$row['sentdate']."\"\r\n";

				$main  = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp, $main);
			}

			//結果保持用メモリを開放する
			mysql_free_result($result);
		}
*/
/*
		// mdptn10
		$i = 0;
		while($i<901){
			$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
			$sql .= "VALUES(NULL, '10', 'mdptn10_test".$i."@axd.co.jp', 'te', '".$i."', 'http://test_".$i."', NULL, '2012-11-27 15:20:00', 0, NULL)";
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
				break;
			}

			$i++;
		}

		// mdptn20
		$i = 0;
		while($i<901){
			$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
			$sql .= "VALUES(NULL, '20', 'mdptn20_test".$i."@axd.co.jp', NULL, NULL, NULL, NULL, '2012-11-27 15:20:00', 0, NULL)";
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
				break;
			}

			$i++;
		}

		// mdptn30
		$i = 0;
		while($i<0){
			$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
			$sql .= "VALUES(NULL, '30', 'mdptn30_test".$i."@axd.co.jp', NULL, NULL, NULL, '7', '2012-11-27 15:20:00', 0, NULL)";
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
				break;
			}

			$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
			$sql .= "VALUES(NULL, '30', 'mdptn30_test".$i."@axd.co.jp', NULL, NULL, NULL, '3', '2012-11-27 15:20:00', 0, NULL)";
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
				break;
			}

			$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
			$sql .= "VALUES(NULL, '30', 'mdptn30_test".$i."@axd.co.jp', NULL, NULL, NULL, '2', '2012-11-27 15:20:00', 0, NULL)";
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
				break;
			}

			$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
			$sql .= "VALUES(NULL, '30', 'mdptn30_test".$i."@axd.co.jp', NULL, NULL, NULL, '5', '2012-11-27 15:20:00', 0, NULL)";
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
				break;
			}

			$i++;
		}

		// mdptn40
		$i = 0;
		while($i<901){
			$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
			$sql .= "VALUES(NULL, '40', 'mdptn40_test".$i."@axd.co.jp', NULL, NULL, NULL, '7', '2012-11-27 15:20:00', 0, NULL)";
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
				break;
			}

			$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
			$sql .= "VALUES(NULL, '40', 'mdptn40_test".$i."@axd.co.jp', NULL, NULL, NULL, '3', '2012-11-27 15:20:00', 0, NULL)";
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
				break;
			}

			$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
			$sql .= "VALUES(NULL, '40', 'mdptn40_test".$i."@axd.co.jp', NULL, NULL, NULL, '2', '2012-11-27 15:20:00', 0, NULL)";
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
				break;
			}

			$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
			$sql .= "VALUES(NULL, '40', 'mdptn40_test".$i."@axd.co.jp', NULL, NULL, NULL, '5', '2012-11-27 15:20:00', 0, NULL)";
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
				break;
			}
			$i++;
		}
*/
	}


	// 終了日時取得
	$end_time = date( "Y/m/d H:i:s", time() );

	$close_flag = mysql_close($link);

	print "<br>[".$end_time."] end";

	function wbsRequest($url, $params){
		$data = http_build_query($params);
		$content = file_get_contents($url.'?'.$data);
		return $content;
	}

?>


</body>
</html>

