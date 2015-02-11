<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>sendhaihai</title>
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
	// 次のmdptnに行くか判断するフラグ
	$next_flg = false;
	// どのmdptnか判断するフラグ
	$mdptn_flg = 0;
	// 登録件数用カウント
	$all_cnt = 0;

	// ファイル名
	$file = "";

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


	//********************************
	// データ取得
	//********************************

	if($err_flg == 0){
		// mdptn10のデータを取得
		$sql = "SELECT seq, kyoten, email, namae, url FROM haihai WHERE mdptn = '10' AND sent = '0' ORDER BY seq";
		$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
		$result = mysql_query($sql, $link);

		if(!$result){
			$error = mysql_error();
			print("クエリの送信に失敗しました。<br />SQL:".$sql);
			$err_flg = 1;
		}else{
			$i = 0;
			while ($row = mysql_fetch_assoc($result)) {
				$seq[$i]		= $row['seq'];
				$kyoten[$i]	= $row['kyoten'];
				$email[$i]	= $row['email'];
				$name[$i]		= $row['namae'];
				$url[$i]		= $row['url'];

				$i++;
			}

			if(count($seq) == 0){
				// データがなければ次のmdptnへ
				$next_flg = true;
			}else{
				// データがあれば処理開始
				$mdptn_flg = 10;
			}

			//結果保持用メモリを開放する
			mysql_free_result($result);
		}

		//*******************************
		// mdptn10のデータがなかった
		//*******************************
		if($next_flg){
			// フラグを折っておく
			$next_flg = false;

			// mdptn20のデータを取得
			$sql = "SELECT seq, email FROM haihai WHERE mdptn = '20' AND sent = '0' ORDER BY seq";
			$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
			}else{
				$i = 0;
				while ($row = mysql_fetch_assoc($result)) {
					$seq[$i]		= $row['seq'];
					$email[$i]	= $row['email'];

					$i++;
				}

				if(count($seq) == 0){
					// データがなければ次のmdptnへ
					$next_flg = true;
				}else{
					// データがあれば処理開始
					$mdptn_flg = 20;
				}

				//結果保持用メモリを開放する
				mysql_free_result($result);
			}
		}

		//*******************************
		// mdptn20のデータがなかった
		//*******************************
		if($next_flg){
			// フラグを折っておく
			$next_flg = false;

			// mdptn30のデータを取得
			$sql = "SELECT seq, email, ptnid FROM haihai WHERE mdptn = '30' AND sent = '0' ORDER BY seq";
			$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
			}else{
				$i = 0;
				while ($row = mysql_fetch_assoc($result)) {
					$seq[$i]		= $row['seq'];
					$email[$i]	= $row['email'];
					$ptnid[$i]	= $row['ptnid'];

					$i++;
				}

				if(count($seq) == 0){
					// データがなければptnidを保存していたファイルを削除
					unlink("./tmp/ptnid30.txt");
					// 次のmdptnへ
					$next_flg = true;
				}else{
					// データがあれば処理開始
					$mdptn_flg = 30;
				}

				//結果保持用メモリを開放する
				mysql_free_result($result);
			}
		}

		//*******************************
		// mdptn30のデータがなかった
		//*******************************
		if($next_flg){
			// フラグを折っておく
			$next_flg = false;

			// mdptn40のデータを取得
			$sql = "SELECT seq, email, ptnid FROM haihai WHERE mdptn = '40' AND sent = '0' ORDER BY seq";
			$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
			}else{
				$i = 0;
				while ($row = mysql_fetch_assoc($result)) {
					$seq[$i]		= $row['seq'];
					$email[$i]	= $row['email'];
					$ptnid[$i]	= $row['ptnid'];

					$i++;
				}

				if(count($seq) == 0){
					// データがなければptnidを保存していたファイルを削除
					unlink("./tmp/ptnid40.txt");
				}else{
					// データがあれば処理開始
					$mdptn_flg = 40;
				}

				//結果保持用メモリを開放する
				mysql_free_result($result);
			}
		}
	}


	//********************************
	// CSV出力、データ更新
	//********************************

	if($err_flg == 0){
		// 使用する日付の取得
		$now_time  = date("Ymd_His");				// 現在日時
		$date			 = date("Y-m-d H:i:s");		// 更新日時
		$step_date = date("Y/m/d");					// ステップ開始日

		//*******************************
		// mdptn10のデータがあった場合
		//*******************************
		if($mdptn_flg == 10){
			// csv出力準備
			$file = "./tmp/mdptn10_".$now_time.".csv";
			$fp = fopen($file, "w");

			$csv_header .= "\"拠点名\",\"メールアドレス\",\"お名前\",\"配信設定URL\"\r\n";
			$csv_header  = mb_convert_encoding($csv_header, "SJIS", "UTF-8");
			fwrite($fp, $csv_header);

			for($i=0; $i<900; $i++){
				if($i == count($seq)){
					break;
				}
				$csv_data = "\"".$kyoten[$i]."\",\"".$email[$i]."\",\"".$name[$i]."\",\"".$url[$i]."\"\r\n";
				$csv_data = mb_convert_encoding($csv_data, "SJIS", "UTF-8");
				fwrite($fp, $csv_data);

				$sql = "UPDATE haihai SET sent = '1', sentdate = '".$date."' WHERE seq = '".$seq[$i]."'";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}
			}

			print "mdptn10を ".$i."件 出力しました。<br>";
			print "あと ".(count($seq)-$i)."件 残っています。<br>";

			$all_cnt = $i;

		//*******************************
		// mdptn20のデータがあった場合
		//*******************************
		}else if($mdptn_flg == 20){
			// csv出力準備
			$file = "./tmp/mdptn20_".$now_time.".csv";
			$fp = fopen($file, "w");

			$csv_header .= "\"メールアドレス\"\r\n";
			$csv_header  = mb_convert_encoding($csv_header, "SJIS", "UTF-8");
			fwrite($fp, $csv_header);

			for($i=0; $i<900; $i++){
				if($i == count($seq)){
					break;
				}
				$csv_data = "\"".$email[$i]."\"\r\n";
				$csv_data = mb_convert_encoding($csv_data, "SJIS", "UTF-8");
				fwrite($fp, $csv_data);

				$sql = "UPDATE haihai SET sent = '1', sentdate = '".$date."' WHERE seq = '".$seq[$i]."'";
				$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
				$result = mysql_query($sql, $link);

				if(!$result){
					$error = mysql_error();
					print("クエリの送信に失敗しました。<br />SQL:".$sql);
					$err_flg = 1;
					break;
				}
			}

			print "mdptn20を ".$i."件 出力しました。<br>";
			print "あと ".(count($seq)-$i)."件 残っています。<br>";

			$all_cnt = $i;

		//*******************************
		// mdptn30のデータがあった場合
		//*******************************
		}else if($mdptn_flg == 30){
			// csv出力準備
			$file = "./tmp/mdptn30_".$now_time.".csv";
			$fp  = fopen($file, "w");

			// ptnidチェック用のtxtファイルを読み込む
			$fp2 = fopen("./tmp/ptnid30.txt", "r");
			$ptnid_chk = fgets($fp2);
			$ptnid_chk = mb_convert_encoding($ptnid_chk, "UTF-8", "SJIS");
			fclose($fp2);

			if($ptnid_chk == NULL || in_array($ptnid_chk, $ptnid) === false){
				// 中身がNULLまたは不一致なら、最初のptnidを書き込む
				$fp2 = fopen("./tmp/ptnid30.txt", "w");
				$main = $ptnid[0];
				$main = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);
				fclose($fp2);
				$pros = $ptnid[0];
			}else{
				$pros = $ptnid_chk;
			}

			$csv_header .= "\"メールアドレス\",\"ステップ開始日\"\r\n";
			$csv_header  = mb_convert_encoding($csv_header, "SJIS", "UTF-8");
			fwrite($fp, $csv_header);

			$cnt	= 0;
			$i		= 0;

			while($i<count($seq)){
				if($pros == $ptnid[$i]){
					if($cnt == 900){
						break;
					}
					
					$csv_data = "\"".$email[$i]."\",\"".$step_date."\"\r\n";
					$csv_data = mb_convert_encoding($csv_data, "SJIS", "UTF-8");
					fwrite($fp, $csv_data);

					$sql  = "UPDATE haihai SET sent = '1', sentdate = '".$date."' WHERE seq = '".$seq[$i]."'";
					$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
					$result = mysql_query($sql, $link);

					if(!$result){
						$error = mysql_error();
						print("クエリの送信に失敗しました。<br />SQL:".$sql);
						$err_flg = 1;
						break;
					}
					$cnt++;
				}
				
				$i++;
			}

			print "mdptn30のptnid：".$pros."を ".$cnt."件 出力しました。<br>";
			print "あと ".(count($seq)-$cnt)."件 残っています。<br>";

			$all_cnt = $cnt;

		//*******************************
		// mdptn40のデータがあった場合
		//*******************************
		}else if($mdptn_flg == 40){
			// csv出力準備
			$file = "./tmp/mdptn40_".$now_time.".csv";
			$fp = fopen($file, "w");

			$csv_header .= "\"メールアドレス\"\r\n";
			$csv_header  = mb_convert_encoding($csv_header, "SJIS", "UTF-8");
			fwrite($fp, $csv_header);

			// ptnidチェック用のtxtファイルを読み込む
			$fp2 = fopen("./tmp/ptnid40.txt", "r");
			$ptnid_chk = fgets($fp2);
			$ptnid_chk = mb_convert_encoding($ptnid_chk, "UTF-8", "SJIS");
			fclose($fp2);

			if($ptnid_chk == NULL || in_array($ptnid_chk, $ptnid) == false){
				// 中身がNULLまたは不一致なら、最初のptnidを書き込む
				$fp2 = fopen("./tmp/ptnid40.txt", "w");
				$main = $ptnid[0];
				$main = mb_convert_encoding($main, "SJIS", "UTF-8");
				fwrite($fp2, $main);
				fclose($fp2);
				$pros = $ptnid[0];
			}else{
				$pros = $ptnid_chk;
			}

			$cnt	= 0;
			$i		= 0;

			while($i<count($seq)){
				if($pros == $ptnid[$i]){
					if($cnt == 900){
						break;
					}
					
					$csv_data = "\"".$email[$i]."\"\r\n";
					$csv_data = mb_convert_encoding($csv_data, "SJIS", "UTF-8");
					fwrite($fp, $csv_data);

					$sql  = "UPDATE haihai SET sent = '1', sentdate = '".$date."' WHERE seq = '".$seq[$i]."'";
					$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");
					$result = mysql_query($sql, $link);

					if(!$result){
						$error = mysql_error();
						print("クエリの送信に失敗しました。<br />SQL:".$sql);
						$err_flg = 1;
						break;
					}
					$cnt++;
				}
				
				$i++;
			}

			print "mdptn40のptnid：".$pros."を ".$cnt."件 出力しました。<br>";
			print "あと ".(count($seq)-$cnt)."件 残っています。<br>";

			$all_cnt = $cnt;

		}else{
			print "データがありませんでした。<br>";
		}
		fclose($fp);
	}

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


	//*******************************************
	// CSV送信処理
	//*******************************************

	// CSV送信
	// アップロード先URL
	$upload_url = 'www.toratoracrm.com/crm/haihaitest/test.php';
	// アカウントID（【例】契約ID [ a0x-24 ] の場合は、"24"。）
	$aid = '303';
	// ユーザID
	$loginid = 'toratoranet';
	// パスワード（外部システム連携接続用パスワード）
	$transport_passwd = '303pittst';
	// CSVファイル（絶対パスでファイルを指定してください。）
	$file = substr($file, 2, strlen($file));
	$csvfile = "/var/www/vhosts/jawhm.or.jp/httpdocs/haihai/".$file;
