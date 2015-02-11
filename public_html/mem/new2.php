<?

ini_set( "display_errors", "On");

mb_language("Ja");
mb_internal_encoding("utf8");

function getRandomString($nLengthRequired = 8){
    $sCharList = "ABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
    mt_srand();
    $sRes = "";
    for($i = 0; $i < $nLengthRequired; $i++)
        $sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
    return $sRes;
}

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

		if (@$_POST['email'] == '')	{
			$chk = 'ng';
		}

		if ($chk == 'ok')	{
			// 入力情報を取得
			$dat_email	= @$_POST['email'];

			$dat_password	= @$_POST['password'];
			$dat_namae	= @$_POST['namae1'].'　'.@$_POST['namae2'];
			$dat_furigana	= @$_POST['furigana1'].'　'.@$_POST['furigana2'];
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
				// 会員番号採番
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

				// 会員情報を仮登録
				try {
					$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
					$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
					$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$db->query('SET CHARACTER SET utf8');
					$sql  = 'INSERT INTO memlist (';
					$sql .= ' id ,email ,password ,namae ,furigana ,gender ,birth ,pcode ,add1 ,add2 ,add3 ,add4 ,tel ,job ,country ,gogaku ,purpose ,know ,agree ,state ,indate ,mailcheck ,mailcheckdate ,mailsend ,insdate ,upddate ';
					$sql .= ') VALUES (';
					$sql .= ' :id ,:email ,:password ,:namae ,:furigana ,:gender ,:birth ,:pcode ,:add1 ,:add2 ,:add3 ,:add4 ,:tel ,:job ,:country ,:gogaku ,:purpose ,:know ,:agree ,:state ,:indate ,:mailcheck ,:mailcheckdate ,:mailsend ,:insdate ,:upddate ';
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
					$stt2->bindValue(':mailcheckdate', '');
					$stt2->bindValue(':mailsend'	, $dat_mailsend);
					$stt2->bindValue(':insdate'	, date('Y/m/d H:i:s'));
					$stt2->bindValue(':upddate'	, date('Y/m/d H:i:s'));
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
				$from = mb_encode_mimeheader(mb_convert_encoding($dat_namae,"JIS"))."<".$dat_email.">";
				mb_send_mail($mailadd,$subject,$body,"From:".$from);

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
				$body .= 'http://www.jawhm.or.jp/mem/new2.php?u='.$dat_id.'&m='.md5($dat_email);
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
				$stt = $db->prepare('SELECT id, email, mailcheck FROM memlist WHERE id = "'.$dat_id.'" ');
				$stt->execute();
				$idx = 0;
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$idx++;
					$cur_id = $row['id'];
					$cur_email = $row['email'];
					$cur_mailcheck = $row['mailcheck'];
				}
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}

			if ($dat_email == $cur_email)	{
				if ($dat_mailcheck == $cur_mailcheck)	{
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
				$stt = $db->prepare('SELECT id, email, namae, furigana, tel, state FROM memlist WHERE id = "'.$dat_id.'" ');
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
				}
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
					mb_send_mail('info@jawhm.or.jp',$subject,$body,"From:".$from);

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

				if ($dat_tgt == 'card')	{
					// カード払いの場合

					if ($cur_state == '1')	{
						// カード払い完了

						$msg  = '';
						$msg .= '&nbsp;<br/>';
						$msg .= '【ご注意】登録料のお支払が確認できません。<br/>';
						$msg .= '&nbsp;<br/>';
						$msg .= '別ウィンドウで表示れているカード決済ページでお支払をお願いいたします。<br/>';
						$msg .= '&nbsp;<br/>';

						$msg .= '<form class="cmxform" id="signupForm" method="post" action="./new2.php">';
						$msg .= '<input type="hidden" name="act" value="s4">';
						$msg .= '<input type="hidden" name="userid" value="'.$dat_id.'">';
						$msg .= '<input type="hidden" name="email" value="'.$cur_email.'">';
						$msg .= '<input type="hidden" name="tgt" value="card">';
						$msg .= '<input class="submit" type="submit" value="再確認" style="width:150px; height:30px; margin:10px 0 10px 0; font-size:11pt; font-weight:bold;" />';
						$msg .= '</form>';

						$msg .= '';
						$msg .= '';
						$msg .= '';
						$msg .= '&nbsp;<br/>';
						$msg .= '&nbsp;<br/>';
						$msg .= 'なお、カード決済ページを閉じてしまった場合は、以下のボタンを押してください。<br/>';
						$msg .= '&nbsp;<br/>';
						$msg .= '【ご注意】<br/>改めて、カード決済ページを表示する場合は、必ず上の「再確認」ボタンを押して、現在の状態を確認してください。<br/>';
						$msg .= '間違えて複数回のカード決済を行った場合、返金処理に時間がかかることがあります。ご注意ください。<br/>';

						$msg .= '<form method="post" action="https://linkpt.cardservice.co.jp/cgi-bin/order.cgi?orders" enctype="x-www.form-encoded" target="_blank" onsubmit="fncCCScript();">';
						$msg .= '<input type="hidden" name="send" value="mail">';
						$msg .= '<input type="hidden" name="clientip" value="2014000153">';
						$msg .= '<input type="hidden" name="money" value="5000">';
						$msg .= '<input type="hidden" name="custom" value="yes">';
						$msg .= '<input type="hidden" name="usrtel" value="'.$cur_tel.'">';
						$msg .= '<input type="hidden" name="usrmail" value="'.$cur_email.'">';
						$msg .= '<input type="hidden" name="usrname" value="">';
						$msg .= '<input type="hidden" name="sendid" value="'.$cur_id.'">';
						$msg .= '<input type="hidden" name="sendpoint" value="online">';
						$msg .= '<input type="submit" value="カード決済ページを表示する" style="width:150px; height:22px; margin:10px 0 10px 0;">';
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
			tel: "required",
			agree: "required"
		},
		messages: {
			namae1: "お名前（氏）を入力してください",
			namae2: "お名前（名）を入力してください",
			furigana1: "フリガナ（氏）を入力してください",
			furigana2: "フリガナ（名）を入力してください",
			year: "(要選択)",
			month: "(要選択)",
			day: "(要選択)",
			email: "メールアドレスを入力してください",
			password: {
				required: "パスワードを入力してください",
				minlength: "パスワードは５文字以上で設定してください"
			},
			confirm_password: {
				required: "パスワードを再度入力してください",
				minlength: "パスワードは５文字以上で設定してください",
				equalTo: "上記のパスワードと異なります。確認してください。"
			},
			pcode: "郵便番号を入力してください",
			add1: "都道府県を入力してください",
			add2: "市区町村を入力してください",
			add3: "番地・建物名を入力してください",
			tel: "電話番号を入力してください",
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
#signupForm { width: 670px; }
#signupForm label.error {
	margin-left: 10px;
	width: auto;
	display: none;
}
.must	{
	color: red;
	font-weight: bold;
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
<style>
.focus	{
	color:	#969696;
}
</style>

</head>

<body>
<div id="header">
    <h1><a href="../index.html"><img src="../images/h1-logo.jpg" alt="一般社団法人日本ワーキング・ホリデー協会" width="410" height="33" /></a></h1>
	<div id="utility-nav">
	<ul>
	  <li class="u-nav01"><a href="../japanese">日本語</a></li>
	  <li class="u-nav02"><a href="../english">英語</a></li>
	  <li class="u-nav03"><a href="../mobile">携帯</a></li>
	</ul>
	</div>
  <img id="top-mainimg" src="../images/top-mainimg.jpg" alt="" width="970" height="170" />  </div>
  <div id="contentsbox"><img id="bgtop" src="../images/contents-bgtop.gif" alt="" />
  <div id="contents">
    <div id="global-nav">
	  <div class="g-n-sec01">
	  <ul id="memberlogin">
	    	<li class="ml01"><a href="/member">メンバーログイン</a></li>
		<li class="ml02"><a href="/mem">メンバー登録はこちら</a></li>
	  </ul>
	  </div>
	  <div class="g-n-sec02">
	  <ul id="g-n-main01">
	    <li class="gnm01"><a href="../system.html">ワーキング・ホリデー制度について</a></li>
		<li class="gnm02"><a href="../start.html">はじめてのワーキング・ホリデー</a></li>
		<li class="gnm03"><a href="../visa/visa_top.html">ワーキング・ホリデー協定国</a></li>
	        <li class="gnm23"><a href="../seminar.html">無料セミナー</a></li>
		<li class="gnm04"><a href="../event.html">イベントカレンダー</a></li>
		<li class="gnm05"><a href="../recruit/index.html">求人・求職情報サイト</a></li>
		<li class="gnm06"><a href="../return.html">帰国者の方へ</a></li>
		<li class="gnm07"><a href="../qa.html">Ｑ＆Ａ</a></li>
		<li class="gnm08"><a href="../info.html">お役立ち情報</a></li>
		<li class="gnm09"><a href="../trans.html">翻訳サービス</a></li>
		<li class="gnm10"><a href="../gogaku-spec.html">語学講座</a></li>
	    <li class="gnm11"><a href="../school.html">語学学校</a></li>
		<li class="gnm12"><a href="../support.html">サポート機関</a></li>
		<li class="gnm13"><a href="../service.html">サービス</a></li>
		<li class="gnm14"><a href="../company.html">企業会員一覧</a></li>
	    <li class="gnm15"><a href="../attention.html">外国人ワーキングホリデー青年</a></li>
	  </ul>
	  <ul id="g-n-main02">
	    <li class="gnm16"><a href="../about.html">ワーキング・ホリデー協会について</a></li>
	        <li class="gnm24"><a href="../volunteer.html">ボランティア・インターン募集</a></li>
		<li class="gnm17"><a href="../access.html">アクセス</a></li>
		<li class="gnm18"><a href="../mem-com.html">企業会員について</a></li>
		<li class="gnm19"><a href="../adv.html">広告掲載のご案内</a></li>
		<li class="gnm20"><a href="../privacy.html">個人情報の取り扱い</a></li>
		<li class="gnm21"><a href="../about.html#deal">特定商取引に関する表記</a></li>
		<li class="gnm22"><a href="../sitemap.html">サイトマップ</a></li>
	  </ul>
	  </div>
	</div>
	<div id="maincontent">
	  <p id="topicpath"><a href="../index.html">トップ</a>　> メンバー登録 </p>

<?

	$step = array();
	$step[] = 'STEP1';
	$step[] = 'STEP2';
	$step[] = 'STEP3';
	$step[] = 'STEP4';
	$step[] = 'STEP5';

	$step[$stepidx] = '<span style="font-size:14pt; font-weight:bold;">STEP'.($stepidx+1).'</span>';

	for ($idx=0; $idx<count($step); $idx++)	{
//		echo $step[$idx].'&nbsp;&nbsp; --> &nbsp;&nbsp; ';
	}
	echo '　　<img src="images/step'.($stepidx+1).'.gif">';

	if ($act == 's1')	{
		// Ｓ１　会員登録画面 ---------------------------------------------------------------------------------------　ここから

?>


<h2 class="sec-title">メンバー登録</h2>
<div style="padding-left:30px;">
	<p>
		以下のフォームに入力をお願いします。<br/>
	</p>

<form class="cmxform" id="signupForm" method="post" action="./new2.php" onsubmit="fncClearFields();">
	<input type="hidden" name="act" value="<? echo $act; ?>">
	<table style="font-size:10pt;" border="1">
		<tr>
			<td>メールアドレス<span class="must">（必須）</span></td>
			<td>
				<input id="email" name="email" size="36" maxlength="80" value="メールアドレス" class="focus" pre="1" /><br/>
				※ログイン用のメールアドレスとなります<br/>
				※ご確認メールをお送りしますので、連絡可能なメールアドレスを入力してください<br/>
				※携帯電話でのメールアドレスをご使用の場合、jawhm.or.jpドメインからのメールを<br/>
				　受信できるように設定を確認してください<br/>
				※メールアドレスの @ の直前にピリオド (.) がある、<br/>
				　または @ より前でピリオドが連続するなどのメールアドレスはご利用いただけません。<br/>
				　恐れ入りますが、他のメールアドレスでご登録ください。<br/>
			</td>
		</tr>
		<tr>
			<td>パスワード<span class="must">（必須）</span></td>
			<td>
				<input id="password" name="password" type="password" maxlength="20" /><br/>
				※半角英数字５～２０文字で入力してください<br/>
				<input id="confirm_password" name="confirm_password" type="password" maxlength="20" /><br/>
				※確認の為、同じパスワードを入力してください<br/>
			</td>
		</tr>
		<tr>
			<td>お名前<span class="must">（必須）</span></td>
			<td>
				(氏) <input id="namae1" name="namae1" maxlength="20" size="10" value="山田" class="focus" pre="1" />
				(名) <input id="namae2" name="namae2" maxlength="20" size="10" value="太郎" class="focus" pre="1" />
			</td>
		</tr>
		<tr>
			<td>フリガナ<span class="must">（必須）</span></td>
			<td>
				(氏) <input id="furigana1" name="furigana1" maxlength="20" size="10" value="ヤマダ" class="focus" pre="1" />
				(名) <input id="furigana2" name="furigana2" maxlength="20" size="10" value="タロウ" class="focus" pre="1" />
			</td>
		</tr>
		<tr>
			<td>性別<span class="must">（必須）</span></td>
			<td>
				<input type="radio" id="gender_male" value="m" name="gender" validate="required:true" />男性 &nbsp;&nbsp;
				<input type="radio" id="gender_female" value="f" name="gender"/>女性
				<label for="gender" class="error">性別を選択してください</label>
			</td>
		</tr>
		<tr>
			<td>生年月日<span class="must">（必須）</span></td>
			<td>
				<select id="y" name="year">
					<option value="">--</option><option value="1970">1970</option>
					<option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option>
					<option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option>
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
			</td>
		</tr>
		<tr>
			<td>現住所<span class="must">（必須）</span></td>
			<td>
				<table>
				<tr>
					<td>郵便番号</td>
					<td><input id="pcode" name="pcode" size=5 maxlength="10" value="100-0001" class="focus" pre="1" /></td>
				</tr>
				<tr>
					<td>都道府県</td>
					<td><input id="add1" name="add1" size=20 maxlength="80" value="東京都" class="focus" pre="1" /></td>
				</tr>
				<tr>
					<td>市区町村</td>
					<td><input id="add2" name="add2" size=40 maxlength="80" value="千代田区" class="focus" pre="1" /></td>
				</tr>
				<tr>
					<td>番地・建物名</td>
					<td><input id="add3" name="add3" size=40 maxlength="80" value="１－２－３千代田マンション１０１" class="focus" pre="1" /></td>
				</tr>
				</table>
				※会員証をお送りしますので、アパート・マンション名なども必ず入力してください<br/>
				※海外からの場合、国名を「都道府県」の欄に入力し<br/>
				　残りの住所を「市区町村」「番地・建物名」に入力してください<br/>
			</td>
		</tr>
		<tr>
			<td>電話番号<span class="must">（必須）</span></td>
			<td><input id="tel" name="tel" maxlength="30" value="03-1234-5678" class="focus" pre="1" /></td>
		</tr>
		<tr>
			<td>職業</td>
			<td>
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
			<td>渡航予定国</td>
			<td>
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
			<td>渡航予定国の語学力</td>
			<td>
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
			<td>渡航目的</td>
			<td>
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
			<td>どこで当協会を<br/>知りましたか</td>
			<td>
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
			<td>ご案内メール</td>
			<td>
				今後、セミナーやイベントのご案内等をお送りしてもよろしいですか？<br/>
				<input type="radio" class="radio" name="mailsend" value="1" checked>&nbsp;受け取る
				&nbsp;&nbsp;
				<input type="radio" class="radio" name="mailsend" value="0">&nbsp;受け取らない
			</td>
		</tr>

		<tr>
			<td>会員規約と<br/>プライバシーポリシー</td>
			<td>
				&nbsp;<br/>
				<input type="checkbox" class="checkbox" id="agree" name="agree" value="同意" /> &nbsp;「<a href="http://www.jawhm.or.jp/privacy.html#memberkiyaku" target="_new">メンバー規約</a>」に同意し、「<a href="http://www.jawhm.or.jp/privacy.html" target="_new">プライバシーポリシー</a>」を確認しました。<br/>
				&nbsp;<br/>
			</td>
		</tr>

	</table>

	<input class="submit" type="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 30px 400px; font-size:11pt; font-weight:bold;" />

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
<h2 class="sec-title">メンバー登録</h2>
<div style="padding-left:30px;">
	<p>
		入力頂いた内容を確認の上、よろしければ「次へ」をクリックしてください。
	</p>

	<table style="font-size:10pt;" border="1">
		<tr>
			<td>メールアドレス</td>
			<td width="400"><? echo $dat_email; ?></td>
		</tr>
		<tr>
			<td>お名前</td>
			<td><? echo $dat_namae; ?></td>
		</tr>
		<tr>
			<td>フリガナ</td>
			<td><? echo $dat_furigana; ?></td>
		</tr>
		<tr>
			<td>性別</td>
			<td>
				<? if ($dat_gender == 'm')	{ echo '男性'; } else { echo '女性'; }	?>
			</td>
		</tr>
		<tr>
			<td>生年月日</td>
			<td>
				<? echo $dat_year.'年 '.$dat_month.'月 '.$dat_day.'日'; ?>
			</td>
		</tr>
		<tr>
			<td>現住所</td>
			<td>
				<table>
				<tr>
					<td>郵便番号</td>
					<td><? echo $dat_pcode; ?></td>
				</tr>
				<tr>
					<td>都道府県</td>
					<td><? echo $dat_add1; ?></td>
				</tr>
				<tr>
					<td>市区町村</td>
					<td><? echo $dat_add2; ?></td>
				</tr>
				<tr>
					<td>番地・建物名</td>
					<td><? echo $dat_add3; ?></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>電話番号</td>
			<td><? echo $dat_tel; ?></td>
		</tr>
		<tr>
			<td>職業</td>
			<td><? echo $dat_job; ?></td>
		</tr>
		<tr>
			<td>渡航予定国</td>
			<td><? echo $dat_country; ?></td>
		</tr>
		<tr>
			<td>渡航予定国の語学力</td>
			<td><? echo $dat_gogaku; ?></td>
		</tr>
		<tr>
			<td>渡航目的</td>
			<td><? echo $dat_purpose; ?></td>
		</tr>
		<tr>
			<td>どこで当協会を<br/>知りましたか</td>
			<td><? echo $dat_know; ?></td>
		</tr>
		<tr>
			<td>ご案内メール</td>
			<td>
				<? if ($dat_mailsend == '1') { echo '受け取る'; } else { echo '受け取らない'; }	?>
			</td>
		</tr>
	</table>

<form class="cmxform" id="signupForm" method="post" action="./new2.php">
	<input type="hidden" name="act" value="<? echo $act; ?>">
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
	<input type=submit class="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 10px 0; font-size:11pt; font-weight:bold;">

</form>

</div>

<script type="text/javascript">


</script>
<?
	}
	if ($act == 's3')	{
		// Ｓ３　メアド確認画面 ---------------------------------------------------------------------------------------　ここから
?>

<h2 class="sec-title">メンバー登録</h2>
<div style="padding-left:30px;">
	<p>
		ご入力頂いたメールアドレス(<? echo $dat_email; ?>)に、承認コードをお送りしました。<br/>
		メールをご覧になり、以下の内容を入力してください。<br/>
	</p>

<?
	if ($msg <> '')	{
		echo '<p style="font-size:11pt; font-weight:bold; margin:15px 50px 15px 0; color:white; background-color:orange;">'.$msg.'</p>';
	}
?>

<form class="cmxform" id="signupForm" method="post" action="./new2.php">
	<input type="hidden" name="act" value="<? echo $act; ?>">
	<input type="hidden" name="userid" value="<? echo $dat_id; ?>">
	<input type="hidden" name="email" value="<? echo $dat_email; ?>">
	<table style="font-size:10pt; margin:20px 0 10px 20px;" border="0">
		<tr>
			<td>承認コード</td>
			<td>
				<input id="mailcheck" name="mailcheck" maxlength="20" /><br/>
			</td>
		</tr>
	</table>
	<input type=button class="back" value="<< 戻る" onclick="history.back();" style="width:150px; height:30px; margin:18px 0 10px 20px; font-size:11pt; font-weight:bold;">
	<input class="submit" type="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 10px 0; font-size:11pt; font-weight:bold;" />
</form>


</div>

<script type="text/javascript">


</script>

<?
	// Ｓ３　メアド確認画面 ---------------------------------------------------------------------------------------　ここまで
	}

	if ($act == 's4')	{
		// Ｓ４　支払処理 ---------------------------------------------------------------------------------------　ここから
?>

<h2 class="sec-title">メンバー登録</h2>
<div style="padding-left:30px;">
	<p>
		メールアドレスの確認ができました。<br/>
	</p>

<?
	if ($msg <> '')	{
		echo '<p style="font-size:11pt; font-weight:bold; margin:15px 50px 15px 0; color:white; background-color:orange;">'.$msg.'</p>';
	}
?>

&nbsp;<br/>
<div id="div_cc">
	<p>
		引き続き、登録料のお支払手続きに入ります。<br/>
		お支払方法を選択してください。<br/>
	</p>
	<div style="border:1px solid navy; margin: 20px 80px 20px 0; padding: 18px 20px 10px 20px;">
		<p>
			【銀行振込でお支払の場合】<br/>
			銀行振込で登録料をお支払の場合、以下の口座をご利用ください。<br/>
			なお、振込手数料はお客様のご負担となります。<br/>
			<div style="border: 2px dotted navy; margin:10px 100px 10px 30px; padding:8px 10px 8px 10px; font-size:11pt;">
				銀行名　　：　三井住友銀行 (0009)<br/>
				支店名　　：　新宿支店 (221)<br/>
				口座番号　：　普通　4246817<br/>
				名義人　　：　シャ）ニホンワーキングホリデーキョウカイ<br/>
			</div>
		</p>
		<div>
			<form class="cmxform" id="signupForm" method="post" action="./new2.php">
				<input type="hidden" name="act" value="<? echo $act; ?>">
				<input type="hidden" name="userid" value="<? echo $dat_id; ?>">
				<input type="hidden" name="email" value="<? echo $dat_email; ?>">
				<input type="hidden" name="tgt" value="furikomi">
				<input class="submit" type="submit" value="銀行振込" style="width:250px; height:30px; margin:18px 0 10px 30px; font-size:11pt; font-weight:bold;" />
			</form>
		</div>
	</div>
	<div style="border:1px solid navy; margin: 20px 80px 20px 0; padding: 18px 20px 10px 20px;">
		<p>
			【クレジットカードでお支払の場合】<br/>
			当協会では、クレジットカードのお支払の場合、株式会社ゼウスのシステムを利用しております。<br/>
			以下の「カード決済ページへ」のボタンをクリックして、支払手続きをお願いいたします。<br/>
			※なお、カード決済ページは別ウィンドウで開きます。<br/>

                        <div style="text-align:center;margin:15px 0 0 0;"><img src="images/creditcard.gif" ></div>
		</p>
		<p>
			【ご注意】
			クレジットカードでお支払の場合、ＶＩＳＡ（ビザ）又はＭＡＳＴＥＲ（マスター）の<br/>
			マークがあるカードのみご利用頂けます。<br/>
		</p>
		<div>
			<form method="post" action="https://linkpt.cardservice.co.jp/cgi-bin/order.cgi?orders" enctype="x-www.form-encoded" target="_blank" onsubmit="fncCCScript();">
				<input type="hidden" name="send" value="mail">
				<input type="hidden" name="clientip" value="2014000153">
				<input type="hidden" name="money" value="5000">
				<input type="hidden" name="custom" value="yes">
				<input type="hidden" name="usrtel" value="<? echo $dat_tel; ?>">
				<input type="hidden" name="usrmail" value="<? echo $dat_email; ?>">
				<input type="hidden" name="usrname" value="">
				<input type="hidden" name="sendid" value="<? echo $dat_id; ?>">
				<input type="hidden" name="sendpoint" value="online">
				<input type="submit" value="クレジットカード" style="width:250px; height:30px; margin:18px 0 10px 30px; font-size:11pt; font-weight:bold;">
			</form>
		</div>
	</div>
</div>
<div id="div_cc_thx" style="display: none;">
	<p>
		クレジットカードでのお支払手続き（別画面）が完了しましたら、次へボタンを押してください。<br/>
	</p>
	<form class="cmxform" id="signupForm" method="post" action="./new2.php">
		<input type="hidden" name="act" value="<? echo $act; ?>">
		<input type="hidden" name="userid" value="<? echo $dat_id; ?>">
		<input type="hidden" name="email" value="<? echo $dat_email; ?>">
		<input type="hidden" name="tgt" value="card">
		<input class="submit" type="submit" value="次へ >>" style="width:150px; height:30px; margin:18px 0 10px 10px; font-size:11pt; font-weight:bold;" />
	</form>
</div>

</div>

<script type="text/javascript">
function fncCCScript()	{
	document.getElementById('div_cc').style.display = 'none';
	document.getElementById('div_cc_thx').style.display = '';
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

<h2 class="sec-title">メンバー登録</h2>
<div style="padding-left:30px;">
	<p>&nbsp;</p>
	<p style="border:2px dotted navy; padding:10px 20px 10px 20px; margin:10px 50px 10px 0;">
		<? echo $abort_msg; ?>
	</p>
	<p>&nbsp;</p>
	<p>
		<a href="./new2.php">メンバー登録を最初からやり直す場合は、こちらからどうぞ</a><br/>
	</p>

</div>

<?
		}else{
			// 通常画面
?>

<h2 class="sec-title">メンバー登録</h2>
<div style="padding-left:30px;">
	<p>
		メンバー登録ありがとうございました。<br/>
	</p>
	<p>
		<? echo $msg; ?>
	</p>
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
  <div id="footer">
    <div id="footer-box">
	<img src="../images/foot-co.gif" alt="" />
	</div>
  </div>

</body>
</html>

