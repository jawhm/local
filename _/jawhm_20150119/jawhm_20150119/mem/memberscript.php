<?php
require_once ('include/mem_function.php');

ini_set( "display_errors", "On");

mb_language("Ja");
mb_internal_encoding("utf8");

	//set parameter
	//-------------
	$mailadd 	= 'meminfo@jawhm.or.jp';
	$mailoffice = 'toiawase@jawhm.or.jp';
	$ok_url_payment 	= 'http://www.jawhm.or.jp/mem/payment.php';
	$wrong_url_payment	= 'http://www.jawhm.or.jp/mem/payment.php';


	// 拠点確認
	$k = strtoupper(@$_GET['k']);
	
	// Retrieve Variable $act treatment
	//---------------------------------------------------------------------------------

	$act = @$_GET['act'];
	if ($act == '')	{	$act = @$_POST['act'];	}
	if ($act == '')	{	$act = 's0';		}

	if($act == '4,5') //payment process + conbini
	{
		$stepidx = 3;
		$act = 's'.$act;
		
		if($conbini_store == 'empty')  // conbini not chosen
		{
			$act = 's4';
			$stepidx = 3;
			$no_store = 'right';
		}

	}
	elseif(isset($_GET['ERROR'])) //payment process error
	{
		$payment_error = 'card-error';
		$card_process = 'OK';
		$act = 's4,5';
	}
	elseif(!isset($_GET['ERROR']) && isset($_GET['FUKA'])) //payment process OK
	{
		$act = 's5';
		$stepidx = 4;
		
		$fuka_id = $_GET['FUKA'];

	}
	else //Normal process
	{
		$stepidx = intval(substr($act,-1));
		$act = 's'.strval($stepidx + 1);
	}
	//----------------------------------------------------------------------------------
	
	
	$msg = '';
	$abort = false;

	// 中断ユーザ判定
	$u = @$_GET['u'];
	$m = @$_GET['m'];
	if ($u <> '' || $m <> '')	{

		try {
			
			$db = connexion_database();
				
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
	
	//=======================================
	// STEP2 ACTION
	//=======================================

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
				$db  = connexion_database();
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
						$db  = connexion_database();
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
	
	//=======================================
	// STEP3 ACTION
	//=======================================
	
	if ($act == 's3')	
	{
		//　入力チェック
		$chk = 'ok';

		if (@$_POST['email'] == '')	
		{
			$chk = 'ng';
		}

		if ($chk == 'ok')	
		{
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
				$db  = connexion_database();
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
			if ($idx > 0)	
			{
				// 既に登録されたメールアドレスの場合
				if ($cur_state == '0')	
				{
					// 仮登録状態の場合は、既存レコードを削除する
					try {
						$db  = connexion_database();
						$stt = $db->prepare('DELETE FROM memlist WHERE email = "'.$dat_email.'"');
						$stt->execute();
						$db = NULL;
					} catch (PDOException $e) {
						die($e->getMessage());
					}
				}
				else
				{
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

			if ($abort == false)	
			{
				// 会員番号採番
				try {
					$db  = connexion_database();
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
					$db  = connexion_database();
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
					$db  = connexion_database();
					$stt = $db->prepare('UPDATE kessai_seq SET seq = '.$cur_num.' ');
					$stt->execute();
					$db = NULL;
				} catch (PDOException $e) {
					die($e->getMessage());
				}
				$dat_sid = $dat_id.substr('000000'.strval($cur_num),-6);

				// 会員情報を仮登録
				try {
					$db  = connexion_database();
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

				if ($k == '')	
				{
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
				}
				else
				{
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
		}
		else
		{
			// 未入力項目があるので、入力画面に差し戻し
			$act = 's1';
			$stepidx = 0;
		}
	}
	
	//=======================================
	// STEP4 ACTION
	//=======================================

	if ($act == 's4')	
	{
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
		
		//------------------------------
		//Back from conbini process
		//------------------------- 
		if($conbini_store == 'empty')
		{
			$dat_id = $FUKA;
			
			//get other needed data
			try {
				$db  = connexion_database();
				$stt = $db->prepare('SELECT email, namae, mailcheck FROM memlist WHERE id = "'.$dat_id.'" ');
				$stt->execute();
				while($row = $stt->fetch(PDO::FETCH_ASSOC)){
					$dat_email = $row['email'];
					$dat_mailcheck = $row['mailcheck'];
				}
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}
		//------------------------------
			
		if ($dat_id == '' || $dat_mailcheck == '')	
		{
			$act = 's5';
			$stepidx = 4;
			$abort = true;
			$abort_msg  = '処理中にエラーが発生しました。エラーコード[GR882]<br/>';
			$abort_msg .= '';
		}
		else
		{
			// メール承認確認
			try {
				$db  = connexion_database();
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
				$db  = connexion_database();
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
				$db  = connexion_database();
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
			if ($cur_state == '5' || $cur_state == '9')	
			{

				$act = 's5';
				$stepidx = 4;
				$abort = true;
				$abort_msg  = '既にメンバー登録料をお支払頂いているか、会員状態が不明です。お問い合わせください。[PE407]<br/>';
				$abort_msg .= '';
			}
			else
			{
				if ($dat_email == $cur_email)	
				{ 						
					if ($dat_mailcheck == $cur_mailcheck || $k <> '')	
					{  
						
						//back from error, avoid to send email and update database again
						//--------------------------------------------------------------
						if(!isset($no_store))
						{
							// 承認コード確認ＯＫ
							try {
								$db  = connexion_database();
								$stt = $db->prepare('UPDATE memlist SET state = "1", mailcheckdate = "'.date('Y/m/d H:i:s').'", upddate = "'.date('Y/m/d H:i:s').'" WHERE id = "'.$dat_id.'" ');
								$stt->execute();
								$db = NULL;
							} catch (PDOException $e) {
								die($e->getMessage());
							}
							// 会員情報読み込み
							try {
								$db  = connexion_database();
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
						
						}
						else
						{
							$msg_store = 'お支払頂くコンビニエンスストアを選択してください。<br />';
						}

					}
					else
					{
						// 承認コード不一致
						$act = 's3';
						$stepidx = 2;
						$msg = '入力された承認コードが一致しません。<br/>お送りしたメールを、もう一度確認してください。<br/>また、承認コードはコピー＆ペーストせず、必ず入力してください。<br/>';
					}
				}
				else
				{
					// メールアドレス不一致
					$act = 's5';
					$stepidx = 4;
					$abort = true;
					$abort_msg = '画面遷移情報が確認できません。<br/>';
				}
			}
		}
	}
	
	//=======================================
	// STEP4,5 ACTION
	//=======================================
	if ($act == 's4,5')	 // use for conbini only, update + send email before displaying page
	{
		if($conbini_process == 'OK')
		{
			$dat_email = $MAIL;
			$dat_id = $FUKA;
			$dat_payment_nb = $payment_number;
			$dat_exp_date = $date_of_use;
			$dat_payment_url = urldecode($url);
			
			//get other needed data
			try
			{
				$db  = connexion_database();
				$stt = $db->prepare('SELECT namae, tel, furigana FROM memlist WHERE id = "'.$dat_id.'" ');
				$stt->execute();
				
				while($row = $stt->fetch(PDO::FETCH_ASSOC))
				{
					$dat_namae = $row['namae'];
					$dat_furigana = $row['furigana'];
					$dat_tel = $row['tel'];
				}
				$db = NULL;
			}
			catch (PDOException $e)
			{
				die($e->getMessage());
			}

			
					
			//make date format
			$year = substr($dat_exp_date, 0,4);
			$month = substr($dat_exp_date, -4,2);
			$day = substr($dat_exp_date, -2);
			
			$full_expired_date = $year.'-'.$month.'-'.$day;
			
			//update user data
			try
			{
				$db  = connexion_database();
					
				$stt = $db->prepare('UPDATE memlist SET  payment = "conv", payment_expired_date="'.$full_expired_date.'", payment_nb="'.$dat_payment_nb.'", payment_url="'.$dat_payment_url.'" WHERE id = "'.$dat_id.'"   ');
				$stt->execute();
				$db = NULL;
			} 
			catch (PDOException $e) 
			{
				die($e->getMessage());
			}

			
			//Mail to customer  OK
			$subject = "登録料のお支払についてのご案内です";
			$body  = '';
			$body .= '日本ワーキングホリデー協会です。';
			$body .= chr(10);
			$body .= 'メンバー登録ありがとうございます。';
			$body .= chr(10);
			$body .= chr(10);
			$body .= 'お選び頂きましたコンビニにてメンバー登録料のお支払をお願い致します。';
			$body .= chr(10);
			$body .= 'なお、コンビニでのお支払は以下の有効期限までにお願い致します。';
			$body .= chr(10);
			$body .= chr(10);
			$body .= '受付番号・払込票番号：'.$dat_payment_nb;
			$body .= chr(10);
			$body .= '受付票・払込票表示：'.$dat_payment_url;
			$body .= chr(10);
			$body .= '有効期限：'.$full_expired_date;
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
						
			
			// 社内通知 OK

			$subject = "【メンバー登録：コンビニ決済予約】  ".$dat_namae."様  ".$dat_email;
			$body  = '';
			$body .= 'メンバー登録でコンビニ決済予約が発生しました。';
			$body .= chr(10);
			$body .= chr(10);
			$body .= '会員番号：'.$dat_id;
			$body .= chr(10);
			$body .= 'メールアドレス：'.$dat_email;
			$body .= chr(10);
			$body .= 'お名前：'.$dat_namae;
			$body .= chr(10);
			$body .= 'フリガナ：'.$dat_furigana;
			$body .= chr(10);
			$body .= '電話番号：'.$dat_tel;
			$body .= chr(10);
			$body .= '受付番号・払込票番号：'.$dat_payment_nb; 
			$body .= chr(10);
			$body .= '受付票・払込票表示：'.$dat_payment_url; 
			$body .= chr(10);
			$body .= '有効期限：'.$full_expired_date;	
			$body .= '';
			$from = mb_encode_mimeheader(mb_convert_encoding($dat_namae,"JIS"))."<".$dat_email.">";
			
			//Send to admin
			mb_send_mail($mailadd,$subject,$body,"From:".$from);
			
			//Send to office
			mb_send_mail($mailoffice,$subject,$body,"From:".$from);
		
		}
	}
	
	//=======================================
	// STEP5 ACTION
	//=======================================
	
	if ($act == 's5')	
	{
		//　サンキュー画面
		$chk = 'ok';

		//come from payment process
		if(isset($fuka_id)) 
		{
			$dat_id		= $fuka_id;
			$dat_tgt	= 'card';
		}
		else
		{
			$dat_id		= @$_POST['userid'];
			$dat_email	= @$_POST['email'];
			$dat_tgt	= @$_POST['tgt'];
		}

		if ($chk == 'ok')
		{

			// 会員情報読み込み
			try {
				$db  = connexion_database();
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
				$db  = connexion_database();
				$stt = $db->prepare('UPDATE memlist SET payment = "'.$dat_tgt.'" WHERE id = "'.$dat_id.'" ');
				$stt->execute();
				$db = NULL;
			} catch (PDOException $e) {
				die($e->getMessage());
			}

			if ($dat_email == $cur_email)	
			{

				if ($dat_tgt == 'furikomi')	
				{
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
					
					// send to admin
					mb_send_mail($mailadd,$subject,$body,"From:".$from);
					
					// send to office
					mb_send_mail($mailoffice,$subject,$body,"From:".$from);

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
				
				if ($dat_tgt == 'conv')	//message only
				{
				
					// 表示メッセージ
					$msg  = '';
					$msg .= 'メンバー登録料をご指定のコンビニでお支払ください。<br/>登録料のお支払が確認できた後、ご登録頂きました住所に会員証をお送り致します。<br/>';
					$msg .= '';

				}
			}
			
			//if card process
			if ($dat_tgt == 'card')
			{
				//update user data
				try
				{
					$db  = connexion_database();
					$stt = $db->prepare('UPDATE memlist SET state="5" WHERE id = "'.$dat_id.'" ');
					$stt->execute();
					$db = NULL;
				} 
				catch (PDOException $e) 
				{
					die($e->getMessage());
				}
				
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

	// 中断画面対応
	if ($act == 'p3')	{
		$act = 's3';
		$stepidx = 2;
	}

?>
<?php
require_once '../include/header.php';

$header_obj = new Header();

$header_obj->title_page='メンバー登録';
$header_obj->description_page='ワーホリメンバー登録：オーストラリア・ニュージーランド・カナダを初めとしたワーキングホリデー（ワーホリ）協定国の最新のビザ取得方法や渡航情報などを発信しています。';
$header_obj->keywords_page='ワーキングホリデー,ワーホリ,オーストラリア,ニュージーランド,カナダ,カナダ,韓国,フランス,ドイツ,イギリス,アイルランド,デンマーク,台湾,香港,ビザ,取得,方法,申請,手続き,渡航,外務省,厚生労働省,最新,ニュース,大使館';

$header_obj->mobileredirect=$redirection;

$header_obj->add_css_files='<link id="calendar_style" href="/mem/css/simple.css" media="screen" rel="Stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css"  href="/mem/css/conbini_logo.css" />
<link rel="stylesheet" type="text/css"  href="/mem/css/memberscript.css" />
<link rel="stylesheet" type="text/css" media="screen" href="/mem/css/screen.css" />
';
$header_obj->add_js_files='<script src="/mem/js/prototype.js" type="text/javascript"></script>
<script src="/mem/js/ajaxzip2/ajaxzip2.js" charset="UTF-8"></script>
<script src="/mem/js/effects.js" type="text/javascript"></script>
<script src="/mem/js/protocalendar.js" type="text/javascript"></script>
<script src="/mem/js/lang_ja.js" type="text/javascript"></script>
<script src="/mem/js/jquery.js" type="text/javascript"></script>
<script src="/mem/js/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery.noConflict();
</script>';

	// Ｓ１　会員登録画面
	if ($act == 's1')	
	{
		$header_obj->add_js_files .='
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
        </script>';
	}
	
	// Ｓ３　メアド確認画面	
	if ($act == 's3')	
	{
		$header_obj->add_js_files .='
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
        </script>';
	}
	// Ｓ4.5 this javscript code helps us to get the right format of the date for the payment process
	if ($act == 's4,5')	
	{
		
		$header_obj->add_js_files .='
	<script type="text/javascript">
      jQuery().ready(function(){ 
          jQuery("#btncheck").click(function() { 
         
		  var gatsu	= jQuery("select#month").val(); 
          var nen	=jQuery("select#year").val(); 
          var expired = nen+gatsu;   
			jQuery("input[name=EXP]").val(expired);		  
          });  
        });					
    </script>';
                    
	}
	
$header_obj->add_js_files .='
<script>
jQuery(function(){
     jQuery(".focus").focus(function(){
          if(this.getAttribute("pre") == "1"){
		this.setAttribute("pre","0")
		jQuery(this).val("").css("color","#000000");
          }
     });
     jQuery(".tooltip img").hover(function() {
        jQuery(this).next("div").animate({opacity: "show", top: "0"}, "fast");}, function() {
               jQuery(this).next("div").animate({opacity: "hide", top: "0"}, "fast");
     });
});
function fncClearFields()	{
	var obj = document.getElementsByClassName("focus");
	for (idx=0; idx<obj.length; idx++)	{
		if (obj[idx].getAttribute("pre") == "1")	{
			obj[idx].value = "";
		}
	}
}
</script>
';

$header_obj->fncMenuHead_imghtml = '<img id="top-mainimg" src="../images/mainimg/mem-topbanner.jpg" alt="" width="970" height="170" />';
$header_obj->fncMenuHead_h1text = '日本ワーキングホリデー協会にメンバー登録しよう！！';
$header_obj->fncMenuHead_link = 'nolink';
$header_obj->fncMenubar_function = false;

$header_obj->display_header();

?>
            <div id="maincontentwide">

			<?php
            
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

				if ($stepidx+1 == 1)	
				{
					?>
					<p style="margin:20px 20px 0px 30px; padding: 5px 0 5px 10px; font-size:11pt; font-weight:bold; background-color:aqua; color:navy;">
						メンバー登録の手順
					</p>
			<?php
				}

				$step[$stepidx] = '<span style="font-size:14pt; font-weight:bold;">STEP'.($stepidx+1).'</span>';

				for ($idx=0; $idx<count($step); $idx++)	
				{
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

				//=========================
				//DISPLAY APPROPRIATE STEP
				//=========================
				
				// step1 registration
				if ($act == 's1')	
				{
					include('step/step1.php');
				}
				// step2 display customer data
				if ($act == 's2')	
				{
					include('step/step2.php');
				}
				// step3 checkmail code
				if ($act == 's3')	
				{
					include('step/step3.php');
				}
				// step4 select payment
				if ($act == 's4')	
				{
					include('step/step4.php');
				}
				// step4 and a half  PAYMENT PROCESSING + CONBINI
				if($act == 's4,5')
				{
					include('step/step4half.php');
				}
				// step5 thankyou
				if ($act == 's5')	
				{
					include('step/step5.php');
				}
					?>
			</div> <!-- END maincontentwide -->
		</div><!-- END contentswide -->
	</div><!-- END contentsbox -->

	<?php fncMenuFooter('nolink'); ?>

</body>
</html>

