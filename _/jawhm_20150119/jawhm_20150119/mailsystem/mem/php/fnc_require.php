<?php

	session_start();

	ini_set( "display_errors", "On");
	mb_language("Ja");
	mb_internal_encoding("utf8");

	require_once 'php/fnc_functions.php';

	require_once 'php/fnc_dbopen.php';
	try {
		// アクセスログ記録
		$sql  = 'INSERT INTO log (';
		$sql .= ' user_id ,user_name ,user_level ,log_date ,http_referer ,content_type ,http_user_agent ,http_connection ,http_cache_control ,http_cookie ,server_addr ,server_port ,remote_addr ,remote_port ,request_method ,request_uri ,script_name';
		$sql .= ') VALUES (';
		$sql .= ' :user_id ,:user_name ,:user_level ,:log_date ,:http_referer ,:content_type ,:http_user_agent ,:http_connection ,:http_cache_control ,:http_cookie ,:server_addr ,:server_port ,:remote_addr ,:remote_port ,:request_method ,:request_uri ,:script_name';
		$sql .= ')';
		$stt2 = $db->prepare($sql);
		$stt2->bindValue(':user_id'			, @$_SESSION['user_id']);
		$stt2->bindValue(':user_name'		, @$_SESSION['user_name']);
		$stt2->bindValue(':user_level'		, @$_SESSION['user_level']);
		$stt2->bindValue(':log_date'		, date('Y/m/d H:i:s'));
		$stt2->bindValue(':http_referer'	, @$_SERVER['HTTP_REFERER']);
		$stt2->bindValue(':content_type'	, @$_SERVER['CONTENT_TYPE']);
		$stt2->bindValue(':http_user_agent'	, @$_SERVER['HTTP_USER_AGENT']);
		$stt2->bindValue(':http_connection'	, @$_SERVER['HTTP_CONNECTION']);
		$stt2->bindValue(':http_cache_control'	, @$_SERVER['HTTP_CACHE_CONTROL']);
		$stt2->bindValue(':http_cookie'		, @$_SERVER['HTTP_COOKIE']);
		$stt2->bindValue(':server_addr'		, @$_SERVER['SERVER_ADDR']);
		$stt2->bindValue(':server_port'		, @$_SERVER['SERVER_PORT']);
		$stt2->bindValue(':remote_addr'		, @$_SERVER['REMOTE_ADDR']);
		$stt2->bindValue(':remote_port'		, @$_SERVER['REMOTE_PORT']);
		$stt2->bindValue(':request_method'	, @$_SERVER['REQUEST_METHOD']);
		$stt2->bindValue(':request_uri'		, @$_SERVER['REQUEST_URI']);
		$stt2->bindValue(':script_name'		, @$_SERVER['SCRIPT_NAME']);
		$stt2->execute();
	} catch (PDOException $e) {
		die($e->getMessage());
	}

	// ログイン情報
	$user_id = @$_SESSION['user_id'];
	$user_name = @$_SESSION['user_name'];
	$user_level = @$_SESSION['user_level'];

	// URL
	$url_base = '/mailsystem/mem/';
	$url_full = 'http://www.jawhm.or.jp'.$url_base;

	// 表示内容
	$title = 'JAWHM';
	$notice = '';

	$menu_style = 'normal';
	$body_style = 'normal';
	$body_title[] = array();
	$body[] = array();

	$menu_title[] = array();
	$menu[] = array();

	$script = '';


	require_once 'php/fnc_inputfield.php';

?>