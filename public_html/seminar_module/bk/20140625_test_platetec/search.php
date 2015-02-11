<?php

include '../seminar_module/seminar_module.php';

$tmp_config = array();
if ($_SESSION['seminar_config']) {
	$tmp_config = unserialize(base64_decode($_SESSION['seminar_config']));
} elseif (isset($_COOKIE['seminar_config'])) {
	$tmp_config = unserialize(base64_decode($_COOKIE['seminar_config']));
}

$config = array();
if (empty($tmp_config[$_POST['script_name']])) {
	$config = $tmp_config;
} else {
	$config = $tmp_config[$_POST['script_name']];
}

$sm = new SeminarModule($config);
echo $sm->get_seminar_show();
