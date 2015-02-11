<?php

	$base = '';
	$base = $url_full;

	require_once 'php/fnc_require.php';
	require_once 'php/fnc_dbopen.php';

	// パラメータ確認
	$act = fnc_getpost('act');
	$msg = '';

	if ($act == 'logout')	{
		$_SESSION['user_id'] = '';
		$_SESSION['user_name'] = '';
		$_SESSION['user_level'] = 0;
		// トップページに移動
		header('Location: ./index');
		exit;
	}

	if ($act == 'login')	{
		$userid = fnc_getpost('userid');
		$pwd = fnc_getpost('pwd');
		try {
			$ini = parse_ini_file('../../../bin/pdo_mail_list.ini', FALSE);
			$db = new PDO($ini['dsn'], $ini['user'], $ini['password']);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query('SET CHARACTER SET utf8');
			$stt = $db->prepare('SELECT userpwd, namae, level FROM userlist WHERE userid = "'.$userid.'" AND inuse = 1');
			$stt->execute();
			$idx = 0;
			$cur_userpwd = '';
			while($row = $stt->fetch(PDO::FETCH_ASSOC)){
				$idx++;
				$cur_userpwd = $row['userpwd'];
				$cur_namae = $row['namae'];
				$cur_level = $row['level'];
			}
			$db = NULL;
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		if (md5($pwd) == $cur_userpwd)	{
			$_SESSION['user_id'] = $userid;
			$_SESSION['user_name'] = $cur_namae;
			$_SESSION['user_level'] = $cur_level;
			// トップページに移動
			header('Location: ./index');
			exit;
		}else{
			$msg = 'ログイン出来ません';
		}
	}

	// ログイン画面表示
	$body_style = 'login';

$body[0] = '
	<div style="border:1px solid navy; width:800px; height:300px; margin:80px 0 80px 0;">
		<form name="form_login" method="post" action="login.php" onsubmit="return(fnc_inputcheck());">
			<table style="color:navy; margin: 80px 0 0 0;">
				<tr>
					<td>USER ID : </td><td>'.field_text('userid', 40, '').'</td>
				</tr>
				<tr>
					<td>PASSWORD : </td><td>'.field_password('pwd', 40, '').'</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right;">
						<input class="button_cancel" type="reset" value="clear" onclick="eID(\'msg\').innerHTML=\'\'">&nbsp;&nbsp;
						<input class="button_submit" type="submit" value="Login">
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td colspan="2" style="color:red; font-size:14pt; font-weight:bold; text-align:center;">
						<span id="msg">'.$msg.'</span>
					</td>
				</tr>
				</table>
		<input type="hidden" name="act" value="login">
		</form>
	</div>
';

$script = '
	function fnc_inputcheck()	{
		if (eID("userid").value == "")	{
			eID("msg").innerHTML = "ユーザＩＤを入力してください";
			eID("userid").focus();
			return false;
		}
		if (eID("pwd").value == "")	{
			eID("msg").innerHTML = "パスワードを入力してください";
			eID("pwd").focus();
			return false;
		}


	}
';


	require_once 'php/tmp_body.php';
	require_once 'php/fnc_dbclose.php';

?>