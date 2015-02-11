<?php

	$msg = '';
	$data = '';

	try {

		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
		$db->query('SET CHARACTER SET utf8');

		$sql  = "";
		$sql .= "select ";
		$sql .= "  vtype";
		$sql .= " ,vmail";
		$sql .= " ,vname1";
		$sql .= " ,vname2";
		$sql .= " ,vcheck";
		$sql .= " ,vid";
		$sql .= " from maillist";
		$sql .= " where vsend = '1' and haihai = 1 ";

		$data[0] = array('拠点名', 'メールアドレス', 'お名前', '配信設定ＵＲＬ');

		$stt = $db->prepare($sql);
		$stt->execute();
		$idx = 0;
		while($row = $stt->fetch(PDO::FETCH_ASSOC)){
			$idx++;
			$cur_vtype = $row['vtype'];
			$cur_vmail = $row['vmail'];
			$cur_vname1 = $row['vname1'];
			$cur_vname2 = $row['vname2'];
			$cur_vcheck = $row['vcheck'];

			$mail_url = 'http://www.jawhm.or.jp/mail/?u='.$cur_vcheck.'&m='.md5($cur_vmail);

			$data[$idx+1] = array($cur_vtype, $cur_vmail, $cur_vname1, $mail_url);
		}
	} catch (PDOException $e) {
		die($e->getMessage());
	}


	// CSVファイル名の設定
	$csv_file = "/var/www/csv/send.csv";

	// CSVデータの作成
	$csv_data = "";
	foreach($data as $key => $value ){
		$field_cnt = 0;
		foreach($value as $csvout)	{
			$field_cnt++;
			$csv_data .= $csvout;
			if (count($value) == $field_cnt)	{
				$csv_data .= "\n";
			}else{
				$csv_data .= ",";
			}
		}
	}
	$fp = fopen($csv_file, 'ab');		// ファイルを追記モードで開く
	flock($fp, LOCK_EX);				// ファイルを排他ロックする
	ftruncate($fp, 0);					// ファイルの中身を空にする
	fwrite($fp, $csv_data);				// データをファイルに書き込む
	fclose($fp);						// ファイルを閉じる


	// ＣＳＶファイルの送信 ------------------------------------------------------------------------------
	// アップロード先URL
	$upload_url = 'a03.hm-f.jp';
	// アカウントID（【例】契約ID [ a0x-24 ] の場合は、"24"。）
	$aid = '303';
	// ユーザID
	$loginid = 'toratoranet';
	// パスワード（外部システム連携接続用パスワード）
	$transport_passwd = '303pittst';
	// CSVファイル（絶対パスでファイルを指定してください。）
	$csvfile = $csv_file;
	// 処理形式（0:登録、1:削除、2:停止、3:禁止、5：可能 のいずれかを指定してください。）
	$import_type = '0';
	// 上書きフラグ（0:上書きしない、1:上書きする のいずれかを指定してください。）
	$is_overwrite = '1';
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
	}
	$request = "POST /?ac=ScheduleCsvImport HTTP/1.1\r\n";
	$request .= "Host: " . $upload_url . "\r\n";
	$headers = array(
		"Content-Type: multipart/form-data; boundary=-attached",
		"Connection: close",
		"Content-Length: " . $length
	);
	$request .= implode("\r\n", $headers) . "\r\n\r\n";
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

	// レスポンスが文字化けする場合は、ご利用の環境にあわせて文字エンコーディングを変換してください。
	$msg .= mb_convert_encoding($response, 'UTF-8', 'UTF-8') . "<br/>";



	$msg .= '<hr/>';
	$msg .= ''.$idx.'件のデータを送信しました。';

	echo $msg;


?>