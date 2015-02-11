<?php

// 一般メニュー読み込み
require 'php/fnc_menu.php';

set_time_limit(0);

if (count($param) > 2) {
	$data_param = $param[2];
}else{
	$data_param = 'main';
}

switch ($data_param)	{
	case "main":
		// 一括メール送信
		try {
			$stt = $db->prepare('SELECT count(*) FROM mail_queue');
			$stt->execute();
			$idx = 0;
			$cnt = 0;
			while($row = $stt->fetch(PDO::FETCH_NUM)){
				$cnt = $row[0];
			}
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		$body_title[] .= 'メール送信状況';
		$body[] .= '
			メール送信待ち件数　：　'.$cnt.' 件　　（'.date('H:i:s').'現在）
			　　<input type="button" value="再表示" onclick="location.reload();">
		';
		$body_title[] .= '送信先選択';
		$body[] .= '
			一括メールの送信先を選択してください<br/>
			&nbsp;<br/>
			　　==>　<a href="'.$url_base.'main/mail/kt_ippan">協会メール会員宛</a><br/>
			&nbsp;<br/>
			　　==>　<a href="'.$url_base.'main/mail/se">セミナー予約者宛</a><br/>
			&nbsp;<br/>
			　　==>　<a href="'.$url_base.'main/mail/jw">メンバー登録済み顧客宛</a><br/>
			&nbsp;<br/>
			　　==>　<a href="'.$url_base.'main/mail/kt">求職外国人宛</a><br/>
			&nbsp;<br/>
		';
		break;

	case "kt_ippan":
	case "se":
	case "jw":
	case "kt":
	case "tt":

		switch ($data_param)	{
			case "kt_ippan":
				$body_title[] .= '「協会メール会員」宛に一斉メールを送信します';
				break;
			case "se":
				$body_title[] .= '「セミナー予約者」宛に一斉メールを送信します';
				break;
			case "jw":
				$body_title[] .= '「メンバー登録済み顧客」宛に一斉メールを送信します';
				break;
			case "kt":
				$body_title[] .= '「求職外語人」宛に一斉メールを送信します';
				break;
			case "tt":
				$body_title[] .= '「テスト」宛に一斉メールを送信します';
				break;
		}

		$body[] .= '
	<form method="POST" action="'.$url_base.'main/mail/send" onsubmit="return(confirm(\'本当に送信しますか？\'));">
		<input type="hidden" name="sendtarget" value="'.$data_param.'">
		件名：<br />
		<input type="text" name="subject" size="80" maxlength="255" /><br />
		本文：<br />
		（自動的に、先頭にお名前が入ります。）<br/>
		<textarea name="body" cols="80" rows="20"></textarea><br />
		署名：<br/>
<textarea name="sig" cols="80" rows="5">
----------
  Japan Association for Working Holiday Makers.
  一般社団法人　日本ワーキング・ホリデー協会
  mail:info@jawhm.or.jp  tel:03-6304-5858
----------
</textarea><br />
		<input type="submit" name="submit" value="　送信　" />
	</form>
		';

		break;

	case "send":
		// 送信処理

		require_once 'Mail/Queue.php';

		$outmsg = '';
		$dbo = array(
			'type' => 'mdb2',
			'dsn' => 'mysqli://mail_list:r2d2c3po303pittst@localhost/mail_list',
			'mail_table' => 'mail_queue'
		);
		$mo = array(
			'driver' => 'smtp',
			'host' => 'localhost',
			'port' => 25,
			'auth' => FALSE
		);
		$sendtarget = fnc_getpost('sendtarget');

		if (@$_POST['subject'] == '' && @$_SESSION['sendstat'] <> 'sending')	{
			$outmsg .= '【エラー】件名が入力されていません。<br/>';
		}
		if (@$_POST['body'] == '' && @$_SESSION['sendstat'] <> 'sending')	{
			$outmsg .= '【エラー】本文が入力されていません。<br/>';
		}

		$mail_subject = @$_POST['subject'];
		$mail_body = @$_POST['body'];
		$mail_sin = @$_POST['sin'];
		$sendmax = 30;
		$limit = 0;

		if ($outmsg == '')	{
			try {

				if (@$_SESSION['sendstat'] <> 'sending' || @$_POST['subject'] <> '')	{
					// 送信予定数をカウント
					$cnt = 0;
					$rs = $db->query('SELECT vmail as email, vname1 as namae , vcheck FROM maillist WHERE vsend = "1" AND vtype = "'.$sendtarget.'" order by vmail ');
					while($row = $rs->fetch(PDO::FETCH_ASSOC)){
						$cnt++;
					}
					$rs->closeCursor();
					$limit = 1;
					$_SESSION['mail_subject'] = $mail_subject;
					$_SESSION['mail_body'] = $mail_body;
					$_SESSION['mail_sin'] = $mail_sin;
					$_SESSION['mail_target'] = $sendtarget;
					$_SESSION['mail_max'] = $cnt;
					$_SESSION['mail_cnt'] = 0;
					$_SESSION['mail_limit'] = 0;
					$_SESSION['sendstat'] = 'sending';

					// 社内通知
					$subject = "【一括メール送信　予約開始】 対象 : ".$sendtarget;
					$senddody  = '';
					$senddody .= '一括メール送信の予約の受付を開始しました。';
					$senddody .= chr(10);
					$senddody .= chr(10);
					$senddody .= '送信予定件数：'.$_SESSION['mail_max'];
					$senddody .= chr(10);
					$senddody .= '送信タイトル：'.$mail_subject;
					$senddody .= chr(10);
					$senddody .= chr(10);
					$senddody .= '送信内容：';
					$senddody .= chr(10);
					$senddody .= $mail_body;
					$senddody .= chr(10);
					$senddody .= chr(10);
					$senddody .= '署名：';
					$senddody .= chr(10);
					$senddody .= $mail_sin;
					$senddody .= '';
                    //$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
                    $from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<j-doi@plate.co.jp>";
                    //mb_send_mail('meminfo@jawhm.or.jp',$subject,$senddody,"From:".$from);
                    mb_send_mail('j-doi@plate.co.jp',$subject,$senddody,"From:".$from);

				}else{

					$mail_subject = $_SESSION['mail_subject'];
					$mail_body = $_SESSION['mail_body'];
					$mail_sin = $_SESSION['mail_sin'];
					$sendtarget = $_SESSION['mail_target'];
					$limit = $_SESSION['mail_limit'];

					$limit = $limit + $sendmax;
					$_SESSION['mail_limit'] = $limit;
				}

				unset($email);
				unset($namae);
				unset($vcheck);

				$email = array();
				$namae = array();
				$vcheck = array();

				$cnt = 0;
				$rs = $db->query('SELECT vmail as email, vname1 as namae , vcheck FROM maillist WHERE vsend = "1" AND vtype = "'.$sendtarget.'" order by vmail limit '.$limit.','.$sendmax.' ');
				while($row = $rs->fetch(PDO::FETCH_ASSOC)){
					$cnt++;
					$email[] = $row['email'];
					$namae[] = $row['namae'];
					$vcheck[] = $row['vcheck'];
				}
				$rs->closeCursor();
				$rs = NULL;

				$q = new Mail_Queue($dbo, $mo);
				for ($idx=0; $idx<count($email); $idx++)	{
					$msg  = '';
					$msg .= chr(10).chr(13);
					$msg .= '---';
					$msg .= chr(10).chr(13);
					$msg .= '◆メール配信の登録内容変更、中止はこちらからお願いします。'.chr(10);
					$msg .= 'http://www.jawhm.or.jp/mail/?u='.$vcheck[$idx].'&m='.md5($email[$idx]);
					$msg .= chr(10).chr(13);
					$msg .= '';

					$headers = array(
                        //'From' => mb_encode_mimeheader('日本ワーキングホリデー協会','ISO-2022-JP').'<info@jawhm.or.jp>',
                        'From' => mb_encode_mimeheader('日本ワーキングホリデー協会','ISO-2022-JP').'<j-doi@plate.co.jp>',
						'To' => mb_encode_mimeheader($namae[$idx],'ISO-2022-JP').'<'.$email[$idx].'>',
						'Subject' => mb_encode_mimeheader($mail_subject, 'ISO-2022-JP'));
					$mime = new Mail_mime();
					$mime->setTXTBody(mb_convert_encoding($namae[$idx].'さん'.chr(10).chr(13).$mail_body.$msg.$mail_sin, 'JIS'));
					$mailbody = $mime->get(array('text_charset'=>'ISO-2022-JP'));
					$headers = $mime->headers($headers);
                    //$q->put('info@jawhm.or.jp', $email[$idx], $headers, $mailbody);
                    $q->put('j-doi@plate.co.jp', $email[$idx], $headers, $mailbody);
				}

				$_SESSION['mail_cnt'] = ($_SESSION['mail_cnt'] + $cnt);
				$outmsg .= '送信予約処理中　： '.$_SESSION['mail_cnt'].' / '.$_SESSION['mail_max'].'<br/>';

			} catch (PDOException $e) {
				$outmsg = $e->getMessage();
			}
		}

		if ($limit == 0)	{
			$outmsg .= '';
		}else{
			if ($limit > $_SESSION['mail_max'])	{
				$outmsg .= '
						送信予約が完了しました！！
						';
				// 送信終了
				$_SESSION['sendstat'] = '';
				// 社内通知
				$subject = "【一括メール送信　予約終了】 対象 : ".$sendtarget;
				$senddody  = '';
				$senddody .= '一括メール送信の予約を受け付けました。';
				$senddody .= chr(10);
				$senddody .= chr(10);
				$senddody .= '送信件数：'.$_SESSION['mail_cnt'];
				$senddody .= chr(10);
				$senddody .= '送信タイトル：'.$mail_subject;
				$senddody .= chr(10);
				$senddody .= chr(10);
				$senddody .= '送信内容：';
				$senddody .= chr(10);
				$senddody .= $mail_body;
				$senddody .= chr(10);
				$senddody .= chr(10);
				$senddody .= '署名：';
				$senddody .= chr(10);
				$senddody .= $mail_sin;
				$senddody .= '';
                //$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
                $from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<j-doi@plate.co.jp>";
                //mb_send_mail('meminfo@jawhm.or.jp',$subject,$senddody,"From:".$from);
                mb_send_mail('j-doi@plate.co.jp',$subject,$senddody,"From:".$from);
			}else{
				$outmsg .= '
					&nbsp;<br/>
					送信処理中です。終了するまで、このＰＣはいじらないでくださいね。<br/>
					<script>
						setTimeout("location.href=\''.$url_base.'main/mail/send\'",2000);
					</script>
				';
			}
		}

		$body_title[] .= '一括メールを送信しました';
		$body[] .= $outmsg;

		break;

	case "card":
		// 決済情報登録
		$body_title[] .= '決済情報登録';
		$body[] .= '
			この機能は、現在使用できません。<br/>
		';

		break;

	case "haihaisend":
		// 配配メール情報更新指示
		$msg = '';

		$msg .= '&nbsp;<br/>';
		$msg .= '&nbsp;<br/>';
		$msg .= '配配メールに登録されている情報の更新を行います。<br/>';
		$msg .= '&nbsp;<br/>';
		$msg .= 'この処理は、通常自動で行われますので、必要な場合以外は実行しないでください。<br/>';
		$msg .= '&nbsp;<br/>';
		$msg .= '<input type="button" value="　　登録　　" onclick="if(confirm(\'配配メールへの登録処理を行います。よろしいですか？\'))location.href=\''.$url_base.'main/mail/haihaisendgo\';">';
		$msg .= '　';
		$msg .= '<input type="button" value="　　削除　　" onclick="if(confirm(\'配配メールへの削除処理を行います。よろしいですか？\'))location.href=\''.$url_base.'main/mail/haihaisenddel\';">';
		$msg .= '&nbsp;<br/>';
		$msg .= '';

		$body_title[] .= '配配メール情報更新';
		$body[] .= $msg;

		break;

	case "haihaisendgo":
		// 配配メール（登録処理）
		$msg = '';
		$data = '';

		try {
			$sql  = "";
			$sql .= "select ";
			$sql .= "  vtype";
			$sql .= " ,vmail";
			$sql .= " ,vname1";
			$sql .= " ,vname2";
			$sql .= " ,vcheck";
			$sql .= " ,vid";
			$sql .= " from maillist";
			$sql .= " where vsend = '1' ";

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
		$csv_file = "/var/www/vhosts/jawhm.or.jp/httpdocs/sendcsv/test.csv";

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

		$body_title[] .= '配配メール情報更新（登録処理）';
		$body[] .= $msg;

		break;

	case "haihaisenddel":
		// 配配メール（削除処理）
		$msg = '';
		$data = '';

		try {
			$sql  = "";
			$sql .= "select ";
			$sql .= "  vtype";
			$sql .= " ,vmail";
			$sql .= " ,vname1";
			$sql .= " ,vname2";
			$sql .= " ,vcheck";
			$sql .= " ,vid";
			$sql .= " from maillist";
			$sql .= " where vsend = '0' ";

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
		$csv_file = "/var/www/vhosts/jawhm.or.jp/httpdocs/sendcsv/test.csv";

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
		$import_type = '1';
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

		$body_title[] .= '配配メール情報更新（削除処理）';
		$body[] .= $msg;

		break;

}


?>