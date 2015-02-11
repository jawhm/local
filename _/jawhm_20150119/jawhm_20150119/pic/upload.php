<?php

	session_start();
	session_regenerate_id();
	$id = session_id();

	$png = file_get_contents('php://input');
	$fp = fopen('pics/' . $id . '.png', 'wb');
	fwrite($fp, $png);
	fclose($fp);

	copy ('pics/' . $id . '.png', 'list/photo/' . date('YmdHis') . '.png');

?>