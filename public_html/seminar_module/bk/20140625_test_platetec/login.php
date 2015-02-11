<?php

session_start();

$email = @$_POST['email'];
$pwd = @$_POST['pwd'];

$msg = false;
// ログイン処理
if ($email == '' || $pwd == '')	{
	$msg = '入力されたメールアドレスかパスワードに誤りがあります。';
}else{
	try {
		$ini = parse_ini_file('../../bin/pdo_mail_list.ini', FALSE);
		$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$db->query('SET CHARACTER SET utf8');
		$stt = $db->prepare('SELECT id, email, password, namae FROM memlist WHERE email = :email and state = "5" ');
		$stt->bindValue(':email', $email);
		$stt->execute();
		$cur_id = '';
		$cur_email = '';
		$cur_password = '';
		$cur_namae = '';
		while($row = $stt->fetch(PDO::FETCH_ASSOC)){
			$cur_id = $row['id'];
			$cur_email = $row['email'];
			$cur_password = $row['password'];
			$cur_namae = $row['namae'];
		}
		$db = NULL;
	} catch (PDOException $e) {
		die($e->getMessage());
	}
	if ($cur_password == md5($pwd))	{
		// ログインOK
		$_SESSION['mem_id'] = $cur_id;
		$_SESSION['mem_name'] = $cur_namae;
		$_SESSION['mem_level'] = 0;
		$msg = true;
	}else{
		$msg = '入力されたメールアドレスかパスワードに誤りがあります。';
	}
}

echo $msg;