print $csvfile."<br>";
	// 処理形式（0:登録、1:削除、2:停止、3:禁止、5：可能 のいずれかを指定してください。）
	if($mdptn_flg == 10 || $mdptn_flg == 30){
		$import_type = '0';
	}else if($mdptn_flg == 20 || $mdptn_flg == 40){
		$import_type = '1';
	}
	// 上書きフラグ（0:上書きしない、1:上書きする のいずれかを指定してください。）
	if($mdptn_flg == 10 || $mdptn_flg == 20 || $mdptn_flg == 30){
		$is_overwrite = '1';
	}else if($mdptn_flg == 40){
		$is_overwrite = '0';
	}
	// 配信グループID（配信グループへの処理であれば必須です。）
	$gid = '';
	// ステップメールプランID（ステップメールプランへの処理であれば必須です。）
	$spid = '';

	// レポートメールの送信（0:送信しない、1:送信する、2:エラー時のみ送信 のいずれかを指定してください。）
	$report_option = '1';
	$errno = 0;
	$errstr = 0;

	$postDataArray = array();
	$postDataArray[] = "---attached\r\n";
	$postDataArray[] = "Content-Disposition: form-data; name=\"aid\"\r\n\r\n" . $aid . "\r\n";
	$postDataArray[] = "---attached\r\n";
	$postDataArray[] = "Content-Disposition: form-data; name=\"loginid\"\r\n\r\n" . $loginid . "\r\n";
	$postDataArray[] = "---attached\r\n";
	$postDataArray[] = "Content-Disposition: form-data; name=\"transport_password\"\r\n\r\n" . $transport_passwd . "\r\n";
	$postDataArray[] = "---attached\r\n";
	$postDataArray[] = "Content-Disposition: form-data; name=\"import_type\"\r\n\r\n" . $import_type . "\r\n";
	$postDataArray[] = "---attached\r\n";
	$postDataArray[] = "Content-Disposition: form-data; name=\"is_overwrite\"\r\n\r\n" . $is_overwrite . "\r\n";
	$postDataArray[] = "---attached\r\n";
	$postDataArray[] = "Content-Disposition: form-data; name=\"gid\"\r\n\r\n" . $gid . "\r\n";
	$postDataArray[] = "---attached\r\n";
	$postDataArray[] = "Content-Disposition: form-data; name=\"spid\"\r\n\r\n" . $spid . "\r\n";
	$postDataArray[] = "---attached\r\n";
	$postDataArray[] = "Content-Disposition: form-data; name=\"report_option\"\r\n\r\n" . $report_option . "\r\n";
	$postDataArray[] = "---attached\r\n";
	if(file_exists($csvfile)) {
		$postDataArray[] = "Content-Disposition: form-data; name=\"csvfile\"; filename=\"".$csvfile."\"\r\n";
		$postDataArray[] = "Content-Type: application/octet-stream\r\n\r\n";
		$postDataArray[] = array($csvfile, filesize($csvfile));
		$postDataArray[] = "---attached--\r\n";
	}

	$length = 0;
	foreach($postDataArray as $data) {
		$length += is_array($data) ? $data[1] : strlen($data);
/*
print_r($data);
print "<br>";
print $length."<br><br>";
*/
	}
	$request = "POST /?ac=ScheduleCsvImport HTTP/1.1\r\n";
	$request .= "Host: " . $upload_url . "\r\n";
	$headers = array(
		"Content-Type: multipart/form-data; boundary=-attached",
		"Connection: close",
		"Content-Length: " . $length
	);
	$request .= implode("\r\n", $headers) . "\r\n\r\n";
print $request."<br>";
	$fp = fsockopen('ssl://' . $upload_url, 443, $errno, $errstr, 10);
	if (!$fp) {
		die("接続に失敗しました。\n");
	}
	fputs($fp, mb_convert_encoding($request, 'SJIS', 'UTF-8'));
	foreach($postDataArray as $data){
		if(is_array($data)){
			$fpCsv = fopen($data[0], 'r');
			while(!feof($fpCsv)) {
				fputs($fp, fread($fpCsv, 8192));
			}
			fclose($fpCsv);
			fputs($fp, "\r\n");
		}else{
			fputs($fp, $data);
		}
	}
	$response = "";
	while (!feof($fp)) {
		$response .= fgets($fp, 4096);
	}
	fclose($fp);

	// msg受け取り
	// レスポンスが文字化けする場合は、ご利用の環境にあわせて文字エンコーディングを変換してください。
	$msg .= mb_convert_encoding($response, 'UTF-8', 'UTF-8') . "<br/>";

	// データ削除
/*
	sql			= "DELETE FROM haihai WHERE sent = '1'";
	$sql 		= mb_convert_encoding($sql, "SJIS", "UTF-8");
*/


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

	$from	 = "From: sendhaihai_log";

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

