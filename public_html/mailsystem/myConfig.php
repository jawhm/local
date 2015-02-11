<?php
require_once 'Mail/Queue.php';

$dbo = array(
	'type' => 'mdb2',
	'dsn' => 'mysqli://mail_list:r2d2c3po303pittst@localhost/mail_list',
	'mail_table' => 'mail_queue'
);
$mo = array(
	'driver' => 'smtp',
	'host' => 'localhost',
	'port' => 25,
	'auth' => FALSE
);
