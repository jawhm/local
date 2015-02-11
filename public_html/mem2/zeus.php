<?

	ini_set( "display_errors", "On");

	mb_language("Ja");
	mb_internal_encoding("utf8");

	// セキュリティー情報取得
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$ip = getenv("REMOTE_ADDR");
	$host = getenv("REMOTE_HOST");
	if ($host == null || $host == $ip)
	$host = gethostbyaddr($ip);


	// パラメータ取得
	$result = @$_GET['result'];
	if ($result == '')	{ $result = @$_POST['result']; }
	$clientip = @$_GET['clientip'];
	if ($clientip == '')	{ $clientip = @$_POST['clientip']; }
	$ordd = @$_GET['ordd'];
	if ($ordd == '')	{ $ordd = @$_POST['ordd']; }
	$money = @$_GET['money'];
	if ($money == '')	{ $money = @$_POST['money']; }
	$telno = @$_GET['telno'];
	if ($telno == '')	{ $telno = @$_POST['telno']; }
	$email = @$_GET['email'];
	if ($email == '')	{ $email = @$_POST['email']; }
	$sendid = @$_GET['sendid'];
	if ($sendid == '')	{ $sendid = @$_POST['sendid']; }
	$sendpoint = @$_GET['sendpoint'];
	if ($sendpoint == '')	{ $sendpoint = @$_POST['sendpoint']; }

	// 社内通知
	$mailadd = 'meminfo@jawhm.or.jp';
	$subject = "【ZEUS決済通知】 会員番号 : ".$sendid;
	$body  = '';
	$body .= 'クレジットカードでの決済を受信しました。';
	$body .= chr(10);
	$body .= chr(10);
	$body .= '結果コード：'.$result;
	$body .= chr(10);
	$body .= 'Client ID：'.$clientip;
	$body .= chr(10);
	$body .= 'オーダーID：'.$ordd;
	$body .= chr(10);
	$body .= '金額：'.$money;
	$body .= chr(10);
	$body .= '電話番号：'.$telno;
	$body .= chr(10);
	$body .= 'メールアドレス：'.$email;
	$body .= chr(10);
	$body .= '会員番号：'.$sendid;
	$body .= chr(10);
	$body .= '備考：'.$sendpoint;
	$body .= chr(10);
	$body .= chr(10);
	$body .= '---------------------------------------------';
	$body .= chr(10);
	$body .= 'IP：'.$ip;
	$body .= chr(10);
	$body .= 'Host：'.$host;
	$body .= chr(10);
	$body .= 'Agent：'.$agent;
	$body .= chr(10);
	$body .= '';
	$from = mb_encode_mimeheader(mb_convert_encoding('ZEUS決済',"JIS"))."<".$email.">";
	mb_send_mail($mailadd,$subject,$body,"From:".$from);

	if ($result == 'OK')	{
		if ($ip == '210.164.6.67' || $ip == '202.221.139.50' || $ip == '218.226.200.164' || $ip == '111.171.250.204' )	{
			// 会員情報読み込み
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$stt = $db->prepare('SELECT id, email, namae, furigana, tel, pcode, add1, add2, add3, state FROM memlist WHERE id = "'.$sendid.'" ');
				$stt->execute();
				$idx = 0;
				$dat_state = '';
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$dat_id = $row['id'];
					$dat_email = $row['email'];
					$dat_namae = $row['namae'];
					$dat_furigana = $row['furigana'];
					$dat_tel = $row['tel'];
					$dat_pcode = $row['pcode'];
					$dat_add1 = $row['add1'];
					$dat_add2 = $row['add2'];
					$dat_add3 = $row['add3'];
					$dat_state = $row['state'];
				}
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}

			if ($dat_state == '1')	{
				try {
					$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
					$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$db->query('SET CHARACTER SET utf8');
					if ($result == 'OK')	{
						// 決済ＯＫ時
						$stt = $db->prepare('UPDATE memlist SET state = "5", orderid = "'.$ordd.'", indate = "'.date('Y/m/d').'", orderdate = "'.date('Y/m/d H:i:s').'", upddate = "'.date('Y/m/d H:i:s').'" WHERE id = "'.$sendid.'" ');

						if ($sendpoint == 'online')	{
							// 支払完了メールを送信
							$subject = "登録料のお支払ありがとうございました。";
							$body  = '';
							$body .= $dat_namae.'様';
							$body .= chr(10);
							$body .= chr(10);
							$body .= '日本ワーキングホリデー協会です。';
							$body .= chr(10);
							$body .= chr(10);
							$body .= 'クレジットカードによる登録料のお支払が確認できました。ありがとうございます。';
							$body .= chr(10);
							$body .= '会員証についきましては、ご登録頂きましたご住所宛てにお送りします。';
							$body .= chr(10);
							$body .= chr(10);
							$body .= '';
							$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
							mb_send_mail($dat_email,$subject,$body,"From:".$from);
						}
						if ($sendpoint == 'manual')	{
							// 支払完了メールを送信
							$subject = "登録料のお支払ありがとうございました。";
							$body  = '';
							$body .= $dat_namae.'様';
							$body .= chr(10);
							$body .= chr(10);
							$body .= '日本ワーキングホリデー協会です。';
							$body .= chr(10);
							$body .= chr(10);
							$body .= 'クレジットカードにより登録料の決済を行いました。ありがとうございます。';
							$body .= chr(10);
							$body .= chr(10);
							$body .= '';
							$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
							mb_send_mail($dat_email,$subject,$body,"From:".$from);
						}

						// 支払完了メールを送信
						$subject = "【メンバー登録】新規メンバーの登録がありました。 ".$dat_id." ".$dat_namae."様";
						$body  = '';
						$body .= '以下の内容で、メンバー登録がありました。';
						$body .= chr(10);
						$body .= 'メンバーカードを発行してください。';
						$body .= chr(10);
						$body .= chr(10);
						$body .= '会員番号：'.$dat_id;
						$body .= chr(10);
						$body .= 'お名前：'.$dat_namae;
						$body .= chr(10);
						$body .= 'フリガナ：'.$dat_furigana;
						$body .= chr(10);
						$body .= '電話番号：'.$dat_tel;
						$body .= chr(10);
						$body .= '郵便番号：'.$dat_pcode;
						$body .= chr(10);
						$body .= '住所１：'.$dat_add1;
						$body .= chr(10);
						$body .= '住所２：'.$dat_add2;
						$body .= chr(10);
						$body .= '住所３：'.$dat_add3;
						$body .= chr(10);
						$body .= '入会日：'.date('Y/m/d');
						$body .= chr(10);
						$body .= chr(10);
						$body .= '';
						$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
						mb_send_mail("toiawase@jawhm.or.jp",$subject,$body,"From:".$from);

					}else{
						// 決済エラー時
						$stt = $db->prepare('UPDATE memlist SET orderid = "'.$result.'", orderdate = "'.date('Y/m/d H:i:s').'", upddate = "'.date('Y/m/d H:i:s').'" WHERE id = "'.$sendid.'" ');
					}
					$stt->execute();
					$db = NULL;
				} catch (PDOException $e) {
					die($e->getMessage());
				}
			}

			if ($dat_state <> '1' || $idx == 0)	{

				if ( $sendpoint == 'manual')	{

					// 社内通知
					$mailadd = 'meminfo@jawhm.or.jp';
					$subject = "マニュアル決済【ZEUS決済通知】 決済コード : ".$sendid;
					$body  = '';
					$body .= 'クレジットカードでの決済を受信しました。（マニュアル決済）';
					$body .= chr(10);
					$body .= chr(10);
					$body .= 'ユーザステータス：'.$dat_state;
					$body .= chr(10);
					$body .= chr(10);
					$body .= '結果コード：'.$result;
					$body .= chr(10);
					$body .= 'Client ID：'.$clientip;
					$body .= chr(10);
					$body .= 'オーダーID：'.$ordd;
					$body .= chr(10);
					$body .= '金額：'.$money;
					$body .= chr(10);
					$body .= '電話番号：'.$telno;
					$body .= chr(10);
					$body .= 'メールアドレス：'.$email;
					$body .= chr(10);
					$body .= '決済コード：'.$sendid;
					$body .= chr(10);
					$body .= '備考：'.$sendpoint;
					$body .= chr(10);
					$body .= chr(10);
					$body .= '---------------------------------------------';
					$body .= chr(10);
					$body .= 'IP：'.$ip;
					$body .= chr(10);
					$body .= 'Host：'.$host;
					$body .= chr(10);
					$body .= 'Agent：'.$agent;
					$body .= chr(10);
					$body .= '';
					$from = mb_encode_mimeheader(mb_convert_encoding('ZEUS決済',"JIS"))."<".$email.">";
					mb_send_mail($mailadd,$subject,$body,"From:".$from);

					// 支払完了メールを送信
					$subject = "お支払ありがとうございました。";
					$body  = '';
					$body .= chr(10);
					$body .= '日本ワーキングホリデー協会です。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= 'クレジットカード決済を行いました。ありがとうございます。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= 'オーダーID：'.$ordd;
					$body .= chr(10);
					$body .= chr(10);
					$body .= '';
					$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
					mb_send_mail($email,$subject,$body,"From:".$from);

				}else{

					// 社内通知
					$mailadd = 'meminfo@jawhm.or.jp';
					$subject = "異常通知【ZEUS決済通知】 会員番号 : ".$sendid;
					$body  = '';
					$body .= 'クレジットカードでの決済を受信しましたが、ステータスエラーです';
					$body .= chr(10);
					$body .= chr(10);
					$body .= 'ユーザステータス：'.$dat_state;
					$body .= chr(10);
					$body .= chr(10);
					$body .= '結果コード：'.$result;
					$body .= chr(10);
					$body .= 'Client ID：'.$clientip;
					$body .= chr(10);
					$body .= 'オーダーID：'.$ordd;
					$body .= chr(10);
					$body .= '金額：'.$money;
					$body .= chr(10);
					$body .= '電話番号：'.$telno;
					$body .= chr(10);
					$body .= 'メールアドレス：'.$email;
					$body .= chr(10);
					$body .= '会員番号：'.$sendid;
					$body .= chr(10);
					$body .= '備考：'.$sendpoint;
					$body .= chr(10);
					$body .= chr(10);
					$body .= '---------------------------------------------';
					$body .= chr(10);
					$body .= 'IP：'.$ip;
					$body .= chr(10);
					$body .= 'Host：'.$host;
					$body .= chr(10);
					$body .= 'Agent：'.$agent;
					$body .= chr(10);
					$body .= '';
					$from = mb_encode_mimeheader(mb_convert_encoding('ZEUS決済',"JIS"))."<".$email.">";
					mb_send_mail($mailadd,$subject,$body,"From:".$from);

				}

			}
		}
	}

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>日本ワーキング・ホリデー協会</title>
</head>
<body>
<?
	echo 'Agent : '.$agent.'<br/>';
	echo 'IP : '.$ip.'<br/>';
	echo 'Host : '.$host.'<br/>';
?>
Result : <? echo $result; ?><br/>
</body>
</html>
