<?

ini_set( "display_errors", "On");

mb_language("Ja");
mb_internal_encoding("utf8");

function trimspace($str)	{
	$data = $str;
	$data = mb_ereg_replace(" ","",$data);
	$data = mb_ereg_replace("　","",$data);
	$data = mb_convert_kana($data, "AK");
	return $data;
}

function getRandomString($nLengthRequired = 8){
    $sCharList = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
    mt_srand();
    $sRes = "";
    for($i = 0; $i < $nLengthRequired; $i++)
        $sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
    return $sRes;
}

	// 拠点確認
	$k = strtoupper(@$_GET['k']);

	$mailadd = 'meminfo@jawhm.or.jp';
	$act = @$_GET['act'];
	if ($act == '')	{	$act = @$_POST['act'];	}
	if ($act == '')	{	$act = 's0';		}

	$stepidx = intval(substr($act,-1));
	$act = 's'.strval($stepidx + 1);

	$msg = '';
	$abort = false;

	// 中断ユーザ判定
	$u = @$_GET['u'];
	$m = @$_GET['m'];
	if ($u <> '' || $m <> '')	{

		try {
			$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$stt = $db->prepare('SELECT id, email, mailcheck, state FROM memlist WHERE id = "'.$u.'" ');
			$stt->execute();
			$idx = 0;
			$cur_email = '';
			$cur_state = '';
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_id = $row['id'];
				$cur_email = $row['email'];
				$cur_mailcheck = $row['mailcheck'];
				$cur_state = $row['state'];
			}
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}

		if ($idx > 0)	{
			if ($cur_state == '0')	{
				if (md5($cur_email) == $m)	{
					$act = 'p3';
					$dat_id = $u;
					$dat_email = $cur_email;
				}else{
					$act = 's5';
					$stepidx = 4;
					$abort = true;
					$abort_msg = '画面遷移情報が確認できません。エラーコード[A992G]<br/>';
				}
			}else{
				$act = 's5';
				$stepidx = 4;
				$abort = true;
				$abort_msg = 'このメールアドレスは、既に承認されています。<br/>';
			}
		}else{
			$act = 's5';
			$stepidx = 4;
			$abort = true;
			$abort_msg = '画面遷移情報が確認できません。エラーコード[T08S3]<br/>';
		}
	}

	if ($act == 's2')	{
		//　入力チェック
		$chk = 'ok';

		if (@$_POST['email'] == '')	{	$chk = 'ng';	}

		if ($chk == 'ok')	{
			// 入力情報を取得
			$dat_email	= @$_POST['email'];

			$dat_password	= @$_POST['password'];
			$dat_namae	= trimspace(@$_POST['namae1']).'　'.trimspace(@$_POST['namae2']);
			$dat_furigana	= mb_convert_kana(trimspace(@$_POST['furigana1']).'　'.trimspace(@$_POST['furigana2']), "C");
			$dat_gender	= @$_POST['gender'];
			$dat_year	= @$_POST['year'];
			$dat_month	= @$_POST['month'];
			$dat_day	= @$_POST['day'];
			$dat_birth	= $dat_year.'/'.$dat_month.'/'.$dat_day;
			$dat_pcode	= mb_convert_kana(@$_POST['pcode'], "a");
			$dat_add1	= @$_POST['add1'];
			$dat_add2	= @$_POST['add2'];
			$dat_add3	= @$_POST['add3'];
			$dat_tel	= mb_convert_kana(@$_POST['tel'], "a");

			if ($dat_namae == '　')	{
				$dat_namae = 'エラー：入力してください';
				$chk = 'ng';
			}
			if ($dat_furigana == '　')	{
				$dat_furigana = 'エラー：入力してください';
				$chk = 'ng';
			}
			if ($dat_month == '' || $dat_day == '')	{
				$chk = 'ng';
			}
			if ($dat_pcode == '')	{
				$dat_pcode = 'エラー：入力してください';
				$chk = 'ng';
			}
			if ($dat_add1 == '')	{
				$dat_add1 = 'エラー：入力してください';
				$chk = 'ng';
			}
			if ($dat_add2 == '')	{
				$dat_add2 = 'エラー：入力してください';
				$chk = 'ng';
			}
			if ($dat_add3 == '')	{
				$dat_add3 = 'エラー：入力してください';
				$chk = 'ng';
			}
			if ($dat_tel == '')	{
				$dat_tel = 'エラー：入力してください';
				$chk = 'ng';
			}

			$dat_job	= @$_POST['job'];
			$dat_country	= '';
			for ($idx=1; $idx<=99; $idx++)	{
				if (@$_POST['c'.$idx] <> '')	{
					if ($dat_country <> '')	{ $dat_country .= '/'; }
					$dat_country .= @$_POST['c'.$idx];
				}
			}
			$dat_gogaku	= @$_POST['gogaku'];
			$dat_purpose	= '';
			for ($idx=1; $idx<=99; $idx++)	{
				if (@$_POST['p'.$idx] <> '')	{
					if ($dat_purpose <> '')	{ $dat_purpose .= '/'; }
					$dat_purpose .= @$_POST['p'.$idx];
				}
			}
			$dat_know	= '';
			for ($idx=1; $idx<=99; $idx++)	{
				if (@$_POST['k'.$idx] <> '')	{
					if ($dat_know <> '')	{ $dat_know .= '/'; }
					$dat_know .= @$_POST['k'.$idx];
				}
			}
			$dat_mailsend	= @$_POST['mailsend'];
			$dat_agree	= @$_POST['agree'];

			$dat_kyoten	= @$_POST['kyoten'];

			// メールアドレス重複確認
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$stt = $db->prepare('SELECT id, email, state FROM memlist WHERE email = "'.$dat_email.'"');
				$stt->execute();
				$idx = 0;
				$cur_state = '';
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_state = $row['state'];
				}
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
			if ($idx > 0)	{
				// 既に登録されたメールアドレスの場合
				if ($cur_state == '0')	{
					// 仮登録状態の場合は、既存レコードを削除する
					try {
						$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
						$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
						$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$db->query('SET CHARACTER SET utf8');
						$stt = $db->prepare('DELETE FROM memlist WHERE email = "'.$dat_email.'"');
						$stt->execute();
						$db = NULL;
					} catch (PDOException $e) {
						die($e->getMessage());
					}
				}else{
					// 登録不可画面を表示する
					$act = 's5';
					$stepidx = 4;
					$abort = true;
					$abort_msg  = '入力されたメールアドレスは既に使用されています。<br/>';
					$abort_msg .= 'ログインする場合は、<a href="/member">こちらから</a>どうぞ。<br/>';
					$abort_msg .= '登録した覚えがない場合は、info@jawhm.or.jp までお問い合わせください。<br/>';
					$abort_msg .= '';
				}
			}
		}else{
			// 未入力項目があるので、入力画面に差し戻し
			$act = 's1';
			$stepidx = 0;
		}
	}

	if ($act == 's3')	{
		//　入力チェック
		$chk = 'ok';

		if (@$_POST['email'] == '')	{
			$chk = 'ng';
		}

		if ($chk == 'ok')	{
			// 入力情報を取得
			$dat_email	= @$_POST['email'];

			$dat_password	= @$_POST['password'];
			$dat_namae	= @$_POST['namae'];
			$dat_furigana	= @$_POST['furigana'];
			$dat_gender	= @$_POST['gender'];
			$dat_year	= @$_POST['year'];
			$dat_month	= @$_POST['month'];
			$dat_day	= @$_POST['day'];
			$dat_birth	= $dat_year.'/'.$dat_month.'/'.$dat_day;
			$dat_pcode	= @$_POST['pcode'];
			$dat_add1	= @$_POST['add1'];
			$dat_add2	= @$_POST['add2'];
			$dat_add3	= @$_POST['add3'];
			$dat_tel	= @$_POST['tel'];

			$dat_job	= @$_POST['job'];
			$dat_country	= @$_POST['country'];
			$dat_gogaku	= @$_POST['gogaku'];
			$dat_purpose	= @$_POST['purpose'];
			$dat_know	= @$_POST['know'];
			$dat_mailsend	= @$_POST['mailsend'];
			$dat_agree	= @$_POST['agree'];

			$dat_kyoten	= @$_POST['kyoten'];

			// 付加情報を設定
			$mail_check = getRandomString(5);

			// メールアドレス重複確認
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$stt = $db->prepare('SELECT id, email, state FROM memlist WHERE email = "'.$dat_email.'"');
				$stt->execute();
				$idx = 0;
				$cur_state = '';
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_state = $row['state'];
				}
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
			if ($idx > 0)	{
				// 既に登録されたメールアドレスの場合
				if ($cur_state == '0')	{
					// 仮登録状態の場合は、既存レコードを削除する
					try {
						$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
						$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
						$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$db->query('SET CHARACTER SET utf8');
						$stt = $db->prepare('DELETE FROM memlist WHERE email = "'.$dat_email.'"');
						$stt->execute();
						$db = NULL;
					} catch (PDOException $e) {
						die($e->getMessage());
					}
				}else{
					// 登録不可画面を表示する
					$act = 's5';
					$stepidx = 4;
					$abort = true;
					$abort_msg  = '入力されたメールアドレスは既に使用されています。<br/>';
					$abort_msg .= 'ログインする場合は、<a href="/member">こちらから</a>どうぞ。<br/>';
					$abort_msg .= '登録した覚えがない場合は、info@jawhm.or.jp までお問い合わせください。<br/>';
					$abort_msg .= '';
				}
			}

			if ($abort == false)	{
				// 会員番号採番＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊＊
				try {
					$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
					$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$db->query('SET CHARACTER SET utf8');
					$stt = $db->prepare('SELECT max(id) as maxid FROM memlist');
					$stt->execute();
					$idx = 0;
					$cur_id = 'JW000000';
					while($row = $stt->fetch(PDO::FETCH_ASSOC)){
						$idx++;
						$cur_id = $row['maxid'];
					}
					$db = NULL;
				} catch (PDOException $e) {
					die($e->getMessage());
				}
				$cur_num = intval(substr($cur_id,-6)) + 1;
				$dat_id = 'JW'.substr('000000'.strval($cur_num),-6);

				// 支払シーケンス取得
				try {
					$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
					$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$db->query('SET CHARACTER SET utf8');
					$stt = $db->prepare('SELECT seq FROM kessai_seq');
					$stt->execute();
					$idx = 0;
					$cur_seq = '0';
					while($row = $stt->fetch(PDO::FETCH_ASSOC)){
						$idx++;
						$cur_seq = $row['seq'];
					}
					$db = NULL;
				} catch (PDOException $e) {
					die($e->getMessage());
				}
				$cur_num = intval($cur_seq) + 1;
				try {
					$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
					$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$db->query('SET CHARACTER SET utf8');
					$stt = $db->prepare('UPDATE kessai_seq SET seq = '.$cur_num.' ');
					$stt->execute();
					$db = NULL;
				} catch (PDOException $e) {
					die($e->getMessage());
				}
				$dat_sid = $dat_id.substr('000000'.strval($cur_num),-6);

				// 会員情報を仮登録
				try {
					$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
					$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$db->query('SET CHARACTER SET utf8');
					$sql  = 'INSERT INTO memlist (';
					$sql .= ' id ,email ,password ,namae ,furigana ,gender ,birth ,pcode ,add1 ,add2 ,add3 ,add4 ,tel ,job ,country ,gogaku ,purpose ,know ,agree ,state ,indate ,mailcheck ,mailcheckdate ,mailsend ,insdate ,upddate, kyoten, sid ';
					$sql .= ') VALUES (';
					$sql .= ' :id ,:email ,:password ,:namae ,:furigana ,:gender ,:birth ,:pcode ,:add1 ,:add2 ,:add3 ,:add4 ,:tel ,:job ,:country ,:gogaku ,:purpose ,:know ,:agree ,:state ,:indate ,:mailcheck ,:mailcheckdate ,:mailsend ,:insdate ,:upddate, :kyoten, :sid ';
					$sql .= ')';
					$stt2 = $db->prepare($sql);
					$stt2->bindValue(':id'		, $dat_id);
					$stt2->bindValue(':email'	, $dat_email);
					$stt2->bindValue(':password'	, md5($dat_password));
					$stt2->bindValue(':namae'	, $dat_namae);
					$stt2->bindValue(':furigana'	, $dat_furigana);
					$stt2->bindValue(':gender'	, $dat_gender);
					$stt2->bindValue(':birth'	, $dat_birth);
					$stt2->bindValue(':pcode'	, $dat_pcode);
					$stt2->bindValue(':add1'	, $dat_add1);
					$stt2->bindValue(':add2'	, $dat_add2);
					$stt2->bindValue(':add3'	, $dat_add3);
					$stt2->bindValue(':add4'	, NULL);
					$stt2->bindValue(':tel'		, $dat_tel);
					$stt2->bindValue(':job'		, $dat_job);
					$stt2->bindValue(':country'	, $dat_country);
					$stt2->bindValue(':gogaku'	, $dat_gogaku);
					$stt2->bindValue(':purpose'	, $dat_purpose);
					$stt2->bindValue(':know'	, $dat_know);
					$stt2->bindValue(':agree'	, $dat_agree);
					$stt2->bindValue(':state'	, '0');
					$stt2->bindValue(':indate'	, date('Y/m/d'));
					$stt2->bindValue(':mailcheck'	, $mail_check);
					$stt2->bindValue(':mailcheckdate', NULL);
					$stt2->bindValue(':mailsend'	, $dat_mailsend);
					$stt2->bindValue(':insdate'	, date('Y/m/d H:i:s'));
					$stt2->bindValue(':upddate'	, date('Y/m/d H:i:s'));
					$stt2->bindValue(':kyoten'	, $dat_kyoten);
					$stt2->bindValue(':sid'		, $dat_sid);
					$stt2->execute();
					$db = NULL;
				} catch (PDOException $e) {
					die($e->getMessage());
				}

				// 社内通知
				$subject = "【メンバー登録：仮登録】  ".$dat_namae."様  ".$dat_email;
				$body  = '';
				$body .= 'メンバー登録の仮登録を受け付けました。';
				$body .= chr(10);
				$body .= chr(10);
				$body .= 'メールアドレス：'.$dat_email;
				$body .= chr(10);
				$body .= 'お名前：'.$dat_namae;
				$body .= chr(10);
				$body .= 'フリガナ：'.$dat_furigana;
				$body .= chr(10);
				$body .= '性別：'.$dat_gender.'  (m:男性 f:女性)';
				$body .= chr(10);
				$body .= '生年月日：'.$dat_birth;
				$body .= chr(10);
				$body .= '郵便番号：'.$dat_pcode;
				$body .= chr(10);
				$body .= '住所１：'.$dat_add1;
				$body .= chr(10);
				$body .= '住所２：'.$dat_add2;
				$body .= chr(10);
				$body .= '住所３：'.$dat_add3;
				$body .= chr(10);
				$body .= '電話番号：'.$dat_tel;
				$body .= chr(10);
				$body .= '職業：'.$dat_job;
				$body .= chr(10);
				$body .= '渡航予定国：'.$dat_country;
				$body .= chr(10);
				$body .= '語学力：'.$dat_gogaku;
				$body .= chr(10);
				$body .= '渡航目的：'.$dat_purpose;
				$body .= chr(10);
				$body .= '協会：'.$dat_know;
				$body .= chr(10);
				$body .= '案内メール：'.$dat_mailsend.'  (0:不要 1:必要)';
				$body .= chr(10);
				$body .= '同意確認：'.$dat_agree;
				$body .= chr(10);
				$body .= chr(10);
				$body .= 'メール承認コード：'.$mail_check;
				$body .= chr(10);
				$body .= '';
				$body .= chr(10);
				$body .= '--------------------------------------';
				$body .= chr(10);
				foreach($_SERVER as $post_name => $post_value){
					$body .= chr(10);
					$body .= $post_name." : ".$post_value;
				}
				$body .= '';
				$from = mb_encode_mimeheader(mb_convert_encoding($dat_namae,"JIS"))."<".$dat_email.">";
				mb_send_mail($mailadd,$subject,$body,"From:".$from);

				if ($k == '')	{
					// 確認メールを送信
					$subject = "メールアドレスの確認です";
					$body  = '';
					$body .= '日本ワーキングホリデー協会です。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= 'メールアドレス確認の為の承認コード（５桁）をお送りします。';
					$body .= chr(10);
					$body .= 'この承認コードを、メンバー登録画面で入力してください。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= '承認コード [ '.$mail_check.' ]';
					$body .= chr(10);
					$body .= chr(10);
					$body .= 'メンバー登録画面を閉じてしまった場合、以下のＵＲＬをご利用ください。';
					$body .= chr(10);
					$body .= 'http://www.jawhm.or.jp/mem/confirm.php?u='.$dat_id.'&m='.md5($dat_email);
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
					mb_send_mail($dat_email,$subject,$body,"From:".$from);
				}else{
					// 確認メールを送信
					$subject = "メールアドレスの確認です";
					$body  = '';
					$body .= '日本ワーキングホリデー協会です。';
					$body .= chr(10);
					$body .= 'メンバー登録ありがとうございます。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= 'このメールは、メールアドレスの確認の為にお送りしております。';
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
					mb_send_mail($dat_email,$subject,$body,"From:".$from);
				}
			}
		}else{
			// 未入力項目があるので、入力画面に差し戻し
			$act = 's1';
			$stepidx = 0;
		}
	}

	if ($act == 's4')	{
		//　メアドチェック
		$chk = 'ok';

		$dat_id		= @$_POST['userid'];
		$dat_email	= @$_POST['email'];
		$dat_mailcheck	= @$_POST['mailcheck'];
		if ($dat_id == '')		{	$dat_id		= @$_GET['userid'];	}
		if ($dat_email == '')		{	$dat_email	= @$_GET['email'];	}
		if ($dat_mailcheck == '')	{	$dat_mailcheck	= @$_GET['mailcheck'];	}
		$dat_sid	= '';
		$dat_name1	= '';
		$dat_name2	= '';
		$dat_tel	= '';
		$dat_adr1	= '';
		$dat_adr2	= '';

		if ($dat_id == '' || $dat_mailcheck == '')	{
			$act = 's5';
			$stepidx = 4;
			$abort = true;
			$abort_msg  = '処理中にエラーが発生しました。エラーコード[GR882]<br/>';
			$abort_msg .= '';
		}else{
			// メール承認確認
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$stt = $db->prepare('SELECT id, email, mailcheck, sid, namae, add1, add2, tel, state FROM memlist WHERE id = "'.$dat_id.'" ');
				$stt->execute();
				$idx = 0;
				$cur_sid = '';
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_id = $row['id'];
					$cur_email = $row['email'];
					$cur_mailcheck = $row['mailcheck'];
					$cur_sid = $row['sid'];
					$cur_namae = $row['namae'];
					$cur_add1 = $row['add1'];
					$cur_add2 = $row['add2'];
					$cur_tel = $row['tel'];
					$cur_state = $row['state'];
				}
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
			$dat_sid 	= $cur_sid;
			$split_name	= mb_split("　", $cur_namae);
			$dat_name1	= $split_name[0];
			$dat_name2	= $split_name[1];
			$dat_tel	= $cur_tel;
			$dat_adr1	= $cur_add1;
			$dat_adr2	= $cur_add2;

			// 支払シーケンス取得
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$stt = $db->prepare('SELECT seq FROM kessai_seq');
				$stt->execute();
				$idx = 0;
				$cur_seq = '0';
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_seq = $row['seq'];
				}
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
			$cur_num = intval($cur_seq) + 1;
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$stt = $db->prepare('UPDATE kessai_seq SET seq = '.$cur_num.' ');
				$stt->execute();
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
			$dat_sid = $cur_id.substr('000000'.strval($cur_num),-6);

			$dat_sid_card = $cur_id.'000000';
			$dat_sid_conv = $cur_id.substr('000000'.strval($cur_num),-6);

			// 支払状態確認
			if ($cur_state == '5' || $cur_state == '9')	{
				$act = 's5';
				$stepidx = 4;
				$abort = true;
				$abort_msg  = '既にメンバー登録料をお支払頂いているか、会員状態が不明です。お問い合わせください。[PE407]<br/>';
				$abort_msg .= '';
			}else{
				if ($dat_email == $cur_email)	{
					if ($dat_mailcheck == $cur_mailcheck || $k <> '')	{
						// 承認コード確認ＯＫ
						try {
							$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
							$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
							$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$db->query('SET CHARACTER SET utf8');
							$stt = $db->prepare('UPDATE memlist SET state = "1", mailcheckdate = "'.date('Y/m/d H:i:s').'", upddate = "'.date('Y/m/d H:i:s').'" WHERE id = "'.$dat_id.'" ');
							$stt->execute();
							$db = NULL;
						} catch (PDOException $e) {
							die($e->getMessage());
						}
						// 会員情報読み込み
						try {
							$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
							$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
							$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
							$db->query('SET CHARACTER SET utf8');
							$stt = $db->prepare('SELECT id, email, namae, furigana, tel FROM memlist WHERE id = "'.$dat_id.'" ');
							$stt->execute();
							$idx = 0;
							while($row = $stt->fetch(PDO::FETCH_ASSOC)){
								$idx++;
								$dat_email = $row['email'];
								$dat_namae = $row['namae'];
								$dat_furigana = $row['furigana'];
								$dat_tel = $row['tel'];
							}
							$db = NULL;
						} catch (PDOException $e) {
							die($e->getMessage());
						}

						// 社内通知
						$subject = "【メンバー登録：メアド承認】  ".$dat_namae."様  ".$dat_email;
						$body  = '';
						$body .= 'メンバー登録でメールアドレスの承認が完了しました。';
						$body .= chr(10);
						$body .= chr(10);
						$body .= 'メールアドレス：'.$dat_email;
						$body .= chr(10);
						$body .= 'お名前：'.$dat_namae;
						$body .= chr(10);
						$body .= 'フリガナ：'.$dat_furigana;
						$body .= chr(10);
						$body .= '電話番号：'.$dat_tel;
						$body .= chr(10);
						$body .= '';
						$from = mb_encode_mimeheader(mb_convert_encoding($dat_namae,"JIS"))."<".$dat_email.">";
						mb_send_mail($mailadd,$subject,$body,"From:".$from);

					}else{
						// 承認コード不一致
						$act = 's3';
						$stepidx = 2;
						$msg = '入力された承認コードが一致しません。<br/>お送りしたメールを、もう一度確認してください。<br/>また、承認コードはコピー＆ペーストせず、必ず入力してください。<br/>';
					}
				}else{
					// メールアドレス不一致
					$act = 's5';
					$stepidx = 4;
					$abort = true;
					$abort_msg = '画面遷移情報が確認できません。<br/>';
				}
			}
		}
	}

	if ($act == 's5')	{
		//　サンキュー画面
		$chk = 'ok';

		$dat_id		= @$_POST['userid'];
		$dat_email	= @$_POST['email'];
		$dat_tgt	= @$_POST['tgt'];

		if ($chk == 'ok')	{

			// 会員情報読み込み
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$stt = $db->prepare('SELECT id, email, namae, furigana, tel, state, mailcheck FROM memlist WHERE id = "'.$dat_id.'" ');
				$stt->execute();
				$idx = 0;
				$cur_email = '';
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_id = $row['id'];
					$cur_email = $row['email'];
					$cur_namae = $row['namae'];
					$cur_furigana = $row['furigana'];
					$cur_tel = $row['tel'];
					$cur_state = $row['state'];
					$cur_mailcheck = $row['mailcheck'];
				}
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
			// 支払方法設定
			try {
				$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
				$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->query('SET CHARACTER SET utf8');
				$stt = $db->prepare('UPDATE memlist SET payment = "'.$dat_tgt.'" WHERE id = "'.$dat_id.'" ');
				$stt->execute();
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}

			if ($dat_email == $cur_email)	{

				if ($dat_tgt == 'furikomi')	{
					// 銀行振込の場合

					// 社内通知
					$subject = "【メンバー登録：振込予約】  ".$cur_namae."様  ".$cur_email;
					$body  = '';
					$body .= 'メンバー登録で振込予約が発生しました。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= '会員番号：'.$cur_id;
					$body .= chr(10);
					$body .= 'メールアドレス：'.$cur_email;
					$body .= chr(10);
					$body .= 'お名前：'.$cur_namae;
					$body .= chr(10);
					$body .= 'フリガナ：'.$cur_furigana;
					$body .= chr(10);
					$body .= '電話番号：'.$cur_tel;
					$body .= chr(10);
					$body .= '';
					$from = mb_encode_mimeheader(mb_convert_encoding($cur_namae,"JIS"))."<".$dat_email.">";
					mb_send_mail($mailadd,$subject,$body,"From:".$from);

					// 社内通知
					$subject = "【メンバー登録：振込予約】  ".$cur_namae."様  ".$cur_email;
					$body  = '';
					$body .= 'メンバー登録で振込予約が発生しました。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= '会員番号：'.$cur_id;
					$body .= chr(10);
					$body .= 'メールアドレス：'.$cur_email;
					$body .= chr(10);
					$body .= 'お名前：'.$cur_namae;
					$body .= chr(10);
					$body .= 'フリガナ：'.$cur_furigana;
					$body .= chr(10);
					$body .= '電話番号：'.$cur_tel;
					$body .= chr(10);
					$body .= '';
					$from = mb_encode_mimeheader(mb_convert_encoding($cur_namae,"JIS"))."<".$dat_email.">";
					mb_send_mail('toiawase@jawhm.or.jp',$subject,$body,"From:".$from);

					// 確認メールを送信
					$subject = "登録料のお振込先をご案内します";
					$body  = '';
					$body .= '日本ワーキングホリデー協会です。';
					$body .= chr(10);
					$body .= 'メンバー登録ありがとうございます。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= '登録料のお振込先は以下の通りとなります。';
					$body .= chr(10);
					$body .= '銀行名　：　三井住友銀行 (0009)';
					$body .= chr(10);
					$body .= '支店名　：　新宿支店 (221)';
					$body .= chr(10);
					$body .= '口座番号：　普通　4246817';
					$body .= chr(10);
					$body .= '名義人　：　シャ）ニホンワーキングホリデーキョウカイ';
					$body .= chr(10);
					$body .= chr(10);
					$body .= '登録料　：　５，０００円';
					$body .= chr(10);
					$body .= '会員番号：　'.$cur_id;
					$body .= chr(10);
					$body .= '※振込手数料はご負担ください。';
					$body .= chr(10);
					$body .= '※本日より１週間以内にお振込みください。';
					$body .= chr(10);
					$body .= '※お振込時の振込人名は、お申込みご本人のお名前でお願い致します。';
					$body .= chr(10);
					$body .= '※また可能であれば、振込人名の名前の前に会員番号を付加してください。';
					$body .= chr(10);
					$body .= '　お振込み確認を確実に行うために、皆様のご協力をお願い致します。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= 'お手数ですが、振込後にご連絡を頂けますようお願い申し上げます。';
					$body .= chr(10);
					$body .= '電話番号：03-6304-5858';
					$body .= chr(10);
					$body .= 'メール：info@jawhm.or.jp';
					$body .= chr(10);
					$body .= '';
					$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
					mb_send_mail($dat_email,$subject,$body,"From:".$from);

					// 表示メッセージ
					$msg  = '';
					$msg .= 'ご登録頂きましたメールアドレスに、振込先口座情報をお送りしました。<br/>';
					$msg .= 'なお、お手数ですが、振込後に当協会までご連絡頂けますようお願い申し上げます。<br/>';
					$msg .= '';

				}

				if ($dat_tgt == 'conv')	{
					// コンビニ決済の場合

					// 社内通知
					$subject = "【メンバー登録：コンビニ決済予約】  ".$cur_namae."様  ".$cur_email;
					$body  = '';
					$body .= 'メンバー登録でコンビニ決済予約が発生しました。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= '会員番号：'.$cur_id;
					$body .= chr(10);
					$body .= 'メールアドレス：'.$cur_email;
					$body .= chr(10);
					$body .= 'お名前：'.$cur_namae;
					$body .= chr(10);
					$body .= 'フリガナ：'.$cur_furigana;
					$body .= chr(10);
					$body .= '電話番号：'.$cur_tel;
					$body .= chr(10);
					$body .= '';
					$from = mb_encode_mimeheader(mb_convert_encoding($cur_namae,"JIS"))."<".$dat_email.">";
					mb_send_mail($mailadd,$subject,$body,"From:".$from);

					// 社内通知
					$subject = "【メンバー登録：コンビニ決済予約】  ".$cur_namae."様  ".$cur_email;
					$body  = '';
					$body .= 'メンバー登録でコンビニ決済予約が発生しました。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= '会員番号：'.$cur_id;
					$body .= chr(10);
					$body .= 'メールアドレス：'.$cur_email;
					$body .= chr(10);
					$body .= 'お名前：'.$cur_namae;
					$body .= chr(10);
					$body .= 'フリガナ：'.$cur_furigana;
					$body .= chr(10);
					$body .= '電話番号：'.$cur_tel;
					$body .= chr(10);
					$body .= '';
					$from = mb_encode_mimeheader(mb_convert_encoding($cur_namae,"JIS"))."<".$dat_email.">";
					mb_send_mail('toiawase@jawhm.or.jp',$subject,$body,"From:".$from);

					// 確認メールを送信
					$subject = "登録料のお支払についてのご案内です";
					$body  = '';
					$body .= '日本ワーキングホリデー協会です。';
					$body .= chr(10);
					$body .= 'メンバー登録ありがとうございます。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= 'お選び頂きましたコンビニにてメンバー登録料のお支払をお願い致します。';
					$body .= chr(10);
					$body .= 'なお、コンビニでのお支払は本日より１４日以内にお願い致します。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= 'お支払が確認できましたら、ご登録の住所宛てに会員証をお送り致します。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= 'また、コンビニ端末等に事業所名として「株式会社デジタルチェック」と表示される場合がありますが、';
					$body .= chr(10);
					$body .= 'こちらは当協会メンバー登録料の収納代行会社の名前ですので、問題ありません。ご安心下さい。';
					$body .= chr(10);
					$body .= chr(10);
					$body .= 'ご不明点などあれば、以下にご連絡ください。';
					$body .= chr(10);
					$body .= '電話番号：03-6304-5858';
					$body .= chr(10);
					$body .= 'メール：info@jawhm.or.jp';
					$body .= chr(10);
					$body .= '';
					$from = mb_encode_mimeheader(mb_convert_encoding("日本ワーキングホリデー協会","JIS"))."<info@jawhm.or.jp>";
					mb_send_mail($dat_email,$subject,$body,"From:".$from);

					// 表示メッセージ
					$msg  = '';
					$msg .= 'メンバー登録料をご指定のコンビニでお支払ください。<br/>登録料のお支払が確認できた後、ご登録頂きました住所に会員証をお送り致します。<br/>';
					$msg .= '';

				}

				if ($dat_tgt == 'card')	{
					// カード払いの場合

					if ($cur_state == '1')	{
						// カード払いできてない！！

						$stepidx--;

						$msg  = '';
						$msg .= '&nbsp;<br/>';
						$msg .= '【ご注意】登録料のお支払が確認できません。<br/>';
						$msg .= '&nbsp;<br/>';
						$msg .= '別ウィンドウで表示れているカード決済ページでお支払をお願いいたします。<br/>';
						$msg .= '&nbsp;<br/>';

						$msg .= '<form class="cmxform" id="signupForm" method="post" action="./welcome.php?k='.$k.'">';
						$msg .= '<input type="hidden" name="act" value="s4">';
						$msg .= '<input type="hidden" name="userid" value="'.$dat_id.'">';
						$msg .= '<input type="hidden" name="email" value="'.$cur_email.'">';
						$msg .= '<input type="hidden" name="tgt" value="card">';
						$msg .= '<input class="submit" type="submit" value="再確認" style="width:150px; height:30px; margin:10px 0 10px 0; font-size:11pt; font-weight:bold;" />';
						$msg .= '</form>';

						$msg .= '';
						$msg .= '&nbsp;<br/>';
						$msg .= '&nbsp;<br/>';
						$msg .= 'なお、カード決済ページを閉じてしまった場合は、以下のボタンを押して支払方法を選択し直してください。<br/>';
						$msg .= '&nbsp;<br/>';

						$msg .= '<form class="cmxform" id="signupForm" method="post" action="./payment.php?k='.$k.'">';
						$msg .= '<input type="hidden" name="act" value="s3">';
						$msg .= '<input type="hidden" name="userid" value="'.$cur_id.'">';
						$msg .= '<input type="hidden" name="email" value="'.$cur_email.'">';
						$msg .= '<input type="hidden" name="mailcheck" value="'.$cur_mailcheck.'">';
						$msg .= '<input class="submit" type="submit" value="支払方法を選び直す" style="width:300px; height:20px; margin:18px 0 10px 0; font-size:11pt; font-weight:bold;" />';
						$msg .= '</form>';

					}else{

						$msg  = '';
						$msg .= 'クレジットカードでのお支払いが確認できました。<br/>';
						$msg .= '&nbsp;<br/>';
						$msg .= 'ご登録頂いた住所に会員証をお送りいたします。<br/>';
						$msg .= '';
						$msg .= '&nbsp;<br/>';
						$msg .= '&nbsp;<br/>';
						$msg .= '';

					}
				}
			}
		}
	}

	// 中断画面対応
	if ($act == 'p3')	{
		$act = 's3';
		$stepidx = 2;
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<?
	require_once '../include/menubar.php';
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>メンバー登録 | 日本ワーキング・ホリデー協会</title>

<meta name="keywords" content="オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館" />

<meta name="description" content="イベントカレンダー：オーストラリア・ニュージーランド・カナダを初めとしたワーキングホリデー協定国の最新のビザ取得方法や渡航情報などを発信しています。" />

<meta name="author" content="Japan Association for Working Holiday Makers" />
<meta name="copyright" content="Japan Association for Working Holiday Makers" />
<link rev="made" href="mailto:info@jawhm.or.jp" />
<link rel="Top" href="../index.html" type="text/html" title="ホームページ(最初のページ)" />
<link rel="Index" href="../index3.html" type="text/html" title="索引ページ" />
<link rel="Contents" href="../content.html" type="text/html" title="目次ページ" />
<link rel="Search" href="../search.html" type="text/html" title="検索できるページ" />
<link rel="Glossary" href="../glossar.html" type="text/html" title="用語解説ページ" />
<link rel="Help" href="file://///Landisk-a14f96/smithsonian/80.ワーキングホリデー協会/Info/help.html" type="text/html" title="ヘルプページ" />
<link rel="First" href="sample01.html" type="text/html" title="最初の文書へ " />
<link rel="Prev" href="sample02.html" type="text/html" title="前の文書へ" />
<link rel="Next" href="sample04.html" type="text/html" title="次の文書へ" />
<link rel="Last" href="sample05.html" type="text/html" title="最後の文書へ" />
<link rel="Up" href="../index2.html" type="text/html" title="一つ上の階層へ" />
<link rel="Copyright" href="../copyrig.html" type="text/html" title="著作権についてのページへ" />
<link rel="Author" href="mailto:info@jawhm.or.jp " title="E-mail address" />

<link id="calendar_style" href="./css/simple.css" media="screen" rel="Stylesheet" type="text/css" />
<script src="./js/prototype.js" type="text/javascript"></script>
<script src="./js/ajaxzip2/ajaxzip2.js" charset="UTF-8"></script>
<script src="./js/effects.js" type="text/javascript"></script>
<script src="./js/protocalendar.js" type="text/javascript"></script>
<script src="./js/lang_ja.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" media="screen" href="./css/screen.css" />
<script src="./js/jquery.js" type="text/javascript"></script>
<script src="./js/jquery.validate.js" type="text/javascript"></script>

<link href="../css/base.css" rel="stylesheet" type="text/css" />
<link href="../css/headhootg-nav.css" rel="stylesheet" type="text/css" />
<link href="../css/contents.css" rel="stylesheet" type="text/css" />


<script type="text/javascript">
jQuery.noConflict();
</script>
<? fncMenuScript(); ?>

<?
	if ($act == 's1')	{
		// Ｓ１　会員登録画面 ---------------------------------------------------------------------------------------　ここから
?>

<script type="text/javascript">
jQuery.validator.setDefaults({
	submitHandler: function()	{
		submit();
	}
});

jQuery().ready(function() {
	jQuery("#signupForm").validate({
		rules: {
			namae1: "required",
			namae2: "required",
			furigana1: "required",
			furigana2: "required",
			gender: "required",
			year: "required",
			month: "required",
			day: "required",
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			pcode: "required",
			add1: "required",
			add2: "required",
			add3: "required",
			tel: {
				required: true,
				number: true,
				minlength: 9,
				maxlength: 11,
			},
			agree: "required"
		},
		messages: {
			namae1: "<br/>お名前（氏）を入力してください",
			namae2: "<br/>お名前（名）を入力してください",
			furigana1: "<br/>フリガナ（氏）を入力してください",
			furigana2: "<br/>フリガナ（名）を入力してください",
			year: "(要選択)",
			month: "(要選択)",
			day: "(要選択)",
			email: "<br/>メールアドレスを入力してください",
			password: {
				required: "<br/>パスワードを入力してください",
				minlength: "<br/>パスワードは５文字以上で設定してください"
			},
			confirm_password: {
				required: "<br/>パスワードを再度入力してください",
				minlength: "<br/>パスワードは５文字以上で設定してください",
				equalTo: "<br/>上記のパスワードと異なります。確認してください。"
			},
			pcode: "郵便番号を入力してください",
			add1: "<br/>都道府県を入力してください",
			add2: "<br/>市区町村を入力してください",
			add3: "<br/>番地・建物名を入力してください",
			tel: {
				required: "<br/>電話番号を入力してください",
				number: "<br/>ハイフンの入力は不要です（電話番号は半角数字で入力してください）",
				minlength: "<br/>電話番号は９～１１桁で入力してください",
				maxlength: "<br/>電話番号は９～１１桁で入力してください（ハイフンは入力不要です）"
			},
			agree: "メンバー登録するには、メンバー規約への同意及びプライバシーポリシーをご確認頂く必要があります。<br/>"
		}
	});

});
</script>

<?
	// Ｓ１　会員登録画面 ---------------------------------------------------------------------------------------　ここまで
	}

	if ($act == 's3')	{
		// Ｓ３　メアド確認画面 ---------------------------------------------------------------------------------------　ここから
?>

<script type="text/javascript">
jQuery().ready(function() {
	jQuery("#signupForm").validate({
		rules: {
			mailcheck: "required"
		},
		messages: {
			mailcheck: "承認コードを入力してください"
		}
	});

});
</script>

<?
	// Ｓ３　メアド確認画面 ---------------------------------------------------------------------------------------　ここまで
	}
?>

<style type="text/css">
#signupForm { width: 860px; }
#signupForm label.error {
	margin-left: 10px;
	width: auto;
	display: none;
}
.entrytable	{
	font-size:11pt;
	border : 1px solid navy;
}
.entrytable tr	{
	border-top: 1px solid navy;
}
.dummy tr	{
	border-top: none;
}
.must	{
	color: red;
	font-weight: bold;
	font-size : 9pt;
}
.focus	{
	color:	#000000;
}
.td_flag	{
	background : #A7FFFF;
	font-size:11pt;
	padding: 0 10px 0 10px;
	width : 5%;
}
.td_tag		{
	background : #A7FFFF;
	font-size:11pt;
	width : 17%;
}
.td_method	{
	font-size : 9pt;
	background : #A7FFFF;
	text-align : right;
	padding-right : 5px;
	color : blue;
	width : 9%;
}
.td_input	{
	padding	: 10px 10px 10px 10px;
	background : white;
	border-left: 1px solid navy;
}
.sample	{
	font-size : 9pt;
	color : darkgray;
}
.postcode	{
	font-size:9pt;
}
.postcode a:visited	{
	color : red;
}
.postcode a:link	{
	color : red;
}
</style>
<style>
.tooltip	{
}
.tooltipmsg	{
	background: #ffc;
	border: 1px solid #fc6;
	font-size : 9pt;
	top: 0px;
	left: 0;
	text-align: left;
	padding: 8px 10px 10px 10px;
	margin: 5px 5px 0px 5px;
	z-index: 2;
	display: none;
}
</style>

