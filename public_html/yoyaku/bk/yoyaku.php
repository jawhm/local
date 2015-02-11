<?php

function getRandomString($nLengthRequired = 8){
    $sCharList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    mt_srand();
    $sRes = "";
    for($i = 0; $i < $nLengthRequired; $i++)
        $sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
    return $sRes;
}

	ini_set( "display_errors", "On");

	require_once 'googleapi.php';

	mb_language("Ja");
	mb_internal_encoding("utf8");

	$vmail1 = 'meminfo@jawhm.or.jp';
	$vmail2 = 'toiawase@jawhm.or.jp';
	$msg = '';
	$youbi = Array("日","月","火","水","木","金","土");

	$seminarid = @$_POST['セミナー番号'];
	$seminarname = @$_POST['セミナー名'];

	$seminarname = strip_tags($seminarname);
	$seminarname = preg_replace("/<img[^>]+\>/i", "", $seminarname);
	$seminarname = mb_convert_kana($seminarname, "K");

	$namae = @$_POST['お名前'];
	if (@$_POST['お名前2'] <> '' )	{
		$namae .= '　'.@$_POST['お名前2'];
	}
	$furigana = @$_POST['フリガナ'];
	if (@$_POST['フリガナ2'] <> '' )	{
		$furigana .= '　'.@$_POST['フリガナ2'];
	}
	$email = @$_POST['メール'];
	$tel = @$_POST['電話番号'];
	$kyomi = @$_POST['興味国'];
	$jiki = @$_POST['出発時期'];
	$sonota = @$_POST['その他'];
	$dohan = @$_POST['同伴者'];
	$mailmem = @$_POST['メール会員'];

	$ninzu = 0;
	if ($dohan == 'on')	{ $ninzu = 1;	}
	$mailmem = 0;
	if ($mailmem == 'on')	{ $mailmem = 1;	}

	$cur_mailinfo = '';
	if ($seminarid <> '')	{
		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$stt = $db->prepare('SELECT id, place, hiduke, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(hiduke,\'%w\') as yobi, date_format(starttime,\'%k:%i\') as sttime, k_title1, k_desc1, pax, booking, waitting, mailinfo FROM event_list WHERE id = "'.$seminarid.'" ');
			$stt->execute();
			$idx = 0;
			$cur_id = '';
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_place = $row['place'];
				$cur_hiduke = $row['hiduke'];
				$cur_y = $row['y'];
				$cur_m = $row['m'];
				$cur_d = $row['d'];
				$cur_yobi = $row['yobi'];
				$cur_sttime = $row['sttime'];

				$cur_title1 = $row['k_title1'];
				$cur_title1 = strip_tags($cur_title1);
				$cur_title1 = preg_replace("/<img[^>]+\>/i", "", $cur_title1);
				$cur_title1 = mb_convert_kana($cur_title1, "K");

				$cur_desc1 = $row['k_desc1'];
				$cur_desc1 = strip_tags($cur_desc1);
				$cur_desc1 = preg_replace("/<img[^>]+\>/i", "", $cur_desc1);
				$cur_desc1 = mb_convert_kana($cur_desc1, "K");

				$cur_pax = $row['pax'];
				$cur_booking = $row['booking'];
				$cur_waitting = $row['waitting'];

				$cur_mailinfo = $row['mailinfo'];

			}
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		if ($cur_id <> '')	{
			// 予約人数
			$ninzu++;
			$zansu = $cur_pax - $cur_booking;

			// 状況確認
			if ($ninzu <= $zansu)	{
				// 予約可能
				$cur_booking += $ninzu;
				$wait = 0;
			}else{
				// 予約不可
				$cur_waitting += $ninzu;
				$wait = 1;
			}

			// イベント情報更新
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$stt = $db->prepare('UPDATE event_list SET booking = '.$cur_booking.' , waitting = '.$cur_waitting.' WHERE id = "'.$seminarid.'" ');
				$stt->execute();
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}

			// 予約番号採番
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$stt = $db->prepare('SELECT max(id) as maxid FROM entrylist');
				$stt->execute();
				$idx = 0;
				$yoyakuno = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$yoyakuno = $row['maxid'];
				}
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
			$yoyakuno++;

			// ＣＲＭに転送
			$data = array(
				 'pwd' => '303pittST'
				,'act' => 'yoyaku'
				,'edit_namae' => $namae
				,'edit_furigana' => $furigana
				,'edit_tel' => $tel
				,'edit_email' => $email
				,'edit_seminarid' => $seminarid
				,'edit_seminarname' => $seminarname
				,'edit_kyomi' => $kyomi
				,'edit_jiki' => $jiki
				,'edit_sonota' => $sonota
				,'edit_ninzu' => $ninzu
			);

			$url = 'https://toratoracrm.com/crm/';
			$val = wbsRequest($url, $data);
			$ret = json_decode($val, true);

			$customid = '';
			if ($ret['result'] == 'OK')	{
				// OK
				$customid = $ret['customid'];
			}

			// 予約リスト追加
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$sql  = 'INSERT INTO entrylist (';
				$sql .= ' id, seminarid, seminarname, namae, furigana, tel, email, kyomi, jiki, sonota, ninzu, stat, wait, mailstat, customid, insdate, upddate';
				$sql .= ') VALUES (';
				$sql .= ' :id, :seminarid, :seminarname, :namae, :furigana, :tel, :email, :kyomi, :jiki, :sonota, :ninzu, :stat, :wait, :mailstat, :customid, :insdate, :upddate';
				$sql .= ')';
				$stt2 = $db->prepare($sql);
				$stt2->bindValue(':id'		, $yoyakuno);
				$stt2->bindValue(':seminarid'	, $seminarid);
				$stt2->bindValue(':seminarname'	, $seminarname);
				$stt2->bindValue(':namae'	, $namae);
				$stt2->bindValue(':furigana'	, $furigana);
				$stt2->bindValue(':tel'		, $tel);
				$stt2->bindValue(':email'	, $email);
				$stt2->bindValue(':kyomi'	, $kyomi);
				$stt2->bindValue(':jiki'	, $jiki);
				$stt2->bindValue(':sonota'	, $sonota);
				$stt2->bindValue(':ninzu'	, $ninzu);
				$stt2->bindValue(':stat'	, '0');
				$stt2->bindValue(':wait'	, $wait);
				$stt2->bindValue(':mailstat'	, '0');
				$stt2->bindValue(':customid'	, $customid);
				$stt2->bindValue(':insdate'	, date('Y/m/d H:i:s'));
				$stt2->bindValue(':upddate'	, date('Y/m/d H:i:s'));
				$stt2->execute();
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}

			// メーリングリスト追加
			if ($email <> '' && $mailmem == '1' )	{
				try {
					$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
					$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$db->query('SET CHARACTER SET utf8');
					$stt = $db->prepare('SELECT vtype FROM maillist WHERE vmail = "'.$email.'" and ( vtype = "jw" or vtype = "se" ) ');
					$stt->execute();
					$idx = 0;
					$vtype = '';
					while($row = $stt->fetch(PDO::FETCH_ASSOC)){
						$idx++;
						$vtype = $row['vtype'];
					}
					$db = NULL;
				} catch (PDOException $e) {
					die($e->getMessage());
				}

				if ($vtype <> 'jw')	{

					try {
						$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
						$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
						$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$db->query('SET CHARACTER SET utf8');

						if ($idx > 0)	{
							// JW更新
							$sql  = 'UPDATE maillist SET ';
							$sql .= '  vtype = "se"';
							$sql .= ', vsend = "1"';
							$sql .= ', vstat = "登録"';
							$sql .= ', vid = "'.$customid.'"';
							$sql .= ', udate = "'.date('Y/m/d').'"';
							$sql .= ' WHERE vmail = "'.$email.'"';
							$sql .= ' AND vtype = "'.$vtype.'"';
							$stt = $db->prepare($sql);
							$stt->execute();
							$db = NULL;
						}else{
							// 新規登録
							$sql  = 'INSERT INTO maillist (';
							$sql .= ' vtype, vmail, vname1, vname2, cdate, udate, vsend, vstat, vcheck, vid ';
							$sql .= ') VALUES (';
							$sql .= ' :vtype, :vmail, :vname1, :vname2, :cdate, :udate, :vsend, :vstat, :vcheck, :vid ';
							$sql .= ')';
							$stt2 = $db->prepare($sql);
							$stt2->bindValue(':vtype'	, 'se');
							$stt2->bindValue(':vmail'	, $email);
							$stt2->bindValue(':vname1'	, $namae);
							$stt2->bindValue(':vname2'	, '');
							$stt2->bindValue(':cdate'	, date('Y/m/d'));
							$stt2->bindValue(':udate'	, date('Y/m/d'));
							$stt2->bindValue(':vsend'	, '1');
							$stt2->bindValue(':vstat'	, '登録');
							$stt2->bindValue(':vcheck'	, getRandomString(14));
							$stt2->bindValue(':vid'		, $customid);
							$stt2->execute();
							$db = NULL;
						}
					} catch (PDOException $e) {
						die($e->getMessage());
					}
				}
			}


			// 社内通知
			$subject = $namae."様 イベント予約";
			$body  = '';
			$body .= '[無料セミナー予約フォーム]';
			$body .= chr(10);
			foreach($_POST as $post_name => $post_value){
				$body .= chr(10);
				$body .= $post_name." : ".$post_value;
			}
			$body .= chr(10);
			$body .= chr(10);
			$body .= '--------------------------------------';
			$body .= chr(10);
			$body .= 'セミナー番号 ： '.$cur_id;
			$body .= chr(10);
			$body .= 'セミナー名 ： '.$cur_title1;
			$body .= chr(10);
			$body .= '日程 ： '.$cur_hiduke.'  '.$cur_sttime.'開始';
			$body .= chr(10);
			$body .= '開催地 ： '.$cur_place;
			$body .= chr(10);
			$body .= chr(10);
			$body .= '予約状況： '.$cur_booking.' ('.$cur_waitting.') / '.$cur_pax;
			$body .= chr(10);
			$body .= '予約番号： '.$yoyakuno;
			$body .= chr(10);
			$body .= '--------------------------------------';
			$body .= chr(10);
			foreach($_SERVER as $post_name => $post_value){
				$body .= chr(10);
				$body .= $post_name." : ".$post_value;
			}
			$body .= '';
			//$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
			$from = $_POST['メール'];
			mb_send_mail($vmail1,$subject,$body,"From:".$from);

			// その他内容ありの場合
			if ($sonota <> '')	{
				$subject = $namae."様 お問い合わせありがとうございます。";
				$body  = '';
				$body .= '[無料セミナー予約フォーム]';
				$body .= chr(10);
				foreach($_POST as $post_name => $post_value){
					$body .= chr(10);
					$body .= $post_name." : ".$post_value;
				}
				$body .= chr(10);
				$body .= chr(10);
				$body .= '--------------------------------------';
				$body .= chr(10);
				$body .= 'セミナー番号 ： '.$cur_id;
				$body .= chr(10);
				$body .= 'セミナー名 ： '.$cur_title1;
				$body .= chr(10);
				$body .= '日程 ： '.$cur_hiduke.'  '.$cur_sttime.'開始';
				$body .= chr(10);
				$body .= '開催地 ： '.$cur_place;
				$body .= chr(10);
				$body .= chr(10);
				$body .= '予約状況： '.$cur_booking.' ('.$cur_waitting.') / '.$cur_pax;
				$body .= chr(10);
				$body .= '予約番号： '.$yoyakuno;
				$body .= chr(10);
				$body .= '--------------------------------------';
				$body .= chr(10);
				foreach($_SERVER as $post_name => $post_value){
					$body .= chr(10);
					$body .= $post_name." : ".$post_value;
				}
				$body .= '';
				//$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
				$from = $_POST['メール'];
				mb_send_mail($vmail2,$subject,$body,"From:".$from);
			}

			// 仮予約メール
			if ($wait == 0)	{
				$subject = "イベント（セミナー）仮予約のご案内";
			}else{
				$subject = "イベント（セミナー）キャンセル待ちのご案内";
			}

			$body  = '';
			$body .= ''.$namae.'様';
			$body .= chr(10);
			$body .= chr(10);
			$body .= '日本ワーキングホリデー協会です。';
			$body .= chr(10);
			$body .= 'この度は、当協会のイベント（セミナー）にご興味を持って頂きありがとうございます。';
			$body .= chr(10);
			$body .= chr(10);
			if ($wait == 0)	{
				$body .= '以下の通り、仮予約を受け付けました。';
			}else{
				$body .= '恐れ入りますが、対象のイベント（セミナー）は、現在満席となりますので、';
				$body .= chr(10);
				$body .= 'キャンセル待ちリストに登録させて頂きました。';
			}
			$body .= chr(10);
			$body .= chr(10);
			if ($wait == 0)	{
				$body .= 'なお、現在は「仮予約」の状態ですので以下のURLを表示し、必ずご予約を確定させてください。'.chr(10);
				$body .= 'また、ご予約が確定されない場合、２４時間で自動的にこの仮予約はキャンセルされます。ご注意ください。'.chr(10);
				$body .= chr(10);
				$body .= '≪予約の確定≫'.chr(10);
			}else{
				$body .= '他のお客様がキャンセルされた場合、順番にご案内いたしますので、このままお待ちください。'.chr(10);
				$body .= 'なお、他のイベント（セミナー）にご興味がある場合は、そちらのご予約をする事も可能です。'.chr(10);
				$body .= 'また、このキャンセル待ちを取り消す場合は、以下のURLからお願いいたします。'.chr(10);
				$body .= chr(10);
				$body .= '≪仮予約の取消≫'.chr(10);
			}
			$body .= 'http://www.jawhm.or.jp/yoyaku/disp/'.$yoyakuno.'/'.md5($email).chr(10);
			$body .= chr(10);
			$body .= '─────────────────────────'.chr(10);
			$body .= '　「'.$cur_title1.'」'.chr(10);
			$body .= '─────────────────────────'.chr(10);
			$body .= chr(10);
			$body .= '≪日時≫'.chr(10);
			$body .= '　'.$cur_y.'年 '.$cur_m.'月 '.$cur_d.'日 ('.$youbi[$cur_yobi].'曜日)   '.$cur_sttime.' 開始'.chr(10);
			$body .= chr(10);
			$body .= '≪会場≫'.chr(10);
			switch ($cur_place)	{
				case 'tokyo':
					$body .='　東京会場'.chr(10);
					$body .='　http://www.jawhm.or.jp/event/map?p=tokyo&wh=s01'.chr(10);
					break;
				case 'osaka':
					$body .='　大阪会場'.chr(10);
					$body .='　http://www.jawhm.or.jp/event/map?p=osaka&wh=s01'.chr(10);
					break;
				case 'nagoya':
					$body .='　名古屋会場'.chr(10);
					$body .='　http://www.jawhm.or.jp/event/map?p=nagoya&wh=s01'.chr(10);
					break;
				case 'fukuoka':
					$body .='　福岡会場'.chr(10);
					$body .='　http://www.jawhm.or.jp/event/map?p=fukuoka&wh=s01'.chr(10);
					break;
				case 'sendai':
					$body .='　仙台会場'.chr(10);
					break;
				case 'toyama':
					$body .='　富山会場'.chr(10);
					break;
				case 'okinawa':
					$body .='　沖縄会場'.chr(10);
					$body .='　http://www.jawhm.or.jp/event/map?p=okinawa&wh=s01'.chr(10);
					break;
			}
			$body .= chr(10);
	//		$body .= '≪内容≫'.chr(10);
			$body .= ''.$cur_desc1.''.chr(10);
			$body .= chr(10);
			if ($cur_ninzu == 2)	{
				$body .= '---------------'.chr(10);
				$body .= '　ご同伴者あり（お二人様のお席をご用意いたします。）'.chr(10);
				$body .= '---------------'.chr(10);
				$body .= chr(10);
			}
			$body .= chr(10);
			if ($cur_mailinfo <> '')	{
				$body .= '≪その他≫'.chr(10);
				$body .= $cur_mailinfo.chr(10);
				$body .= chr(10);
			}
			$body .= chr(10);
			$body .= '◆このメールに覚えが無い場合◆';
			$body .= chr(10);
			$body .= '他の方がメールアドレスを間違えた可能性があります。';
			$body .= chr(10);
			$body .= 'お手数ですが、 info@jawhm.or.jp までご連絡頂ければ幸いです。';
			$body .= chr(10);
			$body .= chr(10);
			$body .= '┏┓━━━━━━━━━━━━━━'.chr(10);
			$body .= '┗■　メンバー登録のご案内'.chr(10);
			$body .= '━━━━━━━━━━━━━━━━'.chr(10);
			$body .= 'メンバー登録はワーホリ成功の第一歩！'.chr(10);
			$body .= ''.chr(10);
			$body .= 'ワーキングホリデーや留学には興味があるけれど、'.chr(10);
			$body .= '　● 海外で何ができるのか？'.chr(10);
			$body .= '　● 何をしなければいけないのか？'.chr(10);
			$body .= '　● どんな準備や手続きが必要なのか？'.chr(10);
			$body .= '　● どのくらい費用がかかるのか？'.chr(10);
			$body .= '　● 渡航先で困ったときはどうすればよいのか？'.chr(10);
			$body .= ''.chr(10);
			$body .= '解らない事が多すぎて、もっと解らなくなってしまいます。'.chr(10);
			$body .= ''.chr(10);
			$body .= 'そんな皆様を支援するために当協会では、'.chr(10);
			$body .= 'ワーホリ成功のためのメンバーサポート制度をご用意しています。'.chr(10);
			$body .= '当協会のメンバーになれば、個別相談をはじめビザ取得のお手伝い、'.chr(10);
			$body .= '出発前の準備、到着後のサポートまで、フルにサポートさせて頂きます。'.chr(10);
			$body .= ''.chr(10);
			$body .= '▼▼▼▼▼ メンバー登録はこちらから ▼▼▼▼▼'.chr(10);
			$body .= '　http://www.jawhm.or.jp/mem?wh=s01'.chr(10);
			$body .= ''.chr(10);
			$body .= '……‥‥‥‥‥・・‥‥‥‥‥……'.chr(10);
			$body .= '　日本ワーキングホリデー協会'.chr(10);
			$body .= '　http://www.jawhm.or.jp'.chr(10);
			$body .= '　E-mail : info@jawhm.or.jp'.chr(10);
			$body .= '……‥‥‥‥‥・・‥‥‥‥‥……'.chr(10);
			$body .= ''.chr(10);
			$body .= '';

			$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
			mb_send_mail($email,$subject,$body,"From:".$from);

			if ($wait == 0)	{
				$msg .= '仮予約を受け付けました。';
			}else{
				$msg .= 'キャンセル待ちを受け付けました。';
			}
			$msg .= 'メールにてご案内を差し上げておりますので、ご確認ください。';

			// カレンダー変更
			GC_Edit($seminarid);

		}else{
			$msg .= 'シーケンスエラー';
		}

	}else{
		$msg .= 'シーケンスエラー';
	}

	echo $msg;

?>
