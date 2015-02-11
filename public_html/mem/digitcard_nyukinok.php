<?
function wbsRequest($url, $params)
{
	$data = http_build_query($params);
	$content = file_get_contents($url.'?'.$data);
	return $content;
}

function getRandomString($nLengthRequired = 8){
    $sCharList = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
    mt_srand();
    $sRes = "";
    for($i = 0; $i < $nLengthRequired; $i++)
        $sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
    return $sRes;
}


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
	$seq = @$_GET['SEQ'];
	if ($seq == '')		{ $seq = @$_POST['SEQ']; }
	$date = @$_GET['DATE'];
	if ($date == '')	{ $date = @$_POST['DATE']; }
	$time = @$_GET['TIME'];
	if ($time == '')	{ $time = @$_POST['TIME']; }
	$sid = @$_GET['SID'];
	if ($sid == '')		{ $sid = @$_POST['SID']; }
	$kingaku = @$_GET['KINGAKU'];
	if ($kingaku == '')	{ $kingaku = @$_POST['KINGAKU']; }
	$cvs = @$_GET['CVS'];
	if ($cvs == '')		{ $cvs = @$_POST['CVS']; }
	$scode = @$_GET['SCODE'];
	if ($scode == '')	{ $scode = @$_POST['SCODE']; }
	$fuka = @$_GET['FUKA'];
	if ($fuka == '')	{ $fuka = @$_POST['FUKA']; }

	// 社内通知
	$mailadd = 'meminfo@jawhm.or.jp';
	$subject = "【クレジットカード決済通知】 会員番号 : ".$fuka;
	$body  = '';
	$body .= 'クレジットカードでの決済を受信しました。';
	$body .= chr(10);
	$body .= chr(10);
	$body .= '通知番号：'.$seq;
	$body .= chr(10);
	$body .= '入金日：'.$date;
	$body .= chr(10);
	$body .= '入金時刻：'.$time;
	$body .= chr(10);
	$body .= 'SID：'.$sid;
	$body .= chr(10);
	$body .= '金額：'.$kingaku;
	$body .= chr(10);
	$body .= '決済方法：'.$cvs;
	$body .= chr(10);
	$body .= '店コード：'.$scode;
	$body .= chr(10);
	$body .= '付加情報：'.$fuka;
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
	$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
	mb_send_mail($mailadd,$subject,$body,"From:".$from);

