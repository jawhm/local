#!/usr/bin/php -q
<?php

function getRandomString($nLengthRequired = 8){
    $sCharList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_";
    mt_srand();
    $sRes = "";
    for($i = 0; $i < $nLengthRequired; $i++)
        $sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
    return $sRes;
}

	mb_language("Ja");
	mb_internal_encoding("utf8");

	//PEARのライブラリ読み込み
	require_once('Mail/mimeDecode.php');
	//メールソースを標準入力から読み込み
	$source = file_get_contents("php://stdin");
	if(!$source)
	{
	  echo "fail!\n";
	  exit();
	}
	//メール解析
	$params['include_bodies'] = true;
	$params['decode_bodies']  = true;
	$params['decode_headers'] = true;
	$decoder = new Mail_mimeDecode($source);
	$structure = $decoder->decode($params);
	$from = mb_convert_encoding(mb_decode_mimeheader($structure->headers['from']), mb_internal_encoding(), "auto");
	if( preg_match( '/<([^>]+)>$/', $from, $regs )){ $from=$regs[1]; }
	$sender = strtolower($from);

	$vmail = $sender;
	$vcheck = getRandomString(14);

	try {
		$ok = 1;

		$ini = parse_ini_file('/var/www/vhosts/jawhm.or.jp/bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$sql = 'INSERT INTO maillist(vtype, vmail, vname1, vname2, cdate, udate, vsend, vstat, vcheck, vid) VALUES(:vtype, :vmail, :vname1, :vname2, :cdate, :udate, :vsend, :vstat, :vcheck, :vid)';
		$stt2 = $db->prepare($sql);
		$stt2->bindValue(':vtype', 'kt_ippan');
		$stt2->bindValue(':vmail', $vmail);
		$stt2->bindValue(':vname1', '名無し');
		$stt2->bindValue(':vname2', '');
		$stt2->bindValue(':cdate', date('Y/m/d'));
		$stt2->bindValue(':udate', date('Y/m/d'));
		$stt2->bindValue(':vsend', '0');
		$stt2->bindValue(':vstat', '仮登録');
		$stt2->bindValue(':vcheck', $vcheck);
		$stt2->bindValue(':vid', '00000');
		$stt2->execute();
		$db = NULL;
	} catch (PDOException $e) {
		if ($e->getCode() == 23000)	{
			$ok = 2;
		}else{
			die($e->getMessage());
		}
	}

	if ($ok == 2)	{
		try {
			$ini = parse_ini_file('/var/www/vhosts/jawhm.or.jp/bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$sql = 'UPDATE maillist SET vname1 = :vname1 , vsend = :vsend , vstat = :vstat , vcheck = :vcheck , udate = :udate WHERE vmail = :vmail AND vtype = :vtype';
			$stt2 = $db->prepare($sql);
			$stt2->bindValue(':vtype', 'kt_ippan');
			$stt2->bindValue(':vmail', $vmail);
			$stt2->bindValue(':vname1', '名無し');
			$stt2->bindValue(':vsend', '0');
			$stt2->bindValue(':vstat', '仮登録');
			$stt2->bindValue(':vcheck', $vcheck);
			$stt2->bindValue(':udate', date('Y/m/d'));
			$stt2->execute();
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	$subject = "メール会員登録";

	$body  = '';
	$body .= '日本ワーキングホリデー協会です。';
	$body .= chr(10);
	$body .= 'メール会員に興味を持って頂きありがとうございます。';
	$body .= chr(10);
	$body .= chr(10);
	$body .= 'http://www.jawhm.or.jp/mail/?u='.$vcheck.'&m='.md5($vmail);
	$body .= chr(10);
	$body .= 'のページで登録を行ってください。';
	$body .= chr(10);
	$body .= chr(10);
	$body .= '◆ご注意◆';
	$body .= chr(10);
	$body .= 'まだ、登録は完了していません。必ず、上記URLのページで登録作業を完了してください。';
	$body .= chr(10);
	$body .= chr(10);
	$body .= '◆このメールに覚えが無い場合◆';
	$body .= chr(10);
	$body .= '他の方がメールアドレスを間違えた可能性があります。';
	$body .= chr(10);
	$body .= 'お手数ですが、 info@jawhm.or.jp までご連絡頂ければ幸いです。';
	$body .= chr(10);
	$body .= chr(10);
	$body .= '';

	$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";

	mb_send_mail($vmail,$subject,$body,"From:".$from);

?>