<style>
.td_check_tag		{
	padding	: 2px 10px 2px 10px;
	background : #A7FFFF;
	font-size:11pt;
}
.td_check_input	{
	padding	: 2px 10px 2px 10px;
	background : white;
}
</style>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20563699-1']);
  _gaq.push(['_setDomainName', '.jawhm.or.jp']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script>
jQuery(function(){
     jQuery(".focus").focus(function(){
          if(this.getAttribute('pre') == "1"){
		this.setAttribute('pre','0')
		jQuery(this).val("").css("color","#000000");
          }
     });
     jQuery(".tooltip img").hover(function() {
        jQuery(this).next("div").animate({opacity: "show", top: "0"}, "fast");}, function() {
               jQuery(this).next("div").animate({opacity: "hide", top: "0"}, "fast");
     });
});
function fncClearFields()	{
	var obj = document.getElementsByClassName('focus');
	for (idx=0; idx<obj.length; idx++)	{
		if (obj[idx].getAttribute('pre') == '1')	{
			obj[idx].value = '';
		}
	}
}
</script>

</head>

<body>

<? fncMenuHead_nolink('<img id="top-mainimg" src="../images/mem-topbanner.jpg" alt="" width="970" height="170" />'); ?>

  <div id="contentsbox"><img id="bgtop" src="../images/contents-bgtop.gif" alt="" />
  <div id="contentswide">

<? // fncMenubar(); ?>

	<div id="maincontentwide">

<?

	if ($k == 'KT')	{
		echo '<div style="font-size:22pt; color:white; background-color:navy; padding:5px 20px 5px 20px; margin: 0 0 10px 20px;">関東エリア登録</div>';
	}
	if ($k == 'KO')	{
		echo '<div style="font-size:22pt; color:white; background-color:navy; padding:5px 20px 5px 20px; margin: 0 0 10px 20px;">関西エリア登録</div>';
	}
	if ($k == 'KK')	{
		echo '<div style="font-size:22pt; color:white; background-color:navy; padding:5px 20px 5px 20px; margin: 0 0 10px 20px;">沖縄エリア登録</div>';
	}


	$step = array();
	$step[] = 'STEP1';
	$step[] = 'STEP2';
	$step[] = 'STEP3';
	$step[] = 'STEP4';
	$step[] = 'STEP5';

	$newpwd = getRandomString(10);

	if ($stepidx+1 == 1)	{
?>
		<p style="margin:20px 20px 0px 30px; padding: 5px 0 5px 10px; font-size:11pt; font-weight:bold; background-color:aqua; color:navy;">
			メンバー登録の手順
		</p>
<?
	}

	$step[$stepidx] = '<span style="font-size:14pt; font-weight:bold;">STEP'.($stepidx+1).'</span>';

	for ($idx=0; $idx<count($step); $idx++)	{
//		echo $step[$idx].'&nbsp;&nbsp; --> &nbsp;&nbsp; ';
	}
	echo '
<div style="margin:10px 0 0 30px;">
	<table>
		<tr>
			<td width="169px" style="text-align:center;">';
				if ($stepidx+1 == 1)	{ print '<img src="images/now.gif">';	}
	echo '
			</td>
			<td width="169px" style="text-align:center;">';
				if ($stepidx+1 == 2)	{ print '<img src="images/now.gif">';	}
	echo '
			</td>
			<td width="169px" style="text-align:center;">';
				if ($stepidx+1 == 3)	{ print '<img src="images/now.gif">';	}
	echo '
			</td>
			<td width="169px" style="text-align:center;">';
				if ($stepidx+1 == 4)	{ print '<img src="images/now.gif">';	}
	echo '
			</td>
			<td width="169px" style="text-align:center;">';
				if ($stepidx+1 == 5)	{ print '<img src="images/now.gif">';	}
	echo '
			</td>
		</tr>
	</table>
	<img src="images/step0'.($stepidx+1).'.gif">
	<table style="font-size:8pt;">
		<tr>
			<td width="169px" style="vertical-align:top;">
				<div style="padding: 0 10px 0 8px;">
					<span style="color:red;">●</span>
					メンバー登録に必要な情報をご入力いただきます。
					入力漏れがある場合は、エラーの内容が表示されます。
				</div>
			</td>
			<td width="169px" style="vertical-align:top;">
				<div style="padding: 0 10px 0 8px;">
					<span style="color:red;">●</span>
					入力いただいた情報に間違いがないかご確認して頂きます。
				</div>
			</td>
			<td width="169px" style="vertical-align:top;">
				<div style="padding: 0 8px 0 0px;">';
		if ($k <> '')	{
			echo '		<span style="color:red;">●</span>
					STEP1で入力頂いたメールアドレスへメールが自動送信されます。<br/>';
		}else{
			echo '		<span style="color:red;">●</span>
					STEP1で入力頂いたメールアドレスへメールが自動送信されます。<br/>
					<span style="color:red;">●</span>
					メールに記載された承認コードを入力し、承認手続きを完了させてください。';
		}
	echo '
				</div>
			</td>
			<td width="169px" style="vertical-align:top;">
				<div style="padding: 0 10px 0 8px;">
					<span style="color:red;">●</span>
					登録料のお支払い方法を選択し、支払いをお願いします。<br/>
					クレジットカード払い、コンビニ払い、銀行振込からお選び頂けます。
				</div>
			</td>
			<td width="169px" style="vertical-align:top;">
				<div style="padding: 0 10px 0 8px;">
					<span style="color:red;">●</span>
					お支払い手続きが終わったら登録完了です。
					早速、メンバーページへログインしてワーホリの準備を始めましょう。
				</div>
			</td>
		</tr>
	</table>
</div>
';

	if ($act == 's1')	{
		// Ｓ１　会員登録画面 ---------------------------------------------------------------------------------------　ここから

?>


<div style="padding-left:30px; float:clear;">

<!--

	<p style="margin:20px 20px 16px 0; padding: 5px 0 5px 10px; font-size:11pt; font-weight:bold; background-color:aqua; color:navy;">
		メンバー登録とは
	</p>
	<p style="margin:10px 0 8px 0; font-size:10pt; float:clear;">
		メンバー登録とは、日本ワーキング・ホリデー協会によるワーホリ成功の為のメンバーサポート制度です。<br/>
		メンバーになると個別カウンセリングや特別セミナーへの参加、ビザ取得サポート、出発前の準備、到着後のサポートまで個別にフルサポート致します。<br/>
		<span style="color:red;">●</span>　メンバー登録料は５，０００円（３年間有効）となります。<br/>
	</p>
-->

	<p style="margin:20px 20px 16px 0; padding: 5px 0 5px 10px; font-size:11pt; font-weight:bold; background-color:aqua; color:navy;">
		お客様情報をご入力下さい　　　　　　　<span style="font-size:8pt; font-weight:normal; color:black;"><img src="images/hissu.gif">　は必須項目です</span>
	</p>

<form class="cmxform" id="signupForm" method="post" action="./check.php?k=<? echo $k; ?>" onsubmit="fncClearFields();">
	<input type="hidden" name="act" value="<? echo $act; ?>">
	<input type="hidden" name="kyoten" value="<? echo $k; ?>">
	<table class="entrytable">
		<tr>
			<td class="td_flag">
				<img src="images/hissu.gif">
			</td>
			<td class="td_tag">
				メールアドレス
			</td>
			<td class="td_method">[半角英数字]</td>
			<td class="td_input">
				<input id="email" name="email" size="36" maxlength="80" value="" class="focus" pre="0" />
				&nbsp;
				<span class="tooltip">
					<img style="cursor:pointer;" src="images/hatena.gif" />
					<div class="tooltipmsg">
						※ログイン用のメールアドレスとなります<br/>
						※携帯電話でのメールアドレスをご使用の場合、<br/>　jawhm.or.jpドメインからのメールを受信できるように設定を確認してください<br/>
						※次のようなメールアドレスはご利用いただけません。<br/>
						　１．メールアドレスの @ の直前にピリオド (.) がある<br/>
						　２． @ より前でピリオドが連続する<br/>
						　恐れ入りますが、他のメールアドレスでご登録ください。<br/>
					</div><br/>
				</span>
				<span class="sample">例） mail@jawhm.or.jp</span>
				<div class="postcode">
					※ご確認のメールをお送りしますので、連絡可能なメールアドレスを入力してください。
				</div>
			</td>
		</tr>
<?	if ($k == '')	{	?>
		<tr>
			<td class="td_flag">
				<img src="images/hissu.gif">
			</td>
			<td class="td_tag">
				パスワード
			</td>
			<td class="td_method">[半角英数字]</td>
			<td class="td_input">
				<div class="postcode">
					※登録後、メンバー専用ページへのログインの際に必要となります。<br/>
				</div>
				<input id="password" name="password" type="password" maxlength="20" />
				&nbsp;
				<span class="tooltip">
					<img style="cursor:pointer;" src="images/hatena.gif" />
					<div class="tooltipmsg">
						※メンバー専用ページにログインする際のパスワードとなります。<br/>
					</div>
				</span>
				<div class="postcode">
					※半角英数字５～２０文字で入力してください。
				</div>
				<input id="confirm_password" name="confirm_password" type="password" maxlength="20" />
				<div class="postcode">
					※確認の為、同じパスワードを入力してください。
				</div>
			</td>
		</tr>
<?	}else{			?>
		<input id="password" name="password" type="hidden" maxlength="20" value="<? echo $newpwd; ?>" />
		<input id="confirm_password" name="confirm_password" type="hidden" maxlength="20" value="<? echo $newpwd; ?>" />
<?	}			?>
		<tr>
			<td class="td_flag">
				<img src="images/hissu.gif">
			</td>
			<td class="td_tag">
				お名前
			</td>
			<td class="td_method">[全角]</td>
			<td class="td_input">
				<table class="dummy">
					<tr>
						<td style="vertical-align:top;">
							　姓 <input id="namae1" name="namae1" maxlength="20" size="10" value="" class="focus" pre="0" />
						</td>
						<td style="vertical-align:top;">
							　　名 <input id="namae2" name="namae2" maxlength="20" size="10" value="" class="focus" pre="0" />
						</td>
						<td style="vertical-align:top;">　様</td>
					</tr>
						<td>
							<span class="sample">　　例） 山田</span>
						</td>
						<td>
							<span class="sample">　　例） 太郎</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="td_flag">
				<img src="images/hissu.gif">
			</td>
			<td class="td_tag">
				フリガナ
			</td>
			<td class="td_method">[全角カナ]</td>
			<td class="td_input">
				<table class="dummy">
					<tr>
						<td style="vertical-align:top;">
							セイ <input id="furigana1" name="furigana1" maxlength="20" size="10" value="" class="focus" pre="0" />
						</td>
						<td style="vertical-align:top;">
							　メイ <input id="furigana2" name="furigana2" maxlength="20" size="10" value="" class="focus" pre="0" />
						</td>
						<td style="vertical-align:top;">　サマ</td>
					</tr>
						<td>
							<span class="sample">　　例） ヤマダ</span>
						</td>
						<td>
							<span class="sample">　　例） タロウ</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="td_flag">
				<img src="images/hissu.gif">
			</td>
			<td class="td_tag">
				性別
			</td>
			<td class="td_method"></td>
			<td class="td_input">
				<input type="radio" id="gender_male" value="m" name="gender" validate="required:true" />男性 &nbsp;&nbsp;
				<input type="radio" id="gender_female" value="f" name="gender" checked/>女性
				<label for="gender" class="error">性別を選択してください</label>
			</td>
		</tr>
		<tr>
			<td class="td_flag">
				<img src="images/hissu.gif">
			</td>
			<td class="td_tag">
				生年月日
			</td>
			<td class="td_method"></td>
			<td class="td_input">
				<select id="y" name="year">
					<option value="">--</option><option value="1970">1970</option>
					<option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option>
					<option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980" selected>1980</option>
					<option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option>
					<option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option>
					<option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option>
					<option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option>
					<option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option>
				</select>年
				<select id="m" name="month">
					<option value="">--</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option>
				</select>月
				<select id="d" name="day">
					<option value="">--</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>
				</select>日
				<img src="./images/icon_calendar.gif" id="select_date_calendar_icon"/>
				&nbsp;
				<span class="tooltip">
					<img style="cursor:pointer;" src="images/hatena.gif" />
					<div class="tooltipmsg">
						※カレンダーアイコンをクリックして簡単に選択して頂くこともできます。
					</div>
				</span>
			</td>
		</tr>
		<tr>
			<td class="td_flag">
				<img src="images/hissu.gif">
			</td>
			<td class="td_tag">
				郵便番号
			</td>
			<td class="td_method">[半角数字]</td>
			<td class="td_input">
				<input id="pcode" name="pcode" size=10 maxlength="10" value="" class="focus" pre="0" onKeyUp="AjaxZip2.zip2addr(this,'add1','add2',null,'add2');" />
				<span class="sample">例） 160-0023</span>
				<div class="postcode">
					郵便番号をご入力頂くと、ご住所が自動で入力されます。　<span style="color:red;">[ <a target="_new" href="http://www.post.japanpost.jp/zipcode/" tabindex="-1">〒郵便番号検索ページへ</a> ]</span>
				</div>
			</td>
		</tr>
		<tr style="border-top:none;">
			<td class="td_flag">
				<img src="images/hissu.gif">
			</td>
			<td class="td_tag">
				都道府県
			</td>
			<td class="td_method">[全角]</td>
			<td class="td_input">
				<input id="add1" name="add1" size=20 maxlength="80" value="" class="focus" pre="0" /><br/><span class="sample">例） 東京都</span>
			</td>
		</tr>
		<tr style="border-top:none;">
			<td class="td_flag">
				<img src="images/hissu.gif">
			</td>
			<td class="td_tag">
				市区町村
			</td>
			<td class="td_method">[全角]</td>
			<td class="td_input">
				<input id="add2" name="add2" size=50 maxlength="80" value="" class="focus" pre="0" /><br/><span class="sample">例） 新宿区西新宿</span>
			</td>
		</tr>
		<tr style="border-top:none;">
			<td class="td_flag">
				<img src="images/hissu.gif">
			</td>
			<td class="td_tag">
				番地・建物名
			</td>
			<td class="td_method">[全角]</td>
			<td class="td_input">
				<input id="add3" name="add3" size=50 maxlength="80" value="" class="focus" pre="0" />
				&nbsp;
				<span class="tooltip">
					<img style="cursor:pointer;" src="images/hatena.gif" />
					<div class="tooltipmsg">
						※海外からの場合、国名を「都道府県」の欄に入力し<br/>
						　残りの住所を「市区町村」「番地・建物名」に入力してください<br/>
					</div>
				</span>
				<br/><span class="sample">例） １－３－３　ステーションビル５０７</span>
				<div class="postcode">
					※メンバーズカードをお送りします。<br/>
					　宛先不明でカードがお送り出来ない事が多くあります。必ず<b>アパート・マンション名など</b>も入力してください。<br/>
				</div>
			</td>
		</tr>
		<tr>
			<td class="td_flag">
				<img src="images/hissu.gif">
			</td>
			<td class="td_tag">
				電話番号
			</td>
			<td class="td_method">[半角数字]</td>
			<td class="td_input">
				<input id="tel" name="tel" maxlength="30" value="" class="focus" pre="0" />
				<br/><span class="sample">例） 0363045858</span>
				<div class="postcode">
					※ハイフンは<b>入力不要</b>です。
				</div>
			</td>
		</tr>
		<tr>
			<td class="td_flag">
			</td>
			<td class="td_tag">
				職業
			</td>
			<td class="td_method"></td>
			<td class="td_input">
				<input type="radio" class="radio" name="job" value="会社員">&nbsp;会社員
				&nbsp;&nbsp;
				<input type="radio" class="radio" name="job" value="派遣">&nbsp;派遣
				&nbsp;&nbsp;
				<input type="radio" class="radio" name="job" value="アルバイト">&nbsp;アルバイト
				&nbsp;&nbsp;
				<input type="radio" class="radio" name="job" value="学生">&nbsp;学生
				&nbsp;&nbsp;
				<input type="radio" class="radio" name="job" value="無職">&nbsp;無職
				&nbsp;&nbsp;
				<input type="radio" class="radio" name="job" value="その他">&nbsp;その他
				<br/>
			</td>
		</tr>
		<tr>
			<td class="td_flag">
			</td>
			<td class="td_tag">
				渡航予定国
			</td>
			<td class="td_method"></td>
			<td class="td_input">
				<input type="checkbox" class="checkbox" name="c1" value="オーストラリア">&nbsp;オーストラリア
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="c2" value="ニュージーランド">&nbsp;ニュージーランド
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="c3" value="カナダ">&nbsp;カナダ
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="c4" value="韓国">&nbsp;韓国
				<br/>
				<input type="checkbox" class="checkbox" name="c5" value="フランス">&nbsp;フランス
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="c6" value="ドイツ">&nbsp;ドイツ
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="c7" value="イギリス">&nbsp;イギリス
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="c8" value="アイルランド">&nbsp;アイルランド
				<br/>
				<input type="checkbox" class="checkbox" name="c9" value="デンマーク">&nbsp;デンマーク
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="c10" value="台湾">&nbsp;台湾
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="c11" value="香港">&nbsp;香港
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="c12" value="未定">&nbsp;未定
				<br/>
			</td>
		</tr>
		<tr>
			<td class="td_flag">
			</td>
			<td class="td_tag">
				渡航予定国の語学力
			</td>
			<td class="td_method"></td>
			<td class="td_input">
				<input type="radio" class="radio" name="gogaku" value="堪能">&nbsp;堪能
				&nbsp;&nbsp;
				<input type="radio" class="radio" name="gogaku" value="日常会話">&nbsp;日常会話
				&nbsp;&nbsp;
				<input type="radio" class="radio" name="gogaku" value="挨拶程度">&nbsp;挨拶程度
				&nbsp;&nbsp;
				<input type="radio" class="radio" name="gogaku" value="全然できない">&nbsp;全然できない
				&nbsp;&nbsp;
				<input type="radio" class="radio" name="gogaku" value="その他">&nbsp;その他
				<br/>
			</td>
		</tr>
		<tr>
			<td class="td_flag">
			</td>
			<td class="td_tag">
				渡航目的
			</td>
			<td class="td_method"></td>
			<td class="td_input">
				<input type="checkbox" class="checkbox" name="p1" value="観光">&nbsp;観光
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="p2" value="語学上達のため">&nbsp;語学上達のため
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="p3" value="将来のキャリアアップ">&nbsp;将来のキャリアアップ
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="p4" value="海外生活体験">&nbsp;海外生活体験
				<br/>
				<input type="checkbox" class="checkbox" name="p5" value="現地調査">&nbsp;現地調査
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="p6" value="研究">&nbsp;研究
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="p7" value="その他">&nbsp;その他
				<br/>
			</td>
		</tr>
		<tr>
			<td class="td_flag">
			</td>
			<td class="td_tag">
				どこで当協会を<br/>　　　知りましたか
			</td>
			<td class="td_method"></td>
			<td class="td_input">
				<input type="checkbox" class="checkbox" name="k1" value="協会ホームページ">&nbsp;協会ホームページ
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="k2" value="留学エージェントの紹介">&nbsp;留学エージェントの紹介
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="k3" value="書籍・雑誌">&nbsp;書籍・雑誌
				<br/>
				<input type="checkbox" class="checkbox" name="k4" value="友人の紹介">&nbsp;友人の紹介
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="k5" value="大使館の紹介">&nbsp;大使館の紹介
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="k6" value="学校の紹介">&nbsp;学校の紹介
				&nbsp;&nbsp;&nbsp;
				<input type="checkbox" class="checkbox" name="k7" value="その他">&nbsp;その他
				<br/>
			</td>
		</tr>
		<tr>
			<td class="td_flag">
			</td>
			<td class="td_tag">
				今後のご案内
			</td>
			<td class="td_method"></td>
			<td class="td_input">
				今後、セミナーやイベントのご案内等をお送りしてもよろしいですか？<br/>
				<input type="radio" class="radio" name="mailsend" value="1" checked>&nbsp;受け取る
				&nbsp;&nbsp;
				<input type="radio" class="radio" name="mailsend" value="0">&nbsp;受け取らない
			</td>
		</tr>

		<tr>
			<td class="td_flag">
				<img src="images/hissu.gif">
			</td>
			<td class="td_tag">
				メンバー規約と<br/>プライバシーポリシー
			</td>
			<td class="td_method"></td>
			<td class="td_input">
				【　メンバー規約　】
				<iframe src="kiyaku1.html" style="height:160px; width:100%; border:1px solid gray;"></iframe>

				【　プライバシーポリシー　】
				<iframe src="kiyaku2.html" style="height:160px; width:100%; border:1px solid gray;"></iframe>

				&nbsp;<br/>
				<input type="checkbox" class="checkbox" id="agree" name="agree" value="同意" />&nbsp;&nbsp;「メンバー規約」に同意し、「プライバシーポリシー」を確認しました。<br/>
				&nbsp;<br/>
			</td>
		</tr>

	</table>

	<input class="submit" type="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 30px 600px; font-size:11pt; font-weight:bold;" />

</form>

</div>

<script type="text/javascript">
SelectCalendar.createOnLoaded({yearSelect: 'y',
	monthSelect: 'm',
	daySelect: 'd'
},
{
	startYear: 1970,
	endYear: 2005,
	lang: 'ja',
	triggers: ['select_date_calendar_icon']
});
</script>

<?
	// Ｓ１　会員登録画面 ---------------------------------------------------------------------------------------　ここまで
	}
	if ($act == 's2')	{
		// Ｓ２　メアド確認画面 ---------------------------------------------------------------------------------------　ここから
?>


<div style="padding-left:30px;">
	<p style="margin:20px 20px 16px 0; padding: 5px 0 5px 10px; font-size:11pt; font-weight:bold; background-color:aqua; color:navy;">
		入力頂いた内容を確認の上、よろしければ「次へ」をクリックしてください。
	</p>

	<table style="font-size:11pt;" border="1" bordercolor="navy">
		<tr>
			<td class="td_check_tag">メールアドレス</td>
			<td class="td_check_input" width="400"><? echo $dat_email; ?></td>
		</tr>
		<tr>
			<td class="td_check_tag">お名前</td>
			<td class="td_check_input"><? echo $dat_namae; ?></td>
		</tr>
		<tr>
			<td class="td_check_tag">フリガナ</td>
			<td class="td_check_input"><? echo $dat_furigana; ?></td>
		</tr>
		<tr>
			<td class="td_check_tag">性別</td>
			<td class="td_check_input">
				<? if ($dat_gender == 'm')	{ echo '男性'; } else { echo '女性'; }	?>
			</td>
		</tr>
		<tr>
			<td class="td_check_tag">生年月日</td>
			<td class="td_check_input">
				<? echo $dat_year.'年 '.$dat_month.'月 '.$dat_day.'日'; ?>
			</td>
		</tr>
		<tr>
			<td class="td_check_tag">現住所</td>
			<td class="td_check_input">
				<table>
				<tr>
					<td>郵便番号</td>
					<td>　　<? echo $dat_pcode; ?></td>
				</tr>
				<tr>
					<td>都道府県</td>
					<td>　　<? echo $dat_add1; ?></td>
				</tr>
				<tr>
					<td>市区町村</td>
					<td>　　<? echo $dat_add2; ?></td>
				</tr>
				<tr>
					<td>番地・建物名</td>
					<td>　　<? echo $dat_add3; ?></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="td_check_tag">電話番号</td>
			<td class="td_check_input"><? echo $dat_tel; ?></td>
		</tr>
		<tr>
			<td class="td_check_tag">職業</td>
			<td class="td_check_input"><? echo $dat_job; ?></td>
		</tr>
		<tr>
			<td class="td_check_tag">渡航予定国</td>
			<td class="td_check_input"><? echo $dat_country; ?></td>
		</tr>
		<tr>
			<td class="td_check_tag">渡航予定国の語学力</td>
			<td class="td_check_input"><? echo $dat_gogaku; ?></td>
		</tr>
		<tr>
			<td class="td_check_tag">渡航目的</td>
			<td class="td_check_input"><? echo $dat_purpose; ?></td>
		</tr>
		<tr>
			<td class="td_check_tag">どこで当協会を知りましたか</td>
			<td class="td_check_input"><? echo $dat_know; ?></td>
		</tr>
		<tr>
			<td class="td_check_tag">今後のご案内</td>
			<td class="td_check_input">
				<? if ($dat_mailsend == '1') { echo '受け取る'; } else { echo '受け取らない'; }	?>
			</td>
		</tr>
	</table>

<form class="cmxform" id="signupForm" method="post" action="./confirm.php?k=<? echo $k; ?>">
	<input type="hidden" name="act" value="<? echo $act; ?>">
	<input type="hidden" name="kyoten" value="<? echo $dat_kyoten; ?>">
	<input type="hidden" name="email" value="<? echo $dat_email; ?>">
	<input type="hidden" name="password" value="<? echo $dat_password; ?>">
	<input type="hidden" name="namae" value="<? echo $dat_namae; ?>">
	<input type="hidden" name="furigana" value="<? echo $dat_furigana; ?>">
	<input type="hidden" name="gender" value="<? echo $dat_gender; ?>">
	<input type="hidden" name="year" value="<? echo $dat_year; ?>">
	<input type="hidden" name="month" value="<? echo $dat_month; ?>">
	<input type="hidden" name="day" value="<? echo $dat_day; ?>">
	<input type="hidden" name="pcode" value="<? echo $dat_pcode; ?>">
	<input type="hidden" name="add1" value="<? echo $dat_add1; ?>">
	<input type="hidden" name="add2" value="<? echo $dat_add2; ?>">
	<input type="hidden" name="add3" value="<? echo $dat_add3; ?>">
	<input type="hidden" name="tel" value="<? echo $dat_tel; ?>">
	<input type="hidden" name="job" value="<? echo $dat_job; ?>">
	<input type="hidden" name="country" value="<? echo $dat_country; ?>">
	<input type="hidden" name="gogaku" value="<? echo $dat_gogaku; ?>">
	<input type="hidden" name="purpose" value="<? echo $dat_purpose; ?>">
	<input type="hidden" name="know" value="<? echo $dat_know; ?>">
	<input type="hidden" name="mailsend" value="<? echo $dat_mailsend; ?>">
	<input type="hidden" name="agree" value="<? echo $dat_agree; ?>">

	<input type=button class="back" value="<< 戻る" onclick="history.back();" style="width:150px; height:30px; margin:18px 0 10px 20px; font-size:11pt; font-weight:bold;">
<?	if ($chk == 'ok')	{	?>
	<input type=submit class="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 10px 0; font-size:11pt; font-weight:bold;">
<?	}	?>
</form>

</div>

<script type="text/javascript">


</script>
<?
	}
	if ($act == 's3')	{
		// Ｓ３　メアド確認画面 ---------------------------------------------------------------------------------------　ここから
?>

<?	if ($k == '')	{	?>

	<div style="padding-left:30px;">
		<p style="margin:20px 20px 16px 0; padding: 5px 0 5px 10px; font-size:11pt; font-weight:bold; background-color:aqua; color:navy;">
			メールをご確認の上、承認コードを入力してください
		</p>
		<p>
			ご入力頂いたメールアドレス ( <? echo $dat_email; ?> ) に、承認コードをお送りしました。<br/>
			メールをご覧になり、以下の内容を入力してください。<br/>
		</p>
		&nbsp;<br/>
		<p>
			なお、承認コードは「５桁の半角英数字」のコードです。
		</p>

	<?
		if ($msg <> '')	{
			echo '<p style="font-size:11pt; font-weight:bold; margin:15px 50px 15px 0; padding: 10px 20px 10px 20px; color:white; background-color:orange;">'.$msg.'</p>';
		}
	?>

	<form class="cmxform" id="signupForm" method="post" action="./payment.php?k=<? echo $k; ?>">
		<input type="hidden" name="act" value="<? echo $act; ?>">
		<input type="hidden" name="userid" value="<? echo $dat_id; ?>">
		<input type="hidden" name="email" value="<? echo $dat_email; ?>">
		<table style="font-size:10pt; margin:20px 0 10px 20px;" border="0">
			<tr>
				<td>承認コード　　</td>
				<td>
					<input id="mailcheck" name="mailcheck" maxlength="20" /><br/>
				</td>
			</tr>
		</table>
		<input type=button class="back" value="<< 戻る" onclick="history.back();" style="width:150px; height:30px; margin:18px 0 10px 20px; font-size:11pt; font-weight:bold;">
		<input class="submit" type="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 10px 0; font-size:11pt; font-weight:bold;" />
	</form>
	</div>
<?	}else{		?>

	<div style="padding-left:30px;">
		<p style="margin:20px 0 10px 0;">
			ご入力頂いたメールアドレス(　<? echo $dat_email; ?>　)に、確認メールをお送りしました。<br/>
			&nbsp;<br/>
			下の「次へ」をクリックして、メンバー登録料のお支払方法を選択してください。<br/>
		</p>

	<?
		if ($msg <> '')	{
			echo '<p style="font-size:11pt; font-weight:bold; margin:15px 50px 15px 0; color:white; background-color:orange;">'.$msg.'</p>';
		}
	?>

	<form class="cmxform" id="signupForm" method="post" action="./payment.php?k=<? echo $k; ?>">
		<input type="hidden" name="act" value="<? echo $act; ?>">
		<input type="hidden" name="userid" value="<? echo $dat_id; ?>">
		<input type="hidden" name="email" value="<? echo $dat_email; ?>">
		<input type="hidden" id="mailcheck" name="mailcheck" value="dummydata" maxlength="20" /><br/>
		<input type=button class="back" value="<< 戻る" onclick="history.back();" style="width:150px; height:30px; margin:18px 0 10px 20px; font-size:11pt; font-weight:bold;">
		<input class="submit" type="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 10px 0; font-size:11pt; font-weight:bold;" />
	</form>
	</div>

<?	}		?>

<?
	// Ｓ３　メアド確認画面 ---------------------------------------------------------------------------------------　ここまで
	}

	if ($act == 's4')	{
		// Ｓ４　支払処理 ---------------------------------------------------------------------------------------　ここから
?>

<div style="padding-left:30px;">
	<p style="margin:20px 20px 16px 0; padding: 5px 0 5px 10px; font-size:11pt; font-weight:bold; background-color:aqua; color:navy;">
		メンバー登録料のお支払手続きをお願いします
	</p>

<?
	if ($msg <> '')	{
		echo '<p style="font-size:11pt; font-weight:bold; margin:15px 50px 15px 0; color:white; background-color:orange;">'.$msg.'</p>';
	}
?>

&nbsp;<br/>
<div id="div_cc">
	<p>
		メールアドレスの確認ができました。
	</p>
	&nbsp;<br/>
	<p>
		引き続き、登録料のお支払手続きに入ります。お支払方法を選択してください。<br/>
	</p>
	<div style="border:1px solid navy; margin: 20px 80px 20px 0; padding: 18px 20px 10px 20px;">
		<p>
			【クレジットカードでお支払の場合】<br/>
			当協会では、クレジットカードのお支払の場合、株式会社デジタルチェックのシステムを利用しております。<br/>
			以下の「カード決済ページへ」のボタンをクリックして、支払手続きをお願いいたします。<br/>
			<strong>クレジットカードのお支払は SSLというシステムを利用しております。カード番号等の情報は暗号化されて送信されます。ご安心下さい。</strong><br/>
			※なお、カード決済ページは別ウィンドウで開きます。<br/>

                        <div style="text-align:center;margin:15px 0 0 0;"><img src="images/creditcard_rogo.gif" ></div>
		</p>
		<p style="color:red; font-weight:bold;">
			&nbsp;<br/>
			【ご注意】<br/>
			クレジットカードでお支払の場合、ＶＩＳＡ（ビザ）又はＭＡＳＴＥＲ（マスター）のマークがあるカードのみご利用頂けます。<br/>
		</p>
		<div>
			<form method="post" action="https://www.digitalcheck.jp/settle/settle3/bp3.dll" target="_blank" accept-charset="Shift_JIS" onsubmit="document.charset='SHIFT-JIS';fncCCScript();">
				<input type="hidden" name="IP" value="A363045858">
				<input type="hidden" name="SID" value="<? echo $dat_sid_card; ?>">
				<input type="hidden" name="FUKA" value="<? echo $dat_id; ?>">
				<input type="hidden" name="NAME1" value="<? echo $dat_name1; ?>">
				<input type="hidden" name="NAME2" value="<? echo $dat_name2; ?>">
				<input type="hidden" name="TEL" value="<? echo $dat_tel; ?>">
				<input type="hidden" name="ADR1" value="<? echo $dat_adr1; ?>">
				<input type="hidden" name="ADR2" value="<? echo $dat_adr2; ?>">
				<input type="hidden" name="MAIL" value="<? echo $dat_email; ?>">
				<input type="hidden" name="N1" value="JAWHM MEMBERSHIP FEE">
				<input type="hidden" name="K1" value="5000">
				<input type="hidden" name="STORE" value="51">
				<input type="hidden" name="KAKUTEI" value="1">
				<input type="submit" value="クレジットカードでお支払の場合はこちら" style="width:350px; height:30px; margin:18px 0 10px 180px; font-size:11pt; font-weight:bold;">
			</form>

		</div>
	</div>
	<div style="border:1px solid navy; margin: 20px 80px 20px 0; padding: 18px 20px 10px 20px;">
		<p>
			【コンビニでお支払の場合】<br/>
			当協会では、コンビニでのお支払の場合、株式会社デジタルチェックのシステムを利用しております。<br/>
			以下の「コンビニ決済ページへ」のボタンをクリックして、支払手続きをお願いいたします。<br/>

			※なお、コンビニ決済ページは別ウィンドウで開きます。<br/>
                        <div style="text-align:center;margin:15px 0 0 0;"><img src="images/convenience_rogo.gif" ></div>
		</p>
		<p style="color:red; font-weight:bold;">
			&nbsp;<br/>
			【ご注意】<br/>
			決済手数料（218円）はお客様のご負担となります。（コンビニ店頭で、5,218円をお支払下さい。）<br/>
			また、コンビニ端末で、事業所名に「株式会社デジタルチェック」と表示される場合がありますが、問題ありません。<br/>
			株式会社デジタルチェックは、メンバー登録料の収納代行会社の名前です。<br/>
		</p>
		<div>
			<form method="post" action="https://www.digitalcheck.jp/settle/settle3/bp3.dll" target="_blank" accept-charset="Shift_JIS" onsubmit="document.charset='SHIFT-JIS';fncCVScript();">
				<input type="hidden" name="IP" value="D363045858">
				<input type="hidden" name="SID" value="<? echo $dat_sid; ?>">
				<input type="hidden" name="FUKA" value="<? echo $dat_id; ?>">
				<input type="hidden" name="NAME1" value="<? echo $dat_name1; ?>">
				<input type="hidden" name="NAME2" value="<? echo $dat_name2; ?>">
				<input type="hidden" name="TEL" value="<? echo $dat_tel; ?>">
				<input type="hidden" name="ADR1" value="<? echo $dat_adr1; ?>">
				<input type="hidden" name="ADR2" value="<? echo $dat_adr2; ?>">
				<input type="hidden" name="MAIL" value="<? echo $dat_email; ?>">
				<input type="hidden" name="N1" value="日本ワーキングホリデー協会メンバー登録料">
				<input type="hidden" name="K1" value="5218">
				<input type="hidden" name="TAX" value="238">
				<input type="hidden" name="STORE" value="99">
				<input type="submit" value="コンビニでお支払の場合はこちら" style="width:350px; height:30px; margin:18px 0 10px 180px; font-size:11pt; font-weight:bold;">
			</form>

		</div>
	</div>
	<div style="border:1px solid navy; margin: 20px 80px 20px 0; padding: 18px 20px 10px 20px;">
		<p>
			【銀行振込でお支払の場合】<br/>
			銀行振込で登録料をお支払の場合、以下の口座をご利用ください。<br/>
			なお、１週間以内にお振込をお願い致します。<br/>
                        <div style="text-align:center;margin:15px 0 0 0;"><img src="images/hurikomi_rogo.gif" ></div>
			<div style="border: 2px dotted navy; margin:10px 100px 10px 30px; padding:8px 10px 8px 10px; font-size:11pt;">
				<table>
					<tr>
						<td>銀行名</td><td>　　：　</td><td>三井住友銀行 (0009)</td>
					</tr>
					<tr>
						<td>支店名</td><td>　　：　</td><td>新宿支店 (221)</td>
					</tr>
					<tr>
						<td>口座番号</td><td>　　：　</td><td>普通　4246817</td>
					</tr>
					<tr>
						<td>名義人</td><td>　　：　</td><td>シャ）ニホンワーキングホリデーキョウカイ</td>
					</tr>
				</table>
			</div>
		</p>
		<p style="color:red; font-weight:bold;">
			&nbsp;<br/>
			【ご注意】<br/>
			お振込手数料はお客様のご負担となります。<br/>手数料は振込方法により異なりますので、取引銀行にお問い合わせください。
		</p>
		<div>
			<form class="cmxform" id="signupForm" method="post" action="./welcome.php?k=<? echo $k; ?>">
				<input type="hidden" name="act" value="<? echo $act; ?>">
				<input type="hidden" name="userid" value="<? echo $dat_id; ?>">
				<input type="hidden" name="email" value="<? echo $dat_email; ?>">
				<input type="hidden" name="tgt" value="furikomi">
				<input class="submit" type="submit" value="銀行振込でお支払の場合はこちら" style="width:350px; height:30px; margin:18px 0 10px 180px; font-size:11pt; font-weight:bold;" />
			</form>
		</div>
	</div>
</div>
<div id="div_cc_thx" style="display: none;">
	<p>
		クレジットカードでのお支払手続き（別画面）が完了しましたら、次へボタンを押してください。<br/>
	</p>
	<form class="cmxform" id="signupForm" method="post" action="./welcome.php?k=<? echo $k; ?>">
		<input type="hidden" name="act" value="<? echo $act; ?>">
		<input type="hidden" name="userid" value="<? echo $dat_id; ?>">
		<input type="hidden" name="email" value="<? echo $dat_email; ?>">
		<input type="hidden" name="tgt" value="card">
		<input class="submit" type="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 10px 10px; font-size:11pt; font-weight:bold;" />
	</form>

	<p style="margin:40px 0 0 0;">
		クレジットカードでのお支払が出来なかった場合や、他の支払い方法を選択する場合は、下のボタンを押してください。<br/>
	</p>
	<form class="cmxform" id="signupForm" method="post" action="./payment.php?k=<? echo $k; ?>">
		<input type="hidden" name="act" value="s3">
		<input type="hidden" name="userid" value="<? echo $dat_id; ?>">
		<input type="hidden" name="email" value="<? echo $dat_email; ?>">
		<input type="hidden" name="mailcheck" value="<? echo $dat_mailcheck; ?>">
		<input class="submit" type="submit" value="支払方法を選び直す" style="width:300px; height:20px; margin:18px 0 10px 0; font-size:11pt; font-weight:bold;" />
	</form>

</div>
<div id="div_cv_thx" style="display: none;">
	<p>
		コンビニ決済でのお手続き（別画面）が完了しましたら、次へボタンを押してください。<br/>
	</p>
	<form class="cmxform" id="signupForm" method="post" action="./welcome.php?k=<? echo $k; ?>">
		<input type="hidden" name="act" value="<? echo $act; ?>">
		<input type="hidden" name="userid" value="<? echo $dat_id; ?>">
		<input type="hidden" name="email" value="<? echo $dat_email; ?>">
		<input type="hidden" name="tgt" value="conv">
		<input class="submit" type="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 10px 10px; font-size:11pt; font-weight:bold;" />
	</form>

	<p style="margin:40px 0 0 0;">
		コンビニ決済が出来なかった場合や、他の支払い方法を選択する場合は、下のボタンを押してください。<br/>
	</p>
	<form class="cmxform" id="signupForm" method="post" action="./payment.php?k=<? echo $k; ?>">
		<input type="hidden" name="act" value="s3">
		<input type="hidden" name="userid" value="<? echo $dat_id; ?>">
		<input type="hidden" name="email" value="<? echo $dat_email; ?>">
		<input type="hidden" name="mailcheck" value="<? echo $dat_mailcheck; ?>">
		<input class="submit" type="submit" value="支払方法を選び直す" style="width:300px; height:20px; margin:18px 0 10px 0; font-size:11pt; font-weight:bold;" />
	</form>

</div>

</div>

<script type="text/javascript">
function fncCCScript()	{
	document.getElementById('div_cc').style.display = 'none';
	document.getElementById('div_cc_thx').style.display = '';
}
function fncCVScript()	{
	document.getElementById('div_cc').style.display = 'none';
	document.getElementById('div_cv_thx').style.display = '';
}


</script>

<?
	// Ｓ４　支払画面 ---------------------------------------------------------------------------------------　ここまで
	}

	if ($act == 's5')	{
		// Ｓ５　メッセージ画面 ---------------------------------------------------------------------------------------　ここから

		if ($abort)	{
			// エラー発生
?>

<div style="padding-left:30px; font-size:12pt;">
	<p>&nbsp;</p>
	<p style="border:2px dotted navy; padding:10px 20px 10px 20px; margin:10px 50px 10px 0;">
		<? echo $abort_msg; ?>
	</p>
	<p>&nbsp;</p>
	<p>
		<a href="./register.php?k=<? echo $k; ?>">メンバー登録を最初からやり直す場合は、こちらからどうぞ</a><br/>
	</p>

</div>

<?
		}else{
			// 通常画面
?>

<div style="padding-left:30px; margin-bottom:80px;">
	<p style="margin:20px 20px 16px 0; padding: 5px 0 5px 10px; font-size:11pt; font-weight:bold; background-color:aqua; color:navy;">
<?
	if ($dat_tgt == 'card' && $cur_state == '1')	{
		print 'メンバー登録料のお支払手続きをお願いいたします。';
	}else{
		print 'メンバー登録ありがとうございました。';
	}
?>
	</p>
	<p>
		<? echo $msg; ?>
	</p>
<?
	if ($dat_tgt == 'card' && $cur_state == '1')	{
	}else{
?>
		<p style="margin-top:10px; font-size:12pt;">
			<a href="/">それでは、ワーホリの準備を始めましょう！！</a><br/>
		</p>

<?
		if ($k <> '')	{
?>
			<div style="margin:20px 20px 20px 0px; padding:10px 20px 10px 20px; border:3px dotted navy; font-size:14pt; font-weight:bold;">
				メンバー登録手続きが完了しました。<br/>
				恐れ入りますが、お近くのスタッフまでお声かけください。<br/>
			</div>
<?
			echo $dat_id.'　';
			switch($dat_tgt)	{
				case 'card':
					echo 'カード払い';
					break;
				case 'conv':
					echo 'コンビニ決済';
					break;
				case 'furikomi':
					echo '銀行振込';
					break;
			}
		}
	}
?>
</div>



<?
		}
	// Ｓ５　メッセージ画面 ---------------------------------------------------------------------------------------　ここまで
	}
?>

	</div>



	</div>
  </div>
  </div>

<? fncMenuFooterNolink(); ?>

</body>
</html>

