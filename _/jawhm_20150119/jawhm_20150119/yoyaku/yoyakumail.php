<?php



	ini_set( "display_errors", "On");



	require_once 'googleapi.php';



	mb_language("Ja");

	mb_internal_encoding("utf8");



	$vmail1 = 'masaki@tora-tora.net';

	$vmail2 = 'toiawase@jawhm.or.jp';

	$msg = '';

	$youbi = Array("日","月","火","水","木","金","土");



	$seminarid = @$_GET['seminarid'];

	$email = @$_GET['email'];

	$ninzu = 0;



	if ($seminarid <> '')	{

		try {

			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);

			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);

			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			$db->query('SET CHARACTER SET utf8');

			$stt = $db->prepare('SELECT id, place, hiduke, year(hiduke) as y, month(hiduke) as m, day(hiduke) as d, date_format(hiduke,\'%w\') as yobi, date_format(starttime,\'%k:%i\') as sttime, k_title1, pax, booking, waitting FROM event_list WHERE id = "'.$seminarid.'" ');

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

				$cur_pax = $row['pax'];

				$cur_booking = $row['booking'];

				$cur_waitting = $row['waitting'];

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



			// 予約リスト追加

			try {

				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);

				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);

				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				$db->query('SET CHARACTER SET utf8');

				$sql  = 'INSERT INTO entrylist (';

				$sql .= ' id, seminarid, seminarname, namae, email, ninzu, stat, wait, mailstat, insdate, upddate';

				$sql .= ') VALUES (';

				$sql .= ' :id, :seminarid, :seminarname, :namae, :email, :ninzu, :stat, :wait, :mailstat, :insdate, :upddate';

				$sql .= ')';

				$stt2 = $db->prepare($sql);

				$stt2->bindValue(':id'		, $yoyakuno);

				$stt2->bindValue(':seminarid'	, $seminarid);

				$stt2->bindValue(':seminarname'	, $cur_title1);

				$stt2->bindValue(':namae'	, 'メール予約');

				$stt2->bindValue(':email'	, $email);

				$stt2->bindValue(':ninzu'	, $ninzu);

				$stt2->bindValue(':stat'	, '3');

				$stt2->bindValue(':wait'	, $wait);

				$stt2->bindValue(':mailstat'	, '0');

				$stt2->bindValue(':insdate'	, date('Y/m/d H:i:s'));

				$stt2->bindValue(':upddate'	, date('Y/m/d H:i:s'));

				$stt2->execute();

				$db = NULL;

			} catch (PDOException $e) {

				die($e->getMessage());

			}



			// 社内通知

			$subject = "メール イベント予約";

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

			$from = $email;

			mb_send_mail($vmail1,$subject,$body,"From:".$from);



			// 仮予約メール

			if ($wait == 0)	{

				$subject = "イベント（セミナー）仮予約のご案内";

			}else{

				$subject = "イベント（セミナー）キャンセル待ちのご案内";

			}



			$body  = '';

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

			$body .= '---------------';

			$body .= chr(10);

			switch ($cur_place)	{

				case 'tokyo':

					$body .='　東京会場';

					$body .= chr(10);

					$body .='　http://www.jawhm.or.jp/event/map?p=tokyo';

					$body .= chr(10);

					break;

				case 'osaka':

					$body .='　大阪会場';

					$body .= chr(10);

					$body .='　http://www.jawhm.or.jp/event/map?p=osaka';

					$body .= chr(10);

					break;

				case 'fukuoka':

					$body .='　福岡会場';

					$body .= chr(10);

					$body .='　http://www.jawhm.or.jp/event/map?p=fukuoka';

					$body .= chr(10);

					break;

				case 'sendai':

					$body .='　仙台会場';

					$body .= chr(10);

					break;

				case 'toyama':

					$body .='　富山会場';

					$body .= chr(10);

					break;

				case 'okinawa':

					$body .='　沖縄会場';

					$body .= chr(10);

					$body .='　http://www.jawhm.or.jp/event/map?p=okinawa';

					$body .= chr(10);

					break;

			}

			$body .= '　'.$cur_y.'年 '.$cur_m.'月 '.$cur_d.'日 ('.$youbi[$cur_yobi].'曜日)   '.$cur_sttime.' 開始';

			$body .= chr(10);

			$body .= '　「'.$cur_title1.'」';

			$body .= chr(10);

			$body .= '---------------';

			$body .= chr(10);

			$body .= chr(10);

			if ($wait == 0)	{

				$body .= 'なお、現在は「仮予約」の状態ですので以下のURLを表示し、必ずご予約を確定させてください。';

				$body .= chr(10);

				$body .= 'また、ご予約が確定されない場合、２４時間で自動的にこの仮予約はキャンセルされます。ご注意ください。';

			}else{

				$body .= '他のお客様がキャンセルされた場合、順番にご案内いたしますので、このままお待ちください。';

				$body .= chr(10);

				$body .= 'なお、他のイベント（セミナー）にご興味がある場合は、そちらのご予約をする事も可能です。';

				$body .= chr(10);

				$body .= 'また、このキャンセル待ちを取り消す場合は、以下のURLからお願いいたします。';

			}

			$body .= chr(10);

			$body .= chr(10);

			$body .= 'http://www.jawhm.or.jp/yoyaku/disp/'.$yoyakuno.'/'.md5($email);

			$body .= chr(10);

			$body .= chr(10);

			$body .= '◆このメールに覚えが無い場合◆';

			$body .= chr(10);

			$body .= '他の方がメールアドレスを間違えた可能性があります。';

			$body .= chr(10);

			$body .= 'お手数ですが、 info@jawhm.or.jp までご連絡頂ければ幸いです。';

			$body .= chr(10);

			$body .= '';

			$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";

			mb_send_mail($email,$subject,$body,"From:".$from);



			if ($wait == 0)	{

				$msg .= '仮予約を受け付けました。';

			}else{

				$msg .= 'キャンセル待ちを受け付けました。';

			}

			$msg .= 'ご入力頂いたメールアドレスにご案内を差し上げておりますので、ご確認ください。';



			// カレンダー変更

			GC_Edit($seminarid);



		}else{

			$msg .= 'シーケンスエラー（イベント不正）';

		}



	}else{

		$msg .= 'シーケンスエラー（パラメータ不正）';

	}



	echo $msg;



?>

