<?php

	// 基本処理
	require_once 'php/fnc_require.php';

	// 状態確認
	if ($user_id == '')	{
		// ログインページ表示
		if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
			$uri = 'https://';
		} else {
			$uri = 'http://';
		}
		$uri .= $_SERVER['HTTP_HOST'];
		header('Location: '.$uri.$url_base.'login.php');
		exit;
	}

?>