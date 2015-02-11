<?php

require_once 'php/fnc_logincheck.php';
require_once 'php/fnc_dbopen.php';

$param = explode('/', @$_SERVER['PATH_INFO']);
$base = '../../../../../';
$base = $url_full;

require 'php/fnc_menu.php';

if (count($param) > 1) {
	// 機能ＰＨＰ読み込み
	require_once 'cont/'.$param[1].'.php';
}else{
	// 初期画面表示 -----------------------------------------
$body_title[] .= 'ダッシュボード';
$body[] .= '
	<a target="_blank" href="/mailsystem/newmember.php">メンバー登録画面</a><br/>
';


}


require_once 'php/tmp_body.php';
require_once 'php/fnc_dbclose.php';

?>