//	if ($ip == '210.164.6.67' || $ip == '202.221.139.50' || $ip == '218.226.200.164' || $ip == '111.171.250.204' )	{
		// 会員情報読み込み
		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$stt = $db->prepare('SELECT id, email, namae, furigana, tel, pcode, add1, add2, add3, state, orderid FROM memlist WHERE id = "'.$fuka.'" ');
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
				$dat_orderid = $row['orderid'];
			}
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		if ($dat_state == '1' || ( $dat_state == '5' && $dat_orderid == ''))	{
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');

				// 決済ＯＫ時
				$stt = $db->prepare('UPDATE memlist SET state = "5", orderid = "'.$cvs.'-'.$date.$time.'-'.$seq.'", indate = "'.date('Y/m/d').'", orderdate = "'.date('Y/m/d H:i:s').'", upddate = "'.date('Y/m/d H:i:s').'" WHERE id = "'.$fuka.'" ');

				// 支払完了メールを送信
				$subject = "登録料のお支払ありがとうございました。";
				$body  = '';
				$body .= $dat_namae.'様';
				$body .= chr(10);
				$body .= chr(10);
				$body .= '日本ワーキングホリデー協会です。';
				$body .= chr(10);
				$body .= chr(10);
				$body .= 'クレジットカード決済による登録料のお支払が確認できました。ありがとうございます。';
				$body .= chr(10);
				$body .= '会員証についきましては、ご登録頂きましたご住所宛てにお送りします。';
				$body .= chr(10);
				$body .= chr(10);
				$body .= '';
				$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
				mb_send_mail($dat_email,$subject,$body,"From:".$from);

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

				$stt->execute();


				// ＣＲＭに転送
				$stt = $db->prepare('SELECT id, email, namae, furigana, gender, birth, year(birth) as yy, month(birth) as mm, day(birth) as dd, pcode, add1, add2, add3, tel, state, indate, mailsend, orderid, orderdate, crmid, crmdate, job, country, gogaku, purpose, know, kyoten FROM memlist WHERE id = "'.$dat_id.'"');
				$stt->execute();
				$idx = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_id = $row['id'];
					$cur_email = $row['email'];
					$cur_namae = $row['namae'];
					$cur_furigana = $row['furigana'];
					$cur_gender = $row['gender'];
					$cur_birth = $row['birth'];
					$cur_pcode = $row['pcode'];
					$cur_add1 = $row['add1'];
					$cur_add2 = $row['add2'];
					$cur_add3 = $row['add3'];
					$cur_tel = $row['tel'];
					$cur_mailsend = $row['mailsend'];
					$cur_state = $row['state'];
					$cur_indate = $row['indate'];
					$cur_orderid = $row['orderid'];
					$cur_orderdate = $row['orderdate'];
					$cur_crmid = $row['crmid'];
					$cur_crmdate = $row['crmdate'];
					$cur_job = $row['job'];
					$cur_country = $row['country'];
					$cur_gogaku = $row['gogaku'];
					$cur_purpose = $row['purpose'];
					$cur_know = $row['know'];
					$cur_kyoten = $row['kyoten'];
				}

				$data = array(
						 'pwd' => '303pittST'
						,'act' => 'member'
						,'edit_id' => $cur_id
						,'edit_sbt' => $cur_kyoten
						,'edit_email' => $cur_email
						,'edit_namae' => $cur_namae
						,'edit_furigana' => $cur_furigana
						,'edit_gender' => $cur_gender
						,'edit_birth' => $cur_birth
						,'edit_pcode' => $cur_pcode
						,'edit_add1' => $cur_add1
						,'edit_add2' => $cur_add2
						,'edit_add3' => $cur_add3
						,'edit_tel' => $cur_tel
						,'edit_job' => $cur_job
						,'edit_country' => $cur_country
						,'edit_gogaku' => $cur_gogaku
						,'edit_purpose' => $cur_purpose
						,'edit_know' => $cur_know
						,'edit_indate' => $cur_indate
						,'edit_orderid' => $cur_orderid
						,'edit_kyoten' => $cur_kyoten
						);

				$url = 'https://toratoracrm.com/crm/';
				$val = wbsRequest($url, $data);
				$ret = json_decode($val, true);

				$customid = '';
				if ($ret['result'] == 'OK')	{
					// OK
					$customid = $ret['customid'];
				}

				// 会員情報更新
				$sql  = 'UPDATE memlist SET ';
				$sql .= '  crmid = "'.$customid.'"';
				$sql .= ', crmdate = "'.date('Y/m/d H:i:s').'"';
				$sql .= ' WHERE id = "'.$cur_id.'"';
				$stt = $db->prepare($sql);
				$stt->execute();

				// メーリングリスト追加
				if ($cur_email <> '' && $cur_mailsend == '1' )	{
					$stt = $db->prepare('SELECT vmail FROM maillist WHERE vmail = "'.$cur_email.'"');
					$stt->execute();
					$idx = 0;
					while($row = $stt->fetch(PDO::FETCH_ASSOC)){
						$idx++;
						$vmail = $row['vmail'];
					}

					// JW削除
					$sql  = 'DELETE FROM maillist ';
					$sql .= ' WHERE vmail = "'.$cur_email.'"';
					$sql .= ' AND vtype = "jw"';
					$stt = $db->prepare($sql);
					$stt->execute();

					// 新規登録
					$sql  = 'INSERT INTO maillist (';
					$sql .= ' vtype, vmail, vname1, vname2, cdate, udate, vsend, vstat, vcheck, vid ';
					$sql .= ') VALUES (';
					$sql .= ' :vtype, :vmail, :vname1, :vname2, :cdate, :udate, :vsend, :vstat, :vcheck, :vid ';
					$sql .= ')';
					$stt2 = $db->prepare($sql);
					$stt2->bindValue(':vtype'	, 'jw');
					$stt2->bindValue(':vmail'	, $cur_email);
					$stt2->bindValue(':vname1'	, $cur_namae);
					$stt2->bindValue(':vname2'	, $cur_id);
					$stt2->bindValue(':cdate'	, date('Y/m/d'));
					$stt2->bindValue(':udate'	, date('Y/m/d'));
					$stt2->bindValue(':vsend'	, '1');
					$stt2->bindValue(':vstat'	, '登録');
					$stt2->bindValue(':vcheck'	, getRandomString(14));
					$stt2->bindValue(':vid'		, $customid);
					$stt2->execute();
				}

				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}

		}else{

			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$stt = $db->prepare('SELECT sendid, amount, namae, youto, paydate, memo FROM card WHERE sendid = "'.$fuka.'" ');
				$stt->execute();
				$idx = 0;
				$dat_state = '';
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_sendid = $row['sendid'];
					$cur_amount = $row['amount'];
					$cur_namae = $row['namae'];
					$cur_youto = $row['youto'];
					$cur_memo = $row['memo'];
					$cur_paydate = $row['paydate'];
				}

				if ($idx > 0)	{
					// 支払情報更新
					$stt = $db->prepare('UPDATE card SET paydate = "'.date('Y/m/d H:i:s').'" WHERE sendid = "'.$fuka.'" ');
					$stt->execute();

					// 支払完了メールを送信
					$subject = "カードマニュアル決済を受け付けました";
					$body  = '';
					$body .= chr(10);
					$body .= 'クレジットカードのマニュアル決済を受け付けました。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= '決済番号：'.$cur_sendid;
					$body .= chr(10);
					$body .= '決済金額：'.$cur_amount;
					$body .= chr(10);
					$body .= 'お名前：'.$cur_namae;
					$body .= chr(10);
					$body .= '適用：'.$cur_youto;
					$body .= chr(10);
					$body .= 'メモ：'.$cur_memo;
					$body .= chr(10);
					$body .= chr(10);
					$body .= '';
					$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
					mb_send_mail("info@jawhm.or.jp",$subject,$body,"From:".$from);

				}else{

					// ２重引落の可能性あり。
					$subject = "カード決済がありましたが、２重引落の可能性があります。";
					$body  = '';
					$body .= chr(10);
					$body .= '以下の情報について、カード決済がありましたが、２重引落の可能性があります。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= '通知番号：'.$seq;
					$body .= chr(10);
					$body .= '入金日：'.$date;
					$body .= chr(10);
					$body .= '入金時刻：'.$time;
					$body .= chr(10);
					$body .= 'SID：'.$sid;
					$body .= chr(10);
					$body .= '金額：'.$kingaku;
					$body .= chr(10);
					$body .= '決済方法：'.$cvs;
					$body .= chr(10);
					$body .= '店コード：'.$scode;
					$body .= chr(10);
					$body .= '付加情報：'.$fuka;
					$body .= chr(10);
					$body .= '';
					$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
					mb_send_mail("info@jawhm.or.jp",$subject,$body,"From:".$from);

				}

				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}

		}
//	}

	header("Content-Type: text/plain; charset=Shift_JIS");
	print "0\r\n";

?>
