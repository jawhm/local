<?php

require_once 'php/fnc_logincheck.php';
require_once 'php/fnc_dbopen.php';

$param = explode('/', $_SERVER['PATH_INFO']);
$base = '../../../../../';
$base = $url_full;


if (count($param) > 1) {
	// 機能ＰＨＰ読み込み
	require_once 'cont/'.$param[1].'.php';

	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=crmoutput.csv");
	echo (mb_convert_encoding($body[1],"SJIS"));

}else{
	// 初期画面表示 -----------------------------------------
?>
<html>
<head><title>表示できません</title></head>
<body>このページは表示できません</body>
</html>
<?php
}

require_once 'php/fnc_dbclose.php';

?>