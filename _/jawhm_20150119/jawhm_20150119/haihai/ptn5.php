<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow"> 
<title>ptn5</title>
<style type="text/css">
input.normal,select.normal,textarea.normal {
	background-color: #E0FFFF;
}
</style>
</head>
<body bgcolor="white">

<?php

	// エラーフラグ、正常：0、異常：1
	$err_flg = 0;
	// 登録件数用カウント
	$all_cnt = 0;

	// 開始日時取得
	$start_time = date( "Y/m/d H:i:s", time() );
	print "[".$start_time."] start";

	// DB接続
	$link = mysql_connect('localhost', 'mail_list', 'r2d2c3po303pittst');
	if (!$link) {
		$error = mysql_error();
		print('接続失敗です。'.mysql_error());
		$err_flg = 1;
	}

	ob_flush();
	flush();

	mysql_query("SET NAMES utf8",$link); //クエリの文字コードを設定

	// データベースを選択する
	if($err_flg == 0){
		$sdb = mysql_select_db("mail_list", $link);
		if(!$sdb){
			$error = mysql_error();
			print("<p>データベースの選択に失敗しました。</p>");
			$err_flg = 1;
		}
	}

	ob_flush();
	flush();

	// 昨日の日付を取得
	$kinou = date( "Y-m-d", strtotime("-1 day") );

	// IDの取得
	if($err_flg == 0){
		$sql = "SELECT KAIIN_ID FROM D_CLASS_YYK WHERE YMD = \"".$kinou."\" AND CLASS_CD = 'KBT'";

		$sql = mb_convert_encoding($sql, "SJIS", "UTF-8");

		$result = mysql_query($sql, $link);

		if(!$result){
			$error = mysql_error();
			print("クエリの送信に失敗しました。<br />SQL:".$sql);
			$err_flg = 1;
		}else{
			$i = 0;
			while ($row = mysql_fetch_assoc($result)) {
				$id[$i]	= $row['KAIIN_ID'];
				$i++;
			}
			ob_flush();
			flush();

			//結果保持用メモリを開放する
			mysql_free_result($result);
		}
	}

	$cnt = 0;
	for($i=0; $i<count($id); $i++){
		// ＣＲＭに転送
		$data = array( 'pwd' => '303pittST', 'id' => $id[$i] );
		$url = 'https://toratoracrm.com/crm/customer.php';
		$val = wbsRequest($url, $data);
		$ret = json_decode($val, true);

		if ($ret['result'] == 'OK'){
			$mail = $ret['mail'];
			for($j=0; $j<count($mail); $j++){
				$email[$cnt] = $mail[$j];
				$cnt++;
			}
		}else{
			$error = ERROR_NUMBER()." : ".ERROR_MESSAGE();
			$err_flg = 1;
			break;
		}
	}

	ob_flush();
	flush();

	// アドレスが重複していたら、一つにする
	$add_cnt = count($email);		// アドレスカウント
	$cnt_ovl = 0;								// 重複カウント

	for($i=0; $i<($add_cnt-1); $i++){
		if($email[$i] != ""){
			for($j=($i+1); $j<$add_cnt; $j++){
				if($email[$i] == $email[$j]){
					$email[$j] = "";
					$cnt_ovl++;
				}
			}
		}
	}
	// 空白の配列を削除
	$email = array_merge(array_diff($email, array("")));

	$date	= date( "Y/m/d H:i:s", time() );

	$ary = mail_chk($email);
	$email		= $ary[0];
	$err_msg	= $ary[1];
	$err_mail = $ary[2];

	// INSERT
	if($err_flg == 0){
		$i = 0;
		while($i<count($email)){

			$sql  = "INSERT INTO haihai(seq, mdptn, email, kyoten, namae, url, ptnid, insdate, sent, sentdate)";
			$sql .= "VALUES(NULL, '30', \"".$email[$i]."\", NULL, NULL, NULL, '5',\"". $date."\", 0, NULL)";
			$result = mysql_query($sql, $link);

			if(!$result){
				$error = mysql_error();
				print("クエリの送信に失敗しました。<br />SQL:".$sql);
				$err_flg = 1;
				break;
			}

			$i++;
			$all_cnt++;
		}

		print "<p>登録件数は[ ".$all_cnt." ]件です。</p>";
		print "<p>アドレスの重複が[ ".$cnt_ovl." ]件ありました。</p>";
		print "<p>メアド形式のエラーが[ ".count($err_mail)." ]件ありました。</p>";
	}


	// 終了日時取得
	$end_time = date( "Y/m/d H:i:s", time() );

	mb_language("Japanese");
	mb_internal_encoding("UTF-8");

	$to		 = "meminfo@jawhm.or.jp";
	$title = "【ステップ登録】「昨日カウンセリング者パターン登録」";
	$main	 = "開始日時：".$start_time."\r\n";
	$main	.= "終了日時：".$end_time."\r\n";
	$main	.= "処理件数：".$all_cnt."件\r\n";
	$main	.= "エラー　：";
	if($err_flg == 0){
		$main .= "なし";
	}else{
		$main .= $error;
	}

	$from	 = "From: ptn5_log";

	if (!mb_send_mail($to, $title, $main, $from)) {
		print "<p>メールの送信に失敗しました。</p>";
	}

	// DB切断
	mysql_close($link);

	print "[".$end_time."] end";

	function wbsRequest($url, $params){
		$data = http_build_query($params);
		$content = file_get_contents($url.'?'.$data);
		return $content;
	}

	function mail_chk($mail){
		$err = 0;
		for($i=0; $i<count($mail); $i++){
			if($mail[$i] != ""){
				$err_msg[$err]  = "";

				// trueでエラー
				$flg = false;

				// 空白のみで登録されていないか調べる
				if(!$flg){
					if($mail[$i] == " " || $mail[$i] == "　"){
						$err_msg[$err] = $msg_null;
						$err_mail[$err] = $mail[$i];
						$mail[$i] = "";
						$flg = true;
					}
				}

				// アドレスに空白が含まれていないか調べる
				if(!$flg){
					if(mb_ereg_match( '.*( |　|\t).*', $mail[$i] ) == 1){
						$err_msg[$err] = $msg_spc;
						$err_mail[$err] = $mail[$i];
						$mail[$i] = "";
						$flg = true;
					}
				}

				// 2byte文字を含むかチェック
				if(!$flg){
					$encode = mb_detect_encoding($mail[$i]);
					if( strlen($mail[$i]) !== mb_strlen($mail[$i], $encode)){
						$err_msg[$err] = $msg_byte;
						$err_mail[$err] = $mail[$i];
						$mail[$i] = "";
						$flg = true;
					}
				}

				/*********************************
				* メールアドレスの形式チェック
				**********************************/

				if(!$flg){
					// アドレスの形式チェック
					// @の前と後に分ける
					$address1 = explode("@", $mail[$i]);

					// @の前に１文字以上あるか調べる
					if(strlen($address1[0]) > 0){
						// 先頭一文字取得
						$head = substr($address1[0], 0, 1);
						// 一文字目が英数字か調べる
						if( preg_match("/[a-zA-Z0-9]/", $head) == 0){
							$err_msg[$err] = $msg_adr;
							$err_mail[$err] = $mail[$i];
							$mail[$i] = "";
							$flg = true;
						}

						// 2文字目以降にドット、ハイフン、下線以外がないか調べる
						$head2 = substr($address1[0], 1, Strlen($address1[0]));
						if( preg_match('/[ !-\, \/ :-@ \[-^ ` \{-\~]/', $head2) == 1 ){
							$err_msg[$err] = $msg_adr;
							$err_mail[$err] = $mail[$i];
							$mail[$i] = "";
							$flg = true;
						}
					}else{
						$err_msg[$err] = $msg_adr;
						$err_mail[$err] = $mail[$i];
						$mail[$i] = "";
						$flg = true;
					}

					// @の後の１文字目が英数字、ハイフンまたは下線かを調べる
					if($adr_flg == "true"){
						$head = substr($address1[1], 0, 1);
						if( preg_match("/[a-zA-Z0-9 \- _]/", $head) == 0){
							$err_msg[$err] = $msg_adr;
							$err_mail[$err] = $mail[$i];
							$mail[$i] = "";
							$flg = true;
						}
					}

					// @の後にドットが連続しているところがないか調べる
					if(stripos($address[1], "..") != ""){
						$err_msg[$err] = $msg_adr;
						$err_mail[$err] = $mail[$i];
						$mail[$i] = "";
						$flg = true;
					}

					// @の後をドットで区切る
					$address2 = explode(".", $address1[1]);
					// 一番後ろの配列は除く
					$cnt = count($address2) - 2;

					// 最後の文字列以外が英数字、ハイフン、ドットまたは下線であるかを調べる
					for($j=0; $j<=$cnt; $j++){
						if(strlen($address2[$j]) > 0){
							if( preg_match('/[ !-\, \/ :-@ \[-^ ` \{-\~]/', $address2[$j]) != 0 ){
								$err_msg[$err] = $msg_adr;
								$err_mail[$err] = $mail[$i];
								$mail[$i] = "";
								$flg = true;
							}
						}
					}

					// 最後の文字列が２文字以上の英数字であるか調べる
					$ary_cnt = count($address2) - 1;
					if( strlen($address2[$ary_cnt]) >= 2 ){
						if( preg_match('/[ !-\/ :-@ \[-` \{-\~]/', $address2[$ary_cnt]) != 0 ){
								$err_msg[$err] = $msg_adr;
								$err_mail[$err] = $mail[$i];
								$mail[$i] = "";
								$flg = true;
						}
					}
				}
				/*********************************
				* ここまで
				**********************************/

				// @の直前にドットがないか調べる
				if(!$flg){
					if(stripos($mail[$i], ".@") != ""){
						$err_msg[$err] = $msg_dot;
						$err_mail[$err] = $mail[$i];
						$mail[$i] = "";
						$flg = true;
					}
				}

				// @の前にドットが連続してないか調べる
				if(!$flg){
					if(stripos($mail[$i], "..") != ""){
						$err_msg[$err] = $msg_dot2;
						$err_mail[$err] = $mail[$i];
						$mail[$i] = "";
						$flg = true;
					}
				}

				// メールアドレスに改行がないか調べる
				if(!$flg){
					if(strstr($mail[$i], "\n") != ""){
						$err_msg[$err] = $msg_line;
						$err_mail[$err] = $mail[$i];
						$mail[$i] = "";
						$flg = true;
					}
				}

				if($flg){
					$err++;
				}

			}else{
				$err_msg[$err] = "アドレスがNULLです。";
				$err_mail[$err] = $mail[$i];
				$mail[$i] = "";
				$err++;
			}
		}

		// データのない配列を削除(ソート)
		$mail = array_merge(array_diff($mail, array("")));
		// データを一つにまとめて戻り値にする
		$ary = array(0 => $mail, 1 => $err_msg, 2 => $err_mail);

		return $ary;
	}


?>


</body>
</html>

