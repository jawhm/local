<?php

require_once 'php/fnc_logincheck.php';
require_once 'php/fnc_dbopen.php';

$param = explode('/', $_SERVER['PATH_INFO']);
$base = '../../../../../';
$base = $url_full;


if (count($param) > 1) {
	// 機能ＰＨＰ読み込み
	require_once 'cont/'.$param[1].'.php';

	for ($idx=1; $idx<count($body); $idx++)	{
		print $body[$idx];
	}


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