<?php

include '../seminar_module/seminar_module.php';

$config = array();
if ($_SESSION['seminar_config']) {
	$config = unserialize(base64_decode($_SESSION['seminar_config']));
} elseif (isset($_COOKIE['seminar_config'])) {
	$config = unserialize(base64_decode($_COOKIE['seminar_config']));
}

$sm = new SeminarModule($config);
echo $sm->get_seminar_show();

